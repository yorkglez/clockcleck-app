<?php
 //require '././vendor/autoload.php';
//use  Faker\Factor::create();
  //require_once('Connection.php');
  class Operations {

    /**
     * [this funtion get data for databse]
     * @param  [string] $table [table name]
     * @return [json]        [return data]
     */
    public function getData($table,$conditions = false, $values = false){
      $sql = "SELECT * FROM ".$table; //sentence sql
      if($conditions != false){
        $sql .= " ".$conditions;
        $stmt = $this->connect()->prepare($sql);
        if($values != false)
          $stmt->execute($values);
        else
          $stmt->execute();
      }

      else{
        // $sql = "SELECT * FROM ".$table; //sentence sql
        $stmt = $this->connect()->prepare($sql); //preprare sentence
        $stmt->execute(); //execute sentente
      }
      /* Get data from db in fetch*/
      while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $fetch[] = $row;
      $this->closeConnection(); //close conection
      return  json_encode($fetch); //return data
    }
    /**
     * [getFirst description]
     * @param  [type]  $table      [description]
     * @param  boolean $conditions [description]
     * @param  boolean $values     [description]
     * @return [type]              [description]
     */
    public function getFirst($table,$conditions = false, $values = false){
        $sql = "SELECT * FROM ".$table." ".$conditions; //sentence sql
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($values);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->closeConnection(); //close conection
        return  json_encode($row); //return data
    }

    public function Create($values, $table){
      $sql = 'INSERT INTO '.$table.'(name,lastname,email,password,type,Extensions_idExtension) VALUES (:name,:lastname,:email,:password,:type,:Extensions_idExtension)';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute($values);
      $resp = false;
      if (  $stmt->execute($values)) {
        $resp = true;
      }
      return '{"resp": '.$resp.'}';
      $this->closeConnection();
    }
    /**
     * [This function call stored procedure]
     * @param [string] $procedure [name of procedure]
     * @param [array] $values    [values for procedure]
     */
    public function Call($procedure,$values,$get = false){
      $exc = false;
      $sql = "CALL ".$procedure." (";
      foreach($values as $param=>$value)
        $sql .= ":".$param.", ";
      $sql = substr($sql,0,-2).')';
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values)){
        $exc = true;
        if ($stmt->rowCount()>0) {
          if($get){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
              $fetch[] = $row;
            $exc = $fetch;
          }
        }
        else
         $exc = false;
      }
      $this->closeConnection();
      return json_encode($exc);
    }

    /**
     * [This function insert new data in database]
     * @param [string] $table  [name table]
     * @param [array] $values [this a]
     */
    public function Insert($table,$values){
      $sql = "INSERT INTO ".$table." (";
      foreach($values as $param=>$value)
        $sql .= $param.", ";
      $sql = substr($sql,0,-2).") VALUES (";
      foreach($values as $param=>$value)
        $sql .= ":".$param.", ";
      $sql = substr($sql,0,-2).")";
      //echo $sql;
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $exc = true;
      else
        $exc = false;
      $this->closeConnection();
      return $exc;
    }
    /**
     * [This function update data]
     * @param [string] $table  [table name]
     * @param [array] $values [description]
     */
    public function Update($table,$values){
      $exc = false;
      $sql = "UPDATE ".$table." SET ";
      foreach($values as $param=>$value){
        if(end( $values )  == $value ){
          $sql = substr($sql,0,-1);
          $sql .="WHERE ".$param." = :".$param;
        }
        else
          $sql .= $param." = :". $param." ,";
      }
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $exc = true;
      return $exc;
    }

    public function Delete($table, $values){
      $exc = false;
      $sql = "DELETE ".$table." WHERE ";
      foreach($values as $param=>$value){
        if(end( $values )  == $value ){
          $sql = substr($sql,0,-1);
          $sql .="WHERE ".$param." = :".$param;
        }
        else
          $sql .= $param." = :". $param." ,";
      }
      $stmt = $this->connect()->prepare($sql);
      if($stmt->execute($values))
        $exc = true;
      return $exc;
    }
    /**
     * [changeStatus description]
     * @param  [type] $table  [description]
     * @param  [type] $id     [description]
     * @param  [type] $idName [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function changeSt($table,$id,$idName,$status){
        $sql ="UPDATE ".$table." SET status = :status WHERE ".$idName."  = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':status',$status,PDO::PARAM_STR);
        if($stmt->execute())
          $resp = true;
        else
          $resp = false;
        $this->closeConnection();
        return json_encode($resp);
    }
    public function fakerUsers(){
      $faker = Faker\Factory::create();
  //    echo $faker->numberBetween($min = 1000, $max = 9000);
      for ($i=0; $i < 10 ; $i++) {       //  $values =[
       //    'name'=> $faker->name,
       //    'lastname'=>$faker->lastname,
       //    'email'=>$faker->email,
       //    'password'=>'123456',
       //    'type'=> 'normal',
       //    'genere'=> 'H',
       //    'Extensions_idExtension'=> 1
       //  ];
       // $this->Insert('Users',$values);
       //

       $values =[
         'codeTeacher'=>$faker->numberBetween($min = 1000, $max = 9000),
         'name'=> $faker->name,
         'lastname'=>$faker->lastname,
         'email'=>$faker->email,
         'phone'=>'384-111-2244',
         'password'=> password_hash('password', PASSWORD_DEFAULT),
         'type'=> 'PTC',
         'genere'=> 'H',
         'Extensions_idExtension'=> 1
       ];
       echo $this->Insert('Teachers',$values);
      }
    }
  }
?>
