<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_user_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_user")["field"];
		$orderby_type=$this->session->userdata("orderby_user")["type"];
	
		if($liketext!='')
		{
			$query=$this->db->select("tb_user.*,tb_usergroup.group_name")->from("tb_user")->join("tb_usergroup","tb_usergroup.usergroup_id=tb_user.tb_usergroup_id")->like("username",$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else
		{
			$query=$this->db->select("tb_user.*,tb_usergroup.group_name")->from("tb_user")->join("tb_usergroup","tb_usergroup.usergroup_id=tb_user.tb_usergroup_id")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function get_all_data($username)
	{
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
		$query=$this->db->get()->result_array();
		return $query;
	}

}