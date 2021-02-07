<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$limit = 10;
		$data['songs']=$this->songs_model->get_all_songs($limit);
		$data['lang']="ALL";
		$data['lang_id']="";
		$data['start_limit']=$limit;
		$data['limit']=$limit;
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function example()
	{
		$this->load->view('example_view');
	}

	function get_autocomplete(){
        if (isset($_GET['term'])) {

			$term = $this->db->escape_str(trim(str_replace(" ","%",preg_replace('/\s\s+/', ' ', $_GET['term']))));
			$result = $this->songs_model->search_language($term);
            if (count($result) > 0) {
            foreach ($result as $row)
				$arr_result[] = array(
					"value"=>$row->name, "lang_id"=>$row->id, "lang_name"=>$row->name
				);
                echo json_encode($arr_result);
            }
        }
	}

	public function search($type)
	{
		if( !isset($_POST['lang_id']) )
		{
			redirect('/', 'refresh');
		}
		$limit = 10;
		$term = $this->db->escape_str(trim(preg_replace('/\s\s+/', ' ', $this->input->post('search'))));
		if (empty($_POST['lang_id'])) {
			$lang = $term;
			$data['lang']=$term;
			$data['lang_id']=rawurlencode($term);
			$type=$type.'.name';
		} else {
			$lang = $this->input->post('lang_id');
			$data['lang']=$this->songs_model->get_by_id('language','id',$this->input->post('lang_id'))->name;
			$data['lang_id']=$this->input->post('lang_id');
		}
		$data['songs']=$this->songs_model->get_by_param($type,$lang,$limit);
		$data['start_limit']=$limit;
		$data['limit']=$limit;
		$this->load->view('header',$data);
		$this->load->view('home_view',$data);
		$this->load->view('footer',$data);
	}

	public function loadmore($type=null,$id=null)
	{
		if(isset($_POST["limit"], $_POST["start"]))
		{
			if($type == null)
			$songs = $this->songs_model->get_all_songs($this->input->post('limit'),$this->input->post('start'));
			else
			$songs = $this->songs_model->get_by_param($type,$id,$this->input->post('limit'),$this->input->post('start'));
			$return = "";
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
				
				$return .= '<a href="#">
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
								<input class="star" type="checkbox" title="bookmark page">
							</div>
							<div class="song_main_language">
								<h4>'.$row->language.'</h4>
							</div>
						</div>
					</div>
				</a>';
			}
			echo $return;
		}
	}
}
