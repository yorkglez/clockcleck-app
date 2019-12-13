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
   // require_once('Report.php');
   date_default_timezone_set('America/Mexico_City');
  // class Aux extends Report{}
  class Report extends Connection
  {
      /**
       * [getReports description]
       * @param  [type] $values [description]
       * @return [type]         [description]
       */
       // use PhpOffice\PhpSpreadsheet\Spreadsheet;
       // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
      public function getReports($values){
        $sql = "CALL getReports(:week,:ter,:startDate,:endDate,:code,:extension,:subject)";//create sentence
        $stmt = $this->connect()->prepare($sql); //prepare sentence
        /*create params*/
        $stmt->bindParam(':week',$values['week'],PDO::PARAM_STR);
        $stmt->bindParam(':ter',$values['ter'],PDO::PARAM_STR);
        $stmt->bindParam(':startDate',$values['startDate'],PDO::PARAM_STR);
        $stmt->bindParam(':endDate',$values['endDate'],PDO::PARAM_STR);
        $stmt->bindParam(':code',$values['code'],PDO::PARAM_STR);
        $stmt->bindParam(':extension',$values['extension'],PDO::PARAM_INT);
        $stmt->bindParam(':subject',$values['subject'],PDO::PARAM_INT);
        $stmt->execute(); //execute sentence
        /*validate results*/
        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
              $fetch[] = $row; //get data
          $this->closeConnection(); //close conection
        }
        else
          $fetch = false;
        return $fetch;
      }
      /**
       * [generateReportExcel description]
       * @param  [type] $values [description]
       * @return [type]         [description]
       */
      public function generateReportExcel($values){
      /*get report type*/
       if($values['code'] != 'null' AND $values['subject'] != 0)
         $reportType = 'materia'; //reporte type
       if($values['code'] != 'null' AND $values['subject'] == 0)
         $reportType = 'docente'; //reporte type
       if($values['code'] == 'null' AND $values['subject'] == 0)
         $reportType = 'general'; //reporte type
        /*call class sheet*/
        $spreadsheet = new Spreadsheet(); //Call class
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet(); //Activate sheet
        // $sheet->setChellValue();
        /*Get teacher name*/
        if($reportType != 'general'){
          $value = ['code' => $values['code']];
          $teacher = json_decode($this->getFirst('view_reports','WHERE codeTeacher =:code',$value));
          $teacherName = $teacher->nameTeacher;
          $dep = $teacher->alias;
        }
        else
          $teacherName = 'General';
        /* Styles */
        $styleTitle = [
          'font'  => [
            'bold'  => true,
            'color' => ['rgb' => '#000000'],
            'size'  => 11,
            'name'  => 'Arial'
          ],
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ]
        ];
        /*Subtitle styles*/
        $styleSubtitle = [
          'font'  => [
            'bold'  => true,
            'color' => ['rgb' => '#000000'],
            'size'  => 11,
            'name'  => 'Arial'
          ],
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
          ]
        ];
        /*Style cells*/
        $styleCells = [
          'borders' => [
            'allBorders' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
              'color' => ['argb' => '#000000'],
            ],
          ],
        ];
        /*Style cell header*/
        $styleCellsHeader = [
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
            'size'  => 10,
            'name'  => 'Arial'
          ],
          'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ]
        ];

        /*General report config*/
        if($reportType == 'general'){
          // $value = ['code' => $values['code']];
          // $teacher = json_decode($this->getFirst('view_reports','WHERE codeTeacher =:code',$value));
          // $teacherName = $teacher->nameTeacher;
          // $dep = $teacher->alias;
          /*Logo*/
          $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
          $drawing ->setPath('../../public/images/tecmmlogo.png'); // put your path and image here
          $drawing ->setCoordinates('A2');
          $drawing ->setOffsetX(0);
          $drawing ->setOffsetY(5);
          $drawing ->getShadow()->setVisible(true);
          $drawing ->setWorksheet($spreadsheet->getActiveSheet());
          $sheet->mergeCells('A2:A5'); //Combinate cells
          $sheet->getStyle('A2:I5')->applyFromArray($styleCellsHeader);
          // /* Header doc */
          $sheet->mergeCells('B2:I2'); //Combinate cells
          $sheet->setCellValue('B2', 'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ'); //Set value cell
          $sheet->getStyle('B2')->applyFromArray($styleTitle); //Apply styles
          // $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //Apply styles
          $sheet->mergeCells('B3:H3'); //Combinate cells
          $sheet->setCellValue('B3', 'Reporte de asistencia personal docente Campus Tala'); //Set value cell
          $sheet->getStyle('B3')->applyFromArray($styleSubtitle); //Apply styles
          $sheet->mergeCells('B4:H4'); //Combinate cells
          if($values['week'] != 'null')
            $sheet->setCellValue('B4', 'Periodo 2018 al 2019 '.$this->dataBetween($values['week']));
          else
            $sheet->setCellValue('B4', 'Periodo 2018 al 2019 personalizado del '
            .date("d-m-Y",strtotime($values['startDate'])).' al '.date("d-m-Y",strtotime($values['endDate'])));
          $sheet->getStyle('B4')->applyFromArray($styleSubtitle); //Apply styles
          $sheet->setCellValue('B5','Extension: '.$this->getExtensionName($values['extension'])); //Extension name
          $sheet->mergeCells('B5:E5'); //Combinate cells
          $sheet->setCellValue('F5','Tipo de reporte: '.$reportType);
          $sheet->mergeCells('F5:I5'); //Combinate cells
          /*Header table*/
          $sheet->setCellValue('A7', 'Departamento');
          $sheet->mergeCells('A7:A8'); //Combinate cells
          $sheet->setCellValue('B7', 'Docente');
          $sheet->mergeCells('B7:B8'); //Combinate cells
          $sheet->setCellValue('C7', 'Tipo');
          $sheet->mergeCells('C7:C8'); //Combinate cells
          $sheet->setCellValue('D7', 'Hora');
          $sheet->mergeCells('D7:E7'); //Combinate cells
          /*Table header*/
          $sheet->setCellValue('D8', 'Entrada');
          $sheet->setCellValue('E8', 'Salida');
          $sheet->setCellValue('F7', 'Localidad');
          $sheet->setCellValue('F8', 'Grupo');
          $sheet->setCellValue('G7', 'Asistencia');
          $sheet->mergeCells('G7:G8'); //Combinate cells
          $sheet->setCellValue('H7', 'Nota');
          $sheet->mergeCells('H7:H8'); //Combinate cells
          $sheet->setCellValue('I7', 'Tema/Actividad');
          $sheet->mergeCells('I7:I8'); //Combinate cells
          $sheet->setCellValue('J7', 'Materia');
          $sheet->mergeCells('J7:J8'); //Combinate cells
          $sheet->setCellValue('K7', 'Total de horas');
          $sheet->mergeCells('K7:K8'); //Combinate cells
          $sheet->getStyle('A7:K8')->applyFromArray($styleHeader); //Apply styles
        }
        /*Report config*/
        else{
          $value = ['code' => $values['code']];
          $teacher = json_decode($this->getFirst('view_reports','WHERE codeTeacher =:code',$value));
          $teacherName = $teacher->nameTeacher;
          $dep = $teacher->alias;
          /*Logo*/
          $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
          $drawing ->setPath('../../public/images/tecmmlogo.png'); // put your path and image here
          $drawing ->setCoordinates('A2');
          $drawing ->setOffsetX(0);
          $drawing ->setOffsetY(5);
          $drawing ->getShadow()->setVisible(true);
          $drawing ->setWorksheet($spreadsheet->getActiveSheet());
          // // /* Cells format */
          $sheet->mergeCells('A2:B5'); //Combinate cells
          $sheet->getStyle('A2:I5')->applyFromArray($styleCellsHeader);
          // /* Header doc */
          $sheet->mergeCells('C2:I2'); //Combinate cells
          $sheet->setCellValue('C2', 'INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ'); //Set value cell
          $sheet->getStyle('C2')->applyFromArray($styleTitle); //Apply styles
          // // $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //Apply styles
          $sheet->mergeCells('C3:H3'); //Combinate cells
          $sheet->setCellValue('C3', 'Reporte de asistencia personal docente Campus Tala'); //Set value cell
          $sheet->getStyle('C3')->applyFromArray($styleSubtitle); //Apply styles
          $sheet->mergeCells('C4:H4'); //Combinate cells
          if($values['week'] != 'null')
            $sheet->setCellValue('C4', 'Periodo del 2019 '.$this->dataBetween($values['week']));
          else
            $sheet->setCellValue('C4', 'Periodo personalizado del '
            .date("d-m-Y",strtotime($values['startDate'])).' al '.date("d-m-Y",strtotime($values['endDate'])));
          $sheet->getStyle('C4')->applyFromArray($styleSubtitle); //Apply styles
          /*Report type docente and materia*/
          // $sheet->setCellValue('A7', 'Tipo');
          // $sheet->mergeCells('A7:A8'); //Combinate cells
          $sheet->setCellValue('A7', 'Hora');
          $sheet->mergeCells('A7:B7'); //Combinate cells
          /*Table header*/
          $sheet->setCellValue('A8', 'Entrada');
          $sheet->setCellValue('B8', 'Salida');
          $sheet->setCellValue('C7', 'Localidad');
          $sheet->setCellValue('C8', 'Grupo');
          $sheet->setCellValue('D7', 'Asistencia');
          $sheet->mergeCells('D7:D8'); //Combinate cells
          $sheet->setCellValue('E7', 'Nota');
          $sheet->mergeCells('E7:E8'); //Combinate cells
          $sheet->setCellValue('F7', 'Tema/Actividad');
          $sheet->mergeCells('F7:F8'); //Combinate cells
          /*Report type docente*/
          if($reportType == 'docente'){
            /*Header*/
            $sheet->setCellValue('C5','Extension: '.$this->getExtensionName($values['extension'])); //Extension name
            $sheet->mergeCells('C5:D5'); //Combinate cells
            $sheet->setCellValue('E5','Tipo de reporte: por '.$reportType);
            $sheet->mergeCells('E5:F5'); //Combinate cells
            $sheet->setCellValue('G5','Docente: '.$teacherName);
            $sheet->mergeCells('G5:H5'); //Combinate cells
            $sheet->setCellValue('I5','Departamento: '.$dep);
            // $sheet->mergeCells('H5:I5'); //Combinate cells
            /*Header table*/
            $sheet->setCellValue('G7', 'Materia');
            $sheet->mergeCells('G7:G8'); //Combinate cells
            $sheet->setCellValue('H7', 'Total de horas');
            $sheet->mergeCells('H7:H8'); //Combinate cellsI
            $sheet->getStyle('A7:H8')->applyFromArray($styleHeader); //Apply styles
          }
          /*Report type materia*/
          else if($reportType == 'materia'){
            /*Header*/
            $sheet->setCellValue('C5','Extension: '.$this->getExtensionName($values['extension'])); //Extension name
            $sheet->mergeCells('C5:D5'); //Combinate cells
            $sheet->setCellValue('E5','Tipo de reporte: por '.$reportType);
            $sheet->mergeCells('E5:F5'); //Combinate cells
            $sheet->setCellValue('G5','Docente: '.$teacherName);
            $sheet->mergeCells('G5:H5'); //Combinate cells
            $sheet->setCellValue('I5','Departamento: '.$dep);
            $sb = ['code'=>$values['subject']];
            $subjectName = json_decode($this->getFirst('viewsbName','WHERE idSubjectlist =:code',$sb));
            $sheet->setCellValue('G06','Materia: '.$subjectName->name);
            $sheet->mergeCells('G6:I6'); //Combinate cells
            // /*Header table */
            $sheet->setCellValue('G7', 'Total de horas');
            $sheet->mergeCells('G7:G8'); //Combinate cells
            $sheet->getStyle('A7:G8')->applyFromArray($styleHeader); //Apply styles
          }
        }
        /* Date & time  */
        $sheet->setCellValue('I3','Fecha: '.$this->getDatetimeNow('date'));
        $sheet->setCellValue('I4','Hora: '.$this->getDatetimeNow('time'));
        /* Get report form database*/
        $reports = $this->getReports($values); //get report and cover to array
        // print_r($values);
        $i = 9; // columns numbers
        /* get data from database */
        foreach ($reports as $row) {
          /*get total hours*/
          $stTime = strtotime($row['checkEntry']);
          $enTime = strtotime($row['checkEnd']);
          $total = round((abs($stTime-$enTime) / 60)/50);
          $sheet->setCellValue('A'.$i, $row['alias']);  //Departamento
          // $sheet->setCellValue('B'.$i, $row['teacherType']);  //Docente type
          if($reportType == 'general'){
            $sheet->setCellValue('B'.$i, $row['nameTeacher']);  //Docente type
            $sheet->setCellValue('C'.$i, $row['teacherType']);  //Docente type
            $sheet->setCellValue('D'.$i, $row['checkEntry']);  //Etrada
            $sheet->setCellValue('E'.$i, $row['checkEnd']);  // Salida
            $sheet->setCellValue('F'.$i, $row['grade']);   // Grupo
            $sheet->setCellValue('G'.$i, $row['type']); //Assitencia
            $sheet->setCellValue('H'.$i, $row['notes']); //Assitencia
            $sheet->setCellValue('I'.$i, $row['topic']); //Tema
            $sheet->setCellValue('J'.$i, $row['nameSubject']); //Materia
            $sheet->setCellValue('K'.$i,  $total); //Materia
            $lastcell = 'K';
          }
          else if($reportType == 'docente'){
            // $sheet->setCellValue('B'.$i, $row['teacherType']);  //Docente type
            $sheet->setCellValue('A'.$i, $row['checkEntry']);  //Etrada
            $sheet->setCellValue('B'.$i, $row['checkEnd']);  // Salida
            $sheet->setCellValue('C'.$i, $row['grade']);   // Grupo
            $sheet->setCellValue('D'.$i, $row['type']); //Assitencia
            $sheet->setCellValue('E'.$i, $row['notes']); //Assitencia
            // $sheet->setCellValue('F'.$i, 'Revision de presentacion de proyectos'); //Tema
            $sheet->setCellValue('F'.$i, $row['topic']); //Tema
            $sheet->setCellValue('G'.$i, $row['nameSubject']); //Materia
            $sheet->setCellValue('H'.$i,  $total); //Materia
            $lastcell = 'H';
          }
          else if($reportType == 'materia'){
            // $sheet->setCellValue('B'.$i, $row['teacherType']);  //Docente type
            $sheet->setCellValue('A'.$i, $row['checkEntry']);  //Etrada
            $sheet->setCellValue('B'.$i, $row['checkEnd']);  // Salida
            $sheet->setCellValue('C'.$i, $row['grade']);   // Grupo
            $sheet->setCellValue('D'.$i, $row['type']); //Assitencia
            // $sheet->setCellValue('E'.$i, $row['notes']); //Assitencia
            $sheet->setCellValue('E'.$i,'Incapacitacion'); //Assitencia
            $sheet->setCellValue('F'.$i,'Realizar examenen de segundo parcial'); //Tema
            // $sheet->setCellValue('H'.$i, $row['topic']); //Tema
            $sheet->setCellValue('G'.$i,  $total); //Materia
            $lastcell = 'G';
          }
          $i++; //row position
        }
        // $highestRow = $sheet->getHighestRow();
        // for ($row = 1; $row <= $highestRow; $row++){
        //     $sheet->getStyle("H$row")->getAlignment()->setWrapText(true);
        // }
        /* Cells format */
        $sheet->getStyle('A7:'.$lastcell.($i-1))->applyFromArray($styleCells);
        /* Auto size cell */
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        // $cellIterator->setIterateOnlyExistingCells(true);
        if($reportType != 'general'){
          foreach( range('A','E') as $cell )
            $sheet->getColumnDimension($cell)->setAutoSize(true);
          foreach( range('G','K') as $cell )
            $sheet->getColumnDimension($cell)->setAutoSize(true);
          $sheet->getColumnDimension('F')->setWidth(40);
        }
        else{
          foreach( range('A','H') as $cell )
            $sheet->getColumnDimension($cell)->setAutoSize(true);
          foreach( range('J','K') as $cell )
            $sheet->getColumnDimension($cell)->setAutoSize(true);
          $sheet->getColumnDimension('I')->setWidth(40);
        }
        // foreach( range('A','I') as $cell )
        //   $sheet->getColumnDimension($cell)->setAutoSize(true);

        /* Save file */
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        try {
          $fileName = 'Reporte-'.$teacherName.'-'.date('d-m-Y-i:s');
          //   $writer->save('export.xlsx');
         //
         header('Content-Type: application/vnd.ms-excel');
         header('Content-Disposition: attachment; filename="'.$fileName.'.xlsx"');
         $writer->save("php://output");
          exit;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
      }
      /**
       * [generateReportPDF description]
       * @param  [type] $values [description]
       * @return [type]         [description]
       */
      public function generateReportPDF($values){
        /*get report type*/
         if($values['code'] != 'null' AND $values['subject'] != 0)
           $reportType = 'materia'; //reporte type
         if($values['code'] != 'null' AND $values['subject'] == 0)
           $reportType = 'docente'; //reporte type
         if($values['code'] == 'null' AND $values['subject'] == 0)
           $reportType = 'general'; //reporte type
        $subject = $values['subject'];
        $extension = iconv('UTF-8', 'ISO-8859-2',$this->getExtensionName($values['extension']));
        // $extension = $this->getExtensionName($values['extension']);
        $reports = $this->getReports($values); //get report and cover to array
        $hoursCount = 0;
        $teacherName = iconv('UTF-8', 'ISO-8859-2', $reports[0]['nameTeacher']);
        // $teacherName = $reports[0]['nameTeacher'];
        if($values['week'] != 'null')
          $period = 'Periodo del 2019 '.$this->dataBetween($values['week']);
        else
          $period = 'Periodo del 2019 personalizado del '.date("d-m-Y",
          strtotime($values['startDate'])).' al '.date("d-m-Y",strtotime($values['endDate']));

        if($reportType != 'general'){
          $value = ['code' => $values['code']];
          $teacher = json_decode($this->getFirst('view_reports','WHERE codeTeacher =:code',$value));
          $dep = $teacher->alias;
          $sbName = '';
          if($reportType == 'materia'){
            $sb = ['code'=>$values['subject']];
            $subjectName = json_decode($this->getFirst('viewsbName','WHERE idSubjectlist =:code',$sb));
            $sbName = $subjectName->name;
          }
          $data = [
            'subject' => $subject,
            'extension' => $extension,
            'teacherName' => $teacherName,
            'period' => $period,
            'dep' => $dep,
            'subjectName' => $sbName
          ];
        }
        else{
          $data = [
            'extension' => $extension,
            'period' => $period
          ];
        }

        $pdf = new FPDF('L','mm','A4',$reportType,$data);
        $pdf->AliasNbPages();
        $pdf->AddPage(); //addpage
        /*Table report type docente or materia*/
        if($reportType != 'general'){
          foreach ($reports as $row) {
            $str  = $row['topic'];
            $charCount = round(strlen($str)/53) + 1;
            $height = ($charCount * 4);
            $multiSize = 8;
            $pdf->Cell(16,$height,$row['checkEntry'],1,0,'C',0);
            $pdf->Cell(16,$height,$row['checkEnd'],1,0,'C',0);
            $pdf->Cell(20,$height,$row['grade'],1,0,'C',0);
            $pdf->Cell(20,$height,$row['type'],1,0,'C',0);
            // $note = iconv('UTF-8', $row['notes'], $note); //encoding utf-8
            $note = iconv('UTF-8', 'ISO-8859-2',  $row['notes']);
            $pdf->Cell(40,$height,$note,1,0,'C',0);
            $topic = iconv('UTF-8', 'ISO-8859-2',  $row['topic']);
            // $topic .='                     xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx                                                                                                                                                                                                                                                                                                 ';
            $pdf->MultiCell(80,$multiSize,$topic,1,'LRB');
            if($reportType != 'materia'){
              // $sb = iconv('UTF-8', $row['nameSubject'], $sb); //encoding utf-8
            //  $sb = iconv('UTF-8', 'ISO-8859-2',  $row['nameSubject']);
              // $sb = 'subject';
              $posY = $pdf->getY();
              $pdf->setY($pdf->getY() - $height);
              $pdf->setX(202);
              $pdf->Cell(55,$height,$row['code'],1,0,'C',0);
              $pdf->setY($posY);
              $pX = 257;
              // $pdf->Cell(55,6,$row['nameSubject'],1,0,'C',0);
            }
            else
              $pX = 202;
            $stTime = strtotime($row['checkEntry']);
            $enTime = strtotime($row['checkEnd']);
            $total = round((abs($stTime-$enTime) / 60)/50);
            $posY = $pdf->getY();
            $pdf->setY($pdf->getY() - $height);
            $pdf->SetX($pX);
            $pdf->Cell(30,$height,$total,1,0,'C',0);
            $pdf->setY($posY);
            // break;
            }
        }
        else{
            foreach ($reports as $row) {
              $str  = $row['nameTeacher'];
              $charCount = round(strlen($str)/27);
              $height = $charCount * 4;
              $multiSize = 4;
              if(strlen($str) <= 78)
                $str .= '  ';
              $pdf->Cell(15,$height,$row['alias'],1,0,'C',0);
              $teacher = iconv('UTF-8', 'ISO-8859-2', $row['nameTeacher']);
              $pdf->MultiCell(55,4,$teacher,1,'LRB');
              $posY = $pdf->getY();
              $pdf->setY($pdf->getY() - $height);
              $pdf->setX(80);
              $pdf->Cell(16,$height,$row['checkEntry'],1,0,'C',0);
              $pdf->Cell(16,$height,$row['checkEnd'],1,0,'C',0);
              $pdf->Cell(20,$height,$row['grade'],1,0,'C',0);
              $pdf->Cell(20,$height,$row['type'],1,0,'C',0);
              $note = iconv('UTF-8', 'ISO-8859-2',  $row['notes']);
              $pdf->Cell(30,$height,$note,1,0,'C',0);
              $topic = iconv('UTF-8', 'ISO-8859-2',$row['topic'].'ddseadadadadeadadadead');
              // $pdf->MultiCell(55,$multiSize,$topic,1,'LRB');
              $pdf->setY($posY);
              $posY = $pdf->getY();
              $pdf->setY($pdf->getY() - $height);
              $pdf->setX(182);
              // $sb = iconv('UTF-8', 'ISO-8859-2',  $row['nameSubject']);
              $pdf->Cell(45,$height,$row['code'],1,0,'C',0);
              $stTime = strtotime($row['checkEntry']);
              $enTime = strtotime($row['checkEnd']);
              $total = round((abs($stTime-$enTime) / 60)/50);
              // $posY = $pdf->getY();
              // $pdf->setY($pdf->getY() - $height);
              // $pdf->setX(259);
              $pdf->Cell(25,$height,$total,1,1,'C',0);
              break;
            }
}
         $this->closeConnection(); //close conection
         $pdf->Output('reporte- '.$reportType.'-'.date('d-m-Y-i:s').'.pdf','I');
         function Footer() {
          $pdf->SetY(-1);
          $pdf->SetFont('Arial','I',8);
          $pdf->Cell(0,10,'Pagina '.$pdf->pageNo(),0,0,'C');
         }
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
    /**
     * [dataBetween description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
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
          $date = 'Quincenal del '.$startDate.' al '.$dt->format('d-m-Y');
          break;

        case 'month':
          $startDate = strtotime ('-1 month' ,strtotime($dt->format('d-m-Y')));
          $startDate = date('d-m-Y',$startDate);
          $date = 'Mensual del '.$startDate.' al '.$dt->format('d-m-Y');
          break;
      }
      return $date;
    }
    /**
     * [getDatetimeNow description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
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
