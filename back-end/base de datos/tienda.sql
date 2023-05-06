-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2023 a las 16:16:08
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
  `nombre_apellido_comprador` varchar(255) NOT NULL COMMENT 'nombre_apellido del usuario que ahce la compra en ese momento',
  `direccion_comprador` varchar(255) NOT NULL COMMENT 'direccion del usuario que ahce la compra en ese momento',
  `telefono_comprador` int(255) NOT NULL COMMENT 'telefono del usuario que ahce la compra en ese momento',
  `tiempo_local_compra` varchar(255) NOT NULL COMMENT 'fecha y hora local de cuando se hizo la compra',
  `zulu_time_compra` varchar(255) NOT NULL COMMENT 'es el tiempo universal en el que se ha hecho la compra\r\n\r\nSe encuentra en create_time',
  `id_orden_compra` varchar(255) NOT NULL COMMENT 'se encuentra en id, bajo create_time',
  `id_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en payer, player_id',
  `email_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en player, adress, email_adress',
  `nombre_apellido_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en player, name, give_name y el surename',
  `importe_total` double(155,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `id_usuario`, `nombre_apellido_comprador`, `direccion_comprador`, `telefono_comprador`, `tiempo_local_compra`, `zulu_time_compra`, `id_orden_compra`, `id_pagador`, `email_pagador`, `nombre_apellido_pagador`, `importe_total`) VALUES
(5, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:54:25', '2023-05-06T13:54:24Z', '47509592MN539135E', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 85.23),
(6, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:55:08', '2023-05-06T13:55:07Z', '8HR07708FA443442U', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48),
(7, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:55:54', '2023-05-06T13:55:53Z', '94A88852HW872694D', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 85.23),
(8, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:57:02', '2023-05-06T13:57:01Z', '4HH43453P24122037', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 85.23),
(9, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:58:02', '2023-05-06T13:58:01Z', '6CW84721L14420538', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48),
(10, 30, 'pepe', 'sonia', 1234, '2023-05-06 15:59:42', '2023-05-06T13:59:41Z', '4C9805336X4527143', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48),
(11, 30, 'pepe', 'sonia', 1234, '2023-05-06 16:01:25', '2023-05-06T14:01:24Z', '5DW31124XK592810Y', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48),
(12, 30, 'pepe', 'sonia', 1234, '2023-05-06 16:02:41', '2023-05-06T14:02:41Z', '3LR8360520748800T', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48),
(13, 30, 'pepe', 'sonia', 1234, '2023-05-06 16:03:42', '2023-05-06T14:03:41Z', '0UV37126GG2227249', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 170.48);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_productos`
--

CREATE TABLE `compra_productos` (
  `id_compra` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `precio` double(155,2) NOT NULL COMMENT 'Es el precio indivudual del producto'
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
  `precio` double(155,2) NOT NULL,
  `activo` int(20) NOT NULL COMMENT '0 no esta activo, 1 esta activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `stock`, `precio`, `activo`) VALUES
(0, 'telefono1', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 0, 30.00, 1),
(1, 'telefono2', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 20.00, 1),
(2, 'telefono3', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 0, 19.99, 1),
(3, 'telefono4', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 19.99, 1),
(4, 'telefono5', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 14.45, 0),
(5, 'telefono6', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 3, 30.45, 1);

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
(30, 'pepe', 'estudiosalvaroestudios@gmail.com', 'pepe', 'sonia', 1234, 1, '644f938fe45ad', 1);

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
-- Indices de la tabla `compra_productos`
--
ALTER TABLE `compra_productos`
  ADD PRIMARY KEY (`id_compra`,`id_producto`),
  ADD KEY `id_comrpa` (`id_compra`,`id_producto`),
  ADD KEY `id_prodcuto` (`id_producto`);

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
  MODIFY `id_compra` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- Filtros para la tabla `compra_productos`
--
ALTER TABLE `compra_productos`
  ADD CONSTRAINT `compra_productos_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

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
