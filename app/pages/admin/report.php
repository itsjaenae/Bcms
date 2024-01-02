<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'report';
$me = "?page=$source"
?>

<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="card card-success">
                        <div class="card-header" style="background-color:#17a2b8">
                            <h3 class="card-title">
                                All Schedules</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <table style="width: 100%;" id="example1" style="align-items: stretch;"
                                    class="table table-hover table-bordered">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bus</th>
                                            <th>Route</th>
                                            <th>Date/Time</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
  
                                    <?php
$stmtBusBooking = $pdo->query("SELECT * FROM bus_booking ORDER BY id DESC");
$stmtScheduleBooking = $pdo->query("SELECT * FROM schedule_booking ORDER BY id DESC");

if ($stmtBusBooking->rowCount() < 1 && $stmtScheduleBooking->rowCount() < 1) {
    echo "No Records Yet";
} else {
    $sn = 0;

    while ($fetch = $stmtBusBooking->fetch(PDO::FETCH_ASSOC)) {
        $id = $fetch['id']; 
        ?>
        <tr>
            <td><?php echo ++$sn; ?></td>
            <td><?php echo ($fetch['bus_no']); ?></td>
            <td><?php echo ($fetch['departure']) . ' to ' .($fetch['destination']); ?></td>
            <td><?php echo date("D d, M Y", strtotime($fetch['date_of_depart'])); ?></td>
               
            <td>
                <a href="<?= ROOT ?>/admin?page=report&id=<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success">
                        View
                    </button>
                </a>
            </td>
        </tr>
        <?php
    }

    // Reset $sn for the next table
    $sn = 0;

    while ($fetch = $stmtScheduleBooking->fetch(PDO::FETCH_ASSOC)) {
        $id = $fetch['id']; 
        ?>
        <tr>
            <td><?php echo ++$sn; ?></td>
            <td><?php echo ($fetch['bus_no']); ?></td>
            <td><?php echo ($fetch['departure']) . ' to ' .($fetch['destination']); ?></td>
            <td><?php echo  date("D d, M Y", strtotime($fetch['date'])), " / ", formatTime($fetch['time']); ?></td>
               
            <td>
                <a href="<?= ROOT ?>/admin?page=report&id=<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success">
                        View
                    </button>
                </a>
            </td>
        </tr>
        <?php
    }
}
?>


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>
</section>
</div>


