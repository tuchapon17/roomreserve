<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Condition extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/condition_model");
		$this->load->model("element_model");
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}
	function edit()
	{
		$cdm=$this->condition_model;
		$emm=$this->element_model;
		$eml=$this->element_lib;
		$frm=$this->form_validation;
	
	
		$config=array(
				array(
						"field"=>"textarea_condition",
						"label"=>"condition",
						"rules"=>""
				)
		);
		$frm->set_rules($config);
		$frm->set_message("rule","message");
		if($frm->run() == false)
		{
			$te_condition_name="textarea_condition";
			$te_condition=array(
					"LB_text"=>"condition",
					"LB_attr"=>$eml->span_redstar(),
					"IN_class"=>'',
					"IN_name"=>$te_condition_name,
					"IN_id"=>$te_condition_name,
					"IN_attr"=>'',
					"help_text"=>""
			);
				
			$PEL=$this->page_element_lib;
			$data=array(
					"htmlopen"=>$PEL->htmlopen(),
					"head"=>$PEL->head("แก้ไขcondition"),
					"bodyopen"=>$PEL->bodyopen(),
					"navbar"=>$PEL->navbar(),
					"js"=>$PEL->js(),
					"footer"=>$PEL->footer(),
					"bodyclose"=>$PEL->bodyclose(),
					"htmlclose"=>$PEL->htmlclose(),
					"condition_tab"=>$this->condition_tab(),
					"te_condition"=>$eml->form_textarea($te_condition)
			);
			$this->load->view("manage/condition/edit_condition",$data);
		}
		else
		{
			$prev_url=$_SERVER['HTTP_REFERER'];
			$session_edit_id="edit_condition_id";
			$set=array(
					"condition"=>$this->input->post("textarea_condition"),
					"last_modified_by"=>$this->session->userdata("rs_username")
			);
			$where=array(
					"condition_id"=>$this->session->userdata($session_edit_id)
			);
			$cdm->manage_edit($set, $where, "tb_condition", $session_edit_id, "edit_condition", "แก้ไขconditionสำเร็จ", "แก้ไขconditionไม่สำเร็จ", "?d=manage&c=condition&m=edit", $prev_url);
		}
	}
	function condition_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			';
		$html.='
			<li><a href="#"  id="edit">แก้ไขcondition</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function load_condition()
	{
		$cdm=$this->condition_model;
		echo json_encode($cdm->load_condition($this->input->post("tid"))[0]);
	}
}