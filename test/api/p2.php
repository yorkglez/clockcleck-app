<?php
  require('./libs/fpdf/fpdf.php');
  /**
   *
   */
  // class Test extends FPDF
  // {
  //   // function Header(){
  //   //   $this->SetFont('Arial','B',15);
  //   //   $this->Cell(30);
  //   //    $this->Cell(30,10,'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ CAMPUS TALA',0,0,'C');
  //   //   // $this->Cell(30,10,'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ CAMPUS TALA',1,0,'C');
  //   //   $this->Ln(20);
  //   //   $this->SetFont('Arial','B',12);
  //   //   $this->Cell(0,10,'Fecha',0,'L');
  //   //   $this->Ln(4);
  //   //   $this->Ln();
  //   // }
  //
  //   // Pie de página
  //   function Footer()
  //   {
  //       // Posición: a 1,5 cm del final
  //       $this->SetY(-15);
  //       // Arial italic 8
  //       $this->SetFont('Arial','I',8);
  //       // Número de página
  //       $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  //   }
  //
  // }
  //
  $type = 'teacher';
  $extension = 'Tala';
  $teacher = 'Juan Luis Rivera';

  $pdf = new FPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  // header
  $pdf->Image('C:/tecmmlogo.png',10,10,25);
  $pdf->Cell(25,20,'',1,0,'L');
  $pdf->SetFont('Arial','B',15);
  $pdf->MultiCell(150,10,'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ CAMPUS TALA',1,'C',0);
  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(150,10,'Reporte de asitencia personal Docente',0,0,'L');
  $pdf->Cell(15,10,'Fecha:',0,0,'R');
  $pdf->SetFont('Arial','',12);
  $pdf->Cell(25,10,'12-14-2018',0,0,'R');
  $pdf->Ln(6);
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(150,10,'Periodo 2018 al 2019 Quincenal del 10/10/2018 al 10/10/2018',0,0,'L');
  $pdf->Cell(13,10,'Hora:',0,0,'R');
  $pdf->SetFont('Arial','',12);
  $pdf->Cell(15,10,'21:12',0,0,'R');
  $pdf->Ln(10);
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(22,10,'Extension:',0,0,'L');
  $pdf->SetFont('Arial','',12);
  $pdf->Cell(20,10,$extension,0,0,'L');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(33,10,'Tipo de reporte:',0,0,'L');
  $pdf->SetFont('Arial','',12);
  $pdf->Cell(30,10,'Por empleado',0,0,'L');
  $pdf->SetFont('Arial','B',12);


  //$pdf->Ln(10);
//  $pdf->SetLeftMargin(2);

  // talbe header
  switch ($type) {
    case 'teacher':
      $pdf->Cell(20,10,'Docente:',0,0,'L');
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(30,10,$teacher,0,0,'R');
      $pdf->Ln(10);

      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(27,6,'Departamento',1,0,'C',0);
      $pdf->Cell(16,6,'Entrada',1,0,'C',0);
      $pdf->Cell(14,6,'Salida',1,0,'C',0);
      $pdf->Cell(12,6,'Grupo',1,0,'C',0);
      $pdf->Cell(20,6,'Asistencia',1,0,'C',0);
      $pdf->Cell(55,6,'Tema/Actividad',1,0,'C',0);
      $pdf->Cell(55,6,'Materia',1,0,'C',0);
      // $pdf->Cell(30,6,'Notas',1,0,'C',0);

      $pdf->Ln(6);
      $pdf->SetFont('Times','',10);
      $pdf->Cell(27,6,'ISIC',1,0,'C',0);
      $pdf->Cell(16,6,'7:00 AM',1,0,'C',0);
      $pdf->Cell(14,6,'8:40 AM',1,0,'C',0);
      $pdf->Cell(12,6,'1',1,0,'C',0);
      $pdf->Cell(20,6,'Presente',1,0,'C',0);
      $pdf->Cell(55,6,'Hacerlos llorar',1,0,'C',0);
      $pdf->Cell(55,6,'Fundamentos de programacion',1,0,'C',0);
      break;
    case 'subject':
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(27,6,'Departamento',1,0,'C',0);
      $pdf->Cell(16,6,'Entrada',1,0,'C',0);
      $pdf->Cell(14,6,'Salida',1,0,'C',0);
      $pdf->Cell(12,6,'Grupo',1,0,'C',0);
      $pdf->Cell(20,6,'Asistencia',1,0,'C',0);
      $pdf->Cell(50,6,'Tema/Actividad',1,0,'C',0);

      // $pdf->Cell(30,6,'Notas',1,0,'C',0);

      $pdf->Ln(6);
      $pdf->SetFont('Times','',10);
      $pdf->Cell(27,6,'ISIC',1,0,'C',0);
      $pdf->Cell(16,6,'7:00 AM',1,0,'C',0);
      $pdf->Cell(14,6,'8:40 AM',1,0,'C',0);
      $pdf->Cell(12,6,'1',1,0,'C',0);
      $pdf->Cell(20,6,'Presente',1,0,'C',0);
      $pdf->Cell(50,6,'Hacerlos llorar',1,0,'C',0);
      break;

    default:
      // code...
      break;
  }



  if ($type == 'all') {
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(27,6,'Departamento',1,0,'C',0);
    $pdf->Cell(16,6,'Entrada',1,0,'C',0);
    $pdf->Cell(14,6,'Salida',1,0,'C',0);
    $pdf->Cell(12,6,'Grupo',1,0,'C',0);
    $pdf->Cell(20,6,'Asistencia',1,0,'C',0);
    $pdf->Cell(50,6,'Tema/Actividad',1,0,'C',0);
    $pdf->Cell(50,6,'Materia',1,0,'C',0);
    // $pdf->Cell(30,6,'Notas',1,0,'C',0);

    $pdf->Ln(6);
    $pdf->SetFont('Times','',10);
    $pdf->Cell(27,6,'ISIC',1,0,'C',0);
    $pdf->Cell(16,6,'7:00 AM',1,0,'C',0);
    $pdf->Cell(14,6,'8:40 AM',1,0,'C',0);
    $pdf->Cell(12,6,'1',1,0,'C',0);
    $pdf->Cell(20,6,'Presente',1,0,'C',0);
    $pdf->Cell(50,6,'Hacerlos llorar',1,0,'C',0);
    $pdf->Cell(50,6,'Fundamentos de programacion',1,0,'C',0);
  }



  $pdf->Ln();
  $pdf->Output();


 ?>
