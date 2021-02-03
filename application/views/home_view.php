<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<title>Music Libery App</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
	<!-- this is for mordanizar js link -->
	<script src="<?php echo base_url();?>assets/js/vendor/modernizr-3.6.0.min.js"></script>
</head>

<body>
	<style>
		.swiper-wrapper {
			width: 77px;
		}
	</style>
	<!-- start header top area -->
	<header id="header_top">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
					<div class="header_top_container">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-4" style="padding-left: 15px;align-self: center;">
								<div class="logoarea">
									<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="24" width="27">
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-8">
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
				</div>
			</div>
		</div>
	</header>
	<!-- end header top area -->

	<!-- start header search area -->
	<section id="header_search_area">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
					<div class="header_search_area_container">
						<h3>Search language</h3>
						<form method="post" action="<?php echo site_url('home/search/language/');?>" id>
							<div id="simpleSearch">
								<input type="hidden" name="lang_id" id="lang_id">
								<input type="search" name="search" placeholder="Enter Language" autocapitalize="sentences" title="Cari di Wikipedia [ctrl-option-f]" accesskey="f" id="searchInput" autocomplete="off">
								<input type="submit" name="go" value="Lanjut" title="Search by language" id="searchButton" class="searchButton">
							</div>
						</form>
						<div class="style_name text-center">
							<p>POPULAR</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->

	<!-- start filter language name -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
					<div class="filter_name_container text-center">
						<p>LANGUAGE: <span><?php echo $lang; ?></span></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end filter language name -->

	<!-- start music list main area -->
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
					<div class="music_list_main_area_container" id="load_data">
						<!-- signle music item -->
						<?php foreach($songs as $row) { ?>
						<a href="#">
							<div class="single_music_item">
								<div class="image_box">
									<?php $picture = $this->songs_model->get_songs_picture($row->id);?>
									<div class="swiper-container">
										<div class="swiper-wrapper">
											<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
											<div class="swiper-slide">
												<img class="img-fluid" src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
											</div>
											<?php }} else { ?>
											<div class="swiper-slide">
												<img class="img-fluid" src="https://www.kindpng.com/picc/m/623-6236350_profile-icon-png-white-clipart-png-download-windows.png" alt="No Image">
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="content_box">
									<div class="song_name">
										<h4><?php echo $row->song; ?></h4>
									</div>
									<div class="geners">
										<ul>
											<li <?php if($row->color != "") { ?> 
											style="color:<?php echo $row->color; ?>" <?php } ?> >
											<?php echo $row->genre; ?>
											</li>
										</ul>
									</div>
									<div class="song_details">
										<p><?php echo $row->artist; ?> <span>(<?php echo $row->country; ?>)</span></p>
									</div>
									<div class="year_instoment">
										<ul>
											<li class="year_song"><?php echo $row->year; ?></li>
											<li class="instoment_song"><?php echo $row->instrument; ?></li>
										</ul>
									</div>
									<div class="favorite_song">
										<input class="star" type="checkbox" title="bookmark page">
									</div>
									<div class="song_main_language">
										<h4><?php echo $row->language; ?></h4>
									</div>
								</div>
							</div>
						</a>
						<?php } ?>
						<!-- signle music item -->
					</div>
					<div id="load_data_message" style="text-align: center;margin-bottom: 10px;"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->

	<!-- start footer top -->
	<section id="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
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
	<!-- start main footer -->
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-xl-9 col-lg-10 col-md-11 mx-auto">
					<div class="footer_container text-center">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="24" width="27" style="margin: 0px -3px;">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="24" width="27" style="margin: 0px -3px;">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="24" width="27" style="margin: 0px -3px;">
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- start main footer -->
	<!-- all javascript load here -->
	<script src="<?php echo base_url();?>assets/js/vendor/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script src="<?php echo base_url().'assets/js/vendor/jquery-ui.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/js/swiper-bundle.min.js'?>"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $( "#searchInput" ).autocomplete({
				source: "<?php echo site_url('home/get_autocomplete/?');?>",
				select: function(event, ui){
					$('#lang_id').val(ui.item.lang_id);
					$('#searchInput').val(ui.item.lang_name);
					$("form").submit();
				},
				focus: function(event, ui){
					$('#lang_id').val(ui.item.lang_id);
					$('#searchInput').val(ui.item.lang_name);
				}
            });

			var limit = <?php echo $limit; ?>;
			var start = <?php echo $start_limit; ?>;
			var action = 'inactive';
			function load_more_songs(limit, start){
				$.ajax({
					url:"<?php echo ($lang_id=="")?site_url('home/loadmore/'):site_url('home/loadmore/language/'.$lang_id);?>",
					method:"POST",
					data:{limit:limit, start:start},
					cache:false,
					success:function(data){
						$('#load_data').append(data);
						if(data == ''){
							$('#load_data_message').css("display","none");
							action = 'active';
						}else{							
							$('#load_data_message').html('<img src="<?php echo base_url();?>assets/img/Loading.gif" alt="Loading" height=100>');
							action = "inactive";
						}
					}
				});
			}

			if(action == 'inactive'){
				action = 'active';
				load_more_songs(limit, start);
			}
			$(window).scroll(function(){
				if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive'){
					action = 'active';
					start = start + limit;
					console.log(start);
					setTimeout(function(){
						load_more_songs(limit, start);
					}, 1000);
				}
			});
        });

		var swiper = new Swiper('.swiper-container', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			autoplay: {
			delay: 5500,
			disableOnInteraction: false,
			},
		});
	</script>
</body>

</html>
