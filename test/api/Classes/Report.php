<?php
  /**
   *
   */
   require '../../vendor/autoload.php';
   // use Spipu\Html2Pdf\Html2Pdf;

   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

   require('../../libs/fpdf/fpdf.php');
   require_once('Connection.php');
   date_default_timezone_set('America/Mexico_City');
  class Report extends Connection
  {


      public function getReports($values){
        $sql = "CALL getReports(:week,:ter,:startDate,:endDate,:code,:extension,:subject)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':week',$values['week'],PDO::PARAM_STR);
        $stmt->bindParam(':ter',$values['ter'],PDO::PARAM_STR);
        $stmt->bindParam(':startDate',$values['startDate'],PDO::PARAM_STR);
        $stmt->bindParam(':endDate',$values['endDate'],PDO::PARAM_STR);
        $stmt->bindParam(':code',$values['code'],PDO::PARAM_STR);
        $stmt->bindParam(':extension',$values['extension'],PDO::PARAM_INT);
        $stmt->bindParam(':subject',$values['subject'],PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
              $fetch[] = $row;
          $this->closeConnection();
        }
        else
          $fetch = false;
        return $fetch;
      }

      public function generateReportExcel($values){
        $spreadsheet = new Spreadsheet(); //Call class
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); //Activate sheet
        /* Styles */
        $styleTitle = array(
          'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '#000000'),
            'size'  => 14,
            'name'  => 'Arial'
          ),
          'alignment' => array(
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          )
        );
        $styleSubtitle = array(
          'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '#000000'),
            'size'  => 12,
            'name'  => 'Arial'
          ),
          'alignment' => array(
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          )
        );
        $styleCells = [
          'borders' => [
            'allBorders' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
              'color' => ['argb' => '#000000'],
            ],
          ],
        ];
        $styleHeader = [
          'font'  => [
            'bold'  => true,
            'color' => array('rgb' => '#000000'),
            'size'  => 12,
            'name'  => 'Arial'
          ],
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ]
        ];

        /* Header doc */
        $sheet->mergeCells('A1:O1'); //Combinate cells
        $sheet->setCellValue('A1', 'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ'); //Set value cell
        $sheet->getStyle('A1')->applyFromArray($styleTitle); //Apply styles
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //Apply styles
        $sheet->mergeCells('A2:I2'); //Combinate cells
        $sheet->setCellValue('A2', 'Reporte De asistencia personal docente Campus Tala'); //Set value cell
        $sheet->getStyle('A2')->applyFromArray($styleSubtitle); //Apply styles

        $sheet->mergeCells('A3:I3'); //Combinate cells
        if($values['week'] != 'null')
          $sheet->setCellValue('A3', 'Periodo 2018 al 2019 '.$this->dataBetween($values['week']));
        else
          $sheet->setCellValue('A3', 'Periodo 2018 al 2019 typereport del '.date("d-m-Y",strtotime($values['startDate'])).' al '.date("d-m-Y",strtotime($values['endDate'])));
        $sheet->getStyle('A3')->applyFromArray($styleSubtitle); //Apply styles

        $sheet->setCellValue('A4','Extension: '.$this->getExtensionName($values['extension'])); //Extension name
        $sheet->mergeCells('A4:B4'); //Combinate cells

        $sheet->setCellValue('C4','Tipo de reporte: Por materia');
        $sheet->mergeCells('C4:E4'); //Combinate cells

        $sheet->setCellValue('F4','Docente: Juan Luis Rivaz');
        $sheet->mergeCells('F4:H4'); //Combinate cells

        /* Date & time  */
        $sheet->setCellValue('J2','Fecha: '.$this->getDatetimeNow('date'));
        $sheet->mergeCells('J2:K2'); //Combinate cells2

        $sheet->setCellValue('J3','Hora: '.$this->getDatetimeNow('time'));
        $sheet->mergeCells('J3:K3'); //Combinate cells

        /* Header table */
        $sheet->setCellValue('A6', 'Departamento');
        $sheet->mergeCells('A6:A7'); //Combinate cells
        $sheet->setCellValue('B6', 'Docente');
        $sheet->mergeCells('B6:B7'); //Combinate cells
        // $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('C6', 'Hora');
        $sheet->mergeCells('C6:D6'); //Combinate cells

        // $sheet->mergeCells('E5:D5'); //Combinate cells

        $sheet->setCellValue('C7', 'Entrada');
        $sheet->setCellValue('D7', 'Salida');
        $sheet->setCellValue('E7', 'Grupo');
        $sheet->setCellValue('E6', 'Localidad');
        $sheet->setCellValue('F6', 'Asistencia');
        $sheet->mergeCells('F6:F7'); //Combinate cells
        $sheet->setCellValue('G6', 'Tema/Actividad');
        $sheet->mergeCells('G6:G7'); //Combinate cells
        $sheet->setCellValue('H6', 'Materia');
        $sheet->mergeCells('H6:H7'); //Combinate cells
        $sheet->setCellValue('I6', 'Total de horas');
        $sheet->mergeCells('I6:I7'); //Combinate cells
        $sheet->getStyle('A6
        :I7')->applyFromArray($styleHeader); //Apply styles
        /* Get report form database*/
        $reports = $this->getReports($values);

        $i = 8;
        /* get data from database */
        foreach ($reports as $row) {
          $sheet->setCellValue('A'.$i, $row['alias']);  //Departamento
          $sheet->setCellValue('B'.$i, 'hello World!');  //Docente type
          $sheet->setCellValue('C'.$i, $row['checkEntry']);  //Etrada
          $sheet->setCellValue('D'.$i, $row['checkEnd']);  // Salida
          $sheet->setCellValue('E'.$i, $row['grade']);   // Grupo
          $sheet->setCellValue('F'.$i, $row['type']); //Assitencia
          $sheet->setCellValue('G'.$i, $row['topic']); //Tema
          $sheet->setCellValue('H'.$i, $row['nameSubject']); //Materia

          $i++; //count
        }

        // $pdf->Cell(27,6,,1,0,'C',0);
        // $pdf->Cell(16,6,,1,0,'C',0);
        // $pdf->Cell(14,6,,1,0,'C',0);
        // $pdf->Cell(12,6,$row['grade'],1,0,'C',0);
        // $pdf->Cell(20,6,,1,0,'C',0);
        // $pdf->Cell(55,6,,1,0,'C',0);
        // $pdf->Cell(55,6,,1,1,'C',0);

        /* Cells format */
        $sheet->getStyle('A6:I'.($i-1))->applyFromArray($styleCells);
        /* Auto size cell */
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        foreach( range('A','I') as $cell ) {
          $sheet->getColumnDimension($cell)->setAutoSize(true);
        }
        /* Save file */
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save('hello world.xlsx');
            echo 'save';
        } catch (\Exception $e) {
          echo $e->getMessage();
        }


      }

      public function generateReportPDF($values){
        $subject = $values['subject'];
        $extension = $this->getExtensionName($values['extension']);

        $sql = "CALL getReports(:week,:ter,:startDate,:endDate,:code,:extension,:subject)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':week',$values['week'],PDO::PARAM_STR);
        $stmt->bindParam(':ter',$values['ter'],PDO::PARAM_STR);
        $stmt->bindParam(':startDate',$values['startDate'],PDO::PARAM_STR);
        $stmt->bindParam(':endDate',$values['endDate'],PDO::PARAM_STR);
        $stmt->bindParam(':code',$values['code'],PDO::PARAM_STR);
        $stmt->bindParam(':extension',$values['extension'],PDO::PARAM_INT);
        $stmt->bindParam(':subject',$values['subject'],PDO::PARAM_INT);
        $stmt->execute();
      //  $this->closeConnection();

        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
          $hoursCount = 0;
          $teacherName = $fetch[0]['nameTeacher'];
          foreach ($fetch as $row) {
            $endTime = strtotime($row['checkEnd']);
            if($endTime != ''){
              $startTime = strtotime($row['checkEntry']);
              $hoursCount = (round(abs($endTime - $startTime) / 60) / 50) + $hoursCount;
            }
          }


          $pdf = new FPDF();
          $pdf->AliasNbPages();
          $pdf->AddPage();

          /*header*/
          $pdf->Image('C:/tecmmlogo.png',10,10,25); //Logo header
          $pdf->Cell(25,20,'',1,0,'L');
          $pdf->SetFont('Arial','B',15);
          $pdf->MultiCell(150,10,'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ CAMPUS TALA',1,'C',0); // TEC MM Name and campus
          $pdf->Ln(5);

          $pdf->SetFont('Arial','B',12);
          $pdf->Cell(150,10,'Reporte de asitencia personal docente',0,0,'L');
          /* line date now */
          $pdf->Cell(15,10,'Fecha:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          $pdf->Cell(23,10,$this->getDatetimeNow('date'),0,0,'R'); //date now
          $pdf->Ln(6);

          $pdf->SetFont('Arial','B',12);
          /* report type */
          if($values['week'] != 'null')
            $pdf->Cell(150,10,'Periodo 2018 al 2019 '.$this->dataBetween($values['week']),0,0,'L');
          else
            $pdf->Cell(150,10,'Periodo 2018 al 2019 custom del '.date("d-m-Y",strtotime($values['startDate'])).' al '.date("d-m-Y",strtotime($values['endDate'])),0,0,'L');
          /* line time now */
          $pdf->Cell(13,10,'Hora:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          $pdf->Cell(12,10,$this->getDatetimeNow('time'),0,0,'R');
          $pdf->Ln(6);
          /* Line total hours  */
          $pdf->SetFont('Arial','B',12);
          $pdf->Cell(31,10,'Total de horas:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          $pdf->Cell(10,10,$hoursCount,0,0,'L'); //total hours
          $pdf->Ln(10);

          $pdf->SetFont('Arial','B',12);
          $pdf->Cell(22,10,'Extension:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          $pdf->Cell(20,10,$extension,0,0,'L');
          $pdf->SetFont('Arial','B',12);
          $pdf->Cell(33,10,'Tipo de reporte:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          if($values['subject'] == 'null')
            $pdf->Cell(30,10,'Por empleado',0,0,'L');
          else
              $pdf->Cell(30,10,'Por materia',0,0,'L');
          $pdf->SetFont('Arial','B',12);
          $pdf->Cell(20,10,'Docente:',0,0,'L');
          $pdf->SetFont('Arial','',12);
          $pdf->Cell(40,10,$teacherName,0,0,'L');
          $pdf->Ln(10);
            /*type teacher*/
            if($subject == 'null'){

              $pdf->SetFont('Arial','B',11);
              $pdf->Cell(27,6,'Departamento',1,0,'C',0);
              $pdf->Cell(16,6,'Entrada',1,0,'C',0);
              $pdf->Cell(14,6,'Salida',1,0,'C',0);
              $pdf->Cell(14,6,'Grupo',1,0,'C',0);
              $pdf->Cell(20,6,'Asistencia',1,0,'C',0);
              $pdf->Cell(55,6,'Tema/Actividad',1,0,'C',0);
              $pdf->Cell(55,6,'Materia',1,0,'C',0);
              // $pdf->Cell(30,6,'Notas',1,0,'C',0);
              $pdf->Ln(6);
              $pdf->SetFont('Times','',10);

              foreach ($fetch as $row) {
                $pdf->Cell(27,6,$row['alias'],1,0,'C',0);
                $pdf->Cell(16,6,$row['checkEntry'],1,0,'C',0);
                $pdf->Cell(14,6,$row['checkEnd'],1,0,'C',0);
                $pdf->Cell(14,6,$row['grade'],1,0,'C',0);
                $pdf->Cell(20,6,$row['type'],1,0,'C',0);
                $pdf->Cell(55,6,$row['topic'],1,0,'C',0);
                $pdf->Cell(55,6,$row['nameSubject'],1,1,'C',0);
              }
            }
            /*type subject*/
            else{
              /*/$pdf->Cell(25,10,'Docente:',0,0,'L');
              $pdf->SetFont('Arial','',12);
              $pdf->Cell(50,10,$stmt->fetch(PDO::FETCH_ASSOC)['nameTeacher'],0,0,'R');
              $pdf->Ln(10);*/
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
                foreach ($fetch as $row) {
                $pdf->Cell(27,6,$row['alias'],1,0,'C',0);
                $pdf->Cell(16,6,$row['checkEntry'],1,0,'C',0);
                $pdf->Cell(14,6,$row['checkEnd'],1,0,'C',0);
                $pdf->Cell(12,6,$row['grade'],1,0,'C',0);
                $pdf->Cell(20,6,$row['type'],1,0,'C',0);
                $pdf->Cell(55,6,$row['topic'],1,0,'C',0);
                $pdf->Cell(55,6,$row['nameSubject'],1,1,'C',0);
              }

            }

         $this->closeConnection();
         $pdf->Output('reporte-'.date('d-m-Y-i:s').'.pdf','I');
        }
        else{
          $fetch = false;
        }

        // function Footer() {
        //   $pdf->SetY(-1);
        //   $pdf->SetFont('Arial','I',8);
        //   $pdf->Cell(0,10,'Pagina '.$pdf->pageNo(),0,0,'C');
        //  }
      }
    /**
     * [getExtensionName description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    private function getExtensionName($id){
      $sql = "SELECT name FROM Extensions WHERE idExtension = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      $extension = $stmt->fetchColumn();
      $this->closeConnection();
      return $extension;
    }

    private function dataBetween($type){
      $dt = new DateTime();
      switch ($type) {
        case 'day':
            $date = 'Diario del '.$dt->format('d-m-Y');
          break;
        case 'week':
            $startDate = strtotime ('-7 day' ,strtotime($dt->format('d-m-Y')));
            $startDate = date('d-m-Y',$startDate);
            $date = 'Semanal del '.$startDate.' al '.$dt->format('d-m-Y');
          break;
        case '2weeks':
          $startDate = strtotime ('-14 day' ,strtotime($dt->format('d-m-Y')));
          $startDate = date('d-m-Y',$startDate);
          $date = 'Semanal del '.$startDate.' al '.$dt->format('d-m-Y');
          break;

        case 'month':
          $startDate = strtotime ('-1 month' ,strtotime($dt->format('d-m-Y')));
          $startDate = date('d-m-Y',$startDate);
          $date = 'Semanal del '.$startDate.' al '.$dt->format('d-m-Y');
          break;
      }
      return $date;
    }
    private function getDatetimeNow($type){
      $tz_object = new DateTimeZone('America/Mexico_City');
   //date_default_timezone_set('Brazil/East');
     $datetime = new DateTime();
     $datetime->setTimezone($tz_object);
     if ($type == 'date')
       return $datetime->format('d-m-Y');
    else if($type == 'time')
       return $datetime->format('H:i');
    }
    public function downloadFile($path){
      try{
      // $path = "./Service/reports/report_test.pdf";
       // $app->response->setStatus(200);
       header('Content-Type','application/pdf' );
       header('Content-Transfer-Encoding', 'Binary');
       header('Content-disposition', 'attachment; filename="report_test"');
       header('Content-Length', filesize($path));
       header('Expires', '0');
       header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
       header('Pragma', 'public');
      // ob_clean();
      ob_start();
      readfile($path);
      $content = ob_get_clean();
      return  $content;
      // $app->response()->body($content);
      }
      catch (Exception $e) {
      $arr = array('status' => "error", 'fault' => $e->getMessage());
    }

    }
  }



 ?>
