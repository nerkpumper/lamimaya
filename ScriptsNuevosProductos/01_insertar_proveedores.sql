-- =============================================
-- PROVEEDORES
-- =============================================

INSERT INTO proveedor (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES
('HANWA', 'HAN', 'ACTIVO', NOW(), 1),
('TERNIUM', 'TER', 'ACTIVO', NOW(), 1),
('TEXTURIZADOS', 'TXT', 'ACTIVO', NOW(), 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);