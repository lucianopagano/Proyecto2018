-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2018 a las 22:17:20
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo20`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acompanamiento`
--

CREATE TABLE `acompanamiento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `acompanamiento`
--

INSERT INTO `acompanamiento` (`id`, `nombre`) VALUES
(1, 'Familiar Cercano'),
(2, 'Hermanos e hijos'),
(3, 'Pareja'),
(4, 'Referentes vinculares'),
(5, 'Policía'),
(6, 'SAME'),
(7, 'Por sus propios medios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `variable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `variable`, `valor`) VALUES
(1, 'mantenimiento', '0'),
(2, 'cantidad_elementos_pagina', '2'),
(3, 'titulo', 'Hospital Alejandro Korn!!'),
(4, 'descripcion', 'descripcion de prueba'),
(5, 'mail', 'lucho@mail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `motivo_id` int(11) NOT NULL,
  `derivacion_id` int(11) DEFAULT NULL,
  `articulacion_con_instituciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `internacion` tinyint(1) NOT NULL DEFAULT '0',
  `diagnostico` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tratamiento_farmacologico_id` int(11) NOT NULL,
  `acompanamiento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id`, `paciente_id`, `fecha`, `motivo_id`, `derivacion_id`, `articulacion_con_instituciones`, `internacion`, `diagnostico`, `observaciones`, `tratamiento_farmacologico_id`, `acompanamiento_id`) VALUES
(1, 1, '2018-11-01', 1, 3, 'prueba de motivo ', 1, 'prueba', 'asdasdasdsa', 1, 1),
(9, 4, '2018-11-01', 1, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(10, 5, '2018-11-01', 1, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(11, 4, '2018-11-01', 2, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(12, 5, '2018-11-01', 2, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(13, 4, '2018-11-01', 3, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(14, 5, '2018-11-01', 3, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(15, 4, '2018-11-01', 3, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(16, 5, '2018-11-01', 3, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(17, 4, '2018-11-01', 3, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(18, 5, '2018-11-01', 3, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(19, 4, '2018-11-01', 3, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(21, 1, '2018-11-01', 5, 1, 'prueba de motivo 1 ', 1, 'prueba 1', 'asdasdasdsa 1', 1, 1),
(22, 4, '2018-11-01', 5, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(23, 5, '2018-11-01', 5, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(24, 1, '2018-11-01', 6, 1, 'prueba de motivo 1 ', 1, 'prueba 1', 'asdasdasdsa 1', 1, 1),
(25, 4, '2018-11-01', 6, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(26, 5, '2018-11-01', 6, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(27, 1, '2018-11-01', 6, 1, 'prueba de motivo 1 ', 1, 'prueba 1', 'asdasdasdsa 1', 1, 1),
(28, 4, '2018-11-01', 6, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(29, 5, '2018-11-01', 6, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(30, 1, '2018-11-01', 6, 1, 'prueba de motivo 1 ', 1, 'prueba 1', 'asdasdasdsa 1', 1, 1),
(31, 4, '2018-11-01', 6, 1, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(32, 5, '2018-11-01', 6, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1),
(33, 5, '2018-11-01', 6, 3, 'prueba de motivo 2 ', 1, 'prueba 2', 'asdasdasdsa 1', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `nombre`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `director` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region_sanitaria_id` int(11) NOT NULL,
  `tipo_institucion_id` int(11) NOT NULL,
  `longitud` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitud` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `institucion`
--

INSERT INTO `institucion` (`id`, `nombre`, `director`, `telefono`, `region_sanitaria_id`, `tipo_institucion_id`, `longitud`, `latitud`) VALUES
(1, 'Hospital Policlinico 1', 'Luciano', '1165005814', 1, 1, NULL, NULL),
(2, 'Hospital Policlinico 2', 'Alvarito', '11651564798', 2, 2, NULL, NULL),
(3, 'Comisaria 1', 'Buba', '11111111', 1, 1, NULL, NULL),
(4, 'Laboratorio de Ciencia y Educación 1', 'Lya', '4444444', 2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partido_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_consulta`
--

CREATE TABLE `motivo_consulta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `motivo_consulta`
--

INSERT INTO `motivo_consulta` (`id`, `nombre`) VALUES
(1, 'Receta Médica'),
(2, 'Control por Guardia'),
(3, 'Consulta'),
(4, 'Intento de Suicidio'),
(5, 'Interconsulta'),
(6, 'Otras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_social`
--

CREATE TABLE `obra_social` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `obra_social`
--

INSERT INTO `obra_social` (`id`, `nombre`) VALUES
(1, 'IOMA'),
(2, 'OSDE'),
(3, 'OSECAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id` int(11) NOT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `lugar_nac` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `region_sanitaria_id` int(11) DEFAULT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `genero_id` int(11) NOT NULL,
  `tiene_documento` tinyint(1) NOT NULL DEFAULT '1',
  `tipo_doc_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nro_historia_clinica` int(11) DEFAULT NULL,
  `nro_carpeta` int(11) DEFAULT NULL,
  `obra_social_id` int(11) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id`, `apellido`, `nombre`, `fecha_nac`, `lugar_nac`, `localidad_id`, `region_sanitaria_id`, `domicilio`, `genero_id`, `tiene_documento`, `tipo_doc_id`, `numero`, `tel`, `nro_historia_clinica`, `nro_carpeta`, `obra_social_id`, `fecha_baja`) VALUES
(1, 'Fernandez Araujo', 'Maria Dolores', '0002-02-02', '2', 1, 1, '2', 2, 1, 1, 2, '2', 2, 2, 1, NULL),
(4, 'Fernandez Araujo', 'Maria Isabel', '1966-01-01', 'La Plata', 2, 1, '19 502', 3, 1, 1, 1111, '1123456789', 2, 1, 1, NULL),
(5, 'Pagano', 'Luciano', '1989-01-01', 'Junin', 3, 1, 'Junin', 1, 0, 1, 34803204, '165005814', 2, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region_sanitaria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `nombre`) VALUES
(1, 'configuracion_update'),
(2, 'todos'),
(3, 'usuario_alta'),
(4, 'usuario_baja'),
(5, 'usuario_edit'),
(6, 'usuario_list'),
(7, 'usuario_view'),
(30, 'paciente_index'),
(31, 'paciente_show'),
(32, 'paciente_update'),
(33, 'paciente_new'),
(34, 'paciente_destroy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region_sanitaria`
--

CREATE TABLE `region_sanitaria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `region_sanitaria`
--

INSERT INTO `region_sanitaria` (`id`, `nombre`) VALUES
(1, 'I'),
(2, 'II'),
(3, 'III'),
(4, 'IV'),
(5, 'V'),
(6, 'VI'),
(7, 'VII'),
(8, 'VIII'),
(9, 'IX'),
(10, 'X'),
(11, 'XI'),
(12, 'XII');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'administrador'),
(3, 'otro'),
(30, 'equipoDeGuardia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_tiene_permiso`
--

CREATE TABLE `rol_tiene_permiso` (
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol_tiene_permiso`
--

INSERT INTO `rol_tiene_permiso` (`rol_id`, `permiso_id`) VALUES
(1, 1),
(1, 2),
(3, 1),
(30, 3),
(30, 5),
(30, 6),
(30, 7),
(30, 30),
(30, 31),
(30, 32),
(30, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `nombre`) VALUES
(1, 'DNI'),
(2, 'LC'),
(3, 'CI'),
(4, 'LE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_institucion`
--

CREATE TABLE `tipo_institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_institucion`
--

INSERT INTO `tipo_institucion` (`id`, `nombre`) VALUES
(1, 'Hospital'),
(2, 'Comisaría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento_farmacologico`
--

CREATE TABLE `tratamiento_farmacologico` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tratamiento_farmacologico`
--

INSERT INTO `tratamiento_farmacologico` (`id`, `nombre`) VALUES
(1, 'Mañana'),
(2, 'Tarde'),
(3, 'Noche');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `username`, `password`, `activo`, `updated_at`, `created_at`, `first_name`, `last_name`) VALUES
(1, 'user@user.com', 'usuario', 'usuario', 1, '2018-10-22 00:10:34', '2018-09-12 14:49:18', 'lucho', 'lucho'),
(2, 'equipoGuardia@equipoGuardia.com', 'eguardia', '123', 1, '2018-10-22 06:58:40', '2018-09-12 14:49:18', 'Equipo', 'De Guardia'),
(3, 'equipo@guardia.com', 'equipo', 'equipo', 1, '2018-10-22 06:10:07', '2018-10-20 20:49:38', 'Luciano', 'Pagano'),
(4, 'otro@otro.com', 'otro', 'otro', 0, '2018-10-22 05:18:57', '2018-09-12 14:49:18', 'otro', 'otro'),
(7, 'damian@damian', 'damian', 'damian', 1, '2018-10-23 12:14:16', '2018-10-22 06:56:33', 'damian', 'damian'),
(11, 'prueba@prueba', 'prueba', 'prueba', 1, '2018-10-22 07:27:17', '2018-10-22 07:25:20', 'prueba', 'prueba'),
(13, 'user@gmail.com', 'user', 'user', 1, '2018-10-23 12:14:41', '2018-10-23 12:14:41', 'user', 'user'),
(14, 'admin@asdf.com', 'a', 'a', 1, '2018-10-23 12:16:59', '2018-10-23 12:16:59', 'a', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tiene_rol`
--

CREATE TABLE `usuario_tiene_rol` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_tiene_rol`
--

INSERT INTO `usuario_tiene_rol` (`usuario_id`, `rol_id`) VALUES
(1, 1),
(2, 30),
(3, 30),
(4, 30),
(7, 30),
(11, 3),
(13, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acompanamiento`
--
ALTER TABLE `acompanamiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_paciente_id` (`paciente_id`),
  ADD KEY `FK_motivo_id` (`motivo_id`),
  ADD KEY `FK_derivacion_id` (`derivacion_id`),
  ADD KEY `FK_tratamiento_farmacologico_id` (`tratamiento_farmacologico_id`),
  ADD KEY `FK_acompanamiento_id` (`acompanamiento_id`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_institucion_region_sanitaria_id` (`region_sanitaria_id`),
  ADD KEY `FK_tipo_institucion_id` (`tipo_institucion_id`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_partido_id` (`partido_id`);

--
-- Indices de la tabla `motivo_consulta`
--
ALTER TABLE `motivo_consulta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `obra_social`
--
ALTER TABLE `obra_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_genero_id` (`genero_id`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_partido_region_sanitaria_id` (`region_sanitaria_id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `region_sanitaria`
--
ALTER TABLE `region_sanitaria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_tiene_permiso`
--
ALTER TABLE `rol_tiene_permiso`
  ADD PRIMARY KEY (`rol_id`,`permiso_id`),
  ADD KEY `FK_permiso_id` (`permiso_id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_institucion`
--
ALTER TABLE `tipo_institucion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tratamiento_farmacologico`
--
ALTER TABLE `tratamiento_farmacologico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_tiene_rol`
--
ALTER TABLE `usuario_tiene_rol`
  ADD PRIMARY KEY (`usuario_id`,`rol_id`),
  ADD KEY `FK_rol_utp_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acompanamiento`
--
ALTER TABLE `acompanamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `institucion`
--
ALTER TABLE `institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `motivo_consulta`
--
ALTER TABLE `motivo_consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `obra_social`
--
ALTER TABLE `obra_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `region_sanitaria`
--
ALTER TABLE `region_sanitaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_institucion`
--
ALTER TABLE `tipo_institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tratamiento_farmacologico`
--
ALTER TABLE `tratamiento_farmacologico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `FK_acompanamiento_id` FOREIGN KEY (`acompanamiento_id`) REFERENCES `acompanamiento` (`id`),
  ADD CONSTRAINT `FK_derivacion_id` FOREIGN KEY (`derivacion_id`) REFERENCES `institucion` (`id`),
  ADD CONSTRAINT `FK_motivo_id` FOREIGN KEY (`motivo_id`) REFERENCES `motivo_consulta` (`id`),
  ADD CONSTRAINT `FK_paciente_id` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`id`),
  ADD CONSTRAINT `FK_tratamiento_farmacologico_id` FOREIGN KEY (`tratamiento_farmacologico_id`) REFERENCES `tratamiento_farmacologico` (`id`);

--
-- Filtros para la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD CONSTRAINT `FK_institucion_region_sanitaria_id` FOREIGN KEY (`region_sanitaria_id`) REFERENCES `region_sanitaria` (`id`),
  ADD CONSTRAINT `FK_tipo_institucion_id` FOREIGN KEY (`tipo_institucion_id`) REFERENCES `tipo_institucion` (`id`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `FK_partido_id` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `FK_genero_id` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`);

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `FK_partido_region_sanitaria_id` FOREIGN KEY (`region_sanitaria_id`) REFERENCES `region_sanitaria` (`id`);

--
-- Filtros para la tabla `rol_tiene_permiso`
--
ALTER TABLE `rol_tiene_permiso`
  ADD CONSTRAINT `FK_permiso_id` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`),
  ADD CONSTRAINT `FK_rol_id` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `usuario_tiene_rol`
--
ALTER TABLE `usuario_tiene_rol`
  ADD CONSTRAINT `FK_rol_utp_id` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `FK_usuario_utp_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
