<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Schedules - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-custom {
            margin-top: 2rem;
            margin-bottom: 5rem;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

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

        .alert-custom {
            margin-top: 1rem;
        }

        .pagination {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }

        .pagination a {
            color: #007bff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
            background-color: #f8f9fa;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>

    <?php include '../app/includes/header.php' ?>
</head>

<body>
    <div class="container container-custom">
        <h2><b><img src="https://img.icons8.com/nolan/64/database.png" />Book A Schedule
                <img src="https://img.icons8.com/ultraviolet/50/000000/bus.png" /></b></h2>
        <br />
        <?php


        $stmt = $pdo->prepare("SELECT * FROM `schedule` WHERE STR_TO_DATE(`date`, '%d-%m-%Y') >= STR_TO_DATE(:today, '%d-%m-%Y')");
        $stmt->bindParam(':today', $today, PDO::PARAM_STR);
        $today = date('d-m-Y');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo "<div class='alert alert-danger alert-custom' role='alert'>
            Sorry, There are no schedules at the moment! Please visit after some time.
          </div>";
        } else {
            $sn = 0;
        ?>
            <table id="database_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Date/Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $fetch) {
                        $db_date = $fetch['date'];
                        if ($db_date == date('d-m-Y')) {
                            $db_time = $fetch['time'];
                            $current_time = date('H:i');
                            if ($current_time >= $db_time) {
                                continue;
                            }
                        }
                        $id = $fetch['id'];

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_schedule'])) {
                            $schedule_id = $_POST['schedule_id'];
                            $_SESSION['schedule_id'] = $schedule_id;
                            //  echo "Form Schedule ID: " . $_POST['schedule_id'];
                            // echo "Session Schedule ID: " . $_SESSION['schedule_id'];

                            $redirect_url = "schedule_booking?timestamp=" . time();
                            echo '<script type="text/javascript">window.location.href="' . $redirect_url . '";</script>';
                            exit;
                        }

                    ?>
                        <tr>
                            <td><?= ++$sn ?></td>
                            <td><?= $fetch['departure'] ?></td>
                            <td><?= $fetch["destination"] ?></td>
                            <td><?= date("D d, M Y", strtotime($fetch['date'])) . '/' . formatTime($fetch['time']) ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="schedule_id" value="<?= $id ?>">
                                    <button type="submit" name="book_schedule" class="btn btn-info">
                                        Book
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>

    </div>

    <?php include '../app/includes/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#database_table').DataTable({
                "order": [
                    [1, "desc"]
                ]
            });
        });
    </script>
</body>

</html>