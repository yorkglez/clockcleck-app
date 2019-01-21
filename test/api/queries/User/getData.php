<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/User.php');
 /*Call Class users*/
 $user = new User;
 $data = $user->getData(); //Get data from database
 echo $data; //Send data in json to frontend
 ?>
