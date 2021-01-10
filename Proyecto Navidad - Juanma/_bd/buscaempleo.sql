-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-02-2020 a las 11:17:54
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `trabajo`
--
DROP DATABASE `trabajo`;
CREATE DATABASE `trabajo` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `trabajo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenna` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `codigoCookie` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `registrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `cliente`
--

TRUNCATE TABLE `cliente`;
--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `email`, `contrasenna`, `codigoCookie`, `nombre`, `telefono`, `registrado`) VALUES
(1, 'juanmyta@gmail.com', '1234', NULL, 'Juanma', '654345676', 0),
(2, 'damiselis@gmail.com', '1234', NULL, 'Sandra', '687665439', 0),
(3, 'xomy13@gmail.com', '1234', NULL, 'Omar', '667984500', 0),
(4, 'pegupe@gmail.com', '1234', NULL, 'Pedro', '632875489', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

DROP TABLE IF EXISTS `linea`;
CREATE TABLE `linea` (
  `pedido_id` int(11) NOT NULL,
  `oferta_id` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precioUnitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `linea`
--

TRUNCATE TABLE `linea`;
--
-- Volcado de datos para la tabla `linea`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `codigo_pedido` varchar(8) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `pedido`
--

TRUNCATE TABLE `pedido`;
--
-- Volcado de datos para la tabla `pedido`
--



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `oferta`;
CREATE TABLE `oferta` (
  `id` int(11) NOT NULL,
  `puesto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL,
  `salario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `producto`
--

TRUNCATE TABLE `oferta`;
--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `oferta` (`id`, `puesto`, `descripcion`, `salario`) VALUES
(1, 'Desarrollador WEB', 'Desarrollador para empresa importante.', '1200.00'),
(2, 'Jardinero/a', 'Se necesita jardinero/a para Palacio Real.', '1300.00'),
(3, 'Niñera', 'Se busca niñera para dos niños de 3 y 4 años.', '800.00'),
(4, 'Mozo de almacén', 'Se necesita mozo de almacén para campaña navidad.', '960.00'),
(5, 'Desarrollador WEB', 'Se busca desarrollador para proyectos grandes.', '2200.00'),
(6, 'Dependiente/a', 'Se necesita dependiente/a para nuevo comercio.', '900.00'),
(7, 'Teleoperador', 'Buscamos teleoperador para la empresa Vodafone.', '800.00'),
(8, 'Bibliotecario/a', 'Necesitamos un bibliotecario/a con experiencia para la Biblioteca Nacional.', '1400.00'),
(9, 'Barrendero/a', 'Se buca barrendero para la ciudad debido a la gran cantidad de jubilaciones.', '1270.00'),
(10, 'Jefe/a de Equipo', 'Se necesita jefe de equipo para empresa logística.', '2000.00'),
(11, 'Encargado/a General', 'Buscamos un encargado general para nuestra empresa.', '1800.00'),
(12, 'Dependiente/a', 'Se busca dependiente para nueva tienda de ropa.', '750.00'),
(13, 'Diseñador Gráfico', 'Buscamos un diseñador gráfico con experiencia para diseñar todos los carteles de nuestra nueva campaña de publicidad.', '1400.00'),
(14, 'Desarrollador WEB', 'Se necesita un Desarrollador WEB con experiencia para importante proyecto.', '1700.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
  ADD PRIMARY KEY (`pedido_id`,`oferta_id`),
  ADD KEY `oferta_id` (`oferta_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `oferta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea`
--
ALTER TABLE `linea`
  ADD CONSTRAINT `linea_ibfk_2` FOREIGN KEY (`oferta_id`) REFERENCES `oferta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linea_ibfk_3` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
