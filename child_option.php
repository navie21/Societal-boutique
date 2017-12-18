<?php
include'../core/init.php';
$parentId=$_POST['parent'];
$select=$_POST['selected'];
$childQ=mysqli_query($db,"select * from catagory where parent='$parentId' order by catagory");
ob_start();
?>
<option  value=''></option>
<?php
while($row=mysqli_fetch_assoc($childQ)){
?>
<option value="<?= $row['id'] ;?>"<?= (($select==$row['id'])?' selected':'') ;?> > <?= $row['catagory'] ;?></option>

<?php echo ob_get_clean(); } ?>