<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function detail($id)
	{
		$data['songs'] = $this->songs_model->get_by_param('songs.id',$id,1);
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
		$limit = 10;
		$data['songs']=$this->songs_model->get_favorite($limit);
		$data['lang_id']="";
		$data['start_limit']=$limit;
		$data['limit']=$limit;
		$this->load->view('header',$data);
		$this->load->view('selected_view',$data);
		$this->load->view('footer',$data);
	}
}

