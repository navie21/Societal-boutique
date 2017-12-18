<?php 

include'../core/init.php';

if(!is_logged_in())
{
	log_error_redirect();
}
include'include/head.php';
include'include/navigation.php';?>
<?php  $query=mysqli_query($db,"select * from brand ");
?>
<?php
$edit="";
if(isset($_GET['edit']) && !empty('edit'))
{
	$edit=(int)$_GET['edit'];
	$edit= sanitize($edit);
	$query7=mysqli_query($db,"select * from brand where id='$edit'");
	$edit_result=mysqli_fetch_assoc($query7);
}


if(isset($_GET['delete']) && !empty('delete'))
{
	$delete=(int)$_GET['delete'];
	$delete= sanitize($delete);
	$query5="delete from brand where id='$delete'";
	$result=mysqli_query($db,$query5);
header('brands.php');
	
}


$error=array();

 if(isset($_POST['add'])) 
 {
    $brand=sanitize($_POST['brand']);
    if($_POST['brand']=='')
    {
       $error[].="you must enter something...!";
       

    }
  

// check given brand exist in db or not
    $query3=mysqli_query($db,"select * from brand where brand='$brand'");
    if(isset($_GET['edit'])){
    	$query3=mysqli_query($db,"select * from brand where brand='$brand' AND id !='$edit'");
    }
    if(mysqli_num_rows($query3)>0)
    {
    	$error[].=$brand."  Entered brand is already exist please try another....!";
    	  
    	}


    	  if(!empty($error))
    	{
             echo display_error($error);
    	}

    	

else
{
	$query4="insert into brand  (brand) values ('$brand')";
	if(isset($_GET['edit']))
	{
		$query4="update brand set brand='$brand'  where id=".$_GET['edit'];
	}
	
	$result=mysqli_query($db,$query4);
		header('brands.php');
	
}
}
?>
<h2 class="text-center"> Brands</h2>
<div  class="text-center">
<form class="form-inline" action="brands.php<?php  echo ((isset($_GET['edit'])?'?edit='.$edit:'')); ?>" method="post">
<div class="form-group">
<label for="brand-name"> <?php  echo ((isset($_GET['edit'])?'Edit':'Add a')); ?> brand</label>
<?php
$brand_value="";
if(isset($_GET['edit']))
{
$brand_value=$edit_result['brand'];
}
else
{ if(isset($_POST['brand'])){ 

	$brand_value= $_POST['brand'];
}

	}?>
<input type="text" name="brand" id="brand" class="form-control" value="<?php echo $brand_value ;?>">
<?php  if(isset($_GET['edit'])){ ?>
<a href="brands.php" class="btn btn-default">cancel </a>

<?php } ?>

<input type="submit" name="add" value="<?php  echo ((isset($_GET['edit'])?'Edit ':'Add ')); ?>Brand" class="btn  btn-success">
	
</div>
<hr>
</form>
</div> 
<table class="table table-bordered table-striped table-condensed" style="width:auto; margin:0 auto;">
<thead>
	<th></th>
	<th>Brand</th>
	<th></th>
</thead>
<tbody>

<?php while($brand=mysqli_fetch_array($query)):?>
	<tr>

	<td><a href="brands.php?edit=<?php echo $brand['id'];?>" class="btn btn-xs-small btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
	<td><?php echo $brand['brand'] ;?></td>
	<td><a href="brands.php?delete=<?php echo $brand['id'];?>" class="btn btn-xs-small"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
	</tr>
<?php endwhile ; ?>
</tbody>


</table>

<?php include'include/footer.php';

?>