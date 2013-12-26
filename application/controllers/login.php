<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function auth()
	{
		if($this->session->userdata("rs_username")) redirect(base_url());
		$config=array(
				array(
						"field"=>"input_username",
						"label"=>"ชื่อผู้เข้าใช้",
						"rules"=>"required"
				),
				array(
						"field"=>"input_password",
						"label"=>"รหัสผ่าน",
						"rules"=>"required"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_username_name="input_username";
			$in_username=array(
					"LB_text"=>"ชื่อผู้เข้าใช้",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_username_name,
					"IN_id"=>$in_username_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_username_name),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>''
			);
			$in_password_name="input_password";
			$in_password=array(
					"LB_text"=>"รหัสผ่าน",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$in_password_name,
					"IN_id"=>$in_password_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_password_name),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>''
			);
			
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("ลงชื่อเข้าใช้"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					
					"in_username"=>$this->eml->form_input($in_username),
					"in_password"=>$this->eml->form_input($in_password)
			);
			$this->load->view("login",$data);
		}
		else 
		{
			$this->load->model("login_model");
			$lm=$this->login_model;
			$login_result=$lm->check_auth();
			if($login_result==false)
			{
				$this->session->set_flashdata("login_message","ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
				redirect(base_url()."?c=login&m=auth");
			}
			else if($login_result==true)
			{
				redirect(base_url());
			}
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url()."?c=login&m=auth");
	}
}