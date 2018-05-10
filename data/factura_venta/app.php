<?php        
	include_once('../../admin/class.php');
	$class = new constante();
	session_start(); 
	ini_set('max_execution_time', 240); //240 segundos = 4 minutos
	error_reporting(0);

	if (isset($_POST['btn_guardar']) == "Guardar") {
		$fecha = $class->fecha_hora();
		$fecha_corta = $class->fecha();
		include 'generarXML.php';	
		include 'firma/firma.php';	
		include 'firma/xades.php';
		include_once('../../admin/correolocal.php');

		// contador factura
		$id = 0;
		$resultado = $class->consulta("SELECT max(id) FROM factura_venta");
		while ($row = $class->fetch_array($resultado)) {
			$id = $row[0];
		}
		$id++;
		// fin

		$defaultMail = mailDefecto;
		$codDoc = '01'; // tipo documento

		// parametros empresa
		$resultado = $class->consulta("SELECT ruc, token, clave, establecimiento, punto_emision FROM empresa WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ruc = $row[0];
			$token = $row[1];
			$pass = $row[2];
			$establecimiento = $row[3];
			$punto_emision = $row[4];
		}
		// fin

		// parametro ambiente
		$resultado = $class->consulta("SELECT codigo FROM tipo_ambiente WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}
		// fin

		// parametro emision
		$resultado = $class->consulta("SELECT codigo FROM tipo_emision WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
		}
		// fin

		// generar clave
		$clave = $class->generarClave($_POST['fecha_emision'],$codDoc,$ruc,$ambiente,$establecimiento.''.$punto_emision,$_POST['serie'],$_POST['fecha_emision'],$emision);
		// fin


		if ($_POST['id_cliente'] != "") {
			// guardar factura normal
			$class->consulta("INSERT INTO factura_venta VALUES  (	'".$id."',
																	'".$_SESSION['empresa']['id']."',
																	'".$_POST['id_cliente']."',
																	'".$_SESSION['user']['id']."',
																	'".$_POST['fecha_emision']."',
																	'',
																	'',
																	'',
																	'".$clave."',
																	'".$establecimiento."',
																	'".$punto_emision."',
																	'".$_POST['serie']."',
																	'".$ambiente."',
																	'".$emision."',
																	'',
																	'1',
																	'".$_POST['select_forma_pago']."',
																	'".$_POST['select_tipo_precio']."',
																	'".$_POST['subtotal']."',
																	'".$_POST['tarifa']."',
																	'".$_POST['tarifa_0']."',
																	'".$_POST['iva']."',
																	'".$_POST['otros']."',
																	'".$_POST['total_pagar']."',
																	'".$_POST['efectivo']."',
																	'".$_POST['cambio']."',
																	'9', 
																	'".$fecha."')");
			// fin
		} else {
			// contador clientes
			$id_cliente = 0;
			$resultado = $class->consulta("SELECT max(id) FROM clientes");
			while ($row = $class->fetch_array($resultado)) {
				$id_cliente = $row[0];
			}
			$id_cliente++;
			// fin
			$dirFoto = "./fotos/defaul.jpg";

			if (strlen($_POST['ruc']) == 10) {
				// guardar cliente cedula
				$class->consulta("INSERT INTO clientes VALUES  (	'".$id_cliente."',
																	'2',
																	'".$_POST['ruc']."',
																	'".$_POST['razon_social']."',
																	'".$_POST['nombre_comercial']."',
																	'',
																	'".$_POST['telefono']."',
																	'',
																	'".$_POST['direccion']."',
																	'".$_POST['correo']."',
																	'0.00',
																	'".$dirFoto."',
																	'',
																	'1', 
																	'".$fecha."')");
			} else {
				if (strlen($_POST['ruc']) == 13) {
					// guardar cliente ruc
					$class->consulta("INSERT INTO clientes VALUES  (	'".$id_cliente."',
																		'1',
																		'".$_POST['ruc']."',
																		'".$_POST['razon_social']."',
																		'".$_POST['nombre_comercial']."',
																		'',
																		'".$_POST['telefono']."',
																		'',
																		'".$_POST['direccion']."',
																		'".$_POST['correo']."',
																		'0.00',
																		'".$dirFoto."',
																		'',
																		'1', 
																		'".$fecha."')");
				// fin
				}	
			}
			
			// guardar factura nuevo cliente
			$class->consulta("INSERT INTO factura_venta VALUES  (	'".$id."',
																	'".$_SESSION['empresa']['id']."',
																	'".$id_cliente."',
																	'".$_SESSION['user']['id']."',
																	'".$_POST['fecha_emision']."',
																	'',
																	'',
																	'',
																	'".$clave."',
																	'".$establecimiento."',
																	'".$punto_emision."',
																	'".$_POST['serie']."',
																	'".$ambiente."',
																	'".$emision."',
																	'',
																	'1',
																	'".$_POST['select_forma_pago']."',
																	'".$_POST['select_tipo_precio']."',
																	'".$_POST['subtotal']."',
																	'".$_POST['tarifa']."',
																	'".$_POST['tarifa_0']."',
																	'".$_POST['iva']."',
																	'".$_POST['otros']."',
																	'".$_POST['total_pagar']."',
																	'".$_POST['efectivo']."',
																	'".$_POST['cambio']."',
																	'9', 
																	'".$fecha."')");
			// fin	
		}

		
		// modificar proformas
        if ($_POST['id_proforma'] != "") {
        	$class->consulta("UPDATE proforma SET estado = '0' WHERE id = '".$_POST['id_proforma']."'");
        }
        // fin

		// datos detalle factura
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    $campo3 = $_POST['campo3'];
	    $campo4 = $_POST['campo4'];
	    $campo5 = $_POST['campo5'];
	    $campo6 = $_POST['campo6'];
	    // Fin

	    // descomponer detalle factura
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $arreglo3 = explode('|', $campo3);
	    $arreglo4 = explode('|', $campo4);
	    $arreglo5 = explode('|', $campo5);
	    $arreglo6 = explode('|', $campo6);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// contador detalle factura
			$id_detalle_factura = 0;
			$resultado = $class->consulta("SELECT max(id) FROM detalle_factura_venta");
			while ($row = $class->fetch_array($resultado)) {
				$id_detalle_factura = $row[0];
			}
			$id_detalle_factura++;
			// fin

			$class->consulta("INSERT INTO detalle_factura_venta VALUES (	'".$id_detalle_factura."',
																			'".$id."',
																			'".$arreglo1[$i]."',
																			'".$arreglo2[$i]."',
																			'".$arreglo3[$i]."',
																			'".$arreglo4[$i]."',
																			'".$arreglo5[$i]."',
																			'".$arreglo6[$i]."',
																			'1', 
																			'".$fecha."')");

			// modificar productos
           	$resultado = $class->consulta("SELECT * FROM productos WHERE id = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($resultado)) {
                $stock = $row['stock'];
            }

            $cal = $stock - $arreglo2[$i];
            $class->consulta("UPDATE productos SET stock = '$cal' WHERE id = '".$arreglo1[$i]."'");
            // fin

            // consultar movimientos
           	$resultado = $class->consulta("SELECT * FROM movimientos WHERE id_producto = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($resultado)) {
                $salida = $row[5];
            }

            $cal2 = $salida + $arreglo2[$i]; 
            $class->consulta("UPDATE movimientos SET salidas = '$cal2', saldo = '$cal' WHERE id_producto = '".$arreglo1[$i]."'");
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
			$class->consulta("INSERT INTO kardex VALUES (	'".$id_kardex."',
															'".$arreglo1[$i]."',
															'".$fecha_corta."',
															'".'F.V:'.$_POST['serie']."',
															'".$arreglo2[$i]."',
															'".$arreglo3[$i]."',
															'".$arreglo5[$i]."',
															'".$cal."',
															'',
															'',
															'2', 
															'".$fecha."')");
			// fin
	    }

	    $xml = generarXML($id,$codDoc,$ambiente,$emision); // generar xml
			
		$firmado = generarFirma($xml, $clave,'factura',$pass,$token,$ambiente); // firmar xml

		if($firmado == 5) {
			$data = 5; // ARCHIVO NO EXISTE
		} else {
			if($firmado == 6) {
				$data = 6; // CONTRASEÑA DE TOKEN INCORRECTA
			} else {
				$respWeb = webService($firmado,$ambiente,$clave,'','factura',$pass,$token,'0'); // Envio Archivo XML Validar 

				if($respWeb) {
					$estado = $respWeb['RespuestaRecepcionComprobante']['estado'];

					if($estado == 'RECIBIDA') {
						$respuesta = consultarComprobante($ambiente, $clave);														
						if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'AUTORIZADO') {

		            	    $numeroAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
		        	        $fechaAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
		    	            $ambienteAutorizacion = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;

			                $class->consulta("UPDATE factura_venta SET fecha_autorizacion = '".$fechaAutorizacion."', estado = '2', numero_autorizacion = '".$numeroAutorizacion."', ambiente = '".$ambienteAutorizacion."' WHERE id = '".$id."'");

			                $dataFile = generarXMLCDATA($respuesta);		                
			                $doc = new DOMDocument('1.0', 'UTF-8');
		        			$doc->loadXML($dataFile); // xml	 
		        			if($doc->save('comprobantes/'.$numeroAutorizacion.'.xml')) {
		        				$email = $_POST['correo'];
		        				$total = $_POST['total_pagar'];
		        				$nombre = $_POST['razon_social'];

		        				// include 'generarPDF.php';
			        			// $data = correo($fecha,$total,$numeroAutorizacion.'.xml',$numeroAutorizacion.'.pdf',$nombre,$email,'comprobantes/'.$numeroAutorizacion.'.xml',generarPDF($id),1);

			        			if(trim($email) == '' && $email != '') {
			        				$resultado = $class->consulta("UPDATE factura_venta SET estado = '1' WHERE id = '".$id."'");			
									if($resultado) {
										$data = 1; // datos actualizados
									} else {
										$data = 4; // error al momento de guadar
									}
								} else {
									$data = 3; // error al momento de enviar el correo
					    			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$id."'"); 
				    			}	
		        			} else {
		        				$data = 2; // error al generar los documentos
			        			$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$id."'");               	
		        			}      
						} else {
							if(isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado) == 'NO AUTORIZADO') {
								$data = 7; // Error en el service web
								$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$id."'");
							}
						}
					} else {
						if($estado == 'DEVUELTA') {
							$data = 8; // Error en el service web
							$class->consulta("UPDATE factura_venta SET estado = '".$data."' WHERE id = '".$id."'");
						}
					}
				}
			}
		}

		print_r(json_encode(array('estado' => $data, 'id' => $id)));
	}

	// anular facturas
	if (isset($_POST['btn_anular']) == "Anular") {
		$fecha_emision = $_POST['fecha_emision'];

		$class->consulta("UPDATE factura_venta SET fecha_anulacion = '$fecha_emision', estado = '0'  WHERE id = '".$_POST['id_factura']."'");

		// datos detalle factura
		$campo1 = $_POST['campo1'];
	    $campo2 = $_POST['campo2'];
	    // Fin

	    // descomponer detalle factura
		$arreglo1 = explode('|', $campo1);
	    $arreglo2 = explode('|', $campo2);
	    $nelem = count($arreglo1);
	    // fin

	    for ($i = 1; $i < $nelem; $i++) {
	    	// modificar productos
           	$resultado = $class->consulta("SELECT * FROM productos WHERE id = '".$arreglo1[$i]."'");
           	while ($row = $class->fetch_array($resultado)) {
                $stock = $row['stock'];
            }

            $cal = $stock + $arreglo2[$i];
            $class->consulta("UPDATE productos SET stock = '$cal' WHERE id = '".$arreglo1[$i]."'");
            // fin
	    }

	    $data = 1;
		echo $data;
	}
	// fin
	

	//cargar facturero
	if (isset($_POST['cargar_facturero'])) {
		$resultado = $class->consulta("SELECT * FROM facturero WHERE estado = '1'");
		while ($row = $class->fetch_array($resultado)) {
			$data_facturero = array(	'fecha_inicio' => $row[1],
							'fecha_caducidad' => $row[2],
							'inicio_facturero' => $row[3],
							'finaliza_facturero' => $row[4],
							'num_items' => $row[6]);
		}

		print_r(json_encode($data_facturero));
	}
	//fin

	//cargar ultima serie factura venta
	if (isset($_POST['cargar_series'])) {
		$resultado = $class->consulta("SELECT MAX(secuencial) FROM factura_venta GROUP BY id ORDER BY id asc");
		while ($row = $class->fetch_array($resultado)) {
			$data = array('serie' => $row[0]);
		}

		print_r(json_encode($data));
	}
	//fin

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

	// llenar cabezera factura venta
	if (isset($_POST['llenar_cabezera_factura'])) {
		$resultado = $class->consulta("SELECT F.id, F.fecha_emision, F.secuencial,  F.id_cliente, C.identificacion, C.razon_social, C.direccion, C.telefono2, C.correo, F.id_forma_pago, F.tipo_precio, F.subtotal, F.tarifa, F.tarifa0, F.iva, F.total_descuento, F.total_venta, F.efectivo, F.cambio, F.estado FROM factura_venta F, clientes C WHERE F.id_cliente = C.id AND F.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_factura' => $row[0],
							'fecha_emision' => $row[1],
							'secuencial' => $row[2],
							'id_cliente' => $row[3],
							'identificacion' => $row[4],
							'razon_social' => $row[5],
							'direccion' => $row[6],
							'telefono2' => $row[7],
							'correo' => $row[8],
							'id_forma_pago' => $row[9],
							'tipo_precio' => $row[10],
							'subtotal' => $row[11],
							'tarifa' => $row[12],
							'tarifa0' => $row[13],
							'iva' => $row[14],
							'descuento' => $row[15],
							'total_pagar' => $row[16],
							'efectivo' => $row[17],
							'cambio' => $row[18],
							'estado' => $row[19]);
		}
		
		print_r(json_encode($data));
	}
	//fin

	// llenar detalle factura venta
	if (isset($_POST['llenar_detalle_factura'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.nombre_tarifa_impuesto, U.incluye_iva, D.pendientes FROM detalle_factura_venta D, factura_venta F, productos U, tarifa_impuesto P  WHERE D.id_producto = U.id AND D.id_factura_venta = F.id AND U.id_porcentaje = P.id AND F.id = '".$_POST['id']."' ORDER BY D.id ASC");
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
		    $arr_data[] = $row['9'];
		}

		echo json_encode($arr_data);
	}
	//fin

	// llenar cabezera proforma
	if (isset($_POST['llenar_cabezera_proforma'])) {
		$resultado = $class->consulta("SELECT P.id, P.id_cliente, C.identificacion, C.razon_social, C.direccion, C.telefono2, C.correo, P.tipo_precio, P.subtotal, P.tarifa, P.tarifa0, P.iva, P.total_descuento, P.total_proforma FROM proforma P, clientes C WHERE P.id_cliente = C.id AND P.id = '".$_POST['id']."'");
		while ($row = $class->fetch_array($resultado)) {
			$data = array(  'id_proforma' => $row[0],
							'id_cliente' => $row[1],
							'identificacion' => $row[2],
							'razon_social' => $row[3],
							'direccion' => $row[4],
							'telefono2' => $row[5],
							'correo' => $row[6],
							'tipo_precio' => $row[7],
							'subtotal' => $row[8],
							'tarifa' => $row[9],
							'tarifa0' => $row[10],
							'iva' => $row[11],
							'descuento' => $row[12],
							'total_pagar' => $row[13]);
		}

		print_r(json_encode($data));
	}
	//fin

	// llenar detalle proforma
	if (isset($_POST['llenar_detalle_proforma'])) {
		$resultado = $class->consulta("SELECT D.id_producto, U.codigo, U.descripcion, D.cantidad, D.precio, D.descuento, D.total, P.nombre_tarifa_impuesto, U.incluye_iva FROM detalle_proforma D, proforma N, productos U, tarifa_impuesto P WHERE D.id_producto = U.id AND D.id_proforma = N.id AND U.id_porcentaje = P.id AND N.id = '".$_POST['id']."' ORDER BY D.id asc");
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