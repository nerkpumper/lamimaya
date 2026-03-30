-- =============================================
-- INSERTS PARA LAMIMAYA
-- Tablas: material, aplicacion, rollo, producto
-- Base de datos: mayamaria
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================
-- MATERIALES
-- =============================================
INSERT INTO `material` (`nombre`, `clave`, `estado`, `fecha_creacion`, `idUsuarioCrea`) VALUES
('ACERO INOXIDABLE 304', 'AI3', 'ACTIVO', NOW(), 1),
('ACERO INOXIDABLE 316', 'AI6', 'ACTIVO', NOW(), 1),
('LÁMINA GALVANIZADA Z220', 'ZG2', 'ACTIVO', NOW(), 1),
('LÁMINA GALVANIZADA Z275', 'ZG7', 'ACTIVO', NOW(), 1),
('LÁMINA GALVANIZADA Z350', 'ZG3', 'ACTIVO', NOW(), 1),
('ACERO CARBONO CAL. 16', 'AC1', 'ACTIVO', NOW(), 1),
('ACERO CARBONO CAL. 18', 'AC2', 'ACTIVO', NOW(), 1),
('ALUMINIO 3003 H14', 'AL3', 'ACTIVO', NOW(), 1),
('ALUMINIO 5052 H32', 'AL5', 'ACTIVO', NOW(), 1),
('LÁMINA ZINTRO GRIS', 'ZGR', 'ACTIVO', NOW(), 1);

-- =============================================
-- APLICACIONES
-- =============================================
INSERT INTO `aplicacion` (`nombreAplicacion`, `estado`, `fecha_creacion`, `idUsuarioCrea`) VALUES
('TECHADO RESIDENCIAL', 'ACTIVO', NOW(), 1),
('TECHADO INDUSTRIAL', 'ACTIVO', NOW(), 1),
('MURO DIVISORIO', 'ACTIVO', NOW(), 1),
('FACHADA VENTILADA', 'ACTIVO', NOW(), 1),
('CUBIERTA APERLANADA', 'ACTIVO', NOW(), 1),
('AISLANTE TÉRMICO', 'ACTIVO', NOW(), 1),
('BAJO NAVE', 'ACTIVO', NOW(), 1),
('ENTREPISO METÁLICO', 'ACTIVO', NOW(), 1),
('REFRIGERACIÓN', 'ACTIVO', NOW(), 1),
('AGRICULTURA', 'ACTIVO', NOW(), 1);

-- =============================================
-- ROLLOS (depende de material)
-- FK: rollo_material_idMaterial, rollo_proveedor_idProveedor, rollo_color_idColor
-- =============================================
INSERT INTO `rollo` (
    `codigo`, `rollo_material_idMaterial`, `calibre`, `pies`, `origen`,
    `rollo_proveedor_idProveedor`, `grado`, `rollo_color_idColor`,
    `descripcion`, `estado`, `fecha_creacion`, `id_usuario_creacion`,
    `existencia`, `apartado`, `iva`, `costokg`, `preciokg1`
) VALUES
('R-GZ220-001', 4, 26, 100.00, 'N', NULL, 33, 1, 'Rollo Galvanizado Z275 Cal. 26 100 pies', 'ACTIVO', NOW(), 1, 95.50, 0.00, 16.00, 8.50, 12.75),
('R-GZ220-002', 4, 24, 120.00, 'N', NULL, 33, 1, 'Rollo Galvanizado Z275 Cal. 24 120 pies', 'ACTIVO', NOW(), 1, 118.00, 0.00, 16.00, 9.25, 13.88),
('R-GZ275-001', 4, 22, 80.00, 'N', NULL, 33, 1, 'Rollo Galvanizado Z275 Cal. 22 80 pies', 'ACTIVO', NOW(), 1, 78.00, 5.00, 16.00, 10.50, 15.75),
('R-ZGR-001', 3, 28, 150.00, 'N', NULL, 33, 2, 'Rollo Zintro Gris Cal. 28 150 pies', 'ACTIVO', NOW(), 1, 145.00, 0.00, 16.00, 7.80, 11.70),
('R-ZGR-002', 3, 26, 100.00, 'N', NULL, 33, 2, 'Rollo Zintro Gris Cal. 26 100 pies', 'ACTIVO', NOW(), 1, 98.00, 0.00, 16.00, 8.20, 12.30),
('R-AL3-001', 8, 24, 200.00, 'I', NULL, 33, 3, 'Rollo Aluminio 3003 Cal. 24 Importado', 'ACTIVO', NOW(), 1, 195.00, 0.00, 16.00, 18.50, 27.75),
('R-AC1-001', 6, 16, 100.00, 'N', NULL, 33, 1, 'Rollo Acero Carbono Cal. 16', 'ACTIVO', NOW(), 1, 99.00, 0.00, 16.00, 11.00, 16.50),
('R-AI3-001', 1, 22, 60.00, 'I', NULL, 33, 4, 'Rollo Acero Inoxidable 304 Cal. 22', 'ACTIVO', NOW(), 1, 58.00, 0.00, 16.00, 45.00, 67.50),
('R-GZ220-003', 4, 28, 200.00, 'N', NULL, 33, 1, 'Rollo Galvanizado Z275 Cal. 28 200 pies', 'ACTIVO', NOW(), 1, 198.00, 0.00, 16.00, 7.50, 11.25),
('R-GZ220-004', 4, 20, 60.00, 'N', NULL, 33, 1, 'Rollo Galvanizado Z275 Cal. 20 60 pies', 'ACTIVO', NOW(), 1, 58.00, 0.00, 16.00, 12.00, 18.00);

-- =============================================
-- PRODUCTOS (depende de aplicacion, material, rollo, tipoProducto, unidad)
-- FK: producto_tipoProducto_idTipoProducto, producto_aplicacion_idAplicacion,
--     producto_material_idMaterial, producto_rollo_idRollo, producto_unidad_idUnidad
-- =============================================
INSERT INTO `producto` (
    `codigo`, `longitud`, `mlpieza`, `producto_tipoProducto_idTipoProducto`,
    `producto_aplicacion_idAplicacion`, `producto_material_idMaterial`,
    `producto_rollo_idRollo`, `producto_unidad_idUnidad`, `calibre`,
    `pies`, `origen`, `descripcion`, `existencia`, `apartado`, `tipoPrecio`,
    `isRango`, `isRollo`, `heredarPrecio`, `cf`, `precio1`, `precio2`,
    `precio3`, `precio4`, `costo`, `estado`, `fecha_creacion`, `idUsuarioCrea`,
    `isSegunda`, `isRoofing`
) VALUES
-- LAMINAS
('LAM-GZ-T6', '6 PIES', 1.83, 1, 1, 4, NULL, 2, 26, 72, 'N', 'Lámina Galvanizada Z275 Cal. 26 6 Pies', 150.00, 0.00, 'G', '0', '0', 'SI', 0.00, 285.00, 275.00, 265.00, 255.00, 195.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-T8', '8 PIES', 2.44, 1, 1, 4, NULL, 2, 26, 96, 'N', 'Lámina Galvanizada Z275 Cal. 26 8 Pies', 200.00, 0.00, 'G', '0', '0', 'SI', 0.00, 380.00, 365.00, 350.00, 340.00, 260.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-T10', '10 PIES', 3.05, 1, 1, 4, NULL, 2, 26, 120, 'N', 'Lámina Galvanizada Z275 Cal. 26 10 Pies', 120.00, 10.00, 'G', '0', '0', 'SI', 0.00, 475.00, 460.00, 445.00, 430.00, 325.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-T12', '12 PIES', 3.66, 1, 2, 4, NULL, 2, 24, 144, 'N', 'Lámina Galvanizada Z275 Cal. 24 12 Pies', 80.00, 0.00, 'G', '0', '0', 'SI', 0.00, 570.00, 550.00, 535.00, 520.00, 390.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-T6-22', '6 PIES', 1.83, 1, 1, 4, NULL, 2, 22, 72, 'N', 'Lámina Galvanizada Z275 Cal. 22 6 Pies', 60.00, 0.00, 'G', '0', '0', 'SI', 0.00, 325.00, 315.00, 305.00, 295.00, 225.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-ZGR-T8', '8 PIES', 2.44, 1, 1, 3, NULL, 2, 28, 96, 'N', 'Lámina Zintro Gris Cal. 28 8 Pies', 180.00, 0.00, 'G', '0', '0', 'SI', 0.00, 340.00, 328.00, 318.00, 308.00, 235.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-AL-T6', '6 PIES', 1.83, 1, 3, 8, NULL, 2, 24, 72, 'I', 'Lámina Aluminio 3003 Cal. 24 6 Pies', 45.00, 0.00, 'G', '0', '0', 'SI', 0.00, 520.00, 505.00, 490.00, 475.00, 380.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-T6-R', '6 PIES', 1.83, 1, 2, 4, NULL, 2, 26, 72, 'N', 'Lámina Galvanizada Z275 Cal. 26 6 Pies Tech. Industrial', 95.00, 0.00, 'G', '0', '0', 'SI', 0.00, 310.00, 298.00, 288.00, 278.00, 210.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),

-- CANALONES
('CAN-GZ-4', '4 PULGADAS', 3.05, 2, 1, 4, NULL, 1, 26, 0, 'N', 'Canalón Galvanizado 4 Pulgadas', 250.00, 0.00, 'G', '0', '0', 'SI', 0.00, 125.00, 120.00, 115.00, 110.00, 85.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('CAN-GZ-5', '5 PULGADAS', 3.05, 2, 1, 4, NULL, 1, 26, 0, 'N', 'Canalón Galvanizado 5 Pulgadas', 180.00, 0.00, 'G', '0', '0', 'SI', 0.00, 145.00, 140.00, 135.00, 130.00, 100.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('CAN-GZ-6', '6 PULGADAS', 3.05, 2, 2, 4, NULL, 1, 24, 0, 'N', 'Canalón Galvanizado 6 Pulgadas Industrial', 120.00, 0.00, 'G', '0', '0', 'SI', 0.00, 175.00, 168.00, 162.00, 156.00, 120.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('CAN-AL-4', '4 PULGADAS', 3.05, 2, 1, 8, NULL, 1, 24, 0, 'I', 'Canalón Aluminio 3003 4 Pulgadas', 80.00, 0.00, 'G', '0', '0', 'SI', 0.00, 185.00, 178.00, 172.00, 165.00, 135.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),

-- MOLDURAS
('MOL-GZ-R1', 'REMATE', 3.05, 3, 1, 4, NULL, 1, 26, 0, 'N', 'Moldura Remate Galvanizada', 500.00, 0.00, 'G', '0', '0', 'SI', 0.00, 45.00, 43.00, 41.00, 39.00, 30.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('MOL-GZ-R2', 'CANAL', 3.05, 3, 1, 4, NULL, 1, 26, 0, 'N', 'Moldura Canal Galvanizada', 450.00, 0.00, 'G', '0', '0', 'SI', 0.00, 55.00, 52.00, 50.00, 48.00, 38.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('MOL-GZ-F1', 'FRENTE', 3.05, 3, 1, 4, NULL, 1, 26, 0, 'N', 'Moldura Frente Galvanizada', 380.00, 0.00, 'G', '0', '0', 'SI', 0.00, 65.00, 62.00, 59.00, 56.00, 45.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('MOL-GZ-J1', 'JUNTA', 3.05, 3, 2, 4, NULL, 1, 26, 0, 'N', 'Moldura Junta Industrial Galvanizada', 300.00, 0.00, 'G', '0', '0', 'SI', 0.00, 75.00, 72.00, 69.00, 66.00, 52.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('MOL-AL-R1', 'REMATE', 3.05, 3, 3, 8, NULL, 1, 24, 0, 'I', 'Moldura Remate Aluminio', 150.00, 0.00, 'G', '0', '0', 'SI', 0.00, 95.00, 91.00, 87.00, 83.00, 68.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('MOL-AI-R1', 'REMATE', 3.05, 3, 9, 1, NULL, 1, 22, 0, 'I', 'Moldura Remate Acero Inoxidable 304', 40.00, 0.00, 'G', '0', '0', 'SI', 0.00, 245.00, 238.00, 230.00, 222.00, 180.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),

-- ACCESORIOS
('ACC-GZ-TORN', 'TORNILLO', NULL, 4, NULL, 4, NULL, 4, NULL, 0, 'N', 'Tornillo Galvanizado para Lámina (Caja 100 pzas)', 500.00, 0.00, 'G', '0', '0', 'NO', 0.00, 85.00, 82.00, 78.00, 75.00, 55.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ACC-GZ-SELL', 'SELLADOR', NULL, 4, NULL, NULL, NULL, 3, NULL, 0, 'N', 'Sellador para Juntas Galvamex (Cubeta 19L)', 50.00, 0.00, 'G', '0', '0', 'NO', 0.00, 650.00, 630.00, 610.00, 590.00, 480.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ACC-GZ-BRIDA', 'BRIDA', NULL, 4, NULL, 4, NULL, 4, NULL, 0, 'N', 'Brida de Fijación Galvanizada', 200.00, 0.00, 'G', '0', '0', 'NO', 0.00, 35.00, 33.00, 31.00, 29.00, 22.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ACC-GZ-CINT', 'CINTA', NULL, 4, NULL, NULL, NULL, 3, NULL, 0, 'N', 'Cinta Butilo 50mm x 15m', 300.00, 0.00, 'G', '0', '0', 'NO', 0.00, 125.00, 120.00, 115.00, 110.00, 85.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),

-- ROLLOS
('ROL-GZ-001', '100 PIES', 30.48, 5, NULL, 4, NULL, 3, 26, 100, 'N', 'Rollo Lámina Galvanizada Cal. 26 100 Pies', 50.00, 0.00, 'G', '0', '1', 'NO', 0.00, 1250.00, 1200.00, 1150.00, 1100.00, 900.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ROL-GZ-002', '120 PIES', 36.58, 5, NULL, 4, NULL, 3, 24, 120, 'N', 'Rollo Lámina Galvanizada Cal. 24 120 Pies', 35.00, 0.00, 'G', '0', '1', 'NO', 0.00, 1550.00, 1490.00, 1430.00, 1370.00, 1120.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ROL-ZGR-001', '150 PIES', 45.72, 5, NULL, 3, NULL, 3, 28, 150, 'N', 'Rollo Zintro Gris Cal. 28 150 Pies', 25.00, 0.00, 'G', '0', '1', 'NO', 0.00, 1100.00, 1060.00, 1020.00, 980.00, 800.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('ROL-AL-001', '200 PIES', 60.96, 5, NULL, 8, NULL, 3, 24, 200, 'I', 'Rollo Aluminio 3003 Cal. 24 Importado 200 Pies', 15.00, 0.00, 'G', '0', '1', 'NO', 0.00, 3800.00, 3680.00, 3550.00, 3420.00, 2900.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),

-- PRODUCTOS CON APLICACIÓN ESPECÍFICA
('LAM-GZ-AGR-6', '6 PIES', 1.83, 1, 10, 4, NULL, 2, 28, 72, 'N', 'Lámina Galvanizada Cal. 28 6 Pies Uso Agrícola', 300.00, 0.00, 'G', '0', '0', 'SI', 0.00, 245.00, 238.00, 230.00, 222.00, 175.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-GZ-AGR-8', '8 PIES', 2.44, 1, 10, 4, NULL, 2, 28, 96, 'N', 'Lámina Galvanizada Cal. 28 8 Pies Uso Agrícola', 280.00, 0.00, 'G', '0', '0', 'SI', 0.00, 325.00, 315.00, 305.00, 295.00, 235.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-ISO-MU-6', '6 PIES', 1.83, 1, 3, NULL, NULL, 2, NULL, 72, 'I', 'Panel Aislante Isobox Muro 50mm 6 Pies', 40.00, 0.00, 'G', '0', '0', 'NO', 0.00, 850.00, 820.00, 790.00, 760.00, 620.00, 'ACTIVO', NOW(), 1, 'NO', 'NO'),
('LAM-ISO-CUB-6', '6 PIES', 1.83, 1, 6, NULL, NULL, 2, NULL, 72, 'I', 'Panel Aislante Isobox Cubierta 80mm 6 Pies', 30.00, 0.00, 'G', '0', '0', 'NO', 0.00, 1250.00, 1210.00, 1170.00, 1130.00, 950.00, 'ACTIVO', NOW(), 1, 'NO', 'NO');

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- =============================================
-- VERIFICACIÓN
-- =============================================
-- SELECT 'Materiales insertados:' AS info, COUNT(*) AS total FROM material;
-- SELECT 'Aplicaciones insertadas:' AS info, COUNT(*) AS total FROM aplicacion;
-- SELECT 'Rollos insertados:' AS info, COUNT(*) AS total FROM rollo;
-- SELECT 'Productos insertados:' AS info, COUNT(*) AS total FROM producto;
