

<?php
ob_start();
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.html");
}else{
    require 'header.php';
	$titulo_libro = $_SESSION['titulo_libro'];
    $autor = $_SESSION['autor'];
	$descripcion = $_SESSION['descripcion'];

    
    ?>
    
    <body>
    <div class="container">
    <h1 style="text-align: center;">Nombre del libro: <?php echo $titulo_libro ?>  </h1>
    <h3 style="text-align: center;">Autor: <?php echo $autor ?> </h3>
    </div>
    
    <div class="card-header">
    <h3 class="card-title">Descripcion: <?php echo $descripcion ?> </h3>
    <img src="assets/100Soledad.jpeg" alt="foto del libro">
    </div>
    
    <!-- /.card-header -->
    <div class="card-body">

    <select name="categorias" id="categorias" class="form-select" aria-label="Default select example">
    </select>
    </div>
    <!-- /.card-body -->
    </div>
    
    
    
    <?php 
    require 'footer.php';
    ?>
    
    
    
    <script src="script/reserva.js?v=<?= rand() ?>"></script>
    
    <?php 
}

ob_end_flush();
?>
