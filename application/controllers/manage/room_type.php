<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_type extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/room_type_model");
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}
	function add()
	{
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		$config=array(
		
				array(
						"field"=>"input_room_type",
						"label"=>"ประเภทห้อง",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$in_room_type_name="input_room_type";
			$in_room_type=array(
					"LB_text"=>"ประเภทห้อง",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_type_name,
					"IN_id"=>$in_room_type_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_type_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มประเภทห้อง"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"room_type_tab"=>$this->room_type_tab(),
					"in_room_type"=>$eml->form_input($in_room_type)
			);
				
			$this->load->view("manage/room_type/add_room_type",$data);
		}
		else
		{
			
			$actm=$this->room_type_model;
			//$data[] to insert new room_type
			$data=array(
					"room_type_id"=>$actm->get_maxid(2, "room_type_id", "tb_room_type"),
					"room_type_name"=>$this->input->post("input_room_type")
			);
			$redirect_link="?d=manage&c=room_type&m=add";
			$actm->manage_add($dat,"tb_room_type",$redirect_link,$redirect_link,"room_type","เพิ่มข้อมูลประเภทห้องสำเร็จ","เพิ่มข้อมูลประเภทห้องไม่สำเร็จ");
		}
	}
	function edit()
	{
		$actm=$this->room_type_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		$config=array(
				array(
						"field"=>"input_room_type",
						"label"=>"ประเภทห้อง",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			if(!$this->session->userdata("orderby_room_type"))
				$this->session->set_userdata("orderby_room_type",array("field"=>"room_type_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['base_url']=base_url()."?d=manage&c=room_type&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
				
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
				
			if($this->session->userdata("search_room_type"))
			{
				$liketext=$this->session->userdata("search_room_type");
				$config['total_rows']=$actm->get_all_numrows("tb_room_type",$liketext,"room_type_name");
				$get_room_type_list=$actm->get_room_type_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$actm->get_all_numrows("tb_room_type",'',"room_type_name");
				$get_room_type_list=$actm->get_room_type_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
				
			//..pagination
				
			$in_room_type_name="input_room_type";
			$in_room_type=array(
					"LB_text"=>"ประเภทห้อง",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_type_name,
					"IN_id"=>$in_room_type_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_type_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$PEL=$this->page_element_lib;
				
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มประเภทห้อง"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"room_type_tab"=>$this->room_type_tab(),
					"in_room_type"=>$eml->form_input($in_room_type),
					"table_edit"=>$this->table_edit($get_room_type_list),
					"session_search_room_type"=>$this->session->userdata("search_room_type"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_room_type"))
			);
			$this->load->view("manage/room_type/edit_room_type",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_room_type_id";
			$set=array(
					"room_type_name"=>$this->input->post("input_room_type")
			);
			$where=array(
					"room_type_id"=>$this->session->userdata($session_edit_id)
			);
			$actm->manage_edit($set, $where, "tb_room_type", $session_edit_id, "edit_room_type", "แก้ไขประเภทห้องสำเร็จ", "แก้ไขประเภทห้องไม่สำเร็จ", "?d=manage&c=room_type&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$actm=$this->room_type_model;
		$actm->manage_delete($this->input->post("del_room_type"), "tb_room_type", "room_type_id", "room_type_name", "edit_room_type", "?d=manage&c=room_type&m=edit");
	}
	
	
	
	
	
	
	
	function room_type_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มประเภทห้อง</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบประเภทห้อง</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_room_type',$this->input->post("input_search_box"));
				
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_room_type");
		}
		redirect(base_url()."?d=manage&c=room_type&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_room_type")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png"';
		else if($this->session->userdata("orderby_room_type")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png"';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ประเภทห้อง</th>
				<th class="same_first_td">แก้ไข</th>
				<th><input type="checkbox" id="del_all_room_type"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=room_type&m=delete" id="form_del_room_type">';
		if(!empty($data))
		{	//<td>'.$num_row.'</td>
			foreach ($data AS $dt):
			$html.='<tr>
					<td>'.$dt["room_type_id"].'</td>
					<td id="room_type'.$dt["room_type_id"].'">'.$dt["room_type_name"].'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=load_room_type("'.$dt["room_type_id"].'")>แก้ไข</button></td>
					<td><input type="checkbox" value="'.$dt["room_type_id"].'" name="del_room_type[]" class="del_room_type"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><button type="submit" class="btn btn-danger" onclick="show_del_list();return false;">ลบ</button></td>
				</tr>
				</table>
				</form>';
		$html.=$this->pagination->create_links();
		return $html;
	}
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_room_type",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_room_type()
	{
	
		$actm=$this->room_type_model;
		echo json_encode($actm->load_room_type($this->input->post("tid"))[0]);
	}
}