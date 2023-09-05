ALTER TABLE `galvamex_appgalva`.`conceptogasto` 
CHANGE COLUMN `idConceptoGasto` `idTipoGasto` INT(11) NOT NULL AUTO_INCREMENT , RENAME TO  `galvamex_appgalva`.`tipogasto` ;


ALTER TABLE `galvamex_appgalva`.`conceptocomisionanticipada` 
CHANGE COLUMN `idConceptoComisionAnticipada` `idConceptoGasto` INT(11) NOT NULL , RENAME TO  `galvamex_appgalva`.`conceptogasto` ;


ALTER TABLE `galvamex_appgalva`.`gasto` 
CHANGE COLUMN `idConceptoGasto` `idTipoGasto` INT(11) NOT NULL ;

ALTER TABLE `galvamex_appgalva`.`objetivopromotor` 
ADD COLUMN `tipo` ENUM('M', 'T', 'A') NULL DEFAULT 'M' AFTER `idPromotor`;


insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (18,'T',2022,1,'14485916.36');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (10,'T',2022,1,'11550000');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (31,'T',2022,1,'7899369.28');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (33,'T',2022,1,'5953824.32');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (13,'T',2022,1,'4555108.48');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (11,'T',2022,1,'4439754.26');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (32,'T',2022,1,'2567920.87');

insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (18,'T',2022,2,'18279846.84');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (10,'T',2022,2,'14575000');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (31,'T',2022,2,'9968251.71');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (33,'T',2022,2,'7513159.26');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (13,'T',2022,2,'5748113.08');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (11,'T',2022,2,'5602547.05');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (32,'T',2022,2,'3240471.58');

insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (18,'T',2022,3,'17934944.07');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (10,'T',2022,3,'14300000');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (31,'T',2022,3,'9780171.48');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (33,'T',2022,3,'7371401.53');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (13,'T',2022,3,'5639658.12');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (11,'T',2022,3,'5496838.61');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (32,'T',2022,3,'3179330.61');

insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (18,'T',2022,4,'18279846.84');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (10,'T',2022,4,'14575000');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (31,'T',2022,4,'9968251.71');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (33,'T',2022,4,'7513159.26');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (13,'T',2022,4,'5748113.08');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (11,'T',2022,4,'5602547.05');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (32,'T',2022,4,'3240471.58');

insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (18,'A',2022,1,'68980554.11');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (10,'A',2022,1,'55000000');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (31,'A',2022,1,'37616044.17');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (33,'A',2022,1,'28351544.36');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (13,'A',2022,1,'21690992.76');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (11,'A',2022,1,'21141686.97');
insert into `objetivopromotor` (idPromotor, tipo, anio, mes, objetivo) values (32,'A',2022,1,'12228194.64');

ALTER TABLE `galvamex_appgalva`.`pedido` 
ADD COLUMN `idCorteComisionT` INT(11) NULL DEFAULT '0' AFTER `idCorteComisionVendedor`,
ADD COLUMN `idCorteComisionTVendedor` INT(11) NULL DEFAULT '0' AFTER `idCorteComisionT`,
ADD COLUMN `idCorteComisionA` INT(11) NULL DEFAULT '0' AFTER `idCorteComisionTVendedor`,
ADD COLUMN `idCorteComisionAVendedor` INT(11) NULL DEFAULT '0' AFTER `idCorteComisionA`;



ALTER TABLE `galvamex_appgalva`.`cortecomision` 
ADD COLUMN `tipo` ENUM('M', 'T', 'A') NULL DEFAULT 'M' AFTER `idCorteComision`,
ADD COLUMN `anio` INT(11) NULL DEFAULT '0' AFTER `tipo`,
ADD COLUMN `emes` INT(11) NULL DEFAULT '0' AFTER `anio`,
;



