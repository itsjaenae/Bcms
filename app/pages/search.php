<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Schedules - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= ROOT ?>/admin_assets/dist/css/adminlte.min.css">
    <?php include '../app/includes/header.php' ?>
</head>
<body>
   

<div class="content">
    <!-- Main content -->
    <section class="content" style="margin-bottom: 5rem; margin-top: 4rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-success">
                        <div class="card-header" style="background-color: #333;color: #fff; height: 45px; font-size: 1rem">
                            <h3 class="card-title"style=" font-size: 1.2rem">Search</h3>
                            <div class='float-right'>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#add" style="background: #361999; padding: 10px 16px">
                                    New Search
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                        <?php
if (isset($_POST['submit'])) {
    $ticket = $_POST['ticket'];

    // Check if bus booking exists
    $checkBusBooking = $pdo->prepare("SELECT bus_booking.*, users.*
    FROM bus_booking
    INNER JOIN users ON users.id = bus_booking.user_id
    WHERE bus_booking.booked_id = :ticket");
$checkBusBooking->bindParam(':ticket', $ticket);
$checkBusBooking->execute();

    // Check if schedule booking exists
    $checkScheduleBooking =   $pdo->prepare("SELECT schedule_booking.*, users.*
    FROM schedule_booking
    INNER JOIN users ON users.id= schedule_booking.user_id
    WHERE  booked_id = :ticket");
    $checkScheduleBooking->bindParam(':ticket', $ticket);
    $checkScheduleBooking->execute();

    if ($checkBusBooking->rowCount() == 1) {
        // Ticket found in bus_booking table
        $row = $checkBusBooking->fetch(PDO::FETCH_ASSOC);
        renderTable($row);
    } elseif ($checkScheduleBooking->rowCount() == 1) {
        // Ticket found in schedule_booking table
        $rows = $checkScheduleBooking->fetch(PDO::FETCH_ASSOC);
        renderTables($rows);
    } else {
        // Ticket not found in either table
        alert("Invalid Ticket Number Provided");
    }
}

function renderTable($row) {
    echo '<table id="example1" style="align-items: stretch;" class="table table-hover w-100 table-bordered table-striped">';
    echo "
        <tr><td colspan='2' class='text-center'><img src='../assets/img/no_image.jpg' class='img img-thumbnail' width='200' height='200'></td></tr>
        <tr><th>FullName</th><td>{$row['card_name']}</td></tr>
        <tr><th>Username</th><td>{$row['username']}</td></tr>
        <tr><th>Email</th><td>{$row['email']}</td></tr>
        <tr><th>Phone</th><td>{$row['phone']}</td></tr>
        <tr><th>Ticket booked_id</th><td>{$row['booked_id']}</td></tr>
        <tr><th>Journey Type</th><td>{$row['j_type']}</td></tr>
        <tr><th>Bus Number</th><td>{$row['bus_no']}</td></tr>
        <tr><th>No of passengers</th><td>{$row['no_of_pass']}</td></tr>
        <tr><th>Departure</th><td>{$row['departure']}</td></tr>
        <tr><th>Destination</th><td>{$row['destination']}</td></tr>
        <tr> <th>Seat</th>
            <td>";

    $seatJson = $row['seat_booking'];
    $seatArray = json_decode($seatJson, true);

    if (is_array($seatArray)) {
        // Access each element of the array
        foreach ($seatArray as $seat) {
            echo "Seat NO:" . $seat[0] . "=> " . $seat[1] . '<br>';
        }
    } else {
        echo "No seat information available";
    }

    echo "</td></tr>
        <tr><th>Trip Date/Time</th><td>" . date("D d, M Y", strtotime($row['date_of_depart'])) . "</td></tr>
        <tr><th>Amount Paid</th><td>$ {$row['total_amount']}</td></tr>
        <tr><th>Payment Date</th><td>" . date("D d, M Y", strtotime($row['date'])) . "</td></tr>
    </table>";
}

function renderTables($rows) {
    echo '<table id="example1" style="align-items: stretch;" class="table table-hover w-100 table-bordered table-striped">';
    echo "
        <tr><td colspan='2' class='text-center'><img src='../assets/img/no_image.jpg' class='img img-thumbnail' width='200' height='200'></td></tr>
        <tr><th>FullName</th><td>{$rows['card_name']}</td></tr>
        <tr><th>Username</th><td>{$rows['username']}</td></tr>
        <tr><th>Email</th><td>{$rows['email']}</td></tr>
        <tr><th>Phone</th><td>{$rows['phone']}</td></tr>
        <tr><th>Ticket booked_id</th><td>{$rows['booked_id']}</td></tr>
        <tr><th>Bus Number</th><td>{$rows['bus_no']}</td></tr>
        <tr><th>No of passengers</th><td>{$rows['pass']}</td></tr>
        <tr><th>Departure</th><td>{$rows['departure']}</td></tr>
        <tr><th>Destination</th><td>{$rows['destination']}</td></tr>

        <tr><th>Trip Date/Time</th><td>" . date("D d, M Y", strtotime($rows['date'])) . "</td></tr>
        <tr><th>Amount Paid</th><td>$ {$rows['price']}</td></tr>
        <tr><th>Payment Date</th><td>" . date("D d, M Y", strtotime($rows['date'])) . "</td></tr>
    </table>";
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <h4 class="modal-title">Search Commuter With Ticket ID
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <table class="table table-bordered">
                        <tr>
                            <th>Enter Ticket Number</th>
                            <td><input type="text" class="form-control" name="ticket" required minlength="3" id=""></td>
                        </tr>
                        <td colspan="2">

                            <input class="btn btn-info" type="submit" value="Search" name='submit'>
                        </td>
                        </tr>
                    </table>
                </form>



            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



    <?php include '../app/includes/footer.php' ?>

    <script src="<?= ROOT ?>/admin_assets/dist/js/adminlte.min.js"></script>



  
</body>

</html>