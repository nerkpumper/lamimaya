

--
-- Estructura de tabla para la tabla `cliente-datosfacturacion`
--

CREATE TABLE `clientedatosfacturacion` (
  `idClienteDatosFacturacion` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idDatosFacturacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosfacturacion`
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
  `credito` decimal(15,2) DEFAULT '0',
  `idUsoCfdi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente-datosfacturacion`
--
ALTER TABLE `clientedatosfacturacion`
  ADD PRIMARY KEY (`idClienteDatosFacturacion`);

--
-- Indices de la tabla `datosfacturacion`
--
ALTER TABLE `datosfacturacion`
  ADD PRIMARY KEY (`idDatosFacturacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente-datosfacturacion`
--
ALTER TABLE `clientedatosfacturacion`
  MODIFY `idClienteDatosFacturacion` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datosfacturacion`
--
ALTER TABLE `datosfacturacion`
  MODIFY `idDatosFacturacion` int(1) NOT NULL AUTO_INCREMENT;
COMMIT;
