<?php
  /*Includes*/
  include('../Headers.php');
  require('../conection.php');

  $table = $_GET['table'];// Get url data
  $text =  $_GET['text'];// Get url data
  $type =  $_GET['type'];// Get url data

 /*Select data for database*/
if ($type == 'admin' || $type == 'normal') {
   $sql = "SELECT * FROM ".$table." WHERE (name LIKE '".$text."%' OR lastname LIKE  '".$text."%' OR email LIKE '".$text."%') AND type = '".$type."'";
 }else{
   $sql = "SELECT * FROM ".$table." WHERE name LIKE '".$text."%' OR lastname LIKE  '".$text."%' OR email LIKE '".$text."%'";
 }

 try{
   $stmt = $dbh->prepare($sql);
   $stmt->execute();
  if($stmt->rowCount() > 0){
    $fetch = array();
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
         $fetch[] = $row;
     }
     echo json_encode($fetch);
   }
   else{
     echo '{"null":  true}';
   }
 } catch (\Exception $e) {
     print "Error!: " . $e->getMessage() . "<br/>";
 }

 $dbh = null; //Close db conection
 ?>
