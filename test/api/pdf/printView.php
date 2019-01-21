
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>printView</title>
    <style media="screen">
      .schoolName{
        text-align: center;
      }
      .table-container table {
        width: 90%;
        border-collapse: collapse;

      }

      .table-container table,.table-container th, td {
          border: 1px solid black;
      }

      .row{
        width: 600px;
      }
      /* .table-info{
        border: none;
        width: 100%;
        text-align: left;
      }
      .info{
        font-weight: normal;
      } */
    </style>
  </head>
  <body>
    <h1 class="schoolName">INSTITUTO TECNOLOGICO JOSE MARIO MOLINA PASQUEL Y HENRIQUEZ</h1>
    <div class="row ">
      <table class="table-info">
        <thead>
          <tr>
            <th>Extension: <span class="info">Tala</span> </th>
            <th>Tipo de reporte: <span class="info">Test</span></th>
            <th>Fecha: <span class="info"><?php echo date('Y-m-d');?></span> </th>
            <th>Hora: <span class="info"><?php echo date('H:i');?></span> </th>
          </tr>
        </thead>
      </table>
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
            <th scope="col">Fecha</th>
            <!-- <th scope="col">Hora de chequeo</th> -->
            <th scope="col">notas</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>
            <td>item</td>

          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>
