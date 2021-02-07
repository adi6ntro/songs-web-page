<?php
class Songs_model extends CI_Model

{
    public function __construct()
    {
		parent::__construct();
    }

	public  function get_all_songs($limit=null,$offset=0)
    {
		$this->db->distinct();
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name');
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->join('language', 'language.id = songs.language');
		$this->db->order_by('songs.id', 'ASC');
		if($limit != null)
			$this->db->limit($limit, $offset);
		$query=$this->db->get();

		return $query->result();
    }

    public function get_by_id($table,$column,$id,$type=null)
    {
		$this->db->from($table);
		if ($type == 'like') {
			$this->db->like($column,$id);
		} else {
			$this->db->where($column,$id);
		}
		$query=$this->db->get();

		return $query->row();
	}

	public function get_by_param($column,$value,$limit=null,$offset=0)
    {
		$this->db->distinct();
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name');
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->join('language', 'language.id = songs.language');
		$this->db->where($column,$value);
		$this->db->order_by('songs.id', 'ASC');
		if($limit != null)
			$this->db->limit($limit, $offset);
		$query=$this->db->get();

		return $query->result();
	}

	function search_language($title){
		$query = $this->db->query("select id,name from language where name like '%$title%' limit 5");
		return $query->result();
		// $this->db->distinct();
        // $this->db->like('language.name', $title , 'both');
        // $this->db->order_by('language.name', 'ASC');
        // $this->db->limit(5);
		// $this->db->select('language.id,language.name as language_name');
		// $this->db->from('songs');
		// $this->db->join('language', 'language.id = songs.language');
        // return $this->db->get()->result();
    }

	public  function get_songs_picture($id)
    {
		$this->db->where('songs_id',$id);
		$this->db->order_by('id', 'ASC');
		$query=$this->db->get('picture');

		return $query->result();
    }
}

?>
