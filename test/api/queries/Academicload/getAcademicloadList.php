<?php
  /*Includes*/
  require('../../Headers.php');
  require('../../Classes/AcademicLoad.php');
  /**/

  $academicLoad = new AcademicLoad;
  $resp = $academicLoad->getAcademicloadList();
  echo $resp;

?>
