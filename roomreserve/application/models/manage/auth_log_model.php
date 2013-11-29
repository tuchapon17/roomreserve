<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_log_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_auth_log_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_auth_log")["field"];
		$orderby_type=$this->session->userdata("orderby_auth_log")["type"];
		//field ที่ค้นหา
		$searchfield=$this->check_searchfield("searchfield_auth_log", "tb_user_username");
		//if($this->session->userdata("searchfield_auth_log")) $searchfield=$this->session->userdata("searchfield_auth_log");
		//else $searchfield="tb_user_username";
		
		$sql_select="*,DATE_FORMAT(login_on,'%d/%m/%Y %H:%i:%s') AS login_on";
		$table_name="tb_auth_log";
		if($liketext!='')
		{
			$query=$this->db->select($sql_select,FALSE)->from($table_name)->like($searchfield,$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else
		{
			$query=$this->db->select($sql_select,FALSE)->from($table_name)->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
}