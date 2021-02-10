<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->output->set_header('HTTP/1.0 200 OK');
$this->output->set_header('HTTP/1.1 200 OK');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
$this->output->set_header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');

?>
<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="UTF-8">
	<title>Music Libery App</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- Favicons -->
	<link rel="apple-touch-icon" href="<?php echo base_url();?>assets/img/favicons/apple-touch-icon.png" sizes="180x180">
	<link rel="icon" href="<?php echo base_url();?>assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="<?php echo base_url();?>assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/plugin/animate.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawsome.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?v=2021">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css?v=2021">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/swiper-bundle.min.css">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.14.0/dist/sweetalert2.min.css'>
	<!-- this is for mordanizar js link -->
	<script src="<?php echo base_url();?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
</head>

<body>
	<style>
		.swiper-wrapper {
			width: 80px;
			padding-top: 1px;
		}
		<?php if ($this->uri->segment(1) == 'signup') { ?>
		.swal2-popup {
			width: 25em !important;
		}
		<?php } ?>
	</style>
	<!-- start header top area -->
	<header id="header_top">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="header_top_container">
						<div class="row">
							<div class="col-2 dropdown pl-0">
								<div class="logoarea">
									<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="25" width="27">
								</div>
							</div>
							<div class="col-10 pr-0">
								<div class="right_style_chose text-right">
									<ul>
										<li class="active"><a href="<?php echo base_url();?>">Popular</a></li>
										<li>C</li>
										<li>F</li>
										<li>M</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="dropdown-content" id="myDropdown">
						<?php if ($this->session->userdata('logged_in')) { ?>
						<a href="<?php echo base_url();?>myaccount">My Account</a>
						<a href="<?php echo base_url();?>logout">Logout</a>
						<?php } else { ?>
						<a href="<?php echo base_url();?>signup">Sign Up</a>
						<a href="<?php echo base_url();?>login">Login</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header top area -->

