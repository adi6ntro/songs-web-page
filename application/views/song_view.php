<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!-- start header search area -->
	<section id="detail_song_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="detail_song_area_container">
						<div class="single_music_item">
							<div class="image_box">
								<?php $picture = $this->songs_model->get_songs_picture($row->id);?>
								<div class="swiper-container swiper1">
									<div class="swiper-wrapper">
										<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
										<div class="swiper-slide text-center">
											<img class="img-fluid pic-songs-shadow" style="height: 250px;width: 250px;"
											src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
										</div>
										<?php }} else { ?>
										<div class="swiper-slide text-center">
											<img class="img-fluid pic-songs-shadow" style="height: 250px;width: 250px;" 
											src="https://www.kindpng.com/picc/m/623-6236350_profile-icon-png-white-clipart-png-download-windows.png" alt="No Image">
										</div>
										<?php } ?>
									</div>
									<div class="swiper-pagination" style="position: unset;margin-top: 20px;"></div>
									<div class="swiper-button-prev"></div>
									<div class="swiper-button-next"></div>
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
									<input class="star" type="checkbox" title="bookmark page" <?php if ($this->session->userdata('logged_in')){ echo ($row->fav_status == 'active')?'checked':''; } ?> onclick="set_favorite(this,<?php echo $row->id;?>)">
								</div>
								<div class="song_main_language">
									<h4><?php echo $row->language; ?></h4>
								</div>
								<div class="song_source">
									<?php $source = $this->songs_model->get_source($row->id);?>
									<?php foreach($source as $web) { ?>
									<a href="<?php echo $web->source_url; ?>"><img style="height: 40px;" src="<?php echo base_url().'assets/img/'.$web->picture; ?>"></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
	<!-- start music list main area -->
	<section id="summary_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="summary_area_container">
						<p><?php echo $row->lyrics; ?></p>
						<button onclick="readmore()" id="readmore">Read more</button>
						<a href="<?php echo $row->source_url_lyrics; ?>"><?php echo $row->source_name_lyrics; ?></a>
					</div>
					<div class="summary_area_container">
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php if ($this->session->userdata('logged_in')){ ?>
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center">
						<p>NOTES</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="music_list_main_area_container" id="load_data">
						<div class="single_music_item">
						<p><?php echo $row->note; ?></p>
						<a href="<?php echo base_url(); ?>" class="btn btn-swal2-cancel">CREATE NEW</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
	<!-- end music list main area -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center" style="padding:6px 10px 3px;">
						<p style="font-size:12px">OTHER SONGS OF THE ARTIST <?php echo ($lang == '')?'':'IN '.strtoupper($lang); ?></p>
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
				<div class="col-12 mx-auto">
					<div class="music_list_main_area_container" id="load_data">
						<?php foreach($songs as $row) { ?>
						<a href="<?php echo base_url().'songs/'.$row->id.'?lang='.rawurlencode($lang_id).'&song=artist';?>">
							<div class="single_music_item">
								<div class="image_box">
									<?php $picture = $this->songs_model->get_songs_picture($row->id);?>
									<div class="swiper-container swiper2">
										<div class="swiper-wrapper swiper-wrapper-custom">
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
										<input class="star" type="checkbox" title="bookmark page" <?php if ($this->session->userdata('logged_in')){ echo ($row->fav_status == 'active')?'checked':''; } ?> onclick="set_favorite(this,<?php echo $row->id;?>)">
									</div>
									<div class="song_main_language">
										<h4><?php echo $row->language; ?></h4>
									</div>
								</div>
							</div>
						</a>
						<?php } ?>
					</div>
					<?php if ($is_load == 'yes') { ?>
					<div id="load_data_message" style="text-align: center;margin-bottom: 10px;">
						<a class='btn btn-loadmore' id="loadMore" onclick="load_more_songs('artist',<?php echo $limit; ?>,<?php echo $start_limit; ?>);"><i class='fa fa-caret-down' aria-hidden='true'></i> More Songs...</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->
	<section id="filter_name">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="filter_name_container text-center" style="padding:6px 10px 3px;">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto py-4">
					<div class="text-center mb-2 mx-5">
						<a href="<?php echo ($next == 0)?"javascript:void(0)":base_url().'songs/'.$next.'?lang='.rawurlencode($lang_id).'&song='.rawurlencode($song); ?>" class="btn btn-direction-song">NEXT</a>
						</div>
						<div class="text-center mb-2 mx-5">
						<a href="<?php echo ($prev == 0)?"javascript:void(0)":base_url().'songs/'.$prev.'?lang='.rawurlencode($lang_id).'&song='.rawurlencode($song); ?>" class="btn btn-direction-song">BACK</a>
						</div>
						<div class="text-center mb-2 mx-5">
						<a href="<?php echo base_url(); ?>" class="btn btn-direction-song">HOME - SEARCH</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- start footer top -->
	<section id="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="footer_top_container">
						<?php if (!$this->session->userdata('logged_in')) { ?>
						<a href="<?php echo base_url().'signup'; ?>">
							<div class="footer_top_content">
								<h3>Create Account</h3>
							</div>
						</a>
						<?php } ?>
						<a href="<?php echo ($this->session->userdata('logged_in'))?base_url().'selected':base_url().'login';?>">
							<div class="footer_top_content">
								<h3>Selected Songs</h3>
							</div>
						</a>
						<a href="javascript:void(0)">
							<div class="footer_top_content">
								<h3>Frequent Questions</h3>
							</div>
						</a>
						<a href="javascript:void(0)">
							<div class="footer_top_content">
								<h3>Contact</h3>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end footer top -->
