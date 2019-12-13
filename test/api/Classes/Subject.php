<?php
  /**
   *
   */
  require_once('Connection.php');
  class Subject extends Connection
  {
    /**
     * [getSubjects description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function getSubjects($values){
      return $this->Call('getSubjects',$values, true);
    }
    public function getSubject($id){
      $sql = "SELECT * FROM Subjects WHERE codeSubject = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $subjects[] = [
        'codeSubject'=>$row['codeSubject'],
        'name'=>$row['name'],
        'credits'=>$row['credits'],
        'sequence'=>$row['sequence']
      ];
      $this->closeConnection();

      $sql = "SELECT * FROM viewgetSubjectsSquence WHERE Subjects_codeSubject = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $subjects[] = [
        'codeSubject'=>$row['codeSubject'],
        'name'=>$row['name'],
        'credits'=>$row['credits']
      ];
      $id = $row['codeSubject'];
      $this->closeConnection();

      while (true) {
        $sql = "SELECT * FROM viewgetSubjectsSquence WHERE Subjects_codeSubject = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $subjects[] = [
            'codeSubject'=>$row['codeSubject'],
            'name'=>$row['name'],
            'credits'=>$row['credits']
          ];
          $id = $row['codeSubject'];
        }
        else
          break;
        $this->closeConnection();
      }
      return  json_encode($subjects);
    }
    /**
     * [addSubject description]
     * @param [type] $values [description]
     */
    public function addSubject($values){
      $resp = false;
      $sql = "INSERT INTO Subjects (codeSubject,name,credits,sequence,status) VALUES (:codeSubject,:name,:credits,'0','1')";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':codeSubject',$values->code);
      $stmt->bindParam(':name',$values->name);
      $stmt->bindParam(':credits',$values->credits);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    /**
     * [searchSubject description]
     * @param  [type] $ter  [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function searchSubject($ter,$type){
      $sql = "CALL searchSubject(:ter,:sequence)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':ter',$ter);
      $stmt->bindParam(':sequence',$type);
      $stmt->execute();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          $fetch[] = $row;
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**
     * [addSubjectSequence description]
     * @param [type] $model [description]
     */
    public function addSubjectSequence($model){
        $count = 0;
        $resp = false;
        $sql = "INSERT INTO Subjects (codeSubject,name,credits,sequence,status) VALUES (:codeSubject,:name,:credits,'1','1')";
        $stmt = $this->connect()->prepare($sql);
        foreach ($model as $data) {
            $stmt->bindParam(':codeSubject',$data->code);
            $stmt->bindParam(':name',$data->name);
            $stmt->bindParam(':credits',$data->credits);
            if($stmt->execute())
              $resp = true;
            else
              $resp = false;
            $count = $count + 1;
        }
        $this->closeConnection();
        $sql = "INSERT INTO Sequences (Subjects_codeSubject,Subjects_codeSubject1) VALUES (:code1,:code2)";
        $stmt = $this->connect()->prepare($sql);
        $x = 0;
        for ($i =0; $i <$count-1; $i++) {
            $code1 = $model[$x]->code;
            $code2 = $model[($x+1)]->code;
            $stmt->bindParam(':code1',$code1);
            $stmt->bindParam(':code2',$code2);
            if($stmt->execute())
              $resp = true;
            else
              $resp = false;
            $x = $x + 1;
        }
        $this->closeConnection();
        return json_encode($resp);
    }
    /**/
    public function getSubjectsList(){
      session_start();
      $code = $_SESSION['id'];
      $sql = "SELECT s.codeSubject, s.name FROM Subjects s WHERE s.status = '1'";
      // $sql = "SELECT s.codeSubject, s.name FROM Subjects s WHERE s.codeSubject NOT IN (SELECT sl.Subjects_codeSubject FROM Subjects_list sl WHERE Teachers_codeTeacher = :code) AND s.status = '1'";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $fetch[] = $row;
      $this->closeConnection();
      return  json_encode($fetch);
    }
    public function getSubjectsListTeacher($code){
      $values = ['code' => $code];
      return $this->getData('viewgetsubjectsteacher_report','WHERE codeTeacher = :code',$values);
    }
    /**
     * [changeStatus description]
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function changeStatus($id,$status){
      $resp = false;
      $sql ="UPDATE Subjects SET status = :status WHERE codeSubject = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':status',$status,PDO::PARAM_STR);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    /**
     * [validateCode description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function validateCode($code){
      $sql = "SELECT codeSubject FROM Subjects WHERE codeSubject = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = false;
      else
        $resp = true;
      $this->closeConnection();
      return  json_encode($resp);
    }

    public function updateSubject($values){
      $sql ="UPDATE Subjects SET name = :name, credits = :credits, codeSubject = :newcode WHERE codeSubject = :oldcode";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return json_encode($resp);
    }
    public function removeSquence($code){
      $sql = "CALL deleteSquences(:code)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      if ($stmt->execute())
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return  json_encode($resp);
    }
  }


 ?>
