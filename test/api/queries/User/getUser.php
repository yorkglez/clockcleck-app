<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/User.php');
  /**/
  $id = $_GET['id'];
  $user = new User;
  $resp = $user->getUser($id);
  echo $resp;
?>
