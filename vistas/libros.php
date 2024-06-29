

<?php
ob_start();
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.html");
}else{
    require 'header.php';
    $nombre_usuario = $_SESSION['nombre_completo'];
    
    ?>
    <body>    
    <div class="container">
    <h1 style="text-align: center;">Libreria</h1>
    </div>
    
    <div class="card">



    <div class="card-header">
    <h3 class="card-title">¿Que libros deseas reservar?</h3>
    
    </div>
    <!-- /.card-header -->
    <div class="card-body">

    <select name="categorias" id="categorias" class="form-select" aria-label="Default select example">
  
</select>


    <table id="tabladatos" class="table table-bordered table-striped">
    <thead >
    <tr>
    <td class="text-center">#</td>
    <td class="text-center">titulo</td>
    <td class="text-center">autor</td>
    <td class="text-center">categoria</td>
    <td class="text-center">status</td>
    </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
    </div>
    <!-- /.card-body -->
    </div>

<!-- Modal -->
<div class="modal fade" id="modalparareservalibro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Reservacion de libros</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idlibroform" name="idlibroform">
      <h2 style="text-align: center;">Nombre del libro: <b id="nombrelibro"></b> </h2>
      <h3 style="text-align: center;">Autor: <b id="autorlibro"></b> </h3>
    <p id="descripcionlibro"></p>
      <hr>
      
      <div>
        <img id="fotodelibro" src="" alt="Previsualización de la imagen" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
      </div>

      <div>
<label for="Fecha Inicio"></label>
      <input type="date" class="form-control" id="fechainicio" name="fechainicio">


      <label for="Fecha Fin"></label>
      <input type="date" class="form-control" id="fechafin" name="fechafin">
      </div>
      
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnparareservar" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>


    
    <?php 
    require 'footer.php';
    ?>
  
    <script src="script/libros.js?v=<?= rand() ?>"></script>
    
    <?php 
}

ob_end_flush();
?>
