<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Subject.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
  $sequence = $data->sequence;
  $subject = new Subject;
  $model = json_decode($data->model);
  if($sequence){
    $resp = $subject->addSubjectSequence($model);
  }
  else{
    $resp = $subject->addSubject($model[0]);
  }
  echo $resp;

?>
