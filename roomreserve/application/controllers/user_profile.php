<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_profile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
		$this->load->library("page_element_lib");
	}
	function view_profile()
	{
		$this->check_loggedin();
		/*#################################################
		 * access rules for view user profile
		#################################################*/
		//If don't have $_GET["vuser"] but has logged in > redirect with $_GET["vuser"]
		if(!isset($_GET["vuser"]) && $this->session->userdata("rs_username"))
			redirect(base_url()."?c=user_profile&m=view_profile&vuser=".$this->session->userdata("rs_username"));
		//If not set $_GET["vuser"] or not logged in
		if(!isset($_GET["vuser"]) || !$this->session->userdata("rs_username")) show_404();		
		
		$this->load->library('element_lib');
		$eml=$this->element_lib;
		
		$PEL=$this->page_element_lib;
		$data=array(
				"htmlopen"=>$PEL->htmlopen(),
				"head"=>$PEL->head("ข้อมูลส่วนตัว"),
				"bodyopen"=>$PEL->bodyopen(),
				"navbar"=>$PEL->navbar(),
				"js"=>$PEL->js(),
				"footer"=>$PEL->footer(),
				"bodyclose"=>$PEL->bodyclose(),
				"htmlclose"=>$PEL->htmlclose(),
				"profile_tab"=>$this->profile_tab()
		);
		
		$this->load->model("user_profile_model");
		$upm=$this->user_profile_model;
		//print_r($upm->user_profile());
		//echo $this->db->last_query();
		//break;

		/*#################################################
		Check query result if no result(count=0) will show 404 page
		###################################################*/
		if(count($upm->user_profile($_GET["vuser"])) == 0)  show_404();
		else $data=array_merge($data,$upm->user_profile($_GET["vuser"])[0]);
		
		$this->load->view("view_profile",$data);
		
	}
	function edit_profile1()
	{
		$this->check_loggedin();
		/*
		 * check ต้องมี session rs_username
		* */
		$this->load->library('element_lib');
		$eml=$this->element_lib;
		
		$this->load->model("user_profile_model");
		$upm=$this->user_profile_model;
		
		$this->load->library("form_validation");
		$frm=$this->form_validation;
		
		$config=array(
				
				array(
						"field"=>"input_email",
						"label"=>$this->lang->line("label_email"),
						"rules"=>"required|valid_email|max_length[128]"
				)
		);
		
		if($this->input->post("change_password")=="checked_pwd")
		{
			$config2=array(
					array(
							"field"=>"input_password0",
							"label"=>$this->lang->line("label_password0"),
							"rules"=>"required|max_length[15]|min_length[5]|callback_check_current_password"
					),
					array(
							"field"=>"input_password",
							"label"=>$this->lang->line("label_password"),
							"rules"=>"required|max_length[15]|min_length[5]|callback_find_space"
					),
					array(
							"field"=>"input_password2",
							"label"=>$this->lang->line("label_password2"),
							"rules"=>"required|max_length[15]|min_length[5]|matches[input_password]"
					)
			);
			$config=array_merge($config,$config2);
		}
		
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			/*initial  create element with element_lib*/
			$in_username_name="input_username";
			$in_username=array(
					"LB_text"=>$this->lang->line("label_username"),
					"LB_attr"=>'',
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_username_name,
					"IN_id"=>$in_username_name,
					"IN_PH"=>'',
					"IN_value"=>$this->session->userdata("rs_username"),
					"IN_attr"=>'maxlength="15" disabled',
					"help_text"=>''
			);
			$in_password_name0="input_password0";
			$in_password0=array(
					"LB_text"=>$this->lang->line("label_password0"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$in_password_name0,
					"IN_id"=>$in_password_name0,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_password_name0),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>$this->lang->line("5_15char")
			);
			$in_password_name="input_password";
			$in_password=array(
					"LB_text"=>$this->lang->line("label_password"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$in_password_name,
					"IN_id"=>$in_password_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_password_name),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>$this->lang->line("5_15char")
			);
			$in_password_name2="input_password2";
			$in_password2=array(
					"LB_text"=>$this->lang->line("label_password2"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$in_password_name2,
					"IN_id"=>$in_password_name2,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_password_name2),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>$this->lang->line("5_15char")
			);
			$in_email_name="input_email";
			$in_email=array(
					"LB_text"=>$this->lang->line("label_email"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_email_name,
					"IN_id"=>$in_email_name,
					"IN_PH"=>'',
					//get current email from user_profile_model->user_email()
					"IN_value"=>$upm->user_email($this->session->userdata("rs_username"))[0]["email"],
					"IN_attr"=>'maxlength="128"',
					"help_text"=>'เช่น example@hotmail.com, example@gmail.com'
			);
			/*-*initial attr for create element with element_lib*/
			
			$pel=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$pel->htmlopen(),
					"head"=>$pel->head("แก้ไขข้อมูลการเข้าใช้ระบบ"),
					"bodyopen"=>$pel->bodyopen(),
					"navbar"=>$pel->navbar(),
					"js"=>$pel->js(),
					"footer"=>$pel->footer(),
					"bodyclose"=>$pel->bodyclose(),
					"htmlclose"=>$pel->htmlclose(),
					"profile_tab"=>$this->profile_tab(),
					
					"in_username"=>$eml->form_input($in_username),
					"in_password0"=>$eml->form_input($in_password0),
					"in_password"=>$eml->form_input($in_password),
					"in_password2"=>$eml->form_input($in_password2),
					"in_email"=>$eml->form_input($in_email)
					
			);
			$this->load->view("edit_profile1",$data);
		}
		else 
		{	
			//$upm->
			$set=array(
					"email"=>$this->input->post("input_email")
			);
			if($this->input->post("change_password")=="checked_pwd")
			{
				$set2=array(
						"password"=>md5($this->input->post("input_password"))
				);
				$set=array_merge($set,$set2);
			}
			$upm->update_edit_profile1($set,$this->session->userdata("rs_username"));
		}
	}
	function edit_profile2()
	{
		$this->check_loggedin();
		/*
		 * check ต้องมี session rs_username
		 * */
			
		$this->load->library('element_lib');
		$eml=$this->element_lib;
	
		$this->load->model("user_profile_model");
		$upm=$this->user_profile_model;

		$this->load->model("element_model");
		$emm=$this->element_model;
		
		$this->load->library("form_validation");
		$frm=$this->form_validation;
	
		$config=array(
				array(
						"field"=>"select_titlename",
						"label"=>$this->lang->line("label_se_titlename"),
						"rules"=>"required"
				),
				array(
						"field"=>"input_firstname",
						"label"=>$this->lang->line("label_firstname"),
						"rules"=>"required|max_length[40]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				),
				array(
						"field"=>"input_lastname",
						"label"=>$this->lang->line("label_lastname"),
						"rules"=>"required|max_length[40]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				),
				array(
						"field"=>"input_occupation",
						"label"=>$this->lang->line("label_in_occupation"),
						"rules"=>"max_length[30]"
				),
				array(
						"field"=>"select_occupation",
						"label"=>$this->lang->line("label_se_occupation"),
						"rules"=>"required|callback_selected_other"
				)
		);

		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$current_data=$upm->get_edit_profile2($this->session->userdata("rs_username"))[0];
			//set session for occupation_id
			$this->session->set_userdata("update_profile2_occupation_id",$current_data["tb_occupation_id"]);
			/*initial  create element with element_lib*/
			$se_titlename_name="select_titlename";
			$se_titlename=array(
					"LB_text"=>$this->lang->line("label_se_titlename"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$se_titlename_name,
					"S_id"=>$se_titlename_name,
					"S_old_value"=>$current_data["tb_titlename_id"],
					"S_data"=>$emm->select_titlename(),
					"S_id_field"=>"titlename_id",
					"S_name_field"=>"titlename",
					"help_text"=>''
			);
			$in_firstname_name="input_firstname";
			$in_firstname=array(
					"LB_text"=>$this->lang->line("label_firstname"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_firstname_name,
					"IN_id"=>$in_firstname_name,
					"IN_PH"=>'',
					"IN_value"=>$current_data["firstname"],
					"IN_attr"=>'maxlength="40"',
					"help_text"=>$this->lang->line("THENchar")
			);
			$in_lastname_name="input_lastname";
			$in_lastname=array(
					"LB_text"=>$this->lang->line("label_lastname"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_lastname_name,
					"IN_id"=>$in_lastname_name,
					"IN_PH"=>'',
					"IN_value"=>$current_data["lastname"],
					"IN_attr"=>'maxlength="40"',
					"help_text"=>$this->lang->line("THENchar")
			);
			/*select occupation*/
			$in_occupation_name="input_occupation";
			$in_occupation=array(
					"LB_text"=>$this->lang->line("label_in_occupation"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_occupation_name,
					"IN_id"=>$in_occupation_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_occupation_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>''
			);
			$se_occupation_name="select_occupation";
			$se_occupation=array(
					"LB_text"=>$this->lang->line("label_se_occupation"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$se_occupation_name,
					"S_id"=>$se_occupation_name,
					"S_old_value"=>$current_data["tb_occupation_id"],
					"S_data"=>$emm->select_occupation(),
					"S_id_field"=>"occupation_id",
					"S_name_field"=>"occupation_name",
					"help_text"=>''
			);
			if($current_data["checked"]==0)
			{
				$in_occupation["IN_value"]=$current_data["occupation_name"];
				$se_occupation["S_old_value"]=00;
			}
			/*-*initial attr for create element with element_lib*/
				
			$pel=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$pel->htmlopen(),
					"head"=>$pel->head("แก้ไขข้อมูลส่วนตัว"),
					"bodyopen"=>$pel->bodyopen(),
					"navbar"=>$pel->navbar(),
					"js"=>$pel->js(),
					"footer"=>$pel->footer(),
					"bodyclose"=>$pel->bodyclose(),
					"htmlclose"=>$pel->htmlclose(),
					"profile_tab"=>$this->profile_tab(),
						
					"se_titlename"=>$eml->form_select($se_titlename),
					"in_firstname"=>$eml->form_input($in_firstname),
					"in_lastname"=>$eml->form_input($in_lastname),
					"in_occupation"=>$eml->form_input($in_occupation),
					"se_occupation"=>$eml->form_select($se_occupation)
			);
			$this->load->view("edit_profile2",$data);
		}
		else
		{
			$set=array(
					"tb_titlename_id"=>$this->input->post("select_titlename"),
					"firstname"=>$this->input->post("input_firstname"),
					"lastname"=>$this->input->post("input_lastname"),
					"tb_occupation_id"=>$this->input->post("select_occupation")
			);
			if($this->input->post("select_occupation")=="00")
			{
				unset($set["tb_occupation_id"]);
				$set_occupation=array(
						"occupation_name"=>$this->input->post("input_occupation")
				);
				$upm->update_occupation($set_occupation,$this->session->userdata("update_profile2_occupation_id"));
			}
			
			$upm->update_edit_profile2($set,$this->session->userdata("rs_username"));	
		}
	}
	function edit_profile3()
	{
		$this->check_loggedin();
		/*
		 * check session rs_username
		 * */
		$this->load->library('element_lib');
		$eml=$this->element_lib;
	
		$this->load->model("user_profile_model");
		$upm=$this->user_profile_model;

		$this->load->model("element_model");
		$emm=$this->element_model;
		
		$this->load->library("form_validation");
		$frm=$this->form_validation;
		
		$config=array(
				array(
						"field"=>$this->lang->line("regis_in_house_no"),
						"label"=>$this->lang->line("label_house_no"),
						"rules"=>"required|max_length[10]|callback_call_lib[regex_lib,regex_house_no,%s - รูปแบบไม่ถูกต้อง]"
				),
				array(
						"field"=>$this->lang->line("regis_in_village_no"),
						"label"=>$this->lang->line("label_village_no"),
						"rules"=>"max_length[2]|numeric"
				),
				array(
						"field"=>$this->lang->line("regis_in_alley"),
						"label"=>$this->lang->line("label_alley"),
						"rules"=>"max_length[30]"
				),
				array(
						"field"=>$this->lang->line("regis_in_road"),
						"label"=>$this->lang->line("label_road"),
						"rules"=>"max_length[25]"
				),
				array(
						"field"=>$this->lang->line("regis_se_province"),
						"label"=>$this->lang->line("label_se_province"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("regis_se_district"),
						"label"=>$this->lang->line("label_se_district"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("regis_se_subdistrict"),
						"label"=>$this->lang->line("label_se_subdistrict"),
						"rules"=>"required"
				)
		);
		
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$current_data=$upm->get_edit_profile3($this->session->userdata("rs_username"))[0];
			//set session for occupation_id
			//$this->session->set_userdata("update_profile2_occupation_id",$current_data["tb_occupation_id"]);
			/*initial  create element with element_lib*/
			$in_house_no=array(
					"LB_text"=>$this->lang->line("label_house_no"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_house_no"),
					"IN_id"=>$this->lang->line("regis_in_house_no"),
					"IN_PH"=>'',
					"IN_value"=>$current_data["house_no"],
					"IN_attr"=>'maxlength="10"',
					"help_text"=>'เช่น 78, 87/3, 1234/987'
			);
			$in_village_no=array(
					"LB_text"=>$this->lang->line("label_village_no"),
					"LB_attr"=>'',
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_village_no"),
					"IN_id"=>$this->lang->line("regis_in_village_no"),
					"IN_PH"=>'',
					"IN_value"=>$current_data["village_no"],
					"IN_attr"=>'maxlength="2"',
					"help_text"=>'เช่น 1, 99'
			);
			$in_alley=array(
					"LB_text"=>$this->lang->line("label_alley"),
					"LB_attr"=>'',
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_alley"),
					"IN_id"=>$this->lang->line("regis_in_alley"),
					"IN_PH"=>'',
					"IN_value"=>$current_data["alley"],
					"IN_attr"=>'maxlength="30"',
					"help_text"=>''
			);
			$in_road_name="input_road";
			$in_road=array(
					"LB_text"=>$this->lang->line("label_road"),
					"LB_attr"=>'',
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_road"),
					"IN_id"=>$this->lang->line("regis_in_road"),
					"IN_PH"=>'',
					"IN_value"=>$current_data["road"],
					"IN_attr"=>'maxlength="25"',
					"help_text"=>''
			);
			$se_province=array(
					"LB_text"=>$this->lang->line("label_se_province"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_province"),
					"S_id"=>$this->lang->line("regis_se_province"),
					"S_old_value"=>$current_data["tb_province_id"],
					"S_data"=>$emm->select_province(),
					"S_id_field"=>"province_id",
					"S_name_field"=>"province_name",
					"help_text"=>''
			);
			$se_district=array(
					"LB_text"=>$this->lang->line("label_se_district"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_district"),
					"S_id"=>$this->lang->line("regis_se_district"),
					"S_old_value"=>"",
					"S_data"=>"",
					"S_id_field"=>"district_id",
					"S_name_field"=>"district_name",
					"help_text"=>''
			);
			$se_subdistrict=array(
					"LB_text"=>$this->lang->line("label_se_subdistrict"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_subdistrict"),
					"S_id"=>$this->lang->line("regis_se_subdistrict"),
					"S_old_value"=>"",
					"S_data"=>"",
					"S_id_field"=>"subdistrict_id",
					"S_name_field"=>"subdistrict_name",
					"help_text"=>''
			);
			/*-*initial attr for create element with element_lib*/
		
			$pel=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$pel->htmlopen(),
					"head"=>$pel->head("แก้ไขข้อมูลส่วนตัว"),
					"bodyopen"=>$pel->bodyopen(),
					"navbar"=>$pel->navbar(),
					"js"=>$pel->js(),
					"footer"=>$pel->footer(),
					"bodyclose"=>$pel->bodyclose(),
					"htmlclose"=>$pel->htmlclose(),
					"profile_tab"=>$this->profile_tab(),
		
					"in_house_no"=>$eml->form_input($in_house_no),
					"in_village_no"=>$eml->form_input($in_village_no),
					"in_alley"=>$eml->form_input($in_alley),
					"in_road"=>$eml->form_input($in_road),
					"se_province"=>$eml->form_select($se_province),
					"se_district"=>$eml->form_select($se_district),
					"se_subdistrict"=>$eml->form_select($se_subdistrict),
					
					"current_district_id"=>$current_data["tb_district_id"],
					"current_subdistrict_id"=>$current_data["tb_subdistrict_id"]
			);
			$this->load->view("edit_profile3",$data);
		}
		else
		{
			$set=array(
					"house_no"=>$this->input->post("input_house_no"),
					"village_no"=>$this->input->post("input_village_no"),
					"alley"=>$this->input->post("input_alley"),
					"road"=>$this->input->post("input_road"),
					"tb_province_id"=>$this->input->post("select_province"),
					"tb_district_id"=>$this->input->post("select_district"),
					"tb_subdistrict_id"=>$this->input->post("select_subdistrict")
			);
			$upm->update_edit_profile3($set,$this->session->userdata("rs_username"));	
		}
	}
	function profile_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="profiletab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="view_profile">ข้อมูลส่วนตัว</a></li>';
			
			if($this->session->userdata("rs_username"))
			{  
		$html.='<li><a href="#" data-toggle="pill" id="edit_profile1">แก้ไขข้อมูลการเข้าใช้ระบบ</a></li>
			<li><a href="#"  id="edit_profile2">แก้ไขข้อมูลส่วนตัว</a></li>
			<li><a href="#"  id="edit_profile3">แก้ไขข้อมูลที่อยู่</a></li>
			';
			}
		$html.='</ul>';
		return $html;
	}
	function check_current_password($data)
	{
		$this->form_validation->set_message("check_current_password","%s - รหัสผ่านเดิมไม่ถูกต้อง");
		$this->load->model("user_profile_model");
		$upm=$this->user_profile_model;
		return $upm->check_current_password($data);
	}

	function selected_other($data)
	{
		/*#################################################
			If seleced otherOccupation from <select>
		###################################################*/
		$this->form_validation->set_message("selected_other","%s - กรุณาระบุอาชีพอื่นๆ");
		if($data=="00") 
		{
			if(strlen(trim($this->input->post("input_occupation")))<1)return false;
			else return true;
		}
		else if($data!="00")
		{
			return true;
		}
		else return false;
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
	function check_loggedin()
	{
		if(!$this->session->userdata("rs_username"))
		{
			//return false;
			redirect(base_url()."?c=login&m=auth");
		}
	}
}