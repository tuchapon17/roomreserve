<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_has_article_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function get_room_has_article_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_room_has_article")["field"];
		$orderby_type=$this->session->userdata("orderby_room_has_article")["type"];
		
		//isset search session
		$searchfield=$this->check_searchfield("searchfield_room_has_article", "room_name");
	
		$sql_select="tb_room_has_article.*,tb_room.room_name,tb_article.article_name,tb_fee_type.fee_type_name";
		$table_name="tb_room_has_article";
		if($liketext!='')
		{
			$query=$this->db->select($sql_select)->from($table_name)->join("tb_room","tb_room_has_article.tb_room_id=tb_room.room_id")->join("tb_article","tb_room_has_article.tb_article_id=tb_article.article_id")->join("tb_fee_type","tb_room_has_article.tb_fee_type_id=tb_fee_type.fee_type_id")->like($searchfield,$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
			
		}
		else
		{
			$query=$this->db->select($sql_select)->from($table_name)->join("tb_room","tb_room_has_article.tb_room_id=tb_room.room_id")->join("tb_article","tb_room_has_article.tb_article_id=tb_article.article_id")->join("tb_fee_type","tb_room_has_article.tb_fee_type_id=tb_fee_type.fee_type_id")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
			
		}
		//echo $this->db->last_query();break;
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function load_room_has_article($room_id,$article_id)
	{
		//for json
		//set session for update
		$this->session->set_userdata("edit_room_has_article_id",$room_id.",".$article_id);
		$this->db->select()->from("tb_room_has_article")->where("tb_room_id",$room_id)->where("tb_article_id",$article_id)->limit(1);
		return $this->db->get()->result_array();
	}
	function get_all_numrows_rha($table,$liketext='',$like_field)
	{
		if($liketext=='')return $this->db->count_all($table);
		else
		{
			return $this->db->from($table)->join("tb_room","tb_room_has_article.tb_room_id=tb_room.room_id")->join("tb_article","tb_room_has_article.tb_article_id=tb_article.article_id")->join("tb_fee_type","tb_room_has_article.tb_fee_type_id=tb_fee_type.fee_type_id")->like($like_field,$liketext,"both")->get()->num_rows();
		}
	}
	function delete_rha($arr_id, $table, $field_PK, $select_field, $message_type='', $main_url='')
	{
		$edit_titlename_message='';
		$this->db->trans_begin();
		foreach($arr_id AS $id):
		// multiple PK >> "PK1,PK2"
		$id_arr=explode(',',$id);
		$field_PK_arr=explode(',',$field_PK);
		$select_field_arr=explode(',',$select_field);
		$where=array(
				$field_PK_arr[0]=>$id_arr[0],
				$field_PK_arr[1]=>$id_arr[1]
		);
		$name=$this->db->select($select_field)->from($table)->join("tb_room","tb_room_has_article.tb_room_id=tb_room.room_id")->join("tb_article","tb_room_has_article.tb_article_id=tb_article.article_id")->where($where)->limit(1)->get()->result_array();
		$this->db->delete($table,$where);
		if($this->db->trans_status()===FALSE):
		$this->db->trans_rollback();
				$edit_titlename_message.="<p class='text-danger'>ลบ ".$name[0][$select_field_arr[0]]." ".$name[0][$select_field_arr[1]]." ไม่สำเร็จ</p>";
		else:
		$this->db->trans_commit();
				$edit_titlename_message.="<p class='text-success'>ลบ ".$name[0][$select_field_arr[0]]." ".$name[0][$select_field_arr[1]]." สำเร็จ</p>";
			endif;
		endforeach;
		$this->session->set_flashdata($message_type."_message",$edit_titlename_message);
		redirect(base_url().$main_url);
	}
}