<?php
  require_once "conexion.php";

function listaEditoriales()
{
  // Esta funcion generar el Select de las editoriales.
  $mysql = conexionMySQL();
  $sql = "SELECT * FROM editorial";

  $resultado = $mysql->query($sql);
  // Para introducirlo en un Select de HTML.
  $lista = "<select id = 'editorial' name = 'editorial_slc' required>";
  // Obtiene los  registros por nombre de campo.
    $lista .= "<option value =''>- - -</option>";
  while($fila = $resultado->fetch_assoc())
  {
    // Concatena la variable "$lista"
    // $lista .= "<option value ='".$fila["id_editorial"]."'>".$fila["editorial"]."</option>";
  
    // Otra forma de realizarlo, se utiliza con "sprintf" para que lo convierta a cadena
    // y poderla concatenar.
    $lista .= sprintf("<option value = '%d'>%s</option>",$fila["id_editorial"],$fila["editorial"]);
  }

  $lista .= "</select>";

  $resultado->free();
  $mysql->close();

  return $lista;
}

function altaHeroe()
{
  // Nuevo atributo "data-insertar"
  $form = "<form id = 'alta-heroe' class = 'formulario' data-insertar>";
    $form .= "<fieldset>";
      $form .= "<legend>Alta De Super Héroes : </legend>";
      $form .= "<div>";
        $form .= "<label for = 'nombre'>Nombre:</label>";
        // name = es para el backend es como lo renoce, en javascript es id para desencadenar prog.
        $form .= "<input type='text' id = 'nombre' name = 'nombre_txt' required />";
      $form .= "</div>";  
      $form .= "<div>";
        $form .= "<label for = 'imagen'>Imagen:</label>";
        $form .= "<input type='text' id = 'imagen' name = 'imagen_txt' required />";
      $form .= "</div>";  
      $form .= "<div>";
        $form .= "<label for = 'descripcion'>Descripcion:</label>";
        $form .= "<textarea id = 'descripcion' name = 'descripcion_txa' required ></textarea>";
      $form .= "</div>";  
      $form .= "<div>";
        $form .= "<label for = 'editorial'>Editorial:</label>";
        $form .= listaEditoriales();
      $form .= "</div>";  
      $form .= "<div>";
        
        // El usuario no ve en la interfaz formulario.
        // Este se envia al controlador, para ejecutar la instruccion .
        $form .= "<input type='submit' id='insertar-btn' name = 'insertar_btn' value= 'Insertar' />";  
        $form .= "<input type='hidden' id='transaccion' name = 'transaccion' value= 'insertar' />";                  
      $form .= "</div>";  
    $form .= "</fieldset>";
  $form .= "</form>";

  // Separando el código de PHP y HTML, con formato utilizando "printf"  
  return printf($form);
}

function listaEditorialesEditada($id)
{
  //Esta funcion devuelve el nombre de la editorial del super heroe.
  $mysql = conexionMySQL();
  $sql = "SELECT * FROM editorial";

  $resultado = $mysql->query($sql);
  // Para introducirlo en un Select de HTML.
  $lista = "<select id = 'editorial' name = 'editorial_slc' required>";
  // Obtiene los  registros por nombre de campo.
    $lista .= "<option value =''>- - -</option>";
  while($fila = $resultado->fetch_assoc())
  {
    // Concatena la variable "$lista"
    // $lista .= "<option value ='".$fila["id_editorial"]."'>".$fila["editorial"]."</option>";
  
    // Otra forma de realizarlo, se utiliza con "sprintf" para que lo convierta a cadena
    // y poderla concatenar.
    $selected = ($id == $fila["id_editorial"])?"selected":"";

    $lista .= sprintf("<option value = '%d' $selected >%s</option>",$fila["id_editorial"],$fila["editorial"]);
  }

  $lista .= "</select>";

  $resultado->free();
  $mysql->close();

  return $lista;
}

function editarHeroe($idHeroe)
{
  $mysql = conexionMYSQL();
  $sql = "SELECT * FROM heroes WHERE id_heroe = $idHeroe";
  if ($resultado=$mysql->query($sql))
  {
    // Muestro form con los datos del registro.
    // Editando los datos del registro.

    // fetch_assoc() = Permite traer de un registro con su nombre de campo
    // $fila es un arreglo con el contenido de los nombres de los campos del registro 
    $fila = $resultado->fetch_assoc();

    $form = "<form id = 'editar-heroe' class = 'formulario' data-editar>";
      $form .= "<fieldset>";
        $form .= "<legend>Edicion De Super Héroes : </legend>";
        $form .= "<div>";
          $form .= "<label for = 'nombre'>Nombre:</label>";
          // name = es para el backend es como lo renoce, en javascript es id para desencadenar prog.
          $form .= "<input type='text' id = 'nombre' name = 'nombre_txt' value = '".$fila["nombre"]."' required />";
        $form .= "</div>";  
        $form .= "<div>";
          $form .= "<label for = 'imagen'>Imagen:</label>";
          $form .= "<input type='text' id = 'imagen' name = 'imagen_txt' value = '".$fila["imagen"]."'required />";
        $form .= "</div>";  
        $form .= "<div>";
          $form .= "<label for = 'descripcion'>Descripcion:</label>";
          $form .= "<textarea id = 'descripcion' name = 'descripcion_txa' required >".$fila["descripcion"]."</textarea>";
        $form .= "</div>";  
        $form .= "<div>";
          $form .= "<label for = 'editorial'>Editorial:</label>";
          $form .= listaEditorialesEditada($fila["editorial"]);
        $form .= "</div>";  
        $form .= "<div>";
        $form .= "<input type='submit' id='actualizar' name = 'actualizar_btn' value= 'Actualizar' />";    
          // El usuario no ve en la interfaz formulario.
          // Este se envia al controlador, para ejecutar la instruccion .
          $form .= "<input type='hidden' id='transaccion' name = 'transaccion' value= 'actualizar' />";           
          // NO se puede modificar el "id" del superheroe, es único es la llave.          
          $form .= "<input type='hidden' id='idHeroe' name = 'idHeroe' value= '".$fila["id_heroe"]."' />";                 

        $form .= "</div>";  
        // Nuevo atributo "data-editar"
      $form .= "</fieldset>";
    $form .= "</form>";
    $resultado->free();
  }
  else
  {
    // Muestro un mensaje de error.
    $form = "<div class = 'error'>Error : No se ejecuto la consulta a la Base de Datos </div>";
  }

  $mysql->close();
  

  // Separando el código de PHP y HTML, con formato utilizando "printf"  
  return printf($form);
}

function catalogoEditoriales()
{
  // echo "funciona catalogEditoriales";
  $editoriales = Array();

  $mysql = conexionMySQL();
  $sql = "SELECT * FROM editorial";
  if ($resultado = $mysql->query($sql))
  {
    // Se llena el arreglo de las editoriales.  
    while($fila = $resultado->fetch_assoc())
    {
      $editoriales[$fila["id_editorial"]] = $fila["editorial"];
    }
    $resultado->free();

  }
  $mysql->close();

  // Para determinar la forma de un objeto en PHP
  // print_r($editoriales);
  return $editoriales;
}
// catalogoEditoriales();

/*
Pasos para conectarse a una Base De Datos MySQL en PHP
1.- Objeto de conexion : $mysql = conexionMySQL().
2.- Consulta SQL : $sql = "SELECT * FROM heroes ORDER BY id_heroe DESC";
3.- Ejecutar la consulta :  $resultado = $mysql->query($sql)
4.- Mostrar los resultados :  $fila = $resultado->fetch_assoc()
*/

  function mostrarHeroes()
  {
    // Se asignan las editoriales que se manejan.
    $editorial = catalogoEditoriales();
    $mysql = conexionMySQL();
    $sql = "SELECT * FROM heroes ORDER BY id_heroe DESC";
    // Es un valor boolean.
    if($resultado = $mysql->query($sql))
    {
      // Determina si existen registros de la consulta.
      if (mysqli_num_rows($resultado)==0)
      {
        $respuesta = "<div class = 'error'>No hay registros en la Base De Datos</div>";
      }
      else
      {
        $tabla = "<table id = 'tabla-heroes' class = 'tabla'>";
        $tabla .= "<thead>";
          $tabla .= "<tr>"; // Renglon del encabezado.
            $tabla .= "<th>Id Héroe</th>"; // Columna del Encabezado
            $tabla .= "<th>Nombre</th>";
            $tabla .= "<th>Imagen</th>";
            $tabla .= "<th>Descripcion</th>";            
            $tabla .= "<th>Editorial</th>";            
            $tabla .= "<th></th>";            
            $tabla .= "<th></th>";                        
          $tabla .= "</tr>";
        $tabla .= "</thead>";      
        $tabla .= "<tbody>";
        // En esta parte se coloca el contenido de la consulta anterior.
        // fetch_assoc() = Permite traer de un registro con su nombre de campo
        // $fila es un arreglo con el contenido de los nombres de los campos del registro 
          while ($fila = $resultado->fetch_assoc())
          {
            // Con fetch_row()
            //"<td>".$fila[0]."</td>";
            // Para desplegar la imagen, debe ser formato "png" y si afecta mayuscalas y 
            // minusculas.
            $tabla .= "<tr>";
              $tabla .= "<td>".$fila["id_heroe"]."</td>";
              $tabla .= "<td><h2>".$fila["nombre"]."</h2></td>";              
              $tabla .= "<td><img src='img/".$fila["imagen"]."' /></td>";
              $tabla .= "<td><p>".$fila["descripcion"]."</p></td>";              
              $tabla .= "<td><h3>".$editorial[$fila["editorial"]]."</h3></td>";
              $tabla .= "<td><a href= '#' class = 'editar' data-id = '".$fila["id_heroe"]."'>Editar</a></td>";
              // no se coloca ID, porque como esta dentro del While no lo hace único.
              $tabla .= "<td><a href= '#' class = 'eliminar' data-id = '".$fila["id_heroe"]."'>Eliminar</a></td>";
              // Si se inspecciona el elemento, se mostrara con el "id_heroe" que le corresponde.
            $tabla .= "</tr>";
          }
          // Cada vez que se termine, se tiene que liberar la variable, para que no ocupe espacio
          // inecesario.
          $resultado->free();


        $tabla .= "</tbody>";      
      $tabla .= "</table>";

      $respuesta = $tabla;
        
      }
    }
    else
    {
      $respuesta = "<div class = 'error'>Error : No se ejecuto la consulta a la Base de Datos </div>";

    }
      // Se tiene que cerrar la conexion a la base de datos 
      $mysql->close();

    return printf($respuesta); 
    // NO se requiere otro argumento ya que no se utiliza en la cadena %s.

  }

?>