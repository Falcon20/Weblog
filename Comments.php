<?php require_once("Include/sessions.php");?>
<?php require_once("Include/functions.php");?>
<?php require_once("Include/db.php"); ?>
<?php Confirm_Login(); ?>

<html>
<head>
	<title>Manage Comments</title>
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
				<li ><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> &nbspDashboard</a></li>
				<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Add new post</a></li>
				<li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp Categories</a></li>
				<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> &nbsp Manage Admins</a></li>
				<li class="active"><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span> &nbsp Comments</a></li>
				<li><a href="Blog.php?Page=1" target="_blank"><span class="glyphicon glyphicon-equalizer"></span> &nbsp Live Blog</a></li>
				<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp Logout</a></li>
			</ul>
		</div><!-- Ending of side area-->
		<div class="col-sm-10"><!-- Main Area-->
		<div ><?php echo Message();
		echo SuccessMessage();?>
		</div>
		<h1>Unapproved Comments</h1>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-hover table-bordered">
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Date</th>
					<th>Comments</th>
					<th>Approve</th>
					<th>Delete Comment</th>
					<th>Details</th>
				</tr>
				<?php
					$sql="SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc";
			$result=mysqli_query($con,$sql);
			$SrNo=0;
			while($row=mysqli_fetch_array($result)){
				$CommentId=$row['id'];
				$DateTimeofComment=$row['datetime'];
				$PersonName=$row['name'];
				$PersonComment=$row['comment'];
				$CommentedPostId=$row['admin_panel_id'];
				$SrNo++;
				if(strlen($PersonName)>15){
					$PersonName=substr($PersonName,0,15).'..';
				}
				
				?>
				<tr>
					<td ><?php echo htmlentities($SrNo);?></td>
					<td style="color:#5e5eff"><?php echo htmlentities($PersonName);?></td>
					<td><?php echo htmlentities($DateTimeofComment);?></td>
					<td><?php echo htmlentities($PersonComment);?></td>
					<td><a href="ApproveComments.php?id=<?php echo 	$CommentId;?>"><span class="btn btn-success">Approve</span></a></td>
					<td><a href="DeleteComments.php?id=<?php echo $CommentId;?>"><span class="btn btn-danger">Delete</span></a></td>
				<td><a href="FullPost.php?id=<?php echo $CommentedPostId;?>" target="_blank" ><span class="btn btn-Primary">Live Preview</span></a></td>
				</tr>
			<?php } ?>
			</table>
		</div>		
		<h1>Approved Comments</h1>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-hover table-bordered">
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Date</th>
					<th>Comments</th>
					<th>Approved By</th>
					<th>Revert Approve</th>
					<th>Delete Comment</th>
					<th>Details</th>
				</tr>
				<?php
				$Admin="Azad";
					$sql="SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc";
			$result=mysqli_query($con,$sql);
			$SrNo=0;
			while($row=mysqli_fetch_array($result)){
				$CommentId=$row['id'];
				$DateTimeofComment=$row['datetime'];
				$PersonName=$row['name'];
				$PersonComment=$row['comment'];
				$ApprovedBy=$row['approvedby'];
				$CommentedPostId=$row['admin_panel_id'];
				$SrNo++;
				if(strlen($PersonName)>15){
					$PersonName=substr($PersonName,0,15).'..';
				}
				
				?>
				<tr>
					<td><?php echo htmlentities($SrNo);?></td>
			<td style="color:#5e5eff"><?php echo htmlentities($PersonName);?></td>
					<td><?php echo htmlentities($DateTimeofComment);?></td>
					<td><?php echo htmlentities($PersonComment);?></td>
					<td><?php echo htmlentities($ApprovedBy); ?></td>
					<td><a href="DisapproveComments.php?id=<?php echo $CommentId;?>"><span class="btn btn-warning">Disapprove</span></a></td>
					<td><a href="DeleteComments.php?id=<?php echo $CommentId;?>"><span class="btn btn-danger">Delete</span></a></td>
				<td><a href="FullPost.php?id=<?php echo $CommentedPostId;?>" target="_blank" ><span class="btn btn-Primary">Live Preview</span></a></td>
				</tr>
			<?php } ?>
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