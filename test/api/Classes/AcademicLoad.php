<?php
/**
 *
 */
 require_once('Connection.php');
session_start();
class AcademicLoad extends Connection
{
  public function assingSubjectTeacher($data){
   foreach ($data as $value) {
      $resp = false;
      $grade =  $value->semester;
      if(isset($value->objetive))
        $objetive =  $value->objetive;
      else
        $objetive = 'nu';
      $codeTeacher  =  $_SESSION['code'];
      $subject =  $value->codeSubject;
      $startTime =  $value->startTime;
      $endTime =  $value->endTime;
      $day =  $value->day;
      $codeCarer = $value->codeCarer;

      $sql =  "call AssingSubject (:grade,:objetive,:codeTeacher,:subject,:startTime,:endTime,:day,:codeCarer)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':grade',$grade);
      $stmt->bindParam(':objetive',$objetive);
      $stmt->bindParam(':codeTeacher',$codeTeacher, PDO::PARAM_STR);
      $stmt->bindParam(':subject',$subject);
      $stmt->bindParam(':startTime',$startTime);
      $stmt->bindParam(':endTime',$endTime);
      $stmt->bindParam(':day',$day);
      $stmt->bindParam(':codeCarer',$codeCarer);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
   }
    return  json_encode($resp);
  }
  /**
   * [getAcademicloadTeacher description]
   * @return [type] [description]
   */
  public function getAcademicloadTeacher(){
    $code =  $_SESSION['id'];
    $fetch = array();
    $sql = "SELECT * FROM ViewAcademicloadTc WHERE codeTeacher = :code";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':code',$code, PDO::PARAM_STR);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $fetch[] = $row;
    $this->closeConnection();
    return json_encode($fetch);
  }
  /**
   * [updateSubjectlist description]
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function updateSubjectlist($data){
  //  print_r($data);
    foreach ($data as $ac) {
      $resp = false;
      /*Update subjectlist*/
      if(isset($ac->idSubjectlist)){
        $sql = "CALL updateSubjectlist(:semester,:objetive,:codeSubject,:startTime,:endTime,:day,:codeCarer,:idSubjectlist,:idSchedule)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':idSubjectlist',$ac->idSubjectlist, PDO::PARAM_INT);
        $stmt->bindParam(':idSchedule',$ac->idSchedule, PDO::PARAM_INT);
      }

      /*Create subjectlist*/
      else{
          $codeTeacher  =  $_SESSION['id'];
          $sql = "call AssingSubject (:semester,:objetive,:codeTeacher,:codeSubject,:startTime,:endTime,:day,:codeCarer)";
          $stmt = $this->connect()->prepare($sql);
          $stmt->bindParam(':codeTeacher',$codeTeacher, PDO::PARAM_STR);
      }
      $stmt->bindParam(':semester',$ac->semester, PDO::PARAM_STR);
      $stmt->bindParam(':objetive',$ac->objetive, PDO::PARAM_STR);
      $stmt->bindParam(':codeSubject',$ac->codeSubject, PDO::PARAM_STR);
      $stmt->bindParam(':startTime',$ac->startTime, PDO::PARAM_STR);
      $stmt->bindParam(':endTime',$ac->endTime, PDO::PARAM_STR);
      $stmt->bindParam(':day',$ac->day, PDO::PARAM_STR);
      $stmt->bindParam(':codeCarer',$ac->codeCarer, PDO::PARAM_STR);
      if($stmt->execute())
        $resp = true;
      $this->closeConnection();
    }
    return json_encode($resp);
  }
  public function getAcademicloadList(){
    $sql = "SELECT * FROM ViewAcademicloadList";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $fetch[] = $row;
    }
    else
      $fetch = false;
    $this->closeConnection();
    return json_encode($fetch);
  }
  public function searchAcademicloadList($ter,$extension){
    $sql = "SELECT * FROM ViewAcademicloadList WHERE (codeTeacher LIKE concat(:ter,'%') OR teacherName LIKE concat(:ter,'%')) AND extension = :extension";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':ter',$ter,PDO::PARAM_STR);
    $stmt->bindParam(':extension',$extension,PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          $fetch[] = $row;
    }
    else
      $fetch = false;
    $this->closeConnection();
    return  json_encode($fetch);
  }
  /**
   * [This function delete the subject in database]
   * @param [int] $id [id subjectlist]
   */
  public function Remove($id){
    $sql ="CALL deleteSubjectList(:id)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    if($stmt->execute())
      $resp = true;
    else
      $resp = false;
    $this->closeConnection();
    return json_encode($resp);
  }
}


 ?>
