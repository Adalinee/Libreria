

var correo
var contrasena
var nombre


var Toast = Swal.mixin({
   toast: true,
   position: 'top-end',
   showConfirmButton: false,
   timer: 2000
});

$("#frmAcceso").on('submit', function (e) {
   e.preventDefault();
   correo = $("#correo").val();
   contrasena = $("#contrasena").val();
   
   
   if (correo.trim() === '' || contrasena.trim() === '') {
      Toast.fire({
         icon: 'error',
         title: 'Por Favor Completar Todos los Campos'
      }).then(() => {
         $(location).attr("href", "../index.php");
      });
   }
   
   else { //si hay datos, enviar a validar al controlador con ajax
      //es un ajax simplificado
      
      $.post("../controlador/usuario.php?op=verificar", { "correo": correo, "contrasena": contrasena },
         function (data) {
            
            try {
               var dataObject = JSON.parse(data); // Intentar convertir la respuesta a un objeto
               
               if ('id' in dataObject) {
                  //console.log("El ID de usuario es: " + idUsuario);
                  Toast.fire({
                     icon: 'success',
                     title: 'Bienvenido'
                  }).then(() => {
                     $(location).attr("href", "home.php");
                  });
               } else {
                  //console.log("La propiedad idusuario no existe en el objeto data.");
                  Toast.fire({
                     icon: 'error',
                     title: 'Usuario y/o Password incorrectos'
                  }).then(() => {
                     $(location).attr("href", "../index.php");
                  });
               }
            } catch (error) {
               //console.error("Error al procesar la respuesta:", error);
               Toast.fire({
                  icon: 'error',
                  title: 'Error al verificar el usuario \n Usuario o Contraseña Incorrecta'
               }).then(() => {
                  $(location).attr("href", "../index.php");
               });
            }
         });
         
      }
   })
   
   
   
   
   // REgistro de usuarios
   
   
   $("#frmRegistro").on('submit', function (e) {
      e.preventDefault();
      
      nombre = $("#nombre_completo").val();
      correo = $("#correodos").val();
      contrasena = $("#contrasenados").val();
      
      
      if (nombre.trim() === '' || correo.trim() === '' || contrasena.trim() === '') {
         
         Toast.fire({
            icon: 'error',
            title: 'Por Favor Completar Todos los Campos'
         }).then(() => {
            $(location).attr("href", "../index.php");
         });
      }
      
      else { //si hay datos, enviar a validar al controlador con ajax
         
         $.post("../controlador/usuario.php?op=guardarregistrousuario", { "nombre": nombre, "correo": correo, "contrasena": contrasena },
            function (data) {
            
               //console.log("El ID de usuario es: " + idUsuario);
               Toast.fire({
                  icon: 'success',
                  title: data
               }).then(() => {
                  $(location).attr("href", "../index.php");
               });
               
            });
            
         }
      })
      
      
      
      
      
      
      
      