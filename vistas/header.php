<?php
if (strlen(session_id()) < 1)
session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi usuario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="../css/sweetalert2.min.css">
<link rel="stylesheet" href="../css/toastr.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css">
<!-- <link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/style.css"> -->

</head>




  <ul class="nav nav-tabs justify-content-end">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="libros.php">LIBROS</a>
  </li>

  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo $_SESSION['nombre_completo'] ?></a>
    <ul class="dropdown-menu">

      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="../controlador/usuario.php?op=salir">Cerrar Sesión</a></li>
    </ul>
  </li>

</ul>




</ul>

