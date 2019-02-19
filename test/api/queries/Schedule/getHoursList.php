<?php

  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Schedule.php');
  /**/
  $schedule = new Schedule;
  $resp = $schedule->getHoursList();
  echo $resp;
?>
