$(document).ready(function () {
  $('.nav-item').click(function (event) {
      event.preventDefault();
      switch ($(this).attr('id')) {
            case 'RevisarT':
                location.reload();
                 break;
            case 'AgregarT':
                $("#contenido").load("ContenidosIndex.php #Agregar");
                 break;
            case 'Usettings':
                $("#contenido").load("ContenidosIndex.php #Ajustes");
                break;
            case 'AdminOp':
                $("#contenido").load("ContenidosIndex.php #AdminSettings");
                break;
            case 'BuscarT':
                $("#contenido").load("ContenidosIndex.php #Buscar");
                 break;
      };
  });
});

$(document).on('click', '.Tarea', function(event){
  event.preventDefault();
  var id = $(this).attr('value');
  switch ($(this).attr('id')) {
    case 'EliminardeDB':
        $("#test").load("EliminarTarea.php", {IDTarea: id });
         break;
    case 'ModificarenDB':
         $("#contenido").load("ContenidosIndex.php #Modificar", {IDTarea: id });
          break;
  };
});

$(document).on('submit', '#AgT', function(event){
  event.preventDefault();
  var texto = $("#AG-texto").val();
  var fecha = $("#AG-fecha").val();
  var etiquetas = $("#AG-etiquetas").val();
  var estado = $("#AG-estado").val();
  $( "#test" ).load("agregarTarea.php", {
    fecha: fecha,
    texto: texto,
    etiquetas: etiquetas,
    estado: estado
  });
});

$(document).on('submit', '#ModT', function(event){
  event.preventDefault();
  var IDTarea = $("#MD-IDT").val();
  var texto = $("#MD-texto").val();
  var fecha = $("#MD-fecha").val();
  var etiquetas = $("#MD-etiquetas").val();
  var estado = $("#MD-estado").val();
  $( "#test" ).load("modificarTarea.php", {
    fecha: fecha,
    texto: texto,
    etiquetas: etiquetas,
    IDTarea: IDTarea,
    estado: estado
  });
});

$(document).on('submit', '#UserSet', function(event){
  event.preventDefault();
  var nombre = $("#US-nombre").val();
  var email = $("#US-email").val();
  $( "#test" ).load("modificarUsuario.php", {
    nombre: nombre,
    email: email
  });
});

$(document).on('submit', '#AdminStt', function(event){
  event.preventDefault();
  var admin = $("#Admin-admin").val();
  var estado = $("#Admin-estado").val();
  var email = $("#Admin-lista").val();
  $( "#test" ).load("AdminModificar.php", {
    admin: admin,
    estado: estado,
    email: email
  });
});

$(document).on('submit', '#BuscarT', function(event){
  event.preventDefault();
  var estado = $("#Buscar-tipo").val();
  var texto = $("#Buscar-texto").val();
  alert(texto);
  $( "#test" ).load("BuscarTarea.php", {
    estado: estado,
    texto: texto
  });
});
