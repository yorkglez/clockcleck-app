<?php
  function saveData($sql, $values,$dbh){
    $res = false;
    try {
       $stmt = $dbh->prepare($sql);
       $stmt->execute($values);
       $res = true;
       echo json_encode(array('resp'=>$res));
    } catch (\Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
    }
  }

 ?>
