<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_position extends MY_Controller
{
	private $jp_model;
	function __construct()
	{
		parent::__construct();
		$this->check_group_privilege(array("02"));
		$this->load->model("manage/job_position_model");
		$this->jp_model=$this->job_position_model;
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_job_position_name",
						"label"=>"ตำแหน่งงาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_job_position_name_name="input_job_position_name";
			$in_job_position_name=array(
					"LB_text"=>"ตำแหน่งงาน",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_job_position_name_name,
					"IN_id"=>$in_job_position_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_job_position_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มตำแหน่งงาน"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"job_position_tab"=>$this->job_position_tab(),
					"in_job_position_name"=>$this->eml->form_input($in_job_position_name)
			);
		
			$this->load->view("manage/job_position/add_job_position",$data);
		}
		else
		{
			$data=array(
					"job_position_id"=>$this->jp_model->get_maxid(2, "job_position_id", "tb_job_position"),
					"job_position_name"=>$this->input->post("input_job_position_name"),
					"checked"=>"1"
			);
			$redirect_link="?d=manage&c=job_position&m=add";
			$this->jp_model->manage_add($data,"tb_job_position",$redirect_link,$redirect_link,"job_position","เพิ่มตำแหน่งงานสำเร็จ","เพิ่มตำแหน่งงานไม่สำเร็จ");
		}
	}
	function edit()
	{
		$config=array(
				array(
						"field"=>"input_job_position_name",
						"label"=>"ตำแหน่งงาน",
						"rules"=>"required|max_length[30]|callback_call_lib[regex_lib,regex_charTHEN,%s - กรอกได้เฉพาะอักษรไทย/อังกฤษ]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_job_position"))
				$this->session->set_userdata("orderby_job_position",array("field"=>"job_position_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=job_position&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
		
				
			if($this->session->userdata("search_job_position"))
			{
				$liketext=$this->session->userdata("search_job_position");
				$config['total_rows']=$this->jp_model->get_all_numrows("tb_job_position",$liketext,"job_position_name");
				
				$get_job_position_list=$this->jp_model->get_job_position_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->jp_model->get_all_numrows("tb_job_position",'',"job_position_name");
				
				$get_job_position_list=$this->jp_model->get_job_position_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$in_job_position_name_name="input_job_position_name";
			$in_job_position_name=array(
					"LB_text"=>"ตำแหน่งงาน",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_job_position_name_name,
					"IN_id"=>$in_job_position_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_job_position_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  ตำแหน่งงาน"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"job_position_tab"=>$this->job_position_tab(),
					"in_job_position_name"=>$this->eml->form_input($in_job_position_name),
					"table_edit"=>$this->table_edit($get_job_position_list),
					"session_search_job_position"=>$this->session->userdata("search_job_position"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_job_position"))
			);
			$this->load->view("manage/job_position/edit_job_position",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_job_position_id";
			$set=array(
					"job_position_name"=>$this->input->post("input_job_position_name")
			);
			$where=array(
					"job_position_id"=>$this->session->userdata($session_edit_id)
			);
			$this->jp_model->manage_edit($set, $where, "tb_job_position", $session_edit_id, "edit_job_position", "แก้ไขตำแหน่งงานสำเร็จ", "แก้ไขตำแหน่งงานไม่สำเร็จ", "?d=manage&c=job_position&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$this->jp_model->manage_delete($this->input->post("del_job_position"), "tb_job_position", "job_position_id", "job_position_name", "edit_job_position", "?d=manage&c=job_position&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->jp_model->manage_allow($allow_list,$disallow_list, "tb_job_position", "job_position_id", "job_position_name", "edit_job_position", "?d=manage&c=job_position&m=edit");
	}
	
	
	
	
	function job_position_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มตำแหน่งงาน</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบตำแหน่งงาน</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_job_position',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_job_position");
		}
		redirect(base_url()."?d=manage&c=job_position&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_job_position")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_job_position")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ตำแหน่งงาน</th>
				<th class="same_first_td">อนุมัติ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_job_position"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=job_position&m=delete" id="form_del_job_position">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			//if     $checkbox='<input type="checkbox" value="'.$dt["job_position_id"].'" name="allow_job_position0[]" class="allow_job_position0">';
			//else   $checkbox='<input type="checkbox" value="'.$dt["job_position_id"].'" name="allow_job_position1[]" class="allow_job_position1" checked>';
			if($dt['checked']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["job_position_id"].'" id="checkboxFourInput'.$dt["job_position_id"].'" name="allow_job_position0[]" class="allow_job_position0"/>
										  	<label for="checkboxFourInput'.$dt["job_position_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["job_position_id"].'" id="checkboxFourInput'.$dt["job_position_id"].'" name="allow_job_position1[]" class="allow_job_position1" checked/>
						  	<label for="checkboxFourInput'.$dt["job_position_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["job_position_id"].'</td>
					<td id="job_position'.$dt["job_position_id"].'">'.$dt["job_position_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_job_position("'.$dt["job_position_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["job_position_id"].'" name="del_job_position[]" class="del_job_position"></td>
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
			$this->session->set_userdata("orderby_job_position",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_job_position()
	{
		echo json_encode($this->jp_model->load_job_position($this->input->post("tid"))[0]);
	}
	
}