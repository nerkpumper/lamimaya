DELIMITER $$

CREATE TRIGGER bi_producto_descauto
BEFORE INSERT ON producto
FOR EACH ROW
BEGIN

    DECLARE vTipo VARCHAR(70);
    DECLARE vAplicacion VARCHAR(70);
    DECLARE vMaterial VARCHAR(70);
    DECLARE vProveedor VARCHAR(70);
    DECLARE vColor VARCHAR(70);
    DECLARE vUnidad VARCHAR(20);

    DECLARE vCalibre INT;
    DECLARE vPies DECIMAL(9,2);
    DECLARE vGrado INT;
    DECLARE vColorId INT;
    DECLARE vRolloId INT;

    SELECT nombre
      INTO vTipo
      FROM tipoproducto
     WHERE idTipoProducto=NEW.producto_tipoProducto_idTipoProducto;

    SELECT nombreAplicacion
      INTO vAplicacion
      FROM aplicacion
     WHERE idAplicacion=NEW.producto_aplicacion_idAplicacion;

    SELECT nombre
      INTO vMaterial
      FROM material
     WHERE idMaterial=NEW.producto_material_idMaterial;

    SELECT nombre
      INTO vUnidad
      FROM unidad
     WHERE idUnidad=NEW.producto_unidad_idUnidad;

    SELECT
        r.idRollo,
        r.calibre,
        r.pies,
        r.grado,
        p.nombre,
        c.idColor,
        c.nombre
    INTO
        vRolloId,
        vCalibre,
        vPies,
        vGrado,
        vProveedor,
        vColorId,
        vColor
    FROM rollo r
    JOIN proveedor p
        ON p.idProveedor=r.rollo_proveedor_idProveedor
    JOIN color c
        ON c.idColor=r.rollo_color_idColor
    WHERE r.idRollo=NEW.producto_rollo_idRollo;

    SET NEW.descauto =
        fnGenerarDescAuto(
            NEW.producto_tipoProducto_idTipoProducto,
            vTipo,
            vAplicacion,
            NEW.producto_material_idMaterial,
            vMaterial,
            vRolloId,
            vCalibre,
            vPies,
            vProveedor,
            vGrado,
            vColorId,
            vColor,
            vUnidad,
            NEW.descripcion,
            NEW.calibre,
            NEW.pies,
            NEW.origen,
            NEW.longitud,
            NEW.medidaespecial
        );

END$$

DELIMITER ;


DROP TRIGGER IF EXISTS `mayamaria`.`producto_BEFORE_INSERT`;

DELIMITER $$

CREATE TRIGGER `producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW BEGIN
        DECLARE vp1 DOUBLE;
        DECLARE vp2 DOUBLE;
        DECLARE vp3 DOUBLE;
        DECLARE vp4 DOUBLE;
        DECLARE vpm DOUBLE;
        DECLARE vcu DOUBLE;
        DECLARE vpkg DOUBLE;
        
        -- Para descauto
        DECLARE vTipo VARCHAR(70);
        DECLARE vAplicacion VARCHAR(70);
        DECLARE vMaterial VARCHAR(70);
        DECLARE vProveedor VARCHAR(70);
        DECLARE vColor VARCHAR(70);
        DECLARE vUnidad VARCHAR(20);

        DECLARE vCalibre INT;
        DECLARE vPies DECIMAL(9,2);
        DECLARE vGrado INT;
        DECLARE vColorId INT;
        DECLARE vRolloId INT;
        
        IF NEW.producto_rollo_idrollo > 1 THEN
            IF NEW.tipoprecio = 'G' AND NEW.isRollo = '0' THEN        
                SELECT totalpreciovta, totalpreciovtar2, totalpreciovtar3, totalpreciovtar4, totalpreciomendez, pesocu, pesokgmt 
                        INTO vp1, vp2, vp3, vp4, vpm, vcu, vpkg
                FROM rollo 
                WHERE idrollo = NEW.producto_rollo_idrollo;
                IF NEW.producto_unidad_idunidad = 4 THEN
                    SET NEW.precio1 = vp1 * NEW.mlpieza;
                    SET NEW.precio2 = vp2 * NEW.mlpieza;
                    SET NEW.precio3 = vp3 * NEW.mlpieza;
                    SET NEW.precio4 = vp4 * NEW.mlpieza;
                    SET NEW.preciomendez = vpm * NEW.mlpieza;
                    SET NEW.costo =  vcu * vpkg * NEW.mlpieza;
                    
                    IF NEW.isSegunda = 'SI' THEN
                        SET NEW.precio1 = (vp1 * NEW.mlpieza)*.85;                        
                        SET NEW.precio2 = (vp1 * NEW.mlpieza)*.85;
                        SET NEW.precio3 = (vp1 * NEW.mlpieza)*.85;
                        SET NEW.precio4 = (vp1 * NEW.mlpieza)*.85;
                        SET NEW.preciomendez = (vp1 * NEW.mlpieza)*.85;
                        SET NEW.costo =  vcu * vpkg * NEW.mlpieza; 
                    END IF;                			
                ELSE
                    SET NEW.precio1 = vp1;                    
                    IF NEW.isRango = '1' THEN               
                        SET NEW.precio2 = vp2;
                        SET NEW.precio3 = vp3;
                        SET NEW.precio4 = vp4;
                        SET NEW.preciomendez = vpm;
                        SET NEW.costo =  vcu * vpkg;
                    END IF;
                
                    IF NEW.isSegunda = 'SI' THEN
                        SET NEW.precio1 = vp1*.85;                        
                        SET NEW.precio2 = vp1*.85;
                        SET NEW.precio3 = vp1*.85;
                        SET NEW.precio4 = vp1*.85;
                        SET NEW.preciomendez = (vp1 * NEW.mlpieza)*.85;
                        SET NEW.costo =  vcu * vpkg * NEW.mlpieza; 
                    END IF;
                END IF;			
            
                IF NEW.tipoRango = '' THEN
                    SET NEW.tipoRango = 'A';
                END IF;
            END IF;
            
            IF NEW.isRollo = '1' THEN        			 
                IF NEW.producto_tipoproducto_idtipoproducto = 5 THEN
                    SELECT preciokg1, preciokg2, preciokg3, preciokg4
                            INTO vp1, vp2, vp3, vp4
                    FROM rollo 
                    WHERE idrollo = NEW.producto_rollo_idrollo;
                    
                    SET NEW.precio1 = vp1;
                    SET NEW.precio2 = vp2;
                    SET NEW.precio3 = vp3;
                    SET NEW.precio4 = vp4;
                    
                    -- SET NEW.costo =  vcu * vpkg * NEW.mlpieza;
                    
                    
                    SET NEW.precio1 = vp1;                        
                    SET NEW.precio2 = vp2;
                    SET NEW.precio3 = vp3;
                    SET NEW.precio4 = vp4;
                    
                    -- SET NEW.costo =  vcu * vpkg * NEW.mlpieza; 				
                    
                
                END IF;			
            
            END IF;

            SELECT nombre
            INTO vTipo
            FROM tipoproducto
            WHERE idTipoProducto=NEW.producto_tipoProducto_idTipoProducto;

            SELECT nombreAplicacion
            INTO vAplicacion
            FROM aplicacion
            WHERE idAplicacion=NEW.producto_aplicacion_idAplicacion;

            SELECT nombre
            INTO vMaterial
            FROM material
            WHERE idMaterial=NEW.producto_material_idMaterial;

            SELECT descripcion
            INTO vUnidad
            FROM unidad
            WHERE idUnidad=NEW.producto_unidad_idUnidad;

            SELECT
                r.idRollo,
                r.calibre,
                r.pies,
                r.grado,
                p.nombre,
                c.idColor,
                c.nombre
            INTO
                vRolloId,
                vCalibre,
                vPies,
                vGrado,
                vProveedor,
                vColorId,
                vColor
            FROM rollo r
            JOIN proveedor p
                ON p.idProveedor=r.rollo_proveedor_idProveedor
            JOIN color c
                ON c.idColor=r.rollo_color_idColor
            WHERE r.idRollo=NEW.producto_rollo_idRollo;

            SET NEW.descauto =
                fnGenerarDescAuto(
                    NEW.producto_tipoProducto_idTipoProducto,
                    vTipo,
                    vAplicacion,
                    NEW.producto_material_idMaterial,
                    vMaterial,
                    vRolloId,
                    vCalibre,
                    vPies,
                    vProveedor,
                    vGrado,
                    vColorId,
                    vColor,
                    vUnidad,
                    NEW.descripcion,
                    NEW.calibre,
                    NEW.pies,
                    NEW.origen,
                    NEW.longitud,
                    NEW.medidaespecial
                );
        ELSE
            SET NEW.descauto = NEW.descripcion;
        END IF;
        SET NEW.lastUpdate = NOW();
        
        
        
    

END$$
DELIMITER ;
