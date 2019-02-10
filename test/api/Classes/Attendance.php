<?php
  /**
   *
   */
  require_once('Connection.php');
  class Attendance extends Connection
  {
    public function createAttendance($values){
      $resp = false;
      // $sql = "INSERT INTO Attendances (idAttendance, type, date_At, checkEntry,checkEnd,topic, Subjects_list_idSubjectlist, Schedule_idSchedule)
      // VALUES (0,'presente','2018-29-11','7:00','7:00','text',43,55)";
      // $sql = "INSERT INTO Attendances (idAttendance, type, date_At, checkEntry,checkEnd,topic, Subjects_list_idSubjectlist, Schedule_idSchedule)
      // VALUES (0,'presente',:date_At,:checkEntry,:checkEnd,:topic,:idSubjectlist,:idSchedule)";
  //    if($values['checkEntry'])

        $sql = "CALL createAttendance('lunes',:date_At,:checkEntry,:checkEnd,:topic,:idSubjectlist,:idSchedule,:tp)";

        //$sql = "CALL createAttendance('lunes',date(now()),'',:checkEnd,:topic,:idSubjectlist,:idSchedule,'end')";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    /**
     * [aveChanges description]
     * @param  [type] $id   [description]
     * @param  [type] $note [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function saveChanges($id,$note,$type){
      $resp = false;
      $sql = "UPDATE Attendances SET notes =:note, type = :type WHERE idAttendance = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam('note',$note,PDO::PARAM_STR);
      $stmt->bindParam('type',$type,PDO::PARAM_STR);
      $stmt->bindParam('id',$id,PDO::PARAM_INT);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    public function check(){
      $resp = false;
      /*Get ids checks of today*/
      $sql = "SELECT Subjects_list_idSubjectlist FROM  Attendances WHERE date_At = date('2018-11-16')";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $idS[] = $row['Subjects_list_idSubjectlist'];
        }
        $this->closeConnection();
        /*Get ids don't checks of today*/

        // $sql = "SELECT sl.idSubjectlist FROM Subjects_list sl
        //       INNER JOIN Schedule s ON s.Subjects_list_idSubjectlist = sl.idSubjectlist
        //       WHERE sl.idSubjectlist NOT IN ".'('.implode(', ',$idS).')'." AND s.day = 'lunes'";

                /*Temp*/
        $sql = "SELECT sl.idSubjectlist, s.idSchedule FROM Subjects_list sl
                INNER JOIN Schedule s ON s.Subjects_list_idSubjectlist = sl.idSubjectlist
                WHERE sl.idSubjectlist NOT IN (5) AND s.day = 'lunes'";
        $stmt = $this->connect()->prepare($sql);
        //$stmt->bindParam(':day','lunes');
        $stmt->execute();

        if($stmt->rowCount() > 0){

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              $idSnot[] = $row;
          }
          $this->closeConnection();

        /*Create check of subjects without check*/
         foreach ($idSnot as $item) {
           $sql = "INSERT INTO Attendances (idAttendance, type, date_At, notes, Subjects_list_idSubjectlist, Schedule_idSchedule)
           VALUES (0,'ausente',date(now()),'No realizo su chequeo.',:idsl, :idsc)";
           $stmt = $this->connect()->prepare($sql);
           $stmt->bindParam(':idsl',$item['idSubjectlist'],PDO::PARAM_INT);
           $stmt->bindParam(':idsc',$item['idSchedule'],PDO::PARAM_INT);
           $stmt->execute();
           echo 'ej';
           $this->closeConnection();
         }
        }
        $resp = true;
      }
    //  return  json_encode($resp);
    }
  }
 ?>
