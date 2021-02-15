<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $limit;
	public function __construct()
	{
		parent::__construct();
		$this->limit = 10;
	}

	public function index()
	{
		$data['songs']=$this->songs_model->get_all_songs($this->limit);
		$data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['lang']="ALL";
		$data['song']="";
		$data['lang_id']="";
		$data['artist']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function example()
	{
		$this->load->view('example_view');
	}

	function get_autocomplete($type){
        if (isset($_POST['term'])) {
			$term = $this->db->escape_str(trim(str_replace(" ","%",preg_replace('/\s\s+/', ' ', $this->input->post('term')))));
			$results = array();
			preg_match_all('/./u', $term, $results);
			$term = implode('%',$results[0]);

			if($type == 'language')
				$result = $this->songs_model->search_language($term,$this->input->post('song'));
			elseif($type == 'song')
				$result = $this->songs_model->search_song($term,$this->input->post('lang_id'));
			else
				$result = array();
			if (count($result) > 0) {
				foreach ($result as $row) {
					$arr_result[] = array(
						"value"=>$row->name, "id"=>$row->id, "name"=>$row->name
					);
				}
				echo json_encode($arr_result);
			}
        }
	}

	public function search($type)
	{
		if ($type != 'language' && $type != 'song')
			redirect('/', 'refresh');
		if ($type == 'language')
			if(!isset($_POST['lang_id']))
				redirect('/', 'refresh');
		if ($type == 'song')
			if (!isset($_POST['song_name']))
				redirect('/', 'refresh');
		$term = $this->db->escape_str(trim(str_replace(" ","%",preg_replace('/\s\s+/', ' ', $this->input->post('search')))));
		$results = array();
		$arr_where = array();
		$like = null;

		if ($type == 'language') {
			if (empty($_POST['lang_id'])) {
				$lang = $term;
				$data['lang']=filter_var($term, FILTER_SANITIZE_STRING);
				$data['lang_id']=filter_var($term, FILTER_SANITIZE_STRING);
				$type='language.name';
			} else if ($this->input->post('search') == "") {
				$data['lang']='ALL';
				$data['lang_id']='';
			} else {
				$lang = $this->input->post('lang_id');
				$data['lang']=filter_var($this->songs_model->get_by_id('language','id',$this->input->post('lang_id'))->name, FILTER_SANITIZE_STRING);
				$data['lang_id']=filter_var($this->input->post('lang_id'), FILTER_SANITIZE_STRING);
			}
			if ($this->input->post('search') != "")
				$arr_where[$type] = $lang;
			if ($this->input->post('song_name') != ""){
				$arr_where['songs.song'] = $this->input->post('song_name');
				$data['song'] = filter_var($this->input->post('song_name'), FILTER_SANITIZE_STRING);
			} else {
				$data['song'] = "";
			}
		} else if ($type == 'song') {
			if (empty($_POST['song_name'])) {
				$data['song']=filter_var($term, FILTER_SANITIZE_STRING);
				preg_match_all('/./u', $term, $results);
				$song = implode('%',$results[0]);
				$like = 'like|song';
			} else if ($this->input->post('search') == "") {
				$data['song']="";
			} else {
				$song = $this->input->post('song_name');
				$data['song']=filter_var($this->input->post('song_name'), FILTER_SANITIZE_STRING);
			}
			if ($this->input->post('search') != "")
				$arr_where[$type] = $song;
			if ($this->input->post('lang_id') != ""){
				$arr_where['language'] = $this->input->post('lang_id');
				$data['lang_id']=filter_var($this->input->post('lang_id'), FILTER_SANITIZE_STRING);
				$data['lang']=filter_var($this->songs_model->get_by_id('language','id',$this->input->post('lang_id'))->name, FILTER_SANITIZE_STRING);
			} else {
				$data['lang']='ALL';
				$data['lang_id']='';
			}
		}
		// $_SESSION['song']=$data['song'];
		// $_SESSION['lang_id']=$data['lang_id'];
		if (count($arr_where) == 0)
			$data['songs']=$this->songs_model->get_all_songs($this->limit);
		else
			$data['songs']=$this->songs_model->get_by_param($arr_where,$this->limit,0,$like);
		$data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$data['artist']="";
		// print_r($data);
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function loadmore()
	{
		if(isset($_POST["limit"], $_POST["start"], $_POST["selected"], $_POST["song"], $_POST["lang"]))
		{
			$arr = array();
			$results = array();
			if (in_array($this->input->post('selected'), array('selected','all','artist'))){
				if ($this->input->post('selected') == 'selected') {
					$songs=$this->songs_model->get_favorite($this->input->post('limit'),$this->input->post('start'));
				} else if ($this->input->post('selected') == 'all') {
					if ($this->input->post('lang') == '' && $this->input->post('song') == '') {
						$songs = $this->songs_model->get_all_songs($this->input->post('limit'),$this->input->post('start'));
					} else {
						if ($this->input->post('lang') != ''){
							$arr['language'] = $this->input->post('lang');
							$like = null;
						}
						if ($this->input->post('song') != '') {
							$term=filter_var($this->input->post('song'), FILTER_SANITIZE_STRING);
							preg_match_all('/./u', $term, $results);
							$arr['song'] = implode('%',$results[0]);
							$like = 'like|song';
						}
						$songs = $this->songs_model->get_by_param($arr,$this->input->post('limit'),$this->input->post('start'),$like);
					}
				} else if ($this->input->post('selected') == 'artist') {
					$arr['songs.artist'] = $this->input->post('song');
					if ($lang != '')
						$arr['language'] = $this->input->post('lang');
					$songs = $this->songs_model->get_by_param($arr,$this->input->post('limit'),$this->input->post('start'));
				}
				$return = "";
				$count_limit = 0;
				$is_load = (count($songs) <= $this->input->post('limit')) ? 'no':'yes';
				foreach($songs as $row) {
					$picture = $this->songs_model->get_songs_picture($row->id);
					$list_picture = "";
					if(!empty($picture)) { 
						foreach($picture as $pic) {
							$list_picture .= '<div class="swiper-slide">';
							if (strpos($pic->url_path, 'http') !== false) 
								$list_picture .= '<img class="img-fluid" src="'.$pic->url_path.'" alt="'.$pic->pic_name.'">'; 
							else 
								$list_picture .= '<img class="img-fluid" src="'.base_url().'assets/img/'.$pic->url_path.'" alt="'.$pic->pic_name.'">'; 
							$list_picture .='</div>';
						}
					} else {
						$list_picture .= '<div class="swiper-slide">
						<img class="img-fluid" src="https://www.kindpng.com/picc/m/623-6236350_profile-icon-png-white-clipart-png-download-windows.png" alt="No Image">
						</div>';
					}

					$color = ($row->color != "")?' style="color:'.$row->color.'"':"";
					$checked = '';
					if ($this->session->userdata('logged_in'))
						$checked = ($row->fav_status == 'active')?'checked':'';
					

					$return .= '<a href="'.base_url().'songs/'.$row->id.'?lang='.rawurlencode($this->input->post('lang')).'&song='.rawurlencode($this->input->post('song')).'">
						<div class="single_music_item">
							<div class="image_box">
								<div class="swiper-container">
								<div class="swiper-wrapper">'.
								$list_picture.
								'</div></div>
							</div>
							<div class="content_box">
								<div class="song_name">
									<h4>'.$row->song.'</h4>
								</div>
								<div class="geners">
									<ul>
										<li'.$color.'>'.
										$row->genre.
										'</li>
									</ul>
								</div>
								<div class="song_details">
									<p>'.$row->artist.' <span>('.$row->country.')</span></p>
								</div>
								<div class="year_instoment">
									<ul>
										<li class="year_song">'.$row->year.'</li>
										<li class="instoment_song">'.$row->instrument.'</li>
									</ul>
								</div>
								<div class="favorite_song">
									<input class="star" type="checkbox" title="bookmark page" '.$checked.' onclick="set_favorite(this,'.$row->id.')">
								</div>
								<div class="song_main_language">
									<h4>'.$row->language.'</h4>
								</div>
							</div>
						</div>
					</a>';
					if (++$count_limit == $this->input->post('limit')) break;
				}
				echo $is_load.'|'.$return;
			} else {
				echo 'no';
			}
		}
	}
	function frequent_questions()
	{
		$data=[];
		$this->load->view('header',$data);
		$this->load->view('frequent_questions',$data);
		$this->load->view('footer',$data);
	}
	
}
