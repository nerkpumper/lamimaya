<?php

require_once "baseapi.inc.php";
require_once FOLDER_MODEL. "model.cortecaja.inc.php";

class APICorteCaja extends APIBase{

    public function currentCorte(){
        $idSucursal = $_GET["idSucursal"];
        $fechaCorte = $_GET["fechaCorte"];

        $sql = "SELECT * FROM cortecaja WHERE idSucursal = " . $idSucursal." AND estado = 'ABIERTO'";

        $corteCaja = new ModeloCortecaja();
        // $this->addResponse("query", "ddd"); 
        // return;
        $rs = $corteCaja->getDataSet($sql);

        if (!$rs)
        {
            $this->throwError("Ha ocurrido un error al intentar obtejer la información");
        }

        $objCorteCaja = $rs[0];

        $fechaApertura = $objCorteCaja["fecha_apertura"];
        $idCorteCaja = $objCorteCaja["idCorteCaja"];
        
        $sql = "SELECT (
                        SELECT SUM(cxc.monto) 
                        FROM cxc   
                        LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
                        INNER JOIN usuario on usuario.idUsuario = cxc.id_usuario_movimiento
                        WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
                        AND cxc.movimiento = 'ABONO'
                        AND cxc.formaPago = 1
                        AND cxc.idReciboDinero = 0
                        AND usuario.idSucursal = ".$idSucursal."
                        AND pedido.idPedido IS NOT NULL) as venta,
                (
                SELECT SUM(cxc.monto) 
                        FROM cxc   
                        LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
                        INNER JOIN usuario on usuario.idUsuario = cxc.id_usuario_movimiento
                        WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
                        AND cxc.movimiento = 'ABONO'
                        AND cxc.formaPago = 1
                        AND cxc.idReciboDinero = 0
                        AND usuario.idSucursal = ".$idSucursal."
                        AND pedido.idPedido IS NULL) as abono,
                (
                SELECT IFNULL(SUM(gasto.monto), 0)
                        FROM gasto                         
                        WHERE gasto.fecha_insert > '".$fechaApertura."' AND gasto.fecha_insert <= '".$fechaCorte."'
                        AND gasto.idSucursal = " .$idSucursal .") as gastos,
                (
                SELECT  IFNULL(SUM(recibodinero.monto), 0)
                        FROM recibodinero                      
                        INNER JOIN usuario ON recibodinero.id_usuario_captura = usuario.idUsuario     
                        WHERE recibodinero.fecha_captura > '".$fechaApertura."' AND recibodinero.fecha_captura <= '".$fechaCorte."'
                        AND recibodinero.formaPago = 1 
                        AND usuario.idSucursal = ".$idSucursal.") recibodinero
                
                ";
        
        
        $rsEfectivos = $corteCaja->getDataSet($sql)[0];

        $this->addResponse("error", false);        
        
        $this->addResponse("idSucursal", $idSucursal);        
        $this->addResponse("posibleFechaCorte", $fechaCorte);
        $this->addResponse("efectivos", $rsEfectivos);        
        $this->addResponse("corteCaja", $objCorteCaja);

        
    }

    public function save(){
        $cj = new ModeloCortecaja();

        $cj->transaccionIniciar();
        
        $idCorteCaja = $_POST["idCorteCaja"];        
        $idSucursal = $_POST["idSucursal"];        
        $fondoApertura = $_POST["fondoApertura"];
        $ventas = $_POST["ventas"];
        $abonos = $_POST["abonos"];
        $entradas = $_POST["entradas"];
        $salidas = $_POST["salidas"];
        $dejaEnFondo = $_POST["dejaEnFondo"];

        $cj->setIdCorteCaja($idCorteCaja);

        if ($cj->getIdCorteCaja() <= 0)
        {
            $this->throwError("Ocurrió un error al cargar la información del corte de caja");
            return;
        }
        
        $cj->setVentas($ventas);
        $cj->setAbonos($abonos);
        $cj->setEntradas($entradas);
        $cj->setSalidas($salidas);
        $cj->setFondoCajaAlCorte($dejaEnFondo);
        $cj->setEstadoREALIZADO();
        
        $cj->setDateAndUser("corte", $this->idUsuario);

        
        $cj->Guardar();

        if ($cj->getError())
        {
            $cj->transaccionRollback();
            $this->throwError($cj->getStrError());
            return;            
        }       

        $cjnew = new ModeloCortecaja();

        $cjnew->setFondoCajaApertura($dejaEnFondo);
        $cjnew->setIdSucursal($idSucursal);
        $cjnew->setEstadoABIERTO();
        $cjnew->setDateAndUser("apertura", $this->idUsuario);

        $cjnew->Guardar();

        if ($cjnew->getError())
        {
            $cj->transaccionRollback();    
            $this->throwError($cjnew->getStrError());        
            return;            
        }  
        
        $cj->transaccionCommit();

        $this->addResponse("error", false);
        $this->addResponse("idCorteCaja", $cjnew->getIdCorteCaja());           
    }

    public function getConceptos(){
        $cg = new ModeloConceptogasto();

        $query = "SELECT idTipoGasto, descripcion FROM conceptogasto ORDER BY idConceptoGasto";

        $lst = $cg->getDataSet($query);

        $this->addResponse("error", false);
        $this->addResponse("lst", $lst);
    }

    //paginaciones
    public function getCortesPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];

        $query = "
            SELECT COUNT(*) total
            FROM cortecaja 
            INNER JOIN sucursal ON cortecaja.idSucursal = sucursal.idSucursal
            INNER JOIN usuario ON cortecaja.id_usuario_corte = usuario.idUsuario
            WHERE cortecaja.estado = 'REALIZADO' AND cortecaja.idSucursal = ". $idSucursal;

        $cc = new ModeloCortecaja();

        $rs = $cc->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT cortecaja.idCorteCaja, cortecaja.fondoCajaApertura, cortecaja.ventas, cortecaja.abonos, cortecaja.entradas, cortecaja.salidas, cortecaja.fondoCajaAlCorte, 
                (cortecaja.fondoCajaApertura + cortecaja.ventas + cortecaja.abonos + cortecaja.entradas - cortecaja.salidas - cortecaja.fondoCajaAlCorte) recogido, 
                cortecaja.fecha_apertura, DATE_FORMAT(cortecaja.fecha_corte, '%d/%m/%Y %h:%i:%s') fecha_corte,
                sucursal.nombre sucursal, concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuarioCorte
            FROM cortecaja 
            INNER JOIN sucursal ON cortecaja.idSucursal = sucursal.idSucursal
            INNER JOIN usuario ON cortecaja.id_usuario_corte = usuario.idUsuario
            WHERE cortecaja.estado = 'REALIZADO' AND cortecaja.idSucursal = ". $idSucursal."
            ORDER BY cortecaja.idCorteCaja DESC
              LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $cc->getDataSet($query);
                
        $this->addResponse("error", false);          
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }

    public function getSalidasPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];
        $fechaApertura = $_GET["fechaApertura"];
        $fechaCorte = $_GET["fechaCorte"];

        $query = "
            SELECT COUNT(*) total
            FROM gasto                       
            INNER JOIN tipogasto  ON gasto.idTipoGasto = tipogasto.idTipoGasto
            INNER JOIN usuario ON gasto.id_usuario_insert = usuario.idUsuario
            WHERE gasto.fecha_insert > '".$fechaApertura."' AND gasto.fecha_insert <= '".$fechaCorte."'
            AND gasto.idSucursal = ".$idSucursal;

        $cc = new ModeloCortecaja();

        $rs = $cc->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT tipogasto.descripcion concepto, gasto.monto, gasto.detalle, DATE_FORMAT(gasto.fecha_insert, '%d/%m/%Y %h:%i:%s') fecha,
                    concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario
            FROM gasto                       
            INNER JOIN tipogasto  ON gasto.idTipoGasto = tipogasto.idTipoGasto
            INNER JOIN usuario ON gasto.id_usuario_insert = usuario.idUsuario
            WHERE gasto.fecha_insert > '".$fechaApertura."' AND gasto.fecha_insert <= '".$fechaCorte."'
            AND gasto.idSucursal = ".$idSucursal."     
            ORDER BY gasto.fecha_insert
                          LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $cc->getDataSet($query);
                
        $this->addResponse("error", false);          
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }

    public function getEntradasPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];
        $fechaApertura = $_GET["fechaApertura"];
        $fechaCorte = $_GET["fechaCorte"];

        $query = "
            SELECT COUNT(*) total
            FROM recibodinero                           
            INNER JOIN usuario ON recibodinero.id_usuario_captura = usuario.idUsuario
            INNER JOIN cliente on recibodinero.idCliente = cliente.idCliente
            WHERE recibodinero.fecha_captura > '".$fechaApertura."' AND recibodinero.fecha_captura <= '".$fechaCorte."'
            AND recibodinero.formaPago = 1
            AND usuario.idSucursal = ".$idSucursal;

        $cc = new ModeloCortecaja();

        $rs = $cc->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT recibodinero.monto, recibodinero.referencia, DATE_FORMAT(recibodinero.fecha_captura, '%d/%m/%Y %h:%i:%s') fecha,
                    concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                    concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario
            FROM recibodinero                           
            INNER JOIN usuario ON recibodinero.id_usuario_captura = usuario.idUsuario
            INNER JOIN cliente on recibodinero.idCliente = cliente.idCliente
            WHERE recibodinero.fecha_captura > '".$fechaApertura."' AND recibodinero.fecha_captura <= '".$fechaCorte."'
            AND recibodinero.formaPago = 1
            AND usuario.idSucursal = ".$idSucursal."     
            ORDER BY recibodinero.fecha_captura
                          LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $cc->getDataSet($query);
                
        $this->addResponse("error", false);           
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }

    public function getVentasPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];
        $fechaApertura = $_GET["fechaApertura"];
        $fechaCorte = $_GET["fechaCorte"];

        $query = "
            SELECT COUNT(*) total
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND cxc.idReciboDinero = 0
            AND usuario.idSucursal =  ".$idSucursal."   
            AND pedido.idPedido IS NOT NULL                 
            ORDER BY cxc.fecha_movimiento";

        $cc = new ModeloCortecaja();

        $rs = $cc->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT cxc.idPedido, cxc.monto, DATE_FORMAT(cxc.fecha_movimiento, '%d/%m/%Y %h:%i:%s') fecha,
                concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario            
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND cxc.idReciboDinero = 0
            AND usuario.idSucursal =  ".$idSucursal."   
            AND pedido.idPedido IS NOT NULL                 
            ORDER BY cxc.fecha_movimiento
                          LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $cc->getDataSet($query);
                
        $this->addResponse("error", false);           
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }

    public function getAbonosPage(){
        $idSucursal = $_GET["idSucursal"];
        $page = $_GET["page"];
        $pageSize = $_GET["pageSize"];
        $fechaApertura = $_GET["fechaApertura"];
        $fechaCorte = $_GET["fechaCorte"];

        $query = "
            SELECT COUNT(*) total
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND cxc.idReciboDinero = 0
            AND usuario.idSucursal =  ".$idSucursal."   
            AND pedido.idPedido IS NULL                 
            ORDER BY cxc.fecha_movimiento";

        $cc = new ModeloCortecaja();

        $rs = $cc->getDataSet($query)[0];

        $totalReg = $rs["total"];

        $query = "
            SELECT cxc.idPedido, cxc.monto, DATE_FORMAT(cxc.fecha_movimiento, '%d/%m/%Y %h:%i:%s') fecha,
                concat(cliente.nombre, ' ', cliente.apellidos) cliente,
                concat(usuario.nombre, ' ' , usuario.apellidoPaterno, ' ', usuario.apellidoMaterno) usuario            
            FROM cxc   
            LEFT JOIN pedido ON cxc.idPedido = pedido.idpedido AND pedido.fecha_capturado > '".$fechaApertura."' AND pedido.fecha_capturado <= '".$fechaCorte."'
            INNER JOIN usuario ON cxc.id_usuario_movimiento = usuario.idUsuario 
            INNER JOIN cliente ON cxc.idCliente = cliente.idCliente
            WHERE cxc.fecha_movimiento > '".$fechaApertura."' AND cxc.fecha_movimiento <= '".$fechaCorte."'
            AND cxc.movimiento = 'ABONO'
            AND cxc.formaPago = 1
            AND cxc.idReciboDinero = 0
            AND usuario.idSucursal =  ".$idSucursal."   
            AND pedido.idPedido IS NULL                 
            ORDER BY cxc.fecha_movimiento
                          LIMIT ".$pageSize."
              OFFSET ".($page * $pageSize);

        $list = $cc->getDataSet($query);
                
        $this->addResponse("error", false);           
        $this->addResponse("totalregs", $totalReg);  
        $this->addResponse("list", $list);          
    }
}

$api = new APICorteCaja();
$api->run();