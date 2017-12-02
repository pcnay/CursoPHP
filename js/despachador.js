// Constante
  /* 
  Lo utiliza "onreadychange"
  200 = Cargo el recurso, 
  300 = Redireccionando
  404 = Archivos no encontrado
  500 = Error del servidor
  */
  // Otra linea que se agrega.

  // Que ha conectado con el servidor PHP, encontro el archivo.
var READY_STATE_COMPLETE = 4;


// Variables
// Es nulo porque no se sabe que navegador se esta utilizando y 
// se tiene que determinar.
var ajax = null;
var btnInsertar = document.querySelector("#insertar");
var precarga = document.querySelector("#precarga");
var respuesta = document.querySelector("#respuesta");
// Selecciona todos los botones con la clase(.) eliminar, se genera con el while para mostrar.
// Se puede utilizar. document.getElementByClassName... (para los identificadores clases de las etiquetas.) 
var btnsEliminar = document.querySelectorAll(".eliminar");

var btnsEditar = document.querySelectorAll(".editar");
// Funciones
function objetoAJAX()
{
  // Ajax depende del navegador 
  if (window.XMLHttpRequest) // Para detectar los otros navegadores.
  {
    return new XMLHttpRequest();
  }
    else if (window.ActiveXObject) // Para detectar el Navegador de Internet Explorer
  {
    return new ActiveXObject("Microsoft.XMLHTTP")
  }

}

// Se comienza a trabajar con la lógica de programación.
// Esta cachando los datos que envia del servidor (PHP).
function enviarDatos()
{
  // Cargando la simulacion del efecto "girando"
  precarga.style.display = "block"; // 
  precarga.innerHTML = "<img src = 'img/loader.gif' />";

  // LibrosWeb Capitulo 7 / xmlhttprequest
  // Esta terminado de tener comunicacion con el servidor 
  if (ajax.readyState == READY_STATE_COMPLETE)
  {
    // Estado de la peticion;  200 = Son OK
    // Se ejecutaran todas las peticiones de JavaScript.
    if(ajax.status == 200) 
    {
      // ajax.responseText = Contiene todo lo que retorna una vez que se ejecuta "send" Ajax
      // es el archivo que retora.
      // alert( "WIIIIIIIIIII");
      precarga.innerHTML = null; // Para que borre la imagen;
      precarga.style.display = "none";
      respuesta.style.display = "block"; // que se vea la imagen.
      respuesta.innerHTML = ajax.responseText; // Para desplegar el formulario.

      // indexOf() = Evaluar si se encuentra la palabra, retorna un número.
      // Si no encuentra devuelve un -1
      if (ajax.responseText.indexOf("data-insertar")> -1)
      {
        document.querySelector("#alta-heroe").addEventListener("submit",insertarActualizarHeroe);
      }

      // indexOf() = Evaluar si se encuentra la palabra, retorna un número.
      // Si no encuentra devuelve un -1
      if (ajax.responseText.indexOf("data-editar")> -1)
      {
        document.querySelector("#editar-heroe").addEventListener("submit",insertarActualizarHeroe);
      }


      // Para recargar la página cuando se termina de insertar los datos.
      if (ajax.responseText.indexOf("data-recargar")> -1)
      {
        setTimeout(window.location.reload(),5000);
      }
    }
    else
    {
      // "/n" ya que no se puede introducir código HTML.

      alert ("El servidor NO conecto \n Error "+ajax.status+" :"+ajax.statusText);
      // alert ("NOOOOOOOOOOOOOOO");
    }

    //console.log(ajax);    
  }
}

function ejecutarAJAX(dato)
{
  ajax = objetoAJAX();
  // Detecta los cambios de estado, cuando cambie llama a la funcion "enviarDatos" 
  ajax.onreadystatechange= enviarDatos;
  // Antes de ejecutar "enviarDatos", debe abrir el archivo "controlador.php"
  // Abre el archivo en el Backend.
  ajax.open("POST","controlador.php"); // aun que este vacio, pero si lo encontro
  // Este línea realiza la ejecución del programa sin recargar la página
  
  // MIME ajax
  // Se pasa como parámetro de formulario, en este caso.
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  ajax.send(dato);
  // Se ejecutan los 3 ultimas líneas para ejecutar la funcion "enviarDatos".
}

function insertarActualizarHeroe(evento)
{
  // Previene que se ejecute por defecto el "submit" que es enviar los datos y desaparece 
  // el formulario.
  evento.preventDefault();
  //alert("Procesa Formulario");
  //console.log(evento.target) // = El evento que lo origino, en este caso es el formulario.
  //console.log(evento.target[1]);// = Es el primer elemento hijo del formulario "fieldset"
  //console.log(evento.target.length) //= Es el número total de elementos (7) que tiene el formulario 
  var nombre = new Array();
  var valor = new Array();
  var hijosForm = evento.target; // Asigna todas las etiquetas hijos del formulario.

  var datos = "";
  // no se toma encuenta el "fielset", se inicia desde 1
  for (var i=1;i<hijosForm.length;i++)
  {
    nombre[i] = hijosForm[i].name; // Para extraer el nombre de la etiqueta.
    valor[i] = hijosForm[i].value; // Para extraer el valor de la etiqueta hijo en cuestion.
                                    // Dato teclado por el usuario.
    datos += nombre[i]+"="+valor[i]+"&";
    // Se utiliza "&" para poder enviar datos al Ajax, es por el cual lo separa.
    //console.log(datos);
  }
    
  // comienza a procesar los datos del formulario para guardarlos en la Base De Datos.
  ejecutarAJAX(datos);
}
function altaHeroe(evento)
{
  evento.preventDefault();
  // alert("Funciona"); solo para determinar que funciona al hacer click
  // Operacion de base de datos se le llama "transaccion"
  var dato = "transaccion=alta";
  ejecutarAJAX(dato);


}

function eliminarHeroe(evento)
{
  var idHeroe = evento.target.dataset.id;
  var eliminar = confirm("Estas seguro de eliminar al Super Heroe con id "+idHeroe);
  evento.preventDefault(); // previene el funcionamiento por defecto, ya que tiene "#" y 
                            // no lo despliege en la URL.
  // Se esta tomando el valor del atributo escrito "data-id"
  // En javaScript el dataset = data, del atributo anterior.
  //alert(evento.target.dataset.id);

  // Ahora se comunicara con Ajax para eliminar el registro.
  if (eliminar)
  {
    var dato = "idHeroe="+idHeroe+"&transaccion=eliminar";
    ejecutarAJAX(dato);

  }

}

function editarHeroe(evento)
{
  // previene el funcionamiento por defecto, ya que tiene "#" y no lo despliege en la URL.
  evento.preventDefault();
  // alert(evento.target.dataset.id);
  
  // Se esta tomando el valor del atributo escrito "data-id"
  // En javaScript el dataset = data, del atributo anterior.
  var idHeroe = evento.target.dataset.id
  // Creando los datos que se le pasaran al Ajax.
  // $transaccion, le indica al controlador que va a realizar
  var datos = "idHeroe="+idHeroe+"&transaccion=editar";

  ejecutarAJAX(datos);

}

function alCargarDocumento()
{
  btnInsertar.addEventListener("click",altaHeroe);
  // Para borrar un registro.
  for (var i=0; i<btnsEliminar.length; i++)
  {
    btnsEliminar[i].addEventListener("click",eliminarHeroe);
  }

  // Para editar un registro.
  for (var i=0; i<btnsEditar.length; i++)
  {
    btnsEditar[i].addEventListener("click",editarHeroe);
  }
  
}

// Eventos
window.addEventListener("load",alCargarDocumento);