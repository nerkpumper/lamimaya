-- no permitir pago v entrega cuando el saldo es mayor a 25000 pesos


USE `galvamex08`;
DROP function IF EXISTS `getSaldosMas30Dias`;

DELIMITER $$
USE `galvamex08`$$
CREATE FUNCTION `getSaldosMas30Dias` (`pIdCliente` INTEGER) RETURNS DECIMAL(15,2)
BEGIN
	DECLARE vSaldos DECIMAL(15,2);
    SET vSaldos = 0;
    SELECT IFNULL(SUM(saldo), 0)  INTO vSaldos
	  FROM pedido 
	 WHERE estado <> 'CANCELADO'
       AND idCliente = pIdCliente
       AND DATE_FORMAT(fecha_capturado, '%Y-%m-%d') < DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') ;
       
    RETURN vSaldos;

END$$

DELIMITER ;

