<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3>SIGN IN</h3>
						<form method="post" action="<?php echo site_url('verify');?>" id="login">
							<div class="form-group">
								<label for="username">EMAIL</label>
								<input type="text" name="username" placeholder="Enter Email" id="username" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="password">PASSWORD</label>
								<input type="password" name="password" placeholder="Enter Password" id="password" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="submit" class="btn btn-swal2-confirm">SIGN IN</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h4 style="font-weight:400">FORGOT YOUR PASSWORD?</h4>
						<h4>RECOVER IT:</h4>
						<form method="post" action="<?php echo site_url('forgot');?>" id="forgot">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" placeholder="Enter Email" id="email" onkeydown="cancelEnter(event)" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="reset_password()" class="btn btn-swal2-confirm" id="forgotbtn">SEND MY PASSWORD</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div style="text-align:center">
						<a href="<?php echo base_url(); ?>" class="btn btn-swal2-cancel">GO BACK TO THE SITE</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
	<!-- start footer top -->
	<section id="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="footer_top_container">
						<a href="javascript:void(0)">
							<div class="footer_top_content">
								<h3>Frequent Questions</h3>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end footer top -->
