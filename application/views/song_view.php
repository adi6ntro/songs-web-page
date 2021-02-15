<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<section id="detail_song_area" style="
		padding: 10px 0px 0px 0px;
		background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="detail_song_area_container" style="padding: 13px 10px 0px;">
						<div class="single_music_item">
							<div class="image_box">
							<?php $picture = $this->songs_model->get_songs_picture($row->id);?>
								<div class="swiper-container swiper1">
									<div class="swiper-wrapper">
										<?php if(!empty($picture)) { foreach($picture as $pic) { ?>
										<div class="swiper-slide text-center">
											<img class="img-fluid pic-songs-shadow" style="height: 209px;width: 209px;"
											src="<?php if (strpos($pic->url_path, 'http') !== false) echo $pic->url_path; else echo base_url().'assets/img/'.$pic->url_path; ?>" alt="<?php echo $pic->pic_name; ?>">
										</div>
										<?php }} else { ?>
										<div class="swiper-slide text-center">
											<img class="img-fluid pic-songs-shadow" style="height: 209px;width: 209px;" 
											src="https://www.kindpng.com/picc/m/623-6236350_profile-icon-png-white-clipart-png-download-windows.png" alt="No Image">
										</div>
										<?php } ?>
									</div>
									<div class="swiper-pagination" style="position: unset;margin-top: 3px;"></div>
									<div class="swiper-button-prev"></div>
									<div class="swiper-button-next"></div>
								</div>
							</div>
							<div class="content_box">
								<div class="song_name" style="
									text-align: center;
									margin-top: 7px;
									font-weight: 800;
									font-size: 20px
								">
									<?php echo $row->song; ?>
								</div>
								<div class="song_subname" style="
									text-align:center;
									margin-top: 2px;
									font-size:12px">
									<p style="color: #7E8083;"><?php echo $row->subname; ?></p>
								</div>								
								<div class="geners" style="
									text-align: center;
									margin-top: 3px;
									font-weight: 700;
									font-size: 12px;
								">
									<p <?php if($row->color != "") { ?> 
										style="color:<?php echo $row->color; ?>" <?php } ?> >
										<?php echo $row->genre; ?>
									</p>
								</div>
								<div class="song_details" style="
									text-align: center;
									margin-top: 1px;
									font-size: 18px;
									font-weight: 300;
								">
									<p><?php echo $row->artist; ?> 
									<span style="color: green;font-size:12px;font-weight:600;">&nbsp(<?php echo $row->country; ?>)</span>
									</p>
								</div>
								<div class="year_instrument" style="
									display: flex;
									justify-content: center;
									margin-top: 2px;
									font-size: 14px;
									font-weight: 600;
								">
									<div style="width: 100%;margin: 0 10px;text-align: <?php echo ($row->instrument != "")?'right':'center'; ?>;">
										<?php echo $row->year; ?>
									</div>
									<?php if ($row->instrument != ""){ ?>
									<div style="color: orange;width: 100%;margin: 0 10px;">
										<?php echo $row->instrument; ?>
									</div>
									<?php } ?>
								</div>
								<div class="song_main_language_2" style=" 										
									display: flex;
									justify-content: center;
									margin-top: 2px;
									font-size: 18px;
									font-weight: 600;
								">
									<div style="width: 100%;margin: 0 10px;text-align: right;">
										<?php echo $row->language_name; ?>
									</div>
									<div style="font-size: 12px;font-weight: 400;width: 100%;margin: 0 10px;align-self: center;">
										(35 songs)
									</div>																	
								</div>
								<div class="favorite_song" style="text-align: center;margin-bottom: 30px;">
									<input class="star" type="checkbox" title="bookmark page" <?php if ($this->session->userdata('logged_in')){ echo ($row->fav_status == 'active')?'checked':''; } ?> onclick="set_favorite(this,<?php echo $row->id;?>)">
								</div>						
								<div class="song_source" style="text-align: center;padding: 2px 20px 0px;border-top: 1px solid #dadada;">
									<div class="more_information" style="padding: 1px 0px 7px;font-size:9px">
										<p style="color: #9FA1A4;">MORE INFORMATION:</p>
									</div>
									<?php $source = $this->songs_model->get_source($row->id);?>
									<?php foreach($source as $web) { ?>
									<a href="<?php echo $web->source_url; ?>" target="_blank"><img style="height: 33px;margin: 0px 3px 10px 3px;" src="<?php echo base_url().'assets/img/'.$web->picture; ?>"></a>
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
	<section id="summary_area" style="padding: 0px 0px 10px 0px;background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="summary_area_container" style="padding: 0px 10px;">
						<div class="lyrics" style="padding: 10px 20px;border-top: 1px solid #dadada;">
							<p class="truncate" id="lyrics"><?php echo $row->lyrics; ?></p>
							<?php if ($row->lyrics != "") { ?><a onclick="readmore()" id="readmore" style="color: #0056b3;text-decoration: none;">More...</a><?php } ?>							
							<br>
						</div>
						<div class="info" style="padding: 5px 20px;border-top: 1px solid #dadada;">
							<a href="<?php echo $row->source_url_lyrics; ?>"
							style="color: #0056b3;text-decoration: none;font-weight:700;font-size:16px"><?php echo $row->source_name_lyrics; ?></a>
						</div>
						<div class="info" style="padding: 0px 20px;border-top: 1px solid white;">
							<!-- <?php echo $row->info; ?> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
	<section id="notes_area" style="padding: 10px 0px 10px 0px;background: #fff;">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="notes_area_container" style="padding: 0px 20px 4px;">
						<?php if ($this->session->userdata('logged_in')){ ?>
						<div class="notes" id="notes" style="padding: 0px 10px 9px;<?php echo ($row->note == '')?'display:none;':'';?>">
							<p id="note" <?php echo ($row->note == '')?'style="display:none;"':'';?>>
							<?php echo $row->note; ?></p>
							<!-- <div id="note"></div> -->
							<textarea name="note" id="noteeditor" cols="30" rows="10" style="display:none;width:100%">
							<?php echo $row->note; ?></textarea>
							<br>
						</div>
						<div class="text-center">
							<a class="btn btn-notes" onclick="updatenotes()" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 4px 18px 1px;" id="updatenotes">
							<?php echo ($row->note == '')?'CREATE NEW':'EDIT';?></a>
							<a class="btn btn-notes" onclick="savenotes()" style="display:none;color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 4px 18px 1px;" id="savenotes">SAVE</a>
						</div>
						<?php } else { ?>
						<div class="text-center">
							<a class="btn btn-notes" href="<?php echo base_url().'signup/createnote';?>" style="color: #0056b3;
							background-color: white;border: 1px solid #0056b3;padding: 4px 18px 1px;">CREATE NEW</a>
						</div>
						<?php } ?>
					</div>
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
						<?php if (count($songs) > 0) { foreach($songs as $row) { ?>
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
						<?php }} else { ?>
							<div class="single_music_item justify-content-center text-center">
							No other songs for this artist.
							</div>
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
