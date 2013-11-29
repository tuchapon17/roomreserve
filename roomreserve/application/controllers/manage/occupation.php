<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Occupation extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/occupation_model");
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
						"field"=>"input_occupation_name",
						"label"=>"อาชีพ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$in_occupation_name_name="input_occupation_name";
			$in_occupation_name=array(
					"LB_text"=>"อาชีพ",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_occupation_name_name,
					"IN_id"=>$in_occupation_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_occupation_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);

			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มอาชีพ"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"occupation_tab"=>$this->occupation_tab(),
					"in_occupation_name"=>$eml->form_input($in_occupation_name)
			);
		
			$this->load->view("manage/occupation/add_occupation",$data);
		}
		else
		{
		
			$dpm=$this->occupation_model;
			$data=array(
					"occupation_id"=>$dpm->get_maxid(2, "occupation_id", "tb_occupation"),
					"occupation_name"=>$this->input->post("input_occupation_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=occupation&m=add";
			$dpm->manage_add($data,"tb_occupation",$redirect_link,$redirect_link,"occupation","เพิ่มอาชีพสำเร็จ","เพิ่มอาชีพไม่สำเร็จ");
		}
	}
	function edit()
	{
		$dpm=$this->occupation_model;
		$emm=$this->element_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
		
		
		$config=array(
				array(
						"field"=>"input_occupation_name",
						"label"=>"อาชีพ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			if(!$this->session->userdata("orderby_occupation"))
				$this->session->set_userdata("orderby_occupation",array("field"=>"occupation_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['base_url']=base_url()."?d=manage&c=occupation&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_occupation"))
			{
				$liketext=$this->session->userdata("search_occupation");
				$config['total_rows']=$dpm->get_all_numrows("tb_occupation",$liketext,"occupation_name");
				
				$get_occupation_list=$dpm->get_occupation_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$dpm->get_all_numrows("tb_occupation",'',"occupation_name");
				
				$get_occupation_list=$dpm->get_occupation_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_occupation_name_name="input_occupation_name";
			$in_occupation_name=array(
					"LB_text"=>"อาชีพ",
					"LB_attr"=>$eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_occupation_name_name,
					"IN_id"=>$in_occupation_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_occupation_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("แก้ไข/ลบ  อาชีพ"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"occupation_tab"=>$this->occupation_tab(),
					"in_occupation_name"=>$eml->form_input($in_occupation_name),
					"table_edit"=>$this->table_edit($get_occupation_list),
					"session_search_occupation"=>$this->session->userdata("search_occupation"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_occupation"))
			);
			$this->load->view("manage/occupation/edit_occupation",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_occupation_id";
			$set=array(
					"occupation_name"=>$this->input->post("input_occupation_name")
			);
			$where=array(
					"occupation_id"=>$this->session->userdata($session_edit_id)
			);
			$dpm->manage_edit($set, $where, "tb_occupation", $session_edit_id, "edit_occupation", "แก้ไขอาชีพสำเร็จ", "แก้ไขอาชีพไม่สำเร็จ", "?d=manage&c=occupation&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$dpm=$this->occupation_model;
		$dpm->manage_delete($this->input->post("del_occupation"), "tb_occupation", "occupation_id", "occupation_name", "edit_occupation", "?d=manage&c=occupation&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$dpm=$this->occupation_model;
		$dpm->manage_allow($allow_list,$disallow_list, "tb_occupation", "occupation_id", "occupation_name", "edit_occupation", "?d=manage&c=occupation&m=edit");
	}
	
	
	
	
	function occupation_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มอาชีพ</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบอาชีพ</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_occupation',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_occupation");
		}
		redirect(base_url()."?d=manage&c=occupation&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_occupation")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_occupation")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>อาชีพ</th>
				<th class="same_first_td">อนุมัติ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_occupation"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=occupation&m=delete" id="form_del_occupation">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			//if     $checkbox='<input type="checkbox" value="'.$dt["occupation_id"].'" name="allow_occupation0[]" class="allow_occupation0">';
			//else   $checkbox='<input type="checkbox" value="'.$dt["occupation_id"].'" name="allow_occupation1[]" class="allow_occupation1" checked>';
			if($dt['checked']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["occupation_id"].'" id="checkboxFourInput'.$dt["occupation_id"].'" name="allow_occupation0[]" class="allow_occupation0"/>
										  	<label for="checkboxFourInput'.$dt["occupation_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["occupation_id"].'" id="checkboxFourInput'.$dt["occupation_id"].'" name="allow_occupation1[]" class="allow_occupation1" checked/>
						  	<label for="checkboxFourInput'.$dt["occupation_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["occupation_id"].'</td>
					<td id="occupation'.$dt["occupation_id"].'">'.$dt["occupation_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=load_occupation("'.$dt["occupation_id"].'")><img width="17" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_150_edit.png"></button></td>
					<td><input type="checkbox" value="'.$dt["occupation_id"].'" name="del_occupation[]" class="del_occupation"></td>
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
			$this->session->set_userdata("orderby_occupation",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_occupation()
	{
	
		$dpm=$this->occupation_model;
		echo json_encode($dpm->load_occupation($this->input->post("tid"))[0]);
	}
	
}