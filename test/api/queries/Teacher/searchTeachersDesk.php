<?php
/*Includes*/
require('../../Headers.php');
require('../../Classes/Teacher.php');
/**/
$ter = $_GET['ter'];
$extension = $_GET['extension'];
/*Call Class users*/
$teacher = new Teacher;
$resp = $teacher->searchTeachersDesk($ter,$extension); //Get data from database
echo $resp; //Send data in json to frontend
 ?>
