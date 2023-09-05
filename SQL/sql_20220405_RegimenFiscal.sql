CREATE TABLE `galvamex_appgalva`.`regimenfiscal` (
  `idRegimenFiscal` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(10) NULL DEFAULT '',
  `descripcion` VARCHAR(120) NULL DEFAULT '',
  `id_usuario_insert` INT NULL DEFAULT '0',
  `fecha_insert` DATETIME NULL DEFAULT '0000-00-00 00.00:00',
  `id_usuario_update` INT NULL DEFAULT '0',
  `fecha_update` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRegimenFiscal`),
  UNIQUE INDEX `idRegimenFiscal_UNIQUE` (`idRegimenFiscal` ASC),
  UNIQUE INDEX `regimenfiscal_codigo_UNIQUE` (`codigo` ASC)
  );


INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('00', '', 2, now(), 2, now());

INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('601', 'General de Ley Personas Morales', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('603', 'Personas Morales con Fines no Lucrativos', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('605', 'Sueldos y Salarios e Ingresos Asimilados a Salarios', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('606', 'Arrendamiento', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('607', 'Régimen de Enajenación o Adquisición de Bienes', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('608', 'Demás ingresos', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('610', 'Residentes en el Extranjero sin Establecimiento Permanente en México', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('611', 'Ingresos por Dividendos (socios y accionistas)', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('612', 'Personas Físicas con Actividades Empresariales y Profesionales', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('614', 'Ingresos por intereses', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('615', 'Régimen de los ingresos por obtención de premios', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('616', 'Sin obligaciones fiscales', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('620', 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('621', 'Incorporación Fiscal', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('622', 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('623', 'Opcional para Grupos de Sociedades', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('624', 'Coordinados', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('625', 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas', 2, now(), 2, now());
INSERT INTO regimenfiscal (codigo, descripcion, id_usuario_insert, fecha_insert, id_usuario_update, fecha_update) VALUES ('626', 'Régimen Simplificado de Confianza', 2, now(), 2, now());



ALTER TABLE `galvamex_appgalva`.`datosfacturacion` 
ADD COLUMN `idRegimenFiscal` INT(11) NULL DEFAULT '1' AFTER `idUsoCfdi`;
