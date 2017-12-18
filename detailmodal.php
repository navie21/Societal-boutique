<?php
 
include'../core/init.php';
echo $cart_id;
$id=$_POST['id'];
$id=(int)$id;
$que=mysqli_query($db,"select * from product where id='$id'");
$product=mysqli_fetch_array($que);
$que2=mysqli_query($db,"select *  from brand where id=".$product['brand']);
$brand=mysqli_fetch_array($que2);
$sizestring=$product['size'];
$sizestring=rtrim($sizestring,",");

$size_array=explode(',', $sizestring);

?>
<?php ob_start(); ?>

<div   class="modal fade  details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1">
  <div class="moda-dialog modal-lg">
  <div class="col-md-2"> </div>
  <div class="modal-content col-md-8 center-block text-center">

     <div class="modal-header">
        <button class="close" type="button" onclick="closeModal()" aria-label="close" >
        <span aria-hidden="close" >&times;</span></button>
        <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>

        </div>
        <div class="modal-body ">
         <div class="container-fluid">
           <div class="row">
            <span id="modal-error" class="bg-danger"></span>
               <div class="col-sm-8 fotorama">

                  
                  
                  <?php  $photos=explode(',',$product['image']);
                  foreach ($photos as $photo) {
                   
                  ?>
                   <div class="center-block ">
                  <img src="<?php echo $photo; ?>" width="175" height="200" alt="<?php echo $product['title']; ?>">
                   </div>
                   <?php } ?>
               
                 
                  </div>
                  
                  <div class="col-sm-3 ">
                  <h4>Details</h4>
                  <p> <?php echo $product['description'] ;?></p>
                  <hr>
                  <p> price:Rs <?php  echo $product['price'];?>/-</p>
                  <p> brand:<?php echo $brand['brand']; ?> </p>
                  </div>
                  <form action="/include/add_cart.php" method="post" id="add-form">
                   <input type="hidden" name="product_id" value="<?= $id; ?>">
                  <input type="hidden" name="availble" id="availble" value="" >
                  	<div class="form-group">
                  	<div class="col-xs-3">
                  	<label for="quantity"> quantity:</label>
                  	<input type="number" class="form-control" id="quantity" name="quantity" min="0" ></div>
                  	
                  	</div>
                    

                  	<div class="form-group col-sm-6">
                  	<label for="size"> Size:</label>
                  	<select name="size" id="size" class="form-control">
                  	<option >choose</option>
                    <?php foreach ($size_array as $string ) {
                      $string_array=explode(':',$string);
                      $size=$string_array[0];
                      $availble=$string_array[1];

                    
                       echo '<option value="'.$size.'" data-availble="'.$availble.'">'.$size.'('.$availble.' Availble)</option>';
                      # code..

                    }

                    ?>
                  	
                  	</select>
                  	</div>


                  	</div>
                  </form>

             </div>
            </div>
             
            
            <div class="modal-footer">
            <button class="btn btn-default" onclick="closeModal()">close</button>
            <button type="submit" class="btn btn-warning" onclick="add_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"> Add to cart</span> </button>

            </div>
            <div class="col-md-2"></div>

   </div>
   </div>
   </div>
   </div>
  <script>
 
 $(function () {
  $('.fotorama').fotorama();
});
     jQuery("#size").change(function()
    {
      var availble=jQuery("#size option:selected").data("availble");
      jQuery("#availble").val(availble);

 
  });


 

    function closeModal(){
    $('#details-modal').modal('hide');
   
    setTimeout(function(){
     $('#details-modal').remove();
   $('.modal-backdrop').remove();
   },500);
  }


  </script>

<?php echo ob_get_clean(); ?>