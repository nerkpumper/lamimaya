ALTER TABLE `galvamex_appgalva`.`cliente` 
CHANGE COLUMN `rangoCliente` `rangoCliente` ENUM('REGULAR', 'DISTINGUIDO', 'SELECT', 'PLATINO') NULL DEFAULT 'REGULAR' ;


ALTER TABLE `galvamex_appgalva`.`rollo` 
ADD COLUMN `totalpreciovtar4` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `totalpreciovtar3`;

ALTER TABLE `galvamex_appgalva`.`producto` 
ADD COLUMN `precio4` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `precio3`;



DROP TRIGGER IF EXISTS `galvamex_appgalva`.`rollo_BEFORE_UPDATE`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE TRIGGER `rollo_BEFORE_UPDATE` BEFORE UPDATE ON `rollo` FOR EACH ROW BEGIN
    
	IF OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu THEN
	   
		SET NEW.lastUpdate = NOW();
		
		UPDATE configuracion SET rolloprodlastupdate = NOW() WHERE idConfiguracion = 1;
		
	END IF;
	

END$$
DELIMITER ;





DROP TRIGGER IF EXISTS `galvamex_appgalva`.`rollo_AFTER_UPDATE`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE TRIGGER `rollo_AFTER_UPDATE` AFTER UPDATE ON `rollo` FOR EACH ROW BEGIN
	DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
	DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
	IF (OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.totalpreciovta;
       SET vp2 = NEW.totalpreciovtar2;
       SET vp3 = NEW.totalpreciovtar3;
       SET vp4 = NEW.totalpreciovtar4;
       SET vpm = NEW.totalpreciomendez;
       SET vcu = NEW.pesocu;
       UPDATE producto 
          SET precio1 = vp1 * mlpieza, 
              precio2 = vp2 * mlpieza, 
              precio3 = vp3 * mlpieza,
              precio4 = vp4 * mlpieza,
              preciomendez = vpm * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'NO';
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4,
              preciomendez = vpm              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'NO';
		UPDATE producto 
          SET precio1 = (vp1*.85) * mlpieza, 
              precio2 = (vp1*.85) * mlpieza, 
              precio3 = (vp1*.85) * mlpieza,
              precio4 = (vp1*.85) * mlpieza,
              preciomendez = (vp1*.85) * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'SI';
	   UPDATE producto 
          SET precio1 = (vp1*.85),
              precio2 = (vp1*.85),
              precio3 = (vp1*.85),
              precio4 = (vp1*.85),
              preciomendez = (vp1*.85)              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'SI';
	END IF;
END$$
DELIMITER ;




DROP TRIGGER IF EXISTS `galvamex_appgalva`.`producto_BEFORE_INSERT`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE TRIGGER `producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW BEGIN
    DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
    DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
    DECLARE vpkg DOUBLE;
	IF NEW.producto_rollo_idrollo > 1 THEN
		IF NEW.tipoprecio = 'G' AND NEW.isRollo = '0' THEN        
			SELECT totalpreciovta, totalpreciovtar2, totalpreciovtar3, totalpreciovtar4, totalpreciomendez, pesocu, pesokgmt 
					INTO vp1, vp2, vp3, vp4, vpm, vcu, vpkg
              FROM rollo 
			 WHERE idrollo = NEW.producto_rollo_idrollo;
			IF NEW.producto_unidad_idunidad = 4 THEN
				SET NEW.precio1 = vp1 * NEW.mlpieza;
				SET NEW.precio2 = vp2 * NEW.mlpieza;
				SET NEW.precio3 = vp3 * NEW.mlpieza;
                SET NEW.precio4 = vp4 * NEW.mlpieza;
				SET NEW.preciomendez = vpm * NEW.mlpieza;
				SET NEW.costo =  vcu * vpkg * NEW.mlpieza;
				
                IF NEW.isSegunda = 'SI' THEN
					SET NEW.precio1 = (vp1 * NEW.mlpieza)*.85;                        
					SET NEW.precio2 = (vp1 * NEW.mlpieza)*.85;
					SET NEW.precio3 = (vp1 * NEW.mlpieza)*.85;
					SET NEW.precio4 = (vp1 * NEW.mlpieza)*.85;
					SET NEW.preciomendez = (vp1 * NEW.mlpieza)*.85;
					SET NEW.costo =  vcu * vpkg * NEW.mlpieza; 
				END IF;                			
			ELSE
				SET NEW.precio1 = vp1;                    
				IF NEW.isRango = '1' THEN               
					SET NEW.precio2 = vp2;
					SET NEW.precio3 = vp3;
                    SET NEW.precio4 = vp4;
					SET NEW.preciomendez = vpm;
					SET NEW.costo =  vcu * vpkg;
				END IF;
			
				IF NEW.isSegunda = 'SI' THEN
					SET NEW.precio1 = vp1*.85;                        
					SET NEW.precio2 = vp1*.85;
					SET NEW.precio3 = vp1*.85;
                    SET NEW.precio4 = vp1*.85;
					SET NEW.preciomendez = (vp1 * NEW.mlpieza)*.85;
					SET NEW.costo =  vcu * vpkg * NEW.mlpieza; 
				END IF;
			END IF;			
        
			IF NEW.tipoRango = '' THEN
				SET NEW.tipoRango = 'A';
			END IF;
		END IF;
    END IF;
	SET NEW.lastUpdate = NOW();

END$$
DELIMITER ;



DROP TRIGGER IF EXISTS `galvamex_appgalva`.`producto_BEFORE_UPDATE`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE TRIGGER `producto_BEFORE_UPDATE` BEFORE UPDATE ON `producto` FOR EACH ROW BEGIN
    IF NEW.preciomendez = 0.0 THEN
		IF NEW.precio3 > 0.0 THEN
			SET NEW.preciomendez = NEW.precio3;
		ELSE
			IF NEW.precio2 > 0.0 THEN
				SET NEW.preciomendez = NEW.precio2;
			ELSE
				SET NEW.preciomendez = NEW.precio1;
            END IF;
        END IF;
    END IF;
	IF OLD.precio1  <> NEW.precio1 OR 
       OLD.precio2 <> NEW.precio2 OR 
       OLD.precio3 <> NEW.precio3 OR
       OLD.precio4 <> NEW.precio4 OR
       OLD.preciomendez <> NEW.preciomendez THEN
		SET NEW.lastUpdate = NOW();
		UPDATE configuracion SET rolloprodlastupdate = NOW() WHERE idConfiguracion = 1;
	END IF;

	

END$$
DELIMITER ;




ALTER TABLE `galvamex_appgalva`.`configuracion` 
ADD COLUMN `comision1R4` DOUBLE NULL DEFAULT '0' AFTER `comision1R3`,
ADD COLUMN `comision2R4` DOUBLE NULL DEFAULT '0' AFTER `comision2R3`,
ADD COLUMN `comision3R4` DOUBLE NULL DEFAULT '0' AFTER `comision3R3`;



ALTER TABLE `galvamex_appgalva`.`pedidodetalle` 
CHANGE COLUMN `tipoPrecio` `tipoPrecio` ENUM('PRECIO', 'RANGO1', 'RANGO2', 'RANGO3', 'IMPORTADO', 'TERNIUM', 'MENDEZ', 'RANGO4') NULL DEFAULT 'PRECIO' ,
CHANGE COLUMN `tipoPrecioOriginal` `tipoPrecioOriginal` ENUM('PRECIO', 'RANGO1', 'RANGO2', 'RANGO3', 'IMPORTADO', 'TERNIUM', 'MENDEZ', 'RANGO4') NULL DEFAULT 'PRECIO' ;




ALTER TABLE `galvamex_appgalva`.`cotizaciondetalle` 
ADD COLUMN `precio4` DECIMAL(9,2) NULL DEFAULT '0' AFTER `precio3`,
CHANGE COLUMN `tipoPrecio` `tipoPrecio` ENUM('PRECIO', 'RANGO1', 'RANGO2', 'RANGO3', 'IMPORTADO', 'TERNIUM', 'MENDEZ', 'RANGO4') NULL DEFAULT 'PRECIO' ,
CHANGE COLUMN `tipoPrecioOriginal` `tipoPrecioOriginal` ENUM('PRECIO', 'RANGO1', 'RANGO2', 'RANGO3', 'IMPORTADO', 'TERNIUM', 'MENDEZ', 'RANGO4') NULL DEFAULT 'PRECIO' ;



ALTER TABLE `galvamex_appgalva`.`cotizacion` 
CHANGE COLUMN `rangoCliente` `rangoCliente` ENUM('REGULAR', 'DISTINGUIDO', 'SELECT', 'PLATINO') NULL DEFAULT 'REGULAR' ;



DROP TRIGGER IF EXISTS `galvamex_appgalva`.`cotizacion_BEFORE_UPDATE`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE TRIGGER `galvamex_appgalva`.`cotizacion_BEFORE_UPDATE` BEFORE UPDATE ON `cotizacion` FOR EACH ROW
BEGIN
	IF OLD.rangoCliente <> NEW.rangoCliente THEN
		
        IF NEW.rangoCliente = 'PLATINO' THEN			
            SET NEW.rangosString = '4444444444';
        ELSE
			IF NEW.rangoCliente = 'SELECT' THEN
				SET NEW.rangosString = '3333333333';
			ELSE
				IF NEW.rangoCliente = 'DISTINGUIDO' THEN
					SET NEW.rangosString = '2222222222';
				ELSE
					SET NEW.rangosString = '1111111111';
				END IF;
			END IF;
        END IF;
        
    
    END IF;
END$$
DELIMITER ;
