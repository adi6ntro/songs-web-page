<?php
class Songs_model extends CI_Model

{
    public function __construct()
    {
		parent::__construct();
    }

	public  function get_all_songs()
    {
		$this->db->distinct();
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,picture');
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$query=$this->db->get();

		return $query->result();
    }

    public function get_by_id($table,$column,$id)
    {
		$this->db->from($table);
		$this->db->where($column,$id);
		$query=$this->db->get();

		return $query->row();
	}

    public function get_by_param($column,$value)
    {
		$this->db->distinct();
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,picture');
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->where($column,$value);
		$query=$this->db->get();

		return $query->result();
	}

	function search_language($title){
		$this->db->distinct();
        $this->db->like('language.name', $title , 'both');
        $this->db->order_by('language.name', 'ASC');
        $this->db->limit(5);
		$this->db->select('language.id,language.name as language_name');
		$this->db->from('songs');
		$this->db->join('language', 'language.id = songs.language');
        return $this->db->get()->result();
    }
}

?>
