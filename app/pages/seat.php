<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Seat Booking - <?= APP_NAME ?></title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/jquery.seat-charts.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?= ROOT ?>/assets/js/jquery.seat-charts.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/seat.css">
</head>
<?php include  '../app/includes/header.php' ?>

<body>
    <?php
    $departureName = isset($_SESSION['departure']) ? $_SESSION['departure'] : '';
    // Fetch the prices from the database based on the departure name
    if (!empty($departureName)) {
        $sql = "SELECT f_price, price FROM bus_route WHERE departure = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$departureName]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $firstClassPrice = $row['f_price'];
            $secondClassPrice = $row['price'];
        } else {
            $firstClassPrice = 55;
            $secondClassPrice = 44;
        }
    }
    ?>





    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="panel grid-50">
                    <div id="bus-seat-map">
                        <div class="front-indicator">Book a Seat</div>
                        <div class="pilot">
                            <div class='wheel'>
                                <img class='steering' src="<?= ROOT ?>/assets/img/wheel.png" alt="wheel">
                            </div>
                            <div class="fuselage">
                                <button type="button" class="door_right">DOOR</button>
                            </div>
                            <div class=" fuselage">
                                <button type="button" class="door_center">DOOR</button>
                            </div>
                        </div>
                        <div class="cabin fuselage" id="bus-seat-map"></div>
                    </div>
                </div>

                <div class="grid-50 booking_details">
                    <div class="booking-details">
                        <form method="post">
                            <h2>Booking Details</h2>
                            <h3>Selected Seats (<span id="counter" name="counter" readonly>0</span>):</h3>
                            <input type="hidden" name="cart_items[]" id="selected-seats-input" value="">
                            <ul id="selected-seats" name="selected_seats[]"></ul>
                            <input type="hidden" name="total" id="total-input" value="">
                            <h2>Total: <b>$<span id="total" name="total_value" readonly>0</span></b></h2>
                            <button type="submit" id="checkout-button">Submit Book</button>
                            <div id="legend"></div>
                        </form>
                        <button id="reset-btn" type="button">Remove selected Seat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        var firstSeatLabel = 1;
        var booked = [];
        var selected = [];
        var sc;
        var $cart = $('#selected-seats');
        var $counter = $('#counter');
        var $total = $('#total');

        function initializeSeatMap() {
            sc = $('#bus-seat-map').seatCharts({
                map: [
                    'ff_ff',
                    'ff_ff',
                    'ee_ee',
                    'ee_ee',
                    'ee___',
                    'ee_ee',
                    'ee_ee',
                    'ee_ee',
                    'eeeee',
                ],
                seats: {
                    f: {
                        price: <?php echo $firstClassPrice; ?>,
                        classes: 'first-class', // your custom CSS class
                        category: 'First Class',
                    },
                    e: {
                        price: <?php echo $secondClassPrice; ?>,
                        classes: 'economy-class', // your custom CSS class
                        category: 'Economy Class',
                    },
                },
                naming: {
                    top: false,
                    getLabel: function(character, row, column) {
                        return firstSeatLabel++;
                    },
                },
                legend: {
                    node: $('#legend'),
                    items: [
                        ['f', 'available', 'First Class'],
                        ['e', 'available', 'Economy Class'],
                        ['f', 'unavailable', 'Already booked'],
                    ],
                },
                click: function() {
                    if (this.status() == 'available') {
                        var cartItem = $('<li>' + this.data().category + ' Seat # ' + this.settings.label + ': <b>$' + this.data().price + '</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
                            .attr('id', 'cart_items' + this.settings.id)
                            .data('seatId', this.settings.id);
                        cartItem.appendTo($cart);

                        $counter.text(sc.find('selected').length + 1);
                        $total.text(recalculateTotal(sc) + this.data().price);

                        cartItem.data('cartData', {
                            label: this.settings.label,
                            category: this.data().category,
                            price: this.data().price,
                        });
                        // Update the hidden input fields
                        $('#selected-seats-input').val(selected.join(','));
                        $('#total-input').val($('#total').text());

                        return 'selected';
                    } else if (this.status() == 'selected') {
                        $counter.text(sc.find('selected').length - 1);
                        $total.text(recalculateTotal(sc) - this.data().price);

                        $('#cart_items' + this.settings.id).remove();

                        return 'available';
                    } else if (this.status() == 'unavailable') {
                        return 'unavailable';
                    } else {
                        return this.style();
                    }
                },

            });
            return $.when(sc);
        }


        // Named function to handle the 'done' callback
        function functionDoneCallback(chart, seats) {
            // Fetch selected seats from the server
            $.ajax({
                url: 'get_booked_seats',
                type: 'GET',
                dataType: 'json',
                success: function(selectedSeats) {
                    // Make sure the seat map is initialized before accessing its methods
                    if (sc) {
                        // Mark selected seats as unavailable
                        for (var i = 0; i < selectedSeats.length; i++) {
                            var seat = sc.get(selectedSeats[i]);
                            if (seat) {
                                seat.status('unavailable');
                            } else {
                                console.error('Seat ' + selectedSeats[i] + ' not found in the seat chart.');
                            }
                        }
                    } else {
                        console.error('Seat map is not properly initialized.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching selected seats: ' + error);
                }
            });
        }

        // Call the function to initialize the seat map and execute the 'done' callback when ready
        initializeSeatMap().done(functionDoneCallback);

        // Add event listener to handle cancellation of selected seats
        $('#selected-seats').on('click', '.cancel-cart-item', function() {
            // Make sure the seat map is initialized before accessing its methods
            if (sc) {
                sc.get($(this).parents('li:first').data('seatId')).click();
            } else {
                console.error('Seat map is not properly initialized.');
            }
        });


        function recalculateTotal(sc) {
            var total = 0;
            sc.find('selected').each(function() {
                total += this.data().price;
            });

            // Round the total to two decimal places
            total = parseFloat(total.toFixed(2));

            return total;
        }


        $(document).ready(function() {
            // Declare selected outside the click event handler

            $('#checkout-button').click(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                var items = $('#selected-seats li');
                if (items.length <= 0) {
                    alert('Please select at least 1 seat first.');
                    return false;
                }

                // Use the existing selected variable
                selected.length = 0;
                var cartItems = [];

                items.each(function() {
                    var id = $(this).attr('id').replace('cart_items', '');
                    selected.push(id);

                    var cartData = $(this).data('cartData');
                    if (cartData) {
                        cartItems.push(cartData);
                    }
                });

                if (booked.length > 0) {
                    selected = selected.concat(booked);
                }

                // AJAX request to handle the form submission
                $.ajax({
                    type: 'POST',
                    url: 'seat_action',
                    data: {
                        total: $('#total').text(),
                        selected_seats: JSON.stringify(selected),
                        cart_items: JSON.stringify(cartItems),
                    },
                    success: function(response) {
                        console.log('Server Response:', response);
                        //alert('Data stored successfully!');
                        // Handle the response as needed, e.g., update UI dynamically
                        window.location.href = '<?= ROOT ?>/seat_action';
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Error storing data: ', error);
                    },
                });
            });

            $('#reset-btn').click(function(event) {
                event.preventDefault();

                if (confirm('Are you sure to reset the reservation of the bus?')) {
                    $.ajax({
                        url: 'reset_seats',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            bus_no: <?php echo json_encode($_SESSION['bus_no']); ?>,
                            email: <?php echo json_encode($_SESSION['email']); ?>
                        },
                        success: function(response) {
                            if (response.success) {
                                localStorage.removeItem('booked');
                                alert('Seats have been reset successfully.');
                                location.reload();
                            } else {
                                alert('Error resetting seats: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Error resetting seats.');
                        }
                    });
                }
            });


        });
    </script>

</body>

</html>