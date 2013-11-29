<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room_has_article extends MY_Controller
{
	private $table_name	="tb_room_has_article";
	private $field_name	=array();
	
	//element_model
	private $emm;
	
	//element_lib
	private $eml;
	
	//page_element_lib
	private $pel;
	
	//form_validation
	private $frm;
	var  $load_rha_model;
	
	function __construct()
	{
		parent::__construct();
		//load and set
		$this->eml=$this->element_lib;
		$this->frm=$this->form_validation;
		$this->pel=$this->page_element_lib;
		$this->load->model("manage/room_has_article_model");
			$this->load_rha_model=$this->room_has_article_model;
		$this->load->model("element_model");
			$this->emm=$this->element_model;
		$this->lang->load("help_text","thailand");
		$this->lang->load("room_has_article/room_has_article","thailand");
	
		$this->get_all_field();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get all field in $table_name and push to array ($field_name)
	 *
	 * @return 	void
	 */
	function get_all_field()
	{
		$fields = $this->load_rha_model->get_all_field($this->table_name);
		foreach($fields as $field)
		{
			$this->field_name[$field]=$field;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * - Receive data from view(add_room_has_article)
	 * - form validation
	 * - Add data to $table_name
	 *
	 * @return 	void
	 */
	function add()
	{
		$config=array(
				array(
						"field"=>$this->lang->line("select_article"),
						"label"=>$this->lang->line("label_select_article"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("select_room"),
						"label"=>$this->lang->line("label_select_room"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("select_fee_type"),
						"label"=>$this->lang->line("label_select_fee_type"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("input_unit_num"),
						"label"=>$this->lang->line("label_input_unit_num"),
						"rules"=>"required|numeric"
				),
				array(
						"field"=>$this->lang->line("input_lump_sum_base_unit"),
						"label"=>$this->lang->line("label_input_lump_sum_base_unit"),
						"rules"=>"numeric"
				)
		);
		$this->frm->set_rules($config);
		if($this->frm->run() == false)
		{
			$se_article=array(
					"LB_text"=>$this->lang->line("label_select_article"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_article"),
					"S_id"=>$this->lang->line("select_article"),
					"S_old_value"=>$this->input->post($this->lang->line("select_article")),
					"S_data"=>$this->emm->get_select("tb_article","article_name"),
					"S_id_field"=>"article_id",
					"S_name_field"=>"article_name",
					"help_text"=>''
			);
			$se_room=array(
					"LB_text"=>$this->lang->line("label_select_room"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_room"),
					"S_id"=>$this->lang->line("select_room"),
					"S_old_value"=>$this->input->post($this->lang->line("select_room")),
					"S_data"=>'',
					"S_id_field"=>"room_id",
					"S_name_field"=>"room_name",
					"help_text"=>''
			);
			$se_fee_type=array(
					"LB_text"=>$this->lang->line("label_select_fee_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_fee_type"),
					"S_id"=>$this->lang->line("select_fee_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_fee_type")),
					"S_data"=>$this->emm->get_select("tb_fee_type","fee_type_name"),
					"S_id_field"=>"fee_type_id",
					"S_name_field"=>"fee_type_name",
					"help_text"=>''
			);
			$in_unit_num=array(
					"LB_text"=>$this->lang->line("label_input_unit_num"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_unit_num"),
					"IN_id"=>$this->lang->line("input_unit_num"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_unit_num")),
					"IN_attr"=>'maxlength="4"',
					"help_text"=>""
			);
			$in_lump_sum_base_unit=array(
					"LB_text"=>$this->lang->line("label_input_lump_sum_base_unit"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_lump_sum_base_unit"),
					"IN_id"=>$this->lang->line("input_lump_sum_base_unit"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_lump_sum_base_unit")),
					"IN_attr"=>'maxlength="4"',
					"help_text"=>""
			);
			
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จองห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"room_has_article_tab"=>$this->room_has_article_tab(),
					"se_article"=>$this->eml->form_select($se_article),
					"se_room"=>$this->eml->form_select($se_room),
					"se_fee_type"=>$this->eml->form_select($se_fee_type),
					"in_unit_num"=>$this->eml->form_input($in_unit_num),
					"in_lump_sum_base_unit"=>$this->eml->form_input($in_lump_sum_base_unit)					
			);
			$this->load->view("manage/room_has_article/add_room_has_article",$data);
		}
		else
		{
			$data=array(
					"tb_room_id"=>$this->input->post($this->lang->line("select_room")),
					"tb_article_id"=>$this->input->post($this->lang->line("select_article")),
					"unit_num"=>$this->input->post($this->lang->line("input_unit_num")),
					"tb_fee_type_id"=>$this->input->post($this->lang->line("select_fee_type")),
					"lump_sum_base_unit"=>$this->input->post($this->lang->line("input_lump_sum_base_unit"))
			);
			$redirect_link="?d=manage&c=room_has_article&m=add";
			$this->load_rha_model->manage_add($data,$this->table_name,$redirect_link,$redirect_link,"room_has_article","เพิ่มครุภัณฑ์/อุปกรณ์สำหรับห้องสำเร็จ","เพิ่มครุภัณฑ์/อุปกรณ์สำหรับห้องไม่สำเร็จ");
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * - Receive data from view(edit_article)
	 * - form validation
	 * - Update data in $table_name
	 *
	 * @return 	void
	 */
	function edit()
	{
		$config=array(
				array(
						"field"=>$this->lang->line("input_article"),
						"label"=>$this->lang->line("label_input_article"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("input_room"),
						"label"=>$this->lang->line("label_input_room"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("select_fee_type"),
						"label"=>$this->lang->line("label_select_fee_type"),
						"rules"=>"required"
				),
				array(
						"field"=>$this->lang->line("input_unit_num"),
						"label"=>$this->lang->line("label_input_unit_num"),
						"rules"=>"required|numeric"
				),
				array(
						"field"=>$this->lang->line("input_lump_sum_base_unit"),
						"label"=>$this->lang->line("label_input_lump_sum_base_unit"),
						"rules"=>"numeric"
				)
		);
		$this->frm->set_rules($config);
		//$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_room_has_article"))
				$this->session->set_userdata("orderby_room_has_article",array("field"=>"tb_room_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['base_url']=base_url()."?d=manage&c=room_has_article&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
	
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
	
			//field ที่ค้นหา
			$searchfield=$this->check_searchfield("searchfield_room_has_article", "tb_room_id");
	
			if($this->session->userdata("search_room_has_article"))
			{
				$liketext=$this->session->userdata("search_room_has_article");
				$config['total_rows']=$this->load_rha_model->get_all_numrows_rha($this->table_name,$liketext,$searchfield);
				$get_room_has_article_list=$this->load_rha_model->get_room_has_article_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_rha_model->get_all_numrows_rha($this->table_name,'',$searchfield);
				$get_room_has_article_list=$this->load_rha_model->get_room_has_article_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
	
			//..pagination
			$se_article=array(
					"LB_text"=>$this->lang->line("label_select_article"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_article"),
					"S_id"=>$this->lang->line("select_article"),
					"S_old_value"=>$this->input->post($this->lang->line("select_article")),
					"S_data"=>$this->emm->get_select("tb_article","article_name"),
					"S_id_field"=>"article_id",
					"S_name_field"=>"article_name",
					"help_text"=>''
			);
			$se_room=array(
					"LB_text"=>$this->lang->line("label_select_room"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_room"),
					"S_id"=>$this->lang->line("select_room"),
					"S_old_value"=>$this->input->post($this->lang->line("select_room")),
					"S_data"=>'',
					"S_id_field"=>"room_id",
					"S_name_field"=>"room_name",
					"help_text"=>''
			);
			$se_fee_type=array(
					"LB_text"=>$this->lang->line("label_select_fee_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_fee_type"),
					"S_id"=>$this->lang->line("select_fee_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_fee_type")),
					"S_data"=>$this->emm->get_select("tb_fee_type","fee_type_name"),
					"S_id_field"=>"fee_type_id",
					"S_name_field"=>"fee_type_name",
					"help_text"=>''
			);
			$in_unit_num=array(
					"LB_text"=>$this->lang->line("label_input_unit_num"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_unit_num"),
					"IN_id"=>$this->lang->line("input_unit_num"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_unit_num")),
					"IN_attr"=>'maxlength="4"',
					"help_text"=>""
			);
			$in_lump_sum_base_unit=array(
					"LB_text"=>$this->lang->line("label_input_lump_sum_base_unit"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_lump_sum_base_unit"),
					"IN_id"=>$this->lang->line("input_lump_sum_base_unit"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_lump_sum_base_unit")),
					"IN_attr"=>'maxlength="4"',
					"help_text"=>""
			);
			
			$in_room=array(
					"LB_text"=>$this->lang->line("label_input_room"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_room"),
					"IN_id"=>$this->lang->line("input_room"),
					"IN_PH"=>'',
					"IN_value"=>'',
					"IN_attr"=>'readonly',
					"help_text"=>""
			);
			$in_article=array(
					"LB_text"=>$this->lang->line("label_input_article"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_article"),
					"IN_id"=>$this->lang->line("input_article"),
					"IN_PH"=>'',
					"IN_value"=>'',
					"IN_attr"=>'readonly',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  ครุภัณฑ์/อุปกรณ์สำหรับห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"room_has_article_tab"=>$this->room_has_article_tab(),
						//"se_article"=>$this->eml->form_select($se_article),
						//"se_room"=>$this->eml->form_select($se_room),
					"se_fee_type"=>$this->eml->form_select($se_fee_type),
					"in_unit_num"=>$this->eml->form_input($in_unit_num),
					"in_lump_sum_base_unit"=>$this->eml->form_input($in_lump_sum_base_unit),
					"in_room"=>$this->eml->form_input($in_room),
					"in_article"=>$this->eml->form_input($in_article),
					"table_edit"=>$this->table_edit($get_room_has_article_list),
					"session_search_room_has_article"=>$this->session->userdata("search_room_has_article"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_room_has_article"))
			);
			$this->load->view("manage/room_has_article/edit_room_has_article",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_room_has_article_id";
			$set=array(
					//"tb_room_id"=>$this->input->post($this->lang->line("select_room")),
					//"tb_article_id"=>$this->input->post($this->lang->line("select_article")),
					"unit_num"=>$this->input->post($this->lang->line("input_unit_num")),
					"tb_fee_type_id"=>$this->input->post($this->lang->line("select_fee_type")),
					"lump_sum_base_unit"=>$this->input->post($this->lang->line("input_lump_sum_base_unit"))
			);
			$arr_sess_edit=explode(",",$this->session->userdata($session_edit_id));
			$where=array(
					"tb_room_id"=>$arr_sess_edit["0"],
					"tb_article_id"=>$arr_sess_edit["1"]
			);
			$this->load_rha_model->manage_edit($set, $where, $this->table_name, $session_edit_id, "edit_room_has_article", "แก้ไขครุครุภัณฑ์/อุปกรณ์สำหรับห้องสำเร็จ", "แก้ไขครุภัณฑ์/อุปกรณ์สำหรับห้องไม่สำเร็จ", "?d=manage&c=room_has_article&m=edit", $prev_url);
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Call function mange_delete
	 * - manage_delete($arr_id, $table, $field_PK, $select_field, $message_type='', $main_url='')
	 *
	 * @return 	void
	 */
	function delete()
	{
		$this->load_rha_model->delete_rha($this->input->post("del_room_has_article"), $this->table_name, "tb_room_id,tb_article_id", "room_name,article_name", "edit_room_has_article", "?d=manage&c=room_has_article&m=edit");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create tab
	 *
	 * @return 	string
	 */
	function room_has_article_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มครุภัณฑ์/อุปกรณ์สำหรับห้อง</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบ ครุภัณฑ์/อุปกรณ์สำหรับห้อง</a></li>
			';
		$html.='</ul>';
		return $html;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set order by session
	 *
	 * @return 	void
	 */
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_room_has_article",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	// --------------------------------------------------------------------
	
	/**
	 * Set search session and redirect
	 *
	 * @return 	void
	 */
	function search()
	{
		if($this->input->post("input_search_box")!='')
		{
			$this->session->set_userdata('search_room_has_article',$this->input->post("input_search_box"));
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_room_has_article");
		}
		redirect(base_url()."?d=manage&c=room_has_article&m=edit");
	}

	// --------------------------------------------------------------------
	
	/**
	 * Create table and pagination for manage data
	 *
	 * @param 	array
	 * @return 	string
	 */
	function table_edit($data)
	{
		if($this->session->userdata("orderby_room_has_article")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png"';
		else if($this->session->userdata("orderby_room_has_article")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png"';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>'.$this->lang->line("label_select_room").'</th>
				<th>'.$this->lang->line("label_select_article").'</th>
				<th>'.$this->lang->line("label_select_fee_type").'</th>
				<th>'.$this->lang->line("label_input_unit_num").'</th>
				<th>'.$this->lang->line("label_input_lump_sum_base_unit").'</th>
				<th class="same_first_td">แก้ไข</th>
				<th><input type="checkbox" id="del_all_room_has_article"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=room_has_article&m=delete" id="form_del_room_has_article">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			$html.='<tr>
					<td id="room'.$dt["tb_room_id"].'">'.$dt["room_name"].'</td>
					<td id="article'.$dt["tb_article_id"].'">'.$dt["article_name"].'</td>
					<td id="fee_type'.$dt["tb_fee_type_id"].'">'.$dt["fee_type_name"].'</td>
					<td>'.$dt["unit_num"].'</td>
					<td>'.$dt["lump_sum_base_unit"].'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=load_room_has_article("'.$dt["tb_room_id"].",".$dt["tb_article_id"].'")>แก้ไข</button></td>
					<td><input type="checkbox" value="'.$dt["tb_room_id"].",".$dt["tb_article_id"].'" name="del_room_has_article[]" class="del_room_has_article"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td></td>
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

	// --------------------------------------------------------------------
	
	/**
	 *
	 * @return 	void
	 * echo Json
	 */
	function select_room_list()
	{
		if($this->input->post("article_id")!=''):
		$query=$this->emm->select_room_rha($this->input->post("article_id"));
		$data='';
		//echo $this->db->last_query();break;
		if($query>0):
		foreach($query AS $ar):
		$data.="<option value='".$ar['room_id']."'>".$ar['room_name']."</option>";
		endforeach;
		endif;
		echo json_encode(array("room_list"=>$data));
		else: echo "";
		endif;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get data reference by ID and return array with json
	 *
	 * @return 	array
	 */
	function load_room_has_article()
	{
		echo json_encode($this->load_rha_model->load_room_has_article($this->input->post("room_id"),$this->input->post("article_id"))[0]);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set search_field session
	 *
	 * @return 	void
	 */
	function set_searchfield()
	{
		if($this->input->post("searchfield"))
		{
			$this->session->set_userdata("searchfield_room_has_article",$this->input->post("searchfield"));
		}
	}
}