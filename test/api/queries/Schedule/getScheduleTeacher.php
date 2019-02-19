<?php
  session_start();
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Schedule.php');
  /**/
  $code = $_SESSION['id'];

  $schedule = new Schedule;
  $resp = $schedule->getScheduleTeacher($code);
  echo $resp;
?>
