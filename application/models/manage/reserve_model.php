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
	function get_all_data($reserve_id)
	{
		$this->db->select()->from("tb_reserve");
		$this->db->join("tb_reserve_has_article","tb_reserve_has_article.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_article","tb_article.article_id=tb_reserve_has_article.tb_article_id");
		$this->db->join("tb_reserve_has_datetime","tb_reserve_has_datetime.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_reserve_has_file","tb_reserve_has_file.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_reserve_has_person","tb_reserve_has_person.tb_reserve_id=tb_reserve.reserve_id");
		$this->db->join("tb_person","tb_person.person_id=tb_reserve_has_person.tb_person_id");
		
		/*
		$this->db->select("	tb_user.username,
							tb_user.email,
							DATE_FORMAT(tb_user.regis_on,'%d/%m/%Y %H:%i:%s') AS regis_on,
							tb_user.regis_ip,
							tb_user.tb_usergroup_id,
							tb_user.tb_titlename_id,
							tb_user.firstname,
							tb_user.lastname,
							tb_user.tb_occupation_id,
							tb_user.phone,
							tb_user.house_no,
							tb_user.village_no,
							tb_user.alley,
							tb_user.road,
							tb_user.tb_province_id,
							tb_user.tb_district_id,
							tb_user.tb_subdistrict_id,
							tb_usergroup.group_name,
							tb_titlename.titlename,
							tb_occupation.occupation_name,
							tb_province.province_name,
							tb_district.district_name,
							tb_subdistrict.subdistrict_name",FALSE)->from("tb_user");
		$this->db->join("tb_usergroup","tb_usergroup.usergroup_id=tb_user.tb_usergroup_id");
		$this->db->join("tb_titlename","tb_titlename.titlename_id=tb_user.tb_titlename_id");
		$this->db->join("tb_occupation","tb_occupation.occupation_id=tb_user.tb_occupation_id");
		$this->db->join("tb_province","tb_province.province_id=tb_user.tb_province_id");
		$this->db->join("tb_district","tb_district.district_id=tb_user.tb_district_id");
		$this->db->join("tb_subdistrict","tb_subdistrict.subdistrict_id=tb_user.tb_subdistrict_id");
		$this->db->where("username",$username)->limit(1);
		*/
		$this->db->where("tb_reserve.reserve_id",$reserve_id)->limit(1);
		$query=$this->db->get()->result_array();
		return $query;
	}
}