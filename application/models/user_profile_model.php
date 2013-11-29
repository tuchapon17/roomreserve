<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_profile_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function user_profile($username)
	{
		$this->db->select("tb_user.*,tb_titlename.titlename,tb_occupation.occupation_name,tb_province.province_name,tb_district.district_name,tb_subdistrict.subdistrict_name")->from("tb_user");
		$this->db->join("tb_titlename","tb_titlename.titlename_id=tb_user.tb_titlename_id");
		$this->db->join("tb_occupation","tb_occupation.occupation_id=tb_user.tb_occupation_id");
		$this->db->join("tb_province","tb_province.province_id=tb_user.tb_province_id");
		$this->db->join("tb_district","tb_district.district_id=tb_user.tb_district_id");
		$this->db->join("tb_subdistrict","tb_subdistrict.subdistrict_id=tb_user.tb_subdistrict_id");
		return $this->db->where("username",$username)->limit(1)->get()->result_array();
	}
	function user_email($username)
	{
		return $this->db->select("email")->from("tb_user")->where("username",$username)->limit(1)->get()->result_array();
	}
	function check_current_password($current_password)
	{
		$query = $this->db->select()->from("tb_user")->where(array("username"=>$this->session->userdata("rs_username"),"password"=>md5($current_password)))->limit(1)->get()->num_rows();
		if($query==1)return true;
		else if($query==0)return false;
	}
	function update_edit_profile1($set,$username)
	{
		$where=array(
				"username"=>$username
		);
		$this->db->trans_begin();
			$this->db->update("tb_user",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			$this->session->set_flashdata("edit_profile1_status",false);
			$this->session->set_flashdata("edit_profile1_message","แก้ไขข้อมูลการเข้าใช้ระบบ ไม่สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile1");
			//echo "Register Error.";
		else:
			$this->db->trans_commit();
			$this->session->set_flashdata("edit_profile1_status",true);
			$this->session->set_flashdata("edit_profile1_message","แก้ไขข้อมูลการเข้าใช้ระบบ สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile1");
		endif;
	}
	
	function get_edit_profile2($username)
	{
		return $this->db->select("firstname,lastname,tb_titlename_id,tb_occupation_id,tb_occupation.occupation_name,tb_occupation.checked")->from("tb_user")->join("tb_occupation","tb_occupation.occupation_id=tb_user.tb_occupation_id")->where("username",$username)->limit(1)->get()->result_array();
	}
	function get_edit_profile3($username)
	{
		return $this->db->select("house_no,village_no,alley,road,tb_province_id,tb_district_id,tb_subdistrict_id")->from("tb_user")->where("username",$username)->limit(1)->get()->result_array();
	}
	function update_occupation($set,$occupation_id)
	{
		$where=array(
				"occupation_id"=>$occupation_id
		);
		$this->db->trans_begin();
		$this->db->update("tb_occupation",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			echo "แก้ไขอาชีพล้มเหลว"; 
		else:
			$this->db->trans_commit();
		endif;
	}
	function update_edit_profile2($set,$username)
	{
		$where=array(
				"username"=>$username
		);
		$this->db->trans_begin();
		$this->db->update("tb_user",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			$this->session->set_flashdata("edit_profile2_status",false);
			$this->session->set_flashdata("edit_profile2_message","แก้ไขข้อมูลส่วนตัว ไม่สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile2");
		else:
			$this->db->trans_commit();
			$this->session->set_flashdata("edit_profile2_status",true);
			$this->session->set_flashdata("edit_profile2_message","แก้ไขข้อมูลส่วนตัว สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile2");
		endif;
	}
	function update_edit_profile3($set,$username)
	{
		$where=array(
				"username"=>$username
		);
		$this->db->trans_begin();
		$this->db->update("tb_user",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			$this->session->set_flashdata("edit_profile3_status",false);
			$this->session->set_flashdata("edit_profile3_message","แก้ไขข้อมูลที่อยู่ ไม่สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile3");
		else:
			$this->db->trans_commit();
			$this->session->set_flashdata("edit_profile3_status",true);
			$this->session->set_flashdata("edit_profile3_message","แก้ไขข้อมูลที่อยู่ สำเร็จ");
			redirect(base_url()."?c=user_profile&m=edit_profile3");
		endif;
	}
}