<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
		$this->load->library("page_element_lib");
		/*$this->label_name_th = array(
				"username"=>"ชื่อผู้เข้าใช้",
				"password"=>"รหัสผ่าน",
				"password2"=>"ยืนยันรหัสผ่าน",
				"email"=>"อีเมล",
				"firstname"=>"ชื่อ",
				"lastname"=>"นามสกุล",
				"in_occupation"=>"ระบุอาชีพอื่นๆ",
				"phone"=>"เบอร์โทรศัพท์",
				"house_no"=>"บ้านเลขที่",
				"village_no"=>"หมู่ที่",
				"alley"=>"ตรอก/ซอย",
				"road"=>"ถนน",
				"se_titlename"=>"คำนำหน้าชื่อ",
				"se_occupation"=>"อาชีพ",
				"se_province"=>"จังหวัด",
				"se_district"=>"อำเภอ/เขต",
				"se_subdistrict"=>"ตำบล/แขวง"
		);*/
	}
	function index()
	{
	}
	function step1()
	{
		//$label_name_th=$this->label_name_th;
		
		$this->load->model("element_model");
		$emm=$this->element_model;
		
		$this->load->library('element_lib');
		$eml=$this->element_lib;
		
		$this->load->library("form_validation");
		$frm=$this->form_validation;
		
		$config=array(
				array(
						"field"=>$this->lang->line("regis_in_username"),
						"label"=>$this->lang->line("label_username"),
						"rules"=>"required|max_length[15]|min_length[5]|callback_regex_charfirst|callback_already_exist"
				),
				array(
						"field"=>$this->lang->line("regis_in_password"),
						"label"=>$this->lang->line("label_password"),
						"rules"=>"required|max_length[15]|min_length[5]|callback_find_space"
				),
				array(
						"field"=>$this->lang->line("regis_in_password2"),
						"label"=>$this->lang->line("label_password2"),
						"rules"=>"required|max_length[15]|min_length[5]|matches[input_password]"
				),
				array(
						"field"=>$this->lang->line("regis_in_email"),
						"label"=>$this->lang->line("label_email"),
						"rules"=>"required|valid_email|max_length[128]"
				),
				array(
						"field"=>$this->lang->line("regis_in_firstname"),
						"label"=>$this->lang->line("label_firstname"),
						"rules"=>"required|max_length[40]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				),
				array(
						"field"=>$this->lang->line("regis_in_lastname"),
						"label"=>$this->lang->line("label_lastname"),
						"rules"=>"required|max_length[40]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				),
				array(
						"field"=>$this->lang->line("regis_in_phone"),
						"label"=>$this->lang->line("label_phone"),
						"rules"=>"required|max_length[10]|min_length[9]|callback_call_lib[regex_lib,regex_zerofirst,%s - รูปแบบไม่ถูกต้อง]"
				),
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
						"field"=>$this->lang->line("regis_in_occupation"),
						"label"=>$this->lang->line("label_occupation"),
						"rules"=>"max_length[30]"
				),
				array(
						"field"=>$this->lang->line("regis_se_titlename"),
						"label"=>$this->lang->line("label_se_titlename"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("regis_se_occupation"),
						"label"=>$this->lang->line("label_se_occupation"),
						"rules"=>"required|callback_selected_other"
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
			/*initial  create element with element_lib*/

			$in_username=array(
					"LB_text"=>$this->lang->line("label_username"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_username"),
					"IN_id"=>$this->lang->line("regis_in_username"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_username")),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>'5-15 ตัวอักษร และขึ้นต้นด้วยตัวอักษรภาษาอังกฤษ เช่น username, user123'
			);
			$in_password=array(
					"LB_text"=>$this->lang->line("label_password"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_password"),
					"IN_id"=>$this->lang->line("regis_in_password"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_password")),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>$this->lang->line("5_15char")
			);
			$in_password2=array(
					"LB_text"=>$this->lang->line("label_password2"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'password',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_password2"),
					"IN_id"=>$this->lang->line("regis_in_password2"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_password2")),
					"IN_attr"=>'maxlength="15"',
					"help_text"=>$this->lang->line("5_15char")
			);
			$in_email=array(
					"LB_text"=>$this->lang->line("label_email"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_email"),
					"IN_id"=>$this->lang->line("regis_in_email"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_email")),
					"IN_attr"=>'maxlength="128"',
					"help_text"=>'เช่น example@hotmail.com, example@gmail.com'
			);
			$in_firstname=array(
					"LB_text"=>$this->lang->line("label_firstname"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_firstname"),
					"IN_id"=>$this->lang->line("regis_in_firstname"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_firstname")),
					"IN_attr"=>'maxlength="40"',
					"help_text"=>$this->lang->line("THENchar")
			);
			$in_lastname=array(
					"LB_text"=>$this->lang->line("label_lastname"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_lastname"),
					"IN_id"=>$this->lang->line("regis_in_lastname"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_lastname")),
					"IN_attr"=>'maxlength="40"',
					"help_text"=>$this->lang->line("THENchar")
			);
			$in_occupation=array(
					"LB_text"=>$this->lang->line("label_in_occupation"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_occupation"),
					"IN_id"=>$this->lang->line("regis_in_occupation"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_occupation")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>''
			);
			$in_phone=array(
					"LB_text"=>$this->lang->line("label_phone"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_phone"),
					"IN_id"=>$this->lang->line("regis_in_phone"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_phone")),
					"IN_attr"=>'maxlength="10"',
					"help_text"=>'เช่น 087653210, 055123456'
			);
			$in_house_no=array(
					"LB_text"=>$this->lang->line("label_house_no"),
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("regis_in_house_no"),
					"IN_id"=>$this->lang->line("regis_in_house_no"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("regis_in_house_no")),
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
					"IN_value"=>set_value($this->lang->line("regis_in_village_no")),
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
					"IN_value"=>set_value($this->lang->line("regis_in_alley")),
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
					"IN_value"=>set_value($this->lang->line("regis_in_road")),
					"IN_attr"=>'maxlength="25"',
					"help_text"=>''
			);
			$se_titlename=array(
					"LB_text"=>$this->lang->line("label_se_titlename"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_titlename"),
					"S_id"=>$this->lang->line("regis_se_titlename"),
					"S_old_value"=>$this->input->post($this->lang->line("regis_se_titlename")),
					"S_data"=>$emm->select_titlename(),
					"S_id_field"=>"titlename_id",
					"S_name_field"=>"titlename",
					"help_text"=>''
			);
			$se_occupation=array(
					"LB_text"=>$this->lang->line("label_se_occupation"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_occupation"),
					"S_id"=>$this->lang->line("regis_se_occupation"),
					"S_old_value"=>$this->input->post($this->lang->line("regis_se_occupation")),
					"S_data"=>$emm->select_occupation(),
					"S_id_field"=>"occupation_id",
					"S_name_field"=>"occupation_name",
					"help_text"=>''
			);
			$se_province=array(
					"LB_text"=>$this->lang->line("label_se_province"),
					"LB_attr"=>$eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("regis_se_province"),
					"S_id"=>$this->lang->line("regis_se_province"),
					"S_old_value"=>$this->input->post($this->lang->line("regis_se_province")),
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
					"S_old_value"=>$this->input->post($this->lang->line("regis_se_district")),
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
					"S_old_value"=>$this->input->post($this->lang->line("regis_se_subdistrict")),
					"S_data"=>"",
					"S_id_field"=>"subdistrict_id",
					"S_name_field"=>"subdistrict_name",
					"help_text"=>''
			);
			/*-*initial attr for create element with element_lib*/
			
			$pel=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$pel->htmlopen(),
					"head"=>$pel->head("สมัครสมาชิก"),
					"bodyopen"=>$pel->bodyopen(),
					"navbar"=>$pel->navbar(),
					"js"=>$pel->js(),
					"footer"=>$pel->footer(),
					"bodyclose"=>$pel->bodyclose(),
					"htmlclose"=>$pel->htmlclose(),
					
					"in_username"=>$eml->form_input($in_username),
					"in_password"=>$eml->form_input($in_password),
					"in_password2"=>$eml->form_input($in_password2),
					"in_email"=>$eml->form_input($in_email),
					"in_firstname"=>$eml->form_input($in_firstname),
					"in_lastname"=>$eml->form_input($in_lastname),
					"in_occupation"=>$eml->form_input($in_occupation),
					"in_phone"=>$eml->form_input($in_phone),
					"in_house_no"=>$eml->form_input($in_house_no),
					"in_village_no"=>$eml->form_input($in_village_no),
					"in_alley"=>$eml->form_input($in_alley),
					"in_road"=>$eml->form_input($in_road),
					"se_titlename"=>$eml->form_select($se_titlename),
					"se_occupation"=>$eml->form_select($se_occupation),
					"se_province"=>$eml->form_select($se_province),
					"se_district"=>$eml->form_select($se_district),
					"se_subdistrict"=>$eml->form_select($se_subdistrict)
			);
			$this->load->view("register1",$data);
		}
		else 
		{	
			$this->load->model("register_model");
			$rgm=$this->register_model;
			$rgm->add_user();
		}
	}
		
	/******************************/
	function select_district()
	{
		/*#################################################
		 Return district list as JSON 
		 SELECT * FROM tb_district WHERE district_id LIKE 'province_id%' ORDER BY ....
		###################################################*/
		$this->load->model("element_model");
		$emm=$this->element_model;
		if($this->input->post("province_id")!=''):
			$query=$emm->select_district($this->input->post("province_id"));
			$data='';
			if($query>0):
				foreach($query AS $ar):
					$data.="<option value='".$ar['district_id']."'>".$ar['district_name']."</option>";
				endforeach;
			endif;
			echo json_encode(array("district_list"=>$data));
		else: echo "";
		endif;
	}
	function select_subdistrict()
	{
		/*#################################################
		Return subdistrict list as JSON
		SELECT * FROM tb_subdistrict WHERE subdistrict_id LIKE 'district_id%' ORDER BY ....
		###################################################*/
		$this->load->model("element_model");
		$emm=$this->element_model;
		if($this->input->post("district_id")!=''):
			$query=$emm->select_subdistrict($this->input->post("district_id"));
			$data='';
			if($query>0):
				foreach($query AS $ar):
					$data.="<option value='".$ar['subdistrict_id']."'>".$ar['subdistrict_name']."</option>";
				endforeach;
			endif;
			echo json_encode(array("subdistrict_list"=>$data));
			else: echo "";
		endif;
	}
	function regex_charfirst($data)
	{
		/*#################################################
		Begin with EN charactor
		for Username
		###################################################*/
		$pattern="/^[a-zA-Z][a-zA-Z0-9]+$/";
		$this->form_validation->set_message('regex_charfirst',"%s - ต้องขึ้นต้นด้วยอักษรภาษาอังกฤษ");
		$rs=preg_match($pattern,$data,$matchOutput);
		if($rs == 1):
			return true;
		else:
			return false;
		endif;
	}
	function regex_charTHEN($data)
	{
		/*#################################################
		 Allow ENG & TH Charactor
		 for Firstname & Lastname
		###################################################*/
		$pattern="/^[a-zA-Zก-ํ]+$/u";
		$this->form_validation->set_message('regex_charTHEN',"%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ");
		$rs=preg_match($pattern,$data,$matchOutput);
		if($rs == 1):
			return true;
		else:
			return false;
		endif;
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
	function selected_other($data)
	{
		/*#################################################
		If seleced otherOccupation from <select>
		###################################################*/
		$this->form_validation->set_message("selected_other","%s - กรุณาระบุอาชีพอื่นๆ");
		if($data=="00") 
		{
			if(strlen(trim($this->input->post($this->lang->line("regis_in_occupation"))))<1)return false;
			else return true;
		}
		else if($data!="00" && $data!="")
		{
			return true;
		}
		else return false;
	}
	function find_space($data)
	{
		/*#################################################
		Find space in string
		###################################################*/
		$this->form_validation->set_message("find_space","%s - มีช่องว่าง");
		if(strpos($data," ")==true) return false;
		else return true;
	}
	function already_exist($data)
	{
		/*#################################################
		Check Username already exist
		###################################################*/
		$this->form_validation->set_message("already_exist","%s - มีอยู่แล้ว ไม่สามารถใช้ได้");
		$this->load->model("register_model");
		$rgm=$this->register_model;
		return $rgm->username_already_exist($data);
	}
	
}