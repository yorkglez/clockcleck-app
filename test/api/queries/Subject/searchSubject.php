<?php
  /*Includes*/
 require('../../Headers.php');
 require('../../Classes/Connection.php');
 require('../../Classes/Subject.php');
 /**/
 $ter = $_GET['ter'];
 $type = $_GET['type'];
 /*Call Class Subject*/
 $subject = new Subject;
 $resp = $subject->searchSubject($ter,$type); //Get data from database
 echo $resp; //Send data in json to frontend
 ?>
