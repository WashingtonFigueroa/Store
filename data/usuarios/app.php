<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	error_reporting(0);
	
	$fecha = $class->fecha_hora();

	if (isset($_POST['Guardar']) == "Guardar") {
		// contador usuarios
		$id_usuarios = 0;
		$resultado = $class->consulta("SELECT max(id) FROM usuarios");
		while ($row = $class->fetch_array($resultado)) {
			$id_usuarios = $row[0];
		}
		$id_usuarios++;
		// fin

		// contador privilegios
		$id_privilegios = 0;
		$resultado = $class->consulta("SELECT max(id) FROM privilegios");
		while ($row = $class->fetch_array($resultado)) {
			$id_privilegios = $row[0];
		}
		$id_privilegios++;
		// fin

		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_usuarios.".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            } else {
            	$dirFoto = "./fotos/defaul.jpg";	
            }      	
		}

		$contrasenia = md5($_POST['clave2']);

		$arreglo = array(	'require',
							'cuenta',
							'empresa',
							'tipo_ambiente',
							'tipo_emision',
							'tipo_comprobante',
							'tipo_documento',
							'tipo_producto',
							'tipo_impuesto',
							'tarifa_impuesto',
							'formas_pago',
							'facturero',
							'categorias',
							'marcas',
							'medida',
							'bodegas',
							'clientes',
							'proveedores',
							'productos',
							'inventario',
							'movimientos',
							'proformas',
							'factura_compra',
							'factura_venta',
							'validar_facturas',
							'nota_credito',
							'ingresos',
							'egresos',
							'kardex',
							'cargos',
							'usuarios',
							'privilegios',
							'reporte_productos',
							'reporte_compras',
							'reporte_ventas',
							'reporte_proformas');

		$array = json_encode($arreglo);

		$class->consulta("INSERT INTO usuarios VALUES (	'$id_usuarios',
														'$_POST[identificacion]',
														'$_POST[nombres_completos]',
														'$_POST[telefono1]',
														'$_POST[telefono2]',
														'$_POST[ciudad]',
														'$_POST[direccion]',
														'$_POST[correo]',
														'$_POST[usuario]',
														'$contrasenia',
														'$_POST[select_cargo]',
														'$dirFoto',
														'$_POST[observaciones]',
														'1', 
														'$fecha')");

		$class->consulta("INSERT INTO privilegios VALUES (	'$id_privilegios',
															'$id_usuarios',
															'$array',
															'1', 
															'$fecha')");	
		
		$data = 1;
		echo $data;
	}

	if (isset($_POST['Modificar']) == "Modificar") {
		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $_POST["id_usuario"].".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE usuarios SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													usuario = '$_POST[usuario]',
													id_cargo = '$_POST[select_cargo]',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id_usuario']."'");	
		} else {
			$class->consulta("UPDATE usuarios SET	identificacion = '$_POST[identificacion]',
													nombres_completos = '$_POST[nombres_completos]',
													telefono1 = '$_POST[telefono1]',
													telefono2 = '$_POST[telefono2]',
													ciudad = '$_POST[ciudad]',
													direccion = '$_POST[direccion]',
													correo = '$_POST[correo]',
													usuario = '$_POST[usuario]',
													id_cargo = '$_POST[select_cargo]',
													imagen = '$dirFoto',
													observaciones = '$_POST[observaciones]' WHERE id = '".$_POST['id_usuario']."'");	
		}	
			
		$data = 2;
		echo $data;
	}

	//comparar identificacion usuarios
	if (isset($_POST['comparar_identificacion'])) {
		$resultado = $class->consulta("SELECT * FROM usuarios U WHERE U.identificacion = '$_POST[identificacion]' AND estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$cont++;
		}

		if ($cont == 0) {
		    $data = 0;
		} else {
		    $data = 1;
		}
		echo $data;
	}
	// fin

	//LLena combo cargos
	if (isset($_POST['llenar_cargo'])) {
		$resultado = $class->consulta("SELECT id, nombre_cargo, principal FROM cargos WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_cargo'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_cargo'].'</option>';
			}
		}
	}
	// fin
?>