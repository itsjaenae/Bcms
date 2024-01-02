<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Booking Action- <?= APP_NAME ?> </title>
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

        th {
            background-color: #361999 !important
        }
    </style>
</head>
<?php include  '../app/includes/header.php' ?>

<body>

    <?php
 if (!isset($_SESSION['USER'])) {
    echo "<script>alert('User not logged in'); window.location.href = 'sign_in';</script>";
    exit(); // Stop execution if the user is not logged in
}
    if (!empty($_POST)) {

        if (!isset($_POST['departure'], $_POST['j_type'], $_POST['date_of_depart'])) {
            echo "<h1><center class='center'>Please refill the details properly</center></h1><br><br>";
            echo '<center><td><form action="bus_ticket" onsubmit="return goBackOnSubmit()"><button style="background-color: #361999; padding: 20px 40px; type="submit"; align=center;"><span style=color:white;><h3>Go back</h3></span></a></td></button></form><br><br>';
        } else {
            $j_types = $_POST['j_type'];
            $j_type = explode('|', $j_types);
            $departure = $_POST['departure'];
            $destination = $_POST['destination'];
            $d_depart = $_POST['date_of_depart'];
            $d_return = $_POST['date_of_return'];

            if (empty($departure)) {
                echo "<h1><center class='center'>Please refill the details properly</center></h1><br><br>";
                echo '<center><td><form action="bus_ticket" onsubmit="return goBackOnSubmit()"><button style="background-color: #361999; padding: 20px 40px; type="submit"; align=center;"><span style=color:white;><h3>Go back</h3></span></a></td></button></form><br><br>';
            } else {
                $sql = "SELECT * FROM bus_route WHERE departure = :departure AND destination = :destination LIMIT 1";
                $fetchRouteStmt = $pdo->prepare($sql);
                $fetchRouteStmt->bindParam(':departure', $departure);
                $fetchRouteStmt->bindParam(':destination', $destination);

                if ($fetchRouteStmt->execute()) {
                    $row = $fetchRouteStmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $dbDepartureDate = $row["dep_date"];

                        if (strtotime($dbDepartureDate) >= strtotime(date('Y-m-d'))) {
                            $price = $row["price"] * $j_type[0];
                            $bus_no = $row["bus_no"];
                            $prices = number_format($price, 2, ".", ",");

                            // Store data into sessions
                            $_SESSION['bus_no'] = $bus_no;
                            $_SESSION['departure'] = $departure;
                            $_SESSION['destination'] = $destination;
                            $_SESSION['j_type'] = $j_type[1];
                            $_SESSION['total_amount'] = $j_type[0];
                            $_SESSION['date_of_depart'] = $d_depart;
                            $_SESSION['date_of_return'] = $d_return;

                            echo "<div class='containers con table-responsive ' > 
                            <table class='table table-bordered table-hover'>
                                <thead class='thead-dark'>
                                    <tr >
                                        <th> Bus No</th>
                                        <th>Departure</th>
                                        <th>Destination</th>
                                        <th> Depart Date</th>
                                        <th> Return Date </th>
                                        <th> Type</th>
                                        <th> Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>$bus_no</td>
                                        <td>$departure</td>
                                        <td>$destination</td>
                                        <td>$d_depart</td>
                                        <td>$d_return </td>
                                        <td> $j_type[1]</td> 
                                        <td>$$prices</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>";

                            echo '<center style="margin-top: 2rem;margin-bottom: 5rem">
                            <td><form action="seat">
                                <button class="btn btn-primary pull-left" type="submit">
                                    <span style=color:white;>View Seat</span>
                                </button>
                            </form>
                            <td><form action="bus_ticket" onsubmit="return goBackOnSubmit()">
                                <button class="btn btn-primary" type="submit"> 
                                    <span style=color:white;> Go back</span>
                                </button>
                            </form><br><br></center>';
                        } else {
                            echo "<h1><center class='center'>No routes available for the selected date</center></h1><br><br>";
                        }
                    } else {
                        echo "<h1><center class='center'>No routes found for the selected departure and destination</center></h1><br><br>";
                    }
                } else {
                    echo "<h1><center class='center'>Error fetching bus route information</center></h1><br><br>";
                }
            }
        }
    }
    ?>

    <?php include  '../app/includes/footer.php' ?>
    <script>
        function goBackOnSubmit() {
            goBack();
            return false;
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>