<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $departureRoute = $_POST['departureRoute'];
        // Fetch destination routes based on the selected departure route
        $sql = "SELECT DISTINCT destination FROM bus_route WHERE departure = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$departureRoute]);
        $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($destinations) {
            $options = '';

            foreach ($destinations as $row) {
                $destination = $row['destination'];
                $options .= '<option value="' . $destination . '">' . $destination . '</option>';
            }

            echo $options;
        } else {
            echo '<option value="">No destinations found</option>';
        }
   
}




?>