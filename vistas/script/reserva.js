var tabla;
var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 2000
});




$.post("../controlador/reserva.php?op=reservacion", function (r) {
    
   selectdocumentos = JSON.parse(r);
   var selectdocumento = $("#reservacion");
   selectdocumento.empty(); // Vaciar el select antes de agregar nuevas opciones
   selectdocumentos.forEach(option => {
       $("#reservacion").append('<option value="' + option.value + '">' + option.text + '</option>');

   });
});




$('#categorias').on('change', function() {
    
   var filtrocategoria = $('#categorias').val();

   listar(filtrocategoria);
})




listar(1);

//funcion listar
function listar(filtrocategoria) {
   tabla = $('#tabladatos').dataTable({
      "aProcessing": true,//activamos el procedimiento del datatable
      "aServerSide": true,//paginacion y filrado realizados por el server
      //dom: 'Bfrtip',//definimos los elementos del control de la tabla
      "ajax":
      {
         url: '../controlador/libros.php?op=listar',
         type: "post",
         data: {filtrocategoria : filtrocategoria},
         dataType: "json",
         complete: function(data) {
            // Aquí manejas la respuesta JSON
   
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



function reservacion(id_libro) {
   bootbox.confirm("¿Esta seguro de Eliminar este dato?", function (result) {
       if (result) {
           $.post("../controlador/libros.php?op=reservacion", { id_libro: id_libro }, function (e) {
               Toast.fire({
                   icon: 'success',
                   title: e
               })
               tabla.ajax.reload();
           });
       }
   })
}








