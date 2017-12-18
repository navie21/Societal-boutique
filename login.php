<?php 
include'../core/init.php';
include'include/head.php';
?>
<div id="login-form" class="text-center"><?php
$email=((isset($_POST['email'])?sanitize($_POST['email']):""));
$email=trim($email);

$pwd=(isset($_POST['pwd'])?sanitize($_POST['pwd']):"");

$pwd=trim($pwd);
$error=array();
if($_POST)
{
if(empty($_POST['email']) || empty($_POST['pwd']))
{
	$error[]="<span class='glyphicon glyphicon-info-sign'></span>  email or password cant be empty";

}
if (!filter_var($email,FILTER_VALIDATE_EMAIL))
{
	$error[]=" <span class='glyphicon glyphicon-info-sign'></span>email is not valid";
}
if (strlen($pwd)<6){
	$error[]=" <span class='glyphicon glyphicon-info-sign'></span>  password must contain atleast 8 letters ";
}
$checkQ=mysqli_query($db,"select * from users where email='$email'") or die(mysqli_error($db));
$user=mysqli_fetch_assoc($checkQ);
$count=mysqli_num_rows($checkQ);
if ($count==0)
{
$error[]="<span class='glyphicon glyphicon-info-sign'></span> email or password are  incorrect";
}
if(!password_verify($pwd,$user['password'])){
	$error[]="<span class='glyphicon glyphicon-info-sign'></span>password is not verified";
}
if (!empty($error))
{
	echo display_error($error);
}
else{
	$user_id=$user['id'];
	login($user_id);
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
  <h2><b>Login </b></h2> 
	
	<form action="login.php" method="post">
	<div class="form-group">
		<input type="text" name="email" class="form-control" value="<?=  $email ;?>" placeholder="email">
	</div>	
	<div class="form-group">
	<input type="password" name="pwd" class="form-control" value="<?= $pwd; ?>" placeholder="password">
		
	</div>	
<div class="form-group">
	<input type="submit" name="submit"  value="Login" class="btn btn-lg btn-primary">
		
	</div>	

	</form>
	<p class="text-right"><a href="../index.php" class="btn btn-success">view site</a></p>
</div>

<?php  include'include/footer.php';?>