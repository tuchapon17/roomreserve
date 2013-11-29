<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Article_type_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_article_type_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_article_type")["field"];
		$orderby_type=$this->session->userdata("orderby_article_type")["type"];
		if($liketext!='')
		{
			$query=$this->db->select()->from("tb_article_type")->like("article_type_name",$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else
		{
			$query=$this->db->select()->from("tb_article_type")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function load_article_type($id)
	{
		//for json
		//set session for update
		$this->session->set_userdata("edit_article_type_id",$id);
		$this->db->select()->from("tb_article_type")->where("article_type_id",$id)->limit(1);
		return $this->db->get()->result_array();
	}
}