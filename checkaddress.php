<?php
include $_SERVER['DOCUMENT_ROOT'].'/shop/core/init.php';
$full_name=sanitize($_POST['full_name']);
$email=sanitize($_POST['email']);
$streetaddress1=sanitize($_POST['streetaddress1']);
$streetaddress2=sanitize($_POST['streetaddress2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zipcode=sanitize($_POST['zipcode']);
$country=sanitize($_POST['country']);
$error=array();
$required=array(
 'full_name'=>$full_name,
 'email'=>$email,
 'streetaddress1'=>$streetaddress1,
 'streetaddress2'=>$streetaddress2,
 'city'=>$city,
 'state'=>$state,
 'zipcode'=>$zipcode,
 'country'=>$country


	);

if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{
$error[]="Email is invalid";
}
foreach ($required as $f => $d) {


if(empty($_POST[$f]) || $_POST[$f]=='')
{
$error[]= $d." is required";
}
}
if(!empty($error))
{
	echo display_error($error);
}
else
{
	echo 'passed';
}



?>