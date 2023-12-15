-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-12-2023 a las 01:52:53
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
-- Base de datos: `sispos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cohorte`
--

CREATE TABLE `cohorte` (
  `CohorteID` int NOT NULL,
  `CodigoSNIES` int DEFAULT NULL,
  `AnioInicio` int DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `FechaFinalizacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cohorte`
--

INSERT INTO `cohorte` (`CohorteID`, `CodigoSNIES`, `AnioInicio`, `FechaInicio`, `FechaFinalizacion`) VALUES
(1, 108094, NULL, '2019-01-12', '2021-12-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `CoordinadorID` int NOT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Identificacion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Genero` enum('Masculino','Femenino') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `FechaVinculacion` date DEFAULT NULL,
  `AcuerdoNombramiento` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`CoordinadorID`, `Nombre`, `Identificacion`, `Direccion`, `Telefono`, `Correo`, `Genero`, `FechaNacimiento`, `FechaVinculacion`, `AcuerdoNombramiento`) VALUES
(1, 'Oscar Revelo', NULL, NULL, '3125352356', 'orevelo@udenar.edu.co', NULL, NULL, NULL, NULL),
(2, 'Ricardo Timarán', NULL, NULL, '3152454325', 'ritimar@udenar.edu.co', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `DocenteID` int NOT NULL,
  `CodigoSNIES` int DEFAULT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Identificacion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Genero` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `EstudianteID` int NOT NULL,
  `CohorteID` int DEFAULT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Identificacion` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Genero` enum('Masculino','Femenino') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineatrabajo`
--

CREATE TABLE `lineatrabajo` (
  `lineatrabajoID` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `lineatrabajo`
--

INSERT INTO `lineatrabajo` (`lineatrabajoID`, `nombre`) VALUES
(1, 'Ingeniería de Software'),
(2, 'Inteligencia Artificial'),
(3, 'Ciencia de Datos'),
(4, 'IoT y Tecnologías 4.0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programaposgrado`
--

CREATE TABLE `programaposgrado` (
  `CodigoSNIES` int NOT NULL,
  `Descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Logo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TelefonoContacto` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolucion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lineatrabajoID` int DEFAULT NULL,
  `CoordinadorID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programaposgrado`
--

INSERT INTO `programaposgrado` (`CodigoSNIES`, `Descripcion`, `Logo`, `Correo`, `TelefonoContacto`, `resolucion`, `fecha`, `lineatrabajoID`, `CoordinadorID`) VALUES
(108092, 'Maestría en Gestión de Tecnologías de la información y el conocimiento', 'Maestría_en_Gestión_de_Tecnologías_de_la_información_y_el_conocimiento_57.png', 'ritimar@udenar.edu.co', '3124675367', 'Resolución N° 006175 de junio de 2019 del MEN', '2019-06-11', 4, 2),
(108094, 'Maestría en Ingeniería de Sistemas y Computación', 'Maestría_en_Ingeniería_de_Sistemas_y_Computación_19.png', 'orevelo@udenar.edu.co', '3215643733', 'Resolución No. 006182 de junio de 2019 del MEN', '2019-06-12', 1, 1),
(432532, '23fsf', '23fsf_75.png', 'kmilofto@gmail.com', '293707142', 'sfefeffaf', '2023-12-16', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int NOT NULL,
  `NombreUsuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Rol` enum('Presidente','Coordinador','Asistente') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `NombreUsuario`, `clave`, `Rol`) VALUES
(1, 'luisobeymar@udenar.edu.co', 'lobeymar2023', 'Presidente'),
(2, 'orevelo@udenar.edu.co', 'orevelo2023', 'Coordinador'),
(3, 'ritimar@udenar.edu.co', 'ritimar2023', 'Coordinador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cohorte`
--
ALTER TABLE `cohorte`
  ADD PRIMARY KEY (`CohorteID`),
  ADD KEY `CodigoSNIES` (`CodigoSNIES`);

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`CoordinadorID`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`DocenteID`),
  ADD KEY `CodigoSNIES` (`CodigoSNIES`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`EstudianteID`),
  ADD KEY `CohorteID` (`CohorteID`);

--
-- Indices de la tabla `lineatrabajo`
--
ALTER TABLE `lineatrabajo`
  ADD PRIMARY KEY (`lineatrabajoID`);

--
-- Indices de la tabla `programaposgrado`
--
ALTER TABLE `programaposgrado`
  ADD PRIMARY KEY (`CodigoSNIES`),
  ADD KEY `CoordinadorID` (`CoordinadorID`),
  ADD KEY `lineatrabajoID` (`lineatrabajoID`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lineatrabajo`
--
ALTER TABLE `lineatrabajo`
  MODIFY `lineatrabajoID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cohorte`
--
ALTER TABLE `cohorte`
  ADD CONSTRAINT `cohorte_ibfk_1` FOREIGN KEY (`CodigoSNIES`) REFERENCES `programaposgrado` (`CodigoSNIES`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`CodigoSNIES`) REFERENCES `programaposgrado` (`CodigoSNIES`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`CohorteID`) REFERENCES `cohorte` (`CohorteID`);

--
-- Filtros para la tabla `programaposgrado`
--
ALTER TABLE `programaposgrado`
  ADD CONSTRAINT `programaposgrado_ibfk_1` FOREIGN KEY (`CoordinadorID`) REFERENCES `coordinador` (`CoordinadorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
