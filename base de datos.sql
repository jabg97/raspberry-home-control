-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-12-2017 a las 21:42:21
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `home`
--

DROP DATABASE IF EXISTS `home`;
CREATE DATABASE IF NOT EXISTS `home` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `home`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`pin`, `nombre`, `log`, `tipo`) VALUES
('11-:-12', 'Cortina #1', '0-:-1', 3),
('13-:-15', 'Cortina #2', '2-:-3', 3),
('16-:-18', 'Puerta', '4-:-5', 3),
('22', 'Bombillo baño', '6', 1),
('29', 'Bombillo baño2', '21', 1),
('3', 'comedor', '8', 1),
('31', 'Bombillo pieza', '22', 1),
('32', 'Bombillo baño3', '26', 1),
('33', 'Sensor de Humo', '23', 2),
('35', 'Sensor de Movimiento #1', '24', 2),
('36', 'Sensor de Movimiento #2', '27', 2),
('37', 'Zona de Iluminacion #1', '25', 3),
('38', 'Zona de Iluminacion #2', '28', 3),
('40', 'Zona de Iluminacion #3', '29', 3),
('5', 'sensor 1', '9', 1),
('7', 'sensor 2', '7', 1);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_device`
--

CREATE TABLE `user_device` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `in_out`
--

CREATE TABLE `in_out` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pout` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fechalimite` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `email`, `rol`, `password`, `token`, `fechalimite`) VALUES
('root', 'balantajaiver@gmail.com', 'ROLE_ADMIN', '$2y$04$HSnpK7VkvQCL.x34ch1XxODJIPIUrCpOBvlW.DILsey3N/q1txSnO', '', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`pin`),
  ADD UNIQUE KEY `UNIQ_5C1C5F523A909126` (`nombre`),
  ADD UNIQUE KEY `UNIQ_5C1C5F528F3F68C5` (`log`);

--
-- Indices de la tabla `user_device`
--
ALTER TABLE `user_device`
  ADD PRIMARY KEY (`pin`,`codigo`);
  
  --
-- Indices de la tabla `in_out`
--
ALTER TABLE `in_out`
  ADD PRIMARY KEY (`pin`,`pout`);


--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `UNIQ_EF687F2E7927C74` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
