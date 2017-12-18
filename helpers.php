<?php 

function display_error($error){
	$display='';
	foreach ($error as $err) {
		
		$display.='<ul class="bg-danger"><li class="text-danger"><b>'.$err.'</b></li>';
		$display.='</ul>';
	}
	return $display;
}

function sanitize($dirty)
{
  return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}


function money($price)
{
	return "Rs ". $price;
}

function login($user_id){
	$_SESSION['sbuser']=$user_id;
	global $db;
	$date=date('Y-m-d H:m:s');
	$dateUQ=mysqli_query($db,"update users set last_login= '$date' where id='$user_id'") or die(mysqli_error($db));
	$_SESSION['success-flash'] = "you are now logged in";

	header('location:index.php');
}
function is_logged_in()
{
	if(isset($_SESSION['sbuser']) || $_SESSION['sbuser']>0)
	{
		return true;
	}
	return false;
}


function log_error_redirect(){

$_SESSION['error-flash']="you must login to access";
header('location:login.php');

}
function has_permission($permission)
{
	global $user;
	$permissions=explode(",",$user['permission']) ;
	
	if(in_array($permission,$permissions,true))
	{
		return true;
	}
	return false;
}
function permission_redirect($url){
	$_SESSION['error-flash']="you do not have permission to access Admin panel";
	header('location:'.$url);
}

function prety_date($date){
	return date("M d,Y h:i A");
}
function  get_cat($child)
{
	$id=sanitize($child);
	global $db;
	$sql= "select p.id as 'pid', p.catagory as 'parent', c.id as 'cid' ,c.catagory as 'child'  from catagory c inner join  catagory p on c.parent=p.id where c.id='$id'";
	$query=mysqli_query($db,$sql) or die(mysqli_error($db));
	$catagory=mysqli_fetch_assoc($query);
	return $catagory;
}

function sizeToArray($string)
{ $s[1]=0;
	$sizestring=explode(',',$string);
	$resultarray=array();
	foreach ($sizestring as $size) {
	
	$s=explode(':',$size);
	$resultarray[]=array('size' => $s[0],'quantity' => $s[1]);
	}
	return $resultarray;

}


function sizeToString($sizes)
{
	$sizestring='';
	foreach ($sizes as  $s) {
		$sizestring.=$s['size'].':'.$s['quantity'].',';
	}

		$rtrimmed=rtrim($sizestring,',');
		return $rtrimmed;


		
	

}
?>