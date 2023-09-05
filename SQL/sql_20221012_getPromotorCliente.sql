DELIMITER $$
CREATE FUNCTION `getPromotorCliente`(`pidCliente` INT) RETURNS varchar(50) CHARSET utf8
    NO SQL
BEGIN
DECLARE vPromotor varchar(50) ;
SELECT  concat(usuario.nombre,' ', usuario.apellidoPaterno)as promotor INTO vPromotor FROM `cliente` INNER JOIN usuario on cliente.idUsuarioPromotor = usuario.idUsuario where idCliente = pidCliente;
RETURN vPromotor;
END$$
DELIMITER ;