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
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Article</th>
                                            <th>Entrée</th>
                                            <th>Sortie</th>
                                            <th>Perdue</th>
                                            <th>Retour</th>
                                            <th>Restante</th>
                                            <th>Seuil</th>
                                            <th>Prix de base</th>
                                            <th>Montant restant</th>
                                        </tr>
                                    </thead>

                                    <tbody id="table_data">
                                    </tbody>
                                </table>
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

    load_stock();

    function load_stock() {
        $.ajax({
            url: "stock/fetch_stock",
            method: 'POST',
            dataType: "JSON",

            success: function(data) {
                var output = '';
                for (var count = 0; count < data.length; count++) {
                    output += '<tr><td>' + data[count].titre + '</td>';
                    output += '<td>' + data[count].qte_total_entree + '</td>';
                    output += '<td>' + data[count].qte_total_vente + '</td>';
                    output += '<td>' + data[count].qte_total_perdue + '</td>';
                    output += '<td>' + data[count].retour + '</td>';
                    output += '<td>' + data[count].restante + '</td>';
                    output += '<td>' + data[count].seuil + '</td>';
                    output += '<td>' + data[count].prixBase + '</td>';
                    output += '<td>' + data[count].mr + '</td></tr>';
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


});
</script>

<script src="assets/js/app.js"></script>

</body>

</html>