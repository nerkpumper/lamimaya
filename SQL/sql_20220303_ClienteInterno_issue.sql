INSERT INTO pedidotrace (trace) VALUES ('El Pedido se ha AUTORIZADO automáticamente por ser cliente GALVAMEX consumo interno');

-- [67]

DROP TRIGGER IF EXISTS `galvamex_appgalva`.`pedido_BEFORE_INSERT`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE  TRIGGER `pedido_BEFORE_INSERT` BEFORE INSERT ON `pedido` FOR EACH ROW BEGIN
	DECLARE vDisponible DECIMAL(9,2);
    DECLARE vTotalSaldoClente DECIMAL(9,2);
    DECLARE vCapacidadPagoCliente DECIMAL(9,2);
    DECLARE vsaldarpedidoparaautorizar VARCHAR(2);
    DECLARE vNoPedidosCliente INTEGER;
    DECLARE vNoPedidosClienteSinSaldar INTEGER;
    SET vNoPedidosClienteSinSaldar = 0;
    SET vNoPedidosCliente = 0;
    select getNoPedidosClienteSinSaldar(NEW.idCliente) INTO vNoPedidosClienteSinSaldar;
    select getNoPedidosCliente(NEW.idCliente) INTO vNoPedidosCliente;
    select getTotalSaldosCliente(NEW.idCliente) INTO vTotalSaldoClente;
    SELECT getDisponibleCreditoCliente(NEW.idCliente) INTO vDisponible;
    SET vsaldarpedidoparaautorizar = 'SI';
    /*SELECT saldarpedidoparaautorizar INTO vsaldarpedidoparaautorizar FROM cliente WHERE idCliente = NEW.idCliente;*/
    SELECT saldarpedidoparaautorizar, capacidadPago INTO vsaldarpedidoparaautorizar, vCapacidadPagoCliente FROM cliente WHERE idCliente = NEW.idCliente;
    /* SET vDisponible = vDisponible + NEW.total; 
    IF NEW.total <= vDisponible AND vsaldarpedidoparaautorizar = 'NO' THEN
		SET NEW.fecha_autorizado = getCurrentTimeStamp();
        SET NEW.id_usuario_autorizado = NEW.id_usuario_capturado;
        SET NEW.observacionAutoriza = 'AUTORIZADO AUTOMÁTICO POR CRÉDITO DE CLIENTE';
        SET NEW.estado = 'AUTORIZADO';
    END IF;*/
    IF NEW.recogeentrega = 'RECOGE' THEN
		SET NEW.generarValeSalida = 'SI';
    END IF;
    IF vNoPedidosCliente > 1 THEN
		SET NEW.tipocliente = 'CAUTIVO';
	ELSE
		IF vNoPedidosCliente = 0 THEN
			UPDATE cliente SET idUsuarioPromotor = idUsuarioPromotor;
		END IF;
    END IF;
     IF NEW.id_usuario_capturado = 9 OR NEW.id_usuario_capturado = 11 THEN
		SET NEW.idSucursalCapturado = 2;
    ELSE
		IF NEW.id_usuario_capturado = 18 THEN
			SET NEW.idSucursalCapturado = 1;
        END IF;		
    END IF;
    SET NEW.checarAutorizacion = 'SI';
	/* 2086 GALVAMEX Consumo Interno */
    IF NEW.idCliente = 2086 THEN
		SET NEW.saldo = 0;
        SET NEW.saldada = 'SI';
        SET NEW.fecha_saldada = NOW();
        SET NEW.fecha_autorizado = NOW();
        SET NEW.id_usuario_autorizado = 2;
        SET NEW.estado = 'AUTORIZADO';
        SET NEW.porDescuento = 100;
        SET NEW.descuento = NEW.total;
        SET NEW.observacionAutoriza = 'AUTORIZADO EN AUTOMÁTICO POR SER GALVAMEX CONSUMO INTERNO';
        SET NEW.tipoAutorizacion = 'AUTOMATICO';
        INSERT INTO pedidostracking (idPedido, idPedidoTrace, json, tipo, fecha)
           VALUES (NEW.idPedido, 67, '', 'SUCCESS', NOW());
    END IF;
	SET NEW.fecha_updateprecios = NEW.fecha_capturado;
END$$
DELIMITER ;
