
<?php
include $_SERVER['DOCUMENT_ROOT'].'/shop/core/init.php';


 include'include/head.php'; 
 include'include/navigation.php' ; 

  include'include/partialheader.php' ; 
  $items='';
  $tax_rate=0.12;
    $grand_total="";
    $subtotal="";
  if($cart_id!='')
  {
  	$cartQ=mysqli_query($db,"select * from cart where id='{$cart_id}'");
  	$cartR=mysqli_fetch_assoc($cartQ);
  	$items=json_decode($cartR['items'],true);




  }

 ?>
<div class="col-md-12">
  <div class="row">

  <h2 class="text-center">My shopping cart</h2>

  <?php

  if($cart_id=='')
  {
?> 
<div class="bg-danger"> 
<p class="text-center text-danger">
 your's shooping cart is empty
</p>
</div>
<?php
  }
  else
  {

  ?>

  <table class="table table-bordered table-striped table-condensed">
  <thead><th>#</th><th>item</th><th>price</th><th>quantity</th><th>size</th><th>subtotal</th></thead>
  <tbody>
  	<?php
  	$i=1;
  	$item_count=0;
  	$subtotal=0;
   foreach ($items as $item) {
  $product_id=$item['id'];
  $pro_detailsQ=mysqli_query($db,"select  * from product where id='$product_id'");
  $pro_details=mysqli_fetch_assoc($pro_detailsQ);
  $sArray=explode(',',$pro_details['size']);
  foreach ($sArray as $sizestring) {
 
 $s=explode(':',$sizestring);
 if($s[0]==$item['size'])
 {
 	$availble=$s[1];
 }
  
  }


  ?>
<tr>
  <td><?php  echo $i++; ?> </td>
  <td><?php echo $pro_details['title'];?></td>
  <td><?php echo money($pro_details['price']);?></td>

   <td>

  <button class="btn btn-primary btn-small" onclick="update_cart('remove',<?= $product_id ;?>,<?= $item['size'] ;?>);">
  -</button>

  <?php echo           $item['quantity'];?>
  <?php if($item['quantity']<$availble)
  { ?>
 <button class="btn btn-primary btn-small" onclick="update_cart('add',<?= $product_id ;?>,<?= $item['size'] ;?>);">
  +</button>
  <?php }
  else
  {
  	 ?>
  	 <span class="text-danger">Max</span>
  	 <?php

  	}?>

  </td>
   <td><?php echo $item['size'];?></td>
   <td><?php echo money($pro_details['price'] * $item['quantity']);?></td>
     </tr>
    <?php
    $item_count+=$item['quantity'];
    $subtotal+=$pro_details['price'] * $item['quantity'];
   }
   $tax=$tax_rate*$subtotal;
   $tax=number_format($tax,2);
   $grand_total=$tax+$subtotal;
    ?>
   
  </tbody>
 
  </table>

  <legend>Totals</legend>
  <table class="table table-bordered table-condensed table-striped">
  	<thead class="totals-total-header">
  		<th>total items</th>
  		<th>Subtotal</th>
  		<th>Tax</th>
  		<th>Grand total</th>
  	</thead>
  	<tbody>
  		<tr>
     <td><?php echo $item_count ; ?></td>
     <td><?php echo money($subtotal); ?></td>
     <td><?php echo money($tax) ; ?></td>
     <td><?php echo money($grand_total); ?></td>

  		</tr>
  	</tbody>

  </table>
   <!-- check out modal-->
<button type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#checkoutModal">
  <span class=" glyphicon glyphicon-shopping-cart"></span> checkput >>
</button>

<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="#checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">User's Details</h4>
      </div>
      <div class="modal-body ">
       <div class="row">'

      
       	  <form action="thankyou.php" method="post" id="payment-form">
       	  <span class="bg-danger" id="payment-error"> </span>
       	    <div id="step1" style="">
            
       	      <div class="form-group col-md-6">
              <input type="hidden" name="tax" value=<?= $tax_rate; ?>>
              <input type="hidden" name="subtotal"  value=<?=$subtotal;?>>
               <input type="hidden" name="grand_total"  value=<?= $grand_total;?>>

              
       	    	<label for="full_name"> full Name:</label>
       	    	<input type="text" id="full_name" name="full_name" class="form-control">

       	      </div>
       	      <div class="form-group col-md-6">
            
       	    	<label for="email"> Email:</label>
       	    	<input type="email" id="email" name="email" class="form-control">

       	      </div>
       	       <div class="form-group col-md-6">
            
       	    	<label for="streetaddress1 "> street address1:</label>
       	    	<input type="text" id="streetaddress1" name="streetaddress1" class="form-control">

       	      </div>
 
          <div class="form-group col-md-6">
            
       	    	<label for="streetaddress2"> street address2:</label>
       	    	<input type="text" id="streetaddress2" name="streetaddress2" class="form-control">

       	      </div>
       	      <div class="form-group col-md-6">
            
       	    	<label for="city"> city:</label>
       	    	<input type="text" id="city" name="city" class="form-control">

       	      </div>


         <div class="form-group col-md-6">
            
       	    	<label for="state"> state:</label>
       	    	<input type="text" id="state" name="state" class="form-control">

       	      </div>
       	   <div class="form-group col-md-6">
            
       	    	<label for="zipcode">zip code:</label>
       	    	<input type="text" id="zipcode" name="zipcode" class="form-control">

       	     </div>

       	      <div class="form-group col-md-6">
            
       	    	<label for="country">country:</label>
       	    	<input type="text" id="country" name="country" class="form-control">

       	     </div>
       	  	</div>
       	  	<div id="step2"  style="display: none;">
       	  		<h2>Card Details</h2>

       	      <div class="form-group col-md-3">
            
       	    	<label for="Name on card ">Name On Card:</label>
       	    	<input type="text" id="noc" name="noc" class="form-control">

       	     </div>

       	      <div class="form-group col-md-3">
            
       	    	<label for="card_number">card number:</label>
       	    	<input type="text" id="card_number" name="card_number" class="form-control">

       	     </div>
       	      <div class="form-group col-md-3">
            
       	    	<label for="cvv">CVV:</label>
       	    	<input type="text" id="CVV" name="CVV" class="form-control">

       	     </div>
       	      <div class="form-group col-md-3">
            
       	    	<label for="Expiry_month">Expiry month:</label>
       	    	<select id="Expiry_month" name="Expiry_month" class="form-control">
       	    	<option value=""></option>
       	    	<?php for($i=1;$i<13;$i++){
       	    		?>
       	    		<option value="<?php echo $i; ?>"> <?= $i ;?></option>
       	    		<?php
       	    	}
       	    	?>

       	    	</select>

       	     </div>
       	       <div class="form-group col-md-3">
            
       	    	<label for="Expiry_year">Expiry year:</label>
       	    	<select type="number" id="Expiry_year" name="Expiry_year" class="form-control">
       	    	<option value=""></option>
       	    	<?php $yr=date("Y"); 
       	    	 for($i=0;$i<11;$i++)
       	    	{ ?>
       	    <option value="<?php $yr+$i ?>"><?= $yr+$i ;?></option>
       	    <?php

       	    	}
       	    	?>
       	    	</select>

       	     </div>



       	  	</div>
<button type="submit" class="btn btn-primary pull-right"  id='checkout' style="display: none" >Check out  </button>
         
       	  </form>
  
       </div>
       
      
      </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" onclick="checkaddress()"  id="next_button">Next</button>

         <button type="button" class="btn btn-primary" onclick="backaddress()"   id="back_button" style="display: none">Back</button>
          <button type="submit" class="btn btn-primary"  id='checkout' style="display: none" >Check out  </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  <?php

  }

  ?>

 
  </div>

</div>
<script>
function backaddress(){
	jQuery('#payment-error').html("");
    			jQuery('#step1').css('display','block');
    			jQuery('#step2').css('display','none');
    			jQuery('#next_button').css('display','block');
          jQuery('#pay').css('display','none');
    			jQuery('#back_button').css('display','none');
    			jQuery('#checkout').css('display','none');
    			
       jQuery("#checkoutModalLabel").html("shipping address Details");



}
	function  checkaddress(){
		var data={
		'full_name':jQuery("#full_name").val(),
        'email':jQuery("#email").val(),
        'streetaddress1':jQuery("#streetaddress1").val(),
        'streetaddress2':jQuery("#streetaddress2").val(),
        'city':jQuery("#city").val(),
        'state':jQuery('#state').val(),
        'zipcode':jQuery('#zipcode').val(),
        'country':jQuery('#country').val()
    }


    jQuery.ajax({
    	url:'include/checkaddress.php',
    	method:'POST',
    	data:data,
    	success:function(data){
    		if(data !='passed')
    		{
    			jQuery('#payment-error').html(data);
    			jQuery('#step1').css('display','none');
    			jQuery('#step2').css('display','block');
    			jQuery('#next_button').css('display','none');
          jQuery('#pay').css('display','block');
    			jQuery('#back_button').css('display','block');
    			jQuery('#checkout').css('display','inline-block');
    			jQuery("#checkoutModalLabel").html("card Details");



    		}

    		if(data=='passed')
    		{ 
    		


    		}

    	},
    	error:function()
    	{
    		alert('something went wrong');
    	}
    });



	}






///for thankyou.php












</script>

   <?php  include'include/footer.php' ; ?>
    
