<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Article_type extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/article_type_model");
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}
	function add()
	{
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		$config=array(
		
				array(
						"field"=>"input_article_type",
						"label"=>"ประเภทครุภัณฑ์/อุปกรณ์",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$in_article_type_name="input_article_type";
			$in_article_type=array(
					"LB_text"=>"ประเภทครุภัณฑ์/อุปกรณ์",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_article_type_name,
					"IN_id"=>$in_article_type_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_article_type_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มประเภทครุภัณฑ์/อุปกรณ์"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"article_type_tab"=>$this->article_type_tab(),
					"in_article_type"=>$eml->form_input($in_article_type)
			);
				
			$this->load->view("manage/article_type/add_article_type",$data);
		}
		else
		{
			
			$actm=$this->article_type_model;
			//$data[] to insert new article_type
			$data=array(
					"article_type_id"=>$actm->get_maxid(2, "article_type_id", "tb_article_type"),
					"article_type_name"=>$this->input->post("input_article_type")
			);
			$redirect_link="?d=manage&c=article_type&m=add";
			$actm->manage_add($data,"tb_article_type",$redirect_link,$redirect_link,"article_type","เพิ่มข้อมูลประเภทครุภัณฑ์/อุปกรณ์สำเร็จ","เพิ่มข้อมูลประเภทครุภัณฑ์/อุปกรณ์ไม่สำเร็จ");
		}
	}
	function edit()
	{
		$actm=$this->article_type_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		$config=array(
				array(
						"field"=>"input_article_type",
						"label"=>"ประเภทครุภัณฑ์/อุปกรณ์",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			if(!$this->session->userdata("orderby_article_type"))
				$this->session->set_userdata("orderby_article_type",array("field"=>"article_type_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['base_url']=base_url()."?d=manage&c=article_type&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
				
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
				
			if($this->session->userdata("search_article_type"))
			{
				$liketext=$this->session->userdata("search_article_type");
				$config['total_rows']=$actm->get_all_numrows("tb_article_type",$liketext,"article_type_name");
				$get_article_type_list=$actm->get_article_type_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$actm->get_all_numrows("tb_article_type",'',"article_type_name");
				$get_article_type_list=$actm->get_article_type_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
				
			//..pagination
				
			$in_article_type_name="input_article_type";
			$in_article_type=array(
					"LB_text"=>"ประเภทครุภัณฑ์/อุปกรณ์",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_article_type_name,
					"IN_id"=>$in_article_type_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_article_type_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$PEL=$this->page_element_lib;
				
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มประเภทครุภัณฑ์/อุปกรณ์"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"article_type_tab"=>$this->article_type_tab(),
					"in_article_type"=>$eml->form_input($in_article_type),
					"table_edit"=>$this->table_edit($get_article_type_list),
					"session_search_article_type"=>$this->session->userdata("search_article_type"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_article_type"))
			);
			$this->load->view("manage/article_type/edit_article_type",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_article_type_id";
			$set=array(
					"article_type_name"=>$this->input->post("input_article_type")
			);
			$where=array(
					"article_type_id"=>$this->session->userdata($session_edit_id)
			);
			$actm->manage_edit($set, $where, "tb_article_type", $session_edit_id, "edit_article_type", "แก้ไขประเภทครุภัณฑ์/อุปกรณ์สำเร็จ", "แก้ไขประเภทครุภัณฑ์/อุปกรณ์ไม่สำเร็จ", "?d=manage&c=article_type&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$actm=$this->article_type_model;
		$actm->manage_delete($this->input->post("del_article_type"), "tb_article_type", "article_type_id", "article_type_name", "edit_article_type", "?d=manage&c=article_type&m=edit");
	}
	
	
	
	
	
	
	
	function article_type_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มประเภทครุภัณฑ์/อุปกรณ์</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบประเภทครุภัณฑ์/อุปกรณ์</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_article_type',$this->input->post("input_search_box"));
				
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_article_type");
		}
		redirect(base_url()."?d=manage&c=article_type&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_article_type")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png"';
		else if($this->session->userdata("orderby_article_type")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png"';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ประเภทครุภัณฑ์/อุปกรณ์</th>
				<th class="same_first_td">แก้ไข</th>
				<th><input type="checkbox" id="del_all_article_type"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=article_type&m=delete" id="form_del_article_type">';
		if(!empty($data))
		{	//<td>'.$num_row.'</td>
			foreach ($data AS $dt):
			$html.='<tr>
					<td>'.$dt["article_type_id"].'</td>
					<td id="article_type'.$dt["article_type_id"].'">'.$dt["article_type_name"].'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=load_article_type("'.$dt["article_type_id"].'")>แก้ไข</button></td>
					<td><input type="checkbox" value="'.$dt["article_type_id"].'" name="del_article_type[]" class="del_article_type"></td>
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
			$this->session->set_userdata("orderby_article_type",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_article_type()
	{
	
		$actm=$this->article_type_model;
		echo json_encode($actm->load_article_type($this->input->post("tid"))[0]);
	}
}