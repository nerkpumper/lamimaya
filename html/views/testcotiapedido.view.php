<?php

require_once FOLDER_MODEL. "model.cotizacion.inc.php";

$cotizacion = new ModeloCotizacion();

// $cotizacion->transaccionCommit();
// return;

//$cotizacion->setIdCotizacion(11);

if ($cotizacion->pasarCotizacionAPedido(48))
{
    echo "La cotizacion se ha convertido en el pedido " . $cotizacion->getIdPedido();
}
else {
    echo "error<br><br>";
}

// $cotizacion->dumpObj();

