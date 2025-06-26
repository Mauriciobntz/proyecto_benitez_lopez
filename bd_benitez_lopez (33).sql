-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2025 a las 18:54:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_benitez_lopez`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id_carrito` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id_carrito`, `usuario_id`, `fecha_creacion`) VALUES
(1, 22, '2025-06-18 23:03:28'),
(2, 4, '2025-06-19 00:06:09'),
(3, 4, '2025-06-19 16:55:32'),
(4, 4, '2025-06-19 16:55:37'),
(5, 4, '2025-06-19 16:55:57'),
(6, 4, '2025-06-19 16:56:05'),
(7, 4, '2025-06-19 16:56:20'),
(8, 3, '2025-06-19 18:35:22'),
(9, 23, '2025-06-19 18:38:01'),
(10, 24, '2025-06-20 01:01:37'),
(11, 6, '2025-06-21 02:55:35'),
(12, 26, '2025-06-26 18:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_items`
--

CREATE TABLE `carrito_items` (
  `id_item` int(11) NOT NULL,
  `carrito_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito_items`
--

INSERT INTO `carrito_items` (`id_item`, `carrito_id`, `producto_id`, `cantidad`) VALUES
(53, 3, 11, 1),
(54, 4, 11, 1),
(56, 5, 5, 1),
(57, 6, 5, 1),
(58, 7, 26, 1),
(61, 8, 6, 1),
(62, 9, 34, 1),
(85, 1, 4, 4),
(94, 12, 5, 1),
(96, 10, 65, 1),
(97, 10, 34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrusel`
--

CREATE TABLE `carrusel` (
  `id` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrusel`
--

INSERT INTO `carrusel` (`id`, `imagen`, `titulo`, `descripcion`, `enlace`, `orden`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'BANNER-CATALOG-SAMSUNG-TAB.jpg', 'Samsung Tab', 'Catálogo de tablets Samsung', 'http://localhost/proyecto_benitez_lopez/productos/34', 1, 1, '2025-06-15 03:57:56', '2025-06-15 22:36:47'),
(2, 'iphone-16-banner.jpg', 'iPhone 16', 'Nuevo iPhone 16', 'http://localhost/proyecto_benitez_lopez/productos/buscar?q=iphone+16', 2, 1, '2025-06-15 03:57:56', '2025-06-19 19:06:06'),
(3, 'xiaomi-tech-banner.jpg', 'Xiaomi Tech', 'Tecnología Xiaomi', 'http://localhost/proyecto_benitez_lopez/productos/4', 3, 1, '2025-06-15 03:57:56', '2025-06-19 19:07:26'),
(6, '1750169501_49439c433165af9d4361.jpg', 'Samsung Galaxy', 'Samsung', 'http://localhost/proyecto_benitez_lopez/productos/9', 4, 1, '2025-06-17 17:11:41', '2025-06-19 19:08:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `imagen_url`) VALUES
(2, 'Accesorios', 'Ordenadores, portátiles y accesorios', '1750377233_b92b10ffab10145f77ec.jpg'),
(4, 'Celulares', 'Descubrí nuestra amplia variedad de celulares de última generación.', '1749951917_425534c8e2fb6c87c960.png'),
(5, 'Notebooks', 'Las mejores noteboks del pais', '1749951899_af022d0418376c2fa016.jpg'),
(6, 'Perifericos', 'Desde teclados mecánicos y ratones de precisión hasta micrófonos profesionales y cámaras web HD, ofrecemos los mejores accesorios para gaming, oficina y streaming.', '1750377980_ca0865db44e8568aef5a.webp'),
(7, 'Auriculares', 'Sumérgete en el sonido perfecto con nuestra gama de auriculares. ', '1749952383_79aa201807b863317b10.jpg'),
(8, 'Tablets', 'Descubre la versatilidad de nuestras tablets para trabajo, estudio y entretenimiento. ', '1749951987_15ffa07c924cb3525c85.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre_tienda` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `email_tienda` varchar(100) NOT NULL,
  `telefono_tienda` varchar(20) DEFAULT NULL,
  `whatsapp_tienda` varchar(20) DEFAULT NULL,
  `direccion_tienda` varchar(255) DEFAULT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `cbu` varchar(22) NOT NULL,
  `area_cobertura` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `whatsapp_url` varchar(255) DEFAULT NULL,
  `horario_atencion` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `mensaje_bienvenida` text DEFAULT NULL,
  `alias_cbu` varchar(50) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `titular_cuenta` varchar(100) DEFAULT NULL,
  `tipo_cuenta` enum('Caja de ahorro','Cuenta corriente') DEFAULT 'Caja de ahorro',
  `mercadopago_public_key` varchar(255) DEFAULT NULL,
  `mercadopago_access_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre_tienda`, `razon_social`, `email_tienda`, `telefono_tienda`, `whatsapp_tienda`, `direccion_tienda`, `cuit`, `cbu`, `area_cobertura`, `facebook_url`, `instagram_url`, `twitter_url`, `whatsapp_url`, `horario_atencion`, `logo_url`, `mensaje_bienvenida`, `alias_cbu`, `banco`, `titular_cuenta`, `tipo_cuenta`, `mercadopago_public_key`, `mercadopago_access_token`) VALUES
(1, 'Follow', 'Follow S.A.', 'soporte@follow.com.ar', '(+54 379) 400-0000', '(+54 9 379) 500-0000', '9 de Julio 1813, Corrientes, Argentina', '30-12345678-9', '2147483647', 'Corrientes, Chaco, Formosa y Misiones (NEA)', 'https://facebook.com/tupagina', 'https://instagram.com/tupagina', 'https://twitter.com/tupagina', 'https://wa.me/543795000000', 'Lunes a Viernes de 9:00 a 21:00 hs', '1750128032_21b8735e1385ba351a71.png', 'Somos una empresa dedicada al comercio electrónico con sede en Corrientes Capital, y presencia en el NEA.', 'follow.mp', 'Mercado Pago', 'Follow SA', 'Caja de ahorro', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `asunto` enum('Solicitud de Cotizacion','Soporte Tecnico','Consulta Facturacion','Reclamo','Sugerencia','Otros') NOT NULL,
  `mensaje` text NOT NULL,
  `preferencia_contacto` enum('correo','llamada','whatsapp') NOT NULL,
  `estado` enum('Sin Leer','Leida','En proceso','Resuelta') NOT NULL DEFAULT 'Sin Leer',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `nombre`, `razon_social`, `correo`, `telefono`, `asunto`, `mensaje`, `preferencia_contacto`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Carlos Méndez', 'Distribuidora Eléctrica S.A.', 'carlos.mendez@distrielec.com', '654321000', 'Solicitud de Cotizacion', 'Buenos días, quisiera recibir una cotización por 20 unidades del modelo Galaxy Book 3 Pro con entrega en Madrid. ¿Aceptan pagos por transferencia bancaria?', 'correo', 'Sin Leer', '2025-06-10 15:28:50', '2025-06-10 21:01:46'),
(2, 'Lucía González', NULL, 'lucia.gonzalez@gmail.com', '600123456', 'Soporte Tecnico', 'Compré un Poco X6 hace una semana y no enciende. Necesito soporte o garantía urgente.', 'whatsapp', 'Leida', '2025-06-10 15:29:07', '2025-06-10 21:03:44'),
(3, 'Martín Alvarez', 'Martín Soluciones TI', 'martin.alvarez@solti.com', '611223344', 'Consulta Facturacion', 'Hola, no me ha llegado la factura correspondiente a la compra del día 9 de junio. ¿Podrían reenviarla?', 'correo', 'En proceso', '2025-06-10 15:29:20', '2025-06-11 18:31:21'),
(4, 'Javier Torres', NULL, 'javi.torres@hotmail.com', '699112233', 'Sugerencia', 'Sería genial si pudieran ofrecer envío gratuito desde un monto más bajo o tener más productos Apple.', 'correo', 'Sin Leer', '2025-06-10 15:29:33', '2025-06-12 05:44:05'),
(11, 'Prueba', 'prueba', 'm@gmail.com', '379400000', 'Reclamo', '-----------------------------------', 'whatsapp', 'Resuelta', '2025-06-11 07:04:45', '2025-06-12 05:43:26'),
(12, 'lisandro', 'hola', 'lisandrolopezz359@gmail.com', '3794000000', 'Soporte Tecnico', 'hola prueba', 'llamada', 'Sin Leer', '2025-06-12 13:36:41', '2025-06-12 13:36:41'),
(13, 'Enzo', '', 'enzo@gmail.com', '3794000000', 'Consulta Facturacion', 'Xiaomi 14T', 'whatsapp', 'Sin Leer', '2025-06-21 00:01:34', '2025-06-21 00:01:34'),
(14, 'Prueba', '', 'prueba@gmail.com', '3794000000', 'Soporte Tecnico', 'Esta es una prueba', 'whatsapp', 'Sin Leer', '2025-06-26 03:36:05', '2025-06-26 03:36:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destacados`
--

CREATE TABLE `destacados` (
  `id_destacado` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `url_producto` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destacados`
--

INSERT INTO `destacados` (`id_destacado`, `producto_id`, `titulo`, `subtitulo`, `video_url`, `url_producto`, `orden`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 8, 'Samsung Galaxy A56', 'Pantalla Super AMOLED de 6.5', '1750026372_ce1f5abb55201023e046.mp4', 'http://localhost/proyecto_benitez_lopez', 1, 1, '2025-06-15 20:59:55', '2025-06-16 02:23:58'),
(2, 11, 'iPhone 16 Pro', 'Chip A18 Pro, 256GB', '1750026389_cd022b6d1809e7958075.mp4', 'http://localhost/proyecto_benitez_lopez', 2, 1, '2025-06-15 20:59:55', '2025-06-16 01:26:29'),
(3, 23, 'Asus Zenbook S16', 'Intel Core i9, 32GB RAM', '1750026408_d09d1178e643f5d39137.mp4', 'http://localhost/proyecto_benitez_lopez', 3, 1, '2025-06-15 20:59:55', '2025-06-16 01:26:48'),
(4, 65, 'Sony WH-1000XM5', 'Cancelación de ruido líder', '1750026419_6d61efcc0e4378a32530.mp4', 'http://localhost/proyecto_benitez_lopez', 4, 1, '2025-06-15 20:59:55', '2025-06-16 01:26:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('particular','fiscal','envio','trabajo') NOT NULL,
  `alias` varchar(50) NOT NULL,
  `direccion` text NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `pais` varchar(50) NOT NULL DEFAULT 'España',
  `es_principal` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `usuario_id`, `tipo`, `alias`, `direccion`, `codigo_postal`, `ciudad`, `provincia`, `pais`, `es_principal`, `fecha_creacion`) VALUES
(1, 2, 'particular', 'Casa', 'Calle Principal 123', '28001', 'Madrid', 'Madrid', 'España', 1, '2025-05-23 00:00:00'),
(2, 2, 'trabajo', 'Oficina', 'Avenida Secundaria 456', '28002', 'Madrid', 'Madrid', 'España', 0, '2025-05-23 00:01:00'),
(3, 3, 'particular', 'Domicilio', 'Plaza Central 789', '08001', 'Barcelona', 'Barcelona', 'España', 1, '2025-05-23 00:02:00'),
(4, 4, 'particular', 'Casa', 'Calle Falsa 123', '28001', 'Madrid', 'Madrid', 'España', 0, '2025-06-16 15:07:34'),
(5, 4, 'trabajo', 'Oficina', 'Avenida Real 456', '28002', 'Madrid', 'Madrid', 'España', 1, '2025-06-16 15:07:34'),
(11, 24, 'particular', 'Casa', 'Calle Falsa 123', '3400', 'Corrientes', 'Corrientes', 'Argentina', 1, '2025-06-20 01:01:37'),
(12, 24, 'trabajo', 'Oficina', 'Av. Libertad 456', '3400', 'Corrientes', 'Corrientes', 'Argentina', 0, '2025-06-20 01:01:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_envio`
--

CREATE TABLE `direccion_envio` (
  `id_direccion_envio` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `pais` varchar(50) NOT NULL DEFAULT 'Argentina',
  `nombre_destinatario` varchar(200) NOT NULL,
  `telefono_contacto` varchar(20) NOT NULL,
  `instrucciones_entrega` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion_envio`
--

INSERT INTO `direccion_envio` (`id_direccion_envio`, `venta_id`, `direccion`, `ciudad`, `provincia`, `codigo_postal`, `pais`, `nombre_destinatario`, `telefono_contacto`, `instrucciones_entrega`) VALUES
(2, 7, 'Av. Las Palmas 123', 'Barcelona', 'Cataluña', '08010', 'España', 'María Gómez', '600000003', NULL),
(4, 9, 'Av. Córdoba 980', 'Sevilla', 'Andalucía', '41001', 'España', 'Pepe González', '611111111', NULL),
(5, 6, 'Calle Libertad 123', 'Madrid', 'Madrid', '28080', 'España', 'Juan Pérez', '600000002', 'Entregar en recepción'),
(6, 10, 'Calle Mendoza 890', 'Sevilla', 'Andalucía', '41002', 'España', 'Pepe González', '611111111', NULL),
(7, 11, 'Calle del Sol 456', 'Madrid', 'Madrid', '28002', 'España', 'Juan Pérez', '600000002', 'Llamar antes de entregar'),
(8, 12, 'Av. Siempre Viva 742', 'Barcelona', 'Cataluña', '08008', 'España', 'María Gómez', '600000003', 'Dejar en portería'),
(9, 13, 'Av. Corrientes 1234', 'Corrientes', 'Corrientes', '3400', 'Argentina', 'Juan Pérez', '600000002', NULL),
(10, 14, 'Calle Falsa 456', 'Buenos Aires', 'Buenos Aires', '1000', 'Argentina', 'Pepe González', '611111111', NULL),
(24, 50, 'Av. Libertad 321', 'Resistencia', 'Chaco', '3500', 'Argentina', 'Enzo Benítez', '610000000', NULL),
(25, 52, '9 de Julio', 'Corrientes', 'Corrientes', '3400', 'Argentina', 'Pepe González', '611111111', ''),
(26, 53, 'Junin 123', 'Corrientes', 'Corrientes', '3400', 'Argentina', 'Pepe González', '611111111', ''),
(27, 54, 'Calle Falsa 123', 'Madrid', 'Madrid', '28001', 'España', 'Pepe González', '611111111', ''),
(28, 55, 'Calle Falsa 123', 'Madrid', 'Madrid', '28001', 'España', 'Pepe González', '611111111', ''),
(29, 56, 'Calle Falsa 123', 'Madrid', 'Madrid', '28001', 'España', 'Pepe González', '611111111', ''),
(30, 57, 'Calle Falsa 123', 'Madrid', 'Madrid', '28001', 'España', 'Pepe González', '611111111', ''),
(31, 58, 'Calle Falsa 123', 'Corrientes', 'Corrientes', '3400', 'Argentina', 'Juan Pérez', '3794123456', 'Dejar en recepción'),
(32, 59, 'Avenida Real 456', 'Madrid', 'Madrid', '28002', 'España', 'Pepe González', '611111111', ''),
(33, 60, 'Calle Falsa 123', 'Madrid', 'Madrid', '28001', 'España', 'Pepe González', '611111111', ''),
(34, 61, 'Avenida Real 456', 'Madrid', 'Madrid', '28002', 'España', 'Pepe González', '611111111', ''),
(35, 62, 'Calle Falsa 123', 'Corrientes', 'Corrientes', '3400', 'Argentina', 'Juan Pérez', '3794123456', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_fiscales` text DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `venta_id`, `fecha_emision`, `datos_fiscales`, `pdf_url`) VALUES
(1, 11, '2025-06-11 18:53:57', 'DNI: 87654321B, Nombre: Juan Pérez', 'facturas/factura-11.pdf'),
(2, 13, '2025-06-19 02:23:44', 'DNI: 87654321B, Nombre: Juan Pérez', 'facturas/factura-13.pdf'),
(3, 14, '2025-06-19 02:24:06', 'DNI: 35478963C, Nombre: Pepe González', 'facturas/factura-14.pdf'),
(4, 50, '2025-06-19 02:30:54', 'DNI: 29100502B, Nombre: Enzo Benítez', 'facturas/factura-50.pdf'),
(5, NULL, '2025-06-20 01:02:44', 'DNI: 40123456, Nombre: Juan Pérez', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_ventas`
--

CREATE TABLE `historico_ventas` (
  `id_historico` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `estado_anterior` enum('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `estado_nuevo` enum('pendiente','pagado','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `accion` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historico_ventas`
--

INSERT INTO `historico_ventas` (`id_historico`, `venta_id`, `estado_anterior`, `estado_nuevo`, `accion`, `usuario_id`, `fecha`) VALUES
(12, 7, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 02:44:31'),
(13, 7, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 02:44:31'),
(14, 6, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 02:52:14'),
(15, 6, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 02:52:14'),
(16, 9, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 02:52:24'),
(17, 9, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 02:52:24'),
(18, 9, 'enviado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-11 02:52:24'),
(19, 10, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 02:52:34'),
(20, 10, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 02:52:34'),
(21, 6, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 02:57:21'),
(22, 11, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 03:01:59'),
(23, 12, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 03:01:59'),
(24, 12, 'pagado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-11 14:38:20'),
(25, 7, 'pagado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-11 15:39:30'),
(26, 7, 'entregado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 15:40:52'),
(27, 7, 'enviado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-11 15:41:01'),
(28, 7, 'entregado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-11 15:41:20'),
(29, 7, 'cancelado', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-11 15:41:33'),
(30, 7, 'pagado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-11 15:41:42'),
(31, 7, 'cancelado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-11 15:41:56'),
(32, 7, 'enviado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-11 15:42:07'),
(33, 7, 'entregado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-11 15:44:06'),
(34, 7, 'cancelado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-11 15:47:56'),
(35, 11, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-12 11:57:22'),
(36, 12, 'entregado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-12 12:55:03'),
(37, 12, 'entregado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-12 12:55:48'),
(41, 10, 'pagado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-18 15:41:37'),
(42, 13, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-18 23:23:44'),
(43, 13, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-18 23:23:44'),
(44, 13, 'enviado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-18 23:23:44'),
(45, 14, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-18 23:24:06'),
(63, 50, 'pendiente', 'pagado', 'Estado cambiado a pagado', 6, '2025-06-18 23:30:54'),
(64, 50, 'pagado', 'enviado', 'Estado cambiado a enviado', 6, '2025-06-18 23:30:54'),
(65, 50, 'enviado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-18 23:30:54'),
(66, 51, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 03:26:55'),
(67, 52, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 04:03:47'),
(68, 53, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 04:21:37'),
(69, 54, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 14:30:18'),
(70, 54, 'pagado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-19 11:31:21'),
(71, 53, 'pagado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-19 11:32:16'),
(72, 52, 'pagado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-19 11:32:22'),
(73, 51, 'pagado', 'cancelado', 'Estado cambiado a cancelado', 6, '2025-06-19 11:32:28'),
(74, 55, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 16:00:23'),
(75, 56, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-19 16:24:12'),
(76, 57, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-20 00:46:08'),
(77, 57, 'pagado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-19 21:47:40'),
(81, 59, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-20 01:32:06'),
(82, 60, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-26 03:45:03'),
(83, 61, 'pendiente', 'pagado', 'Compra realizada', 4, '2025-06-26 12:50:06'),
(84, 62, 'pendiente', 'pagado', 'Compra realizada', 24, '2025-06-26 13:14:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Tarjeta','Transferencia','Contrapago','Bitcoin') DEFAULT NULL,
  `estado` enum('exitoso','fallido') DEFAULT 'exitoso',
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `comprobante` varchar(255) DEFAULT NULL COMMENT 'Ruta o referencia del comprobante para transferencias o Bitcoin',
  `referencia_pago` varchar(50) DEFAULT NULL COMMENT 'Número de referencia para transferencias'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `venta_id`, `monto`, `metodo_pago`, `estado`, `fecha_pago`, `comprobante`, `referencia_pago`) VALUES
(1, 7, 1950.00, 'Transferencia', 'exitoso', '2025-06-11 05:44:31', NULL, NULL),
(2, 6, 1800.00, 'Tarjeta', 'exitoso', '2025-06-11 05:52:14', NULL, NULL),
(3, 9, 2249.99, 'Tarjeta', 'exitoso', '2025-06-11 05:52:24', NULL, NULL),
(4, 10, 749.00, 'Tarjeta', 'exitoso', '2025-06-11 05:52:34', NULL, NULL),
(5, 11, 1549.99, 'Tarjeta', 'exitoso', '2025-06-11 06:01:59', NULL, NULL),
(6, 12, 1799.00, 'Transferencia', 'exitoso', '2025-06-11 06:01:59', NULL, NULL),
(7, 13, 1399.99, 'Tarjeta', 'exitoso', '2025-06-19 02:23:44', NULL, NULL),
(8, 14, 249.99, 'Transferencia', 'exitoso', '2025-06-19 02:24:06', NULL, NULL),
(30, 50, 1049.99, 'Tarjeta', 'exitoso', '2025-06-19 02:30:54', NULL, NULL),
(31, 51, 1400.00, 'Contrapago', 'exitoso', '2025-06-19 06:26:55', NULL, NULL),
(32, 52, 1500.00, 'Bitcoin', 'exitoso', '2025-06-19 07:03:47', NULL, NULL),
(33, 53, 750.00, 'Transferencia', 'exitoso', '2025-06-19 07:21:37', NULL, '123456789101112'),
(34, 54, 1358.00, 'Contrapago', 'exitoso', '2025-06-19 17:30:18', NULL, NULL),
(35, 55, 679.00, 'Contrapago', 'exitoso', '2025-06-19 19:00:23', NULL, NULL),
(36, 56, 3845.00, 'Bitcoin', 'exitoso', '2025-06-19 19:24:12', NULL, NULL),
(37, 57, 1100.00, 'Contrapago', 'exitoso', '2025-06-20 03:46:08', NULL, NULL),
(38, 58, 3845.00, 'Tarjeta', 'exitoso', '2025-06-20 01:01:38', NULL, NULL),
(39, 59, 679.00, 'Bitcoin', 'exitoso', '2025-06-20 04:32:06', NULL, NULL),
(40, 60, 679.00, 'Bitcoin', 'exitoso', '2025-06-26 06:45:03', NULL, NULL),
(41, 61, 350.00, 'Transferencia', 'exitoso', '2025-06-26 15:50:06', NULL, '111111111111111'),
(42, 62, 2649.90, 'Contrapago', 'exitoso', '2025-06-26 16:14:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo_documento` enum('DNI','NIE','Pasaporte','CIF') NOT NULL,
  `documento` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('H','M','O') DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `usuario_id`, `tipo_documento`, `documento`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `telefono`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 1, 'DNI', '12345678A', 'Admin', 'Sistema', '1980-01-01', 'H', '600000001', '2025-05-22 23:28:51', '2025-05-22 23:28:51'),
(2, 2, 'DNI', '87654321B', 'Juan', 'Pérez', '1990-05-15', 'H', '600000002', '2025-05-22 23:32:23', '2025-05-22 23:32:23'),
(3, 3, 'DNI', 'X1234567C', 'María', 'Gómez', '1985-08-20', 'M', '600000003', '2025-05-22 23:43:02', '2025-06-19 18:36:01'),
(4, 4, 'DNI', '35478963C', 'Pepe', 'González', '1988-03-20', 'H', '611111111', '2025-06-11 06:11:42', '2025-06-26 06:41:52'),
(5, 5, 'DNI', '29100502B', 'Enzo', 'Benítez', '1993-11-10', 'H', '610000000', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(6, 6, 'DNI', '30111222F', 'Jefe', 'Administrador', '1975-01-01', 'H', '699999999', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(7, 16, 'DNI', '33322111X', 'Moski', 'López', '1995-06-15', 'O', '600111111', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(8, 17, 'DNI', '28877221K', 'God', 'Mode', '1990-07-07', 'H', '600222222', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(9, 18, 'DNI', '31999888H', 'Cesilia', 'Acosta', '1992-04-02', 'M', '600333333', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(10, 19, 'DNI', '31222333J', 'Baul', 'Martínez', '1991-12-24', 'H', '600444444', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(11, 20, 'DNI', '30201011Z', 'Jesus', 'Nazareno', '0001-01-01', 'H', '600555555', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(12, 21, 'DNI', '32323232Q', 'Yoyo', 'Tester', '1999-09-09', 'O', '600666666', '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(13, 22, 'DNI', '43329300', 'Prueba', 'González', '0000-00-00', 'H', '3794000000', '2025-06-18 23:29:25', '2025-06-18 23:29:44'),
(14, 24, 'DNI', '40123456', 'Juan', 'Pérez', '1990-05-15', 'H', '3794123456', '2025-06-20 01:01:37', '2025-06-26 19:51:57'),
(15, 26, 'DNI', '40123456', 'Prueba', 'González', '2025-06-01', 'H', '3794000000', '2025-06-26 18:53:50', '2025-06-26 19:38:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `especificaciones` text DEFAULT NULL,
  `garantia_meses` int(11) DEFAULT 12,
  `peso_kg` decimal(10,2) DEFAULT NULL,
  `dimensiones` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `ventas_totales` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `marca`, `modelo`, `precio`, `stock`, `imagen_url`, `categoria_id`, `fecha_alta`, `especificaciones`, `garantia_meses`, `peso_kg`, `dimensiones`, `activo`, `ventas_totales`) VALUES
(4, 'Xiaomi 14T', '512GB RAM | Color: Black', 'Xiaomi', '14T', 750.00, 27, 'xiaomi14t.png', 4, '2025-06-10 02:26:52', '{\"Origen\":\"China\",\"Garantia\":\"Extendida\",\"Ram\":\"516GB\",\"Color\":\"Negro Mate\"}', 24, NULL, NULL, 1, 2),
(5, 'Lenovo ThinkPad X1 Carbon', 'Intel Core i7 vPro | Teclado mecánico', 'Lenovo', 'ThinkPad X1 Carbon', 1500.00, 15, 'lenovo.png', 5, '2025-06-09 23:26:52', '{\"Procesador\":\"Intel Core i7 vPro\",\"RAM\":\"16GB\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"14\\\" FHD\",\"Sistema Operativo\":\"Windows 11 Pro\",\"Peso\":\"1.13 kg\",\"Conectividad\":\"Wi-Fi 6, Bluetooth 5.2\"}', 36, NULL, NULL, 1, 2),
(6, 'Poco X6 Pro', '256GB RAM | Color: Yellow', 'Xiaomi', 'X6 Pro', 350.00, 0, 'pocox6pro.png', 4, '2025-06-09 23:26:52', '{\"Procesador\":\"MediaTek Dimensity 1080\",\"RAM\":\"8GB\",\"Almacenamiento\":\"256GB\",\"Pantalla\":\"6.67\\\" AMOLED 120Hz\",\"Bater\\u00eda\":\"5000 mAh\",\"C\\u00e1mara Principal\":\"64MP\",\"Sistema Operativo\":\"Android 13\"}', 12, NULL, NULL, 1, 9),
(7, 'Xiaomi Pad 6', 'Snapdragon 870 | Pantalla 11 2,8K', 'Xiaomi', 'Pad 6', 369.00, 25, 'xiaomipad6.png', 8, '2025-06-09 23:26:52', '{\"Procesador\":\"Snapdragon 870\",\"RAM\":\"6GB/8GB\",\"Almacenamiento\":\"128GB/256GB\",\"Pantalla\":\"11\\\" 2.8K 144Hz\",\"Batería\":\"8840 mAh\",\"Sistema Operativo\":\"MIUI Pad 14\",\"Peso\":\"490g\"}', 12, NULL, NULL, 1, 0),
(8, 'Samsung A55 5G', '512GB RAM | Color: White', 'Samsung', 'A55 5G', 450.00, 29, 'a55.png', 8, '2025-06-09 23:26:52', '{\"Procesador\":\"Exynos 1480\",\"RAM\":\"8GB\",\"Almacenamiento\":\"128GB\\/256GB\",\"Pantalla\":\"6.6\\\" Super AMOLED 120Hz\",\"Bater\\u00eda\":\"5000 mAh\",\"C\\u00e1mara Principal\":\"50MP\"}', 24, NULL, NULL, 1, 1),
(9, 'Samsung S25 Ultra', '1024GB RAM | Color: White', 'Samsung', 'S25 Ultra', 1100.00, 17, 's25ultra.png', 4, '2025-06-09 23:26:52', '{\"Procesador\":\"Snapdragon 8 Gen 3\",\"RAM\":\"12GB/16GB\",\"Almacenamiento\":\"256GB/512GB/1TB\",\"Pantalla\":\"6.8\\\" Dynamic AMOLED 2X 144Hz\",\"Batería\":\"5000 mAh\",\"Cámara Principal\":\"200MP\",\"Sistema Operativo\":\"Android 15\"}', 36, NULL, NULL, 1, 1),
(10, 'iPhone 16', '512GB RAM | Color: Blue', 'Apple', 'iPhone 16', 1000.00, 24, 'iphone16.png', 4, '2025-06-09 23:26:52', '{\"Procesador\":\"A18 Bionic\",\"RAM\":\"6GB\",\"Almacenamiento\":\"128GB/256GB/512GB\",\"Pantalla\":\"6.1\\\" Super Retina XDR\",\"Batería\":\"3279 mAh\",\"Cámara Principal\":\"48MP\",\"Sistema Operativo\":\"iOS 18\"}', 12, NULL, NULL, 1, 3),
(11, 'iPhone 16 Pro Max', '1024GB RAM | Color: White', 'Apple', 'iPhone 16 Pro Max', 1250.00, 13, 'iphone16promax.png', 4, '2025-06-09 23:26:52', '{\"Procesador\":\"A18 Pro Bionic\",\"RAM\":\"8GB\",\"Almacenamiento\":\"256GB/512GB/1TB\",\"Pantalla\":\"6.7\\\" Super Retina XDR ProMotion\",\"Batería\":\"4422 mAh\",\"Cámara Principal\":\"48MP + 12MP + 12MP\",\"Sistema Operativo\":\"iOS 18\"}', 12, NULL, NULL, 1, 0),
(12, 'Redmi Note 13 Pro', '512GB RAM | Color: Blue', 'Xiaomi', 'Redmi Note 13 Pro', 450.00, 30, 'redminote13pro.png', 4, '2025-06-10 06:08:43', '{\"Procesador\":\"Snapdragon 7s Gen 2\",\"RAM\":\"8GB/12GB\",\"Almacenamiento\":\"128GB/256GB\",\"Pantalla\":\"6.67\\\" AMOLED 120Hz\",\"Batería\":\"5100 mAh\",\"Cámara Principal\":\"200MP\",\"Sistema Operativo\":\"Android 13\"}', 12, NULL, NULL, 1, 0),
(13, 'Poco X6', '256GB RAM | Color: White', 'Xiaomi', 'Poco X6', 250.00, 40, 'pocox6.png', 4, '2025-06-10 06:08:43', '{\"Procesador\":\"Snapdragon 7s Gen 2\",\"RAM\":\"8GB\",\"Almacenamiento\":\"256GB\",\"Pantalla\":\"6.67\\\" AMOLED 120Hz\",\"Batería\":\"5100 mAh\",\"Cámara Principal\":\"64MP\",\"Sistema Operativo\":\"Android 13\"}', 12, NULL, NULL, 1, 0),
(14, 'Redmi Buds 4', 'in-ear | USB tipo C', 'Xiaomi', 'Redmi Buds 4', 120.00, 50, 'redmibuds4.png', 7, '2025-06-10 06:08:43', '{\"Tipo\":\"In-ear inalámbricos\",\"Conectividad\":\"Bluetooth 5.2\",\"Autonomía\":\"30h (con estuche)\",\"Cancelación de ruido\":\"No\",\"Resistencia\":\"IP54\",\"Peso\":\"4.5g por auricular\"}', 12, NULL, NULL, 1, 1),
(15, 'Redmi Buds 5', 'in-ear | USB tipo C', 'Xiaomi', 'Redmi Buds 5', 140.00, 44, 'redmibuds5.png', 7, '2025-06-10 06:08:43', '{\"Tipo\":\"in-ear\",\"Conectividad\":\"USB tipo C\"}', 12, NULL, NULL, 1, 0),
(16, 'Apple AirPods Pro 2', 'Chip H2 | Cancelación de ruido mejorada + Modo ambiente', 'Apple', 'AirPods Pro 2', 249.99, 30, 'airPods.png', 7, '2025-06-10 06:08:43', '{\"Tipo\":\"In-ear inalámbricos\",\"Conectividad\":\"Bluetooth 5.3\",\"Autonomía\":\"6h (30h con estuche)\",\"Cancelación de ruido\":\"Activa\",\"Resistencia\":\"IP54\",\"Chip\":\"H2\",\"Peso\":\"5.3g por auricular\"}', 12, NULL, NULL, 1, 1),
(17, 'Samsung Galaxy Buds 2 Pro', 'Sonido Hi-Fi de 24 bits | Cancelación activa de ruido', 'Samsung', 'Galaxy Buds 2 Pro', 142.00, 35, 'galaxybuds.png', 7, '2025-06-10 06:08:43', '{\"Tipo\":\"In-ear inalámbricos\",\"Conectividad\":\"Bluetooth 5.3\",\"Autonomía\":\"5h (18h con estuche)\",\"Cancelación de ruido\":\"Activa\",\"Resistencia\":\"IPX7\",\"Peso\":\"5.5g por auricular\"}', 12, NULL, NULL, 1, 0),
(18, 'Galaxy Book 3', '16GB RAM | 152GB SSD', 'Samsung', 'Galaxy Book 3', 1200.00, 19, 'galaxybook3.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Intel Core i5-1340P\",\"RAM\":\"16GB LPDDR5\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"15.6\\\" FHD AMOLED\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.55kg\",\"Batería\":\"76Wh\"}', 24, NULL, NULL, 1, 0),
(19, 'Galaxy Book 3 Pro', '16GB RAM | 1TB SSD', 'Samsung', 'Galaxy Book 3 Pro', 1500.00, 15, 'galaxybook3pro.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Intel Core i7-1360P\",\"RAM\":\"16GB LPDDR5\",\"Almacenamiento\":\"1TB SSD\",\"Pantalla\":\"16\\\" AMOLED 3K\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.56kg\",\"Batería\":\"76Wh\"}', 24, NULL, NULL, 1, 0),
(20, 'MacBook Air M2', 'Apple M2 | Pantalla 13,6', 'Apple', 'MacBook Air M2', 1500.00, 25, 'macbookair2.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2 (8-core)\",\"RAM\":\"8GB/16GB\",\"Almacenamiento\":\"256GB/512GB SSD\",\"Pantalla\":\"13.6\\\" Liquid Retina\",\"Sistema Operativo\":\"macOS\",\"Peso\":\"1.24kg\",\"Batería\":\"52.6Wh\"}', 24, NULL, NULL, 1, 1),
(21, 'MacBook Pro M3', 'Apple M3 | Pantalla 120Hz', 'Apple', 'MacBook Pro M3', 1700.00, 14, 'macbookpro3.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M3 (10-core)\",\"RAM\":\"16GB\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"14.2\\\" Liquid Retina XDR\",\"Sistema Operativo\":\"macOS\",\"Peso\":\"1.61kg\",\"Batería\":\"70Wh\"}', 24, NULL, NULL, 1, 0),
(22, 'Dell XPS 13', 'Intel Core i7 | Pantalla 4k', 'Dell', 'XPS 13', 1400.00, 20, 'dell.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Intel Core i7-1360P\",\"RAM\":\"16GB LPDDR5\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"13.4\\\" 4K UHD+\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.17kg\",\"Batería\":\"60Wh\"}', 24, NULL, NULL, 1, 0),
(23, 'Asus ROG Zephyrus G14', 'AMD Ryzen 9 | RTX 4060', 'Asus', 'ROG Zephyrus G14', 1700.00, 9, 'zephyrus.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"AMD Ryzen 9 7940HS\",\"RAM\":\"16GB DDR5\",\"Almacenamiento\":\"1TB SSD\",\"Pantalla\":\"14\\\" QHD 165Hz\",\"GPU\":\"NVIDIA RTX 4060\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.72kg\"}', 24, NULL, NULL, 1, 0),
(24, 'Logitech MX Master 3S', 'Sensor de 8K DPI | Scroll MagSpeed', 'Logitech', 'MX Master 3S', 340.00, 30, 'logitechmouse.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Ratón inalámbrico\",\"Sensor\":\"8000 DPI\",\"Conectividad\":\"Bluetooth/Unifying\",\"Batería\":\"70 días\",\"Botones\":\"7 programables\",\"Peso\":\"141g\"}', 12, NULL, NULL, 1, 0),
(25, 'Razer DeathAdder V3', 'Sensor Focus Pro 30K DPI | Super liviano (63g)', 'Razer', 'DeathAdder V3', 161.99, 40, 'razermouse.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Ratón gaming\",\"Sensor\":\"Focus Pro 30K DPI\",\"Conectividad\":\"Cableado\",\"Botones\":\"5 programables\",\"Peso\":\"63g\",\"Iluminación\":\"Razer Chroma RGB\"}', 12, NULL, NULL, 1, 0),
(26, 'Redragon Kumara K552', 'Teclado mecánico compacto | Switches Outemu Blue', 'Redragon', 'Kumara K552', 70.00, 50, 'KUMARA.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Teclado mecánico\",\"Switches\":\"Outemu Blue\",\"Iluminación\":\"LED rojo\",\"Conectividad\":\"Cableado USB\",\"Teclas\":\"87 (TKL)\",\"Peso\":\"900g\"}', 12, NULL, NULL, 1, 0),
(27, 'SteelSeries Apex Pro', 'Switches OmniPoint ajustables | Pantalla OLED integrada', 'SteelSeries', 'Apex Pro', 119.00, 25, 'steel.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Teclado mecánico\",\"Switches\":\"OmniPoint ajustables\",\"Iluminación\":\"RGB\",\"Conectividad\":\"Cableado USB\",\"Teclas\":\"104\",\"Pantalla\":\"OLED integrada\",\"Peso\":\"1.2kg\"}', 12, NULL, NULL, 1, 0),
(28, 'Elgato Stream Deck', '15 botones LCD programables | Integración con OBS, Twitch, Spotify, etc.', 'Elgato', 'Stream Deck', 250.00, 20, 'streamdeck.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Panel de control\",\"Botones\":\"15 LCD táctiles\",\"Conectividad\":\"USB\",\"Software\":\"Elgato Stream Deck\",\"Compatibilidad\":\"Windows/macOS\",\"Peso\":\"250g\"}', 12, NULL, NULL, 1, 0),
(29, 'HyperX QuadCast', 'Micrófono de condensador con 4 patrones polares | Filtro antipop y shock mount integrados', 'HyperX', 'QuadCast', 139.99, 15, 'microfonohyper.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Micrófono de condensador\",\"Patrones\":\"4 (Estéreo, Omnidireccional, Cardioide, Bidireccional)\",\"Conectividad\":\"USB\",\"Frecuencia\":\"20Hz–20kHz\",\"Peso\":\"350g\",\"Incluye\":\"Soporte antivibraciones\"}', 12, NULL, NULL, 1, 0),
(30, 'Logitech C920s Pro', 'Resolución Full HD 1080p | Micrófono estéreo dual', 'Logitech', 'C920s Pro', 49.99, 30, 'camaralogi.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"Webcam\",\"Resolución\":\"1080p Full HD\",\"Enfoque\":\"Automático\",\"Micrófono\":\"Estéreo dual\",\"Conectividad\":\"USB\",\"Compatibilidad\":\"Windows/macOS\",\"Peso\":\"150g\"}', 12, NULL, NULL, 1, 0),
(31, 'iPad Pro M2', 'Apple M2 | Pantalla XDR 120Hz', 'Apple', 'iPad Pro M2', 799.00, 20, 'ipadprom2.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2\",\"RAM\":\"8GB/16GB\",\"Almacenamiento\":\"128GB/256GB/512GB/1TB/2TB\",\"Pantalla\":\"12.9\\\" XDR 120Hz\",\"Batería\":\"40.88Wh\",\"Sistema Operativo\":\"iPadOS\",\"Peso\":\"682g\"}', 12, NULL, NULL, 1, 0),
(32, 'iPad Air M2', 'Apple M2 | Pantalla Retina 10,9', 'Apple', 'iPad Air M2', 749.00, 25, 'ipadair13.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2\",\"RAM\":\"8GB\",\"Almacenamiento\":\"64GB/256GB\",\"Pantalla\":\"10.9\\\" Retina\",\"Batería\":\"28.6Wh\",\"Sistema Operativo\":\"iPadOS\",\"Peso\":\"461g\"}', 12, NULL, NULL, 1, 1),
(33, 'iPad (10ª generación)', 'Apple A14 | Pantalla Retina 10,9', 'Apple', 'iPad 10', 579.00, 30, 'ipad10.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple A14 Bionic\",\"RAM\":\"4GB\",\"Almacenamiento\":\"64GB/256GB\",\"Pantalla\":\"10.9\\\" Retina\",\"Batería\":\"28.6Wh\",\"Sistema Operativo\":\"iPadOS\",\"Peso\":\"477g\"}', 12, NULL, NULL, 1, 0),
(34, 'Samsung Galaxy Tab S9 Ultra', 'Snapdragon 8 Gen 2 | Pantalla Amoled 14,6', 'Samsung', 'Galaxy Tab S9 Ultra', 679.00, 42, 'galaxytabs9ultra.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Snapdragon 8 Gen 2\",\"RAM\":\"12GB/16GB\",\"Almacenamiento\":\"256GB/512GB/1TB\",\"Pantalla\":\"14.6\\\" AMOLED 120Hz\",\"Batería\":\"11200 mAh\",\"Sistema Operativo\":\"Android\",\"Peso\":\"732g\"}', 12, NULL, NULL, 1, 8),
(35, 'Samsung Galaxy Tab S9 FE', 'Exynos 1380 | Pantalla LCD 12,4', 'Samsung', 'Galaxy Tab S9 FE', 449.00, 20, 'tabgalaxys9fe.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Exynos 1380\",\"RAM\":\"6GB/8GB\",\"Almacenamiento\":\"128GB/256GB\",\"Pantalla\":\"12.4\\\" LCD 90Hz\",\"Batería\":\"10090 mAh\",\"Sistema Operativo\":\"Android\",\"Peso\":\"571g\"}', 12, NULL, NULL, 1, 0),
(36, 'Microsoft Surface Pro 9', 'Intel Core i5/i7 | Pantalla PixelSense de 13', 'Microsoft', 'Surface Pro 9', 999.00, 15, 'surface.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Intel Core i5-1235U/i7-1255U\",\"RAM\":\"8GB/16GB/32GB\",\"Almacenamiento\":\"128GB/256GB/512GB/1TB\",\"Pantalla\":\"13\\\" PixelSense\",\"Batería\":\"47.7Wh\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"879g\"}', 12, NULL, NULL, 1, 0),
(37, 'Amazon Fire HD 10', 'Octa-Core | Pantalla Full-HD 10,1', 'Amazon', 'Fire HD 10', 150.00, 30, 'amazon.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Octa-Core 2.0 GHz\",\"RAM\":\"3GB\",\"Almacenamiento\":\"32GB/64GB\",\"Pantalla\":\"10.1\\\" Full HD\",\"Batería\":\"6500 mAh\",\"Sistema Operativo\":\"Fire OS\",\"Peso\":\"465g\"}', 12, NULL, NULL, 1, 0),
(50, 'Smartwatch Galaxy Watch 6', 'Monitor de salud avanzado con ECG y seguimiento de sueño', 'Samsung', 'Galaxy Watch 6', 299.99, 25, '1750375509_3000b07a2f0c3fc1f3b4.jpg', 2, '2025-06-13 04:45:36', '{\"Pantalla\":\"1.5\\\" Super AMOLED\",\"Sistema Operativo\":\"Wear OS\",\"Batería\":\"425 mAh\",\"Resistencia\":\"IP68 / 5ATM\",\"Conectividad\":\"Bluetooth/Wi-Fi\",\"Sensores\":\"ECG, SpO2, HRM, acelerómetro, giroscopio\"}', 24, NULL, NULL, 1, 0),
(51, 'Reloj Inteligente Xiaomi Band 8', 'Monitor de actividad con pantalla AMOLED y 16 días de batería', 'Xiaomi', 'Mi Band 8', 89.99, 30, '1750376010_00f40aa2d267796a25b0.png', 2, '2025-06-13 04:45:36', '{\"Pantalla\":\"1.62\\\" AMOLED\",\"Batería\":\"190 mAh (hasta 16 días)\",\"Resistencia\":\"5ATM\",\"Conectividad\":\"Bluetooth 5.1\",\"Sensores\":\"HRM, acelerómetro, giroscopio\",\"Peso\":\"26g\"}', 12, NULL, NULL, 1, 10),
(52, 'Cargador Inalámbrico 15W', 'Carga rápida inalámbrica compatible con Qi', 'Belkin', 'BoostCharge 15W', 49.99, 50, '1750375759_23aa4efac6b74ff211de.webp', 2, '2025-06-13 04:45:36', '{\"Potencia\":\"15W\",\"Entrada\":\"USB-C\",\"Compatibilidad\":\"Qi\"}', 12, NULL, NULL, 1, 0),
(53, 'Monitor Gaming 27', 'Pantalla QHD con tecnología IPS y FreeSync Premium', 'AOC', 'Q27G2U', 289.00, 15, '1750375928_72d114e62f67f2499c23.png', 2, '2025-06-13 04:45:36', '{\"Tamaño\":\"27\\\"\",\"Resolución\":\"2560x1440 (QHD)\",\"Tipo Panel\":\"IPS\",\"Tasa de refresco\":\"144Hz\",\"Tiempo de respuesta\":\"1ms\",\"Conectores\":\"HDMI, DisplayPort\"}', 24, NULL, NULL, 1, 0),
(54, 'Disco SSD NVMe 1TB', 'Velocidades de lectura hasta 3500MB/s', 'Crucial', 'P3', 89.99, 30, '1750375991_b0ec2be0d03044c0e418.jpg', 2, '2025-06-13 04:45:36', '{\"Capacidad\":\"1TB\",\"Interfaz\":\"PCIe Gen3\",\"Velocidad\":\"3500MB\\/s\"}', 36, NULL, NULL, 1, 0),
(55, 'Router WiFi 6 AX5400', 'Doble banda con cobertura para toda la casa', 'TP-Link', 'Archer AX73', 159.99, 20, '1750376079_e4e2002baafb292afe82.webp', 2, '2025-06-13 04:45:36', '{\"Velocidad\":\"5400 Mbps (5GHz: 4804 Mbps + 2.4GHz: 574 Mbps)\",\"Banda\":\"Dual-band\",\"Antenas\":\"6 externas\",\"Puertos\":\"4x Gigabit LAN, 1x Gigabit WAN\",\"Seguridad\":\"WPA3, SPI Firewall\"}', 24, NULL, NULL, 1, 0),
(56, 'Motorola Edge 40', 'Pantalla pOLED 144Hz y carga rápida de 68W', 'Motorola', 'Edge 40', 599.00, 18, '1750376877_bd6385d16cf311e356a2.jpg', 4, '2025-06-13 04:45:36', '{\"Procesador\":\"MediaTek Dimensity 8020\",\"RAM\":\"8GB\",\"Almacenamiento\":\"256GB\",\"Pantalla\":\"6.55\\\" pOLED 144Hz\",\"Batería\":\"4400 mAh\",\"Carga rápida\":\"68W\",\"Sistema Operativo\":\"Android 13\"}', 24, NULL, NULL, 1, 0),
(57, 'Realme GT Neo 3', 'Carga ultra rápida de 150W y chipset Dimensity 8100', 'Realme', 'GT Neo 3', 499.00, 22, '1750376852_19a3e7619761eeb1cecd.jpeg', 4, '2025-06-13 04:45:36', '{\"Procesador\":\"MediaTek Dimensity 8100\",\"RAM\":\"8GB/12GB\",\"Almacenamiento\":\"128GB/256GB\",\"Pantalla\":\"6.7\\\" AMOLED 120Hz\",\"Batería\":\"4500 mAh\",\"Carga rápida\":\"150W\",\"Sistema Operativo\":\"Android 12\"}', 24, NULL, NULL, 1, 0),
(58, 'Nothing Phone (2)', 'Diseño transparente con Glyph Interface', 'Nothing', 'Phone (2)', 699.00, 15, '1750376817_120a607da7c3d3d15924.webp', 4, '2025-06-13 04:45:36', '{\"Procesador\":\"Snapdragon 8+ Gen 1\",\"RAM\":\"8GB/12GB\",\"Almacenamiento\":\"128GB/256GB/512GB\",\"Pantalla\":\"6.7\\\" OLED 120Hz\",\"Batería\":\"4700 mAh\",\"Carga rápida\":\"45W\",\"Sistema Operativo\":\"Android 13\"}', 24, NULL, NULL, 1, 0),
(59, 'HP Pavilion 15', 'Procesador AMD Ryzen 7 y gráficos Radeon', 'HP', 'Pavilion 15-eg2000', 899.00, 12, '1750020868_e4799f703abd0514740f.png', 5, '2025-06-13 04:48:02', '{\"Procesador\":\"AMD Ryzen 7 5825U\",\"RAM\":\"16GB DDR4\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"15.6\\\" FHD IPS\",\"GPU\":\"AMD Radeon Graphics\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.75kg\"}', 24, NULL, NULL, 1, 0),
(60, 'Acer Swift 3', 'Ultrabook ligero con pantalla IPS y teclado retroiluminado', 'Acer', 'Swift SF314-512', 799.00, 10, '1750376795_9c69ddd5433f659dd8be.jpg', 5, '2025-06-13 04:48:02', '{\"Procesador\":\"Intel Core i5-1240P\",\"RAM\":\"8GB LPDDR4X\",\"Almacenamiento\":\"512GB SSD\",\"Pantalla\":\"14\\\" FHD IPS\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.25kg\",\"Batería\":\"56Wh\"}', 24, NULL, NULL, 1, 0),
(61, 'Asus Vivobook Pro 16', 'Pantalla OLED 4K y gráficos NVIDIA RTX 3050', 'Asus', 'Vivobook Pro 16X', 1299.00, 8, '1750376779_bb438291760d7731d6be.webp', 5, '2025-06-13 04:48:02', '{\"Procesador\":\"AMD Ryzen 7 6800H\",\"RAM\":\"16GB DDR5\",\"Almacenamiento\":\"1TB SSD\",\"Pantalla\":\"16\\\" OLED 4K\",\"GPU\":\"NVIDIA RTX 3050\",\"Sistema Operativo\":\"Windows 11\",\"Peso\":\"1.95kg\"}', 24, NULL, NULL, 1, 0),
(62, 'Teclado Mecánico HyperX Alloy Origins', 'Switches HyperX Red con retroiluminación RGB', 'HyperX', 'Alloy Origins', 99.99, 25, '1750376481_fbe09e7a739d39d1396e.webp', 6, '2025-06-13 04:48:02', '{\r\n  \"Tipo\": \"Teclado mecánico\",\r\n  \"Switches\": \"HyperX Red\",\r\n  \"Iluminación\": \"RGB\",\r\n  \"Conectividad\": \"Cableado USB\",\r\n  \"Teclas\": \"104\",\r\n  \"Peso\": \"1.1kg\"\r\n}', 24, NULL, NULL, 1, 0),
(63, 'Mouse Inalámbrico Logitech G Pro X', 'Sensor HERO 25K y diseño ultraligero', 'Logitech', 'G Pro X Superlight', 149.99, 20, '1750376463_044ac7adcf00d481bd83.jpg', 6, '2025-06-13 04:48:02', '{\r\n  \"Tipo\": \"Ratón gaming inalámbrico\",\r\n  \"Sensor\": \"HERO 25K\",\r\n  \"Conectividad\": \"Lightspeed Wireless\",\r\n  \"Peso\": \"63g\",\r\n  \"Botones\": \"5 programables\",\r\n  \"Batería\": \"70 horas\"\r\n}', 24, NULL, NULL, 1, 0),
(64, 'Alfombrilla Gaming XL', 'Superficie de tela de alta precisión', 'SteelSeries', 'QcK XXL', 39.99, 30, '1750376446_4f80400d20861b4c1d15.png', 6, '2025-06-13 04:48:02', '{\r\n  \"Tamaño\": \"900x400mm\",\r\n  \"Material\": \"Tela de alta densidad\",\r\n  \"Grosor\": \"2mm\",\r\n  \"Base\": \"Antideslizante\",\r\n  \"Peso\": \"500g\"\r\n}', 12, NULL, NULL, 1, 0),
(65, 'Auriculares Inalámbricos Sony WH-1000XM5', 'Cancelación de ruido líder y sonido Hi-Res', 'Sony', 'WH-1000XM5', 399.99, 15, '1750376430_b4aa28903333214401d2.webp', 7, '2025-06-13 04:48:02', '{\r\n  \"Tipo\": \"Over-ear inalámbricos\",\r\n  \"Conectividad\": \"Bluetooth 5.2\",\r\n  \"Autonomía\": \"30h\",\r\n  \"Cancelación de ruido\": \"ANC avanzada\",\r\n  \"Peso\": \"250g\",\r\n  \"Micrófono\": \"Integrado\"\r\n}', 24, NULL, NULL, 1, 0),
(66, 'Auriculares Gaming Corsair Virtuoso', 'Sonido surround 7.1 y micrófono broadcast', 'Corsair', 'Virtuoso RGB Wireless', 179.99, 18, '1750376238_26fd17d6248590e270c7.webp', 7, '2025-06-13 04:48:02', '{\r\n  \"Tipo\": \"Over-ear inalámbricos\",\r\n  \"Conectividad\": \"Wireless 2.4GHz/Bluetooth/USB\",\r\n  \"Autonomía\": \"20h\",\r\n  \"Micrófono\": \"Broadcast-quality\",\r\n  \"Peso\": \"420g\",\r\n  \"Iluminación\": \"RGB\"\r\n}', 24, NULL, NULL, 1, 0),
(67, 'Earbuds Huawei FreeBuds Pro 2', 'Cancelación de ruido inteligente y sonido Hi-Fi', 'Huawei', 'FreeBuds Pro 2', 199.99, 22, '1750376217_fb5c2f598e18b67acfdb.jpg', 7, '2025-06-13 04:48:02', '{\r\n  \"Tipo\": \"In-ear inalámbricos\",\r\n  \"Conectividad\": \"Bluetooth 5.2\",\r\n  \"Autonomía\": \"6.5h (30h con estuche)\",\r\n  \"Cancelación de ruido\": \"Inteligente\",\r\n  \"Peso\": \"5.9g por auricular\",\r\n  \"Resistencia\": \"IP54\"\r\n}', 12, NULL, NULL, 1, 0),
(68, 'Lenovo Tab P12', 'Pantalla 2K con lápiz óptico incluido', 'Lenovo', 'Tab P12', 399.00, 12, '1750020831_75af36558bb44e1b46be.jpg', 8, '2025-06-13 04:48:03', '{\"Procesador\":\"MediaTek Kompanio 1300T\",\"RAM\":\"4GB/8GB\",\"Almacenamiento\":\"128GB/256GB\",\"Pantalla\":\"12.7\\\" 2K\",\"Batería\":\"10200 mAh\",\"Sistema Operativo\":\"Android\",\"Incluye\":\"Lápiz óptico\"}', 24, NULL, NULL, 1, 0),
(69, 'Xiaomi Pad 6 Pro', 'Pantalla 144Hz y procesador Snapdragon 8+ Gen1', 'Xiaomi', 'Pad 6 Pro', 599.00, 9, '1750020788_c71afdb14be1ad3e6bfc.png', 8, '2025-06-13 04:48:03', '{\"Procesador\":\"Snapdragon 8+ Gen 1\",\"RAM\":\"8GB/12GB\",\"Almacenamiento\":\"128GB/256GB/512GB\",\"Pantalla\":\"11\\\" 2.8K 144Hz\",\"Batería\":\"8600 mAh\",\"Sistema Operativo\":\"Android\",\"Carga rápida\":\"67W\"}', 24, NULL, NULL, 1, 0),
(70, 'Samsung Galaxy Tab A8', 'Tablet económica con pantalla FHD', 'Samsung', 'Galaxy Tab A8', 229.00, 20, '1750020774_2e94e0cb602b024c582d.webp', 8, '2025-06-13 04:48:03', '{\"Procesador\":\"Unisoc Tiger T618\",\"RAM\":\"3GB/4GB\",\"Almacenamiento\":\"32GB/64GB/128GB\",\"Pantalla\":\"10.5\\\" FHD\",\"Batería\":\"7040 mAh\",\"Sistema Operativo\":\"Android\",\"Peso\":\"508g\"}', 12, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id_resena` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL CHECK (`calificacion` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id_resena`, `producto_id`, `usuario_id`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 4, 2, 5, 'Excelente teléfono, muy rápido y buena cámara', '2025-05-26 00:00:00'),
(2, 5, 1, 5, 'Excelente producto, muy recomendable.', '2025-06-11 03:34:04'),
(4, 6, 3, 3, 'Producto aceptable, pero esperaba más.', '2025-06-11 03:34:04'),
(5, 4, 1, 1, 'No funcionó correctamente. Tuve que devolverlo.', '2025-06-11 03:34:04'),
(6, 5, 1, 5, 'Excelente producto, muy recomendable.', '2025-06-11 03:34:05'),
(7, 4, 2, 4, 'Buena calidad, pero la entrega fue lenta.', '2025-06-11 03:34:05'),
(8, 6, 3, 5, 'Producto aceptable, pero esperaba más.', '2025-06-19 18:33:18'),
(9, 4, 1, 1, 'No funcionó correctamente. Tuve que devolverlo.', '2025-06-11 03:34:05'),
(16, 34, 4, 3, 'Muy Buen Producto', '2025-06-19 18:31:14'),
(19, 5, 24, 5, 'Excelente notebook, muy rápida y ligera', '2025-06-21 01:22:14'),
(20, 16, 24, 4, 'Buenos auriculares, pero un poco caros', '2025-06-20 01:01:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` enum('cliente','admin') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `password_hash`, `rol`, `fecha_registro`, `username`) VALUES
(1, 'admin@tienda.com', '$2y$10$dNlVWnU8dlG5FcY3ywR3SeM.B6aFJT250bf3dqXls7RxfUeBrMfPu', 'admin', '2025-05-22 23:28:51', 'admin'),
(2, 'cliente17@email.com', '$2y$10$FQQhmvbaQvSaKmeU4v5l/O/pF86NPmhtDDbO.n96UKxO62Modjs1W', 'cliente', '2025-05-22 23:32:23', 'cliente1'),
(3, 'cliente2@email.com', '$2y$10$gdfA0aQwta2JWKtQ5ScOCuhwJGpeG/nAWXyKqwcSBB9WQOU5Gx2OO', 'cliente', '2025-05-22 23:43:02', 'cliente2'),
(4, 'pepe@gmail.com', '$2y$10$gaqx4I3KcG3iECmACB6P5uKEfAEobGqe.zf/zNpfT74.36HM.1b0u', 'cliente', '2025-06-05 07:13:54', 'Pepe'),
(5, 'mauriciobenitezok@gmail.com', '$2y$10$qsIsNcNOR8JDu/zsCQGT6O.BN5WusshawmcrSZhyZlGVBPfBPNO6O', 'cliente', '2025-06-05 08:11:48', 'enzo'),
(6, 'admin@gmail.com', '$2y$10$OXo1XhX/qorgMsB0vRrgc.p6QyjmmPpAFdlNNJE0rBTgMb1lC61km', 'admin', '2025-06-06 09:06:02', 'Jefe'),
(16, 'moski@gmail.com', '$2y$10$MSNB5M7Uf3fD1uVYfNVCSOmZnlbbPO9Gs2lKAUxoh0Ody3sAWCfci', 'cliente', '2025-06-08 05:33:45', 'moski'),
(17, 'god@gmail.com', '$2y$10$QJAV0SOZI1hWK1c2hTw0zOnXhS1Nwwopo3K2NwPKSJqFjOWh/KS2y', 'cliente', '2025-06-08 05:35:22', 'God'),
(18, 'cesiliaacosta01@gmail.com', '$2y$10$pUNctLb.T.u7CWdos1vONed.8vA/ackUdBy3fA1IA0k7Zz/0IzOCS', 'cliente', '2025-06-08 05:37:48', 'enzop'),
(19, 'baul@gmail.com', '$2y$10$UZqVeOlXBVoblZ1v01nMhOCPb2LCpuUzk2qdomp5sPE2jTWE2VJr6', 'cliente', '2025-06-08 10:26:29', 'Baul'),
(20, 'jesus@gmail.com', '$2y$10$bw0OOjqcz3dzvrHNVrkak.T/VRdNF3Z14yk5Zk4lBA5jA8MoF/K0C', 'cliente', '2025-06-08 11:16:03', 'Jesus'),
(21, 'yo@gmail.com', '$2y$10$S9iDO2pQGNtL/UHuuAuVQewC5UARRt5GT6QpVw3PHDcgf0nXeN9NO', 'cliente', '2025-06-08 11:29:17', 'yoyo'),
(22, 'prueba@gmail.com', '$2y$10$3aY98RPrgeV1zehreOjPqOYHxM9MBtErnpeedsT7NiiV508Q0tB2e', 'cliente', '2025-06-18 22:56:39', 'Prueba'),
(23, 'user@gmail.com', '$2y$10$76W4F5X7EPsCMl9yCHQSOeWnIo89vSfL2wOt8DnsFBeH5rQkTzgQS', 'cliente', '2025-06-19 18:37:44', 'Usuariotest'),
(24, 'juan@gmail.com', '$2y$10$Dm.obNZwF55a0aJxujgo4e2n/nSNULzNxw6eQFTMo8XArj1VF1QDK', 'cliente', '2025-06-20 01:01:37', 'Juan'),
(26, 'test@gmail.com', '$2y$10$w8gZYna2hpDosI7AfDY.K.oBiX6VvZBzHMCqUWur4PgPrXcpyw6Bi', 'cliente', '2025-06-26 18:52:48', 'test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL,
  `estado` enum('pendiente','pagado','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) DEFAULT NULL,
  `id_direccion_envio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `usuario_id`, `fecha_venta`, `fecha_actualizacion`, `estado`, `total`, `id_direccion_envio`) VALUES
(6, 2, '2025-06-11 05:40:14', '2025-06-11 05:57:21', 'enviado', 1800.00, 5),
(7, 3, '2025-06-11 05:41:05', '2025-06-11 18:47:56', 'cancelado', 1950.00, 2),
(9, 5, '2025-06-11 05:44:45', NULL, 'entregado', 2249.99, 4),
(10, 4, '2025-06-11 05:45:17', '2025-06-18 18:41:37', 'entregado', 749.00, 6),
(11, 2, '2025-06-11 06:01:59', '2025-06-12 14:57:22', 'enviado', 1549.99, 7),
(12, 3, '2025-06-11 06:01:59', '2025-06-12 15:55:48', 'entregado', 1799.00, 8),
(13, 2, '2025-06-19 02:23:44', NULL, 'entregado', 1399.99, 9),
(14, 4, '2025-06-19 02:24:06', NULL, 'pagado', 249.99, 10),
(50, 5, '2025-06-19 02:30:54', NULL, 'entregado', 1049.99, 24),
(51, 4, '2025-06-19 06:26:55', '2025-06-19 14:32:28', 'cancelado', 1400.00, 0),
(52, 4, '2025-06-19 07:03:47', '2025-06-19 14:32:22', 'cancelado', 1500.00, 25),
(53, 4, '2025-06-19 07:21:37', '2025-06-19 14:32:16', 'cancelado', 750.00, 26),
(54, 4, '2025-06-19 17:30:18', '2025-06-19 14:31:21', 'entregado', 1358.00, 27),
(55, 4, '2025-06-19 19:00:23', '2025-06-19 16:00:23', 'pagado', 679.00, 28),
(56, 4, '2025-06-19 19:24:12', '2025-06-19 16:24:12', 'pagado', 3845.00, 29),
(57, 4, '2025-06-20 03:46:08', '2025-06-20 00:47:40', 'entregado', 1100.00, 30),
(58, 24, '2025-06-20 01:01:37', NULL, 'entregado', 3845.00, 31),
(59, 4, '2025-06-20 04:32:06', '2025-06-20 01:32:06', 'pagado', 679.00, 32),
(60, 4, '2025-06-26 06:45:03', '2025-06-26 03:45:03', 'pagado', 679.00, 33),
(61, 4, '2025-06-26 15:50:06', '2025-06-26 12:50:06', 'pagado', 350.00, 34),
(62, 24, '2025-06-26 16:14:25', '2025-06-26 13:14:25', 'pagado', 2649.90, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_items`
--

CREATE TABLE `venta_items` (
  `id_item` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_items`
--

INSERT INTO `venta_items` (`id_item`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 7, 5, 1, 1500.00),
(2, 7, 6, 1, 350.00),
(6, 9, 32, 1, 749.00),
(7, 6, 4, 1, 750.00),
(8, 6, 6, 1, 350.00),
(9, 6, 5, 1, 700.00),
(10, 10, 4, 1, 750.00),
(11, 10, 6, 1, 350.00),
(12, 11, 14, 1, 120.00),
(13, 11, 10, 1, 1000.00),
(14, 11, 16, 1, 249.99),
(15, 12, 20, 1, 549.01),
(16, 13, 4, 1, 750.00),
(17, 13, 6, 1, 649.99),
(18, 14, 16, 1, 249.99),
(46, 50, 13, 1, 250.00),
(47, 50, 16, 1, 249.99),
(48, 50, 14, 1, 120.00),
(49, 50, 12, 1, 430.00),
(50, 51, 22, 1, 1400.00),
(51, 52, 19, 1, 1500.00),
(52, 53, 4, 1, 750.00),
(53, 54, 34, 2, 679.00),
(54, 55, 34, 1, 679.00),
(55, 56, 34, 5, 679.00),
(56, 56, 8, 1, 450.00),
(57, 57, 9, 1, 1100.00),
(58, 58, 5, 1, 1500.00),
(59, 58, 16, 2, 249.99),
(60, 58, 34, 1, 679.00),
(61, 59, 34, 1, 679.00),
(62, 60, 34, 1, 679.00),
(63, 61, 6, 1, 350.00),
(64, 62, 6, 5, 350.00),
(65, 62, 51, 10, 89.99);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `fk_carritos_usuarios` (`usuario_id`);

--
-- Indices de la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `carrito_id` (`carrito_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `carrusel`
--
ALTER TABLE `carrusel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `idx_estado` (`estado`),
  ADD KEY `idx_asunto` (`asunto`),
  ADD KEY `idx_fecha_creacion` (`fecha_creacion`);

--
-- Indices de la tabla `destacados`
--
ALTER TABLE `destacados`
  ADD PRIMARY KEY (`id_destacado`),
  ADD KEY `fk_destacados_productos` (`producto_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `fk_direcciones_usuarios` (`usuario_id`);

--
-- Indices de la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  ADD PRIMARY KEY (`id_direccion_envio`),
  ADD KEY `venta_id` (`venta_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `pedido_id` (`venta_id`);

--
-- Indices de la tabla `historico_ventas`
--
ALTER TABLE `historico_ventas`
  ADD PRIMARY KEY (`id_historico`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `pedido_id` (`venta_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `usuario_unico` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `idx_stock` (`stock`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `fk_resenas_usuarios` (`usuario_id`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_ventas_usuarios` (`usuario_id`),
  ADD KEY `idx_fecha_venta` (`fecha_venta`);

--
-- Indices de la tabla `venta_items`
--
ALTER TABLE `venta_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `pedido_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `carrusel`
--
ALTER TABLE `carrusel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `destacados`
--
ALTER TABLE `destacados`
  MODIFY `id_destacado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  MODIFY `id_direccion_envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historico_ventas`
--
ALTER TABLE `historico_ventas`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `venta_items`
--
ALTER TABLE `venta_items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_carritos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  ADD CONSTRAINT `fk_carrito_items_carritos` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id_carrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_carrito_items_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `destacados`
--
ALTER TABLE `destacados`
  ADD CONSTRAINT `fk_destacados_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_direcciones_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  ADD CONSTRAINT `direccion_envio_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_facturas_ventas` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historico_ventas`
--
ALTER TABLE `historico_ventas`
  ADD CONSTRAINT `historico_ventas_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historico_ventas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pagos_ventas` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `fk_personas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `fk_resenas_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resenas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `venta_items`
--
ALTER TABLE `venta_items`
  ADD CONSTRAINT `fk_venta_items_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_venta_items_ventas` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
