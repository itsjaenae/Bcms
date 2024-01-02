<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Payment- <?= APP_NAME ?> </title>
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
  // Check if the user is logged in
  if (!isset($_SESSION['USER'])) {
    echo "<script>alert('User not logged in'); window.location.href = 'sign_in';</script>";
    exit(); // Stop execution if the user is not logged in
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $currentDate = date('Y-m-d');
  $email = $_SESSION['email'];

  // Check if the user exists
  $checkUserQuery = "SELECT id FROM users WHERE email = :email LIMIT 1";
  $checkUserStmt = $pdo->prepare($checkUserQuery);
  $checkUserStmt->bindParam(':email', $email);

  if ($checkUserStmt->execute()) {
    $userId = $checkUserStmt->fetchColumn();

  // Continue with the submission
  $name = $_POST['card_name'];
  $card = $_POST['card_no'];
  $EY   = $_POST['exp_year'];
  $EM   = $_POST['exp_month'];
  $Cvv  = $_POST['cvv'];
  $Pin  = $_POST['pin'];

  $bookingID = uniqid('booked_', true);
  $seatBookingArray = !empty($_SESSION['seat_booking']) ? $_SESSION['seat_booking'] : [];
  $seatBookingArray = array_map('array_values', $seatBookingArray);
  $serializedSeatBooking = json_encode($seatBookingArray);

  $jTypeString = !empty($_SESSION['total_amount']) ? $_SESSION['total_amount'] : '';
  $firstJTypeValue = intval($jTypeString);
  $totalAmount = floatval($_SESSION['total']);
  $calculatedJType = $firstJTypeValue * $totalAmount;

  if ($serializedSeatBooking === false) {
      echo "Error encoding seat booking data to JSON";
  } else {
      $sql = "INSERT INTO bus_booking 
              (booked_id,  email, departure, destination, bus_no, date_of_depart, 
              date_of_return, card_no, exp_year, exp_month, cvv, card_name, seat_booking, total, pin,  j_type, total_amount, no_of_pass, booked_date, user_id) 
              VALUES (:bookingID,  :email, :departure, :destination, :bus_no, :date_of_depart, 
              :date_of_return, :card_no, :exp_year, :exp_month, :cvv, :card_name, :seat_booking, :total, :pin,  :j_type, :total_amount, :no_of_pass, :booked_date, :user_id)";

      // Prepare the statement
      $stmt = $pdo->prepare($sql);

      // Bind parameters   
      $stmt->bindParam(':bookingID', $bookingID);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':departure', $_SESSION['departure']);
      $stmt->bindParam(':destination', $_SESSION['destination']);
      $stmt->bindParam(':bus_no', $_SESSION['bus_no']);
      $stmt->bindParam(':date_of_depart', $_SESSION['date_of_depart']);
      $stmt->bindParam(':date_of_return', $_SESSION['date_of_return']);
      $stmt->bindParam(':card_no', $card);
      $stmt->bindParam(':exp_year', $EY);
      $stmt->bindParam(':exp_month', $EM);
      $stmt->bindParam(':cvv', $Cvv);
      $stmt->bindParam(':card_name', $_POST['card_name']);
      $stmt->bindParam(':seat_booking', $serializedSeatBooking);
      $stmt->bindParam(':total', $_SESSION['total']);
      $stmt->bindParam(':pin', $Pin);
      $stmt->bindParam(':j_type', $_SESSION['j_type']);
      $stmt->bindParam(':total_amount', $calculatedJType);
      $stmt->bindParam(':no_of_pass', $_SESSION['no_of_pass']);
      $stmt->bindParam(':user_id', $userId);
      $stmt->bindParam(':booked_date', $currentDate);
  }

  // Execute the statement
  if ($stmt->execute()) {
      echo "<h1><center>Your Ticket has been successfully booked<center></h1><br>";
      echo '<script>window.location.href = "booking_done";</script>';
      exit();
  } else {
      echo "Error: " . $stmt->errorInfo()[2];
  }
   
    }
}

 


  ?>


  <?php include  '../app/includes/footer.php' ?>
</body>

</html>