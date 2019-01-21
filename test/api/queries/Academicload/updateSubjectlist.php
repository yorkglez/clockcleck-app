<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/AcademicLoad.php');
  /**/
  $data = json_decode(file_get_contents("php://input",true));

  $academicLoad = new AcademicLoad;
 $resp = $academicLoad->updateSubjectlist($data);
 echo $resp;

?>
