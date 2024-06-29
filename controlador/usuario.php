<?php


session_start();
require_once "../modelo/Usuario.php";

$usuario = new Usuario();

$idusuariosesion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
$id_reserva = isset($_POST["id_reserva"]) ? limpiarCadena($_POST["id_reserva"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$contrasena = isset($_POST["contrasena"]) ? limpiarCadena($_POST["contrasena"]) : "";



switch ($_GET["op"]) {
	
	case 'guardarregistrousuario':

		$clavehash = hash("SHA256", $contrasena);
		
		$rspta = $usuario->insertar($nombre, $correo, $clavehash);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario";
		break;
	
	
	// eliminar la reserva por usuarios
	case 'desactivar':
		
		$estado = 1;
		
		$rspta = $usuario->desactivar($id_reserva);
		
		if ($rspta) {
			
			//primero obtener el id de libro mediante el id de la reserva
			
			$rsptaobteneridlibro = $usuario->obteneridlibro($id_reserva);
			
			if ($rsptaobteneridlibro["id_libro"]) {

				$id_libro = $rsptaobteneridlibro["id_libro"];

				require_once "../modelo/Libros.php";
				$libros = new Libros();
				
				$rsptalibros = $libros->cambiarestadodelibro($id_libro, $estado);
			}
			
			
		}
		
		echo $rspta ? "Datos Eliminados correctamente" : "No se pudo Eliminar los datos";
		break;
		
		
		case 'listar':
			
			$rspta = $usuario->listar($idusuariosesion);
			if ($rspta) {
				$data = array();
				$cnt = 1;
				
				while ($reg = $rspta->fetch(PDO::FETCH_OBJ)) {
					$data[] = array(
						"0" => $cnt,
						"1" => $reg->titulo_libro,
						"2" => $reg->autor,
						"3" => $reg->nombrecategoria,
						"4" => '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->id_reserva . ')"><i class="fas fa-trash"></i></button>'
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
				
				$rspta = $usuario->verificar($correo, $clavehash);
				
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
					
					
					
				}
				?>