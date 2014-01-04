<?php
class Function_lib
{
	var $ci;
	function __construct()
	{
		$this->ci =& get_instance();
	}
	
	function check_group_privilege($privilege,$is=false,$operator="AND")
	{
		$enable=true;
		if($enable)
		{
			$error_num=0;
			$this->ci->load->model("login_model");
			$lm=$this->ci->login_model;
			$privilege_array=array();
			if(!is_array($privilege))$privilege=array($privilege);
			if($this->ci->session->userdata("rs_username"))
			{
				//foreach($lm->get_group_privilege() as $gp)
				foreach($lm->get_user_privilege() as $gp)
				{
					array_push($privilege_array, $gp['tb_privilege_id']);
				}
				if(strtoupper($operator)=="AND")
				{
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
							<p><a href='".base_url()."'>หน้าแรก</a>".nbs(4)."<a href='".@$_SERVER['HTTP_REFERER']."'>ย้อนกลับ</a></p>
							");
						}
					}
					else
					{
						if($is) return true;
					}
				}
				else if(strtoupper($operator)=="OR")
				{
					foreach($privilege as $p)
					{
						if(in_array($p, $privilege_array))
						{
							$error_num++;
						}
					}
					if($error_num==0)
					{
						if($is) return false;
						else
						{
							show_error("
							<p>ขออภัย คุณไม่มีสิทธิ์เข้าใช้หน้านี้</p>
							<p><a href='".base_url()."'>หน้าแรก</a>".nbs(4)."<a href='".@$_SERVER['HTTP_REFERER']."'>ย้อนกลับ</a></p>
							");
						}
					}
					else
					{
						if($is) return true;
					}
				}
				
			}
			else
			{
				if($is) return false;
				else
				{
					$this->ci->session->set_flashdata("login_message","กรุณาเข้าสู่ระบบ");
					redirect(base_url()."?c=login&m=auth");
				}
				
			}
		}
	}
	function check_loggedin()
	{
		if(!$this->ci->session->userdata("rs_username"))
		{
			$this->ci->session->set_flashdata("login_message","กรุณาเข้าสู่ระบบ");
			redirect(base_url()."?c=login&m=auth");
		}
	}
}