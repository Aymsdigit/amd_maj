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
                                <a href="#" id="btn-new-vente"
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
                                            <form id="form-vente" method="post">
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Clients</label>
                                                            <select class="form-select" name="client" id="client">

                                                            </select>
                                                            <span id="client-error"
                                                                class="client-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Type de paiement</label>
                                                            <select class="form-select" name="type" id="type">
                                                                <option value="">Veuillez choisir un type de paiement
                                                                </option>
                                                                <option value="cash">Cash</option>
                                                                <option value="credit">Crédit</option>
                                                            </select>
                                                            <span id="type-error" class="type-error text-danger"></span>
                                                        </div>
                                                    </div>
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
                                                            <label class="form-label">Quantité</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez la quantité : ex(20)" type="text"
                                                                name="quantite" id="quantite" required value="" />
                                                            <span id="quantite-error"
                                                                class="quantite-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Prix untitaire</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le prix : ex(2000)" type="text"
                                                                name="prix" id="prix" required value="" />
                                                            <span id="prix-error" class="prix-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Montant total</label>
                                                            <input class="form-control"
                                                                placeholder="Calcul du montant total..." type="text"
                                                                name="montant" id="montant" disabled value="" />
                                                            <span id="montant-error"
                                                                class="montant-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button id="btn-save-vente" type="submit"
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
                                                    <th>Article</th>
                                                    <th>Quantité</th>
                                                    <th>Prix</th>
                                                    <th>Prix total</th>
                                                    <th>Type vente</th>
                                                    <th>Date insertion</th>
                                                    <th>Options</th>
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

    function load_vente() {
        $.ajax({
            url: "vente/fetch_vente",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].nom_prenoms + '</td>';
                    output += '<td>' + data[count].article + '</td>';
                    output += '<td>' + data[count].quantite + '</td>';
                    output += '<td>' + data[count].prix + '</td>';
                    output += '<td>' + data[count].montant + '</td>';

                    if (data[count].type_vente == "credit") {
                        output +=
                            '<td><span class="badge bg-warning p-2 btn-rounded waves-effect waves-light">A crédit</span></td>';
                    } else {
                        output +=
                            '<td><span class="badge bg-primary p-2 btn-rounded waves-effect waves-light">Cash</span></td>';
                    }
                    output += '<td>' + data[count].date_vente + '</td>';
                    output +=
                        '<td><div class="btn-group me-2 mb-2 mb-sm-0"><button type="button" name="edit" class="btn btn-primary waves-light edit waves-effect" data-id="' +
                        data[count].id_vente +
                        '"><i class="fa fa-pen"></i></button><button data-id="' +
                        data[count].id_vente +
                        '" type="button" name="delete" class="btn btn-primary waves-light delete waves-effect"><i class="far fa-trash-alt"></i></button></div></td></tr>';
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

    function load_client() {
        $.ajax({
            url: "client/fetch_client",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '<option value="">Veuillez choisir un client</option>';
                for (var count = 0; count < data.length; count++) {
                    output += '<option value="' + data[count].id + '">' + data[count].nom_prenoms +
                        '</option>';
                }
                $('#client').html(output);
            }
        });
    }

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

    $('#btn-new-vente').click(function() {
        $('#form-vente')[0].reset();
        $('#article-error').text('');
        $('#quantite-error').text('');
        $('#prix-error').text('');
        $('#type-error').text('');
        $('#client-error').text('');
        $('#modal-title').text('Nouvelle vente');
        $('#action').val('Add');
        $('#btn-save-vente').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-vente').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "vente/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-vente').text('patientez...');
                $('#btn-save-vente').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-vente').text('Save');
                $('#btn-save-vente').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#article-error').text(data.article_error);
                    $('#quantite-error').text(data.quantite_error);
                    $('#prix-error').text(data.prix_error);
                    $('#client-error').text(data.client_error);
                    $('#type-error').text(data.type_error);
                } else {
                    // $('#vente-modal').modal('hide');
                    $('#form-vente')[0].reset();
                    $('#message').html(data.message);
                    load_vente();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            }
        });
    });

    $('#prix').keyup(function() {
        var prix = $('#prix').val();
        var quantite = $('#quantite').val();

        if (prix.length > 0) {
            var montant = prix * quantite;
            $('#montant').val(montant);
        }
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "vente/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification de la vente');
                $('#article').val(data.id_article);
                $('#client').val(data.id_client);
                $('#quantite').val(data.qte);
                $('#prix').val(data.prix);
                $('#type').val(data.type_vente);
                $('#article-error').text(data.article_error);
                $('#quantite-error').text(data.quantite_error);
                $('#prix-error').text(data.prix_error);
                $('#client-error').text(data.client_error);
                $('#type-error').text(data.type_error);
                $('#action').val('Edit');

                $('#btn-save-vente').text('Mettre à jour');
                $('#myModal').modal('show');
                $('#hidden_id').val(id);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Voulez vous vraiment supprimer cet élément ?")) {
            $.ajax({
                url: "vente/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_vente();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

    load_article();
    load_client();
    load_vente();
});
</script>

<script src="assets/js/app.js"></script>

</body>

</html>