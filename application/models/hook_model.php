<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hook_Model extends CI_Model
{
	function __construct()
	{
		
	}
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
			$group_of_user=$this->get_group_of_user()[0]['tb_usergroup_id'];
			
			$this->db->select("tb_privilege_id")->from("tb_usergroup_has_privilege");
			$this->db->where(array("tb_usergroup_id"=>$group_of_user));
			print_r($this->db->get()->result_array());
			echo $this->session->userdata("rs_username");
			//return $this->db->get()->result_array();
		}
	}
}