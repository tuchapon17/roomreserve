<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class b_calendar_Model extends CI_Model
{
	var $conf;
	var $month;
	var $year;
	function __construct()
	{
		parent::__construct();
		$this->conf=array(
				"start_day"=>'monday',
				"show_next_prev"=>true,
				"next_prev_url"=>"?c=b_calendar&m=main"
		);
		$this->month=(isset($_GET["month"]) ? $this->month=$_GET["month"] : $this->month="");
		$this->year=(isset($_GET["year"]) ? $this->year=$_GET["year"] : $this->year="");
		
		$this->conf["template"]='
		{table_open}<table class="table-calendar">{/table_open}

	   	{heading_row_start}<tr>{/heading_row_start}
	
	   	{heading_previous_cell}<th ><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
	   	{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
	   	{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

	   	{heading_row_end}</tr>{/heading_row_end}

	   	{week_row_start}<tr>{/week_row_start}
	   	{week_day_cell}<td >{week_day}</td>{/week_day_cell}
	   	{week_row_end}</tr>{/week_row_end}

	   	{cal_row_start}<tr>{/cal_row_start}
	   	{cal_cell_start}<td>{/cal_cell_start}

	   	{cal_cell_content}
				{day}
				{content}
		{/cal_cell_content}
	   	{cal_cell_content_today}
				<span class="highlight date" id="'.$this->year.'-'.$this->month.'-{day}">{day}</span>
				{content}
		{/cal_cell_content_today}

	   	{cal_cell_no_content}
				<span class="date" id="'.$this->year.'-'.$this->month.'-{day}">{day}</span>
		{/cal_cell_no_content}
	   	{cal_cell_no_content_today}
				<span class="highlight date" id="'.$this->year.'-'.$this->month.'-{day}">{day}</span>
		{/cal_cell_no_content_today}

	   	{cal_cell_blank}&nbsp;{/cal_cell_blank}

	   	{cal_cell_end}</td>{/cal_cell_end}
	   	{cal_row_end}</tr>{/cal_row_end}

	   	{table_close}</table>{/table_close}
		';
	}
	function get_calendar($year,$month,$approve,$room_id)
	{
		$this->db->select()->from("tb_reserve_has_datetime");
		$this->db->join("tb_reserve","tb_reserve_has_datetime.tb_reserve_id=tb_reserve.reserve_id");
		//$where=array("tb_reserve.approve"=>1);
		if($this->session->userdata("bct-approve")!="all")
			$where["tb_reserve.approve"]=$this->session->userdata("bct-approve");
		if($room_id!=null && $room_id!='all')
			$where['tb_reserve.tb_room_id']=$room_id;
		if(isset($where))
			$this->db->where($where);
		$this->db->like("reserve_datetime_begin","$year-$month","after")->order_by("reserve_datetime_begin","ASC");
		$query=$this->db->get();
		$cal_data=array();
		foreach ($query->result_array() as $row)
		{
			//$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)]="<i class='fa fa-info-circle'></i>";
			if(!array_key_exists((int)substr($row["reserve_datetime_begin"],8,2), $cal_data))
				//$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)]="<div class='text-left' onclick='alert(\"$row[reserve_datetime_begin].$row[reserve_datetime_end]\");'>".$row["project_name"]."</div>";
				$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)]="<div class='time-small'><small><a href='".base_url()."?d=manage&c=reserve&m=view&id=".$row['tb_reserve_id']."'>".substr($row["reserve_datetime_begin"],11,5)."-".substr($row["reserve_datetime_end"],11,5)."</a></small></div>";
			else
				//$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)].="<div class='text-left' onclick='alert(\"$row[reserve_datetime_begin].$row[reserve_datetime_end]\");'>".$row["project_name"]."</div>";
				$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)].="<div class='time-small'><small><a href='".base_url()."?d=manage&c=reserve&m=view&id=".$row['tb_reserve_id']."'>".substr($row["reserve_datetime_begin"],11,5)."-".substr($row["reserve_datetime_end"],11,5)."</a></small></div>";
		}
		return $cal_data;
	}
	function generate($year,$month,$approve,$room_id)
	{
		$this->load->library("calendar2",$this->conf);
		/*$cal_data=array(
				10=>'?c=test&m=calen&year=2013&month=10',
				11=>'bar'
		);*/
		$cal_data=$this->get_calendar($year, $month,$approve,$room_id);
		return $this->calendar2->generate($year,$month,$cal_data);
	}
}