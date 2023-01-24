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
                                <a href="#" id="btn-new-fournisseur"
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
                                            <form method="post" class="needs-validation" name="form-fournisseur"
                                                id="form-fournisseur" novalidate>
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nom & prénoms</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le nom du fournisseur : ex(fournisseur1)"
                                                                type="text" name="name" id="name" required value="" />
                                                            <span id="name-error" class="name-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le contact : ex(0700000000)"
                                                                type="text" name="contact" id="contact" required
                                                                value="" />
                                                            <span id="contact-error"
                                                                class="contact-error text-danger"></span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Adresse</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez l'adresse : bouaké ville..."
                                                                type="text" name="adresse" id="adresse" required
                                                                value="" />
                                                            <span id="adresse-error"
                                                                class="adresse-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span id="title-error" class="title-error text-danger"></span>
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
                                                    <th>Nom & prénoms</th>
                                                    <th>Contact</th>
                                                    <th>Adresse</th>
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

    function load_fournisseur() {
        $.ajax({
            url: "fournisseur/fetch_fournisseur",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].nom_prenoms + '</td>';
                    output += '<td>' + data[count].contact + '</td>';
                    output += '<td>' + data[count].adresse + '</td>';
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

    $('#btn-new-fournisseur').click(function() {
        $('#form-fournisseur')[0].reset();
        $('#name-error').text('');
        $('#contact-error').text('');
        $('#adresse-error').text('');
        $('#modal-title').text('Nouveau fournisseur');
        $('#action').val('Add');
        $('#btn-save-fournisseur').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-fournisseur').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "fournisseur/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-fournisseur').text('patientez...');
                $('#btn-save-fournisseur').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-fournisseur').text('Save');
                $('#btn-save-fournisseur').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#title-error').text(data.title_error);
                } else {
                    $('#form-fournisseur')[0].reset();
                    $('#message').html(data.message);
                    load_fournisseur();

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
            url: "fournisseur/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification de catégorie : ' + data.nom_prenoms);
                $('#name').val(data.nom_prenoms);
                $('#contact').val(data.contact);
                $('#adresse').val(data.adresse);
                $('#name-error').text('');
                $('#contact-error').text('');
                $('#adresse-error').text('');
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
                url: "fournisseur/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_fournisseur();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

    load_fournisseur();

})
</script>
<script src="assets/js/app.js"></script>

</body>

</html>