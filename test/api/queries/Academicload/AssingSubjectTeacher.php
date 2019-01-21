<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/AcademicLoad.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));
//  print_r($data[0]);
  $academicLoad = new AcademicLoad;
  $resp = $academicLoad->assingSubjectTeacher($data);
  echo $resp;

?>
