-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2023 a las 14:52:41
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
-- Estructura de tabla para la tabla `codigo_descuento`
--

CREATE TABLE `codigo_descuento` (
  `id_cupon` varchar(155) NOT NULL,
  `porcentaje` double(65,2) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0 no esta activo este descuento, 1 esta activo este descuento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigo_descuento`
--

INSERT INTO `codigo_descuento` (`id_cupon`, `porcentaje`, `estado`) VALUES
('PEPE', 20.00, 1),
('SONIA', 10.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `id_datos_comprador` int(255) NOT NULL,
  `tiempo_local_compra` varchar(255) NOT NULL COMMENT 'fecha y hora local de cuando se hizo la compra',
  `zulu_time_compra` varchar(255) NOT NULL COMMENT 'es el tiempo universal en el que se ha hecho la compra\r\n\r\nSe encuentra en create_time',
  `id_orden_compra` varchar(255) NOT NULL COMMENT 'se encuentra en id, bajo create_time',
  `id_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en payer, player_id',
  `email_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en player, adress, email_adress',
  `nombre_apellido_pagador` varchar(255) NOT NULL COMMENT 'se encuentra en player, name, give_name y el surename',
  `precio_total` double(155,2) NOT NULL,
  `id_cupon` varchar(150) DEFAULT NULL,
  `total_tras_codigo` double(155,2) NOT NULL,
  `porcentaje_iva` double(155,2) NOT NULL,
  `total_final_con_iva` double(155,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `id_usuario`, `id_datos_comprador`, `tiempo_local_compra`, `zulu_time_compra`, `id_orden_compra`, `id_pagador`, `email_pagador`, `nombre_apellido_pagador`, `precio_total`, `id_cupon`, `total_tras_codigo`, `porcentaje_iva`, `total_final_con_iva`) VALUES
(55, 32, 10, '2023-05-12 15:04:44', '2023-05-12T13:04:43Z', '0HT88478LF042552W', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 20.00, NULL, 20.00, 21.00, 24.20),
(56, 32, 10, '2023-05-13 11:16:57', '2023-05-13T09:16:55Z', '4MC293798C0591215', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 37.99, NULL, 37.99, 21.00, 45.97),
(57, 32, 10, '2023-05-13 11:46:19', '2023-05-13T09:46:18Z', '62U992206F1251242', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 37.99, NULL, 37.99, 21.00, 45.97),
(58, 32, 10, '2023-05-15 12:25:35', '2023-05-15T10:25:35Z', '9XJ43326N5920240J', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 20.00, 'PEPE', 16.00, 21.00, 19.36),
(59, 32, 10, '2023-05-15 12:59:58', '2023-05-15T10:59:58Z', '4CU50453RF436650P', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 35.98, 'PEPE', 28.78, 21.00, 34.83),
(60, 32, 10, '2023-05-15 13:46:26', '2023-05-15T11:46:26Z', '1DS83417LB690912R', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 73.97, 'PEPE', 59.18, 21.00, 71.61),
(61, 32, 10, '2023-05-15 13:47:02', '2023-05-15T11:47:03Z', '37N89950MM7803846', 'EU2AG9GA88P58', 'sb-pipgx25897233@personal.example.com', 'John Doe', 73.97, 'PEPE', 59.18, 21.00, 71.61);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_productos`
--

CREATE TABLE `compra_productos` (
  `id_compra` int(255) NOT NULL,
  `id_producto` int(255) NOT NULL,
  `cantidad` int(255) NOT NULL,
  `precio_unidad` double(155,2) NOT NULL COMMENT 'Es el precio indivudual del producto',
  `precio_total` double(155,2) NOT NULL COMMENT 'el precio inicial por las unidades',
  `porcentaje_descuento` double(155,2) NOT NULL DEFAULT 0.00,
  `total_tras_descuento` double(155,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra_productos`
--

INSERT INTO `compra_productos` (`id_compra`, `id_producto`, `cantidad`, `precio_unidad`, `precio_total`, `porcentaje_descuento`, `total_tras_descuento`) VALUES
(55, 1, 1, 20.00, 20.00, 0.00, 20.00),
(56, 1, 1, 20.00, 20.00, 0.00, 20.00),
(56, 2, 1, 19.99, 19.99, 10.00, 17.99),
(57, 1, 1, 20.00, 20.00, 0.00, 20.00),
(57, 2, 1, 19.99, 19.99, 10.00, 17.99),
(58, 1, 1, 20.00, 20.00, 0.00, 20.00),
(59, 2, 2, 19.99, 39.98, 10.00, 35.98),
(60, 1, 1, 20.00, 20.00, 0.00, 20.00),
(60, 2, 3, 19.99, 59.97, 10.00, 53.97),
(61, 1, 1, 20.00, 20.00, 0.00, 20.00),
(61, 2, 3, 19.99, 59.97, 10.00, 53.97);

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
(16, 32, NULL, 'hola', 'tete', 'espera', '2023-05-12 15:04:58'),
(17, 32, NULL, 'pepe', 'pepe', 'espera', '2023-05-16 14:44:31'),
(18, 32, NULL, 'pepe', 'pepe', 'espera', '2023-05-16 14:45:50'),
(19, 32, NULL, 'asdasd', 'asads', 'espera', '2023-05-16 14:48:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_usuario`
--

CREATE TABLE `datos_usuario` (
  `id_datos` int(255) NOT NULL,
  `nombre_apellido` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` int(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datos_usuario`
--

INSERT INTO `datos_usuario` (`id_datos`, `nombre_apellido`, `direccion`, `telefono`) VALUES
(6, 'pepe', '', 0),
(7, 'pepe', 'sonia', 0),
(8, 'pepe', 'sonia', 123),
(9, 'pepe', 'asd', 123),
(10, 'pepe', 'asd', 1234);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id_descuento` int(155) NOT NULL,
  `porcentaje` decimal(65,2) NOT NULL,
  `id_producto` int(155) NOT NULL COMMENT 'no puede haber el mismo producot dos veces con dos descuentos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id_descuento`, `porcentaje`, `id_producto`) VALUES
(3, 20.00, 3),
(4, 10.00, 2);

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
  `id_empleado` int(255) DEFAULT NULL,
  `id_compra` int(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `consulta` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL COMMENT 'espera: aun no ha sido atendida trabajando: se esta trabajando en ella finalizada: consulta cerrada 	',
  `fecha` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`id_incidencia`, `id_empleado`, `id_compra`, `asunto`, `consulta`, `estado`, `fecha`) VALUES
(6, NULL, 55, 'hola', 'teete', 'espera', '2023-05-16 14:57:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `stock` int(255) NOT NULL,
  `precio` double(155,2) NOT NULL,
  `activo` int(20) NOT NULL COMMENT '0 no esta activo, 1 esta activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `tipo`, `stock`, `precio`, `activo`) VALUES
(0, 'telefono1', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 'tecología', 0, 30.00, 1),
(1, 'camiseta1', 'Esta camiseta está confeccionada en suave algodón de alta calidad, con un diseño gráfico llamativo en tonos vibrantes que resalta su estilo moderno y urbano. Con corte clásico y ajuste regular, es cómoda y perfecta para llevar en cualquier ocasión. Su versatilidad te permite combinarla con pantalones, shorts o faldas, para crear diferentes looks y expresar tu personalidad. Además, su durabilidad garantiza que podrás disfrutar de ella por mucho tiempo. Una prenda imprescindible en cualquier guardarropa.', 'ropa', -1, 20.00, 1),
(2, 'telefono3', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 'tecología', 4, 19.99, 1),
(3, 'camiseta2', 'Esta camiseta está confeccionada en suave algodón de alta calidad, con un diseño gráfico llamativo en tonos vibrantes que resalta su estilo moderno y urbano. Con corte clásico y ajuste regular, es cómoda y perfecta para llevar en cualquier ocasión. Su versatilidad te permite combinarla con pantalones, shorts o faldas, para crear diferentes looks y expresar tu personalidad. Además, su durabilidad garantiza que podrás disfrutar de ella por mucho tiempo. Una prenda imprescindible en cualquier guardarropa.', 'ropa', -9, 19.99, 1),
(4, 'telefono5', 'El teléfono es un dispositivo electrónico de comunicación, compacto y portátil, que permite hacer llamadas, enviar mensajes de texto, navegar por internet, tomar fotos, ver videos y mucho más. Con una pantalla táctil de alta resolución, cámara integrada, conectividad inalámbrica y potentes capacidades de procesamiento, el teléfono es una herramienta multifuncional que combina comunicación, entretenimiento y productividad en un solo dispositivo. Diseñado con elegancia y estilo, el teléfono se ha convertido en una parte esencial de la vida cotidiana, facilitando la comunicación y el acceso a la información en cualquier momento y lugar.', 'tecología', 3, 14.45, 0),
(5, 'accesorio1', 'Este accesorio es el complemento perfecto para cualquier atuendo. Confeccionado con materiales de alta calidad, su diseño elegante y sofisticado lo hace ideal para lucir en ocasiones especiales. Su practicidad y funcionalidad lo hacen perfecto para el día a día, mientras que su estilo atemporal lo hace una inversión duradera en tu guardarropa. Con detalles cuidadosamente elaborados, este accesorio resaltará tu estilo y personalidad. Además, su versatilidad te permite combinarlo con diferentes prendas y estilos para crear looks únicos y destacar en cualquier situación.', 'accesorio', 4, 30.45, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `id_datos` int(255) DEFAULT NULL,
  `validada` int(20) NOT NULL COMMENT 'contiene 1 si la cuenta esta confirmada y 0 si aun no lo esta',
  `codigo` varchar(150) DEFAULT NULL COMMENT 'contiene codigos para realizas ciertas confirmaciones',
  `novedades` int(20) NOT NULL COMMENT '1 si quiere novedades 0 si no quiere novedades'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `contrasenia`, `id_datos`, `validada`, `codigo`, `novedades`) VALUES
(32, 'estudiosalvaroestudios@gmail.com', 'pepe2', 10, 1, '0', 0);

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
-- Indices de la tabla `codigo_descuento`
--
ALTER TABLE `codigo_descuento`
  ADD PRIMARY KEY (`id_cupon`),
  ADD KEY `id_codigo` (`id_cupon`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_datos_comprador` (`id_datos_comprador`),
  ADD KEY `id_codigo_desceunto` (`id_cupon`);

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
-- Indices de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD PRIMARY KEY (`id_datos`),
  ADD KEY `id_datos` (`id_datos`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id_descuento`),
  ADD UNIQUE KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_empleado_2` (`id_empleado`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `id_incidencia` (`id_incidencia`),
  ADD KEY `id_incidencia_2` (`id_incidencia`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_compra` (`id_compra`);

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
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_datos` (`id_datos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id_datos` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_datos_comprador`) REFERENCES `datos_usuario` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`id_cupon`) REFERENCES `codigo_descuento` (`id_cupon`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Filtros para la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD CONSTRAINT `descuentos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidencias_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_datos`) REFERENCES `datos_usuario` (`id_datos`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
