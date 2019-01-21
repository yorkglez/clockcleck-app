<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/Config.php');
 /*Call Class Operations*/
 $config = new Config;
 $data = $config->getConfig(); //Get data from database
 echo $data; //Send data in json to frontend
 ?>
