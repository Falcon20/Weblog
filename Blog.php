<?php
require_once("Include/db.php");
require_once("Include/sessions.php");
require_once("Include/functions.php");?>
<html>
<head>
<title>Blog Page</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/publicstyles.css">
	<style>
	
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
	<div class="row">
		<div class="col-sm-8"><!--- Main Blog Area -->
		<?php
			if(isset($_GET["SearchButton"])){
				$Search=$_GET["Search"];
				$ViewQuery="SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY datetime desc";
			}
			else if(isset($_GET['Page'])){
				 $Page=$_GET['Page'];
					if($Page<=0){
					$ShowPostFrom=0;
					}
					else{
						$ShowPostFrom=($Page*5)-5;
					}
					$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $ShowPostFrom,5 ";
			}
			else if(isset($_GET['Category'])){
				$Category=$_GET['Category'];
				$ViewQuery="SELECT * from admin_panel WHERE category='$Category' ORDER BY datetime desc";
			}
			else{
				$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime desc";
			}
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
			<p class="post"> <?php if(strlen($Post)>150){ $Post=substr($Post,0,150).'...';}  echo $Post; ?></p>
			</div>
			<a href="FullPost.php?id=<?php echo $Postid ;?>"><span class="btn btn-info">
				Read More &rsaquo;&rsaquo; </span>
				</a>
		</div>
		<?php
			} ?>
			<nav>
				<ul class="pagination pull-left pagination-lg">
		<?php
		if(isset($_GET['Page'])){
			if($Page>1){
				// Creating Backward Button
				?>
				<li><a href="Blog.php?Page=<?php echo $Page-1;?>">&laquo </a></li>
				<?php
			}
		}
		$QueryPagination="SELECT * FROM admin_panel";
			$result=mysqli_query($con,$QueryPagination);
			$RowPagination=mysqli_fetch_array($result);
			$TotalPost=array_shift($RowPagination);
			$PostPagination=$TotalPost/5;
			$PostPagination=ceil($PostPagination);
			for($i=1;$i<=$PostPagination;$i++){
				if(isset($_GET['Page'])){
				if($i==$Page){
					?>
					<li class="active"><a href="Blog.php?Page=<?php echo $i;?>"><?php echo $i;?></a></li>
					<?php
				}
				else{
					?>
				<li><a href="Blog.php?Page=<?php echo $i;?>"><?php echo $i;?></a></li>
				<?php
				}
				?>
				<?php
			}
			
			}
			?>
			<?php
			if(isset($_GET['Page'])){
			if($Page<$PostPagination){
				// Creating forward button
				?>
				<li><a href="Blog.php?Page=<?php echo $Page+1;?>">&raquo </a></li>
				<?php
			}
		}
			?>
			</ul>
			</nav>
			
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
			<div class="panel-body bg">
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
				<img class="pull-left" style="margin-top:10px;" src="Upload/<?php echo htmlentities($Image); ?>" width="70px" height="60px"/>
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












