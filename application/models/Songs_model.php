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
		$fav_status = ($this->session->userdata('logged_in'))?',fav_status':'';
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name'.$fav_status);
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->join('language', 'language.id = songs.language');
		if ($this->session->userdata('logged_in')) {
			$this->db->join('favorite', "songs_id = songs.id and user_id = ".$this->session->userdata('logged_in')['id'], 'left');
		}
		$this->db->order_by('songs.seq_order', 'ASC');
		if($limit != null)
			$this->db->limit($limit+1, $offset);
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

	public function get_by_param($arr_where,$limit=null,$offset=0,$type=null)
    {
		if ($this->session->userdata('logged_in')) {
			$fav_status = ",fav_status";
			$fav_join = " left join favorite on songs_id = songs.id and user_id = ".$this->session->userdata('logged_in')['id'];
		} else {
			$fav_status = "";
			$fav_join = "";
		}

		$data = explode("|",$type);

		if ($data[0] == 'like') {
			$where = "";
			if($limit != null) $limit+=1; 
			if (isset($arr_where[$data[1]]) && $arr_where[$data[1]]!=""){
				$where .= " and ".$data[1]." like '%".$arr_where[$data[1]]."%'";
				unset($arr_where[$data[1]]);
			}
			foreach ($arr_where as $key => $value) {
				$where .= " and $key = '$value'";
			}
			if ($limit != null){
				if ($offset>0) {
					$qlimit = "LIMIT $offset, $limit";
				} else {
					$qlimit = "LIMIT $limit";
				}
			} else {
				$qlimit = "";
			}
			$query = $this->db->query("select distinct 
			songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,
			year,style,instrument,language.name as language_name$fav_status from songs
			join artist on songs.artist = artist.artist
			join genre on songs.genre = genre.name
			join country on artist.country = country.id
			join language on language.id = songs.language$fav_join
			where 1=1$where
			order by songs.seq_order $qlimit");
		} else {
			$this->db->distinct();
			$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,
			country,country.name as country_name,year,style,instrument,language.name as language_name'.$fav_status);
			$this->db->from('songs');
			$this->db->join('artist', 'songs.artist = artist.artist');
			$this->db->join('genre', 'songs.genre = genre.name');
			$this->db->join('country', 'artist.country = country.id');
			$this->db->join('language', 'language.id = songs.language');
			if ($this->session->userdata('logged_in')) {
				$this->db->join('favorite', 'songs_id = songs.id and user_id = '.$this->session->userdata('logged_in')['id'], 'left');
			}
			$this->db->where($arr_where);
			$this->db->order_by('songs.seq_order', 'ASC');
			if($limit != null)
				$this->db->limit($limit+1, $offset);
			$query=$this->db->get();
		}
		return $query->result();
	}

	public function get_songs($id)
    {
		$fav_status = ($this->session->userdata('logged_in'))?',fav_status,note':'';
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,
		country.name as country_name,year,style,instrument,language.name as language_name,
		lyrics,source_name_lyrics,source_url_lyrics'.$fav_status);
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->join('language', 'language.id = songs.language');
		if ($this->session->userdata('logged_in')) {
			$this->db->join('favorite', 'favorite.songs_id = songs.id and favorite.user_id = '.$this->session->userdata('logged_in')['id'], 'left');
			$this->db->join('notes', 'notes.songs_id = songs.id and notes.user_id = '.$this->session->userdata('logged_in')['id'], 'left');
		}
		$this->db->where('songs.id',$id);
		$query=$this->db->get();

		return $query->row();
	}

	public function get_favorite($limit=null,$offset=0)
    {
		$this->db->distinct();
		$this->db->select('songs.id,song,songs.artist,genre,genre.color,language,country,country.name as country_name,year,style,instrument,language.name as language_name,fav_status');
		$this->db->from('songs');
		$this->db->join('artist', 'songs.artist = artist.artist');
		$this->db->join('genre', 'songs.genre = genre.name');
		$this->db->join('country', 'artist.country = country.id');
		$this->db->join('language', 'language.id = songs.language');
		$this->db->join('favorite', "songs_id = songs.id and user_id = ".$this->session->userdata('logged_in')['id']." and fav_status='active'");
		$this->db->order_by('fav_date', 'DESC');
		if($limit != null)
			$this->db->limit($limit+1, $offset);
		$query=$this->db->get();

		return $query->result();
	}

	function update_favorite($songs_id,$fav_status){
		$array = array(
			'user_id' => $this->session->userdata('logged_in')['id'], 
			'songs_id' => $songs_id
		);
		$this->db->where($array);
		$query=$this->db->get('favorite');
		if($query->num_rows()==0){
			$insert_data = array(
				'user_id' => $this->session->userdata('logged_in')['id'],
				'songs_id' => $songs_id,
				'fav_status' => ($fav_status === 'true')?'active':'inactive'
			);
			$this->db->insert('favorite',$insert_data);
		} else {
			$insert_data = array(
				'fav_status' => ($fav_status === 'true')?'active':'inactive'
			);
			$this->db->where($array);
			$this->db->update('favorite', $insert_data);
		}
		return 'yes';
	}

	function update_note($songs_id,$note){
		$array = array(
			'user_id' => $this->session->userdata('logged_in')['id'], 
			'songs_id' => $songs_id
		);
		$this->db->where($array);
		$query=$this->db->get('notes');
		if($query->num_rows()==0){
			$insert_data = array(
				'user_id' => $this->session->userdata('logged_in')['id'],
				'songs_id' => $songs_id,
				'note' => $note
			);
			$this->db->insert('notes',$insert_data);
		} else {
			$insert_data = array(
				'note' => $note
			);
			$this->db->where($array);
			$this->db->update('notes', $insert_data);
		}
		return 'yes';
	}

	function search_language($title,$sess){
		$query = $this->db->query("select id,name from language where name like '%$title%' limit 5");
		if ($sess != "") {
			$query = $this->db->query("select songs.id,name from songs join language on language.id=songs.language
			where language.name like '%$title%' and songs.song = ".$this->db->escape($sess)." limit 5");
		}
		return $query->result();
    }

	function search_song($title,$sess){
		$qsess = "";
		if ($sess != "")
			$qsess = " and language.id = ".$this->db->escape($sess);
		$query = $this->db->query("select songs.id,song as name from songs join language on language.id=songs.language
		where song like '%$title%'".$qsess." limit 5");
		return $query->result();
    }

	function get_direction_song($id,$lang,$song,$dir){
		$where = "";
		$join = "";
		$row = $this->get_by_id('songs','id',$id);
		if ($lang != '')
			$where .= " and language=".$this->db->escape($lang);
		if ($song != ''){
			if ($song == 'selected')
				$join .= " join favorite on songs_id = songs.id and user_id = ".$this->session->userdata('logged_in')['id']." and fav_status='active'";
			if ($song == 'artist'){
				$where .= " and songs.artist = ".$this->db->escape($row->artist);
			}
		}
		if ($dir == 'next') {
			$where .= " and songs.seq_order > ".$row->seq_order;
			$order = "asc";
		} else if ($dir == 'prev') {
			$where .= " and songs.seq_order < ".$row->seq_order;
			$order = "desc";
		} else {
			return 0;
		}
		if ($this->session->userdata('logged_in')) {
			$fav_status = ",fav_status";
			if ($song != 'selected')
				$join .= " left join favorite on songs_id = songs.id and user_id = ".$this->session->userdata('logged_in')['id'];
		}
		$query = $this->db->query("select distinct songs.id,songs.seq_order from songs
		join artist on songs.artist = artist.artist
		join genre on songs.genre = genre.name
		join country on artist.country = country.id
		join language on language.id = songs.language$join
		where 1=1$where order by songs.seq_order $order limit 1");
		// print_r($this->db->last_query());
		return ($query->num_rows() == 0)?0:$query->row()->id;
    }

	public function get_songs_picture($id)
    {
		$this->db->where('songs_id',$id);
		$this->db->order_by('id', 'ASC');
		$query=$this->db->get('picture');

		return $query->result();
    }

	public function get_source($id)
    {
		$this->db->select('songs_source_external.source_name,source_url,picture');
		$this->db->join('source_external', 'songs_source_external.source_name = source_external.source_name');
		$this->db->where('songs_id',$id);
		$this->db->order_by('seq_order', 'ASC');
		$query=$this->db->get('songs_source_external');

		return $query->result();
    }
}

?>
