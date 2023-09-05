DELIMITER $$
CREATE FUNCTION `getTotalSaldosClientePedidosSinEntregar`(`pIdCliente` INT) RETURNS decimal(15,2)
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