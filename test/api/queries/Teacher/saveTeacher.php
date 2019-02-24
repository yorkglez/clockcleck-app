<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');
  /**/
  // $data = json_decode(file_get_contents("php://input",true));
  //
  $values = [
    'code' => $data->code,
    'name' => $data->name,
    'lastname' => $data->lastname,
    'type' => $data->type,
    'password'=> '123456',
    'email' => $data->email,
    'phone' => $data->phone,
    'genere' => $data->genere,
    'fingerRoute'=>$data->fingerRoute,
    'extension' => $data->extension,
    'token' => ''
  ];
  // $values = [
  //   'code' => '',
  //   'name' => '',
  //   'lastname' => '',
  //   'type' => '$data->type',
  //   'password'=> '123456',
  //   'email' => 'email@email.com',
  //   'phone' => '$data->phone',
  //   'genere' => '$data->genere',
  //   'fingerRoute'=>'$data->fingerRoute',
  //   'extension' => '$data->extension',
  //   'token' => ''
  // ];
//  echo $values['email'];
  //  print_r($values);
  $teacher = new Teacher;
   $resp = $teacher->saveTeacher($values);
  echo $resp;
?>
