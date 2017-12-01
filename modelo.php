<?php
  require_once "conexion.php";

  function insertarHeroe($nombre,$imagen,$descripcion,$editorial)
  {
    // Cuando es "0" mySQL automáticamente inserta en el último que lleva + 1
    $sql = "INSERT INTO heroes (id_heroe,nombre,imagen,descripcion,editorial) VALUE (0,'$nombre','$imagen','$descripcion',$editorial)";
    $mySQL = conexionMySQL();

    if($resultado = $mySQL->query($sql))
    {
      $respuesta =  "<div class = 'exito' data-recargar>Se inserto con éxito el registro del SuperHeroe : <b>$nombre</b></div>";
    }
    else
    {
      $respuesta =  "<div class = 'error' >Ocurrió un error NO se inserto el reg. del superHeroe : <b>$nombre</b></div>";
    }
    $mySQL->close();

    return printf($respuesta);
  }

  function eliminarHeroe($id)
  {
    
    $sql = "DELETE FROM heroes WHERE id_heroe=$id";
    $mySQL = conexionMySQL();

    if($resultado = $mySQL->query($sql))
    {
      $respuesta =  "<div class = 'exito' data-recargar>Se elimino el registro con exito el Super Heroe con el Id  <b>$id</b></div>";
    }
    else
    {
      $respuesta =  "<div class = 'error' >Ocurrió un error NO se ielimino el reg. del superHeroe : <b>$id</b></div>";
    }
    $mySQL->close();

    return printf($respuesta);
  }

?>