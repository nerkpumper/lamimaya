<?php

	// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#
	
	

	require_once FOLDER_MODEL. "model.material.inc.php";
	require_once FOLDER_MODEL. "model.aplicacion.inc.php";
	require_once FOLDER_MODEL. "model.tipoproducto.inc.php";
	require_once FOLDER_MODEL. "model.unidad.inc.php";
// 	require_once FOLDER_MODEL. "model.rollo.inc.php";
	require_once FOLDER_MODEL. "model.viewproductos.inc.php";
	require_once FOLDER_MODEL. "model.proveedor.inc.php";
	
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
        // $r->starDebug();
        
        
        $vp = new ModeloViewproductos();
        
        // filtro: {
		// 	tipoProducto: '0',
		// 	aplicacion: '0',
		// 	material: '0',
		// 	unidad: '4'
        // },
        $lst = $vp->getDataSet("call spGetProductosStock(".$filtro["tipoProducto"].",".$filtro["aplicacion"].",".$filtro["material"].",".$filtro["unidad"].",".$filtro["proveedor"].")");
        // $lst = $vp->getDataSet("call spGetProductosStock()");
        
        // $lst = $vp->getDataSet("select idproducto, codigo, material, aplicacion from viewproductos");

        $pushcol = "";
        $pushrow = "";
        
        if (count($lst) > 0)
        {

            foreach($lst[0] as $key=>$value)
            {
                $pushcol .= "
                    app.columns.push({
                            col: '".$key."'
                        });
                ";
                // echo "{col: '".$key."'},";
            }
    
            // echo "]<br><br>";
            
            foreach($lst as $row)
            {
                $data = "";
    
                
                foreach($row as $key=>$value)
                {
                    $data .= "{ dato: '".$value."'	},";
                }
                
                
                $pushrow .= "
                    app.rows.push({
                            data: [".$data."]
                        });
                ";
                
               
            }
            
        }
        $r->script(" app.columns.splice(0, app.columns.length); ".$pushcol);
        $r->script(" app.rows.splice(0, app.rows.length); ".$pushrow . "  mdlExitWait();  ");

		// $r->endDegug();
		return $r;
	}	
	$xajax->registerFunction("obtenerReporte");

	

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
	
 	$unidad = new ModeloUnidad();
		
 	$lstUnidades = $unidad->getOptionForSelectOnlyList($unidad->getForSelect("idUnidad", "concat(clave,' - ',descripcion)"));
		
 	$material = new ModeloMaterial();
			
 	$lstMateriales = $material->getOptionForSelect($material->getForSelect("idMaterial", "nombre", "estado = 'ACTIVO'"), "0", "-- TODOS --");
	
	$tipoProducto = new ModeloTipoproducto();
		
	$lstTiposProducto = $tipoProducto->getOptionForSelect($tipoProducto->getForSelect("idTipoProducto", "nombre", "estado = 'ACTIVO'", "1"), "0", "-- TODOS --");
		
 	$aplicacion = new ModeloAplicacion();
	
 	$lstModelosLamina = $aplicacion->getOptionForSelect($aplicacion->getForSelect("idAplicacion", "nombreAplicacion", "estado = 'ACTIVO'"), "0", "-- TODAS --");
	
	$proveedor = new Modeloproveedor();
	
	$lstProveedor = $proveedor->getOptionForSelect($proveedor->getForSelect("idProveedor", "nombre", "estado = 'ACTIVO'"), "0", "-- TODOS --");