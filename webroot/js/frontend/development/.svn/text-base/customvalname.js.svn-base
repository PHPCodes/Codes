function ajax_formname(form,site_url,link_id){	

	var req = jQuery.post
	( 
		ajax_url+site_url, 
		jQuery('#' + form).serialize(), 
		function(html){
			//alert(html)
			//alert('hi')
			var explode = html.split("\n");
			var shown = false;
			var msg = '<b>You have errors in your form. Please check the following fields and try again:</b><br /><br /><ol>';
			var count=0;
			for ( var i in explode )
			{
				var explode_again = explode[i].split("|");
						
				if ($.trim(explode_again[0])=='error')
				{
					if ( ! shown ) {
						jQuery('#'+link_id).show();
					}
					
					shown = true;
					img=ajax_url+"/img/cross_icon.png";
					add_remove_class('ok','error',explode_again[1]);
					jQuery('#err_' + explode_again[1]).show();
					jQuery('#err_' + explode_again[1]).html(explode_again[2]);

					msg += "<li>" + explode_again[1] + "</li>";
					count++;
				}
				else if ($.trim(explode_again[0])=='ok') {
					
					img2=ajax_url+"/img/green-check_con.png";
					add_remove_class('error','ok',explode_again[1]);
					//jQuery('#err_' + explode_again[1]).html("<img src="+img2+">");
					jQuery('#err_' + explode_again[1]).html();
					jQuery('#err_' + explode_again[1]).hide();
				
				}
			}
			
			if (!shown)
			{
				
				jQuery('#' + link_id).html("Form submitted successfully");
				add_remove_class('error','success',link_id);
				jQuery('#' + link_id).show();
				//$('#'+form).submit();
				if(form != 'pynmt_chk4guest')
				{
					$('#'+form).submit();
				}
				/*else
				{
					$('#'+form).hide();
					$('#'+form).parent().next().children('.checkout-content').show();
				}*/
			}
			else {
				//jQuery('#error_next_message').show();	
				add_remove_class('success','error',link_id);
				jQuery('#' + link_id).html(msg + "</ol>");
				
				if(form=='signup_form')
				{
				var explode_scroll = explode[count].split("|");
				var slide=jQuery('#err_'+explode_scroll[1]).offset().top/2;
				$('html, body').animate({scrollTop:slide},'slow');
				}
			}
			
			req = null;
		}
	);
	
	return false; 
}

function add_remove_class(search,replace,element_id)
{
	if (jQuery('#' + element_id).hasClass(search)){
		jQuery('#' + element_id).removeClass(search);
	}
	jQuery('#' + element_id).addClass(replace);
}