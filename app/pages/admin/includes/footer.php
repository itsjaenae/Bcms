   <!-- Main Footer -->
   <footer class="main-footer" >
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <?php echo APP_NAME ; ?>
            </div>
            <!-- Default to the left -->
            <strong><?php echo date("Y"); ?> - All Rights Reserved</strong>
        </footer>
    
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= ROOT ?>/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= ROOT ?>/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= ROOT ?>/admin_assets/dist/js/adminlte.min.js"></script>
    <script src="<?= ROOT ?>/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- DataTables -->
    <script src="<?= ROOT ?>/admin_assets/plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?= ROOT ?>/admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= ROOT ?>/admin_assets/dist/js/demo.js"></script>
    <script src="<?= ROOT ?>/admin_assets/dist/js/pages/dashboard3.js"></script>

    <script>
    $(function() {
        $("#example1").DataTable();
    });
    </script>
    <?php if ($section == 'query') { ?>
    <script src="<?= ROOT ?>/admin_assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= ROOT ?>/admin_assets/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- page script -->
    <script>
    $(function() {
        /* jQueryKnob */

        $('.knob').knob({
            draw: function() {}
        })

    })
    </script>
    <?php } ?>