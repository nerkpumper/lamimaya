DROP function IF EXISTS `testComisionesPedido`;

DELIMITER $$
CREATE FUNCTION `testComisionesPedido`(`pIdPedido` INTEGER, `pIdUsuario` INTEGER) RETURNS varchar(200)
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

