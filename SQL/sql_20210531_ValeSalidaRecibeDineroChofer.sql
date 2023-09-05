ALTER TABLE `valesalida` 
ADD COLUMN `chkRecibeDinero` ENUM('SI', 'NO') NULL DEFAULT 'NO' AFTER `chkImprimirPedidoNoSaldado`;
