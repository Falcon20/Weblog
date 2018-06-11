<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
	function Redirect_to($new_location){
		header("Location:".$new_location);
		exit;
		
	}
	function Login_Attempt($UserName,$Password){
		$con = mysqli_connect("localhost","root","","phpcms");
		$sql="SELECT * FROM registration WHERE username='$UserName' AND password='$Password'";
			$result=mysqli_query($con,$sql);
			if($row=mysqli_fetch_assoc($result)){
				return $row;
			}
			else{
				return null;
			}
	}
	function Login()
	{
		if(isset($_SESSION['User_Id'])){
			return true;
		}
	}
	function Confirm_Login()
	{
		if(!Login()){
				$_SESSION["ErrorMessage"]="Login Required";
			Redirect_to("Login.php");
		}
	}

?>