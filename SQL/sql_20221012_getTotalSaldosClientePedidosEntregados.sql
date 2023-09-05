CREATE FUNCTION `getTotalSaldosClientePedidosEntregados`(`pIdCliente` INTEGER) RETURNS decimal(15,2)
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