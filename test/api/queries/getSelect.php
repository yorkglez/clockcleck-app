<?php
  /*This function get data*/
  function getData($stmt){
    $stmt->execute();
    $fetch = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $fetch[] = $row;
    }
    echo json_encode($fetch);
  }

?>
