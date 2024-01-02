<?php
if (!isset($file_access)) die("Direct File Access Denied");
$source = 'payment';
$me = "?page=$source";
?>
<div class="content">



    <div class="row">
        <div class="container-fluid">
            <div class="row">
        <div class="col-xs-12">


                <div class="card card-success">
                    <div class="card-header border-0" style="background-color:#17a2b8">
                        <h3 class="card-title">All Payments</h3>

                    </div>
                    <div class="card-body">
                    <table id="example1" style="align-items: stretch; " class="table table-hover w-100 table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ticket No</th>
                                    <th>Card Name</th>
                                    <th>Email</th>
                                    <th>Seat Booked</th>
                                    <th>Type</th>
                                    <th>Bus No</th>
                                    <th>Passengers</th>
                                    <th>Departure</th>
                                    <th>Date</th>
                                    <th>Destination</th>
                                    <th>Return</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
// Assuming you have a PDO connection named $pdo

$query = "SELECT * FROM bus_booking";
$stmt = $pdo->query($query);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    $seatJson = $row['seat_booking'];
    $seatArray = json_decode($seatJson, true);
?>
<tr>
    <td><?php echo $row['booked_id']; ?></td>
    <td><?php echo $row['card_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td>
                        <?php
                        if (is_array($seatArray)) {
                            // Access each element of the array
                            foreach ($seatArray as $seat) {
                                echo "Seat NO:" . $seat[0] .  "=> " . $seat[1] . '<br>';
                            }
                        } else {
                            echo "No seat information available";
                        }
                        ?>   
                    </td>
    <td><?php echo $row['j_type']; ?></td>
    <td><?php echo $row['bus_no']; ?></td>
    <td><?php echo $row['no_of_pass']; ?></td>
    <td><?php echo $row['departure']; ?></td>
    <td><?php echo  date("D d, M Y", strtotime($row['date_of_depart'])); ?></td>
    <td><?php echo $row['destination']; ?></td>
    <td><?php echo  date("D d, M Y", strtotime($row['date_of_return'])); ?></td>
    <td>$<?php echo $row['total_amount']; ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
 
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- /.col -->
</div>
<!-- /.row -->

</div>