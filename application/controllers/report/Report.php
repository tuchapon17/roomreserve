<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends MY_Controller {
	
	private $rpm;

	function __construct()
	{
		parent::__construct();
		$this->load->model("report/report_model");
		$this->rpm=$this->report_model;
	}
	
	function report_type()
	{
		ob_clean();
		$data=array(
				"htmlopen"=>$this->pel->htmlopen(),
				"head"=>$this->pel->head("ปฏิทิน"),
				"bodyopen"=>$this->pel->bodyopen(),
				"navbar"=>$this->pel->navbar(),
				"js"=>$this->pel->js(),
				"footer"=>$this->pel->footer(),
				"bodyclose"=>$this->pel->bodyclose(),
				"htmlclose"=>$this->pel->htmlclose()
		);
		$this->load->view("report/report_type",$data);
	}
	function report_type_process()
	{
		//$year สำหรับออกรายงานรายปี และใช้กำหนดปีสำหรับออกรายงาน
		$year=$this->input->post("se_year");
		$month=$this->input->post("se_month");
		$post_time_length=$this->input->post("se_time_length");
		
		//กำหนดเวลาเริ่ม-สิ้นสุด สำหรับรายปี
		$year_time=array("begin"=>$year."-01-01","end"=>$year."-12-31");
		
		//กำหนดเวลาเริ่ม-สิ้นสุด สำหรับรายเทอม
		if($this->input->post("se_term")=="term1")		$term_time=array("begin"=>$year."-05-31","end"=>$year."-10-31");
		else if($this->input->post("se_term")=="term2")	$term_time=array("begin"=>$year."-11-01","end"=>($year+1)."-03-01");
		else if($this->input->post("se_term")=="term3")	$term_time=array("begin"=>($year+1)."-03-02","end"=>($year+1)."-05-30");
		
		//กำหนดเวลาเริ่ม-สิ้นสุด สำหรับรายไตรมาส
		if($this->input->post("se_quarter")=="quarter1")
		{
			//หาวันที่สุดท้ายของเดือนกุมภาพันธ์ find last date of Feb
			$timestamp = strtotime('February '.$year);
			//$first_second = date('m-01-Y 00:00:00', $timestamp);
			$last_feb  = date('Y-m-t', $timestamp);
			$quarter_time = array("begin"=>($year-1)."-12-01","end"=>$last_feb);
		}
		else if($this->input->post("se_quarter")=="quarter2")	$quarter_time=array("begin"=>$year."-03-01","end"=>$year."-05-31");
		else if($this->input->post("se_quarter")=="quarter3")	$quarter_time=array("begin"=>$year."-06-01","end"=>$year."-08-31");
		else if($this->input->post("se_quarter")=="quarter4")	$quarter_time=array("begin"=>$year."-09-01","end"=>$year."-11-30");
		
		//กำหนดเวลาเริ่ม-สิ้นสุด สำหรับรายเดือน (รูปแบบ : y-m-01 - y-m-วันสุดท้ายของเดือน)
		$month_name=array("January","February","March","April","May","June","July","August","September","October","November","December");
		$month_last_date=date('Y-'.$month.'-t',strtotime($month_name[((int)$month-1)].' '.$year));
		$month_time=array("begin"=>$year."-".$month."-01","end"=>$month_last_date);
		
		//เลือกประเภทรายงาน
		if($this->input->post("se_report_type")=="report_reserve")
		{
			$this->db->select()->from("tb_reserve_has_datetime");
			$this->db->join("tb_reserve","tb_reserve.reserve_id=tb_reserve_has_datetime.tb_reserve_id");
			$this->db->join("tb_room","tb_room.room_id=tb_reserve.tb_room_id");
			if($post_time_length=="tl_month")
			{
				echo "tl_month";
				$this->db->where("reserve_datetime_begin >=",$month_time['begin']);
				$this->db->where("reserve_datetime_end <=",$month_time['end']);
			}
			else if($post_time_length=="tl_quarter")
			{
				echo "tl_quarter";
				$this->db->where("reserve_datetime_begin >=",$quarter_time['begin']);
				$this->db->where("reserve_datetime_end <=",$quarter_time['end']);
			}
			else if($post_time_length=="tl_term")
			{
				echo "tl_term";
				$this->db->where("reserve_datetime_begin >=",$term_time['begin']);
				$this->db->where("reserve_datetime_end <=",$term_time['end']);
			}
			else if($post_time_length=="tl_year")
			{
				$this->db->where("reserve_datetime_begin >=",$year_time['begin']);
				$this->db->where("reserve_datetime_end <=",$year_time['end']);
			}
			$report_type_query=$this->db->get()->result_array();
			//print_r($report_type_query);
			
			$this->report_output($report_type_query);
		}
		else if($this->input->post("se_report_type")=="report_room_use")
		{
			
		}
			
			
		/*
		 * 
    ไตรมาสที่ 1 หมายถึงช่วงเดือน ธันวาคม ถึง กุมภาพันธ์
    ไตรมาสที่ 2 หมายถึงช่วงเดือน มีนาคม ถึง พฤษภาคม
    ไตรมาสที่ 3 หมายถึงช่วงเดือน มิถุนายน ถึง สิงหาคม
    ไตรมาสที่ 4 หมายถึงช่วงเดือน กันยายน ถึง พฤศจิกายน

		 */
		
	}
	
	function report_output($report)
	{
		//http://www.tcpdf.org/examples/example_048.phps
		//http://www.tcpdf.org/examples/example_048.pdf
		//www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
		
		$this->load->library("pdf");
		$pdf=$this->pdf;
		
		/*
		 * public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		*/
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		//$fontname = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/roomreserve/plugins/fonts/THSarabunNewI.ttf', 'TrueTypeUnicode', '', 32);
		$pdf->SetTitle('My Title');
		$margin=array(
				"top"=>23.5,
				"right"=>23.5,
				"left"=>23.5
		);
		$pdf->SetMargins($margin["left"], $margin["top"],$margin["right"],true);
		//$pdf->SetHeaderMargin(30);
		//$pdf->SetTopMargin(20);
		//$pdf->setFooterMargin(90);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->setFontSubsetting(false);
		$pdf->SetFont('thsarabunnewb', '', 18);

		$pdf->AddPage();
		$pdf->Cell(0, 15, 'รายงานการจองห้อง', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$pdf->SetFont('thsarabunnew', '', 16);
		$width=array(5,40,10,25,20);
		//table
		$tbl =<<<EOT
		<style>
			.text-center{
				text-align:center;
			}
			table{
				width:100%;
				display:block;
			}
		</style>
		<div><hr></div>
		<table cellspacing="0" cellpadding="1" border="0.2">
		<tr>
				<th class="text-center" width="{$width[0]}%">ลำดับ</th>
				<th class="text-center" width="{$width[1]}%">โครงการ</th>
				<th class="text-center" width="{$width[2]}%">ห้อง</th>
				<th class="text-center" width="{$width[3]}%">วันเวลาจอง</th>
				<th class="text-center" width="{$width[4]}%"></th>
		</tr>
		</table>
EOT;
		$pdf->writeHTML($tbl, false, false, false, false, '');
		$count=0;
		$tbl=<<<EOT
			<style>
			.text-center{
				text-align:center;
			}
			table{
				width:100%;
				display:block;
			}
		</style>
			<table cellspacing="0" cellpadding="1" border="0.2">
EOT;
		foreach($report as $r)
		{
			for($i=1;$i<=3;$i++)
			{
				if($pdf->getY()<$pdf->getPageHeight()-23.5)
				{
					$count++;
			$tbl.=<<<EOT
		    <tr>
		        <td class="text-center" width="{$width[0]}%">{$count}</td>
		        <td  width="{$width[1]}%">{$r['project_name']}</td>
		        <td class="text-center" width="{$width[2]}%">{$r['room_name']}</td>
		        <td width="{$width[3]}%">{$r['reserve_datetime_begin']} - {$this->getTime($r['reserve_datetime_end'])}</td>
		        <td width="{$width[4]}%"></td>
		    </tr>
			
EOT;
				$pdf->writeHTML($tbl, false, false, false, false, '');
				}
				else
				{
					$pdf->AddPage();
				}
				
			}
		}

		$tbl.=<<<EOT
		</table>
EOT;
		
		
		ob_clean();
		$pdf->Output('My-File-Name.pdf', 'I');
		
		
	}
	function getTime($datetime)
	{
		return substr($datetime,11,19);
	}

	
	
	
	
	
	
	
	
}