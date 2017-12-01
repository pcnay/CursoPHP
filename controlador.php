<?php
  require "vistas.php";
  require "modelo.php";
// Otra linea prueba

  /*
  Aplicacion = CreateReadUpdateDelete
  PHP  tiene 2 métodos de envio de datos a través del formulario  : POST y GET

  Create    Afecta BD       INSERT (SQL)       POST  Modelo.php
  Read      NO Afecta BD    SELECT (SQL)       GET   Vista.php
  Update    Afecta BD       UPDATE (SQL)       POST  Modelo.php
  Delete    Afecta BD       DELETE (SQL)       POST  Modelo.php

  */
  $transaccion = $_POST["transaccion"]; // Arreglo global.
  // Cuando se retorno, sin recargar la página se muestra el contenido de la variable $transaccion
  //echo $transaccion;

  function ejecutarTransaccion($transaccion)
  {
    if ($transaccion == "alta")
    {
      // Mostrar el formulario de Alta.
      // Esta creada en el arcivo "vistas.php". Se agrega el formulario.
      altaHeroe(); 
      
    }
    else if ($transaccion == "insertar")
    {
      //Procesar los datos del formulario de alta e insertarlos en MySQL.
      // Estos valores se separan de la cadena enviar en el "ajax.open(Post....)"
      // Estos son los datos que vienen del formulario, para ser insertados a la B.D.
      // Esta función se define en "modelo.php" porque afecta a la Base De Datos.
            insertarHeroe(        
        $_POST['nombre_txt'],
        $_POST['imagen_txt'],
        $_POST['descripcion_txa'],
        $_POST['editorial_slc']
      );

    }
    else if ($transaccion == "eliminar")
    {
      // Eliminar un registro de MySQL.
      eliminarHeroe($_POST["idHeroe"]); // Se crea en el modelo.php, afecta la base de datos.
    }
    else if ($transaccion == "editar")
    {
      // Traer los datros del reg.a modificar en un formulario
    }
    else if ($transaccion = "actualizar")
    {
      // Modificar los reg. en el MySQL.
    }
  }
  ejecutarTransaccion($transaccion);
?>
