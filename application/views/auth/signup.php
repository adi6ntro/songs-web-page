<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start header search area -->
	<section id="login_form_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="login_form_area_container">
						<h3 style="text-transform:none">
							<?php echo ($cek == 'cek')?'You need to have an account':'Having an account will allow you'; ?>
							<br>to save your selected songs
						</h3>
						<h3 style="text-transform:none;font-weight:400;margin-top:10px;margin-bottom:20px">
							To create an account just enter<br>
							a username and an email<br>
							to send you a password:
						</h3>
						<form method="post" id="signup">
							<div class="form-group">
								<label for="username">USERNAME</label>
								<input type="text" name="username" placeholder="Enter Username" id="username" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="email">EMAIL</label>
								<input type="email" name="email" placeholder="Enter Email" id="email" class="form-control" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="reemail">REWRITE EMAIL</label>
								<input type="email" name="reemail" placeholder="Enter Rewrite Email" id="reemail" class="form-control" autocomplete="off">
							</div>
							<div style="text-align:center">
								<button type="button" onclick="register()" id="send" class="btn btn-swal2-confirm">SEND</button><br><br>
								<a href="<?php echo base_url();?>" class="btn btn-swal2-cancel-light">CANCEL</a>
							</div>
						</form>
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
