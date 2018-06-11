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
	$Admin="Azad Singh";
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
		$EditFromUrl=$_GET['Edit'];
		
		if(!mysqli_query($con,"UPDATE admin_panel SET datetime ='$DateTime',title='$Title',category='$Category',author='$Admin',image='$Image',post='$Post' WHERE id='$EditFromUrl'")){
			$_SESSION["ErrorMessage"]="Something went wrong";
			Redirect_to("Dashboard.php");
		
	}
	else{
		$_SESSION["SuccessMessage"]="Post updated successfully";
		 move_uploaded_file($tempname,"Upload/$Image");
		 
			Redirect_to("Dashboard.php");
	}
	
 }
}
	
?>
<html>
<head>
	<title>Edit Post</title>
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
		<div class="col-sm-2">
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
		<h1>Update Post</h1>
		<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>
		<div>
		<?php
			$SearchQueryParameter=$_GET["Edit"];
			$Query="SELECT * from admin_panel WHERE id='$SearchQueryParameter'";
			$result=mysqli_query($con,$Query);
			while($row=mysqli_fetch_array($result)){
				$TitleToBeUpdated=$row["title"];
				$CategoryToBeUpdated=$row["category"];
				$ImageToBeUpdated=$row["image"];
				$PostToBeUpdated=$row["post"];
			}
		?>
		<form action ="EditPost.php?Edit=<?php echo $SearchQueryParameter;?>" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
				<label for ="categoryname"><span class="FieldInfo">Title:</span></label>
				<input  value="<?php echo $TitleToBeUpdated; ?>" type="title" class="form-control" name="Title" id="title" placeholder="Title"><br>
				
				</div>
				<div class="form-group">
				<label><span class="FieldInfo">Existing Category :</span></label>
				<?php echo $CategoryToBeUpdated; ?>
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
				<label><span class="FieldInfo">Existing Image :</span></label>
				<img src="Upload/<?php echo $ImageToBeUpdated; ?>" width="170px"  height="50px"/>
				</div>
				<div class="form-group">
				<label for ="imageselect"><span class="FieldInfo">Select Image:</span></label>
				<input type="file" class="form-control" name="Image" id="imageselect">
				</div>
				<div class="form-group">
				<label for ="postarea"><span class="FieldInfo">Post:</span></label>
				<textarea class="form-control" name="Post" id="postarea"><?php echo $PostToBeUpdated;?></textarea>
				</div>
				<br>
				<input class="btn btn-success btn-block" type="submit" name="submit" value="Update Post">
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