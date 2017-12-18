<?php include $_SERVER['DOCUMENT_ROOT'].'/shop/core/init.php';

if(!is_logged_in())
{
	log_error_redirect();
}
$x=array();
$productArray=array();
include'include/head.php';
include'include/navigation.php';
if(isset($_GET['complete']) && $_GET['complete']==1)
{
	$cart_id=$_GET['cart_id'];
	$updateQ=mysqli_query($db,"update cart set shipped=1 where id='{$cart_id}'");
	$_SESSION['success-flash']="the order has been completed !";
	header('location:index.php');

}
$txn_id=sanitize((int)$_GET['orders']);
$tranQ=mysqli_query($db,"select * from transaction where id='{$txn_id}'");
$orders=mysqli_fetch_assoc($tranQ);
$cart_id=$orders['cart_id'];
$cartQ=mysqli_query($db,"select * from cart where id='{$cart_id}'");
$cartR=mysqli_fetch_assoc($cartQ);
$items=json_decode($cartR['items'],true);

$idArray=array();

foreach ($items as $item) {
	$idArray[]=$item['id'];

}
$ids=implode(',',$idArray);
$proQ=mysqli_query($db,"select i.id as 'id',i.title  as 'title',c.id as 'cid',c.catagory as 'child' ,p.catagory as 'parent' from product i left join catagory c on i.catagory=c.id left join catagory p on c.parent=p.id where i.id IN ({$ids})") or die(mysqli_error($db));
while($product=mysqli_fetch_assoc($proQ)){
	foreach($items as $item)
	{
       if($item['id']==$product['id'])
       {
       	$x=$item;
       	continue;
       }
	}
	$productArray[]=array_merge($x,$product);

	
	
}


?>
<h2 class="text-center"> items ordered</h2>
<table class="table table-bordered table-condended table-striped">
	<thead>
		<th>quantity</th>
		<th>title</th>
		<th>catagory</th>
		<th>size</th>
	</thead>
	<tbody>
	<?php foreach($productArray as $p) {?>
		<tr>
			<td><?=  $p['quantity'] ;?></td>
			<td><?=  $p['title'] ;?></td>
			<td><?=  $p['parent']."--".$p['child'];?></td>
			<td><?= $p['size'] ;?></td>
		</tr>
<?php } ?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-6">
		<h3 class="text-center">orders details</h3>
		<table class="table table-bordered table-striped table-condended">
			<tbody>
				<tr>
				<td>subtotal</td>
				<td><?= money($orders['subtotal']);?></td>
				</tr>
				<tr>
				<td>Tax</td>
				<td><?= money($orders['tax']*100).'%';?></td>
				</tr>
				<tr>
				<td>Grand Total</td>
				<td><?= money($orders['grandtotal']);?></td>
				</tr>
				<tr>
				<td>order type</td>
				<td><?= prety_date($orders['transDate']);?></td>
				</tr>

			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<h3 class="text-center">shipping Address</h3>
		<address>
			<?= $orders['full_name'] ;?> <br>
			<?= $orders['street1'] ; ?> <br>
			<?= $orders['city']." ".$orders['state']."  ". $orders['zipcode']."  ".  $orders['country']; ?>


		</address>
	</div>
	</div>
	<div class="pull-right">
	<a href="index.php" class="btn btn-default btn-large">cancel</a>
	<a href="orders.php?complete=1&cart_id=<?= $cart_id; ?>" class="btn btn-primary btn-large">complete</a>
	</div>
