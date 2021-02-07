<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3><?php echo $username; ?></h3>
						<h5>ACCOUNT</h5>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h3>CHANGE PASSWORD</h3>
						<form id="change_pass">
							<div class="form-group">
								<input type="password" name="password" placeholder="Enter New Password" id="password" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="change_password()" class="btn btn-swal2-confirm">CHANGE</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h3>CHANGE USERNAME</h3>
						<form id="change_user">
							<div class="form-group">
								<input type="text" name="username" placeholder="Enter New Username" id="username" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="change_username()" class="btn btn-swal2-confirm">CHANGE</button>
							</div>
						</form>
					</div>
					<hr style="margin: 1rem 2rem;border-top: 3px solid rgba(0,0,0,.1);">
					<div class="login_form_area_container">
						<h3>DELETE ACCOUNT</h3>
						<div style="text-align:center">
							<button type="button" class="btn btn-swal2-confirm" onclick="delete_account()">CHANGE</button>
						</div>
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
						<div class="footer_top_content text-center">
							<h3>Frequent Questions</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end footer top -->
