<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Report.php');



   // $extension = $_GET['extension'];
   // $week =  $_GET['week'];
   // $startDate =  $_GET['startDate'];
   // $endDate =  $_GET['endDate'];
   // $code = $_GET['codeTeacher'];
   // $subject =  $_GET['subject'];

   // $extension = '1';
   // $week =  'month';
   // $startDate =  'null';
   // $endDate =  'null';
   // $code = '1414';
   // $carer =  '';
   //
   $extension = '1';
   $week =  'week';
   $startDate =  'null';
   $endDate =  'null';
   $code = '1414';
   $carer =  '';
   $subject = 50;
   //
   $values = [
      'week' => $week,
     'ter' => '',
     'startDate' => $startDate,
     'endDate' => $endDate,
     'code' =>$code,
     'extension'=>$extension,
     'subject'=>$subject,
   ];
  $report= new Report;
  $report->generateReportPDF($values);

 ?>
