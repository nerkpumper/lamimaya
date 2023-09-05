<?php

// ----------------------------------------------------------------------------------------------------------------------#
	// -------------------------------------------------------Includes-------------------------------------------------------#
	// ----------------------------------------------------------------------------------------------------------------------#

    require_once FOLDER_MODEL. "model.rentaEquipo.inc.php";

    $xajax = new xajax();

    function guardarRentaEquipo(
    $folio,
    $fechacaptura,
    $totalRentaEquipo,
    $nombreOperario1,
    $sueldoHr1,
    $nombreOperario2,
    $sueldoHr2, 
    $ayudante,
    $sueldoAyudante,
    $horasTrabajadas,
    $tipoCombustible,
    $costoLitro,
    $litrosConsumidos,
    $totalOperario, 
    $totalCombustible, 
    $total){
      
        $r = new xajaxResponse();
        // $r->starDebug();
        $rentaequipo = new ModeloRentaEquipo();
        

        $rentaequipo->setFolio($folio);
        $rentaequipo->setFecha_captura($fechacaptura);
        $rentaequipo->setTotalRentaEquipo($totalRentaEquipo);
        $rentaequipo->setNombreOperario1($nombreOperario1);
        $rentaequipo->setSueldoHr1($sueldoHr1);
        $rentaequipo->setNombreOperario2($nombreOperario2);
        $rentaequipo->setSueldoHr2($sueldoHr2);
        $rentaequipo->setSueldoAyudante($sueldoAyudante);
        $rentaequipo->setAyudante($ayudante);
        $rentaequipo->setTipoCombustible($tipoCombustible);
        $rentaequipo->setCostoLitro($costoLitro);
        $rentaequipo->setHorasTrabajadas($horasTrabajadas);
        $rentaequipo->setLitrosConsumidos($litrosConsumidos);
        $rentaequipo->setTotaHrsOperario($totalOperario);
        $rentaequipo->setTotalCombustible($totalCombustible);
        $rentaequipo->setTotal($total);
        
        // $r->endDegug();,
        // return $r;

<<<<<<< HEAD

<<<<<<< HEAD
        if($fechacaptura = '' or $fechacaptura = 0){
            $r->saSuccess("Ingrese Dato");
        }else{

            $rentaequipo->Guardar();
        }
=======
     
            $rentaequipo->Guardar();
     
>>>>>>> salvador-modulo-renta-equipo

        
=======
 
            $rentaequipo->Guardar();
            $r->script("app.limpiarCampos();");
    
>>>>>>> salvador-modulo-renta-equipo

        if ($rentaequipo->getError())
		{
			$r->saError($rentaequipo->getStrError());
			return $r;
        }
        else
		{
			$r->saSuccess("Movimiento registrado con �xito");
			
		}

        return $r;
    }
    $xajax->registerFunction("guardarRentaEquipo");
    $xajax->processRequest();