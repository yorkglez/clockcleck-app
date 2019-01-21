<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Teacher.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));

  $values = [
    'oldCode' => $data->oldCode,
    'code' => $data->code,
    'name' => $data->name,
    'lastname' => $data->lastname,
    'type' => $data->type,
    'fingerRoute'=> $data->fingerRoute,
    'email' => $data->email,
    'phone' => $data->phone,
    'genere' => $data->genere,
    'fingerRoute'=>$data->fingerRoute,
    'extension' => $data->extension,
    'app'=>$data->app
  ];
  //  print_r($values);
  $teacher = new Teacher;
  $resp = $teacher->updateTeacherDesk($values);
  echo $resp;
?>
