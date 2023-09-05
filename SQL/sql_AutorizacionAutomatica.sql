ALTER TABLE `galvamex_appgalva`.`pedidostracking` 
ADD COLUMN `idRazonAutorizacionAutomatica` INT NULL DEFAULT '0' AFTER `idPedido`,
ADD COLUMN `tipoCliente` ENUM('NUEVO', 'EXISTENTE') NULL DEFAULT 'NUEVO' AFTER `idRazonAutorizacionAutomatica`,
ADD COLUMN `necesitaSurtir` ENUM('SI', 'NO') NULL DEFAULT 'NO' AFTER `tipoCliente`,
CHANGE COLUMN `msg` `json` VARCHAR(2000) NOT NULL DEFAULT '' ;


CREATE TABLE `galvamex_appgalva`.`razonautorizacionautomatica` (
  `idRazonAutorizacionAutomatica` INT NOT NULL AUTO_INCREMENT,
  `razonAutorizacion` VARCHAR(500) NULL DEFAULT '',
  PRIMARY KEY (`idRazonAutorizacionAutomatica`));


ALTER TABLE `galvamex_appgalva`.`pedidostracking` 
CHANGE COLUMN `tipoCliente` `tipoCliente` ENUM('NUEVO', 'EXISTENTE', 'ND') NULL DEFAULT 'NUEVO' ,
CHANGE COLUMN `necesitaSurtir` `necesitaSurtir` ENUM('SI', 'NO', 'ND') NULL DEFAULT 'NO' ;

ALTER TABLE `galvamex_appgalva`.`pedidostracking` 
ADD COLUMN `conCredito` ENUM('YES', 'NO', 'ND') NULL DEFAULT 'ND' AFTER `track`,
CHANGE COLUMN `tipoCliente` `tipoCliente` ENUM('NUEVO', 'EXISTENTE', 'ND') NULL DEFAULT 'ND' ,
CHANGE COLUMN `necesitaSurtir` `necesitaSurtir` ENUM('SI', 'NO', 'ND') NULL DEFAULT 'ND' ;


ALTER TABLE `galvamex_appgalva`.`pedidostracking` 
DROP COLUMN `conCredito`,
DROP COLUMN `necesitaSurtir`,
DROP COLUMN `tipoCliente`,
CHANGE COLUMN `idRazonAutorizacionAutomatica` `idPedidoTrace` INT(11) NULL DEFAULT '0' ;


ALTER TABLE `galvamex_appgalva`.`razonautorizacionautomatica` 
CHANGE COLUMN `idRazonAutorizacionAutomatica` `idPedidoTrace` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `razonAutorizacion` `trace` VARCHAR(500) NULL DEFAULT '' , RENAME TO  `galvamex_appgalva`.`pedidotrace` ;


INSERT INTO pedidotrace (trace) VALUES ('Inicia proceso de Autorización automática del Pedido');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, con crédito, se requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, que se cubra el 50% o más');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 25% de anticipo');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 25% de anticipo. Se debe consultar a crédito y cobranza');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, con crédito, no requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Saldo de crédito cubre pedido y no tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Crédito disponible no cubre el saldo del pedido');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Saldo de crédito suficiente para cubrir saldo de pedido y no tener pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, aprobado: Saldo de Pedido no mayor al 20% del crédito disponible y no tiene saldo vencido a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Saldo de pedido mayor al 20% al saldo disponible de crédito');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito y no tener pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, sin crédito, se requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Anticipo no cubre al menos el 50%');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, aprobado: Anticipo al menos del 25%');
INSERT INTO pedidotrace (trace) VALUES ('Anticipo del pedido menor a 25%');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, sin crédito, no requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Anticipo no cubre al menos el 50%');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Cubrir al menos el 50% de anticipo y no tener saldo vencido a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Opción 2 en caso de no cumplir el criterio principal: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido');
INSERT INTO pedidotrace (trace) VALUES ('El saldo de la capacidad de pago no cubre el saldo del pedido');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Anticipo del pedido menor a 25%');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Anticipo al menos del 25%, no tiene saldos vencidos a mas de 30 días, capacidad de pago cubre saldo de pedido');
INSERT INTO pedidotrace (trace) VALUES ('Cliente nuevo, sin crédito');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Anticipo al menos del 50%');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Anticipo al menos del 50%');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, aprobado: Cubrir al menos el 40% de anticipo');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Cubrir al menos el 40% de anticipo. Se debe consultar a crédito y cobranza');
INSERT INTO pedidotrace (trace) VALUES ('Cliente nuevo, se ha detectado crédito. No se continua con la validación de autorización automática');
INSERT INTO pedidotrace (trace) VALUES ('No se pudo obtener la información del cliente del pedido');
INSERT INTO pedidotrace (trace) VALUES ('Inicia proceso de liberación de vales automática del Pedido');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, con crédito, se requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, con crédito, no requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Saldo de crédito de pedidos entregados cubra el saldo del pedido y no tener pedidos vendidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, aprobado: Saldo del pedido no mayor a 20% del saldo de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Saldo de pedido mayor al 20% al saldo disponible de crédito de pedidos entregados');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Saldo de pedido no sea mayor al 20% al saldo disponible de crédito de pedidos entregados y no tener pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, sin crédito, se requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: En caso de requerir adquisición de materiales, cubrir el saldo restante. Se debe consultar a crédito y cobranza');
INSERT INTO pedidotrace (trace) VALUES ('Cliente existente, sin crédito, no requiere adquisición de materiales');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: En caso de no requerir adquisición de materiales, cubrir el saldo restante');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Cubrir el saldo restante del pedido');
INSERT INTO pedidotrace (trace) VALUES ('Opción 2 en caso de no cumplir el criterio principal: Saldo total de pedidos entregados más el saldo de este pedido no mayor a 25 000 y lo cubra de su capadidad de pago disponible y no tener pedidos vencidoas a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('El cliente tiene pedidos vencidos a mas de 30 días');
INSERT INTO pedidotrace (trace) VALUES ('Saldo total de pedidos entregados mas éste, mayor a 25 000 o su capacidad de pago no cubre dicho monto');
INSERT INTO pedidotrace (trace) VALUES ('Opción en caso de no cumplir criterio, NO aprobado: Saldo total de pedidos entregados más el saldo de este pedido mayor a 25 000 o dicho monto no lo cubre su capacidad de pago, no tener saldos vencidos a mas de 30 días. Se debe consultar a crédito y cobranza');
INSERT INTO pedidotrace (trace) VALUES ('Cliente nuevo');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación aprobado: Debe liquidar el pedido');
INSERT INTO pedidotrace (trace) VALUES ('Criterio para liberación NO aprobado: Debe liquidar el pedido');
INSERT INTO pedidotrace (trace) VALUES ('No se pudo obtener la información del cliente del pedido');
