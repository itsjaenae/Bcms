<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'bus_route';
$me = "?page=$source";
if (isset($_GET['status'], $_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    if ($status == 0) {
        $status = 0;
    } else {
        $status = 1;
    }
    $query = ("UPDATE bus_route SET status = '$status' WHERE id = '$id'");
    $queryn = dbConnect($query);
    echo "<script>alert('Action completed!');window.location.href='bus_route$me';</script>";
}
?>

<div class="content">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card card-success">
                        <div class="card-header" style="background-color:#17a2b8">
                            <h3 class="card-title">
                                All Bus Routes</h3>
                            <div class='float-right'>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add">
                                    Add New Bus Route &#128645;
                                </button>
                            </div>
                        </div>

                        <div class="card-body">

                            <table id="example1" style="align-items: stretch; " class="table table-hover w-100 table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Price</th>
                                        <th>f Price</th>
                                        <th>Bus No</th>
                                        <th>class</th>
                                        <th>D-Date</th>
                                        <th>D-Time</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $query = "select * from bus_route ";
                                    $rows = dbConnect($query);
                                    if ($rows < 1) echo "No Records Yet";
                                    $sn = 0;

                                    ?>
                                    <?php if (!empty($rows)) : ?>
                                        <?php foreach ($rows as $row) :  ?>

                                            <tr>
                                                <td><?php echo ++$sn; ?></td>
                                                <td><?php echo $row['departure']; ?></td>
                                                <td><?php echo $row['destination'];

                                                    //   $fullname = $row['departure'] . " to " . $row['destination']; 
                                                    ?></td>
                                                <td>$<?php echo $row['price']; ?></td>
                                                <td>$<?php echo $row['f_price']; ?></td>
                                                <td><?php echo $row['bus_no']; ?></td>
                                                <td><?php echo $row['class']; ?></td>
                                                <td><?php echo  date("D d, M Y", strtotime($row['dep_date'])) ; ?></td>
                                                <td><?php echo $row['dep_time'], " / ", formatTime($row['dep_time']); ?></td>

                                                <td>
                                                    <?php
                                                    if ($row['status'] == 0) {
                                                    ?>
                                                        <a href="<?= ROOT ?>/admin/bus_route?page=bus_route&status=1&id=<?php echo $row['id']; ?>">
                                                            <button onclick="return confirm('You are about to enable this route.')" type="submit" class="btn btn-success">
                                                                Enable Route
                                                            </button></a>
                                                    <?php } else { ?>
                                                        <a href="<?= ROOT ?>/admin/bus_route?page=bus_route&status=0&id=<?php echo $row['id']; ?>">
                                                            <button onclick="return confirm('You are about to disable this route.')" type="submit" class="btn btn-danger">
                                                                Disable Route
                                                            </button></a>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <form method="POST">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $row['id'] ?>">
                                                            Edit
                                                        </button> -

                                                        <input type="hidden" class="form-control" name="del_bus" value="<?php echo $row['id'] ?>" required id="">
                                                        <button type="submit" onclick="return confirm('Are you sure about this?')" class="btn btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>


                                            <div class="modal fade" id="edit<?php echo $row['id'] ?>">
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
                                                                <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>" required id="">
                                                                <p>From : <input type="text" class="form-control" value="<?php echo $row['departure'] ?>" name="departure" required id="">
                                                                </p>
                                                                <p> To : <input type="text" class="form-control" value="<?php echo $row['destination'] ?>" name="destination" required id="">
                                                                </p>
                                                                <p> Price : <input type="text" class="form-control" value="<?php echo $row['price'] ?>" name="price" required id="">
                                                                </p>
                                                                 <p>First Class Price : <input type="text" class="form-control" value="<?php echo $row['f_price'] ?>" name="f_price" required id="">
                                                                </p>
                                                                
                                                                <p> Bus Number : <input type="text" class="form-control" value="<?php echo $row['bus_no'] ?>" name="bus_no" required id="">
                                                                </p>

                                                                <p> Class : <select name="class[]" multiple class="form-control tm-select" required id="class">
                                                                        <option value="<?= $row['class'] ?>" <?= old_select('class', $row['id']) ?> selected><?= $row['class'] ?></option>

                                                                        <option value="First Class">First Class</option>
                                                                        <option value="Second Class">Second Class</option>
                                                                        <option value="A.C">A.C</option>
                                                                        <option value="Tv">Tv</option>
                                                                    </select>

                                                                </p>
                                                               
                                                                <p> Departing Date : <input type="date" class="form-control" onchange="check(this.value)" value="<?php echo date("D d, M Y", strtotime($row['dep_date']))   ?>" name="dep_date" required id="date">
                                                                </p>
                                                                <p> Dep Time : <input type="time" class="form-control" name="dep_time" required id="" value="<?php echo $row['dep_time'] ?>">
                                                                </p>
                                                                <p>
                                                                    <input class="btn btn-info" type="submit" value="Edit Bus Route" name='edit'>
                                                                </p>
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

                                            <?php endforeach; ?>
                                        <?php endif; ?>
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
                <h4 class="modal-title">Add New Bus Route &#128649;
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <table class="table table-bordered">

                        <tr>
                            <th>From</th>
                            <td><input type="text" class="form-control" name="departure" required id=""></td>
                        </tr>
                        <tr>
                            <th>To</th>
                            <td><input type="text" class="form-control" name="destination" required id="">
                            </td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><input type="text" class="form-control" name="price" required id="">
                            </td>
                        </tr>
                        <tr>
                            <th>First Class Price</th>
                            <td><input type="text" class="form-control" name="f_price" required id="">
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Bus Number</th>
                            <td><input type="text" class="form-control" name="bus_no" required id="">
                            </td>
                        </tr>

                        <tr>
                            <th>Class</th>
                            <td><select name="class[]" multiple class="form-control tm-select" required id="class">
                                    <option value="Default" disabled selected>Class Type</option>
                                    <option value="First Class">First Class</option>
                                    <option value="Second Class">Second Class</option>
                                    <option value="A.C">A.C</option>
                                    <option value="Tv">Tv</option>
                                </select>
                            </td>
                        </tr>
                       
                        <tr>
                            <th> Departing Date </th>
                            <td> <input type="date" class="form-control" onchange="check(this.value)" name="dep_date" required id="date">
                            </td>
                        </tr>
                        <tr>
                            <th> Departing Time </th>
                            <td><input type="time" class="form-control" name="dep_time" required id="">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">

                                <input class="btn btn-info" type="submit" value="Add Bus Route" name='submit'>
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

<?php

if (isset($_POST['submit'])) {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $f_price = $_POST['f_price'];
    $bus_no = $_POST['bus_no'];

    $class = $_POST['class'];
    $dep_date = $_POST['dep_date'];
    $dep_time = $_POST['dep_time'];
    if (!isset($destination, $departure, $price, $f_price, $bus_no, $dep_date, $dep_time,  $class,)) {
        alert("Fill Form Properly!");
    } else {
        foreach ($_POST['class'] as $class) {
            $class = implode(',', $_POST['class']);
           
         $sql = "insert into bus_route (departure, destination, price, f_price,  bus_no,  class, dep_date, dep_time) values (:departure, :destination, :price, :f_price, :bus_no,  :class,  :dep_date, :dep_time)";
         $handle = $pdo->prepare($sql);
         
            $params = [
                ':departure' => $departure,
                ':destination' => $destination,
                ':price' => $price,
                ':f_price' => $f_price,
                ':bus_no' => $bus_no,
                  ':class'=>$class,
                ':dep_date' => $dep_date,
                ':dep_time' => $dep_time
            ];

            $handle->execute($params);
            // alert("bus_route Added!");
            // redirect($_SERVER['PHP_SELF'] . "$me");
            echo "<script>alert('bus_route Added!');window.location.href='bus_route$me';</script>";
        }
    }
}


if (isset($_POST['edit'])) {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $f_price = $_POST['f_price'];
    $bus_no = $_POST['bus_no'];

    $class = $_POST['class'];
    $dep_date = $_POST['dep_date'];
    $dep_time = $_POST['dep_time'];
    $id = $_POST['id'];
    if (!isset($departure, $destination, $price)) {
        alert("Fill Form Properly!");
    } else {
        foreach ($_POST['class'] as $class) {
            $class = implode(',', $_POST['class']);
            $sql = "UPDATE bus_route SET  departure = :departure, destination = :destination, price = :price,  f_price = :f_price,  bus_no = :bus_no,   class = :class, dep_date = :dep_date, dep_time = :dep_time WHERE id= :id ";
            $handle = $pdo->prepare($sql);
            $handle->bindParam(':id', $id, PDO::PARAM_INT);
            $handle->bindParam(':price', $price, PDO::PARAM_STR);
            $handle->bindParam(':f_price', $f_price, PDO::PARAM_STR);
            $handle->bindParam(':departure', $departure, PDO::PARAM_STR);
            $handle->bindParam(':destination', $destination, PDO::PARAM_STR);
            $handle->bindParam(':bus_no', $bus_no, PDO::PARAM_STR);
            $handle->bindParam(':class', $class, PDO::PARAM_STR);
            $handle->bindParam(':dep_date', $dep_date, PDO::PARAM_STR);
            $handle->bindParam(':dep_time', $dep_time, PDO::PARAM_STR);

            $handle->execute();
           
            echo "<script>alert('Action completed!');window.location.href='bus_route$me';</script>";
            //  alert("Route Modified!");
            //  load($_SERVER['PHP_SELF'] . "$me");
        }
    }
}


// if (isset($_POST['del_bus'])) {
//     $id = $_POST['del_bus'];
//     $query = "DELETE FROM bus_route WHERE id =  :del_bus";
//     $handle = $pdo->prepare($query);
//     $handle->bindParam(':del_bus', $id, PDO::PARAM_INT);
//     if ($handle->execute()) {
//         echo "<script>window.location.href='bus_route$me';</script>";
//         //alert('bus_route Could Not Be Deleted. This bus_route Has Been Tied To Another Data!');
//     } else {
//         echo "<script>alert('bus_route Deleted!');window.location.href='bus_route$me';</script>";
//     }
// }
if (isset($_POST['del_bus'])) {
    $id = $_POST['del_bus'];

    // Start a transaction to ensure atomicity
    $pdo->beginTransaction();

    try {
      
        $query = "DELETE bus_route, seats, bus_booking
                  FROM bus_route
                  LEFT JOIN seats ON bus_route.departure = seats.departure AND
                   bus_route.destination = seats.destination
                  LEFT JOIN bus_booking ON bus_route.departure = bus_booking.departure AND 
                  bus_route.destination = bus_booking.destination
                  WHERE bus_route.id = :del_bus";

        $handle = $pdo->prepare($query);
        $handle->bindParam(':del_bus', $id, PDO::PARAM_INT);
        $handle->execute();

        // Commit the transaction
        $pdo->commit();

        echo "<script>alert('Bus Route and related records deleted!');window.location.href='bus_route$me';</script>";
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        echo "<script>alert('Error deleting Bus Route!');window.location.href='bus_route$me';</script>";
    }
}
?>


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