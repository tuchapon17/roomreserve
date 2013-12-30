<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	//element_model
	public $emm;
	
	//element_lib
	public $eml;
	
	//page_element_lib
	public $pel;
	
	//form_validation
	public $frm;
	
	function __construct()
	{
		parent::__construct();
		$this->eml=$this->element_lib;
		$this->frm=$this->form_validation;
		$this->pel=$this->page_element_lib;
		$this->load->model("element_model");
		$this->emm=$this->element_model;
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}
	function call_lib($data,$param)
	{
		/*#################################################
		 * $param = library_name , method_in_library , error_message
		* $param_value=array(library_name , method_in_library , error_message);
		###################################################*/
		$param_value=explode(',',$param);
		$this->form_validation->set_message("call_lib",$param_value[2]);
		$this->load->library($param_value[0]);
		//send $data to method in library
		return $this->$param_value[0]->$param_value[1]($data);
	}
	function call_lib_with_data($data,$param)
	{
		/*#################################################
		 * $param = library_name , method_in_library , error_message
		* $param_value=array(library_name , method_in_library , error_message , data1&data2);
		###################################################*/
		$param_value=explode(',',$param);
		$send_data=explode('&',$param_value[3]);
		$this->form_validation->set_message("call_lib_with_data",$param_value[2]);
		$this->load->library($param_value[0]);
		//send $data to method in library
		return $this->$param_value[0]->$param_value[1]($data,$send_data);
	}
	function check_searchfield($sess_name,$default_field)
	{
		if($this->session->userdata($sess_name)) return $this->session->userdata($sess_name);
		else return $default_field;
	}
	function check_group_privilege($privilege,$is=false)
	{
		$enable=true;
		if($enable)
		{
			$error_num=0;
			$this->load->model("login_model");
			$lm=$this->login_model;
			$privilege_array=array();
			if($this->session->userdata("rs_username"))
			{
				foreach($lm->get_group_privilege() as $gp)
				{
					array_push($privilege_array, $gp['tb_privilege_id']);
				}
				foreach($privilege as $p)
				{
					if(!in_array($p, $privilege_array))
					{
						$error_num++;
					}
				}
				if($error_num>0)
				{
					if($is) return false;
					else 
					{
						show_error("
							<p>ขออภัย คุณไม่มีสิทธิ์เข้าใช้หน้านี้</p>
							<p><a href='".base_url()."'>หน้าแรก</a>".nbs(4)."<a href='".$_SERVER['HTTP_REFERER']."'>ย้อนกลับ</a></p>
							");
					}
				}
				else 
				{
					if($is) return true;
				}
			}
			else
			{
				if($is) return false;
				else redirect(base_url()."?c=login&m=auth");
			}
		}
	}
}
?>