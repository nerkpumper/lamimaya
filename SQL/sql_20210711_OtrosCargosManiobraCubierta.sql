ALTER TABLE `galvamex_appgalva`.`otrocargo` 
ADD COLUMN `automatico` ENUM('SI', 'NO') NULL DEFAULT 'NO' AFTER `precioIngreso`;


INSERT INTO `galvamex_appgalva`.`otrocargo` (`descripcion`, `ingreso`, `solicitar`, `precioIngreso`, `automatico`) VALUES ('MANIOBRAS EN CUBIERTA', 'PESOS', '$', '1', 'SI');
