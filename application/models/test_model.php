<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_Model extends CI_Model
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
				"next_prev_url"=>"?c=test&m=calen"
		);
		$this->month=(isset($_GET["month"]) ? $this->month=$_GET["month"] : $this->month="");
		$this->year=(isset($_GET["year"]) ? $this->year=$_GET["year"] : $this->year="");
		
		$this->conf["template"]='
		{table_open}<table class="table-bordered">{/table_open}

	   	{heading_row_start}<tr>{/heading_row_start}
	
	   	{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
	   	{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
	   	{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

	   	{heading_row_end}</tr>{/heading_row_end}

	   	{week_row_start}<tr>{/week_row_start}
	   	{week_day_cell}<td>{week_day}</td>{/week_day_cell}
	   	{week_row_end}</tr>{/week_row_end}

	   	{cal_row_start}<tr>{/cal_row_start}
	   	{cal_cell_start}<td>{/cal_cell_start}

	   	{cal_cell_content}
				<a href="{content}">{day}-'.$this->month.'-'.$this->year.'</a>
				<div>{content}</div>
		{/cal_cell_content}
	   	{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

	   	{cal_cell_no_content}{day}{/cal_cell_no_content}
	   	{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

	   	{cal_cell_blank}&nbsp;{/cal_cell_blank}

	   	{cal_cell_end}</td>{/cal_cell_end}
	   	{cal_row_end}</tr>{/cal_row_end}

	   	{table_close}</table>{/table_close}
		';
	}
	function get_calendar($year,$month)
	{
		$query=$this->db->select()->from("tb_reserve_has_datetime")
		->join("tb_reserve","tb_reserve_has_datetime.tb_reserve_id=tb_reserve.reserve_id")
		->like("reserve_datetime_begin","$year-$month","after")->get();
		$cal_data=array();
		foreach ($query->result_array() as $row)
		{
			if(!array_key_exists((int)substr($row["reserve_datetime_begin"],8,2), $cal_data))
				$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)]="<div onclick='alert(\"$row[reserve_datetime_begin].$row[reserve_datetime_end]\");'>".$row["project_name"]."</div>";
			else 
				$cal_data[(int)substr($row["reserve_datetime_begin"],8,2)].="<div onclick='alert(\"$row[reserve_datetime_begin].$row[reserve_datetime_end]\");'>".$row["project_name"]."</div>";
			
		}
		print_r($cal_data);
		echo $this->db->last_query();
		return $cal_data;
	}
	function generate($year,$month)
	{
		
		$this->load->library("calendar",$this->conf);
		/*$cal_data=array(
				10=>'?c=test&m=calen&year=2013&month=10',
				11=>'bar'
		);*/
		$cal_data=$this->get_calendar($year, $month);
		return $this->calendar->generate($year,$month,$cal_data);
	}
}