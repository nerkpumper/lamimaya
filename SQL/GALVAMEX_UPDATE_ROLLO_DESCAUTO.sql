-- Poblar rollo.descauto usando la lógica de viewrollos
-- (misma fórmula que la columna calculada `descauto` de GALVAMEX_CREATEVIEWROLLOS.sql)
UPDATE rollo r
INNER JOIN material rm ON rm.idMaterial = r.rollo_material_idMaterial
INNER JOIN color col ON col.idColor = r.rollo_color_idColor
INNER JOIN proveedor rp ON rp.idProveedor = r.rollo_proveedor_idProveedor
SET r.descauto =
    IF((r.idRollo > 1),
        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(CONCAT('ROLLO ',
                                rm.nombre,
                                ' CAL ',
                                r.calibre,
                                ' ',
                                r.pies,
                                ' PIES ',
                                IF((r.origen = 'I'),
                                    ' IMPORTADO ',
                                    ' NACIONAL '),
                                rp.nombre,
                                IF((r.grado > 0),
                                    CONCAT(' GRADO ', r.grado),
                                    ''),
                                IF((r.rollo_color_idColor > 1),
                                    CONCAT(' ', col.nombre),
                                    '')),
                        '-- NO APLICA --',
                        ''),
                    '--NO APLICA--',
                    ''),
                'CAL 0',
                ''),
            '0 PIES',
            ''),
        '  ',
        ' '),
    '-- NO APLICA --')
WHERE r.descauto IS NULL;
