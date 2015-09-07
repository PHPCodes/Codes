<script type="text/javascript">
	$(document).ready(function() {
		$(".submitLogin").on("click",function(){
			$('#AdminLogin').validate({
				rules: {
					"data[Member][log_email]": {
						required:true,
						email:true,
						remote:ajax_url+'suppliers/checkMemberEmailLog'
					},
					"data[Member][log_password]":
					{
						 required:true,
						 remote:
						 {  
		                url: ajax_url+'suppliers/checkMemberPasswordLog',
		                type: 'post',
		                data:
		                {
		                    'email': $('#login-username').val()
		                } 					    
						 } 
					    
					}
				},
				messages: {
					"data[Member][log_email]": {
						required:'Please enter email.',
						email:'Please enter valid email.',
						remote:'Email address does not exists.'
					},
					"data[Member][log_password]": {
						required:'Please enter password.',
						remote:'Incorrect password! Enter a valid password.'
					}, 
				}	
			});
		})
		var email = '<?php echo @$remEmailSup; ?>';
		var pass = '<?php echo @$remPassSup; ?>';
		if(email != '' && pass != '') { 
			$('.remcheck').prop("checked",true); 
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {	
		$('#forgot_form').validate({
			rules: {
					"data[Member][log_email]": {
						required:true,
						email:true,
						remote:ajax_url+'Suppliers/checkMemberEmailLog'
					}
				},
				messages: {
					"data[Member][log_email]": {
						required:'Please enter email.',
						email:'Please enter valid email.',
						remote:'Email address does not exists.'
					} 
				}	
			});
	
});
</script>
<!--  Modal content for the mixer image example -->
  <div class="modal fade pop-up-10" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true" id = "modal1">
    <div class="modal-dialog modal-md">
      <div class="modal-content forgot_content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          
        </div>
        <div class="modal-body forgot_body">
        		<div class="login_heading">
					<h1><span class=" glyphicon glyphicon-log-in"></span>Forgot Password</h1>
				</div>
			<form action="<?php echo HTTP_ROOT;?>Suppliers/forgot_password" id="forgot_form" method="post" novalidate="novalidate">
				<div class="left_login no_border">
					<!--<img src="images/or.png"/>-->
					<h3 class="text-center"></h3>
					<div class="col-lg-12 col-sm-12  col-md-12 col-xs-12 padding_0">
						<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
							<label style="color:#5cb85c;">E-mail</label>
						</div>
						<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
							<div class="form-group">
								<input type="text" value="" class="form-control " name="data[Member][log_email]">
								<span style="margin-left:0px !important; padding-left:0px !important; color:red" class="errAjax" id="err_email"></span>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-sm-8  col-md-8 col-xs-12 col-lg-offset-3 col-sm-offset-3 col-md-offset-3 ">
						<div class="login_btn">
							<input type="submit" value="Get Password" id="submitForgot" class="btn btn-success ">
						</div>
					</div>
				</div>
			</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal mixer image -->


<!-- login area -->
<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 padding_0">
	<div class="login_container">
		<div class="login_heading">
			<h1><span class=" glyphicon glyphicon-log-in"></span>Supplier sign in</h1>
		</div>
		<div class="marchant_login">
			<div id="loginbox" class="mainbox col-md-6 col-xs-12 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Sign In</div>
					</div>     
					<div class="panel-body">
						<form action="<?php echo HTTP_ROOT;?>Suppliers/login" id="AdminLogin" class="form-horizontal" role="form" method="post">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="login-username" type="text" class="form-control"  name="data[Member][log_email]" value="<?php echo @$remEmailSup;?>" placeholder="email">                                        
							</div>
							<div  class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="login-password" type="password" class="form-control" name="data[Member][log_password]" value="<?php echo @$remPassSup;?>" placeholder="password">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding_0 ">
								<a href="#" data-toggle="modal" data-target=".pop-up-10">Forgot Your Password?</a>
								<!--a href="<?php echo HTTP_ROOT;?>suppliers/forgot_password">Forgot Password?</a-->
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding_0 ">
								<div class="input-group margin_align">
									<div class="checkbox">
										<label>
										  <input  type="checkbox"  name="data[Member][check]" class="remcheck"> Remember me
										</label>
									</div>
								</div>
							</div>
							<div  class="form-group">
								<div class="col-sm-12 controls">
									<input id="btn-login" href="#" class="btn btn-success submitLogin" type="submit" value="Login" />
		
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="col-md-12 control">
								<div class="forget_password_merchant" >
									Don't have an account! <a href="<?php echo HTTP_ROOT;?>Suppliers/register">Sign Up Here</a>
								</div>
							</div>
						</div>  <!--<form>-->  
					</div>                     
				</div>  
			</div>
		</div>
	</div>
</div>
<!-- End login area -->