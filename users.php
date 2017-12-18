<?php 
include'../core/init.php';

if(!is_logged_in())
{
	log_error_redirect();
}
if(!has_permission('admin'))
{
	permission_redirect('index.php');
}
include'include/head.php';
include'include/navigation.php';

//insert the data in database'
if(isset($_POST))
{
$error=array();
$name=((isset($_POST['name'])?sanitize($_POST['name']):""));
$email=((isset($_POST['email'])?sanitize($_POST['email']):""));
$date=date('Y-m-d H:i:s');
$password=((isset($_POST['pwd'])?sanitize($_POST['pwd']):""));
$permission=(isset($_POST['permission'])?sanitize($_POST['permission']):"");
$confirm=((isset($_POST['confirm'])?sanitize($_POST['confirm']):""));
if(isset($_POST['user'])){
$chekQ=mysqli_query($db,"select * from users where email='$email'") or die(mysqli_error($db));

$emailCount=mysqli_num_rows($chekQ);
if($emailCount>=1)
{
	$error[]="email is already exist";

}

$required=array('name','email','pwd' ,'confirm','permission');
foreach($required as $f)
{
	if(empty($_POST[$f]))
	{
		$error[]="All fields are required";
		break;
	}
}
if($password!=$confirm){
	$error[]="new password and confirm password are not matching";
}
if(strlen($password)<6)
{
	$error[]="password lentgh must be greater yhan 6";
}
if (!filter_var($email,FILTER_VALIDATE_EMAIL))
{
	$error[]="your email is not valid";
}
if(!empty($error))
{
	echo display_error($error);
}
else{
	$hashed=password_hash($password,PASSWORD_DEFAULT);
	$insertQ=mysqli_query($db,"insert into users(full_name,email,password,join_date,permission) values('$name','$email','$hashed','$date','$permission')") or die(mysqli_error($db));
	$_SESSION['success-flash']="you have added successfully";
	header('location:users.php');


}
}
}

//delete user
if(isset($_GET['delete']))
{
	$delete_id=$_GET['delete'];
	$delQ=mysqli_query($db,"delete from  users where id='$delete_id'");
	$_SESSION['success-flash']="you have deleted one user successfully";
	header('location:users.php');
}

// for add
if(isset($_GET['add'])){
	?>
	<div>
	<form action="users.php?add=1" method="post">
	<div class="form-group col-md-6">
	<label for="name">Name*</label>
	<input type="text" class="form-control" name="name" value="<?=$name;?>">
		
	</div>
	<div class="form-group  col-md-6">
	<label for="email">Email*</label>
	<input type="text" class="form-control" name="email" value="<?=$email; ?>">
		
	</div>

	<div class="form-group col-md-6">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="pwd" value="<?= $password ; ?>">
		
	</div>

	<div class="form-group col-md-6">
	<label for="confirm">confirm</label>
	<input type="password" class="form-control" name="confirm" value="<?= $confirm ; ?>">
		
	</div>
	<div class="form-group col-md-6">
	<label for="permission">Permission:  </label>
	<select name="permission" class="form-control">
		
		<option value=""<?= (($permission='')?' selected':''); ?>> </option>
		<option value="editer"<?= (($permission='editer')?' selected':''); ?>> Editer </option>
		<option value="admin,editor"<?= (($permission='admin,editer')?' selected':''); ?>>Admin </option>
	</select>

	</div>

<div class="form-group pull-right  text-right col-md-6"  id="add-user" style="margin-top: 40px;">
	<a href="users.php" class="btn btn-default">cancel</a>
	<input type="submit" name="user" class="btn btn-primary"  value="Add-User">
		
	</div>

		
	</form>
	</div>

	<?php
}
else
{
?>
<h2>Users</h2>
<a href="users.php?add=1" class="btn btn-success btn-lg text-right pull-right" id="add-users">Add user</a>
<table class="table table-bordered table-condensed table-striped table-condensed">
<thead class="bg-primary">
	<th></th>
	<th>Name</th>
	<th>Email</th>
	<th>join Date</th>
	<th>last login</th>
	<th>permission</th>

</thead>

<tbody>
<?php
$userQ=mysqli_query($db,"select * from users") or die(mysqli_error($db));

while($userR=mysqli_fetch_assoc($userQ)){

?>
	<tr>
	<?php if($user_id!=$userR['id']){
		?>
<td><a href="users.php?delete=<?= $userR['id'];?>" class="glyphicon glyphicon-remove-sign"></a> 
</td><?php }
 else  {
	echo"<td> </td>";
	} ?>
	<td><?= $userR['full_name'] ;?></td>
	<td><?= $userR['email'] ;?></td>
	<td><?=  prety_date($userR['join_date']) ; ;?></td>
	<td><?=  prety_date($userR['last_login']) ; ;?></td>
	<td><?= $userR['permission'] ;?></td>

	</tr>
	<?php } ?>
</tbody>

 </table>
<?php
}
include'include/footer.php';
?>
