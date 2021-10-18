<?php
$op = $_GET['op'];
$title = $_GET['title'];
 $rr=0;
//CONEXIÓN AL SERVICIO WEB 
       $cliente=new SoapClient(null, array('uri'=>'http://localhost/','location'=>'https://pw183110356.000webhostapp.com/practicas/GSW/serviciosweb/servicioweb.php'
	   )	
	  );	
	  //MÉTODO QUE OBTIENE LOS REGISTROS
	  $consulta=$cliente->consultarProductosPDF($op);			
	  //HACE USO DE LA LIBRERÍA FPDF, QUE PERMITIRÁ HACER USO DE LAS LIBRERÍAS PARA GENERAR UN ARCHIVO EN PDF
require('../pdf/fpdf.php');

//CREAR UN NUEVO ARCHIVO PDF 
$pdf=new FPDF();
$pdf->SetTitle($_GET['nom']);
//AGREGAR UNA NUEVA PÁGINA AL ARCHIVO PDF
$pdf->AddPage();

//CONFIGURAR LA FUENTE: TIPO, LETRA, ESTILO, TAMAÑO
$pdf->SetFont('Arial','B',16);

//Image(rutaNombreImagen,col, renglon, largo, alto, ruta) -->permite colocar una imagen en el reporte
$pdf->Image('../imagenes/sistema/logo.png' , 10 ,10, 30 , 20,'PNG', '');
//col, ren
$pdf->Cell(50,10);
//se recomienda manejarlo separado para poder dejarlo en el mismo renglón del logo
$pdf->write(15, $title);
//GENERA UNA LÍNEA, X1,Y1, X2,Y2
$pdf->line(10,40,183,40);
$pdf->Ln(); //hace un enter
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
//GENERA UNA NUEVA CELDA DENTRO DE LA HOJA
//CELL(COLUMNA, ANCHO DE LA CELDA GENERADA, VALOR A IMPRIMIR, BORDE-->0|1)
$pdf->Cell(25,10, 'Nombre',0);
$pdf->Cell(35,10, 'Presentacion',0);
$pdf->Cell(20,10, 'Cantidad',0);
$pdf->Cell(25,10, 'Caducidad',0);
$pdf->Cell(25,10, 'Proveedor',0);
$pdf->Cell(20,10, 'Costo',0);
$pdf->Cell(25,10, 'Foto',0);
$pdf->line(10,48,183,48);
$pdf->Ln();
$pdf->SetFont('Arial','',11);
//RECORREN LOS DATOS DE LA CONSULTA PARA AGREGARLOS A UNA CELDA DE LA MISMA PÁGINA
 for($rr=0;$rr<count($consulta);$rr++) {
    $pdf->Cell(25,13,$consulta[$rr]['PRODUCTO'],0);
    $pdf->Cell(35,13,$consulta[$rr]['PRESENTACION'],0);
    $pdf->Cell(20,13,$consulta[$rr]['CANTIDAD'],0);
    $pdf->Cell(25,13,$consulta[$rr]['VENCIMIENTO'],0);
    $pdf->Cell(25,13,$consulta[$rr]['PROVEEDOR'],0);
    $pdf->Cell(20,13,$consulta[$rr]['PRECIO_ADQUISICION'],0);
    // $pdf->Cell(35,13,$consulta[$rr]['FOTO'],0);
    $pdf->Image("../../".$consulta[$rr]['FOTO'], 160 , 51+(13*$rr), 10, 10);
    $pdf->Ln();
 }
$pdf->Output();
?>