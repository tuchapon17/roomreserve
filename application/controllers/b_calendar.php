<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class B_calendar extends MY_Controller {
	private $cm;
	function __construct()
	{
		parent::__construct();
		//$this->fl->check_group_privilege("03");
		$this->load->model('b_calendar_model');
		$this->cm=$this->b_calendar_model;
	}
	function main($year=null,$month=null)
	{
		if(isset($_GET['year']))
		{
			if($this->session->userdata("bct-year")!=$_GET["year"]) $year=$_GET['year'];
			else $year=$_GET['year'];
		}
		else redirect($_SERVER["QUERY_STRING"]."&year=".date("Y"));
		if(isset($_GET['month']))
		{
			if($this->session->userdata("bct-month")!=$_GET["month"]) $month=$_GET['month'];
			else $month=$_GET['month'];
		}
		else redirect($_SERVER["QUERY_STRING"]."&month=".date("m"));
		
		if(isset($_GET['resid']))$reserve_id=$_GET['resid'];
		else $reserve_id=null;
		//if(isset($_GET['rmid']))$room_id=$_GET['rmid'];
		//else $room_id=null;
		
		$room_id=($this->session->userdata("bct-room")) ? $this->session->userdata("bct-room") : null;
		//$year=($this->session->userdata("bct-year")) ? $this->session->userdata("bct-year") : null;
		//$month=($this->session->userdata("bct-month")) ? $this->session->userdata("bct-month") : null;
		$approve=($this->session->userdata("bct-approve")) ? $this->session->userdata("bct-approve") : "all";
		
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("ปฏิทิน"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose(),
				"calendar"=>$this->cm->generate($year,$month,$approve,$room_id),
				"customviewbox"=>$this->customviewbox()
		);
		$this->load->view("b_calendar_main",$data);
	}
	function bydate()
	{
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("วันที่"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose()
		);
		$this->load->view("b_calendar_by_date",$data);
	}
	function get_date_detail()
	{
		$query=$this->db->select()->from("tb_reserve")
		->join("tb_reserve_has_datetime","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id")
		->join("tb_reserve_has_person","tb_reserve.reserve_id=tb_reserve_has_person.tb_reserve_id")
		->join("tb_room","tb_reserve.tb_room_id=tb_room.room_id")
		//->where("tb_reserve.approve",1)
		->like("tb_reserve_has_datetime.reserve_datetime_begin",$this->input->post("ymd"),"after")->get();
		//$query=$this->db->select()->from("tb_reserve_has_datetime")->like("reserve_datetime_begin",$this->input->post("ymd"),"after")->get();
		if($query->num_rows()>0)
			echo json_encode($query->result_array());
		//else echo json_encode("");
	}
	function getdatetime()
	{
		$this->db->select()->from("tb_reserve_has_datetime");
		$this->db->join("tb_reserve","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id");
		//$this->db->where("tb_reserve.approve",1);
		$this->db->like("reserve_datetime_begin",$this->input->post("likedate"));
		$this->db->order_by("reserve_datetime_begin","ASC");
		echo json_encode($this->db->get()->result_array());
		
	}
	function get_datetime_detail()
	{
		$query=$this->db->select()->from("tb_reserve")
		->join("tb_reserve_has_datetime","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id")
		->join("tb_reserve_has_person","tb_reserve.reserve_id=tb_reserve_has_person.tb_reserve_id")
		->join("tb_room","tb_reserve.tb_room_id=tb_room.room_id")
		->where("tb_reserve_has_datetime.datetime_id",$this->input->post("datetime_id"))
		->order_by("tb_reserve_has_datetime.reserve_datetime_begin","ASC")
		->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
			echo json_encode($query->result_array()[0]);
		//else echo json_encode("");
	}
	function customviewbox()
	{
		$html='<form class="form-horizontal" role="form" action="'.base_url().'?c=b_calendar&m=customview_process" method="post" autocomplete="off">';
		$html.='
      		 	<div class="form-group">
					<label class="col-lg-2 control-label" for="bct-room">ห้อง</label>
					<div class="col-lg-10">
				      	<select id="bct-room" name="bct-room" class="form-control">
						<option value="all">ทุกห้อง</option>';
		$room=$this->emm->get_select("tb_room","room_name");
		foreach ($room as $r)
		{
			$html.='<option value="'.$r['room_id'].'">'.$r['room_name'].'</option>';
		}
			$html.='</select>
					</div><!-- col-lg-10 -->
				</div><!-- form-group -->
				<div class="form-group">
					<label class="col-lg-2 control-label" for="bct-year">ปี</label>
					<div class="col-lg-10">
						<select id="bct-year" name="bct-year" class="form-control">';
			$year=date('Y');
			$month=date('m');
				$html.='<option value="'.($year-2).'">'.($year-2).'</option>';
				$html.='<option value="'.($year-1).'">'.($year-1).'</option>';
				$html.='<option value="'.$year.'" selected="selected">'.$year.'</option>';
				$html.='<option value="'.($year+1).'">'.($year+1).'</option>';
				$html.='<option value="'.($year+2).'">'.($year+2).'</option>';
				$html.='</select>
					</div><!-- col-lg-10 -->
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label" for="bct-month">เดือน</label>
					<div class="col-lg-10">
						<select id="bct-month" name="bct-month" class="form-control">';
			for($i=1;$i<=12;$i++)
			{
				$month_th=array("ม.ค.","ก.พ.","มี.ค.","เม.ษ.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
				$text=str_pad($i,2,0,STR_PAD_LEFT);
				$selected=($text==str_pad($month,2,0,STR_PAD_LEFT)) ? 'selected="selected"' : '';
				$html.='<option value="'.$text.'" '.$selected.'>'.$month_th[$i-1].'</option>';
			}
				$html.='</select>
					</div><!-- col-lg-10 -->
				</div>';
				$html.='
					<div class="form-group">
						<label class="col-lg-2 control-label" for="bct-month">การอนุมัติ</label>
						<div class="col-lg-10">
						<select id="bct-approve" name="bct-approve" class="form-control">
							<option value="all">ทั้งหมด</option>
							<option value="0">รออนุมัติ</option>
							<option value="1">อนุมัติ</option>
							<option value="2">ส่งให้ผู้บริหารอนุมัติ</option>
							<option value="3">ไม่อนุมัติ</option>
						</select>	
						</div>
					</div>
						';
				$html.='
					<div class="form-group text-right">
						<div class="col-lg-12">
						'.$this->eml->btn("search","id='bct-btn'").nbs(4).$this->eml->btn("refreshcheck","onclick=window.location='".base_url()."?c=b_calendar&m=reset_customview'").'
						</div>
					</div>';
			$html.='</form>';
		return $html;
	}
	function customview_process()
	{
		$set=array(
				"bct-room"=>$this->input->post("bct-room"),
				"bct-year"=>$this->input->post("bct-year"),
				"bct-month"=>$this->input->post("bct-month"),
				"bct-approve"=>$this->input->post("bct-approve")
		);
		$this->session->set_userdata($set);
		redirect(base_url()."?c=b_calendar&m=main&year=".$this->input->post("bct-year")."&month=".$this->input->post("bct-month"));
	}
	function reset_customview()
	{
		$unset=array(
				"bct-room"=>null,
				"bct-year"=>null,
				"bct-month"=>null,
				"bct-approve"=>null
		);
		$this->session->unset_userdata($unset);
		redirect(base_url()."?c=b_calendar&m=main");
	}
}