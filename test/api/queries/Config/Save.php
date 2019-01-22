  <?php
  /*Includes*/
   require('../../Headers.php');
   require('../../Classes/Config.php');

   $data = json_decode(file_get_contents("php://input",true));

   $values = [
     'startTime' =>   $data->startTime,
     'endTime' =>  $data->endTime,
     'durationModule' =>  $data->durationModule,
     'sbreakTime' =>  $data->sbreakTime,
     'ebreakTime' =>  $data->ebreakTime,
     'durationBreak' =>$data->durationBreak
   ];
   $config = new Config;
   $resp =  $config->Save($values);
   echo $resp;

 ?>
