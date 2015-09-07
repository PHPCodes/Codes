<?php echo $this->element("admin_header"); ?>
<?php // echo $this->element("admin_topright"); ?>
<?php // echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->element("admin_rightsidebar"); ?> 
		<!-- Start right content -->
        <div class="content-page">
			<!-- Start Content here -->
            <div class="content">
            					<!-- Page Heading Start -->
				<div class="page-heading">
					<h1><i class='glyphicon glyphicon-user'></i> User Management</h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>User Management<i class='icon-right-open-2'></i>Right  Answers</h3> 	        		
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Right </strong> Answers </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<?php $count=1; foreach ($data as $info) { ?>
							<div class="widget-content padding">
								  <div class="form-group">
									<label><strong> Question </strong><strong> <?php echo $count.' :'; ?> </strong></label>
										<div><?php echo $info['Question']['question']; ?></div>
								  </div>
								  <div class="form-group">
									<label><strong>Options: </strong></label>
									<?php $i=1;  foreach ($info['Question']['Answer'] as  $ans) { ?>
									<div> <strong><?php echo $i; ?> </strong><?php echo $ans['answer'];  ?></div>
									<?php $i++; } ?>
									
								  </div>		
									<div class="form-group">
									<label><strong>Right Answer: </strong></label>
										<div>
										<?php 
											foreach ($info['Question']['Answer'] as  $ans) {
												if($ans['right_question'] == 1) {
													echo $ans['answer'];
												}
											}
										?>
										</div>
								  </div>	
								  <div class="form-group">
									<label><strong>Your Answer: </strong></label>
										<div>
										<?php 
											foreach ($info['Question']['Answer'] as  $ans) {
												if($ans['id'] == $info['QuestionAnswer']['answer_id']) {
													echo $ans['answer'];
												} 
											}
											if($info['QuestionAnswer']['answer_id'] == 0) {
												echo "Skip Question";
											}
										?>
										</div>
								  </div>	
							</div>
							<?php $count++; } ?>
						</div>
						
					</div>
				</div>
				
				            <!-- Footer Start -->
            <footer>
                Swimpedia &copy; 2015
                <div class="footer-links pull-right">
                	<a href="#">About</a><a href="#">Support</a><a href="#">Terms of Service</a><a href="#">Legal</a><a href="#">Help</a><a href="#">Contact Us</a>
                </div>
            </footer>
            <!-- Footer End -->			
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->

	</div>
	<!-- End of page -->
		<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>