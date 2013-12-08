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
}