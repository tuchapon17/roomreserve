<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/*
		$this->load->library('upload'); // Load Library
		$files = $_FILES;
		//print_r($_FILES);
		$cpt = count($_FILES['project_file']['name']);
		$config = array();
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'doc|docx|pdf';
		$config['max_size']      = '0';
		$config['overwrite']     = FALSE;
		$this->upload->initialize($config); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean
				
		for($i=0; $i<$cpt; $i++)
		{
			
			$name = $_FILES["project_file"]["name"][$i];
			$ext = end(explode(".", $name));
			$file_detail=array(
					"new_name"=>str_replace(".", "_", microtime(true)).".".end(explode(".", $_FILES["project_file"]["name"][$i])),
					"old_name"=>$_FILES["project_file"]["name"][$i],
					"ext"=>end(explode(".", $_FILES["project_file"]["name"][$i])),
					"type"=>$_FILES["project_file"]["type"][$i],
					"error"=>$_FILES["project_file"]["error"][$i],
					"size"=>$_FILES["project_file"]["size"][$i]
			);
			print_r($file_detail);
				
			$_FILES['project_file']['name']= $files['project_file']['name'][$i];
			$_FILES['project_file']['type']= $files['project_file']['type'][$i];
			$_FILES['project_file']['tmp_name']= $files['project_file']['tmp_name'][$i];
			$_FILES['project_file']['error']= $files['project_file']['error'][$i];
			$_FILES['project_file']['size']= $files['project_file']['size'][$i];
			//echo "<hr>";print_r($_FILES);
			if($this->upload->do_upload('project_file'))echo "uploaded".$i;
			else echo "not up".$i;
			echo $this->upload->display_errors('<p>', '</p>');
		
										
										
		
		
		}*/
		//$this->load->view("test");
		$fields = $this->db->field_data("tb_reserve");
		foreach($fields as $f)
		{
			echo "<p>";
			echo $f->type;
			echo $f->max_length;
			echo $f->name;
			echo $f->primary_key;
			echo "</p>";
		}
		
	}
	public function calen($year=null,$month=null)
	{
		if(isset($_GET['year']))$year=$_GET['year'];
		if(isset($_GET['month']))$month=$_GET['month'];
		
		$this->load->model('test_model');
		$data["calendar"]=$this->test_model->generate($year,$month);
		$this->load->view("test",$data);
	}
	function random()
	{	echo str_pad(9,5,9,STR_PAD_RIGHT);
		$arr=array();
		for($i=1;$i<=15;$i++)
		{
			$r=rand(1,9);
			if(in_array($r,$arr))
			{
				//echo $r."exist";
				//print_r($arr);
				//echo "<br>";
			}
			else array_push($arr,$r);
		}
		
	}
	function testpdf()
	{
		ob_clean();
		$this->load->library("pdf");
		$pdf=$this->pdf;
		/*
		 * public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		 */
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		//$fontname = $pdf->addTTFfont($_SERVER['DOCUMENT_ROOT'].'/roomreserve/plugins/fonts/THSarabunNewI.ttf', 'TrueTypeUnicode', '', 32);
		$pdf->SetTitle('My Title');
		$pdf->SetHeaderMargin(30);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->setFontSubsetting(false);
		$pdf->SetFont('thsarabunnew', '', 16);
		
		$pdf->AddPage();
		//$pdf->SetPrintHeader(false);
		//$pdf->SetPrintFooter(false);
		
		$header = array('Country','column2');
		
		// data loading
		$data = $pdf->LoadData(array(
			"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
			"bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb"
		));
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		
		
		
		$pdf->Write(18, 'Some sample text');
		$pdf->Cell(0, 12, 'ภาษาไทยExample 001 - cell', 1, 1, 'C');
		$pdf->Multicell(0,2,"ทดสอบภถี่สี่ห้าเจ็ดเป๊กThis is a multi-line text string\nNew line\nNew line");
		
		ob_end_clean();
		$pdf->Output('My-File-Name.pdf', 'I');
	}
	function post()
	{
		if(isset($_GET['id']))
		{
			echo $_GET['id'];break;
			//redirect(base_url()."?c=test&m=post");
		}
		echo '<form action="'.base_url().'?c=test&m=post&id=1234" method="post">';
		echo '<button type="submit">test</button></form>';
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */