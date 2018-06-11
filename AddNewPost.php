<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");
Confirm_Login();
if(isset($_POST['submit'])){
	$Title=mysqli_real_escape_string($con,$_POST['Title']);
	$Category=mysqli_real_escape_string($con,$_POST['Category']);
	$Post=mysqli_real_escape_string($con,$_POST['Post']);
	date_default_timezone_set("Asia/Calcutta");
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
	$Admin=$_SESSION['Username'];
	$Image=$_FILES["Image"]["name"];
	$tempname=$_FILES['Image']['tmp_name'];
	if(empty($Title)){
		$_SESSION["ErrorMessage"]="Title can't be empty";
		Redirect_to("AddNewPost.php");
		
	}
	elseif(strlen($Title)<2){
		$_SESSION["ErrorMessage"]="Title must be at least 2 character long";
		Redirect_to("AddNewPost.php");
	
	}
	else{
		
		if(!mysqli_query($con,"INSERT INTO admin_panel (datetime,title,category,author,image,post) 
VALUES ('$DateTime','$Title','$Category','$Admin','$Image','$Post')")){
			$_SESSION["ErrorMessage"]="Something went wrong";
			Redirect_to("AddNewPost.php");
		
	}
	else{
		$_SESSION["SuccessMessage"]="Post added successfully";
		 move_uploaded_file($tempname,"Upload/$Image");
			Redirect_to("AddNewPost.php");
	}
	
 }
}
	
?>
<html>
<head>
	<title>Add New Post</title>
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
				<li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Add new post</a></li>
				<li ><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp Categories</a></li>
				<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> &nbspManage Admins</a></li>
				<li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span> &nbspComments</a></li>
				<li><a href="Blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbspLive Blog</a></li>
				<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbspLogout</a></li>
			</ul>
		</div><!-- Ending of side area-->
		<div class="col-sm-10">
		<h1>Add New Post</h1>
		<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>
		<div>
		<form action ="AddNewPost.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
				<label for ="categoryname"><span class="FieldInfo">Title:</span></label>
				<input type="title" class="form-control" name="Title" id="title" placeholder="Title"><br>
				
				</div>
				<div class="form-group">
				<label for ="categoryselect"><span class="FieldInfo">Category :</span></label>
				<select class="form-control" id="categoryselect" name="Category">
				<?php   
			$sql="SELECT * FROM category ORDER BY datetime desc";
			$result=mysqli_query($con,$sql);
			while($row=mysqli_fetch_array($result)){
				$id=$row['id'];
				$CategoryName=$row['name'];	
				
			?>
			
				<option><?php echo $CategoryName;?></option>
			<?php } ?>
				</select>
				</div>
				<div class="form-group">
				<label for ="imageselect"><span class="FieldInfo">Select Image:</span></label>
				<input type="file" class="form-control" name="Image" id="imageselect">
				</div>
				<div class="form-group">
				<label for ="postarea"><span class="FieldInfo">Post:</span></label>
				<textarea class="form-control" name="Post" id="postarea"></textarea>
				</div>
				<br>
				<input class="btn btn-success btn-block" type="submit" name="submit" value="Add new post">
			</fieldset>
		</form>
		</div>
		
			
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