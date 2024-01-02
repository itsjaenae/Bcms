<?php


$bus_no = $_SESSION['bus_no']; 
$fetchBookedSeatsSql = "SELECT selected_seats FROM seats WHERE bus_no = :bus_no AND booked = 1";
$fetchBookedSeatsStmt = $pdo->prepare($fetchBookedSeatsSql);
$fetchBookedSeatsStmt->bindParam(':bus_no', $bus_no);

if ($fetchBookedSeatsStmt->execute()) {
    $bookedSeatsString = $fetchBookedSeatsStmt->fetchAll(PDO::FETCH_COLUMN);

    $bookedSeats = [];

    foreach ($bookedSeatsString as $seatsString) {
        $seats = explode(',', $seatsString);
        $bookedSeats = array_merge($bookedSeats, $seats);
    }

    echo json_encode($bookedSeats);
} else {
    echo json_encode(['error' => 'Error fetching booked seats']);
}
?>
