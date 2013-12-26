<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_log extends MY_Controller
{
	var $al_model;
	function __construct()
	{
		parent::__construct();
		$this->load->model("manage/auth_log_model");
		$this->al_model=$this->auth_log_model;
	}
	function edit()
	{
		$config=array(
				array(
						"field"=>"",
						"label"=>"บันทึกการเข้าสู่ระบบ",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_auth_log"))
				$this->session->set_userdata("orderby_auth_log",array("field"=>"auth_log_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=auth_log&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
			//ตำแหน่งหน้าที่แสดงข้อมูล
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
			//field ที่ค้นหา
			$searchfield=$this->check_searchfield("searchfield_auth_log", "tb_user_username");
			//if($this->session->userdata("searchfield_auth_log")) $searchfield=$this->session->userdata("searchfield_auth_log");
			//else $searchfield="tb_user_username";
			
			//ถ้ามี การค้นหา
			if($this->session->userdata("search_auth_log"))
			{
				$liketext=$this->session->userdata("search_auth_log");
				$config['total_rows']=$this->al_model->get_all_numrows("tb_auth_log",$liketext,$searchfield);
	
				$get_auth_log_list=$this->al_model->get_auth_log_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->al_model->get_all_numrows("tb_auth_log",'',$searchfield);
	
				$get_auth_log_list=$this->al_model->get_auth_log_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
	
			//..pagination
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  สาขาวิชา/งาน"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"auth_log_tab"=>$this->auth_log_tab(),
					
					"table_edit"=>$this->table_edit($get_auth_log_list),
					"session_search_auth_log"=>$this->session->userdata("search_auth_log"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_auth_log"))
			);
			$this->load->view("manage/auth_log/edit_auth_log",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_auth_log_id";
			$set=array(
					"auth_log_name"=>$this->input->post("input_auth_log_name")
			);
			$where=array(
					"auth_log_id"=>$this->session->userdata($session_edit_id)
			);
			$this->al_model->manage_edit($set, $where, "tb_auth_log", $session_edit_id, "edit_auth_log", "แก้ไขสาขาวิชา/งานสำเร็จ", "แก้ไขสาขาวิชา/งานไม่สำเร็จ", "?d=manage&c=auth_log&m=edit", $prev_url);
		}
	}
	
	
	
	function auth_log_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			';
		$html.='
			<li><a href="#"  id="edit">จัดการบันทึกการเข้าสู่ระบบ</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box")!='')
		{
			$this->session->set_userdata('search_auth_log',$this->input->post("input_search_box"));
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_auth_log");
		}
		redirect(base_url()."?d=manage&c=auth_log&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_auth_log")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_auth_log")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ชื่อผู้ใช้</th>
				<th>IPที่เข้าสู่ระบบ</th>
				<th>วัน/เวลาที่เข้าสู่ระบบ</th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=auth_log&m=delete" id="form_del_auth_log">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			$html.='<tr>
					<td>'.$dt["auth_log_id"].'</td>
					<td id="auth_log'.$dt["auth_log_id"].'">'.$dt["tb_user_username"].'</td>
					<td>'.$dt["ip_address"].'</td>
					<td>'.$dt["login_on"].'</td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='
				</table>
				</form>';
		$html.=$this->pagination->create_links();
		return $html;
	}
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_auth_log",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function set_searchfield()
	{
		if($this->input->post("searchfield"))
		{
			$this->session->set_userdata("searchfield_auth_log",$this->input->post("searchfield"));
		}
	}
}