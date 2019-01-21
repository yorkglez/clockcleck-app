<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Extension.php');
  /**/
  $extension = new Extension;
  $resp = $extension->getExtension();
  echo $resp;
?>
