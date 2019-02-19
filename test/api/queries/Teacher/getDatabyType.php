<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Teacher.php');

  /*Call Class users*/
  $type = $_GET['type'];
  $teacher = new Teacher;
  $resp =   $teacher->getTeacherForType($type);
  echo $resp;
 ?>
