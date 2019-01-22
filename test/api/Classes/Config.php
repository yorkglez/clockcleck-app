<?php
  /**
   *
   */
  require_once('Connection.php');
  class Config extends Connection
  {
    /**
     * [getConfig description]
     * @return [type] [description]
     */
    public function getConfig(){
      $sql = "SELECT * FROM Config ORDER BY idConfig DESC LIMIT 1";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return  json_encode($row);
    }
    /**
     * [Update description]
     * @param [type] $values [description]
     */
    public function Update($values){
      $sql = "UPDATE Config SET durationModule = :durationModule , startTime = :startTime, endTime = :endTime,
      sbreakTime = :sbreakTime, ebreakTime = :ebreakTime, durationBreak = :durationBreak WHERE idConfig = :id";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return json_encode($resp);
    }

    public function Save($values){
      $sql = "INSERT INTO Config (durationModule, startTime, endTime, sbreakTime, ebreakTime, durationBreak, year)
      VALUES (:durationModule, :startTime, :endTime, :sbreakTime, :ebreakTime, :durationBreak, year(now()) ) ";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return json_encode($resp);
    }
  }



 ?>
