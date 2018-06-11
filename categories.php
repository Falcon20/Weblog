<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
Confirm_Login(); 
if(isset($_POST['submit'])){
	$category=mysqli_real_escape_string($con,$_POST['category']);
	date_default_timezone_set("Asia/Calcutta");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
	$Admin=$_SESSION['Username'];
	if(empty($category)){
		$_SESSION["ErrorMessage"]="All fields must be filled out";
		Redirect_to("categories.php");
		
	}
	elseif(strlen($category)>99){
		$_SESSION["ErrorMessage"]="Too long name for a category";
		Redirect_to("categories.php");
	
	}
	else{
		if(!mysqli_query($con,"INSERT INTO category (datetime,name,creatorname) 
VALUES ('$DateTime','$category','$Admin')")){
			$_SESSION["ErrorMessage"]="Category could not be created";
			Redirect_to("categories.php");
	}
	else{
		$_SESSION["SuccessMessage"]="Category Created Successfully";
			Redirect_to("categories.php");
	}
	
 }
}
	
?>
<html>
<head>
	<title>Categories</title>
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
				<li ><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> &nbspDashboard</a></li>
				<li ><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Add new post</a></li>
				<li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp Categories</a></li>
				<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> &nbspManage Admins</a></li>
				<li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span> &nbspComments </a></li>
				<li><a href="Blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbspLive Blog</a></li>
				<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbspLogout</a></li>
			</ul>
		</div><!-- Ending of side area-->
		<div class="col-sm-10">
		<h1>Manage Categories</h1>
		<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>
		<div>
		<form action ="categories.php" method="post">
			<fieldset>
				<div class="form-group">
				<label for ="categoryname"><span class="FieldInfo">Name:</span></label>
				<input type="text" class="form-control" name="category" id="categoryname"><br>
				<input class="btn btn-success btn-block" type="submit" name="submit" value="Add new category">
				</div>
			</fieldset>
		</form>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
			<tr>
				<th>Sr. No.</th>
				<th>Date and Time</th>
				<th>Category Name</th>
				<th>Creator Name</th>
				<th>Action</th>
			</tr>
			<?php   
			$SrNo=0;
			$sql="SELECT * FROM category ORDER BY datetime desc";
			$result=mysqli_query($con,$sql);
			while($row=mysqli_fetch_array($result)){
				$Id=$row['id'];
				$DateTime=$row['datetime'];
				$CategoryName=$row['name'];
				$CreatorName=$row['creatorname'];
			$SrNo++;
			?>
			<tr>
				<td><?php echo $SrNo; ?></td>
				<td><?php echo $DateTime; ?></td>
				<td><?php echo $CategoryName; ?></td>
				<td><?php echo $CreatorName; ?></td>
				<td><a href="DeleteCategories.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
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