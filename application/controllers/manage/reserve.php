<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reserve extends MY_Controller
{
	private $table_name	="tb_reserve";
	private $field_name	=array();

	var  $load_reserve_model;
	
	function __construct()
	{
		parent::__construct();
		$this->fl->check_group_privilege(array("01","02","04","07"),false,"OR");
		$this->load->model("manage/reserve_model");
			$this->load_reserve_model=$this->reserve_model;
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
		$this->fl->check_group_privilege(array("07"));
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
			$data["reserve_tab"]=(!$this->fl->check_group_privilege(array("07"),true)) ? $this->reserve_tab() : '';
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
			if($this->input->post("article"))
			{
				foreach ($this->input->post("article") as $index=>$val)
				{
					$data2=array(
							"tb_reserve_id"=>$reserve_id,
							"tb_article_id"=>$val,
							"unit_num"=>$this->input->post("article_num")[$index]
					);
					$this->load_reserve_model->manage_add2($data2,"tb_reserve_has_article");
				}
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
							//1388212969.8946 to 1388212969_8946
							"new_name"=>str_replace(".", "_",microtime(true)).rand(100,999).".".end(explode(".", $files["project_file"]["name"][$i])),
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
				redirect(base_url()."?d=manage&c=reseve&m=view&id=".$reserve_id);
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
			$query=$this->emm->reserve_room_list($this->input->post("room_type_id"));
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
				<input type="checkbox" name="article[]" value="'.$q["tb_article_id"].'">'.$q["article_name"].' <span>('.$q["article_num"].')</span></label>
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
	function edit()
	{
		$this->fl->check_group_privilege(array("01"));
		$config=array(
				array(
						"field"=>"input_reserve_name",
						"label"=>"ชื่อห้อง",
						"rules"=>"required|max_length[50]"
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_reserve"))
				$this->session->set_userdata("orderby_reserve",array("field"=>"reserve_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=reserve&m=edit";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]+$/',$_GET['page'])) $this->getpage=(($_GET['page']-1)*$config['per_page']);
			else $this->getpage=0;
		
		
			if($this->session->userdata("search_reserve"))
			{
				$liketext=$this->session->userdata("search_reserve");
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows("tb_reserve",$liketext,"reserve_id");
		
				$get_reserve_list=$this->load_reserve_model->get_reserve_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows("tb_reserve",'',"reserve_id");
				$get_reserve_list=$this->load_reserve_model->get_reserve_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จัดการการจอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"reserve_tab"=>$this->reserve_tab(),
					"table_edit"=>$this->table_edit($get_reserve_list),
					"session_search_reserve"=>$this->session->userdata("search_reserve"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_reserve"))
			);
			$this->load->view("manage/reserve/edit_reserve",$data);
		}
		else
		{

		}
	}
	function edit2()
	{
		$this->fl->check_group_privilege(array("01"));
		$config=array(
				array(
						"field"=>"aa",
						"label"=>"aa",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_reserve2"))
				$this->session->set_userdata("orderby_reserve2",array("field"=>"reserve_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=reserve&m=edit2";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]+$/',$_GET['page'])) $this->getpage=(($_GET['page']-1)*$config['per_page']);
			else $this->getpage=0;
		
		
			if($this->session->userdata("search_reserve2"))
			{
				$liketext=$this->session->userdata("search_reserve2");
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows2("tb_reserve",$liketext,"reserve_id");
		
				$get_reserve_list=$this->load_reserve_model->get_reserve_list2($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows2("tb_reserve",'',"reserve_id");
		
				$get_reserve_list=$this->load_reserve_model->get_reserve_list2($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จัดการการจอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"reserve_tab"=>$this->reserve_tab(),
					"table_edit"=>$this->table_edit($get_reserve_list),
					"session_search_reserve"=>$this->session->userdata("search_reserve2"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_reserve2"))
			);
			$this->load->view("manage/reserve/edit_reserve2",$data);
		}
		else
		{

		}
	}
	function edit3()
	{
		$this->fl->check_group_privilege(array("04"));
		$config=array(
				array(
						"field"=>"aa",
						"label"=>"aa",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_reserve3"))
				$this->session->set_userdata("orderby_reserve3",array("field"=>"reserve_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=reserve&m=edit3";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
	
			if(isset($_GET['page']) && preg_match('/^[\d]+$/',$_GET['page'])) $this->getpage=(($_GET['page']-1)*$config['per_page']);
			else $this->getpage=0;
	
	
			if($this->session->userdata("search_reserve3"))
			{
				$liketext=$this->session->userdata("search_reserve3");
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows3("tb_reserve",$liketext,"reserve_id");
	
				$get_reserve_list=$this->load_reserve_model->get_reserve_list3($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_reserve_model->get_all_reserve_numrows3("tb_reserve",'',"reserve_id");
	
				$get_reserve_list=$this->load_reserve_model->get_reserve_list3($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
	
			//..pagination
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จัดการการจอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"reserve_tab"=>$this->reserve_tab(),
					"table_edit"=>$this->table_edit($get_reserve_list),
					"session_search_reserve"=>$this->session->userdata("search_reserve3"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_reserve3"))
			);
			$this->load->view("manage/reserve/edit_reserve3",$data);
		}
		else
		{
	
		}
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_reserve")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_reserve")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ชื่อโครงการ</th>
				<th class="same_first_td">อนุมัติ</th>
				<th class="same_first_td">รายละเอียด</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_reserve"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=reserve&m=delete" id="form_del_reserve">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			if($dt['approve']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["reserve_id"].'" id="checkboxFourInput'.$dt["reserve_id"].'" name="allow_reserve0[]" class="allow_reserve0"/>
										  	<label for="checkboxFourInput'.$dt["reserve_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["reserve_id"].'" id="checkboxFourInput'.$dt["reserve_id"].'" name="allow_reserve1[]" class="allow_reserve1" checked/>
						  	<label for="checkboxFourInput'.$dt["reserve_id"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$dt["reserve_id"].'</td>
					<td id="reserve'.$dt["reserve_id"].'">'.$dt["project_name"].'</td>
					<td class="text-center">'.$this->eml->btn('approve','onclick=approve_alert("'.$dt['reserve_id'].'","'.base_url().'");').'</td>
					<td class="same_first_td">'.$this->eml->btn('view','onclick=window.open("'.base_url().'?d=manage&c=reserve&m=view&id='.$dt["reserve_id"].'","_blank")').'</td>
					<td><input type="checkbox" value="'.$dt["reserve_id"].'" name="del_reserve[]" class="del_reserve"></td>
			';
			//<td class="same_first_td">'.$this->eml->btn('view','onclick=show_all_data("'.$dt["reserve_id"].'")').'</td>
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
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
	function reserve_tab()
	{
		//<li><a href="#"  id="add">จองห้อง</a></li>
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			';
		if($this->fl->check_group_privilege(array("02"),true))
		{
			$html.='<li><a href="#"  id="edit">จัดการการจอง</a></li>';
		}
		$html.='<li><a href="#"  id="edit2">จัดการการจองที่อนุมัติแล้ว</a></li>';
		if($this->fl->check_group_privilege(array("04"),true))
		{
			$html.='<li><a href="#"  id="edit3">จัดการการจองสำหรับผู้บริหาร</a></li>';
		}
		
		$html.='</ul>';
		return $html;
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$this->load_reserve_model->manage_allow($allow_list,$disallow_list, "tb_reserve", "reserve_id", "project_name", "edit_reserve", "?d=manage&c=reserve&m=edit");
	}
	function show_all_data()
	{
		if($this->input->post("get")=="article")
		{
			echo json_encode($this->load_reserve_model->get_article_data($this->input->post("reserve_id")));
		}
		else if($this->input->post("get")=="datetime")
		{
			echo json_encode($this->load_reserve_model->get_datetime_data($this->input->post("reserve_id")));
		}
		else if($this->input->post("get")=="file")
		{
			echo json_encode($this->load_reserve_model->get_file_data($this->input->post("reserve_id")));
		}
		else if($this->input->post("get")=="reserve")
		{
			echo json_encode($this->load_reserve_model->get_reserve_data($this->input->post("reserve_id"))[0]);
		}
		
	}
	function view()
	{
		if(isset($_GET["id"]))
		{
			
			$article_data=$this->load_reserve_model->get_article_data($_GET["id"]);
			$datetime_data=$this->load_reserve_model->get_datetime_data($_GET["id"]);
			$file_data=$this->load_reserve_model->get_file_data($_GET["id"]);
			$reserve_data=$this->load_reserve_model->get_reserve_data($_GET["id"])[0];
			
			/*
			 * test
			*/

			$this->db->select("tb_person_type.*")->from("tb_reserve_has_person");
			$this->db->join("tb_person","tb_person.person_id=tb_reserve_has_person.tb_person_id");
			$this->db->join("tb_person_type","tb_person_type.person_type_id=tb_person.tb_person_type_id");
			$this->db->where("tb_reserve_has_person.tb_reserve_id",$_GET["id"])->limit(1);
			$person_type = $this->db->get()->result_array();
			
			$this->db->select()->from("tb_reserve_has_article");
			$this->db->join("tb_article","tb_article.article_id=tb_reserve_has_article.tb_article_id");
			$this->db->where("tb_reserve_id",$_GET["id"]);
			$used_article = $this->db->get()->result_array();
			
			$this->db->select("tb_article.article_id")->from("tb_reserve_has_article");
			$this->db->join("tb_article","tb_article.article_id=tb_reserve_has_article.tb_article_id");
			$this->db->where("tb_reserve_id",$_GET["id"]);
			$used_article_query = $this->db->get()->result_array();
			
			$where_in=array();
			foreach($used_article_query as $u)
			{
				array_push($where_in,$u['article_id']);
			}
			
			$this->db->select("
					tb_room.*,tb_room.tb_fee_type_id AS room_fee_type,
					tb_room_has_article.*,tb_room_has_article.tb_fee_type_id AS rha_fee_type,
					tb_fee_type.*,
					tb_article.*,
					tb_reserve_has_article.*,
					tb_reserve.*,
					tb_reserve_has_datetime.*
					")->from("tb_room");
			$this->db->join("tb_room_has_article","tb_room_has_article.tb_room_id=tb_room.room_id");
			$this->db->join("tb_fee_type","tb_fee_type.fee_type_id=tb_room_has_article.tb_fee_type_id");
			$this->db->join("tb_article","tb_article.article_id=tb_room_has_article.tb_article_id");
			$this->db->join("tb_reserve_has_article","tb_reserve_has_article.tb_article_id=tb_article.article_id");
			$this->db->join("tb_reserve","tb_reserve.reserve_id=tb_reserve_has_article.tb_reserve_id");
			$this->db->join("tb_reserve_has_datetime","tb_reserve_has_datetime.tb_reserve_id=tb_reserve_has_article.tb_reserve_id");
			//$this->db->join("tb_reserve_has_person","tb_reserve_has_person.tb_reserve_id=tb_reserve_has_article.tb_reserve_id");
			$this->db->where("tb_room.room_id",$reserve_data['tb_room_id']);
			
			//ถ้า ไม่มีรายการจองอุปกรณ์
			if(!empty($used_article_query))
				$this->db->where_in("tb_room_has_article.tb_article_id",$where_in);
			
			$used_room = $this->db->get()->result_array();
			echo $this->db->last_query();
			//print_r($used_room);
			$total_price=0;
			foreach($used_room as $u)
			{
				//ค่าบริการของ อุปกรณ์
				//หา fee_type_id $u['fee_type_id'];
				//fee_type อยู่ใน tb_room_has_article
				if($u['fee_type_id']=="01")//เหมา
				{
					$price01 = ($u['fee_unit_lump_sum']*$u['lump_sum_base_unit']);
					if($u['unit_num'] > $u['lump_sum_base_unit']) 
						$price01 + (($u['unit_num']-$u['lump_sum_base_unit'])*$u['fee_over_unit_lump_sum']);
					//echo "ค่าบริการต่อหน่วย:".$u['fee_unit_lump_sum']."จำนวนพื้นฐาน(เหมา):".$u['lump_sum_base_unit'];
					echo "<hr>";
					echo "อุปกรณ์ :".$u['article_name'];
					echo "ประเภทค่าบริการ:".$u['fee_type_name'];
					echo "อัตราค่าบริการแบบเหมา  = จำนวนอุปกรณ์ :".$u['lump_sum_base_unit']." คิดเป็นเงิน :".($u['fee_unit_lump_sum']*$u['lump_sum_base_unit'])." บาท";
					echo "หากเกิน ".$u['lump_sum_base_unit']."หน่วย จะคิดหน่วยละ ".$u['fee_over_unit_lump_sum']." บาท";
					echo "<br>";
					echo "คิดเป็นเงิน : ".$price01." บาท";
					$total_price+=$price01;
				}
				else if($u['fee_type_id']=="02")//ชม.
				{
					//หาความต่างของเวลา จาก วัน/เวลาเริ่มต้น  - วัน/เวลาสิ้นสุด
					$datetime_diff=$this->datetime_diff($u['reserve_datetime_begin'], $u['reserve_datetime_end']);
					//ถ้านาทีเกิน 30 นาที ให้ บวกชม.เพิ่ม 1 และให้นาทีรีเซตเป็น 0
					if($datetime_diff['minute'] > 10)
					{
						$datetime_diff['minute']=0;
						$datetime_diff['hour']++;
					}
					$price02 = ($u['fee_unit_hour']*$datetime_diff['hour'])*$u['unit_num'];
					echo "<hr>";
					echo "อุปกรณ์:".$u['article_name'];
					echo "ค่าบริการ : ".$u['fee_unit_hour']." บาท/ชั่วโมง จำนวนอุปกรณ์ที่จอง : ".$u['unit_num'];
					echo "ประเภทค่าบริการ:".$u['fee_type_name'];
					echo "จำนวนเวลาที่จอง : ".$datetime_diff['hour']." ชั่วโมง";
					echo "คิดเป็นเงิน : ".$price02." บาท";
					
					$total_price+=$price02;
				}
			}
			//ค่าบริการของห้อง
			$this->db->select("COUNT(tb_reserve_id) AS count_tb_reserve_id")->from("tb_reserve_has_datetime");
			$count_day = $this->db->where("tb_reserve_id",$_GET['id'])->get()->result_array();
			
			
			if($used_room[0]['room_fee_type']=="01")//เหมา
			{
				echo "<hr>";
				echo "ค่าบริการห้อง ".$u['room_name']." : ".$u['room_fee_lump_sum']." บาท/วัน.";
				echo "คิดเป็นเงิน : ".($u['room_fee_lump_sum']*$count_day[0]['count_tb_reserve_id'])." บาท";
			}
			else if($used_room[0]['room_fee_type']=="02")//ชม.
			{
				echo "<hr>";
				echo "ค่าบริการห้อง ".$u['room_name']." : ".$u['room_fee_hour']." บาท/ชม.";
				echo "จำนวนเวลาที่จอง : ".$datetime_diff['hour']." ชั่วโมง";
				echo "คิดเป็นเงิน : ".($datetime_diff['hour']*$u['room_fee_hour'])." บาท";
			}
			
			echo "<hr>total".$total_price;
			if($person_type[0]['person_type_id']=="01")//ภายใน
			{
				
			}
			else if($person_type[0]['person_type_id']=="02")//ภายนอก
			{
					
			}
				
			/*
			 * test
			*/
			
			
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไข/ลบ  ห้อง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"article_data"=>$article_data,
					"datetime_data"=>$datetime_data,
					"file_data"=>$file_data,
					"reserve_data"=>$reserve_data,
					"total_price"=>$total_price
			);
			$this->load->view("manage/reserve/view_reserve",$data);
		}
	}
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_reserve",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
		if($this->input->post("field") && $this->input->post("type2"))
		{
			$this->session->set_userdata("orderby_reserve2",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type2")));
		}
	}
	function datetime_diff($datetimebegin,$datetimeend)
	{
		$start_date = new DateTime($datetimebegin);
		$end_date = new DateTime($datetimeend);
		$interval = $start_date->diff($end_date);
		return array(
				"year"=>$interval->y,
				"month"=>$interval->m,
				"day"=>$interval->d,
				"hour"=>$interval->h,
				"minute"=>$interval->i,
				"second"=>$interval->s
		);
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_reserve',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_reserve");
		}
		redirect(base_url()."?d=manage&c=reserve&m=edit");
	}
	function search2()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_reserve2',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_reserve2");
		}
		redirect(base_url()."?d=manage&c=reserve&m=edit2");
	}
	function search3()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_reserve3',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_reserve3");
		}
		redirect(base_url()."?d=manage&c=reserve&m=edit3");
	}
	function reserve_approve()
	{
		echo $this->input->post("select_approve");
		$set=array("approve"=>$this->input->post("select_approve"));
		if($this->input->post("select_approve") == 1)
		{
			$set['approve_on']=date('Y-m-d H:i:s');
			$set['approve_by']=$this->session->userdata("rs_username");
		}
		$where=array("reserve_id"=>@$_GET['id']);
		$this->load_reserve_model->manage_edit2($set,$where,"tb_reserve","reserve_approve","สำเร็จ","ไม่สำเร็จ",$_SERVER['HTTP_REFERER']);
		/*
		 * $set=array(
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
			$this->rom->manage_edit($set, $where, "tb_room", "edit_room", "แก้ไขห้องสำเร็จ", "แก้ไขห้องไม่สำเร็จ", "?d=manage&c=room&m=edit", $prev_url);
		
		 */
	}
	function reserve_list()
	{
		$config=array(
				array(
						"field"=>"aa",
						"label"=>"aa",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			if(!$this->session->userdata("orderby_reserve_list"))
				$this->session->set_userdata("orderby_reserve_list",array("field"=>"reserve_id","type"=>"ASC"));
			//pagination
			$this->load->library("pagination");
			$config['use_page_numbers'] = TRUE;
			$config['base_url']=base_url()."?d=manage&c=reserve&m=reserve_list";
			//set per_page
			if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
			else $config['per_page']=3;
		
			if(isset($_GET['page']) && preg_match('/^[\d]+$/',$_GET['page'])) $this->getpage=(($_GET['page']-1)*$config['per_page']);
			else $this->getpage=0;
		
		
			if($this->session->userdata("search_reserve_list"))
			{
				$liketext=$this->session->userdata("search_reserve_list");
				$config['total_rows']=$this->load_reserve_model->user_reserve_list_numrows("tb_reserve",$liketext,"reserve_id");
		
				$get_reserve_list=$this->load_reserve_model->user_reserve_list($config['per_page'],$this->getpage,$liketext);
			}
			else
			{
				$config['total_rows']=$this->load_reserve_model->user_reserve_list_numrows("tb_reserve",'',"reserve_id");
				$get_reserve_list=$this->load_reserve_model->user_reserve_list($config['per_page'],$this->getpage);
			}
			$this->pagination->initialize($config);
		
			//..pagination
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("จัดการการจอง"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"table_edit"=>$this->table_reserve_list($get_reserve_list),
					"session_search_reserve"=>$this->session->userdata("search_reserve_list"),
					"pagination_num_rows"=>$config["total_rows"],
					"manage_search_box"=>$this->pel->manage_search_box($this->session->userdata("search_reserve_list"))
			);
			$this->load->view("manage/reserve/user_reserve_list",$data);
		}
		else
		{
		
		}
	}
	function table_reserve_list($data)
	{
		if($this->session->userdata("orderby_reserve")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_reserve")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>รหัส</th>
				<th>ชื่อโครงการ</th>
				<th class="same_first_td">สถานะการจอง</th>
				<th class="same_first_td">รายละเอียด</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_reserve"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=reserve&m=delete" id="form_del_reserve">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			if($dt['approve']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["reserve_id"].'" id="checkboxFourInput'.$dt["reserve_id"].'" name="allow_reserve0[]" class="allow_reserve0"/>
										  	<label for="checkboxFourInput'.$dt["reserve_id"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["reserve_id"].'" id="checkboxFourInput'.$dt["reserve_id"].'" name="allow_reserve1[]" class="allow_reserve1" checked/>
						  	<label for="checkboxFourInput'.$dt["reserve_id"].'"></label>
					  		</span>';
			if($dt['approve']==0) $approve_text="<span class='text-warning'>รออนุมัติ</span>";
			else if($dt['approve']==1) $approve_text="<span class='text-success'>อนุมัติ</span>";
			else if($dt['approve']==3) $approve_text="<span class='text-danger'>ไม่อนุมัติ</span>";
			$html.='<tr>
					<td>'.$dt["reserve_id"].'</td>
					<td id="reserve'.$dt["reserve_id"].'">'.$dt["project_name"].'</td>
					<td>'.$approve_text.'</td>
					<td class="same_first_td">'.$this->eml->btn('view','onclick=window.open("'.base_url().'?d=manage&c=reserve&m=view&id='.$dt["reserve_id"].'","_blank")').'</td>
					<td><input type="checkbox" value="'.$dt["reserve_id"].'" name="del_reserve[]" class="del_reserve"></td>
			';
			//<td class="same_first_td">'.$this->eml->btn('view','onclick=show_all_data("'.$dt["reserve_id"].'")').'</td>
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
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
	function set_per_page()
	{
		if($this->input->post("num") && preg_match('/^[1-9]|[1-9][\d]+/',$this->input->post("num")))
		{
			$this->session->set_userdata("set_per_page",$this->input->post("num"));
		}
		//redirect(base_url()."?d=manage&c=titlename&m=edit","refresh");
	}
	function search_user_list()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_reserve_list',$this->input->post("input_search_box"));
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_reserve_list");
		}
		redirect(base_url()."?d=manage&c=reserve&m=reserve_list");
	}
}