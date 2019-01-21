<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Auth.php');
  /**/
  $auth = new Auth;
  $resp = $auth->getUserInfo();
  echo $resp;
 ?>
