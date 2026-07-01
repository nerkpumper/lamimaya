-- =====================================================
-- Motivos por los que NO se muestra "Imprimir Orden Producción"
-- Basado en getImprimir() de pedido.inc.php
-- =====================================================
-- Reemplaza "?idPedido?" por el número de pedido a evaluar.

SET @idPedido = ?idPedido?;

SELECT
  p.idPedido,
  p.estado,
  p.colocado,
  p.explotado,
  p.explotadook,
  /* -- Estado inválido -- */
  CASE
    WHEN p.estado = 'CANCELADO' THEN '✗ Estado es CANCELADO'
    WHEN p.estado = 'CAPTURADO' THEN '✗ Estado es CAPTURADO (aún no autorizado)'
    WHEN p.estado IN ('AUTORIZADO','PRODUCCION','TERMINADO','ENTREGADO') THEN '✓ Estado válido'
    ELSE '✗ Estado desconocido: ' + p.estado
  END AS val_estado,

  /* -- colocado -- */
  CASE
    WHEN p.colocado = 'SI' THEN '✓ colocado = SI'
    ELSE '✗ colocado = NO → el pedido no ha sido asignado a sucursales'
  END AS val_colocado,

  /* -- Sucursales asignadas con cantidad > 0 -- */
  (SELECT COUNT(DISTINCT pdc.idsucursal)
   FROM pedidodetalle pd
   INNER JOIN pedidodetallecolocacion pdc ON pd.idPedidoDetalle = pdc.idPedidoDetalle
   WHERE pd.idPedido = p.idPedido AND pdc.cantidad > 0
  ) AS sucursales_con_asignacion,

  CASE
    WHEN EXISTS (
      SELECT 1
      FROM pedidodetalle pd
      INNER JOIN pedidodetallecolocacion pdc ON pd.idPedidoDetalle = pdc.idPedidoDetalle
      WHERE pd.idPedido = p.idPedido AND pdc.cantidad > 0
    ) THEN '✓ Hay asignaciones con cantidad > 0'
    ELSE '✗ Ningún detalle tiene asignación > 0 en pedidodetallecolocacion'
  END AS val_asignacion,

  /* -- Resumen -- */
  CASE
    WHEN p.estado IN ('CANCELADO','CAPTURADO') THEN 'NO — estado incorrecto'
    WHEN p.colocado != 'SI' THEN 'NO — no colocado'
    WHEN NOT EXISTS (
      SELECT 1
      FROM pedidodetalle pd
      INNER JOIN pedidodetallecolocacion pdc ON pd.idPedidoDetalle = pdc.idPedidoDetalle
      WHERE pd.idPedido = p.idPedido AND pdc.cantidad > 0
    ) THEN 'NO — sin asignaciones > 0'
    ELSE 'SÍ — debería mostrar el botón (dependiendo del rol)'
  END AS resultado_final

FROM pedido p
WHERE p.idPedido = @idPedido;
