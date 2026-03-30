-- =============================================
-- VERIFICACION: Consultas para verificar inserciones
-- =============================================

-- Verificar aplicaciones insertadas
SELECT 'APLICACIONES' AS tabla, COUNT(*) AS total FROM aplicacion WHERE nombreAplicacion NOT LIKE '--%';

-- Verificar materiales insertados
SELECT 'MATERIALES' AS tabla, COUNT(*) AS total FROM material WHERE nombre NOT LIKE '--%';

-- Verificar rollos insertados (excluyendo "NO APLICA")
SELECT 'ROLLOS' AS tabla, COUNT(*) AS total FROM rollo WHERE codigo NOT LIKE '--%';

-- Verificar productos insertados
SELECT 'PRODUCTOS' AS tabla, COUNT(*) AS total FROM producto;

-- Listar aplicaciones nuevas
SELECT idAplicacion, nombreAplicacion FROM aplicacion ORDER BY idAplicacion;

-- Listar materiales nuevos
SELECT idMaterial, nombre, clave FROM material ORDER BY idMaterial;

-- Listar rollos nuevos con su material
SELECT r.idRollo, r.codigo, m.nombre AS material, r.calibre, r.pies 
FROM rollo r 
LEFT JOIN material m ON m.idMaterial = r.rollo_material_idMaterial
WHERE r.codigo NOT LIKE '--%'
ORDER BY r.idRollo;

-- Muestra de productos insertados
SELECT p.idProducto, p.codigo, p.descripcion, a.nombreAplicacion AS aplicacion, m.nombre AS material
FROM producto p
LEFT JOIN aplicacion a ON a.idAplicacion = p.producto_aplicacion_idAplicacion
LEFT JOIN material m ON m.idMaterial = p.producto_material_idMaterial
ORDER BY p.idProducto DESC
LIMIT 30;
