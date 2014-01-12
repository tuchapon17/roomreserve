<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assign_Model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * select สิทธิ์ัทั้งหมดของตัวเราที่ login อยู่
	 */
	function get_privilege_list()
	{
		/*$this->db->select()->from("tb_user_has_privilege");
		$this->db->join("tb_privilege","tb_privilege.privilege_id=tb_user_has_privilege.tb_privilege_id");
		$this->db->where(array("tb_user_username"=>$this->session->userdata("rs_username")) );
		return $this->db->get()->result_array();*/
		
		$query = $this->db->query("SELECT * 
				FROM tb_user_has_privilege 
				JOIN tb_privilege 
				ON tb_privilege.privilege_id = tb_user_has_privilege.tb_privilege_id 
				WHERE tb_privilege_id NOT IN 
					(SELECT tb_privilege_id FROM tb_privilege_assign WHERE canceled = 0 
					AND assign_to = '".$this->session->userdata("rs_username")."') 
				AND tb_user_username ='".$this->session->userdata("rs_username")."'",FALSE);
		return $query->result_array();
	}
	
	/*
	 * select รายชื่อ username ที่ยังไม่มีสิทธิ์ที่เราจะโอนให้
	 */
	function get_user_list($privilege_id)
	{
		$user_list = $this->db->query("select tb_user.username from tb_user
					join tb_user_has_privilege
					on tb_user_has_privilege.tb_user_username = tb_user.username
					where username not in
						(SELECT tb_user_username FROM tb_user_has_privilege where tb_privilege_id = ".$privilege_id.")
					group by username",FALSE)->result_array();
		return $user_list;
	}
	
	function get_privilege_assign_list($perpage,$page)
	{
		$this->db->select()->from("tb_privilege_assign");
		$this->db->join("tb_privilege","tb_privilege.privilege_id=tb_privilege_assign.tb_privilege_id");
		$this->db->where("assign_from",$this->session->userdata("rs_username"))->order_by("assign_date","DESC")->limit($perpage,$page);
		return $this->db->get()->result_array();
	}
	
	function allow_assign($set,$where)
	{
		
		$this->db->trans_begin();
		$this->db->update("tb_privilege_assign",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			return false;
		else:
			$this->db->trans_commit();
			return true;
		endif;
	}
}