


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
            <h1>Mi nombre: <?php echo $nombre_usuario ?> </h1>
            <h2>Mis reservas en total: <b id="cantidaddereservas"></b> </h2>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mis reservas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabladatos" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <td>#</td>
                    <td>titulo</td>
                    <td>autor</td>
                    <td>categoria</td>
                    <td>status</td>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

    

    <?php 
		require 'footer.php';
		?>
		

		
		<script src="script/home.js?v=<?= rand() ?>"></script>
		
		<?php 
	}

	ob_end_flush();
	?>
