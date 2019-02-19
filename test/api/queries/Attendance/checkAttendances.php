<?php
    /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Attendance.php');
   $data = json_decode(file_get_contents("php://input",true));
   $values = [
     'checkEntry' => $data->checkEntry,
     'checkEnd' => $data->checkEnd,
     'topic' => $data->topic,
     'idSubjectlist' => $data->idSubjectlist,
     'idSchedule' => $data->idSchedule,
     'date_At' => $data->date_At,
     'tp' => $data->tp
   ];

   /*Call Class Operations*/
   $teacher = new Attendance;

   $resp = $teacher->createAttendance($values); //Get data from database
   echo $resp; //Send data in json to frontend
 ?>
