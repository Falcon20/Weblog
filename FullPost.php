<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");?>
<?php
if(isset($_POST['submit'])){
		$PostId=$_GET['id'];
	 $Name=mysqli_real_escape_string($con,$_POST['Name']);
	 $Email=mysqli_real_escape_string($con,$_POST['Email']);
	 $Comment=mysqli_real_escape_string($con,$_POST['Comment']);
	date_default_timezone_set("Asia/Calcutta"); 
	$CurrentTime=time();
	$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($Name)||empty($Email)||empty($Comment)){
		$_SESSION["ErrorMessage"]="Please fill in all fields";
		
	}
	elseif(strlen($Comment)>500){
		$_SESSION["ErrorMessage"]="Only 500 characters are allowed in comment";
	
	}
	else{
		$PostIdFromURL=$_GET['id'];
		$Admin=$_SESSION['Username'];
		if(!mysqli_query($con,"INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id) 
VALUES ('$DateTime','$Name','$Email','$Comment','pending','OFF','$PostIdFromURL')")){
			$_SESSION["ErrorMessage"]="Something went wrong";
			Redirect_to("FullPost.php?id={$PostId}");
		
	}
	else{
		$_SESSION["SuccessMessage"]="Comment added successfully";
			Redirect_to("FullPost.php?id={$PostId}");
	}
	
 }
} 
?>
<html>
<head>
<title>Full Blog Post</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/publicstyles.css">
	<style>
	.FieldInfo{
		color :rgb(251,174,44);
		font-family: Bitter,Georgia,"Times New Roman",Times,serif;
		font-size: 1.2em;
	}
	.CommentBlock{
		background-color:#f6f7f9;
	}
	.Comment-info{
		color:#365899;
		font-family:sans-serif;
		font-size: 1.1em;
		font-weight: bold;
		padding-top:10px;
	}
	.discription{
		color:#868686;
	margin-top:-2px;
	}
	.Comment{
		margin-top:-2px;
		padding -bottom:10px;
		font-size: 1.1em;
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
		<li class="active"><a href="Blog.php">Blog</a></li>
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
</nav>
</div>
<div class="Line" style="height: 10px; background:#27aae1"></div>
<div class="container"><!-- Container starting-->
	<div class="blog header">
	<h1>The Complete Responsive CMS Blog</h1>
	<p class="lead">The complete blog using PHP and MySQL.</p >
	</div >
	<div>
		<?php echo Message();
		echo SuccessMessage();?>
		</div>

	<div class="row">
		<div class="col-sm-8"><!--- Main Blog Area -->
		<?php
			if(isset($_GET["SearchButton"])){
				$Search=$_GET["Search"];
				$ViewQuery="SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY datetime desc";
			}
			else{
				$PostIdFromUrl=$_GET["id"];
			$ViewQuery="SELECT * FROM admin_panel WHERE id='$PostIdFromUrl' ORDER BY datetime desc";}
			$result=mysqli_query($con,$ViewQuery);
			while($row=mysqli_fetch_array($result)){
				$Postid=$row['id'];
				$DateTime=$row['datetime'];
				$Title=$row['title'];
				$Category=$row['category'];
				$Admin=$row['author'];
				$Image=$row['image'];
				$Post=$row['post'];
		
		?>
		<div class=" blogpost thumbnail">
		<img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>"/>
			<div class="caption">
			<h1 id="heading" ><?php echo htmlentities($Title); ?></h1>
			<p class="discription"> Category: <?php echo htmlentities($Category);?> Published on <?php echo htmlentities($DateTime)?></p>
			<p class="post"> <?php echo nl2br($Post); ?></p>
			</div>
		</div>
		<?php
			} ?>
		<div>
		<span class="FieldInfo">Comments</span>
		<br>
		
		<?php
			$PostIdForComment=$_GET['id'];
			$sql="SELECT * FROM comments WHERE admin_panel_id='$PostIdForComment' and status='ON'";
			$result=mysqli_query($con,$sql);
			while($row=mysqli_fetch_array($result)){
				$CommentDate=$row['datetime'];
				$CommenterName=$row['name'];
				$Comments=$row['comment']
				
				
		?>
		<div class="CommentBlock">
		<img style="margin-left:10px; margin-top:10px;"class="pull-left" src="Images/comment.png" width="70px" height="70px">
			<p style="margin-left:90px;" class="Comment-info"><?php echo htmlentities($CommenterName); ?></p>
			<p style="margin-left:90px;" class="discription"><?php echo htmlentities($CommentDate); ?></p>
			<p style="margin-left:90px;" class="Comment"><?php echo nl2br($Comments); ?></p>
		</div>
			<?php } ?>
		
		<span class="FieldInfo">Share your thoughts about this post</span><br><br>
		<form  method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
				<label for ="Name"><span class="FieldInfo">Name:</span></label>
				<input type="text" class="form-control" name="Name" id="Name" placeholder="Name">
				</div>
				<div class="form-group">
				<label for ="Email"><span class="FieldInfo">Email:</span></label>
				<input type="email" class="form-control" name="Email" id="Email" placeholder="Email">
				</div>
				<div class="form-group">
				<label for ="commentarea"><span class="FieldInfo">Comment:</span></label>
				<textarea class="form-control" name="Comment" id="commentarea"></textarea>
				</div>
				<br>
				<input class="btn  btn-primary btn-block" type="submit" name="submit" value="Submit">
			</fieldset>
		</form>
		</div>
		
		</div ><!--- Main Blog area ending-->
		
		<div class="col-sm-offset-1 col-sm-3"><!-- Side Area-->
		<h2 >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAbout me</h2>
		<img src="Upload/azad.jpg" class="img-responsive img-circle imageicon"/><br>
		<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">Categories</h2>
			</div>
			<div class="panel-body">
			
			<?php 
			//$con=mysqli_connect("localhost","root","","phpcms");
				$Query="SELECT * from category ORDER by datetime desc";
			$result=mysqli_query($con,$Query);
			while($row=mysqli_fetch_array($result)){
				$Id=$row['id'];
				$Category=$row['name'];
			?>
			<a href="Blog.php?Category=<?php echo $Category; ?>">
			<span id="heading"><?php echo $Category;?>.<br><br></span>
			</a>
			<?php
			}
			?>
			</div>
			<div class="panel-footer">
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">Recent Posts</h2>
			</div>
			<div class="panel-body bcolor">
			<?php
				$Query="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
			$result=mysqli_query($con,$Query);
			while($row=mysqli_fetch_array($result)){
				 $Id=$row['id'];	
				 $Title=$row['title'];
				 $DateTime=$row['datetime'];
				 $Image=$row['image'];
				 if(strlen($DateTime)>	11){
					 $DateTime=substr($DateTime,0,11);
				 }
				?>
				<div>
				<img class="pull-left" style="margin-top:10px" margin-left: "10px" src="Upload/<?php echo htmlentities($Image); ?>" width="70px" height="60px"/>
				<a href="FullPost.php?id=<?php echo $Id;?>">
				<p id="heading" style="margin-left:90px"><?php echo htmlentities($Title);?></p>
				</a>
				<p class="discription" style="margin-left:90px"><?php echo htmlentities($DateTime);?></p>
				<hr >
				</div>
				<?php
			}
				?>
			</div>
			<div class="panel-footer">
			</div>
		</div>
		</div><!-- side area ending--->
		
	</div><!-- Row Ending-->

</div><!---- container ending-->
	
</body>
</html>












