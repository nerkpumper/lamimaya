-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2023 at 12:16 PM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galvamex_appgalva`
--

-- --------------------------------------------------------

--
-- Table structure for table `aplicacion`
--

CREATE TABLE `aplicacion` (
  `idAplicacion` int(11) NOT NULL,
  `nombreAplicacion` varchar(70) DEFAULT NULL,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aportacionesmendez`
--

CREATE TABLE `aportacionesmendez` (
  `idAportacionMendez` int(11) NOT NULL,
  `monto` decimal(15,2) NOT NULL,
  `fecha_capturado` datetime NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cambioprecio`
--

CREATE TABLE `cambioprecio` (
  `idCambioPrecio` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `cambioPrecio_producto_idProducto` int(11) DEFAULT NULL,
  `noPrecio` int(11) DEFAULT 0,
  `precioAnterior` double DEFAULT 0,
  `precio` double DEFAULT 0,
  `idUsuario` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cambiopreciodobles`
--

CREATE TABLE `cambiopreciodobles` (
  `idCambioPrecioDobles` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `cambioPrecioDobles_precioXDobles_idPrecioXDobles` int(11) DEFAULT NULL,
  `dobleces` int(11) DEFAULT 0,
  `precioAnterior` double DEFAULT 0,
  `precio` double DEFAULT 0,
  `idUsuario` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(70) DEFAULT '',
  `apellidos` varchar(70) DEFAULT '',
  `empresa` varchar(70) DEFAULT '',
  `domicilio1` varchar(70) DEFAULT '',
  `domicilio2` varchar(70) DEFAULT '',
  `numero` varchar(45) DEFAULT '',
  `colonia` varchar(70) DEFAULT '',
  `ciudad` varchar(70) DEFAULT '',
  `telefonos` varchar(70) DEFAULT '',
  `email` varchar(70) DEFAULT '',
  `rfc` varchar(20) DEFAULT '',
  `idUsuarioPromotor` int(11) DEFAULT 1,
  `idPromotorAnterior` int(11) DEFAULT 0,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0,
  `porDescuento` double NOT NULL DEFAULT 0,
  `idUsoCfdi` int(11) DEFAULT 22,
  `credito` decimal(15,2) DEFAULT 0.00,
  `sumacreditorfc` decimal(15,2) DEFAULT 0.00,
  `capacidadPago` decimal(15,2) DEFAULT 25000.00,
  `sumacapacidadpagorfc` decimal(15,2) DEFAULT 0.00,
  `usado` double DEFAULT 0,
  `creditopromotor` double NOT NULL DEFAULT 0,
  `facturable` enum('SI','NO') DEFAULT 'NO',
  `razonsocial` varchar(250) DEFAULT '',
  `domiciliofiscal` varchar(250) DEFAULT '',
  `codigopostal` varchar(45) DEFAULT '',
  `codigopostalfiscal` varchar(45) DEFAULT '',
  `coloniafiscal` varchar(70) DEFAULT '',
  `numerofiscal` varchar(45) DEFAULT '',
  `ciudadfiscal` varchar(70) DEFAULT '',
  `saldarpedidoparaautorizar` enum('SI','NO') DEFAULT 'SI',
  `saldarpedidoparavalesalida` enum('SI','NO') DEFAULT 'NO',
  `samedata` enum('SI','NO') DEFAULT 'NO',
  `rangoCliente` enum('REGULAR','DISTINGUIDO','SELECT','PLATINO') DEFAULT 'REGULAR',
  `enviarPlanProteccion` enum('SI','NO') DEFAULT 'NO',
  `procesarCreditos` enum('NO','SI') DEFAULT 'NO',
  `fecha_ultimo_proceso` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `cliente`
--
DELIMITER $$
CREATE TRIGGER `cliente_BEFORE_INSERT` BEFORE INSERT ON `cliente` FOR EACH ROW BEGIN
	IF NEW.idUsuarioPromotor = 4  THEN
		SET NEW.idUsuarioPromotor = 1;
    END IF;
    SET NEW.capacidadPago = 0;
    SET NEW.idPromotorAnterior = NEW.idUsuarioPromotor;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `clientedatosfacturacion`
--

CREATE TABLE `clientedatosfacturacion` (
  `idClienteDatosFacturacion` int(1) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idDatosFacturacion` int(11) DEFAULT NULL,
  `fecha_insert` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_insert` int(11) DEFAULT 0,
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_update` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `idColor` int(11) NOT NULL,
  `nombre` varchar(70) DEFAULT '',
  `clave` varchar(5) DEFAULT '',
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_crea` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_crea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_modifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_baja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conceptogasto`
--

CREATE TABLE `conceptogasto` (
  `idConceptoGasto` int(11) NOT NULL,
  `nombre` varchar(70) DEFAULT NULL,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `idConfiguracion` int(11) NOT NULL,
  `rangoMetros1Inicio` double DEFAULT 0,
  `rangoMetros1Fin` double DEFAULT 0,
  `rangoMetros2Inicio` double DEFAULT 0,
  `rangoMetros2Fin` double DEFAULT 0,
  `rangoMetros3Inicio` double DEFAULT 0,
  `rangoMetros3Fin` double DEFAULT 0,
  `rangoMetros1AcryOpaInicio` double DEFAULT 0,
  `rangoMetros1AcryOpaFin` double DEFAULT 0,
  `rangoMetros2AcryOpaInicio` double DEFAULT 0,
  `rangoMetros2AcryOpaFin` double DEFAULT 0,
  `rangoMetros3AcryOpaInicio` double DEFAULT 0,
  `rangoMetros3AcryOpaFin` double DEFAULT 0,
  `rangoMetros1MultipanelInicio` double DEFAULT 0,
  `rangoMetros1MultipanelFin` double DEFAULT 0,
  `rangoMetros2MultipanelInicio` double DEFAULT 0,
  `rangoMetros2MultipanelFin` double DEFAULT 0,
  `rangoMetros3MultipanelInicio` double DEFAULT 0,
  `rangoMetros3MultipanelFin` double DEFAULT 0,
  `pesoXCalibre20` double DEFAULT 0,
  `pesoXCalibre22` double DEFAULT 0,
  `pesoXCalibre24` double DEFAULT 0,
  `pesoXCalibre26` double DEFAULT 0,
  `pesoXCalibre28` double DEFAULT 0,
  `pedidoDescuento` double DEFAULT 0,
  `comision1R1` double DEFAULT 0,
  `comision1R2` double DEFAULT 0,
  `comision1R3` double DEFAULT 0,
  `comision1R4` double DEFAULT 0,
  `comision2R1` double DEFAULT 0,
  `comision2R2` double DEFAULT 0,
  `comision2R3` double DEFAULT 0,
  `comision2R4` double DEFAULT 0,
  `comision3R1` double DEFAULT 0,
  `comision3R2` double DEFAULT 0,
  `comision3R3` double DEFAULT 0,
  `comision3R4` double DEFAULT 0,
  `lastCheckUpdatePrecios` datetime DEFAULT current_timestamp(),
  `lastIdPedidoChecked` int(11) DEFAULT 0,
  `rolloprodlastupdate` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_modificacion` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`idConfiguracion`, `rangoMetros1Inicio`, `rangoMetros1Fin`, `rangoMetros2Inicio`, `rangoMetros2Fin`, `rangoMetros3Inicio`, `rangoMetros3Fin`, `rangoMetros1AcryOpaInicio`, `rangoMetros1AcryOpaFin`, `rangoMetros2AcryOpaInicio`, `rangoMetros2AcryOpaFin`, `rangoMetros3AcryOpaInicio`, `rangoMetros3AcryOpaFin`, `rangoMetros1MultipanelInicio`, `rangoMetros1MultipanelFin`, `rangoMetros2MultipanelInicio`, `rangoMetros2MultipanelFin`, `rangoMetros3MultipanelInicio`, `rangoMetros3MultipanelFin`, `pesoXCalibre20`, `pesoXCalibre22`, `pesoXCalibre24`, `pesoXCalibre26`, `pesoXCalibre28`, `pedidoDescuento`, `comision1R1`, `comision1R2`, `comision1R3`, `comision1R4`, `comision2R1`, `comision2R2`, `comision2R3`, `comision2R4`, `comision3R1`, `comision3R2`, `comision3R3`, `comision3R4`, `lastCheckUpdatePrecios`, `lastIdPedidoChecked`, `rolloprodlastupdate`, `fecha_modificacion`, `id_usuario_modificacion`) VALUES
(1, 1, 749, 750, 1499, 1500, 999999, 1, 300, 301, 600, 601, 999999, 1, 300, 301, 600, 601, 999999, 9.07, 7.55, 5.38, 4.65, 3.93, 10, 2, 1.75, 1.5, 1.25, 2, 1.75, 1.5, 1.25, 1, 0.9, 0.8, 0.7, '2020-08-08 02:09:06', 0, '2023-08-24 09:19:59', '2022-01-04 15:30:25', 2);

--
-- Triggers `configuracion`
--
DELIMITER $$
CREATE TRIGGER `configuracion_AFTER_UPDATE` AFTER UPDATE ON `configuracion` FOR EACH ROW BEGIN
IF OLD.rangoMetros1Inicio <> NEW.rangoMetros1Inicio OR
   OLD.rangoMetros1Fin <> NEW.rangoMetros1Fin OR
   OLD.rangoMetros2Inicio <> NEW.rangoMetros2Inicio OR
   OLD.rangoMetros2Fin <> NEW.rangoMetros2Fin OR
   OLD.rangoMetros3Inicio <> NEW.rangoMetros3Inicio OR
   OLD.rangoMetros3Fin <> NEW.rangoMetros3Fin OR
   OLD.pesoXCalibre22 <> NEW.pesoXCalibre22 OR
   OLD.pesoXCalibre24 <> NEW.pesoXCalibre24 OR
   OLD.pesoXCalibre26 <> NEW.pesoXCalibre26 OR
   OLD.pesoXCalibre28 <> NEW.pesoXCalibre28 OR
   OLD.pedidoDescuento <> NEW.pedidoDescuento OR
   OLD.comision1R1 <> NEW.comision1R1 OR
   OLD.comision1R2 <> NEW.comision1R2 OR
   OLD.comision1R3 <> NEW.comision1R3 OR
   OLD.comision2R1 <> NEW.comision2R1 OR
   OLD.comision2R2 <> NEW.comision2R2 OR
   OLD.comision2R3 <> NEW.comision2R3 OR
   OLD.comision3R1 <> NEW.comision3R1 OR
   OLD.comision3R2 <> NEW.comision3R2 OR
   OLD.comision3R3 <> NEW.comision3R3 THEN
   INSERT INTO `configuracionlog`
		(`rangoMetros1Inicio`,
		`rangoMetros1Fin`,
		`rangoMetros2Inicio`,
		`rangoMetros2Fin`,
		`rangoMetros3Inicio`,
		`rangoMetros3Fin`,
		`pesoXCalibre22`,
		`pesoXCalibre24`,
		`pesoXCalibre26`,
		`pesoXCalibre28`,
        `pedidoDescuento`,
        `comision1R1`,
        `comision1R2`,
        `comision1R3`,
        `comision2R1`,
        `comision2R2`,
        `comision2R3`,
        `comision3R1`,
        `comision3R2`,
        `comision3R3`,
		`fecha_modificacion`,
		`id_usuario_modificacion`)
	VALUES
		(NEW.rangoMetros1Inicio,
		 NEW.rangoMetros1Fin,
		 NEW.rangoMetros2Inicio,
		 NEW.rangoMetros2Fin,
		 NEW.rangoMetros3Inicio,
		 NEW.rangoMetros3Fin,
		 NEW.pesoXCalibre22,
		 NEW.pesoXCalibre24,
		 NEW.pesoXCalibre26,
		 NEW.pesoXCalibre28,
         NEW.pedidoDescuento,
         NEW.comision1R1,
         NEW.comision1R2,
         NEW.comision1R3,
         NEW.comision2R1,
         NEW.comision2R2,
         NEW.comision2R3,
         NEW.comision3R1,
         NEW.comision3R2,
         NEW.comision3R3,
		 NEW.fecha_modificacion,
		 NEW.id_usuario_modificacion);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `configuracionlog`
--

CREATE TABLE `configuracionlog` (
  `idConfiguracionLog` int(11) NOT NULL,
  `rangoMetros1Inicio` double DEFAULT NULL,
  `rangoMetros1Fin` double DEFAULT NULL,
  `rangoMetros2Inicio` double DEFAULT NULL,
  `rangoMetros2Fin` double DEFAULT NULL,
  `rangoMetros3Inicio` double DEFAULT NULL,
  `rangoMetros3Fin` double DEFAULT NULL,
  `pesoXCalibre22` double DEFAULT 0,
  `pesoXCalibre24` double DEFAULT 0,
  `pesoXCalibre26` double DEFAULT 0,
  `pesoXCalibre28` double DEFAULT 0,
  `pedidoDescuento` double DEFAULT 0,
  `comision1R1` double DEFAULT 0,
  `comision1R2` double DEFAULT 0,
  `comision1R3` double DEFAULT 0,
  `comision2R1` double DEFAULT 0,
  `comision2R2` double DEFAULT 0,
  `comision2R3` double DEFAULT 0,
  `comision3R1` double DEFAULT 0,
  `comision3R2` double DEFAULT 0,
  `comision3R3` double DEFAULT 0,
  `fecha_modificacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_modificacion` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `correo`
--

CREATE TABLE `correo` (
  `idCorreo` int(11) NOT NULL,
  `idDe` int(11) DEFAULT 0,
  `idPara` int(11) DEFAULT 0,
  `tema` varchar(75) DEFAULT '',
  `contenido` text DEFAULT NULL,
  `estatus` enum('UNREAD','READ') DEFAULT 'UNREAD',
  `categoria` enum('BUZON','IMPORTANTE','ELIMINAR') DEFAULT 'BUZON',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `correo`
--
DELIMITER $$
CREATE TRIGGER `correo_BEFORE_INSERT` BEFORE INSERT ON `correo` FOR EACH ROW BEGIN
	SET NEW.fecha = getCurrentTimeStamp();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cortecaja`
--

CREATE TABLE `cortecaja` (
  `idCorteCaja` int(11) NOT NULL,
  `fondoCajaApertura` decimal(15,2) DEFAULT 0.00,
  `ventas` decimal(15,2) DEFAULT 0.00,
  `abonos` decimal(15,2) DEFAULT 0.00,
  `entradas` decimal(15,2) DEFAULT 0.00,
  `salidas` decimal(15,2) DEFAULT 0.00,
  `fondoCajaAlCorte` decimal(15,2) DEFAULT 0.00,
  `idSucursal` int(11) DEFAULT 0,
  `estado` enum('REALIZADO','ABIERTO') DEFAULT 'ABIERTO',
  `id_usuario_apertura` int(11) DEFAULT 0,
  `fecha_apertura` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_corte` int(11) DEFAULT 0,
  `fecha_corte` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cortecomision`
--

CREATE TABLE `cortecomision` (
  `idCorteComision` int(11) NOT NULL,
  `tipo` enum('M','T','A') DEFAULT 'M',
  `anio` int(11) DEFAULT 0,
  `mes` int(11) DEFAULT 0,
  `idPromotor` int(11) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `total` decimal(9,2) DEFAULT 0.00,
  `porcentajeObjetivoVenta` decimal(9,2) DEFAULT 0.00,
  `incentivo` decimal(9,2) DEFAULT 0.00,
  `comisionAdelantada` decimal(9,2) DEFAULT 0.00,
  `aPagar` decimal(9,2) DEFAULT 0.00,
  `saldo` decimal(9,2) DEFAULT 0.00,
  `fechaInicio` varchar(10) DEFAULT '',
  `fechaFin` varchar(10) DEFAULT '',
  `pagada` enum('NO','SI') DEFAULT 'NO',
  `fecha_pagada` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_pagada` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `cortecomision`
--
DELIMITER $$
CREATE TRIGGER `cortecomision_AFTER_INSERT` AFTER INSERT ON `cortecomision` FOR EACH ROW BEGIN
	IF NEW.saldo > 0 THEN
		insert into cxccortecomision (idcortecomision, idpromotor, movimiento, monto, saldoActual, observacion, fecha_movimiento, id_usuario_movimiento) 
			values (NEW.idCorteComision, NEW.idPromotor, 'PORPAGAR', NEW.saldo, '0', 'TOTAL A PAGAR EN LA COMISIÓN', NEW.fecha_creacion, NEW.id_usuario_creacion);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cortecomision_BEFORE_INSERT` BEFORE INSERT ON `cortecomision` FOR EACH ROW BEGIN
	IF NEW.aPagar > 0 THEN
		SET NEW.saldo = NEW.aPagar;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cortecomisionroofing`
--

CREATE TABLE `cortecomisionroofing` (
  `idCorteComisionRoofing` int(11) NOT NULL,
  `idPromotor` int(11) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `total` decimal(9,2) DEFAULT 0.00,
  `incentivo` decimal(9,2) DEFAULT 0.00,
  `comisionAdelantada` decimal(9,2) DEFAULT 0.00,
  `aPagar` decimal(9,2) DEFAULT 0.00,
  `saldo` decimal(9,2) DEFAULT 0.00,
  `fechaInicio` varchar(10) DEFAULT '',
  `fechaFin` varchar(10) DEFAULT '',
  `pagada` enum('NO','SI') DEFAULT 'NO',
  `fecha_pagada` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_pagada` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `cortecomisionroofing`
--
DELIMITER $$
CREATE TRIGGER `cortecomisionroofing_AFTER_INSERT` AFTER INSERT ON `cortecomisionroofing` FOR EACH ROW BEGIN
	IF NEW.saldo > 0 THEN
		insert into cxccortecomisionroofing (idcortecomisionroofing, idpromotor, movimiento, monto, saldoActual, observacion, fecha_movimiento, id_usuario_movimiento) 
			values (NEW.idCorteComisionRoofing, NEW.idPromotor, 'PORPAGAR', NEW.saldo, '0', 'TOTAL A PAGAR EN LA COMISIÓN', NEW.fecha_creacion, NEW.id_usuario_creacion);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cortecomisionroofing_BEFORE_INSERT` BEFORE INSERT ON `cortecomisionroofing` FOR EACH ROW BEGIN
		SET NEW.saldo = NEW.aPagar;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacion`
--

CREATE TABLE `cotizacion` (
  `idCotizacion` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT 0,
  `subtotal` double DEFAULT 0,
  `otrosCargos` decimal(15,2) DEFAULT 0.00,
  `iva` double DEFAULT 0,
  `porDecuento` double DEFAULT 0,
  `descuento` double DEFAULT 0,
  `total` decimal(15,2) DEFAULT 0.00,
  `porDescuento` double DEFAULT 0,
  `maxDescuentoIndividual` double DEFAULT 0,
  `descuentoIndividual` double DEFAULT 0,
  `anticipo` double DEFAULT 0,
  `estado` enum('CAPTURADO','AUTORIZADO','PRODUCCION','TERMINADO','ENTREGADO','CANCELADO') DEFAULT 'CAPTURADO',
  `idUsoCfdi` int(11) DEFAULT 22,
  `saldada` enum('SI','NO') DEFAULT 'NO',
  `fecha_saldada` datetime DEFAULT '0000-00-00 00:00:00',
  `observaciones` varchar(45) DEFAULT '',
  `fecha_capturado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_capturado` int(11) DEFAULT 0,
  `observacionCaptura` varchar(255) DEFAULT '',
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00',
  `fecha_descuento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_descuento` int(11) DEFAULT 0,
  `recogeentrega` enum('RECOGE','ENTREGA','OBRA') DEFAULT 'RECOGE',
  `tipoObra` enum('NINGUNO','PISO','CUBIERTA') DEFAULT 'NINGUNO',
  `personaEntrega` varchar(250) DEFAULT '',
  `domicilioEntrega` varchar(150) DEFAULT '',
  `numeroEntrega` varchar(45) DEFAULT '',
  `coloniaEntrega` varchar(70) DEFAULT '',
  `ciudadEntrega` varchar(70) DEFAULT '',
  `horaRecibe` varchar(50) DEFAULT '',
  `fechaCompromiso` datetime DEFAULT '0000-00-00 00:00:00',
  `fechaEntregaPorDefinir` enum('NS','NO','SI') DEFAULT 'NS',
  `fechaAbierta` enum('SI','NO') DEFAULT 'NO',
  `pedidoExpress` enum('SI','NO') DEFAULT 'NO',
  `tipo` enum('AT','D') DEFAULT 'AT',
  `fecha_limitepago` datetime DEFAULT '0000-00-00 00:00:00',
  `tipocliente` enum('NUEVO','CAUTIVO') DEFAULT 'NUEVO',
  `idPedido` int(11) DEFAULT 0,
  `idSucursalCapturado` int(11) DEFAULT 0,
  `idSucursalPreferenciaRecoge` int(11) DEFAULT 0,
  `rangosString` varchar(20) DEFAULT '',
  `rangoCliente` enum('REGULAR','DISTINGUIDO','SELECT','PLATINO') DEFAULT 'REGULAR',
  `fecha_autorizaimpresion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_autorizaimpresion` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `cotizacion`
--
DELIMITER $$
CREATE TRIGGER `cotizacion_BEFORE_INSERT` BEFORE INSERT ON `cotizacion` FOR EACH ROW BEGIN
	DECLARE vrangoCliente VARCHAR(20);
	SELECT rangoCliente INTO vrangoCliente
	FROM cliente WHERE idCliente = NEW.idCliente;
	SET NEW.rangoCliente = vrangoCliente;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cotizacion_BEFORE_UPDATE` BEFORE UPDATE ON `cotizacion` FOR EACH ROW BEGIN
	IF OLD.rangoCliente <> NEW.rangoCliente THEN
		
        IF NEW.rangoCliente = 'PLATINO' THEN			
            SET NEW.rangosString = '4444444444';
        ELSE
			IF NEW.rangoCliente = 'SELECT' THEN
				SET NEW.rangosString = '3333333333';
			ELSE
				IF NEW.rangoCliente = 'DISTINGUIDO' THEN
					SET NEW.rangosString = '2222222222';
				ELSE
					SET NEW.rangosString = '1111111111';
				END IF;
			END IF;
        END IF;
        
    
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cotizaciondetalle`
--

CREATE TABLE `cotizaciondetalle` (
  `idCotizacionDetalle` int(11) NOT NULL,
  `IdCotizacion` int(11) DEFAULT 0,
  `renglon` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `idRolloBase` int(11) DEFAULT 1,
  `tipoPrecio` enum('PRECIO','RANGO1','RANGO2','RANGO3','IMPORTADO','TERNIUM','MENDEZ','RANGO4') DEFAULT 'PRECIO',
  `tipoPrecioOriginal` enum('PRECIO','RANGO1','RANGO2','RANGO3','IMPORTADO','TERNIUM','MENDEZ','RANGO4') DEFAULT 'PRECIO',
  `comision` decimal(15,2) DEFAULT 0.00,
  `comisionOriginal` decimal(15,2) DEFAULT NULL,
  `partida` decimal(9,2) DEFAULT 0.00,
  `cantidad` decimal(9,2) DEFAULT 0.00,
  `cantidadReal` decimal(9,2) DEFAULT 0.00,
  `desarrollo` varchar(50) DEFAULT '',
  `dobleces` int(11) DEFAULT 0,
  `curvar` enum('SI','NO') DEFAULT 'NO',
  `curvatura` varchar(20) DEFAULT '',
  `precioUnitario` decimal(15,2) DEFAULT 0.00,
  `precioUnitarioOriginal` decimal(15,2) DEFAULT NULL,
  `total` double DEFAULT 0,
  `explotarUnidad` decimal(9,2) DEFAULT 0.00,
  `totalExplotar` decimal(9,2) DEFAULT 0.00,
  `pesoKiloML` double DEFAULT 0,
  `precio1` decimal(9,2) DEFAULT 0.00,
  `precio2` decimal(9,2) DEFAULT 0.00,
  `precio3` decimal(9,2) DEFAULT 0.00,
  `precio4` decimal(9,2) DEFAULT 0.00,
  `preciomendez` decimal(9,2) DEFAULT 0.00,
  `molLaminasATomar` int(11) DEFAULT 0,
  `molPrecioDobleces` decimal(15,2) DEFAULT 0.00,
  `molPrecioCorte` decimal(15,2) DEFAULT 0.00,
  `molIsScrap` enum('NO','SI') DEFAULT 'NO',
  `molTotalcmScrap` decimal(9,2) DEFAULT 0.00,
  `molDescMaquila` varchar(45) DEFAULT '',
  `molLongitudinal` enum('L','A') DEFAULT 'L',
  `molCalibre` varchar(5) DEFAULT '',
  `molIdMaterial` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cotizacionrechazada`
--

CREATE TABLE `cotizacionrechazada` (
  `idCotizacionRechazada` int(11) NOT NULL,
  `idCotizacion` int(11) NOT NULL,
  `idMotivoRechazo` int(11) NOT NULL,
  `fecha_rechazo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cxc`
--

CREATE TABLE `cxc` (
  `idCxc` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `idCliente` int(11) DEFAULT 0,
  `movimiento` enum('CARGO','ABONO') DEFAULT 'CARGO',
  `monto` decimal(15,2) DEFAULT 0.00,
  `saldoActual` decimal(15,2) DEFAULT 0.00,
  `isAnticipo` enum('SI','NO') DEFAULT 'NO',
  `cargoPorPedido` enum('SI','NO') DEFAULT 'NO',
  `formaPago` int(11) DEFAULT 0,
  `referencia` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0,
  `idReciboDinero` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `cxc`
--
DELIMITER $$
CREATE TRIGGER `cxc_AFTER_INSERT` AFTER INSERT ON `cxc` FOR EACH ROW BEGIN
	 DECLARE vsaldoPedido DOUBLE;
    DECLARE vsaldoPromotor DOUBLE;
    DECLARE vidPromotor DOUBLE;
    DECLARE vmontoAPromotor DOUBLE;
    DECLARE vSaldada VARCHAR(2);
	IF NEW.movimiento = 'CARGO' AND NEW.idPedido > 0 AND NEW.cargoPorPedido = 'NO' THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE pedido 
           SET saldo = saldo + NEW.monto
		 WHERE idPedido = NEW.idPedido;
         SET SQL_SAFE_UPDATES=1;
    END IF;
    IF NEW.movimiento = 'ABONO' AND NEW.idPedido > 0 THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE pedido 
           SET saldo = saldo - NEW.monto
		 WHERE idPedido = NEW.idPedido;
         SET SQL_SAFE_UPDATES=1;
    END IF;
    SELECT saldo , saldopromotor, saldada INTO vsaldoPedido, vsaldoPromotor,vSaldada
      FROM pedido            
      WHERE idPedido = NEW.idPedido;
	IF NEW.movimiento = 'ABONO' AND vsaldoPedido <= 0.0 AND vSaldada = 'NO' THEN
		UPDATE pedido 
           SET saldada = 'SI', fecha_saldada = NOW()
		 WHERE idPedido = NEW.idPedido;
    END IF;
    IF NEW.movimiento = 'ABONO' AND vsaldoPromotor > 0 THEN
        select idusuariopromotor INTO vidPromotor
		  from cliente
          where idcliente = NEW.idCliente;
		IF NEW.monto > vsaldoPromotor THEN
			INSERT INTO cxcpromotor (idPedido, idCliente, movimiento, 
                            monto,
							formaPago, referencia, fecha_movimiento, id_usuario_movimiento)
			VALUES (NEW.idPedido, NEW.idCliente, NEW.movimiento, 
					vsaldoPromotor, 
					NEW.formaPago, NEW.referencia, NEW.fecha_movimiento, NEW.id_usuario_movimiento);
		ELSE
			INSERT INTO cxcpromotor (idPedido, idCliente, movimiento, 
                            monto,
							formaPago, referencia, fecha_movimiento, id_usuario_movimiento)
			VALUES (NEW.idPedido, NEW.idCliente, NEW.movimiento, 
					NEW.monto, 
					NEW.formaPago, NEW.referencia, NEW.fecha_movimiento, NEW.id_usuario_movimiento);
        END IF;
    END IF;
    IF NEW.idPedido > 0 AND NEW.movimiento = 'ABONO' THEN
    	UPDATE cliente SET procesarCreditos = 'SI' WHERE idCliente = NEW.idCliente;  
        
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxc_BEFORE_DELETE` BEFORE DELETE ON `cxc` FOR EACH ROW BEGIN
	INSERT INTO cxcdeleted (idCxc, idPedido, idCliente, movimiento, 
                            monto, saldoActual, isAnticipo, cargoPorPedido, 
							formaPago, referencia, fecha_movimiento, id_usuario_movimiento)
		VALUES (OLD.idCxc, OLD.idPedido, OLD.idCliente, OLD.movimiento, 
                OLD.monto, OLD.saldoActual, OLD.isAnticipo, OLD.cargoPorPedido, 
				OLD.formaPago, OLD.referencia, OLD.fecha_movimiento, OLD.id_usuario_movimiento);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxc_BEFORE_INSERT` BEFORE INSERT ON `cxc` FOR EACH ROW BEGIN
	DECLARE vsaldoNota DECIMAL(9,2);
    SET vsaldoNota = getSaldoPedido(NEW.idPedido);
	SET NEW.saldoActual = vsaldoNota;
	/* 2086 GALVAMEX Consumo Interno */
    IF NEW.idCliente = 2086 AND NEW.movimiento = 'CARGO' THEN
		SET NEW.monto = 0;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cxccortecomision`
--

CREATE TABLE `cxccortecomision` (
  `idCxcCorteComision` int(11) NOT NULL,
  `idCorteComision` int(11) DEFAULT 0,
  `idPromotor` int(11) DEFAULT 0,
  `movimiento` enum('PORPAGAR','PAGO') DEFAULT 'PORPAGAR',
  `monto` decimal(9,2) DEFAULT 0.00,
  `saldoActual` decimal(9,2) DEFAULT 0.00,
  `observacion` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `cxccortecomision`
--
DELIMITER $$
CREATE TRIGGER `cxccortecomision_AFTER_INSERT` AFTER INSERT ON `cxccortecomision` FOR EACH ROW BEGIN
	DECLARE vsaldoPedido DOUBLE;    
    IF NEW.movimiento = 'PAGO' AND NEW.idCorteComision > 0 THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE cortecomision
           SET saldo = saldo - NEW.monto
		 WHERE idCorteComision = NEW.idCorteComision;
         SET SQL_SAFE_UPDATES=1;
    END IF;
    SELECT saldo INTO vsaldoPedido
      FROM cortecomision            
      WHERE idCorteComision = NEW.idCorteComision;
	IF vsaldoPedido <= 0.0 THEN
		UPDATE cortecomision 
           SET pagada = 'SI', fecha_pagada = NOW(), id_usuario_pagada = NEW.id_usuario_movimiento
		 WHERE idCorteComision = NEW.idCorteComision;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxccortecomision_BEFORE_INSERT` BEFORE INSERT ON `cxccortecomision` FOR EACH ROW BEGIN
	DECLARE vsaldoNota DECIMAL(9,2);
    SET vsaldoNota = getSaldoCorteComision(NEW.idCorteComision);
	SET NEW.saldoActual = vsaldoNota;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cxccortecomisionroofing`
--

CREATE TABLE `cxccortecomisionroofing` (
  `idCxcCorteComisionRoofing` int(11) NOT NULL,
  `idCorteComisionRoofing` int(11) DEFAULT 0,
  `idPromotor` int(11) DEFAULT 0,
  `movimiento` enum('PORPAGAR','PAGO') DEFAULT 'PORPAGAR',
  `monto` decimal(9,2) DEFAULT 0.00,
  `saldoActual` decimal(9,2) DEFAULT 0.00,
  `observacion` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `cxccortecomisionroofing`
--
DELIMITER $$
CREATE TRIGGER `cxccortecomisionroofing_AFTER_INSERT` AFTER INSERT ON `cxccortecomisionroofing` FOR EACH ROW BEGIN
	DECLARE vsaldoPedido DOUBLE;    
    IF NEW.movimiento = 'PAGO' AND NEW.idCorteComisionRoofing > 0 THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE cortecomisionroofing
           SET saldo = saldo - NEW.monto
		 WHERE idCorteComisionRoofing = NEW.idCorteComisionRoofing;
         SET SQL_SAFE_UPDATES=1;
    END IF;
    SELECT saldo INTO vsaldoPedido
      FROM cortecomisionroofing            
      WHERE idCorteComisionRoofing = NEW.idCorteComisionRoofing;
	IF vsaldoPedido <= 0.0 THEN
		UPDATE cortecomisionroofing 
           SET pagada = 'SI', fecha_pagada = NOW(), id_usuario_pagada = NEW.id_usuario_movimiento
		 WHERE idCorteComisionRoofing = NEW.idCorteComisionRoofing;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxccortecomisionroofing_BEFORE_INSERT` BEFORE INSERT ON `cxccortecomisionroofing` FOR EACH ROW BEGIN
	DECLARE vsaldoNota DECIMAL(9,2);
    SET vsaldoNota = getSaldoCorteComisionRoofing(NEW.idCorteComisionRoofing);
	SET NEW.saldoActual = vsaldoNota;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cxccuentacomision`
--

CREATE TABLE `cxccuentacomision` (
  `idCxcCuentaComision` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `tipo` enum('DEDUCIR','PAGAR','INCENTIVO') DEFAULT 'DEDUCIR',
  `idConceptoGasto` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `monto` decimal(9,2) DEFAULT 0.00,
  `observacion` varchar(255) DEFAULT '',
  `idCorteComision` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cxccuentacomisionroofing`
--

CREATE TABLE `cxccuentacomisionroofing` (
  `idCxcCuentaComisionRoofing` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `tipo` enum('DEDUCIR','PAGAR','INCENTIVO') DEFAULT 'DEDUCIR',
  `idConceptoGasto` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `monto` decimal(9,2) DEFAULT 0.00,
  `observacion` varchar(255) DEFAULT '',
  `idCorteComisionRoofing` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cxcdeleted`
--

CREATE TABLE `cxcdeleted` (
  `idCxc` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `idCliente` int(11) DEFAULT 0,
  `movimiento` enum('CARGO','ABONO') DEFAULT 'CARGO',
  `monto` decimal(9,2) DEFAULT 0.00,
  `saldoActual` decimal(9,2) DEFAULT 0.00,
  `isAnticipo` enum('SI','NO') DEFAULT 'NO',
  `cargoPorPedido` enum('SI','NO') DEFAULT 'NO',
  `formaPago` int(11) DEFAULT 0,
  `referencia` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cxcpromotor`
--

CREATE TABLE `cxcpromotor` (
  `idCxcPromotor` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `idCliente` int(11) DEFAULT 0,
  `movimiento` enum('CARGO','ABONO') DEFAULT 'CARGO',
  `monto` decimal(9,2) DEFAULT 0.00,
  `saldoActual` decimal(9,2) DEFAULT 0.00,
  `formaPago` int(11) DEFAULT 0,
  `referencia` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `cxcpromotor`
--
DELIMITER $$
CREATE TRIGGER `cxcpromotor_AFTER_INSERT` AFTER INSERT ON `cxcpromotor` FOR EACH ROW BEGIN
	DECLARE vsaldoPedido DOUBLE;
	IF NEW.movimiento = 'CARGO' AND NEW.idPedido > 0 THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE pedido 
           SET saldopromotor = saldopromotor + NEW.monto
		 WHERE idPedido = NEW.idPedido;
         SET SQL_SAFE_UPDATES=1;
    END IF;
    IF NEW.movimiento = 'ABONO' AND NEW.idPedido > 0 THEN
		SET SQL_SAFE_UPDATES=0;
		UPDATE pedido 
           SET saldopromotor = saldopromotor - NEW.monto
		 WHERE idPedido = NEW.idPedido;
         SET SQL_SAFE_UPDATES=1;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxcpromotor_BEFORE_DELETE` BEFORE DELETE ON `cxcpromotor` FOR EACH ROW BEGIN
	INSERT INTO cxcpromotordeleted (idCxcPromotor, idPedido, idCliente, movimiento, 
                            monto, saldoActual, 
							formaPago, referencia, fecha_movimiento, id_usuario_movimiento)
		VALUES (OLD.idCxcPromotor, OLD.idPedido, OLD.idCliente, OLD.movimiento, 
                OLD.monto, OLD.saldoActual, 
				OLD.formaPago, OLD.referencia, OLD.fecha_movimiento, OLD.id_usuario_movimiento);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cxcpromotor_BEFORE_INSERT` BEFORE INSERT ON `cxcpromotor` FOR EACH ROW BEGIN
	DECLARE vsaldoNota DECIMAL(9,2);
    SET vsaldoNota = getSaldoPromotorPedido(NEW.idPedido);
	SET NEW.saldoActual = vsaldoNota;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cxcpromotordeleted`
--

CREATE TABLE `cxcpromotordeleted` (
  `idCxcPromotor` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `idCliente` int(11) DEFAULT 0,
  `movimiento` enum('CARGO','ABONO') DEFAULT 'CARGO',
  `monto` decimal(9,2) DEFAULT 0.00,
  `saldoActual` decimal(9,2) DEFAULT 0.00,
  `formaPago` int(11) DEFAULT 0,
  `referencia` varchar(70) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `datosfacturacion`
--

CREATE TABLE `datosfacturacion` (
  `idDatosFacturacion` int(11) NOT NULL,
  `rfc` varchar(20) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `razonSocial` varchar(250) DEFAULT '',
  `domicilio` varchar(250) DEFAULT '',
  `codigoPostal` varchar(20) DEFAULT '',
  `colonia` varchar(70) DEFAULT '',
  `numero` varchar(20) DEFAULT '',
  `ciudad` varchar(70) DEFAULT '',
  `idUsoCfdi` int(11) DEFAULT NULL,
  `idRegimenFiscal` int(11) DEFAULT 1,
  `credito` decimal(15,2) DEFAULT 0.00,
  `capacidadPago` decimal(15,2) DEFAULT 0.00,
  `privado` enum('SI','NO') DEFAULT 'SI',
  `fecha_insert` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_insert` int(11) DEFAULT 0,
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_update` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `espesor`
--

CREATE TABLE `espesor` (
  `idEspesor` int(5) NOT NULL,
  `calibre` int(5) NOT NULL,
  `cm` decimal(10,5) NOT NULL,
  `mm` decimal(10,4) NOT NULL,
  `pulgada` varchar(50) NOT NULL,
  `onzas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorito`
--

CREATE TABLE `favorito` (
  `idFavorito` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `favorito` enum('SI','NO') DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `formapago`
--

CREATE TABLE `formapago` (
  `idFormaPago` int(11) NOT NULL,
  `clave` varchar(3) DEFAULT NULL,
  `descripcion` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gasto`
--

CREATE TABLE `gasto` (
  `idGasto` int(11) NOT NULL,
  `idTipoGasto` int(11) NOT NULL,
  `idSucursal` int(11) DEFAULT 0,
  `monto` decimal(15,2) DEFAULT 0.00,
  `detalle` varchar(70) DEFAULT '',
  `id_usuario_insert` int(11) DEFAULT 0,
  `fecha_insert` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_update` int(11) DEFAULT 0,
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `incentivo`
--

CREATE TABLE `incentivo` (
  `idIncentivo` int(11) NOT NULL,
  `inicio` double(15,2) DEFAULT NULL,
  `fin` double(15,2) DEFAULT NULL,
  `porcentaje` double(9,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventariosucursal`
--

CREATE TABLE `inventariosucursal` (
  `idInventarioSucursal` int(11) NOT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `existencia` decimal(9,2) DEFAULT NULL,
  `apartado` decimal(9,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invzmov`
--

CREATE TABLE `invzmov` (
  `idInvzmov` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT 0,
  `documento` enum('PEDIDO','OC','NINGUNO','REGISTROPRODUCCION','TRANSFERENCIA') DEFAULT 'NINGUNO',
  `referencia` varchar(20) DEFAULT NULL,
  `movimiento` enum('ENTRADA','SALIDA') DEFAULT NULL,
  `salidaDespacho` enum('SI','NO') DEFAULT 'NO',
  `existenciaProducto` decimal(9,2) DEFAULT 0.00,
  `existenciaProductoSucursal` decimal(9,2) DEFAULT 0.00,
  `cantidad` decimal(9,2) DEFAULT 0.00,
  `observaciones` varchar(255) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idRemisionRollo` int(11) DEFAULT 0,
  `idSucursal` int(11) DEFAULT 1,
  `isML` enum('SI','NO') DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `invzmov`
--
DELIMITER $$
CREATE TRIGGER `invzmov_AFTER_INSERT` AFTER INSERT ON `invzmov` FOR EACH ROW BEGIN
/* 
INSERT INTO invzstocknorollo (idRemisionRollo, idProducto, existencia) VALUES ();
*/
	DECLARE vidInvzStockNoRollo INTEGER;
    SET vidInvzStockNoRollo = 0;
    /*SELECT IFNULL(idInvzStockNoRollo,0) INTO vidInvzStockNoRollo
     FROM invzstocknorollo
	 WHERE idProducto = NEW.idProducto
       AND idRemisionRollo = NEW.idRemisionRollo;*/
       SELECT IFNULL(idInvzStockNoRollo,0) INTO vidInvzStockNoRollo
     FROM invzstocknorollo
	 WHERE idProducto = NEW.idProducto
       AND idRemisionRollo = 0;
    IF NEW.movimiento = 'ENTRADA' THEN
		UPDATE producto 
           SET existencia = existencia + NEW.cantidad
		 WHERE idProducto = NEW.idProducto;
         UPDATE inventariosucursal
		   SET existencia = existencia + NEW.cantidad
		WHERE idproducto = NEW.idProducto
          AND idSucursal = NEW.idSucursal;
         IF vidInvzStockNoRollo > 0 THEN
			UPDATE invzstocknorollo 
               SET existencia = existencia + NEW.cantidad
			 WHERE idInvzStockNoRollo = vidInvzStockNoRollo;
         ELSE
			INSERT INTO invzstocknorollo (idRemisionRollo, idProducto, existencia) VALUES (NEW.idRemisionRollo, NEW.idProducto, NEW.cantidad);
         END IF;
    ELSE
		IF NEW.idPedidoDetalle > 0 THEN
			IF NEW.isML = 'NO' THEN
				UPDATE pedidodetalle
				   SET explotadoReal = explotadoReal + NEW.cantidad,
					   partidadespachada = partidadespachada + NEW.cantidad,
					   fecha_despachado = NEW.fecha_movimiento, 
					   id_usuario_despachado = NEW.id_usuario_movimiento,
                       idSucursalDespachado = NEW.idSucursal
				 WHERE idPedidoDetalle = NEW.idPedidoDetalle AND idProducto = NEW.idProducto; 
                 UPDATE pedidodetallecolocacion
				   SET cantidadSurtida = cantidadSurtida + NEW.cantidad
				 WHERE idPedidoDetalle = NEW.idPedidoDetalle AND idSucursal = NEW.idSucursal; 
			ELSE
				UPDATE pedidodetalle
				   SET explotadoReal = explotadoReal + (NEW.cantidad / cantidadReal),
					   partidadespachada = partidadespachada + (NEW.cantidad / cantidadReal),
					   fecha_despachado = NEW.fecha_movimiento, 
					   id_usuario_despachado = NEW.id_usuario_movimiento,
                       idSucursalDespachado = NEW.idSucursal
				 WHERE idPedidoDetalle = NEW.idPedidoDetalle AND idProducto = NEW.idProducto; 
                 UPDATE pedidodetallecolocacion
				   SET cantidadSurtida = cantidadSurtida + (NEW.cantidad)
				 WHERE idPedidoDetalle = NEW.idPedidoDetalle AND idSucursal = NEW.idSucursal; 
            END IF;
        END IF;
		IF NEW.salidaDespacho = 'NO' THEN	
			UPDATE producto 
			   SET existencia = existencia - NEW.cantidad
		     WHERE idProducto = NEW.idProducto;
			UPDATE inventariosucursal
			   SET existencia = existencia - NEW.cantidad
			 WHERE idproducto = NEW.idProducto
			   AND idSucursal = NEW.idSucursal;
		ELSE
			/* Si no es moldura, entonces actualizar las existencias. */
			IF NEW.idProducto <> 9 THEN
				UPDATE producto 
				   SET existencia = existencia - NEW.cantidad, apartado = apartado - NEW.cantidad, apartadoReal = apartadoReal - NEW.cantidad
				 WHERE idProducto = NEW.idProducto;
                 UPDATE inventariosucursal
					SET existencia = existencia - NEW.cantidad,
                        apartado = apartado - NEW.cantidad
					WHERE idproducto = NEW.idProducto
					  AND idSucursal = NEW.idSucursal;
            END IF;
		END IF;
        IF vidInvzStockNoRollo > 0 THEN
			UPDATE invzstocknorollo 
               SET existencia = existencia - NEW.cantidad
			 WHERE idInvzStockNoRollo = vidInvzStockNoRollo;
         ELSE
			INSERT INTO invzstocknorollo (idRemisionRollo, idProducto, existencia) VALUES (NEW.idRemisionRollo, NEW.idProducto, NEW.cantidad * -1);
         END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `invzmov_BEFORE_INSERT` BEFORE INSERT ON `invzmov` FOR EACH ROW BEGIN
	DECLARE vExistenciaProducto DOUBLE;
    DECLARE vExistenciaProductoSucursal DOUBLE;
    DECLARE vidTipoProducto INT;
    DECLARE vidUnidad INT;
    DECLARE vidRollo INT;
    IF NEW.idSucursal = 0 THEN
        SET NEW.idSucursal = 1;
    END IF;
	SELECT existencia, 
		producto_tipoproducto_idTipoProducto,
		producto_unidad_idUnidad,
	    producto_rollo_idRollo INTO vExistenciaProducto, vidTipoProducto, vidUnidad, vidRollo                
      FROM producto
	 WHERE idProducto = NEW.idProducto;
     IF vidTipoProducto = 1 AND vidUnidad = 1 AND vidRollo = 1 THEN
		SET NEW.isML = 'SI';
	 ELSE
		SET NEW.isML = 'NO';
     END IF;
     SELECT existencia INTO vExistenciaProductoSucursal
      FROM inventariosucursal
	 WHERE idProducto = NEW.idProducto
	   AND idSucursal = NEW.idSucursal;
     SET NEW.existenciaProducto = vExistenciaProducto;
     SET NEW.existenciaProductoSucursal = vExistenciaProductoSucursal;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invzmovnorollo`
--

CREATE TABLE `invzmovnorollo` (
  `idinvzmovnorollo` int(11) NOT NULL,
  `idRemisionRollo` int(11) DEFAULT NULL,
  `almacenOrigen` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','OBRA','DELTA','LAGOS','TRANSITO') DEFAULT NULL,
  `almacenDestino` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','OBRA','DELTA','LAGOS','TRANSITO') DEFAULT NULL,
  `fecha_movimiento` datetime DEFAULT NULL,
  `id_usuario_movimiento` int(11) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `invzmovnorollo`
--
DELIMITER $$
CREATE TRIGGER `invzmovnorollo_AFTER_INSERT` AFTER INSERT ON `invzmovnorollo` FOR EACH ROW BEGIN
	update remisionrollo set almacen = NEW.almacenDestino where idremisionrollo = NEW.idRemisionRollo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invzmovrollo`
--

CREATE TABLE `invzmovrollo` (
  `idInvzmovRollo` int(11) NOT NULL,
  `idRollo` int(11) DEFAULT 0,
  `idRemisionRollo` int(11) DEFAULT 0,
  `documento` enum('PEDIDO','OC','REMISION','NINGUNO') DEFAULT 'NINGUNO',
  `referencia` varchar(20) DEFAULT NULL,
  `movimiento` enum('ENTRADA','SALIDA') DEFAULT NULL,
  `salidaDespacho` enum('SI','NO') DEFAULT 'NO',
  `existenciaRollo` decimal(9,2) DEFAULT 0.00,
  `existenciaNoRollo` decimal(9,2) DEFAULT 0.00,
  `cantidad` decimal(9,2) DEFAULT 0.00,
  `observaciones` varchar(255) DEFAULT '',
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idRegistroProduccion` int(11) DEFAULT 0,
  `idRegistroProduccionDetalle` int(11) DEFAULT 0,
  `idSucursal` int(11) DEFAULT 1,
  `piezas` decimal(9,2) DEFAULT 0.00,
  `isRPParaMoldura` enum('SI','NO') DEFAULT 'NO',
  `descontarDePiezas` enum('SI','NO') DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `invzmovrollo`
--
DELIMITER $$
CREATE TRIGGER `invzmovrollo_AFTER_INSERT` AFTER INSERT ON `invzmovrollo` FOR EACH ROW BEGIN
	DECLARE vIdRollo INT;
    SELECT remisionRollo_rollo_idRollo INTO vIdRollo 
      FROM remisionrollo
	 WHERE idRemisionRollo = NEW.idRemisionRollo;
    IF NEW.movimiento = 'ENTRADA' THEN
		UPDATE rollo 
           SET existencia = existencia + NEW.cantidad
		 WHERE idRollo = vIdRollo;
         IF NEW.idRegistroProduccion > 0 THEN
			IF NEW.idRemisionRollo > 0 THEN
				UPDATE remisionrollo
				   SET existencia = existencia + NEW.cantidad
				 WHERE idRemisionRollo = NEW.idRemisionRollo;
			END IF;
         END IF;
    ELSE
		IF NEW.idRemisionRollo > 0 THEN
			UPDATE remisionrollo
			   SET existencia = existencia - NEW.cantidad
			 WHERE idRemisionRollo = NEW.idRemisionRollo;
        END IF;
        IF NEW.idPedidoDetalle > 0 AND NEW.isRPParaMoldura = 'NO' THEN
        		IF NEW.descontarDePiezas = 'NO' THEN
					UPDATE pedidodetalle
					   SET explotadoReal = explotadoReal + NEW.cantidad,				   
						   fecha_despachado = NEW.fecha_movimiento, 	
		                   id_usuario_despachado = NEW.id_usuario_movimiento,
		                   idSucursalDespachado = NEW.idSucursal
					 WHERE idPedidoDetalle = NEW.idPedidoDetalle;
				ELSE
					UPDATE pedidodetalle
					   SET explotadoReal = explotadoReal + NEW.piezas ,				   
						   fecha_despachado = NEW.fecha_movimiento, 	
		                   id_usuario_despachado = NEW.id_usuario_movimiento,
		                   idSucursalDespachado = NEW.idSucursal
					 WHERE idPedidoDetalle = NEW.idPedidoDetalle;
				END IF;
             UPDATE pedidodetallecolocacion
				   SET cantidadSurtida = cantidadSurtida + NEW.piezas
				 WHERE idPedidoDetalle = NEW.idPedidoDetalle AND idSucursal = NEW.idSucursal;
        END IF;
		IF NEW.salidaDespacho = 'NO' THEN
			UPDATE rollo 
			   SET existencia = existencia - NEW.cantidad
		     WHERE idRollo = vIdRollo;
		ELSE
			UPDATE rollo
			   SET existencia = existencia - NEW.cantidad, apartado = apartado - NEW.cantidad
		     WHERE idRollo = vIdRollo;
		END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `invzmovrollo_BEFORE_INSERT` BEFORE INSERT ON `invzmovrollo` FOR EACH ROW BEGIN
	DECLARE vExistenciaRollo DOUBLE;
    DECLARE vExistenciaNoRollo DOUBLE;
    IF NEW.idSucursal = 0 THEN
    	SET NEW.idSucursal = 1;
    END IF;
	SELECT existencia INTO vExistenciaRollo 
      FROM rollo
	 WHERE idRollo = NEW.idRollo;
	IF NEW.idRemisionRollo > 0 THEN
		 IF NEW.movimiento = 'ENTRADA'  THEN
			IF NEW.idRegistroProduccion = 0 THEN
				SELECT existencia INTO vExistenciaNoRollo 
				FROM remisionrollo
				WHERE idRemisionRollo = NEW.idRemisionRollo;
				SET NEW.existenciaNoRollo = vExistenciaNoRollo - NEW.cantidad;		
			ELSE
				SET NEW.existenciaNoRollo = vExistenciaNoRollo;		
			END IF;
		END IF ;
		SELECT existencia INTO vExistenciaNoRollo 
		FROM remisionrollo
		WHERE idRemisionRollo = NEW.idRemisionRollo;
		SET NEW.existenciaNoRollo = vExistenciaNoRollo;		
     END IF;
     SET NEW.existenciaRollo = vExistenciaRollo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invzstocknorollo`
--

CREATE TABLE `invzstocknorollo` (
  `idInvzStockNoRollo` int(11) NOT NULL,
  `idRemisionRollo` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `existencia` double DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invzstocknorolloback`
--

CREATE TABLE `invzstocknorolloback` (
  `idInvzStockNoRollo` int(11) NOT NULL DEFAULT 0,
  `idRemisionRollo` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `existencia` double DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `listaprecio`
--

CREATE TABLE `listaprecio` (
  `idListaPrecio` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_inicio` int(11) DEFAULT 0,
  `fecha_fin` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_fin` int(11) DEFAULT 0,
  `estado` enum('ACTUAL','ANTERIOR') DEFAULT 'ACTUAL'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `listaprecio`
--
DELIMITER $$
CREATE TRIGGER `listaprecio_AFTER_UPDATE` AFTER UPDATE ON `listaprecio` FOR EACH ROW BEGIN
	IF NEW.estado = 'ANTERIOR' AND OLD.estado = 'ACTUAL' THEN
        insert into listapreciodetalle (idListaPrecio, idProducto, costo, precio1, precio2, precio3) 
			select NEW.idListaPrecio, idProducto, '0', precio1, precio2, precio3 
			from producto 
			where estado = 'ACTIVO';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `listapreciodetalle`
--

CREATE TABLE `listapreciodetalle` (
  `idListaPrecioDetalle` int(11) NOT NULL,
  `idListaPrecio` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `costo` decimal(9,2) DEFAULT 0.00,
  `precio1` decimal(9,2) DEFAULT 0.00,
  `precio2` decimal(9,2) DEFAULT 0.00,
  `precio3` decimal(9,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `idMaterial` int(11) NOT NULL,
  `nombre` varchar(70) CHARACTER SET latin1 DEFAULT '',
  `clave` varchar(3) CHARACTER SET latin1 DEFAULT '',
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `motivorechazo`
--

CREATE TABLE `motivorechazo` (
  `idMotivoRechazo` int(11) NOT NULL,
  `motivo` varchar(70) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movrecibodinero`
--

CREATE TABLE `movrecibodinero` (
  `idmovReciboDinero` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idReciboDinero` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `saldoAnterior` decimal(9,2) NOT NULL,
  `saldoActual` decimal(9,2) NOT NULL,
  `monto` decimal(9,2) NOT NULL DEFAULT 0.00,
  `fecha_movimiento` datetime NOT NULL,
  `id_usuario_movimiento` int(11) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `movimiento` enum('GENERARECIBO','USADOENPEDIDO','REGRESARDINEROACLIENTE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `movrecibodinero`
--
DELIMITER $$
CREATE TRIGGER `movrecibodinero_AFTER_UPDATE` BEFORE INSERT ON `movrecibodinero` FOR EACH ROW BEGIN
IF(NEW.movimiento = 'GENERARECIBO')THEN
UPDATE recibodinero 
SET monto = NEW.monto,
        disponible = NEW.monto
        WHERE  idReciboDinero = NEW.idReciboDinero;
END IF;
IF(NEW.movimiento = 'USADOENPEDIDO')THEN
UPDATE recibodinero 
SET disponible = disponible - NEW.monto
WHERE  idReciboDinero = NEW.idReciboDinero;
END IF;
IF(NEW.movimiento ='REGRESARDINEROACLIENTE')THEN 
UPDATE recibodinero 
SET disponible = 0 
WHERE  recibodinero.idReciboDinero = NEW.idReciboDinero;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `movrecibodinero_BEFORE_INSERT` BEFORE INSERT ON `movrecibodinero` FOR EACH ROW BEGIN
    DECLARE vIdCliente INT;
    DECLARE vSaldoActual INT;
SELECT idCliente INTO vIdcliente FROM `recibodinero` where idReciboDinero = NEW.idReciboDinero;
Set vSaldoActual = getSaldoActualReciboDinero(vIdCliente);
IF(NEW.movimiento = 'GENERARECIBO')THEN
SET new.saldoAnterior = vSaldoActual;
SET new.SaldoActual= vSaldoActual + new.monto;
END IF;
IF(NEW.movimiento = 'USADOENPEDIDO')THEN
SET new.saldoAnterior = vSaldoActual;
SET new.SaldoActual= vSaldoActual - new.monto;
END IF;
IF(NEW.movimiento = 'REGRESADINEROACLIENTE')THEN
SET new.saldoAnterior = vSaldoActual;
SET new.SaldoActual= vSaldoActual - new.monto;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `movsapartado`
--

CREATE TABLE `movsapartado` (
  `idMosvApartado` int(11) NOT NULL,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT NULL,
  `tipo` enum('APARTADO','DESAPARTADO') DEFAULT NULL,
  `cantidad` decimal(9,2) DEFAULT NULL,
  `kg` decimal(9,2) DEFAULT 0.00,
  `fecha_movimiento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_movimiento` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notificacion`
--

CREATE TABLE `notificacion` (
  `idNotificacion` int(11) NOT NULL,
  `idProvoca` int(11) DEFAULT 0,
  `idPara` int(11) DEFAULT 0,
  `tema` varchar(70) DEFAULT '',
  `contenido` varchar(255) DEFAULT '',
  `leido` enum('SI','NO') DEFAULT 'NO',
  `borrar` enum('SI','NO') DEFAULT 'NO',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `notificacion`
--
DELIMITER $$
CREATE TRIGGER `notificacion_BEFORE_INSERT` BEFORE INSERT ON `notificacion` FOR EACH ROW BEGIN
	SET NEW.fecha = getCurrentTimeStamp();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notificacionescortes`
--

CREATE TABLE `notificacionescortes` (
  `id` int(11) NOT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `turno` enum('M','V') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `objetivopromotor`
--

CREATE TABLE `objetivopromotor` (
  `idObjetivoPromotor` int(11) NOT NULL,
  `idPromotor` int(11) DEFAULT 0,
  `tipo` enum('M','T','A') DEFAULT 'M',
  `anio` int(11) DEFAULT 0,
  `mes` int(11) DEFAULT 0,
  `objetivo` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otrocargo`
--

CREATE TABLE `otrocargo` (
  `idOtroCargo` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT '',
  `ingreso` enum('PESOS','OTRO') DEFAULT 'PESOS',
  `solicitar` varchar(45) DEFAULT '$',
  `precioIngreso` decimal(9,2) DEFAULT 1.00,
  `automatico` enum('SI','NO') DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otromotivodescripcion`
--

CREATE TABLE `otromotivodescripcion` (
  `IdOtroMotivoDescripcion` int(11) NOT NULL,
  `idCotizacionRechazada` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otroscargoscotizacion`
--

CREATE TABLE `otroscargoscotizacion` (
  `idOtrosCargosCotizacion` int(11) NOT NULL,
  `idCotizacion` int(11) NOT NULL DEFAULT 0,
  `idotrocargo` int(11) NOT NULL DEFAULT 0,
  `cantidadIngreso` decimal(15,2) NOT NULL DEFAULT 0.00,
  `monto` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otroscargospedido`
--

CREATE TABLE `otroscargospedido` (
  `idOtrosCargosPedido` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `idOtroCargo` int(11) DEFAULT 0,
  `cantidadIngreso` decimal(15,2) DEFAULT 0.00,
  `monto` decimal(15,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT 0,
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `otrosCargos` decimal(15,2) DEFAULT 0.00,
  `iva` decimal(9,2) DEFAULT 0.00,
  `porDecuento` decimal(9,2) DEFAULT 0.00,
  `descuento` decimal(9,2) DEFAULT 0.00,
  `total` decimal(15,2) DEFAULT 0.00,
  `porDescuento` decimal(9,2) DEFAULT 0.00,
  `maxDescuentoIndividual` double DEFAULT 0,
  `descuentoIndividual` double DEFAULT 0,
  `anticipo` double DEFAULT 0,
  `saldo` decimal(15,2) DEFAULT 0.00,
  `totalcte` double DEFAULT 0,
  `saldocte` double DEFAULT 0,
  `totalpromotor` decimal(9,2) DEFAULT 0.00,
  `saldopromotor` decimal(9,2) DEFAULT 0.00,
  `estado` enum('CAPTURADO','AUTORIZADO','PRODUCCION','TERMINADO','ENRUTA','ENTREGADO','CANCELADO') DEFAULT 'CAPTURADO',
  `explotado` enum('NO','SI') DEFAULT 'NO',
  `explotadook` enum('NO','SI') DEFAULT 'NO',
  `despachado` enum('SI','NO') DEFAULT 'NO',
  `idUsoCfdi` int(11) DEFAULT 22,
  `solicitaFactura` enum('NO','SI') DEFAULT 'NO',
  `facturado` enum('NO','SI') DEFAULT 'NO',
  `fecha_solicitafactura` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_solicitafactura` int(11) DEFAULT 0,
  `factura` varchar(50) DEFAULT '0',
  `fecha_factura` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_factura` int(11) DEFAULT 0,
  `saldada` enum('SI','NO') DEFAULT 'NO',
  `fecha_saldada` datetime DEFAULT '0000-00-00 00:00:00',
  `idComision` int(11) DEFAULT 0,
  `idCorteComision` int(11) DEFAULT 0,
  `idCorteComisionVendedor` int(11) DEFAULT 0,
  `idCorteComisionT` int(11) DEFAULT 0,
  `idCorteComisionTVendedor` int(11) DEFAULT 0,
  `idCorteComisionA` int(11) DEFAULT 0,
  `idCorteComisionAVendedor` int(11) DEFAULT 0,
  `comisionpagada` enum('SI','NO') DEFAULT 'NO',
  `observaciones` varchar(45) DEFAULT '',
  `fecha_capturado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_capturado` int(11) DEFAULT 0,
  `observacionCaptura` varchar(255) DEFAULT '',
  `autorizacxc` enum('NO','SI') DEFAULT 'NO',
  `fecha_autorizado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_autorizado` int(11) DEFAULT 0,
  `tipoAutorizacion` enum('NINGUNO','AUTOMATICO','CXC','PROMO','PROMO4050') DEFAULT 'NINGUNO',
  `observacionAutoriza` varchar(250) DEFAULT '',
  `fecha_produccion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_produccion` int(11) DEFAULT 0,
  `fecha_terminado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_terminado` int(11) DEFAULT 0,
  `fecha_entregado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_entregado` int(11) DEFAULT 0,
  `fecha_cancelado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_cancelado` int(11) DEFAULT 0,
  `observacionCancela` varchar(250) DEFAULT '',
  `fecha_descuento` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_descuento` int(11) DEFAULT 0,
  `listo_para_producir` enum('NO','SI') DEFAULT 'NO',
  `recogeentrega` enum('RECOGE','ENTREGA','OBRA') DEFAULT 'RECOGE',
  `tipoObra` enum('NINGUNO','PISO','CUBIERTA') DEFAULT 'NINGUNO',
  `personaEntrega` varchar(250) DEFAULT '',
  `domicilioEntrega` varchar(150) DEFAULT '',
  `numeroEntrega` varchar(45) DEFAULT '',
  `coloniaEntrega` varchar(70) DEFAULT '',
  `ciudadEntrega` varchar(70) DEFAULT '',
  `horaRecibe` varchar(50) DEFAULT '',
  `fechaCompromiso` datetime DEFAULT '0000-00-00 00:00:00',
  `fechaEntregaPorDefinir` enum('NS','NO','SI') DEFAULT 'NS',
  `fechaAbierta` enum('SI','NO') DEFAULT 'NO',
  `pedidoExpress` enum('SI','NO') DEFAULT 'NO',
  `tipo` enum('AT','D') DEFAULT 'AT',
  `generarValeSalida` enum('NO','AUNNO','SI') DEFAULT 'NO',
  `observacion_aunno` varchar(250) DEFAULT '',
  `fecha_limitepago` datetime DEFAULT '0000-00-00 00:00:00',
  `tipocliente` enum('NUEVO','CAUTIVO') DEFAULT 'NUEVO',
  `idcotizacion` int(11) DEFAULT 0,
  `idSucursalCapturado` int(11) DEFAULT 0,
  `colocado` enum('SI','NO') DEFAULT 'NO',
  `colocadoAutomatico` enum('SI','NO') DEFAULT 'NO',
  `idSucursalPreferenciaRecoge` int(11) DEFAULT 0,
  `idCCRoofing` int(11) DEFAULT 0,
  `idCCRoofingVendedor` int(11) DEFAULT 0,
  `despieceTerminado` enum('SI','NO') DEFAULT 'NO',
  `planProteccion` enum('SI','NO') DEFAULT 'NO',
  `checarAutorizacion` enum('SI','NO') DEFAULT 'NO',
  `tipoRuta` enum('SINRUTA','ENRUTA','REENRUTAR') DEFAULT 'SINRUTA',
  `idRutaEnvio` int(11) DEFAULT 0,
  `id_usuario_enruta` int(11) DEFAULT 0,
  `fecha_enruta` datetime DEFAULT '0000-00-00 00:00:00',
  `rangosString` varchar(20) DEFAULT '',
  `fecha_updateprecios` datetime DEFAULT '0000-00-00 00:00:00',
  `desbloqueadoPreciosAdmin` enum('SI','NO') DEFAULT 'NO',
  `apartarMercancia` enum('SI','NO') DEFAULT 'SI',
  `idClienteDatosFacturacion` int(11) DEFAULT 0,
  `liberaVales` enum('SI','NO') DEFAULT 'NO',
  `id_usuario_libera_vales` int(11) DEFAULT 0,
  `fecha_libera_vales` datetime DEFAULT '0000-00-00 00:00:00',
  `observacionLiberaVales` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `pedido`
--
DELIMITER $$
CREATE TRIGGER `pedido_AFTER_INSERT` AFTER INSERT ON `pedido` FOR EACH ROW BEGIN
	DECLARE vnombreCliente VARCHAR(100);
    DECLARE vidUsuarioPromotor INTEGER;
    IF NEW.idCliente > 0 THEN
		UPDATE cliente SET porDescuento = 0 WHERE idCliente = NEW.idCliente;
    END IF;
    SELECT idUsuarioPromotor INTO vidUsuarioPromotor FROM cliente WHERE idCliente = NEW.idCliente;
    SELECT concat(nombre, ' ', apellidos) INTO vnombreCliente
     FROM cliente
	WHERE idCliente = NEW.idCliente;
    IF NEW.idCliente = 137  THEN
		INSERT INTO cxc (idPedido, idCliente, movimiento, monto, isAnticipo, cargoPorPedido, formapago, referencia, fecha_movimiento, id_usuario_movimiento)
			VALUES (NEW.idPedido, NEW.idCliente, 'CARGO', NEW.total, 'NO', 'SI', 0, 'CARGO POR PEDIDO MDM' , NEW.fecha_capturado, NEW.id_usuario_capturado);
    ELSE
		INSERT INTO cxc (idPedido, idCliente, movimiento, monto, isAnticipo, cargoPorPedido, formapago, referencia, fecha_movimiento, id_usuario_movimiento)
			VALUES (NEW.idPedido, NEW.idCliente, 'CARGO', NEW.total, 'NO', 'SI', 0, 'CARGO POR PEDIDO' , NEW.fecha_capturado, NEW.id_usuario_capturado);
    END IF;
         IF NEW.estado = 'AUTORIZADO' AND NEW.tipoAutorizacion = 'AUTOMATICO' THEN
            IF vidUsuarioPromotor = NEW.id_usuario_capturado THEN            
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido Autorizado para su producción.'), NEW.idPedido);
            ELSE
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, vidUsuarioPromotor, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido Autorizado para su producción.'), NEW.idPedido);
				INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
					VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido Autorizado para su producción.'), NEW.idPedido);
			END IF;
         END IF;
     UPDATE cliente SET usado = getCreditoUsadoCliente(NEW.idCliente), procesarCreditos = 'SI' WHERE idCliente = NEW.idCliente;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pedido_AFTER_UPDATE` AFTER UPDATE ON `pedido` FOR EACH ROW BEGIN
	DECLARE vidPromotor INTEGER;
    DECLARE vsucursales VARCHAR(255);
    SELECT idUsuarioPromotor INTO vidPromotor
     FROM cliente
	WHERE idCliente = NEW.idCliente;
	-- IF OLD.estado = 'CAPTURADO' AND NEW.estado = 'AUTORIZADO' THEN	
			/*INSERT INTO notificacion (idProvoca, idPara, tema, contenido) 
				VALUES (NEW.id_usuario_autorizado, 4, concat('Pedido ', NEW.idPedido ,' Autorizado'), concat('Ha Autorizado el [PED_AI]',NEW.idPedido,'[PED_AT]',NEW.idPedido,'[PED_AF]. Si puede producirse podrá pasarlo a PRODUCCIÓN.')); */
			-- IF OLD.saldada = 'NO' AND NEW.saldada = 'SI' THEN
			-- 	IF vidPromotor = NEW.id_usuario_capturado THEN            
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
			-- 	ELSE
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado en automatico por haber sido saldado.'), NEW.idPedido);
			-- 	END IF;
            -- ELSE
			-- 	IF vidPromotor = NEW.id_usuario_capturado THEN            
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
			-- 	ELSE
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
			-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
			-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' AUTORIZADO'), concat('El pedido ', NEW.idPedido,' ha sido autorizado.'), NEW.idPedido);
			-- 	END IF;
            -- END IF;
	-- END IF;
    IF OLD.colocado = 'SI' AND NEW.colocado = 'NO' THEN	
			SET SQL_SAFE_UPDATES = 0;
			delete from pedidodetallecolocacion 
            where idpedidodetalle in (SELECT idpedidodetalle FROM pedidodetalle where idpedido = NEW.idPedido);       
            IF NEW.idPedido > 1 THEN
				delete from valesalidadetalle where idpedido = NEW.idPedido;
                delete from valesalida where idpedido = NEW.idPedido;
                delete from valesalidapromotordetalle where idpedido = NEW.idPedido;
                delete from valesalidapromotor where idpedido = NEW.idPedido;
            END IF;
            SET SQL_SAFE_UPDATES = 1;
	END IF;
    -- IF OLD.colocado = 'NO' AND NEW.colocado = 'SI' THEN	
		-- SET vsucursales = '';
		-- select GROUP_CONCAT(distinct sucursal.nombre  SEPARATOR ', ') into vsucursales
		-- 	from pedidodetallecolocacion
		-- 	inner join sucursal on pedidodetallecolocacion.idsucursal = sucursal.idsucursal
		-- 	where idpedidodetalle in (select idpedidodetalle from pedidodetalle where idpedido = NEW.idPedido)
        --     AND pedidodetallecolocacion.cantidad > 0;
		
		-- IF vsucursales = 'TORRES LANDA' THEN            
            
				-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
				-- 	VALUES (2, 30, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal\t\t\t\t\t\t\t(es):',vsucursales,'.'), NEW.idPedido);

		-- END IF;
	


			-- IF vidPromotor = NEW.id_usuario_capturado THEN            
				-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
				-- 	VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido Asignado a la(s) sucursal(es):',vsucursales,'.'), NEW.idPedido);
            -- ELSE
				-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
				-- 	VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido asignado a la(s) sucursal(es): ',vsucursales,'.'), NEW.idPedido);
				-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
				-- 	VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO'), concat('El pedido ', NEW.idPedido,' ha sido asignado a la(s) sucursal(es): ',vsucursales,'.'), NEW.idPedido);
			-- END IF;
    -- END IF;
    IF OLD.saldo <> NEW.saldo  THEN
		UPDATE cliente SET usado = getCreditoUsadoCliente(NEW.idCliente) WHERE idCliente = NEW.idCliente;
        -- IF NEW.saldo <= 0 THEN
		-- 	IF vidPromotor = NEW.id_usuario_capturado THEN            
		-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
        --     ELSE
		-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 			VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
		-- 		INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 			VALUES (2, NEW.id_usuario_capturado, 2, concat('Pedido ', NEW.idPedido,' SALDADO'), concat('El pedido ', NEW.idPedido,' ha sido saldado.'), NEW.idPedido);
		-- 	END IF;
        -- END IF;
    END IF;
    -- IF NEW.estado = 'CANCELADO' THEN	
		-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 			VALUES (2, 22, 2, concat('Pedido ', NEW.idPedido,' CANCELADO'), concat('El pedido ', NEW.idPedido,' ha sido Cancelado.'), NEW.idPedido);
    -- END IF;
    -- IF OLD.total <> NEW.total THEN
		-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 			VALUES (2, 22, 2, concat('Importe de Pedido ', NEW.idPedido,' ha cambiado'), concat('El importe del pedido ', NEW.idPedido,' ha cambiado. Antes: ', OLD.total, ', ahora: ', NEW.total), NEW.idPedido);
    -- END IF;
    IF OLD.saldopromotor <> NEW.saldopromotor THEN
		UPDATE usuario SET usado = getCreditoUsadoPromotor(vidPromotor) WHERE idUsuario = vidPromotor;
    END IF;
    -- IF  NEW.colocadoAutomatico = 'SI' THEN
		-- INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
		-- 					VALUES (2, 28, 2, concat('Pedido ', NEW.idPedido,' ASIGNADO AUTOMATICO'), concat('El pedido ', NEW.idPedido,' ha sido asignado en automatico .'), NEW.idPedido);
                        
	-- END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pedido_BEFORE_INSERT` BEFORE INSERT ON `pedido` FOR EACH ROW BEGIN
	DECLARE vDisponible DECIMAL(9,2);
    DECLARE vTotalSaldoClente DECIMAL(9,2);
    DECLARE vCapacidadPagoCliente DECIMAL(9,2);
    DECLARE vsaldarpedidoparaautorizar VARCHAR(2);
    DECLARE vNoPedidosCliente INTEGER;
    DECLARE vNoPedidosClienteSinSaldar INTEGER;
    DECLARE vCreditoUsadoEntregados DECIMAL(9,2);
    DECLARE vPagoVencido INTEGER;
    SET vNoPedidosClienteSinSaldar = 0;
    SET vNoPedidosCliente = 0;
    select getNoPedidosClienteSinSaldar(NEW.idCliente) INTO vNoPedidosClienteSinSaldar;
    select getNoPedidosCliente(NEW.idCliente) INTO vNoPedidosCliente;
    select getTotalSaldosCliente(NEW.idCliente) INTO vTotalSaldoClente;
    SELECT getDisponibleCreditoCliente(NEW.idCliente) INTO vDisponible;
    SELECT getCreditoUsadoClienteDatoFacturacionEntregados(NEW.idCliente, 0) INTO vCreditoUsadoEntregados;
    SELECT getDiasPagoVencido(NEW.idCliente) INTO vPagoVencido;
    SET vsaldarpedidoparaautorizar = 'SI';
    /*SELECT saldarpedidoparaautorizar INTO vsaldarpedidoparaautorizar FROM cliente WHERE idCliente = NEW.idCliente;*/
    SELECT saldarpedidoparaautorizar, capacidadPago INTO vsaldarpedidoparaautorizar, vCapacidadPagoCliente FROM cliente WHERE idCliente = NEW.idCliente;
      IF vPagoVencido < 8 AND (vCapacidadPagoCliente - vCreditoUsadoEntregados) >= NEW.total THEN 
        SET NEW.fecha_autorizado = getCurrentTimeStamp();
        SET NEW.id_usuario_autorizado = 2;
        SET NEW.observacionAutoriza = 'AUTORIZADO AUTOMÁTICO POR CAPACIDAD DE PAGO DE CLIENTE';
        SET NEW.estado = 'AUTORIZADO';
      END IF;
    
    /* SET vDisponible = vDisponible + NEW.total; 
    IF NEW.total <= vDisponible AND vsaldarpedidoparaautorizar = 'NO' THEN
		SET NEW.fecha_autorizado = getCurrentTimeStamp();
        SET NEW.id_usuario_autorizado = NEW.id_usuario_capturado;
        SET NEW.observacionAutoriza = 'AUTORIZADO AUTOMÁTICO POR CRÉDITO DE CLIENTE';
        SET NEW.estado = 'AUTORIZADO';
    END IF;*/
    IF NEW.recogeentrega = 'RECOGE' THEN
		SET NEW.generarValeSalida = 'SI';
    END IF;
    IF vNoPedidosCliente > 1 THEN
		SET NEW.tipocliente = 'CAUTIVO';
	ELSE
		IF vNoPedidosCliente = 0 THEN
			UPDATE cliente SET idUsuarioPromotor = idUsuarioPromotor;
		END IF;
    END IF;
     IF NEW.id_usuario_capturado = 9 OR NEW.id_usuario_capturado = 11 THEN
		SET NEW.idSucursalCapturado = 2;
    ELSE
		IF NEW.id_usuario_capturado = 18 THEN
			SET NEW.idSucursalCapturado = 1;
        END IF;		
    END IF;
    SET NEW.checarAutorizacion = 'SI';
	/* 2086 GALVAMEX Consumo Interno */
    IF NEW.idCliente = 2086 THEN
		SET NEW.saldo = 0;
        SET NEW.saldada = 'SI';
        SET NEW.fecha_saldada = NOW();
        SET NEW.fecha_autorizado = NOW();
        SET NEW.id_usuario_autorizado = 2;
        SET NEW.estado = 'AUTORIZADO';
        SET NEW.porDescuento = 100;
        SET NEW.descuento = NEW.total;
        SET NEW.observacionAutoriza = 'AUTORIZADO EN AUTOMÁTICO POR SER GALVAMEX CONSUMO INTERNO';
        SET NEW.tipoAutorizacion = 'AUTOMATICO';
        INSERT INTO pedidostracking (idPedido, idPedidoTrace, json, tipo, fecha)
           VALUES (NEW.idPedido, 67, '', 'SUCCESS', NOW());
    END IF;
	SET NEW.fecha_updateprecios = NEW.fecha_capturado;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidodetalle`
--

CREATE TABLE `pedidodetalle` (
  `idPedidoDetalle` int(11) NOT NULL,
  `IdPedido` int(11) DEFAULT 0,
  `renglon` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `idRolloBase` int(11) DEFAULT 1,
  `tipoPrecio` enum('PRECIO','RANGO1','RANGO2','RANGO3','IMPORTADO','TERNIUM','MENDEZ','RANGO4') DEFAULT 'PRECIO',
  `tipoPrecioOriginal` enum('PRECIO','RANGO1','RANGO2','RANGO3','IMPORTADO','TERNIUM','MENDEZ','RANGO4') DEFAULT 'PRECIO',
  `comision` decimal(15,2) DEFAULT 0.00,
  `comisionOriginal` decimal(15,2) DEFAULT NULL,
  `partida` decimal(9,2) DEFAULT 0.00,
  `cantidad` decimal(9,2) DEFAULT 0.00,
  `cantidadReal` decimal(9,2) DEFAULT 0.00,
  `desarrollo` varchar(50) DEFAULT '',
  `dobleces` int(11) DEFAULT 0,
  `curvar` enum('SI','NO') DEFAULT 'NO',
  `curvatura` varchar(20) DEFAULT '',
  `precioUnitario` decimal(15,2) DEFAULT 0.00,
  `precioUnitarioOriginal` decimal(15,2) DEFAULT NULL,
  `total` double DEFAULT 0,
  `explotarUnidad` decimal(9,2) DEFAULT 0.00,
  `totalExplotar` decimal(9,2) DEFAULT 0.00,
  `totalExplotado` decimal(9,2) DEFAULT 0.00,
  `explotadoReal` decimal(9,2) DEFAULT 0.00,
  `partidaDespachada` double DEFAULT 0,
  `mlDespachado` decimal(9,2) DEFAULT 0.00,
  `partidaenvale` decimal(9,2) DEFAULT 0.00,
  `listo_para_producir` enum('NO','SI') DEFAULT 'NO',
  `despachado` enum('SI','NO') DEFAULT 'NO',
  `fecha_despachado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_despachado` int(11) DEFAULT 0,
  `idSucursalDespachado` int(11) DEFAULT 0,
  `pesoKiloML` double DEFAULT 0,
  `molLaminasATomar` int(11) DEFAULT 0,
  `molPrecioDobleces` decimal(15,2) DEFAULT 0.00,
  `molPrecioCorte` decimal(15,2) DEFAULT 0.00,
  `molIsScrap` enum('NO','SI') DEFAULT 'NO',
  `molTotalcmScrap` decimal(9,2) DEFAULT 0.00,
  `molDescMaquila` varchar(45) DEFAULT '',
  `molLongitudinal` enum('L','A') DEFAULT 'L',
  `costoProducto` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `pedidodetalle`
--
DELIMITER $$
CREATE TRIGGER `pedidodetalle_AFTER_INSERT` AFTER INSERT ON `pedidodetalle` FOR EACH ROW BEGIN
	UPDATE producto
	   SET apartadoReal = apartadoReal + NEW.partida
	 WHERE idProducto = NEW.IdProducto AND producto_unidad_idUnidad = 4;
      UPDATE producto
	   SET apartadoReal = apartadoReal + (NEW.partida * NEW.cantidadReal)
	 WHERE idProducto = NEW.IdProducto AND producto_rollo_idrollo = 1 and producto_tipoproducto_idtipoproducto = 1 and producto_unidad_idunidad = 1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pedidodetalle_AFTER_UPDATE` AFTER UPDATE ON `pedidodetalle` FOR EACH ROW BEGIN
	DECLARE vNoDespachados INTEGER;
    DECLARE vPartidaDespachada DOUBLE;
    DECLARE vKilosDespachados DOUBLE;
    DECLARE vidPromotor INTEGER;
    DECLARE vidUsuarioCapturado INTEGER;
    IF OLD.partidadespachada <> NEW.partidadespachada AND NEW.idPedido < 5867 THEN
		SET vPartidaDespachada = NEW.partidadespachada - OLD.partidadespachada;
        IF vPartidaDespachada > 0 THEN
			   /*select idpedidodetalle, idpedido, idproduc	to, cantidad, fecha_despachado, id_usuario_despachado from pedidodetalle; */
				INSERT INTO valesalidadetalle (idPedidoDetalle, idPedido, idProducto, cantidad,fecha_despacho, id_usuario_despacho, idSucursalDespachado) 
                VALUES (NEW.idpedidodetalle, NEW.idpedido, NEW.idproducto, vPartidaDespachada, NEW.fecha_despachado, NEW.id_usuario_despachado, NEW.idSucursalDespachado);
        END IF;
        /*ESTO ES PARA LOS PRODUCTOS*/
        IF NEW.partidadespachada > OLD.partidadespachada THEN
			SET vPartidaDespachada = NEW.partidadespachada - OLD.partidadespachada;
            SET vKilosDespachados = NEW.explotarUnidad * vPartidaDespachada;
			/* se incrementó la partida, osea, se surtió */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'DESAPARTADO', vPartidaDespachada, vKilosDespachados, NEW.fecha_despachado, NEW.id_usuario_despachado);			
		ELSE
			SET vPartidaDespachada = OLD.partidadespachada- NEW.partidadespachada;
            SET vKilosDespachados = NEW.explotarUnidad * vPartidaDespachada;
            /* Se apartó, esto no debe pasar */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'APARTADO', vPartidaDespachada, vKilosDespachados, NEW.fecha_despachado, NEW.id_usuario_despachado);			
        END IF;
    END IF;
    /* ESTO ES PARA LOS ROLLOS */
    IF OLD.totalExplotado <> NEW.totalExplotado  THEN
        /*ESTO ES PARA LOS ROLLOS*/
        IF NEW.totalExplotado > OLD.totalExplotado THEN
            /*SET vPartidaDespachada = NEW.totalExplotado - OLD.totalExplotado;
             SET vPartidaDespachada = NEW.partida - OLD.partida;
            */
            SET vPartidaDespachada = NEW.partida;
            SET vKilosDespachados = NEW.totalExplotado - OLD.totalExplotado;
			/* se incrementó la partida, osea, se surtió */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'APARTADO', vPartidaDespachada, vKilosDespachados, getCurrentTimeStamp(), 2);			
		ELSE
			SET vPartidaDespachada = OLD.partida - NEW.partida;
            SET vKilosDespachados = NEW.totalExplotado - OLD.totalExplotado;
            /* Se apartó, esto no debe pasar */
			INSERT INTO movsapartado (idPedidoDetalle, idProducto, tipo, cantidad, kg, fecha_movimiento, id_usuario_movimiento) 
			        VALUES (NEW.idpedidodetalle, NEW.idproducto, 'DESAPARTADO', vPartidaDespachada, kg, NEW.fecha_despachado, NEW.id_usuario_despachado);			
        END IF;
    END IF;
	-- IF OLD.despachado = 'NO' AND NEW.despachado = 'SI' THEN
    --     SELECT ifnull(count(*), 0), cliente.idUsuarioPromotor, pedido.id_usuario_capturado INTO vNoDespachados, vidPromotor, vidUsuarioCapturado
    --       FROM pedidodetalle 
    --       inner join pedido on pedido.idpedido = pedidodetalle.idpedido
    --       inner join cliente on cliente.idcliente = pedido.idcliente
	-- 	 WHERE pedidodetalle.idpedido = NEW.idPedido 
    --        AND pedidodetalle.despachado = 'NO';  
	-- 	IF vNoDespachados = 0 THEN
	-- 		UPDATE pedido
    --            SET despachado = 'SI',
    --                estado = 'TERMINADO',
    --                fecha_terminado = NEW.fecha_despachado,
    --                id_usuario_terminado = NEW.id_usuario_despachado
	-- 		 WHERE idPedido = NEW.idPedido;
    --          IF vidPromotor = vidUsuarioCapturado THEN            
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
    --         ELSE
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
	-- 			INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
	-- 				VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' TERMINADO'), concat('El pedido ', NEW.idPedido,' ha sido surtido en su totalidad.'), NEW.idPedido);
	-- 		END IF;
    --     END IF;
    -- END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pedidodetalle_BEFORE_INSERT` BEFORE INSERT ON `pedidodetalle` FOR EACH ROW BEGIN
	DECLARE vIdUsuarioPromotor INTEGER;
    DECLARE vIdUsuarioPromotorAnterior INTEGER;
    DECLARE vIdCliente INTEGER;
    DECLARE vComisionR1 DECIMAL(15,2);
    DECLARE vComisionR2 DECIMAL(15,2);
    DECLARE vComisionR3 DECIMAL(15,2);
    DECLARE vComisionR4 DECIMAL(15,2);
    DECLARE vIsRoofing VARCHAR(2);
    DECLARE vpesocu DECIMAL(15,2);
    DECLARE vpesokgmt DECIMAL(15,2);
    DECLARE vcostoProducto DECIMAL(15,2);
    DECLARE vpies DECIMAL(15,2);
    DECLARE vtipoProducto DECIMAL(15,2);
    /*select p.idcliente, c.idusuariopromotor into vIdCliente, vIdUsuarioPromotor 
		from pedido p
		inner join cliente c on c.idcliente = p.idcliente
		where p.idpedido = NEW.idPedido;
    */
    select p.idcliente, c.idusuariopromotor,  c.idPromotorAnterior,
       IF( u.rangocomisiones = 'ALTO', co.comision1R1, IF (u.rangocomisiones = 'MEDIO', co.comision2R1, co.comision3R1)) comisionR1,
       IF( u.rangocomisiones = 'ALTO', co.comision1R2, IF (u.rangocomisiones = 'MEDIO', co.comision2R2, co.comision3R2)) comisionR2,
       IF( u.rangocomisiones = 'ALTO', co.comision1R3, IF (u.rangocomisiones = 'MEDIO', co.comision2R3, co.comision3R3)) comisionR3,
       IF( u.rangocomisiones = 'ALTO', co.comision1R4, IF (u.rangocomisiones = 'MEDIO', co.comision2R4, co.comision3R4)) comisionR4      
        into vIdCliente, vIdUsuarioPromotor ,vIdUsuarioPromotorAnterior, vComisionR1, vComisionR2, vComisionR3, vComisionR4
		from pedido p
		inner join cliente c on c.idcliente = p.idcliente
        inner join usuario u on u.idusuario = c.idusuariopromotor
        inner join configuracion co on co.idconfiguracion = 1
		where p.idpedido = NEW.idPedido;
    IF vIdUsuarioPromotor <> 18 THEN	
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = vComisionR1;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = vComisionR1;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = vComisionR1;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = vComisionR1;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = vComisionR2;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = vComisionR3;
								ELSE
									IF NEW.tipoprecio = 'RANGO4' THEN
										SET NEW.comision = vComisionR4;	
									END IF;
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
    END IF;
	IF vIdUsuarioPromotor = 18 /*Estela*/ OR
	   vIdUsuarioPromotor = 11 /*Saul*/ OR
       vIdUsuarioPromotor = 21 /*Saida*/ OR
       vIdUsuarioPromotor = 15 /*Sergio*/ OR
       vIdUsuarioPromotor = 32 /*Lety*/ THEN	
        SET NEW.comision = 0.5;
    END IF;
	IF NEW.idProducto = 10 THEN
        SET NEW.comision = 2;        
    END IF;
    IF vIdUsuarioPromotor = 10 AND vIdCliente <= 548 AND vIdCliente <> 342 THEN	
		/* 
        342
			352 = 0.5
            499 = 0.5
        */
        IF vIdCliente = 352 OR vIdCliente = 499 OR vIdCliente=364 THEN
			SET NEW.comision = 0.5;
        ELSE
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = 1.5;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = 1.5;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = 1.5;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = 1.5;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = 1.25;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = 1;
								ELSE
									IF NEW.tipoprecio = 'RANGO4' THEN
										SET NEW.comision = 0.75;	
									END IF;
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
        END IF;
    END IF;
    SELECT isRoofing INTO vIsRoofing
     FROM producto
     WHERE idProducto = NEW.idProducto;
     /* IF NEW.idProducto >= 517 AND NEW.idProducto <= 532 THEN */
    IF vIsRoofing = 'SI' THEN
        SET NEW.comision = 2;        
    END IF;
	SET NEW.tipoPrecioOriginal = NEW.tipoPrecio;
    SET NEW.comisionOriginal = NEW.comision;
    SET NEW.precioUnitarioOriginal = NEW.precioUnitario;
    SELECT pesocu, pesokgmt, pies INTO vpesocu, vpesokgmt, vpies FROM rollo WHERE idRollo = NEW.idRolloBase;
    /* si el pedido era cliente de Miguel ya se ha quitado lo de Miguel en febrero 2021 */
    IF vIdUsuarioPromotorAnterior = 9999 THEN	
			IF NEW.tipoprecio = 'PRECIO' THEN
				SET NEW.comision = 2;
			ELSE 
				IF NEW.tipoprecio = 'TERNIUM' THEN
					SET NEW.comision = 2;
				ELSE
					IF NEW.tipoprecio = 'RANGO1' THEN
						SET NEW.comision = 2;
					ELSE 
						IF NEW.tipoprecio = 'IMPORTADO' THEN
							SET NEW.comision = 2;
						ELSE
							IF NEW.tipoprecio = 'RANGO2' THEN
								SET NEW.comision = 1.75;
							ELSE
								IF NEW.tipoprecio = 'RANGO3' THEN
									SET NEW.comision = 1.5;
								END IF;
							END IF;
						END IF;
					END IF;
				END IF;
			END IF;
    END IF;	
    IF vIdUsuarioPromotor = 34 /*Oscar Rios, cero comision*/ THEN	
        SET NEW.comision = 0;
    END IF;
    IF NEW.idProducto <> 9 THEN 
    SET NEW.costoProducto = (vpesocu * vpesokgmt * 1.16)* NEW.partida * NEW.cantidad;
    END IF;
    SELECT costo, producto_tipoProducto_idTipoProducto INTO vcostoProducto, vtipoProducto FROM producto WHERE idProducto = NEW.idProducto;
    IF NEW.idRolloBase = 1 THEN 
    SET NEW.costoProducto = vcostoProducto * NEW.partida * NEW.cantidad;
    END IF;
     IF NEW.idProducto = 9 THEN  
		SET NEW.costoProducto = vpesocu * vpesokgmt* 1.16 * NEW.cantidad * (NEW.partida/(FLOOR((vpies*30.5)/ NEW.desarrollo)));
    END IF;
     IF vtipoProducto = 5 THEN  
		SET NEW.costoProducto = NEW.partida * NEW.cantidad * 1.16 * vpesocu;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidodetallecolocacion`
--

CREATE TABLE `pedidodetallecolocacion` (
  `idPedidoDetalleColocacion` int(11) NOT NULL,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idInventarioSucursal` int(11) DEFAULT 0,
  `idSucursal` int(11) DEFAULT 0,
  `cantidad` decimal(9,2) DEFAULT 0.00,
  `cantidadSurtida` decimal(9,2) DEFAULT 0.00,
  `cantidadEnVale` decimal(9,2) DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `pedidodetallecolocacion`
--
DELIMITER $$
CREATE TRIGGER `pedidodetallecolocacion_AFTER_DELETE` AFTER DELETE ON `pedidodetallecolocacion` FOR EACH ROW BEGIN
	IF OLD.idInventarioSucursal > 0 THEN
		UPDATE inventariosucursal
		   SET apartado = apartado - OLD.cantidad
		 WHERE idInventarioSucursal = OLD.idInventarioSucursal;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pedidodetallecolocacion_AFTER_INSERT` AFTER INSERT ON `pedidodetallecolocacion` FOR EACH ROW BEGIN
	IF NEW.idInventarioSucursal > 0 THEN
		UPDATE inventariosucursal
		   SET apartado = apartado + NEW.cantidad
		 WHERE idInventarioSucursal = NEW.idInventarioSucursal;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidostracking`
--

CREATE TABLE `pedidostracking` (
  `idPedidosTracking` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL DEFAULT 0,
  `idPedidoTrace` int(11) DEFAULT 0,
  `json` varchar(2000) NOT NULL DEFAULT '',
  `tipo` enum('INFO','WARNING','SUCCESS','ERROR') DEFAULT 'INFO',
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `track` enum('PEDIDO','VALESALIDA') DEFAULT 'PEDIDO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `pedidostracking`
--
DELIMITER $$
CREATE TRIGGER `pedidostracking_BEFORE_INSERT` BEFORE INSERT ON `pedidostracking` FOR EACH ROW BEGIN
	SET NEW.fecha = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidotrace`
--

CREATE TABLE `pedidotrace` (
  `idPedidoTrace` int(11) NOT NULL,
  `trace` varchar(500) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pesomt`
--

CREATE TABLE `pesomt` (
  `idPesoMt` int(11) NOT NULL,
  `calibre` int(11) DEFAULT 0,
  `pies2` double DEFAULT 0,
  `pies3` double DEFAULT 0,
  `pies348` double DEFAULT 0,
  `pies376` double DEFAULT 0,
  `pies4` double DEFAULT 0,
  `fecha_modificacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_modificacion` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pesomt`
--

INSERT INTO `pesomt` (`idPesoMt`, `calibre`, `pies2`, `pies3`, `pies348`, `pies376`, `pies4`, `fecha_modificacion`, `id_usuario_modificacion`) VALUES
(1, 18, 5.98, 8.97, 10.4, 11.24, 11.96, '0000-00-00 00:00:00', 0),
(2, 20, 4.54, 6.8, 7.89, 8.52, 9.07, '0000-00-00 00:00:00', 0),
(3, 22, 3.81, 5.71, 6.62, 7.15, 7.61, '0000-00-00 00:00:00', 0),
(4, 24, 2.71, 4.07, 4.71, 5.09, 5.42, '0000-00-00 00:00:00', 0),
(5, 26, 2.32, 3.52, 4.02, 4.35, 4.63, '0000-00-00 00:00:00', 0),
(6, 28, 1.98, 2.97, 3.44, 3.72, 3.96, '0000-00-00 00:00:00', 0),
(7, 30, 1.63, 2.44, 2.83, 3.06, 3.26, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `precioacrilica`
--

CREATE TABLE `precioacrilica` (
  `idPrecioAcrilica` int(11) NOT NULL,
  `idProductoAplicacion` int(11) NOT NULL,
  `idProductoMaterial` int(11) NOT NULL,
  `precioRango1` decimal(9,2) NOT NULL,
  `precioRango2` decimal(9,2) NOT NULL,
  `precioRango3` decimal(9,2) NOT NULL,
  `precioRango4` decimal(9,2) NOT NULL DEFAULT 0.00,
  `precioRangoMendez` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `precioacrilica`
--
DELIMITER $$
CREATE TRIGGER `precioacrilica_AFTER_UPDATE` AFTER UPDATE ON `precioacrilica` FOR EACH ROW BEGIN    
    DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
    DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
IF(OLD.precioRango1 <> NEW.precioRango1 OR
   OLD.precioRango2 <> NEW.precioRango2 OR
   OLD.precioRango3 <> NEW.precioRango3 OR
   OLD.precioRango4 <> NEW.precioRango4 OR
   OLD.precioRangoMendez <> NEW.precioRangoMendez or 1 = 1)
         THEN 
   	     SET vp1 = NEW.precioRango1;
         SET vp2 = NEW.precioRango2;
         SET vp3 = NEW.precioRango3;
         SET vp4 = NEW.precioRango4;
         SET vpm = NEW.precioRangoMendez;	
         UPDATE producto 
          SET precio1 = vp1 * producto.longitud,
              precio2 = vp2 * producto.longitud,
              precio3 = vp3 * producto.longitud,
              precio4 = vp4 * producto.longitud,
              preciomendez = vpm * producto.longitud 
		WHERE producto.producto_aplicacion_idAplicacion =			  
              	NEW.idProductoAplicacion 
              AND producto.producto_material_idMaterial = 		            	 						  
              NEW.idProductoMaterial AND producto.producto_unidad_idUnidad = 4 AND producto.idProducto <> 351;
          SET vpm = NEW.precioRangoMendez;	
         
         UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4,
              preciomendez = vpm 
		WHERE producto.producto_aplicacion_idAplicacion =			  
              	NEW.idProductoAplicacion 
              AND producto.producto_material_idMaterial = 		            	 						  NEW.idProductoMaterial AND producto.producto_unidad_idUnidad = 1;                 
              
         END IF;
 END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `precioacrilica_BEFORE_UPDATE` BEFORE UPDATE ON `precioacrilica` FOR EACH ROW BEGIN
INSERT INTO `precioacrilicahistory` (`idPrecioAcrilica`, `idProductoAplicacion`, `idProductoMaterial`, `precioRango1`, `precioRango2`, `precioRango3`, `precioRangoMendez`, fecha_Update ) VALUES (NULL, OLD.idProductoAplicacion, OLD.idProductoMaterial, OLD.precioRango1, OLD.precioRango2, OLD.precioRango3, OLD.precioRangoMendez, now());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `precioacrilicahistory`
--

CREATE TABLE `precioacrilicahistory` (
  `idPrecioAcrilica` int(11) NOT NULL,
  `idProductoAplicacion` int(11) NOT NULL,
  `idProductoMaterial` int(11) NOT NULL,
  `precioRango1` decimal(9,2) NOT NULL,
  `precioRango2` decimal(9,2) NOT NULL,
  `precioRango3` decimal(9,2) NOT NULL,
  `precioRango4` decimal(9,2) NOT NULL DEFAULT 0.00,
  `precioRangoMendez` decimal(9,2) NOT NULL,
  `fecha_Update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `precioxdobles`
--

CREATE TABLE `precioxdobles` (
  `idPrecioXDobles` int(11) NOT NULL,
  `tipoPrecio` char(1) DEFAULT NULL,
  `desarrollo` varchar(15) DEFAULT '0',
  `calibre` int(11) DEFAULT 0,
  `precio1` double DEFAULT 0,
  `precio2` double DEFAULT 0,
  `precio3` double DEFAULT 0,
  `precio4` double DEFAULT 0,
  `precio5` double DEFAULT 0,
  `precio6` double DEFAULT 0,
  `precio7` double DEFAULT 0,
  `precio8` double DEFAULT 0,
  `precio9` double DEFAULT 0,
  `precio10` double DEFAULT 0,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `precioxdobles`
--

INSERT INTO `precioxdobles` (`idPrecioXDobles`, `tipoPrecio`, `desarrollo`, `calibre`, `precio1`, `precio2`, `precio3`, `precio4`, `precio5`, `precio6`, `precio7`, `precio8`, `precio9`, `precio10`, `idUsuario`) VALUES
(1, 'I', '1-15', 26, 19, 22, 25, 28, 31, 34, 37, 40, 43, 46, 4),
(2, 'I', '1-15', 24, 25, 28, 31, 34, 37, 40, 43, 46, 49, 52, 4),
(3, 'I', '16-20', 26, 25, 28, 31, 34, 37, 40, 43, 46, 49, 52, 4),
(4, 'I', '16-20', 24, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 4),
(5, 'I', '21-30', 26, 37, 40, 43, 46, 49, 52, 55, 58, 61, 64, 4),
(6, 'I', '21-30', 24, 42, 45.5, 48.5, 51.5, 54.5, 57.5, 60.5, 63.5, 66.5, 69.5, 4),
(7, 'I', '31-40', 26, 50, 53, 56, 59, 62, 65, 68, 71, 74, 77, 4),
(8, 'I', '31-40', 24, 57, 60, 63, 66, 69, 72, 75, 78, 81, 84, 4),
(9, 'I', '41-61', 26, 74, 77, 80, 83, 86, 89, 92, 95, 98, 101, 4),
(10, 'I', '41-61', 24, 85, 88, 91, 94, 97, 100, 103, 106, 109, 112, 4),
(11, 'I', '62-1.22', 26, 148, 151, 154, 157, 160, 163, 166, 169, 172, 175, 4),
(12, 'I', '62-1.22', 24, 169, 172, 175, 178, 181, 184, 187, 190, 193, 196, 4),
(13, 'T', '1-15', 26, 26.83, 29.83, 32.83, 35.83, 38.83, 41.83, 44.83, 47.83, 50.83, 53.83, 6),
(14, 'T', '1-15', 24, 30.04, 33.04, 36.04, 39.04, 42.04, 45.04, 48.04, 51.04, 54.04, 57.04, 6),
(15, 'T', '1-15', 22, 39.75, 42.75, 45.75, 48.75, 51.75, 54.75, 57.75, 60.75, 63.75, 66.75, 6),
(16, 'T', '16-20', 26, 32.38, 35.38, 38.38, 41.38, 44.38, 47.38, 50.38, 53.38, 56.38, 59.38, 6),
(17, 'T', '16-20', 24, 36.88, 39.88, 42.88, 45.88, 48.88, 51.88, 54.88, 57.88, 60.88, 63.88, 6),
(18, 'T', '16-20', 22, 51.08, 54.08, 57.08, 60.08, 63.08, 66.08, 69.08, 72.08, 75.08, 78.08, 6),
(19, 'T', '21-25', 26, 50.67, 53.67, 56.67, 59.67, 62.67, 65.67, 68.67, 71.67, 74.67, 77.67, 6),
(20, 'T', '21-25', 24, 57.08, 60.08, 63.08, 66.08, 69.08, 72.08, 75.08, 78.08, 81.08, 84.08, 6),
(21, 'T', '21-25', 22, 76.5, 79.5, 82.5, 85.5, 88.5, 91.5, 94.5, 97.5, 100.5, 103.5, 6),
(22, 'T', '26-30', 26, 50.67, 53.67, 56.67, 59.67, 62.67, 65.67, 68.67, 71.67, 74.67, 77.67, 6),
(23, 'T', '26-30', 24, 57.08, 60.08, 63.08, 66.08, 69.08, 72.08, 75.08, 78.08, 81.08, 84.08, 6),
(24, 'T', '26-30', 22, 76.5, 79.5, 82.5, 85.5, 88.5, 91.5, 94.5, 97.5, 100.5, 103.5, 6),
(25, 'T', '31-35', 26, 61.75, 64.75, 67.75, 70.75, 73.75, 76.75, 79.75, 82.75, 85.75, 88.75, 6),
(26, 'T', '31-35', 24, 70.75, 73.75, 76.75, 79.75, 82.75, 85.75, 88.75, 91.75, 94.75, 97.75, 6),
(27, 'T', '31-35', 22, 99.17, 102.17, 105.17, 108.17, 111.17, 114.17, 117.17, 120.17, 123.17, 126.17, 6),
(28, 'T', '36-40', 26, 61.75, 64.75, 67.75, 70.75, 73.75, 76.75, 79.75, 82.75, 85.75, 88.75, 6),
(29, 'T', '36-40', 24, 70.75, 73.75, 76.75, 79.75, 82.75, 85.75, 88.75, 91.75, 94.75, 97.75, 6),
(30, 'T', '36-40', 22, 99.17, 102.17, 105.17, 108.17, 111.17, 114.17, 117.17, 120.17, 123.17, 126.17, 6),
(31, 'T', '41-45', 26, 74.5, 77.5, 80.5, 83.5, 86.5, 89.5, 92.5, 95.5, 98.5, 101.5, 6),
(32, 'T', '41-45', 24, 84.13, 87.13, 90.13, 93.13, 96.13, 99.13, 102.13, 105.13, 108.13, 111.13, 6),
(33, 'T', '41-45', 22, 113.25, 116.25, 119.25, 122.25, 125.25, 128.25, 131.25, 134.25, 137.25, 140.25, 6),
(34, 'T', '46-61', 26, 91.13, 94.13, 97.13, 100.13, 103.13, 106.13, 109.13, 112.13, 115.13, 118.13, 6),
(35, 'T', '46-61', 24, 104.63, 107.63, 110.63, 113.63, 116.63, 119.63, 122.63, 125.63, 128.63, 131.63, 6),
(36, 'T', '46-61', 22, 147.25, 150.25, 153.25, 156.25, 159.25, 162.25, 165.25, 168.25, 171.25, 174.25, 6),
(37, 'T', '62-91', 26, 146, 149, 152, 155, 158, 161, 164, 167, 170, 173, 6),
(38, 'T', '62-91', 24, 165.25, 168.25, 171.25, 174.25, 177.25, 180.25, 183.25, 186.25, 189.25, 192.25, 6),
(39, 'T', '62-91', 22, 223.5, 226.5, 229.5, 232.5, 235.5, 238.5, 241.5, 244.5, 247.5, 250.5, 6),
(40, 'T', '92-1.22', 26, 179.25, 182.25, 185.25, 188.25, 191.25, 194.25, 197.25, 200.25, 203.25, 206.25, 6),
(41, 'T', '92-1.22', 24, 205.25, 208.25, 211.25, 214.25, 217.25, 220.25, 223.25, 226.25, 229.25, 232.25, 6),
(42, 'T', '92-1.22', 22, 291.5, 294.5, 297.5, 300.5, 303.5, 306.5, 309.5, 312.5, 315.5, 318.5, 6);

--
-- Triggers `precioxdobles`
--
DELIMITER $$
CREATE TRIGGER `precioxdobles_AFTER_INSERT` AFTER INSERT ON `precioxdobles` FOR EACH ROW BEGIN
	INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 1 , 0, NEW.precio1, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 2 , 0, NEW.precio2, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 3 , 0, NEW.precio3, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 4 , 0, NEW.precio4, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 5 , 0, NEW.precio5, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 6 , 0, NEW.precio6, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 7 , 0, NEW.precio7, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 8 , 0, NEW.precio8, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 9 , 0, NEW.precio9, NEW.idUsuario);
    INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
    VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 10 , 0, NEW.precio10, NEW.idUsuario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `precioxdobles_AFTER_UPDATE` AFTER UPDATE ON `precioxdobles` FOR EACH ROW BEGIN
	IF NEW.precio1 <> OLD.precio1 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 1, OLD.precio1, NEW.precio1, NEW.idUsuario);
    END IF;
    IF NEW.precio2 <> OLD.precio2 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 2, OLD.precio2, NEW.precio2, NEW.idUsuario);
    END IF;
    IF NEW.precio3 <> OLD.precio3 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 3, OLD.precio3, NEW.precio3, NEW.idUsuario);
    END IF;
    IF NEW.precio4 <> OLD.precio4 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 4, OLD.precio4, NEW.precio4, NEW.idUsuario);
    END IF;
    IF NEW.precio5 <> OLD.precio5 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 5, OLD.precio5, NEW.precio5, NEW.idUsuario);
    END IF;
    IF NEW.precio6 <> OLD.precio6 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 6, OLD.precio6, NEW.precio6, NEW.idUsuario);
    END IF;
    IF NEW.precio7 <> OLD.precio7 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 7, OLD.precio7, NEW.precio7, NEW.idUsuario);
    END IF;
    IF NEW.precio8 <> OLD.precio8 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 8, OLD.precio8, NEW.precio8, NEW.idUsuario);
    END IF;
    IF NEW.precio9 <> OLD.precio9 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 9, OLD.precio9, NEW.precio9, NEW.idUsuario);
    END IF;
    IF NEW.precio10 <> OLD.precio10 THEN    
		INSERT INTO cambiopreciodobles (fecha, cambiopreciodobles_precioXDobles_idPrecioXDobles, dobleces, precioAnterior, precio, idUsuario) 
          VALUES (getCurrentTimeStamp(), NEW.idPrecioXDobles, 10, OLD.precio10, NEW.precio10, NEW.idUsuario);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `longitud` varchar(20) DEFAULT '',
  `mlpieza` decimal(9,2) DEFAULT 0.00,
  `producto_tipoProducto_idTipoProducto` int(11) DEFAULT NULL,
  `producto_aplicacion_idAplicacion` int(11) DEFAULT NULL,
  `producto_material_idMaterial` int(11) DEFAULT NULL,
  `producto_rollo_idRollo` int(11) DEFAULT NULL,
  `producto_unidad_idUnidad` int(11) DEFAULT NULL,
  `calibre` int(11) DEFAULT NULL,
  `pies` int(11) DEFAULT 0,
  `origen` enum('N','I') DEFAULT 'N',
  `descripcion` varchar(255) DEFAULT '',
  `existencia` decimal(9,2) DEFAULT 0.00,
  `apartado` double DEFAULT 0,
  `apartadoReal` double DEFAULT 0,
  `tipoPrecio` char(1) DEFAULT 'G',
  `isRango` char(1) DEFAULT '0',
  `tipoRango` char(1) DEFAULT '0',
  `isRollo` char(1) DEFAULT '0',
  `heredarPrecio` enum('SI','NO') DEFAULT 'SI',
  `cf` decimal(9,2) DEFAULT 0.00,
  `precio1` decimal(9,2) DEFAULT 0.00,
  `precio2` decimal(9,2) DEFAULT 0.00,
  `precio3` decimal(9,2) DEFAULT 0.00,
  `precio4` decimal(9,2) DEFAULT 0.00,
  `preciomendez` decimal(9,2) DEFAULT 0.00,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0,
  `isRoofing` enum('NO','SI') DEFAULT 'NO',
  `medidaespecial` varchar(45) DEFAULT '',
  `costo` decimal(9,2) NOT NULL,
  `isSegunda` enum('SI','NO') NOT NULL DEFAULT 'NO',
  `lastUpdate` datetime NOT NULL DEFAULT current_timestamp(),
  `idProveedor` int(11) DEFAULT NULL,
  `resurtir` enum('NO','SI') DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `producto`
--
DELIMITER $$
CREATE TRIGGER `producto_AFTER_INSERT` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
	IF NEW.tipoPrecio = 'G' THEN
		INSERT INTO notificacion (idProvoca, idPara, tema, contenido)
         SELECT NEW.idUsuarioCrea, idUsuario,concat('Alta Producto ', NEW.codigo), CONCAT('Ha generado el Producto [PROD_AI]',NEW.idProducto,'[PROD_AT]',NEW.descripcion,'[PROD_AF], favor de especificar Precios.')
		  FROM usuario 
		 WHERE idRol IN (1,2) ;  
    END IF;
    IF NEW.producto_unidad_idUnidad = 4 THEN
		insert into inventariosucursal (idSucursal, idProducto, existencia, apartado)
		select idSucursal, NEW.idProducto, 0, 0 
		from sucursal;
	END IF;
    insert into favorito (idUsuario, idProducto)
	select usuario.idUsuario, producto.idProducto
	from usuario
	cross join producto
	where usuario.estatus = 'ACTIVO' and producto.idProducto = NEW.idProducto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW BEGIN
    DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
    DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
    DECLARE vpkg DOUBLE;
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
    END IF;
	SET NEW.lastUpdate = NOW();

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `producto_BEFORE_UPDATE` BEFORE UPDATE ON `producto` FOR EACH ROW BEGIN
    IF NEW.preciomendez = 0.0 THEN
		IF NEW.precio3 > 0.0 THEN
			SET NEW.preciomendez = NEW.precio3;
		ELSE
			IF NEW.precio2 > 0.0 THEN
				SET NEW.preciomendez = NEW.precio2;
			ELSE
				SET NEW.preciomendez = NEW.precio1;
            END IF;
        END IF;
    END IF;
	IF OLD.precio1  <> NEW.precio1 OR 
       OLD.precio2 <> NEW.precio2 OR 
       OLD.precio3 <> NEW.precio3 OR
       OLD.precio4 <> NEW.precio4 OR
       OLD.preciomendez <> NEW.preciomendez THEN
		SET NEW.lastUpdate = NOW();
		UPDATE configuracion SET rolloprodlastupdate = NOW() WHERE idConfiguracion = 1;
	END IF;

	

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `productopanel`
--

CREATE TABLE `productopanel` (
  `idPesoPanel` int(11) NOT NULL,
  `idMaterial` int(11) NOT NULL,
  `calibreLamSup` int(11) NOT NULL,
  `CalibreLamInf` int(11) NOT NULL,
  `pesoMl` decimal(4,2) NOT NULL,
  `espesor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `nombre` varchar(70) CHARACTER SET latin1 DEFAULT NULL,
  `clave` varchar(5) DEFAULT NULL,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pushnotifica`
--

CREATE TABLE `pushnotifica` (
  `idPushNotifica` int(11) NOT NULL,
  `idProvoca` int(11) DEFAULT 0,
  `idPara` int(11) DEFAULT 0,
  `tipo` int(11) DEFAULT 0,
  `tema` varchar(100) DEFAULT '',
  `contenido` varchar(500) DEFAULT '',
  `acepta` enum('SINRESPUESTA','SI','NO') DEFAULT 'SINRESPUESTA',
  `refint` int(11) DEFAULT 0,
  `refstr` varchar(25) DEFAULT '',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00',
  `enviado` enum('NO','SI') DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `pushnotifica`
--
DELIMITER $$
CREATE TRIGGER `pushnotifica_BEFORE_INSERT` BEFORE INSERT ON `pushnotifica` FOR EACH ROW BEGIN
	SET NEW.fecha = getCurrentTimeStamp();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `recibodinero`
--

CREATE TABLE `recibodinero` (
  `idReciboDinero` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `monto` decimal(9,2) NOT NULL,
  `disponible` decimal(9,2) NOT NULL,
  `formaPago` int(11) NOT NULL,
  `referencia` varchar(70) NOT NULL,
  `fecha_captura` datetime NOT NULL,
  `id_usuario_captura` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `recibodinero`
--
DELIMITER $$
CREATE TRIGGER `recibodinero_AFTER_INSERT` AFTER INSERT ON `recibodinero` FOR EACH ROW BEGIN
	Update cliente set enviarPlanProteccion = 'SI' where idcliente = NEW.idCliente;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `regimenfiscal`
--

CREATE TABLE `regimenfiscal` (
  `idRegimenFiscal` int(11) NOT NULL,
  `codigo` varchar(10) DEFAULT '',
  `descripcion` varchar(120) DEFAULT '',
  `id_usuario_insert` int(11) DEFAULT 0,
  `fecha_insert` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_update` int(11) DEFAULT 0,
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `regimenfiscal`
--

INSERT INTO `regimenfiscal` (`idRegimenFiscal`, `codigo`, `descripcion`, `id_usuario_insert`, `fecha_insert`, `id_usuario_update`, `fecha_update`) VALUES
(1, '', '', 2, '2022-04-06 14:14:47', 2, '2022-04-06 14:14:47'),
(2, '601', 'General de Ley Personas Morales', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(3, '603', 'Personas Morales con Fines no Lucrativos', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(4, '605', 'Sueldos y Salarios e Ingresos Asimilados a Salarios', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(5, '606', 'Arrendamiento', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(6, '607', 'Régimen de Enajenación o Adquisición de Bienes', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(7, '608', 'Demás ingresos', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(8, '610', 'Residentes en el Extranjero sin Establecimiento Permanente en México', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(9, '611', 'Ingresos por Dividendos (socios y accionistas)', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(10, '612', 'Personas Físicas con Actividades Empresariales y Profesionales', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(11, '614', 'Ingresos por intereses', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(12, '615', 'Régimen de los ingresos por obtención de premios', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(13, '616', 'Sin obligaciones fiscales', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(14, '620', 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(15, '621', 'Incorporación Fiscal', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(16, '622', 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(17, '623', 'Opcional para Grupos de Sociedades', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(18, '624', 'Coordinados', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(19, '625', 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10'),
(20, '626', 'Régimen Simplificado de Confianza', 2, '2022-04-06 16:46:10', 2, '2022-04-06 16:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `registroproduccion`
--

CREATE TABLE `registroproduccion` (
  `idRegistroProduccion` int(11) NOT NULL,
  `idRemisionRollo` int(11) DEFAULT 0,
  `consecutivoNoRollo` int(11) DEFAULT 0,
  `kilos` decimal(9,2) DEFAULT 0.00,
  `kilosMaquilados` decimal(9,2) DEFAULT 0.00,
  `totalml` decimal(9,2) DEFAULT 0.00,
  `factor` decimal(9,2) DEFAULT 0.00,
  `rendimiento` decimal(9,2) DEFAULT 0.00,
  `terminado` enum('SI','NO') DEFAULT 'NO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `fecha_termina` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_termina` int(11) DEFAULT 0,
  `espesor` decimal(9,4) NOT NULL,
  `largoRollo` decimal(9,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `registroproduccion`
--
DELIMITER $$
CREATE TRIGGER `registroproduccion_AFTER_UPDATE` AFTER UPDATE ON `registroproduccion` FOR EACH ROW BEGIN
	DECLARE vDiferencia DECIMAL(9,2);
    DECLARE vTotalKilos DECIMAL(9,2);
    DECLARE vIdRollo INTEGER;
	SET vDiferencia = 0.0;
	IF OLD.terminado = 'NO' AND NEW.terminado = 'SI' THEN
		UPDATE registroproducciondetalle 
           SET totalReal = totalKg * NEW.factor / 100 
		 WHERE idRegistroProduccion = NEW.idRegistroProduccion;
          update remisionrollo set estado = 'TERMINADO' 
         where idremisionrollo = NEW.idRemisionRollo;
		SET vTotalKilos = NEW.kilosMaquilados;
		SET vDiferencia = NEW.kilos - vTotalKilos;
         IF vDiferencia < 0.0 THEN
			SELECT remisionRollo_rollo_idRollo INTO vIdRollo
              FROM remisionrollo 
			 WHERE idRemisionRollo = NEW.idRemisionRollo;
			INSERT INTO invzmovrollo (idRollo, idRemisionRollo, documento, referencia, movimiento, salidaDespacho, cantidad, observaciones, fecha_movimiento, id_usuario_movimiento, idRegistroProduccion)
               VALUES (vIdRollo, NEW.idRemisionRollo, 'NINGUNO', '', 'ENTRADA', 'NO', (vDiferencia * -1), 'AJUSTE POR REGISTRO DE PRODUCCIÓN (RENDIMIENTO)', NEW.fecha_termina, NEW.id_usuario_termina, NEW.idRegistroProduccion);
         ELSE 
			IF vDiferencia > 0.0 THEN
					SELECT remisionRollo_rollo_idRollo INTO vIdRollo
					  FROM remisionrollo 
					 WHERE idRemisionRollo = NEW.idRemisionRollo;
					INSERT INTO invzmovrollo (idRollo, idRemisionRollo, documento, referencia, movimiento, salidaDespacho, cantidad, observaciones, fecha_movimiento, id_usuario_movimiento, idRegistroProduccion)
					VALUES (vIdRollo, NEW.idRemisionRollo, 'NINGUNO', '', 'SALIDA', 'NO', (vDiferencia), 'AJUSTE POR REGISTRO DE PRODUCCIÓN(EXCEDENTE)', NEW.fecha_termina, NEW.id_usuario_termina, NEW.idRegistroProduccion);
            END IF;
         END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `registroproduccion_BEFORE_INSERT` BEFORE INSERT ON `registroproduccion` FOR EACH ROW BEGIN
	DECLARE vConsecutivo INTEGER;
    DECLARE vKilos DOUBLE;
    SELECT IFNULL(MAX(consecutivoNoRollo), 0) INTO vConsecutivo
      FROM registroproduccion
     WHERE idRemisionRollo = NEW.idRemisionRollo;
     SELECT existencia INTO vKilos
      FROM remisionrollo
     WHERE idRemisionRollo = NEW.idRemisionRollo;
     update remisionrollo set estado = 'PRODUCCION' 
         where idremisionrollo = NEW.idRemisionRollo;
	SET NEW.consecutivoNoRollo = vConsecutivo + 1;
    SET NEW.kilos = vKilos;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `registroproduccion_BEFORE_UPDATE` BEFORE UPDATE ON `registroproduccion` FOR EACH ROW BEGIN
	IF OLD.terminado = 'NO' AND NEW.terminado = 'SI' THEN
		IF NEW.kilosMaquilados > 0 THEN
			SET NEW.factor = (NEW.kilos * 100) / NEW.kilosMaquilados;
			/* SET NEW.rendimiento = ((NEW.kilosMaquilados - NEW.kilos)*100) / NEW.kilosMaquilados; */
            SET NEW.rendimiento = ((NEW.kilosMaquilados / NEW.kilos) - 1 ) * 100;
		END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `registroproducciondetalle`
--

CREATE TABLE `registroproducciondetalle` (
  `idRegistroProduccionDetalle` int(11) NOT NULL,
  `idRegistroProduccion` int(11) DEFAULT 0,
  `tipo` enum('STOCK','PEDIDO','PYC') DEFAULT 'STOCK',
  `idProducto` int(11) DEFAULT 0,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `partida` double DEFAULT 0,
  `longitud` decimal(9,2) DEFAULT 0.00,
  `kgml` decimal(9,2) DEFAULT 0.00,
  `totalKg` decimal(9,2) DEFAULT 0.00,
  `totalReal` decimal(9,2) DEFAULT 0.00,
  `fecha_captura` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_captura` int(11) DEFAULT 0,
  `idSucursal` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `registroproducciondetalle`
--
DELIMITER $$
CREATE TRIGGER `registroproducciondetalle_AFTER_INSERT` AFTER INSERT ON `registroproducciondetalle` FOR EACH ROW BEGIN
	/*
kilosMaquilados = totalkg
totalml = partida * longitud
*/
	update registroproduccion 
     set kilosMaquilados = kilosMaquilados + NEW.totalkg, 
         totalml = totalml + (NEW.partida * NEW.longitud)
    where idregistroproduccion = NEW.idregistroproduccion;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `remisionrollo`
--

CREATE TABLE `remisionrollo` (
  `idRemisionRollo` int(11) NOT NULL,
  `remision` varchar(30) DEFAULT NULL,
  `remisionRollo_rollo_idRollo` int(11) DEFAULT NULL,
  `noRollo` varchar(40) DEFAULT NULL,
  `kilos` decimal(9,2) DEFAULT 0.00,
  `existencia` decimal(9,2) DEFAULT 0.00,
  `almacen` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','DELTA','OBRA','LAGOS','TRANSITO','MORELOS','EL RANCHITO') DEFAULT 'ALMACEN A',
  `almacenOriginal` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','DELTA','OBRA','LAGOS','TRANSITO','MORELOS','EL RANCHITO') DEFAULT 'ALMACEN A',
  `idPedidoObra` int(11) DEFAULT 0,
  `comprador` enum('GALVAMEX','MENDEZ') DEFAULT 'GALVAMEX',
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `remisionRollo_usuario_idUsuario` int(11) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT current_timestamp(),
  `norollooriginal` varchar(40) DEFAULT '',
  `idrollooriginal` int(11) DEFAULT 0,
  `usuario_baja` int(11) DEFAULT 0,
  `fecha_baja` date DEFAULT '0000-00-00',
  `estado` enum('ACTIVO','PRODUCCION','TERMINADO','BAJA') DEFAULT 'ACTIVO',
  `costokg` decimal(9,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `remisionrollo`
--
DELIMITER $$
CREATE TRIGGER `remisionrollo_AFTER_INSERT` AFTER INSERT ON `remisionrollo` FOR EACH ROW BEGIN
	/*UPDATE rollo 
       SET existencia = existencia + NEW.kilos
	 WHERE idRollo = NEW.remisionRollo_rollo_idRollo;     */
     INSERT INTO invzmovrollo (idRollo, idRemisionRollo, documento, referencia, movimiento, salidaDespacho, cantidad, observaciones, fecha_movimiento, id_usuario_movimiento)
           VALUES (NEW.remisionRollo_rollo_idRollo, NEW.idRemisionRollo, 'REMISION', NEW.remision, 'ENTRADA', 'NO', NEW.kilos, NEW.noRollo, concat(NEW.fecha, ' ', NEW.hora), NEW.remisionRollo_usuario_idUsuario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remisionrollo_AFTER_UPDATE` AFTER UPDATE ON `remisionrollo` FOR EACH ROW BEGIN
	INSERT INTO `remisionrollohistory`
(
`idRemisionRollo`,
`remision`,
`remisionRollo_rollo_idRollo`,
`noRollo`,
`kilos`,
`existencia`,
`almacen`,
`almacenOriginal`,
`comprador`,
`fecha`,
`hora`,
`remisionRollo_usuario_idUsuario`,
`ts`,
`norollooriginal`,
`idrollooriginal`,
`usuario_baja`,
`fecha_baja`,
`estado`)
VALUES
(NEW.`idRemisionRollo`,
NEW.`remision`,
NEW.`remisionRollo_rollo_idRollo`,
NEW.`noRollo`,
NEW.`kilos`,
NEW.`existencia`,
NEW.`almacen`,
NEW.`almacenOriginal`,
NEW.`comprador`,
NEW.`fecha`,
NEW.`hora`,
NEW.`remisionRollo_usuario_idUsuario`,
NEW.`ts`,
NEW.`norollooriginal`,
NEW.`idrollooriginal`,
NEW.`usuario_baja`,
NEW.`fecha_baja`,
NEW.`estado`);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remisionrollo_BEFORE_INSERT` BEFORE INSERT ON `remisionrollo` FOR EACH ROW BEGIN
	DECLARE vcostokg DECIMAL(9,2);
    SET NEW.norollooriginal = NEW.norollo; 
    SET NEW.estado = 'ACTIVO';
    SET NEW.idrollooriginal = NEW.remisionRollo_rollo_idRollo;
    SET NEW.fecha = CURDATE();
    SET NEW.hora = CURTIME();
    SET NEW.ts = getCurrentTimeStamp();
    SET NEW.almacenOriginal = NEW.almacen;
    select costokg INTO vcostokg
    from rollo 
    where idrollo = NEW.remisionRollo_rollo_idRollo;
    SET NEW.costokg = vcostokg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `remisionrollo_BEFORE_UPDATE` BEFORE UPDATE ON `remisionrollo` FOR EACH ROW BEGIN
    IF NEW.almacen <> 'OBRA' THEN
		SET NEW.almacenOriginal = NEW.almacen;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `remisionrollohistory`
--

CREATE TABLE `remisionrollohistory` (
  `idRemisionRolloHistory` int(11) NOT NULL,
  `idRemisionRollo` int(11) NOT NULL,
  `remision` varchar(30) DEFAULT NULL,
  `remisionRollo_rollo_idRollo` int(11) DEFAULT NULL,
  `noRollo` varchar(40) DEFAULT NULL,
  `kilos` decimal(9,2) DEFAULT 0.00,
  `existencia` decimal(9,2) DEFAULT 0.00,
  `almacen` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','DELTA','OBRA') DEFAULT 'ALMACEN A',
  `almacenOriginal` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','DELTA') DEFAULT 'ALMACEN A',
  `idPedidoObra` int(11) DEFAULT 0,
  `comprador` enum('GALVAMEX','MENDEZ') DEFAULT 'GALVAMEX',
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(8) DEFAULT NULL,
  `remisionRollo_usuario_idUsuario` int(11) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT current_timestamp(),
  `norollooriginal` varchar(40) DEFAULT '',
  `idrollooriginal` int(11) DEFAULT 0,
  `usuario_baja` int(11) DEFAULT 0,
  `fecha_baja` date DEFAULT '0000-00-00',
  `estado` enum('ACTIVO','PRODUCCION','TERMINADO','BAJA') DEFAULT 'ACTIVO',
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00',
  `costokg` decimal(9,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `remisionrollohistory`
--
DELIMITER $$
CREATE TRIGGER `remisionrollohistory_BEFORE_INSERT` BEFORE INSERT ON `remisionrollohistory` FOR EACH ROW BEGIN
	SET NEW.fecha_update = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `idRol` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `descripcion` varchar(200) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `titulo` varchar(45) CHARACTER SET latin1 DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`, `descripcion`, `titulo`) VALUES
(1, 'root', 'Acceso para desarrollo, tiene permisos de todo.', ''),
(2, 'Administrador', 'Administrador del sistema', ''),
(3, 'Producción', 'Área de Producción', ''),
(4, 'Promotor', 'Promotor', ''),
(5, 'Ventas', 'Ventas', ''),
(6, 'CxC', 'Cuentas por Cobrar', ''),
(7, 'CxcVentas', 'Cuentas por Cobrar y Ventas', ''),
(8, 'Promotor Producción', 'Promotor y Producción', ''),
(9, 'Productor', 'Productor', ''),
(10, 'CxCView', 'CxC Viewer', ''),
(11, 'Promotor Produccion Sucursales', 'Promotor Producción Sucursales', ''),
(12, 'Promotor Externo', 'Promotor Externo', ''),
(13, 'Gerente Ventas', 'Gerente ventas', '');

-- --------------------------------------------------------

--
-- Table structure for table `rollo`
--

CREATE TABLE `rollo` (
  `idRollo` int(11) NOT NULL,
  `codigo` varchar(20) CHARACTER SET latin1 DEFAULT '',
  `rollo_material_idMaterial` int(11) DEFAULT NULL,
  `calibre` int(11) DEFAULT NULL,
  `pies` decimal(9,2) DEFAULT 0.00,
  `origen` enum('I','N') DEFAULT 'N',
  `rollo_proveedor_idProveedor` int(11) DEFAULT NULL,
  `grado` int(11) DEFAULT 33,
  `rollo_color_idColor` int(11) DEFAULT 1,
  `descripcion` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `observaciones` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_modifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_baja` int(11) DEFAULT 0,
  `existencia` decimal(9,2) DEFAULT 0.00,
  `apartado` double(9,2) DEFAULT 0.00,
  `iva` decimal(9,2) DEFAULT 0.00,
  `prodmes` decimal(9,2) DEFAULT 0.00,
  `porutilidad` decimal(9,2) DEFAULT 0.00,
  `porcomision` decimal(9,2) DEFAULT 0.00,
  `descuento` decimal(9,2) DEFAULT 0.00,
  `costoflete` decimal(9,2) DEFAULT 0.00,
  `costokg` decimal(9,2) DEFAULT 0.00,
  `pesokgmt` decimal(9,2) DEFAULT 0.00,
  `pesocu` decimal(9,2) DEFAULT 0.00,
  `pesoimporte` decimal(9,2) DEFAULT 0.00,
  `pesoparti` decimal(9,2) DEFAULT 0.00,
  `fmod` decimal(9,2) DEFAULT 0.00,
  `moi` decimal(9,2) DEFAULT 0.00,
  `gastosfab` decimal(9,2) DEFAULT 0.00,
  `comisiones` decimal(9,2) DEFAULT 0.00,
  `gastosventa` decimal(9,2) DEFAULT 0.00,
  `gastosfinancieros` decimal(9,2) DEFAULT 0.00,
  `gastosadmon` decimal(9,2) DEFAULT 0.00,
  `modiva` decimal(9,2) DEFAULT 0.00,
  `moiiva` decimal(9,2) DEFAULT 0.00,
  `gastosfabiva` decimal(9,2) DEFAULT 0.00,
  `comisionesiva` decimal(9,2) DEFAULT 0.00,
  `gastosventaiva` decimal(9,2) DEFAULT 0.00,
  `gastosfinancierosiva` decimal(9,2) DEFAULT 0.00,
  `gastosadmoniva` decimal(9,2) DEFAULT 0.00,
  `modparti` decimal(9,2) DEFAULT 0.00,
  `moiparti` decimal(9,2) DEFAULT 0.00,
  `gastosfabparti` decimal(9,2) DEFAULT 0.00,
  `comisionesparti` decimal(9,2) DEFAULT 0.00,
  `gastosventaparti` decimal(9,2) DEFAULT 0.00,
  `gastosfinancierosparti` decimal(9,2) DEFAULT 0.00,
  `gastosadmonparti` decimal(9,2) DEFAULT 0.00,
  `totalessummes` decimal(9,2) DEFAULT 0.00,
  `totalessumkg` decimal(9,2) DEFAULT 0.00,
  `totalespeso` decimal(9,2) DEFAULT 0.00,
  `totalesfab` decimal(9,2) DEFAULT 0.00,
  `totalcostofab` decimal(9,2) DEFAULT 0.00,
  `totalpreciovta` decimal(9,2) DEFAULT 0.00,
  `totalpreciovtar2` decimal(9,2) DEFAULT 0.00,
  `totalpreciovtar3` decimal(9,2) DEFAULT 0.00,
  `totalpreciovtar4` decimal(9,2) DEFAULT 0.00,
  `totalpreciomendez` decimal(9,2) DEFAULT 0.00,
  `lastUpdate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `rollo`
--
DELIMITER $$
CREATE TRIGGER `rollo_AFTER_UPDATE` AFTER UPDATE ON `rollo` FOR EACH ROW BEGIN
	DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
	DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
	IF (OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.totalpreciovta;
       SET vp2 = NEW.totalpreciovtar2;
       SET vp3 = NEW.totalpreciovtar3;
       SET vp4 = NEW.totalpreciovtar4;
       SET vpm = NEW.totalpreciomendez;
       SET vcu = NEW.pesocu;
       UPDATE producto 
          SET precio1 = vp1 * mlpieza, 
              precio2 = vp2 * mlpieza, 
              precio3 = vp3 * mlpieza,
              precio4 = vp4 * mlpieza,
              preciomendez = vpm * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'NO';
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4,
              preciomendez = vpm              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'NO';
		UPDATE producto 
          SET precio1 = (vp1*.85) * mlpieza, 
              precio2 = (vp1*.85) * mlpieza, 
              precio3 = (vp1*.85) * mlpieza,
              precio4 = (vp1*.85) * mlpieza,
              preciomendez = (vp1*.85) * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'SI';
	   UPDATE producto 
          SET precio1 = (vp1*.85),
              precio2 = (vp1*.85),
              precio3 = (vp1*.85),
              precio4 = (vp1*.85),
              preciomendez = (vp1*.85)              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'SI';
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rollo_BEFORE_UPDATE` BEFORE UPDATE ON `rollo` FOR EACH ROW BEGIN
    
	IF OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu THEN
	   
		SET NEW.lastUpdate = NOW();
		
		UPDATE configuracion SET rolloprodlastupdate = NOW() WHERE idConfiguracion = 1;
		
	END IF;
	

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ruta`
--

CREATE TABLE `ruta` (
  `idRuta` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT '',
  `descripcion` varchar(255) DEFAULT '',
  `fecha_crea` varchar(45) DEFAULT '0000-00-00 00:0:00',
  `id_usuario_crea` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rutaenvio`
--

CREATE TABLE `rutaenvio` (
  `idRutaEnvio` int(11) NOT NULL,
  `idRuta` int(11) DEFAULT 0,
  `fecha` date DEFAULT '0000-00-00',
  `turno` enum('MATUTINO','VESPERTINO') DEFAULT 'MATUTINO',
  `maxml` decimal(15,2) DEFAULT 0.00,
  `maxpeso` decimal(15,2) DEFAULT 0.00,
  `estado` enum('CREADA','VEHICULOASIGNADO','ENRUTA','TERMINADA') DEFAULT 'CREADA',
  `noPedidos` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rutaenviodetalle`
--

CREATE TABLE `rutaenviodetalle` (
  `idRutaEnvioDetalle` int(11) NOT NULL,
  `idRutaEnvio` int(11) DEFAULT 0,
  `idPedido` int(11) DEFAULT 0,
  `idValeSalida` int(11) DEFAULT 0,
  `maxml` decimal(15,2) DEFAULT 0.00,
  `maxpeso` decimal(15,2) DEFAULT 0.00,
  `enRuta` enum('SI','NO') DEFAULT 'NO',
  `orden` int(11) DEFAULT 0,
  `idRutaEnvioVehiculo` int(11) DEFAULT 0,
  `ordenVehiculo` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `rutaenviodetalle`
--
DELIMITER $$
CREATE TRIGGER `rutaenviodetalle_AFTER_DELETE` AFTER DELETE ON `rutaenviodetalle` FOR EACH ROW BEGIN
	/* idRutaEnvio, idPedido, maxml, maxpeso, enRuta, orden */
    /*UPDATE pedido SET tipoRuta = 'REENRUTAR' WHERE idPedido = OLD.idPedido;*/
    DECLARE vml DECIMAL(15,2);
    DECLARE vkg DECIMAL(15,2);
    DECLARE vv INT;
    DECLARE vCuantosValesEnVehiculo INT;
    UPDATE valesalida SET tipoRuta = 'REENRUTAR' WHERE idValeSalida = OLD.idValeSalida;
    SELECT ifnull(max(maxml),0), ifnull(sum(maxpeso),0) INTO vml, vkg
     FROM rutaenviodetalle where idRutaEnvio = OLD.idRutaEnvio;
	 SELECT ifnull(count(*),0) INTO vv 
      FROM rutaenviodetalle where idRutaEnvio = OLD.idRutaEnvio;
    UPDATE rutaenvio SET maxml = vml, maxpeso = vkg, nopedidos= vv WHERE idRutaEnvio = OLD.idRutaEnvio;
    -- UPDATE rutaenvio SET maxml = vml, maxpeso = vkg WHERE idRutaEnvio = OLD.idRutaEnvio;
    SELECT ifnull(count(*),0) INTO vCuantosValesEnVehiculo
     FROM rutaenviodetalle where idRutaEnvioVehiculo = OLD.idRutaEnvioVehiculo;
    IF vCuantosValesEnVehiculo = 0 THEN
		DELETE FROM rutaenviovehiculo where idRutaEnvioVehiculo = OLD.idRutaEnvioVehiculo and estatus <> 'COMPLETADO';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rutaenviodetalle_AFTER_INSERT` AFTER INSERT ON `rutaenviodetalle` FOR EACH ROW BEGIN
    DECLARE vMaxKG DECIMAL(15,2);
    DECLARE vMaxML DECIMAL(15,2);
	SELECT maxml, maxpeso INTO vMaxML, vMaxKG
      FROM rutaenvio
	 WHERE idRutaEnvio = NEW.idRutaEnvio;
    IF NEW.maxml > vMaxML THEN
		UPDATE rutaenvio SET maxml = NEW.maxml, maxpeso = maxpeso + NEW.maxpeso ,
           noPedidos = noPedidos + 1
           WHERE idRutaEnvio = NEW.idRutaEnvio;
	ELSE
		UPDATE rutaenvio SET maxpeso = maxpeso + NEW.maxpeso , noPedidos = noPedidos + 1
           WHERE idRutaEnvio = NEW.idRutaEnvio;
    END IF;
    /*UPDATE pedido 
		SET tipoRuta = 'ENRUTA',
            idRutaenvio = NEW.idRutaEnvio
		WHERE idPedido = NEW.idPedido;*/
	UPDATE valesalida 
		SET tipoRuta = 'ENRUTA',
            idRutaenvio = NEW.idRutaEnvio
		WHERE idValeSalida = NEW.idValeSalida;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rutaenviodetalle_BEFORE_INSERT` BEFORE INSERT ON `rutaenviodetalle` FOR EACH ROW BEGIN
	DECLARE vUltimo INTEGER;
    SELECT MAX(orden) INTO vUltimo
      FROM rutaenviodetalle
	 WHERE idRutaEnvio = NEW.idRutaEnvio;
    SET vUltimo = IFNULL(vUltimo, 0);
	SET NEW.orden = vUltimo + 1;    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rutaenviovehiculo`
--

CREATE TABLE `rutaenviovehiculo` (
  `idRutaEnvioVehiculo` int(11) NOT NULL,
  `idRutaEnvio` int(11) DEFAULT 0,
  `idVehiculo` int(11) DEFAULT 0,
  `kilometrajeInicial` decimal(15,2) DEFAULT 0.00,
  `kilometrajeFinal` decimal(15,2) DEFAULT 0.00,
  `cargoGasolina` enum('SI','NO') DEFAULT 'NO',
  `litros` decimal(9,2) DEFAULT 0.00,
  `tipoCombustible` enum('NA','MAGNA','PREMIUM','DIESEL') DEFAULT 'NA',
  `id_usuario_regreso` int(11) DEFAULT 0,
  `fecha_regreso` datetime DEFAULT '0000-00-00 00:00:00',
  `estatus` enum('ASIGNADO','ENRUTA','COMPLETADO') DEFAULT 'ASIGNADO',
  `id_usuario_envio` int(11) DEFAULT 0,
  `fecha_envio` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_asignado` int(11) DEFAULT 0,
  `fecha_asignado` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `rutaenviovehiculo`
--
DELIMITER $$
CREATE TRIGGER `rutaenviovehiculo_AFTER_UPDATE` AFTER UPDATE ON `rutaenviovehiculo` FOR EACH ROW BEGIN
	DECLARE vIncompletos INT;
	SET vIncompletos = 100;
    SELECT count(*) INTO vIncompletos
	FROM rutaenviovehiculo
	where idrutaenvio = NEW.idRutaEnvio
	and estatus <> 'COMPLETADO';
    IF vIncompletos = 0 THEN
		UPDATE rutaenvio
        SET estado = 'TERMINADA'
        WHERE idRutaEnvio = NEW.idRutaEnvio;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sucursal`
--

CREATE TABLE `sucursal` (
  `idSucursal` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT '',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creacion` int(11) DEFAULT 0,
  `visible` enum('SI','NO') DEFAULT 'SI'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `sucursal`
--
DELIMITER $$
CREATE TRIGGER `sucursal_AFTER_INSERT` AFTER INSERT ON `sucursal` FOR EACH ROW BEGIN
	insert into inventariosucursal (idSucursal, idProducto, existencia, apartado)
	select NEW.idSucursal, idProducto, 0, 0 
    from producto
	where producto_unidad_idUnidad = 4;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tipogasto`
--

CREATE TABLE `tipogasto` (
  `idTipoGasto` int(11) NOT NULL,
  `descripcion` varchar(70) DEFAULT '',
  `id_usuario_insert` int(11) DEFAULT 0,
  `fecha_insert` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_update` int(11) DEFAULT 0,
  `fecha_update` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipoproducto`
--

CREATE TABLE `tipoproducto` (
  `idTipoProducto` int(11) NOT NULL,
  `nombre` varchar(70) DEFAULT NULL,
  `clave` varchar(3) DEFAULT NULL,
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO',
  `fecha_creacion` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioCrea` int(11) DEFAULT 0,
  `fecha_modifica` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioModifica` int(11) DEFAULT 0,
  `fecha_baja` datetime DEFAULT '0000-00-00 00:00:00',
  `idUsuarioBaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tomainventario`
--

CREATE TABLE `tomainventario` (
  `idTomaInventario` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_inicio` int(11) DEFAULT 0,
  `fecha_fin` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_fin` int(11) DEFAULT 0,
  `estado` enum('ACTIVO','TOMADO') DEFAULT 'ACTIVO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tomainventariodetalle`
--

CREATE TABLE `tomainventariodetalle` (
  `idTomaInventarioDetalle` int(11) NOT NULL,
  `idTomaInventario` int(11) DEFAULT 0,
  `idRemisionRollo` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `norollo` varchar(40) DEFAULT '',
  `idRolloOriginal` int(11) DEFAULT 0,
  `idRolloUpdate` int(11) DEFAULT 0,
  `kilosOriginal` decimal(9,2) DEFAULT 0.00,
  `kilosUpdate` decimal(9,2) DEFAULT 0.00,
  `almacenOriginal` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO') DEFAULT 'ALMACEN PRINCIPAL',
  `almacenUpdate` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO') DEFAULT 'ALMACEN PRINCIPAL',
  `existenciaOriginal` decimal(9,2) DEFAULT 0.00,
  `existenciaUpdate` decimal(9,2) DEFAULT 0.00,
  `fecha_captura` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_captura` int(11) DEFAULT 0,
  `tipotoma` enum('NUEVO','UPDATE') DEFAULT 'UPDATE',
  `tipoproducto` enum('ROLLO','PRODUCTO') DEFAULT 'ROLLO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `tomainventariodetalle`
--
DELIMITER $$
CREATE TRIGGER `tomainventariodetalle_AFTER_INSERT` AFTER INSERT ON `tomainventariodetalle` FOR EACH ROW BEGIN
	IF NEW.idRemisionRollo > 0 AND NEW.tipotoma = 'UPDATE' THEN
        IF NEW.idRolloOriginal <> NEW.idRolloUpdate OR
           NEW.kilosOriginal <> NEW.kilosUpdate OR
           NEW.almacenOriginal <> NEW.almacenUpdate THEN
           UPDATE remisionrollo 
              SET remisionRollo_rollo_idRollo = NEW.idRolloUpdate,
                  kilos = NEW.kilosUpdate,
                  existencia = NEW.kilosUpdate,
                  almacen = NEW.almacenUpdate
			WHERE idRemisionRollo = NEW.idRemisionRollo;
           IF NEW.idRolloOriginal <> NEW.idRolloUpdate OR
			   NEW.kilosOriginal <> NEW.kilosUpdate THEN
				UPDATE rollo 
                   SET existencia = getExistenciasRollo(NEW.idRolloUpdate) 
                 WHERE idRollo = NEW.idRolloUpdate;
                 IF NEW.idRolloOriginal > 1 THEN
					 UPDATE rollo 
					   SET existencia = getExistenciasRollo(NEW.idRolloOriginal) 
					 WHERE idRollo = NEW.idRolloOriginal;
                 END IF;
           END IF;
		END IF;
	ELSE
		IF NEW.idProducto > 0 AND NEW.tipotoma = 'UPDATE' THEN
			IF NEW.existenciaOriginal > NEW.existenciaUpdate THEN			   
			   INSERT INTO invzmov (idproducto, referencia, movimiento, cantidad, observaciones, fecha_movimiento, id_usuario_movimiento)
					VALUES (NEW.idProducto, CONCAT('INVENTARIO_', NEW.idTomaInventario), 'SALIDA', (NEW.existenciaOriginal - NEW.existenciaUpdate), CONCAT('Toma de Inventario ', NEW.idTomaInventario), getCurrentTimeStamp(), 2);
			ELSE
				IF NEW.existenciaOriginal < NEW.existenciaUpdate THEN			   
					INSERT INTO invzmov (idproducto, referencia, movimiento, cantidad, observaciones, fecha_movimiento, id_usuario_movimiento)
						VALUES (NEW.idProducto, CONCAT('INVENTARIO_', NEW.idTomaInventario), 'ENTRADA', (NEW.existenciaUpdate - NEW.existenciaOriginal), CONCAT('Toma de Inventario ', NEW.idTomaInventario), getCurrentTimeStamp(), 2);
                END IF;
			END IF;
		END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tomainventariodetalle_BEFORE_INSERT` BEFORE INSERT ON `tomainventariodetalle` FOR EACH ROW BEGIN
	SET NEW.tipotoma = 'UPDATE';
	IF NEW.tipoproducto = 'ROLLO' THEN	
		IF NEW.idRemisionRollo = 0 THEN
			SET NEW.idRolloOriginal = NEW.idRolloUpdate;
			SET NEW.kilosOriginal = NEW.kilosUpdate;
			SET NEW.almacenOriginal = NEW.almacenUpdate;
			INSERT INTO remisionrollo (remision, remisionRollo_rollo_idRollo, noRollo, kilos, existencia, almacen, remisionRollo_usuario_idUsuario)    
				VALUES (CONCAT('INVENTARIO_',NEW.idTomaInventario), NEW.idRolloUpdate, NEW.norollo, NEW.kilosUpdate, NEW.kilosUpdate, NEW.almacenUpdate, 2);
			SET NEW.tipotoma = 'NUEVO';
			SET NEW.idRemisionRollo = LAST_INSERT_ID();
		END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transferenciarollo`
--

CREATE TABLE `transferenciarollo` (
  `idTransferenciaRollo` int(11) NOT NULL,
  `almacenOrigen` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','OBRA','DELTA','LAGOS','TRANSITO','EL RANCHITO') DEFAULT NULL,
  `almacenDestino` enum('ALMACEN A','ALMACEN B','ALMACEN PRINCIPAL','MCM','ALPES','CASA','NARCISO','OBRA','DELTA','LAGOS','TRANSITO','EL RANCHITO') DEFAULT NULL,
  `estatus` enum('CREADA','ACEPTADA','CANCELADA') DEFAULT 'CREADA',
  `fecha_crea` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_crea` int(11) DEFAULT 0,
  `fecha_acepta` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_acepta` varchar(45) DEFAULT '0',
  `fecha_cancela` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_cancela` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transferenciarollodetalle`
--

CREATE TABLE `transferenciarollodetalle` (
  `idTransferenciaRolloDetalle` int(11) NOT NULL,
  `idTransferenciaRollo` int(11) DEFAULT 0,
  `idRemisionRollo` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transferenciastock`
--

CREATE TABLE `transferenciastock` (
  `idTransferenciaStock` int(11) NOT NULL,
  `sucursalOrigen` int(11) DEFAULT 0,
  `sucursalDestino` int(11) DEFAULT 0,
  `estatus` enum('CREADA','ACEPTADA','CANCELADA') DEFAULT 'CREADA',
  `fecha_crea` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_crea` int(11) DEFAULT 0,
  `fecha_acepta` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_acepta` varchar(45) DEFAULT '0',
  `fecha_cancela` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_cancela` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transferenciastockdetalle`
--

CREATE TABLE `transferenciastockdetalle` (
  `idTransferenciaStockDetalle` int(11) NOT NULL,
  `idTransferenciaStock` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `cantidad` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unidad`
--

CREATE TABLE `unidad` (
  `idUnidad` int(11) NOT NULL,
  `clave` varchar(3) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usocfdi`
--

CREATE TABLE `usocfdi` (
  `idUsoCfdi` int(11) NOT NULL,
  `clave` varchar(4) DEFAULT NULL,
  `descripcion` varchar(70) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usocfdi`
--

INSERT INTO `usocfdi` (`idUsoCfdi`, `clave`, `descripcion`) VALUES
(1, 'G01', 'Adquisición de mercancias'),
(2, 'G02', 'Devoluciones, descuentos o bonificaciones'),
(3, 'G03', 'Gastos en general'),
(4, 'I01', 'Construcciones'),
(5, 'I02', 'Mobilario y equipo de oficina por inversiones'),
(6, 'I03', 'Equipo de transporte'),
(7, 'I04', 'Equipo de computo y accesorios'),
(8, 'I05', 'Dados, troqueles, moldes, matrices y herramental'),
(9, 'I06', 'Comunicaciones telefónicas'),
(10, 'I07', 'Comunicaciones satelitales'),
(11, 'I08', 'Otra maquinaria y equipo'),
(12, 'D01', 'Honorarios médicos, dentales y gastos hospitalarios.'),
(13, 'D02', 'Gastos médicos por incapacidad o discapacidad'),
(14, 'D03', 'Gastos funerales.'),
(15, 'D04', 'Donativos.'),
(16, 'D05', 'Intereses reales efectivamente pagados por créditos hipotecarios (casa'),
(17, 'D06', 'Aportaciones voluntarias al SAR.'),
(18, 'D07', 'Primas por seguros de gastos médicos.'),
(19, 'D08', 'Gastos de transportación escolar obligatoria.'),
(20, 'D09', 'Depósitos en cuentas para el ahorro, primas que tengan como base plane'),
(21, 'D10', 'Pagos por servicios educativos (colegiaturas)'),
(22, 'P01', 'Por definir');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `password` char(128) CHARACTER SET latin1 NOT NULL,
  `salt` char(128) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `apellidoPaterno` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `apellidoMaterno` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `estatus` enum('activo','suspendido','baja') CHARACTER SET latin1 NOT NULL DEFAULT 'activo',
  `idRol` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `img` varchar(100) DEFAULT '',
  `rangoComisiones` enum('ALTO','MEDIO','BAJO') DEFAULT 'BAJO',
  `cobracomision` enum('SI','NO') NOT NULL DEFAULT 'NO',
  `capturaPedido` enum('SI','NO') NOT NULL DEFAULT 'NO',
  `credito` double DEFAULT 0,
  `usado` double DEFAULT 0,
  `tokendevice` varchar(255) DEFAULT '',
  `idSucursal` int(11) DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `api_token` varchar(60) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT '',
  `whatsappStatus` enum('ACTIVO','INACTIVO') DEFAULT 'INACTIVO',
  `wscode` varchar(6) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `username`, `email`, `password`, `salt`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `estatus`, `idRol`, `img`, `rangoComisiones`, `cobracomision`, `capturaPedido`, `credito`, `usado`, `tokendevice`, `idSucursal`, `remember_token`, `api_token`, `whatsapp`, `whatsappStatus`, `wscode`) VALUES
(1, 'MOSTRADOR', 'mostrador@mostrador.com', '368c276f47724d3105d1c808197f148253e0594291f2c769f27fd2b99c00506d5404ae751f5ea3a2d3ce59653c5a693b49a7a938b65bf100342c3befc37bf4c7', '5bbcd33d5dc07c498ae584141c93898af2cd479914d75460f12f1f33dbc1179cd3180de8f48d38cdd0042198185e7118c9864efbd9bcfe93f19c4974ca313a42', 'MOSTRADOR', 'MOSTRADOR', '', 'activo', 4, '', 'BAJO', 'NO', 'NO', 0, 0, '', 0, NULL, NULL, '', 'INACTIVO', ''),
(2, 'Zeus', 'juan.urrutiar@outlook.com', '7cd3f5c34771bc11d2b6ecef5fb74be8fba2861120227030ff210858bc30e0fd303d77e9d105aede95fe2eddaec5c2557c8d43352374706f0085fcdace1f1569', 'fbd3a80a867e74088c3cdaa11d513264c7ee2140d4ea297e54deeecf0c87dff64aa2ec997ad063245fc227ea21f57cb4715d56be46be5bff314973f6ecdcbc29', 'SYSTEM', 'GALVAMEX', '', 'activo', 1, 'c0770895-0be0-443b-a58f-c24276b62bb1.jpg', 'BAJO', 'NO', 'NO', 0, 0, 'cU9h5CZMGQQ:APA91bHdQSTw9hg1tsRNDSQjIUatUQrklH1bkpqEgE33qTem0L43AY4BODZihPZipnsTcKN04Bm-xJXhVeZv_jzCP57TRuKrkGTuiBA0DpTA5Xr2RCYCWRZAmrp-tE165n9x9CJTRi3X', 1, '', 'DRLKXgAcub8rcu1d2YbtYDuJknOyvFIJFH6NpOO8CC94mbjmTJeulrF01ztO', '4777043987', 'ACTIVO', '415313');

--
-- Triggers `usuario`
--
DELIMITER $$
CREATE TRIGGER `usuario_AFTER_INSERT` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
	insert into favorito (idUsuario, idProducto)
	select usuario.idUsuario, producto.idProducto
	from usuario
	cross join producto
	where producto.estado = 'ACTIVO' and usuario.idUsuario = NEW.idUsuario;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usuariovistasmovil`
--

CREATE TABLE `usuariovistasmovil` (
  `idUsuarioVistasMovil` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idVistaMovil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_intento_login`
--

CREATE TABLE `usuario_intento_login` (
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `time` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `valesalida`
--

CREATE TABLE `valesalida` (
  `idValeSalida` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `estado` enum('CREADO','ENRUTA','SALIDA','ENTREGADO') DEFAULT 'CREADO',
  `generarValeSalida` enum('NO','AUNNO','SI') DEFAULT 'NO',
  `observacion_aunno` varchar(250) DEFAULT '',
  `fecha_creado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creado` int(11) DEFAULT 0,
  `fecha_salida` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_salida` varchar(45) DEFAULT '0',
  `idSucursal` int(11) DEFAULT 1,
  `chkDireccionCorrecta` enum('SI','NO') DEFAULT 'NO',
  `chkDiaCorrecto` enum('SI','NO') DEFAULT 'NO',
  `chkHorarioCorrecto` enum('SI','NO') DEFAULT 'NO',
  `chkEquipoListo` enum('SI','NO') DEFAULT 'NO',
  `chkPersonaCorrecta` enum('SI','NO') DEFAULT 'NO',
  `chkHayEspacio` enum('SI','NO') DEFAULT 'NO',
  `chkImprimirPedidoNoSaldado` enum('SI','NO') DEFAULT 'NO',
  `chkRecibeDinero` enum('SI','NO') DEFAULT 'NO',
  `personaEntrega` varchar(250) DEFAULT '',
  `domicilioEntrega` varchar(150) DEFAULT '',
  `numeroEntrega` varchar(45) DEFAULT '',
  `coloniaEntrega` varchar(70) DEFAULT '',
  `ciudadEntrega` varchar(70) DEFAULT '',
  `horaRecibe` varchar(50) DEFAULT '',
  `fechaCompromiso` datetime DEFAULT '0000-00-00 00:00:00',
  `yaImpreso` enum('SI','NO') DEFAULT 'NO',
  `pagoVSEntrega` enum('SI','NO') DEFAULT 'NO',
  `tipoRuta` enum('SINRUTA','ENRUTA','REENRUTAR') DEFAULT 'SINRUTA',
  `idRutaEnvio` int(11) DEFAULT 0,
  `id_usuario_enruta` int(11) DEFAULT 0,
  `fecha_enruta` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_entrega` int(11) DEFAULT 0,
  `fecha_entrega` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `valesalida`
--
DELIMITER $$
CREATE TRIGGER `valesalida_AFTER_UPDATE` AFTER UPDATE ON `valesalida` FOR EACH ROW BEGIN
    DECLARE vestadoPedido VARCHAR(20);
    DECLARE vvsNoCompletados INT;
    DECLARE vidPromotor INTEGER;
    DECLARE vidUsuarioCapturado INTEGER;
    DECLARE vfechaCompromisoPedido DATETIME;
         select  pedido.fechaCompromiso INTO  vfechaCompromisoPedido from pedido where idpedido = NEW.idPedido;       
         IF NEW.fechaCompromiso > vfechaCompromisoPedido  THEN update pedido set pedido.fechaCompromiso = NEW.fechaCompromiso  where          idpedido = NEW.idPedido;
         END IF;
	IF NEW.estado <> OLD.estado THEN
        IF NEW.estado = 'SALIDA' THEN
			update pedido set tipoRuta = 'ENRUTA' where idpedido = NEW.idPedido and tipoRuta = 'SINRUTA';
        END IF;
        IF NEW.estado = 'ENTREGADO' THEN
			select pedido.estado, cliente.idUsuarioPromotor, pedido.id_usuario_capturado INTO vestadoPedido, vidPromotor, vidUsuarioCapturado 
			from pedido 
            inner join cliente on cliente.idcliente = pedido.idcliente
            where idpedido = NEW.idPedido;
			select IFNULL(count(*), 0) INTO vvsNoCompletados
			from valesalida vs 
			where vs.idpedido = NEW.idPedido
			and vs.estado <> 'ENTREGADO';
            IF vestadoPedido = 'TERMINADO' and vvsNoCompletados = 0 THEN
				UPDATE pedido
				   SET estado = 'ENTREGADO',
					   fecha_entregado = NEW.fecha_entrega,
					   id_usuario_entregado = NEW.id_usuario_entrega
				 WHERE idPedido = NEW.idPedido;
				 IF vidPromotor = vidUsuarioCapturado THEN            
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' ENTREGADO'), concat('El pedido ', NEW.idPedido,' ha sido ENTREGADO en su totalidad.'), NEW.idPedido);
				ELSE
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, vidPromotor, 2, concat('Pedido ', NEW.idPedido,' ENTREGADO'), concat('El pedido ', NEW.idPedido,' ha sido ENTREGADO en su totalidad.'), NEW.idPedido);
					INSERT INTO pushnotifica (idProvoca, idPara, tipo, tema, contenido, refint)
						VALUES (2, vidUsuarioCapturado, 2, concat('Pedido ', NEW.idPedido,' ENTREGADO'), concat('El pedido ', NEW.idPedido,' ha sido ENTREGADO en su totalidad.'), NEW.idPedido);
				END IF;
			END IF;
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `valesalida_BEFORE_INSERT` BEFORE INSERT ON `valesalida` FOR EACH ROW BEGIN
	DECLARE vRecogeEntrega VARCHAR(20);
    DECLARE vpersonaEntrega VARCHAR(250);
	DECLARE vdomicilioEntrega VARCHAR(150);
	DECLARE vnumeroEntrega VARCHAR(45);
	DECLARE vcoloniaEntrega VARCHAR(70);
	DECLARE vciudadEntrega VARCHAR(70);
	DECLARE vhoraRecibe VARCHAR(50);
	DECLARE vfechaCompromiso DATETIME;
    DECLARE vidCliente INT;
    select idCliente, recogeentrega, personaEntrega, domicilioEntrega,	numeroEntrega,	coloniaEntrega, ciudadEntrega, horaRecibe, fechaCompromiso
    into vidCliente, vRecogeEntrega, vpersonaEntrega, vdomicilioEntrega,	vnumeroEntrega,	vcoloniaEntrega, vciudadEntrega, vhoraRecibe, vfechaCompromiso
    from pedido 
    where idpedido = NEW.idPedido;
    SET NEW.personaEntrega = vpersonaEntrega;
    SET NEW.domicilioEntrega = vdomicilioEntrega;
    SET NEW.numeroEntrega = vnumeroEntrega;
    SET NEW.coloniaEntrega = vcoloniaEntrega;
    SET NEW.ciudadEntrega = vciudadEntrega; 
    SET NEW.horaRecibe = vhoraRecibe;
    SET NEW.fechaCompromiso = vfechaCompromiso;
    IF vRecogeEntrega = 'RECOGE' OR vidCliente = 137 THEN
		SET NEW.chkDireccionCorrecta = 'SI';
		SET NEW.chkDiaCorrecto = 'SI';
		SET NEW.chkHorarioCorrecto = 'SI';
		SET NEW.chkEquipoListo = 'SI';
		SET NEW.chkPersonaCorrecta = 'SI';
		SET NEW.chkHayEspacio = 'SI';
        SET NEW.generarValeSalida = 'SI';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `valesalidadetalle`
--

CREATE TABLE `valesalidadetalle` (
  `idValeSalidaDetalle` int(11) NOT NULL,
  `idValeSalida` int(11) DEFAULT 0,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idPedido` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `cantidad` double DEFAULT 0,
  `fecha_despacho` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_despacho` varchar(45) DEFAULT '0',
  `idSucursalDespachado` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `valesalidapromotor`
--

CREATE TABLE `valesalidapromotor` (
  `idValeSalidaPromotor` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT 0,
  `estado` enum('CREADO','SALIDA') DEFAULT 'CREADO',
  `generarValeSalida` enum('NO','AUNNO','SI') DEFAULT 'NO',
  `observacion_aunno` varchar(250) DEFAULT '',
  `fecha_creado` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_creado` int(11) DEFAULT 0,
  `fecha_salida` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_salida` varchar(45) DEFAULT '0',
  `idSucursal` int(11) DEFAULT 1,
  `chkDireccionCorrecta` enum('SI','NO') DEFAULT 'NO',
  `chkDiaCorrecto` enum('SI','NO') DEFAULT 'NO',
  `chkHorarioCorrecto` enum('SI','NO') DEFAULT 'NO',
  `chkEquipoListo` enum('SI','NO') DEFAULT 'NO',
  `chkPersonaCorrecta` enum('SI','NO') DEFAULT 'NO',
  `chkHayEspacio` enum('SI','NO') DEFAULT 'NO',
  `chkImprimirPedidoNoSaldado` enum('SI','NO') DEFAULT 'NO',
  `idValeSalida` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `valesalidapromotor`
--
DELIMITER $$
CREATE TRIGGER `valesalidapromotor_BEFORE_DELETE` BEFORE DELETE ON `valesalidapromotor` FOR EACH ROW BEGIN
	DELETE FROM valesalidapromotordetalle
    WHERE idValeSalidaPromotor = OLD.idValeSalidaPromotor;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `valesalidapromotor_BEFORE_INSERT` BEFORE INSERT ON `valesalidapromotor` FOR EACH ROW BEGIN
	DECLARE vRecogeEntrega VARCHAR(20);
    select recogeentrega into vRecogeEntrega
    from pedido 
    where idpedido = NEW.idPedido;
    IF vRecogeEntrega = 'RECOGE' THEN
		SET NEW.chkDireccionCorrecta = 'SI';
		SET NEW.chkDiaCorrecto = 'SI';
		SET NEW.chkHorarioCorrecto = 'SI';
		SET NEW.chkEquipoListo = 'SI';
		SET NEW.chkPersonaCorrecta = 'SI';
		SET NEW.chkHayEspacio = 'SI';
		SET NEW.chkImprimirPedidoNoSaldado = 'SI';
        SET NEW.generarValeSalida = 'SI';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `valesalidapromotordetalle`
--

CREATE TABLE `valesalidapromotordetalle` (
  `idValeSalidaPromotorDetalle` int(11) NOT NULL,
  `idValeSalidaPromotor` int(11) DEFAULT 0,
  `idPedidoDetalle` int(11) DEFAULT 0,
  `idPedido` int(11) DEFAULT 0,
  `idPedidoDetalleColocacion` int(11) DEFAULT 0,
  `idProducto` int(11) DEFAULT 0,
  `cantidad` double DEFAULT 0,
  `fecha_despacho` datetime DEFAULT '0000-00-00 00:00:00',
  `id_usuario_despacho` varchar(45) DEFAULT '0',
  `idSucursalDespachado` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `valesalidapromotordetalle`
--
DELIMITER $$
CREATE TRIGGER `valesalidapromotordetalle_AFTER_DELETE` AFTER DELETE ON `valesalidapromotordetalle` FOR EACH ROW BEGIN
	UPDATE pedidodetalle 
       SET partidaenvale = partidaenvale - OLD.cantidad
     WHERE idpedidodetalle = OLD.idPedidoDetalle;
    UPDATE pedidodetallecolocacion 
       SET cantidadenvale = cantidadenvale - OLD.cantidad
     WHERE idpedidodetallecolocacion = OLD.idPedidoDetalleColocacion; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `valesalidapromotordetalle_AFTER_INSERT` AFTER INSERT ON `valesalidapromotordetalle` FOR EACH ROW BEGIN
	UPDATE pedidodetalle 
       SET partidaenvale = partidaenvale + NEW.cantidad
     WHERE idpedidodetalle = NEW.idPedidoDetalle;
	UPDATE pedidodetallecolocacion 
       SET cantidadenvale = cantidadenvale + NEW.cantidad
     WHERE idpedidodetallecolocacion = NEW.idPedidoDetalleColocacion;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vehiculo`
--

CREATE TABLE `vehiculo` (
  `idVehiculo` int(11) NOT NULL,
  `placas` varchar(45) DEFAULT '0',
  `descripcion` varchar(155) DEFAULT '0',
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `disponibilidad` enum('DISPONIBLE','ENRUTA','ENREPARACION') DEFAULT 'DISPONIBLE'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aplicacion`
--
ALTER TABLE `aplicacion`
  ADD PRIMARY KEY (`idAplicacion`),
  ADD UNIQUE KEY `nombreModeloLamina_UNIQUE` (`nombreAplicacion`);

--
-- Indexes for table `aportacionesmendez`
--
ALTER TABLE `aportacionesmendez`
  ADD PRIMARY KEY (`idAportacionMendez`);

--
-- Indexes for table `cambioprecio`
--
ALTER TABLE `cambioprecio`
  ADD PRIMARY KEY (`idCambioPrecio`);

--
-- Indexes for table `cambiopreciodobles`
--
ALTER TABLE `cambiopreciodobles`
  ADD PRIMARY KEY (`idCambioPrecioDobles`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `clientedatosfacturacion`
--
ALTER TABLE `clientedatosfacturacion`
  ADD PRIMARY KEY (`idClienteDatosFacturacion`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`idColor`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indexes for table `conceptogasto`
--
ALTER TABLE `conceptogasto`
  ADD PRIMARY KEY (`idConceptoGasto`),
  ADD UNIQUE KEY `nombreConceptoGasto_UNIQUE` (`nombre`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`idConfiguracion`);

--
-- Indexes for table `configuracionlog`
--
ALTER TABLE `configuracionlog`
  ADD PRIMARY KEY (`idConfiguracionLog`);

--
-- Indexes for table `correo`
--
ALTER TABLE `correo`
  ADD PRIMARY KEY (`idCorreo`);

--
-- Indexes for table `cortecaja`
--
ALTER TABLE `cortecaja`
  ADD PRIMARY KEY (`idCorteCaja`),
  ADD UNIQUE KEY `idCorteCaja_UNIQUE` (`idCorteCaja`);

--
-- Indexes for table `cortecomision`
--
ALTER TABLE `cortecomision`
  ADD PRIMARY KEY (`idCorteComision`);

--
-- Indexes for table `cortecomisionroofing`
--
ALTER TABLE `cortecomisionroofing`
  ADD PRIMARY KEY (`idCorteComisionRoofing`);

--
-- Indexes for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`idCotizacion`),
  ADD KEY `fk_pedido_cliente_idx` (`idCliente`);

--
-- Indexes for table `cotizaciondetalle`
--
ALTER TABLE `cotizaciondetalle`
  ADD PRIMARY KEY (`idCotizacionDetalle`),
  ADD KEY `fk_pedidodetalle_pedido_idx` (`IdCotizacion`);

--
-- Indexes for table `cotizacionrechazada`
--
ALTER TABLE `cotizacionrechazada`
  ADD PRIMARY KEY (`idCotizacionRechazada`);

--
-- Indexes for table `cxc`
--
ALTER TABLE `cxc`
  ADD PRIMARY KEY (`idCxc`);

--
-- Indexes for table `cxccortecomision`
--
ALTER TABLE `cxccortecomision`
  ADD PRIMARY KEY (`idCxcCorteComision`);

--
-- Indexes for table `cxccortecomisionroofing`
--
ALTER TABLE `cxccortecomisionroofing`
  ADD PRIMARY KEY (`idCxcCorteComisionRoofing`);

--
-- Indexes for table `cxccuentacomision`
--
ALTER TABLE `cxccuentacomision`
  ADD PRIMARY KEY (`idCxcCuentaComision`);

--
-- Indexes for table `cxccuentacomisionroofing`
--
ALTER TABLE `cxccuentacomisionroofing`
  ADD PRIMARY KEY (`idCxcCuentaComisionRoofing`);

--
-- Indexes for table `cxcdeleted`
--
ALTER TABLE `cxcdeleted`
  ADD PRIMARY KEY (`idCxc`);

--
-- Indexes for table `cxcpromotor`
--
ALTER TABLE `cxcpromotor`
  ADD PRIMARY KEY (`idCxcPromotor`);

--
-- Indexes for table `cxcpromotordeleted`
--
ALTER TABLE `cxcpromotordeleted`
  ADD PRIMARY KEY (`idCxcPromotor`);

--
-- Indexes for table `datosfacturacion`
--
ALTER TABLE `datosfacturacion`
  ADD PRIMARY KEY (`idDatosFacturacion`);

--
-- Indexes for table `espesor`
--
ALTER TABLE `espesor`
  ADD PRIMARY KEY (`idEspesor`);

--
-- Indexes for table `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`idFavorito`),
  ADD KEY `IDX_USUARIO_FAVORITO` (`idUsuario`),
  ADD KEY `IDX_PRODUCTO_FAVORITO` (`idProducto`);

--
-- Indexes for table `formapago`
--
ALTER TABLE `formapago`
  ADD PRIMARY KEY (`idFormaPago`);

--
-- Indexes for table `gasto`
--
ALTER TABLE `gasto`
  ADD PRIMARY KEY (`idGasto`),
  ADD UNIQUE KEY `idGasto_UNIQUE` (`idGasto`);

--
-- Indexes for table `incentivo`
--
ALTER TABLE `incentivo`
  ADD PRIMARY KEY (`idIncentivo`);

--
-- Indexes for table `inventariosucursal`
--
ALTER TABLE `inventariosucursal`
  ADD PRIMARY KEY (`idInventarioSucursal`);

--
-- Indexes for table `invzmov`
--
ALTER TABLE `invzmov`
  ADD PRIMARY KEY (`idInvzmov`);

--
-- Indexes for table `invzmovnorollo`
--
ALTER TABLE `invzmovnorollo`
  ADD PRIMARY KEY (`idinvzmovnorollo`);

--
-- Indexes for table `invzmovrollo`
--
ALTER TABLE `invzmovrollo`
  ADD PRIMARY KEY (`idInvzmovRollo`);

--
-- Indexes for table `invzstocknorollo`
--
ALTER TABLE `invzstocknorollo`
  ADD PRIMARY KEY (`idInvzStockNoRollo`);

--
-- Indexes for table `listaprecio`
--
ALTER TABLE `listaprecio`
  ADD PRIMARY KEY (`idListaPrecio`);

--
-- Indexes for table `listapreciodetalle`
--
ALTER TABLE `listapreciodetalle`
  ADD PRIMARY KEY (`idListaPrecioDetalle`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`idMaterial`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- Indexes for table `motivorechazo`
--
ALTER TABLE `motivorechazo`
  ADD PRIMARY KEY (`idMotivoRechazo`);

--
-- Indexes for table `movrecibodinero`
--
ALTER TABLE `movrecibodinero`
  ADD PRIMARY KEY (`idmovReciboDinero`);

--
-- Indexes for table `movsapartado`
--
ALTER TABLE `movsapartado`
  ADD PRIMARY KEY (`idMosvApartado`);

--
-- Indexes for table `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`idNotificacion`);

--
-- Indexes for table `notificacionescortes`
--
ALTER TABLE `notificacionescortes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objetivopromotor`
--
ALTER TABLE `objetivopromotor`
  ADD PRIMARY KEY (`idObjetivoPromotor`);

--
-- Indexes for table `otrocargo`
--
ALTER TABLE `otrocargo`
  ADD PRIMARY KEY (`idOtroCargo`);

--
-- Indexes for table `otromotivodescripcion`
--
ALTER TABLE `otromotivodescripcion`
  ADD PRIMARY KEY (`IdOtroMotivoDescripcion`);

--
-- Indexes for table `otroscargoscotizacion`
--
ALTER TABLE `otroscargoscotizacion`
  ADD PRIMARY KEY (`idOtrosCargosCotizacion`),
  ADD KEY `otroscargoscotizacion_idOtrosCargosCotizacion_idx` (`idOtrosCargosCotizacion`) USING BTREE;

--
-- Indexes for table `otroscargospedido`
--
ALTER TABLE `otroscargospedido`
  ADD PRIMARY KEY (`idOtrosCargosPedido`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_pedido_cliente_idx` (`idCliente`),
  ADD KEY `estado` (`estado`);

--
-- Indexes for table `pedidodetalle`
--
ALTER TABLE `pedidodetalle`
  ADD PRIMARY KEY (`idPedidoDetalle`),
  ADD KEY `fk_pedidodetalle_pedido_idx` (`IdPedido`);

--
-- Indexes for table `pedidodetallecolocacion`
--
ALTER TABLE `pedidodetallecolocacion`
  ADD PRIMARY KEY (`idPedidoDetalleColocacion`),
  ADD UNIQUE KEY `pdc_ipd_suc` (`idPedidoDetalle`,`idSucursal`);

--
-- Indexes for table `pedidostracking`
--
ALTER TABLE `pedidostracking`
  ADD PRIMARY KEY (`idPedidosTracking`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Indexes for table `pedidotrace`
--
ALTER TABLE `pedidotrace`
  ADD PRIMARY KEY (`idPedidoTrace`);

--
-- Indexes for table `pesomt`
--
ALTER TABLE `pesomt`
  ADD PRIMARY KEY (`idPesoMt`),
  ADD UNIQUE KEY `calibre_UNIQUE` (`calibre`);

--
-- Indexes for table `precioacrilica`
--
ALTER TABLE `precioacrilica`
  ADD PRIMARY KEY (`idPrecioAcrilica`);

--
-- Indexes for table `precioacrilicahistory`
--
ALTER TABLE `precioacrilicahistory`
  ADD PRIMARY KEY (`idPrecioAcrilica`);

--
-- Indexes for table `precioxdobles`
--
ALTER TABLE `precioxdobles`
  ADD PRIMARY KEY (`idPrecioXDobles`),
  ADD KEY `idx_precioxdobles` (`tipoPrecio`,`desarrollo`,`calibre`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `idx_codigo_long` (`codigo`,`longitud`),
  ADD KEY `fk_lamina_modelolamina_idx` (`producto_aplicacion_idAplicacion`),
  ADD KEY `fk_lamina_material_idx` (`producto_material_idMaterial`),
  ADD KEY `fk_lamina_rollo_idx` (`producto_rollo_idRollo`),
  ADD KEY `fk_lamina_tipoproducto_idx` (`producto_tipoProducto_idTipoProducto`),
  ADD KEY `fk_producto_unidad_idx` (`producto_unidad_idUnidad`);

--
-- Indexes for table `productopanel`
--
ALTER TABLE `productopanel`
  ADD PRIMARY KEY (`idPesoPanel`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indexes for table `pushnotifica`
--
ALTER TABLE `pushnotifica`
  ADD PRIMARY KEY (`idPushNotifica`);

--
-- Indexes for table `recibodinero`
--
ALTER TABLE `recibodinero`
  ADD PRIMARY KEY (`idReciboDinero`);

--
-- Indexes for table `regimenfiscal`
--
ALTER TABLE `regimenfiscal`
  ADD PRIMARY KEY (`idRegimenFiscal`),
  ADD UNIQUE KEY `idRegimenFiscal_UNIQUE` (`idRegimenFiscal`),
  ADD UNIQUE KEY `regimenfiscal_codigo_UNIQUE` (`codigo`);

--
-- Indexes for table `registroproduccion`
--
ALTER TABLE `registroproduccion`
  ADD PRIMARY KEY (`idRegistroProduccion`);

--
-- Indexes for table `registroproducciondetalle`
--
ALTER TABLE `registroproducciondetalle`
  ADD PRIMARY KEY (`idRegistroProduccionDetalle`);

--
-- Indexes for table `remisionrollo`
--
ALTER TABLE `remisionrollo`
  ADD PRIMARY KEY (`idRemisionRollo`),
  ADD KEY `ix_remisionrollo_idRollo` (`remisionRollo_rollo_idRollo`),
  ADD KEY `fk_remisionrollo_usuario` (`remisionRollo_usuario_idUsuario`);

--
-- Indexes for table `remisionrollohistory`
--
ALTER TABLE `remisionrollohistory`
  ADD PRIMARY KEY (`idRemisionRolloHistory`),
  ADD KEY `ix_remisionrollo_idRollo` (`remisionRollo_rollo_idRollo`),
  ADD KEY `fk_remisionrollo_usuario` (`remisionRollo_usuario_idUsuario`),
  ADD KEY `ix_idremisionrollo` (`idRemisionRollo`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indexes for table `rollo`
--
ALTER TABLE `rollo`
  ADD PRIMARY KEY (`idRollo`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `fk_rollo_material_idx` (`rollo_material_idMaterial`),
  ADD KEY `fk_rollo_proveedor_idx` (`rollo_proveedor_idProveedor`);

--
-- Indexes for table `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`idRuta`);

--
-- Indexes for table `rutaenvio`
--
ALTER TABLE `rutaenvio`
  ADD PRIMARY KEY (`idRutaEnvio`);

--
-- Indexes for table `rutaenviodetalle`
--
ALTER TABLE `rutaenviodetalle`
  ADD PRIMARY KEY (`idRutaEnvioDetalle`);

--
-- Indexes for table `rutaenviovehiculo`
--
ALTER TABLE `rutaenviovehiculo`
  ADD PRIMARY KEY (`idRutaEnvioVehiculo`);

--
-- Indexes for table `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`idSucursal`);

--
-- Indexes for table `tipogasto`
--
ALTER TABLE `tipogasto`
  ADD PRIMARY KEY (`idTipoGasto`),
  ADD UNIQUE KEY `idConceptoGasto_UNIQUE` (`idTipoGasto`);

--
-- Indexes for table `tipoproducto`
--
ALTER TABLE `tipoproducto`
  ADD PRIMARY KEY (`idTipoProducto`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD UNIQUE KEY `clave_UNIQUE` (`clave`);

--
-- Indexes for table `tomainventario`
--
ALTER TABLE `tomainventario`
  ADD PRIMARY KEY (`idTomaInventario`);

--
-- Indexes for table `tomainventariodetalle`
--
ALTER TABLE `tomainventariodetalle`
  ADD PRIMARY KEY (`idTomaInventarioDetalle`);

--
-- Indexes for table `transferenciarollo`
--
ALTER TABLE `transferenciarollo`
  ADD PRIMARY KEY (`idTransferenciaRollo`);

--
-- Indexes for table `transferenciarollodetalle`
--
ALTER TABLE `transferenciarollodetalle`
  ADD PRIMARY KEY (`idTransferenciaRolloDetalle`);

--
-- Indexes for table `transferenciastock`
--
ALTER TABLE `transferenciastock`
  ADD PRIMARY KEY (`idTransferenciaStock`);

--
-- Indexes for table `transferenciastockdetalle`
--
ALTER TABLE `transferenciastockdetalle`
  ADD PRIMARY KEY (`idTransferenciaStockDetalle`);

--
-- Indexes for table `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`idUnidad`);

--
-- Indexes for table `usocfdi`
--
ALTER TABLE `usocfdi`
  ADD PRIMARY KEY (`idUsoCfdi`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `user_unique` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `fk_login_rol_idx` (`idRol`);

--
-- Indexes for table `usuariovistasmovil`
--
ALTER TABLE `usuariovistasmovil`
  ADD PRIMARY KEY (`idUsuarioVistasMovil`);

--
-- Indexes for table `valesalida`
--
ALTER TABLE `valesalida`
  ADD PRIMARY KEY (`idValeSalida`);

--
-- Indexes for table `valesalidadetalle`
--
ALTER TABLE `valesalidadetalle`
  ADD PRIMARY KEY (`idValeSalidaDetalle`),
  ADD KEY `idxValeSalidaDetalleIdPedido` (`idPedido`);

--
-- Indexes for table `valesalidapromotor`
--
ALTER TABLE `valesalidapromotor`
  ADD PRIMARY KEY (`idValeSalidaPromotor`),
  ADD KEY `idx_valedalidapromotor_idpedido` (`idPedido`);

--
-- Indexes for table `valesalidapromotordetalle`
--
ALTER TABLE `valesalidapromotordetalle`
  ADD PRIMARY KEY (`idValeSalidaPromotorDetalle`),
  ADD KEY `idxValeSalidaPromotorDetalleIdPedido` (`idPedido`);

--
-- Indexes for table `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`idVehiculo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplicacion`
--
ALTER TABLE `aplicacion`
  MODIFY `idAplicacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aportacionesmendez`
--
ALTER TABLE `aportacionesmendez`
  MODIFY `idAportacionMendez` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cambioprecio`
--
ALTER TABLE `cambioprecio`
  MODIFY `idCambioPrecio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cambiopreciodobles`
--
ALTER TABLE `cambiopreciodobles`
  MODIFY `idCambioPrecioDobles` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientedatosfacturacion`
--
ALTER TABLE `clientedatosfacturacion`
  MODIFY `idClienteDatosFacturacion` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `idColor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `idConfiguracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `configuracionlog`
--
ALTER TABLE `configuracionlog`
  MODIFY `idConfiguracionLog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `correo`
--
ALTER TABLE `correo`
  MODIFY `idCorreo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cortecaja`
--
ALTER TABLE `cortecaja`
  MODIFY `idCorteCaja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cortecomision`
--
ALTER TABLE `cortecomision`
  MODIFY `idCorteComision` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cortecomisionroofing`
--
ALTER TABLE `cortecomisionroofing`
  MODIFY `idCorteComisionRoofing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `idCotizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizaciondetalle`
--
ALTER TABLE `cotizaciondetalle`
  MODIFY `idCotizacionDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacionrechazada`
--
ALTER TABLE `cotizacionrechazada`
  MODIFY `idCotizacionRechazada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxc`
--
ALTER TABLE `cxc`
  MODIFY `idCxc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxccortecomision`
--
ALTER TABLE `cxccortecomision`
  MODIFY `idCxcCorteComision` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxccortecomisionroofing`
--
ALTER TABLE `cxccortecomisionroofing`
  MODIFY `idCxcCorteComisionRoofing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxccuentacomision`
--
ALTER TABLE `cxccuentacomision`
  MODIFY `idCxcCuentaComision` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxccuentacomisionroofing`
--
ALTER TABLE `cxccuentacomisionroofing`
  MODIFY `idCxcCuentaComisionRoofing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cxcpromotor`
--
ALTER TABLE `cxcpromotor`
  MODIFY `idCxcPromotor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `datosfacturacion`
--
ALTER TABLE `datosfacturacion`
  MODIFY `idDatosFacturacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `espesor`
--
ALTER TABLE `espesor`
  MODIFY `idEspesor` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorito`
--
ALTER TABLE `favorito`
  MODIFY `idFavorito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formapago`
--
ALTER TABLE `formapago`
  MODIFY `idFormaPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gasto`
--
ALTER TABLE `gasto`
  MODIFY `idGasto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incentivo`
--
ALTER TABLE `incentivo`
  MODIFY `idIncentivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventariosucursal`
--
ALTER TABLE `inventariosucursal`
  MODIFY `idInventarioSucursal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invzmov`
--
ALTER TABLE `invzmov`
  MODIFY `idInvzmov` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invzmovnorollo`
--
ALTER TABLE `invzmovnorollo`
  MODIFY `idinvzmovnorollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invzmovrollo`
--
ALTER TABLE `invzmovrollo`
  MODIFY `idInvzmovRollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invzstocknorollo`
--
ALTER TABLE `invzstocknorollo`
  MODIFY `idInvzStockNoRollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listaprecio`
--
ALTER TABLE `listaprecio`
  MODIFY `idListaPrecio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listapreciodetalle`
--
ALTER TABLE `listapreciodetalle`
  MODIFY `idListaPrecioDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `idMaterial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `motivorechazo`
--
ALTER TABLE `motivorechazo`
  MODIFY `idMotivoRechazo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movrecibodinero`
--
ALTER TABLE `movrecibodinero`
  MODIFY `idmovReciboDinero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movsapartado`
--
ALTER TABLE `movsapartado`
  MODIFY `idMosvApartado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `idNotificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificacionescortes`
--
ALTER TABLE `notificacionescortes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `objetivopromotor`
--
ALTER TABLE `objetivopromotor`
  MODIFY `idObjetivoPromotor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otrocargo`
--
ALTER TABLE `otrocargo`
  MODIFY `idOtroCargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otromotivodescripcion`
--
ALTER TABLE `otromotivodescripcion`
  MODIFY `IdOtroMotivoDescripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otroscargoscotizacion`
--
ALTER TABLE `otroscargoscotizacion`
  MODIFY `idOtrosCargosCotizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otroscargospedido`
--
ALTER TABLE `otroscargospedido`
  MODIFY `idOtrosCargosPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidodetalle`
--
ALTER TABLE `pedidodetalle`
  MODIFY `idPedidoDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidodetallecolocacion`
--
ALTER TABLE `pedidodetallecolocacion`
  MODIFY `idPedidoDetalleColocacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidostracking`
--
ALTER TABLE `pedidostracking`
  MODIFY `idPedidosTracking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidotrace`
--
ALTER TABLE `pedidotrace`
  MODIFY `idPedidoTrace` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pushnotifica`
--
ALTER TABLE `pushnotifica`
  MODIFY `idPushNotifica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recibodinero`
--
ALTER TABLE `recibodinero`
  MODIFY `idReciboDinero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regimenfiscal`
--
ALTER TABLE `regimenfiscal`
  MODIFY `idRegimenFiscal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registroproduccion`
--
ALTER TABLE `registroproduccion`
  MODIFY `idRegistroProduccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registroproducciondetalle`
--
ALTER TABLE `registroproducciondetalle`
  MODIFY `idRegistroProduccionDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remisionrollo`
--
ALTER TABLE `remisionrollo`
  MODIFY `idRemisionRollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remisionrollohistory`
--
ALTER TABLE `remisionrollohistory`
  MODIFY `idRemisionRolloHistory` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rollo`
--
ALTER TABLE `rollo`
  MODIFY `idRollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruta`
--
ALTER TABLE `ruta`
  MODIFY `idRuta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rutaenvio`
--
ALTER TABLE `rutaenvio`
  MODIFY `idRutaEnvio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rutaenviodetalle`
--
ALTER TABLE `rutaenviodetalle`
  MODIFY `idRutaEnvioDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rutaenviovehiculo`
--
ALTER TABLE `rutaenviovehiculo`
  MODIFY `idRutaEnvioVehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipogasto`
--
ALTER TABLE `tipogasto`
  MODIFY `idTipoGasto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipoproducto`
--
ALTER TABLE `tipoproducto`
  MODIFY `idTipoProducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tomainventario`
--
ALTER TABLE `tomainventario`
  MODIFY `idTomaInventario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tomainventariodetalle`
--
ALTER TABLE `tomainventariodetalle`
  MODIFY `idTomaInventarioDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferenciarollo`
--
ALTER TABLE `transferenciarollo`
  MODIFY `idTransferenciaRollo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferenciarollodetalle`
--
ALTER TABLE `transferenciarollodetalle`
  MODIFY `idTransferenciaRolloDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferenciastock`
--
ALTER TABLE `transferenciastock`
  MODIFY `idTransferenciaStock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferenciastockdetalle`
--
ALTER TABLE `transferenciastockdetalle`
  MODIFY `idTransferenciaStockDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidad`
--
ALTER TABLE `unidad`
  MODIFY `idUnidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usocfdi`
--
ALTER TABLE `usocfdi`
  MODIFY `idUsoCfdi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `usuariovistasmovil`
--
ALTER TABLE `usuariovistasmovil`
  MODIFY `idUsuarioVistasMovil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valesalida`
--
ALTER TABLE `valesalida`
  MODIFY `idValeSalida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valesalidadetalle`
--
ALTER TABLE `valesalidadetalle`
  MODIFY `idValeSalidaDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valesalidapromotor`
--
ALTER TABLE `valesalidapromotor`
  MODIFY `idValeSalidaPromotor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valesalidapromotordetalle`
--
ALTER TABLE `valesalidapromotordetalle`
  MODIFY `idValeSalidaPromotorDetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rollo`
--
ALTER TABLE `rollo`
  ADD CONSTRAINT `fk_rollo_material` FOREIGN KEY (`rollo_material_idMaterial`) REFERENCES `material` (`idMaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rollo_proveedor` FOREIGN KEY (`rollo_proveedor_idProveedor`) REFERENCES `proveedor` (`idProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;












INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('-- NO APLICA --','NA',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('PINTRO SULTANA','PS',now(), 2);
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ZINTRO ALUM','ZA',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('GALVANIZADO','GA',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('TIZACRIL POLIESTER','POL',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ACRYLIT G18','ACR',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('TERMOFON','TMF',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('PINTRO POLIESTER','PP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('STABILIT OPALIT','OPA',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOBOX','ISB',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOVINILE','ISV',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOCOP','ISC',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOPARETE BOX','IBO',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOPARETE PIANO','IPI',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOPARETE PLISS�','IPL',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('TIZACRIL POLIESTER BLANCO FRIO','PBF',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('GALVATEJA','GAL',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('MULTYTECHO','MUT',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('GALVATECHO','GAT',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ECONOTECHO','ECT',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('MULTYMURO MESA','MMM',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('LAMITEJA','TEJ',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOCOP PIR FM','IPF',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('SIMPLEX POLIESTER','SPO',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('MULTYMURO PIR FM','MMP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA MURO PUR','HMU',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA CUBIERTA PUR','HCU',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('ISOPARETE PIR','IPP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA MURO PIR','HMP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA CUBIERTA PIR','HCP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA TEJA PUR','HTP',now(), 2); 
INSERT INTO material (nombre, clave, fecha_creacion, idUsuarioCrea) values ('HIANSA FRIGO','HFG',now(), 2); 


INSERT INTO aplicacion (nombreAplicacion) values ('--NO APLICA--');
INSERT INTO aplicacion (nombreAplicacion) values ('LISA');
INSERT INTO aplicacion (nombreAplicacion) values ('OG-100');
INSERT INTO aplicacion (nombreAplicacion) values ('R-101');
INSERT INTO aplicacion (nombreAplicacion) values ('RN-100');
INSERT INTO aplicacion (nombreAplicacion) values ('KR-18');
INSERT INTO aplicacion (nombreAplicacion) values ('R-72');
INSERT INTO aplicacion (nombreAplicacion) values ('OG-30');
INSERT INTO aplicacion (nombreAplicacion) values ('T-81');
INSERT INTO aplicacion (nombreAplicacion) values ('LOSACERO');
INSERT INTO aplicacion (nombreAplicacion) values ('PANEL');
INSERT INTO aplicacion (nombreAplicacion) values ('T-60');
INSERT INTO aplicacion (nombreAplicacion) values ('R-86');
INSERT INTO aplicacion (nombreAplicacion) values ('GALVATEJA');
INSERT INTO aplicacion (nombreAplicacion) values ('T-942');
INSERT INTO aplicacion (nombreAplicacion) values ('LAMITEJA');
INSERT INTO aplicacion (nombreAplicacion) values ('T-941');
INSERT INTO aplicacion (nombreAplicacion) values ('T-952');


INSERT INTO color (nombre, clave) values ('-- NO APLICA --','');
INSERT INTO color (nombre, clave) values ('GRIS ESTANDAR','I');
INSERT INTO color (nombre, clave) values ('GRIS 9002','II');
INSERT INTO color (nombre, clave) values ('ARENA','III');
INSERT INTO color (nombre, clave) values ('ROJO JANITZIO','IV');
INSERT INTO color (nombre, clave) values ('BLANCO/BLANCO','V');


INSERT INTO proveedor (nombre, clave) values ('-- NO APLICA --','NA');
INSERT INTO proveedor (nombre, clave) values ('TERNIUM','TER');
INSERT INTO proveedor (nombre, clave) values ('TIZACRIL','TIZ');
INSERT INTO proveedor (nombre, clave) values ('STABILIT','STA');
INSERT INTO proveedor (nombre, clave) values ('HANWA','HAN');
INSERT INTO proveedor (nombre, clave) values ('ISOCINDU','ISO');
INSERT INTO proveedor (nombre, clave) values ('HIANSA','HIS');


INSERT INTO tipoproducto (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES ('LÁMINA', 'L', 'ACTIVO', NOW(), 2);
INSERT INTO tipoproducto (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES ('CANALÓN', 'C', 'ACTIVO', NOW(), 2);
INSERT INTO tipoproducto (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES ('MOLDURA', 'M', 'ACTIVO', NOW(), 2);
INSERT INTO tipoproducto (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES ('ACCESORIO', 'AC', 'ACTIVO', NOW(), 2);
INSERT INTO tipoproducto (nombre, clave, estado, fecha_creacion, idUsuarioCrea) VALUES ('ROLLO', 'R', 'ACTIVO', NOW(), 2);

INSERT INTO unidad (clave, descripcion) VALUES ('ML', 'METRO LINEAL');
INSERT INTO unidad (clave, descripcion) VALUES ('M2', 'METRO CUADRADO');
INSERT INTO unidad (clave, descripcion) VALUES ('KG', 'KILOGRAMO');
INSERT INTO unidad (clave, descripcion) VALUES ('PZA', 'PIEZA');

---------------------------------------------------------------------------------


ALTER TABLE `lamimaya`.`rollo` 
ADD COLUMN `preciokg1` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `totalpreciomendez`,
ADD COLUMN `preciokg2` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `preciokg1`,
ADD COLUMN `preciokg3` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `preciokg2`,
ADD COLUMN `preciokg4` DECIMAL(9,2) NULL DEFAULT '0.00' AFTER `preciokg3`;


DROP TRIGGER IF EXISTS `lamimaya`.`rollo_BEFORE_UPDATE`;

DELIMITER $$
USE `lamimaya`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `rollo_BEFORE_UPDATE` BEFORE UPDATE ON `rollo` FOR EACH ROW BEGIN
    
	IF OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR
	   OLD.preciokg1 <> NEW.preciokg1 OR
       OLD.preciokg2 <> NEW.preciokg2 OR
       OLD.preciokg3 <> NEW.preciokg3 OR
       OLD.preciokg4 <> NEW.preciokg4 OR
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu THEN
	   
		SET NEW.lastUpdate = NOW();
		
		UPDATE configuracion SET rolloprodlastupdate = NOW() WHERE idConfiguracion = 1;
		
	END IF;
	

END$$
DELIMITER ;


DROP TRIGGER IF EXISTS `lamimaya`.`rollo_AFTER_UPDATE`;

DELIMITER $$
USE `lamimaya`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `rollo_AFTER_UPDATE` AFTER UPDATE ON `rollo` FOR EACH ROW BEGIN
	DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
	DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
	IF (OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR       
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.totalpreciovta;
       SET vp2 = NEW.totalpreciovtar2;
       SET vp3 = NEW.totalpreciovtar3;
       SET vp4 = NEW.totalpreciovtar4;
       SET vpm = NEW.totalpreciomendez;
       SET vcu = NEW.pesocu;
       UPDATE producto 
          SET precio1 = vp1 * mlpieza, 
              precio2 = vp2 * mlpieza, 
              precio3 = vp3 * mlpieza,
              precio4 = vp4 * mlpieza,
              preciomendez = vpm * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'NO';
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4,
              preciomendez = vpm              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'NO';
		UPDATE producto 
          SET precio1 = (vp1*.85) * mlpieza, 
              precio2 = (vp1*.85) * mlpieza, 
              precio3 = (vp1*.85) * mlpieza,
              precio4 = (vp1*.85) * mlpieza,
              preciomendez = (vp1*.85) * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'SI';
	   UPDATE producto 
          SET precio1 = (vp1*.85),
              precio2 = (vp1*.85),
              precio3 = (vp1*.85),
              precio4 = (vp1*.85),
              preciomendez = (vp1*.85)              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'SI';
	END IF;
    
    IF (OLD.preciokg1 <> NEW.preciokg1 OR
       OLD.preciokg2 <> NEW.preciokg2 OR
       OLD.preciokg3 <> NEW.preciokg3 OR
       OLD.preciokg4 <> NEW.preciokg4) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.preciokg1;
       SET vp2 = NEW.preciokg2;
       SET vp3 = NEW.preciokg3;
       SET vp4 = NEW.preciokg4;
       
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 3 
          AND producto_tipoproducto_idtipoproducto = 5
          AND isRollo = '0' ;
		
	END IF;
END$$
DELIMITER ;



DROP TRIGGER IF EXISTS `lamimaya`.`producto_BEFORE_INSERT`;

DELIMITER $$
USE `lamimaya`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW BEGIN
    DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
    DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
    DECLARE vpkg DOUBLE;
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
    END IF;
	SET NEW.lastUpdate = NOW();

END$$
DELIMITER ;


DROP TRIGGER IF EXISTS `lamimaya`.`rollo_AFTER_UPDATE`;

DELIMITER $$
USE `lamimaya`$$
CREATE DEFINER=`root`@`localhost` TRIGGER `rollo_AFTER_UPDATE` AFTER UPDATE ON `rollo` FOR EACH ROW BEGIN
	DECLARE vp1 DOUBLE;
    DECLARE vp2 DOUBLE;
	DECLARE vp3 DOUBLE;
    DECLARE vp4 DOUBLE;
    DECLARE vpm DOUBLE;
    DECLARE vcu DOUBLE;
	IF (OLD.totalpreciovta  <> NEW.totalpreciovta OR 
       OLD.totalpreciovtar2 <> NEW.totalpreciovtar2 OR 
       OLD.totalpreciovtar3 <> NEW.totalpreciovtar3 OR
       OLD.totalpreciovtar4 <> NEW.totalpreciovtar4 OR       
       OLD.totalpreciomendez <> NEW.totalpreciomendez OR
       OLD.pesocu <> NEW.pesocu) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.totalpreciovta;
       SET vp2 = NEW.totalpreciovtar2;
       SET vp3 = NEW.totalpreciovtar3;
       SET vp4 = NEW.totalpreciovtar4;
       SET vpm = NEW.totalpreciomendez;
       SET vcu = NEW.pesocu;
       UPDATE producto 
          SET precio1 = vp1 * mlpieza, 
              precio2 = vp2 * mlpieza, 
              precio3 = vp3 * mlpieza,
              precio4 = vp4 * mlpieza,
              preciomendez = vpm * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'NO';
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4,
              preciomendez = vpm              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'NO';
		UPDATE producto 
          SET precio1 = (vp1*.85) * mlpieza, 
              precio2 = (vp1*.85) * mlpieza, 
              precio3 = (vp1*.85) * mlpieza,
              precio4 = (vp1*.85) * mlpieza,
              preciomendez = (vp1*.85) * mlpieza
 	    WHERE producto_rollo_idrollo = NEW.idRollo
	      AND producto_unidad_idunidad = 4 and isRollo = '0' AND isSegunda = 'SI';
	   UPDATE producto 
          SET precio1 = (vp1*.85),
              precio2 = (vp1*.85),
              precio3 = (vp1*.85),
              precio4 = (vp1*.85),
              preciomendez = (vp1*.85)              
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 1 and isRollo = '0' AND isSegunda = 'SI';
	END IF;
    
    IF (OLD.preciokg1 <> NEW.preciokg1 OR
       OLD.preciokg2 <> NEW.preciokg2 OR
       OLD.preciokg3 <> NEW.preciokg3 OR
       OLD.preciokg4 <> NEW.preciokg4) AND NEW.idRollo > 1 THEN
       SET vp1 = NEW.preciokg1;
       SET vp2 = NEW.preciokg2;
       SET vp3 = NEW.preciokg3;
       SET vp4 = NEW.preciokg4;
       
	   UPDATE producto 
          SET precio1 = vp1,
              precio2 = vp2,
              precio3 = vp3,
              precio4 = vp4
		WHERE producto_rollo_idrollo = NEW.idRollo
          AND producto_unidad_idunidad = 3 
          AND producto_tipoproducto_idtipoproducto = 5
          AND isRollo = '1' ;
		
	END IF;
END$$
DELIMITER ;
