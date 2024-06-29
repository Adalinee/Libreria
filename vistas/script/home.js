
var tabla;

var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 1000
});


listar();

//funcion listar
function listar() {

   $("#cantidaddereservas").empty()

   tabla = $('#tabladatos').dataTable({
      "aProcessing": true,//activamos el procedimiento del datatable
      "aServerSide": true,//paginacion y filrado realizados por el server
      dom: 'Bfrtip',//definimos los elementos del control de la tabla
      "ajax":
      {
         url: '../controlador/usuario.php?op=listar',
         type: "get",
         dataType: "json",
         complete: function(data) {
            // Aquí manejas la respuesta JSON
            console.log(data)
            var cantreservas = data.responseJSON.iTotalRecords; // Puedes usar esto para depuración
            $("#cantidaddereservas").html(cantreservas)
         },
         error: function(e) {
            console.log(e.responseText); // Muestra cualquier error en la consola
         }
      },
      "scrollCollapse": true,
      "select": true,
      "bDestroy": true,
      "autoWidth": false,
      "lengthChange": false,
      "order": [[0, "asc"]],
      language: {
         "decimal": "",
         "emptyTable": "No hay información",
         "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
         "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
         "infoFiltered": "(Filtrado de _MAX_ total entradas)",
         "infoPostFix": "",
         "thousands": ",",
         "lengthMenu": "Mostrar _MENU_ Entradas",
         "loadingRecords": "Cargando...",
         "processing": "Procesando...",
         "search": "Buscar:",
         "zeroRecords": "Sin resultados encontrados",
         "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
         }
      }
   }).DataTable();
}




function desactivar(id_reserva) {
   bootbox.confirm("¿Esta seguro de Eliminar este dato?", function (result) {
       if (result) {
           $.post("../controlador/usuario.php?op=desactivar", { id_reserva: id_reserva }, function (e) {
               Toast.fire({
                   icon: 'success',
                   title: e
               })
               tabla.ajax.reload();
           });
       }
   })
}






