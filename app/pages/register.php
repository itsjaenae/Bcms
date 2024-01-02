<?php

if (isset($_POST['submit'])) {
  if (isset($_POST['username'], $_POST['phone'], $_POST['email'], $_POST['password'], $_POST['retype_password']) && !empty($_POST['username']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['password'] && !empty($_POST['retype_password']))) {
    $errors = [];

    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $retype_password = trim($_POST['retype_password']);

    $options = array("cost" => 4);
    $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
    $date = date('Y-m-d H:i:s');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $sql = 'select * from users where email = :email';
      $stmt = $pdo->prepare($sql);
      $p = ['email' => $email];
      $stmt->execute($p);

      if ($password == $retype_password) {
        if ($stmt->rowCount() == 0) {

          $sql = "insert into users (username, phone, email, `password`, date) values(:username,:phone,:email,:password,:date)";

          try {
            $handle = $pdo->prepare($sql);
            $params = [
              ':username' => $username,
              ':phone' => $phone,
              ':email' => $email,
              ':password' => $hashPassword,
              ':date' => $date,
            ];

            $handle->execute($params);

            $success = 'User has been created successfully';
            redirect("sign_in");
          } catch (PDOException $e) {
            $errors[] = $e->getMessage();
          }
        } else {
          $valUsername = $username;
          $valPhone = $phone;
          $valEmail = '';
          $valPassword = $password;

          $errors['email'] = 'Email address already registered';
        }
      } else {
        $errors['password'] = "Passwords do not match";
      }
    } else {
      $errors['email'] = "Email address is not valid";
    }
  } else {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
      $errors['username'] = 'Username is required';
    } else if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
      $errors['username'] = "Username can only have letters and no spaces";
    } else {
      $valUsername = $_POST['username'];
    }

    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
      $errors['phone'] = 'Phone is required';
    } else if (preg_match("/^[0-9]{10}$/",  $_POST['phone'])) {
      $errors['phone'] = 'Phone should be a number';
    } else {
      $valPhone = $_POST['phone'];
    }

    if (!isset($_POST['email']) || empty($_POST['email'])) {
      $errors['email'] = 'Email is required';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Email not valid";
    } else {
      $valEmail = $_POST['email'];
    }


    if (empty($_POST['password'])) {
      $errors['password'] = "A password is required";
    } elseif (strlen($_POST['password']) < 8) {
      $errors['password'] = "Password must be 8 character or more";
    } else {
      $valPassword = $_POST['password'];
    }

    if (empty($_POST['terms'])) {
      $errors['terms'] = "Please accept the terms";
    }
  }
}
?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Register - <?= APP_NAME ?></title>

  <link href="<?= ROOT ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="<?= ROOT ?>/assets/css/sign_in.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin m-auto">
    <?php
    // if(isset($errors) && count($errors) > 0){
    // 	foreach($errors as $error_msg)	{
    // 		echo '<div class="alert alert-danger">'.$error_msg.'</div>';
    // 	}}
    if (isset($success)) {
      echo '<div class="alert alert-success">' . $success . '</div>';
    }
    ?>

    <form method="post">
      <a href="home">
        <img class="mb-4 rounded-circle shadow" src="<?= ROOT ?>/assets/img/wheel.png" alt="Site logo" width="92" height="92" style="object-fit: cover;">
      </a>
      <h1 class="h3 mb-3 fw-normal">Create account</h1>

      <div class="form-floating">
        <input value="<?= old_value('username') ?>" name="username" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
        <label for="floatingInput">Username</label>
      </div>
      <?php if (!empty($errors['username'])) : ?>
        <div class="text-danger"><?= $errors['username'] ?></div>
      <?php endif; ?>


      <div class="form-floating">
        <input value="<?= old_value('phone') ?>" name="phone" type="text" class="form-control mb-2" id="floatingInput" placeholder="Phone">
        <label for="floatingInput">Phone</label>
      </div>
      <?php if (!empty($errors['phone'])) : ?>
        <div class="text-danger"><?= $errors['phone'] ?></div>
      <?php endif; ?>


      <div class="form-floating">
        <input value="<?= old_value('email') ?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <?php if (!empty($errors['email'])) : ?>
        <div class="text-danger"><?= $errors['email'] ?></div>
      <?php endif; ?>

      <div class="form-floating">
        <input value="<?= old_value('password') ?>" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <?php if (!empty($errors['password'])) : ?>
        <div class="text-danger"><?= $errors['password'] ?></div>
      <?php endif; ?>

      <div class="form-floating">
        <input value="<?= old_value('retype_password') ?>" name="retype_password" type="password" class="form-control" id="floatingPassword" placeholder="Retype Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="my-2">Already have an account? <a href="<?= ROOT ?>/sign_in">Login here</a></div>

      <div class="checkbox mb-3">
        <label>
          <input <?= old_checked('terms') ?> name="terms" type="checkbox" value="terms" required> Accept terms and conditions
        </label>
      </div>
      <?php if (!empty($errors['terms'])) : ?>
        <div class="text-danger"><?= $errors['terms'] ?></div>
      <?php endif; ?>

      <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Create</button>

    </form>
  </main>



</body>

</html>