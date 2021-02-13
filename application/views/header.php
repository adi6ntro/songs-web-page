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
	<!-- <script src="https://use.fontawesome.com/c2f2b417aa.js"></script> -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawsome.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?v=2021">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css?v=2021">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/swiper-bundle.min.css">
	<!-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" /> -->
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.14.0/dist/sweetalert2.min.css'>
	<!-- this is for mordanizar js link -->
	<script src="<?php echo base_url();?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
</head>

<body>
	<style>
		<?php if ($this->uri->segment(1) == 'songs') { ?>
		#more {display: none;}
		.pic-songs-shadow {
			-moz-box-shadow:    7px 3px 18px 5px #ccc;
			-webkit-box-shadow: 7px 3px 18px 5px #ccc;
			box-shadow:         7px 3px 18px 5px #ccc;
		}
		.swiper-wrapper-custom {
			width: 80px;
			padding-top: 1px;
		}
		<?php } else { ?>
		.swiper-wrapper {
			width: 80px;
			padding-top: 1px;
		}
		<?php } ?>
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
						<a href="javascript:void(0)" class="hello"><i class="fa fa-user-alt" aria-hidden="true"></i> Hello, <span id="h-username"><?php echo $this->session->userdata('logged_in')['username'];?></span></a>
						<hr style="margin: 0px 0 7px;">
						<a href="<?php echo base_url();?>myaccount">My Account</a>
						<a href="<?php echo base_url();?>logout">Log Out</a>
						<hr style="margin: 0px 0 7px;">
						<a href="<?php echo base_url();?>">Home</a>
						<a href="<?php echo base_url();?>selected">Selected Songs</a>
						<?php } else { ?>
						<a href="<?php echo base_url();?>">Home</a>
						<hr style="margin: 0px 0 7px;">
						<?php } ?>
						<a href="<?php echo base_url();?>">Frequent Questions</a>
						<a href="<?php echo base_url();?>">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header top area -->
	<div class="open-menu">
	<?php if (!$this->session->userdata('logged_in')) { ?>
	<section id="header_menu_login_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="header_menu_login_area_container">
						<a href="<?php echo base_url();?>login" class="btn btn-menu-login">Log in</a>
						<a href="<?php echo base_url();?>signup" class="btn btn-menu-signup">Sign up</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
