<?php 

include'../core/init.php';
include'include/head.php';
$uploadedfilepace=array();
$tmp=array();

if(!is_logged_in())
{
	log_error_redirect();
}
include'include/navigation.php';
$parent="";

 $edit_id="";
 $uploadeddbpath="";
 $error=array();

			$sA=array();
			$sB=array();
 //delete
 if((isset($_GET['delete']))){
 	$del_id=$_GET['delete'];
 	$delQ=mysqli_query($db,"update product set deleted=1 where id=".$del_id);
 	header('location:products.php');
 }
if(isset($_GET['add']) || isset($_GET['edit']))
{
	$brandQ=mysqli_query($db,"select * from brand order by brand");
	$catQ=mysqli_query($db,"select * from catagory where parent=0 order by catagory");
	 $title=((isset($_POST['title']) && $_POST['title']!='')?sanitize($_POST['title']):'');
	 $brand=((isset($_POST['brand']) && $_POST['brand']!='')?sanitize($_POST['brand']):'');
	$child=((isset($_POST['child']) && $_POST['child']!='')?sanitize($_POST['child']):'');
    $price=((isset($_POST['price']) && $_POST['price']!='')?sanitize($_POST['price']):'');
    $listprice=((isset($_POST['listprice']) && $_POST['listprice']!='')?sanitize($_POST['listprice']):'');
     $size=((isset($_POST['sizes']) && $_POST['sizes']!='')?sanitize($_POST['sizes']):'');
      $size=rtrim($size,",");
      $save_image="";
    
     $description=((isset($_POST['description']) && $_POST['description']!='')?sanitize($_POST['description']):'');
       


      
       if(isset($_GET['edit']))
       {
       	$edit_id=$_GET['edit'];
       	$productQ=mysqli_query($db,"select * from product where id='$edit_id'");
       	$productR=mysqli_fetch_assoc($productQ);
       
       
if(isset($_GET['delete_image']))
{
	$image_url=$_SERVER['DOCUMENT_ROOT']."/shop".$productR['image'];
	unlink($image_url);
	unset($image_url);
	$deleteQ=mysqli_query($db,"update product set image='' where id='$edit_id'");
	header('location:products.php?edit='.$edit_id);
}
	$title=((isset($_POST['title']) && $_POST['title']!='')?sanitize($_POST['title']):$productR['title']);
       	$brand=((isset($_POST['brand']) && $_POST['brand']!='')?sanitize($_POST['brand']):$productR['brand']);
       	$child=(((isset($_POST['child']) && $_POST['child']!='')?sanitize($_POST['child']):$productR['catagory']));
       	$parentQ=mysqli_query($db,"select * from catagory where id='$child'");
       	$parentR=mysqli_fetch_assoc($parentQ);

       $parent=((isset($_POST['pcatagory']) && $_POST['pcatagory']!='')?sanitize($_POST['pcatagory']):$parentR['parent']);
       $price=((isset($_POST['price']) && $_POST['price']!='')?sanitize($_POST['price']):$productR['price']);
       $listprice=((isset($_POST['listprice']) && $_POST['listprice']!='')?sanitize($_POST['listprice']):$productR['list_price']);
       $size=((isset($_POST['sizes']) && $_POST['sizes']!='')?sanitize($_POST['sizes']):$productR['size']);
       $description=((isset($_POST['description']) && $_POST['description']!='')?sanitize($_POST['description']):$productR['description']);
       $size=((isset($_POST['sizes']) && $_POST['sizes']!='')?sanitize($_POST['sizes']):$productR['size']);
       $size=rtrim($size,",");

       $save_image=(($productR['image']!='')?$productR['image']:"");
       $uploadeddbpath=$save_image;


}



if(!empty($size)){

			$sizeArray=sanitize($size);
			$sizeArray=rtrim($sizeArray,",");

			$sizeString=explode(",",$sizeArray);

			foreach ($sizeString as $ss) {
				$s=explode(":", $ss);
			    $sA[]=$s[0];
				$sB[]=$s[1];

		}
		

		}
		else
			{ $sizeString=array();
			}

// for quantity and size
	if($_POST){
		



$required= array('title','brand','price','pcatagory','sizes');
			foreach($required as $rq)
			{
                  if(empty($_POST[$rq])){
                  	$error[]="<span class='glyphicon  glyphicon-info-sign'></span>  All field  with * is required ";
                  	break;
                  }
			}


		

$photocount=count($_FILES['photo']['name']);

if($photocount>0)
{ for($i=0;$i<$photocount;$i++)
	{
	

	
	$name=$_FILES['photo']['name'][$i];
	$nameA=explode(".", $name);
	$imageName=$nameA[0];
	$imageExt=$nameA[1];
	
	$mimeA=explode("/",$_FILES['photo']['type'][$i]);
	$mimeName=$mimeA[0];
    $mimeExt=$mimeA[1];
    $tmp[]=$_FILES['photo']['tmp_name'][$i];
    $fsize=$_FILES['photo']['size'][$i];
    $allowed=array('png','jpg','jpeg','gif');

    $uploadedName=md5(microtime()).".".$imageExt;
  
    $uploadedfilepace[]=$_SERVER['DOCUMENT_ROOT']."/shop/image/products/".$uploadedName;
  
    if($i!=0)
    {
    	$uploadeddbpath.=",";
    }
    $uploadeddbpath.="/shop/image/products/".$uploadedName;
   
     
    if($mimeName!='image'){
    	$error[]="  <span class='glyphicon  glyphicon-info-sign'></span>   file must only image type";
  
    }
    
    if(!in_array($imageExt,$allowed) || $imageExt=='')
    {
    	$error[]=" <span class='glyphicon glyphicon-info-sign'></span>   file are allowed  png,jpeg or gif only ";
    }
    if($fsize>5000000)
  {
  	$error[]=" <span class='glyphicon  glyphicon-info-sign'></span>  file can't be more large than 5 mb";
  }


    }

    }        if(!empty($error))
            {
            	echo display_error($error);

            } 
            else
            { 
            	 

            	if($photocount>0){
            		for($i=0;$i<$photocount;$i++)
            		{
            move_uploaded_file($tmp[$i],$uploadedfilepace[$i]);
        }
        }
    }
           
            $uploadQ="insert into product(title,price,list_price,brand,catagory,image,description,size)  values('$title','$price','$listprice','$brand','$child','$uploadeddbpath','$description','$size')" ;
            
             
                if(isset($_GET['edit']))
                {   
                $uploadQ="update product set title='$title',price='$price' ,list_price='$listprice',brand='$brand', catagory='$child',image='$uploadeddbpath',description='$description',size='$size' where id=".$edit_id;
                }

              $re=mysqli_query($db,$uploadQ) or die(mysqli_error($db));
          
                header('location:products.php');
            

            

}
		
	
	?>
	
	<h2 class="text-center"><?= (isset($_GET['edit'])?'Edit':'Add');?> Product</h2><hr>
	<form action="products.php?<?=(isset($_GET['edit'])?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
	<div class="form-group col-md-3">
	<label for="title">title*</label>
	<input type="text" class="form-control" name="title" value="<?= $title ; ?>">
		
	</div>
	<div class="form-group col-md-3">
	<label for="brand">brand*</label>
	<select class="form-control" name="brand" >
		<option value=""<?= (( $brand=='')?'selected':'');?> ></option>
		<?php while($brandR=mysqli_fetch_assoc($brandQ)) {

			?>

			<option value="<?= $brandR['id'] ;?>"<?= (($brand == $brandR['id'])?'selected':''); ?> ><?= $brandR['brand']; ?></option>
	<?php	}
		?>

	</select>
	</div>

		
		<div class="form-group col-md-3">
	<label for="parent_catagory">Parent Cataory*</label>
	<select class="form-control" id="parent" name="pcatagory">
		<option value=""<?= (($parent ==' ')?' selected':'');?> ></option>
		<?php while($catR=mysqli_fetch_assoc($catQ)) {

			?>

			<option value="<?= $catR['id']; ?>"<?=(($parent==$catR['id'])?'selected':''); ?> ><?= $catR['catagory']; ?></option>
	<?php	}
		?>

	</select>
	</div>

			
		<div class="form-group col-md-3">
	<label for="child_catagory">Child Cataory*</label>
	<select class="form-control" id="child" name="child">

	</select>
	</div>

		<div class="form-group col-md-3">
	<label for="price">price*</label>
	<input type="text" class="form-control" name="price" value="<?= ($price);?>">
		
	</div>

		<div class="form-group col-md-3">
	<label for=" list price">list price</label>
	<input type="text" class="form-control" name="listprice" value="<?= $listprice ;?>">
		
	</div>
	
<div class="form-group col-md-3">
	<label for="quantity & size"> quantiy &size*</label>
	<button class="btn btn-default form-control" onclick="jQuery('#sizeModal').modal('toggle');return false;">Add & size</button>
	
	</div>
	
	<div class="form-group col-md-3">
	<label for="quantity & size"> quantity &size preview</label>
	
	<input type="text" class="form-control" name="sizes" id="sizes"  value="<?= $size ;?>" readonly>
		
	</div>
	<div class="form-group col-md-6">
	<?php

	if($save_image!=""){
	  $photos=explode(',',$save_image);
                  foreach ($photos as $photo) {
                   
                  ?>
	<div class="saved_image"><img style="width:200px;height:auto;"src="<?= $photo ;?>"></div>
	<?php } ?>

	<a href="products.php?delete_image&edit=<?= $edit_id ; ?>" class="text-danger">delete image</a>
<?php } else { ?>
	<label for="photo"> photo</label>
	<input type="file" name="photo[]" id="photo"  class="form-control" multiple="">
		<?php }  ?>
	</div>

</div>
	<div class="form-group col-md-6">
	<label for="description"> description</label>

	<textarea name="description" id="description" rows="6" class="form-control"><?= $description ;?></textarea>

		
	</div>
	<br><br><br>
	<div class="form-group col-md-3  pull-right">
	<input type="submit" name="addp" class="btn btn-success form-control"  value="submit">
	</div><div class="clearfix"></div>


	</form>

<!-- Modal -->
<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizeModalLabel">Sizes  & quantity </h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <?php for($i=1;$i<=12;$i++):

          	
          	?>
        <div class="form-group col-md-4">
        <label for="size">size</label>

        <input type="text" name="size<?= $i;?>" id="size<?= $i;?>" value="<?php echo((!empty($sA[$i-1]))?$sA[$i-1]:'');?>"class="form-control" >

        </div>
         <div class="form-group col-md-2">
        <label for="quantity">quantity</label>
      
        <input type="number" name="quantity<?= $i;?>"  id="qty<?=$i; ?>" class="form-control" value="<?=((!empty($sB[$i-1])? $sB[$i-1]:0)) ;?>"  min="0">
       
        </div>	
<?php endfor ; ?>
       
        	

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update();jQuery('#sizeModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
}

// to print prduct table main
$query=mysqli_query($db,"select * from product where deleted =0");
if(isset($_GET['featured']) && !empty($_GET['featured']))
{
	$id=$_GET['id'];
	$featured=$_GET['featured'];
	$featuredQuery=mysqli_query($db,"update  product set featured='$featured' where id='$id'");
	header('location:products.php');
}
?>

<h2 class="text-center" style="margin:100px 300px"> Products</h2><hr>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-p-btn ">Add Product</a><div class="clearfix"></div>
<table class="table table-bordered table-condensed table-striped">
	
	<thead class="bg-primary">
		<th>Edit/delete</th><th>product</th><th>price</th><th>catagory</th><th>featured</th><th>sold</th>
	</thead>
	<tbody>

<?php while($row=mysqli_fetch_assoc($query)) { 
  $childId=$row['catagory'];
  $childQuery=mysqli_query($db,"select * from catagory where id='$childId'");
  $childQResult=mysqli_fetch_assoc($childQuery);
  $childCatg=$childQResult['catagory'];
  $Getparent=$childQResult['parent'];
  $parentQuery=mysqli_query($db,"select * from catagory where id='$Getparent'");
  $parentR=mysqli_fetch_assoc($parentQuery);
  $parentName=$parentR['catagory'];
  $catag=$parentName."-".$childCatg;

 ?>

<tr>
		<td>
			<a href="products.php?edit=<?= $row['id'] ?>" class="btn btn-xs-small btn-default" > <span class="glyphicon glyphicon-pencil"></span></a>
			<a href="products.php?delete=<?= $row['id'] ?>" class="btn btn-xs-small btn-default" > <span class="glyphicon glyphicon-remove-sign"></span></a>
		</td>
		<td><?= $row['title'] ?></td>
		<td><?=  money($row['price'])?></td>
		<td><?= $catag ?>;</td>
		<td> <a href="products.php?featured=<?=(($row['featured']==0)?'1':'0'); ?> & id= <?= $row['id']; ?>" class="btn btn-xs-small btn-default"> <span class="glyphicon glyphicon-<?=(($row['featured']==1)?'minus':'plus');?>" > </span></a> <?= (($row['featured']==0)?'non-featured':'featured');?></td>
		<td></td>
		</tr

		<?php 
	}
	?>
	</tbody>
</table>


<?php
include'include/footer.php';
?>
<script>
jQuery('document').ready(function(){
	get_child_option('<?php echo $child ;?>');

});
</script>


