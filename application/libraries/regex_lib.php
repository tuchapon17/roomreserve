<?php
class Regex_lib extends CI_Form_validation
{
	function __construct()
	{
	
	}
	function regex_zerofirst($data)
	{
		/*#################################################
		 Begin with 0
		for thai Phone
		###################################################*/
		$CI =& get_instance();
		$pattern="/^[0][0-9]+$/";
		//$CI->form_validation->set_message('regex_zerofirst',"%s - ต้องขึ้นต้นด้วยอักษรภาษาอังกฤษ");
		$rs=preg_match($pattern,$data,$matchOutput);
		if($rs == 1):
			return true;
		else:
			return false;
		endif;
	}
	function regex_house_no($data)
	{
		/*#################################################
			House no num/num or num
		###################################################*/
		$pattern="/^([0-9]|([0-9]\/[0-9]))+$/";
		//$this->form_validation->set_message('regex_house_no',"%s - รูปแบบไม่ถูกต้อง");
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
		//$this->form_validation->set_message('regex_charTHEN',"%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ");
		$rs=preg_match($pattern,$data,$matchOutput);
		if($rs == 1):
		return true;
		else:
		return false;
		endif;
	}
	function regex_decimal($data,$max_length)
	{
		//  /^([0-9]{1,6})(\.[0-9]{1,2})?$/
		$pattern="/^([0-9]{1,".$max_length[0]."})(\.[0-9]{1,".$max_length[1]."})?$/";
		$rs=preg_match($pattern,$data,$matchOutput);
		if($rs == 1) return true;
		else return false;
	}
}