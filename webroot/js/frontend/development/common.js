var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/cybercoupon/";

$(document).ready(function(){


	//setTimeout( function() {$('.succ_msg').hide();}, 4*1000);
	//setTimeout( function() {$('.success').hide();}, 4*1000);
	//setTimeout( function() {$('.BaseStatus,.BaseError').hide();}, 4*1000);

 $(document).on('click','.BaseStatus,.BaseError',function(){
      $(this).remove();	/* 
		$('.succ_msg').hide();
		$('.success').hide();	
		$('.BaseStatus,.BaseError').hide();	 */
	})
	
	$(document).click(function(){
      $('.succ_msg').hide();
		$('.success').hide();	
		$('.BaseStatus,.BaseError').hide();	
	})
	
	
	
	$(document).on('click','#edit-1-b',function()
   {
			if($('#edit-1-email').is(':visible'))
				$('#edit-1-email').slideUp(500);
			else
				$('#edit-1-email').slideDown(500);
	})
	
	//$('.submit-linkbtn').click(function()
	$(document).on('click','.submit-linkbtn',function()
	{
		var referral_id=$(this).prev('input[type=hidden]').val();
		var $this=$(this);
		var referral_email=$('.referral_email').val();
		var referee_id=$('.referral_email').prev('input[type=hidden]').val();
		if(referral_email!='')
		{
			var email_valid=IsEmail(referral_email);
			if(email_valid)
			{
				$.ajax({
					type:"POST",
					url:ajax_url+'App/referral_link',
					data:{referral_email:referral_email,referee_id:referee_id,referral_id:referral_id},
					success:function(resp)
					{
						var response=resp.split('@@');
						//alert(response[0])
						//alert(response[1])	
						//alert(response[2])
						if(response[0]=='linksuccess')
						{
							 $('.referral_msg').show();
						 $('.referral_msg').html('<span style="color:#0A601D;">You have successfully linked to this user.<span>');
							$this.prev('input[type=hidden]').val(response[1]);
							$('.link_section').show();
						   $('.unlink_section').hide();
						   $('.link_section').children('span').children('span').html(response[2]);
						}
						else if(response[0]=='linkupdatesuccess')
						{
							 $('.referral_msg').show();
						 $('.referral_msg').html('<span style="color:#0A601D;">Your link has been updated successfully.<span>');
							$this.prev('input[type=hidden]').val(response[1]);
							$('.link_section').show();
						   $('.unlink_section').hide();
						   $('.link_section').children('span').children('span').html(response[2]);
						}
						else if(response[0]=='linkavailability')
						{
							 $('.referral_msg').show();
						 $('.referral_msg').html('<span style="color:#0A601D;">you have been successfully linked to '+response[1]+'.<span>');
							$('.referral_email').next('input[type=hidden]').val(1);
						}
						else
						{
							 $('.referral_msg').show();
						  $('.referral_msg').html(resp);
						  $('.referral_email').next('input[type=hidden]').val(0);
					 }
					}
				});
			}
			else
			{
				$('.referral_msg').show();
				$('.referral_msg').html('<span style="color:red;">Please enter valid referral email id.</span>');
			}
		}
		else
		{
			
			$.ajax({
				type:"POST",
				url:ajax_url+'App/referral_unlink',
				data:{referral_email:referral_email,referee_id:referee_id,referral_id:referral_id},
				success:function(resp)
				{	
					if(resp=='unlinksuccess')
					{
						$('.referral_msg').show();
						$('.referral_msg').html('<span style="color:#0A601D;">You have been successfully unlink.<span>');
						$this.prev('input[type=hidden]').val(0);
						$('.link_section').hide();
						$('.unlink_section').show();
					}
					else
					{					
						$('.referral_msg').show();
						$('.referral_msg').html(resp);
					}
				}
			});
		}
	})
	
	function IsEmail(email)
	{
      var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
		if (reg.test(email))
		   return true;
		else
		   return false;
	}     
	
	
	
});
