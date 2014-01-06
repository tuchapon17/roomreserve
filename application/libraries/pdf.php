<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    //Page header
    public function Header() {
    	// Logo
    	//$image_file = K_PATH_IMAGES.'logo_example.jpg';
    	//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    	//$this->SetY(0);
    	// Set font
    	$this->SetFont('thsarabunnew', '', 15);
    	// Title
    	//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    	//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    	$this->Cell(0, 0, $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'C', 'M');
    }
    
    // Page footer
    public function Footer() {
    	// Position at 15 mm from bottom
    	// Set font
    	//$this->SetFont('thsarabunnew', 'I', 8);
    	// Page number
    	
    }
}