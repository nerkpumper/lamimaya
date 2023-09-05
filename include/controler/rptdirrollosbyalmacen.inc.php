<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
	
	
	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Funciones------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#


	// ----------------------------------------------------------------------------------------------------------------------#
	// -----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	$xajax = new xajax();
// 	$xajax->setCharEncoding('ISO-8859-1');
	
	//$xajax->de decodeUTF8InputOn();
	
//   	ob_start();	
// 	echo "hola mundito";
// 	$debug = ob_get_clean();
// 	$r->mostrarMsgs($debug);
	
	function obtenerReporte($filtro)
	{
		$r = new xajaxResponse();
		
		
		$repo = new ModeloRemisionrollo();
		$header = "";
		
		
		$header = " <th>Almacen</th>
					<th>Material</th>
                    <th>Remisi&oacute;n</th>
                    <th>Rollo</th>
                    <th>Existencia</th>
                    <th>Reg. Prod.</th>
								";
		
	   $r->assign("tblReporteHead", "innerHTML", $header); 
	   
	   $sql = "select rr.almacen,vr.codigo, rr.idremisionrollo, rr.remision, rr.norollo, rr.kilos kilosinicial, if(rr.existencia > 0, rr.existencia , 0) existencia,
                    if(rr.existencia > 0, '' , '<') neg,
                    ifnull(rp.idregistroproduccion, 0) idregistroproduccion, ifnull(rp.terminado, '-') terminado
                from remisionrollo rr
 	   inner join viewrollos vr
 	   on rr.remisionrollo_rollo_idrollo = vr.idrollo
        left join registroproduccion rp 
       on rp.idremisionrollo = rr.idremisionrollo                
                where rr.estado <> 'BAJA'  ";
	   

// 	   left join registroproduccion rp
// 	   on rr.idremisionrollo = rp.idremisionrollo
	   
	    if ($filtro["almacen"] != 'ALL')
	    {
	        $sql .= " AND rr.almacen = '".$filtro["almacen"]."' ";	        
	    }
	    	$sql .= " ORDER BY rr.almacen ASC, vr.codigo ASC";
	    $lst = $repo->getDataSet($sql);
		
		$detalle = "";
		$totalExistencia = 0;
		foreach ($lst as $row)
		{
		    if ($row["terminado"] != 'SI')
		    {
		        if ($row["existencia"] > 0)
		        {
		            $totalExistencia += (float)$row["existencia"];
		        }
		        
		        $detalle .= "<tr>";
		        
		        $detalle .= "<td>".$row["almacen"]."</td>";
		        $detalle .= "<td>".$row["codigo"]."</td>";
		        $detalle .= "<td>".$row["remision"]."</td>";
		        $detalle .= "<td>".$row["norollo"]."</td>";
		        $detalle .= "<td>".$row["neg"].number_format($row["existencia"],2)."</td>";
		        
		        if ($row["idregistroproduccion"] > 0)
		        {
		            $detalle .= "<td>".$row["idregistroproduccion"]."</td>";
		            
		        }
		        else
		        {
		            $detalle .= "<td></td>";
		        }
		        
		        $detalle .= "</tr>";
		    }
		    
		    				
			
		}
		
		$r->assign("tblReporteBody", "innerHTML", $detalle);
		$r->script("app.totalExistencia = ".$totalExistencia."; mdlExitWait();");
		
		return $r;
	}	
	$xajax->registerFunction("obtenerReporte");
	
	function obtenerReporteAgrupado($filtro)
	{
	    $r = new xajaxResponse();
	    
	    
	    $repo = new ModeloRemisionrollo();
	    $header = "";
	    
	    
	    $header = " <th>Almacen</th>                    
                    <th>Existencia</th>
								";
	    
	    $r->assign("tblReporteHead", "innerHTML", $header);
	    
	    $sql = "select rr.almacen,vr.codigo, SUM(if (rr.existencia > 0, rr.existencia,0)) existencia
                from remisionrollo rr
                inner join viewrollos vr
                on rr.remisionrollo_rollo_idrollo = vr.idrollo                
                where rr.estado <> 'BAJA' AND rr.existencia <> 0 ";
	    
// 	    left join registroproduccion rp
// 	    on rr.idremisionrollo = rp.idremisionrollo
	    
	    if ($filtro["almacen"] != 'ALL')
	    {
	        $sql .= " AND rr.almacen = '".$filtro["almacen"]."' ";
	    }
	    
	    $sql .= " GROUP BY rr.almacen ";
	    
	    $lst = $repo->getDataSet($sql);
	    
	    $detalle = "";
	    $totalExistencia = 0;
	    foreach ($lst as $row)
	    {
	        $totalExistencia += (float)$row["existencia"];
	        
	        $detalle .= "<tr>";
	        
	        $detalle .= "<td>".$row["almacen"]."</td>";
	        $detalle .= "<td>".number_format($row["existencia"],2)."</td>";
	        
	        $detalle .= "</tr>";
	        
	    }
	    
	    $r->assign("tblReporteBody", "innerHTML", $detalle);
	    $r->script("app.totalExistencia = ".$totalExistencia."; mdlExitWait();");
	    
	    return $r;
	}
	$xajax->registerFunction("obtenerReporteAgrupado");

	

	$xajax->processRequest();

	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Procesamiento de formulario----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#


	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Inicializacion de variables----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	

	#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------Salida de Javascript-------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	
 	