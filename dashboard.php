<?php require_once("Include/sessions.php");?>
<?php require_once("Include/functions.php");?>
<?php require_once("Include/db.php"); ?>
<?php Confirm_Login(); ?>

<html>
<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="adminstyle.css">
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
		<li class="active"><a href="Blog.php" target="_blank">Blog</a></li>
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
		<div class="col-sm-2">
		<br><br>
			<ul id="Side_menu" class="nav nav-pills nav-stacked">
				<li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> &nbspDashboard</a></li>
				<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Add new post</a></li>
				<li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp Categories</a></li>
				<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp Manage Admins</a></li>
				<li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span> &nbsp Comments <?php
							$QueryTotal="SELECT COUNT(*) FROM comments WHERE status='OFF'";
							$ResultOfQuery=mysqli_query($con,$QueryTotal);
							$ExecuteTotal=mysqli_fetch_array($ResultOfQuery);
							 $Total=array_shift($ExecuteTotal);
							 if($Total>0){
								 ?>
								 <span style="margin-top:5px;" class="label label-warning pull-right">
								 <?php echo $Total; ?>
								 </span>
								 <?php
							 }
						?></a>
				</li>
				<li><a href="Blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbsp Live Blog</a></li>
				<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp Logout</a></li>
			</ul>
		</div><!-- Ending of side area-->
		<div class="col-sm-10"><!-- Main Area-->
		<div ><?php echo Message();
		echo SuccessMessage();?>
		</div>
		<h1>Admin Dashboard</h1>
		<div class="table-responsive">
		<table class=" table table-hover table-striped table-bordered">
			<tr> 
				<th>No</th>
				<th>Post Title</th>
				<th>Date and time</th>
				<th>Category</th>
				<th>Author</th>
				<th>Banner</th>
				<th>Comments</th>
				<th>Actions</th>
				<th>Details</th>
			</tr>
			<?php
				$ViewQuery="SELECT * from admin_panel ORDER BY datetime desc";
				$result=mysqli_query($con,$ViewQuery);
				$srno=0;
				while($row=mysqli_fetch_array($result))
				{
					$Id=$row["id"];
					$DateTime=$row["datetime"];
					$Title=$row["title"];
					$Category=$row["category"];
					$Admin=$row["author"];
					$Image=$row["image"];
					$Post=$row["post"];
					$srno++;
					?>
					<tr>
						<td><?php echo $srno; ?></td>
						<td style="color:#5e5eff;"><?php if(strlen($Title)>20){
							$Title=substr($Title,0,20).'..';
						}
							echo $Title; ?></td>
						<td><?php if(strlen($DateTime)>10){
							$DateTime=substr($DateTime,0,10).'..';
						}
						 echo $DateTime; ?></td>
							
						<td><?php if(strlen($Category)>20){
							$Category=substr($Category,0,20).'..';
						} echo $Category; ?></td>
						<td><?php 
							if(strlen($Admin)>10){
							$Admin=substr($Admin,0,10).'..';
						}						
						echo $Admin; ?></td>
						<td><img src="Upload/<?php echo $Image; ?>" width="150px" height="60px"></td>
						<td>
						<?php
							$QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'";
							$ResultOfQuery=mysqli_query($con,$QueryApproved);
							$ExecuteApproved=mysqli_fetch_array($ResultOfQuery);
							 $TotalApproved=array_shift($ExecuteApproved);
							 if($TotalApproved>0){
								 ?>
								 <span class="label label-success pull-right">
								 <?php echo $TotalApproved; ?>
								 </span>
								 <?php
							 }
						?>
						<?php
							$QueryUnapproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='OFF'";
							$ResultOfQuery=mysqli_query($con,$QueryUnapproved);
							$ExecuteUnapproved=mysqli_fetch_array($ResultOfQuery);
							 $TotalUnapproved=array_shift($ExecuteUnapproved);
							 if($TotalUnapproved>0){
								 ?>
								 <span class="label label-danger pull-left">
								 <?php echo $TotalUnapproved; ?>
								 </span>
								 <?php
							 }
						?>
						</td>
						<td><a href="EditPost.php?Edit=<?php echo $Id;?>"><span class="btn btn-warning">Edit</span></a>
						<a href="DeletePost.php?Delete=<?php echo $Id;?>"><span class="btn btn-danger">Delete</span></td>
						<td><a href="FullPost.php?id=<?php echo $Id ;?>"><span class = "btn btn-primary">Live Preview</span></a></td>
					</tr>
					<?php
				}
			?>
		</table>
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
<div style="height=10px; background: #27aae1;"></div>
</body>
</html>