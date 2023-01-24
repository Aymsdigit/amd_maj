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
                                <a href="#" id="btn-new-approvisionnement"
                                    class="btn btn-danger rounded btn-custom waves-effect waves-light">Ajouter</a>
                            </div>
                            <!-- sample modal content -->
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="modal-title">Modal Heading
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" class="needs-validation" name="form-approvisionnement"
                                                id="form-approvisionnement" novalidate>
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Fournisseurs</label>
                                                            <select class="form-select" name="fournisseur"
                                                                id="fournisseur">

                                                            </select>
                                                            <span id="fournisseur-error"
                                                                class="fournisseur-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Articles</label>
                                                            <select class="form-select" name="article" id="article">

                                                            </select>
                                                            <span id="article-error"
                                                                class="article-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Quantité</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez la quantité : 20..." type="number"
                                                                name="quantite" id="quantite" required value="" />
                                                            <span id="quantite-error"
                                                                class="quantite-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Prix</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le prix : 2000..." type="number"
                                                                name="prix" id="prix" required value="" />
                                                            <span id="prix-error" class="prix-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button id="btn-save-fournisseur" type="submit"
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
                                                    <th>Fournisseur</th>
                                                    <th>Article</th>
                                                    <th>Quantité</th>
                                                    <th>Prix</th>
                                                    <th>Date</th>
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

                <div class="card card-body">
                    <div class="row">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        Approvisionnement Global
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body text-muted">
                                        <div class="table-responsive">
                                            <table id="global"
                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Article</th>
                                                        <th>Quantité</th>
                                                        <th>Prix</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="global_data">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    function load_fournisseur() {
        $.ajax({
            url: "fournisseur/fetch_fournisseur",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '<option value="">Veuillez choisir un fournisseur</option>';
                for (var count = 0; count < data.length; count++) {
                    output += '<option value="' + data[count].id + '">' + data[count]
                        .nom_prenoms +
                        '</option>';
                }
                $('#fournisseur').html(output);
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

    load_article();
    load_fournisseur();
    load_approvisionnement();
    load_global();

    function load_global() {
        $.ajax({
            url: "approvisionnement/fetch_global",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].article + '</td>';
                    output += '<td>' + data[count].quantite + '</td>';
                    output += '<td>' + data[count].newPrice + '</td></tr>';
                }
                $('#global_data').html(output);
                var datatable = $('#global').DataTable({
                    lengthChange: false,
                    buttons: ['pdf', 'print'],
                    destroy: true,
                    retrieve: true,
                    "processing": true,
                    "serverside": true,
                    "order": [],
                });
                datatable.buttons().container().appendTo(
                    '#global_wrapper .col-md-6:eq(0)');
                $("#datatable_length select").addClass('form-select form-select-sm');
            }
        });
    }

    function load_approvisionnement() {
        $.ajax({
            url: "approvisionnement/fetch_approvisionnement",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].fournisseur + '</td>';
                    output += '<td>' + data[count].article + '</td>';
                    output += '<td>' + data[count].quantite + '</td>';
                    output += '<td>' + data[count].prix + '</td>';
                    output += '<td>' + data[count].date + '</td>';
                    output +=
                        '<td><div class="btn-group me-2 mb-2 mb-sm-0"><button type="button" name="edit" class="btn btn-primary waves-light edit waves-effect" data-id="' +
                        data[count].id_approvisionnement +
                        '"><i class="fa fa-pen"></i></button><button data-id="' +
                        data[count].id_approvisionnement +
                        '" type="button" name="delete" class="btn btn-primary waves-light delete waves-effect"><i class="far fa-trash-alt"></i></button></div></td></tr>';
                }
                $('#table_data').html(output);
                $("#datatable").DataTable(),
                    $("#datatable-buttons").DataTable({
                        dom: 'Bfrtip',
                        order: [
                            [0, 'desc']
                        ],
                        destroy: true,
                        retrieve: true,
                        "processing": true,
                        "serverside": true,
                        lengthMenu: [
                            [10]
                        ],
                        "oLanguage": {
                            "sSearch": "Recherche",
                            "sLengthMenu": "Afficher _MENU_ données",
                            "sInfo": "Affichage de _START_ sur _END_ sur un total de _TOTAL_ de données",
                            "oPaginate": {
                                "sNext": "suiv",
                                "sPrevious": "prec",
                            }
                        },
                        lengthChange: !1,
                        buttons: ["print", "excel", "pdf"]
                    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
                    $(".dataTables_length select").addClass("form-select form-select-sm")
                datatable.buttons().container().appendTo(
                    '#datatable-buttons_wrapper .col-md-6:eq(0)');
            }
        });
    }

    $('#btn-new-approvisionnement').click(function() {
        $('#form-approvisionnement')[0].reset();
        $('#fournisseur-error').text('');
        $('#article-error').text('');
        $('#quantite-error').text('');
        $('#prix-error').text('');
        $('#modal-title').text('Nouvel approvisionnement');
        $('#action').val('Add');
        $('#btn-save-approvisionnement').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-approvisionnement').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "approvisionnement/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-approvisionnement').text('patientez...');
                $('#btn-save-approvisionnement').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-approvisionnement').text('Save');
                $('#btn-save-approvisionnement').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#fournisseur-error').text(data.fournisseur_error);
                    $('#article-error').text(data.article_error);
                    $('#quantite-error').text(data.quantite_error);
                    $('#prix-error').text(data.prix_error);
                } else {
                    // $('#form-approvisionnement')[0].reset();
                    $('#message').html(data.message);
                    load_approvisionnement();
                    load_global();
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
            url: "approvisionnement/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification Approvisionnement : ' + data
                    .id);
                $('#fournisseur').val(data.id_fournisseur);
                $('#article').val(data.id_article);
                $('#quantite').val(data.qte);
                $('#prix').val(data.prix);
                $('#article-error').text('');
                $('#fournisseur-error').text('');
                $('#quantite-error').text('');
                $('#prix-error').text('');
                $('#action').val('Edit');

                $('#btn-save-fournisseur').text('Mettre à jour');
                $('#myModal').modal('show');
                $('#hidden_id').val(id);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Voulez vous vraiment supprimer cet élément ?")) {
            $.ajax({
                url: "approvisionnement/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_approvisionnement();
                    load_global();
                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });


})
</script>
<script src="assets/js/app.js"></script>

</body>

</html>