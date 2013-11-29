<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('element_lib');
		$this->load->library("form_validation");
		$this->load->model("manage/user_model");
		$this->load->model("element_model");
		$this->lang->load("help_text","thailand");
		$this->lang->load("label_name","thailand");
	}

	function edit()
	{
		$usm=$this->user_model;
		$emm=$this->element_model;
		$eml=$this->element_lib;
		
		if(!$this->session->userdata("orderby_user"))
			$this->session->set_userdata("orderby_user",array("field"=>"username","type"=>"ASC"));
		//pagination
		$this->load->library("pagination");
		$config['base_url']=base_url()."?d=manage&c=user&m=edit";
		//set per_page
		if($this->session->userdata("set_per_page")) $config['per_page']=$this->session->userdata("set_per_page");
		else $config['per_page']=3;
		
		if(isset($_GET['page']) && preg_match('/^[\d]$/',$_GET['page'])) $this->getpage=$_GET['page'];
		else $this->getpage=0;
		
		
		if($this->session->userdata("search_user"))
		{
			$liketext=$this->session->userdata("search_user");
			$config['total_rows']=$usm->get_all_numrows("tb_user",$liketext,"username");
		
			$get_user_list=$usm->get_user_list($config['per_page'],$this->getpage,$liketext);
		}
		else
		{
			$config['total_rows']=$usm->get_all_numrows("tb_user",'',"username");
		
			$get_user_list=$usm->get_user_list($config['per_page'],$this->getpage);
		}
		$this->pagination->initialize($config);
		
		//..pagination
		
		$PEL=$this->page_element_lib;
		$data=array(
				"htmlopen"=>$PEL->htmlopen(),
				"head"=>$PEL->head("แก้ไข/ลบ  สาขาวิชา/งาน"),
				"bodyopen"=>$PEL->bodyopen(),
				"navbar"=>$PEL->navbar(),
				"js"=>$PEL->js(),
				"footer"=>$PEL->footer(),
				"bodyclose"=>$PEL->bodyclose(),
				"htmlclose"=>$PEL->htmlclose(),
				"user_tab"=>$this->user_tab(),
				"table_edit"=>$this->table_edit($get_user_list),
				"session_search_user"=>$this->session->userdata("search_user"),
				"pagination_num_rows"=>$config["total_rows"],
				"manage_search_box"=>$PEL->manage_search_box($this->session->userdata("search_user"))
		);
		$this->load->view("manage/user/edit_user",$data);
	}
	function delete()
	{
		$usm=$this->user_model;
		$usm->manage_delete($this->input->post("del_user"), "tb_user", "username", "username", "edit_user", "?d=manage&c=user&m=edit");
	}
	
	function user_tab()
	{
		$html='
		<ul class="nav nav-tabs" id="manage_tab">
			<!-- data-toggle มี pill/tab -->
			';
		$html.='
			<li><a href="#"  id="edit">จัดการผู้ใช้</a></li>
			';
		$html.='</ul>';
		return $html;
	}
	function allow()
	{
		//$data = array
		$allow_list=$this->input->post("allow_list");
		$disallow_list=$this->input->post("disallow_list");
		$usm=$this->user_model;
		$usm->manage_allow($allow_list,$disallow_list, "tb_user", "username", "username", "edit_user", "?d=manage&c=user&m=edit");
	}
	function search()
	{
		if($this->input->post("input_search_box"))
		{
			$this->session->set_userdata('search_user',$this->input->post("input_search_box"));
	
		}
		else if($this->input->post("clear"))
		{
			$this->session->unset_userdata("search_user");
		}
		redirect(base_url()."?d=manage&c=user&m=edit");
	}
	function table_edit($data)
	{
		if($this->session->userdata("orderby_user")["type"]=="ASC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_212_down_arrow.png">';
		else if($this->session->userdata("orderby_user")["type"]=="DESC") $img='<img width="9" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_213_up_arrow.png">';
		$num_row=$this->getpage+1;
		$html='
				<table class="table table-striped table-bordered fixed-table" id="tabel_data_list">';
		$html.='<thead>
				<th>ลำดับ</th>
				<th>ชื่อผู้ใช้</th>
				<th>กลุ่มผู้ใช้</th>
				<th class="same_first_td">สถานะผู้ใช้<br/><button type="button" class="cbtn cbtn-green" id="allow-all"><button type="button" class="cbtn cbtn-red" id="disallow-all"></th>
				<th class="same_first_td">รายละเอียด</th>
				<th>ลบ<br/><input type="checkbox" id="del_all_user"></th>
		';
		$html.='</thead>
		<form method="post" action="'.base_url().'?d=manage&c=user&m=delete" id="form_del_user">';
		if(!empty($data))
		{
			foreach ($data AS $dt):
			//<td>'.$num_row.'</td>
			if($dt['user_status']==0)$checkbox='<span class="checkboxFour">
									  		<input type="checkbox" value="'.$dt["username"].'" id="checkboxFourInput'.$dt["username"].'" name="allow_user0[]" class="allow_user0"/>
										  	<label for="checkboxFourInput'.$dt["username"].'"></label>
									  		</span>';
			else $checkbox='<span class="checkboxFour">
					  		<input type="checkbox" value="'.$dt["username"].'" id="checkboxFourInput'.$dt["username"].'" name="allow_user1[]" class="allow_user1" checked/>
						  	<label for="checkboxFourInput'.$dt["username"].'"></label>
					  		</span>';
			$html.='<tr>
					<td>'.$num_row.'</td>
					<td id="user'.$dt["username"].'">'.$dt["username"].'</td>
					<td>'.$dt["group_name"].'</td>
					<td class="same_first_td">'.$checkbox.'</td>
					<td class="same_first_td"><button type="button" class="btn btn-primary" onclick=show_all_data("'.$dt["username"].'")><img width="17" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_051_eye_open.png"></button></td>
					<td><input type="checkbox" value="'.$dt["username"].'" name="del_user[]" class="del_user"></td>
			';
			$html.='</tr>';
			$num_row++;
			endforeach;
		}
		$html.='<tr>
				<td></td>
				<td></td>
				<td></td>
				<td align="center"><button type="button" class="btn btn-success" onclick="show_allow_list();return false;"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_206_ok_2.png"></button>
									<button type="button" class="btn btn-warning" onclick="location.reload(true);"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_081_refresh.png"></button>
						</td>
				<td></td>
				<td><button type="submit" class="btn btn-danger" onclick="show_del_list();return false;"><img width="12" src="'.base_url().'images/glyphicons_free/glyphicons/png/glyphicons_016_bin.png"></button></td>
				</tr>
				</table>
				</form>';
		$html.=$this->pagination->create_links();
		return $html;
	}
	function set_orderby()
	{
		if($this->input->post("field") && $this->input->post("type"))
		{
			$this->session->set_userdata("orderby_user",array("field"=>$this->input->post("field"),"type"=>$this->input->post("type")));
		}
	}
	function show_all_data()
	{
		$usm=$this->user_model;
		echo json_encode($usm->get_all_data($this->input->post("username"))[0]);
	}
}