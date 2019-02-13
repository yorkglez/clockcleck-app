<?php
  /**
   *
   */
  require_once('Connection.php');
  class Teacher extends Connection
  {
    /**
     * [getTeachers description]
     * @return [type] [description]
     */
    public function getTeachers($values){
      return $this->Call('getTeachers',$values,true);
      // $sql = "SELECT * FROM View_Teachers WHERE NOT status = '0'" ;
      // $stmt = $this->connect()
      // ->query($sql);
      // $fetch = array();
      // while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      //     $fetch[] = $row;
      // }
      // $this->closeConnection();
      // return  json_encode($fetch);
    }
    public function getTeacher($id){
      $values = ['id' => $id];
      return $this->getFirst('View_Teachers', "WHERE codeTeacher = :id", $values );
      // $sql = "SELECT * FROM View_Teachers WHERE codeTeacher = :id";
      // $stmt = $this->connect()->prepare($sql);
      // $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      // $stmt->execute();
      // $row = $stmt->fetch(PDO::FETCH_ASSOC);
      // $this->closeConnection();
      // return  json_encode($row);
    }
    public function getSelect($ex){
      $sql = "SELECT name,codeTeacher FROM Teachers WHERE Extensions_idExtension = :ex";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':ex',$ex,PDO::PARAM_INT);
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
     * [updatePorfile description]
     * @param  [type] $values [description]
     * @return [type]         [description]
     */
    public function updatePorfile($values){
      session_start();
      $id = $_SESSION['id'];
      $sql = "UPDATE Teachers SET name = :name, lastname = :lastname, email = :email phone = :phone WHERE codeTeacher = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->bindParam(':name',$values->name,PDO::PARAM_STR);
      $stmt->bindParam(':lastname',$values->lastname,PDO::PARAM_STR);
      $stmt->bindParam(':email',$values->email,PDO::PARAM_STR);
      if($stmt->execute())
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**
     * [changePorfile description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function changePorfile($data){
      session_start();
      $code = $_SESSION['code'];
      $resp = false;
      $sql = "UPDATE Teachers SET name = :name, lastname = :lastname, email = :email WHERE codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->bindParam(':name',$data->name,PDO::PARAM_STR);
      $stmt->bindParam(':lastname',$data->lastname,PDO::PARAM_STR);
      $stmt->bindParam(':email',$data->email,PDO::PARAM_STR);
      if ($stmt->execute())
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    /**
     * [validateEmail description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public function validateEmail($data){
      session_start();

        $code = $_SESSION['id'];
        $email = $data;




      $sql = "SELECT email FROM View_Teachers WHERE codeTeacher = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$code,PDO::PARAM_STR);
      $stmt->execute();
      $oldEmail = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      if($oldEmail['email'] == $email){
        $resp = true;
      }
      else{
        $sql = "SELECT email FROM View_Teachers WHERE email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0)
          $resp = false;
        else
          $resp = true;
        $this->closeConnection();
        $sql = "SELECT email FROM Users WHERE email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0)
          $resp = false;
        else
          $resp = true;
        $this->closeConnection();
      }
     return  json_encode($resp);
    }
    /**
     * [validateCode description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function validateCode($code){
      $sql = "SELECT codeTeacher FROM View_Teachers WHERE codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = true;
      else
        $resp = false;
      $this->closeConnection();
      return  json_encode($resp);
    }

    /**
     * [getinfoPorfile description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getinfoPorfile($code){
      $sql = "SELECT * FROM View_Teachers WHERE NOT status = '0' AND codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      return  json_encode($row);
    }

    /**
     * [getSubjectsList description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getSubjectsList($code){
      $sql = "SELECT * FROM viewgetsubjectsteacher WHERE codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $fetch[] = $row;
        }
      }

      else{
          $fetch = false;
      }
      $this->closeConnection();
      return  json_encode($fetch);
    }

    public function getSchedulelist($idsl, $code){
      $sql = "SELECT  at.Schedule_idSchedule  FROM attendances at
      INNER JOIN Subjects_list sl ON sl.idSubjectlist = at.Subjects_list_idSubjectlist
      WHERE sl.Teachers_codeTeacher = :code AND at.date_At = '2019-02-11' AND sl.idSubjectlist = :idsl";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':idsl',$idsl,PDO::PARAM_INT);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetchColumn())
          $ids[] = $row;
        $cad =  implode(',',$ids);
        $this->closeConnection();

        $sql = "SELECT idSchedule AS id, concat(startTime, ' - ', endTime) as hours FROM schedule
        WHERE idSchedule not in "."(".$cad.") AND Subjects_list_idSubjectlist = :idsl";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':idsl',$idsl,PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
        }
        else
          $fetch = false;
        $this->closeConnection();
      }
      else{
        $daynum = date("N", strtotime(date('l')));
        $sql = "SELECT idSchedule AS id, concat(startTime, ' - ', endTime) as hours FROM schedule
        WHERE Subjects_list_idSubjectlist = :idsl AND day = :day";
        $stmt->bindParam(':idsl',$idsl,PDO::PARAM_INT);
        $stmt->bindParam(':day',$daynum,PDO::PARAM_STR);
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $fetch[] = $row;
        }
        else
          $fetch = false;
        $this->closeConnection();
      }
      return  json_encode($fetch);



      // $sql = "CALL getScheduleList(:day,:id);";
      // $stmt = $this->connect()->prepare($sql);
      // $stmt->bindParam(':day',$day);
      // $stmt->bindParam(':id',$id);
      // $stmt->execute();
      // if($stmt->rowCount() > 0){
      //   while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      //       $fetch[] = $row;
      //   }
      // }
      // else{
      //   $fetch = false;
      // }
      //
      // $this->closeConnection();
      // return  json_encode($fetch);
    }
    /*Automatic download finger file*/
    public function getFingerfile($fileName){
      $path = 'C:/FingersServer/';
        $fingerRoute = $path.$fileName.".fpt";
        if (file_exists($fingerRoute)) {
            $mm_type="application/octet-stream";
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Type: " . $mm_type);
            header("Content-Length: " .(string)(filesize($fingerRoute)) );
            header('Content-Disposition: attachment; filename="'.basename($fingerRoute).'"');
            header("Content-Transfer-Encoding: binary\n");
            readfile($fingerRoute);
            exit();
        }
        else {
          print 'Sorry, we could not find requested download file.';
        }
    //  }

    }
    /**
     * [changePassword description]
     * @param  [type] $oldpassword [description]
     * @param  [type] $newpassword [description]
     * @return [type]              [description]
     */
     public function changePassword($oldPassword, $newPassword){
       session_start();
       $id = $_SESSION['id'];
       $sql = "SELECT password FROM Teachers WHERE codeTeacher = :id";
       $stmt = $this->connect()->prepare($sql);
       $stmt->bindParam(':id',$id,PDO::PARAM_STR);
       $stmt->execute();
       $resp = false;
       if(password_verify($oldPassword, $stmt->fetchColumn())){
         $this->closeConnection();
         $sql = "UPDATE Teachers SET password = :password WHERE codeTeacher = :id";
         $stmt = $this->connect()->prepare($sql);
         $encrypt = password_hash($newPassword, PASSWORD_DEFAULT);
         $stmt->bindParam(':id',$id,PDO::PARAM_INT);
         $stmt->bindParam(':password',$encrypt,PDO::PARAM_STR);
         if($stmt->execute())
           $resp = true;
       }
       $this->closeConnection();
       return  json_encode($resp);
     }


    public function saveTeacher($values){
    //  include_once('/Helpers.php');
      $resp = false;
      $tmpPass = $this->temporalcode(6);
      // /*Encrypt password*/
      $encrypt = password_hash('123456', PASSWORD_DEFAULT);
      $values['password'] = $encrypt;
      $token = bin2hex(random_bytes(25));
      $token = $token;
      $values['token'] = '__token'.$token;
      $sql = 'INSERT INTO Teachers (codeTeacher,name,lastname,type,password,email,phone,genere,fingerRoute,Extensions_idExtension,token)
      VALUES (:code,:name,:lastname,:type,:password,:email,:phone,:genere,:fingerRoute,:extension,:token)';
      $stmt = $this->connect()->prepare($sql);
      if ($stmt->execute($values))
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }
    private function sendConfirmEmail($to,$type,$token,$id){
      $from = "test@hostinger-tutorials.com";
      $to = "test@gmail.com";
      $subject = "Checking PHP mail";
      $url ="localhost:4200/confirmemail/".$type."/".$token."/".$id;
      $message = "PHP mail works just fine <a href=".$url.">Confirmar Email</a>";
      $headers = "From:" . $from;
      mail($to,$subject,$message, $headers);
      echo "The email message was sent.";
    }
    private function sendMail(){

    }

    /**/
    public function activateTeacher($id){
      $sql ="UPDATE Teachers SET status = '1' WHERE codeTeacher = :id";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      return '{"success": true}';
      $this->closeConnection();
    }

    public function searchTeachersDesk($ter,$extension){
      $sql = "SELECT * FROM View_searchTeachersDesk WHERE (code LIKE concat(:ter,'%') OR name LIKE concat(:ter,'%') OR lastname LIKE concat(:ter,'%') OR email LIKE concat(:ter,'%')) AND extension = :extension ";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':ter', $ter, PDO::PARAM_STR);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_INT);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $fetch[] = $row;        }
      }
      else{
          $fetch = false;
      }
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**/
    public function searchTeacher($ter,$type,$extension){
      $sql = "CALL searchTeacher(:ter,'web',:type,:extension)";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':type', $type, PDO::PARAM_STR);
      $stmt->bindParam(':ter', $ter, PDO::PARAM_STR);
      $stmt->bindParam(':extension', $extension, PDO::PARAM_STR);
      $stmt->execute();
      $fetch = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $fetch[] = $row;
      }
      $this->closeConnection();
      return  json_encode($fetch);
    }
    /**/
    public function getTeacherForType($type){
      if($type == 'A' || $type == 'B' || $type == 'PTC'){
        $sql = "SELECT * FROM Teachers WHERE type = :type AND  status = '1'";
      }
      elseif ($type =='inactive') {
        $sql = 'SELECT * FROM Teachers WHERE status = :type';
        $type = '0';
      }
      else{
          $sql = "SELECT * FROM Teachers WHERE NOT status = '0'";
      }
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':type',$type);
      $stmt->execute();
      $fetch = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $fetch[] = $row;
      }
      return  json_encode($fetch);
      $this->closeConnection();
    }
    /**/
    public function updateTeacher($values){
      $resp = false;
      $sql = "CALL updateTeachers(:oldCode,:code,:name,:lastname,:type,:email,:phone,'H','f',:extension,'web')";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values)){
        $resp = true;
      }
      $this->closeConnection();
      return $resp;
    }
    /**/
    public function updateTeacherDesk($values){
      $resp = false;
      $sql = "CALL updateTeachers(:oldCode,:code,:name,:lastname,:type,:email,:phone,:genere,:fingerRoute,:extension,:app)";
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $resp = true;
      $this->closeConnection();
      return json_encode($resp);
    }

    function temporalcode($length) {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomcode = '';
      for ($i = 0; $i < $length; $i++) {
      $randomcode .= $characters[rand(0, $charactersLength - 1)];
       }
      return $randomcode;
    }
  }
 ?>
