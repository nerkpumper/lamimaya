<?php
require_once FOLDER_INCLUDE . 'lib/fpdf/fpdfnerk.php';
require_once FOLDER_MODEL. "model.registroproduccion.inc.php";


function salir(){
    echo "<script>
        
					window.close();
		</script>";
}

$_tituloReporte = "Inventario Rollos/Productos";
$_subtituloReporte = "";
$_campos = array("CÓDIGO", "NOROLLO", "DESCRIPCIÓN", "EXISTENCIA","COSTO CON IVA", "IMPORTE");



function normaliza ($cadena){
    //  	$originales  = 'Ãƒâ‚¬Ãƒï¿½Ãƒâ€šÃƒÆ’Ãƒâ€žÃƒâ€¦Ãƒâ€ Ãƒâ€¡ÃƒË†Ãƒâ€°ÃƒÅ Ãƒâ€¹ÃƒÅ’Ãƒï¿½ÃƒÅ½Ãƒï¿½Ãƒï¿½Ãƒâ€˜Ãƒâ€™Ãƒâ€œÃƒâ€�Ãƒâ€¢Ãƒâ€“ÃƒËœÃƒâ„¢ÃƒÅ¡Ãƒâ€ºÃƒÅ“Ãƒï¿½ÃƒÅ¾ÃƒÅ¸ÃƒÂ ÃƒÂ¡ÃƒÂ¢ÃƒÂ£ÃƒÂ¤ÃƒÂ¥ÃƒÂ¦ÃƒÂ§ÃƒÂ¨ÃƒÂ©ÃƒÂªÃƒÂ«ÃƒÂ¬ÃƒÂ­ÃƒÂ®ÃƒÂ¯ÃƒÂ°ÃƒÂ±ÃƒÂ²ÃƒÂ³ÃƒÂ´ÃƒÂµÃƒÂ¶ÃƒÂ¸ÃƒÂ¹ÃƒÂºÃƒÂ»ÃƒÂ½ÃƒÂ½ÃƒÂ¾ÃƒÂ¿Ã…â€�Ã…â€¢Ã¯Â¿Â½';
    //  	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRro';
    
    $originales  = 'Ã ,Ã¡,Ã¢,Ã£,Ã¤,Ã§,Ã¨,Ã©,Ãª,Ã«,Ã¬,Ã­,Ã®,Ã¯,Ã±,Ã²,Ã³,Ã´,Ãµ,Ã¶,Ã¹,Ãº,Ã»,Ã¼,Ã½,Ã¿,Ã€,Ã�,Ã‚,Ãƒ,Ã„,Ã‡,Ãˆ,Ã‰,ÃŠ,Ã‹,ÃŒ,Ã�,ÃŽ,Ã�,Ã‘,Ã’,Ã“,Ã”,Ã•,Ã–,Ã™,Ãš,Ã›,Ãœ,Ã�';
    $modificadas = 'a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y';
    
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    
    //$tofind = array('Ã ','Ã¡','Ã¢','Ã£','Ã¤', 'Ã§', 'Ã¨','Ã©','Ãª','Ã«', 'Ã¬','Ã­','Ã®','Ã¯', 'Ã±', 'Ã²','Ã³','Ã´','Ãµ','Ã¶', 'Ã¹','Ãº','Ã»','Ã¼', 'Ã½','Ã¿', 'Ã€','Ã�','Ã‚','Ãƒ','Ã„', 'Ã‡', 'Ãˆ','Ã‰','ÃŠ','Ã‹', 'ÃŒ','Ã�','ÃŽ','Ã�', 'Ã‘', 'Ã’','Ã“','Ã”','Ã•','Ã–', 'Ã™','Ãš','Ã›','Ãœ', 'Ã�');
    //$replac = array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y');
    //return(strtr($cadena,$tofind,$replac));
    
    //  	$cadena = utf8_decode($cadena);
    //  	$cadena = strtr($cadena, utf8_decode($tofind), $toreplac);
    //  	$cadena = strtolower($cadena);
    return $cadena;
    //return utf8_encode($cadena);
}

if (PHP_SAPI == 'cli')
    die('Este archivo solo se puede ver desde un navegador web');
    
    /** Se agrega la libreria PHPExcel */
    require_once FOLDER_INCLUDE . 'lib/PHPExcel/PHPExcel.php';
    // require_once LIB_CONEXION_MYSQL;
    
    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();
    
    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("Galvamex App") //Autor
    ->setLastModifiedBy("Galvamex App") //Ultimo usuario que lo modificÃƒÆ’Ã‚Â³
    ->setTitle("Reporte")
    ->setSubject("Reporte")
    ->setDescription("Reporte")
    ->setKeywords("reporte")
    ->setCategory("Reporte Galvamex");
    
    //Landscape
    // $objPHPExcel->getActiveSheet()
    // 				 ->getPageSetup()
    // 				 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    
    $objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    
    $objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    
    // $tituloReporte = "REPORTE DE RECEPCIÃ“N DE MATERIALES";
    // $titulosColumnas = array('FECHA', 'PROVEEDOR', 'REMISIÃ“N', 'NUM. ROLLO', 'PRODUCTO', 'KILOS RECIB.', 'Hora', 'ts');
    
    //LANDSCAPE
    //Titulo
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('C1:G1');
    //Subtitulo
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('C2:G2');
    
    // //PORTRAIT
    // // //Titulo
    //  $objPHPExcel->setActiveSheetIndex(0)
    //        		    ->mergeCells('D1:I1');
    // // //Subtitulo
    //  $objPHPExcel->setActiveSheetIndex(0)
    //        		    ->mergeCells('D2:I2');
    
    
    
    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C1',$_tituloReporte);
    // 	$objPHPExcel->setActiveSheetIndex(0)
    // 	->setCellValue('D2',$_subtituloReporte);
    
    
    
    $estiloTituloReporte = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>12,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => FALSE
        )
    );
    
    $estiloTituloReporteTipo = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>18,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => FALSE
        )
    );
    
    $estiloHeader = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>9,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => FALSE
        )
    );
    
    
    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            ),
        )
    );
    
    $styleArrayBold = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
                'bold' => true
            ),
        )
    );
    
    $col = 0;
    foreach ($_campos as $colTitle)
    {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow($col++, 8, $colTitle);
    }
    
    
//     $objPHPExcel->getActiveSheet()->getStyle('F4:'. 'G12')->applyFromArray($styleArray);
    
    
    // //Headers
    // $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle(chr(65) . '8:'. chr(64 + count($_campos)).'8')->applyFromArray($styleArray);
    $objPHPExcel
    ->getActiveSheet()
    ->getStyle(chr(65) . '8:'. chr(64 + count($_campos)).'8')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('E0E0E0');
    
    // //echo "vamos por los datos - Row: " . $idRollo;
    
    //Datos
    $_strQuery = "select vr.idrollo, rr.idremisionrollo, rr.remision, rr.norollo, if(rr.existencia > 0, rr.existencia,0) existencia, 
vr.codigo, vr.descauto descripcion, vr.pesocu 
from remisionrollo rr 
inner join viewrollos vr on rr.remisionrollo_rollo_idrollo = vr.idrollo 
 where rr.estado <> 'BAJA'
order by vr.idrollo;";

    
//     where rr.estado = 'ACTIVO'

    $cnn = new clsConexionMySQL();
    
    $datos = $cnn->getDataSet($_strQuery);
//     $rp = new ModeloRegistroproduccion();
    
//     $rp->getRegistroProduccion($idRegistroProduccion);
    
    
//     $datos = $rp->__rsDetalle;
    
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A6',"ROLLOS");
    $objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($estiloTituloReporteTipo);
    
    $row = 9;
    $ts = "";
    $totalImporte = 0;
    $importe = 0;
    $totalImporteGlobal = 0;
    $codigo = "";
    $codigoAux = "";
    foreach ($datos as $item)
    {
        // 		$col = 0;
        // 		foreach ($item as $cell)
            // 		{
            // 			$objPHPExcel->setActiveSheetIndex(0)
            // 			->setCellValueByColumnAndRow($col++, $row, $cell);
        
            // 		}
            
        $codigo = $item["codigo"];
        
        if ($codigo != $codigoAux)
        {
            if ($codigoAux != "")
            {
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(4, $row, "Total " );
                
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(5, $row, $totalImporte);
                
                $objPHPExcel->getActiveSheet()->getStyle('E' . $row .':'. 'F'. $row)->applyFromArray($styleArrayBold);
                $objPHPExcel
                ->getActiveSheet()
                ->getStyle('E' . $row . ':F'. $row)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('E0E0E0');
                
                $totalImporte = 0;
                
                $row++;
                $row++;
            }
            
            
            $codigoAux = $codigo;            
            
        }
        
            
        $importe =number_format($item["pesocu"]*1.16,2) * $item["existencia"];
        $totalImporte += $importe;
        $totalImporteGlobal += $importe;
            
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $row, $item["codigo"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $row, $item["norollo"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(2, $row, $item["descripcion"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(3, $row, $item["existencia"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4, $row, number_format($item["pesocu"]*1.16,2));        
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(5, $row, number_format($importe,2));
//         $objPHPExcel->setActiveSheetIndex(0)
//         ->setCellValueByColumnAndRow(6, $row, $item["totalreal"]);
        
        
        
        
        $row++;
    }
    
    if ($codigoAux != "")
    {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4, $row, "Total " . $codigo);
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(5, $row, $totalImporte);
        
        $objPHPExcel->getActiveSheet()->getStyle('E' . $row .':'. 'F'. $row)->applyFromArray($styleArrayBold);
        $objPHPExcel
        ->getActiveSheet()
        ->getStyle('E' . $row . ':F'. $row)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('E0E0E0');
        
        
        
        $row++;
        $row++;
        
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4, $row, "Total Global");
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(5, $row, $totalImporteGlobal);
        
        $objPHPExcel->getActiveSheet()->getStyle('E' . $row .':'. 'F'. $row)->applyFromArray($styleArrayBold);
        $objPHPExcel
        ->getActiveSheet()
        ->getStyle('E' . $row . ':F'. $row)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('E0E0E0');
        
        
        
        $row++;
        $row++;
    }
    
    $row++;
    
    
    
    ///  P R O D U C T O S 
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$row,"PRODUCTOS");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':A'.$row)->applyFromArray($estiloTituloReporteTipo);
    
    
    $row++;
    $row++;
    $_campos = array("CÓDIGO", "DESCRIPCIÓN", "EXISTENCIA","COSTO CON IVA","IMPORTE");
    
    $col = 0;
    foreach ($_campos as $colTitle)
    {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow($col++, $row, $colTitle);
    }
    
    
    $objPHPExcel->getActiveSheet()->getStyle(chr(65) . $row.':'. chr(64 + count($_campos)).$row)->applyFromArray($styleArray);
    $objPHPExcel
    ->getActiveSheet()
    ->getStyle(chr(65) . $row.':'. chr(64 + count($_campos)).$row)
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('E0E0E0');
    
    
    //Datos
    $_strQuery = "select vp.idproducto, vp.codigo, vp.descauto descripcion, concat(vp.tipoproducto, vp.aplicacion,vp.material) llave, vp.existencia, vp.costo
from viewproductos vp
where estado = 'ACTIVO' 
and vp.idrollo = 1
and vp.existencia > 0;";
    
    
    //     where rr.estado = 'ACTIVO'
    
    
    
    $datos = $cnn->getDataSet($_strQuery);
    //     $rp = new ModeloRegistroproduccion();
    
    //     $rp->getRegistroProduccion($idRegistroProduccion);
    
    
    //     $datos = $rp->__rsDetalle;
    
    $row++;
    $ts = "";
    $totalImporte = 0;
    $importe = 0;
    $totalImporteGlobal = 0;
    $codigo = "";
    $codigoAux = "";
    foreach ($datos as $item)
    {
        // 		$col = 0;
        // 		foreach ($item as $cell)
        // 		{
        // 			$objPHPExcel->setActiveSheetIndex(0)
        // 			->setCellValueByColumnAndRow($col++, $row, $cell);
        
        // 		}
        
        $codigo = $item["llave"];
        
        if ($codigo != $codigoAux)
        {
            if ($codigoAux != "")
            {
//                 $objPHPExcel->setActiveSheetIndex(0)
//                 ->setCellValueByColumnAndRow(4, $row, "Total " . $codigo);
                
//                 $objPHPExcel->setActiveSheetIndex(0)
//                 ->setCellValueByColumnAndRow(5, $row, $totalImporte);
                
//                 $objPHPExcel->getActiveSheet()->getStyle('E' . $row .':'. 'F'. $row)->applyFromArray($styleArrayBold);
//                 $objPHPExcel
//                 ->getActiveSheet()
//                 ->getStyle('E' . $row . ':F'. $row)
//                 ->getFill()
//                 ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
//                 ->getStartColor()
//                 ->setRGB('E0E0E0');
                
                $totalImporte = 0;
                
                $row++;
                $row++;
            }
            
            
            $codigoAux = $codigo;
            
        }
        
        
//         $importe = $item["pesocu"] * $item["existencia"];
//         $totalImporte += $importe;
//         $totalImporteGlobal += $importe;
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $row, $item["codigo"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $row, $item["descripcion"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(2, $row, $item["existencia"]);
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(3, $row,number_format($item["costo"]*1.16,2) );
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4, $row,number_format(($item["costo"]*1.16)*$item["existencia"],2));
//         $objPHPExcel->setActiveSheetIndex(0)
//         ->setCellValueByColumnAndRow(3, $row, $item["existencia"]);
//         $objPHPExcel->setActiveSheetIndex(0)
//         ->setCellValueByColumnAndRow(4, $row, $item["pesocu"]);
        
//         $objPHPExcel->setActiveSheetIndex(0)
//         ->setCellValueByColumnAndRow(5, $row, $importe);
        //         $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValueByColumnAndRow(6, $row, $item["totalreal"]);
        
        
        
        
        $row++;
    }
    
    
    
    $_campos = array("CÓDIGO", "NOROLLO", "DESCRIPCIÓN", "EXISTENCIA","PRECIO", "IMPORTE");
    
    // 	$_subtituloReporte = $rp->getRegitroProduccionDato("norollo");
    
    // 	$objPHPExcel->setActiveSheetIndex(0)
    // 	->setCellValue('C2',$_subtituloReporte);
    
    // 	$row++;
    // 	$row++;
//     $row = 4;
//     $colDatosRP = 5;
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "FECHA DE PRODUCCION");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("fecha_creacion"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "NUMERO DE ROLLO");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("norollo"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS DE ROLLO");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilos"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS MAQUILADOS");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilosmaquilados"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "KILOS FALTANTES");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("kilosfaltantes"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "TOTAL DE ML");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("totalml"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "FACTOR");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("factor"));
    
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP, $row, "RENDIMIENTO");
//     $objPHPExcel->setActiveSheetIndex(0)
//     ->setCellValueByColumnAndRow($colDatosRP + 1, $row++, $rp->getRegitroProduccionDato("rendimiento"));
    
    for($i = 'A'; $i <= chr(64 + count($_campos)); $i++){
        $objPHPExcel->setActiveSheetIndex(0)
        ->getColumnDimension($i)->setAutoSize(TRUE);
        
    }
    
    
    $objPHPExcel->getActiveSheet()->getStyle('C1:G1')->applyFromArray($estiloTituloReporte);
    
    // $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($estiloDatosLabelRollo);
    // $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($estiloDatosRollo);
    // $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($estiloDatosLabelRollo);
    // $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($estiloDatosRollo);
    
//     $objPHPExcel->getActiveSheet()->getStyle('A6:'.chr(64 + count($_campos)).'6')->applyFromArray($estiloHeader);
    
    //$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);
    //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D5");
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('12');
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('13');
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('58');
    
    // $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
    // $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
    
    // $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight('26');
    
    
    
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('test_img');
    $objDrawing->setDescription('test_img');
    //$objDrawing->setPath('C:\\xampp\\htdocs\\galvamex\\codigogalvamex\\html\\img\\galvalogo.jpeg');
    // $objDrawing->setPath('../img/galvalogo.jpeg');
    $objDrawing->setPath('img/galvalogo.jpeg');
    $objDrawing->setCoordinates('A1');
    //setOffsetX works properly
    $objDrawing->setOffsetX(2);
    $objDrawing->setOffsetY(2);
    //set width, height
    $objDrawing->setResizeProportional(false);
    $objDrawing->setWidth(170);
    $objDrawing->setHeight(75);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    
    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    //$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
    
    //header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
    header('Content-Disposition: attachment;filename="ReporteInventario_' . date('YmdHis') . '.xlsx"');
    header('Cache-Control: max-age=0');
    // 	$fileName = "Reporte_".date('YmdHis').".xlsx";
    // 	$path = "../reportes/";
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    // $objWriter->save($path.$fileName);
    $objWriter->save('php://output');
    // echo $fileName;
    exit;
    
    
    