<?php
class Page_element_lib
{
	var $ci;
	private $eml;
	private $fl;
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('element_lib');
			$this->eml=$this->ci->element_lib;
		$this->ci->load->library('function_lib');
			$this->fl=$this->ci->function_lib;
	}
	function htmlopen()
	{
		return "<!DOCTYPE html>
				<html lang='th'>";
	}
	function htmlclose()
	{
		return "</html>";
	}
	function bodyopen()
	{
		return "<body>";
	}
	function bodyclose()
	{
		return "</body>";
	}
	function head($title)
	{
		$html='
		<head>
		    <meta charset="utf-8">
			
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <meta name="description" content="">
		    <meta name="author" content="">
		    <title>'.$title.'</title>
		    
		    <link rel="shortcut icon" href="'.base_url().'plugins/bootstrap3.0/assets/ico/favicon.png">
		    <!-- Bootstrap core CSS -->
		    <link href="'.base_url().'plugins/bootstrap3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		    <link href="'.base_url().'plugins/font-awesome-4.0.3/css/font-awesome.min.css" rel="stylesheet">
		    <link href="'.base_url().'css/public_css.css" rel="stylesheet">
		    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		    <!--[if lt IE 9]>
		      <script src="'.base_url().'plugins/bootstrap3.0/assets/js/html5shiv.js"></script>
		      <script src="'.base_url().'plugins/bootstrap3.0/assets/js/respond.min.js"></script>
		    <![endif]-->
		    		<style>
		      		body {
				  		padding-top: 50px;
					}
		    		.navbar-inverse {
					   	background-color: #D89E36;
		      			border-color:#D89E36;
					}
		      		.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus{
		      			background-color: #BD4932;
		      		}
		      		.navbar-inverse .navbar-nav > li > a , .navbar-inverse .navbar-brand{
		      			color:#FFFAD5;
		      		}
		      		.btn-default{
		      			color:#FFFAD5;
		      			background-color:#105B63;
		      		}
		      		.red-text{
		      			color:red;
		      		}
		      		.fixed-table{
		      			table-layout: fixed;
    					word-wrap: break-word;
		      			margin-bottom:0px;
		      			margin-top:10px;
		      		}
		      		.fixed-table tr th:first-child,tr td:first-child,th:last-child,tr td:last-child{
		      			width:90px;
		      			text-align:center;
					}
		      		.same_first_td{
		      			width:100px;
		      			text-align:center;
		      		}
		      		.text-success{
		      			color:#468847;
		      		}
		      		.text-warning{
		      			color:#C09853;
		      		}
		      		.text-info{
						color:#3A87AD;
					}
		      		.text-danger{
		      			color:#B94A48;
		      		}
		      		.text-success,.text-warning,.text-info,.text-danger{
						font-weight:bold;
					}
		      		.search-box{
		      			margin-bottom:20px;
		      		}
		      		#search_box_div{
						padding:0px;
					}
		      		i.fa{
		      			color:black;
		      		}
		      		i.fa-white{
		      			color:white;
		      		}
		      		.wordw{
		      			word-wrap: break-word;
		      		}
		      		</style>
		  </head>
		';
		return $html;
	}
	function navbar()
	{
		//$ci =& get_instance();
		$html='
		<div class="navbar navbar-inverse navbar-fixed-top" id="navbarmenu">
	      <div class="container">
	        <div class="navbar-header" style="background-color: #BD4932;">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="?c=home">ระบบจองห้อง</a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	            <li><a href="?c=home">หน้าแรก</a></li>
		';
		//<li class="active">
		$html.='<li><a href="?d=manage&c=reserve&m=add">จองห้อง</a></li>';
		if($this->fl->check_group_privilege(array("02","05","06"),true,"OR"))
		{
			$html.='<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">จัดการข้อมูล<b class="caret"></b></a>
					<ul class="dropdown-menu">';
			if($this->fl->check_group_privilege(array("02"),true))
			{
				$html.='<li><a href="?d=manage&c=article_type&m=add">ประเภทครุภัณฑ์/อุปกรณ์</a></li>';
				$html.='<li><a href="?d=manage&c=article&m=add">ครุภัณฑ์/อุปกรณ์</a></li>';
				$html.='<li><a href="?d=manage&c=room_has_article&m=add">ครุภัณฑ์/อุปกรณ์สำหรับห้อง</a></li>';
				$html.='<li class="divider"></li>';
				$html.='<li><a href="?d=manage&c=room_type&m=add">ประเภทห้อง</a></li>';
				$html.='<li><a href="?d=manage&c=room&m=add">ห้อง</a></li>';
				$html.='<li class="divider"></li>';
				$html.='<li><a href="?d=manage&c=titlename&m=add">คำนำหน้าชื่อ</a></li>';
				$html.='<li><a href="?d=manage&c=condition&m=edit">ระเบียบการใช้งานระบบ</a></li>';
				$html.='<li><a href="?d=manage&c=reserve&m=edit">การจอง</a></li>';
				$html.='<li class="divider"></li>';
				$html.='<li><a href="?d=manage&c=faculty&m=add">คณะ/กอง</a></li>';
				$html.='<li><a href="?d=manage&c=job_position&m=add">ตำแหน่งงาน</a></li>';
				$html.='<li><a href="?d=manage&c=department&m=add">สาขาวิชา/งาน</a></li>';
				$html.='<li><a href="?d=manage&c=office&m=add">หน่วยงาน</a></li>';
				$html.='<li><a href="?d=manage&c=occupation&m=add">อาชีพ</a></li>';
			}
			
			if($this->fl->check_group_privilege(array("06"),true))
				$html.='<li><a href="?d=manage&c=user&m=edit">ผู้ใช้งาน</a></li>';
			if($this->fl->check_group_privilege(array("05"),true))
				$html.='<li><a href="?d=manage&c=auth_log&m=edit">บันทึกการเข้าสู่ระบบ</a></li>';
			$html.='<li class="divider"></li>';
			
			$html.='</ul>
				</li>
			';
		}
		if($this->fl->check_group_privilege(array("04"),true))
		{
			$html.='<li><a href="?d=manage&c=reserve&m=edit">การจอง</a></li>';
		}
		
		if(!$this->ci->session->userdata("rs_username"))
		{
			$html.='<li><a href="?c=register&m=step1">สมัครสมาชิก</a></li>
					<li><a href="?c=login&m=auth">ลงชื่อเข้าใช้</a></li>';
		}
		else
		{
			$html.='<li class="dropdown active">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$this->ci->session->userdata("rs_username").'<b class="caret"></b></a>
				        <ul class="dropdown-menu">
				          <li><a href="?c=user_profile&m=view_profile">ข้อมูลส่วนตัว</a></li>
				          <li ><a id="logout_menu">ออกจากระบบ</a></li>
				        </ul>
			      	</li>
		';
		}
		$html.='<li><a href="?c=calendar&m=main">ปฏิทิน</a></li>';
		$html.='</ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </div>
		';
		return $html;
	}
	function js()
	{
		$html='
		<!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="'.base_url().'plugins/bootstrap3.0/assets/js/jquery.js"></script>
	    <script src="'.base_url().'plugins/bootstrap3.0/dist/js/bootstrap.min.js"></script>
	    <script src="'.base_url().'js/bootbox4.0.0.min.js"></script>
	    <script src="'.base_url().'js/public_script.js"></script>
		';
		return $html;
	}
	function footer()
	{
		return '
		<footer>
        	<p>&copy; CCURU 2013</p>
      	</footer>';
	}
	function manage_search_box($search_text)
	{
		//$ci = &get_instance();
		$html='
				<div class="input-group col-lg-5 col-lg-offset-7 search-box" id="search_box_div">
					<span class="input-group-btn">
						'.
						$this->eml->btn('perpage','').
						$this->eml->btn('sort_by','onclick="select_orderby()"').
						$this->eml->btn('search_by','onclick="select_searchfield()"').
						'
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" onclick="set_per_page(10)">10 แถว</a></li>
							<li><a href="#" onclick="set_per_page(20)">20 แถว</a></li>
							<li><a href="#" onclick="set_per_page(30)">30 แถว</a></li>
							<li><a href="#" onclick="set_per_page(40)">40 แถว</a></li>
							<li><a href="#" onclick="set_per_page(50)">50 แถว</a></li>
							<li><a href="#" onclick="set_per_page(60)">60 แถว</a></li>
							<li><a href="#" onclick="set_per_page(70)">70 แถว</a></li>
							<li><a href="#" onclick="set_per_page(80)">80 แถว</a></li>
							<li><a href="#" onclick="set_per_page(90)">90 แถว</a></li>
							<li><a href="#" onclick="set_per_page(100)">100 แถว</a></li>
						</ul>
					</span>
					<input type="text" maxlength="30" value="'.$search_text.'" placeholder="ค้นหา" id="input_search_box" name="input_search_box" class="form-control ">
					<span class="input-group-btn">
						'.$this->eml->btn('search','').$this->eml->btn('clear_search','').'
					</span>
				</div>
      		 	';
		return $html;
	}
}