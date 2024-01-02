<?php

if (!admin_logged_in()) {
    redirect('admin_login');
} else {
    $file_access = true;
}

$section  = $url[1] ?? 'dashboard';
$action   = $url[2] ?? 'view';
$id       = $url[3] ?? 0;

$filename = "../app/pages/pages/admin/" . $section . ".php";
if (!file_exists($filename)) {
    $filename = "../app/pages/pages/admin/404.php";
}
if (@$_GET['page'] == 'report' && isset($_GET['id'])) {
    printReport($_GET['id']);
    // echo "<script>window.location='admin.php'</script>";
}
$fullname =  "System Administrator";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= ROOT ?>/admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

    <title> Admin - <?= APP_NAME ?></title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= ROOT ?>/admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= ROOT ?>/admin_assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include  '../app/pages/admin/includes/header.php' ?>

        <aside class="main-sidebar sidebar-dark-success elevation-4">
            <?php include  '../app/pages/admin/includes/sidebar.php' ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> Administrator Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <?php
            if (!isset($section))
                include 'admin/dashboard.php';
            elseif ($section == 'schedule')
                include 'admin/schedule.php';
                elseif ($section == 'schedule_payment')
                include 'admin/schedule_payment.php';
        
            elseif ($section == 'report')
                include 'admin/report.php';
            elseif ($section == 'users')
                include 'admin/users.php';
            elseif ($section == 'bus_route')
                include 'admin/bus_route.php';
          
            elseif ($section == 'logout') {
                include 'admin/logout.php';
                //   @session_destroy();
                // echo "<script>alert('You are being logged out'); window.location='../';</script>";
                // exit;
            } elseif ($section == 'payment')
                include 'admin/payment.php';

            elseif ($section == 'search')
                include 'admin/search.php';

            else {
                include 'admin/dashboard.php';
            }
            //TODO:
            ?>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <?php include  '../app/pages/admin/includes/footer.php' ?>
    </div>
</body>

</html>