<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');

  $fileName = $_GET['fileName'];
  $teacher = new Teacher;
  $resp = $teacher->getFingerfile($fileName);
  echo $resp;
?>
