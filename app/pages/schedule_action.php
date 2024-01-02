<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Schedule Action- <?= APP_NAME ?> </title>
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
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $schedule_id = $_SESSION['schedule_id'];

    //   if (isset($_SESSION['schedule_id'])) {
    //     $schedule_id = $_SESSION['schedule_id'];
    //     echo "Schedule ID: " . $schedule_id;
    // } else {
    //     echo "Schedule ID not found in the session.";
    // }

    // Check if the user exists
    $checkUserQuery = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $checkUserStmt = $pdo->prepare($checkUserQuery);
    $checkUserStmt->bindParam(':email', $email);

    if ($checkUserStmt->execute()) {
      $userId = $checkUserStmt->fetchColumn();

      $name = $_POST['card_name'];
      $card = $_POST['card_no'];
      $EY   = $_POST['exp_year'];
      $EM   = $_POST['exp_month'];
      $Cvv  = $_POST['cvv'];
      $Pin  = $_POST['pin'];
      $pass = $_POST['pass'];


      $sql = "SELECT *
      FROM schedule
      JOIN bus_route ON schedule.departure = bus_route.departure AND schedule.destination = bus_route.destination
      WHERE schedule.id = :schedule_id";

      $smt = $pdo->prepare($sql);
      $smt->bindParam(':schedule_id', $schedule_id);
      //$smt->bindValue(':schedule_id', $schedule_id, PDO::PARAM_INT);


      $smt->execute();

      $scheduleInfo = $smt->fetch(PDO::FETCH_ASSOC);

      if ($scheduleInfo) {
        $booked_id = uniqid('BOOKED');
        $booked_date = date('Y-m-d');

        $insertBooking = $pdo->prepare("INSERT INTO schedule_booking (booked_id, user_id, email, time, schedule_id, 
          departure, destination, date, pass, card_no, card_name, exp_month, exp_year, cvv, pin, price, 
          bus_no, booked_date) VALUES (:booked_id, :user_id, :email, :time, :schedule_id, :departure, 
          :destination, :date, :pass, :card_no, :card_name, :exp_month, :exp_year, :cvv, 
          :pin, :price, :bus_no, :booked_date)");

        $calculatedPrice = $scheduleInfo['price'] * $pass;

        $insertBooking->bindParam(':booked_id', $booked_id);
        $insertBooking->bindParam(':user_id', $userId);
        $insertBooking->bindParam(':email', $email);
        $insertBooking->bindParam(':time', $scheduleInfo['time']);
        $insertBooking->bindParam(':schedule_id', $schedule_id);
        $insertBooking->bindParam(':departure', $scheduleInfo['departure']);
        $insertBooking->bindParam(':destination', $scheduleInfo['destination']);
        $insertBooking->bindParam(':date', $scheduleInfo['date']);
        $insertBooking->bindParam(':pass', $pass);
        $insertBooking->bindParam(':card_no', $card);
        $insertBooking->bindParam(':card_name', $name);
        $insertBooking->bindParam(':exp_month', $EM);
        $insertBooking->bindParam(':exp_year', $EY);
        $insertBooking->bindParam(':cvv', $Cvv);
        $insertBooking->bindParam(':pin', $Pin);
        $insertBooking->bindParam(':price', $calculatedPrice);
        $insertBooking->bindParam(':bus_no', $scheduleInfo['bus_no']);
        $insertBooking->bindParam(':booked_date', $booked_date);

        if ($insertBooking->execute()) {
          echo '<script>window.location.href = "schedule_done";</script>';
          exit();
        } else {
          echo "<div class='alert alert-danger' role='alert'>
                      Failed to book. Please try again.
                  </div>";
        }
      } else {
        echo "<div class='alert alert-danger' role='alert'>
                  Schedule information not found.
              </div>";
      }
    }
  }



  ?>


  <?php include  '../app/includes/footer.php' ?>
</body>

</html>