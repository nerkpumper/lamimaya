-- notificacionescortes

CREATE TABLE `galvamex08`.`notificacionescortes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idSucursal` INT NULL,
  `fecha` DATETIME NULL,
  `turno` ENUM('M', 'V') NULL,
  PRIMARY KEY (`id`));
