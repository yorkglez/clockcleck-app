<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Report.php');
 // echo $_GET['week'];// Get url data
 /*Call Class Report*/
 $report= new Report;
 $data = json_decode(file_get_contents("php://input",true));

 $values = [
   'week' => $data->week,
   'ter' => $data->search,
   'startDate' => $data->startDate,
   'endDate' => $data->endDate,
   'code' =>$code =  isset($data->teachersSelect)? $data->teachersSelect: 'null',
   'extension'=>$data->extension,
   'subject'=>isset($data->subjectCode)? $data->subjectCode: 0
 ];
 // $values = [
 //   'week' => 'day',
 //   'ter' => '',
 //   'startDate' => 'null',
 //   'endDate' => 'null',
 //   'code' =>'1414',
 //   'extension'=>1,
 //   'subject'=>isset($data->subjectCode)? $data->subjectCode: 0
 // ];
 $resp = $report->getReports($values); //Get data from database
 echo json_encode($resp); //Send data in json to frontend
 ?>
