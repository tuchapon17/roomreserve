<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
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
}
?>