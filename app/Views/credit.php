<?= $this->include('partials/main') ?>

<head>

    <?= $this->include('partials/title-meta') ?>

    <?= $this->include('partials/head-css') ?>

</head>


<?= $this->include('partials/body') ?>

<!-- <body data-layout="horizontal" data-topbar="colored"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->include('partials/topbar') ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?= $this->include('partials/sidebar') ?>
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <?= $this->include('partials/page-title') ?>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <!-- Left sidebar -->
                        <div class="email-leftbar card">
                            <div class="d-grid">
                                <a href="#" id="btn-new-retour"
                                    class="btn btn-danger rounded btn-custom waves-effect waves-light">Ajouter</a>
                            </div>
                            <!-- sample modal content -->
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" class="needs-validation" name="retour-form"
                                                id="form-retour" novalidate>
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Article</label>
                                                            <select class="form-select" name="article" id="article">

                                                            </select>
                                                            <span id="article-error"
                                                                class="article-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Motif</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le motif ..." type="text"
                                                                name="motif" id="motif" required value="" />
                                                            <span id="motif-error"
                                                                class="motif-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Quantite</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez la quantité ..." type="text"
                                                                name="quantite" id="quantite" required value="" />
                                                            <span id="quantite-error"
                                                                class="quantite-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Adresse</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez l'adresse..." type="text"
                                                                name="adresse" id="adresse" required value="" />
                                                            <span id="adresse-error"
                                                                class="adresse-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button id="btn-save-retour" type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Sauvegarder</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                        <!-- End Left sidebar -->

                        <!-- Right Sidebar -->
                        <div class="email-rightbar mb-3">

                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Client</th>
                                                    <th>Crédit</th>
                                                    <th>Reste</th>
                                                    <th>Date crédit</th>
                                                    <th>Statut</th>
                                                    <th>Paiement</th>
                                                    <th>Détails</th>
                                                </tr>
                                            </thead>

                                            <tbody id="table_data">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- card -->

                        </div>
                        <!-- end Col-9 -->

                    </div>

                </div>


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <?= $this->include('partials/footer') ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?= $this->include('partials/right-sidebar') ?>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<?= $this->include('partials/vendor-scripts') ?>
<?= $this->include('partials/datatables') ?>

<script>
$(document).ready(function() {

    load_article();

    function load_article() {
        $.ajax({
            url: "article/load_article",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '<option value="">Veuillez choisir un article</option>';
                for (var count = 0; count < data.length; count++) {
                    output += '<option value="' + data[count].id + '">' + data[count].titre +
                        '</option>';
                }
                $('#article').html(output);
            }
        });
    }

    function load_credit() {
        $.ajax({
            url: "credit/fetch_credit",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].nom_prenoms + '</td>';
                    output += '<td>' + data[count].credit + '</td>';
                    output += '<td class="text-warning">' + data[count].reste + '</td>';
                    output += '<td>' + data[count].date_insertion + '</td>';
                    if (data[count].reste != 0) {
                        output +=
                            '<td><span class="badge badge-soft-warning font-size-12">Non soldé...</span></td>';
                    } else {
                        output +=
                            '<td><span class="badge badge-soft-success font-size-12">Soldé</span></td>';
                    }
                    if (data[count].reste != 0) {
                        output += '<td><button data-nom_prenom="' + data[count].nom_prenom +
                            '" data-client= "' + data[count].client_id +
                            '" data-montant = "' + data[count].reste +
                            '" data-id="' +
                            data[
                                count]
                            .id +
                            '" class="btn font-16 btn-primary w-50" id="btn-add_paie" ><i class="mdi mdi-plus-circle-outline"></i></button></td>';
                    } else {
                        output += '<td>...</td>';
                    }
                    output += '<td><button data-credit="' + data[count].credit +
                        '" data-nom_prenom="' + data[count].nom_prenom +
                        '"  class="btn btn-outline-secondary details_client" data-id="' + data[
                            count].id + '" data-client= "' + data[count].client_id +
                        '"><i class="fas fa-copy"></i></buttonhref=></td></tr>';
                }
                $('#table_data').html(output);
                var datatable = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: ['pdf', 'print', 'colvis'],
                    destroy: true,
                    retrieve: true,
                    "processing": true,
                    "serverside": true,
                    "order": [],
                });
                datatable.buttons().container().appendTo(
                    '#datatable-buttons_wrapper .col-md-6:eq(0)');
                $("#datatable_length select").addClass('form-select form-select-sm');
            }
        });
    }

    load_credit();

    $('#btn-new-retour').click(function() {
        $('#form-retour')[0].reset();
        $('#motif-error').text('');
        $('#article-error').text('');
        $('#adresse-error').text('');
        $('#quantite-error').text('');
        $('#modal-title').text('Nouvelle retour');
        $('#action').val('Add');
        $('#btn-save-retour').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-retour').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "retour/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-retour').text('patientez...');
                $('#btn-save-retour').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-retour').text('Save');
                $('#btn-save-retour').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#motif-error').text(data.motif_error);
                    $('#article-error').text(data.article_error);
                    $('#adresse-error').text(data.adresse_error);
                    $('#quantite-error').text(data.quantite_error);
                } else {
                    $('#form-retour')[0].reset();
                    $('#message').html(data.message);
                    load_retour();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            }
        });
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "retour/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification de retour : ' + data.motif);
                $('#motif').val(data.motif);
                $('#article').val(data.id_article);
                $('#adresse').val(data.adresse);
                $('#quantite').val(data.quantite);
                $('#motif-error').text('');
                $('#adresse-error').text('');
                $('#quantite-error').text('');
                $('#action').val('Edit');

                $('#btn-save-retour').text('Mettre à jour');
                $('#myModal').modal('show');
                $('#hidden_id').val(id);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Voulez vous vraiment supprimer cet élément ?")) {
            $.ajax({
                url: "retour/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_retour();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });
});
</script>

<script src="assets/js/app.js"></script>

</body>

</html>