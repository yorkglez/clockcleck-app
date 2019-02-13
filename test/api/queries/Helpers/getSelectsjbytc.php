<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/Connection.php');
  require('../../Classes/Helpers.php');
  $date =  $_GET['date'];
  $code =  $_GET['code'];

  /*Call Class Teacher*/
  $helper= new Helpers;
  $resp = $helper->getSelectsjbytc($date,$code = '1414' );
  echo $resp; //Send data in json to frontend

?>
