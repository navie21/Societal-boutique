

<footer class="text-center">&copy;copyright 2016-17 is reserved Naveen's Boutique </footer>



<script>
	$(window).scroll(function(){
		var scrol=$(this).scrollTop();
		console.log(scrol);

	})


	function detailmodal(id){
		var data={"id":id};
		jQuery.ajax({


			url:"include/detailmodal.php",
			method:"post",
			data:data,
			success:function(data){
				jQuery('body').append(data);
				jQuery('#details-modal').modal('toggle');
			},
			error:function(){
				alert('something went wrong');
			},
		});
	}

function update_cart(node,edit_id,edit_size)
{ var data={'node':node,'edit_id':edit_id,'edit_size':edit_size};
 jQuery.ajax({
 	


			url:"include/update_cart.php",
			method:"post",
			data:data,
			success:function(data){
				location.reload();
			},
			error:function(){
				alert('something went wrong');
			},
 })


}


	function add_cart(){

		jQuery('#modal-error').html("");

var size=jQuery("#size").val();
	var quantity=jQuery("#quantity").val();
	var availble=jQuery("#availble").val();
	var error="";
	var data=jQuery("#add-form").serialize();


	if(size=="choose" || quantity==0 || quantity=="")
	{
		error+="<p class='text-danger'>you must choose a size and quantity</p>";
	
jQuery("#modal-error").html(error);

return;
}

else if(quantity>availble){

error+=" <p class='text-danger'><span class='glyphicon glyphicon-info-sign'></span>there are only "+availble+"</p>";
jQuery("#modal-error").html(error);
return;
}

else
{
	jQuery.ajax({
		url:"include/add_cart.php",
		type:"post",
		data:data,
		success:function(){
			location.reload();
		},
		error:function(){

			alert("something went wrong");
		}
	});
}


}
</script>
