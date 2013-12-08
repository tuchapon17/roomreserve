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
		if(isset($_GET['month']))$month=$_GET['month'];
		
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
}