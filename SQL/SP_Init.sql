DELIMITER $$
CREATE  PROCEDURE `spGetProductosStock`(IN idtipoproducto INT, IN idaplicacion INT, IN idmaterial INT, IN idunidad INT)
BEGIN

DECLARE done INT DEFAULT FALSE;

DECLARE idProducto int;
DECLARE codigo varchar(255);
DECLARE descripcion varchar(1000);
DECLARE sucursal VARCHAR(255);
DECLARE cantidad int;


DECLARE curDistinctProductos CURSOR FOR 
	select DISTINCT p.idproducto , p.codigo, p.descauto
		from viewproductos p 
		inner join inventariosucursal invs on p.idproducto = invs.idproducto
		inner join sucursal s on invs.idSucursal = s.idSucursal
		where p.estado = 'ACTIVO' 
        and (idtipoproducto = 0 OR p.idtipoproducto = idtipoproducto)
        and (idaplicacion = 0 OR p.idaplicacion = idaplicacion)
        and (idmaterial = 0 OR p.idmaterial = idmaterial)
        and (idunidad = 0 OR p.idunidad = idunidad)
        and idtipoproducto <> 5
        order by p.idrollo, p.idtipoproducto, p.material, p.aplicacion, p.mlpieza ;
		 -- where p.idproducto = 277;
        
DECLARE curSucursales CURSOR FOR 
	select REPLACE(LOWER(nombre),' ','') nombre from sucursal where visible = 'SI';
    
DECLARE curInventario CURSOR FOR 
	select p.idproducto, p.codigo, REPLACE(LOWER(s.nombre),' ','') nombre, (invs.existencia - invs.apartado) existencia
		from viewproductos p 
		inner join inventariosucursal invs on p.idproducto = invs.idproducto
		inner join sucursal s on invs.idSucursal = s.idSucursal and s.visible = 'SI'
        where (idtipoproducto = 0 OR p.idtipoproducto = idtipoproducto)
        and (idaplicacion = 0 OR p.idaplicacion = idaplicacion)
        and (idmaterial = 0 OR p.idmaterial = idmaterial)
        and (idunidad = 0 OR p.idunidad = idunidad);
		-- where p.idproducto = 277;
		

DECLARE curDistinctRollos CURSOR FOR 
	select DISTINCT r.idrollo  idproducto, r.codigo, r.descauto
		from viewrollos r 				
		where r.idrollo > 1 and  r .estado = 'ACTIVO'     
        and (idmaterial = 0 OR r.idmaterial = idmaterial)
        order by r.idrollo;		
		
DECLARE curInventarioRollos CURSOR FOR 
	select DISTINCT r.idrollo  idproducto, r.codigo, REPLACE(LOWER(s.nombre),' ','') nombre, ifnull(getExistenciasRolloSucursal(s.idsucursal, r.idrollo),0) existencia
		from viewrollos r 		
		inner join sucursal s on s.visible = 'SI'
		where r.idrollo > 1 and  r .estado = 'ACTIVO'                   
        order by r.idrollo;				

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;


DROP TEMPORARY TABLE IF EXISTS tmpproductos;

CREATE TEMPORARY TABLE tmpproductos   
(
	idproducto int ,
    codigo varchar(255) primary key,
    descripcion varchar(1000)
);

SET done = FALSE;

OPEN curSucursales;
  curSucursales_loop: LOOP
    FETCH curSucursales INTO sucursal;
    IF done THEN
      LEAVE curSucursales_loop;
    END IF;
    SET @strquery = CONCAT('ALTER table tmpproductos ADD ', sucursal,' INT DEFAULT 0;');

PREPARE myquery FROM @strquery;
EXECUTE myquery;
    
  END LOOP;
  CLOSE curSucursales;


SET done = FALSE;

OPEN curDistinctProductos;
  DistinctProducto_loop: LOOP
    FETCH curDistinctProductos INTO idProducto, codigo, descripcion;
    IF done THEN
      LEAVE DistinctProducto_loop;
    END IF;
    insert into tmpproductos(idproducto, codigo, descripcion) values (idProducto, codigo, descripcion);
  END LOOP;
  CLOSE curDistinctProductos;
  

SET done = FALSE;

OPEN curInventario;
  curInventario_loop: LOOP
    FETCH curInventario INTO idproducto, codigo, sucursal, cantidad;
    IF done THEN
      LEAVE curInventario_loop;
    END IF;
    SET @strquery = CONCAT('UPDATE tmpproductos SET ', sucursal,' = ', cantidad, ' where codigo = \'', codigo,'\';');

PREPARE myquery FROM @strquery;
EXECUTE myquery;
    
  END LOOP;
  CLOSE curInventario;  
  
/* rollos */

	IF idtipoproducto = 0 or idtipoproducto = 5 THEN
		SET done = FALSE;

		OPEN curDistinctRollos;
		  DistinctRollo_loop: LOOP
			FETCH curDistinctRollos INTO idProducto, codigo, descripcion;
			IF done THEN
			  LEAVE DistinctRollo_loop;
			END IF;
			insert into tmpproductos(idproducto, codigo, descripcion) values (idProducto, codigo, descripcion);
		  END LOOP;
		  CLOSE curDistinctRollos;
		  
		SET done = FALSE;

		OPEN curInventarioRollos;
		  DistinctRollo_loop: LOOP
			FETCH curInventarioRollos INTO idProducto, codigo, sucursal, cantidad;
			IF done THEN
			  LEAVE DistinctRollo_loop;
			END IF;
			SET @strquery = CONCAT('UPDATE tmpproductos SET ', sucursal,' = ', cantidad, ' where codigo = \'', codigo,'\';');

			PREPARE myquery FROM @strquery;
			EXECUTE myquery;

		  END LOOP;
		  CLOSE curInventarioRollos;  
		END IF;
  
/* fin rollos */  
  

  

select  *
from tmpproductos order by 1;


END$$
DELIMITER ;





DELIMITER $$
CREATE  PROCEDURE `spMoverRutaDetalle`(`pIdRutaEnvioOrigen` INT, `pIdRutaEnvioDestino` INT)
BEGIN
	DECLARE vUltimoOrdenDestino INT;
    
	select IFNULL(max(orden) ,0) into vUltimoOrdenDestino
	from rutaenviodetalle where idrutaenvio = pIdRutaEnvioDestino;

	insert into rutaenviodetalle (idRutaEnvio, idPedido, idValeSalida, maxml, maxpeso, enRuta, orden, idRutaEnvioVehiculo, ordenVehiculo )
	select pIdRutaEnvioDestino, idPedido, idValeSalida, maxml, maxpeso, enRuta, orden, 0, 0
	from rutaenviodetalle where idrutaenvio = pIdRutaEnvioOrigen;
    
    SET SQL_SAFE_UPDATES = 0;
    DELETE FROM rutaenviodetalle where idrutaenvio = pIdRutaEnvioOrigen;
    DELETE FROM rutaenvio where idrutaenvio = pIdRutaEnvioOrigen;
	SET SQL_SAFE_UPDATES = 1;

END$$
DELIMITER ;


DELIMITER $$
CREATE  PROCEDURE `spRegistrarFamilias`()
BEGIN
		insert into comfamilia (idAplicacion, idMaterial)
		select distinct v.idAplicacion, 
			   v.idMaterial
		from viewproductos v
		left join comfamilia c on c.idAplicacion = v.idAplicacion
			 and c.idMaterial = v.idMaterial
		where v.idtipoproducto = 1 
		and v.idrollo = 1
		and v.idUnidad = 4
		and v.mlpieza > 0
		and v.estado = 'ACTIVO'
		and c.idaplicacion is null
        order by v.idaplicacion, v.idmaterial;

END$$
DELIMITER ;


DELIMITER $$
CREATE  PROCEDURE `spRegistrarPorcentajesCompraSucursal`()
BEGIN
	
		
		
	UPDATE inventariosucursal isuc
	-- SELECT p.idProducto, p.codigo, p.mlpieza, vtas.cantidad, vtassuc.idSucursal, vtassuc.cantidad, IF(vtas.cantidad > 0 , ROUND(vtassuc.cantidad*100/vtas.cantidad, 2), 0) porcentaje
	-- FROM inventariosucursal isuc 
	INNER JOIN producto p on isuc.idproducto = p.idproducto
	INNER JOIN (SELECT idProducto, sum(cantidad) cantidad
				  FROM comproduccionstock
				 WHERE fecha BETWEEN date_format(DATE_ADD(curdate(), INTERVAL -12 MONTH), "%Y-%m-%d") AND date_format(curdate(), "%Y-%m-%d")    
					GROUP BY idProducto) vtas
	   ON p.idProducto = vtas.idProducto
	  /* AND p.producto_tipoproducto_idtipoproducto = 1
	  AND p.producto_unidad_idUnidad = 4
	  AND p.mlpieza > 0
	  AND p.estado = 'ACTIVO' */
	INNER JOIN (SELECT idProducto, idSucursal, sum(cantidad) cantidad
				  FROM comproduccionstock
				 WHERE fecha BETWEEN date_format(DATE_ADD(curdate(), INTERVAL -12 MONTH), "%Y-%m-%d") AND date_format(curdate(), "%Y-%m-%d")    
					GROUP BY idProducto, idSucursal) vtassuc
	   ON p.idProducto = vtassuc.idProducto 
	   AND isuc.idSucursal = vtassuc.idSucursal
	SET isuc.compraAnual = vtassuc.cantidad, compraPorcentaje = IF(vtas.cantidad > 0 , ROUND(vtassuc.cantidad*100/vtas.cantidad, 2), 0) 
	WHERE isuc.idProducto = vtassuc.idproducto
	  AND isuc.idSucursal = vtassuc.idSucursal;
	  
	  
	  
	  

END$$
DELIMITER ;




DELIMITER $$
CREATE  PROCEDURE `spRegistrarVentasDelDia`()
BEGIN
	
    INSERT INTO comproduccionstock (idproducto, fecha, anio, mes, dia, cantidad)
	SELECT p.idproducto, curdate(), 
		DATE_FORMAT(curdate(), '%Y') anio, 
		DATE_FORMAT(curdate(), '%m') mes, 
		DATE_FORMAT(curdate(), '%d') dia,
        0
	FROM producto p
    LEFT JOIN comproduccionstock c ON p.idproducto = c.idproducto AND curdate() = c.fecha
	WHERE p.producto_tipoproducto_idtipoproducto = 1 
	-- and producto_rollo_idRollo = 1
	AND p.producto_unidad_idUnidad = 4
	AND p.mlpieza > 0
    AND p.estado = 'ACTIVO'    
    AND c.idProducto IS NULL
	ORDER BY p.producto_aplicacion_idAplicacion, p.mlpieza;
        
    UPDATE comproduccionstock c
	INNER JOIN (SELECT i.idproducto, DATE_FORMAT(i.fecha_movimiento, '%Y-%m-%d') fecha, SUM(cantidad) AS cantidad
				FROM invzmov i 
				WHERE i.documento = 'PEDIDO'
				AND i.idpedidodetalle > 0
				-- and i.idproducto = 164
				AND DATE_FORMAT(i.fecha_movimiento, '%Y-%m-%d') = curdate() -- '2018-05-05'
				GROUP BY 1,2) inv
		ON inv.idproducto = c.idproducto AND inv.fecha = c.fecha
	SET c.cantidad = inv.cantidad
	WHERE c.idproducto = inv.idProducto
	  AND c.fecha = curdate() ; -- '2018-05-05';  
	  
	 /* venta del mes */
	 
	 INSERT INTO comproduccionmesstock (idsucursal, idproducto, anio, mes, cantidad)
	SELECT datos.idsucursal, datos.idproducto, 
		datos.anio, 
		datos.mes, 
		0
	FROM (SELECT i.idsucursal, i.idproducto, DATE_FORMAT(i.fecha_movimiento, '%Y') anio, DATE_FORMAT(i.fecha_movimiento, '%m') mes, SUM(cantidad) AS cantidad
			FROM invzmov i 
			WHERE i.documento = 'PEDIDO'
			AND i.idpedidodetalle > 0
			-- AND i.idproducto = 515
			-- AND DATE_FORMAT(i.fecha_movimiento, '%Y-%m') =  '2019-05'
			-- AND DATE_FORMAT(i.fecha_movimiento, '%Y-%m-%d') = curdate()
			GROUP BY 1,2, 3, 4) datos
	LEFT JOIN comproduccionmesstock c ON datos.idproducto = c.idproducto AND datos.anio = c.anio AND datos.mes = c.mes
	WHERE c.idComProduccionMesStock IS NULL
	ORDER BY 1, 2, 3;


	UPDATE comproduccionmesstock c
	INNER JOIN (SELECT i.idsucursal, i.idproducto, DATE_FORMAT(i.fecha_movimiento, '%Y') anio, DATE_FORMAT(i.fecha_movimiento, '%m') mes, SUM(cantidad) AS cantidad
				FROM invzmov i 
				WHERE i.documento = 'PEDIDO'
				AND i.idpedidodetalle > 0
				-- AND i.idproducto = 515
				-- AND DATE_FORMAT(i.fecha_movimiento, '%Y-%m') = '2019-05'
				AND DATE_FORMAT(i.fecha_movimiento, '%Y-%m-%d') = curdate()
				GROUP BY 1,2,3,4) inv
		ON inv.idproducto = c.idproducto 
		AND inv.idsucursal = c.idsucursal
		AND inv.anio = c.anio AND inv.mes = c.mes
	SET c.cantidad = inv.cantidad
	-- where c.idproducto = 515 and c.fecha = '2019-05-15'
	;  



END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE `spRegistrarVentasDesdeCreacionDeProducto`(`pIdProducto` INT)
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE vFechaInicio varchar(10);
    DECLARE vFechaProceso varchar(10);
    DECLARE vidProducto INT;
    -- declare vString varchar(20000);
	declare vint int;
            
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
		
        /* obtenemos primer fecha del producto */
        SELECT DATE_FORMAT(fecha_creacion, '%Y-%m-%d') INTO vFechaInicio
		FROM producto WHERE idproducto = pIdProducto;
        
        SET vFechaProceso = vFechaInicio;
		
		SET vint = 0;
		elloop: LOOP
			-- FETCH curSucursales INTO sucursal;
			IF vFechaProceso > curdate()   THEN
			  LEAVE elloop;
			END IF;
			
			INSERT INTO comproduccionstock (idSucursal, idproducto, fecha, anio, mes, dia, cantidad)
            SELECT idSucursal, pIdProducto, DATE_FORMAT(vFechaProceso, '%Y-%m-%d'), DATE_FORMAT(vFechaProceso, '%Y'), DATE_FORMAT(vFechaProceso, '%m'), DATE_FORMAT(vFechaProceso, '%d'), 0
              FROM sucursal WHERE visible = 'SI';
            
			
			-- set vString = concat (vString, ' - ', vFechaProceso);
			SET vFechaProceso = DATE_ADD(vFechaProceso, INTERVAL 1 DAY);
		  END LOOP;
	  
END$$
DELIMITER ;
