<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Teacher.php');
  /**/
  $values = json_decode(file_get_contents("php://input",true));

  $teacher = new Teacher;
  $resp = $teacher->updatePorfile($values);
  echo $resp;
?>
