-- =============================================================
-- Diagnóstico: colocaCantidad listado (getPedidoParaSurtir) vs detalle (getPedidoDetalleSucursal)
-- =============================================================
-- Reemplaza ?idPedidoDetalle? y ?idSucursal? según el caso.

SET @idPedidoDetalle = ?;
SET @idSucursal = ?;

-- 1. Datos del pedidodetallecolocacion (debería tener colocaCantidad > 0)
SELECT pdc.idPedidoDetalleColocacion,
       pdc.idPedidoDetalle,
       pdc.idSucursal,
       pdc.cantidad    AS colocaCantidad,
       pdc.cantidadsurtida AS colocaCantidadSurtida,
       s.nombre        AS sucursalNombre
FROM pedidodetallecolocacion pdc
INNER JOIN sucursal s ON pdc.idSucursal = s.idSucursal
WHERE pdc.idPedidoDetalle = @idPedidoDetalle
  AND pdc.idSucursal = @idSucursal;

-- 2. ¿Existe el registro en inventariosucursal? 
--    Si NO existe → INNER JOIN falla → colocaCantidad se queda en 0
SELECT invs.idInventarioSucursal,
       invs.idProducto,
       invs.idSucursal,
       invs.existencia,
       invs.apartado
FROM inventariosucursal invs
WHERE invs.idProducto = (SELECT pd.idProducto FROM pedidodetalle pd WHERE pd.idPedidoDetalle = @idPedidoDetalle)
  AND invs.idSucursal = @idSucursal;

-- 3. Resumen de diagnóstico
SELECT
  (SELECT COUNT(*) FROM pedidodetallecolocacion pdc 
   WHERE pdc.idPedidoDetalle = @idPedidoDetalle AND pdc.idSucursal = @idSucursal) AS existe_colocacion,
  (SELECT COUNT(*) FROM inventariosucursal invs 
   WHERE invs.idProducto = (SELECT pd.idProducto FROM pedidodetalle pd WHERE pd.idPedidoDetalle = @idPedidoDetalle) 
     AND invs.idSucursal = @idSucursal) AS existe_inventario,
  CASE
    WHEN (SELECT COUNT(*) FROM pedidodetallecolocacion pdc 
          WHERE pdc.idPedidoDetalle = @idPedidoDetalle AND pdc.idSucursal = @idSucursal) = 0
    THEN 'ERROR: No hay registro en pedidodetallecolocacion'
    WHEN (SELECT COUNT(*) FROM inventariosucursal invs 
          WHERE invs.idProducto = (SELECT pd.idProducto FROM pedidodetalle pd WHERE pd.idPedidoDetalle = @idPedidoDetalle) 
            AND invs.idSucursal = @idSucursal) = 0
    THEN 'BUG: INNER JOIN con inventariosucursal elimina la fila (no existe inventario)'
    ELSE 'OK: debería mostrar colocaCantidad correctamente'
  END AS resultado;
