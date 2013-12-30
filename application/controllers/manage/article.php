<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Article extends MY_Controller
{
	private $table_name	="tb_article";
	private $field_name	=array();
	var  $load_article_model;
	
	function __construct()
	{
		parent::__construct();
		$this->fl->check_group_privilege(array("02"));
		$this->load->model("manage/article_model");
		$this->load_article_model=$this->article_model;

		$this->lang->load("article/article","thailand");
		
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
		$fields = $this->load_article_model->get_all_field($this->table_name);
		foreach($fields as $field)
		{
			$this->field_name[$field]=$field;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * - Receive data from view(add_article)
	 * - form validation
	 * - Add data to $table_name
	 * 
	 * @return 	void
	 */
	function add()
	{
		$config=array(
				array(
						"field"=>$this->lang->line("input_article"),
						"label"=>$this->lang->line("label_input_article"),
						"rules"=>"required|max_length[30]"
				),
				array(
						"field"=>$this->lang->line("input_fee_unit_hour"),
						"label"=>$this->lang->line("label_input_fee_unit_hour"),
						"rules"=>"required|max_length[9]|callback_call_lib_with_data[regex_lib,regex_decimal,%s - รูปแบบตัวเลขไม่ถูกต้อง,6&2]"
				),
				array(
						"field"=>$this->lang->line("input_fee_unit_lump_sum"),
						"label"=>$this->lang->line("label_input_fee_unit_lump_sum"),
						"rules"=>"required|max_length[9]|callback_regex_decimal"
				),
				array(
						"field"=>$this->lang->line("input_fee_over_unit_lump_sum"),
						"label"=>$this->lang->line("label_input_fee_over_unit_lump_sum"),
						"rules"=>"required|max_length[9]|callback_regex_decimal"
				),
				array(
						"field"=>$this->lang->line("select_article_type"),
						"label"=>$this->lang->line("label_select_article_type"),
						"rules"=>"required"
				)
		);
		$this->frm->set_rules($config);
		//$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			
			$in_article=array(
					"LB_text"=>$this->lang->line("label_input_article"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_article"),
					"IN_id"=>$this->lang->line("input_article"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_article")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			
			$in_fee_unit_hour=array(
					"LB_text"=>$this->lang->line("label_input_fee_unit_hour"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_unit_hour"),
					"IN_id"=>$this->lang->line("input_fee_unit_hour"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_unit_hour")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);

			$in_fee_unit_lump_sum=array(
					"LB_text"=>$this->lang->line("label_input_fee_unit_lump_sum"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_unit_lump_sum"),
					"IN_id"=>$this->lang->line("input_fee_unit_lump_sum"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_unit_lump_sum")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);
			
			$in_fee_over_unit_lump_sum=array(
					"LB_text"=>$this->lang->line("label_input_fee_over_unit_lump_sum"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_over_unit_lump_sum"),
					"IN_id"=>$this->lang->line("input_fee_over_unit_lump_sum"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_over_unit_lump_sum")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);
			
			$se_article_type=array(
					"LB_text"=>$this->lang->line("label_select_article_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_article_type"),
					"S_id"=>$this->lang->line("select_article_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_article_type")),
					"S_data"=>$this->emm->select_article_type(),
					"S_id_field"=>"article_type_id",
					"S_name_field"=>"article_type_name",
					"help_text"=>''
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("เพิ่มครุภัณฑ์/อุปกรณ์"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"article_tab"=>$this->article_tab(),
					"in_article"=>$this->eml->form_input($in_article),
					"in_fee_unit_hour"=>$this->eml->form_input($in_fee_unit_hour),
					"in_fee_unit_lump_sum"=>$this->eml->form_input($in_fee_unit_lump_sum),
					"in_fee_over_unit_lump_sum"=>$this->eml->form_input($in_fee_over_unit_lump_sum),
					"se_article_type"=>$this->eml->form_select($se_article_type)
			);
				
			$this->load->view("manage/article/add_article",$data);
		}
		else
		{
			$data=array(
					"article_id"=>$this->load_article_model->get_maxid(3, $this->field_name["article_id"], $this->table_name),
					"article_name"=>$this->input->post($this->lang->line("input_article")),
					"tb_article_type_id"=>$this->input->post("select_article_type"),
					"fee_unit_hour"=>$this->input->post("input_fee_unit_hour"),
					"fee_unit_lump_sum"=>$this->input->post("input_fee_unit_lump_sum"),
					"fee_over_unit_lump_sum"=>$this->input->post("input_fee_over_unit_lump_sum")
			);
			$redirect_link="?d=manage&c=article&m=add";
			$this->load_article_model->manage_add($data,$this->table_name,$redirect_link,$redirect_link,"article","เพิ่มครุภัณฑ์/อุปกรณ์สำเร็จ","เพิ่มครุภัณฑ์/อุปกรณ์ไม่สำเร็จ");
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
						"rules"=>"required|max_length[30]"
				),
				array(
						"field"=>$this->lang->line("input_fee_unit_hour"),
						"label"=>$this->lang->line("label_input_fee_unit_hour"),
						"rules"=>"required|max_length[9]|callback_call_lib_with_data[regex_lib,regex_decimal,%s - รูปแบบตัวเลขไม่ถูกต้อง,6&2]"
				),
				array(
						"field"=>$this->lang->line("input_fee_unit_lump_sum"),
						"label"=>$this->lang->line("label_input_fee_unit_lump_sum"),
						"rules"=>"required|max_length[9]|callback_regex_decimal"
				),
				array(
						"field"=>$this->lang->line("input_fee_over_unit_lump_sum"),
						"label"=>$this->lang->line("label_input_fee_over_unit_lump_sum"),
						"rules"=>"required|max_length[9]|callback_regex_decimal"
				),
				array(
						"field"=>$this->lang->line("select_article_type"),
						"label"=>$this->lang->line("label_select_article_type"),
						"rules"=>"required"
				)
		);
		$this->frm->set_rules($config);
		//$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_article"))
				$this->session->set_userdata("orderby_article",array("field"=>"article_name","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=article&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
				
			if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
			else $this->getpage=0;
				
			//field ที่ค้นหา
			$searchfield=$this->check_searchfield("searchfield_article", "article_name");
				
			if($this->session->userdata("search_article"))
			{
				$liketext=$this->session->userdata("search_article");
				$config['total_rows']=$this->load_article_model->get_all_numrows($this->table_name,$liketext,$searchfield);
				$get_article_list=$this->load_article_model->get_article_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_article_model->get_all_numrows($this->table_name,'',$searchfield);
				//$get_article_list=$this->load_article_model->get_article_list($config['per_page'],$this->getpage);
				$get_article_list=$this->load_article_model->get_article_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
				
			//..pagination
				
			
			$in_article=array(
					"LB_text"=>$this->lang->line("label_input_article"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_article"),
					"IN_id"=>$this->lang->line("input_article"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_article")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			
			$in_fee_unit_hour=array(
					"LB_text"=>$this->lang->line("label_input_fee_unit_hour"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_unit_hour"),
					"IN_id"=>$this->lang->line("input_fee_unit_hour"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_unit_hour")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);

			$in_fee_unit_lump_sum=array(
					"LB_text"=>$this->lang->line("label_input_fee_unit_lump_sum"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_unit_lump_sum"),
					"IN_id"=>$this->lang->line("input_fee_unit_lump_sum"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_unit_lump_sum")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);
			
			$in_fee_over_unit_lump_sum=array(
					"LB_text"=>$this->lang->line("label_input_fee_over_unit_lump_sum"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_fee_over_unit_lump_sum"),
					"IN_id"=>$this->lang->line("input_fee_over_unit_lump_sum"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_fee_over_unit_lump_sum")),
					"IN_attr"=>'maxlength="9"',
					"help_text"=>"999999.99"
			);
			
			$se_article_type=array(
					"LB_text"=>$this->lang->line("label_select_article_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_article_type"),
					"S_id"=>$this->lang->line("select_article_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_article_type")),
					"S_data"=>$this->emm->select_article_type(),
					"S_id_field"=>"article_type_id",
					"S_name_field"=>"article_type_name",
					"help_text"=>''
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  ประเภทครุภัณฑ์/อุปกรณ์"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"article_tab"=>$this->article_tab(),
					"in_article"=>$this->eml->form_input($in_article),
					"in_fee_unit_hour"=>$this->eml->form_input($in_fee_unit_hour),
					"in_fee_unit_lump_sum"=>$this->eml->form_input($in_fee_unit_lump_sum),
					"in_fee_over_unit_lump_sum"=>$this->eml->form_input($in_fee_over_unit_lump_sum),
					"se_article_type"=>$this->eml->form_select($se_article_type),
					"table_edit"=>$this->table_edit($get_article_list),
					"session_search_article"=>$this->session->userdata("search_article"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_article"))
			);
			$this->load->view("manage/article/edit_article",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_article_id";
			$set=array(
					"article_name"=>$this->input->post($this->lang->line("input_article")),
					"tb_article_type_id"=>$this->input->post("select_article_type"),
					"fee_unit_hour"=>$this->input->post("input_fee_unit_hour"),
					"fee_unit_lump_sum"=>$this->input->post("input_fee_unit_lump_sum"),
					"fee_over_unit_lump_sum"=>$this->input->post("input_fee_over_unit_lump_sum")
			);
			$where=array(
					"article_id"=>$this->session->userdata($session_edit_id)
			);
			$this->load_article_model->manage_edit($set, $where, $this->table_name, $session_edit_id, "edit_article", "แก้ไขครุภัณฑ์/อุปกรณ์สำเร็จ", "แก้ไขครุภัณฑ์/อุปกรณ์ไม่สำเร็จ", "?d=manage&c=article&m=edit", $prev_url);
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
		$this->load_article_model->manage_delete($this->input->post("del_article"), $this->table_name, "article_id", "article_name", "edit_article", "?d=manage&c=article&m=edit");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create tab
	 *
	 * @return 	string
	 */
	function article_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			<li><a href="#"  id="add">เพิ่มครุภัณฑ์/อุปกรณ์</a></li>';
		$html.='
			<li><a href="#"  id="edit">แก้ไข/ลบครุภัณฑ์/อุปกรณ์</a></li>
			';
		$html.='</ul>';
		return $html;
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
			$this->session->set_userdata('search_article',$this->input->post("input_search_box"));
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_article");
		}
		redirect(base_url()."?d=manage&c=article&m=edit");
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
		if($this->session->userdata("orderby_article")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png"';
		else if($this->session->userdata("orderby_article")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png"';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ชื่อครุภัณฑ์/อุปกรณ์</th>
				<th>ประเภทครุภัณฑ์/อุปกรณ์</th>
				<th>ค่าบริการหน่วยต่อชม.</th>
				<th>ค่าบริการเหมาต่อหน่วย</th>
				<th>ค่าบริการเหมาส่วนเกินต่อหน่วย</th>
				<th class="same_first_td">แก้ไข</th>
				<th><input type="checkbox" id="del_all_article"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=article&m=delete" id="form_del_article">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			$html.='<tr>
					<td>'.$dt["article_id"].'</td>
					<td id="article'.$dt["article_id"].'">'.$dt["article_name"].'</td>
					<td>'.$dt["article_type_name"].'</td>
					<td>'.$dt["fee_unit_hour"].'</td>
					<td>'.$dt["fee_unit_lump_sum"].'</td>
					<td>'.$dt["fee_over_unit_lump_sum"].'</td>
					<td class="same_first_td">'.$this->eml->btn('edit','onclick=load_article("'.$dt["article_id"].'")').'</td>
					<td><input type="checkbox" value="'.$dt["article_id"].'" name="del_article[]" class="del_article"></td>
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
				<td></td>
				<td>'.$this->eml->btn('delete','onclick="show_del_list();return false;"').'</td>
				</tr>
				</table>
				</form>';
		$html.=$this->pagination->create_links();
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
			$this->session->set_userdata("orderby_article",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get data reference by ID and return array with json
	 *
	 * @return 	array
	 */
	function load_article()
	{
		echo json_encode($this->load_article_model->load_article($this->input->post("tid"))[0]);
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
			$this->session->set_userdata("searchfield_article",$this->input->post("searchfield"));
		}
	}
}