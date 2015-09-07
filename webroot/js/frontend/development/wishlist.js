$(document).ready(function(){
	//--------- wishlist 
	$(document).on('click','.addWish',function(){
		//var deal_id = $('#dealId').val();
		$(this).addClass('ajax_loader');
		var t = $(this);
		var deal_id = $(this).attr('rel');
		$.ajax({
			type: 'POST',
			url: ajax_url+'Customers/add_to_wishlist/'+deal_id,
			success: function(msg)
			{
				if(msg=="success")
				{
						t.removeClass('ajax_loader');
						$('.add_fav'+deal_id).hide();
						$('.remove_fav'+deal_id).show();
				}
			}
		});
		return false;
	});
	//
	$(document).on('click','.removeWish',function(){
				//var deal_id = $('#dealId').val();
				$(this).addClass('ajax_loader');
				var t = $(this);
				var deal_id = $(this).attr('rel');
				$.ajax({
					type: 'POST',
					url: ajax_url+'Customers/del_wishlist/'+deal_id,
					success: function(msg)
					{
						if(msg=="success")
						{
								t.removeClass('ajax_loader');
								$('.add_fav'+deal_id).show();
								$('.remove_fav'+deal_id).hide();
						}
						
					}
				});
				return false;
	});
	
});
