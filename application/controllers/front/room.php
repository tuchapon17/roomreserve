<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends MY_Controller
{
	var $rm;
	var $getpage;
	function __construct()
	{
		parent::__construct();
		$this->load->model("front/room_model");
		$this->rm=$this->room_model;
	}
	
	function view()
	{
		/*
		 * view room with pagination
		//pagination
		$this->load->library("pagination");
		$config['use_page_numbers'] = TRUE;
		$config['base_url']=base_url()."?d=front&c=room&m=view";
		$config['per_page']=1;
		
		if(isset($_GET['page']) && preg_match('/^[\d]+$/',$_GET['page'])) $this->getpage=(($_GET['page']-1)*$config['per_page']);
		else $this->getpage=0;
		
		$config['total_rows']=$this->rm->get_room_view_data($config['per_page'],$this->getpage,"num_rows");
		$get_room_list=$this->rm->get_room_view_data($config['per_page'],$this->getpage,"array");
		
		$this->pagination->initialize($config);
		//..pagination
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("ข้อมูลห้อง"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose(),
				"pagination"=>$this->pagination->create_links(),
				"get_room_list"=>$get_room_list,
				"get_pic_list"=>$this->rm->get_pic_list($get_room_list[0]['room_id']),
				"form_select_room"=>$this->form_select_room()
		);
		*/
		$room_id=($this->session->userdata("view-room"))?$this->session->userdata("view-room"):null;
		$room_data=$this->rm->get_room_data($room_id);
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("ข้อมูลห้อง"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose(),
				"get_room_list"=>$room_data,
				"get_pic_list"=>$this->rm->get_pic_list($room_data[0]['room_id']),
				"form_select_room"=>$this->form_select_room()
		);
		$this->load->view("front/view_room",$data);
	}
	function form_select_room()
	{
		$html='<form class="form-horizontal" role="form" action="'.base_url().'?d=front&c=room&m=form_select_room_process" method="post" autocomplete="off">';
		$html.='
      		 	<div class="form-group">
					<label class="col-lg-2 control-label" for="select_room_type">ประเภทห้อง</label>
					<div class="col-lg-10">
				      	<select id="select_room_type" name="select_room_type" class="form-control">
							<option value="">เลือกประเภทห้อง</option>
					';
		/*$room=$this->rm->form_select_room_get_room();
		foreach($room as $r)
		{
			if($this->session->userdata("view-room")==$r['room_id'])
				$selected='selected';
			else $selected='';
			$html.='<option value="'.$r['room_id'].'" '.$selected.'>'.$r['room_name'].'</option>';
		}
		*/
		$roomtype=$this->rm->form_select_room_get_room_type();
		foreach($roomtype as $r)
		{
			if($this->session->userdata("view-roomtype")==$r['room_type_id'])
				$selected='selected';
			else $selected='';
			$html.='<option value="'.$r['room_type_id'].'" '.$selected.'>'.$r['room_type_name'].'</option>';
		}
		$html.='		</select>
					</div><!-- col-lg-10 -->
				</div>';
		$html.='
      		 	<div class="form-group">
					<label class="col-lg-2 control-label" for="select_room">ห้อง</label>
					<div class="col-lg-10">
				      	<select id="select_room" name="select_room" class="form-control">
							<option value="">เลือกห้อง</option>
						</select>
					</div>
				</div>
				';
		$html.='
				<div class="form-group text-right">
					<div class="col-lg-12">
					'.$this->eml->btn("search","id='view-btn'").nbs(4).$this->eml->btn("refreshcheck","onclick=window.location='".base_url()."?d=front&c=room&m=reset_form_select_room';").'
					</div>
				</div>';
		$html.='</form>';		
		return $html;
	}
	function form_select_room_process()
	{
			$set=array(
					"view-roomtype"=>$this->input->post("select_room_type"),
					"view-room"=>$this->input->post("select_room")
			);
			$this->session->set_userdata($set);
			redirect(base_url()."?d=front&c=room&m=view");
	}
	function reset_form_select_room()
	{
		$unset=array(
				"view-roomtype"=>null,
				"view-room"=>null
		);
		$this->session->unset_userdata($unset);
		redirect(base_url()."?d=front&c=room&m=view");
	}
	function select_room_list()
	{
		
		if($this->input->post("room_type_id")!=''):
			$query=$this->rm->form_select_room_get_room($this->input->post("room_type_id"));
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
}