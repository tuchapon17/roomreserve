<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		//$this->fl->check_group_privilege("03");
	}
	function main($year=null,$month=null)
	{
		if(isset($_GET['year']))$year=$_GET['year'];
		else redirect($_SERVER["QUERY_STRING"]."&year=".date("Y"));
		if(isset($_GET['month']))$month=$_GET['month'];
		else redirect($_SERVER["QUERY_STRING"]."&month=".date("m"));
		if(isset($_GET['resid']))$reserve_id=$_GET['resid'];
		else $reserve_id=null;
		if(isset($_GET['rmid']))$room_id=$_GET['rmid'];
		else $room_id=null;
		$this->load->model('calendar_model');
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("จองห้อง"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose(),
				"calendar"=>$this->calendar_model->generate($year,$month,$reserve_id,$room_id),
				"customviewbox"=>$this->customviewbox()
		);
		$this->load->view("calendar_main",$data);
	}
	function bydate()
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
		$this->load->view("calendar_by_date",$data);
	}
	function get_date_detail()
	{
		$query=$this->db->select()->from("tb_reserve")
		->join("tb_reserve_has_datetime","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id")
		->join("tb_reserve_has_person","tb_reserve.reserve_id=tb_reserve_has_person.tb_reserve_id")
		->join("tb_room","tb_reserve.tb_room_id=tb_room.room_id")
		->where("tb_reserve.approve",1)
		->like("tb_reserve_has_datetime.reserve_datetime_begin",$this->input->post("ymd"),"after")->get();
		//$query=$this->db->select()->from("tb_reserve_has_datetime")->like("reserve_datetime_begin",$this->input->post("ymd"),"after")->get();
		if($query->num_rows()>0)
			echo json_encode($query->result_array());
		//else echo json_encode("");
	}
	function getdatetime()
	{
		$this->db->select()->from("tb_reserve_has_datetime")->like("reserve_datetime_begin",$this->input->post("likedate"));
		echo json_encode($this->db->get()->result_array());
		
	}
	function get_datetime_detail()
	{
		$query=$this->db->select()->from("tb_reserve")
		->join("tb_reserve_has_datetime","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id")
		->join("tb_reserve_has_person","tb_reserve.reserve_id=tb_reserve_has_person.tb_reserve_id")
		->join("tb_room","tb_reserve.tb_room_id=tb_room.room_id")
		->where("tb_reserve_has_datetime.datetime_id",$this->input->post("datetime_id"))->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
			echo json_encode($query->result_array()[0]);
		//else echo json_encode("");
	}
	function customviewbox()
	{
		$html='
				<div class="form-inline text-right">
      		 		<div class="form-group">
					<label class="col-lg" for="ct-room">ห้อง</label>
	      		 	<select id="ct-room" class="form-control">
					  <option value="all">ทุกห้อง</option>';
		$room=$this->emm->get_select("tb_room","room_name");
		foreach ($room as $r)
		{
			$html.='<option value="'.$r['room_id'].'">'.$r['room_name'].'</option>';
		}
					  
			$html.='</select>
					</div>
					<div class="form-group">
					<label class="col-lg" for="ct-year">ปี</label>
					<select id="ct-year" class="form-control">';
			$year=date('Y');
			$month=date('m');
			$html.='<option value="'.($year-2).'">'.($year-2).'</option>';
			$html.='<option value="'.($year-1).'">'.($year-1).'</option>';
			$html.='<option value="'.$year.'" selected="selected">'.$year.'</option>';
			$html.='<option value="'.($year+1).'">'.($year+1).'</option>';
			$html.='<option value="'.($year+2).'">'.($year+2).'</option>';
			$html.='</select>
					</div>
					<div class="form-group">
					<label class="col-lg" for="ct-month">เดือน</label>
					<select id="ct-month" class="form-control">';
			for($i=1;$i<=12;$i++)
			{
				$text=str_pad($i,2,0,STR_PAD_LEFT);
				$selected=($text==str_pad($month,2,0,STR_PAD_LEFT)) ? 'selected="selected"' : '';
				$html.='<option value="'.$text.'" '.$selected.'>'.$text.'</option>';
			}
			$html.='</select>
					</div>
					
					'.$this->eml->btn("submitcheck","id='ct-btn'").'
					
      		 	</div>
		';
		return $html;
	}
}