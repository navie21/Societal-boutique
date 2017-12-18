<?php
include'../core/init.php';
include'include/head.php';

if(!is_logged_in())
{
  log_error_redirect();
}
include'include/navigation.php';

//delete
if(isset($_GET['delete']))
{
  $del_id=$_GET['delete'];
  $query6=mysqli_query($db,"delete from catagory where id='$del_id'");
  header('location:catagory.php');
}

// edit
if(isset($_GET['edit'])){

  $edit_id=$_GET['edit'];
  $query7=mysqli_query($db,"select * from catagory where id='$edit_id'");

  
  $edit_result=mysqli_fetch_assoc($query7);
}

$error=array();

if(isset($_POST['Add_cat'])&& !empty($_POST)){
  $pparent=sanitize($_POST['parent']);
  $cat=sanitize($_POST['catagory']);
  if($cat=='')
  {
    $error[]='<span class="glyphicon glyphicon-info-sign"></span> catagory cant be blank';
  }
$query3=mysqli_query($db,"select * from catagory where catagory='$cat'  AND parent='$pparent'");
if(isset($_GET['edit']))
{
  $edit_id=$_GET['edit'];
  $query3=mysqli_query($db,"select * from catagory where catagory='$cat'  AND parent='$pparent'  AND id !='$edit_id'");

}
if(mysqli_num_rows($query3)>0)
{
   $error[] ='<span class="glyphicon glyphicon-info-sign"></span> '. $cat."  is already exist in catagory list";
}
  if(!empty($error)){

    $display=display_error($error);?>
    <script>
    jQuery('document').ready(function(){
      jQuery('#error').html('<?php echo  $display?>');
    })
    </script>


    <?php

  }


else
{
  $query4="insert into catagory (catagory,parent ) values('$cat','$pparent')";

if(isset($_GET['edit']))
{ $edit=$_GET['edit'];
  $query4="update catagory set catagory='$cat' ,parent='$pparent' where id='$edit'";
}
$rslt=mysqli_query($db,$query4);
header('location:catagory.php');


}

}



$cat_value="";
$parent_id=0;
if(isset($_GET['edit']))
{
$cat_value=$edit_result['catagory'];
$parent_id=$edit_result['parent'];
}
else{
  if(isset($_POST['brand'])){ 
    $cat_value=$cat;

  $parent_id= $pparent;
}

}
?>
<h2 class="text-center"> Catagories</h2> <hr>
<div class="row">
<!--form-->
<div class="col-md-6">
<legend><?php  echo ((isset($_GET['edit'])?'Edit':'Add')); ?> catagory</legend>
<div id="error"></div>
<form class="form" action="catagory.php<?php  echo ((isset($_GET['edit'])?'?edit='.$edit_id:'')); ?>" method="post">
<div class="form-group">
<select  name="parent" class="form-control" required="required">

  <option value="0"<?php echo (($parent_id==0? 'selected="selected"':''));?> >parent</option>
  <?php

  $query2=mysqli_query($db,"select * from catagory where parent=0");
  while ($row=mysqli_fetch_assoc($query2)) {
    ?>

    <option value="<?php echo $row['id']; ?>"<?php echo (($parent_id==$row['id']? 'selected="selected"':'')) ;?> > <?=$row['catagory'] ;?> </option>
   
<?Php  }
  ?>
</select>
  
</div>

  
  <div class="form-group">
  <input type="text" name="catagory" id="catagory"  value="<?php echo $cat_value; ?> " class="form-control" placeholder="catagory">
  </div>

  <div class="form-group">
 
  <input type="submit" name="Add_cat" value="<?php echo ((isset($_GET['edit'])?'Edit':'Add'));?> catagory" class="btn btn-success" placeholder="catagory">
 
  </div>


</form>
</div>

<!-- catagories-->
<div class="col-md-6">
  <table class="table table-bordered">
  	<thead>
  	
  		<th>
  		catagory
  		</th>
  		<th>
  		parent
  		</th>
  		<th>
  		</th>


  	</thead>

  	<tbody>
    <?php 

    $query=mysqli_query($db,"select *  from catagory where parent=0");
  	 while($parent=mysqli_fetch_assoc($query)) : 


  	$parent_id=$parent['id'];

  	?>
  		<tr class="bg-primary">
         <td> <?php echo  $parent['catagory']; ?></td>
         <td> parent </td>
     <td>  <a href="catagory.php?edit=<?php echo $parent['id'] ; ?>" class="btn btn-lg-small btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
      <a href="catagory.php?delete=<?php echo $parent['id'] ;  ?>" class="btn btn-xs-small btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
      </td>
        
  		 </tr>
  		 <?php  $query1=mysqli_query($db,"select * from catagory where parent='$parent_id' ");
  		 while($child=mysqli_fetch_assoc($query1)):
  		 	?>
  		 <tr class="bg-info">
  		 	<td><?php echo $child['catagory'] ?></td>
  		 	<td><?php echo $parent['catagory'] ?></td>
  		 	<td> <a href="catagory.php?edit=<?php echo $child['id'];?>" class="btn btn-lg-small btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
  		 	 <a href="catagory.php?delete=<?php echo $child['id'];?>" class="btn btn-xs-small btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>



  		 </tr>

<?php endwhile;


endwhile;
 ?>
  	</tbody>


  </table>



 </div>
</div>
<?php 

include'include/footer.php';

?>