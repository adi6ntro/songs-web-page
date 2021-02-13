<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

	var $limit;
	public function __construct()
	{
		parent::__construct();
		$this->limit = 10;
	}

	public function detail($id)
	{
		$data['row'] = $this->songs_model->get_songs($id);
		$data['songs'] = $this->songs_model->get_all_songs(4);
		// $data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['is_load']='no';
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

	public function selected() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		}
		$data['songs']=$this->songs_model->get_favorite($this->limit);
		$data['is_load']=(count($data['songs']) <= $this->limit)?'no':'yes';
		$data['lang_id']="";
		$data['start_limit']=$this->limit;
		$data['limit']=$this->limit;
		$this->load->view('header',$data);
		$this->load->view('selected_view',$data);
		$this->load->view('footer',$data);
	}
}

