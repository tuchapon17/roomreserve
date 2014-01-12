<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends MY_Controller
{
	private $rom;
	function __construct()
	{
		parent::__construct();
		$this->fl->check_group_privilege(array("02"));
		$this->load->model("manage/room_model");
		$this->rom=$this->room_model;
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
				),
				/*array(
						"field"=>"input_room_fee",
						"label"=>"ค่าบริการ",
						"rules"=>"required|max_length[9]"
				),*/
				array(
						"field"=>"select_fee_type",
						"label"=>"ประเภทค่าบริการ",
						"rules"=>"required"
				),
				array(
						"field"=>"input_room_fee_hour",
						"label"=>"ค่าบริการต่อชั่วโมง",
						"rules"=>"required|max_length[9]"
				),
				array(
						"field"=>"input_room_fee_lump_sum",
						"label"=>"ค่าบริการแบบเหมา",
						"rules"=>"required|max_length[9]"
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
			/*$in_room_fee="input_room_fee";
			$in_room_fee=array(
					"LB_text"=>"ค่าบริการ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee,
					"IN_id"=>$in_room_fee,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);*/
			$se_fee_type=array(
					"LB_text"=>"ประเภทค่าบริการ",
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>"select_fee_type",
					"S_id"=>"select_fee_type",
					"S_old_value"=>$this->input->post("select_fee_type"),
					"S_data"=>$this->emm->get_select("tb_fee_type","fee_type_name"),
					"S_id_field"=>"fee_type_id",
					"S_name_field"=>"fee_type_name",
					"help_text"=>''
			);
			$in_room_fee_hour="input_room_fee_hour";
			$in_room_fee_hour=array(
					"LB_text"=>"ค่าบริการต่อชั่วโมง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee_hour,
					"IN_id"=>$in_room_fee_hour,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee_hour),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);
			$in_room_fee_lump_sum="input_room_fee_lump_sum";
			$in_room_fee_lump_sum=array(
					"LB_text"=>"ค่าบริการแบบเหมา",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee_lump_sum,
					"IN_id"=>$in_room_fee_lump_sum,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee_lump_sum),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"room_tab"=>$this->room_tab(),
					"in_room_name"=>$this->eml->form_input($in_room_name),
					"se_room_type"=>$this->eml->form_select($se_room_type),
					"te_room_detail"=>$this->eml->form_textarea($te_room_detail),
					"in_discount_percent"=>$this->eml->form_input($in_discount_percent),
					//"in_room_fee"=>$this->eml->form_input($in_room_fee),
					"se_fee_type"=>$this->eml->form_select($se_fee_type),
					"in_room_fee_hour"=>$this->eml->form_input($in_room_fee_hour),
					"in_room_fee_lump_sum"=>$this->eml->form_input($in_room_fee_lump_sum)
			);
		
			$this->load->view("manage/room/add_room",$data);
		}
		else
		{
			$data=array(
					"room_id"=>$this->rom->get_maxid(2, "room_id", "tb_room"),
					"room_name"=>$this->input->post("input_room_name"),
					"tb_room_type_id"=>$this->input->post("select_room_type"),
					"room_detail"=>$this->input->post("textarea_room_detail"),
					"room_status"=>"1",
					"discount_percent"=>$this->input->post("input_discount_percent"),
					"room_fee_hour"=>$this->input->post("input_room_fee_hour"),
					"room_fee_lump_sum"=>$this->input->post("input_room_fee_lump_sum")
			);
			$redirect_link="?d=manage&c=room&m=add";
			$this->rom->manage_add($data,"tb_room",$redirect_link,$redirect_link,"room","เพิ่มห้องสำเร็จ","เพิ่มห้องไม่สำเร็จ");
		}
	}
	function edit()
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
				$config['total_rows']=$this->rom->get_all_numrows("tb_room",$liketext,"room_name");
	
				$get_room_list=$this->rom->get_room_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->rom->get_all_numrows("tb_room",'',"room_name");
	
				$get_room_list=$this->rom->get_room_list($config['per_page'],$this->getpage);
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
			/*$in_room_fee="input_room_fee";
			$in_room_fee=array(
					"LB_text"=>"ค่าบริการ",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee,
					"IN_id"=>$in_room_fee,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);*/
			$se_fee_type=array(
					"LB_text"=>"ประเภทค่าบริการ",
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>"select_fee_type",
					"S_id"=>"select_fee_type",
					"S_old_value"=>$this->input->post("select_fee_type"),
					"S_data"=>$this->emm->get_select("tb_fee_type","fee_type_name"),
					"S_id_field"=>"fee_type_id",
					"S_name_field"=>"fee_type_name",
					"help_text"=>''
			);
			$in_room_fee_hour="input_room_fee_hour";
			$in_room_fee_hour=array(
					"LB_text"=>"ค่าบริการต่อชั่วโมง",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee_hour,
					"IN_id"=>$in_room_fee_hour,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee_hour),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);
			$in_room_fee_lump_sum="input_room_fee_lump_sum";
			$in_room_fee_lump_sum=array(
					"LB_text"=>"ค่าบริการแบบเหมา",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$in_room_fee_lump_sum,
					"IN_id"=>$in_room_fee_lump_sum,
					"IN_PH"=>'',
					"IN_value"=>set_value($in_room_fee_lump_sum),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  ห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"room_tab"=>$this->room_tab(),
					"in_room_name"=>$this->eml->form_input($in_room_name),
					"se_room_type"=>$this->eml->form_select($se_room_type),
					"te_room_detail"=>$this->eml->form_textarea($te_room_detail),
					"in_discount_percent"=>$this->eml->form_input($in_discount_percent),
					//"in_room_fee"=>$this->eml->form_input($in_room_fee),
					"se_fee_type"=>$this->eml->form_select($se_fee_type),
					"in_room_fee_hour"=>$this->eml->form_input($in_room_fee_hour),
					"in_room_fee_lump_sum"=>$this->eml->form_input($in_room_fee_lump_sum),
					"table_edit"=>$this->table_edit($get_room_list),
					"session_search_room"=>$this->session->userdata("search_room"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_room"))
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
					"discount_percent"=>$this->input->post("input_discount_percent"),
					"room_fee_hour"=>$this->input->post("input_room_fee_hour"),
					"room_fee_lump_sum"=>$this->input->post("input_room_fee_lump_sum")
			);
			$where=array(
					"room_id"=>$this->session->userdata($session_edit_id)
			);
			$this->rom->manage_edit($set, $where, "tb_room", $session_edit_id, "edit_room", "แก้ไขห้องสำเร็จ", "แก้ไขห้องไม่สำเร็จ", "?d=manage&c=room&m=edit", $prev_url);
		}
	}
	function delete()
	{
		$this->rom->manage_delete($this->input->post("del_room"), "tb_room", "room_id", "room_name", "edit_room", "?d=manage&c=room&m=edit");
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->rom->manage_allow($allow_list,$disallow_list, "tb_room", "room_id", "room_name", "edit_room", "?d=manage&c=room&m=edit");
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
				<th class="same_first_td">จัดการรูป</th>
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
					<td class="text-center">'.$checkbox.'</td>
					<td class="text-center">'.$this->eml->btn('picture','onclick=window.open("'.base_url().'?d=manage&c=room&m=pic&rmid='.$dt['room_id'].'","_blank")').'</td>
					<td class="text-center">'.$this->eml->btn('edit','onclick=load_room("'.$dt["room_id"].'")').'</td>
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
									$this->eml->btn('refreshcheck','onclick="location.reload(true);"').'
				</td>
				<td></td>											
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
		$data=$this->rom->load_room($this->input->post("tid"))[0];
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
	function pic()
	{
		
		$config2=array(
				array(
						"field"=>"test",
						"label"=>"",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config2);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(isset($_GET['rmid']))
			{
				//pagination
				$this->load->library("pagination");
				$config_pg['use_page_numbers'] = TRUE;
				$config_pg['base_url']=base_url()."?d=manage&c=room&m=pic&rmid=".$_GET['rmid'];
				//set per_page
				$config_pg['per_page']=5;
				$getpage;
				if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $getpage=(($_GET['page']-1)*$config_pg['per_page']);
				else $getpage=0;
				$config_pg['total_rows']=$this->rom->get_all_numrows("tb_room_has_pic",'',"room_pic_id");
				$this->pagination->initialize($config_pg);
				//..pagination
				
				$this->session->set_userdata("room_has_pic_id",$_GET['rmid']);
				$data=array(
						"htmlopen"=>$this->pel->htmlopen(),
						"head"=>$this->pel->head("จัดการรูป"),
						"bodyopen"=>$this->pel->bodyopen(),
						"navbar"=>$this->pel->navbar(),
						"js"=>$this->pel->js(),
						"footer"=>$this->pel->footer(),
						"bodyclose"=>$this->pel->bodyclose(),
						"htmlclose"=>$this->pel->htmlclose(),
						"pic_table"=>$this->rom->room_pic($config_pg['per_page'],$getpage),
						"pagination_link"=>$this->pagination->create_links(),
						"room_data"=>$this->rom->get_room_data($_GET['rmid'])
				);
				$this->load->view("manage/room/upload_pic",$data);
			}
			else
			{
				$data=array(
						"htmlopen"=>$this->pel->htmlopen(),
						"head"=>$this->pel->head("จัดการรูป"),
						"bodyopen"=>$this->pel->bodyopen(),
						"navbar"=>$this->pel->navbar(),
						"js"=>$this->pel->js(),
						"footer"=>$this->pel->footer(),
						"bodyclose"=>$this->pel->bodyclose(),
						"htmlclose"=>$this->pel->htmlclose(),
						"room_list_for_upload"=>$this->room_list_for_upload()
				);
				$this->load->view("manage/room/room_list_upload_pic",$data);
			}
		}
		else
		{
			$this->load->library('upload'); // Load Library
			$files = $_FILES;
			$cpt = count($_FILES['pic_file']['name']);
			$config = array();
			$config['upload_path'] = './upload/pic/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = '0';
			$config['overwrite']     = FALSE;
			$this->upload->initialize($config); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean
			
			for($i=0; $i<$cpt; $i++)
			{
				echo $i;
				$name = $_FILES["pic_file"]["name"][$i];
				$ext = end(explode(".", $name));
				$file_detail=array(
					//1388212969.8946 to 1388212969_8946
					"new_name"=>str_replace(".", "_",microtime(true)).rand(100,999).".".end(explode(".", $files["pic_file"]["name"][$i])),
					"old_name"=>$files["pic_file"]["name"][$i],
					"ext"=>end(explode(".", $files["pic_file"]["name"][$i])),
					"type"=>$files["pic_file"]["type"][$i],
					"error"=>$files["pic_file"]["error"][$i],
					"size"=>$files["pic_file"]["size"][$i]
				);
				print_r($file_detail);
				$_FILES['pic_file']['name']= $file_detail["new_name"];
				$_FILES['pic_file']['type']= $files['pic_file']['type'][$i];
				$_FILES['pic_file']['tmp_name']= $files['pic_file']['tmp_name'][$i];
				$_FILES['pic_file']['error']= $files['pic_file']['error'][$i];
				$_FILES['pic_file']['size']= $files['pic_file']['size'][$i];
				//echo "<hr>";print_r($_FILES);
				if($this->upload->do_upload('pic_file'))
				{
					//upload success
					$data5=array(
						"room_pic_id"=>$this->rom->get_maxid(5,"room_pic_id","tb_room_has_pic"),
						"pic_name"=>$file_detail["new_name"],
						"tb_room_id"=>$this->session->userdata("room_has_pic_id")
					);
					
					$this->rom->manage_add2($data5,"tb_room_has_pic");
				}
				else
				{
					echo $this->upload->display_errors('<p>', '</p>');
				}
			}
			$s = "?d=manage&c=room&m=pic&rmid=".$this->session->userdata("room_has_pic_id");
			redirect(base_url().$s);
		}
	}//function pic()
	function del_room_pic()
	{
		$arr_room_pic_id = $this->input->post("del_room_pic");
		foreach($arr_room_pic_id as $rp)
		{
			$pic_name = $this->rom->get_pic_file_name($rp)[0]['pic_name'];
			
			$file_path = "upload/pic/".$pic_name;
			//echo $file_path;
			if(file_exists($file_path))
			{
				if(unlink($file_path))
				{
					//echo "unlinked";
				}
			}
		}
		$this->rom->manage_delete($this->input->post("del_room_pic"), "tb_room_has_pic", "room_pic_id", "room_pic_id", "del_room_pic", "?d=manage&c=room&m=pic&rmid=".$this->session->userdata("room_has_pic_id"));
	}
	function update_pic_descript()
	{
		$set=array("pic_descript"=>$this->input->post("pic_descript"));
		$where=array("room_pic_id"=>$this->input->post("room_pic_id"));
		$this->db->trans_begin();
		$this->db->update("tb_room_has_pic",$set,$where);
		if($this->db->trans_status()===FALSE):
			$this->db->trans_rollback();
		else:
			$this->db->trans_commit();
			echo json_encode(array("commit"));
		endif;
	}
	function room_list_for_upload()
	{
		$room_list = $this->rom->get_room_list_upload();
		$options='';
		foreach($room_list as $r)
		{
			$options.='<option value="'.$r['room_id'].'">'.$r['room_name'].'</option>';
		}
		$html='
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">เลือกห้อง</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<select class="form-control" id="room_list">
						'.$options.'
					</select>
					<br/>
					<div class="text-right">
					'.$this->eml->btn("submit","id='btn_room_list'").'
					</div>
				</div>
			</div>
		</div>
		';
		return $html;
	}
}