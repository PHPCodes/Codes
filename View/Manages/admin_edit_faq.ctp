<script type="text/javascript">
$(document).ready(function(){
	var validator = $("#frm").click(function(){
			tinyMCE.triggerSave();
			}).validate({
					ignore: "",
					errorPlacement: function(label, element) {
					if (element.is("textarea")) {
						label.insertAfter(element.next());
					} else {
						label.insertAfter(element)
					}
				}
				
	  		});
	  validator.focusInvalid = function() {
			// put focus on tinymce on submit validation
			if( this.settings.focusInvalid ) {
				try {
					var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
					if (toFocus.is("textarea")) {
						tinyMCE.get(toFocus.attr("id")).focus();
					} else {
						toFocus.filter(":visible").focus();
					}
				} catch(e) {
					// ignore IE throwing errors when focusing hidden elements
				}
			}
		}
});
	
  tinyMCE.init({
		// General options
		mode : "specific_textareas",
		theme : "advanced",
		editor_selector : "tinymce",
		plugins : "pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave, ccSimpleUploader,safari,pagebrea",
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
        relative_urls : false,

		file_browser_callback: "ccSimpleUploader",
		plugin_ccSimpleUploader_upload_path: '../../../../uploads',                 
		plugin_ccSimpleUploader_upload_substitute_path: '/uploads/',
		// Style formats
		style_formats : [
		{title : "Bold text", inline : "b"},
			{title : "Red text", inline : "span", styles : {color : "#ff0000"}},
			{title : "Red header", block : "h1", styles : {color : "#ff0000"}},
			{title : "Example 1", inline : "span", classes : "example1"},
			{title : "Example 2", inline : "span", classes : "example2"},
			{title : "Table styles"},
			{title : "Table row 1", selector : "tr", classes : "tablerow1"}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
		
		
	});	

</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#frm').validate();
});
</script>
<div id="page-layout">
	<div id="page-content">
		<div id="page-content-wrapper">
        	<a href="javascript:void(0)" onClick="history.go(-1)" class="ui-state-default ui-corner-all float-right ui-button">Back</a>
			<div class="inner-page-title">
				<h2>Edit FAQ</h2>
               <span></span>
			</div>
            <form id="frm" method="post" enctype="multipart/form-data" action="<?php echo HTTP_ROOT.'admin/Manages/edit_faq/'.base64_encode(convert_uuencode($id))?>">
              <fieldset>
            <div class="content-box content-box-header" style="border:none;">
					<div class="column-content-box">
            
            <div class="ui-state-default ui-corner-top ui-box-header">

                <span class="ui-icon float-left ui-icon-notice"></span>

                Edit FAQ
            </div>
            
            <div class="content-box-wrapper">
            	<input type="hidden" id="mem_id" value="<?php echo $id; ?>" />
                
                <ul>
                <li>
							<label class="desc">Faq Type<em>*</em></label>
							<div>
								<select class="field text full required" name="data[Faq][faq_type]" style="padding:3px;" >
						   	<option  <?php if($faqs['Faq']['faq_type']=="customer"){ echo 'selected="selected"'; } ?>>Customer</option>   
						   	<option <?php if($faqs['Faq']['faq_type']=="supplier"){ echo 'selected="selected"'; } ?>>Supplier</option>   
						   						
							</select>
							</div>
						  </li>
						  <li>
                    <label class="desc">Order<em>*</em>(Enter float number like 1.001 )</label>
                    <div>
                      
					     <input class="field text full required" name="data[Faq][order]" value="<?php echo $faqs['Faq']['order'];?>" >
                    </div>
                  </li>
                    <li>
                    <label class="desc">Question<em>*</em></label>
                    <div>
                      
					  <textarea  class="field text full required" name="data[Faq][question]" ><?php echo $faqs['Faq']['question'];?></textarea>
                    </div>
                  </li>
                  
                  
				  <li>
                    <label class="desc">Answer<em>*</em></label>
                    <div>
                      <textarea  class="field text full required tinymce" name="data[Faq][answer]" ><?php echo $faqs['Faq']['answer'];?></textarea>
                    </div>
                  </li>
                 
                </ul>
              
          </div> <!-- end of content box wrapper -->
            
            </div>
            </div>
            
              <li>
                <input class="submit sub-bttn" type="submit" value="Submit"/>
              </li>
            </fieldset>
            </form>
            
			<div class="clearfix"></div>

			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>