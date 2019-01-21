<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/User.php');
 /**/
 $ter = $_GET['ter'];
 $type = $_GET['type'];
 /*Call Class users*/
 $user = new User;
 $resp = $user->searchUser($ter,$type); //Get data from database
 echo $resp; //Send data in json to frontend
 ?>
