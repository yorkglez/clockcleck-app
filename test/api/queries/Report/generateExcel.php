<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Report.php');
   $week =  $_GET['week'];
   $startDate =  $_GET['startDate'];
   $endDate =  $_GET['endDate'];
   $code = $_GET['codeTeacher'];
   $extension = $_GET['extension'];
   $subject =  $_GET['subject'];

   // TEMP:
   // $extension = '1';
   // $week =  'week';
   // $startDate =  'null';
   // $endDate =  'null';
   // $code = '1414';
   // $carer =  '';
   // $subject = 50;
   //
   if($subject == 'null')
    $subject = 0;
   $values = [
     'week' => $week,
     'ter' => '',
     'startDate' => $startDate,
     'endDate' => $endDate,
     'code' =>$code ,
     'extension'=>$extension,
     'subject'=> $subject 
   ];
  $report= new Report;
  $report->generateReportExcel($values);

 ?>
