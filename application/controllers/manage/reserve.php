<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reserve extends MY_Controller
{
	private $table_name	="tb_reserve";
	private $field_name	=array();
	
	//element_model
	private $emm;
	
	//element_lib
	private $eml;
	
	//page_element_lib
	private $pel;
	
	//form_validation
	private $frm;
	var  $load_reserve_model;
	
	function __construct()
	{
		parent::__construct();
		//load and set
		//$this->load->library('element_lib');
			$this->eml=$this->element_lib;
		//$this->load->library("form_validation");
			$this->frm=$this->form_validation;
			$this->pel=$this->page_element_lib;
		$this->load->model("manage/reserve_model");
			$this->load_reserve_model=$this->reserve_model;
		$this->load->model("element_model");
			$this->emm=$this->element_model;
		$this->lang->load("help_text","thailand");
		$this->lang->load("reserve/reserve","thailand");
		
		//$this->get_all_field();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get all field in $table_name and push to array ($field_name)
	 *
	 * @return 	void
	 */
	function get_all_field()
	{
		$fields = $this->load_reserve_model->get_all_field($this->table_name);
		foreach($fields as $field)
		{
			$this->field_name[$field]=$field;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * - Receive data from view(add_reserve)
	 * - form validation
	 * - Add data to $table_name
	 *
	 * @return 	void
	 */
	function add()
	{
		$config=array(
				array(
						"field"=>$this->lang->line("input_std_id"),
						"label"=>$this->lang->line("label_input_std_id"),
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		if($this->frm->run() == false)
		{
			$in_std_id=array(
					"LB_text"=>$this->lang->line("label_input_std_id"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_std_id"),
					"IN_id"=>$this->lang->line("input_std_id"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_std_id")),
					"IN_attr"=>'maxlength="11"',
					"help_text"=>""
			);
			$in_phone=array(
					"LB_text"=>$this->lang->line("label_input_phone"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_phone"),
					"IN_id"=>$this->lang->line("input_phone"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_phone")),
					"IN_attr"=>'maxlength="10" phone',
					"help_text"=>""
			);
			$in_num_of_people=array(
					"LB_text"=>$this->lang->line("label_input_num_of_people"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_num_of_people"),
					"IN_id"=>$this->lang->line("input_num_of_people"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_num_of_people")),
					"IN_attr"=>'maxlength="3"',
					"help_text"=>""
			);
			$in_project_name=array(
					"LB_text"=>$this->lang->line("label_input_project_name"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_project_name"),
					"IN_id"=>$this->lang->line("input_project_name"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_project_name")),
					"IN_attr"=>'maxlength="100"',
					"help_text"=>""
			);
			$te_for_use=array(
					"LB_text"=>$this->lang->line("label_textarea_for_use"),
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("textarea_for_use"),
					"IN_id"=>$this->lang->line("textarea_for_use"),
					"IN_attr"=>'',
					"help_text"=>""
			);
			$se_faculty=array(
					"LB_text"=>$this->lang->line("label_select_faculty"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_faculty"),
					"S_id"=>$this->lang->line("select_faculty"),
					"S_old_value"=>$this->input->post($this->lang->line("select_faculty")),
					"S_data"=>$this->emm->select_faculty(),
					"S_id_field"=>"faculty_id",
					"S_name_field"=>"faculty_name",
					"help_text"=>''
			);
			$se_department=array(
					"LB_text"=>$this->lang->line("label_select_department"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_department"),
					"S_id"=>$this->lang->line("select_department"),
					"S_old_value"=>$this->input->post($this->lang->line("select_department")),
					"S_data"=>$this->emm->get_select("tb_department","department_name"),
					"S_id_field"=>"department_id",
					"S_name_field"=>"department_name",
					"help_text"=>''
			);
			$se_job_position=array(
					"LB_text"=>$this->lang->line("label_select_job_position"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_job_position"),
					"S_id"=>$this->lang->line("select_job_position"),
					"S_old_value"=>$this->input->post($this->lang->line("select_job_position")),
					"S_data"=>$this->emm->get_select("tb_job_position","job_position_name"),
					"S_id_field"=>"job_position_id",
					"S_name_field"=>"job_position_name",
					"help_text"=>''
			);
			$se_room_type=array(
					"LB_text"=>$this->lang->line("label_select_room_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_room_type"),
					"S_id"=>$this->lang->line("select_room_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_room_type")),
					"S_data"=>$this->emm->get_select("tb_room_type","room_type_name"),
					"S_id_field"=>"room_type_id",
					"S_name_field"=>"room_type_name",
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
			$se_office=array(
					"LB_text"=>$this->lang->line("label_select_office"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_office"),
					"S_id"=>$this->lang->line("select_office"),
					"S_old_value"=>$this->input->post($this->lang->line("select_office")),
					"S_data"=>$this->emm->get_select("tb_office","office_name"),
					"S_id_field"=>"office_id",
					"S_name_field"=>"office_name",
					"help_text"=>''
			);
			$se_person_type=array(
					"LB_text"=>$this->lang->line("label_select_person_type"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_person_type"),
					"S_id"=>$this->lang->line("select_person_type"),
					"S_old_value"=>$this->input->post($this->lang->line("select_person_type")),
					"S_data"=>$this->emm->get_select("tb_person_type","person_type"),
					"S_id_field"=>"person_type_id",
					"S_name_field"=>"person_type",
					"help_text"=>''
			);
			$se_person=array(
					"LB_text"=>$this->lang->line("label_select_person"),
					"LB_attr"=>$this->eml->span_redstar(),
					"S_class"=>'',
					"S_name"=>$this->lang->line("select_person"),
					"S_id"=>$this->lang->line("select_person"),
					"S_old_value"=>$this->input->post($this->lang->line("select_person")),
					"S_data"=>'',
					"S_id_field"=>"person_type_id",
					"S_name_field"=>"person_type",
					"help_text"=>''
			);
			//add other
			$in_faculty=array(
					"LB_text"=>$this->lang->line("label_input_faculty"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_faculty"),
					"IN_id"=>$this->lang->line("input_faculty"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_faculty")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$in_department=array(
					"LB_text"=>$this->lang->line("label_input_department"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_department"),
					"IN_id"=>$this->lang->line("input_department"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_department")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$in_job_position=array(
					"LB_text"=>$this->lang->line("label_input_job_position"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_job_position"),
					"IN_id"=>$this->lang->line("input_job_position"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_job_position")),
					"IN_attr"=>'maxlength="30"',
					"help_text"=>""
			);
			$in_office=array(
					"LB_text"=>$this->lang->line("label_input_office"),
					"LB_attr"=>"",
					"IN_type"=>'text',
					"IN_class"=>'',
					"IN_name"=>$this->lang->line("input_office"),
					"IN_id"=>$this->lang->line("input_office"),
					"IN_PH"=>'',
					"IN_value"=>set_value($this->lang->line("input_office")),
					"IN_attr"=>'maxlength="30"',
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
					"se_faculty"=>$this->eml->form_select($se_faculty),
					"se_department"=>$this->eml->form_select($se_department),
					"se_job_position"=>$this->eml->form_select($se_job_position),
					"se_room_type"=>$this->eml->form_select($se_room_type),
					"se_room"=>$this->eml->form_select($se_room),
					"se_office"=>$this->eml->form_select($se_office),
					"se_person_type"=>$this->eml->form_select($se_person_type),
					"se_person"=>$this->eml->form_select($se_person),
					"in_std_id"=>$this->eml->form_input($in_std_id),
					"in_phone"=>$this->eml->form_input($in_phone),
					"in_num_of_people"=>$this->eml->form_input($in_num_of_people),
					"in_project_name"=>$this->eml->form_input($in_project_name),
					"te_for_use"=>$this->eml->form_textarea($te_for_use),
					"in_faculty"=>$this->eml->form_input($in_faculty),
					"in_department"=>$this->eml->form_input($in_department),
					"in_job_position"=>$this->eml->form_input($in_job_position),
					"in_office"=>$this->eml->form_input($in_office)
			);
			$this->load->view("manage/reserve/add_reserve",$data);
		}
		else
		{
			echo "<hr>";
			echo "ข้อมูลผู้จอง";
			echo "<hr>";
			echo "<p>person_type : ".$this->input->post("select_person_type")."</p>";
			echo "<p>person : ".$this->input->post("select_person")."</p>";
			if($this->input->post("select_person")=="03")//บุคคลทั่วไป
			{
				echo "<p>select_job_position : ".$this->input->post("select_job_position")."</p>";
				if($this->input->post("select_job_position")=="00")
					echo "<p>input_job_position : ".$this->input->post("input_job_position")."</p>";
				echo "<p>select_office : ".$this->input->post("select_office")."</p>";
				if($this->input->post("select_office")=="00")
					echo "<p>input_office : ".$this->input->post("input_office")."</p>";
			}
			echo "<p>input_phone : ".$this->input->post("input_phone")."</p>";
			echo "<hr>";
			echo "มีความประสงค์ขอใช้";
			echo "<hr>";
			echo "<p>select_room_type : ".$this->input->post("select_room_type")."</p>";
			echo "<p>select_room : ".$this->input->post("select_room")."</p>";
			echo "<p>input_num_of_people : ".$this->input->post("input_num_of_people")."</p>";
			echo "<p>textarea_for_use : ".$this->input->post("textarea_for_use")."</p>";
			//echo "<p> : ".$this->input->post("")."</p>";
			//echo $this->input->post("select_person_type");
			//echo $this->input->post("select_person_type");
			print_r($this->input->post("article"));
			print_r($this->input->post("article_num"));
			
			
			print_r($this->input->post("input-begin-time1"));
			print_r($this->input->post("input-end-time1"));
			foreach($this->input->post("input-begin-time1") as $key=>$bg)
			{
				echo $this->convert_datetime($bg)["date"];
				echo "<hr>";
				//echo $this->convert_datetime($bg)["time"];
				
			}
			print_r($this->input->post("day-time2"));
		}
		//redirect(base_url()."?d=manage&c=reserve&m=add_datetime");
	}

	function add_datetime()
	{
		$config=array(
				array(
						"field"=>$this->lang->line("input_std_id"),
						"label"=>$this->lang->line("label_input_std_id"),
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		if($this->frm->run() == false)
		{
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จองห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose()
			);
			$this->load->view("manage/reserve/add_datetime_reserve",$data);
		}
		else
		{
			//add to reserve_has_datetime
		}
	}
	function convert_datetime($subject)
	{
		$datetime=array("date"=>'',"time"=>'');
		//find date
		$pattern = "/(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}/";
		preg_match($pattern,$subject, $matches);
		
		if(count($matches)>0)
		{
			$date_pos=array(
					"year"=>substr($matches[0],6,4),
					"month"=>substr($matches[0],3,2),
					"day"=>substr($matches[0],0,2)
			);
			$datetime["date"]=$date_pos["year"]."-".$date_pos["month"]."-".$date_pos["day"];
		}

		//find time
		$pattern = "/(0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0])/";
		preg_match($pattern,$subject, $matches);
		if(count($matches)>0)$datetime["time"]=$matches[0];
		return $datetime;
	}
	function select_room_list()
	{
		/*
		 * Return JSON
		 */
		if($this->input->post("room_type_id")!=''):
			$query=$this->emm->select_room_list($this->input->post("room_type_id"));
			$data='';
			if($query>0):
			foreach($query AS $ar):
			$data.="<option value='".$ar['room_id']."'>".$ar['room_name']."</option>";
			endforeach;
		endif;
		echo json_encode(array("room_list"=>$data));
		else: echo "";
		endif;
	}
	function select_person_list()
	{
		/*
		 * Return JSON
		*/
		if($this->input->post("person_type_id")!=''):
		$query=$this->emm->select_person_list($this->input->post("person_type_id"));
		$data='';
		if($query>0):
		foreach($query AS $ar):
		$data.="<option value='".$ar['person_id']."'>".$ar['person']."</option>";
		endforeach;
		endif;
		echo json_encode(array("person_list"=>$data));
		else: echo "";
		endif;
	}
	function get_room_has_article()
	{
		if($this->input->post("room_id")!='')
		{
			$query=$this->load_reserve_model->get_room_has_article($this->input->post("room_id"));
			$arr=array();
			foreach($query as $q)
			{
				$html='';
				$html.='<div class="checkbox del-checkbox">
				<label>
				<input type="checkbox" name="article[]" value="'.$q["tb_article_id"].'">'.$q["article_name"].' <span>('.$q["unit_num"].')</span></label>
				</div>';
				array_push($arr,$html);
			}
			echo json_encode($arr);	
		}
	}
}