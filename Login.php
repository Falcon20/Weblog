<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
if(isset($_POST['submit'])){
	$UserName=mysqli_real_escape_string($con,$_POST['UserName']);
	$Password=mysqli_real_escape_string($con,$_POST['Password']);
	if(empty($UserName)||empty($Password)){
		$_SESSION["ErrorMessage"]="All fields must be filled out";
		Redirect_to("Login.php");
		
	}
	else
	{
		$Found_Account=Login_Attempt($UserName,$Password);
			$_SESSION["User_Id"]=$Found_Account['id'];
			$_SESSION["Username"]=$Found_Account['username'];
			if($Found_Account){
		$_SESSION["SuccessMessage"]="Welcome {$_SESSION['Username']}";
		Redirect_to("dashboard.php");
		}
	else{
		$_SESSION["ErrorMessage"]="Invalid UserName or Password";
		Redirect_to("Login.php");
	}
		
	
}
}
	
?>
<html>
<head>
	<title>Manage Admins</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="adminstyle.css">
	<style>
	.FieldInfo{
		color :rgb(251,174,44);
		font-family: Bitter,Georgia,"Times New Roman",Times,serif;
		font-size: 1.2em;
	}
	</style>
</head>
<body>
<div style="height: 10px; background:#27aae1"></div>
<nav class="navbar navbar-inverse " role="navigation">
	<div class="container">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		 data-target="#collapse">
		 <span class="sr-only">Toggle Navagation</span>
		 <span class="icon-bar"></span>
		 <span class="icon-bar"></span>
		 <span class="icon-bar"></span>
		 </button>
			<a class="navbar-brand" href="Blog.php">
				<img style="margin-top:-15px" src="logo.png" width="200" height="50">
			</a>
		</div>
		<div class="collapse navbar-collapse" id="collapse">
		<ul class="nav navbar-nav navbar-right">
		<li><a href="#">Home</a></li>
		<li><a href="Blog.php" target="_blank">Blog</a></li>
		<li><a href="#">About Us</a></li>
		<li><a href="#">Services</a></li>
		<li><a href="#">Contact Us</a></li>
		<form action="Blog.php" class="navbar-form navbar-right">
			<div class="form-group">
			<input type="text" class="form-control" placeholder="Search" name="Search">
			</div >
			<button class="btn btn-default" name="SearchButton">Go</button>
		</form>
		</ul>
		
	</div>
</div>
<div style="height: 10px; background:#27aae1"></div>	
</nav>

<div class="container-fluid">
	<div class="row">
		<!-- Ending of side area-->
		<div class="col-sm-offset-4 col-sm-4">
		<br><br><br><br>
		<h1 style="color:white;" align="center"> Welcome Back !</h1>
		<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>
		<div>
		<form action ="Login.php" method="post">
			<fieldset>
				<div class="form-group">
				<label for ="UserName"><span class="FieldInfo">UserName:</span></label>
				<div class="input-group">
					<span class="input-group-addon">
					<span class="glyphicon glyphicon-envelope text-primary"></span>
					</span>
				
				<input type="text" class="form-control" name="UserName" id="UserName" placeholder="Name"><br>
				</div>
				</div>
				<div class="form-group">
				<label for ="Password"><span class="FieldInfo">Password :</span></label>
				<div class="input-group">
					<span class="input-group-addon">
					<span class="glyphicon glyphicon-lock text-primary"></span>
					</span>
				<input type="Password" class="form-control" name="Password" id="Password" placeholder="Password"><br>
				</div><br>
				</div>
				<div class="form-group">
				
				<input class="btn btn-warning btn-block" type="submit" name="submit" value="Add new Admin">
				</div>
			</fieldset>
		</form>
		</div>
		
		 </div><!---Ending of main area-->
	</div>

</div>	

<div style="height=: 10px; background: #27aae1;"></div>
</body>
</html>