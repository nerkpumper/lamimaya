<?php

require_once FOLDER_MODEL. "model.pedido.inc.php";

echo "Reclacular Pedido";

if (!isset($param1))
{
    echo "<br><br> No se ha especificado numero de pedido";
}
else
{
    $pedido = new ModeloPedido();
    
    $pedido->RecalcularPedido($param1, false);
    echo "<br> procesando . . . . . . . . . .";
    $pedido->RecalcularPedido($param1, true);
    echo "<br> proceso terminado . . . . . . . . . .";
    $pedido->RecalcularPedido($param1, false);
}




return;

$pedido = new ModeloPedido();

$pedido->RecalcularPedido(2883, true);
$pedido->RecalcularPedido(2924, true);
$pedido->RecalcularPedido(2931, true);
$pedido->RecalcularPedido(2944, true);
$pedido->RecalcularPedido(2972, true);
$pedido->RecalcularPedido(3020, true);
$pedido->RecalcularPedido(3041, true);
$pedido->RecalcularPedido(3047, true);
$pedido->RecalcularPedido(3054, true);
$pedido->RecalcularPedido(3106, true);
$pedido->RecalcularPedido(3114, true);
$pedido->RecalcularPedido(3135, true);
$pedido->RecalcularPedido(3136, true);
$pedido->RecalcularPedido(3157, true);
$pedido->RecalcularPedido(3241, true);
$pedido->RecalcularPedido(3310, true);
$pedido->RecalcularPedido(3333, true);
$pedido->RecalcularPedido(3382, true);
$pedido->RecalcularPedido(3405, true);
$pedido->RecalcularPedido(3409, true);
$pedido->RecalcularPedido(3421, true);
$pedido->RecalcularPedido(3444, true);
$pedido->RecalcularPedido(3450, true);
$pedido->RecalcularPedido(3451, true);
$pedido->RecalcularPedido(3460, true);
$pedido->RecalcularPedido(3465, true);
$pedido->RecalcularPedido(3467, true);
$pedido->RecalcularPedido(3468, true);
$pedido->RecalcularPedido(3476, true);
$pedido->RecalcularPedido(3511, true);
$pedido->RecalcularPedido(3556, true);
$pedido->RecalcularPedido(3571, true);
$pedido->RecalcularPedido(3586, true);
$pedido->RecalcularPedido(3613, true);
$pedido->RecalcularPedido(3660, true);
$pedido->RecalcularPedido(3688, true);
$pedido->RecalcularPedido(3753, true);
$pedido->RecalcularPedido(3800, true);
$pedido->RecalcularPedido(3825, true);
$pedido->RecalcularPedido(3862, true);
$pedido->RecalcularPedido(3864, true);
$pedido->RecalcularPedido(3872, true);
$pedido->RecalcularPedido(3873, true);
$pedido->RecalcularPedido(3915, true);
$pedido->RecalcularPedido(3916, true);
$pedido->RecalcularPedido(4056, true);
$pedido->RecalcularPedido(4057, true);
$pedido->RecalcularPedido(4058, true);
$pedido->RecalcularPedido(4121, true);
$pedido->RecalcularPedido(4122, true);
$pedido->RecalcularPedido(4124, true);
$pedido->RecalcularPedido(4158, true);
$pedido->RecalcularPedido(4225, true);
$pedido->RecalcularPedido(4242, true);
$pedido->RecalcularPedido(4277, true);
$pedido->RecalcularPedido(4289, true);
$pedido->RecalcularPedido(4311, true);
$pedido->RecalcularPedido(4330, true);
$pedido->RecalcularPedido(4355, true);
$pedido->RecalcularPedido(4441, true);
$pedido->RecalcularPedido(4470, true);
$pedido->RecalcularPedido(4480, true);
$pedido->RecalcularPedido(4493, true);
$pedido->RecalcularPedido(4521, true);
$pedido->RecalcularPedido(4596, true);
$pedido->RecalcularPedido(4623, true);
$pedido->RecalcularPedido(4632, true);
$pedido->RecalcularPedido(4648, true);
$pedido->RecalcularPedido(4690, true);
$pedido->RecalcularPedido(4760, true);
$pedido->RecalcularPedido(4763, true);
$pedido->RecalcularPedido(4775, true);
$pedido->RecalcularPedido(4807, true);
$pedido->RecalcularPedido(4820, true);
$pedido->RecalcularPedido(4826, true);
$pedido->RecalcularPedido(4837, true);
$pedido->RecalcularPedido(4869, true);
$pedido->RecalcularPedido(4870, true);
$pedido->RecalcularPedido(4871, true);
$pedido->RecalcularPedido(4887, true);
