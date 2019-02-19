<?php
/*Includes*/
require('../../Headers.php');
require('../../Classes/Teacher.php');
/**/
$ter = $_GET['ter'];
$type = $_GET['type'];
$extension = $_GET['extension'];

/*Call Class users*/
$teacher = new Teacher;
$resp = $teacher->searchTeacher($ter,$type,$extension); //Get data from database
echo $resp; //Send data in json to frontend
 ?>
