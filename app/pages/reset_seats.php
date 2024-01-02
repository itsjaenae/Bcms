<?php


if (isset($_SESSION['email'], $_POST['bus_no'], $_POST['email'])) {
    $userEmail = $_SESSION['email'];
    $busNoToReset = $_POST['bus_no'];
    $requestedEmail = $_POST['email'];

    // Check if the logged-in user's email matches the requested email
    if ($userEmail === $requestedEmail) {
        try {
            // Delete seats associated with the specified bus_no and email
            $deleteSeatsSql = "DELETE FROM seats WHERE bus_no = :bus_no AND email = :email";
            $deleteSeatsStmt = $pdo->prepare($deleteSeatsSql);
            $deleteSeatsStmt->bindParam(':bus_no', $busNoToReset);
            $deleteSeatsStmt->bindParam(':email', $userEmail);

            if ($deleteSeatsStmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error resetting seats']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
      
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
