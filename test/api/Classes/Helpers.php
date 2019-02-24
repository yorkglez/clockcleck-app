<?php
  /**
   *
   */
   require_once('Connection.php');
  class Helpers extends Connection
  {
    public function generateToken(){
      $token = bin2hex(random_bytes(20));;
      return $token;
    }

    public function checkEmail($email){
      $sql = "SELECT email FROM Users WHERE email = :email";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':email',$email,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0)
        $resp = true;
      else{
        $this->closeConnection();
        $sql = 'SELECT email FROM Teachers WHERE email = :email';
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0)
          $resp = true;
        else
          $resp = false;
      }
      $this->closeConnection();
      return  json_encode($resp);
    }
    /**
     * [sendMail description]
     * @param  [type] $emailTo [description]
     * @param  [type] $subject [description]
     * @param  [type] $body    [description]
     * @return [type]          [description]
     */
     public function sendMail($emailTo,$subject,$body){
       require('../../libs/PHPMailer/src/PHPMailer.php');
       require('../../libs/PHPMailer/src/SMTP.php');
       require('../../libs/PHPMailer/src/Exception.php');
       require('../../libs/PHPMailer/src/OAuth.php');
       $mail = new PHPMailer\PHPMailer\PHPMailer();   // Passing `true` enables exceptions
       $emailFrom = 'clockcheck@malastareas.com';
       try {
         /*Server settings*/
         //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
         $mail->isSMTP();                                      // Set mailer to use SMTP
         $mail->Host = 'mail.malastareas.com ';  // Specify main and backup SMTP servers
         $mail->SMTPAuth = true;                               // Enable SMTP authentication
         $mail->Username = $emailFrom;                 // SMTP username
         $mail->Password = 'ilovetamales123';                           // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
         $mail->Port = 587;                                    // TCP port to connect to
         /*Recipients*/
         $mail->setFrom($emailFrom, 'Clock Check');
         $mail->addAddress($emailTo, 'User');     // Add a recipient
         /*Content*/
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = $subject;
         $mail->Body = $body;
         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
         $mail->send();
         return true;
       } catch (Exception $e) {
         return false;
       }
     }

    public function getSelectsjbytc($date,$code){
      $timestamp = strtotime($date);
      $dayName = date("l", $timestamp);
      $nDay = date('N',strtotime($dayName));
      $sql = "SELECT sl.idSubjectlist AS id, sb.name  FROM Subjects_list sl
      INNER JOIN Subjects sb ON sl.Subjects_codeSubject = sb.codeSubject
      INNER JOIN schedule sc ON sc.Subjects_list_idSubjectlist = sl.idSubjectlist
      WHERE sc.day = ".$nDay." AND sl.Teachers_codeTeacher = :code";
      $stmt = $this->connect()->prepare($sql);
      // $stmt->bindParam(':day', $nDay, PDO::PARAM_INT);
      $stmt->bindParam(':code', $code, PDO::PARAM_STR);
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

   public function getSchedulelist($idsl, $code){
     $sql = "SELECT  at.Schedule_idSchedule FROM Attendances at
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

       $sql = "SELECT idSchedule, concat(startTime, ' - ', endTime) as hours FROM Schedule WHERE idSchedule not in "."(".$cad.")";
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
     else
       $fetch = false;
     return  json_encode($fetch);
   }
  }





 ?>
