<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
	}
	
	/**
	 * Insert register information to tb_user , Insert user privilege to tb_user_has_privilege
	 */
	function add_user()
	{
		$username=$this->input->post("input_username");
		$password=md5($this->input->post("input_password"));
		$email=$this->input->post("input_email");
		$titlename=$this->input->post("select_titlename");
		$firstname=$this->input->post("input_firstname");
		$lastname=$this->input->post("input_lastname");
		$occupation=$this->input->post("select_occupation");
		$phone=$this->input->post("input_phone");
		
		$data=array(
				"username"=>strtolower($username),
				"password"=>$password,
				"email"=>strtolower($email),
				"regis_on"=>date('Y-m-d H:i:s'),
				"regis_ip"=>$this->input->ip_address(),
				"tb_usergroup_id"=>"04",
				"tb_titlename_id"=>$titlename,
				"firstname"=>$firstname,
				"lastname"=>$lastname,
				"tb_occupation_id"=>$occupation,
				"phone"=>$phone,
				"house_no"=>$this->input->post("input_house_no"),
				"village_no"=>$this->input->post("input_village_no"),
				"alley"=>$this->input->post("input_alley"),
				"road"=>$this->input->post("input_road"),
				"tb_province_id"=>$this->input->post("select_province"),
				"tb_district_id"=>$this->input->post("select_district"),
				"tb_subdistrict_id"=>$this->input->post("select_subdistrict")
		);
		//if data is '' ,spaceToNull convert '' to NULL before insert to DB
		foreach($data AS $key=>$val):
			$data[$key]=$this->toNull($data[$key]);
		endforeach;
		$this->db->trans_begin();
			/*#################################################
			 * insert otheroccupation to tb_occupation
			#################################################*/
			if($this->input->post("select_occupation")=="00")
			{
				//get current max id from MY_Model
				$new_id=$this->get_maxid(2, "occupation_id", "tb_occupation");

				$data_occupation=array(
						"occupation_id"=>$new_id,
						"occupation_name"=>trim($this->input->post("input_occupation")),
						//เปิดให้แสดงอาชีพที่เพิ่มใหม่ ให้เจ้าหน้าที่ตรวจสอบ ยกเลิกออกภายหลัง
						"checked"=>"0"
				);
				$this->db->set($data_occupation)->insert("tb_occupation");
				//set new occupation id
				$data["tb_occupation_id"]=$new_id;
				
			}
			/*
			 * insert new user to tb_user
			*/
			$this->db->set($data)->insert('tb_user');
			
			/*
			* select privilege from usergroup and insert to tb_user_has_privilege
			*/
			/* ไม่ได้ใช้ มี trigger แล้ว = "add_user_has_privilege"
			$this->db->select()->from("tb_usergroup_has_privilege");
			$group_privilege = $this->db->where("tb_usergroup_id","04")->get()->result_array();
			foreach($group_privilege as $g)
			{
				$gp = array(
						"tb_privilege_id"=>$g['tb_privilege_id'],
						"tb_user_username"=>$username
				);
				$this->db->set($gp)->insert("tb_user_has_privilege");
			}*/
				
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			$this->session->set_flashdata("register_status",false);
			$this->session->set_flashdata("register_message","ลงทะเบียนไม่สำเร็จ");
			redirect(base_url()."?c=register&m=step1");
			//echo "Register Error.";
		else:
			$this->db->trans_commit();
			$this->session->set_flashdata("register_status",true);
			$this->session->set_flashdata("register_message","ลงทะเบียนสำเร็จ");
			redirect(base_url()."?c=register&m=step1");
		endif;
	}
	
	/**
	 * convert '' to NULL before insert to DB
	 * @param $data
	 * @return NULL|old_data
	 */
	function toNull($data)
	{
		if($data=='')return null;
		else return $data;
	}
	
	/**
	 * Check Username in tb_user, Return true if username not exists
	 * @param $username
	 * @return boolean
	 */
	function username_already_exist($username)
	{
		$this->db->select()->from("tb_user")->where("username",$username);
		$num_rows=$this->db->get()->num_rows();
		if($num_rows>0)return false;
		else if($num_rows==0)return true;
	}
	
}