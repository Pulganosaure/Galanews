<?php
session_start();
$existe = isset($_SESSION['username']);

if($existe == true)
{
	unset($_SESSION['username']);
	header('location: ../main.php');
}
else
{
		header('location: ../main.php');
}