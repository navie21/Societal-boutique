<?php $sql3="select * from product where featured=1 AND deleted=0";
if(isset($_GET["search-button"]))
{
	$searchItem=$_GET['search'];
	$sql3="select * from product where title like '%$searchItem%'";
}
;
$featured=$db->query($sql3);
?>

<div class="col-md-8 ">
	<div class="row">
	 <h2 class="text-center"> Feature products</h2>

	  
	 <?php while($row=mysqli_fetch_array($featured)):?>
	 	<div class="col-md-3">
	 <h4><?php echo $row['title']?> </h4>
	
	  <?php  $photos=explode(',',$row['image']); ?>
                  
                  
	 <img src="<?= $photos[0]; ?>" width="175" height="200" alt="levis-jeans">
	
	
	 
	 <p class="list-price text-danger">List-price:<s> Rs <?php echo $row['list_price'];?></s></p>
	 <p class="price"> Our price:Rs <?php  echo $row['price']?></p>
	 <button  type="button" class="btn  btn-sm btn-success" onclick="detailmodal(<?php echo $row['id'] ?>)">details</button>
	 </div>
	<?php endwhile;?>




</div>

</div>