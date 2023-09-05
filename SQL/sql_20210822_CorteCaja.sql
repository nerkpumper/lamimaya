CREATE TABLE `galvamex_appgalva`.`cortecaja` (
  `idCorteCaja` INT NOT NULL AUTO_INCREMENT,
  `fondoCajaApertura` DECIMAL(15,2) NULL DEFAULT '0.0',
  `ventas` DECIMAL(15,2) NULL DEFAULT '0.0',
  `abonos` DECIMAL(15,2) NULL DEFAULT '0.0',
  `entradas` DECIMAL(15,2) NULL DEFAULT '0.0',
  `salidas` DECIMAL(15,2) NULL DEFAULT '0.0',
  `fondoCajaAlCorte` DECIMAL(15,2) NULL DEFAULT '0.0',
  `idSucursal` INT NULL DEFAULT '0',
  `id_usuario_apertura` INT NULL DEFAULT '0',
  `fecha_apertura` DATETIME NULL DEFAULT '0000-00-00 00.00:00',
  `id_usuario_corte` INT NULL DEFAULT '0',
  `fecha_corte` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCorteCaja`),
  UNIQUE INDEX `idCorteCaja_UNIQUE` (`idCorteCaja` ASC));


INSERT INTO `galvamex_appgalva`.`cortecaja` (`fondoCajaApertura`, `ventas`, `abonos`, `entradas`, `salidas`, `fondoCajaAlCorte`, `idSucursal`, 
`id_usuario_apertura`, `fecha_apertura`, `id_usuario_corte`, `fecha_corte`)
SELECT '0', '0', '0', '0', '0', '0', idSucursal, 
'2', '2021-01-01 00:00:00', '2', '2021-01-01 00:00:00' FROM sucursal WHERE visible = 'SI';


CREATE TABLE `galvamex_appgalva`.`conceptogasto` (
  `idConceptoGasto` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(70) NULL DEFAULT '',
  `id_usuario_insert` INT NULL DEFAULT '0',
  `fecha_insert` DATETIME NULL DEFAULT '0000-00-00 00.00:00',
  `id_usuario_update` INT NULL DEFAULT '0',
  `fecha_update` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idConceptoGasto`),
  UNIQUE INDEX `idConceptoGasto_UNIQUE` (`idConceptoGasto` ASC));


CREATE TABLE `galvamex_appgalva`.`gasto` (
  `idGasto` INT NOT NULL AUTO_INCREMENT,  
  `idConceptoGasto` INT NOT NULL,
  `idSucursal` INT NULL DEFAULT '0',
  `monto` DECIMAL(15,2) NULL DEFAULT '0.0',
  `id_usuario_insert` INT NULL DEFAULT '0',
  `fecha_insert` DATETIME NULL DEFAULT '0000-00-00 00.00:00',
  `id_usuario_update` INT NULL DEFAULT '0',
  `fecha_update` DATETIME NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idGasto`),
  UNIQUE INDEX `idGasto_UNIQUE` (`idGasto` ASC));


ALTER TABLE `galvamex_appgalva`.`gasto` 
ADD COLUMN `detalle` VARCHAR(70) NULL DEFAULT '' AFTER `monto`;


ALTER TABLE `galvamex_appgalva`.`cortecaja` 
ADD COLUMN `estado` ENUM('REALIZADO', 'ABIERTO') NULL DEFAULT 'ABIERTO' AFTER `idSucursal`;
