<?php
 //require '././vendor/autoload.php';
//use  Faker\Factor::create();
//  require_once('Connection.php');
  class Operations {

    /**
     * [this funtion get data for databse]
     * @param  [string] $table [table name]
     * @return [json]        [return data]
     */
    public function getData($table,$conditions = false, $values = false){
      $sql = "SELECT * FROM ".$table; //sentence sql
      /*create sentence with conditons*/
      if($conditions != false){
        $sql .= " ".$conditions; // add conditions
        $stmt = $this->connect()->prepare($sql); //prepare sentence
        /*execute setence with values*/
        if($values != false)
          $stmt->execute($values);
        else
          $stmt->execute();
      }
      /*execute sentence without conditions*/
      else{
        $stmt = $this->connect()->prepare($sql); //preprare sentence
        $stmt->execute(); //execute sentente
      }
      /* Get data from db in fetch*/
      if($stmt->rowCount() > 0){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          $fetch[] = $row; //get row
      }
      else
        $fetch = false;
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
    /**
     * [Create description]
     * @param [type] $values [description]
     * @param [type] $table  [description]
     */
    public function Create($values, $table){
      $sql = 'INSERT INTO '.$table.'(name,lastname,email,password,type,Extensions_idExtension) VALUES (:name,:lastname,:email,:password,:type,:Extensions_idExtension)';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute($values);
      $resp = false;
      if (  $stmt->execute($values)) {
        $resp = true;
      }
      $this->closeConnection();
      return '{"resp": '.$resp.'}';
    }
    /**
     * [This function call stored procedure]
     * @param [string] $procedure [name of procedure]
     * @param [array] $values    [values for procedure]
     */
    public function Call($procedure,$values,$get = false){
      $exc = false;
      $sql = "CALL ".$procedure." ("; //create call sentence
      /*search params*/
      foreach($values as $param=>$value)
        $sql .= ":".$param.", "; //add param to sentence
      $sql = substr($sql,0,-2).')'; //remove chars trash
      $stmt = $this->connect()->prepare($sql); //prepare sentence
      /*execute sentence with values*/
      if($stmt->execute($values)){
        $exc = true;
        if ($stmt->rowCount()>0) {
          /*validate if this procedure return data*/
          if($get){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
              $fetch[] = $row; //get row
            $exc = $fetch;
          }
        }
        else
         $exc = false;
      }
      $this->closeConnection(); //close conection
      return json_encode($exc); //return response
    }

    /**
     * [This function insert new data in database]
     * @param [string] $table  [name table]
     * @param [array] $values [this a]
     */
    public function Insert($table,$values){
      $sql = "INSERT INTO ".$table." ("; // create sentence
      /*search params*/
      foreach($values as $param=>$value)
        $sql .= $param.", "; //add param to sencente
      $sql = substr($sql,0,-2).") VALUES ("; //create values sentence
      /*search values*/
      foreach($values as $param=>$value)
        $sql .= ":".$param.", "; //add values to sentence
      $sql = substr($sql,0,-2).")"; //remove chars trash
      $stmt = $this->connect()->prepare($sql); //prepare sentence
      /*execute sentence with values*/
      if($stmt->execute($values))
        $exc = true;
      else
        $exc = false;
      $this->closeConnection(); //close conection
      return $exc; //return response
    }
    /**
     * [This function update data]
     * @param [string] $table  [table name]
     * @param [array] $values [description]
     */
    public function Update($table,$values){
      $exc = false;
      $sql = "UPDATE ".$table." SET "; // create sentence
      /*search params*/
      foreach($values as $param=>$value){
        /*validate last param in array*/
        if(end( $values )  == $value ){
          $sql = substr($sql,0,-1);
          $sql .="WHERE ".$param." = :".$param;
        }
        else
          $sql .= $param." = :". $param." ,";
      }
      $stmt = $this->connect()->prepare($sql); //prepare sentence
      /*excute sentence with values*/
      if($stmt->execute($values))
        $exc = true;
      $this->closeConnection(); //close conection
      return json_encode($exc); //return response
      // echo $sql;
    }
    /**
     * [Delete description]
     * @param [type] $table  [description]
     * @param [type] $idName [description]
     * @param [type] $id     [description]
     */
    public function Delete($table, $idName, $id){
      $sql ="DELETE FROM ".$table." WHERE ".$idName." = :id"; //create sentence
      $stmt = $this->connect()->prepare($sql); //prepare sentence
      $stmt->bindParam(':id',$id); //add param
      /*execute sentence*/
      if($stmt->execute())
        $resp = true;
      else
        $resp = false;
      $this->closeConnection(); //close conection
      return json_encode($resp); //return response
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
    //    $this->closeConnection(); //close conection
        $sql ="UPDATE ".$table." SET status = :status WHERE ".$idName."  = :id"; //create sentence
        $stmt = $this->connect()->prepare($sql); //prepare sentence
        $stmt->bindParam(':id',$id); //add param
        $stmt->bindParam(':status',$status,PDO::PARAM_STR); //add param
        /* execute sentence*/
        if($stmt->execute())
          $resp = true;
        else
          $resp = false;
        $this->closeConnection(); //close conection
        return json_encode($resp); //return response
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
