<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/User.php');

  /*Call Class users*/
  $type = $_GET['type'];
  $user = new User;
  $resp =   $user->getUserForType($type);
  echo $resp;

 ?>
