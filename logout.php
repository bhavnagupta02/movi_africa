<?php
session_start();
require_once 'main-class.php';
$user = new USER();

if(!$user->is_logged_in())
{
    session_destroy();
	$_SESSION['user_id'] = false;
	$_SESSION['IdSer'] = false;
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{
    session_destroy();
	$_SESSION['user_id'] = false; 
	$_SESSION['IdSer'] = false;
	$user->logout();	
	$user->redirect('index.php');
}
?>
