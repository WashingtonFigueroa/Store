<?php
    require('../../fpdf/fpdf.php');
    include_once('../../admin/class.php');
    include_once('../../admin/funciones_generales.php');
    $class = new constante();   
    date_default_timezone_set('America/Guayaquil'); 
    session_start();

    class PDF extends FPDF {   
        var $widths;
        var $aligns;
        function SetWidths($w) {            
            $this->widths = $w;
        }                       
        function Header() {             
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "PRODUCTOS", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',10);                                                    
            $this->Cell(190, 8, $_SESSION['empresa']['nombre_comercial'], 0,1, 'C',0);
            $imagen = substr($_SESSION['empresa']['imagen'], 1);                                
            $this->Image('../../data/empresa'.$imagen,1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['empresa']['representante_legal']),0,1, 'C',0);                                
            $this->Cell(85, 5, "TEL.: ".utf8_decode($_SESSION['empresa']['telefono1']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['empresa']['telefono2']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['empresa']['ciudad']),0,1, 'C',0);                                                                                        
            $this->Ln(18);
            $this->SetX(1);
            $this->Cell(30, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(95, 5, utf8_decode("Producto"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Precio Minorista"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("Precio Mayorista"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Stock"),1,1, 'C',0);   
        }

        function Footer() {            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    $pdf = new PDF('P','mm','a4');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Amble-Regular');                    
    $pdf->SetFont('Amble-Regular','',10);       
    $pdf->SetFont('Arial','B',9);   
    $pdf->SetX(5);
    $resultado = $class->consulta("SELECT codigo, codigo_barras, descripcion, precio_minorista, precio_mayorista, stock FROM productos WHERE estado = '1'");       
    $pdf->SetFont('Amble-Regular','',9);   
    $pdf->SetX(5);    
    while ($row = $class->fetch_array($resultado)) {                
        $pdf->SetX(1);                  
        $pdf->Cell(30, 5, utf8_decode($row[0]),0,0, 'L',0);
        $pdf->Cell(95, 5, maxCaracter(utf8_decode($row[2]),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($row[3]),0,0, 'C',0);        
        $pdf->Cell(30, 5, utf8_decode($row[4]),0,0, 'C',0);                         
        $pdf->Cell(20, 5, utf8_decode($row[5]),0,0, 'C',0);                         
        $pdf->Ln(5);        
    }    
                                                     
    $pdf->Output();
?>