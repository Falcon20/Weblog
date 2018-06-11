<?php require_once("Include/sessions.php");?>
<?php require_once("Include/functions.php");?>
<?php require_once("Include/db.php"); ?>
<?php
if(isset($_GET['id'])){
	$IDFromURL=$_GET['id'];
	$sql="DELETE from category  WHERE id='$IDFromURL'";
			$result=mysqli_query($con,$sql);
			if($result){
				$_SESSION["SuccessMessage"]="Category has been deleted";
				Redirect_to("categories.php");
			}
			else{
				
				$_SESSION["ErrorMessage"]="Something went wrong. Try Again!";
				Redirect_to("categories.php");
				
			}
}

?>