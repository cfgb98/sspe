-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2023 a las 23:35:22
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_embarazadas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermeras`
--

CREATE TABLE `enfermeras` (
  `idenfermeras` int(11) NOT NULL,
  `estatus_enfermera` varchar(12) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `enfermeras`
--

INSERT INTO `enfermeras` (`idenfermeras`, `estatus_enfermera`, `idusuario`) VALUES
(1, 'Registro', 4),
(2, 'Registro', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `idmedicamento` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  `nombre_medicamento` varchar(50) NOT NULL,
  `via_administracion` varchar(50) NOT NULL,
  `observaciones` varchar(50) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`idmedicamento`, `folio`, `nombre_medicamento`, `via_administracion`, `observaciones`, `fecha_caducidad`, `usuario_id`, `estatus`) VALUES
(1, 1234567, 'Acido folico', 'Oral', 'Una tableta cada 24 horas', '2024-10-29', 5, 1),
(2, 234567, 'materna-vitaminas', 'Oral', '1 tableta cada 12 horas', '2024-10-29', 1, 1),
(3, 12345678, 'Sulfato magnesico IV', 'intravenosa o intramuscular', 'Administrar en caso de convulsiones por eclampsia	', '2024-02-10', 5, 1),
(4, 3456789, 'acido Ursodesoxicolico', 'Oral', 'Administrar en caso de colestasis ', '2024-03-01', 5, 1),
(5, 34567890, 'Paracetamol', 'Oral', 'Administrar en caso de dolor', '2023-12-08', 5, 1),
(6, 34567891, 'Doxilamina ', 'Oral', 'Administrar en caso de nauseas', '2024-04-05', 5, 1),
(7, 34567892, 'Omeprazol', 'Oral', 'Administrar en caso de acidez estomacal', '2024-01-18', 5, 1),
(8, 134567893, 'Xilometazolina', 'Gotas nasales', 'Administrar en caso de congestion nasal', '2024-02-08', 5, 1),
(9, 34567894, 'Amoxicilina ', 'Oral', 'Administrar en caso de alguna infeccion bacteriana', '2024-04-18', 5, 1),
(10, 34567895, 'Metformina', 'Oral', 'Administrar en caso de diabetes gestacional', '2024-03-06', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `idmedico` int(11) NOT NULL,
  `estatus_medico` varchar(20) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`idmedico`, `estatus_medico`, `estatus`, `idusuario`) VALUES
(1, 'Registro', 1, 2),
(2, 'Registro', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `idpaciente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `hora` time NOT NULL,
  `curp` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `cod_postal` int(11) NOT NULL,
  `estatus_paciente` varchar(50) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`idpaciente`, `nombre`, `apellido_paterno`, `apellido_materno`, `hora`, `curp`, `fecha_nacimiento`, `domicilio`, `telefono`, `cod_postal`, `estatus_paciente`, `estatus`, `idusuario`) VALUES
(1, 'Miriam', 'Mojica', 'Borquez', '19:54:00', 'MOBM270280MJCRNR06', '1980-02-27', 'A la Explanada 125', '36737352', 45020, 'Registro', 1, 1),
(2, 'Irma', 'Bernabe', 'Sanchez', '16:24:00', 'BESI670725MJCRN06', '1967-07-25', 'Al Arroyo 212', '36737958', 45020, 'Registro', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Medico'),
(3, 'Enfermero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `idseguimiento` int(11) NOT NULL,
  `idpaciente` int(11) NOT NULL,
  `cuantos_embarazos` tinyint(4) NOT NULL,
  `cuantos_partos` tinyint(4) NOT NULL,
  `cuantas_cesareas` tinyint(4) NOT NULL,
  `cuantos_abortos` tinyint(4) NOT NULL,
  `dilatacion` text NOT NULL,
  `borramiento` varchar(20) NOT NULL,
  `amnios` varchar(12) NOT NULL,
  `frecuencia_fetal` text DEFAULT NULL,
  `presion_arterial` text NOT NULL,
  `urgencias` text DEFAULT NULL,
  `idenfermera` int(11) NOT NULL,
  `idmedico` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estatus_seguimiento` varchar(20) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`idseguimiento`, `idpaciente`, `cuantos_embarazos`, `cuantos_partos`, `cuantas_cesareas`, `cuantos_abortos`, `dilatacion`, `borramiento`, `amnios`, `frecuencia_fetal`, `presion_arterial`, `urgencias`, `idenfermera`, `idmedico`, `usuario_id`, `estatus_seguimiento`, `estatus`) VALUES
(1, 1, 2, 1, 0, 1, '10CM', '100', 'NORMALES', '120', '120/80', 'NINGUNA', 1, 2, 5, 'PROCESO', 1),
(2, 2, 1, 1, 0, 0, '10CM', '100', 'NORMALES', '140', '120/80', 'NINGUNA', 2, 1, 5, 'PROCESO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_medicamento`
--

CREATE TABLE `seguimiento_medicamento` (
  `id_seguimientomedicamento` int(11) NOT NULL,
  `idseguimiento` int(11) NOT NULL,
  `idmedicamento` int(11) NOT NULL,
  `estatus` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento_medicamento`
--

INSERT INTO `seguimiento_medicamento` (`id_seguimientomedicamento`, `idseguimiento`, `idmedicamento`, `estatus`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) DEFAULT NULL,
  `apellido_materno` varchar(50) DEFAULT NULL,
  `cedula` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `correo`, `usuario`, `clave`, `rol`, `estatus`, `nombre`, `apellido_paterno`, `apellido_materno`, `cedula`) VALUES
(1, 'jara148630@gmail.com', 'admin', '4aa62acb5d04020d3b8ce28ab23d7149', 1, 1, 'José Alan', 'Romero', 'Ascencio', 127),
(2, 'dr.palafox_daniel@gmail.com', 'drPFDa', '25f9e794323b453885f5181f1b624d0b', 2, 1, 'Daniel', 'Palafox', 'Fernandez', 125),
(3, 'dr_acosta.borrayo_jorge@gmail.com', 'drABJ', 'acbd9ab2f68bea3f5291f825416546a1', 2, 1, 'Jorge', 'Acosta', 'Borrayo', 50),
(4, 'mirsa.andrea@outlook.com', 'mirsa', '2015da9b126b064a3c14369388c0df31', 3, 1, 'Andrea', 'Miranda', 'Sainz', 20),
(5, 'crisadmin@hotmail.com', 'admincrisg', '82bfd8436e440d9aefce43696d5fc7ed', 1, 1, 'Cristian Fernando', 'Garcia', 'Bernabe', 10),
(6, 'hector_rs@hotmail.com', 'enrs', '3788944cdc2dc9bed241e4d0450dbe4a', 3, 1, 'Hector', 'Rodriguez', 'Silva', 30);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `enfermeras`
--
ALTER TABLE `enfermeras`
  ADD PRIMARY KEY (`idenfermeras`),
  ADD KEY `fk_id_enfermeras` (`idusuario`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`idmedicamento`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idmedico`),
  ADD KEY `fk_id_medico` (`idusuario`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`idpaciente`),
  ADD KEY `fk_id_pacientes` (`idusuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`idseguimiento`),
  ADD KEY `idpaciente` (`idpaciente`),
  ADD KEY `idenfermera` (`idenfermera`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idmedico` (`idmedico`);

--
-- Indices de la tabla `seguimiento_medicamento`
--
ALTER TABLE `seguimiento_medicamento`
  ADD PRIMARY KEY (`id_seguimientomedicamento`),
  ADD KEY `idsegumiento` (`idseguimiento`),
  ADD KEY `idmedicamento` (`idmedicamento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `enfermeras`
--
ALTER TABLE `enfermeras`
  MODIFY `idenfermeras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `idmedicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `idmedico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idpaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `idseguimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `seguimiento_medicamento`
--
ALTER TABLE `seguimiento_medicamento`
  MODIFY `id_seguimientomedicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `enfermeras`
--
ALTER TABLE `enfermeras`
  ADD CONSTRAINT `fk_id_enfermeras` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD CONSTRAINT `medicamentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `fk_id_medico` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_id_pacientes` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguimiento_ibfk_3` FOREIGN KEY (`idpaciente`) REFERENCES `pacientes` (`idpaciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguimiento_ibfk_4` FOREIGN KEY (`idenfermera`) REFERENCES `enfermeras` (`idenfermeras`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguimiento_ibfk_5` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimiento_medicamento`
--
ALTER TABLE `seguimiento_medicamento`
  ADD CONSTRAINT `seguimiento_medicamento_ibfk_1` FOREIGN KEY (`idseguimiento`) REFERENCES `seguimiento` (`idseguimiento`),
  ADD CONSTRAINT `seguimiento_medicamento_ibfk_2` FOREIGN KEY (`idmedicamento`) REFERENCES `medicamentos` (`idmedicamento`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
