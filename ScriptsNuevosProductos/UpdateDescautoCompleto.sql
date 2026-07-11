UPDATE producto p
INNER JOIN tipoproducto tp ON tp.idTipoProducto = p.producto_tipoProducto_idTipoProducto
INNER JOIN aplicacion a ON a.idAplicacion = p.producto_aplicacion_idAplicacion  
INNER JOIN material m ON m.idMaterial = p.producto_material_idMaterial
INNER JOIN viewrollos r ON r.idRollo = p.producto_rollo_idRollo
INNER JOIN color col ON col.idColor = r.idColor
INNER JOIN unidad u ON u.idUnidad = p.producto_unidad_idUnidad
SET p.descauto = 
    REPLACE(IF((tp.idTipoProducto = 4),
            p.descripcion,
            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(CONCAT(tp.nombre,
                                            ' ',
                                            IF((a.nombreAplicacion LIKE '%PYC%'),
                                                ' PUNTAS Y COLAS ',
                                                ''),
                                            a.nombreAplicacion,
                                            ' ',
                                            m.nombre,
                                            IF((m.idMaterial = 15), '  ', ' '),
                                            IF((r.calibre > 0),
                                                CONCAT('CAL ', r.calibre, ' '),
                                                IF((p.calibre > 0),
                                                    CONCAT(' CAL ', p.calibre, ' '),
                                                    '')),
                                            ' ',
                                            IF((m.idMaterial = 15),
                                                ' OZ ',
                                                '  '),
                                            IF((p.medidaespecial <> ''),
                                                CONCAT(' ', p.medidaespecial,IF(p.producto_material_idMaterial IN (62, 63) ,'MM','') ),
                                                ''),
                                            IF((r.pies > 0.0),
                                                r.pies,
                                                IF((p.pies > 0.0), p.pies, '')),
                                            IF(((m.idMaterial = 29)
                                                    OR (m.idMaterial = 17)
                                                    OR (m.idMaterial = 28)
                                                    OR (m.idMaterial = 31)
                                                    OR (m.idMaterial = 30)
                                                    OR (m.idMaterial = 11)
                                                    OR (m.idMaterial = 35)
                                                    OR (m.idMaterial = 36)
                                                    OR (m.idMaterial = 37)
                                                    OR (m.idMaterial = 38)),
                                                ' PULGADAS',
                                                IF(((r.pies > 0.0) OR (p.pies > 0.0)),
                                                    ' PIES ',
                                                    '')),
                                            IF((r.idRollo > 1),
                                                IF((p.origen = 1),
                                                    ' NACIONAL ',
                                                    ' IMPORTADO '),
                                                ''),
                                            r.proveedor,
                                            ' ',
                                            IF(((r.grado > 0)
                                                    AND (r.idRollo > 0)),
                                                CONCAT(' GRADO ', r.grado, ' '),
                                                ''),
                                            IF((r.idColor > 1),
                                                CONCAT(' ', col.nombre),
                                                ''),
                                            p.longitud,
                                            IF((p.longitud LIKE '%X%'),
                                                '',
                                                IF((p.longitud <> ''),
                                                    IF(p.producto_material_idMaterial IN (62, 63)  ,' ML',' MTS') , '')),
                                            IF((r.idRollo = 1),
                                                IF((p.origen = 1),
                                                    ' NACIONAL',
                                                    IF(p.producto_material_idMaterial IN (62, 63) ,' ','IMPORTADO')),
                                                '')),
                                    '-- NO APLICA --',
                                    ''),
                                '--NO APLICA--',
                                ''),
                            'CAL 0.00',
                            ''),
                        '0.00 PIES',
                        ''),
                    '  ',
                    ' '),
                '0.00 PULGADAS',
                '')),
        '  ',
        ' ')
        where descauto is null;