<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Contact Form - <?= APP_NAME ?></title>

  <style>
    .form-control {
      border-color: #000;
    }

    .btn {
      border-color: #361999;
      background: #361999;
      margin-top: 2rem;
    }

    .contact_text {
      margin-top: 6rem;
      margin-bottom: 4rem;
      text-align: center;
    }
  </style>
</head>
<?php include  '../app/includes/header.php' ?>

<body>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// if (!class_exists('PHPMailer\PHPMailer\Exception')){

//   // require_once('PHPMailer_5.2.2/class.phpmailer.php');
// require_once '../PHPMailer/src/Exception.php';
// require_once '../PHPMailer/src/PHPMailer.php';
// require_once '../PHPMailer/src/SMTP.php';
//   }else{
//       die("HArd");
//   }



// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to send mail
function contactMail($name, $surname, $email, $subject, $message)
{
    try {
        $mail = new PHPMailer(true);
       $mail->SMTPDebug = 0; // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'example@gmail.com';
        $mail->Password = 'password';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom($email, $name . ' ' . $surname);
        $mail->addAddress('example@gmail.com', 'john');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
       
          
        // Send the email
        $mail->send();

        return 'Message has been sent';
        return 1;
    } catch (Exception $e) {
       // return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        return 0 ;
        ;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $name = sanitizeInput($_POST['name']);
    $surname = sanitizeInput($_POST['surname']);
    $email = sanitizeInput($_POST['email']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);

    // Send the mail
    $result = contactMail($name, $surname, $email, $subject, $message);

    echo $result;
}

?>

  <div class="container my-5">
    <h1 class="contact_text">Contact Us</h1>
    <div class="row justify-content-center" style="margin-bottom: 6rem">
      <div class="col-lg-9">
        <form action="<?= ROOT ?>/contact_form" method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="your-name" class="form-label">Your Name</label>
              <input type="text" class="form-control" id="your-name" name="name" required>
            </div>
            <div class="col-md-6">
              <label for="your-surname" class="form-label">Your Surname</label>
              <input type="text" class="form-control" id="your-surname" name="surname" required>
            </div>
            <div class="col-md-6">
              <label for="your-email" class="form-label">Your Email</label>
              <input type="email" class="form-control" id="your-email" name="email" required>
            </div>
            <div class="col-md-6">
              <label for="your-subject" class="form-label">Your Subject</label>
              <input type="text" class="form-control" id="your-subject" name="subject">
            </div>
            <div class="col-12">
              <label for="your-message" class="form-label">Your Message</label>
              <textarea class="form-control" id="your-message" name="message" rows="5" required></textarea>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  <button data-res="<?php echo $sum; ?>" type="submit" class="btn w-100 fw-bold" style="color: #fff;">Send</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>





</body>

</html>