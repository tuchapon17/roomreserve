<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends MY_Controller
{
	private $dpm_model;
	function __construct()
	{
		parent::__construct();
		$this->load->model("manage/department_model");
		$this->dpm_model=$this->department_model;
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_department_name",
						"label"=>"สาขาวิชา/งาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_department_name_name="input_department_name";
			$in_department_name=array(
					"LB_text"=>"สาขาวิชา/งาน",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_department_name_name,
					"IN_id"=>$in_department_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_department_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มสาขาวิชา/งาน"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"department_tab"=>$this->department_tab(),
					"in_department_name"=>$this->eml->form_input($in_department_name)
			);
		
			$this->load->view("manage/department/add_department",$data);
		}
		else
		{
			$data=array(
					"department_id"=>$this->dpm_model->get_maxid(2, "department_id", "tb_department"),
					"department_name"=>$this->input->post("input_department_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=department&m=add";
			$this->dpm_model->manage_add($data,"tb_department",$redirect_link,$redirect_link,"department","เพิ่มสาขาวิชา/งานสำเร็จ","เพิ่มสาขาวิชา/งานไม่สำเร็จ");
		}
	}
	function edit()
	{
		$config=array(
				array(
						"field"=>"input_department_name",
						"label"=>"สาขาวิชา/งาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_department"))
				$this->session->set_userdata("orderby_department",array("field"=>"department_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=department&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_department"))
			{
				$liketext=$this->session->userdata("search_department");
				$config['total_rows']=$this->dpm_model->get_all_numrows("tb_department",$liketext,"department_name");
				
				$get_department_list=$this->dpm_model->get_department_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->dpm_model->get_all_numrows("tb_department",'',"department_name");
				
				$get_department_list=$this->dpm_model->get_department_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_department_name_name="input_department_name";
			$in_department_name=array(
					"LB_text"=>"สาขาวิชา/งาน",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_department_name_name,
					"IN_id"=>$in_department_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_department_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  สาขาวิชา/งาน"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"department_tab"=>$this->department_tab(),
					"in_department_name"=>$this->eml->form_input($in_department_name),
					"table_edit"=>$this->table_edit($get_department_list),
					"session_search_department"=>$this->session->userdata("search_department"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_department"))
			);
			$this->load->view("manage/department/edit_department",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_department_id";
			$set=array(
					"department_name"=>$this->input->post("input_department_name")
			);
			$where=array(
					"department_id"=>$this->session->userdata($session_edit_id)
			);
			$this->dpm_model->manage_edit($set, $where, "tb_department", $session_edit_id, "edit_department", "แก้ไขสาขาวิชา/งานสำเร็จ", "แก้ไขสาขาวิชา/งานไม่สำเร็จ", "?d=manage&c=department&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$this->dpm_model->manage_delete($this->input->post("del_department"), "tb_department", "department_id", "department_name", "edit_department", "?d=manage&c=department&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->dpm_model->manage_allow($allow_list,$disallow_list, "tb_department", "department_id", "department_name", "edit_department", "?d=manage&c=department&m=edit");
	}
	
	
	
	
	function department_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มสาขาวิชา/งาน</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบสาขาวิชา/งาน</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_department',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_department");
		}
		redirect(base_url()."?d=manage&c=department&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_department")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_department")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>สาขาวิชา/งาน</th>
				<th class="same_first_td">อนุมัติ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_department"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=department&m=delete" id="form_del_department">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			//if     $checkbox='<input type="checkbox" value="'.$dt["department_id"].'" name="allow_department0[]" class="allow_department0">';
			//else   $checkbox='<input type="checkbox" value="'.$dt["department_id"].'" name="allow_department1[]" class="allow_department1" checked>';
			if($dt['checked']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["department_id"].'" id="checkboxFourInput'.$dt["department_id"].'" name="allow_department0[]" class="allow_department0"/>
										  	<label for="checkboxFourInput'.$dt["department_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["department_id"].'" id="checkboxFourInput'.$dt["department_id"].'" name="allow_department1[]" class="allow_department1" checked/>
						  	<label for="checkboxFourInput'.$dt["department_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["department_id"].'</td>
					<td id="department'.$dt["department_id"].'">'.$dt["department_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_department("'.$dt["department_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["department_id"].'" name="del_department[]" class="del_department"></td>
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
			$this->session->set_userdata("orderby_department",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_department()
	{
		echo json_encode($this->dpm_model->load_department($this->input->post("tid"))[0]);
	}
	
}