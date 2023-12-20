-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-12-2023 a las 22:37:47
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sispos_test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_conocimiento`
--

CREATE TABLE `areas_conocimiento` (
  `id_area` int NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `areas_conocimiento`
--

INSERT INTO `areas_conocimiento` (`id_area`, `nombre`) VALUES
(1, 'Ingeniería de requisitos'),
(2, 'Ingeniería de software'),
(3, 'Ingeniería de hardware'),
(4, 'Ingeniería de sistemas de información'),
(5, 'Ingeniería de redes'),
(6, 'Ingeniería de seguridad'),
(7, 'Ingeniería en telecomunicaciones'),
(8, 'Ingeniería en inteligencia artificial'),
(9, 'Ingeniería de sistemas embebidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistente`
--

CREATE TABLE `asistente` (
  `id_asistente` int NOT NULL,
  `id_coordinador` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cohorte`
--

CREATE TABLE `cohorte` (
  `id_cohorte` int NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cohorte`
--

INSERT INTO `cohorte` (`id_cohorte`, `fecha_inicio`, `fecha_finalizacion`) VALUES
(1, '2024-01-12', '2025-12-05'),
(2, '2026-01-12', '2027-12-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `id_coordinador` int NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_vinculacion` date DEFAULT NULL,
  `acuerdo_nombramiento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `direccion`, `telefono`, `correo`, `genero`, `fecha_nacimiento`, `fecha_vinculacion`, `acuerdo_nombramiento`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `codigo_estudiantil` varchar(255) DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `semestre` int DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `id_cohorte` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_maestria`
--

CREATE TABLE `estudiante_maestria` (
  `id_estudiante_maestria` int NOT NULL,
  `id_estudiante` int DEFAULT NULL,
  `id_programa` int DEFAULT NULL,
  `semestre_actual` int DEFAULT NULL,
  `graduado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion`
--

CREATE TABLE `identificacion` (
  `id` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `identificacion`
--

INSERT INTO `identificacion` (`id`, `nombre`) VALUES
(1, 'Luis Obeymar Estrada'),
(2, 'Oscar Revelo Sánchez'),
(3, 'Ricardo Timaran Pereira');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_trabajo`
--

CREATE TABLE `lineas_trabajo` (
  `id_linea` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lineas_trabajo`
--

INSERT INTO `lineas_trabajo` (`id_linea`, `nombre`) VALUES
(1, 'Ingeniería de Software'),
(2, 'Inteligencia Artificial'),
(3, 'Ciencia de Datos'),
(4, 'IoT y Tecnologías 4.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profesor` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `genero` enum('M','F') DEFAULT NULL,
  `fenac` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `formacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profesor`, `nombre`, `direccion`, `telefono`, `correo`, `genero`, `fenac`, `foto`, `formacion`) VALUES
(3434343, 'egegegeee', 'Carrera 370 BIS A # 1 1 , San Andrés De Tumaco, Nariño, CO', '3155776309', 'kmilofto@gmail.com', 'F', '2023-12-07', '3434343_11.jpg', 'pregrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_areas_conocimiento`
--

CREATE TABLE `profesor_areas_conocimiento` (
  `id_profesor` int DEFAULT NULL,
  `id_area` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `profesor_areas_conocimiento`
--

INSERT INTO `profesor_areas_conocimiento` (`id_profesor`, `id_area`) VALUES
(3434343, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `Codigo_SNIES` int NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `Correo` varchar(255) DEFAULT NULL,
  `modalidad` enum('investigación','profundización') DEFAULT NULL,
  `TelefonoContacto` varchar(255) DEFAULT NULL,
  `id_coordinador` int DEFAULT NULL,
  `resolucion` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`Codigo_SNIES`, `Descripcion`, `Logo`, `Correo`, `modalidad`, `TelefonoContacto`, `id_coordinador`, `resolucion`, `fecha`) VALUES
(108092, 'awddad', 'awddad_44.jpg', 'luisobeymar@udenar.edu.co', 'profundización', '3122169169', 2, 'awddad_15.pdf', '2023-12-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_linea_trabajo`
--

CREATE TABLE `programa_linea_trabajo` (
  `id_programa` int DEFAULT NULL,
  `id_linea` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `programa_linea_trabajo`
--

INSERT INTO `programa_linea_trabajo` (`id_programa`, `id_linea`) VALUES
(108092, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_profesor`
--

CREATE TABLE `programa_profesor` (
  `id_programa` int NOT NULL,
  `id_profesor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `programa_profesor`
--

INSERT INTO `programa_profesor` (`id_programa`, `id_profesor`) VALUES
(108092, 3434343);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol` enum('Presidente','Coordinador','Asistente') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `rol`) VALUES
(1, 'luisobeymar@udenar.edu.co', 'lobeymar2023', 'Presidente'),
(2, 'orevelo@udenar.edu.co', 'orevelo2023', 'Coordinador'),
(3, 'ritimar@udenar.edu.co', 'ritimar2023', 'Coordinador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas_conocimiento`
--
ALTER TABLE `areas_conocimiento`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `asistente`
--
ALTER TABLE `asistente`
  ADD KEY `asistente_coordinador_fk` (`id_coordinador`),
  ADD KEY `asistente_identificacion_fk` (`id_asistente`);

--
-- Indices de la tabla `cohorte`
--
ALTER TABLE `cohorte`
  ADD PRIMARY KEY (`id_cohorte`);

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`id_coordinador`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `id_cohorte` (`id_cohorte`);

--
-- Indices de la tabla `estudiante_maestria`
--
ALTER TABLE `estudiante_maestria`
  ADD PRIMARY KEY (`id_estudiante_maestria`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `identificacion`
--
ALTER TABLE `identificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_trabajo`
--
ALTER TABLE `lineas_trabajo`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profesor`);

--
-- Indices de la tabla `profesor_areas_conocimiento`
--
ALTER TABLE `profesor_areas_conocimiento`
  ADD KEY `profesor_areas_conocimiento_ibfk_1` (`id_profesor`),
  ADD KEY `profesor_areas_conocimiento_ibfk_2` (`id_area`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`Codigo_SNIES`),
  ADD KEY `programa_coordinador_fk` (`id_coordinador`);

--
-- Indices de la tabla `programa_linea_trabajo`
--
ALTER TABLE `programa_linea_trabajo`
  ADD KEY `programa_linea_trabajo_ibfk_1` (`id_programa`),
  ADD KEY `programa_linea_trabajo_ibfk_2` (`id_linea`);

--
-- Indices de la tabla `programa_profesor`
--
ALTER TABLE `programa_profesor`
  ADD KEY `programa_profesor_1_fk` (`id_programa`),
  ADD KEY `programa_profesor_2_fk` (`id_profesor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas_conocimiento`
--
ALTER TABLE `areas_conocimiento`
  MODIFY `id_area` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cohorte`
--
ALTER TABLE `cohorte`
  MODIFY `id_cohorte` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_maestria`
--
ALTER TABLE `estudiante_maestria`
  MODIFY `id_estudiante_maestria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `lineas_trabajo`
--
ALTER TABLE `lineas_trabajo`
  MODIFY `id_linea` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistente`
--
ALTER TABLE `asistente`
  ADD CONSTRAINT `asistente_coordinador_fk` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asistente_identificacion_fk` FOREIGN KEY (`id_asistente`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD CONSTRAINT `coordinador_ibfk_1` FOREIGN KEY (`id_coordinador`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`id_cohorte`) REFERENCES `cohorte` (`id_cohorte`);

--
-- Filtros para la tabla `estudiante_maestria`
--
ALTER TABLE `estudiante_maestria`
  ADD CONSTRAINT `estudiante_maestria_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_maestria_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`Codigo_SNIES`);

--
-- Filtros para la tabla `profesor_areas_conocimiento`
--
ALTER TABLE `profesor_areas_conocimiento`
  ADD CONSTRAINT `profesor_areas_conocimiento_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id_profesor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profesor_areas_conocimiento_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas_conocimiento` (`id_area`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `programa_coordinador_fk` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`);

--
-- Filtros para la tabla `programa_linea_trabajo`
--
ALTER TABLE `programa_linea_trabajo`
  ADD CONSTRAINT `programa_linea_trabajo_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`Codigo_SNIES`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programa_linea_trabajo_ibfk_2` FOREIGN KEY (`id_linea`) REFERENCES `lineas_trabajo` (`id_linea`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `programa_profesor`
--
ALTER TABLE `programa_profesor`
  ADD CONSTRAINT `programa_profesor_1_fk` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`Codigo_SNIES`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programa_profesor_2_fk` FOREIGN KEY (`id_profesor`) REFERENCES `profesor` (`id_profesor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id`) REFERENCES `identificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
