$(document).ready(function () {
  $('.Tarea').click(function (event) {
      event.preventDefault();
      var id = $(this).attr('value')
      switch ($(this).attr('id')) {
          case 'EliminardeDB':
              $("#test").load("EliminarTarea.php", {IDTarea: id });
               break;
          case 'ModificarenDB':
               $("#contenido").load("ContenidosIndex.php #Modificar", {IDTarea: id });
                break;


      };
  });
});

$(document).ready(function () {
  $('.nav-item').click(function (event) {
      event.preventDefault();
      switch ($(this).attr('id')) {
          case 'BuscarT':
              location.reload();
              $("#contenido").load("indexBuscarTarea.php #contenido");
               break;
          case 'AgregarT':
              $("#contenido").load("ContenidosIndex.php #Agregar");
               break;
      };
  });
});
