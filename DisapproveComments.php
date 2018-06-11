<?php require_once("Include/sessions.php");?>
<?php require_once("Include/functions.php");?>
<?php require_once("Include/db.php"); ?>
<?php
if(isset($_GET['id'])){
	$IDFromURL=$_GET['id'];
	$sql="UPDATE comments SET status='OFF' WHERE id='$IDFromURL'";
			$result=mysqli_query($con,$sql);
			if($result){
				$_SESSION["SuccessMessage"]="Comment has been disapproved";
				Redirect_to("Comments.php");
			}
			else{
				
				$_SESSION["ErrorMessage"]="Something went wrong. Try Again!";
				Redirect_to("Comments.php");
				
			}
}

?>