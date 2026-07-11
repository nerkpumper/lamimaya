DELIMITER $$

CREATE FUNCTION fnGenerarDescAuto(
    pTipoProducto INT,
    pTipoNombre VARCHAR(70),
    pAplicacion VARCHAR(70),
    pMaterialId INT,
    pMaterial VARCHAR(70),
    pRolloId INT,
    pCalibreRollo INT,
    pPiesRollo DECIMAL(9,2),
    pProveedor VARCHAR(70),
    pGrado INT,
    pColorId INT,
    pColor VARCHAR(70),
    pUnidad VARCHAR(20),
    pDescripcion VARCHAR(255),
    pCalibre INT,
    pPies INT,
    pOrigen CHAR(1),
    pLongitud VARCHAR(20),
    pMedidaEspecial VARCHAR(45)
)
RETURNS VARCHAR(200)
DETERMINISTIC
BEGIN

    DECLARE vDesc VARCHAR(500);

    IF pTipoProducto = 4 THEN
        RETURN pDescripcion;
    END IF;

    SET vDesc = CONCAT(

        pTipoNombre,

        ' ',

        CASE
            WHEN pAplicacion LIKE '%PYC%'
            THEN ' PUNTAS Y COLAS '
            ELSE ''
        END,

        pAplicacion,

        ' ',

        pMaterial,

        CASE
            WHEN pMaterialId = 15 THEN '  '
            ELSE ' '
        END,

        CASE
            WHEN pCalibreRollo > 0 THEN CONCAT('CAL ',pCalibreRollo,' ')
            WHEN pCalibre > 0 THEN CONCAT('CAL ',pCalibre,' ')
            ELSE ''
        END,

        CASE
            WHEN pMaterialId = 15 THEN ' OZ '
            ELSE ''
        END,

        CASE
            WHEN pMedidaEspecial <> ''
            THEN CONCAT(
                    pMedidaEspecial,
                    CASE
                        WHEN pMaterialId IN (62,63)
                        THEN 'MM'
                        ELSE ''
                    END,
                    ' '
                 )
            ELSE ''
        END,

        CASE
            WHEN pPiesRollo>0 THEN pPiesRollo
            WHEN pPies>0 THEN pPies
            ELSE ''
        END,

        CASE
            WHEN pMaterialId IN (11,17,28,29,30,31,35,36,37,38)
                THEN ' PULGADAS'
            WHEN pPiesRollo>0 OR pPies>0
                THEN ' PIES'
            ELSE ''
        END,

        CASE
            WHEN pRolloId>1
                THEN CASE
                        WHEN pOrigen='N'
                        THEN ' NACIONAL '
                        ELSE ' IMPORTADO '
                     END
            ELSE ''
        END,

        pProveedor,

        CASE
            WHEN pGrado>0
                THEN CONCAT(' GRADO ',pGrado)
            ELSE ''
        END,

        CASE
            WHEN pColorId>1
                THEN CONCAT(' ',pColor)
            ELSE ''
        END,

        pLongitud,

        CASE
            WHEN pLongitud LIKE '%X%'
                THEN ''
            WHEN pLongitud<>''
                THEN CASE
                        WHEN pMaterialId IN (62,63)
                            THEN ' ML'
                        ELSE ' MTS'
                     END
            ELSE ''
        END,

        CASE
            WHEN pRolloId=1 THEN
                CASE
                    WHEN pOrigen='N'
                        THEN ' NACIONAL'
                    WHEN pMaterialId NOT IN (62,63)
                        THEN ' IMPORTADO'
                    ELSE ''
                END
            ELSE ''
        END

    );

    SET vDesc = REPLACE(vDesc,'-- NO APLICA --','');
    SET vDesc = REPLACE(vDesc,'--NO APLICA--','');
    SET vDesc = REPLACE(vDesc,'CAL 0.00','');
    SET vDesc = REPLACE(vDesc,'0.00 PIES','');
    SET vDesc = REPLACE(vDesc,'0.00 PULGADAS','');

    WHILE INSTR(vDesc,'  ')>0 DO
        SET vDesc = REPLACE(vDesc,'  ',' ');
    END WHILE;

    RETURN TRIM(vDesc);

END$$

DELIMITER ;

