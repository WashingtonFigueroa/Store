<?php 
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	// error_reporting(0);

	// guardar facturas
	if (isset($_POST['btn_guardar']) == "Guardar") {
		$fecha = $class->fecha_hora();
		$fecha_corta = $class->fecha();

		// contador factura
		$id_factura = 0;
		$resultado = $class->consulta("SELECT max(id) FROM factura_compra");
		while ($row = $class->fetch_array($resultado)) {
			$id_factura = $row[0];
		}
		$id_factura++;
		// fin

		// guardar factura compra
		$class->consulta("INSERT INTO factura_compra VALUES  (	'".$id_factura."',
																'".$_SESSION['empresa']['id']."',
																'".$_POST['id_proveedor']."',
																'".$_SESSION['user']['id']."',
																'".$_POST['fecha_emision']."',
																'".$_POST['fecha_registro']."',
																'".$_POST['fecha_caducidad']."',
																'".$_POST['fecha_cancelacion']."',
																'',
																'1',
																'".$_POST['serie']."',
																'".$_POST['autorizacion']."',
																'".$_POST['select_forma_pago']."',
																'".$_POST['subtotal']."',
																'".$_POST['tarifa']."',
																'".$_POST['tarifa_0']."',
																'".$_POST['iva']."',
																'".$_POST['otros']."',
																'".$_POST['total_pagar']."',
																'',
																'1', 
																'".$fecha."')");
		// fin

		// datos detalle factura
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    $campo3 = $_POST['campo3'];
	    $campo4 = $_POST['campo4'];
	    $campo5 = $_POST['campo5'];
	    // Fin

	    // descomponer detalle factura
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $arreglo3 = explode('|', $campo3);
	    $arreglo4 = explode('|', $campo4);
	    $arreglo5 = explode('|', $campo5);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// contador detalle factura
			$id_detalle_factura = 0;
			$resultado = $class->consulta("SELECT max(id) FROM detalle_factura_compra");
			while ($row = $class->fetch_array($resultado)) {
				$id_detalle_factura = $row[0];
			}
			$id_detalle_factura++;
			// fin

			$resp = $class->consulta("INSERT INTO detalle_factura_compra VALUES(	'".$id_detalle_factura."',
																					'".$id_factura."',
																					'".$arreglo1[$i]."',
																					'".$arreglo2[$i]."',
																					'".$arreglo3[$i]."',
																					'".$arreglo4[$i]."',
																					'".$arreglo5[$i]."',
																					'1', 
																					'".$fecha."')");

			// consultar productos
           	$consulta = $class->consulta("SELECT * FROM productos WHERE id = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($consulta)) {
                $stock = $row[16];
            }

            $cal = $stock + $arreglo2[$i];
            $class->consulta("UPDATE productos SET stock = '$cal' WHERE id = '".$arreglo1[$i]."'");
            // fin

            // consultar movimientos
           	$consulta2 = $class->consulta("SELECT * FROM movimientos WHERE id_producto = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($consulta2)) {
                $entrada = $row[4];
            }

            $cal2 = $entrada + $arreglo2[$i]; 
            $class->consulta("UPDATE movimientos SET entradas = '$cal2', saldo = '$cal' WHERE id_producto = '".$arreglo1[$i]."'");
            // fin

            // contador kardex
			$id_kardex = 0;
			$resultado = $class->consulta("SELECT max(id) FROM kardex");
			while ($row = $class->fetch_array($resultado)) {
				$id_kardex = $row[0];
			}
			$id_kardex++;
			// fin

			// guardar kardex
			$resp = $class->consulta("INSERT INTO kardex VALUES (	'".$id_kardex."',
																	'".$arreglo1[$i]."',
																	'".$fecha_corta."',
																	'".'F.C:'.$_POST['serie']."',
																	'".$arreglo2[$i]."',
																	'".$arreglo3[$i]."',
																	'".$arreglo5[$i]."',
																	'".$cal."',
																	'',
																	'',
																	'1', 
																	'".$fecha."')");
			// fin
	    }

		echo $id_factura;
	}
	// fin

	// LLenar forma pago
	if (isset($_POST['llenar_forma_pago'])) {
		$resultado = $class->consulta("SELECT id, codigo ,nombre_forma, principal FROM formas_pago WHERE estado = '1' order by id asc");
		print'<option value="">&nbsp;</option>';
		while ($row = $class->fetch_array($resultado)) {
			if($row['principal'] == 'Si') {
				print '<option value="'.$row['id'].'" selected>'.$row['codigo'].' - '.$row['nombre_forma'].'</option>';	
			} else {
				print '<option value="'.$row['id'].'">'.$row['codigo'].' - '.$row['nombre_forma'].'</option>';	
			}
		}
	}
	// fin

	// llenar cabezera factura compra
	if (isset($_POST['llenar_cabezera_factura'])) {
		$resultado = $class->consulta("SELECT F.id, F.fecha_emision, F.secuencial, F.id_proveedor, P.identificacion, P.razon_social, P.telefono2, P.direccion, P.correo, F.fecha_registro, F.fecha_caducidad, F.fecha_cancelacion, F.autorizacion, F.id_forma_pago, F.subtotal, F.tarifa, F.tarifa0, F.iva, F.total_descuento, F.total_compra, F.observaciones FROM factura_compra F, proveedores P WHERE F.id_proveedor = P.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_factura' => $row[0],
							'fecha_emision' => $row[1],
							'secuencial' => $row[2],
							'id_proveedor' => $row[3],
							'identificacion' => $row[4],
							'razon_social' => $row[5],
							'telefono' => $row[6],
							'direccion' => $row[7],
							'correo' => $row[8],
							'fecha_registro' => $row[9],
							'fecha_caducidad' => $row[10],
							'fecha_cancelacion' => $row[11],
							'autorizacion' => $row[12],
							'id_forma_pago' => $row[13],
							'subtotal' => $row[14],
							'tarifa' => $row[15],
							'tarifa0' => $row[16],
							'iva' => $row[17],
							'descuento' => $row[18],
							'total_pagar' => $row[19],
							'observaciones' => $row[20]);
		}

		print_r(json_encode($data));
	}
	//fin

	// llenar detalle factura compra
	if (isset($_POST['llenar_detalle_factura'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.nombre_tarifa_impuesto, U.incluye_iva FROM detalle_factura_compra D, factura_compra F, productos U, tarifa_impuesto P  WHERE D.id_producto = U.id AND D.id_factura_compra = F.id AND U.id_porcentaje = P.id AND F.id = '".$_POST['id']."' ORDER BY D.id ASC");
		while ($row = $class->fetch_array($resultado)) {
			$arr_data[] = $row['0'];
		    $arr_data[] = $row['1'];
		    $arr_data[] = $row['2'];
		    $arr_data[] = $row['3'];
		    $arr_data[] = $row['4'];
		    $arr_data[] = $row['5'];
		    $arr_data[] = $row['6'];
		    $arr_data[] = $row['7'];
		    $arr_data[] = $row['8'];
		}

		echo json_encode($arr_data);
	}
	//fin
?>