<?php 
$q1=mysqli_query($db,"select * from catagory where  parent=0");
 ?>
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">
<a href="index.php" class="navbar-brand" > SOCIETAL'S BOUTIQUE </a>
<ul class="nav navbar-nav">
<?php while($row=mysqli_fetch_assoc($q1)){
	
	 $pid= $row['id'];
 $q2=mysqli_query($db,"select * from catagory where parent='$pid'");

     ?>
	<li class="dropdown">
	


	<a href="#8"  class="dropdown-toggle" data-toggle="dropdown"><?php echo $row['catagory']; ?><span class="caret"></span> </a>
	<ul class="dropdown-menu" role="menu">

	<?php 

     
      while($child=mysqli_fetch_assoc($q2)){
      

	?>
  
	<li> <a href="catagory.php?cat=<?= $child['id'];?>" > <?php echo $child['catagory'];  ?> </a></li> 

	<?php } ?>



	</ul>
	</li>
	<?php } ?>

<li style="margin-top: 5px; margin-left: 10px" >
<form class="form-group" method="get" action="">
<input type="text" name="search" style="{
border:2px solid #b3b3b3;
background:#dddddd;
width:400px;
border-radius:35px;
-moz-border-radius:25px; 
-moz-box-shadow:    1px 1px 1px #ccc;
-webkit-box-shadow: 1px 1px 1px 1px #ccc;
 box-shadow:         1px 2px 2px 2px #ccc;
 margin-top: 5px;
" class="form-control" size="40" placeholder="search " >

</li>
<li style="margin-top: 5px;"><button  name="search-button" class="btn btn-xs-small btn-default"><span class="glyphicon glyphicon-search"> 
</span>
</button></li></form>


<li>
<a href="cart.php" style="text-decoration: none"><span class="glyphicon glyphicon-shopping-cart">  Mycart</span></a>
</li>

	</ul>
	</div>
	</nav>
		