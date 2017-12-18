<?php
include $_SERVER['DOCUMENT_ROOT'].'/shop/core/init.php';
$node=sanitize($_POST['node']);
$edit_id=sanitize($_POST['edit_id']);
$edit_size=sanitize($_POST['edit_size']);
$cartQ=mysqli_query($db,"select * from cart where id='{$cart_id}' ");
$carts=mysqli_fetch_assoc($cartQ);
$items=json_decode($carts['items'],true);
$updated_items=array();
if($node=='remove')
 {
 	foreach($items as $item)
 	{
 		if($item['id']==$edit_id && $item['size']==$edit_size)
 		{
 			$item['quantity']=$item['quantity']-1;
 		}

 		if($item['quantity']>0)
 			{
 				$updated_items[]=$item;
 			}
 	}
 }
if($node=='add')
 {
 	foreach($items as $item)
 	{
 		if($item['id']==$edit_id && $item['size']==$edit_size)
 		{
 			$item['quantity']=$item['quantity']+1;
 		}

 		
 				$updated_items[]=$item;
   }

 }

 if(!empty($updated_items))
 { 
 	$json_update=json_encode($updated_items);

 	$updateQ=mysqli_query($db,"update cart set items='{$json_update}' where id='{$cart_id}'");
 	$_SESSION['success-flash']="your shopping cart has been updated";
 }

if(empty($updated_items))
{
	$updateQ=mysqli_query($db,"delete from cart  where id='{$cart_id}'");
	setcookie(CART_COOKIE,'','1','/',null);
	
}

?>


