<?php 
include'../core/init.php';
include'include/head.php';

if(!is_logged_in())
{
	log_error_redirect();
}
?>
<div id="login-form" class="text-center"><?php

$hashed=$user['password'];

$oldpwd=(isset($_POST['oldpwd'])?sanitize($_POST['oldpwd']):"");
$oldpwd=trim($oldpwd);
$npwd=(isset($_POST['pwd'])?sanitize($_POST['pwd']):"");
 $npwd=trim($npwd);
$confirm=(isset($_POST['confirm'])?sanitize($_POST['confirm']):"");
$confirm=trim($confirm);
$error=array();
if($_POST)
{ 
//checking new and confirm match 
	$user_id=$_SESSION['sbuser'];
if($npwd!=$confirm){
	$error[]="new password and confirm password are not matching";
}


if(empty($_POST['oldpwd']) || empty($_POST['pwd']) ||empty($_POST['confirm']))
{
	$error[]="All these fields are required";

}
if (strlen($npwd)<6){
	$error[]="password must contain atleast 8 letters ";
}
if(!password_verify($oldpwd,$user['password'])){
	$error[]="old password is not verified";
}
if (!empty($error))
{
	echo display_error($error);
}

else
{ 
	
	$nwhashed=password_hash($npwd,PASSWORD_DEFAULT);
	$changepwdQ=mysqli_query($db,"update users set password='$nwhashed' where id='$user_id'");
	$_SESSION['success-flash']="your password has changed successfully";
	header('location:index.php');
}

}

?>
<style>
	body{
		background-image: url("../image/bg4.jpg");
		background-size: 100vw 100vh;
background-attachment: fixed;

	}
	#login-form{
		width:50%;
	height:60%;
	border:10px solid ;
	border-radius: 15px;
	box-shadow: 7px 7px 7px rgba(0,0,0,0);
	margin:  8% auto;
	padding: 15px;
	}
	#login-form h2{
		font-family: comic Sans Ms;
	}
	footer{
		color: black;
	}
</style>
  <h2><b>Change Password</b></h2> 
	
	<form action="change_password.php" method="post">
	
	<div class="form-group">
	<input type="password" name="oldpwd" class="form-control" value="<?= $oldpwd; ?>" placeholder=" old password">
		
	</div>	

	<div class="form-group">
	<input type="password" name="pwd" class="form-control" value="<?= $npwd; ?>" placeholder=" new password">
		
	</div>	

	<div class="form-group">
	<input type="password" name="confirm" class="form-control" value="<?= $confirm; ?>" placeholder="confirm password">
		
	</div>	
<div class="form-group">
<a href="index.php" class="btn btn-lg btn-default"> cancel</a>
	<input type="submit" name="submit"  value="Apply" class="btn btn-lg btn-primary">
		
	</div>	

	</form>
	
</div>

<?php  include'include/footer.php';?>