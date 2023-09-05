ALTER TABLE `galvamex_appgalva`.`pedido` 
ADD COLUMN `apartarMercancia` ENUM('SI', 'NO') NULL DEFAULT 'SI' AFTER `desbloqueadoPreciosAdmin`;


USE `galvamex_appgalva`;
DROP function IF EXISTS `getRolloApartado`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getRolloApartado`(`pIdRollo` INTEGER) RETURNS decimal(15,2)
BEGIN    
    DECLARE vApartado DECIMAL(15,2);
    select ifnull(sum(IF(pro.producto_tipoProducto_idTipoProducto = 5,
				(pd.partida * pd.cantidad),
				(pd.partida *pd.cantidad* 
					IF(pd.pesoKiloML = 0,
						(SELECT pesokgmt FROM `viewrollos` WHERE idRollo = 2 ), 
                        pd.pesoKiloML))) - 
					IF(p.recogeentrega = 'OBRA',
						(pd.mlDespachado * pd.pesoKiloML),
                        IF(pro.producto_tipoProducto_idTipoProducto = 5 ,
							(pd.partidaDespachada * pd.cantidad), 
                            (pd.partidaDespachada * pd.cantidad * pd.pesoKiloML ))
							)), 0) INTO  vApartado
		from pedidodetalle pd
		inner join pedido p on p.idpedido = pd.idpedido and p.apartarMercancia = 'SI'
		inner join producto pro on pro.idproducto = pd.idproducto 
		where p.estado in ('CAPTURADO', 'AUTORIZADO', 'PRODUCCION')
		-- and pd.listo_para_producir = 'SI' 
        and pd.despachado = 'NO'
		and pro.producto_rollo_idrollo = pIdRollo;
	RETURN vApartado;
END$$

DELIMITER ;




USE `galvamex_appgalva`;
DROP function IF EXISTS `getProductoApartado`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE  FUNCTION `getProductoApartado`(`pIdProducto` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
	DECLARE vApartadoProductoMl DECIMAL(15,2);
    DECLARE vProductoUnidad INT(11);
    
    SELECT SUM(pd.partida) - (pd.partidaDespachada), 
           SUM(pd.partida * pd.cantidad) - (pd.partidaDespachada*pd.cantidad), 
           producto.producto_unidad_idUnidad  INTO  vApartado, vApartadoProductoML, vProductoUnidad
		from pedidodetalle pd
		inner join pedido p
		on p.idpedido = pd.idpedido AND p.apartarMercancia = 'SI'
		inner join producto
        on producto.idProducto = pd.idProducto 
		where p.estado in ('CAPTURADO', 'AUTORIZADO', 'PRODUCCION')
		-- and pd.listo_para_producir = 'SI' 
        and pd.despachado = 'NO'
		and pd.idproducto = pIdProducto;
	
    IF(vProductoUnidad=1)THEN
    	RETURN vApartadoProductoML;
    ELSE
        RETURN vApartado;
    END IF;
END$$

DELIMITER ;



USE `galvamex_appgalva`;
DROP function IF EXISTS `getProductoApartadoReal`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE  FUNCTION `getProductoApartadoReal`(`pIdProducto` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
        DECLARE vApartadoProductoMl DECIMAL(15,2);
        DECLARE vProductoUnidad INT(11);
    
    select sum(pd.partida)-(pd.partidaDespachada), 
			sum(pd.partida * pd.cantidad)-(pd.partidaDespachada*pd.cantidad), 
            producto.producto_unidad_idUnidad  INTO  vApartado, vApartadoProductoML, vProductoUnidad
		from pedidodetalle pd
		inner join pedido p
		on p.idpedido = pd.idpedido AND p.apartarMercancia = 'SI'
                inner join producto
                on producto.idProducto = pd.idProducto
		where p.estado in ('CAPTURADO', 'AUTORIZADO', 'PRODUCCION')
		/*and pd.listo_para_producir = 'NO'*/ and pd.despachado = 'NO' 
		and pd.idproducto = pIdProducto;
    IF(vProductoUnidad=1)THEN
    	RETURN vApartadoProductoML;
    ELSE
        RETURN vApartado;
    END IF;
END$$

DELIMITER ;



USE `galvamex_appgalva`;
DROP function IF EXISTS `getProductoApartadoSucursal`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE  FUNCTION `getProductoApartadoSucursal`(`pIdProducto` INTEGER, `pIdSucursal` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
    DECLARE vApartadoProductoMl DECIMAL(15,2);
    DECLARE vProductoUnidad INT(11);
    
    select sum(pdc.cantidad - pdc.cantidadSurtida),
			sum((pdc.cantidad - pdc.cantidadSurtida)*(pd.cantidad)), 
            producto.producto_unidad_idUnidad  INTO  vApartado , vApartadoProductoMl ,vProductoUnidad
		from pedidodetalle pd
		inner join pedido p on p.idpedido = pd.idPedido AND p.apartarMercancia = 'SI'
        inner join pedidodetallecolocacion pdc on pd.idpedidodetalle = pdc.idpedidodetalle and pdc.cantidad > 0
        INNER JOIN producto on pd.idProducto = producto.idProducto
		where p.estado in ('CAPTURADO', 'AUTORIZADO', 'PRODUCCION')
		/*and pd.listo_para_producir = 'NO'*/ and pd.despachado = 'NO'
		and pd.idproducto = pIdProducto
        and pdc.idSucursal = pIdSucursal		;
    	
	IF(vProductoUnidad=1)THEN
        RETURN IFNULL(vApartadoProductoML, 0);
    ELSE  
        RETURN IFNULL(vApartado, 0);
    END IF;
END$$

DELIMITER ;



USE `galvamex_appgalva`;
DROP function IF EXISTS `getProductosApartadoAutorizados`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getProductosApartadoAutorizados`(`pIdProducto` INT) RETURNS int(11)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
    select IFNULL(sum(partida),0) INTO  vApartado
		from pedidodetalle pd
		inner join pedido p
		on p.idpedido = pd.idpedido AND p.apartarMercancia = 'SI'
		where p.estado in ('AUTORIZADO', 'PRODUCCION')
		and pd.listo_para_producir = 'SI' and pd.despachado = 'NO'
		and pd.idproducto = pIdProducto;
	RETURN vApartado;
END$$

DELIMITER ;

