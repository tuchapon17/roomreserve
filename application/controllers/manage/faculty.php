<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faculty extends MY_Controller
{
	private $fc_model;
	function __construct()
	{
		parent::__construct();
		$this->check_group_privilege(array("02"));
		$this->load->model("manage/faculty_model");
		$this->fc_model=$this->faculty_model;
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_faculty_name",
						"label"=>"คณะ/กอง",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_faculty_name_name="input_faculty_name";
			$in_faculty_name=array(
					"LB_text"=>"คณะ/กอง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_faculty_name_name,
					"IN_id"=>$in_faculty_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_faculty_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มคณะ/กอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"faculty_tab"=>$this->faculty_tab(),
					"in_faculty_name"=>$this->eml->form_input($in_faculty_name)
			);
		
			$this->load->view("manage/faculty/add_faculty",$data);
		}
		else
		{
			$data=array(
					"faculty_id"=>$this->fc_model->get_maxid(2, "faculty_id", "tb_faculty"),
					"faculty_name"=>$this->input->post("input_faculty_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=faculty&m=add";
			$this->fc_model->manage_add($data,"tb_faculty",$redirect_link,$redirect_link,"faculty","เพิ่มคณะ/กองสำเร็จ","เพิ่มคณะ/กองไม่สำเร็จ");
		}
	}
	function edit()
	{
		$config=array(
				array(
						"field"=>"input_faculty_name",
						"label"=>"คณะ/กอง",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_faculty"))
				$this->session->set_userdata("orderby_faculty",array("field"=>"faculty_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=faculty&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_faculty"))
			{
				$liketext=$this->session->userdata("search_faculty");
				$config['total_rows']=$this->fc_model->get_all_numrows("tb_faculty",$liketext,"faculty_name");
				
				$get_faculty_list=$this->fc_model->get_faculty_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->fc_model->get_all_numrows("tb_faculty",'',"faculty_name");
				
				$get_faculty_list=$this->fc_model->get_faculty_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_faculty_name_name="input_faculty_name";
			$in_faculty_name=array(
					"LB_text"=>"คณะ/กอง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_faculty_name_name,
					"IN_id"=>$in_faculty_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_faculty_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  คณะ/กอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"faculty_tab"=>$this->faculty_tab(),
					"in_faculty_name"=>$this->eml->form_input($in_faculty_name),
					"table_edit"=>$this->table_edit($get_faculty_list),
					"session_search_faculty"=>$this->session->userdata("search_faculty"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_faculty"))
			);
			$this->load->view("manage/faculty/edit_faculty",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_faculty_id";
			$set=array(
					"faculty_name"=>$this->input->post("input_faculty_name")
			);
			$where=array(
					"faculty_id"=>$this->session->userdata($session_edit_id)
			);
			$this->fc_model->manage_edit($set, $where, "tb_faculty", $session_edit_id, "edit_faculty", "แก้ไขคณะ/กองสำเร็จ", "แก้ไขคณะ/กองไม่สำเร็จ", "?d=manage&c=faculty&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$this->fc_model->manage_delete($this->input->post("del_faculty"), "tb_faculty", "faculty_id", "faculty_name", "edit_faculty", "?d=manage&c=faculty&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->fc_model->manage_allow($allow_list,$disallow_list, "tb_faculty", "faculty_id", "faculty_name", "edit_faculty", "?d=manage&c=faculty&m=edit");
	}
	
	
	
	
	function faculty_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มคณะ/กอง</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบคณะ/กอง</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_faculty',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_faculty");
		}
		redirect(base_url()."?d=manage&c=faculty&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_faculty")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_faculty")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>คณะ/กอง</th>
				<th class="same_first_td">อนุมัติ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_faculty"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=faculty&m=delete" id="form_del_faculty">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			//if     $checkbox='<input type="checkbox" value="'.$dt["faculty_id"].'" name="allow_faculty0[]" class="allow_faculty0">';
			//else   $checkbox='<input type="checkbox" value="'.$dt["faculty_id"].'" name="allow_faculty1[]" class="allow_faculty1" checked>';
			if($dt['checked']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["faculty_id"].'" id="checkboxFourInput'.$dt["faculty_id"].'" name="allow_faculty0[]" class="allow_faculty0"/>
										  	<label for="checkboxFourInput'.$dt["faculty_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["faculty_id"].'" id="checkboxFourInput'.$dt["faculty_id"].'" name="allow_faculty1[]" class="allow_faculty1" checked/>
						  	<label for="checkboxFourInput'.$dt["faculty_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["faculty_id"].'</td>
					<td id="faculty'.$dt["faculty_id"].'">'.$dt["faculty_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_faculty("'.$dt["faculty_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["faculty_id"].'" name="del_faculty[]" class="del_faculty"></td>
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
			$this->session->set_userdata("orderby_faculty",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_faculty()
	{
		echo json_encode($this->fc_model->load_faculty($this->input->post("tid"))[0]);
	}
	
}