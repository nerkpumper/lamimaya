-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2022 a las 20:35:08
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `galvamex_appgalva`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivorechazo`
--

CREATE TABLE `motivorechazo` (
  `idMotivoRechazo` int(11) NOT NULL,
  `motivo` varchar(70) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `estado` enum('ACTIVO','BAJA') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `motivorechazo`
--

INSERT INTO `motivorechazo` (`idMotivoRechazo`, `motivo`, `descripcion`, `estado`) VALUES
(1, 'Precio alto', 'El cliente tiene un mejor precio con otro proveedor ', 'ACTIVO'),
(2, 'Cotizacion entregada a destiempo ', 'No se entrega cotizacion a tiempo por falta de Precios ', 'ACTIVO'),
(3, 'Sin Inventario Rollos', 'No se cuenta con el inventario suficiente , acanalado o rollo para venta por kilo', 'ACTIVO'),
(4, 'Sin Inventario traslucidas', 'No se cuenta con el inventario suficiente traslucidas', 'ACTIVO'),
(5, 'Sin Inventario compra a proveedor ', 'El tiempo de entrega del proveedor es demasiado ', 'ACTIVO'),
(6, 'Tiempo de entrega', 'El cliente rechaza el tiempo de entrega', 'ACTIVO'),
(7, 'Varias cotizaciones al mismo cliente', 'Se entregan varias cotizaciones al mismo cliente, una cotizacion por cada material.', 'ACTIVO'),
(8, 'Cliente no gana licitacion.', 'cliente no gana licitacion.', 'ACTIVO'),
(9, 'Cliente ocupa cotizacion para presupuesto ', 'Cliente ocupa cotizacion para presupuesto ', 'ACTIVO'),
(10, 'Otro', 'Ingrese motivo de rechazo', 'ACTIVO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `motivorechazo`
--
ALTER TABLE `motivorechazo`
  ADD PRIMARY KEY (`idMotivoRechazo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `motivorechazo`
--
ALTER TABLE `motivorechazo`
  MODIFY `idMotivoRechazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
