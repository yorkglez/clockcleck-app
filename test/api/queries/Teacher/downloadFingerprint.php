<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');

  $fileName = $_GET['id'];
  $teacher = new Teacher;
  $resp = $teacher->getFingerfile($fileName);
  echo $resp;
?>
