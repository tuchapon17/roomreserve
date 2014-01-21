<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    
    //Page header
    public function Header() {
    	// Logo
    	//$image_file = K_PATH_IMAGES.'logo_example.jpg';
    	//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    	$this->SetY(12.5);
    	$this->SetX(195);
    	// Set font
    	$this->SetFont('thsarabunnew', '', 16);
    	// Title
    	//$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    	//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    	$this->Cell(0, 0, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'C', 'M');
    }
    
    // Page footer
    public function Footer() {
    	// Position at 15 mm from bottom
    	// Set font
    	//$this->SetFont('thsarabunnew', 'I', 8);
    	// Page number
    	
    }
    public function LoadData($file) {
    	// Read file lines
    	//$lines = file($file);
    	
    	$lines = $file;
    	$data = array();
    	foreach($lines as $line) {
    		$data[] = explode(';', chop($line));
    	}
    	return $data;
    }
    public function ColoredTable($header,$data) {
    	// Colors, line width and bold font
    	$this->SetFillColor(255, 255, 255);
    	$this->SetTextColor(0);
    	$this->SetDrawColor(0, 0, 0);
    	$this->SetLineWidth(0.2);
    	//$this->SetFont('', '');
    	// Header
    	$w = array(40, 35);
    	$num_headers = count($header);
    	for($i = 0; $i < $num_headers; ++$i) {
    		$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
    	}
    	$this->Ln();
    	// Color and font restoration
    	$this->SetFillColor(224, 235, 255);
    	$this->SetTextColor(0);
    	$this->SetFont('');
    	// Data
    	$fill = 0;
    	foreach($data as $row) {
    		//$this->MultiCell($w[0], 6, $row[0], 'LR', 1, 'L', $fill,'');
    			$this->Cell($w[0], 6, $row[0], 'LR', 1, 'L', $fill);
    		//$this->MultiCell($w[1], 6, $row[1], 'LR', 0, 'L', $fill,'');
    			$this->Cell($w[1], 6, $row[1], 'LR', 1, 'L', $fill);
    		//$this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
    		//$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
    		$this->Ln();
    		$fill=!$fill;
    	}
    	//$this->Cell(array_sum($w), 0, '', 'LR',1,'L','',2);
    }
}













