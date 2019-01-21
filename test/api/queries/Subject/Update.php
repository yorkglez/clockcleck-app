<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Subject.php');

  $data = json_decode(file_get_contents("php://input",true)); //Get id
  $values = [
    'newcode'=> $data->model->code,
    'name'=> $data->model->name,
    'credits'=>$data->model->credits,
    'oldcode'=>$data->id
  ];

  $subject = new Subject;
  $resp = $subject->Update($values); //Get data from database
  echo $resp; //Send data in json to frontend

 ?>
