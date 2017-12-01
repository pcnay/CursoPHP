<?php 
  require_once "vistas.php"
  // Para trabajar de forma limpia en el PHP,ademas se requiere ya que en este archivo
  // se encuentran todas las vistas que requiere la aplicación.

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"
  <title>Aplicacion CRUD De SuperHeroes</title>
  <meta name="description" content = "Aplicacion CRUD con filosofia MVC desarrollada en 
  PHP MySQL y Ajax" />
  
  <link rel="stylesheet" href="css/super-heroes.css" />

</head>
<body>
  <header id = "cabecera">
    <h1>Super Heroes</h1>
    <div><img src="img/super-heroes.jpg" alt= "Super Heroes" /></div>
    <!-- Desencadena el Ajax -->
    <a href="#"id="insertar">Insertar</a>
 
  </header>

  <section id="contenido">
    <!-- En este DIV se colocara la respuesta del Ajax -->
    <div id="respuesta"></div>

    <!-- Desplegara el icono de cargando -->
    <div id="precarga"></div>

    <?php mostrarHeroes(); ?>

   <!-- <p>Aca va el contenido</p> -->
  </section>


  <!-- Llamando al archivo de JavaScript -->
  <script src="js/despachador.js"></script>
</body>
</html>