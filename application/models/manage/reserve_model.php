<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reserve_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_room_has_article($room_id)
	{
		$select_feild="tb_room_has_article.*,tb_article.article_id,tb_article.article_name";
		$this->db->select($select_feild)->from("tb_room_has_article")->join("tb_article","tb_room_has_article.tb_article_id=tb_article.article_id")->where("tb_room_id",$room_id);
		return $this->db->get()->result_array();
	}
	function find_one($table, $where)
	{
		$this->db->select()->from($table)->where($where)->limit(1);
		return $this->db->get()->result_array();
	}
	function get_reserve_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_reserve")["field"];
		$orderby_type=$this->session->userdata("orderby_reserve")["type"];
	
		if($liketext!='')
		{
			$query=$this->db->select()->from("tb_reserve")->like("reserve_id",$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else
		{
			$query=$this->db->select()->from("tb_reserve")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function get_article_data($reserve_id)
	{
		$this->db->select(
				"tb_reserve.reserve_id,
				tb_reserve_has_article.*,
				tb_article.*"
		)->from("tb_reserve");
		$this->db->join("tb_reserve_has_article","tb_reserve_has_article.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_article","tb_article.article_id=tb_reserve_has_article.tb_article_id");
		$this->db->where("tb_reserve.reserve_id",$reserve_id);
		$query=$this->db->get()->result_array();
		return $query;
	}
	function get_datetime_data($reserve_id)
	{
		$this->db->select(
				"tb_reserve.reserve_id,
				tb_reserve_has_datetime.*"
		)->from("tb_reserve");
		$this->db->join("tb_reserve_has_datetime","tb_reserve_has_datetime.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->where("tb_reserve.reserve_id",$reserve_id);
		$query=$this->db->get()->result_array();
		return $query;
	}
	function get_file_data($reserve_id)
	{
		$this->db->select(
				"tb_reserve.reserve_id,
				tb_reserve_has_file.*"
		)->from("tb_reserve");
		$this->db->join("tb_reserve_has_file","tb_reserve_has_file.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->where("tb_reserve.reserve_id",$reserve_id);
		$query=$this->db->get()->result_array();
		return $query;
	}
	function get_reserve_data($reserve_id)
	{
		$this->db->select()->from("tb_reserve");
		$this->db->join("tb_room","tb_room.room_id=tb_reserve.tb_room_id");
		$this->db->join("tb_reserve_has_person","tb_reserve_has_person.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_person","tb_person.person_id=tb_reserve_has_person.tb_person_id");
		$this->db->join("tb_person_type","tb_person_type.person_type_id=tb_person.tb_person_type_id");
		$this->db->join("tb_job_position","tb_job_position.job_position_id=tb_reserve_has_person.tb_job_position_id","left");
		$this->db->join("tb_office","tb_office.office_id=tb_reserve_has_person.tb_office_id","left");
		$this->db->join("tb_department","tb_department.department_id=tb_reserve_has_person.tb_department_id","left");
		$this->db->join("tb_faculty","tb_faculty.faculty_id=tb_reserve_has_person.tb_faculty_id","left");
		$this->db->where("tb_reserve.reserve_id",$reserve_id);
		$query=$this->db->get()->result_array();
		return $query;
	}
}