<?php
  /**
   *
   */
  require_once('Connection.php');
  class Config extends Connection
  {

    function getConfig(){
      $sql = "SELECT durationModule, startTime, endTime, sbreakTime, ebreakTime, durationBreak FROM Config ORDER BY idConfig DESC LIMIT 1";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return  json_encode($row);

    }
  }



 ?>
