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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */