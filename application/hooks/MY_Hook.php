<?php
class MY_Hook
{
	var $ci;
	var $hm;
	function MY_Hook()
	{
		$this->ci =& get_instance();
		
	}
	function is_loggedin()
	{
		if(!$this->ci->session->userdata("rs_username"))
		{
			redirect(base_url()."?c=login&m=auth");
		}
	}
	function check_group_privilege()
	{
		if($this->ci->session->userdata("rs_username"))
		{
			
		}
	}
	function test()
	{
		$this->ci->load->model("hook_model");
		$this->hm=$this->ci->hook_model;
		$this->hm->get_group_privilege();
	}
}