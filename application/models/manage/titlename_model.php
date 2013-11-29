<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Titlename_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function add_titlename($data)
	{
		$this->db->trans_begin();
		/*#################################################
		 * insert
		#################################################*/
		//$new_id=$this->get_maxid(2, "titlename_id", "tb_titlename");
		
		$this->db->set($data)->insert('tb_titlename');
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
			$this->session->set_flashdata("titlename_status",false);
			$this->session->set_flashdata("titlename_message","<p class='text-danger'>เพิ่มคำนำหน้าชื่อไม่สำเร็จ</p>");
			redirect(base_url()."?d=manage&c=titlename&m=add");
		else:
			$this->db->trans_commit();
			$this->session->set_flashdata("titlename_status",true);
			$this->session->set_flashdata("titlename_message","<p class='text-success'>เพิ่มคำนำหน้าชื่อสำเร็จ</p>");
			redirect(base_url()."?d=manage&c=titlename&m=add");
		endif;
	}
	function edit_titlename($set,$prev_url)
	{
		if($this->session->userdata("edit_titlename_id"))
		{
			$where=array(
					"titlename_id"=>$this->session->userdata("edit_titlename_id")
			);
			$this->db->trans_begin();
				$this->db->update("tb_titlename",$set,$where);
			if($this->db->trans_status()===FALSE):
				$this->db->trans_rollback();
				$this->session->set_flashdata("edit_titlename_status",false);
				$this->session->set_flashdata("edit_titlename_message","<p class='text-danger'>แก้ไขคำนำหน้าชื่อ ไม่สำเร็จ</p>");
				redirect($prev_url);
				//echo "Register Error.";
			else:
				$this->db->trans_commit();
				$this->session->unset_userdata("edit_titlename_id");
				$this->session->set_flashdata("edit_titlename_status",true);
				$this->session->set_flashdata("edit_titlename_message","<p class='text-success'>แก้ไขคำนำหน้าชื่อ สำเร็จ</p>");
				redirect($prev_url);
			endif;
		}
		else
		{
			$this->session->set_flashdata("edit_titlename_status",false);
			$this->session->set_flashdata("edit_titlename_message","<p class='text-danger'>แก้ไขคำนำหน้าชื่อ ไม่สำเร็จ</p>");
			redirect(base_url()."?d=manage&c=titlename&m=edit");
		}
	}
	function delete_titlename($arr_id)
	{
		$edit_titlename_message='';
		$this->db->trans_begin();
		foreach($arr_id AS $id):
			$where=array(
					"titlename_id"=>$id
			);
			$name=$this->db->select("titlename")->from("tb_titlename")->where($where)->limit(1)->get()->result_array();
		
			$this->db->delete("tb_titlename",$where);
			if($this->db->trans_status()===FALSE):
				$this->db->trans_rollback();
				$edit_titlename_message.="<p class='text-danger'>ลบ ".$id." ".$name[0]["titlename"]." ไม่สำเร็จ</p>";
			else:
				$this->db->trans_commit();
				//$edit_titlename_message.="<p>ลบคำนำหน้าชื่อ ".$id." สำเร็จ</p>";
				$edit_titlename_message.="<p class='text-success'>ลบ ".$id." ".$name[0]["titlename"]." สำเร็จ</p>";
			endif;
		endforeach;
		$this->session->set_flashdata("edit_titlename_message",$edit_titlename_message);
		redirect(base_url()."?d=manage&c=titlename&m=edit");
	}
	function get_titlename_list($perpage,$getpage=0,$liketext='')
	{
		$orderby_filed=$this->session->userdata("orderby_titlename")["field"];
		$orderby_type=$this->session->userdata("orderby_titlename")["type"];
		if($liketext!='')
		{
			$query=$this->db->select()->from("tb_titlename")->like("titlename",$liketext,"both")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		else 
		{
			$query=$this->db->select()->from("tb_titlename")->order_by("CONVERT(".$orderby_filed." USING TIS620)",$orderby_type)->limit($perpage,$getpage)->get();
		}
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function load_titlename($id)
	{
		//for json
		//set session for update 
		$this->session->set_userdata("edit_titlename_id",$id);
		$this->db->select()->from("tb_titlename")->where("titlename_id",$id)->limit(1);
		return $this->db->get()->result_array();
	}
	
}