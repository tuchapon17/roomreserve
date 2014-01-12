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
				"get_pic_list"=>$this->rm->get_pic_list($get_room_list[0]['room_id'])
		);
		$this->load->view("front/view_room",$data);
	}
}