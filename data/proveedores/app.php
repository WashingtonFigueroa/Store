<?php 
	if(!isset($_SESSION)) {
        session_start();        
    }
    
    include_once('../../admin/datos_sri.php');
	include_once('../../admin/datos_cedula.php');
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();
	error_reporting(0);

	if (isset($_POST['Guardar']) == "Guardar") {
		// contador proveedores
		$id_proveedor = 0;
		$resultado = $class->consulta("SELECT max(id) FROM proveedores");
		while ($row = $class->fetch_array($resultado)) {
			$id_proveedor = $row[0];
		}
		$id_proveedor++;
		// fin

		if(isset($_FILES["file_1"])) {
			$temporal = $_FILES['file_1']['tmp_name'];
            $extension = explode(".",  $_FILES['file_1']['name']); 
            $extension = end($extension);                    			            
            $nombre = $id_proveedor.".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            } else {
            	$dirFoto = "./fotos/defaul.jpg";	
            }      	
		}

		$class->consulta("INSERT INTO proveedores VALUES  (	'$id_proveedor',
															'$_POST[select_documento]',
															'$_POST[identificacion]',
															'$_POST[razon_social]',
															'$_POST[nombre_comercial]',
															'$_POST[telefono1]',
															'$_POST[telefono2]',
															'$_POST[ciudad]',
															'$_POST[direccion]',
															'$_POST[correo]',
															'$_POST[cupo_credito]',
															'$dirFoto',
															'$_POST[observaciones]',
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
            $nombre = $_POST["id_proveedor"].".".$extension;
            $destino = "./fotos/".$nombre;			            
            $root = getcwd();	
            if(move_uploaded_file($temporal, $root.$destino)) {
            	$dirFoto = $destino;
            }     	
		}

		if($dirFoto == '') {
			$class->consulta("UPDATE proveedores SET	id_tipo_documento = '$_POST[select_documento]',
														identificacion = '$_POST[identificacion]',
														razon_social = '$_POST[razon_social]',
														nombre_comercial = '$_POST[nombre_comercial]',
														telefono1 = '$_POST[telefono1]',
														telefono2 = '$_POST[telefono2]',
														ciudad = '$_POST[ciudad]',
														direccion = '$_POST[direccion]',
														correo = '$_POST[correo]',
														cupo = '$_POST[cupo_credito]',
														observaciones = '$_POST[observaciones]',
														fecha_creacion = '$fecha' WHERE id = '".$_POST['id_proveedor']."'");	
		} else {
			$class->consulta("UPDATE proveedores SET	id_tipo_documento = '$_POST[select_documento]',
														identificacion = '$_POST[identificacion]',
														razon_social = '$_POST[razon_social]',
														nombre_comercial = '$_POST[nombre_comercial]',
														telefono1 = '$_POST[telefono1]',
														telefono2 = '$_POST[telefono2]',
														ciudad = '$_POST[ciudad]',
														direccion = '$_POST[direccion]',
														correo = '$_POST[correo]',
														cupo = '$_POST[cupo_credito]',
														imagen = '$dirFoto',
														observaciones = '$_POST[observaciones]',
														fecha_creacion = '$fecha' WHERE id = '".$_POST['id_proveedor']."'");	
		}

		$data = 2;
		echo $data;
	}

	//comprarar identificaciones proveedores
	if (isset($_POST['comparar_identificacion'])) {
		$cont = 0;

		$resultado = $class->consulta("SELECT * FROM proveedores C WHERE C.id_tipo_documento = '$_POST[tipo_documento]' AND C.identificacion = '$_POST[identificacion]'");
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

	//LLena combo tipo documentos
	if (isset($_POST['llenar_tipo_documento'])) {
		$id = $class->idz();
		$resultado = $class->consulta("SELECT id, nombre_tipo_documento, principal FROM tipo_documento WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['nombre_tipo_documento'].'</option>';
			} else {
				print '<option value="'.$row['id'].'">'.$row['nombre_tipo_documento'].'</option>';
			}
		}
	}
	// fin

	// consultar ruc
	if (isset($_POST['consulta_ruc'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new ServicioSRI();///creamos nuevo objeto de servicios SRI
		$datosEmpresa = $servicio->consultar_ruc($ruc); ////accedemos a la funcion datosSRI
		$establecimientos = $servicio->establecimientoSRI($ruc);

		print_r(json_encode(['datosEmpresa'=>$datosEmpresa,'establecimientos'=>$establecimientos]));		
	}
	// fin

	// consultar cedula
	if (isset($_POST['consulta_cedula'])) {
		$ruc = $_POST['txt_ruc'];
		$servicio = new DatosCedula();///creamos nuevo objeto de antecedentes
		$datosCedula = $servicio->consultar_cedula($ruc); ////accedemos a la funcion datosSRI

		print_r(json_encode(['datosPersona'=>$datosCedula]));		
	}
	// fin
?>