<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_Model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_room_view_data($perpage=0,$page=0,$return_type="array")
	{
		if($return_type=="array")
		{
			$this->db->select()->from("tb_room");
			//$this->db->join("tb_room_has_pic","tb_room_has_pic.tb_room_id=tb_room.room_id");
			$this->db->join("tb_room_type","tb_room_type.room_type_id=tb_room.tb_room_type_id");
			$this->db->join("tb_fee_type","tb_fee_type.fee_type_id=tb_room.tb_fee_type_id");
			$this->db->group_by("room_id")->limit($perpage,$page);
			$data = $this->db->get();
			return $data->result_array();
		}
		else if($return_type=="num_rows")
		{
			$this->db->select()->from("tb_room");
			$this->db->join("tb_room_has_pic","tb_room_has_pic.tb_room_id=tb_room.room_id");
			$this->db->group_by("tb_room.room_id");
			$data = $this->db->get();
			return $data->num_rows();
		}
	}
	function get_pic_list($room_id)
	{
		$this->db->select()->from("tb_room_has_pic");
		$this->db->where("tb_room_id",$room_id);
		return $this->db->get()->result_array();
	}
	function form_select_room_get_room($room_type_id)
	{
		$this->db->select()->from("tb_room")->where("tb_room_type_id",$room_type_id);
		return $this->db->get()->result_array();
	}
	function form_select_room_get_room_type()
	{
		$this->db->select()->from("tb_room_type");
		return $this->db->get()->result_array();
	}
	function get_room_data($room_id)
	{
		$this->db->select()->from("tb_room");
		$this->db->join("tb_room_type","tb_room_type.room_type_id=tb_room.tb_room_type_id");
		$this->db->join("tb_fee_type","tb_fee_type.fee_type_id=tb_room.tb_fee_type_id");
		if($room_id!=null)$this->db->where("room_id",$room_id);
		else $this->db->limit(1);
		return $this->db->get()->result_array();
	}
	function check_room_id($room_id)
	{
		$count = $this->db->select("COUNT(room_id) AS count")->from("tb_room")->where("room_id",$room_id)->get()->result_array();
		$count = $count[0];
		return ($count['count']>0) ? true : false;
	}

}