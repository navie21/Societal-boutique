<?php
include $_SERVER['DOCUMENT_ROOT']."/shop/core/init.php";

$product_id=sanitize($_POST['product_id']);
$size=sanitize($_POST['size']);
$quantity=sanitize($_POST['quantity']);


$item=array();
$item[]=array(
'id'=>$product_id,
'size'=>$size,

'quantity'=>$quantity
	);


$pQuery=mysqli_query($db,"select * from product where id=$product_id") or mysqli_error($db) ;
$pqResult=mysqli_fetch_assoc($pQuery);

$_SESSION['success-flash']= $pqResult['title']." has been added";
 $item_json=json_encode($item);
      $cart_expiry=date("Y-m-d H:i:s",strtotime("+ 30 days"));
     $cartQ=mysqli_query($db,"insert into cart(items,expiry) values('{$item_json}','{$cart_expiry}')") or mysqli_error($db); 
      $cart_id=mysqli_insert_id($db);
      echo $cart_id;
      

?>