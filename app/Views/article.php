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
                                <a href="#" id="btn-new-article"
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
                                            <form id="form-article" method="post">
                                                <span class="" id="message"></span>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Catégorie article</label>
                                                            <select class="form-select" name="categorie" id="categorie">

                                                            </select>
                                                            <span id="categorie-error"
                                                                class="categorie-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Titre article</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le titre de l'article : ex(article1)"
                                                                type="text" name="article-title" id="article-title"
                                                                required value="" />
                                                            <span id="article-error"
                                                                class="article-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Seuil article</label>
                                                            <input class="form-control"
                                                                placeholder="Entrez le seuil de l'article : ex(10)"
                                                                type="number" name="article-seuil" id="article-seuil"
                                                                required value="" />
                                                            <span id="seuil-error"
                                                                class="seuil-error text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button type="button" class="btn btn-light waves-effect"
                                                        data-bs-dismiss="modal">Fermer</button>
                                                    <button id="btn-save-article" type="submit"
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
                                                    <th>Categorie</th>
                                                    <th>Titre</th>
                                                    <th>Seuil</th>
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
    function load_categorie() {
        $.ajax({
            url: "category/fetch_categories",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '<option value="">Veuillez choisir une catégorie</option>';
                for (var count = 0; count < data.length; count++) {
                    output += '<option value="' + data[count].id + '">' + data[count].titre +
                        '</option>';
                }
                $('#categorie').html(output);
            }
        });
    }

    function load_article() {
        $.ajax({
            url: "article/fetch_article",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].titreCategorie + '</td>';
                    output += '<td>' + data[count].titreArticle + '</td>';
                    output += '<td>' + data[count].seuil + '</td>';
                    output += '<td>' + data[count].article_insertion + '</td>';
                    output +=
                        '<td><div class="btn-group me-2 mb-2 mb-sm-0"><button type="button" name="edit" class="btn btn-primary waves-light edit waves-effect" data-id="' +
                        data[count].idArticle +
                        '"><i class="fa fa-pen"></i></button><button data-id="' +
                        data[count].idArticle +
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

    $('#btn-new-article').click(function() {
        $('#form-article')[0].reset();
        $('#article-error').text('');
        $('#categorie-error').text('');
        $('#seuil-error').text('');
        $('#modal-title').text('Nouvel Article');
        $('#action').val('Add');
        $('#btn-save-article').text('Ajouter');
        $('#myModal').modal('show');
    });

    $('#form-article').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "article/insert",
            method: "POST",
            data: $(this).serialize(),
            dataType: "JSON",

            beforeSend: function() {
                $('#btn-save-article').text('patientez...');
                $('#btn-save-article').attr('disabled', 'disabled');
            },

            success: function(data) {
                $('#btn-save-article').text('Save');
                $('#btn-save-article').attr('disabled', false);

                if (data.error == 'yes') {
                    $('#article-error').text(data.article_error);
                    $('#categorie-error').text(data.categorie_error);
                    $('#seuil-error').text(data.seuil_error);
                } else {
                    $('#form-article')[0].reset();
                    $('#message').html(data.message);
                    load_article();

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
            url: "article/show",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'JSON',

            success: function(data) {
                $('#modal-title').text('Modification de l\'article : ' + data.libelle);
                $('#article-title').val(data.libelle);
                $('#article-seuil').val(data.seuil);
                $('#categorie').val(data.id_categorie);
                $('#article-error').text('');
                $('#categorie-error').text('');
                $('#seuil-error').text('');
                $('#action').val('Edit');

                $('#btn-save-article').text('Mettre à jour');
                $('#myModal').modal('show');
                $('#hidden_id').val(id);
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Voulez vous vraiment supprimer cet élément ?")) {
            $.ajax({
                url: "article/delete",
                method: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',

                success: function(data) {
                    $('#message').html(data.message);
                    load_article();

                    setTimeout(function() {
                        $('#message').html('');
                    }, 5000);
                }
            });
        }
    });

    load_article();
    load_categorie();
});
</script>

<script src="assets/js/app.js"></script>

</body>

</html>