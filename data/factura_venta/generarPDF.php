<?php
	require_once("../../fpdf/rotation.php");
	require_once("../../fpdf/barcode.inc.php");
	require_once("../../admin/class.php");

	class PDF extends PDF_Rotate {   
	    var $widths;
	    var $aligns;       
	    function SetWidths($w) {            
	        $this->widths = $w;
	    }

	    function Header() {                         
	        $this->AddFont('Amble-Regular','','Amble-Regular.php');
	        $this->SetFont('Amble-Regular','',10);        
	        $fecha = date('Y-m-d', time());           
	        $this->SetY(1);
	        $this->Cell(20, 5, 'Generado: '.$fecha, 0,0, 'C', 0);                                                             
	        $this->Cell(178, 5, 'dte', 0,0, 'R', 0);                                                             
	        $this->Ln(7);
	        $this->SetX(13);
	        // $this->RotatedImage('../../fpdf/logo.fw.png', 50, 150, 100, 80, 45);                            
	        $this->SetX(0);            
		}

	    function Footer() {            
	        $this->SetY(-10);            
	        $this->SetFont('Arial','I',8);            
	        $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
	    } 

	   	function RotatedImage($file, $x, $y, $w, $h, $angle) {            
	        $this->Rotate($angle, $x, $y);
	        $this->Image($file, $x, $y, $w, $h);
	        $this->Rotate(0);
	    }      		         
	}

	if(isset($_GET['id'])) {				
		$id = $_GET['id'];
		generarPDF($id);
	}

	function generarPDF($id) {
		$class = new constante();
		$resultado = $class->consulta("SELECT E.ruc, F.numero_autorizacion, F.fecha_emision, F.clave_acceso, E.razon_social, E.nombre_comercial, E.direccion_matriz, E.direccion_establecimiento, E.contribuyente, E.obligacion, C.razon_Social, C.identificacion, C.direccion, C.telefono1, C.correo, F.secuencial, F.establecimiento, F.punto_emision, F.fecha_autorizacion, TC.codigo, F.ambiente, F.emision, E.imagen FROM factura_venta F, clientes C, empresa E, tipo_documento TC WHERE F.id_cliente = C.id AND C.id_tipo_documento = TC.id AND F.id_empresa = E.id AND F.id = '".$id."'");	
		while ($row = $class->fetch_array($resultado)) {
			$ruc = $row[0];		
			$numeroAutorizacion = $row[1];
			$fechaEmision = $row[2];
			$claveAcceso = $row[3];
			$razonSocial = $row[4];
			$nombreComercial = $row[5];
			$direcionMatriz = $row[6];
			$direccionEstablecimiento = $row[7];
			$nroContribuyente = $row[8];
			$obligado = $row[9];
			$contribuyente = $row[10];
			$identificacion = $row[11];
			$direcion = $row[12];
			$telefono = $row[13];
			$email = $row[14];			
			$secuencial = $row[15];
			$establecimiento = $row[16];
			$puntoEmision = $row[17];
			$fechaAut = $row[18];
			$codigo = $row[19];
			$ambiente = $row[20];
			$emision = $row[21];
			$imagen = $row[22];
		}		

		$resultado = $class->consulta("SELECT nombre_tipo_emision FROM tipo_emision WHERE codigo = '".$emision."'");
		while ($row = $class->fetch_array($resultado)) {
			$emision = $row[0];
		}

		$resultado = $class->consulta("SELECT nombre_tipo_ambiente FROM tipo_ambiente WHERE codigo = '".$ambiente."'");
		while ($row = $class->fetch_array($resultado)) {
			$ambiente = $row[0];
		}

		$ceros = 9;
		$temp = '';
		$tam = $ceros - strlen($secuencial);
	  	for ($i = 0; $i < $tam; $i++) {                 
	    	$temp = $temp .'0';        
	  	}
	  	$secuencial = $temp .''. $secuencial;

		$pdf = new PDF('P','mm','a4');
		$pdf->AddPage();
		$pdf->SetMargins(10,0,0,0);        
		$pdf->AliasNbPages();
		$pdf->SetAutoPageBreak(true, 10);
		$pdf->AddFont('Amble-Regular','','Amble-Regular.php');
		$pdf->SetFont('Amble-Regular','',10); 

		$logo = substr($imagen, 1);
		$pdf->Rect(3, 8, 100, 36 ,1, 'D');
		$pdf->Image('../../data/empresa'.$logo,5,20,90,15); // Img Empresa 
		
		$pdf->Rect(3, 45, 100, 53 , 'D'); // 2 datos personales
		$pdf->Text(108, 15, 'RUC:'. $ruc); // ruc		 	
		$pdf->Text(108, 23, utf8_decode("FACTURA")); // Tipo comprobante
		$pdf->Text(108, 31, 'No. '. $establecimiento.'-'.$puntoEmision.'-'.$secuencial); // Secuencial
		$pdf->Text(108, 39, utf8_decode('NÚMERO DE AUTORIZACIÓN')); // N° Autorizacion
		$pdf->SetY(40);
		$pdf->SetX(107);	
		$pdf->Multicell(100, 5, $numeroAutorizacion,0); // N° Autorización		
		$pdf->Text(108, 55, utf8_decode('FECHA Y HORA DE AUTORIZACIÓN')); // fecha y hora de autorizacion
		$pdf->Text(108, 61, $fechaAut); // FECHA
		$pdf->Text(108, 68, utf8_decode('AMBIENTE: '.$ambiente)); // Ambiente
		$pdf->Text(108, 75, utf8_decode('EMISIÓN: '.$emision)); // Tipo de emision
		$pdf->Text(108, 81, utf8_decode('CLAVE DE ACCESO: ')); // Clave de acceso
		$code_number = $claveAcceso; // Código de barras		
		new barCodeGenrator($code_number,1,'temp.gif', 470, 60, true); /// img codigo barras	
		$pdf->Image('temp.gif',108,83,96,15);     	

		$pdf->Rect(106, 8, 102, 90 , 'D'); //Datos Empresa	 
		$pdf->SetY(46);
		$pdf->SetX(4);
		$pdf->multiCell( 98,5, $razonSocial,0 ); // Razon Social Empresa	
		$pdf->SetY(56);
		$pdf->SetX(4);	
		$pdf->SetY(66);	
		$pdf->SetX(4);	
		$pdf->multiCell( 98, 5, 'Dir Matriz: '.$direcionMatriz,0); // Direccion Matriz	
		$pdf->SetY(76);	
		$pdf->SetX(4);	
		$pdf->multiCell( 98, 5, 'Dir Sucursal: '.$direccionEstablecimiento,0);// Direccion Establecimiento	
		$pdf->Text(5, 96, utf8_decode('Obligado a llevar Contabilidad: '.$obligado)); // Obligado a llevar contabilidad
		$pdf->Rect(3, 101, 205, 20 , 'D'); // INFO TRIBUTARIA			     
	 	$pdf->SetY(101);
		$pdf->SetX(3);
		$pdf->multiCell( 130, 6, utf8_decode('Razón Social / Nombres y Apellidos: '.$contribuyente ),0); // Nombre cliente	
		$pdf->Text(135, 105, utf8_decode('RUC / CI: '.$identificacion)); // Ruc cliente
		$pdf->Text(5, 117, utf8_decode('Fecha de Emisión: '.$fechaEmision)); //fecha de emision cliente
		$pdf->Text(136, 117, utf8_decode('Guía de Remisión: ')); //guia remision 

		// detalles factura
	    $pdf->SetFont('Amble-Regular','',9);               
	    $pdf->SetY(123);
		$pdf->SetX(3);
		$pdf->multiCell( 20, 5, utf8_decode('Cod. Principal'),1 );
		$pdf->SetY(123);
		$pdf->SetX(23);
		$pdf->multiCell( 20, 5, utf8_decode('Cod. Auxiliar'),1 );
		$pdf->SetY(123);
		$pdf->SetX(43);
		$pdf->multiCell( 15, 10, utf8_decode('Cantidad'),1 );
		$pdf->SetY(123);
		$pdf->SetX(58);
		$pdf->multiCell( 95, 10, utf8_decode('Descripción'),1 );
		$pdf->SetY(123);
		$pdf->SetX(153);
		$pdf->multiCell( 17, 5, utf8_decode('Precio Unitario'),1 );
		$pdf->SetY(123);
		$pdf->SetX(170);
		$pdf->multiCell( 18, 10, utf8_decode('Descuento'),1 );
		$pdf->SetY(123);
		$pdf->SetX(188);
		$pdf->multiCell( 20, 10, utf8_decode('Total'),1 );
		
		$x = 133;
		$y = 3;
		$resultado = $class->consulta("SELECT P.codigo, P.descripcion, D.cantidad, D.precio, D.descuento, D.total FROM factura_venta F, detalle_factura_venta D, productos P WHERE D.id_factura_venta = F.id AND D.id_producto = P.id  AND F.id = '".$id."'");
		while ($row = $class->fetch_array($resultado)) {
			$codigo = utf8_decode($row[0]);
			$codigoAuxiliar = '';
			$descripcion = utf8_decode($row[1]);
			$cantidad = $row[2];
			$precio = number_format($row[3], 2, '.', '');;
			$descuento = $row[4];
			$total = number_format($row[5], 2, '.', '');

			$pdf->SetY($x);
			$pdf->SetX(3);
			if(strlen($codigo) > 20)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(20, $tam, $codigo,1);

			$pdf->SetY($x);
			$pdf->SetX(23);
			if(strlen($codigoAuxiliar) > 19)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(20, $tam, $codigoAuxiliar,1);

			$pdf->SetY($x);
			$pdf->SetX(43);
			if(strlen($cantidad) > 10)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(15, $tam, $cantidad,1);

			$pdf->SetY($x);
			$pdf->SetX(58);
			if(strlen($descripcion) > 50)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(95, $tam, $descripcion,1);
			
			$pdf->SetY($x);
			$pdf->SetX(153);
			if(strlen($precio) > 10)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(17, $tam, $precio,1);

			$pdf->SetY($x);
			$pdf->SetX(170);
			if(strlen($descuento) > 15)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(18, $tam, $descuento,1);

			$pdf->SetY($x);
			$pdf->SetX(188);
			if(strlen($total) > 10)
				$tam = 5;
			else
				$tam = 10;	
			$pdf->multiCell(20, $tam, $total,1);			
			$x = $x + 10;
		}

		// pie de pagina           	
		if($pdf->getY() <= 220) {
			$pdf->Ln(5);
			$pdf->SetX(3);		   
		    $pdf->Rect($pdf->GetX(), $pdf->GetY(), 100, 40 , 'D');////3 INFO ADICIONAL	   
			$y =  $pdf->GetY();
			$x =  $pdf->GetX();	
			$y1 =  $pdf->GetY();
			$x1 =  $pdf->GetX();	
			$pdf->Text($x + 5, $y + 5, utf8_decode('INFORMACIÓN ADICIONAL'));//informacion 		
			$pdf->SetY($y + 7);
			$pdf->SetX($x);
			$pdf->multiCell( 100, 5, utf8_decode("Dirección:".$direcion ),0 );
			$pdf->SetY($y + 17);
			$pdf->SetX($x);
			$pdf->multiCell( 100, 10, utf8_decode("Teléfono: ".$telefono ),0 );
			$pdf->SetY($y + 29);
			$pdf->SetX($x);
			$pdf->multiCell( 100, 5, utf8_decode("Email: ".$email ),0 );

			$resultado = $class->consulta("SELECT F.subtotal, F.tarifa, F.tarifa0, F.iva, F.total_descuento, F.total_venta FROM factura_venta F WHERE F.id = '".$id."'");		
			while ($row = $class->fetch_array($resultado)) {
				$subtotal = $row[0];
				$tarifa = $row[1];
				$tarifa0 = $row[2];
				$iva = $row[3];
				$descuento = $row[4];
				$total = $row[5];	
			}

			$pdf->Ln(5);
			$pdf->SetX(108);
			$x1 = $x1 + 105;		   
		    $pdf->SetY($y1);
			$pdf->SetX($x1);
			$pdf->multiCell( 62, 6, utf8_decode("Subtotal 12%"),1 );	
			$pdf->SetY($y1);
			$pdf->SetX($x1+62);
			$pdf->multiCell(38, 6, number_format($tarifa, 2, '.', ''),1);
			$pdf->SetY($y1 + 6);
			$pdf->SetX($x1);
			$pdf->multiCell(62, 6, utf8_decode("Subtotal 0%"),1);	
			$pdf->SetY($y1 + 6);
			$pdf->SetX($x1 + 62);
			$pdf->multiCell(38, 6, number_format($tarifa0, 2, '.', ''),1);	
			$pdf->SetY($y1 + 12);
			$pdf->SetX($x1);
			$pdf->multiCell( 62, 6, utf8_decode("Descuento"),1 );	
			$pdf->SetY($y1 + 12);
			$pdf->SetX($x1 + 62);
			$pdf->multiCell(38, 6, number_format($descuento, 2, '.', ''),1);
			$pdf->SetY($y1 + 18);
			$pdf->SetX($x1);
			$pdf->multiCell(62, 6, utf8_decode("Iva"),1);	
			$pdf->SetY($y1 + 18);
			$pdf->SetX($x1 + 62);
			$pdf->multiCell(38, 6, number_format($iva, 2, '.', ''),1);	
			$pdf->SetY($y1 + 24);
			$pdf->SetX($x1);
			$pdf->multiCell(62, 6, utf8_decode("Propina"),1);	
			$pdf->SetY($y1 + 24);
			$pdf->SetX($x1 + 62);
			$pdf->multiCell(38, 6, utf8_decode("0.00"),1);
			$pdf->SetY($y1 + 30);
			$pdf->SetX($x1);
			$pdf->multiCell(62, 6, utf8_decode("Total"),1);	
			$pdf->SetY($y1 + 30);
			$pdf->SetX($x1 + 62);
			$pdf->multiCell(38, 6, number_format($total, 2, '.', ''),1);	
		
			// FORMAS DE PAGO	           	
			$pdf->SetX(3);		   	    
			$y =  $pdf->GetY();
			$x =  $pdf->GetX();				
			$pdf->SetY($y + 7);
			$pdf->SetX($x);
			$pdf->multiCell( 80, 6, utf8_decode("FORMAS DE PAGO"),1);
			$pdf->SetY($y + 7);
			$pdf->SetX($x + 80);
			$pdf->multiCell( 20, 6, utf8_decode("VALOR"),1 );
			$resultado = $class->consulta("SELECT P.nombre_forma FROM factura_venta F, formas_pago P WHERE F.id_forma_pago = P.id AND F.id = '".$id."'");
			while ($row = $class->fetch_array($resultado)) {
				$pdf->SetY($y + 13);
				$pdf->SetX($x);
				$pdf->multiCell(80, 6, utf8_decode($row[0]),1);
				$pdf->SetY($y + 13);
				$pdf->SetX($x + 80);
				$pdf->multiCell( 20, 6, utf8_decode($total),1);
			}
		} else {
			// $pdf->AddPage();
			// $pdf->Ln(5);
			// $pdf->SetX(3);		   
		 //    $pdf->Rect($pdf->GetX(), $pdf->GetY(), 100, 40 , 'D');////3 INFO ADICIONAL	   
			// $y =  $pdf->GetY();
			// $x =  $pdf->GetX();	
			// $y1 =  $pdf->GetY();
			// $x1 =  $pdf->GetX();	
			// $pdf->Text($x + 5, $y + 5, utf8_decode('INFORMACIÓN ADICIONAL'));//informacion 		
			// $pdf->SetY($y + 7);
			// $pdf->SetX($x);
			// $pdf->multiCell( 100, 5, utf8_decode("Dirección:".$direcion ),0 );
			// $pdf->SetY($y + 17);
			// $pdf->SetX($x);
			// $pdf->multiCell( 100, 10, utf8_decode("Teléfono: ".$telefono ),0 );
			// $pdf->SetY($y + 29);
			// $pdf->SetX($x);
			// $pdf->multiCell( 100, 5, utf8_decode("Email: ".$email ),0 );		

			// ///////TOTALES////
			// $sql = "select 
			// 	DIP.idImpuesto,
			//     TI.codigo,
			//     TI.nombre,
			//     TTI.nombre,
			//     TTI.codigo impuestoCodigo,
			//     sum(DF.cantidad)cantidad,
			//     sum(DF.valorProducto)valor,
			//     sum(DIP.valor)valorImpuesto				    
			// from factura F 
			// inner join detallefactura DF on F.id = DF.idFactura
			// inner join producto P on P.id = DF.idProducto
			// inner join detalleimpuestoproducto DIP on DF.id = DIP.idDetalleFactura
			// inner join tarifaimpuesto TI on TI.id = DIP.idImpuesto
			// inner join tipoimpuesto TTI on TTI.id = TI.idImpuesto
			// where F.id = '".$id."'
			// group by DIP.idImpuesto";
			// //echo $sql;
			// $sql = $class->consulta($sql);
			// $subtotal12 = 0;
			// $subtotal0 = 0;
			// $iva12 = 0;
			// while ($row = $class->fetch_array($sql)) {
			// 	$iva12 = $iva12 + $row[7];
			// 	if($row[2] == 12){
			// 		$subtotal12 = $subtotal12 + ($row[6]);
			// 	}else{
			// 		$subtotal0 = $subtotal0 + ($row[6]);
			// 	}
			// }
			// $pdf->Ln(5);
			// $pdf->SetX(108);
			// $x1 = $x1 + 105;		   
		 //    $pdf->SetY($y1);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("Subtotal 12 %"),1 );	
			// $pdf->SetY($y1);
			// $pdf->SetX($x1+62);
			// $pdf->multiCell( 38, 6, number_format($subtotal12, 2, '.', ''),1 );
			// $pdf->SetY($y1 + 6);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("Subtotal IVA 0 %"),1 );	
			// $pdf->SetY($y1 + 6);
			// $pdf->SetX($x1 + 62);
			// $pdf->multiCell( 38, 6, number_format($subtotal0, 2, '.', ''),1 );	
			// $pdf->SetY($y1 + 12);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("Descuento"),1 );	
			// $pdf->SetY($y1 + 12);
			// $pdf->SetX($x1 + 62);
			// $pdf->multiCell( 38, 6, utf8_decode("0.00"),1 );
			// $pdf->SetY($y1 + 18);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("IVA 12 %"),1 );	
			// $pdf->SetY($y1 + 18);
			// $pdf->SetX($x1 + 62);
			// $pdf->multiCell( 38, 6, number_format($iva12, 2, '.', ''),1 );	
			// $pdf->SetY($y1 + 24);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("PROPINA"),1 );	
			// $pdf->SetY($y1 + 24);
			// $pdf->SetX($x1 + 62);
			// $pdf->multiCell( 38, 6, utf8_decode("0.00"),1 );
			// $pdf->SetY($y1 + 30);
			// $pdf->SetX($x1);
			// $pdf->multiCell( 62, 6, utf8_decode("TOTAL"),1 );	
			// $pdf->SetY($y1 + 30);
			// $pdf->SetX($x1 + 62);
			// $pdf->multiCell( 38, 6, number_format($subtotal0 + $subtotal12 + $iva12, 2, '.', ''),1 );	
		
			// /////////////////FORMAS DE PAGO//////////	           	
			// $pdf->SetX(3);		   	    
			// $y =  $pdf->GetY();
			// $x =  $pdf->GetX();				
			// $pdf->SetY($y + 7);
			// $pdf->SetX($x);
			// $pdf->multiCell( 80, 6, utf8_decode("FORMAS DE PAGO"),1 );
			// $pdf->SetY($y + 7);
			// $pdf->SetX($x + 80);
			// $pdf->multiCell( 20, 6, utf8_decode("VALOR"),1 );
			// $sql = "SELECT FP.nombre, FPF.valor FROM factura F inner join formapagofactura FPF on  FPF.idFactura = F.id inner join formapago FP on FPF.idFormaPago = Fp.id where F.id = '".$id."'";		        
	  //       $sql = $class->consulta($sql);
			// while ($row = $class->fetch_array($sql)) {
			// 	$pdf->SetY($y + 13);
			// 	$pdf->SetX($x);
			// 	$pdf->multiCell( 80, 6, utf8_decode($row[0]),1 );
			// 	$pdf->SetY($y + 13);
			// 	$pdf->SetX($x + 80);
			// 	$pdf->multiCell( 20, 6, utf8_decode($row[1]),1 );
			// }
		}
		if(isset($_GET['id'])) {
			$pdf->Output();		
		} else {
			$pdf_file_contents = $pdf->Output("","S");		
			return $pdf_file_contents;
		}
	}
?>