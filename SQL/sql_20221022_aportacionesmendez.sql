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
-- Estructura de tabla para la tabla `aportacionesmendez`
--

CREATE TABLE `aportacionesmendez` (
  `idAportacionMendez` int(11) NOT NULL,
  `monto` decimal(15,2) NOT NULL,
  `fecha_capturado` datetime NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aportacionesmendez`
--
ALTER TABLE `aportacionesmendez`
  ADD PRIMARY KEY (`idAportacionMendez`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aportacionesmendez`
--
ALTER TABLE `aportacionesmendez`
  MODIFY `idAportacionMendez` int(11) NOT NULL AUTO_INCREMENT;