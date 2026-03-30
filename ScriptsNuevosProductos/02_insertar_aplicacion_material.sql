-- =============================================
-- PASO 1: INSERTAR APLICACIONES
-- =============================================
INSERT INTO aplicacion (nombreAplicacion, estado, fecha_creacion, idUsuarioCrea) VALUES
('T-81', 'ACTIVO', NOW(), 1),
('T-60', 'ACTIVO', NOW(), 1),
('KR-18DA', 'ACTIVO', NOW(), 1),
('R-101', 'ACTIVO', NOW(), 1),
('RN-100', 'ACTIVO', NOW(), 1),
('KR-18', 'ACTIVO', NOW(), 1),
('T-942', 'ACTIVO', NOW(), 1),
('T-941', 'ACTIVO', NOW(), 1),
('T-952', 'ACTIVO', NOW(), 1),
('OG-100', 'ACTIVO', NOW(), 1),
('ISOCOP', 'ACTIVO', NOW(), 1),
('LOSACERO', 'ACTIVO', NOW(), 1),
('LISA', 'ACTIVO', NOW(), 1),
('R-72', 'ACTIVO', NOW(), 1),
('PANEL', 'ACTIVO', NOW(), 1),
('OG-30', 'ACTIVO', NOW(), 1),
('TEJ GAL', 'ACTIVO', NOW(), 1)
ON DUPLICATE KEY UPDATE nombreAplicacion = VALUES(nombreAplicacion);

-- =============================================
-- PASO 2: INSERTAR MATERIALES
-- =============================================
INSERT INTO material (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES
('STABILIT OPALIT', 'OPA', 'ACTIVO', NOW(), 1),
('ACRYLIT G18', 'ACR', 'ACTIVO', NOW(), 1),
('GALVANIZADO', 'GA', 'ACTIVO', NOW(), 1),
('GALVANIZADO SEC', 'GALS', 'ACTIVO', NOW(), 1),
('HIANSA CUBIERTA PIR', 'HCP', 'ACTIVO', NOW(), 1),
('HIANSA CUBIERTA PIR SEGUNDA', 'HCS', 'ACTIVO', NOW(), 1),
('HIANSA CUBIERTA PUR', 'HCU', 'ACTIVO', NOW(), 1),
('HIANSA FRIGO', 'HFG', 'ACTIVO', NOW(), 1),
('HIANSA MURO PIR', 'HMP', 'ACTIVO', NOW(), 1),
('HIANSA MURO PUR', 'HMU', 'ACTIVO', NOW(), 1),
('HIANSA MURO PUR SEGUNDA', 'HSE', 'ACTIVO', NOW(), 1),
('HIANSA TEJA PUR', 'HTP', 'ACTIVO', NOW(), 1),
('HIANSA TEJA PUR DESPINTADO', 'HTD', 'ACTIVO', NOW(), 1),
('ISOCOP', 'ISC', 'ACTIVO', NOW(), 1),
('ISOPARETE BOX', 'IBO', 'ACTIVO', NOW(), 1),
('MULTYMURO MESA', 'MMM', 'ACTIVO', NOW(), 1),
('MULTYTECHO', 'MUT', 'ACTIVO', NOW(), 1),
('PINTRO POLIESTER', 'PP', 'ACTIVO', NOW(), 1),
('PINTRO SULTANA', 'PS', 'ACTIVO', NOW(), 1),
('TIZACRIL POLIESTER BLANCO FRIO', 'PBF', 'ACTIVO', NOW(), 1),
('ZINTRO ALUM', 'ZA', 'ACTIVO', NOW(), 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);