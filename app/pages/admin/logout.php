<?php 

if(!empty($_SESSION['ADMIN']))
	unset($_SESSION['ADMIN']);
	echo "<script>alert('You are being logged out'); window.location.href='<?=ROOT?>/admin';</script>";
	
exit;

