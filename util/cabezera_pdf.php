<?php

require 'fpdf/fpdf.php';
class PDFF extends FPDF{
    function Header(){
        $this->Image('../styles/guzz.png',15,10,21);
        $this->SetFont('Arial','B',15);
        $this->Cell(30);
        $this->Cell(135,10,'Agua Monte Arroyo',0,1,'C');
        //$this->SetFont('Arial','B',10);
        //$this->Cell(30);  
        $this->SetFont('Arial','B',10);
        $this->Cell(30);
        $this->Cell(135,10,'Intensamente Refrescante!',0,1,'C'); 
    }
    function Footer(){
        $fecha=date('Y-m-d H:i:s');
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(90,10,'Constancia generada el: '.$fecha,0,0,'L');
        $this->Cell(20,10,'Pagina ' . $this->PageNo().'/{nb}',0,0,'C');
    }
}
?>