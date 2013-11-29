<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_room_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_room")["field"];
		$orderby_type=$this->session->userdata("orderby_room")["type"];
	
		if($liketext!='')
		{
			$query=$this->db->select()->from("tb_room")->like("room_name",$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else
		{
			$query=$this->db->select()->from("tb_room")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function load_room($id)
	{
		//for json
		//set session for update
		$this->session->set_userdata("edit_room_id",$id);
		$this->db->select()->from("tb_room")->where("room_id",$id)->limit(1);
		return $this->db->get()->result_array();
	}
}