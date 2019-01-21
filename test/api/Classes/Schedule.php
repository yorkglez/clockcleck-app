<?php
  /**
   *
   */
   require_once('Connection.php');
   require ('../../libs/Carbon/autoload.php');
   use Carbon\Carbon;
  class Schedule extends Connection
  {

    private $config;
    private $breakTime;
    public function AssingSubject($values){
      $sql = "call AssingSubject (:grade, :clicle, :objetive, :codeTeacher, :codeSubject, :startTime, :endTime, :day, :codeCarer)";
      $stmt = $this->connect()
      ->prepare($sql);
      $stmt->execute($values);
    }
    /**
     * [getScheduleConfig description]
     * @return [type] [description]
     */
    public function getScheduleConfig($code){
      // session_start();
      // $code = $_SESSION['id'];
      $sql = "SELECT * FROM view_getconfigsc WHERE Teachers_codeTeacher = :code LIMIT 1";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':code',$code,PDO::PARAM_STR);
      $stmt->execute();

      $this->config = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
    //  print_r($this->config);
      $startTime = strtotime($this->config['startTime']);
      $endTime = strtotime($this->config['endTime']);
      $durationModule = $this->config['durationModule'];
      $sbreakTime = $this->config['sbreakTime'];
      $durationBreak = $this->config['durationBreak'];
      $modules = (round(abs($endTime - $startTime) / 60) - $durationBreak) / $durationModule;
      for ($i=0; $i <$modules+1 ; $i++) {
        if(date("H:i",$startTime) ==  $sbreakTime){
          $endTime =  date("H:i", strtotime('+'.$durationBreak.' minutes', $startTime));
          $this->breakTime = ($i);
        }
        else
          $endTime =  date("H:i", strtotime('+'.$durationModule.' minutes', $startTime));
        if($startTime < strtotime('12:00'))
          $tm = ' AM';
        else
          $tm = ' PM';
        if($startTime < strtotime('10:00'))
          $st = substr(date("H:i",$startTime),1);
        else if(strtotime($endTime) < strtotime('10:00'))
          $et = substr($endTime,1);
        else
          $st = date("H:i",$startTime);
        $et = $endTime;
        $hours[] = $st.$tm.' - '.$endTime.$tm;
        $startTime =  strtotime($endTime);
      }
      $array['hours'] = $hours;
      $array['breakTime'] = $this->breakTime;
      return json_encode($array);
    }
    /**
     * [getHoursList description]
     * @return [type] [description]
     */
    public function getHoursList(){
      $sql = "SELECT * FROM Config ORDER BY idConfig DESC LIMIT 1";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute();
      $this->config = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();

      $startTime = strtotime($this->config['startTime']);
      $endTime = strtotime($this->config['endTime']);
      $durationModule = $this->config['durationModule'];
      $sbreakTime = $this->config['sbreakTime'];
      $durationBreak = $this->config['durationBreak'];
      $modules = (round(abs($endTime - $startTime) / 60) - $durationBreak) / $durationModule;
      for ($i=0; $i <$modules+2 ; $i++) {
        if(date("H:i",$startTime) ==  $sbreakTime){
          $endTime =  date("H:i", strtotime('+'.$durationBreak.' minutes', $startTime));
          $this->breakTime = ($i);
        }
        else{
          $endTime =  date("H:i", strtotime('+'.$durationModule.' minutes', $startTime));
          if($startTime < strtotime('12:00'))
            $tm = ' AM';
          else
            $tm = ' PM';
          if($startTime < strtotime('10:00'))
            $st = substr(date("H:i",$startTime),1);
          else if(strtotime($endTime) < strtotime('10:00'))
            $et = substr($endTime,1);
          else
            $st = date("H:i",$startTime);
          $et = $endTime;
          $hour['value'] = date("H:i",$startTime);
          $hour['hour'] = $st.$tm;
          //$hour = ;
          $fetch[] = $hour;
        }
        $startTime =  strtotime($endTime);
      }
      return json_encode($fetch);
    }

    /**
     * [getScheduleTeacher description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getScheduleTeacher($id){
      $sql = "SELECT * FROM view_getconfigsc WHERE Teachers_codeTeacher = :id LIMIT 1";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      $this->config = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->closeConnection();
      $sql = "SELECT * FROM View_getScheduleteacher WHERE Teachers_codeTeacher = :id order by(startTime) ASC";
      $stmt = $this->connect()->prepare($sql);
      $stmt->bindParam(':id',$id,PDO::PARAM_STR);
      $stmt->execute();
      if($stmt->rowCount() > 0){
        $list['lunes'][0] = null;
        $list['martes'][0] = null;
        $list['miercoles'][0] = null;
        $list['jueves'][0] = null;
        $list['viernes'][0] = null;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $startTime = strtotime($row['startTime']);
            $endTime = strtotime($row['endTime']);
            $modules = round(abs($endTime - $startTime) / 60)/50;

            for ($i=0; $i <=$modules; $i++) {
              if($row['day'] == 'lunes'){
                $index = $this->getindex_schedule(date("H:i",$startTime));
                $list['lunes'][$index] = $row['subjectName'];
                $list['lunes'][$this->breakTime] = 'Receso';
              }
              else if($row['day'] == 'martes'){
                $index = $this->getindex_schedule(date("H:i",$startTime));
                $list['martes'][$index] = $row['subjectName'];
                $list['martes'][$this->breakTime] = 'Receso';
              }
              else if($row['day'] == 'miercoles'){
                $index = $this->getindex_schedule(date("H:i",$startTime));
                $list['miercoles'][$index] = $row['subjectName'];
                $list['miercoles'][$this->breakTime] = 'Receso';
              }
              else if($row['day'] == 'jueves'){
                $index = $this->getindex_schedule(date("H:i",$startTime));
                $list['jueves'][$index] = $row['subjectName'];
                $list['jueves'][$this->breakTime] = 'Receso';
              }
              else if($row['day'] == 'viernes'){
                $index = $this->getindex_schedule(date("H:i",$startTime));
                $list['viernes'][$index] = $row['subjectName'];
                $list['viernes'][$this->breakTime] = 'Receso';
              }
              if (date("H:i",$startTime) == $this->config['sbreakTime'])
                $endTime = date("H:i", strtotime('+'.$this->config['durationBreak'].' minutes', $startTime));
              else
                $endTime = date("H:i", strtotime('+50 minutes', $startTime));

              $startTime =  strtotime($endTime);
            }
        }
      }
      else
        $list = false;
      $this->closeConnection();
      return  json_encode($list);
    }

    /**
     * [getindex_schedule description]
     * @param  [type] $start [description]
     * @return [type]        [description]
     */
    private function getindex_schedule($start){
      $startTime = strtotime($this->config['startTime']);
      $endTime = strtotime($this->config['endTime']);
      $durationModule = $this->config['durationModule'];
      $sbreakTime = $this->config['sbreakTime'];
      $durationBreak = $this->config['durationBreak'];
      $modules = (round(abs($endTime - $startTime) / 60) - $durationBreak) / $durationModule;
      $index = 0;
      for ($i=0; $i <=$modules; $i++) {
          if($i != 0){
            $dt =  date("H:i", strtotime('+'.$durationModule.' minutes', $startTime));
            $startTime =  strtotime($dt);
            if($dt ==  $sbreakTime ){
                $dt =  date("H:i", strtotime('+'.$durationBreak.' minutes', $startTime));
                $startTime =  strtotime($dt);
                $this->breakTime = ($i);
                $i++;
            }
          }
          else if($i == 0)
            $dt = date("H:i",$startTime);
          if($start == $dt)
             $index = $i;
      }
      return $index;
      }
  }

 ?>
