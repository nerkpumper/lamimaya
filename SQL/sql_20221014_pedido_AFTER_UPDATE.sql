DROP TRIGGER IF EXISTS `pedido_AFTER_UPDATE`;CREATE TRIGGER `pedido_AFTER_UPDATE` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
	DECLARE vidPromotor INTEGER;
    DECLARE vsucursales VARCHAR(255);
    DECLARE vFechaCompromisoPedido DATETIME;
	DECLARE vFechaCompromisoVale DATETIME;
    SELECT idUsuarioPromotor INTO vidPromotor
     FROM cliente
	WHERE idCliente = NEW.idCliente;
    IF OLD.fechaCompromiso <> NEW.fechaCompromiso THEN
    UPDATE `valesalida` SET `fechaCompromiso` = NEW.fechaCompromiso WHERE     idPedido = NEW.idPedido;
    END IF;   
	IF OLD.estado = 'CAPTURADO' AND NEW.estado = 'AUTORIZADO' THEN	
			/*INSERT INTO notificacion (idProvoca, idPara, tema, contenido) 
				VALUES (NEW.id_usuario_autorizado, 4, concat('Pedido ', NEW.idPedido ,' Autorizado'), concat('Ha Autorizado el [PED_AI]',NEW.idPedido,'[PED_AT]',NEW.idPedido,'[PED_AF]. Si puede producirse podrá pasarlo a PRODUCCIÓN.')); */
			IF OLD.saldada = 'NO' AND NEW.saldada = 'SI' THEN
				IF vidPromotor = NEW.id_usuario_capturado THEN            
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
				ELSE
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
				END IF;
            ELSE
				IF vidPromotor = NEW.id_usuario_capturado THEN            
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
				ELSE
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
				END IF;
            END IF;
	END IF;
    IF OLD.colocado = 'SI' AND NEW.colocado = 'NO' THEN	
			SET SQL_SAFE_UPDATES = 0;
			delete from pedidodetallecolocacion 
            where idpedidodetalle in (SELECT idpedidodetalle FROM pedidodetalle where idpedido = NEW.idPedido);       
            IF NEW.idPedido > 1 THEN
				delete from valesalidadetalle where idpedido = NEW.idPedido;
                delete from valesalida where idpedido = NEW.idPedido;
                delete from valesalidapromotordetalle where idpedido = NEW.idPedido;
                delete from valesalidapromotor where idpedido = NEW.idPedido;
            END IF;
            SET SQL_SAFE_UPDATES = 1;
	END IF;
    IF OLD.colocado = 'NO' AND NEW.colocado = 'SI' THEN	
		SET vsucursales = '';
		select GROUP_CONCAT(distinct sucursal.nombre  SEPARATOR ', ') into vsucursales
			from pedidodetallecolocacion
			inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
			where idpedidodetalle in (select idpedidodetalle from pedidodetalle where idpedido = NEW.idPedido)
            AND pedidodetallecolocacion.cantidad > 0;
IF vsucursales = 'TORRES LANDA' THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, 30, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal\t\t\t\t\t\t\t(es):',vsucursales,'.'), NEW.idPedido);
		END IF;
IF vsucursales = 'GALVAMEX LAGOS DE MORENO' THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, 11, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal\t\t\t\t\t\t\t(es):',vsucursales,'.'), NEW.idPedido);
		END IF; 
IF vsucursales = 'MORELOS' THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, 36, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal\t\t\t\t\t\t\t(es):',vsucursales,'.'), NEW.idPedido);
		END IF;  
IF vidPromotor = NEW.id_usuario_capturado THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal(es):',vsucursales,'.'), NEW.idPedido);
            ELSE
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido asignado a la(s) sucursal(es): ',vsucursales,'.'), NEW.idPedido);
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido asignado a la(s) sucursal(es): ',vsucursales,'.'), NEW.idPedido);
			END IF;
    END IF;
    IF OLD.saldo <> NEW.saldo THEN
		UPDATE cliente SET usado = getCreditoUsadoCliente(NEW.idCliente) WHERE idCliente = NEW.idCliente;
        IF NEW.saldo <= 0 THEN
			IF vidPromotor = NEW.id_usuario_capturado THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
            ELSE
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
			END IF;
        END IF;
    END IF;
    IF NEW.estado = 'CANCELADO' THEN	
		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, 22, 2, concat('Pedido ', NEW.idPedido,' CANCELADO', ' factura asignada ', NEW.factura), concat('El pedido ', NEW.idPedido,' ha sido Cancelado.'), NEW.idPedido);
    END IF;
    IF OLD.total <> NEW.total THEN
		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, 22, 2, concat('Importe de Pedido ', NEW.idPedido,' ha cambiado'), concat('El importe del pedido ', NEW.idPedido,' ha cambiado. Antes: ', OLD.total, ', ahora: ', NEW.total, ' factura asignada ', NEW.factura), NEW.idPedido);
    END IF;
    IF OLD.saldopromotor <> NEW.saldopromotor THEN
		UPDATE usuario SET usado = getCreditoUsadoPromotor(vidPromotor) WHERE idUsuario = vidPromotor;
    END IF;
    IF  NEW.colocadoAutomatico = 'SI' THEN
	INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, 28, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO AUTOMATICO'), concat('El pedido ', NEW.idPedido,' ha sido asignado en automatico .'), NEW.idPedido);
				END IF;
                
END