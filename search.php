
<?php

include'core/init.php';

 include'include/head.php' ; 
 include'include/navigation.php' ; 
  include'include/partialheader.php' ; 
  include'include/leftside.php' ; 

$sql="select * from product";
if(isset($_POST['cat']))
{
$cat_id=(($_POST['cat']!='')?$_POST['cat']:'');
}

if($cat_id=='')
{
	$sql.=" where deleted=0";
}
else
{
	$sql.=" where catagory='$cat_id' AND deleted =0";
}

if(isset($_POST['submit']))
{
$price_sort=(($_POST['price_sort'])?$_POST['price_sort']:'');
$min_price=(($_POST['min']!='')?$_POST['min']:'');
$max_price=(($_POST['max']!='')?$_POST['max']:'');
$brand=(($_POST['brand']!='')?$_POST['brand']:'');
}
if($min_price!='')
{
	$sql.= " AND price>='$min_price'";
}
if($max_price!='')
{
	$sql.= " AND price<='$max_price'";
}
if($brand!=''){
	$sql.="  AND brand='{$brand}'";
}


if($price_sort=='high')
{
	$sql.=" order by price desc";

}
if($price_sort=='low')
{
	$sql.=" order by price";

}

$productQ=mysqli_query($db,$sql);

$catagory=get_cat($cat_id);
?>

<div class="col-md-8">
	<div class="row">
<?php if($cat_id!=''){?>
	 <h2 class="text-center"> <?= $catagory['parent'].'-'.$catagory['child'] ; ?></h2>
	  <?php } else ?>
	     <h2 class="text-center"> societal boutique</h2>
	 
	 

	 <?php  while($row=mysqli_fetch_assoc($productQ)):?>
	 	<div class="col-md-4">
	 <h4><?php echo $row['title']?> </h4>
	 <?php $photos=explode(',',$row['image']) ; ?>
	 <img src="<?php echo $photos[0] ;?>" width="175" height="200" alt="levis-jeans">
	 <p class="list-price text-danger">List-price:<s> Rs <?php echo $row['list_price'];?></s></p>
	 <p class="price"> Our price:Rs <?php  echo $row['price']?></p>
	 <button  type="button" class="btn  btn-sm btn-success" onclick="detailmodal(<?php echo $row['id'] ?>)">details</button>
	 </div>
	<?php endwhile;?>




</div>

</div>
<?php 
  include'include/rightside.php' ; 
  
     include'include/footer.php' ; 
    


 ?>

<body>

 




</body>
</html>
 <script>
    function closeModal(){
    $('#details-modal').modal('hide');
    setTimeout(function(){ $('#details-modal').remove();
      $('.modal-backdrop').remove();

    },500);
  }
  </script>
<?php  echo ob_get_clean(); ?>