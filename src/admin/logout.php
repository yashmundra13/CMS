<?php
session_start();
require_once 'classes/class.tuser.php';
$user = new TUSER();

if(!$user->is_logged_in())
{
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{
	$user->logout();	
	$user->redirect('index.php');
}
?>