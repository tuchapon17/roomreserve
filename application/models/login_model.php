<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function check_auth()
	{
		$username = $this->security->xss_clean(strtolower($this->input->post("input_username")));
		$password = $this->security->xss_clean($this->input->post("input_password"));
		$where=array(
				"username"=>$username,
				"password"=>md5($password),
				"user_status"=>"1"
		);
		$this->db->select("username,tb_usergroup_id")->from("tb_user")->where($where)->limit(1);
		$query = $this->db->get();
		
		if($query->num_rows()===1)
		{
			$r = $query->row();
			
			/*#################################################
			 * Insert login logs 
			#################################################*/
			//$this->db->select("MAX(auth_log_id) AS auth_log_id")->from("tb_auth_log")->limit(1);
			//$r2=$this->db->get()->row();
			$auth_maxid=$this->get_maxid(7, "auth_log_id", "tb_auth_log");
			$auth_log=array(
					//"auth_log_id"=>str_pad((int)$r2->auth_log_id+1,7,"0",STR_PAD_LEFT),
					"auth_log_id"=>$auth_maxid,
					"tb_user_username"=>$r->username,
					"ip_address"=>$this->input->ip_address(),
					"login_on"=>date('Y-m-d H:i:s')
			);
			$this->db->trans_begin();
			$this->db->insert("tb_auth_log",$auth_log);
			if($this->db->trans_status()===FALSE):
				$this->db->trans_rollback();
				echo "Log Error";
			else:
				$this->db->trans_commit();
			endif;
			
			/*#################################################
			 * Set session
			#################################################*/
			$set_session=array(
					"rs_username"=>$r->username,
					"rs_usergroup"=>$r->tb_usergroup_id,
					"login_validated"=>"1",
			);
			$this->session->set_userdata($set_session);
			
			return true;
		}
		else return false;
	}
	
	/*
	 * check privilege
	 * */
	function get_group_of_user()
	{
		if($this->session->userdata("rs_username"))
		{
			$this->db->select("tb_usergroup_id")->from("tb_user");
			$this->db->where(array("username"=>$this->session->userdata("rs_username")));
			return $this->db->get()->result_array();
		}
	}
	function get_group_privilege()
	{
		if($this->session->userdata("rs_username"))
		{
			//$group_of_user=$this->get_group_of_user()[0]['tb_usergroup_id'];
			$group_of_user=$this->session->userdata("rs_usergroup");
			$this->db->select("tb_privilege_id")->from("tb_usergroup_has_privilege");
			$this->db->where(array("tb_usergroup_id"=>$group_of_user));
			return $this->db->get()->result_array();
		}
	}
	
	function get_user_privilege()
	{
		if($this->session->userdata("rs_username"))
		{
			$this->db->select()->from("tb_user_has_privilege");
			$this->db->where("tb_user_username",$this->session->userdata("rs_username"));
			return $this->db->get()->result_array();
		}
	}
}