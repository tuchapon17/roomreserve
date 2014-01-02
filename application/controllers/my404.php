<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class my404 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		//$this->output->set_status_header('404');
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
		$this->load->view("error/error_404",$data);
	}
}