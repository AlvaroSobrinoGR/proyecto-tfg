-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2023 a las 18:51:41
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
  `id_cupon` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `porcentaje` double(65,2) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0 no esta activo este descuento, 1 esta activo este descuento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigo_descuento`
--

INSERT INTO `codigo_descuento` (`id_cupon`, `porcentaje`, `estado`) VALUES
('PEPE', 10.00, 1),
('SONIA', 5.00, 0);

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
  `id_cupon` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `total_tras_codigo` double(155,2) NOT NULL,
  `porcentaje_iva` double(155,2) NOT NULL,
  `total_final_con_iva` double(155,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(12, 10.00, 4),
(13, 5.00, 0),
(14, 12.00, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(255) NOT NULL,
  `nombre_apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre_apellidos`, `email`, `contraseña`) VALUES
(2, 'Pepe Soleres', 'Pepe.Soleres@SimplyMinimal.com', '$2y$10$vEIPnX/79q1aKHp4HCCWCutZopbXT3sRhA/2YytGVKTSalEdFV9P.');

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
(0, 'Funda de teléfono', 'Funda de Cintura para Teléfono Celular, Bolsa de Cintura para Hombre, Diseñada para Celulares de hasta 6.9\", Riñonera con Clip Vertical, Mosquetón y Bolsillo para Tarjetas, Ideal para Deportes, Camping y Viajes.', 'accesorios', 20, 14.99, 1),
(1, 'MP02 Phone', 'Nueva Generación del Teléfono Móvil Minimalista, MP02 Phone. Conectividad 4G LTE, Enfoque en Seguridad Digital, Pantalla de 2 pulgadas, Batería de 1,280 mAh, Compatibilidad Multibanda, Nano-SIM y Lengua Española - Color Negro.', 'tecnología', 20, 329.00, 1),
(2, 'Reloj AC02', 'Reloj AC02 es un elegante reloj de mesa con función de alarma. Cuenta con un diseño analógico y está equipado con un preciso movimiento de cuarzo japonés. Su estructura de aluminio y cristal de vidrio brindan durabilidad y estilo. Diseñado por Jasper Morrison y fabricado en Japón, este reloj en color negro añade un toque sofisticado a cualquier espacio.', 'tecnología', 0, 19.99, 1),
(3, 'Silla Sky', 'Comodidad y versatilidad en un diseño elegante. Adaptable a cualquier espacio, tanto interior como exterior. Diseño solo en color crema.', 'muebles', 20, 31.45, 0),
(4, 'Cargador UC01', 'El Cargador UC01 es un elegante Hub USB diseñado con 3 puertos y alimentación externa, que ofrece una solución eficiente para conectar y cargar varios dispositivos. Este cargador rápido, fabricado en Italia, destaca por su diseño sofisticado en color negro.', 'tecnología', 20, 29.99, 1),
(5, 'Cartera Slim Sleeve', 'La cartera Slim Sleeve, una opción elegante y funcional. Fabricada con cuero de alta calidad, esta cartera delgada tipo bifold cuenta con un bolsillo delantero y capacidad para 4 a 12 tarjetas. También incluye un compartimento para billetes doblados. Es la combinación perfecta de estilo y practicidad en un accesorio compacto.', 'accesorios', 20, 79.00, 1),
(6, 'Armonía', 'Juego de 3 jarrones de cerámica blanca, simples y decorativos. Perfectos para la decoración del hogar, estos jarrones mate son ideales tanto para hierba de pampas como para flores. Añaden estilo a estantes, mesas de café y sala de estar, creando una armonía visual.', 'decoración', 20, 29.99, 1);

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
  MODIFY `id_compra` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `id_datos` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
