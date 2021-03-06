<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Office extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/office_model");
		$this->load->model("element_model");
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}
	function add()
	{
		$emm=$this->element_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		$config=array(
				array(
						"field"=>"input_office_name",
						"label"=>"หน่วยงาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$in_office_name_name="input_office_name";
			$in_office_name=array(
					"LB_text"=>"หน่วยงาน",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_office_name_name,
					"IN_id"=>$in_office_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_office_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);

			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มหน่วยงาน"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"office_tab"=>$this->office_tab(),
					"in_office_name"=>$eml->form_input($in_office_name)
			);
		
			$this->load->view("manage/office/add_office",$data);
		}
		else
		{
		
			$ofm=$this->office_model;
			$data=array(
					"office_id"=>$ofm->get_maxid(2, "office_id", "tb_office"),
					"office_name"=>$this->input->post("input_office_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=office&m=add";
			$ofm->manage_add($data,"tb_office",$redirect_link,$redirect_link,"office","เพิ่มหน่วยงานสำเร็จ","เพิ่มหน่วยงานไม่สำเร็จ");
		}
	}
	function edit()
	{
		$ofm=$this->office_model;
		$emm=$this->element_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		
		$config=array(
				array(
						"field"=>"input_office_name",
						"label"=>"หน่วยงาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			if(!$this->session->userdata("orderby_office"))
				$this->session->set_userdata("orderby_office",array("field"=>"office_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['base_url']=base_url()."?d=manage&c=office&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_office"))
			{
				$liketext=$this->session->userdata("search_office");
				$config['total_rows']=$ofm->get_all_numrows("tb_office",$liketext,"office_name");
				
				$get_office_list=$ofm->get_office_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$ofm->get_all_numrows("tb_office",'',"office_name");
				
				$get_office_list=$ofm->get_office_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_office_name_name="input_office_name";
			$in_office_name=array(
					"LB_text"=>"หน่วยงาน",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_office_name_name,
					"IN_id"=>$in_office_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_office_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("แก้ไข/ลบ  หน่วยงาน"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"office_tab"=>$this->office_tab(),
					"in_office_name"=>$eml->form_input($in_office_name),
					"table_edit"=>$this->table_edit($get_office_list),
					"session_search_office"=>$this->session->userdata("search_office"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_office"))
			);
			$this->load->view("manage/office/edit_office",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_office_id";
			$set=array(
					"office_name"=>$this->input->post("input_office_name")
			);
			$where=array(
					"office_id"=>$this->session->userdata($session_edit_id)
			);
			$ofm->manage_edit($set, $where, "tb_office", $session_edit_id, "edit_office", "แก้ไขหน่วยงานสำเร็จ", "แก้ไขหน่วยงานไม่สำเร็จ", "?d=manage&c=office&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$ofm=$this->office_model;
		$ofm->manage_delete($this->input->post("del_office"), "tb_office", "office_id", "office_name", "edit_office", "?d=manage&c=office&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$ofm=$this->office_model;
		$ofm->manage_allow($allow_list,$disallow_list, "tb_office", "office_id", "office_name", "edit_office", "?d=manage&c=office&m=edit");
	}
	
	
	
	
	function office_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มหน่วยงาน</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบหน่วยงาน</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_office',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_office");
		}
		redirect(base_url()."?d=manage&c=office&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_office")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_office")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>หน่วยงาน</th>
				<th class="same_first_td">อนุมัติ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_office"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=office&m=delete" id="form_del_office">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			//if     $checkbox='<input type="checkbox" value="'.$dt["office_id"].'" name="allow_office0[]" class="allow_office0">';
			//else   $checkbox='<input type="checkbox" value="'.$dt["office_id"].'" name="allow_office1[]" class="allow_office1" checked>';
			if($dt['checked']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["office_id"].'" id="checkboxFourInput'.$dt["office_id"].'" name="allow_office0[]" class="allow_office0"/>
										  	<label for="checkboxFourInput'.$dt["office_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["office_id"].'" id="checkboxFourInput'.$dt["office_id"].'" name="allow_office1[]" class="allow_office1" checked/>
						  	<label for="checkboxFourInput'.$dt["office_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["office_id"].'</td>
					<td id="office'.$dt["office_id"].'">'.$dt["office_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=load_office("'.$dt["office_id"].'")><img width="17" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_150_edit.png"></button></td>
					<td><input type="checkbox" value="'.$dt["office_id"].'" name="del_office[]" class="del_office"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td align="center"><button type="button" class="btn btn-success" onclick="show_allow_list();return false;"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_206_ok_2.png"></button>
									<button type="button" class="btn btn-warning" onclick="location.reload(true);"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_081_refresh.png"></button>
						</td>
				<td></td>
				<td><button type="submit" class="btn btn-danger" onclick="show_del_list();return false;"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_016_bin.png"></button></td>
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
			$this->session->set_userdata("orderby_office",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_office()
	{
	
		$ofm=$this->office_model;
		echo json_encode($ofm->load_office($this->input->post("tid"))[0]);
	}
	
}