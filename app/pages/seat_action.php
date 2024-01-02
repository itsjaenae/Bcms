<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>seat_booking- <?= APP_NAME ?></title>
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
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalAmount = isset($_POST['total']) ? $_POST['total'] : 0;
    $cartItems = isset($_POST['cart_items']) ? (is_string($_POST['cart_items'])  ? json_decode($_POST['cart_items'], true) : $_POST['cart_items']) : [];
    $selected = json_decode($_POST['selected_seats']);

    if ($selected !== null) {
      $selecteds = implode(',', $selected);

      $insertSeatSql = "INSERT INTO seats (selected_seats, booked, bus_no, email, departure, destination) VALUES (:selected_seats, 1, :bus_no, :email, :departure, :destination)";
      $insertSeatStmt = $pdo->prepare($insertSeatSql);
      $insertSeatStmt->bindParam(':selected_seats', $selecteds);
      $insertSeatStmt->bindParam(':bus_no', $_SESSION['bus_no']);
      $insertSeatStmt->bindParam(':email', $_SESSION['email']);
      $insertSeatStmt->bindParam(':departure', $_SESSION['departure']);
      $insertSeatStmt->bindParam(':destination', $_SESSION['destination']);
      if ($insertSeatStmt->execute()) {
        echo 'Insert successful.<br>';
      } else {
        echo 'Error inserting seat: ' . implode(' - ', $insertSeatStmt->errorInfo()) . '<br>';
      }
    } else {
      echo 'Error decoding selected seats JSON.<br>';
    }






    $_SESSION['seat_booking'] = $cartItems;
    $_SESSION['total'] = $totalAmount;

    echo 'Data stored successfully!';
  } else {
  }

  if (isset($_SESSION['seat_booking'])) {

    $cartItems = $_SESSION['seat_booking'];
    $totalAmount = $_SESSION['total'];

    $jTypeString = !empty($_SESSION['total_amount']) ? $_SESSION['total_amount'] : '';
    $firstJTypeValue = intval($jTypeString);
    // Convert $_SESSION['total'] to a numeric value
    $totalAmount = floatval($_SESSION['total']);
    // Calculate the value to be stored in j_type
    $calculatedJType = $firstJTypeValue * $totalAmount;
    $j_type = $_SESSION['j_type'];

    // Count the number of selected seats
    $no_of_pass = count($cartItems);

    // Store the count in the session variable
    $_SESSION['no_of_pass'] = $no_of_pass;

    echo
    "<div class='containers con table-responsive ' > 
      <table class='table table-bordered table-hover'>
          <thead class='thead-dark'>
              <tr>
                  <th>Seat Selected</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Passenger</th>
                  <th>Total Amount </th>
              </tr>
          </thead>
          <tbody>";

    if (is_array($_SESSION['seat_booking'])) {
      foreach ($_SESSION['seat_booking'] as $item) {
        echo "<tr><td> " . $item['label'] . "</td>
        <td>" . $item['category'] . "</td>
        <td> $" . $item['price'] . "</td>";
      }
      // echo '<td>$' . $totalAmount . '</td>';
      echo '<td >Passengers: ' . $no_of_pass . '</td>';
      echo '<td>For ' . $j_type . ' ticket => $' . $calculatedJType . ' </td></tr>';
    } else {
      echo "Invalid cart items data.";
    }
    echo "</tbody></table></div>";

    echo '<center style="margin-top: 2rem;margin-bottom: 5rem">
      <td><form action="seat">
      <button class="btn btn-primary pull-right" type="submit">
          <span style=color:white;>Go back</span>
      </button>
      </form>
      
      <td><form action="bus_payment">
      <button class="btn btn-primary" type="submit"> 
          <span style=color:white;> Checkout</span>
          </button>
          </form><br><br></center>';
  } else {

    echo 'No data available.';
  }

  ?>



  <?php include  '../app/includes/footer.php' ?>
</body>

</html>