DELIMITER $$
DROP TRIGGER IF EXISTS `pedidodetalle_BEFORE_INSERT`;CREATE TRIGGER `pedidodetalle_BEFORE_INSERT` BEFORE INSERT ON `pedidodetalle` FOR EACH ROW BEGIN
	DECLARE vIdUsuarioPromotor INTEGER;
    DECLARE vIdUsuarioPromotorAnterior INTEGER;
    DECLARE vIdCliente INTEGER;
    DECLARE vComisionR1 DECIMAL(15,2);
    DECLARE vComisionR2 DECIMAL(15,2);
    DECLARE vComisionR3 DECIMAL(15,2);
	DECLARE vComisionR4 DECIMAL(15,2);
    DECLARE vIsRoofing VARCHAR(2);
    DECLARE vpesocu DECIMAL(15,2);
    DECLARE vpesokgmt DECIMAL(15,2);
    DECLARE vcostoProducto DECIMAL(15,2);
    DECLARE vpies DECIMAL(15,2);
    DECLARE vtipoProducto DECIMAL(15,2);
    /*select p.idcliente, c.idusuariopromotor into vIdCliente, vIdUsuarioPromotor 
		from pedido p
		inner join cliente c on c.idcliente = p.idcliente
		where p.idpedido = NEW.idPedido;
    */
    select p.idcliente, c.idusuariopromotor,  c.idPromotorAnterior,
       IF( u.rangocomisiones = 'ALTO', co.comision1R1, IF (u.rangocomisiones = 'MEDIO', co.comision2R1, co.comision3R1)) comisionR1,
       IF( u.rangocomisiones = 'ALTO', co.comision1R2, IF (u.rangocomisiones = 'MEDIO', co.comision2R2, co.comision3R2)) comisionR2,
       IF( u.rangocomisiones = 'ALTO', co.comision1R3, IF (u.rangocomisiones = 'MEDIO', co.comision2R3, co.comision3R3)) comisionR3,
	   IF( u.rangocomisiones = 'ALTO', co.comision1R4, IF (u.rangocomisiones = 'MEDIO', co.comision2R4, co.comision3R4)) comisionR4 
        into vIdCliente, vIdUsuarioPromotor ,vIdUsuarioPromotorAnterior, vComisionR1, vComisionR2, vComisionR3, vComisionR4
		from pedido p
		inner join cliente c on c.idcliente = p.idcliente
        inner join usuario u on u.idusuario = c.idusuariopromotor
        inner join configuracion co on co.idconfiguracion = 1
		where p.idpedido = NEW.idPedido;
    IF vIdUsuarioPromotor <> 18 THEN	
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = vComisionR1;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = vComisionR1;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = vComisionR1;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = vComisionR1;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = vComisionR2;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = vComisionR3;
								ELSE
									IF NEW.tipoprecio = 'RANGO4' THEN
										SET NEW.comision = vComisionR4;	
									END IF;
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
    END IF;
	IF vIdUsuarioPromotor = 18 /*Estela*/ OR
	   vIdUsuarioPromotor = 11 /*Saul*/ OR
       vIdUsuarioPromotor = 21 /*Saida*/ OR
       vIdUsuarioPromotor = 15 /*Sergio*/ OR
       vIdUsuarioPromotor = 32 /*Lety*/ THEN	
        SET NEW.comision = 0.5;
    END IF;
	IF NEW.idProducto = 394 THEN
        SET NEW.comision = 2;        
    END IF;
    IF vIdUsuarioPromotor = 10 AND vIdCliente <= 548 AND vIdCliente <> 342 THEN	
		/* 
        342
			352 = 0.5
            499 = 0.5
        */
        IF vIdCliente = 352 OR vIdCliente = 499 OR vIdCliente=364 THEN
			SET NEW.comision = 0.5;
        ELSE
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = 1.5;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = 1.5;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = 1.5;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = 1.5;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = 1.25;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = 1;
								ELSE
									IF NEW.tipoprecio = 'RANGO4' THEN
										SET NEW.comision = 0.75;	
									END IF;
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
        END IF;
    END IF;
    SELECT isRoofing INTO vIsRoofing
     FROM producto
     WHERE idProducto = NEW.idProducto;
     /* IF NEW.idProducto >= 517 AND NEW.idProducto <= 532 THEN */
    IF vIsRoofing = 'SI' THEN
        SET NEW.comision = 2;        
    END IF;
	SET NEW.tipoPrecioOriginal = NEW.tipoPrecio;
    SET NEW.comisionOriginal = NEW.comision;
    SET NEW.precioUnitarioOriginal = NEW.precioUnitario;
    SELECT pesocu, pesokgmt, pies INTO vpesocu, vpesokgmt, vpies FROM rollo WHERE idRollo = NEW.idRolloBase;
    /* si el pedido era cliente de Miguel ya se ha quitado lo de Miguel en febrero 2021 */
    IF vIdUsuarioPromotorAnterior = 9999 THEN	
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = 2;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = 2;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = 2;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = 2;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = 1.75;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = 1.5;
								ELSE
									IF NEW.tipoprecio = 'RANGO4' THEN
										SET NEW.comision = 1.25;
									END IF;								
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
    END IF;	

    IF vIdUsuarioPromotor = 34 /*Oscar Rios, cero comision*/ THEN	
        SET NEW.comision = 0;
    END IF;
    IF NEW.idProducto <> 386 THEN 
    SET NEW.costoProducto = (vpesocu * vpesokgmt * 1.16)* NEW.partida * NEW.cantidad;
    END IF;
    SELECT costo, producto_tipoProducto_idTipoProducto INTO vcostoProducto, vtipoProducto FROM producto WHERE idProducto = NEW.idProducto;
    IF NEW.idRolloBase = 1 THEN 
    SET NEW.costoProducto = vcostoProducto * NEW.partida * NEW.cantidad;
    END IF;
     IF NEW.idProducto = 386 THEN  
		SET NEW.costoProducto = vpesocu * vpesokgmt* 1.16 * NEW.cantidad * (NEW.partida/(FLOOR((vpies*30.5)/ NEW.desarrollo)));
    END IF;
     IF vtipoProducto = 5 THEN  
		SET NEW.costoProducto = NEW.partida * NEW.cantidad * 1.16 * vpesocu;
    END IF;
END