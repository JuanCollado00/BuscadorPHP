<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/customColors.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/index.css" media="screen,projection" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulario</title>
</head>

<body>
  <video src="img/video.mp4" id="vidFondo"></video>

  <div class="contenedor">
    <div class="card rowTitulo">
      <h1>Buscador</h1>
    </div>
    <div class="colFiltros">
      <form action="index.php" method="post" id="formulario">
        <div class="filtrosContenido">
          <div class="tituloFiltros">
            <h5>Realiza una búsqueda personalizada</h5>
          </div>
          <div class="filtroCiudad input-field">
            <label for="selectCiudad">Ciudad:</label><br><br><br>
            <?php
            $jsonStringAll = file_get_contents("data-1.json");
            $dataAll= json_decode($jsonStringAll, true);
            $ciudades = array();
            $tipo = array();
            for ($i = 0; $i < count($dataAll); $i++) {
              if (!in_array($dataAll[$i]["Ciudad"], $ciudades)) {
                $ciudades[] = $dataAll[$i]["Ciudad"];
              }
              if(!in_array($dataAll[$i]["Tipo"], $tipo)) {
                $tipo[] = $dataAll[$i]["Tipo"];
              }
            }
            ?>
            <select name="ciudad" id="selectCiudad" style="display: inline-block;">

              <?php
              for ($i = 0; $i < count($ciudades); $i++) {
                echo ' <option value="' . $ciudades[$i] . '" >' . $ciudades[$i] . '</option>';
              }
              ?>

            </select>
          </div>
          <div class="filtroTipo input-field">
            <label for="selecTipo">Tipo:</label><br><br><br>
            <select name="tipo" id="selectTipo" style="display: inline-block;">
            <?php
              for ($i = 0; $i < count($tipo); $i++) {
                echo ' <option value="' . $tipo[$i] . '" >' . $tipo[$i] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="filtroPrecio">
            <label for="rangoPrecio">Precio:</label>
            <input type="text" id="rangoPrecio" name="precio" value="" />
          </div>
          <div class="botonField">
            <input type="submit" class="btn white" value="Buscar" id="submitButton">
          </div>
        </div>
      </form>
    </div>

    <div class="colContenido">
      <div class="tituloContenido card">
        <h5>Resultados de la búsqueda:</h5>
        <div class="divider"></div>
        <div class="card">
          <?php
          if (isset($_POST["mostrarTodos"])) {
            $jsonString = file_get_contents("data-1.json");
            $data = json_decode($jsonString, true); ?>

            <table class="striped">
              <thead>
                <th>Imagen</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Telefono</th>
                <th>Codigo Postal</th>
                <th>Tipo</th>
                <th>Precio</th>
              </thead>
              <tbody>
                <?php
                for ($i = 0; $i < count($data); $i++) { ?>

                  <tr>
                    <td><img src="img/home.jpg" height="50"></td>
                    <td><?php echo $data[$i]["Direccion"]; ?></td>
                    <td><?php echo $data[$i]["Ciudad"]; ?></td>
                    <td><?php echo $data[$i]["Telefono"]; ?></td>
                    <td><?php echo $data[$i]["Codigo_Postal"]; ?></td>
                    <td><?php echo $data[$i]["Tipo"]; ?></td>
                    <td><?php echo $data[$i]["Precio"]; ?></td>
                  </tr>

                <?php  } 
                ?>
              </tbody>
            </table>

          <?php   } elseif (isset($_POST["ciudad"])) { 
            $jsonString = file_get_contents("data-1.json");
            $data = json_decode($jsonString, true); 
            $ciudad = $_POST["ciudad"];
            $tipo = $_POST["tipo"];
            $precio = explode(";", $_POST["precio"]);
            $precio1 = $precio[0];
            $precio2 = $precio[1];
            ?>
            <table class="striped">
              <thead>
                <th>Imagen</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Telefono</th>
                <th>Codigo Postal</th>
                <th>Tipo</th>
                <th>Precio</th>
              </thead>
              <tbody>
                <?php
                for ($i = 0; $i < count($data); $i++) { 
                 $tempPrecio = str_replace("$", "", $data[$i]["Precio"] );
                 $tempPrecio = str_replace(",", "", $tempPrecio );

                  if($ciudad == $data[$i]["Ciudad"]){
                    
                    if($tipo == $data[$i]["Tipo"]){
                      
                      if($tempPrecio >= $precio1 && $tempPrecio <= $precio2){
                        ?>

                  <tr>
                    <td><img src="img/home.jpg" height="50"></td>
                    <td><?php echo $data[$i]["Direccion"]; ?></td>
                    <td><?php echo $data[$i]["Ciudad"]; ?></td>
                    <td><?php echo $data[$i]["Telefono"]; ?></td>
                    <td><?php echo $data[$i]["Codigo_Postal"]; ?></td>
                    <td><?php echo $data[$i]["Tipo"]; ?></td>
                    <td><?php echo $data[$i]["Precio"]; ?></td>
                  </tr>

                <?php

                      }
                    }
                  }
                  
                  } 
                ?>
              </tbody>
            </table>

          <?php     } ?>

        </div>
        <form method="post" id="formulario">
          <input type="hidden" value="mostarTodos" name="mostrarTodos">
          <button type="submit" name="todos" class="btn-flat waves-effect" id="mostrarTodos">Mostrar Todos</button>
        </form>
      </div>

    </div>
  </div>

  <script type="text/javascript" src="js/jquery-3.0.0.js"></script>
  <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
</body>

</html>