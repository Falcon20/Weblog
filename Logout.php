<?php
	require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
$_SESSION['User_Id']=null;
session_destroy();
Redirect_to(('Login.php'));
?>