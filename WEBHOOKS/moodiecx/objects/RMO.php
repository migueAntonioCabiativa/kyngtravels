<?php //------            RMO (Reports Make Object) Objeto de creacion de Reportes               ------------

require 'layouts/fpdf/fpdf.php';

class RMO extends FPDF{

  function Header(){
      global $title;

      // Arial bold 15
      $this->SetFont('Arial','B',15);
      $this->Image('../../assets/images/logo_moodie_negro1.png',10,6,58);
      $this->SetDrawColor(168,207,69);
      $this->Line(10,23,200,23);

      // Calculamos ancho y posición del título.
      $w = $this->GetStringWidth($title)+6;
      $this->SetX(10);
      $this->SetY(200);
      // Colores de los bordes, fondo y texto
      $this->SetDrawColor(0,0,0); // Borde Negro
      $this->SetFillColor(255,255,255);
      $this->SetTextColor(0,0,0);
      // Ancho del borde (1 mm)
      $this->SetLineWidth(0.1);
      // Título
      $this->Cell($w,9,$title,1,1,'C',true);
      // Salto de línea
      $this->Ln(10);
  }

  public function paguina($CON){
    $porcentaje = $CON->Promedio_dia_CDN('Thursday');

    // PAGUINA 1
    $this->AddPage();
    $this->SetFont('Arial','B',15);



    $this->Image('reports/imgs/grafica1.png',70,50,140);
    //$this->Image('../assets/images/logo_moodie_negro1.png',60,90,58);

    // PAGUINA 2
    $this->AddPage();
    $this->SetFont('Arial','B',15);
    $this->Image('../../assets/images/logo_moodie_negro1.png',20,40,58);

    for ($i=0; $i < 5; $i++) {
      $this->Cell(0,10,utf8_decode('Imprimiendo línea número '.$porcentaje),0,1);
    }
  }

  function Footer(){
      // Posición a 1,5 cm del final
      $this->SetY(-15);
      // Arial itálica 8
      $this->SetFont('Arial','I',8);
      // Color del texto en gris
      $this->SetTextColor(128);
      // Número de página
      $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
  }


  public function report($CON,$OR='',$OT='',$year='',$month='',$day='',$RP=''){
    global $title;
    $pdf = new RMO('P','mm','A4');

    $title = "Reddddporte $OR";
    $this->SetTitle($title);
    $this->SetAuthor('Julio Verne');

    $this->paguina($CON);

    if(is_file( 'reports/reporte.pdf' ))
    {
    unlink('reports/reporte.pdf');
    }
    $this->Output('F','reports/reporte.pdf');
    }



}
?>
