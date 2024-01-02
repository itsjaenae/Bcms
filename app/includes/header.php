<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home - <?= APP_NAME ?></title>

  <!-- load stylesheets -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
  <link rel="stylesheet" href="<?= ROOT ?>/assets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/slick/slick-theme.css" />
  <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/datepicker.css" />
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
  <style>
    /* Dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown button style */
.dropbtn {
    padding: 10px;
    border: none;
    cursor: pointer;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 8px 10px;
    text-decoration: none;
    display: block;
}

/* Change color on hover */
.dropdown-content a:hover {
    background-color:#ddd;
}

/* Show the dropdown content when the dropdown button is hovered over */
.dropdown:hover .dropdown-content {
    display: block;
}
  </style>
</head>

<body>
  <div class="tm-main-content" id="top">
    <div class="tm-top-bar-bg"></div>
    <div class="tm-top-bar" id="tm-top-bars">
      <!-- Top Navbar -->
      <div class="container">
        <div class="row">

          <nav class="navbar navbar-expand-lg narbar-light">
            <a class="navbar-brand mr-auto" href="<?= ROOT ?>/home">
              <img src="<?= ROOT ?>/assets/img/wheel.png" alt="Site logo">
              Bcms
            </a>
            <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link  <?= $url[0] == 'home' ? 'active' : 'link-dark' ?>" href="<?= ROOT ?>/home">Home
                    <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link  <?= $url[0] == 'bus_ticket' ? 'active' : 'link-dark' ?>" href="<?= ROOT ?>/bus_ticket">Bus Tickets</a>
                </li>
               
                <?php if(isset($_SESSION['USER'])){ ?>
    <li class="nav-item dropdown">
    <a class="nav-link dropbtn <?= $url[0] == 'dashboard' ? 'active' : 'link-dark' ?>" 
    href="<?= ROOT ?>/dashboard">Dashboard</a>

        <div class="dropdown-content">
        <a class="dropdown-item" href="<?= ROOT ?>/schedules">Schedules</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= ROOT ?>/search">Search</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= ROOT ?>/logout">Logout</a>
        </div>
    </li>
<?php } else { ?>
    <li class="nav-item">
        <a class="nav-link <?= $url[0] == 'sign_in' ? 'active' : 'link-dark' ?>" href="<?= ROOT ?>/sign_in">Sign In</a>
    </li>
<?php } ?>


                <li class="nav-item">
                  <a class="nav-link  <?= $url[0] == 'contact_form' ? 'active' : 'link-dark' ?>" href="<?= ROOT ?>/contact_form">Contact Us</a>
                </li>
              
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>