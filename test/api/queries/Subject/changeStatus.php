<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Subject.php');

  $data = json_decode(file_get_contents("php://input",true)); //Get id
  $id = $data->id;
  $status = $data->status;
  /*Call Class Teacher*/
  $subject = new Subject;

  $resp = $subject->changeStatus($id,$status); //Get data from database
  echo $resp; //Send data in json to frontend

 ?>
