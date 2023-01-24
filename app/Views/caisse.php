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
                    <div class="col">
                        <div class="card card-body">
                            caisse
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-body">
                            caisse
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

    // function load_caisse() {
    //     $.ajax({
    //         url: "caisse/fetch_caisse",
    //         method: 'POST',
    //         dataType: "JSON",

    //         success: function(data) {
    //             var output = '';
    //             for (var count = 0; count < data.length; count++) {
    //                 output += '<tr><td>' + data[count].vente + '</td>';
    //                 output += '<td>' + data[count].paiement + '</td>';
    //                 output += '<td>' + data[count].charge + '</td>';
    //                 output += '<td>' + data[count].versement + '</td>';
    //                 output += '<td>' + data[count].caisse + '</td>';
    //                 output += '<td>' + data[count].date_insertion + '</td></tr>';

    //             }
    //             $('#table_data').html(output);
    //             var datatable = $('#datatable-buttons').DataTable({
    //                 lengthChange: false,
    //                 buttons: ['pdf', 'print', 'colvis'],
    //                 destroy: true,
    //                 retrieve: true,
    //                 "processing": true,
    //                 "serverside": true,
    //                 "order": [],
    //             });
    //             datatable.buttons().container().appendTo(
    //                 '#datatable-buttons_wrapper .col-md-6:eq(0)');
    //             $("#datatable_length select").addClass('form-select form-select-sm');
    //         }
    //     });
    // }

    // load_caisse();
});
</script>

<script src="assets/js/app.js"></script>

</body>

</html>