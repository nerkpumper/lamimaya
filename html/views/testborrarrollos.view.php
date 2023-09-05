<?php

require_once FOLDER_MODEL. "model.remisionrollo.inc.php";
require_once FOLDER_MODEL. "model.invzmovrollo.inc.php";


// $idremisiones = [2060,    2061,    2062,    2065,    2072,    2073,    2074,    2075,    2076,    2077,    2078,    2079,    2080,    2081,    2083,    2093,    2094   ];
//$idremisiones = [2065,    2072,    2073,    2074,    2075,    2076,    2077,    2078,    2079,    2080,    2081,    2083,    2093,    2094   ];

$idremisiones = [
2095,
2096,
2097,
2098,
2099,
2100,
2101,
2102,
2103,
2104,
2105,
2106,
2107,
2108,
2109,
2110,
2111];  


//  $idremisiones = [2062];


foreach ($idremisiones as $remi) 
{
    $remisionRollo = new ModeloRemisionrollo();
		
		$remisionRollo->setIdRemisionRollo($remi);
		
		if ($remisionRollo->getIdRemisionRollo() <= 0)
		{
			echo "<br><br>No se han podido cargar los datos del no. rollo.";			
			return;
        }
        
        if ($remisionRollo->getRemisionRollo_rollo_idRollo() > 100)
        {
            echo "<br><br>Parece que ya se hizo el proceso.";			
			return;
        }
		
		$mov = new ModeloInvzmovrollo();
		
		$mov->setIdRollo($remisionRollo->getRemisionRollo_rollo_idRollo());
		$mov->setIdRemisionRollo($remi);
		$mov->setDocumentoNINGUNO();
		$mov->setReferencia("R: " . $remisionRollo->getRemision() . " #: " . $remisionRollo->getNoRollo());
		$mov->setMovimientoSALIDA();
		$mov->setSalidaDespachoNO();
		$mov->setCantidad($remisionRollo->getExistencia());
		$mov->setObservaciones("Eliminacion de No. Rollo");
		$mov->setDateAndUser("movimiento");
		
		$remisionRollo->setNoRollo($remisionRollo->getNoRollo() . "_del_".date("YmdHis"));
		$remisionRollo->setEstadoBAJA();
		$remisionRollo->setDateAndUser("baja");
		$remisionRollo->setRemisionRollo_rollo_idRollo($remisionRollo->getRemisionRollo_rollo_idRollo() + 1000);
		
		
		$mov->Guardar();
		// return;
		if (!$mov->getError())		
		{
		
		    $remisionRollo->Guardar();
		    
		    
		    
		    if (!$remisionRollo->getError())
		    {
		        echo "<br>El No. Rollo " . $remisionRollo->getNoRollo() . " ha sido eliminado de manera correcta.";
		    }
		    else
		    {
		        echo "<br> - - - - - - -El No. Rollo ha sido descontado pero no se eliminó";
		    }
		    
			
		}
		else
		{
			echo "<br> *********************************************Ocurrió un error al intentar eliminar el No. Rollo. " . $mov->getStrError();
		}
}