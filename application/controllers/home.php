<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library("page_element_lib");
	}
	function index()
	{
		$PEL=$this->page_element_lib;
		$data=array(
				"htmlopen"=>$PEL->htmlopen(),
				"head"=>$PEL->head("ระบบจัดการการจองห้องผ่านระบบเครือข่ายอินเทอร์เน็ต ศูนย์คอมพิวเตอร์ มหาวิทยาลัยราชภัฏอุตรดิตถ์"),
				"bodyopen"=>$PEL->bodyopen(),
				"navbar"=>$PEL->navbar(),
				"js"=>$PEL->js(),
				"footer"=>$PEL->footer(),
				"bodyclose"=>$PEL->bodyclose(),
				"htmlclose"=>$PEL->htmlclose()
		
		);
		$this->load->view('home',$data);
	}
	function test()
	{
		$PEL=$this->page_element_lib;
		$data=array(
			"htmlopen"=>$PEL->htmlopen(),
			"head"=>$PEL->head(""),
			"bodyopen"=>$PEL->bodyopen(),
			"navbar"=>$PEL->navbar(),
			"js"=>$PEL->js(),
			"footer"=>$PEL->footer(),
			"bodyclose"=>$PEL->bodyclose(),
			"htmlclose"=>$PEL->htmlclose()
				
		);
		$this->load->view("test",$data);
	}
}