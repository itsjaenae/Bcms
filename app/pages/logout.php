<?php 

if(!empty($_SESSION['USER']))
	unset($_SESSION['USER']);

redirect('home');
// session_start();
// 	session_destroy();
// 	header('location: index.php');
