ALTER TABLE `galvamex_appgalva`.`clientedatosfacturacion` 
ADD COLUMN `credito` DECIMAL(15,2) NULL DEFAULT '0' AFTER `idDatosFacturacion`;


ALTER TABLE `galvamex_appgalva`.`datosfacturacion` 
DROP COLUMN `credito`;

ALTER TABLE `galvamex_appgalva`.`clientedatosfacturacion` 
ADD COLUMN `capacidadPago` DECIMAL(15,2) NULL DEFAULT '0' AFTER `credito`;


ALTER TABLE `galvamex_appgalva`.`pedido` 
ADD COLUMN `idClienteDatosFacturacion` INT(11) NULL DEFAULT '0' AFTER `apartarMercancia`;   


USE `galvamex_appgalva`;
DROP function IF EXISTS `getCreditoUsadoClienteDatoFacturacion`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getCreditoUsadoClienteDatoFacturacion` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
BEGIN
	/* Obteiene la suma de los saldos del cliente, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(15,2);
    
    SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
	  FROM pedido 
	 WHERE idCliente = pIdCliente AND idClienteDatosFacturacion = pIdClienteDatosFacturacion;
          
    RETURN vSaldo;
END$$

USE `galvamex_appgalva`;
DROP function IF EXISTS `getSaldosMas30DiasClienteRFC`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getSaldosMas30DiasClienteRFC` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado = 'ENTREGADO'
       AND idCliente = pIdCliente AND idClienteDatosFacturacion = pIdClienteDatosFacturacion
       AND DATE_FORMAT(fecha_capturado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') ;
       
    RETURN vSaldos;
END$$

DELIMITER ;



ALTER TABLE `galvamex_appgalva`.`pedido` 
ADD COLUMN `liberaVales` ENUM('SI', 'NO') NULL DEFAULT 'NO' AFTER `idClienteDatosFacturacion`,
ADD COLUMN `id_usuario_libera_vales` INT NULL DEFAULT '0' AFTER `liberaVales`,
ADD COLUMN `fecha_libera_vales` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `id_usuario_libera_vales`,
ADD COLUMN `observacionLiberaVales` VARCHAR(255) NULL DEFAULT '' AFTER `fecha_libera_vales`;


USE `galvamex_appgalva`;
DROP function IF EXISTS `getCreditoUsadoClienteDatoFacturacionEntregados`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getCreditoUsadoClienteDatoFacturacionEntregados` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
BEGIN
	/* Obteiene la suma de los saldos del cliente, es decir, lo que tiene usado de su crédito */
    DECLARE vSaldo DECIMAL(15,2);
    
    SELECT IFNULL(SUM(saldo), 0) INTO vSaldo
	  FROM pedido 
	 WHERE idCliente = pIdCliente AND idClienteDatosFacturacion = pIdClienteDatosFacturacion
       AND estado = 'ENTREGADO';
          
    RETURN vSaldo;
END$$


ALTER TABLE `galvamex_appgalva`.`pedidostracking` 
ADD COLUMN `track` ENUM('PEDIDO', 'VALESALIDA') NULL DEFAULT 'PEDIDO' AFTER `fecha`;



ALTER TABLE `galvamex_appgalva`.`cliente` 
ADD COLUMN `sumacreditorfc` DECIMAL(15,2) NULL DEFAULT '0' AFTER `credito`,
ADD COLUMN `sumacapacidadpagorfc` DECIMAL(15,2) NULL DEFAULT '0' AFTER `capacidadPago`;



ALTER TABLE `galvamex_appgalva`.`clientedatosfacturacion` 
ADD COLUMN `fecha_insert` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `capacidadPago`,
ADD COLUMN `id_usuario_insert` INT NULL DEFAULT '0' AFTER `fecha_insert`,
ADD COLUMN `fecha_update` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `id_usuario_insert`,
ADD COLUMN `id_usuario_update` INT NULL DEFAULT '0' AFTER `fecha_update`;




ALTER TABLE `galvamex_appgalva`.`datosfacturacion` 
ADD COLUMN `fecha_insert` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `idUsoCfdi`,
ADD COLUMN `id_usuario_insert` INT NULL DEFAULT '0' AFTER `fecha_insert`,
ADD COLUMN `fecha_update` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `id_usuario_insert`,
ADD COLUMN `id_usuario_update` INT NULL DEFAULT '0' AFTER `fecha_update`;



ALTER TABLE `galvamex_appgalva`.`clientedatosfacturacion` 
DROP COLUMN `capacidadPago`,
DROP COLUMN `credito`;


ALTER TABLE `galvamex_appgalva`.`datosfacturacion` 
ADD COLUMN `credito` DECIMAL(15,2) NULL DEFAULT '0' AFTER `idUsoCfdi`,
ADD COLUMN `capacidadPago` DECIMAL(15,2) NULL DEFAULT '0' AFTER `credito`;


ALTER TABLE `galvamex_appgalva`.`datosfacturacion` 
ADD COLUMN `privado` ENUM('SI', 'NO') NULL DEFAULT 'NO' AFTER `capacidadPago`;



USE `galvamex_appgalva`;
DROP function IF EXISTS `getCreditoUsadoClienteDatoFacturacion`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getCreditoUsadoClienteDatoFacturacion` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
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



USE `galvamex_appgalva`;
DROP function IF EXISTS `getSaldosMas30DiasClienteRFC`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getSaldosMas30DiasClienteRFC` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
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
         AND DATE_FORMAT(pedido.fecha_capturado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d')
		 AND IFNULL( datosfacturacion.privado, 'SI') = 'SI';
    ELSE
		SELECT IFNULL(SUM(saldo), 0) INTO vSaldos
		  FROM pedido 
		 WHERE idClienteDatosFacturacion = pIdClienteDatosFacturacion
         AND pedido.estado = 'ENTREGADO'
         AND DATE_FORMAT(pedido.fecha_capturado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d');
	END IF;
       
    RETURN vSaldos;
END$$

DELIMITER ;




USE `galvamex_appgalva`;
DROP function IF EXISTS `getCreditoUsadoClienteDatoFacturacionEntregados`;

DELIMITER $$
USE `galvamex_appgalva`$$
CREATE FUNCTION `getCreditoUsadoClienteDatoFacturacionEntregados` (`pIdCliente` INTEGER, `pIdClienteDatosFacturacion` INTEGER) RETURNS decimal(15,2)
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

