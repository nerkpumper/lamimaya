DELIMITER $$
CREATE  FUNCTION `cotizacionHaCambiadoDePrecio`(`pIdCotizacion` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	DECLARE resp VARCHAR(2);
	DECLARE cuantosNoMoldura INTEGER;
	DECLARE cuantosMoldura INTEGER;
	SET resp = 'NO';
	SELECT COUNT(*) INTO cuantosNoMoldura
	FROM cotizaciondetalle cd
	INNER JOIN cotizacion c ON cd.idcotizacion = c.idcotizacion
	INNER JOIN producto p ON cd.idproducto = p.idProducto
	WHERE cd.idproducto NOT IN (386, 394) 
	  AND cd.idcotizacion = pIdCotizacion
	  AND DATE_FORMAT(p.lastUpdate, '%Y-%m-%d %H:%i') > DATE_FORMAT(c.fecha_capturado, '%Y-%m-%d %H:%i');
	SELECT COUNT(*) INTO cuantosMoldura
	FROM cotizaciondetalle cd
	INNER JOIN cotizacion c ON cd.idcotizacion = c.idcotizacion
	INNER JOIN rollo r ON cd.idRolloBase = r.idrollo
	WHERE cd.idproducto = 386
	  AND cd.idcotizacion = pIdCotizacion
	  AND DATE_FORMAT(r.lastUpdate, '%Y-%m-%d %H:%i') > DATE_FORMAT(c.fecha_capturado, '%Y-%m-%d %H:%i');  
	IF (cuantosNoMoldura + cuantosMoldura) > 0 THEN
		SET resp = 'SI';
	END IF;
    RETURN resp;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getAbonoPedido0A30Dias`(`pIdPedido` INT, `pfechaPedido` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbono DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0)  INTO vAbono
	  FROM cxc
	  WHERE movimiento = 'ABONO' 
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND DATE_FORMAT(CURDATE(), '%Y-%m-%d')	  
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') <= pfechaPedido
	  AND idPedido = pIdPedido;
    RETURN vAbono;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getAbonoPedido31A60Dias`(`pIdPedido` INTEGER, `pfechaPedido` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbono DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0)  INTO vAbono
	  FROM cxc 
	  WHERE movimiento = 'ABONO' 
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 31 DAY), '%Y-%m-%d')
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') <= pfechaPedido	  
	  AND idPedido = pIdPedido;
    RETURN vAbono;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getAbonoPedidoMas60Dias`(`pIdPedido` INTEGER, `pfechaPedido` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbono DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0)  INTO vAbono
	  FROM cxc 
	  WHERE movimiento = 'ABONO'
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d')  < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d')	
	  AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') <= pfechaPedido	  
	  AND idPedido = pIdPedido;
    RETURN vAbono;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getAbonoPedidoTotalAmparar`(`pIdPedido` INTEGER, `pfechaPedido` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldoHasta30 DECIMAL(15,2);
	DECLARE vSaldoHasta60 DECIMAL(15,2);
	DECLARE vSaldoDespues60 DECIMAL(15,2);
	SELECT getAbonoPedido0A30Dias(pIdPedido, pfechaPedido), 
           getAbonoPedido31A60Dias(pIdPedido, pfechaPedido), 
		   getAbonoPedidoMas60Dias(pIdPedido, pfechaPedido)
		   INTO vSaldoHasta30, vSaldoHasta60, vSaldoDespues60;
    RETURN (vSaldoHasta30 * 2) + (vSaldoHasta60 * 1.5) + vSaldoDespues60;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionPagadaPedido`(`pidPedido` INT, `pidUsuarioConsulta` INT) RETURNS int(11)
    NO SQL
BEGIN
DECLARE vIdPromotor integer;
DECLARE vIdUsuarioCaptura integer;
DECLARE vMiCliente integer;
DECLARE vIdCorteComision integer;
DECLARE vIdCorteVendedor integer;
DECLARE vComisionPagada integer;

SELECT  pedido.id_usuario_capturado, getDueñoClientePedido(idCliente), pedido.idCorteComision, pedido.idCorteComisionVendedor  INTO vIdUsuarioCaptura, vIdPromotor, vIdCorteComision, vIdCorteVendedor FROM pedido where idPedido = pidPedido;

   IF pidUsuarioConsulta = vIdPromotor  THEN
      set vMiCliente = 1; 
   ELSE 
      set vMiCliente = 0;
   END IF;
   IF vMiCliente = 1 and vIdCorteComision > 0 THEN
        	SET vComisionPagada = 1;
    	    RETURN vComisionPagada;
        
   ELSEIF vMiCliente = 0 and vIdCorteVendedor > 0 THEN  
	        SET vComisionPagada = 1;
    	    RETURN vComisionPagada;
   ELSE          
            SET vComisionPagada = 0;
    	    RETURN vComisionPagada;

   END IF;
   
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionesPedido`(`pIdPedido` INTEGER) RETURNS decimal(9,2)
BEGIN
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
	select porDescuento into vPorDescuento  
      from pedido 
     where idpedido = pIdPedido;
    select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
    from pedidodetalle where idpedido = pIdPedido;
    SET vComisiones =vComisiones-(vComisiones*vPorDescuento/100);
	RETURN vComisiones;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionesPedidoUsuario`(`pIdPedido` INT, `pIdUsuario` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vTEXTO VARCHAR(200);
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
    DECLARE vComisionOtroCargo DECIMAL(9,2);
    DECLARE vComisionesRentas DECIMAL(9,2);
    DECLARE vUsuarioCapturado INTEGER;
    DECLARE vPromotor INTEGER;
    DECLARE vIdCliente INTEGER;
    DECLARE vPromotorAnterior INTEGER;
    DECLARE vDividirEntre2 INTEGER;
    SET vTEXTO = '';
    -- set vPromotorAnterior = 9;
    SET vDividirEntre2 = 0;
    set vComisionOtroCargo = 0;
    set vComisionesRentas = 0;
    select ifnull((sum(monto)), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    /*
    select ifnull(sum(monto), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    */
	select pedido.porDescuento, pedido.id_usuario_capturado,  cliente.idusuariopromotor, pedido.idCliente, cliente.idusuariopromotor
           into vPorDescuento, vUsuarioCapturado,  vPromotor, vIdCliente, vPromotorAnterior
      from pedido 
      inner join cliente on cliente.idcliente = pedido.idcliente      
     where pedido.idpedido =  pIdPedido;
    SET vTEXTO = concat(vTEXTO,' Usuario = ', pidUsuario, ' - ');
    SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
	SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
    SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
    IF pIdPedido <= 1847 THEN
		IF pIdUsuario = 18 /*Estela*/ OR
           pIdUsuario = 11 /*Saul*/ OR
           pIdUsuario = 21 /*Saida*/ OR
           pIdUsuario = 36 /*Raul*/     THEN
				IF pIdPedido > 1513 THEN
					/* Comisiones Estela */ 
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'
                        where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 1 => Comisiones mostrador, pedido <= 1847 y > 1513');
                ELSE
					SET vComisiones = 0;
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 2 => Comisiones mostrador comisiones cero, pedido <= 1847 y < 1513');
                END IF;          
        ELSE
			IF pIdUsuario = vPromotor OR (pIdUsuario = 10 AND vPromotor = 18 AND pIdPedido <= 1513)  THEN
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
                   /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'*/
                    where idpedido = pIdPedido;
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 3 => Comisiones NO mostrador, pedido <= 1847 y > 1513');
			ELSE
				SET vComisiones = 0;
                SET vTEXTO = CONCAT(vTEXTO, '-> CASO 4 => Comisiones NO mostrador comisiones cero, pedido <= 1847 y < 1513');
			END IF;
		END IF;
	ELSE /* TODO EL PROCESO ES PRACTICAMENTE AQUI */
		/* 
			pIdUsuario        = el usuario al que se le desea Calcular la Comisión del pIdPedido
            vUsuarioCapturado = usuario que captura el pedido
            vPromotor         = dueño del cliente
        */
		IF vUsuarioCapturado = pIdUsuario OR vPromotor = pIdUsuario OR pIdUsuario = vPromotorAnterior /* para calculo de Miguel */ THEN
			/* Si el usuario que se consulta capturó el pedido o es el promotor del cliente */
			IF vUsuarioCapturado = vPromotor /*AND vPromotorAnterior <> 9 */ THEN   /* Si quien captura el pedido, es e mismo dueño del cliente */
				IF pIdUsuario = 18 /*Estela*/ OR
			  	   pIdUsuario = 11 /*Saul*/ OR
                   pIdUsuario = 21 /*Saida*/ OR
                   pIdUsuario = 36 /*Raul*/ THEN
					/* Comisiones Estela, Saul, Saida y Lety */ 
					IF pIdUsuario = 18 /*Estela*/ THEN
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', comision, 0.65)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
						where idpedido = pIdPedido;
											
                    	SET vTEXTO = CONCAT(vTEXTO, '-> CASO 5.5 => /*Estela*/ el que captura es el promotor y son de mostrador, se da el 0.65 de comision');
					ELSE /*Los demas*/
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', comision, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
						where idpedido = pIdPedido;
                    
					
                    	SET vTEXTO = CONCAT(vTEXTO, '-> CASO 5 => el que captura es el promotor y son de mostrador, se da el 0.5 de comision');
					END IF;
					SET vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE					
					IF (vPromotor = 18 /*Estela*/ OR
					   vPromotor = 11 /*Saul*/ OR
					   vPromotor = 21 /*Saida*/ OR
					   vPromotor = 36 /*Raul*/)
						AND vPromotorAnterior = 9 
                        AND pIdUsuario = 9 THEN
                        /* el promotor es un mostrador, pero era de Miguel, entonces */
						
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, (comision - .5))   / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 13 => vendedor = promotor, NO mostrador, usuario = Miguel, comision - 0.5 ');
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                    ELSE
						/* el que capturó el pedido es el promotor tambien del cliente, se da toda la comisión */ 
						select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
						where idpedido = pIdPedido;
						set vComisionesRentas = vComisionOtroCargo * (2/100); 
						SET vTEXTO = CONCAT(vTEXTO, '-> CASO 6 => el que captura es el promotor y NO son de mostrador, comision completa');
						SET vDividirEntre2 = 1;						
                    END IF;
				END IF;
			ELSE /* Si quien captura el pedido no es el dueño del cliente */
				IF vUsuarioCapturado = pIdUsuario THEN /* quien captura el pedido, es al que se le esta calculando la comisión */
					 /* quien captura pedido saida, promotor es Estela solo sera .2 para saida % */
                    IF pIdUsuario = 21 AND vPromotor = 18 THEN
                        select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 0.2, 0.2)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                    ELSE    /* quien captura pedido, no es promotor solo el .5 % */
					select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                        /* pero si son clientes de 0.5% de Yoana, solo el 0.25 */
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 7 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision');
					 END IF; 
                    IF vIdCliente = 352 OR vIdCliente = 499 THEN
						/* Para Estela de estos clientes es el 0.5, para los demas el 0.25 */
						IF pIdUsuario = 18 /*Estela*/ OR
                           pIdUsuario = 11 /*Saul*/ OR
                           pIdUsuario = 21 /*Saida*/ OR
                           pIdUsuario = 36 /*Raul*/ THEN

							IF pIdUsuario = 18 /*Estela*/ THEN
								/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones  */
								select ifnull(sum(cast(total * ( 0.65  / 100) as DECIMAL(10,2))),0) into vComisiones  
								from pedidodetalle 
								/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
								where idpedido = pIdPedido;
								SET vTEXTO = CONCAT(vTEXTO, '-> CASO 8.8 => /*Estela*/ vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
							ELSE
								/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones  */
								select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
								from pedidodetalle 
								/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
								where idpedido = pIdPedido;
								SET vTEXTO = CONCAT(vTEXTO, '-> CASO 8 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
							END IF;
						ELSE
                            /* tambien para el otro promotor es el 0.5 20191029*/
							select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
							from pedidodetalle 
							/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
							where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 9 => vendedor <> promotor, NO mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
						END IF;
					END IF;
					SET vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE /* se esta calculando la comisión a un dueño del cliente, y éste no capturó el pedido */
					IF pIdUsuario = 18 /*Estela*/ OR
                       pIdUsuario = 11 /*Saul*/ OR
                       pIdUsuario = 21 /*Saida*/ OR
                       pIdUsuario = 36 /*Raul*/ THEN
						/* Comisiones Estela, Saul, Saida, Lety */ 

						IF pIdUsuario = 18 /*Estela*/ THEN
							select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.65)  / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
							INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
							where idpedido = pIdPedido;
							
							SET vTEXTO = CONCAT(vTEXTO, '-> CASO 10.10 => /*Estela*/ vendedor <> promotor, usuario=promotor, mostrador, se da el 0.5 de comision');
						ELSE
							select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
							INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
							where idpedido = pIdPedido;
							
							SET vTEXTO = CONCAT(vTEXTO, '-> CASO 10 => vendedor <> promotor, usuario=promotor, mostrador, se da el 0.5 de comision');
						END IF;
                        
						SET vComisionesRentas = vComisionOtroCargo * (0.5/100); 
                        
					ELSE
						/* vPromotor = pIdUsuario el usuario que solicita comision es el promotor*/
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, IF(comision <= .5, comision,(comision - .5) ) )  / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 11 => vendedor <> promotor, usuario = promotor, comision - 0.5 , NO mostrador');
						IF vIdCliente = 352 OR vIdCliente = 499 THEN
							/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5) / 100) as DECIMAL(10,2))),0) into vComisiones  */
                            /* select ifnull(sum(cast(total * ( 0.25 / 100) as DECIMAL(10,2))),0) into vComisiones */ /* si alguien mas vende a este cliente Yohana pierde su comision 20191029*/
                            select ifnull(sum(cast(total * ( 0 / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
                            /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
                            where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 12 => vendedor <> promotor, usuario = promotor, NO mostrador, no hay comision, clientes 352 y 499');
						END IF;
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                        SET vDividirEntre2 = 1;
					END IF;
				END IF;
			END IF;
		 ELSE
			SET vComisiones = 0;
		 END IF;
    END IF;
    SET vComisiones = vComisiones + vComisionesRentas;
    SET vComisiones = vComisiones-(vComisiones*vPorDescuento/100);
   IF pIdPedido > 11194  THEN
		IF vDividirEntre2 = 1 AND vPromotorAnterior = 9 THEN
			SET vComisiones = vComisiones / 2;
            SET vTEXTO = CONCAT(vTEXTO, '-> DIVIDE ENTRE 2');
		END IF;
	ELSE
		IF vPromotorAnterior = 9 THEN
			IF pidUsuario = 9 AND vUsuarioCapturado = 9 THEN        
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
				from pedidodetalle 
				INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
				where idpedido = pIdPedido;
				set vComisionesRentas = vComisionOtroCargo * (2/100); 
				SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
				SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
				SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
				SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 14 => el que captura es el promotor y fue MIGUEL exepcion pedido 11194, comision completa');
			ELSE
				IF pidUsuario <> 9 AND vUsuarioCapturado <> 9 THEN        
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
					INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
					where idpedido = pIdPedido;
					set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
					SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
					SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
					SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
					SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
					SET vTEXTO = CONCAT(vTEXTO, '-> CASO 16 => el que captura es el promotor y fue MIGUEL exepcion pedido 11194, comision completa');
				ELSE
					SET vComisiones = 0;
					SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
					SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
					SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
					SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
					SET vTEXTO = CONCAT(vTEXTO, '-> CASO 15 => Interceptado, Pedido era de Miguel antes del 11194');
				END IF;
			END IF;
        END IF;
    END IF;
    if pIdPedido = 4132 then
		SET vComisiones = 9597.29;
	end if;
    RETURN vComisiones; 
    -- return concat(vComisiones, ': ', vTEXTO) ;
	
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionesPedidoUsuario2`(`pIdPedido` INT, `pIdUsuario` INT) RETURNS decimal(9,2)
BEGIN
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
    DECLARE vComisionOtroCargo DECIMAL(9,2);
    DECLARE vComisionesRentas DECIMAL(9,2);
    DECLARE vUsuarioCapturado INTEGER;
    DECLARE vPromotor INTEGER;
    select ifnull(monto, 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo >1;
    set vComisionOtroCargo = 0;
    set vComisionesRentas = 0;
	select pedido.porDescuento, pedido.id_usuario_capturado,  cliente.idusuariopromotor  into vPorDescuento, vUsuarioCapturado,  vPromotor
      from pedido 
      inner join cliente on cliente.idcliente = pedido.idcliente      
     where pedido.idpedido =  pIdPedido;
	IF pIdPedido <= 1847 THEN
		IF pIdUsuario = 18 THEN
				IF pIdPedido > 1513 THEN
					/* Comisiones Estela */ 
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle where idpedido = pIdPedido;
                ELSE
					SET vComisiones = 0;
                END IF;          
        ELSE
			IF pIdUsuario = vPromotor OR (pIdUsuario = 10 AND vPromotor = 18)  THEN
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle where idpedido = pIdPedido;
			ELSE
				SET vComisiones = 0;
			END IF;
		END IF;
	ELSE
		IF vUsuarioCapturado = pIdUsuario OR vPromotor = pIdUsuario  THEN
			/* Si el usuario que se consulta capturó el pedido o es el promotor del cliente */
			IF vUsuarioCapturado = vPromotor  THEN
				IF pIdUsuario = 18 THEN
					/* Comisiones Estela */ 
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle where idpedido = pIdPedido;
                    set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE
					/* el que capturó el pedido es el promotor tambien del cliente, se da toda la comisión */ 
					select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle where idpedido = pIdPedido;
                    set vComisionesRentas = vComisionOtroCargo * (2/100); 
				END IF;
			ELSE
				IF vUsuarioCapturado = pIdUsuario THEN
					/* quien captura pedido, no es promotor solo el .5 % */
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle where idpedido = pIdPedido;
					set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE
					IF pIdUsuario = 18 THEN
						/* Comisiones Estela */ 
						select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle where idpedido = pIdPedido;
                        set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
					ELSE
						/* vPromotor = pIdUsuario el usuario que solicita comision es el promotor*/
						select ifnull(sum(cast(total * ((comision - .5) / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle where idpedido = pIdPedido;
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
					END IF;
				END IF;
			END IF;
		 ELSE
			SET vComisiones = 0;
		 END IF;
    END IF;
    SET vComisiones = vComisiones + vComisionesRentas;
    SET vComisiones = vComisiones-(vComisiones*vPorDescuento/100);
	RETURN vComisiones;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionesPedidoUsuarioRoofing`(`pIdPedido` INT, `pIdUsuario` INT) RETURNS decimal(9,2)
BEGIN
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
    DECLARE vUsuarioCapturado INTEGER;
    DECLARE vPromotor INTEGER;
    DECLARE vIdCliente INTEGER;
    /*
    select ifnull(sum(monto), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    */
	select pedido.porDescuento, pedido.id_usuario_capturado,  cliente.idusuariopromotor, pedido.idCliente  
    into vPorDescuento, vUsuarioCapturado,  vPromotor, vIdCliente
      from pedido 
      inner join cliente on cliente.idcliente = pedido.idcliente      
     where pedido.idpedido =  pIdPedido;
		IF vUsuarioCapturado = pIdUsuario OR vPromotor = pIdUsuario  THEN
			/* Si el usuario que se consulta capturó el pedido o es el promotor del cliente */
			IF vUsuarioCapturado = vPromotor  THEN
					/* Comisiones Roofing 2% */ 
					select ifnull(sum(cast(total * (2 / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
					INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'SI'
					where idpedido = pIdPedido;
			ELSE
				IF vUsuarioCapturado = pIdUsuario THEN
					/* quien captura pedido, no es promotor solo el 2.5 % */
					select ifnull(sum(cast(total * (1 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'SI'
						where idpedido = pIdPedido;
				ELSE
						/* vPromotor = pIdUsuario el usuario que solicita comision es el promotor*/
						select ifnull(sum(cast(total * (1 / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
							INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'SI'
							where idpedido = pIdPedido;
				END IF;
			END IF;
		 ELSE
			SET vComisiones = 0;
		 END IF;
    SET vComisiones = vComisiones-(vComisiones*vPorDescuento/100);
	RETURN vComisiones;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getComisionesPedidoUsuarioTexto`(`pIdPedido` INT, `pIdUsuario` INT) RETURNS varchar(2000) CHARSET utf8
BEGIN
	DECLARE vTEXTO VARCHAR(200);
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
    DECLARE vComisionOtroCargo DECIMAL(9,2);
    DECLARE vComisionesRentas DECIMAL(9,2);
    DECLARE vUsuarioCapturado INTEGER;
    DECLARE vPromotor INTEGER;
    DECLARE vIdCliente INTEGER;
    DECLARE vPromotorAnterior INTEGER;
    DECLARE vDividirEntre2 INTEGER;
    SET vTEXTO = '';
    -- set vPromotorAnterior = 9;
    SET vDividirEntre2 = 0;
    set vComisionOtroCargo = 0;
    set vComisionesRentas = 0;
    select ifnull((sum(monto)), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    /*
    select ifnull(sum(monto), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    */
	select pedido.porDescuento, pedido.id_usuario_capturado,  cliente.idusuariopromotor, pedido.idCliente, cliente.idusuariopromotor
           into vPorDescuento, vUsuarioCapturado,  vPromotor, vIdCliente, vPromotorAnterior
      from pedido 
      inner join cliente on cliente.idcliente = pedido.idcliente      
     where pedido.idpedido =  pIdPedido;
    SET vTEXTO = concat(vTEXTO,' Usuario = ', pidUsuario, ' - ');
    SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
	SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
    SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
    IF pIdPedido <= 1847 THEN
		IF pIdUsuario = 18 /*Estela*/ OR
           pIdUsuario = 11 /*Saul*/ OR
           pIdUsuario = 21 /*Saida*/ OR
           pIdUsuario = 32 /*Lety*/     THEN
				IF pIdPedido > 1513 THEN
					/* Comisiones Estela */ 
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'
                        where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 1 => Comisiones mostrador, pedido <= 1847 y > 1513');
                ELSE
					SET vComisiones = 0;
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 2 => Comisiones mostrador comisiones cero, pedido <= 1847 y < 1513');
                END IF;          
        ELSE
			IF pIdUsuario = vPromotor OR (pIdUsuario = 10 AND vPromotor = 18 AND pIdPedido <= 1513)  THEN
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
                   /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'*/
                    where idpedido = pIdPedido;
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 3 => Comisiones NO mostrador, pedido <= 1847 y > 1513');
			ELSE
				SET vComisiones = 0;
                SET vTEXTO = CONCAT(vTEXTO, '-> CASO 4 => Comisiones NO mostrador comisiones cero, pedido <= 1847 y < 1513');
			END IF;
		END IF;
	ELSE /* TODO EL PROCESO ES PRACTICAMENTE AQUI */
		/* 
			pIdUsuario        = el usuario al que se le desea Calcular la Comisión del pIdPedido
            vUsuarioCapturado = usuario que captura el pedido
            vPromotor         = dueño del cliente
        */
		IF vUsuarioCapturado = pIdUsuario OR vPromotor = pIdUsuario OR pIdUsuario = vPromotorAnterior /* para calculo de Miguel */ THEN
			/* Si el usuario que se consulta capturó el pedido o es el promotor del cliente */
			IF vUsuarioCapturado = vPromotor /*AND vPromotorAnterior <> 9 */ THEN   /* Si quien captura el pedido, es e mismo dueño del cliente */
				IF pIdUsuario = 18 /*Estela*/ OR
			  	   pIdUsuario = 11 /*Saul*/ OR
                   pIdUsuario = 21 /*Saida*/ OR
                   pIdUsuario = 32 /*Lety*/ THEN
					/* Comisiones Estela, Saul, Saida y Lety */ 
					select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', comision, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
                    INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                    where idpedido = pIdPedido;
                    set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 5 => el que captura es el promotor y son de mostrador, se da el 0.5 de comision');
				ELSE					
					IF (vPromotor = 18 /*Estela*/ OR
					   vPromotor = 11 /*Saul*/ OR
					   vPromotor = 21 /*Saida*/ OR
					   vPromotor = 32 /*Lety*/)
						AND vPromotorAnterior = 9 
                        AND pIdUsuario = 9 THEN
                        /* el promotor es un mostrador, pero era de Miguel, entonces */
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, (comision - .5))   / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 13 => vendedor = promotor, NO mostrador, usuario = Miguel, comision - 0.5 ');
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                    ELSE
						/* el que capturó el pedido es el promotor tambien del cliente, se da toda la comisión */ 
						select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
						where idpedido = pIdPedido;
						set vComisionesRentas = vComisionOtroCargo * (2/100); 
						SET vTEXTO = CONCAT(vTEXTO, '-> CASO 6 => el que captura es el promotor y NO son de mostrador, comision completa');
						SET vDividirEntre2 = 1;						
                    END IF;
				END IF;
			ELSE /* Si quien captura el pedido no es el dueño del cliente */
				IF vUsuarioCapturado = pIdUsuario THEN /* quien captura el pedido, es al que se le esta calculando la comisión */
					/* quien captura pedido, no es promotor solo el .5 % */
					select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                        /* pero si son clientes de 0.5% de Yoana, solo el 0.25 */
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 7 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision');
					IF vIdCliente = 352 OR vIdCliente = 499 THEN
						/* Para Estela de estos clientes es el 0.5, para los demas el 0.25 */
						IF pIdUsuario = 18 /*Estela*/ OR
                           pIdUsuario = 11 /*Saul*/ OR
                           pIdUsuario = 21 /*Saida*/ OR
                           pIdUsuario = 32 /*Lety*/ THEN
		 					/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones  */
                            select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
							from pedidodetalle 
							/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
							where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 8 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
						ELSE
                            /* tambien para el otro promotor es el 0.5 20191029*/
							select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
							from pedidodetalle 
							/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
							where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 9 => vendedor <> promotor, NO mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
						END IF;
					END IF;
					set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE /* se esta calculando la comisión a un dueño del cliente, y éste no capturó el pedido */
					IF pIdUsuario = 18 /*Estela*/ OR
                       pIdUsuario = 11 /*Saul*/ OR
                       pIdUsuario = 21 /*Saida*/ OR
                       pIdUsuario = 32 /*Lety*/ THEN
						/* Comisiones Estela, Saul, Saida, Lety */ 
						select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                        set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 10 => vendedor <> promotor, usuario=promotor, mostrador, se da el 0.5 de comision');
					ELSE
						/* vPromotor = pIdUsuario el usuario que solicita comision es el promotor*/
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, if(comision = .5 ,comision,(comision - .5)))    / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 11 => vendedor <> promotor, usuario = promotor, comision - 0.5 , NO mostrador');
						IF vIdCliente = 352 OR vIdCliente = 499 THEN
							/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5) / 100) as DECIMAL(10,2))),0) into vComisiones  */
                            /* select ifnull(sum(cast(total * ( 0.25 / 100) as DECIMAL(10,2))),0) into vComisiones */ /* si alguien mas vende a este cliente Yohana pierde su comision 20191029*/
                            select ifnull(sum(cast(total * ( 0 / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
                            /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
                            where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 12 => vendedor <> promotor, usuario = promotor, NO mostrador, no hay comision, clientes 352 y 499');
						END IF;
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                        SET vDividirEntre2 = 1;
					END IF;
				END IF;
			END IF;
		 ELSE
			SET vComisiones = 0;
		 END IF;
    END IF;
    SET vComisiones = vComisiones + vComisionesRentas;
    SET vComisiones = vComisiones-(vComisiones*vPorDescuento/100);
   IF pIdPedido > 11194  THEN
		IF vDividirEntre2 = 1 AND vPromotorAnterior = 9 THEN
			SET vComisiones = vComisiones / 2;
            SET vTEXTO = CONCAT(vTEXTO, '-> DIVIDE ENTRE 2');
		END IF;
	ELSE
		IF vPromotorAnterior = 9 THEN
			IF pidUsuario = 9 AND vUsuarioCapturado = 9 THEN        
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
				from pedidodetalle 
				INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
				where idpedido = pIdPedido;
				set vComisionesRentas = vComisionOtroCargo * (2/100); 
				SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
				SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
				SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
				SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 14 => el que captura es el promotor y fue MIGUEL exepcion pedido 11194, comision completa');
			ELSE
                SET vComisiones = 0;
				SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
				SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
				SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
				SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 15 => Interceptado, Pedido era de Miguel antes del 11194');
			END IF;
        END IF;
    END IF;
    if pIdPedido = 4132 then
		SET vComisiones = 9597.29;
	end if;
    -- RETURN vComisiones; 
    return concat(vComisiones, ': ', vTEXTO) ;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCreditoUsadoCliente`(`pIdCliente` INTEGER) RETURNS decimal(15,2)
BEGIN
	 /* Obteiene la suma de los saldos del cliente, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(15,2);
    SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
	  FROM pedido 
	 WHERE idcliente = pIdCliente;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCreditoUsadoClienteDatoFacturacion`(`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
BEGIN
	/* Obteiene la suma de los saldos del cliente, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(15,2);
    DECLARE vPrivado VARCHAR(2);

    SET vSaldo = 0;
    SET vPrivado = 'SI';
    
	IF pIdClienteDatosFacturacion > 0 THEN    
		SELECT datosfacturacion.privado INTO vPrivado
		FROM clientedatosfacturacion
		INNER JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion;
   END IF;
   
   IF vPrivado = 'SI' THEN
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
		FROM pedido 
		LEFT JOIN clientedatosfacturacion ON pedido.idClienteDatosFacturacion = clientedatosfacturacion.idClienteDatosFacturacion
		LEFT JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE pedido.idCliente = pIdCliente
		 AND IFNULL( datosfacturacion.privado, 'SI') = 'SI';
    ELSE
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
		  FROM pedido 
		 WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion;
	END IF;
          
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCreditoUsadoClienteDatoFacturacionEntregados`(`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
BEGIN
	/* Obteiene la suma de los saldos del cliente, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(15,2);
    DECLARE vPrivado VARCHAR(2);
    
    SET vSaldo = 0;
    SET vPrivado = 'SI';
    
	IF pIdClienteDatosFacturacion > 0 THEN    
		SELECT datosfacturacion.privado INTO vPrivado
		FROM clientedatosfacturacion
		INNER JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion;
   END IF;
   
   IF vPrivado = 'SI' THEN
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
		FROM pedido 
		LEFT JOIN clientedatosfacturacion ON pedido.idClienteDatosFacturacion = clientedatosfacturacion.idClienteDatosFacturacion
		LEFT JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE pedido.idCliente = pIdCliente
		 AND pedido.estado = 'ENTREGADO'         
		 AND IFNULL( datosfacturacion.privado, 'SI') = 'SI';
   ELSE
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
		  FROM pedido 
		 WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion
		   AND estado = 'ENTREGADO';
   END IF;
   
	RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCreditoUsadoPromotor`(`pIdUsuario` INTEGER) RETURNS decimal(9,2)
BEGIN
	 /* Obteiene la suma de los saldos del Promotor, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(9,2);
	SELECT IFNULL(SUM(saldopromotor), 0) INTO vSaldo
	  FROM pedido as p
	 INNER JOIN cliente as c
        ON c.idCliente = p.idCliente
	 INNER JOIN usuario as u
	    ON u.idUsuario = c.idUsuarioPromotor
	 WHERE u.idUsuario = pIdUsuario;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCurrentListaPrecio`() RETURNS int(11)
BEGIN
	DECLARE vidListaPrecio INTEGER;
    set vidListaPrecio = -999;
    select IFNULL(idListaPrecio,-999) into vidListaPrecio
		from listaprecio
		where estado = 'ACTUAL';
	RETURN vidListaPrecio;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCurrentTimeStamp`() RETURNS datetime
BEGIN
/*RETURN (CURRENT_TIMESTAMP + INTERVAL 2 HOUR); */
RETURN (CURRENT_TIMESTAMP);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getCurrentTomaInventario`() RETURNS int(11)
BEGIN
	DECLARE vidToma INTEGER;
    set vidToma = -999;
    select IFNULL(idTomaInventario,-999) into vidToma
		from tomainventario
		where estado = 'ACTIVO';
	RETURN vidToma;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getDiasPagoVencido`(`pidCliente` INT) RETURNS int(5)
    NO SQL
BEGIN

DECLARE vDiasPagoVencido INT(5);


SELECT if(estado = 'ENTREGADO' AND saldo > 0 ,datediff(CURRENT_DATE(),fecha_entregado) , 0) INTO vDiasPagoVencido FROM `pedido` where idCliente = pidCliente ORDER BY `if(estado = 'ENTREGADO' AND saldo > 0 ,datediff(CURRENT_DATE(),fecha_entregado) , 0)` DESC LIMIT 1;


RETURN vDiasPagoVencido;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getDiasPagoVencidoPedido`(`pidPedido` INT) RETURNS int(11)
    NO SQL
BEGIN

DECLARE vDiasPagoVencidoPedido INT(5);


SELECT  if(estado = 'ENTREGADO' AND saldo > 0 ,datediff(CURRENT_DATE(),fecha_entregado) , 0) INTO vDiasPagoVencidoPedido  FROM `pedido` where idPedido = pidPedido
 ;

RETURN vDiasPagoVencidoPedido;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getDisponibleCreditoCliente`(`pIdCliente` INTEGER) RETURNS decimal(9,2)
BEGIN
	 /* Obtiene el disponible del crédito del cliente */
    DECLARE vDisponible DECIMAL(9,2);
    SELECT IFNULL(IF(idcliente = 1, 0, (credito - usado)), 0) INTO vDisponible
	  FROM cliente 
	 WHERE idcliente = pIdCliente;
    RETURN vDisponible;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getDueñoClientePedido`(`pidCliente` INT) RETURNS int(11)
    NO SQL
BEGIN
DECLARE vIdPromotor integer;

SELECT  idUsuarioPromotor  INTO vIdPromotor FROM cliente where idCliente = pidCliente;
RETURN vIdPromotor;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getExistenciaProductoSucursal`(`pIdProducto` INT, `pIdSucursal` INT) RETURNS decimal(15,2)
    NO SQL
BEGIN
DECLARE vProductoExistencia DECIMAL(15,2);
SELECT existencia INTO vProductoExistencia 
FROM `inventariosucursal` 
where  idproducto = pIdProducto
   and idSucursal = pIdSucursal;
RETURN vProductoExistencia;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getExistenciasRollo`(`pIdRollo` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vExistencia DECIMAL(15,2);
    set vExistencia = 0;
    select ifnull(sum(if(existencia > 0, existencia, 0)),0) into vExistencia
			from remisionrollo
			where remisionrollo_rollo_idrollo = pIdRollo
            and estado <> 'BAJA' and estado <> 'TERMINADO'
			;
	RETURN vExistencia;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getExistenciasRolloSucursal`(`pIdSucursal` INTEGER, `pIdRollo` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vExistencia DECIMAL(15,2);
    set vExistencia = 0;
    IF pIdSucursal = 1 THEN
		select sum(existencia) into vExistencia
			from remisionrollo
			where almacen NOT IN ('DELTA', 'LAGOS')
            and remisionrollo_rollo_idrollo = pIdRollo;
    ELSE 
		IF pIdSucursal = 2 THEN
			select sum(existencia) into vExistencia
				from remisionrollo
				where almacen = 'DELTA'
				and remisionrollo_rollo_idrollo = pIdRollo;
		ELSE
			select sum(existencia) into vExistencia
				from remisionrollo
				where almacen = 'LAGOS'
				and remisionrollo_rollo_idrollo = pIdRollo;
        END IF;
    END IF;
    RETURN vExistencia;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getFechaParaPagoComision`(`pIdPedido` INT) RETURNS datetime
    NO SQL
BEGIN

DECLARE vFechaSaldado DATETIME;
DECLARE vFechaEntregado DATETIME;
DECLARE vUltimaFecha DATETIME;

SELECT pedido.fecha_entregado, pedido.fecha_saldada INTO vFechaSaldado, vFechaEntregado FROM pedido WHERE idPedido = pIdPedido; 

	if vFechaSaldado > vFechaEntregado THEN
		SET vUltimaFecha = vFechaSaldado;
	ELSE
		SET vUltimaFecha = vFechaEntregado;
	END IF;
RETURN vUltimaFecha;

END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getFechaUltimaCompraCliente`(`pIdCliente` INT) RETURNS int(11)
    NO SQL
BEGIN
	DECLARE vFechaUltimaCompra DATE;
   SELECT fecha_capturado FROM `pedido` where idCliente= pIdCliente ORDER BY 		`pedido`.`fecha_capturado` DESC LIMIT 1 
 into vFechaUltimaCompra;
  
	RETURN vFechaUltimaCompra;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
	SELECT ifnull(SUM(rr.kilos * vr.pesocu),0) INTO vCosto
	FROM remisionrollo rr
	inner join viewrollos vr on rr.remisionRollo_rollo_idrollo = vr.idrollo
	WHERE  date_format(rr.fecha, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin
	AND rr.estado <> 'BAJA';
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexHasta`(`pfecha` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
	SELECT ifnull(SUM(rr.kilos * vr.pesocu),0) INTO vCosto
	FROM remisionrollo rr
	inner join viewrollos vr on rr.remisionRollo_rollo_idrollo = vr.idrollo
	WHERE date_format(rr.fecha, '%Y-%m-%d') < pfecha
	AND rr.estado <> 'BAJA';
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexKilosEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vKilos DECIMAL(15,2);
	SET vKilos = 0.0;
	SELECT ifnull(SUM(kilos),0) INTO vKilos
	FROM remisionrollo
	WHERE 
	date_format(fecha, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin
	AND estado <> 'BAJA';
    RETURN vKilos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexKilosHasta`(`pfecha` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vKilos DECIMAL(15,2);
	SET vKilos = 0.0;
	SELECT ifnull(SUM(kilos),0) INTO vKilos
	FROM remisionrollo
	WHERE date_format(fecha, '%Y-%m-%d') < pfecha
	AND estado <> 'BAJA';
    RETURN vKilos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexSalidaEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
    select ifnull(SUM(ir.cantidad * vr.pesocu),0) INTO vCosto
	from invzmovrollo ir
	inner join remisionrollo rr on ir.idRemisionRollo = rr.idRemisionRollo
	inner join viewrollos vr on rr.remisionRollo_rollo_idrollo = vr.idrollo
	WHERE  ir.movimiento = 'SALIDA'
	AND rr.estado <> 'BAJA'
	AND date_format(ir.fecha_movimiento, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin;
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioGalvamexSalidaKilosEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vKilos DECIMAL(15,2);
	SET vKilos = 0.0;
    select ifnull(SUM(ir.cantidad),0) INTO vKilos
	from invzmovrollo ir
	inner join remisionrollo rr on ir.idRemisionRollo = rr.idRemisionRollo
	inner join viewrollos vr on rr.remisionRollo_rollo_idrollo = vr.idrollo
	WHERE ir.movimiento = 'SALIDA'
	AND rr.estado <> 'BAJA'
	AND date_format(ir.fecha_movimiento, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin;
    RETURN vKilos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioInicialMendez`() RETURNS decimal(15,2)
BEGIN

	DECLARE vCosto DECIMAL(15,2);

    SELECT SUM(monto) INTO vCosto FROM `aportacionesmendez`;

    

	#SET vCosto = 10145174 + 1080545.22+788536.68+1004191.24+1100088.20+601151.28;

    RETURN vCosto;

END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioMendez`() RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
	SELECT ifnull(SUM(kilos * costokg),0) INTO vCosto
	FROM remisionrollo
	WHERE comprador = 'MENDEZ'
	AND date_format(fecha, '%Y-%m-%d') Between '2019-01-01' and '2019-06-30'
	AND estado <> 'BAJA';
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioMendezEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
	SELECT ifnull(SUM(kilos * costokg),0) INTO vCosto
	FROM remisionrollo
	WHERE comprador = 'MENDEZ'
	AND date_format(fecha, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin
	AND estado <> 'BAJA';
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioMendezHasta`(`pfecha` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	SET vCosto = 0.0;
	SELECT ifnull(SUM(kilos * costokg),0) INTO vCosto
	FROM remisionrollo
	WHERE comprador = 'MENDEZ'
	AND date_format(fecha, '%Y-%m-%d') >= '2019-01-01'    
    AND date_format(fecha, '%Y-%m-%d') < pfecha
	AND estado <> 'BAJA';
	SET vCosto = vCosto * 1.16;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioStockEntradasGalvamexEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vEntradas DECIMAL(15,2);
	SET vEntradas = 0.0;
	select ifnull(sum(i.cantidad * p.costo), 0) into vEntradas 
	from invzmov i
	inner join producto p on i.idproducto = p.idproducto
	where i.movimiento = 'ENTRADA' 
	and  date_format(i.fecha_movimiento, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin;
    RETURN vEntradas;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioStockGalvamexHasta`(`pfecha` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vCosto DECIMAL(15,2);
	DECLARE vEntradas DECIMAL(15,2);
	DECLARE vSalidas DECIMAL(15,2);
	SET vCosto = 0.0;
	select ifnull(sum(i.cantidad * p.costo), 0) into vEntradas 
	from invzmov i
	inner join producto p on i.idproducto = p.idproducto
	where i.movimiento = 'ENTRADA' and  date_format(i.fecha_movimiento, '%Y-%m-%d') < pfecha;
	select ifnull(sum(i.cantidad * p.costo), 0)  into vSalidas
	from invzmov i
	inner join producto p on i.idproducto = p.idproducto
	where i.movimiento = 'SALIDA' and  date_format(i.fecha_movimiento, '%Y-%m-%d') < pfecha;
	SET vCosto = vEntradas - vSalidas;
    RETURN vCosto;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getInventarioStockSalidasGalvamexEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSalidas DECIMAL(15,2);
	SET vSalidas = 0.0;
	select ifnull(sum(i.cantidad * p.costo), 0) into vSalidas
	from invzmov i
	inner join producto p on i.idproducto = p.idproducto
	where i.movimiento = 'SALIDA' 
	and  date_format(i.fecha_movimiento, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin;
    RETURN vSalidas;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getMaxKGPedido`(`pIdPedido` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vMaxKG DECIMAL(15,2);
	select SUM(partida * cantidadreal * viewrollos.pesoKiloML) INTO vMaxKG
		from pedidodetalle 
		inner join viewrollos on viewrollos.idrollo = pedidodetalle.idrollobase
		where idrollobase > 1
		and idpedido = pIdPedido;
    RETURN IFNULL(vMaxKG, 0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getMaxMLPedido`(`pIdPedido` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vMaxML DECIMAL(15,2);
	select MAX(cantidadreal) INTO vMaxML
		from pedidodetalle 		
		where idpedido = pIdPedido;
    RETURN IFNULL(vMaxML,0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getMaxMLRutaEnvioVehiculo`(`pIdRutaEnvioVehiculo` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vMaxML DECIMAL(15,2);
	select MAX(red.maxml) INTO vMaxML
		from rutaenviodetalle red        
		where red.idRutaEnvioVehiculo = pIdRutaEnvioVehiculo;
    RETURN IFNULL(vMaxML,0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getMaxMLValeSalida`(`pIdValeSalida` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vMaxML DECIMAL(15,2);
	select MAX(pd.cantidadreal) INTO vMaxML
		from valesalidadetalle vsd
        inner join pedidodetalle pd on vsd.idpedidodetalle = pd.idpedidodetalle
		inner join viewrollos vr on vr.idrollo = pd.idrollobase
		where pd.idrollobase > 1
		and vsd.idValeSalida = pIdValeSalida;
    RETURN IFNULL(vMaxML,0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoPedidosCliente`(`pIdCliente` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoPedidos INTEGER;
    select COUNT(*) into vNoPedidos 
    from pedido where idCliente = pIdCliente;
	RETURN vNoPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoPedidosClienteSinSaldar`(`pIdCliente` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoPedidos INTEGER;
    select COUNT(*) into vNoPedidos 
    from pedido 
	where idCliente = pIdCliente
	and saldada = 'NO'
	and estado NOT IN('CANCELADO', 'CAPTURADO');
	RETURN vNoPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoPedidosSinSaldarPromo`(`pIdCliente` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoPedidos INTEGER;
    select COUNT(*) into vNoPedidos 
    from pedido 
	where idCliente = pIdCliente
	and saldada = 'NO'
    and tipoAutorizacion = 'PROMO'
	and estado NOT IN('CANCELADO', 'CAPTURADO');
	RETURN vNoPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoRollosEnAlmacen`(`pIdRollo` INTEGER) RETURNS int(11)
BEGIN
		DECLARE vNoRollos INTEGER; 
	select count(idremisionrollo) into vNoRollos from remisionrollo where remisionRollo_rollo_idrollo = pIdRollo and estado IN ('ACTIVO'); 
	RETURN vNoRollos; 
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoRollosEnRegistroProduccion`(`pIdRollo` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoRollos INTEGER;
    select count(rr.idRemisionRollo) into vNoRollos
      from registroproduccion rp
     inner join remisionrollo rr
        on rr.idRemisionRollo = rp.idRemisionRollo
     where rr.remisionRollo_rollo_idrollo = pIdRollo
     and estado = 'PRODUCCION';
	RETURN vNoRollos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoRollosEnRegistroProduccionTerminados`(`pIdRollo` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoRollos INTEGER;
    select count(rr.idRemisionRollo) into vNoRollos
	from registroproduccion rp
	inner join remisionrollo rr
	on rr.idRemisionRollo = rp.idRemisionRollo
	where rr.remisionRollo_rollo_idrollo = pIdRollo
	and rp.terminado = 'SI';
	RETURN vNoRollos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNoRollosTotal`(`pIdRollo` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vNoRollos INTEGER;
    select count(idremisionrollo) into vNoRollos 
    from remisionrollo 
    where remisionRollo_rollo_idrollo = pIdRollo
    and estado IN ('ACTIVO', 'PRODUCCION');
	RETURN vNoRollos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getNumRenglonesPedido`(`pIdPedido` INT) RETURNS int(3)
    NO SQL
BEGIN
	DECLARE vNumRenglones INT (2);
	select COUNT(idPedidoDetalle) INTO vNumRenglones
		from pedidodetalle 
		where idpedido = pIdPedido;
    RETURN IFNULL(vNumRenglones, 0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getObjetivoAlcanzadoPromotorAnual`(`pIdPromotor` INT) RETURNS decimal(12,2)
    NO SQL
BEGIN DECLARE vObjetivoAlcanzado DECIMAL(12,2); SELECT sum(pedido.total) INTO vObjetivoAlcanzado FROM `pedido` INNER JOIN cliente as c ON c.idCliente = pedido.idCliente INNER JOIN usuario as u ON u.idUsuario = c.idUsuarioPromotor WHERE ((idUsuarioPromotor = pIdPromotor)or( pedido.id_usuario_capturado = pIdPromotor and pedido.idCliente= 1)) and date_format(fecha_saldada, "%Y") = YEAR(now()) and pedido.estado = 'ENTREGADO' ORDER BY `pedido`.`idPedido` ASC; RETURN vObjetivoAlcanzado ; END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getPedidoSucursalesAsignadas`(`pidPedido` INT) RETURNS varchar(2000) CHARSET utf8
BEGIN
	DECLARE vSucursales varchar(2000);
	SET vSucursales = '';
    select GROUP_CONCAT(distinct UPPER(sucursal.nombre)  SEPARATOR ', ') into vSucursales
	from pedidodetallecolocacion
	inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
	where idpedidodetalle in (select idpedidodetalle from pedidodetalle where idpedido = pidPedido)
	AND pedidodetallecolocacion.cantidad > 0;
    RETURN IFNULL(vSucursales, '');
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getPedidoValesSalida`(`pidPedido` INT) RETURNS varchar(2000) CHARSET utf8
BEGIN
	DECLARE vVales varchar(2000);
	SET vVales = '';
	select GROUP_CONCAT('<a target="_blank" href="valesalidagenerarsucursal/',idpedido,'" class="badge badge-primary"> ', idvalesalida, ' </a>' SEPARATOR ' &nbsp;') into vVales
	from valesalida
	where idpedido = pidPedido;
    RETURN IFNULL(vVales, '');
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getPedidosPendienteDePagoMas30Dias`(`pIdCliente` INTEGER) RETURNS int(11)
BEGIN
	DECLARE vPedidos INTEGER;
	SELECT COUNT(*) INTO vPedidos
	FROM pedido 
	WHERE saldo > 0
	  AND estado NOT IN ('CANCELADO', 'ENTREGADO')
	  AND idcliente = pIdCliente
	  AND DATE_FORMAT(fecha_capturado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') ;  
    RETURN vPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getProductoApartado`(`pIdProducto` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
	DECLARE vApartadoProductoMl DECIMAL(15,2);
    DECLARE vProductoUnidad INT(11);
    
    SELECT SUM(pd.partida) - SUM(pd.partidaDespachada), 
           SUM(pd.partida * pd.cantidad) - SUM(pd.partidaDespachada*pd.cantidad), 
           producto.producto_unidad_idUnidad  INTO  vApartado, vApartadoProductoML, vProductoUnidad
		from pedidodetalle pd
		inner join pedido p
		on p.idpedido = pd.idpedido AND p.apartarMercancia = 'SI'
		inner join producto
        on producto.idProducto = pd.idProducto 
		where p.estado in ( 'AUTORIZADO', 'PRODUCCION')
        and pd.IdPedido not in(18100, 21600, 25024)
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

DELIMITER $$
CREATE  FUNCTION `getProductoApartadoReal`(`pIdProducto` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vApartado DECIMAL(15,2);
        DECLARE vApartadoProductoMl DECIMAL(15,2);
        DECLARE vProductoUnidad INT(11);
    
    select sum(pd.partida)-SUM(pd.partidaDespachada), 
			sum(pd.partida * pd.cantidad)-sum(pd.partidaDespachada*pd.cantidad), 
            producto.producto_unidad_idUnidad  INTO  vApartado, vApartadoProductoML, vProductoUnidad
		from pedidodetalle pd
		inner join pedido p
		on p.idpedido = pd.idpedido AND p.apartarMercancia = 'SI'
                inner join producto
                on producto.idProducto = pd.idProducto
		where p.estado in ( 'AUTORIZADO', 'PRODUCCION')
		/*and pd.listo_para_producir = 'NO'*/ and pd.despachado = 'NO'           and pd.IdPedido not in(18100, 21600, 25024)
		and pd.idproducto = pIdProducto;
    IF(vProductoUnidad=1)THEN
    	RETURN vApartadoProductoML;
    ELSE
        RETURN vApartado;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
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

DELIMITER $$
CREATE  FUNCTION `getProductosApartadoAutorizados`(`pIdProducto` INT) RETURNS int(11)
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

DELIMITER $$
CREATE  FUNCTION `getPromotorCliente`(`pidCliente` INT) RETURNS varchar(50) CHARSET utf8
    NO SQL
BEGIN
DECLARE vPromotor varchar(50) ;
SELECT  concat(usuario.nombre,' ', usuario.apellidoPaterno)as promotor INTO vPromotor FROM `cliente` INNER JOIN usuario on cliente.idUsuarioPromotor = usuario.idUsuario where idCliente = pidCliente;
RETURN vPromotor;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getPromotorPedido`(`pIdPedido` INT) RETURNS varchar(50) CHARSET utf8
    NO SQL
BEGIN
	DECLARE  vPromotor  VARCHAR(50);
	select concat(usuario.nombre,'',usuario.apellidoPaterno) as promotor INTO vPromotor
		from pedido
        INNER JOIN usuario on pedido.id_usuario_capturado    = usuario.idUsuario
		where idpedido = pIdPedido;
    RETURN vPromotor;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getRolloApartado`(`pIdRollo` INT) RETURNS decimal(15,2)
BEGIN    
    DECLARE vApartado DECIMAL(15,2);
    DECLARE vApartadoAgregado DECIMAL(15,2);
  select ifnull(SUM(IF(pro.producto_tipoProducto_idTipoProducto = 5,
				(pd.partida * pd.cantidad),
                  IF(pro.producto_tipoProducto_idTipoProducto = 1 AND pro.producto_unidad_idUnidad = 4,
                     pd.partida * pd.cantidad * pro.longitud *IF(pd.pesoKiloML = 0, (SELECT pesokgmt FROM `viewrollos` WHERE idRollo = 2 ), pd.pesoKiloML),
                     IF(pd.idProducto = 386,
                        IF(pd.pesoKiloML = 0,(SELECT pesokgmt FROM `viewrollos` WHERE idRollo = pd.idRolloBase ), pd.pesoKiloML)*cantidad *      															ceiling((partida/(FLOOR((rollo.pies* 30.5)/pd.desarrollo))))                                                
                        ,(pd.partida *pd.cantidad* IF(pd.pesoKiloML = 0,(SELECT pesokgmt FROM `viewrollos` WHERE idRollo = 2 ), pd.pesoKiloML)))))- 
					IF(p.recogeentrega = 'OBRA',
						(pd.mlDespachado * pd.pesoKiloML),
                        IF(pro.producto_tipoProducto_idTipoProducto = 5 ,
							(pd.partidaDespachada * pd.cantidad), IF(pro.producto_tipoProducto_idTipoProducto = 1 AND pro.producto_unidad_idUnidad = 4, pd.partidaDespachada * pd.cantidad * pro.longitud *IF(pd.pesoKiloML = 0,
						(SELECT pesokgmt FROM `viewrollos` WHERE idRollo = 2 ), 
                        pd.pesoKiloML), 
                            (pd.partidaDespachada * pd.cantidad * pd.pesoKiloML )))
							)), 0) INTO  vApartado
		from pedidodetalle pd
		inner join pedido p on p.idpedido = pd.idpedido and p.apartarMercancia = 'SI'
		inner join producto pro on pro.idproducto = pd.idproducto
        inner join rollo on pd.idRolloBase = rollo.idRollo
		where p.estado in ('AUTORIZADO', 'PRODUCCION')
		
        and pd.despachado = 'NO'  and pd.idPedidoDetalle NOT in( 66650238, 66650243, 66650244, 66650246, 66642134, 66642135, 66642136,  66650236, 66654388, 66658512, 66658514, 66658515, 66642132, 66642133, 66654375) 
		and  pd.idRolloBase = pIdRollo and p.idPedido not in(24931,25506, 25510);
        IF pIdRollo = 11 THEN 
        SET vApartadoAgregado = 464.21;
        SET vApartado =vApartado + vApartadoAgregado;
        END IF;
	RETURN vApartado;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoActualReciboDinero`(`IdUsuario` INT) RETURNS decimal(9,2)
    NO SQL
BEGIN
	DECLARE vSaldoActual DECIMAL(9,2);
    DECLARE vUsadoEnPedido DECIMAL(9,2);
    DECLARE vGeneraRecibo DECIMAL(9,2);
	DECLARE vRegresaDinero DECIMAL(9,2);
    SELECT IFNULL(SUM(movrecibodinero.monto), 0) INTO vGeneraRecibo
	  FROM movrecibodinero
       INNER JOIN recibodinero on movrecibodinero.idReciboDinero = 			   recibodinero.idReciboDinero
	 WHERE movrecibodinero.movimiento = 'GENERARECIBO'
       AND recibodinero.idCliente = IdUsuario ;
   SELECT IFNULL(SUM(movrecibodinero.monto), 0) INTO vUsadoEnPedido
	  FROM movrecibodinero
       INNER JOIN recibodinero on movrecibodinero.idReciboDinero = 			   recibodinero.idReciboDinero
	 WHERE movrecibodinero.movimiento = 'USADOENPEDIDO'
       AND recibodinero.idCliente = IdUsuario ;
       SELECT IFNULL(SUM(movrecibodinero.monto), 0) INTO vRegresaDinero
	  FROM movrecibodinero
       INNER JOIN recibodinero on movrecibodinero.idReciboDinero = 			   recibodinero.idReciboDinero
	 WHERE movrecibodinero.movimiento = 'REGRESARDINEROACLIENTES'
       AND recibodinero.idCliente = IdUsuario ;
   SET vSaldoActual =	(vGeneraRecibo)-(vUsadoEnPedido+vRegresaDinero);
    RETURN vSaldoActual;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoCorteComision`(`pIdCorteComision` INTEGER) RETURNS decimal(9,2)
BEGIN
	DECLARE vCargos DECIMAL(9,2);
    DECLARE vAbonos DECIMAL(9,2);
    DECLARE vSaldo DECIMAL(9,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxccortecomision 
	 WHERE movimiento = 'PORPAGAR'
       AND idcortecomision = pIdCorteComision;
	SELECT IFNULL(SUM(monto),0) INTO vAbonos
	  FROM cxccortecomision
	 WHERE movimiento = 'PAGO'
       AND idcortecomision = pIdCorteComision;
	SET vSaldo = vCargos - vAbonos;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoCorteComisionRoofing`(`pIdCorteComisionRoofing` INTEGER) RETURNS decimal(9,2)
BEGIN
	DECLARE vCargos DECIMAL(9,2);
    DECLARE vAbonos DECIMAL(9,2);
    DECLARE vSaldo DECIMAL(9,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxccortecomisionroofing 
	 WHERE movimiento = 'PORPAGAR'
       AND idcortecomisionroofing = pIdCorteComisionroofing;
	SELECT IFNULL(SUM(monto),0) INTO vAbonos
	  FROM cxccortecomisionroofing
	 WHERE movimiento = 'PAGO'
       AND idcortecomisionroofing = pIdCorteComisionroofing;
	SET vSaldo = vCargos - vAbonos;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoPedido`(`pIdPedido` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
    DECLARE vAbonos DECIMAL(15,2);
    DECLARE vSaldo DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxc 
	 WHERE movimiento = 'CARGO'
       AND idPedido = pIdPedido;
	SELECT IFNULL(SUM(monto),0) INTO vAbonos
	  FROM cxc 
	 WHERE movimiento = 'ABONO'
       AND idPedido = pIdPedido;
	SET vSaldo = vCargos - vAbonos;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoPendienteDePago`(`pIdCliente` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldo DECIMAL(15,2);
	SELECT SUM(saldo) INTO vSaldo
	FROM pedido 
	WHERE saldo > 0
	  AND estado NOT IN ('CANCELADO', 'ENTREGADO')
	  AND idcliente = pIdCliente
	  AND DATE_FORMAT(fecha_capturado, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND DATE_FORMAT(CURDATE(), '%Y-%m-%d');
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoPromotorPedido`(`pIdPedido` INTEGER) RETURNS decimal(9,2)
BEGIN
	DECLARE vCargos DECIMAL(9,2);
    DECLARE vAbonos DECIMAL(9,2);
    DECLARE vSaldo DECIMAL(9,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxcpromotor 
	 WHERE movimiento = 'CARGO'
       AND idPedido = pIdPedido;
	SELECT IFNULL(SUM(monto),0) INTO vAbonos
	  FROM cxcpromotor
	 WHERE movimiento = 'ABONO'
       AND idPedido = pIdPedido;
	SET vSaldo = vCargos - vAbonos;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDinero`(`pIdCliente` INTEGER) RETURNS decimal(9,2)
BEGIN	
	DECLARE vSaldo DECIMAL(9,2);
    SELECT IFNULL(SUM(disponible), 0) INTO vSaldo
	  FROM recibodinero 
	 WHERE idCliente = pidCliente;
    RETURN vSaldo;  
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDinero0A30Dias`(`pIdCliente` INTEGER, `pfechaCotizacion` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(disponible), 0)  INTO vSaldo
	  FROM recibodinero 
	  WHERE DATE_FORMAT(fecha_captura, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND DATE_FORMAT(CURDATE(), '%Y-%m-%d')
	  AND DATE_FORMAT(fecha_captura, '%Y-%m-%d') <= pfechaCotizacion
	  AND idcliente = pIdCliente;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDinero31A60Dias`(`pIdCliente` INTEGER, `pfechaCotizacion` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(disponible), 0)  INTO vSaldo
	  FROM recibodinero 
	  WHERE DATE_FORMAT(fecha_captura, '%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 31 DAY), '%Y-%m-%d')
	  AND DATE_FORMAT(fecha_captura, '%Y-%m-%d') <= pfechaCotizacion
	  AND idcliente = pIdCliente;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDineroAntesCotizacion`(`pIdCliente` INTEGER, `pfechaCotizacion` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(disponible), 0)  INTO vSaldo
	  FROM recibodinero 
	  WHERE DATE_FORMAT(fecha_captura, '%Y-%m-%d') <= pfechaCotizacion
	  AND idcliente = pIdCliente;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDineroMas60Dias`(`pIdCliente` INTEGER, `pfechaCotizacion` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(disponible), 0)  INTO vSaldo
	  FROM recibodinero 
	  WHERE DATE_FORMAT(fecha_captura, '%Y-%m-%d')  < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d')
	  AND DATE_FORMAT(fecha_captura, '%Y-%m-%d') <= pfechaCotizacion
	  AND idcliente = pIdCliente;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldoReciboDineroTotalAmparar`(`pIdCliente` INTEGER, `pfechaCotizacion` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldoHasta30 DECIMAL(15,2);
	DECLARE vSaldoHasta60 DECIMAL(15,2);
	DECLARE vSaldoDespues60 DECIMAL(15,2);
	SELECT getSaldoReciboDinero0A30Dias(pIdCliente, pfechaCotizacion), 
           getSaldoReciboDinero31A60Dias(pIdCliente, pfechaCotizacion), 
		   getSaldoReciboDineroMas60Dias(pIdCliente, pfechaCotizacion)
		   INTO vSaldoHasta30, vSaldoHasta60, vSaldoDespues60;
    RETURN (vSaldoHasta30 * 2) + (vSaldoHasta60 * 1.5) + vSaldoDespues60;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldosMas30Dias`(`pIdCliente` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado = 'ENTREGADO'
       AND idCliente = pIdCliente
       AND DATE_FORMAT(fecha_entregado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') ;
       
    RETURN vSaldos;

END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSaldosMas30DiasClienteRFC`(`pIdCliente` INT, `pIdClienteDatosFacturacion` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    DECLARE vPrivado VARCHAR(2);
    
    SET vSaldos = 0;
    SET vPrivado = 'SI';
    
	IF pIdClienteDatosFacturacion > 0 THEN    
		SELECT datosfacturacion.privado INTO vPrivado
		FROM clientedatosfacturacion
		INNER JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion;
   END IF;
   
   IF vPrivado = 'SI' THEN
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldos
		FROM pedido 
		LEFT JOIN clientedatosfacturacion ON pedido.idClienteDatosFacturacion = clientedatosfacturacion.idClienteDatosFacturacion
		LEFT JOIN datosfacturacion ON clientedatosfacturacion.idDatosFacturacion = datosfacturacion.idDatosFacturacion
		WHERE pedido.idCliente = pIdCliente
         AND pedido.estado = 'ENTREGADO'
         AND DATE_FORMAT(pedido.fecha_entregado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d')
		 AND IFNULL( datosfacturacion.privado, 'SI') = 'SI';
    ELSE
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldos
		  FROM pedido 
		 WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion
         AND pedido.estado = 'ENTREGADO'
         AND DATE_FORMAT(pedido.fecha_entregado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d');
	END IF;
       
    RETURN vSaldos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getSucursalPedido`(`idPedido` INT) RETURNS varchar(20) CHARSET utf8
    NO SQL
BEGIN
DECLARE vSucursal VARCHAR(20);
select (GROUP_CONCAT(distinct sucursal.nombre  SEPARATOR ', ')) into vSucursal
			from pedidodetallecolocacion
			inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
			where idpedidodetalle in (select idpedidodetalle from pedidodetalle where idpedido = idPedido)
            AND pedidodetallecolocacion.cantidad > 0;
     RETURN vSucursal;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalAbonosCliente`(`pIdCliente` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbonos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vAbonos
	  FROM cxc 
	 WHERE movimiento = 'ABONO'
       AND idCliente = pIdCliente;
    RETURN vAbonos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalAbonosPedido`(`pIdPedido` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbonos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vAbonos
	  FROM cxc 
	 WHERE movimiento = 'ABONO'
       AND idPedido = pIdPedido;
    RETURN vAbonos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalAbonosPedidoPromotor`(`pIdPedido` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vAbonos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vAbonos
	  FROM cxcpromotor
	 WHERE movimiento = 'ABONO'
       AND idPedido = pIdPedido;
    RETURN vAbonos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalAbonosPromotor`(`pIdPromotor` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0)  INTO vCargos
	  FROM cxc 
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'ABONO'     
       AND cliente.idUsuarioPromotor = pIdPromotor;
    RETURN vCargos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalCargosCliente`(`pIdCliente` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxc 
	 WHERE movimiento = 'CARGO'
       AND idCliente = pIdCliente;
    RETURN vCargos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalCargosPedido`(`pIdPedido` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxc 
	 WHERE movimiento = 'CARGO'
       AND idPedido = pIdPedido;
    RETURN vCargos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalCargosPedidoPromotor`(`pIdPedido` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
    SELECT IFNULL(SUM(monto), 0) INTO vCargos
	  FROM cxcpromotor 
	 WHERE movimiento = 'CARGO'
       AND idPedido = pIdPedido;
    RETURN vCargos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalCargosPromotor`(`pIdPromotor` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargos DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0)  INTO vCargos
	  FROM cxc 
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'CARGO'     
       AND cliente.idUsuarioPromotor = pIdPromotor;
    RETURN vCargos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalKGRutaEnvioVehiculo`(`pIdRutaEnvioVehiculo` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vTotalKG DECIMAL(15,2);
	select SUM(red.maxpeso) INTO vTotalKG
		from rutaenviodetalle red        
		where red.idRutaEnvioVehiculo = pIdRutaEnvioVehiculo;
    RETURN IFNULL(vTotalKG, 0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalKGValeSalida`(`pIdValeSalida` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vTotalKG DECIMAL(15,2);
	select SUM(vsd.cantidad * pd.cantidadreal * vr.pesoKiloML) INTO vTotalKG
		from valesalidadetalle vsd
        inner join pedidodetalle pd on vsd.idpedidodetalle = pd.idpedidodetalle
		inner join viewrollos vr on vr.idrollo = pd.idrollobase
		where pd.idrollobase > 1
        and vsd.idValeSalida = pIdValeSalida;
    RETURN IFNULL(vTotalKG, 0);
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPedidoByValeSalida`(`pIdValeSalida` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vTotal DECIMAL(15,2);
    select sum(total) INTO vTotal
		from valesalidadetalle 
		inner join pedidodetalle on pedidodetalle.idpedidodetalle = valesalidadetalle.idpedidodetalle
		where valesalidadetalle.idvalesalida = pIdValeSalida;
	RETURN vTotal;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPedidoRoofing`(`pIdPedido` INTEGER) RETURNS decimal(9,2)
BEGIN
	DECLARE vTotalPedido DECIMAL(9,2);
    select ifnull(sum(total),0) into vTotalPedido
    from pedidodetalle 
    INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'SI'
    where pedidodetalle.idpedido = pIdPedido;
	RETURN vTotalPedido;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPedidosMendez`() RETURNS decimal(15,2)
BEGIN
	DECLARE vPedidos DECIMAL(15,2);
	SET vPedidos = 0.0;
	SELECT ifnull(SUM(total),0) INTO vPedidos
	FROM pedido
	WHERE idcliente = 137
	AND date_format(fecha_capturado, '%Y-%m-%d') between '2019-01-01' and '2019-06-30';
	SET vPedidos = vPedidos * 1.16;
    RETURN vPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPedidosMendezEntre`(`pfechaInicio` VARCHAR(10), `pfechaFin` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vPedidos DECIMAL(15,2);
	SET vPedidos = 0.0;
	SELECT ifnull(SUM(if (idpedido < 4760, total * 1.16, total)),0) INTO vPedidos
	FROM pedido
	WHERE idcliente = 137
	AND date_format(fecha_capturado, '%Y-%m-%d') BETWEEN pfechaInicio AND pfechaFin
    AND date_format(fecha_capturado, '%Y-%m-%d') >= '2019-01-01'
    AND estado <> 'CANCELADO';
	/* SET vPedidos = vPedidos * 1.16; */
    RETURN vPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPedidosMendezHasta`(`pfecha` VARCHAR(10)) RETURNS decimal(15,2)
BEGIN
	DECLARE vPedidos DECIMAL(15,2);
	SET vPedidos = 0.0;
	SELECT ifnull(SUM(if (idpedido < 4760, total * 1.16, total)),0) INTO vPedidos
	FROM pedido
	WHERE idcliente = 137
	AND date_format(fecha_capturado, '%Y-%m-%d') >= '2019-01-01'
    AND date_format(fecha_capturado, '%Y-%m-%d') < pfecha
    AND estado <> 'CANCELADO';
	/* SET vPedidos = vPedidos * 1.16; */
    RETURN vPedidos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalPycRegistroProduccion`(`pIdRegistroProduccion` INT(11)) RETURNS decimal(15,2)
    NO SQL
BEGIN
DECLARE vTotalPyc DECIMAL(9,2);

SELECT IFNULL(sum(totalKg),0)as totalPYC INTO vTotalPyc FROM `registroproducciondetalle` where tipo = 'PYC' AND idRegistroProduccion = pIdRegistroProduccion;


return vTotalPyc;

END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalReciboDinero`(`pIdCliente` INT) RETURNS decimal(9,2)
    NO SQL
BEGIN DECLARE vTotalRecibo DECIMAL(9,2); SELECT IFNULL(SUM(monto), 0) INTO vTotalRecibo FROM recibodinero WHERE idCliente = pidCliente; RETURN vTotalRecibo; END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalSaldosCliente`(`pIdCliente` INTEGER) RETURNS decimal(15,2)
BEGIN	
    DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado <> 'CANCELADO'
       AND idCliente = pIdCliente;
    RETURN vSaldos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalSaldosClientePedidosEntregados`(`pIdCliente` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado = 'ENTREGADO'
       AND idCliente = pIdCliente;
    RETURN vSaldos;
RETURN 1;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalSaldosClientePedidosSinEntregar`(`pIdCliente` INT) RETURNS decimal(15,2)
    NO SQL
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado  NOT IN('ENTREGADO', 'CANCELADO')
       AND idCliente = pIdCliente;
    RETURN vSaldos;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalSaldosEntregadosPromotor`(`pIdPromotor` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargo DECIMAL(15,2);
	DECLARE vAbono DECIMAL(15,2);
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0) INTO vCargo
	  FROM cxc
	 INNER JOIN pedido
        ON pedido.idpedido = cxc.idpedido AND pedido.estado = 'ENTREGADO' AND pedido.saldo > 0
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'CARGO'       
       AND cliente.idUsuarioPromotor = pIdPromotor;
	SELECT IFNULL(SUM(monto), 0) INTO vAbono
	  FROM cxc
	 INNER JOIN pedido
        ON pedido.idpedido = cxc.idpedido AND pedido.estado = 'ENTREGADO' AND pedido.saldo > 0
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'ABONO'       
       AND cliente.idUsuarioPromotor = pIdPromotor;
	SET vSaldo = vCargo - vAbono;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalSaldosPorEntregarPromotor`(`pIdPromotor` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vCargo DECIMAL(15,2);
	DECLARE vAbono DECIMAL(15,2);
	DECLARE vSaldo DECIMAL(15,2);
	SELECT IFNULL(SUM(monto), 0) INTO vCargo
	  FROM cxc
	 INNER JOIN pedido
        ON pedido.idpedido = cxc.idpedido
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'CARGO'
       AND pedido.estado not in ('CANCELADO','ENTREGADO')
       AND cliente.idUsuarioPromotor = pIdPromotor;
	SELECT IFNULL(SUM(monto), 0) INTO vAbono
	  FROM cxc
	 INNER JOIN pedido
        ON pedido.idpedido = cxc.idpedido
	 INNER JOIN cliente
        ON cliente.idCliente = cxc.idCliente
	 WHERE cxc.movimiento = 'ABONO'
       AND pedido.estado not in ('CANCELADO','ENTREGADO')
       AND cliente.idUsuarioPromotor = pIdPromotor;
	SET vSaldo = vCargo - vAbono;
    RETURN vSaldo;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalValeSalida`(`pidVale` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vTotalVale DECIMAL(15,2);
	SET vTotalVale = 0.0;
	select ifnull(round(sum(pd.total/pd.partida*vsd.cantidad),2),0) into vTotalVale
		from valesalidadetalle vsd
		inner join pedidodetalle pd on vsd.idpedidodetalle = pd.idpedidodetalle
		where idvalesalida = pidVale;
    RETURN vTotalVale;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `getTotalValeSalidaPromotor`(`pidVale` INT) RETURNS decimal(15,2)
BEGIN
	DECLARE vTotalVale DECIMAL(15,2);
	SET vTotalVale = 0.0;
	select ifnull(round(sum(pd.total/pd.partida*vsd.cantidad),2),0) into vTotalVale
		from valesalidapromotordetalle vsd
		inner join pedidodetalle pd on vsd.idpedidodetalle = pd.idpedidodetalle
		where idvalesalidapromotor = pidVale;
    RETURN vTotalVale;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `isPedidodetalleParcial`(`pIdPedidoDetalle` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
    DECLARE visParcial varchar(2);
    DECLARE vNoSucursales INTEGER;
    SET visParcial = 'NO';
    SET vNoSucursales = 0;
    select count(*) into vNoSucursales
	 from pedidodetallecolocacion 
	where idpedidodetalle = pIdPedidoDetalle
	  and cantidad > 0;
    IF vNoSucursales > 1 THEN
		SET visParcial = 'SI';		
    END IF;
    RETURN visParcial;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `isPromotorBloqueadoXCredito`(`pIdPromotor` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	 /* Obtiene el disponible del crédito del cliente */
    DECLARE vBloqueado varchar(2);
    SET vBloqueado = 'NO';
    RETURN vBloqueado;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `nnnn`() RETURNS int(11)
    NO SQL
return 1$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `pedidoBloqueadoXPrecios`(`pIdPedido` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	DECLARE vAmparado DECIMAL(15,2);
	DECLARE vTotal DECIMAL(15,2);
	DECLARE vSaldada VARCHAR(2);
	DECLARE vHaCambioPrecios VARCHAR(2);
	DECLARE vDesbloqueadoPreciosAdmin VARCHAR(2);
	DECLARE resp VARCHAR(2);
	SET resp = 'NO';
	SELECT getAbonoPedidoTotalAmparar(idpedido, DATE_FORMAT(fecha_capturado, '%Y-%m-%d')), 
	       pedidoHaCambiadoDePrecio(idpedido),
		   total, saldada, desbloqueadoPreciosAdmin INTO vAmparado, vHaCambioPrecios, vTotal, vSaldada, vDesbloqueadoPreciosAdmin
	  FROM pedido
	 WHERE idpedido = pIdPedido;
	IF vDesbloqueadoPreciosAdmin = 'NO' AND vHaCambioPrecios = 'SI' AND vSaldada = 'NO' AND vAmparado < vTotal THEN
		SET resp = 'SI';
	END IF;
    RETURN resp;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `pedidoHaCambiadoDePrecio`(`pIdPedido` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	DECLARE resp VARCHAR(2);
	DECLARE cuantosNoMoldura INTEGER;
	DECLARE cuantosMoldura INTEGER;
	SET resp = 'NO';
	SELECT COUNT(*) INTO cuantosNoMoldura
	FROM pedidodetalle pd
	INNER JOIN pedido p ON pd.idpedido = p.idpedido
	INNER JOIN producto pr ON pd.idproducto = pr.idProducto
	WHERE pd.idproducto NOT IN (386, 394) 
	  AND pd.idpedido = pIdPedido
	  AND DATE_FORMAT(pr.lastUpdate, '%Y-%m-%d %H:%i') > DATE_FORMAT(p.fecha_updateprecios, '%Y-%m-%d %H:%i');
	SELECT COUNT(*) INTO cuantosMoldura
	FROM pedidodetalle pd
	INNER JOIN pedido p ON pd.idpedido = p.idpedido
	INNER JOIN rollo r ON pd.idRolloBase = r.idrollo
	WHERE pd.idproducto = 386
	  AND pd.idpedido = pIdPedido
	  AND DATE_FORMAT(r.lastUpdate, '%Y-%m-%d %H:%i') > DATE_FORMAT(p.fecha_updateprecios, '%Y-%m-%d %H:%i');  
	IF (cuantosNoMoldura + cuantosMoldura) > 0 THEN
		SET resp = 'SI';
	END IF;
    RETURN resp;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `pedidoPuedeProducirse`(`pIdPedido` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	DECLARE vregistros INTEGER;
    DECLARE vrespuesta VARCHAR(2);
    SELECT IFNULL(COUNT(idPedido), 0) INTO vregistros
	  FROM pedidodetalle
	 WHERE idPedido = pIdPedido
       AND listo_para_producir = 'SI';
	IF vregistros > 0 THEN
		SET vrespuesta = 'SI';
    ELSE
		SET vrespuesta = 'NO';
    END IF;
    RETURN vrespuesta;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `pedidoPuedeTerminarse`(`pIdPedido` INT) RETURNS varchar(2) CHARSET latin1
BEGIN
	DECLARE vregistros INTEGER;
    DECLARE vrespuesta VARCHAR(2);
    SELECT IFNULL(COUNT(idPedido), 0) INTO vregistros
	  FROM valesalidadetalle
	 WHERE idPedido = pIdPedido
       AND idValeSalida = 0;
	IF vregistros > 0 THEN
		SET vrespuesta = 'NO';
    ELSE
		SET vrespuesta = 'SI';
    END IF;
    RETURN vrespuesta;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `pedidoYaTieneSurtido`(`pIdPedido` INTEGER) RETURNS varchar(2) CHARSET utf8
BEGIN
	DECLARE vregistros INTEGER;
    DECLARE vrespuesta VARCHAR(2);
    SELECT IFNULL(COUNT(idPedido), 0) INTO vregistros
	  FROM pedidodetalle
	 WHERE idPedido = pIdPedido
       AND listo_para_producir = 'SI' 
       AND partidaDespachada > 0;
	IF vregistros > 0 THEN
		SET vrespuesta = 'SI';
    ELSE
		SET vrespuesta = 'NO';
    END IF;
    RETURN vrespuesta;
END$$
DELIMITER ;

DELIMITER $$
CREATE  FUNCTION `testComisionesPedido`(`pIdPedido` INTEGER, `pIdUsuario` INTEGER) RETURNS varchar(200) CHARSET utf8
BEGIN
	DECLARE vTEXTO VARCHAR(200);
	DECLARE vComisiones DECIMAL(9,2);
    DECLARE vPorDescuento DECIMAL(9,2);
    DECLARE vComisionOtroCargo DECIMAL(9,2);
    DECLARE vComisionesRentas DECIMAL(9,2);
    DECLARE vUsuarioCapturado INTEGER;
    DECLARE vPromotor INTEGER;
    DECLARE vIdCliente INTEGER;
    DECLARE vPromotorAnterior INTEGER;
    DECLARE vDividirEntre2 INTEGER;
    SET vTEXTO = '';
    -- set vPromotorAnterior = 9;
    SET vDividirEntre2 = 0;
    set vComisionOtroCargo = 0;
    set vComisionesRentas = 0;
    select ifnull((sum(monto)), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    /*
    select ifnull(sum(monto), 0) into vComisionOtroCargo
		from otroscargospedido where idpedido = pIdPedido and idotrocargo  >= 2;
    */
	select pedido.porDescuento, pedido.id_usuario_capturado,  cliente.idusuariopromotor, pedido.idCliente, cliente.idPromotorAnterior
           into vPorDescuento, vUsuarioCapturado,  vPromotor, vIdCliente, vPromotorAnterior
      from pedido 
      inner join cliente on cliente.idcliente = pedido.idcliente      
     where pedido.idpedido =  pIdPedido;
    SET vTEXTO = concat(vTEXTO,' Usuario = ', pidUsuario, ' - ');
    SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
	SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
    SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
    IF pIdPedido <= 1847 THEN
		IF pIdUsuario = 18 /*Estela*/ OR
           pIdUsuario = 11 /*Saul*/ OR
           pIdUsuario = 21 /*Saida*/ OR
           pIdUsuario = 32 /*Lety*/     THEN
				IF pIdPedido > 1513 THEN
					/* Comisiones Estela */ 
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'
                        where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 1 => Comisiones mostrador, pedido <= 1847 y > 1513');
                ELSE
					SET vComisiones = 0;
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 2 => Comisiones mostrador comisiones cero, pedido <= 1847 y < 1513');
                END IF;          
        ELSE
			IF pIdUsuario = vPromotor OR (pIdUsuario = 10 AND vPromotor = 18 AND pIdPedido <= 1513)  THEN
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
                   /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto AND producto.isRoofing = 'NO'*/
                    where idpedido = pIdPedido;
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 3 => Comisiones NO mostrador, pedido <= 1847 y > 1513');
			ELSE
				SET vComisiones = 0;
                SET vTEXTO = CONCAT(vTEXTO, '-> CASO 4 => Comisiones NO mostrador comisiones cero, pedido <= 1847 y < 1513');
			END IF;
		END IF;
	ELSE /* TODO EL PROCESO ES PRACTICAMENTE AQUI */
		/* 
			pIdUsuario        = el usuario al que se le desea Calcular la Comisión del pIdPedido
            vUsuarioCapturado = usuario que captura el pedido
            vPromotor         = dueño del cliente
        */
		IF vUsuarioCapturado = pIdUsuario OR vPromotor = pIdUsuario OR pIdUsuario = vPromotorAnterior /* para calculo de Miguel */ THEN
			/* Si el usuario que se consulta capturó el pedido o es el promotor del cliente */
			IF vUsuarioCapturado = vPromotor /*AND vPromotorAnterior <> 9 */ THEN   /* Si quien captura el pedido, es e mismo dueño del cliente */
				IF pIdUsuario = 18 /*Estela*/ OR
			  	   pIdUsuario = 11 /*Saul*/ OR
                   pIdUsuario = 21 /*Saida*/ OR
                   pIdUsuario = 32 /*Lety*/ THEN
					/* Comisiones Estela, Saul, Saida y Lety */ 
					select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', comision, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
                    INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                    where idpedido = pIdPedido;
                    set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 5 => el que captura es el promotor y son de mostrador, se da el 0.5 de comision');
				ELSE					
					IF (vPromotor = 18 /*Estela*/ OR
					   vPromotor = 11 /*Saul*/ OR
					   vPromotor = 21 /*Saida*/ OR
					   vPromotor = 32 /*Lety*/)
						AND vPromotorAnterior = 9 
                        AND pIdUsuario = 9 THEN
                        /* el promotor es un mostrador, pero era de Miguel, entonces */
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, (comision - .5))   / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 13 => vendedor = promotor, NO mostrador, usuario = Miguel, comision - 0.5 ');
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                    ELSE
						/* el que capturó el pedido es el promotor tambien del cliente, se da toda la comisión */ 
						select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
						INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
						where idpedido = pIdPedido;
						set vComisionesRentas = vComisionOtroCargo * (2/100); 
						SET vTEXTO = CONCAT(vTEXTO, '-> CASO 6 => el que captura es el promotor y NO son de mostrador, comision completa');
						SET vDividirEntre2 = 1;						
                    END IF;
				END IF;
			ELSE /* Si quien captura el pedido no es el dueño del cliente */
				IF vUsuarioCapturado = pIdUsuario THEN /* quien captura el pedido, es al que se le esta calculando la comisión */
					/* quien captura pedido, no es promotor solo el .5 % */
					select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                        /* pero si son clientes de 0.5% de Yoana, solo el 0.25 */
                    SET vTEXTO = CONCAT(vTEXTO, '-> CASO 7 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision');
					IF vIdCliente = 352 OR vIdCliente = 499 THEN
						/* Para Estela de estos clientes es el 0.5, para los demas el 0.25 */
						IF pIdUsuario = 18 /*Estela*/ OR
                           pIdUsuario = 11 /*Saul*/ OR
                           pIdUsuario = 21 /*Saida*/ OR
                           pIdUsuario = 32 /*Lety*/ THEN
		 					/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones  */
                            select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
							from pedidodetalle 
							/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
							where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 8 => vendedor <> promotor, mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
						ELSE
                            /* tambien para el otro promotor es el 0.5 20191029*/
							select ifnull(sum(cast(total * ( 0.5  / 100) as DECIMAL(10,2))),0) into vComisiones  
							from pedidodetalle 
							/* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
							where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 9 => vendedor <> promotor, NO mostrador, usuario=vendedor, se da 0.5 de comision por clientes 352 y 499');
						END IF;
					END IF;
					set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
				ELSE /* se esta calculando la comisión a un dueño del cliente, y éste no capturó el pedido */
					IF pIdUsuario = 18 /*Estela*/ OR
                       pIdUsuario = 11 /*Saul*/ OR
                       pIdUsuario = 21 /*Saida*/ OR
                       pIdUsuario = 32 /*Lety*/ THEN
						/* Comisiones Estela, Saul, Saida, Lety */ 
						select ifnull(sum(cast(total * (  if(producto.isRoofing = 'SI', 1, 0.5)  / 100) as DECIMAL(10,2))),0) into vComisiones 
						from pedidodetalle 
                        INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                        where idpedido = pIdPedido;
                        set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 10 => vendedor <> promotor, usuario=promotor, mostrador, se da el 0.5 de comision');
					ELSE
						/* vPromotor = pIdUsuario el usuario que solicita comision es el promotor*/
						select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, (comision - .5))   / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle
                            INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
                            where idpedido = pIdPedido;
                        SET vTEXTO = CONCAT(vTEXTO, '-> CASO 11 => vendedor <> promotor, usuario = promotor, comision - 0.5 , NO mostrador');
						IF vIdCliente = 352 OR vIdCliente = 499 THEN
							/* select ifnull(sum(cast(total * ( if(producto.isRoofing = 'SI', 1, 0.5) / 100) as DECIMAL(10,2))),0) into vComisiones  */
                            /* select ifnull(sum(cast(total * ( 0.25 / 100) as DECIMAL(10,2))),0) into vComisiones */ /* si alguien mas vende a este cliente Yohana pierde su comision 20191029*/
                            select ifnull(sum(cast(total * ( 0 / 100) as DECIMAL(10,2))),0) into vComisiones 
							from pedidodetalle 
                            /* INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto  */
                            where idpedido = pIdPedido;
                            SET vTEXTO = CONCAT(vTEXTO, '-> CASO 12 => vendedor <> promotor, usuario = promotor, NO mostrador, no hay comision, clientes 352 y 499');
						END IF;
						set vComisionesRentas = vComisionOtroCargo * (1.5/100); 
                        SET vDividirEntre2 = 1;
					END IF;
				END IF;
			END IF;
		 ELSE
			SET vComisiones = 0;
		 END IF;
    END IF;
    SET vComisiones = vComisiones + vComisionesRentas;
    SET vComisiones = vComisiones-(vComisiones*vPorDescuento/100);
    IF pIdPedido > 11194  THEN
		IF vDividirEntre2 = 1 AND vPromotorAnterior = 9 THEN
			SET vComisiones = vComisiones / 2;
            SET vTEXTO = CONCAT(vTEXTO, '-> DIVIDE ENTRE 2');
		END IF;
	ELSE
		IF vPromotorAnterior = 9 THEN
			IF pidUsuario = 9 AND vUsuarioCapturado = 9 THEN        
				select ifnull(sum(cast(total * (comision / 100) as DECIMAL(10,2))),0) into vComisiones 
				from pedidodetalle 
				INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
				where idpedido = pIdPedido;
				set vComisionesRentas = vComisionOtroCargo * (2/100); 
				SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
				SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
				SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
				SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
				SET vTEXTO = CONCAT(vTEXTO, '-> CASO 14 => el que captura es el promotor y fue MIGUEL exepcion pedido 11194, comision completa');
			ELSE
				IF pidUsuario <> 9 AND vUsuarioCapturado <> 9 THEN        
					select ifnull(sum(cast(total * (0.5 / 100) as DECIMAL(10,2))),0) into vComisiones 
					from pedidodetalle 
					INNER JOIN producto on pedidodetalle.idproducto = producto.idproducto 
					where idpedido = pIdPedido;
					set vComisionesRentas = vComisionOtroCargo * (0.5/100); 
					SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
					SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
					SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
					SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
					SET vTEXTO = CONCAT(vTEXTO, '-> CASO 16 => el que captura es el promotor y fue MIGUEL exepcion pedido 11194, comision completa');
				ELSE
					SET vComisiones = 0;
					SET vTEXTO = concat(' Usuario = ', pidUsuario, ' - ');
					SET vTEXTO = concat(vTEXTO,' Vendedor = ', vUsuarioCapturado, ' - ');
					SET vTEXTO = concat(vTEXTO,' Promotor = ', vPromotor, ' - ');	
					SET vTEXTO = concat(vTEXTO,' PromotorAnterior = ', vPromotorAnterior, ' -   ');
					SET vTEXTO = CONCAT(vTEXTO, '-> CASO 15 => Interceptado, Pedido era de Miguel antes del 11194');
				END IF;
			END IF;
        END IF;
    END IF;
    if pIdPedido = 4132 then
		SET vComisiones = 9597.29;
	end if;
    /* RETURN vComisiones; */
    return concat(vComisiones, ': ', vTEXTO) ;
END$$
DELIMITER ;
