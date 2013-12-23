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
					"S_data"=>$this->emm->get_select("tb_department","department_name",array("checked"=>1)),
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
					"S_data"=>$this->emm->get_select("tb_job_position","job_position_name",array("checked"=>1)),
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
					"S_data"=>$this->emm->get_select("tb_office","office_name",array("checked"=>1)),
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
			$this->db->trans_begin();
			
			//insert tb_reserve
			$reserve_id=$this->load_reserve_model->get_maxid(5,"reserve_id","tb_reserve");
			$data=array(
					"reserve_id"=>$reserve_id,
					"tb_user_username"=>$this->session->userdata("rs_username"),
					"tb_room_id"=>$this->input->post("select_room"),
					"for_use"=>$this->input->post("textarea_for_use"),
					"project_name"=>$this->input->post("input_project_name"),
					"other_article"=>$this->input->post("other_article"),
					"num_of_people"=>$this->input->post("input_num_of_people"),
					"reserve_on"=>date('Y-m-d H:i:s')
					//""=>"",
			);
			$redirect_link="?d=manage&c=reserve&m=add";
			$this->load_reserve_model->manage_add2($data,"tb_reserve");
			
			//insert tb_reserve_has_article
			foreach ($this->input->post("article") as $index=>$val)
			{
				$data2=array(
						"tb_reserve_id"=>$reserve_id,
						"tb_article_id"=>$val,
						"unit_num"=>$this->input->post("article_num")[$index]
				);
				$this->load_reserve_model->manage_add2($data2,"tb_reserve_has_article");
			}
			
			//insert tb_reserve_has_datetime
			if($this->input->post("reserve_time")=="reserve_time1")
			{
				foreach($this->input->post("input-begin-time1") as $key=>$val)
				{
					//วันเริ่ม กับ สิ้นสุดต้องเป็นวันเดียวกัน
					if($this->convert_datetime($this->input->post("input-begin-time1")[$key])["date"] == $this->convert_datetime($this->input->post("input-end-time1")[$key])["date"])
					{
						$beginDT=new DateTime($this->convert_datetime($val)["date"]." ".$this->convert_datetime($val)["time"]);
						$endDT=new DateTime($this->convert_datetime($this->input->post("input-end-time1")[$key])["date"]." ".$this->convert_datetime($this->input->post("input-end-time1")[$key])["time"]);
						$interval = DateInterval::createFromDateString('1 day');
						//หาระยะเวลา
						$period = new DatePeriod($beginDT, $interval, $endDT);
						foreach ( $period as $dt )
						{
							$begin1=$dt->format( "Y-m-d H:i:s" );
							$pattern = "/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])/";
							preg_match($pattern,$dt->format( "Y-m-d H:i:s" ), $enddate);
							$end1=$enddate[0]." ".$this->convert_datetime($this->input->post("input-end-time1")[$key])["time"];
							$data3=array(
									"datetime_id"=>$this->load_reserve_model->get_maxid(6,"datetime_id","tb_reserve_has_datetime"),
									"tb_reserve_id"=>$reserve_id,
									"reserve_datetime_begin"=>$begin1,
									"reserve_datetime_end"=>$end1
							);
							$this->load_reserve_model->manage_add2($data3,"tb_reserve_has_datetime");
						}					
					}
				}
			}
			else if($this->input->post("reserve_time")=="reserve_time2")
			{
				$yearBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],0,4);
				$monthBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],5,2);
				$dateBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],8,2);
				$yearEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],0,4);
				$monthEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],5,2);
				$dateEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],8,2);
				$timeBegin=$this->convert_datetime($this->input->post("input-begin-time2"))["time"];
				$timeEnd=$this->convert_datetime($this->input->post("input-end-time2"))["time"];
				$arrDateTimeBegin=array();
				$arrDateTimeEnd=array();
				$arr_dayofweek=$this->input->post("day-time2");
				for($y=$yearBegin; $y<=$yearEnd; $y++)
				{
					if($yearEnd-$y>0)
					{
						if($y==$yearBegin) $minmonth=$monthBegin;
						else $minmonth=1;
						for($m=$minmonth; $m<=12; $m++)
						{
							$d1;
							if($y==$yearBegin)//ถ้าเป็นปีแรก
							{
							//ถ้าเป็นเดือนแรกให้เริ่มloopตั้งแต่วันเริ่มที่เลือกไว้
								if($m==$monthBegin) $d1=$dateBegin;
								else $d1=1;
							}
							else $d1=1;
							for($d1; $d1<=cal_days_in_month(CAL_GREGORIAN, $m, $y); $d1++)
							{
								foreach($arr_dayofweek as $key=>$val)
								{
									if(date('w',strtotime($y."-".$m."-".$d1))==$val)
									{
										array_push($arrDateTimeBegin, $y."-".$m."-".$d1." ".$timeBegin);
										array_push($arrDateTimeEnd, $y."-".$m."-".$d1." ".$timeEnd);
									}
								}
							}
						}
					}
					else if($yearEnd-$y==0)
					{
						for($m=1; $m<=$monthEnd; $m++)
						{
							if($m==$monthEnd)
							{
								for($d1=1; $d1<=$dateEnd; $d1++)
								{
									foreach($arr_dayofweek as $key=>$val)
									{
										if(date('w',strtotime($y."-".$m."-".$d1))==$val)
										{
											array_push($arrDateTimeBegin, $y."-".$m."-".$d1." ".$timeBegin);
											array_push($arrDateTimeEnd, $y."-".$m."-".$d1." ".$timeEnd);
										}
									}
								}
							}
						}
					}
				}
				foreach($arrDateTimeBegin as $index=>$val)
				{
					$data3=array(
							"datetime_id"=>$this->load_reserve_model->get_maxid(6,"datetime_id","tb_reserve_has_datetime"),
							"tb_reserve_id"=>$reserve_id,
							"reserve_datetime_begin"=>$val,
							"reserve_datetime_end"=>$arrDateTimeEnd[$index]
					);
					$this->load_reserve_model->manage_add2($data3,"tb_reserve_has_datetime");
				}
			}
					
			//insert tb_reserve_has_person
			if($this->input->post("select_person")=="03")//บุคคลทั่วไป
			{
				$job_position_id=$this->input->post("select_job_position");
				$office_id=$this->input->post("select_office");
				if($this->input->post("select_job_position")=="00")
				{
					if($this->load_reserve_model->find_one("tb_job_position",array("job_position_name"=>$this->input->post("input_job_position"))))
					{
						$exists_data=$this->load_reserve_model->find_one("tb_job_position",array("job_position_name"=>$this->input->post("input_job_position")))[0];
						if($this->countdim($exists_data)==1)
							$job_position_id=$exists_data["job_position_id"];
					}
					else
					{
						$job_position_id=$this->load_reserve_model->get_maxid(2,"job_position_id","tb_job_position");
						$this->load_reserve_model->manage_add2(
								array(
										"job_position_id"=>$job_position_id,
										"job_position_name"=>$this->input->post("input_job_position")
								),
								"tb_job_position");
					}
				}
				if($this->input->post("select_office")=="00")
				{
					if($this->load_reserve_model->find_one("tb_office",array("office_name"=>$this->input->post("input_office"))))
					{
						$exists_data=$this->load_reserve_model->find_one("tb_office",array("office_name"=>$this->input->post("input_office")))[0];
						if($this->countdim($exists_data)==1)
							$office_id=$exists_data["office_id"];
					}
					else
					{
						$office_id=$this->load_reserve_model->get_maxid(2,"office_id","tb_office");
						$this->load_reserve_model->manage_add2(
								array(
										"office_id"=>$office_id,
										"office_name"=>$this->input->post("input_office")
								),
								"tb_office");
					}
				}
				$data4=array(
						"tb_reserve_id"=>$reserve_id,
						"tb_person_id"=>$this->input->post("select_person"),
						"phone"=>$this->input->post("input_phone"),
						"tb_job_position_id"=>$job_position_id,
						"tb_office_id"=>$office_id
				);
			}
			else if($this->input->post("select_person")=="02" || $this->input->post("select_person")=="01")//02std || 01teacher
			{
				$faculty_id=$this->input->post("select_faculty");
				$department_id=$this->input->post("select_department");
				$job_position_id=$this->input->post("select_job_position");
				if($this->input->post("select_faculty")=="00")
				{
					//ถ้ามี ชื่อที่ซ้ำกันอยู่แล้วให้เลือกคีย์ของชื่อนั้นมาใช้อ้างอิง เพราะ ฟิลด์ชื่อเป็น unique
					if($this->load_reserve_model->find_one("tb_faculty",array("faculty_name"=>$this->input->post("input_faculty"))))
					{
						$exists_data=$this->load_reserve_model->find_one("tb_faculty",array("faculty_name"=>$this->input->post("input_faculty")))[0];
						if($this->countdim($exists_data)==1)
							$faculty_id=$exists_data["faculty_id"];
					}
					else
					{
						$faculty_id=$this->load_reserve_model->get_maxid(2,"faculty_id","tb_faculty");
						$this->load_reserve_model->manage_add2(
							array(
									"faculty_id"=>$faculty_id,
									"faculty_name"=>$this->input->post("input_faculty")
							),
							"tb_faculty");
					}
				}
				if($this->input->post("select_department")=="00")
				{
					//ถ้ามี ชื่อที่ซ้ำกันอยู่แล้วให้เลือกคีย์ของชื่อนั้นมาใช้อ้างอิง เพราะ ฟิลด์ชื่อเป็น unique
					if($this->load_reserve_model->find_one("tb_department",array("department_name"=>$this->input->post("input_department"))))
					{
						$exists_data=$this->load_reserve_model->find_one("tb_department",array("department_name"=>$this->input->post("input_department")))[0];
						if($this->countdim($exists_data)==1)
							$department_id=$exists_data["department_id"];
					}
					else
					{
						$department_id=$this->load_reserve_model->get_maxid(2,"department_id","tb_department");
						$this->load_reserve_model->manage_add2(
							array(
									"department_id"=>$department_id,
									"department_name"=>$this->input->post("input_department")
							),
							"tb_department");
					}
				}
				if($this->input->post("select_person")=="01")//01=อาจารย์/เจ้าหน้าที่
				{
					if($this->input->post("select_job_position")=="00")
					{
						if($this->load_reserve_model->find_one("tb_job_position",array("job_position_name"=>$this->input->post("input_job_position"))))
						{
							$exists_data=$this->load_reserve_model->find_one("tb_job_position",array("job_position_name"=>$this->input->post("input_job_position")))[0];
							if($this->countdim($exists_data)==1)
								$job_position_id=$exists_data["job_position_id"];
						}
						else
						{
							$job_position_id=$this->load_reserve_model->get_maxid(2,"job_position_id","tb_job_position");
							$this->load_reserve_model->manage_add2(
									array(
											"job_position_id"=>$job_position_id,
											"job_position_name"=>$this->input->post("input_job_position")
									),
									"tb_job_position");
						}
					}
					//data 01teacher
					$data4=array(
							"tb_reserve_id"=>$reserve_id,
							"tb_person_id"=>$this->input->post("select_person"),
							"phone"=>$this->input->post("input_phone"),
							"tb_faculty_id"=>$faculty_id,
							"tb_department_id"=>$department_id,
							"tb_job_position_id"=>$job_position_id
					);
				}
				else
				{
					//data 02std
					$data4=array(
							"tb_reserve_id"=>$reserve_id,
							"tb_person_id"=>$this->input->post("select_person"),
							"phone"=>$this->input->post("input_phone"),
							"tb_faculty_id"=>$faculty_id,
							"tb_department_id"=>$department_id,
							"std_id"=>$this->input->post("input_std_id")
					);
				}
			}
			//data4 ใช้กับรหัส person 01 02 03
			$this->load_reserve_model->manage_add2($data4,"tb_reserve_has_person");
			
			
			//upload file
			if($this->input->post("select_person_type")!=02)
			{
				$this->load->library('upload'); // Load Library
				$files = $_FILES;
				$cpt = count($_FILES['project_file']['name']);
				$config = array();
				$config['upload_path'] = './upload/';
				$config['allowed_types'] = 'doc|docx|pdf';
				$config['max_size']      = '0';
				$config['overwrite']     = FALSE;
				$this->upload->initialize($config); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean
				
				for($i=0; $i<$cpt; $i++)
				{
					$name = $_FILES["project_file"]["name"][$i];
					$ext = end(explode(".", $name));
					$file_detail=array(
							"new_name"=>str_replace(".", "_", microtime(true)).".".end(explode(".", $files["project_file"]["name"][$i])),
							"old_name"=>$files["project_file"]["name"][$i],
							"ext"=>end(explode(".", $files["project_file"]["name"][$i])),
							"type"=>$files["project_file"]["type"][$i],
							"error"=>$files["project_file"]["error"][$i],
							"size"=>$files["project_file"]["size"][$i]
					);
					print_r($file_detail);
					$_FILES['project_file']['name']= $file_detail["new_name"];
					$_FILES['project_file']['type']= $files['project_file']['type'][$i];
					$_FILES['project_file']['tmp_name']= $files['project_file']['tmp_name'][$i];
					$_FILES['project_file']['error']= $files['project_file']['error'][$i];
					$_FILES['project_file']['size']= $files['project_file']['size'][$i];
					//echo "<hr>";print_r($_FILES);
					if($this->upload->do_upload('project_file'))
					{
						//upload success
						$data5=array(
								"file_id"=>$this->load_reserve_model->get_maxid(5,"file_id","tb_reserve_has_file"),
								"tb_reserve_id"=>$reserve_id,
								"file_name"=>$file_detail["new_name"],
								"old_file_name"=>$file_detail["old_name"]
						);
						$this->load_reserve_model->manage_add2($data5,"tb_reserve_has_file");
					}
					else
					{
						echo $this->upload->display_errors('<p>', '</p>');
					}
				}
			}
			if($this->db->trans_status()===FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
			}
			
			
			/* TEST SHOW DATA ZONE
			echo "<hr>";
			echo "tb_reserve";
			echo "<hr>";
			echo "<p>reserve_id : xxx</p>";
			echo "<p>tb_user_username : session_username</p>";
			echo "<p>tb_room_id : ".$this->input->post("select_room")."</p>";
			echo "<p>for_use : ".$this->input->post("textarea_for_use")."</p>";
			echo "<p>project_name : ".$this->input->post("input_project_name")."</p>";
			echo "<p>other_article : ".$this->input->post("other_article")."</p>";
			echo "<p>num_of_people : ".$this->input->post("input_num_of_people")."</p>";
			echo "<p>reserve_on : ".date("Y-m-d H:i:s")."</p>";
			echo "<p> : ".$this->input->post("")."</p>";
			//echo "<p> : ".$this->input->post("")."</p>";
			echo "<hr>";
			echo "tb_reserve_has_datetime";
			echo "<hr>";
			if($this->input->post("reserve_time")=="reserve_time1")
			{
				foreach($this->input->post("input-begin-time1") as $key=>$val)
				{
					echo "<p>begin-time1:".$key." : ".$this->input->post("input-begin-time1")[$key]."</p>";
					echo "<p>end-time1:".$key." : ".$this->input->post("input-end-time1")[$key]."</p>";
				}
			}
			else if($this->input->post("reserve_time")=="reserve_time2")
			{
				
				$yearBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],0,4);
				$monthBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],5,2);
				$dateBegin=substr($this->convert_datetime($this->input->post("input-begin-time2"))["date"],8,2);
				$yearEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],0,4);
				$monthEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],5,2);
				$dateEnd=substr($this->convert_datetime($this->input->post("input-end-time2"))["date"],8,2);
				$timeBegin=$this->convert_datetime($this->input->post("input-begin-time2"))["time"];
				$timeEnd=$this->convert_datetime($this->input->post("input-end-time2"))["time"];
				$arrDateTimeBegin=array();
				$arrDateTimeEnd=array();
				$arr_dayofweek=$this->input->post("day-time2");
				for($y=$yearBegin; $y<=$yearEnd; $y++)
				{
					if($yearEnd-$y>0)
					{
						if($y==$yearBegin) $minmonth=$monthBegin;
						else $minmonth=1;
						for($m=$minmonth; $m<=12; $m++)
						{
							$d1;
							if($y==$yearBegin)//ถ้าเป็นปีแรก
							{
								//ถ้าเป็นเดือนแรกให้เริ่มloopตั้งแต่วันเริ่มที่เลือกไว้
								if($m==$monthBegin) $d1=$dateBegin;
								else $d1=1;
							}
							else $d1=1;
							for($d1; $d1<=cal_days_in_month(CAL_GREGORIAN, $m, $y); $d1++)
							{
								foreach($arr_dayofweek as $key=>$val)
								{
									if(date('w',strtotime($y."-".$m."-".$d1))==$val)
									{
										array_push($arrDateTimeBegin, $y."-".$m."-".$d1." ".$timeBegin);
										array_push($arrDateTimeEnd, $y."-".$m."-".$d1." ".$timeEnd);
									}
								}
							}
						}
					}
					else if($yearEnd-$y==0)
					{
						for($m=1; $m<=$monthEnd; $m++)
						{
							if($m==$monthEnd)
							{
								for($d1=1; $d1<=$dateEnd; $d1++)
								{
									foreach($arr_dayofweek as $key=>$val)
									{
										if(date('w',strtotime($y."-".$m."-".$d1))==$val)
										{
											array_push($arrDateTimeBegin, $y."-".$m."-".$d1." ".$timeBegin);
											array_push($arrDateTimeEnd, $y."-".$m."-".$d1." ".$timeEnd);
										}
									}
								}
							}
						}
					}
				}
				print_r($arrDateTimeBegin);
				print_r($arrDateTimeEnd);
				//echo $this->convert_datetime($this->input->post("input-begin-time2"))["date"];
			}
			
			
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
			else if($this->input->post("select_person")=="02")//std
			{
				//select_faculty
				//	input_faculty
				//select_department
				//	input_department
				//input_std_id
			}
			else if($this->input->post("select_person")=="01")//teacher
			{
				//select_faculty
				//	input_faculty
				//select_department
				//	input_department
				//select_job_position
				//	input_job_position
			}
			echo "<p>input_phone : ".$this->input->post("input_phone")."</p>";
			echo "<hr>";
			echo "มีความประสงค์ขอใช้";
			echo "<hr>";
			echo "<p>select_room_type : ".$this->input->post("select_room_type")."</p>";
			echo "<p>select_room : ".$this->input->post("select_room")."</p>";
			echo "<p>input_num_of_people : ".$this->input->post("input_num_of_people")."</p>";
			echo "<p>textarea_for_use : ".$this->input->post("textarea_for_use")."</p>";
			echo "<hr>";
			echo "ครุภัณฑ์/อุปกรณ์ที่ใช้";
			echo "<hr>";
			echo "<p>checkbox article[] : ".print_r($this->input->post("article"))."</p>";
			echo "<p>checkbox article_num[] : ".print_r($this->input->post("article_num"))."</p>";
			echo "<p>textarea other_article : ".$this->input->post("other_article")."</p>";
			echo "<hr>";
			echo "ข้อมูลโครงการ";
			echo "<hr>";
			echo "<p>input_project_name : ".$this->input->post("input_project_name")."</p>";
			echo "<hr>";
			echo "กำหนดเวลา";
			echo "<hr>";
			echo "<p>radio: ".$this->input->post("reserve_time")."</p>";
			echo "<p>input-begin-time1[] : ".print_r($this->input->post("input-begin-time1"))."</p>";
			echo "<p>input-end-time1[] : ".print_r($this->input->post("input-end-time1"))."</p>";
			echo "<p>input-begin-time2 : ".$this->input->post("input-begin-time2")."</p>";
			echo "<p>input-end-time2 : ".$this->input->post("input-end-time2")."</p>";
			echo "<p>day-time2[] : ".print_r($this->input->post("day-time2"))."</p>";
			//echo "<p> : ".$this->input->post("")."</p>";
			//echo $this->input->post("select_person_type");
			//echo $this->input->post("select_person_type");
			//print_r($this->input->post("article"));
			//print_r($this->input->post("article_num"));
			
			
			//print_r($this->input->post("input-begin-time1"));
			//print_r($this->input->post("input-end-time1"));
			foreach($this->input->post("input-begin-time1") as $key=>$bg)
			{
				//echo $this->convert_datetime($bg)["date"];
				//echo "<hr>";
				//echo $this->convert_datetime($bg)["time"];
				
			}
			//print_r($this->input->post("day-time2"));
			 
			*/
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
		$pattern = "/([0-9]|0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]|6[0])/";
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
	// count dimension of array
	function countdim($array)
	{
		if (is_array(reset($array)))
		{
			$return = countdim(reset($array)) + 1;
		}
		else
		{
			$return = 1;
		}
		return $return;
	}
}