-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2025 a las 00:31:02
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
(1, 2, '2025-05-23 16:00:00'),
(2, 3, '2025-05-23 17:30:00');

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
(1, 1, 4, 1),
(2, 1, 5, 1),
(3, 2, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Electrónica', 'Productos electrónicos y dispositivos'),
(2, 'Informática', 'Ordenadores, portátiles y accesorios'),
(4, 'Celulares', 'Descubrí nuestra amplia variedad de celulares de última generación.'),
(5, 'Notebooks', 'Las mejores noteboks del pais'),
(6, 'Perifericos', ''),
(7, 'Auriculares', ''),
(8, 'Tablets', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre_tienda` varchar(100) NOT NULL,
  `email_tienda` varchar(100) NOT NULL,
  `telefono_tienda` varchar(20) DEFAULT NULL,
  `direccion_tienda` varchar(255) DEFAULT NULL,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `envio_gratis_desde` decimal(10,2) DEFAULT NULL,
  `tiempo_entrega` int(11) NOT NULL DEFAULT 1,
  `pago_tarjeta` tinyint(1) NOT NULL DEFAULT 1,
  `pago_transferencia` tinyint(1) NOT NULL DEFAULT 1,
  `cuenta_bancaria` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `horario_atencion` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `mensaje_bienvenida` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre_tienda`, `email_tienda`, `telefono_tienda`, `direccion_tienda`, `costo_envio`, `envio_gratis_desde`, `tiempo_entrega`, `pago_tarjeta`, `pago_transferencia`, `cuenta_bancaria`, `facebook_url`, `instagram_url`, `twitter_url`, `horario_atencion`, `logo_url`, `mensaje_bienvenida`) VALUES
(1, 'Mi Tienda', 'admin@mitienda.com', '', '', 0.00, NULL, 1, 1, 1, '', NULL, NULL, NULL, NULL, NULL, NULL);

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
(12, 'lisandro', 'hola', 'lisandrolopezz359@gmail.com', '3794000000', 'Soporte Tecnico', 'hola prueba', 'llamada', 'Sin Leer', '2025-06-12 13:36:41', '2025-06-12 13:36:41');

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
(3, 3, 'particular', 'Domicilio', 'Plaza Central 789', '08001', 'Barcelona', 'Barcelona', 'España', 1, '2025-05-23 00:02:00');

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
  `pais` varchar(50) NOT NULL DEFAULT 'España',
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
(8, 12, 'Av. Siempre Viva 742', 'Barcelona', 'Cataluña', '08008', 'España', 'María Gómez', '600000003', 'Dejar en portería');

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
(0, 11, '2025-06-11 18:53:57', 'DNI: 87654321B, Nombre: Juan Pérez', 'facturas/factura-11.pdf');

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
(37, 12, 'entregado', 'entregado', 'Estado cambiado a entregado', 6, '2025-06-12 12:55:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `estado` enum('exitoso','fallido') DEFAULT 'exitoso',
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `venta_id`, `monto`, `metodo_pago`, `estado`, `fecha_pago`) VALUES
(1, 7, 1950.00, 'transferencia', 'exitoso', '2025-06-11 05:44:31'),
(2, 6, 1800.00, 'tarjeta', 'exitoso', '2025-06-11 05:52:14'),
(3, 9, 2249.99, 'tarjeta', 'exitoso', '2025-06-11 05:52:24'),
(4, 10, 749.00, 'tarjeta', 'exitoso', '2025-06-11 05:52:34'),
(5, 11, 1549.99, 'tarjeta', 'exitoso', '2025-06-11 06:01:59'),
(6, 12, 1799.00, 'transferencia', 'exitoso', '2025-06-11 06:01:59');

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
  `telefono_alternativo` varchar(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `usuario_id`, `tipo_documento`, `documento`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `telefono`, `telefono_alternativo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 1, 'DNI', '12345678A', 'Admin', 'Sistema', '1980-01-01', 'H', '600000001', NULL, '2025-05-22 23:28:51', '2025-05-22 23:28:51'),
(2, 2, 'DNI', '87654321B', 'Juan', 'Pérez', '1990-05-15', 'H', '600000002', '910000002', '2025-05-22 23:32:23', '2025-05-22 23:32:23'),
(3, 3, 'NIE', 'X1234567C', 'María', 'Gómez', '1985-08-20', 'M', '600000003', NULL, '2025-05-22 23:43:02', '2025-05-22 23:43:02'),
(4, 4, 'DNI', '35478963C', 'Pepe', 'González', '1988-03-20', 'H', '611111111', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(5, 5, 'DNI', '29100502B', 'Enzo', 'Benítez', '1993-11-10', 'H', '610000000', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(6, 6, 'DNI', '30111222F', 'Jefe', 'Administrador', '1975-01-01', 'H', '699999999', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(7, 16, 'DNI', '33322111X', 'Moski', 'López', '1995-06-15', 'O', '600111111', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(8, 17, 'DNI', '28877221K', 'God', 'Mode', '1990-07-07', 'H', '600222222', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(9, 18, 'DNI', '31999888H', 'Cesilia', 'Acosta', '1992-04-02', 'M', '600333333', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(10, 19, 'DNI', '31222333J', 'Baul', 'Martínez', '1991-12-24', 'H', '600444444', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(11, 20, 'DNI', '30201011Z', 'Jesus', 'Nazareno', '0001-01-01', 'H', '600555555', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42'),
(12, 21, 'DNI', '32323232Q', 'Yoyo', 'Tester', '1999-09-09', 'O', '600666666', NULL, '2025-06-11 06:11:42', '2025-06-11 06:11:42');

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
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `marca`, `modelo`, `precio`, `stock`, `imagen_url`, `categoria_id`, `fecha_alta`, `especificaciones`, `garantia_meses`, `peso_kg`, `dimensiones`, `activo`) VALUES
(4, 'Xiaomi 14T', '512GB RAM | Color: Black', 'Xiaomi', '14T', 750.00, 30, 'xiaomi14t.png', 4, '2025-06-10 02:26:52', '{\"Origen\":\"China\",\"Garantia\":\"Extendida\",\"Ram\":\"516GB\"}', 24, NULL, NULL, 1),
(5, 'Lenovo ThinkPad X1 Carbon', 'Intel Core i7 vPro | Teclado mecánico', 'Lenovo', 'ThinkPad X1 Carbon', 1500.00, 16, 'lenovo.png', 5, '2025-06-09 23:26:52', NULL, 36, NULL, NULL, 1),
(6, 'Poco X6 Pro', '256GB RAM | Color: Yellow', 'Xiaomi', 'X6 Pro', 350.00, 41, 'pocox6pro.png', 4, '2025-06-09 23:26:52', NULL, 12, NULL, NULL, 1),
(7, 'Xiaomi Pad 6', 'Snapdragon 870 | Pantalla 11 2,8K', 'Xiaomi', 'Pad 6', 369.00, 25, 'xiaomipad6.png', 1, '2025-06-09 23:26:52', '{\"Procesador\":\"Snapdragon 870\", \"RAM\":\"6GB\", \"Almacenamiento\":\"128GB\", \"Pantalla\":\"11\" 2.8K\", \"Batería\":\"8840mAh\"}', 12, 0.49, '25.4x16.5x0.65 cm', 1),
(8, 'Samsung A55 5G', '512GB RAM | Color: White', 'Samsung', 'A55 5G', 450.00, 35, 'a55.png', 1, '2025-06-09 23:26:52', '{\"Almacenamiento\":\"512GB\", \"Color\":\"White\", \"RAM\":\"8GB\", \"Pantalla\":\"6.6\" Super AMOLED\", \"Procesador\":\"Exynos 1480\"}', 24, 0.21, '16.1x7.7x0.83 cm', 1),
(9, 'Samsung S25 Ultra', '1024GB RAM | Color: White', 'Samsung', 'S25 Ultra', 1100.00, 20, 's25ultra.png', 1, '2025-06-09 23:26:52', '{\"Almacenamiento\":\"1TB\", \"Color\":\"White\", \"RAM\":\"12GB\", \"Pantalla\":\"6.8\" Dynamic AMOLED 2X\", \"Procesador\":\"Exynos 2500\"}', 36, 0.23, '16.3x7.8x0.85 cm', 1),
(10, 'iPhone 16', '512GB RAM | Color: Blue', 'Apple', 'iPhone 16', 1000.00, 30, 'iphone16.png', 1, '2025-06-09 23:26:52', '{\"Almacenamiento\":\"512GB\", \"Color\":\"Blue\", \"RAM\":\"6GB\", \"Pantalla\":\"6.1\" Super Retina XDR\", \"Procesador\":\"A18 Bionic\"}', 12, 0.17, '14.7x7.2x0.78 cm', 1),
(11, 'iPhone 16 Pro Max', '1024GB RAM | Color: White', 'Apple', 'iPhone 16 Pro Max', 1250.00, 15, 'iphone16promax.png', 1, '2025-06-09 23:26:52', '{\"Almacenamiento\":\"1TB\", \"Color\":\"White\", \"RAM\":\"8GB\", \"Pantalla\":\"6.7\" Super Retina XDR\", \"Procesador\":\"A18 Pro Bionic\"}', 12, 0.22, '16.1x7.8x0.80 cm', 1),
(12, 'Redmi Note 13 Pro', '512GB RAM | Color: Blue', 'Xiaomi', 'Redmi Note 13 Pro', 450.00, 30, 'redminote13pro.png', 4, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(13, 'Poco X6', '256GB RAM | Color: White', 'Xiaomi', 'Poco X6', 250.00, 40, 'pocox6.png', 4, '2025-06-10 06:08:43', '{\"Almacenamiento\":\"256GB\",\"Color\":\"White\",\"RAM\":\"8GB\"}', 12, NULL, NULL, 1),
(14, 'Redmi Buds 4', 'in-ear | USB tipo C', 'Xiaomi', 'Redmi Buds 4', 120.00, 50, 'redmibuds4.png', 7, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(15, 'Redmi Buds 5', 'in-ear | USB tipo C', 'Xiaomi', 'Redmi Buds 5', 140.00, 45, 'redmibuds5.png', 7, '2025-06-10 06:08:43', '{\"Tipo\":\"in-ear\",\"Conectividad\":\"USB tipo C\"}', 12, NULL, NULL, 1),
(16, 'Apple AirPods Pro 2', 'Chip H2 | Cancelación de ruido mejorada + Modo ambiente', 'Apple', 'AirPods Pro 2', 249.99, 30, 'airPods.png', 7, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(17, 'Samsung Galaxy Buds 2 Pro', 'Sonido Hi-Fi de 24 bits | Cancelación activa de ruido', 'Samsung', 'Galaxy Buds 2 Pro', 142.00, 35, 'galaxybuds.png', 7, '2025-06-10 06:08:43', '{\"Sonido\":\"Hi-Fi de 24 bits\",\"Caracter\\u00edsticas\":\"Cancelaci\\u00f3n activa de ruido\"}', 12, NULL, NULL, 1),
(18, 'Galaxy Book 3', '16GB RAM | 152GB SSD', 'Samsung', 'Galaxy Book 3', 1200.00, 20, 'galaxybook3.png', 5, '2025-06-10 06:08:43', '{\"RAM\":\"16GB\",\"Almacenamiento\":\"152GB SSD\"}', 24, NULL, NULL, 1),
(19, 'Galaxy Book 3 Pro', '16GB RAM | 1TB SSD', 'Samsung', 'Galaxy Book 3 Pro', 1500.00, 15, 'galaxybook3pro.png', 5, '2025-06-10 06:08:43', '{\"RAM\":\"16GB\",\"Almacenamiento\":\"1TB SSD\"}', 24, NULL, NULL, 1),
(20, 'MacBook Air M2', 'Apple M2 | Pantalla 13,6', 'Apple', 'MacBook Air M2', 1500.00, 25, 'macbookair2.png', 5, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2\",\"Pantalla\":\"13.6 pulgadas\"}', 24, NULL, NULL, 1),
(21, 'MacBook Pro M3', 'Apple M3 | Pantalla 120Hz', 'Apple', 'MacBook Pro M3', 1700.00, 15, 'macbookpro3.png', 2, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M3\", \"Pantalla\":\"120Hz\"}', 24, 1.40, '31.2x22.1x1.6 cm', 1),
(22, 'Dell XPS 13', 'Intel Core i7 | Pantalla 4k', 'Dell', 'XPS 13', 1400.00, 20, 'dell.png', 2, '2025-06-10 06:08:43', NULL, 24, NULL, NULL, 1),
(23, 'Asus ROG Zephyrus G14', 'AMD Ryzen 9 | RTX 4060', 'Asus', 'ROG Zephyrus G14', 1700.00, 10, 'zephyrus.png', 2, '2025-06-10 06:08:43', '{\"Procesador\":\"AMD Ryzen 9\", \"GPU\":\"RTX 4060\"}', 24, 1.65, '31.2x22.7x1.9 cm', 1),
(24, 'Logitech MX Master 3S', 'Sensor de 8K DPI | Scroll MagSpeed', 'Logitech', 'MX Master 3S', 340.00, 30, 'logitechmouse.png', 6, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(25, 'Razer DeathAdder V3', 'Sensor Focus Pro 30K DPI | Super liviano (63g)', 'Razer', 'DeathAdder V3', 161.99, 40, 'razermouse.png', 6, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(26, 'Redragon Kumara K552', 'Teclado mecánico compacto | Switches Outemu Blue', 'Redragon', 'Kumara K552', 70.00, 50, 'KUMARA.png', 6, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(27, 'SteelSeries Apex Pro', 'Switches OmniPoint ajustables | Pantalla OLED integrada', 'SteelSeries', 'Apex Pro', 119.00, 25, 'steel.png', 6, '2025-06-10 06:08:43', '{\"Switches\":\"OmniPoint ajustables\",\"Caracter\\u00edsticas\":\"Pantalla OLED integrada\"}', 12, NULL, NULL, 1),
(28, 'Elgato Stream Deck', '15 botones LCD programables | Integración con OBS, Twitch, Spotify, etc.', 'Elgato', 'Stream Deck', 250.00, 20, 'streamdeck.png', 6, '2025-06-10 06:08:43', '{\"Botones\":\"15 LCD programables\",\"Integraciones\":\"OBS, Twitch, Spotify\"}', 12, NULL, NULL, 1),
(29, 'HyperX QuadCast', 'Micrófono de condensador con 4 patrones polares | Filtro antipop y shock mount integrados', 'HyperX', 'QuadCast', 139.99, 15, 'microfonohyper.png', 6, '2025-06-10 06:08:43', '{\"Tipo\":\"condensador\",\"Patrones polares\":\"4\",\"Caracter\\u00edsticas\":\"Filtro antipop y shock mount\"}', 12, NULL, NULL, 1),
(30, 'Logitech C920s Pro', 'Resolución Full HD 1080p | Micrófono estéreo dual', 'Logitech', 'C920s Pro', 49.99, 30, 'camaralogi.png', 6, '2025-06-10 06:08:43', '{\"Resoluci\\u00f3n\":\"Full HD 1080p\",\"Micr\\u00f3fono\":\"est\\u00e9reo dual\"}', 12, NULL, NULL, 1),
(31, 'iPad Pro M2', 'Apple M2 | Pantalla XDR 120Hz', 'Apple', 'iPad Pro M2', 799.00, 20, 'ipadprom2.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2\",\"Pantalla\":\"XDR 120Hz\"}', 12, NULL, NULL, 1),
(32, 'iPad Air M2', 'Apple M2 | Pantalla Retina 10,9', 'Apple', 'iPad Air M2', 749.00, 25, 'ipadair13.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple M2\",\"Pantalla\":\"Retina 10.9\"}', 12, NULL, NULL, 1),
(33, 'iPad (10ª generación)', 'Apple A14 | Pantalla Retina 10,9', 'Apple', 'iPad 10', 579.00, 30, 'ipad10.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Apple A14\",\"Pantalla\":\"Retina 10.9\"}', 12, NULL, NULL, 1),
(34, 'Samsung Galaxy Tab S9 Ultra', 'Snapdragon 8 Gen 2 | Pantalla Amoled 14,6', 'Samsung', 'Galaxy Tab S9 Ultra', 679.00, 15, 'galaxytabs9ultra.png', 8, '2025-06-10 06:08:43', NULL, 12, NULL, NULL, 1),
(35, 'Samsung Galaxy Tab S9 FE', 'Exynos 1380 | Pantalla LCD 12,4', 'Samsung', 'Galaxy Tab S9 FE', 449.00, 20, 'tabgalaxys9fe.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Exynos 1380\",\"Pantalla\":\"LCD 12.4\"}', 12, NULL, NULL, 1),
(36, 'Microsoft Surface Pro 9', 'Intel Core i5/i7 | Pantalla PixelSense de 13', 'Microsoft', 'Surface Pro 9', 999.00, 15, 'surface.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Intel Core i5\\/i7\",\"Pantalla\":\"PixelSense 13\"}', 12, NULL, NULL, 1),
(37, 'Amazon Fire HD 10', 'Octa-Core | Pantalla Full-HD 10,1', 'Amazon', 'Fire HD 10', 150.00, 30, 'amazon.png', 8, '2025-06-10 06:08:43', '{\"Procesador\":\"Octa-Core\",\"Pantalla\":\"Full-HD 10.1\"}', 12, NULL, NULL, 1);

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
(8, 6, 3, 3, 'Producto aceptable, pero esperaba más.', '2025-06-11 03:34:05'),
(9, 4, 1, 1, 'No funcionó correctamente. Tuve que devolverlo.', '2025-06-11 03:34:05'),
(10, 4, 4, 5, 'Todo Perfecto.', '2025-06-12 15:57:48');

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
(17, 'god@gmail.com', '$2y$10$QJAV0SOZI1hWK1c2hTw0zOnXhS1Nwwopo3K2NwPKSJqFjOWh/KS2y', 'admin', '2025-06-08 05:35:22', 'God'),
(18, 'cesiliaacosta01@gmail.com', '$2y$10$pUNctLb.T.u7CWdos1vONed.8vA/ackUdBy3fA1IA0k7Zz/0IzOCS', 'cliente', '2025-06-08 05:37:48', 'enzop'),
(19, 'baul@gmail.com', '$2y$10$UZqVeOlXBVoblZ1v01nMhOCPb2LCpuUzk2qdomp5sPE2jTWE2VJr6', 'cliente', '2025-06-08 10:26:29', 'Baul'),
(20, 'jesus@gmail.com', '$2y$10$bw0OOjqcz3dzvrHNVrkak.T/VRdNF3Z14yk5Zk4lBA5jA8MoF/K0C', 'cliente', '2025-06-08 11:16:03', 'Jesus'),
(21, 'yo@gmail.com', '$2y$10$S9iDO2pQGNtL/UHuuAuVQewC5UARRt5GT6QpVw3PHDcgf0nXeN9NO', 'cliente', '2025-06-08 11:29:17', 'yoyo');

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
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `usuario_id`, `fecha_venta`, `fecha_actualizacion`, `estado`, `total`) VALUES
(6, 2, '2025-06-11 05:40:14', '2025-06-11 05:57:21', 'enviado', 1800.00),
(7, 3, '2025-06-11 05:41:05', '2025-06-11 18:47:56', 'cancelado', 1950.00),
(9, 5, '2025-06-11 05:44:45', NULL, 'entregado', 2249.99),
(10, 4, '2025-06-11 05:45:17', NULL, 'pagado', 749.00),
(11, 2, '2025-06-11 06:01:59', '2025-06-12 14:57:22', 'enviado', 1549.99),
(12, 3, '2025-06-11 06:01:59', '2025-06-12 15:55:48', 'entregado', 1799.00);

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
(10, 11, 4, 1, 750.00),
(11, 11, 6, 1, 350.00),
(12, 11, 14, 1, 120.00),
(13, 12, 10, 1, 1000.00),
(14, 12, 16, 1, 249.99),
(15, 12, 20, 1, 549.01);

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
  ADD UNIQUE KEY `documento_unico` (`tipo_documento`,`documento`),
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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  MODIFY `id_direccion_envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historico_ventas`
--
ALTER TABLE `historico_ventas`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `venta_items`
--
ALTER TABLE `venta_items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
