s<?php

include $_SERVER['DOCUMENT_ROOT']."/shop/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/shop/config.php";
$product_id=sanitize($_POST['product_id']);
$size=sanitize($_POST['size']);
$quantity=sanitize($_POST['quantity']);
$availble=sanitize($_POST['availble']);

$item=array();
$item[]=array(
'id'=>$product_id,
'size'=>$size,

'quantity'=>$quantity
	);

$pQuery=mysqli_query($db,"select * from product where id='$product_id'") ;
$pqResult=mysqli_fetch_assoc($pQuery);
if($cart_id !='')
{

$cartQ=mysqli_query($db,"select * from cart where id='{$cart_id}'");

$cartR=mysqli_fetch_assoc($cartQ);
echo $cart_id;
var_dump($cartR);
$previous_item=array();
$previous_item=json_decode($cartR['items'],true);
$item_match=0;
$new_items=array();
foreach ($previous_item as $pitem) {
if($item[0]['id']==$pitem['id'] && $item[0]['size']==$pitem['size'])
{

	$pitem['quantity']=$pitem['quantity']+$item[0]['quantity'];
	if($pitem['quantity']>$availble)
	{
		$pitem['quantity']=$availble;
	}

	$item_match=1;
	  

}
$new_items[]=$pitem;
}

if($item_match!=1)
	{ $new_items=array_merge($item,$previous_item);
	}

	$item_json=json_encode($new_items);
	  $cart_expiry=date("Y-m-d H:i:s",strtotime("+ 30 days"));
	  $cartQ=mysqli_query($db,"update cart set items='{$item_json}',expiry='{$cart_expiry}' where id='{$cart_id}'");
	   setcookie($cart_cookie_name,'',1,'/',null);
	    setcookie($cart_cookie_name,$cart_id,$cart_cookie_expiry,'/',null);
   
   
	 



}

else{

	  $item_json=json_encode($item);
      $cart_expiry=date("Y-m-d H:i:s",strtotime("+ 30 days"));
      $cartQ=mysqli_query($db,"insert into cart(items,expiry) values('{$item_json}','{$cart_expiry}')") or mysqli_error($db); 
      $cart_id=mysqli_insert_id($db);
      $_SESSION['success-flash']= $pqResult['title']." has been added";
   setcookie($cart_cookie_name,$cart_id,$cart_cookie_expiry,'/',null);
   


}

$_SESSION['success-flash']= $pqResult['title']." has been added";

?>