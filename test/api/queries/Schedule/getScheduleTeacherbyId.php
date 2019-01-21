<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Schedule.php');
  /**/
  $code = $_GET['code'];
  $schedule = new Schedule;
  $resp = $schedule->getScheduleTeacher($code);
  echo $resp;
?>
