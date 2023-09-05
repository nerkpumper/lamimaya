CREATE DEFINER=`root`@`localhost` TRIGGER `pedidodetalle_AFTER_UPDATE` AFTER UPDATE ON `pedidodetalle` FOR EACH ROW BEGIN
	DECLARE vNoDespachados INTEGER;
    DECLARE vPartidaDespachada DOUBLE;
    DECLARE vKilosDespachados DOUBLE;
    DECLARE vidPromotor INTEGER;
    DECLARE vidUsuarioCapturado INTEGER;
    IF OLD.partidadespachada <> NEW.partidadespachada AND NEW.idPedido < 5867 THEN
		SET vPartidaDespachada = NEW.partidadespachada - OLD.partidadespachada;
        IF vPartidaDespachada > 0 THEN
			   /*select idpedidodetalle, idpedido, idproduc	to, cantidad, fecha_despachado, id_usuario_despachado from pedidodetalle; */
				INSERT INTO valesalidadetalle (idPedidoDetalle, idPedido, idProducto, cantidad,fecha_despacho, id_usuario_despacho, idSucursalDespachado) 
                VALUES (NEW.idpedidodetalle, NEW.idpedido, NEW.idproducto, vPartidaDespachada, NEW.fecha_despachado, NEW.id_usuario_despachado, NEW.idSucursalDespachado);
        END IF;
        /*ESTO ES PARA LOS PRODUCTOS*/
        IF NEW.partidadespachada > OLD.partidadespachada THEN
			SET vPartidaDespachada = NEW.partidadespachada - OLD.partidadespachada;
            SET vKilosDespachados = NEW.explotarUnidad * vPartidaDespachada;
			/* se incrementó la partida, osea, se surtió */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'DESAPARTADO', vPartidaDespachada, vKilosDespachados, NEW.fecha_despachado, NEW.id_usuario_despachado);			
		ELSE
			SET vPartidaDespachada = OLD.partidadespachada- NEW.partidadespachada;
            SET vKilosDespachados = NEW.explotarUnidad * vPartidaDespachada;
            /* Se apartó, esto no debe pasar */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'APARTADO', vPartidaDespachada, vKilosDespachados, NEW.fecha_despachado, NEW.id_usuario_despachado);			
        END IF;
    END IF;
    /* ESTO ES PARA LOS ROLLOS */
    IF OLD.totalExplotado <> NEW.totalExplotado  THEN
        /*ESTO ES PARA LOS ROLLOS*/
        IF NEW.totalExplotado > OLD.totalExplotado THEN
            /*SET vPartidaDespachada = NEW.totalExplotado - OLD.totalExplotado;
             SET vPartidaDespachada = NEW.partida - OLD.partida;
            */
            SET vPartidaDespachada = NEW.partida;
            SET vKilosDespachados = NEW.totalExplotado - OLD.totalExplotado;
			/* se incrementó la partida, osea, se surtió */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'APARTADO', vPartidaDespachada, vKilosDespachados, getCurrentTimeStamp(), 2);			
		ELSE
			SET vPartidaDespachada = OLD.partida - NEW.partida;
            SET vKilosDespachados = NEW.totalExplotado - OLD.totalExplotado;
            /* Se apartó, esto no debe pasar */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'DESAPARTADO', vPartidaDespachada, kg, NEW.fecha_despachado, NEW.id_usuario_despachado);			
        END IF;
    END IF;
	-- IF OLD.despachado = 'NO' AND NEW.despachado = 'SI' THEN
    --     SELECT ifnull(count(*), 0), cliente.idUsuarioPromotor, pedido.id_usuario_capturado INTO vNoDespachados, vidPromotor, vidUsuarioCapturado
    --       FROM pedidodetalle 
    --       inner join pedido on pedido.idpedido = pedidodetalle.idpedido
    --       inner join cliente on cliente.idcliente = pedido.idcliente
	-- 	 WHERE pedidodetalle.idpedido = NEW.idPedido 
    --        AND pedidodetalle.despachado = 'NO';  
	-- 	IF vNoDespachados = 0 THEN
	-- 		UPDATE pedido
    --            SET despachado = 'SI',
    --                estado = 'TERMINADO',
    --                fecha_terminado = NEW.fecha_despachado,
    --                id_usuario_terminado = NEW.id_usuario_despachado
	-- 		 WHERE idPedido = NEW.idPedido;
    --          IF vidPromotor = vidUsuarioCapturado THEN            
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
    --         ELSE
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
	-- 		END IF;
    --     END IF;
    -- END IF;
END