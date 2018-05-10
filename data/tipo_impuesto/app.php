<?php 
	if(!isset($_SESSION)){
        session_start();        
    }
	include_once('../../admin/class.php');
	$class = new constante();
	$fecha = $class->fecha_hora();

	// contador tipo impuesto
	$id_tipo_impuesto = 0;
	$resultado = $class->consulta("SELECT max(id) FROM tipo_impuesto");
	while ($row = $class->fetch_array($resultado)) {
		$id_tipo_impuesto = $row[0];
	}
	$id_tipo_impuesto++;
	// fin

	if ($_POST['oper'] == "add") {
		$resultado = $class->consulta("SELECT count(*) FROM tipo_impuesto WHERE nombre_tipo_impuesto = '$_POST[nombre_tipo_impuesto]'");
		while ($row = $class->fetch_array($resultado)) {
			$data = $row[0];
		}

		if ($data != 0) {
			$data = "3";
		} else {
			$class->consulta("INSERT INTO tipo_impuesto VALUES ('$id_tipo_impuesto','$_POST[codigo]','$_POST[nombre_tipo_impuesto]','$_POST[principal]','$_POST[observaciones]','1','$fecha');");
			$data = "1";
		}
	} else {
	    if ($_POST['oper'] == "edit") {
	    	$resultado = $class->consulta("SELECT count(*) FROM tipo_impuesto WHERE nombre_tipo_impuesto = '$_POST[nombre_tipo_impuesto]' AND id NOT IN ('".$_POST['id']."')");
			while ($row = $class->fetch_array($resultado)) {
				$data = $row[0];
			}

			if ($data != 0) {
			 	$data = "3";
			} else {
				$class->consulta("UPDATE tipo_impuesto SET codigo = '$_POST[codigo]',nombre_tipo_impuesto = '$_POST[nombre_tipo_impuesto]',principal = '$_POST[principal]',observaciones = '$_POST[observaciones]',estado = '$_POST[estado]',fecha_creacion = '$fecha' WHERE id = '".$_POST['id']."'");
	    		$data = "2";
			}
	    } else {
	    	if ($_POST['oper'] == "del") {
	    		$class->consulta("UPDATE tipo_impuesto SET estado = '0' WHERE id = '".$_POST['id']."'");
	    		$data = "4";	
	    	}
	    }
	}

	echo $data;
?>