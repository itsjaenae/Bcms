<!DOCTYPE html>
<html lang="en">

<head>   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>User Dashboard- <?= APP_NAME ?></title>

    <style>
        table#database_table {
            font-size: 16px;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            overflow-x: auto;
        }

        #database_table td,
        #database_table th {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        #database_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #database_table th {
            padding-top: 11px;
            padding-bottom: 11px;
            background-color: black;
            color: white;
        }

        @media (max-width: 1200px) {

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th,
            td {
                min-width: 200px;
            }
        }
    </style>
    <?php include '../app/includes/header.php' ?>
</head>

<body>
    <div class="container" style="margin-top: 2rem; margin-bottom: 5rem;">
        <h2>
            <center><b><img src="https://img.icons8.com/nolan/64/database.png" />USER'S BUS BOOKINGS <img src="https://img.icons8.com/ultraviolet/50/000000/bus.png" /></center></b></h1>
            <br />
            <table id="database_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Travel Date</th>
                        <th>Booking ID</th>
                        <th>Card Name</th>
                        <th>Seat Booking</th>
                        <th>Type</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Bus Number</th>
                        <th>Amount Paid</th>
                        <th>Print</th>
                        <th>Date Booked</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlTransactions = "SELECT * FROM `bus_booking` WHERE `email` = :email";
                    $selectStmt = $pdo->prepare($sqlTransactions);
                    $selectStmt->bindParam(':email', $_SESSION['email']);
                    $selectStmt->execute();
   
                    if ($selectStmt->rowCount() > 0) {
                        while ($row = $selectStmt->fetch(PDO::FETCH_ASSOC)) {
                            $seatJson = $row['seat_booking'];
                            $seatArray = json_decode($seatJson, true);

                            echo '<tr>
                                <td>' .  date("D d, M Y", strtotime($row['date_of_depart']))  . '</td>
                                <td>' . $row["booked_id"] . '</td>
                                <td>' . $row["card_name"] . '</td>
                                <td>';

                            if (is_array($seatArray)) {
                                foreach ($seatArray as $seat) {
                                    echo "Seat:" . $seat[0] . "=> " . $seat[1] . '<br>';
                                }
                            } else {
                                echo "No seat information available";
                            }

                            echo '</td>
                                <td>' . $row["j_type"] . '</td>
                                <td>' . $row["departure"] . '</td>
                                <td>' . $row["destination"] . '</td>
                                <td>' . $row["bus_no"] . '</td>
                                <td>$&nbsp&nbsp' . $row["total_amount"] . '</td>
                              <td><a  href="print_ticket?pid=' . $row["booked_id"] . '">Click Here</a></td>
                              <td>' .  date("D d, M Y", strtotime($row['booked_date']))  . '</td>
                            </tr>';
                        }
                    } else {
                        echo "<tr><td colspan='10'><h2>No Records Found</h2></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
    </div>

    <?php include '../app/includes/footer.php' ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#database_table').DataTable({
            "order": [
                [1, "desc"]
            ]
        });
    });
</script>