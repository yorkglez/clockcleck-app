<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Subject.php');
  $code = $_GET['code'];
  $subject = new Subject;
  $resp = $subject->getSubjectsListTeacher($code);
  echo $resp;
?>
