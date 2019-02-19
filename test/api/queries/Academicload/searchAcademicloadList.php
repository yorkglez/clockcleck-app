<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/AcademicLoad.php');
  /**/
  $ter = $_GET['ter'];
  $extension = $_GET['extension'];
  $academicLoad = new AcademicLoad;
  $resp = $academicLoad->searchAcademicloadList($ter,$extension);
  echo $resp;

?>
