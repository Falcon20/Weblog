<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
Confirm_Login(); 
if(isset($_POST['submit'])){
	$UserName=mysqli_real_escape_string($con,$_POST['UserName']);
	$Password=mysqli_real_escape_string($con,$_POST['Password']);
	$ConfirmPassword=mysqli_real_escape_string($con,$_POST['ConfirmPassword']);
	date_default_timezone_set("Asia/Calcutta");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
	$Admin="Azad Singh";
	if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
		$_SESSION["ErrorMessage"]="All fields must be filled out";
		Redirect_to("Admins.php");
		
	}
	elseif(strlen($Password)<4){
		$_SESSION["ErrorMessage"]="At least 4 characters are required for password";
		Redirect_to("Admins.php");
	
	}
	elseif($Password!==$ConfirmPassword){
			$_SESSION["ErrorMessage"]="Passwords do not match";
		Redirect_to("Admins.php");
			
		}
		
	else{
		if(!mysqli_query($con,"INSERT INTO registration (datetime,username,password,addedby) 
VALUES ('$DateTime','$UserName','$Password','$Admin')")){
			$_SESSION["ErrorMessage"]="Admin could not be added";
			Redirect_to("Admins.php");
	}
	else{
		$_SESSION["SuccessMessage"]="Admin added Successfully";
			Redirect_to("Admins.php");
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
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2"><br><br><br><br>
			<ul id="Side_menu" class="nav nav-pills nav-stacked">
				<li ><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> &nbsp Dashboard</a></li>
				<li ><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Add new post</a></li>
				<li ><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp Categories</a></li>
				<li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp Manage Admins</a></li>
				<li ><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span> &nbspComments</a></li>
				<li><a href="Blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbspLive Blog</a></li>
				<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbspLogout</a></li>
			</ul>
		</div><!-- Ending of side area-->
		<div class="col-sm-10">
		<h1>Manage Admin Access</h1>
		<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>
		<div>
		<form action ="Admins.php" method="post">
			<fieldset>
				<div class="form-group">
				<label for ="UserName"><span class="FieldInfo">UserName:</span></label>
				<input type="text" class="form-control" name="UserName" id="UserName" placeholder="Name"><br>
				</div>
				<div class="form-group">
				<label for ="Password"><span class="FieldInfo">Password :</span></label>
				<input type="Password" class="form-control" name="Password" id="Password" placeholder="Password"><br>
				</div>
				<div class="form-group">
				<label for ="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
				<input type="Password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype same password"><br>
				<input class="btn btn-success btn-block" type="submit" name="submit" value="Add new Admin">
				</div>
			</fieldset>
		</form>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
			<tr>
				<th>Sr. No.</th>
				<th>Date and Time</th>
				<th>Admin Name</th>
				<th>Added By</th>
				<th>Action</th>
			</tr>
			<?php   
			$SrNo=0;
			$sql="SELECT * FROM registration ORDER BY datetime desc";
			$result=mysqli_query($con,$sql);
			while($row=mysqli_fetch_array($result)){
				$Id=$row['id'];
				$DateTime=$row['datetime'];
				$UserName=$row['username'];
				$Admin=$row['addedby'];
			$SrNo++;
			?>
			<tr>
				<td><?php echo $SrNo; ?></td>
				<td><?php echo $DateTime; ?></td>
				<td><?php echo $UserName; ?></td>
				<td><?php echo $Admin; ?></td>
				<td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
			</tr>
			<?php
				}
			?>
			
			</table>
		</div >
		 </div><!---Ending of main area-->
	</div>

</div>	
<div id="footer">
	<hr><p align="center" style="color: white;">Theme By | Azad Singh | &copy;2018--- All Rights Reserved</p>
	<a style="color: white; text-decoration: none; cursor: pointer;" href="#">
	<p align="center">This site is designed by Azad Singh. No one is allowed to copy the contents other than Azad Singh himself</p><hr>
	</a>
</div>
<div style="height=: 10px; background: #27aae1;"></div>
</body>
</html>