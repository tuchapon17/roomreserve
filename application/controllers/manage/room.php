<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends MY_Controller
{
	//element_model
	private $emm;
	
	//element_lib
	private $eml;
	
	//page_element_lib
	private $pel;
	
	//form_validation
	private $frm;
	
	function __construct()
	{
		parent::__construct();
		//load and set
		//$this->load->library('element_lib');
		$this->eml=$this->element_lib;
		//$this->load->library("form_validation");
			$this->frm=$this->form_validation;
			$this->pel=$this->page_element_lib;
		$this->load->model("element_model");
			$this->emm=$this->element_model;
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
		
		
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/room_model");
		$this->load->model("element_model");
	}
	function add()
	{
		$config=array(
				array(
						"field"=>"input_room_name",
						"label"=>"ชื่อห้อง",
						"rules"=>"required|max_length[50]"
				),
				array(
						"field"=>"select_room_type",
						"label"=>"ประเภทห้อง",
						"rules"=>"required"
				),
				array(
						"field"=>"textarea_room_detail",
						"label"=>"ชื่อห้อง",
						"rules"=>""
				),
				array(
						"field"=>"input_discount_percent",
						"label"=>"ส่วนลดของห้อง",
						"rules"=>"required|max_length[6]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$in_room_name_name="input_room_name";
			$in_room_name=array(
					"LB_text"=>"ชื่อห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_name_name,
					"IN_id"=>$in_room_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$se_room_type=array(
					"LB_text"=>"ประเภทห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>"select_room_type",
					"S_id"=>"select_room_type",
					"S_old_value"=>$this->input->post("select_room_type"),
					"S_data"=>$this->emm->select_room_type(),
					"S_id_field"=>"room_type_id",
					"S_name_field"=>"room_type_name",
					"help_text"=>''
			);
			$te_room_detail_name="textarea_room_detail";
			$te_room_detail=array(
					"LB_text"=>"รายละเอียดห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_class"=>'',
					"IN_name"=>$te_room_detail_name,
					"IN_id"=>$te_room_detail_name,
					"IN_attr"=>'',
					"help_text"=>""
			);
			$in_discount_percent_name="input_discount_percent";
			$in_discount_percent=array(
					"LB_text"=>"ส่วนลด(%)",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_discount_percent_name,
					"IN_id"=>$in_discount_percent_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_discount_percent_name),
					"IN_attr"=>'maxlength="7"',
					"help_text"=>""
			);
			
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("เพิ่มห้อง"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"room_tab"=>$this->room_tab(),
					"in_room_name"=>$this->eml->form_input($in_room_name),
					"se_room_type"=>$this->eml->form_select($se_room_type),
					"te_room_detail"=>$this->eml->form_textarea($te_room_detail),
					"in_discount_percent"=>$this->eml->form_input($in_discount_percent)
			);
		
			$this->load->view("manage/room/add_room",$data);
		}
		else
		{
		
			$rom=$this->room_model;
			$data=array(
					"room_id"=>$rom->get_maxid(2, "room_id", "tb_room"),
					"room_name"=>$this->input->post("input_room_name"),
					"tb_room_type_id"=>$this->input->post("select_room_type"),
					"room_detail"=>$this->input->post("textarea_room_detail"),
					"room_status"=>"1",
					"discount_percent"=>$this->input->post("input_discount_percent")
			);
			$redirect_link="?d=manage&c=room&m=add";
			$rom->manage_add($data,"tb_room",$redirect_link,$redirect_link,"room","เพิ่มห้องสำเร็จ","เพิ่มห้องไม่สำเร็จ");
		}
	}
	function edit()
	{
		$rom=$this->room_model;
		
		
		
	
	
		$config=array(
				array(
						"field"=>"input_room_name",
						"label"=>"ชื่อห้อง",
						"rules"=>"required|max_length[50]"
				),
				array(
						"field"=>"select_room_type",
						"label"=>"ประเภทห้อง",
						"rules"=>"required"
				),
				array(
						"field"=>"textarea_room_detail",
						"label"=>"ชื่อห้อง",
						"rules"=>""
				),
				array(
						"field"=>"input_discount_percent",
						"label"=>"ส่วนลดของห้อง",
						"rules"=>"required|max_length[6]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_room"))
				$this->session->set_userdata("orderby_room",array("field"=>"room_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=room&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
	
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
	
	
			if($this->session->userdata("search_room"))
			{
				$liketext=$this->session->userdata("search_room");
				$config['total_rows']=$rom->get_all_numrows("tb_room",$liketext,"room_name");
	
				$get_room_list=$rom->get_room_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$rom->get_all_numrows("tb_room",'',"room_name");
	
				$get_room_list=$rom->get_room_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
	
			//..pagination
			$in_room_name_name="input_room_name";
			$in_room_name=array(
					"LB_text"=>"ชื่อห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_name_name,
					"IN_id"=>$in_room_name_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_name_name),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$se_room_type=array(
					"LB_text"=>"ประเภทห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>"select_room_type",
					"S_id"=>"select_room_type",
					"S_old_value"=>$this->input->post("select_room_type"),
					"S_data"=>$this->emm->select_room_type(),
					"S_id_field"=>"room_type_id",
					"S_name_field"=>"room_type_name",
					"help_text"=>''
			);
			$te_room_detail_name="textarea_room_detail";
			$te_room_detail=array(
					"LB_text"=>"รายละเอียดห้อง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_class"=>'',
					"IN_name"=>$te_room_detail_name,
					"IN_id"=>$te_room_detail_name,
					"IN_attr"=>'',
					"help_text"=>""
			);
			$in_discount_percent_name="input_discount_percent";
			$in_discount_percent=array(
					"LB_text"=>"ส่วนลด(%)",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_discount_percent_name,
					"IN_id"=>$in_discount_percent_name,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_discount_percent_name),
					"IN_attr"=>'maxlength="7"',
					"help_text"=>""
			);
				
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("แก้ไข/ลบ  ห้อง"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"room_tab"=>$this->room_tab(),
					"in_room_name"=>$this->eml->form_input($in_room_name),
					"se_room_type"=>$this->eml->form_select($se_room_type),
					"te_room_detail"=>$this->eml->form_textarea($te_room_detail),
					"in_discount_percent"=>$this->eml->form_input($in_discount_percent),
					"table_edit"=>$this->table_edit($get_room_list),
					"session_search_room"=>$this->session->userdata("search_room"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_room"))
			);
			$this->load->view("manage/room/edit_room",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_room_id";
			$set=array(
					"room_name"=>$this->input->post("input_room_name"),
					"tb_room_type_id"=>$this->input->post("select_room_type"),
					"room_detail"=>$this->input->post("textarea_room_detail"),
					"discount_percent"=>$this->input->post("input_discount_percent")
			);
			$where=array(
					"room_id"=>$this->session->userdata($session_edit_id)
			);
			$rom->manage_edit($set, $where, "tb_room", $session_edit_id, "edit_room", "แก้ไขห้องสำเร็จ", "แก้ไขห้องไม่สำเร็จ", "?d=manage&c=room&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$rom=$this->room_model;
		$rom->manage_delete($this->input->post("del_room"), "tb_room", "room_id", "room_name", "edit_room", "?d=manage&c=room&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$rom=$this->room_model;
		$rom->manage_allow($allow_list,$disallow_list, "tb_room", "room_id", "room_name", "edit_room", "?d=manage&c=room&m=edit");
	}
	
	function room_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มห้อง</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบห้อง</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_room',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_room");
		}
		redirect(base_url()."?d=manage&c=room&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_room")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_room")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ห้อง</th>
				<th>ส่วนลด(%)</th>
				<th class="same_first_td">สถานะ<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">แก้ไข</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_room"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=room&m=delete" id="form_del_room">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			if($dt['room_status']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["room_id"].'" id="checkboxFourInput'.$dt["room_id"].'" name="allow_room0[]" class="allow_room0"/>
										  	<label for="checkboxFourInput'.$dt["room_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["room_id"].'" id="checkboxFourInput'.$dt["room_id"].'" name="allow_room1[]" class="allow_room1" checked/>
						  	<label for="checkboxFourInput'.$dt["room_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["room_id"].'</td>
					<td id="room'.$dt["room_id"].'">'.$dt["room_name"].'</td>
					<td>'.$dt["discount_percent"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_room("'.$dt["room_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["room_id"].'" name="del_room[]" class="del_room"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td></td>
				<td align="center">'.$this->eml->btn('submitcheck','onclick="show_allow_list();return false;"')." ".
									$this->eml->btn('refreshcheck','onclick="location.reload(true);"').'</td>
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
			$this->session->set_userdata("orderby_room",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function load_room()
	{
	
		$rom=$this->room_model;
		$data=$rom->load_room($this->input->post("tid"))[0];
		//$data["room_detail"]=$this->reverse_escape($data["room_detail"]);
		echo json_encode($data);
	}
	function set_searchfield()
	{
		if($this->input->post("searchfield"))
		{
			$this->session->set_userdata("searchfield_room",$this->input->post("searchfield"));
		}
	}
}