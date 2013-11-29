<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Condition_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function load_condition($id)
	{
		//for json
		//set session for update
		$this->session->set_userdata("edit_condition_id",$id);
		$this->db->select()->from("tb_condition")->where("condition_id",$id)->limit(1);
		return $this->db->get()->result_array();
	}
}