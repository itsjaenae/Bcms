<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Schedule Booking - <?= APP_NAME ?> </title>
    <style>
        .form_container {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5rem;
        }

        .payment-form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 450px;
            max-width: 100%;
            margin-top: 50px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .card-inputs {
            display: flex;
            gap: 8px;
        }

        .card-inputs input {
            flex: 1;
            margin-right: 8px;
        }

        .submit-btn {
            background-color: #361999;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 1rem;

        }

        .submit-btn:hover {
            background-color: rgba(#361999, 0.4);
        }
    </style>
    <?php include  '../app/includes/header.php' ?>
</head>

<body>
    <div class="form_container">
        <div class="payment-form">
            <h2>Payment Details</h2>
            <form method='post' action='<?= ROOT ?>/schedule_action'>
                <input type="hidden" name="schedule_id" value="<?= $_SESSION['schedule_id'] ?>">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" name="card_no" placeholder="1234 5678 9012 3456" required maxlength='16'>

                <label for="cardHolder">Name on Card</label>
                <input type="text" id="cardHolder" name="card_name" placeholder="John Doe" required maxlength='50'>

                <div class="card-inputs">
                    <div>
                        <label for="expiryYear">Expiry Date</label>
                        <input type="text" id="expiryYear" name="exp_year" placeholder="YY" required maxlength="2">

                    </div>
                    <div>
                        <label for="expiryMonth">Expiry Date</label>
                        <input type="text" id="expiryMonth" name="exp_month" placeholder="MM" required maxlength='2'>
                    </div>
                    <div>
                        <label for="cvv">CVV</label>
                        <input type="password" id="cvv" name="cvv" placeholder="123" required maxlength='3'>
                    </div>
                </div>
                <div class="card-inputs">
                    <div>
                        <label for="pin">PIN</label>
                        <input type="password" id="pin" name="pin" placeholder="Enter your PIN" required maxlength='4'>
                    </div>

                    <div>
                        <label for="pin">No of Passengers</label>
                        <input type="number" id="pass" name="pass" placeholder="No of Passengers" required>
                    </div>

                </div>
                <button type="submit" name='register_submit' class="submit-btn">Submit Payment</button>
            </form>
        </div>
    </div>
    <?php include  '../app/includes/footer.php' ?>
</body>

</html>