<?php
 //require '././vendor/autoload.php';
//use  Faker\Factor::create();
  require_once('Connection.php');
  class Operations extends Connection {

    /**
     * [this funtion get data for databse]
     * @param  [string] $table [table name]
     * @return [json]        [return data]
     */
    public function getData($table,$conditions = false, $values = false){
      $sql = "SELECT * FROM ".$table; //sentence sql
      if(!$conditions){
        // $sql = "SELECT * FROM ".$table." ".$conditions;
        $sql .= " ".$conditions;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($values);
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
    public function Call($procedure,$values,$get){
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
    /**
     * [changeStatus description]
     * @param  [type] $table  [description]
     * @param  [type] $id     [description]
     * @param  [type] $idName [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function changeStatus($table,$id,$idName,$status){
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

    public function getRows($table,$conditions = array()){
    $sql = 'SELECT ';
    $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
    $sql .= ' FROM '.$table;
    if(array_key_exists("where",$conditions)){
        $sql .= ' WHERE ';
        $i = 0;
        foreach($conditions['where'] as $key => $value){
            $pre = ($i > 0)?' AND ':'';
            $sql .= $pre.$key." = '".$value."'";
            $i++;
        }
    }






    if(array_key_exists("order_by",$conditions)){
        $sql .= ' ORDER BY '.$conditions['order_by'];
    }

    if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
        $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
    }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
        $sql .= ' LIMIT '.$conditions['limit'];
    }

    $query = $this->db->prepare($sql);
    $query->execute();

    if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
        switch($conditions['return_type']){
            case 'count':
                $data = $query->rowCount();
                break;
            case 'single':
                $data = $query->fetch(PDO::FETCH_ASSOC);
                break;
            default:
                $data = '';
        }
    }else{
        if($query->rowCount() > 0){
            $data = $query->fetchAll();
        }
    }
    return !empty($data)?$data:false;
}

  }
?>
