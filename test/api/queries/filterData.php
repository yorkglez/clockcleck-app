<?php

  function filterData($sql,$dbh,$type,$table){
    try {
      if(!$type ==''){
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':type',$type);
      }else{
          $sql = 'SELECT * FROM '.$table;
          $stmt = $dbh->prepare($sql);
      }
      $stmt->execute();
      $fetch = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $fetch[] = $row;
      }
      echo json_encode($fetch);
    } catch (\Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
    $dbh = null; //Close db conection
  }

?>
