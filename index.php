<?php 
include'../core/init.php';

if(!is_logged_in())
{
	log_error_redirect();
}

include'include/head.php';
include'include/navigation.php';
?>
<?php
$tranQ=mysqli_query($db,"select t.id as tid,t.cart_id,t.full_name,t.transDate,t.grandtotal,c.items,c.paid,c.shipped from transaction t  left join cart c  on t.cart_id=c.id where paid=1 and shipped=0 order by transDate") or die(mysqli_error($db));
?>
<div class="col-md-12">
  <div class="text-center"><h2>Orders to ship</h2></div>
 
  <table class="table table-condensed table-bordered table-striped">
  	 <thead>
  	   	 <th>Details</th>
  	 	<th>transactionID</th>
  	 	<th>Full Name</th>
  	 	<th>Grand total</th>
  	 	<th>transaction Date</th>
  	 </thead>
  	 <tbody>
  	<?php while($row=mysqli_fetch_assoc($tranQ)){
  $tid=	$row['tid']; ?>
  	 	<tr>
  	 	    <td><a href="orders.php?orders=<?= $tid ;?>" class="btn btn-xs btn-primary">details</a></td>
  	 		<td><?= $row['tid'];?></td>
  	 		<td><?= $row['full_name'];?></td>
  	 		<td><?= $row['grandtotal'];?></td>
  	 		<td><?= $row['transDate'];?></td>
  	 	</tr>
  	 	<?php 
  	 } 
  	 ?>
  	 	</tbody>
  	 </tbody>
  		
  </table>

</div>


<?php 

include'include/footer.php';

?>