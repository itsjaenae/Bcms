<?php

if(isset($_POST['submit'])){
	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL))	{
			$sql = "select * from users where email = :email ";
			$handle = $pdo->prepare($sql);
			$params = ['email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0){
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $getRow['password'])){
          authenticate($getRow['password']);
          $_SESSION['email'] = $getRow['email'];
					//unset($getRow['password']);
				//	$_SESSION = $getRow;
				//	header('location:dashboard.php');
        redirect("home");
					exit();
				}	else	{
				$errors[] = "Wrong Email or Password";
				}}	else{
				$errors[] = "Wrong Email or Password";
			}}else{
			$errors[] = "Email address is not valid";	
		}}else{
		$errors[] = "Email and Password are required";	
	}
 
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Login - <?= APP_NAME ?></title>

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

  <main class="form-signin  m-auto">
  <?php 
				if(isset($errors) && count($errors) > 0)
				{
					foreach($errors as $error_msg)
					{
						echo '<div class="alert alert-danger">'.$error_msg.'</div>';
					}
				}
			?>
    <form method="POST"  action="<?= ROOT ?>/sign_in">
      <a href="home">
        <img class="mb-4 rounded-circle shadow" src="<?= ROOT ?>/assets/img/wheel.png" alt="" width="92" height="92" style="object-fit: cover;">
      </a>
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    

      <div class="form-floating">
        <input value="<?= old_value('email') ?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input value="<?= old_value('password') ?>" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="my-2">Dont have an account? <a href="<?= ROOT ?>/register">Signup here</a></div>
      <div class="checkbox mb-3">
        <label>
          <input name="remember" type="checkbox" value="1"> Remember me
        </label>
      </div>
      <input class="w-100 btn btn-lg btn-primary" name="submit" type="submit" value="Sign In" />

    </form>
  </main>



</body>

</html>