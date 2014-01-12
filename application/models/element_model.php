<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Element_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function select_titlename()
	{
		//asc น้อยไปมาก
		$this->db->select()->from("tb_titlename")->order_by("titlename","ASC");
		$query=$this->db->get();
		return $query->result_array();
		/*
		if($query->num_rows>0)
		{
			return $query->result_array();
		}else
		{
			return false;
		}
		*/
	}
	function select_occupation()
	{
		$this->db->select()->from("tb_occupation")->where("checked","1")->order_by("occupation_name","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_province()
	{
		//เรียงลำดับ ภาษาไทย โดยไม่สนสระ = CONVERT(Filed_name USING TIS620)
		$this->db->select()->from("tb_province")->order_by("CONVERT(province_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_district($province_id)
	{
		$this->db->select()->from("tb_district")->like('district_id',$province_id,'after')->order_by("CONVERT(district_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_subdistrict($district_id)
	{
		$this->db->select()->from("tb_subdistrict")->like('subdistrict_id',$district_id,'after')->order_by("CONVERT(subdistrict_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_article_type()
	{
		$this->db->select()->from("tb_article_type")->order_by("CONVERT(article_type_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_room_type()
	{
		$this->db->select()->from("tb_room_type")->order_by("CONVERT(room_type_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_faculty()
	{
		$this->db->select()->from("tb_faculty")->where("checked",1)->order_by("CONVERT(faculty_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_select($table_name,$order_field,$where='')
	{
		if($where=='')
			$this->db->select()->from($table_name)->order_by("CONVERT(".$order_field." USING TIS620)","ASC");
		else $this->db->select()->from($table_name)->where($where)->order_by("CONVERT(".$order_field." USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_room_list($room_type_id)
	{
		$this->db->select()->from("tb_room")->like('tb_room_type_id',$room_type_id,'both')->order_by("CONVERT(room_name USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	function select_room_rha($article_id)
	{
		//$this->db->select("tb_room.room_id,tb_room.room_name,tb_room_has_article.tb_room_id,tb_room_has_article.tb_article_id")->from("tb_room")->join("tb_room_has_article","tb_room.room_id=tb_room_has_article.tb_room_id","left")->where('tb_article_id !=',$article_id)->or_where('tb_article_id IS NULL')->order_by("CONVERT(room_name USING TIS620)","ASC");
		$query=$this->db->query("SELECT * FROM tb_room WHERE NOT EXISTS (SELECT * FROM tb_room_has_article WHERE  tb_room.room_id=tb_room_has_article.tb_room_id AND tb_room_has_article.tb_article_id='".$article_id."') ORDER BY CONVERT(room_name USING TIS620 ) ASC");
		//$query=$this->db->get();
		return $query->result_array();
	}
	function select_person_list($person_type_id)
	{
		$this->db->select()->from("tb_person")->like('tb_person_type_id',$person_type_id,'both')->order_by("CONVERT(person USING TIS620)","ASC");
		$query=$this->db->get();
		return $query->result_array();
	}
	
	/**
	 * เลือกห้องเฉพาะที่มีอุปกรณ์ (tb_room_has_article)
	 * @param string $room_type_id
	 * @return array
	 */
	function reserve_room_list($room_type_id)
	{
		$this->db->select()->from("tb_room");
		$this->db->join("tb_room_has_article","tb_room_has_article.tb_room_id=tb_room.room_id");
		$this->db->like('tb_room_type_id',$room_type_id,'both')
		->order_by("CONVERT(room_name USING TIS620)","ASC")
		->group_by("room_name");
		$query=$this->db->get();
		return $query->result_array();
	}
}