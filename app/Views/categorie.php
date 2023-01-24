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
                                <a href="#" id="btn-new-categorie"
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
                                            <form method="post" class="needs-validation" name="categorie-form"
                                                id="form-categorie" novalidate>
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <div class="mb-3">
                                                            <label class="form-label">Titre</label>
                                                            <input class="form-control" type="text"
                                                                name="categorie-title" placeholder="Entrez le titre..."
                                                                id="categorie-title" required value="" />
                                                        </div>
                                                    </div><!-- end col -->
                                                </div>
                                                <span id="title-error" class="title-error text-danger"></span>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button id="btn-save-categorie" type="submit"
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
                                                    <th>Titre</th>
                                                    <th>Date d'insertion</th>
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

    function load_categorie() {
        $.ajax({
            url: "category/fetch_categories",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].titre + '</td>';
                    output += '<td>' + data[count].date_insertion + '</td>';
                    output +=
                        '<td><div class="btn-group me-2 mb-2 mb-sm-0"><button type="button" name="edit" class="btn btn-primary waves-light edit waves-effect" data-id="' +
                        data[count].id +
                        '"><i class="fa fa-pen"></i></button><button data-id="' +
                        data[count].id +
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

    $('#btn-new-categorie').click(function() {
        $('#form-categorie')[0].reset();
        $('#title-error').text('');
        $('#modal-title').text('Nouvelle catégorie');
        $('#action').val('Add');
        $('#btn-save-categorie').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-categorie').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "category/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-categorie').text('patientez...');
                $('#btn-save-categorie').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-categorie').text('Save');
                $('#btn-save-categorie').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#title-error').text(data.title_error);
                } else {
                    $('#form-categorie')[0].reset();
                    $('#message').html(data.message);
                    load_categorie();

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
            url: "category/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification de catégorie : ' + data.titre);
                $('#categorie-title').val(data.titre);
                $('#title-error').text('');
                $('#action').val('Edit');

                $('#btn-save-categorie').text('Mettre à jour');
                $('#myModal').modal('show');
                $('#hidden_id').val(id);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Voulez vous vraiment supprimer cet élément ?")) {
            $.ajax({
                url: "category/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_categorie();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

    load_categorie();

})
</script>
<script src="assets/js/app.js"></script>

</body>

</html>