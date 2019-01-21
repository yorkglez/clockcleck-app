<?php
  /*Includes*/
  require('../conection.php');
  include('../Headers.php');

  $data = json_decode(file_get_contents("php://input",true));
  $sql = 'DELETE FROM '.$data->table.' WHERE idUser = :id';
  $id = $data->id;
  $res = false;
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    $res = true;
  } catch (\Exception $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
  }


  echo json_encode(array('resp'=>$res));

 ?>
