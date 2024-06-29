<?php


session_start();
require_once "../modelo/Reserva.php";

$rserva = new Reserva();

$idusuariosesion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";

$id_libro= isset($_POST["id_libro"]) ? limpiarCadena($_POST["id_libro"]) : "";

$filtrocategoria= isset($_POST["filtrocategoria"]) ? limpiarCadena($_POST["filtrocategoria"]) : "";


switch ($_GET["op"]) {
	
 


		// reservacion
	case 'reservacion':
		$rspta = $lbro->reservacion($id_libro);
		echo $rspta ? "Datos Eliminados correctamente" : "No se pudo Eliminar los datos";
		break;


	case 'listar':

		$rspta = $lbro->listar($filtrocategoria);
		if ($rspta) {
			$data = array();
			$cnt = 1;
			
			while ($reg = $rspta->fetch(PDO::FETCH_OBJ)) {
				$data[] = array(
					"0" => $cnt,
					"1" => $reg->titulo_libro,
					"2" => $reg->autor,
					"3" => $reg->nombrecategoria,
					"4" => $reg->descripcion,
					"5" => '<button class="btn btn-danger btn-xs" onclick="reservacion(' . $reg->id_libro. ')"><i class="fas fa-ticket-alt"></i></button>'
				);
				$cnt++;
			}
			
			$results = array(
				"sEcho" => 1, //info para datatables
				"iTotalRecords" => count($data), //enviamos el total de registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);
		} else {
			// Manejar el error de la consulta
			echo json_encode(array("error" => "Error en la consulta a la base de datos"));
		}
		break;

	
	case 'verificar':
		//validar si el usuario tiene acceso al sistema

		//Hash SHA256 en la contraseña
		$clavehash = hash("SHA256", $contrasena);

		$rspta = $lbro->verificar($correo, $clavehash);

		$fetch = $rspta->fetch(PDO::FETCH_OBJ);
		if ($fetch !== false) {
			# Declaramos la variables de sesion
			$_SESSION['id_usuario'] = $fetch->id;
			$_SESSION['nombre_completo'] = $fetch->nombre_completo;
			$_SESSION['correo'] = $fetch->correo;

		}

		echo json_encode($fetch);



		break;
	case 'salir':
		//limpiamos la variables de la secion
		session_unset();

		//destruimos la sesion
		session_destroy();
		//redireccionamos al login
		header("Location: ../index.php");
		break;

		

		// esto llena el select para las categorias
		case 'selectcategorias':

            $rspta = $lbro->listarcategorias();
            $options = array();
            while ($reg = $rspta->fetch(PDO::FETCH_OBJ)) {
                $options[] = array("value" => $reg->id_categoria, "text" => $reg->descripcion);
            }
            echo json_encode($options);
            break;







     }
?>