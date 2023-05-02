-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2023 a las 13:01:56
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avissos_disponibilidad`
--

CREATE TABLE `avissos_disponibilidad` (
  `id_usuario` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `fecha_compra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_prodcutos`
--

CREATE TABLE `compra_prodcutos` (
  `id_comrpa` int(255) NOT NULL,
  `id_prodcuto` int(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `precio` int(255) NOT NULL COMMENT 'Es el precio indivudual del producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `id_empleado` int(255) DEFAULT NULL COMMENT 'Es el empleado que se encargo de esta consulta',
  `asunto` varchar(255) NOT NULL,
  `consulta` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL COMMENT 'espera: aun no ha sido atendida\r\ntrabajando: se esta trabajando en ella\r\nfinalizada: consulta cerrada',
  `fecha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `id_usuario`, `id_empleado`, `asunto`, `consulta`, `estado`, `fecha`) VALUES
(4, 30, NULL, 'hola', 'pepe', 'espera', '2023-05-01 14:43:02'),
(8, 30, NULL, 'asdasd', 'asdasddas', 'espera', '2023-05-02 10:47:43'),
(14, 30, NULL, 'asdasd', 'asdasd', 'espera', '2023-05-02 12:01:27'),
(15, 30, NULL, 'asdasd', 'asdasd', 'espera', '2023-05-02 12:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(255) NOT NULL,
  `nombre_apellidos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id_incidencia` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `id_empleado` int(255) DEFAULT NULL,
  `id_compra` int(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `consulta` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL COMMENT 'espera: aun no ha sido atendida trabajando: se esta trabajando en ella finalizada: consulta cerrada 	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `stock` int(255) NOT NULL,
  `activo` int(20) NOT NULL COMMENT '0 no esta activo, 1 esta activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `stock`, `activo`) VALUES
(0, 'telefono1', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 1),
(1, 'telefono2', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 1),
(2, 'telefono3', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 0, 1),
(3, 'telefono4', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 1),
(4, 'telefono5', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 0),
(5, 'telefono6', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` int(255) DEFAULT NULL,
  `validada` int(20) NOT NULL COMMENT 'contiene 1 si la cuenta esta confirmada y 0 si aun no lo esta',
  `codigo` varchar(150) DEFAULT NULL COMMENT 'contiene codigos para realizas ciertas confirmaciones',
  `novedades` int(20) NOT NULL COMMENT '1 si quiere novedades 0 si no quiere novedades'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contrasenia`, `direccion`, `telefono`, `validada`, `codigo`, `novedades`) VALUES
(30, 'asdas', 'estudiosalvaroestudios@gmail.com', 'pepe', 'asdasdasd', 1234, 1, '644f938fe45ad', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avissos_disponibilidad`
--
ALTER TABLE `avissos_disponibilidad`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_compra` (`id_compra`);

--
-- Indices de la tabla `compra_prodcutos`
--
ALTER TABLE `compra_prodcutos`
  ADD PRIMARY KEY (`id_comrpa`,`id_prodcuto`),
  ADD KEY `id_comrpa` (`id_comrpa`,`id_prodcuto`),
  ADD KEY `id_prodcuto` (`id_prodcuto`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `id_usuario` (`id_usuario`,`id_empleado`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id_incidencia`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `avissos_disponibilidad`
--
ALTER TABLE `avissos_disponibilidad`
  ADD CONSTRAINT `avissos_disponibilidad_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `avissos_disponibilidad_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra_prodcutos`
--
ALTER TABLE `compra_prodcutos`
  ADD CONSTRAINT `compra_prodcutos_ibfk_1` FOREIGN KEY (`id_comrpa`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_prodcutos_ibfk_2` FOREIGN KEY (`id_prodcuto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
