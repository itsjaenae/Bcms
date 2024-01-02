<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Schedule Done - <?= APP_NAME ?></title>
    <style>
        .center {
            background: #D3D3D3;
            text-align: center;
            padding: 30px 50px;
            justify-content: center;
            margin: 20px;
        }

        form {
            margin: 40px
        }

        .con {
            margin: 20px;
            margin-top: 4rem
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printable,
            #printable * {
                visibility: visible;
            }

            #printable {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<?php include '../app/includes/header.php' ?>

<body style="background-color: F5F1F0;margin-top: 5rem;">
    <h2 align="center"><b><img src="https://img.icons8.com/ios-filled/50/000000/summary-list.png" /> Booking Summary</b></h2>
    <br>

    <?php
    if (!isset($_SESSION['USER'])) {
        echo "<script>alert('User not logged in'); window.location.href = 'sign_in';</script>";
        exit(); // Stop execution if the user is not logged in
    }
    // Fetch data using PDO
    $selectQuery = "SELECT * FROM `schedule_booking` WHERE `schedule_id` = :schedule_id ORDER BY `booked_id` DESC LIMIT 1";
    $selectStmt = $pdo->prepare($selectQuery);
    $selectStmt->bindParam(':schedule_id', $_SESSION['schedule_id']);
    $selectStmt->execute();

    // Check if there are any rows returned
    if ($row = $selectStmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["booked_id"];
        $_SESSION['booked_id'] = $id;

    ?>
        <div class="ticket" id="printable">
            <table class="table table-striped" id="font">

                <tr>
                    <th>Ticket No</th>
                    <td><?php echo $row['booked_id']; ?></td>
                </tr>

                <tr>
                    <th>Card Name</th>
                    <td><?php echo $row['card_name'] ?></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><?php echo $row['email'] ?></td>
                </tr>

                <tr>
                    <th>Bus No</th>
                    <td><?php echo $row['bus_no'] ?></td>
                </tr>
                <tr>
                    <th>No Of Passengers</th>
                    <td><?php echo $row['pass'] ?></td>
                </tr>
                <tr>
                    <th>Departure</th>
                    <td><?php echo $row['departure'] ?></td>
                </tr>
                <tr>
                    <th>Departure Date/Time</th>
                    <td><?php echo  date("D d, M Y", strtotime($row['date'])), " / ", formatTime($row['time'])  ?></td>
                </tr>
                <tr>
                    <th>Destination</th>
                    <td><?php echo $row['destination'] ?></td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td>$&nbsp;&nbsp;<?php echo $row['price'] ?></td>
                </tr>

            </table>
        </div>
        <table align="center" style="margin-top: 3rem;">
            <tr>
                <td><a href="javascript:void(0);" onclick="printTicket()">
                        <h3><span style="color:#fff;background-color: black; 
    border-color: black; padding: 0.8rem; border-radius: 0.5rem">
                                Print Ticket
                            </span></h3>
                    </a></td>
            </tr>
        </table>
    <?php } ?>

    <script>
        function printTicket() {
            var printContent = document.getElementById("printable").outerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</body>

</html>