var tabla;
var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 2000
});



//mostrar las fechas captura la fecha actual aca agrega a fecha inicio por defecto la fecha actual
var today = new Date(); 

var formatDate = function(date) {
   var day = ("0" + date.getDate()).slice(-2);
   var month = ("0" + (date.getMonth() + 1)).slice(-2);
   return date.getFullYear() + "-" + month + "-" + day;
};

var fechainicio = formatDate(today);

document.getElementById('fechainicio').value = fechainicio;




$.post("../controlador/libros.php?op=selectcategorias", function (r) {
   
   selectdocumentos = JSON.parse(r);
   var selectdocumento = $("#categorias");
   selectdocumento.empty(); // Vaciar el select antes de agregar nuevas opciones
   selectdocumentos.forEach(option => {
      $("#categorias").append('<option value="' + option.value + '">' + option.text + '</option>');
      
   });
});




$('#categorias').on('change', function() {
   
   var filtrocategoria = $('#categorias').val();
   
   listar(filtrocategoria);
})



//iniciar mostrando todos con el valor de0
listar(0);

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




function abrirmodalreserva(iddellibro) {
   
   var id_libro = iddellibro;
   
   $("#idlibroform").val(id_libro);

   $.post("../controlador/libros.php?op=mostrarfiltrodellibro", { id_libro: id_libro },
      function (data) {
         data = JSON.parse(data);
         
         $("#nombrelibro").html(data.titulo_libro);
         $("#autorlibro").html(data.autor);

         $("#descripcionlibro").html(data.descripcion);
         
         
         $("#fotodelibro").attr("src", "../assets/" + data.foto);
         
         
         $("#modalparareservalibro").modal("show")
      })
      
   }
   
   
   
   //escucha el boton de reservar
   
   
   $("#btnparareservar").off('click').on('click', function(e) {
      e.preventDefault();
      var id_libro = $("#idlibroform").val();
      var fechaini = $("#fechainicio").val()
      var fechafin = $("#fechafin").val()
      $.post("../controlador/libros.php?op=guardarreserva", {id_libro: id_libro, fechaini: fechaini, fechafin: fechafin },
         function (data) {
            
            Toast.fire({
               icon: 'success',
               title: data
           })
           tabla.ajax.reload();
            
            $("#modalparareservalibro").modal("hide")
         })
         
         
      });
      