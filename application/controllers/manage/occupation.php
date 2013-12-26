<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Occupation extends MY_Controller
{
	private $occ_model;
	function __construct()
	{
		parent::__construct();
		$this->load->model("manage/occupation_model");
		$this->occ_model=$this->occupation_model;
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_occupation_name",
						"label"=>"อาชีพ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_occupation_name_name="input_occupation_name";
			$in_occupation_name=array(
					"LB_text"=>"อาชีพ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_occupation_name_name,
					"IN_id"=>$in_occupation_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_occupation_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มอาชีพ"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"occupation_tab"=>$this->occupation_tab(),
					"in_occupation_name"=>$this->eml->form_input($in_occupation_name)
			);
		
			$this->load->view("manage/occupation/add_occupation",$data);
		}
		else
		{
		
			$this->occ_model=$this->occupation_model;
			$data=array(
					"occupation_id"=>$this->occ_model->get_maxid(2, "occupation_id", "tb_occupation"),
					"occupation_name"=>$this->input->post("input_occupation_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=occupation&m=add";
			$this->occ_model->manage_add($data,"tb_occupation",$redirect_link,$redirect_link,"occupation","เพิ่มอาชีพสำเร็จ","เพิ่มอาชีพไม่สำเร็จ");
		}
	}
	function edit()
	{
		$this->occ_model=$this->occupation_model;
		$config=array(
				array(
						"field"=>"input_occupation_name",
						"label"=>"อาชีพ",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_occupation"))
				$this->session->set_userdata("orderby_occupation",array("field"=>"occupation_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=occupation&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_occupation"))
			{
				$liketext=$this->session->userdata("search_occupation");
				$config['total_rows']=$this->occ_model->get_all_numrows("tb_occupation",$liketext,"occupation_name");
				
				$get_occupation_list=$this->occ_model->get_occupation_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->occ_model->get_all_numrows("tb_occupation",'',"occupation_name");
				
				$get_occupation_list=$this->occ_model->get_occupation_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_occupation_name_name="input_occupation_name";
			$in_occupation_name=array(
					"LB_text"=>"อาชีพ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_occupation_name_name,
					"IN_id"=>$in_occupation_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_occupation_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  อาชีพ"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"occupation_tab"=>$this->occupation_tab(),
					"in_occupation_name"=>$this->eml->form_input($in_occupation_name),
					"table_edit"=>$this->table_edit($get_occupation_list),
					"session_search_occupation"=>$this->session->userdata("search_occupation"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_occupation"))
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
			$this->occ_model->manage_edit($set, $where, "tb_occupation", $session_edit_id, "edit_occupation", "แก้ไขอาชีพสำเร็จ", "แก้ไขอาชีพไม่สำเร็จ", "?d=manage&c=occupation&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$this->occ_model=$this->occupation_model;
		$this->occ_model->manage_delete($this->input->post("del_occupation"), "tb_occupation", "occupation_id", "occupation_name", "edit_occupation", "?d=manage&c=occupation&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->occ_model=$this->occupation_model;
		$this->occ_model->manage_allow($allow_list,$disallow_list, "tb_occupation", "occupation_id", "occupation_name", "edit_occupation", "?d=manage&c=occupation&m=edit");
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
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_occupation("'.$dt["occupation_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["occupation_id"].'" name="del_occupation[]" class="del_occupation"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td align="center">'.$this->eml->btn('submitcheck','onclick="show_allow_list();return false;"')." ".
									$this->eml->btn('refreshcheck','onclick="location.reload(true);"').'
				</td>
				<td></td>
				<td>'.$this->eml->btn('delete','onclick="show_del_list();return false;"').'</td>
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
	
		$this->occ_model=$this->occupation_model;
		echo json_encode($this->occ_model->load_occupation($this->input->post("tid"))[0]);
	}
	
}