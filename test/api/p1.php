<?php
  require './vendor/autoload.php';
  use Spipu\Html2Pdf\Html2Pdf;
 ob_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

  </head>
  <body>
    <div>
      <h2 class="tec-title">INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ CAMPUS TALA</h2>
      <!-- <div class="row"> -->
        <div class="sub-title">Reporte de asistencia</div>
        <div class="date">Fecha: <span>12/14/2018</span> </div>
      <!-- </div> -->
      <!-- <div class="row"> -->
        <div class="period">
          Periodo <span>2018</span> al <span>2019</span> <span>Quincenal</span> del <span>10/10/2018</span> al <span>10/10/2018</span>
        </div>
        <div class="hour">Hora: <span>12/14/2018</span> </div>
      <!-- </div> -->
      <!-- <div class="row"> -->
        <div class="extension">Extension: <span>Tala</span></div>
        <div class="type">Tipo de reporte: <span>Por empleado</span><div>
      <!-- </div> -->


    </div>
  </body>
</html>
<?php
  $html = ob_get_clean();
  $pdf = new Html2Pdf('P','A4','es','true','UTF-8');
  $pdf->writeHTML($html);
  ob_end_clean();
  $pdf->output('reporte.pdf', 'I');


 ?>
