  <?php
    require '../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

    ob_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>printView</title>
    <style media="screen">
      .schoolName{
        color:red
      }
    </style>
  </head>
  <body>
    <h1 class="schoolName">INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ</h1>
    <div class="row ">
      <div class="col-md-2">
        Extension:
      </div>
      <div class="col-md-2">
        Tipo de reporte:
      </div>
      <div class="col-md-2">
        Fecha:
      </div>
      <div class="col-md-2">
        Hora:
      </div>
    </div>
    <br>
    <div class="table-container">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">Departamento</th>
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Entrada</th>
            <th scope="col">Salida</th>
            <th scope="col">Tipo de asistencia</th>
            <th scope="col">Grupo</th>
            <th scope="col">Tema/Actividad</th>
            <th scope="col">Materia</th>
            <!-- <th scope="col">Hora de chequeo</th> -->
            <th scope="col">notas</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
            <th>item</th>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>


<?php
    $html = ob_get_clean();
    $pdf = new Html2Pdf('P','A4','es','true','UTF-8');
    $pdf->writeHTML($html);


    //ob_start();
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ob_end_clean();
    $pdf->output('reporte.pdf', 'I');
 ?>
