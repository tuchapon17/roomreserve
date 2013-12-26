<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Titlename extends MY_Controller
{
	private $tn_model;
	function __construct()
	{
		parent::__construct();
		$this->load->model("manage/titlename_model");
		$this->tn_model=$this->titlename_model;
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_titlename",
						"label"=>"คำนำหน้าชื่อ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);	
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_titlename_name="input_titlename";
			$in_titlename=array(
					"LB_text"=>"คำนำหน้าชื่อ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_titlename_name,
					"IN_id"=>$in_titlename_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_titlename_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มคำนำหน้าชื่อ"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"titlename_tab"=>$this->titlename_tab(),
					"in_titlename"=>$this->eml->form_input($in_titlename)
			);
			$this->load->view("manage/titlename/add_titlename",$data);
		}
		else
		{
			$data=array(
					"titlename_id"=>$this->tn_model->get_maxid(2, "titlename_id", "tb_titlename"),
					"titlename"=>$this->input->post("input_titlename")
			);
			$this->tn_model->add_titlename($data);
		}
	}
	var $getpage;
	function edit()
	{
		$config=array(
				array(
						"field"=>"input_titlename",
						"label"=>"คำนำหน้าชื่อ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_titlename")) 
				$this->session->set_userdata("orderby_titlename",array("field"=>"titlename","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=titlename&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
			
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
			
			if($this->session->userdata("search_titlename"))
			{
				$liketext=$this->session->userdata("search_titlename");
				$config['total_rows']=$this->tn_model->get_all_numrows("tb_titlename",$liketext,"titlename");
				$get_titlename_list=$this->tn_model->get_titlename_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->tn_model->get_all_numrows("tb_titlename",'',"titlename");
				$get_titlename_list=$this->tn_model->get_titlename_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
			
			//..pagination
			
			$in_titlename_name="input_titlename";
			$in_titlename=array(
					"LB_text"=>"คำนำหน้าชื่อ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_titlename_name,
					"IN_id"=>$in_titlename_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_titlename_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบคำนำหน้าชื่อ"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"titlename_tab"=>$this->titlename_tab(),
					"in_titlename"=>$this->eml->form_input($in_titlename),
					"table_edit"=>$this->table_edit($get_titlename_list),
					"session_search_titlename"=>$this->session->userdata("search_titlename"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_titlename"))
			);
			//print_r($this->tn_model->get_titlename_list($config['per_page'],$this->getpage));break;
			$this->load->view("manage/titlename/edit_titlename",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$set=array(
					"titlename"=>$this->input->post("input_titlename")
			);			
			$this->tn_model->edit_titlename($set,$prev_url);
		}
	}
	function delete()
	{
		$this->tn_model->delete_titlename($this->input->post("del_titlename"));
	}
	
	function titlename_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="titlename_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มคำนำหน้าชื่อ</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบคำนำหน้าชื่อ</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_titlename")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png"';
		else if($this->session->userdata("orderby_titlename")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png"';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>คำนำหน้าชื่อ</a></th>
				<th class="same_first_td">แก้ไข</th>
				<th><input type="checkbox" id="del_all_titlename"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=titlename&m=delete" id="form_del_titlename">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			$html.='<tr>
					<td>'.$dt["titlename_id"].'</td>
					<td id="titlename'.$dt["titlename_id"].'">'.$dt["titlename"].'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_titlename("'.$dt["titlename_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["titlename_id"].'" name="del_titlename[]" class="del_titlename"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>'.$this->eml->btn('delete','onclick="show_del_list();return false;"').'</td>
				</tr>
				</table>
				</form>';
		$html.=$this->pagination->create_links();
		return $html;
	}
	function load_titlename()
	{
		echo json_encode($this->tn_model->load_titlename($this->input->post("tid"))[0]);
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_titlename',$this->input->post("input_search_box"));
			
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_titlename");
		}
		redirect(base_url()."?d=manage&c=titlename&m=edit");
	}
	function set_per_page()
	{
		if($this->input->post("num") && preg_match('/^[1-9]|[1-9][\d]+/',$this->input->post("num")))
		{
			$this->session->set_userdata("set_per_page",$this->input->post("num"));
		}
		//redirect(base_url()."?d=manage&c=titlename&m=edit","refresh");
	}
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_titlename",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function search_box()
	{
		$html='
					
		';
	}
	
}
//preg_match('/^[1-9]|[1-9][\d]+/',$_GET['per_page']) ตัวเลขแต่ไม่ให้ 0 นำหน้า