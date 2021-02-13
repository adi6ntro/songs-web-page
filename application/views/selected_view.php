<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<!-- start header search area -->
	<section id="header_search_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="header_search_area_container">
						<h3>SELECTED SONGS</h3>
					</div>
					<hr style="margin: .5rem 0 0;">
				</div>
			</div>
		</div>
	</section>
	<!-- end header search area -->
	<!-- start music list main area -->
	<section id="music_list_main_area">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="music_list_main_area_container" id="load_data">
						<?php if (count($songs) > 0) { foreach($songs as $row) { ?>
						<a href="<?php echo base_url().'songs/'.$row->id.'?lang='.rawurlencode($lang_id).'&song='.rawurlencode($song);?>">
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
										<input class="star" type="checkbox" title="bookmark page" checked onclick="set_favorite(this,<?php echo $row->id;?>)">
									</div>
									<div class="song_main_language">
										<h4><?php echo $row->language; ?></h4>
									</div>
								</div>
							</div>
						</a>
						<?php }} else { ?>
							<div class="single_music_item text-center">
								No Selected Songs
							</div>
						<?php } ?>
					</div>
					<?php if ($is_load == 'yes') { ?>
					<div id="load_data_message" style="text-align: center;margin-bottom: 10px;">
						<a class='btn btn-loadmore' id="loadMore" onclick="load_more_songs('selected',<?php echo $limit; ?>,<?php echo $start_limit; ?>);"><i class='fa fa-caret-down' aria-hidden='true'></i> More Songs...</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end music list main area -->

	<!-- start footer top -->
	<section id="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<a href="<?php echo ($this->session->userdata('logged_in'))?base_url().'selected':base_url().'login';?>">
						<div class="footer_top_container" id="select-song-menu">
							<div class="footer_top_content text-center">
								<h3>Selected Songs</h3>
							</div>
						</div>
					</a>
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
