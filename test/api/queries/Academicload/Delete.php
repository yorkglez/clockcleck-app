<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/AcademicLoad.php');
  /**/
  $id = json_decode(file_get_contents("php://input",true));
  $academicLoad = new AcademicLoad;
  $resp = $academicLoad->Remove($id);
  echo $resp;

?>
