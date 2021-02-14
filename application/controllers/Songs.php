<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

	var $limit;
	public function __construct()
	{
		parent::__construct();
		$this->limit = 4;
	}

	public function detail($id)
	{
		if ($this->input->get('song') == 'selected' && !$this->session->userdata('logged_in')){
			redirect('/', 'refresh');
		}

		$data['row'] = $this->songs_model->get_songs($id);
		$lang = rawurldecode($this->input->get('lang'));
		$song = rawurldecode($this->input->get('song'));

		$arr_where = array('songs.artist'=>$data['row']->artist);
		if ($lang != '')
			$arr_where['language'] = $lang;
		$data['songs']=$this->songs_model->get_by_param($arr_where,$this->limit);
		// $data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['is_load']='no';
		$data['next']=$this->songs_model->get_direction_song($id,$lang,$song,'next');
		$data['prev']=$this->songs_model->get_direction_song($id,$lang,$song,'prev');
		$data['lang_id']=$lang;
		$data['lang']=($lang == '')?'':$this->songs_model->get_by_id('language','id',$lang)->name;
		$data['song']=$song;
		$data['artist']=$data['row']->artist;

		$this->load->view('header',$data);
		$this->load->view('song_view',$data);
		$this->load->view('footer',$data);
	}

	public function selected_save() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$rr = $this->songs_model->update_favorite($this->db->escape_str($this->input->post('songsid')),$this->db->escape_str($this->input->post('favorite')));
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	public function savenote() {
		if (!$this->session->userdata('logged_in')) {
			echo false;
		} else {
			$rr = $this->songs_model->update_note($this->db->escape_str($this->input->post('song_id')),$this->db->escape_str($this->input->post('note')));
			// $this->session->set_flashdata('result', $rr);
			echo $rr;
		}
	}

	public function selected() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}
		$data['songs']=$this->songs_model->get_favorite($this->limit);
		$data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['lang']="ALL";
		$data['lang_id']="";
		$data['song']="selected";
		$data['artist']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('selected_view',$data);
		$this->load->view('footer',$data);
	}
}

