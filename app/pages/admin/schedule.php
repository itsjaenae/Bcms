<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'schedule';
$me = "?page=$source";


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
                            <div class='float-right'>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#add">
                                    Add New Schedule &#128645;
                                </button> 
                            </div>
                        </div>

                        <div class="card-body">

                            <table id="example1" style="align-items: stretch;" class="table table-hover w-100 table-bordered table-striped<?php //
                                                                                                                                            ?>">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bus No</th>
                                        <th>Departure</th>
                                        <th>Destination</th>
                                        <th>Price</th>
                                        <th>Date/Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                 $stmt = $pdo->query("SELECT bus_route.*, schedule.*
                                 FROM schedule
                                 LEFT JOIN bus_route ON bus_route.departure = schedule.departure
                                   AND bus_route.destination = schedule.destination
                                 ORDER BY schedule.id DESC");
                                    if ($stmt->rowCount() < 1) {
                                        echo "No Records Yet";
                                    } else {
                                        $sn = 0;
                                        while ($fetch = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $id = $fetch['id']; ?><tr>
                                                <td><?php echo ++$sn; ?></td>
                                                <td><?php echo ($fetch['bus_no']); ?></td>
                                                <td><?php echo ($fetch['departure']); ?></td>
                                                <td><?php echo ($fetch['destination']);
                                                    $fullname = " Schedule" ?></td>
                                                <td>$ <?php echo ($fetch['price']); ?></td>


                                                <td><?php echo date("D d, M Y", strtotime($fetch['date'])), " / ", formatTime($fetch['time']); ?></td>

                                                <td>
                                                    <form method="POST">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $id ?>">
                                                            Edit
                                                        </button> -

                                                        <input type="hidden" class="form-control" name="del_bus" value="<?php echo $id ?>" required id="">
                                                        <button type="submit" onclick="return confirm('Are you sure about this?')" class="btn btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="edit<?php echo $id ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Editing <?php echo $fullname;


                                                                                            ?> &#128642;</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">


                                                            <form action="" method="post">
                                                                <input type="hidden" class="form-control" name="id" value="<?php echo $id ?>" required id="">

                                                                <p>Departure: <select class="form-control" name="departure" required id="departureRoute" onchange="getDestinationRoutes()">
                                                                        <option value="Default" disabled selected>Departure Name</option>
                                                                        <?php
                                                                        $query = "SELECT id, departure FROM bus_route WHERE status= 1";
                                                                        $rows = dbConnect($query);
                                                                        if (!empty($rows)) :
                                                                            foreach ($rows as $row) :
                                                                        ?>
                                                                                <option <?= old_select('departure', $row['id']) ?> value="<?= $row['departure'] ?>"><?= $row['departure'] ?></option>
                                                                        <?php
                                                                            endforeach;
                                                                        endif;
                                                                        ?>
                                                                    </select>
                                                                </p>

                                                                <p>Destination : <select class="form-control" name="destination" required id="destinationRoute">
                                                                        <option class="label_text" value="Default" disabled selected>Route</option>
                                                                        <!-- Options will be dynamically loaded here through AJAX -->
                                                                   
                                                                    </select>
                                                                </p>
                                                                <p>
                                                                    Price: <input class="form-control" type="number" value="<?php echo $fetch['price'] ?>" name="price" required id="">
                                                                </p>
                                                               
                                                                <p>
                                                                    Date :
                                                                    <input type="date" class="form-control" onchange="check(this.value)" id="date" placeholder="Date" name="date" required value="<?php echo (date('Y-m-d', strtotime($fetch["date"]))) ?>">

                                                                </p>
                                                                <p>
                                                                    Time : <input class="form-control" type="time" value="<?php echo $fetch['time'] ?>" name="time" required id="">
                                                                </p>
                                                                <p class="float-right"><input type="submit" name="edit" class="btn btn-success" value="Edit Schedule"></p>
                                                            </form>

                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
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
</section>
</div>




    <div class="modal fade" id="add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" align="center">
            <div class="modal-header">
                <h4 class="modal-title">Add New Schedule &#128649;
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="post">
                    <div class="row">
                    <div class="col-sm-6">
                            Departure : <select class="form-control" name="departure" required id="getRoute" onchange="getRoutes()">
                                                                        <option value="Default" disabled selected>Departure Name</option>
                                                                        <?php
                                                                        $query = "SELECT id, departure FROM bus_route WHERE status= 1";
                                                                        $rows = dbConnect($query);
                                                                        if (!empty($rows)) :
                                                                            foreach ($rows as $row) :
                                                                        ?>
                                                                                <option <?= 'departure', $row['id'] ?> value="<?= $row['departure'] ?>"><?= $row['departure'] ?></option>
                                                                        <?php
                                                                            endforeach;
                                                                        endif;
                                                                        ?>
                            </select>

                        </div>
                        <div class="col-sm-6">
                            Route : <select class="form-control" name="destination" required id="addRoute">
                              <option class="label_text" value="Default" disabled selected>Route</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            Price : <input class="form-control" type="text" name="price" required
                                id="">
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            Date : <input class="form-control" onchange="check(this.value)" type="date" name="date"
                                required id="date">
                        </div>
                        <div class="col-sm-6">

                            Time : <input class="form-control" type="time" name="time" required id="">
                        </div>
                    </div>
                    <hr>
                    <input type="submit" name="submit" class="btn btn-success" value="Add Schedule"></p>
                </form>

                <script>
                function check(val) {
                    val = new Date(val);
                    var age = (Date.now() - val) / 31557600000;
                    var formDate = document.getElementById('date');
                    if (age > 0) {
                        alert("Past/Current Date not allowed");
                        formDate.value = "";
                        return false;
                    }
                }
                </script>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
if (isset($_POST['submit'])) {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $date = formatDate($date);
    $time = $_POST['time'];

    if (!isset($departure, $destination, $price, $date, $time)) {
        alert("Fill Form Properly!");
    } else {
 
        $stmt = $pdo->prepare("INSERT INTO `schedule`(`destination`, `departure`, `date`, `time`, `price`) VALUES (:destination, :departure, :date, :time, :price)");
        $stmt->bindParam(':destination', $destination);
        $stmt->bindParam(':departure', $departure);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':price', $price);

        $stmt->execute();

        alert("Schedule Added!");
        echo "<script>window.location.href='schedule?page=schedule';</script>";
    }
}


if (isset($_POST['edit'])) {
    $destination = $_POST['destination'];
    $departure = $_POST['departure'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $date = formatDate($date);
    $time = $_POST['time'];
    $id = $_POST['id'];

    if (!isset($destination, $departure, $price, $date, $time, $id)) {
        alert("Fill Form Properly!");
    } else {

        $stmt = $pdo->prepare("UPDATE `schedule` SET `departure`=?, `destination`=?, `date`=?, `time`=?, `price`=? WHERE id = ?");
        $stmt->bindParam(1, $departure);
        $stmt->bindParam(2, $destination);
        $stmt->bindParam(3, $date);
        $stmt->bindParam(4, $time);
        $stmt->bindParam(5, $price);
        $stmt->bindParam(6, $id);

        $stmt->execute();

        $msg = "Having considered user's satisfactions and every other things, we the management are so sorry to let inform you that there has been a change in the date and time of your trip. <hr/> New Date: $date. <br/> New Time: " . formatTime($time) . " <hr/> Kindly disregard if the date/time still stays the same.";

        $e = $pdo->query("SELECT users.email FROM users INNER JOIN schedule_booking ON 
        schedule_booking.user_id = users.id WHERE schedule_booking.schedule_id = '$id'");
        while ($getter = $e->fetch(PDO::FETCH_ASSOC)) {
            @sendMail($getter['email'], "Change In Trip Date/Time", $msg);
        }

        alert("Schedule Modified!");
        echo "<script>window.location.href='schedule?page=schedule';</script>";
    }
}


if (isset($_POST['del_bus'])) {

    $id = $_POST['del_bus'];

    $stmt = $pdo->prepare("DELETE FROM schedule WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() < 1) {
        alert("Schedule Could Not Be Deleted. This Route Has Been Tied To Another Data!");
    } else {
        alert("Schedule Deleted!");
    }

    echo "<script>window.location.href='schedule?page=schedule';</script>";
}


?>
<script>
    function getRoutes() {
        var getRoute = $('#getRoute').val();

        // Using jQuery for AJAX request
        $.ajax({
            type: 'POST',
            url: '<?= ROOT ?>/route2',
            data: {
                getRoute: getRoute
            },
            success: function(data) {
                // Update the destination routes dropdown
                $('#addRoute').html(data);
            }
        });
    }
</script>
<script>
    function getDestinationRoutes() {
        var departureRoute = $('#departureRoute').val();

        // Using jQuery for AJAX request
        $.ajax({
            type: 'POST',
            url: '<?= ROOT ?>/route',
            data: {
                departureRoute: departureRoute
            },
            success: function(data) {
                // Update the destination routes dropdown
                $('#destinationRoute').html(data);
            }
        });
    }
</script>