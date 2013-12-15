<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {
	//page_element_lib
	private $pel;
	function __construct()
	{
		parent::__construct();
		$this->pel=$this->page_element_lib;
	}
	function main($year=null,$month=null)
	{
		if(isset($_GET['year']))$year=$_GET['year'];
		else redirect($_SERVER["QUERY_STRING"]."&year=".date("Y"));
		if(isset($_GET['month']))$month=$_GET['month'];
		else redirect($_SERVER["QUERY_STRING"]."&month=".date("m"));
		
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
				"calendar"=>$this->calendar_model->generate($year,$month)
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
		else echo json_encode("");
	}
	function testdate()
	{
		$this->db->select()->from("tb_reserve_has_datetime")->like("reserve_datetime_begin",$this->input->post("likedate"));
		echo json_encode($this->db->get()->result_array());
		
	}
}