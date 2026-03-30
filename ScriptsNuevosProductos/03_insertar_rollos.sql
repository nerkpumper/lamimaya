-- =============================================
-- ROLLOS
-- =============================================

INSERT INTO rollo (codigo, rollo_material_idMaterial, rollo_proveedor_idProveedor, 
                   calibre, pies, origen, descripcion, 
                   estado, fecha_creacion, id_usuario_creacion,
                   existencia, costokg)
SELECT * FROM (
SELECT 
    'RGA264NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CAL 26 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    1040.18 AS existencia, 
    24.41 AS costokg
UNION ALL
SELECT 
    'RGA244NTERG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO G37 CAL 24 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    24427.43 AS existencia, 
    23.92 AS costokg
UNION ALL
SELECT 
    'RGA224NTERG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CALIBRE 22 4 PIES TERNIUM G37' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    33785.94 AS existencia, 
    23.580000000000002 AS costokg
UNION ALL
SELECT 
    'RGA263NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CAL 26 3 PIES NACIONAL TERNIUM GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    -35.2 AS existencia, 
    24.88 AS costokg
UNION ALL
SELECT 
    'RGA243NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CALIBRE 24 DE 3 PIES GRADO 33 TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    17307.48 AS existencia, 
    24.38 AS costokg
UNION ALL
SELECT 
    'RGA204NTERG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    20.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CAL20 4 PIES NACIONAL TERNIUM GRADO 37' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    20790.100000000002 AS existencia, 
    23.34 AS costokg
UNION ALL
SELECT 
    'RGA223NTERG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO GALVANIZADO CAL 22 3.0 NACIONAL TERNIUM GRADO 37' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    24.03 AS costokg
UNION ALL
SELECT 
    'RGA244IHANG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO GALVANIZADO CAL 24 4.0 IMPORTADO HANWA GRADO 37' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    19022.29 AS existencia, 
    22.75 AS costokg
UNION ALL
SELECT 
    'RGA224IHANG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO GALVANIZADO CAL 22 4.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    34187.25 AS existencia, 
    20.55 AS costokg
UNION ALL
SELECT 
    'RGA204IHANG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    20.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO GALVANIZADO CAL 20 4.0 IMPORTADO HANWA GRADO 37' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    31.88 AS costokg
UNION ALL
SELECT 
    'RGALS224NTERG37' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'GALVANIZADO SEC' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'LOSACERO SEC. 25 TERNIUM CAL. 22 GALVANIZADO' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    71466.0 AS existencia, 
    20.94 AS costokg
UNION ALL
SELECT 
    'RPP262NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    2.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 26 2 PIES NACIONAL TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    32.37 AS costokg
UNION ALL
SELECT 
    'RPP243NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 24 3 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    6993.18 AS existencia, 
    30.830000000000002 AS costokg
UNION ALL
SELECT 
    'RPP223NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 22 3 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    175.08 AS existencia, 
    29.560000000000002 AS costokg
UNION ALL
SELECT 
    'RPP224NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 22 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    43980.63 AS existencia, 
    29.0 AS costokg
UNION ALL
SELECT 
    'RPP242NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    2.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 24 2 PIES NACIONAL TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    69896.54000000001 AS existencia, 
    31.71 AS costokg
UNION ALL
SELECT 
    'RPP263NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    3.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO CAL 26 3 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    50.7 AS costokg
UNION ALL
SELECT 
    'RPP204NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    20.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO CAL 20 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    14277.62 AS existencia, 
    28.7 AS costokg
UNION ALL
SELECT 
    'RPP264IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CALIBRE 26 DE 4 PIES GRADO 33 IMPORTACION HANWA' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    208333.2 AS existencia, 
    25.87 AS costokg
UNION ALL
SELECT 
    'RPP242IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    2.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 24 2 PIES HANWA GR33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    240120.32 AS existencia, 
    24.84 AS costokg
UNION ALL
SELECT 
    'RPP244IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 24 4 PIES IMP HANWA' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    135945.05 AS existencia, 
    24.63 AS costokg
UNION ALL
SELECT 
    'RPP262IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    2.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 26 2.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    75683.16 AS existencia, 
    24.85 AS costokg
UNION ALL
SELECT 
    'RPP224IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 22 4.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    14157.4 AS existencia, 
    23.18 AS costokg
UNION ALL
SELECT 
    'RPP223IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    22.0 AS calibre, 
    3.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 22 3.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    27531.63 AS existencia, 
    23.080000000000002 AS costokg
UNION ALL
SELECT 
    'RPP243IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    3.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 24 3.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    671.22 AS existencia, 
    24.5 AS costokg
UNION ALL
SELECT 
    'RPP264NKIOGRIG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    1 AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO GRIS KIOSKO CAL 26 4.0 NACIONAL GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    30.310000000000002 AS costokg
UNION ALL
SELECT 
    'RPP263.48NTERIIIG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    3.48 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO POLIESTER CALIBRE 26 DE 3.48 PIES TERNIUM COLOR NEGRO GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    0.0 AS existencia, 
    27.21 AS costokg
UNION ALL
SELECT 
    'RPP264IHANXIIG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 26 4.0 IMPORTADO ROJO JANITZIO GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    119731.44 AS existencia, 
    25.87 AS costokg
UNION ALL
SELECT 
    'RPP264ITEXAVEG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO POLIESTER' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TEXTURIZADOS' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO PINTRO POLIESTER CAL 26 4.0 IMPORTADO TEXTURIZADO GRADO 33 AVEJENTADO' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    10693.800000000001 AS existencia, 
    34.300000000000004 AS costokg
UNION ALL
SELECT 
    'RPS264NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO SULTANA' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO SULTANA CAL 26 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    231202.61000000002 AS existencia, 
    28.95 AS costokg
UNION ALL
SELECT 
    'RPS244NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'PINTRO SULTANA' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO PINTRO SULTANA CAL 24 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    48413.22 AS existencia, 
    28.35 AS costokg
UNION ALL
SELECT 
    'RZA242NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'ZINTRO ALUM' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    2.0 AS pies, 
    'N' AS origen, 
    'ROLLO ZINTRO ALUM CAL 24 2 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    5854.83 AS existencia, 
    26.51 AS costokg
UNION ALL
SELECT 
    'RZA244NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'ZINTRO ALUM' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO ZINTRO ALUM CAL 24 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    10250.02 AS existencia, 
    25.37 AS costokg
UNION ALL
SELECT 
    'RZA264NTERG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'ZINTRO ALUM' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'TERNIUM' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'N' AS origen, 
    'ROLLO ZINTRO ALUM CAL 26 4 PIES TERNIUM' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    70006.62 AS existencia, 
    25.900000000000002 AS costokg
UNION ALL
SELECT 
    'RZA264IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'ZINTRO ALUM' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    26.0 AS calibre, 
    4.0 AS pies, 
    'I' AS origen, 
    'ROLLO ZINTRO ALUM CALIBRE 26 DE 4 PIES IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    165644.67 AS existencia, 
    22.77 AS costokg
UNION ALL
SELECT 
    'RZA242IHANG33' AS codigo, 
    (SELECT idMaterial FROM material WHERE nombre = 'ZINTRO ALUM' LIMIT 1) AS rollo_material_idMaterial,
    (SELECT idProveedor FROM proveedor WHERE nombre = 'HANWA' LIMIT 1) AS rollo_proveedor_idProveedor,
    24.0 AS calibre, 
    2.0 AS pies, 
    'I' AS origen, 
    'ROLLO ZINTRO ALUM CAL 24 2.0 IMPORTADO HANWA GRADO 33' AS descripcion, 
    'ACTIVO' AS estado, 
    NOW() AS fecha_creacion, 
    1 AS id_usuario_creacion,
    77625.03 AS existencia, 
    22.5 AS costokg) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM rollo WHERE codigo = tmp.codigo);
