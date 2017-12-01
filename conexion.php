<?php
// Es mejor que include, "require_one" muestra error  y no avanza.
// Solamente se agrega una sola vez.
//include("config.php");
require_once("config.php");

function conexionMySQL()
{

    // Para conectarse a la base de datos se utiliza la clase "mysqli"..
    $conexion = new mysqli(SERVER,USER,PASS,BD);
    // Si es verdadero, no se conecto.
    if ($conexion->connect_error)
    {
        // Generar codigo HTML se genera en una cadena.
        $error = "<div class = 'error'>";
        // Concaternar la continuacion de cadena.
        $error .= "Error De Conexion N° <b>".$conexion->connect_errno."</b> Mensaje del error: <mark>".$conexion->connect_error."</mark>";
        $error .="</div>";
        // Termina de ejecutar el script
        die($error);
        
    }
    else
    {
        //$formato = "<div> class = 'mensaje'>Conexion exitosa <b>".$conexion->host_info.</b></div>";
        //echo $formato;

        // funciones para imprimir con formatos PHP.
        // $formato = "<div class = 'mensaje'>Conexion exitosa <b> %s </b></div>";

        // Documentacion de los formatos http://php.net/manual/es/function_printf.php
        // revisar las tablas para determinar que argumento usar %s, %b,.....
        //printf($formato,$conexion->host_info);
        
    }

    // Es para caracteres en español de los registros en la Base De Datos
    $conexion->query("SET CHARACTER SET UTF8");
    return $conexion;

 }
// conexionMySQL();

?>