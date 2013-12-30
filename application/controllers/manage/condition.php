<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Condition extends MY_Controller
{
	private $cdm;
	function __construct()
	{
		parent::__construct();
		$this->fl->check_group_privilege(array("02"));
		$this->load->model("manage/condition_model");
		$this->cdm=$this->condition_model;
	}
	function edit()
	{
		$config=array(
				array(
						"field"=>"textarea_condition",
						"label"=>"condition",
						"rules"=>""
				)
		);
		$this->frm->set_rules($config);
		$this->frm->set_message("rule","message");
		if($this->frm->run() == false)
		{
			$te_condition_name="textarea_condition";
			$te_condition=array(
					"LB_text"=>"condition",
					"LB_attr"=>$this->eml->span_redstar(),
					"IN_class"=>'',
					"IN_name"=>$te_condition_name,
					"IN_id"=>$te_condition_name,
					"IN_attr"=>'',
					"help_text"=>""
			);
			$data=array(
					"htmlopen"=>$this->pel->htmlopen(),
					"head"=>$this->pel->head("แก้ไขcondition"),
					"bodyopen"=>$this->pel->bodyopen(),
					"navbar"=>$this->pel->navbar(),
					"js"=>$this->pel->js(),
					"footer"=>$this->pel->footer(),
					"bodyclose"=>$this->pel->bodyclose(),
					"htmlclose"=>$this->pel->htmlclose(),
					"condition_tab"=>$this->condition_tab(),
					"te_condition"=>$this->eml->form_textarea($te_condition)
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
			$this->cdm->manage_edit($set, $where, "tb_condition", $session_edit_id, "edit_condition", "แก้ไขconditionสำเร็จ", "แก้ไขconditionไม่สำเร็จ", "?d=manage&c=condition&m=edit", $prev_url);
		}
	}
	function condition_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			';
		$html.='
			<li><a href="#"  id="edit">แก้ไขระเบียบการใช้งานระบบ</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function load_condition()
	{
		echo json_encode($this->cdm->load_condition($this->input->post("tid"))[0]);
	}
}