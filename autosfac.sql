-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2019 a las 02:33:47
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `autosfac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_codigopais`
--

CREATE TABLE `cs_codigopais` (
  `cs_codigopais_id` int(11) NOT NULL,
  `cs_codigopais_cod` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `cs_codigopais_des` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_codigopais`
--

INSERT INTO `cs_codigopais` (`cs_codigopais_id`, `cs_codigopais_cod`, `cs_codigopais_des`) VALUES
(1, 'PE', 'PERU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_documentosrelacionados`
--

CREATE TABLE `cs_documentosrelacionados` (
  `cs_documentosrelacionados_id` int(11) NOT NULL,
  `cs_documentosrelacionados_cod` int(2) NOT NULL,
  `cs_documentosrelacionados_des` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_elementosadicionales`
--

CREATE TABLE `cs_elementosadicionales` (
  `cs_elementosadicionales_id` int(11) NOT NULL,
  `cs_elementosadicionales_cod` int(4) NOT NULL,
  `cs_elementosadicionales_des` tinytext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_elementosadicionales`
--

INSERT INTO `cs_elementosadicionales` (`cs_elementosadicionales_id`, `cs_elementosadicionales_cod`, `cs_elementosadicionales_des`) VALUES
(1, 1000, 'Monto en Letras'),
(2, 1002, 'Leyenda \"TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE\"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_modalidadtranslado`
--

CREATE TABLE `cs_modalidadtranslado` (
  `cs_modalidadtranslado_id` int(11) NOT NULL,
  `cs_modalidadtranslado_cod` int(2) NOT NULL,
  `cs_modalidadtranslado_des` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_modalidadtranslado`
--

INSERT INTO `cs_modalidadtranslado` (`cs_modalidadtranslado_id`, `cs_modalidadtranslado_cod`, `cs_modalidadtranslado_des`) VALUES
(1, 1, 'Transporte público'),
(2, 2, 'Transporte privado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_motivostranslado`
--

CREATE TABLE `cs_motivostranslado` (
  `cs_motivostranslado_id` int(11) NOT NULL,
  `cs_motivostranslado_cod` int(2) NOT NULL,
  `cs_motivostranslado_des` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_otrosconceptos`
--

CREATE TABLE `cs_otrosconceptos` (
  `cs_otrosconceptos_id` int(11) NOT NULL,
  `cs_otrosconceptos_cod` int(4) NOT NULL,
  `cs_otrosconceptos_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_otrosconceptos`
--

INSERT INTO `cs_otrosconceptos` (`cs_otrosconceptos_id`, `cs_otrosconceptos_cod`, `cs_otrosconceptos_des`) VALUES
(1, 1001, 'Total valor de venta - operaciones gravadas'),
(2, 1002, 'Total valor de venta - operaciones inafectas'),
(3, 1003, 'Total valor de venta - operaciones exoneradas'),
(4, 1004, 'Total valor de venta - operaciones gratuitas'),
(5, 1005, 'Sub total de venta'),
(6, 2001, 'Percepciones'),
(7, 2002, 'Retenciones'),
(8, 2003, 'Detracciones'),
(9, 2004, 'Bonificaciones'),
(10, 2005, 'Total descuentos'),
(11, 3001, 'FISE (Ley 29852) Fondo Inclusión Social Energético');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_resumendiario`
--

CREATE TABLE `cs_resumendiario` (
  `cs_resumendiario_id` int(11) NOT NULL,
  `cs_resumendiario_cod` int(1) NOT NULL,
  `cs_resumendiario_des` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_resumendiario`
--

INSERT INTO `cs_resumendiario` (`cs_resumendiario_id`, `cs_resumendiario_cod`, `cs_resumendiario_des`) VALUES
(1, 1, 'Adicionar'),
(2, 2, 'Modificado'),
(3, 3, 'Anulado'),
(4, 4, 'Anulado en el día (anulado antes de informar comprobante)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_resumendiarioboletas`
--

CREATE TABLE `cs_resumendiarioboletas` (
  `cs_resumendiarioboletas_id` int(11) NOT NULL,
  `cs_resumendiarioboletas_cod` int(2) NOT NULL,
  `cs_resumendiarioboletas_des` varchar(12) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_resumendiarioboletas`
--

INSERT INTO `cs_resumendiarioboletas` (`cs_resumendiarioboletas_id`, `cs_resumendiarioboletas_cod`, `cs_resumendiarioboletas_des`) VALUES
(1, 1, 'Gravado'),
(2, 2, 'Exonerado'),
(3, 3, 'Inafecto'),
(4, 4, 'Exportación'),
(5, 5, 'Gratuitas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipoafectacionigv`
--

CREATE TABLE `cs_tipoafectacionigv` (
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_cod` int(2) NOT NULL,
  `cs_tipoafectacionigv_des` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipoafectacionigv`
--

INSERT INTO `cs_tipoafectacionigv` (`cs_tipoafectacionigv_id`, `cs_tipoafectacionigv_cod`, `cs_tipoafectacionigv_des`) VALUES
(1, 10, 'Gravado — Operación Onerosa'),
(2, 11, 'Gravado — Retiro por premio'),
(3, 12, 'Gravado — Retiro por donación'),
(4, 13, 'Gravado — Retiro'),
(5, 14, 'Gravado — Retiro por publicidad'),
(6, 15, 'Gravado — Bonificaciones'),
(7, 16, 'Gravado — Retiro por entrega a trabajadores'),
(8, 17, 'Gravado — IVAP'),
(9, 20, 'Exonerado — Operación Onerosa'),
(10, 21, 'Exonerado — Transferencia Gratuita'),
(11, 30, 'Inafecto — Operación Onerosa'),
(12, 31, 'Inafecto — Retiro por Bonificación'),
(13, 32, 'Inafecto — Retiro'),
(14, 33, 'Inafecto — Retiro por Muestras Médicas'),
(15, 34, 'Inafecto — Retiro por Convenio Colectivo'),
(16, 35, 'Inafecto — Retiro por Premio'),
(17, 36, 'Inafecto — Retiro por publicidad'),
(18, 40, 'Exportación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipodocumento`
--

CREATE TABLE `cs_tipodocumento` (
  `cs_tipodocumento_id` int(11) NOT NULL,
  `cs_tipodocumento_cod` int(2) NOT NULL,
  `cs_tipodocumento_des` tinytext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipodocumento`
--

INSERT INTO `cs_tipodocumento` (`cs_tipodocumento_id`, `cs_tipodocumento_cod`, `cs_tipodocumento_des`) VALUES
(1, 1, 'FACTURA'),
(2, 3, 'BOLETA DE VENTA'),
(3, 7, 'NOTA DE CREDITO'),
(4, 8, 'NOTA DE DEBITO'),
(5, 4, 'LIQUIDACION DE COMPRA'),
(6, 91, 'INVOICE'),
(7, 50, 'DUA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipodocumentoidentidad`
--

CREATE TABLE `cs_tipodocumentoidentidad` (
  `cs_tipodocumentoidentidad_id` int(11) NOT NULL,
  `cs_tipodocumentoidentidad_cod` tinyint(1) NOT NULL,
  `cs_tipodocumentoidentidad_des` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipodocumentoidentidad`
--

INSERT INTO `cs_tipodocumentoidentidad` (`cs_tipodocumentoidentidad_id`, `cs_tipodocumentoidentidad_cod`, `cs_tipodocumentoidentidad_des`) VALUES
(1, 1, 'DOC. NACIONAL DE IDENTIDAD'),
(2, 6, 'REG. UNICO DE CONTRIBUYENTES'),
(3, 0, 'OTROS TIPOS DE DOCUMENTOS'),
(4, 4, 'CARNET DE EXTRANJERIA'),
(5, 7, 'PASAPORTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipomoneda`
--

CREATE TABLE `cs_tipomoneda` (
  `cs_tipomoneda_id` int(11) NOT NULL,
  `cs_tipomoneda_cod` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipomoneda_des` varchar(35) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipomoneda`
--

INSERT INTO `cs_tipomoneda` (`cs_tipomoneda_id`, `cs_tipomoneda_cod`, `cs_tipomoneda_des`) VALUES
(1, 'PEN', 'Nuevo Sol'),
(2, 'USD', 'US Dollar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tiponotacreditoelectronica`
--

CREATE TABLE `cs_tiponotacreditoelectronica` (
  `cs_tiponotacreditoelectronica_id` int(11) NOT NULL,
  `cs_tiponotacreditoelectronica_cod` int(2) NOT NULL,
  `cs_tiponotacreditoelectronica_des` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tiponotacreditoelectronica`
--

INSERT INTO `cs_tiponotacreditoelectronica` (`cs_tiponotacreditoelectronica_id`, `cs_tiponotacreditoelectronica_cod`, `cs_tiponotacreditoelectronica_des`) VALUES
(1, 1, 'Anulación de la operación'),
(2, 2, 'Corrección por error en el RUC'),
(3, 3, 'Corrección por error en la descripción'),
(4, 4, 'Descuento global'),
(5, 5, 'Descuento por ítem'),
(6, 6, 'Devolución total'),
(7, 7, 'Devolución por ítem'),
(8, 8, 'Bonificación'),
(9, 9, 'Disminución en el valor'),
(10, 10, 'Otros conceptos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tiponotadedebitoelectronica`
--

CREATE TABLE `cs_tiponotadedebitoelectronica` (
  `cs_tiponotadedebitoelectronica_id` int(11) NOT NULL,
  `cs_tiponotadedebitoelectronica_cod` int(2) NOT NULL,
  `cs_tiponotadedebitoelectronica_des` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tiponotadedebitoelectronica`
--

INSERT INTO `cs_tiponotadedebitoelectronica` (`cs_tiponotadedebitoelectronica_id`, `cs_tiponotadedebitoelectronica_cod`, `cs_tiponotadedebitoelectronica_des`) VALUES
(1, 1, 'Intereses por mora'),
(2, 2, 'Aumento en el valor'),
(3, 3, 'Penalidades / otros conceptos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipooperacion`
--

CREATE TABLE `cs_tipooperacion` (
  `cs_tipooperacion_id` int(11) NOT NULL,
  `cs_tipooperacion_cod` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipooperacion_des` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipooperacion`
--

INSERT INTO `cs_tipooperacion` (`cs_tipooperacion_id`, `cs_tipooperacion_cod`, `cs_tipooperacion_des`) VALUES
(1, '0101', 'Venta Interna'),
(2, '2', 'Exportación'),
(3, '3', 'No Domiciliados'),
(4, '4', 'Venta Interna - Anticipos'),
(5, '5', 'Venta Itinerante'),
(6, '6', 'Factura Guía'),
(7, '7', 'Venta Arroz Pilado'),
(8, '8', 'Factura - Comprobante de Percepción'),
(9, '10', 'Factura - Guía Remitente'),
(10, '11', 'Factura - Guia Transportista'),
(11, '12', 'Boleta de Venta - Comprobante de Percepción');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipoprecioventa`
--

CREATE TABLE `cs_tipoprecioventa` (
  `cs_tipoprecioventa_id` int(11) NOT NULL,
  `cs_tipoprecioventa_cod` int(2) NOT NULL,
  `cs_tipoprecioventa_des` varchar(56) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipoprecioventa`
--

INSERT INTO `cs_tipoprecioventa` (`cs_tipoprecioventa_id`, `cs_tipoprecioventa_cod`, `cs_tipoprecioventa_des`) VALUES
(1, 1, 'Precio unitario (incluye el IGV)'),
(2, 2, 'Valor referencial unitario en operaciones no onerosas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tiposistemacalculoisc`
--

CREATE TABLE `cs_tiposistemacalculoisc` (
  `cs_tiposistemacalculoisc_id` int(11) NOT NULL,
  `cs_tiposistemacalculoisc_cod` int(2) NOT NULL,
  `cs_tiposistemacalculoisc_des` tinytext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipotributo`
--

CREATE TABLE `cs_tipotributo` (
  `cs_tipoatributo_id` int(11) NOT NULL,
  `cs_tipoatributo_cod` int(4) NOT NULL,
  `cs_tipoatributo_des` varchar(35) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipotributo`
--

INSERT INTO `cs_tipotributo` (`cs_tipoatributo_id`, `cs_tipoatributo_cod`, `cs_tipoatributo_des`) VALUES
(1, 1000, 'IGV IMPUESTO GENERAL A LAS VENTAS'),
(2, 2000, 'ISC IMPUESTO SELECTIVO AL CONSUMO'),
(3, 9999, 'OTROS CONCEPTOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_tipounidadmedida`
--

CREATE TABLE `cs_tipounidadmedida` (
  `cs_tipounidadmedida_id` int(11) NOT NULL,
  `cs_tipounidadmedida_cod` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipounidadmedida_des` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_tipounidadmedida`
--

INSERT INTO `cs_tipounidadmedida` (`cs_tipounidadmedida_id`, `cs_tipounidadmedida_cod`, `cs_tipounidadmedida_des`) VALUES
(1, 'BG', 'BOLSA'),
(2, 'BO', 'BOTELLA'),
(3, 'BX', 'CAJA'),
(4, 'DZN', 'DOCENA'),
(5, 'GRM', 'GRAMO'),
(6, 'SET', 'JUEGO'),
(7, 'KT', 'KIT'),
(8, 'CA', 'LATAS'),
(9, 'LTR', 'LITRO'),
(10, 'MTR', 'METRO'),
(11, 'PK', 'PAQUETE'),
(12, 'NIU', 'UNIDAD (BIENES)'),
(13, 'ZZ', 'UNIDAD (SERVICIOS)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cs_ubigeo`
--

CREATE TABLE `cs_ubigeo` (
  `tb_ubigeo_id` int(11) NOT NULL,
  `tb_ubigeo_coddep` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_codpro` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_coddis` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_tip` enum('Departamento','Provincia','Distrito') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cs_ubigeo`
--

INSERT INTO `cs_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(1, '01', '00', '00', 'AMAZONAS', 'Departamento'),
(2, '02', '00', '00', 'ANCASH', 'Departamento'),
(3, '03', '00', '00', 'APURIMAC', 'Departamento'),
(4, '04', '00', '00', 'AREQUIPA', 'Departamento'),
(5, '05', '00', '00', 'AYACUCHO', 'Departamento'),
(6, '06', '00', '00', 'CAJAMARCA', 'Departamento'),
(7, '07', '00', '00', 'CALLAO', 'Departamento'),
(8, '08', '00', '00', 'CUSCO', 'Departamento'),
(9, '09', '00', '00', 'HUANCAVELICA', 'Departamento'),
(10, '10', '00', '00', 'HUANUCO', 'Departamento'),
(11, '11', '00', '00', 'ICA', 'Departamento'),
(12, '12', '00', '00', 'JUNIN', 'Departamento'),
(13, '13', '00', '00', 'LA LIBERTAD', 'Departamento'),
(14, '14', '00', '00', 'LAMBAYEQUE', 'Departamento'),
(15, '15', '00', '00', 'LIMA', 'Departamento'),
(16, '16', '00', '00', 'LORETO', 'Departamento'),
(17, '17', '00', '00', 'MADRE DE DIOS', 'Departamento'),
(18, '18', '00', '00', 'MOQUEGUA', 'Departamento'),
(19, '19', '00', '00', 'PASCO', 'Departamento'),
(20, '20', '00', '00', 'PIURA', 'Departamento'),
(21, '21', '00', '00', 'PUNO', 'Departamento'),
(22, '22', '00', '00', 'SAN MARTIN', 'Departamento'),
(23, '23', '00', '00', 'TACNA', 'Departamento'),
(24, '24', '00', '00', 'TUMBES', 'Departamento'),
(25, '25', '00', '00', 'UCAYALI', 'Departamento'),
(26, '01', '01', '00', 'CHACHAPOYAS', 'Provincia'),
(27, '01', '02', '00', 'BAGUA', 'Provincia'),
(28, '01', '03', '00', 'BONGARA', 'Provincia'),
(29, '01', '04', '00', 'CONDORCANQUI', 'Provincia'),
(30, '01', '05', '00', 'LUYA', 'Provincia'),
(31, '01', '06', '00', 'RODRIGUEZ DE MENDOZA', 'Provincia'),
(32, '01', '07', '00', 'UTCUBAMBA', 'Provincia'),
(33, '02', '01', '00', 'HUARAZ', 'Provincia'),
(34, '02', '02', '00', 'AIJA', 'Provincia'),
(35, '02', '03', '00', 'ANTONIO RAYMONDI', 'Provincia'),
(36, '02', '04', '00', 'ASUNCION', 'Provincia'),
(37, '02', '05', '00', 'BOLOGNESI', 'Provincia'),
(38, '02', '06', '00', 'CARHUAZ', 'Provincia'),
(39, '02', '07', '00', 'CARLOS FERMIN FITZCARRALD', 'Provincia'),
(40, '02', '08', '00', 'CASMA', 'Provincia'),
(41, '02', '09', '00', 'CORONGO', 'Provincia'),
(42, '02', '10', '00', 'HUARI', 'Provincia'),
(43, '02', '11', '00', 'HUARMEY', 'Provincia'),
(44, '02', '12', '00', 'HUAYLAS', 'Provincia'),
(45, '02', '13', '00', 'MARISCAL LUZURIAGA', 'Provincia'),
(46, '02', '14', '00', 'OCROS', 'Provincia'),
(47, '02', '15', '00', 'PALLASCA', 'Provincia'),
(48, '02', '16', '00', 'POMABAMBA', 'Provincia'),
(49, '02', '17', '00', 'RECUAY', 'Provincia'),
(50, '02', '18', '00', 'SANTA', 'Provincia'),
(51, '02', '19', '00', 'SIHUAS', 'Provincia'),
(52, '02', '20', '00', 'YUNGAY', 'Provincia'),
(53, '03', '01', '00', 'ABANCAY', 'Provincia'),
(54, '03', '02', '00', 'ANDAHUAYLAS', 'Provincia'),
(55, '03', '03', '00', 'ANTABAMBA', 'Provincia'),
(56, '03', '04', '00', 'AYMARAES', 'Provincia'),
(57, '03', '05', '00', 'COTABAMBAS', 'Provincia'),
(58, '03', '06', '00', 'CHINCHEROS', 'Provincia'),
(59, '03', '07', '00', 'GRAU', 'Provincia'),
(60, '04', '01', '00', 'AREQUIPA', 'Provincia'),
(61, '04', '02', '00', 'CAMANA', 'Provincia'),
(62, '04', '03', '00', 'CARAVELI', 'Provincia'),
(63, '04', '04', '00', 'CASTILLA', 'Provincia'),
(64, '04', '05', '00', 'CAYLLOMA', 'Provincia'),
(65, '04', '06', '00', 'CONDESUYOS', 'Provincia'),
(66, '04', '07', '00', 'ISLAY', 'Provincia'),
(67, '04', '08', '00', 'LA UNION', 'Provincia'),
(68, '05', '01', '00', 'HUAMANGA', 'Provincia'),
(69, '05', '02', '00', 'CANGALLO', 'Provincia'),
(70, '05', '03', '00', 'HUANCA SANCOS', 'Provincia'),
(71, '05', '04', '00', 'HUANTA', 'Provincia'),
(72, '05', '05', '00', 'LA MAR', 'Provincia'),
(73, '05', '06', '00', 'LUCANAS', 'Provincia'),
(74, '05', '07', '00', 'PARINACOCHAS', 'Provincia'),
(75, '05', '08', '00', 'PAUCAR DEL SARA SARA', 'Provincia'),
(76, '05', '09', '00', 'SUCRE', 'Provincia'),
(77, '05', '10', '00', 'VICTOR FAJARDO', 'Provincia'),
(78, '05', '11', '00', 'VILCAS HUAMAN', 'Provincia'),
(79, '06', '01', '00', 'CAJAMARCA', 'Provincia'),
(80, '06', '02', '00', 'CAJABAMBA', 'Provincia'),
(81, '06', '03', '00', 'CELENDIN', 'Provincia'),
(82, '06', '04', '00', 'CHOTA', 'Provincia'),
(83, '06', '05', '00', 'CONTUMAZA', 'Provincia'),
(84, '06', '06', '00', 'CUTERVO', 'Provincia'),
(85, '06', '07', '00', 'HUALGAYOC', 'Provincia'),
(86, '06', '08', '00', 'JAEN', 'Provincia'),
(87, '06', '09', '00', 'SAN IGNACIO', 'Provincia'),
(88, '06', '10', '00', 'SAN MARCOS', 'Provincia'),
(89, '06', '11', '00', 'SAN MIGUEL', 'Provincia'),
(90, '06', '12', '00', 'SAN PABLO', 'Provincia'),
(91, '06', '13', '00', 'SANTA CRUZ', 'Provincia'),
(92, '07', '01', '00', 'PROV. CONST. DEL CALLAO', 'Provincia'),
(93, '08', '01', '00', 'CUSCO', 'Provincia'),
(94, '08', '02', '00', 'ACOMAYO', 'Provincia'),
(95, '08', '03', '00', 'ANTA', 'Provincia'),
(96, '08', '04', '00', 'CALCA', 'Provincia'),
(97, '08', '05', '00', 'CANAS', 'Provincia'),
(98, '08', '06', '00', 'CANCHIS', 'Provincia'),
(99, '08', '07', '00', 'CHUMBIVILCAS', 'Provincia'),
(100, '08', '08', '00', 'ESPINAR', 'Provincia'),
(101, '08', '09', '00', 'LA CONVENCION', 'Provincia'),
(102, '08', '10', '00', 'PARURO', 'Provincia'),
(103, '08', '11', '00', 'PAUCARTAMBO', 'Provincia'),
(104, '08', '12', '00', 'QUISPICANCHI', 'Provincia'),
(105, '08', '13', '00', 'URUBAMBA', 'Provincia'),
(106, '09', '01', '00', 'HUANCAVELICA', 'Provincia'),
(107, '09', '02', '00', 'ACOBAMBA', 'Provincia'),
(108, '09', '03', '00', 'ANGARAES', 'Provincia'),
(109, '09', '04', '00', 'CASTROVIRREYNA', 'Provincia'),
(110, '09', '05', '00', 'CHURCAMPA', 'Provincia'),
(111, '09', '06', '00', 'HUAYTARA', 'Provincia'),
(112, '09', '07', '00', 'TAYACAJA', 'Provincia'),
(113, '10', '01', '00', 'HUANUCO', 'Provincia'),
(114, '10', '02', '00', 'AMBO', 'Provincia'),
(115, '10', '03', '00', 'DOS DE MAYO', 'Provincia'),
(116, '10', '04', '00', 'HUACAYBAMBA', 'Provincia'),
(117, '10', '05', '00', 'HUAMALIES', 'Provincia'),
(118, '10', '06', '00', 'LEONCIO PRADO', 'Provincia'),
(119, '10', '07', '00', 'MARAÃ‘ON', 'Provincia'),
(120, '10', '08', '00', 'PACHITEA', 'Provincia'),
(121, '10', '09', '00', 'PUERTO INCA', 'Provincia'),
(122, '10', '10', '00', 'LAURICOCHA', 'Provincia'),
(123, '10', '11', '00', 'YAROWILCA', 'Provincia'),
(124, '11', '01', '00', 'ICA', 'Provincia'),
(125, '11', '02', '00', 'CHINCHA', 'Provincia'),
(126, '11', '03', '00', 'NAZCA', 'Provincia'),
(127, '11', '04', '00', 'PALPA', 'Provincia'),
(128, '11', '05', '00', 'PISCO', 'Provincia'),
(129, '12', '01', '00', 'HUANCAYO', 'Provincia'),
(130, '12', '02', '00', 'CONCEPCION', 'Provincia'),
(131, '12', '03', '00', 'CHANCHAMAYO', 'Provincia'),
(132, '12', '04', '00', 'JAUJA', 'Provincia'),
(133, '12', '05', '00', 'JUNIN', 'Provincia'),
(134, '12', '06', '00', 'SATIPO', 'Provincia'),
(135, '12', '07', '00', 'TARMA', 'Provincia'),
(136, '12', '08', '00', 'YAULI', 'Provincia'),
(137, '12', '09', '00', 'CHUPACA', 'Provincia'),
(138, '13', '01', '00', 'TRUJILLO', 'Provincia'),
(139, '13', '02', '00', 'ASCOPE', 'Provincia'),
(140, '13', '03', '00', 'BOLIVAR', 'Provincia'),
(141, '13', '04', '00', 'CHEPEN', 'Provincia'),
(142, '13', '05', '00', 'JULCAN', 'Provincia'),
(143, '13', '06', '00', 'OTUZCO', 'Provincia'),
(144, '13', '07', '00', 'PACASMAYO', 'Provincia'),
(145, '13', '08', '00', 'PATAZ', 'Provincia'),
(146, '13', '09', '00', 'SANCHEZ CARRION', 'Provincia'),
(147, '13', '10', '00', 'SANTIAGO DE CHUCO', 'Provincia'),
(148, '13', '11', '00', 'GRAN CHIMU', 'Provincia'),
(149, '13', '12', '00', 'VIRU', 'Provincia'),
(150, '14', '01', '00', 'CHICLAYO', 'Provincia'),
(151, '14', '02', '00', 'FERREÃ‘AFE', 'Provincia'),
(152, '14', '03', '00', 'LAMBAYEQUE', 'Provincia'),
(153, '15', '01', '00', 'LIMA', 'Provincia'),
(154, '15', '02', '00', 'BARRANCA', 'Provincia'),
(155, '15', '03', '00', 'CAJATAMBO', 'Provincia'),
(156, '15', '04', '00', 'CANTA', 'Provincia'),
(157, '15', '05', '00', 'CAÃ‘ETE', 'Provincia'),
(158, '15', '06', '00', 'HUARAL', 'Provincia'),
(159, '15', '07', '00', 'HUAROCHIRI', 'Provincia'),
(160, '15', '08', '00', 'HUAURA', 'Provincia'),
(161, '15', '09', '00', 'OYON', 'Provincia'),
(162, '15', '10', '00', 'YAUYOS', 'Provincia'),
(163, '16', '01', '00', 'MAYNAS', 'Provincia'),
(164, '16', '02', '00', 'ALTO AMAZONAS', 'Provincia'),
(165, '16', '03', '00', 'LORETO', 'Provincia'),
(166, '16', '04', '00', 'MARISCAL RAMON CASTILLA', 'Provincia'),
(167, '16', '05', '00', 'REQUENA', 'Provincia'),
(168, '16', '06', '00', 'UCAYALI', 'Provincia'),
(169, '16', '07', '00', 'DATEM DEL MARAÃ‘ON', 'Provincia'),
(170, '17', '01', '00', 'TAMBOPATA', 'Provincia'),
(171, '17', '02', '00', 'MANU', 'Provincia'),
(172, '17', '03', '00', 'TAHUAMANU', 'Provincia'),
(173, '18', '01', '00', 'MARISCAL NIETO', 'Provincia'),
(174, '18', '02', '00', 'GENERAL SANCHEZ CERRO', 'Provincia'),
(175, '18', '03', '00', 'ILO', 'Provincia'),
(176, '19', '01', '00', 'PASCO', 'Provincia'),
(177, '19', '02', '00', 'DANIEL ALCIDES CARRION', 'Provincia'),
(178, '19', '03', '00', 'OXAPAMPA', 'Provincia'),
(179, '20', '01', '00', 'PIURA', 'Provincia'),
(180, '20', '02', '00', 'AYABACA', 'Provincia'),
(181, '20', '03', '00', 'HUANCABAMBA', 'Provincia'),
(182, '20', '04', '00', 'MORROPON', 'Provincia'),
(183, '20', '05', '00', 'PAITA', 'Provincia'),
(184, '20', '06', '00', 'SULLANA', 'Provincia'),
(185, '20', '07', '00', 'TALARA', 'Provincia'),
(186, '20', '08', '00', 'SECHURA', 'Provincia'),
(187, '21', '01', '00', 'PUNO', 'Provincia'),
(188, '21', '02', '00', 'AZANGARO', 'Provincia'),
(189, '21', '03', '00', 'CARABAYA', 'Provincia'),
(190, '21', '04', '00', 'CHUCUITO', 'Provincia'),
(191, '21', '05', '00', 'EL COLLAO', 'Provincia'),
(192, '21', '06', '00', 'HUANCANE', 'Provincia'),
(193, '21', '07', '00', 'LAMPA', 'Provincia'),
(194, '21', '08', '00', 'MELGAR', 'Provincia'),
(195, '21', '09', '00', 'MOHO', 'Provincia'),
(196, '21', '10', '00', 'SAN ANTONIO DE PUTINA', 'Provincia'),
(197, '21', '11', '00', 'SAN ROMAN', 'Provincia'),
(198, '21', '12', '00', 'SANDIA', 'Provincia'),
(199, '21', '13', '00', 'YUNGUYO', 'Provincia'),
(200, '22', '01', '00', 'MOYOBAMBA', 'Provincia'),
(201, '22', '02', '00', 'BELLAVISTA', 'Provincia'),
(202, '22', '03', '00', 'EL DORADO', 'Provincia'),
(203, '22', '04', '00', 'HUALLAGA', 'Provincia'),
(204, '22', '05', '00', 'LAMAS', 'Provincia'),
(205, '22', '06', '00', 'MARISCAL CACERES', 'Provincia'),
(206, '22', '07', '00', 'PICOTA', 'Provincia'),
(207, '22', '08', '00', 'RIOJA', 'Provincia'),
(208, '22', '09', '00', 'SAN MARTIN', 'Provincia'),
(209, '22', '10', '00', 'TOCACHE', 'Provincia'),
(210, '23', '01', '00', 'TACNA', 'Provincia'),
(211, '23', '02', '00', 'CANDARAVE', 'Provincia'),
(212, '23', '03', '00', 'JORGE BASADRE', 'Provincia'),
(213, '23', '04', '00', 'TARATA', 'Provincia'),
(214, '24', '01', '00', 'TUMBES', 'Provincia'),
(215, '24', '02', '00', 'CONTRALMIRANTE VILLAR', 'Provincia'),
(216, '24', '03', '00', 'ZARUMILLA', 'Provincia'),
(217, '25', '01', '00', 'CORONEL PORTILLO', 'Provincia'),
(218, '25', '02', '00', 'ATALAYA', 'Provincia'),
(219, '25', '03', '00', 'PADRE ABAD', 'Provincia'),
(220, '25', '04', '00', 'PURUS', 'Provincia'),
(221, '01', '01', '01', 'CHACHAPOYAS', 'Distrito'),
(222, '01', '01', '02', 'ASUNCION', 'Distrito'),
(223, '01', '01', '03', 'BALSAS', 'Distrito'),
(224, '01', '01', '04', 'CHETO', 'Distrito'),
(225, '01', '01', '05', 'CHILIQUIN', 'Distrito'),
(226, '01', '01', '06', 'CHUQUIBAMBA', 'Distrito'),
(227, '01', '01', '07', 'GRANADA', 'Distrito'),
(228, '01', '01', '08', 'HUANCAS', 'Distrito'),
(229, '01', '01', '09', 'LA JALCA', 'Distrito'),
(230, '01', '01', '10', 'LEIMEBAMBA', 'Distrito'),
(231, '01', '01', '11', 'LEVANTO', 'Distrito'),
(232, '01', '01', '12', 'MAGDALENA', 'Distrito'),
(233, '01', '01', '13', 'MARISCAL CASTILLA', 'Distrito'),
(234, '01', '01', '14', 'MOLINOPAMPA', 'Distrito'),
(235, '01', '01', '15', 'MONTEVIDEO', 'Distrito'),
(236, '01', '01', '16', 'OLLEROS', 'Distrito'),
(237, '01', '01', '17', 'QUINJALCA', 'Distrito'),
(238, '01', '01', '18', 'SAN FRANCISCO DE DAGUAS', 'Distrito'),
(239, '01', '01', '19', 'SAN ISIDRO DE MAINO', 'Distrito'),
(240, '01', '01', '20', 'SOLOCO', 'Distrito'),
(241, '01', '01', '21', 'SONCHE', 'Distrito'),
(242, '01', '02', '01', 'BAGUA', 'Distrito'),
(243, '01', '02', '02', 'ARAMANGO', 'Distrito'),
(244, '01', '02', '03', 'COPALLIN', 'Distrito'),
(245, '01', '02', '04', 'EL PARCO', 'Distrito'),
(246, '01', '02', '05', 'IMAZA', 'Distrito'),
(247, '01', '02', '06', 'LA PECA', 'Distrito'),
(248, '01', '03', '01', 'JUMBILLA', 'Distrito'),
(249, '01', '03', '02', 'CHISQUILLA', 'Distrito'),
(250, '01', '03', '03', 'CHURUJA', 'Distrito'),
(251, '01', '03', '04', 'COROSHA', 'Distrito'),
(252, '01', '03', '05', 'CUISPES', 'Distrito'),
(253, '01', '03', '06', 'FLORIDA', 'Distrito'),
(254, '01', '03', '07', 'JAZAN', 'Distrito'),
(255, '01', '03', '08', 'RECTA', 'Distrito'),
(256, '01', '03', '09', 'SAN CARLOS', 'Distrito'),
(257, '01', '03', '10', 'SHIPASBAMBA', 'Distrito'),
(258, '01', '03', '11', 'VALERA', 'Distrito'),
(259, '01', '03', '12', 'YAMBRASBAMBA', 'Distrito'),
(260, '01', '04', '01', 'NIEVA', 'Distrito'),
(261, '01', '04', '02', 'EL CENEPA', 'Distrito'),
(262, '01', '04', '03', 'RIO SANTIAGO', 'Distrito'),
(263, '01', '05', '01', 'LAMUD', 'Distrito'),
(264, '01', '05', '02', 'CAMPORREDONDO', 'Distrito'),
(265, '01', '05', '03', 'COCABAMBA', 'Distrito'),
(266, '01', '05', '04', 'COLCAMAR', 'Distrito'),
(267, '01', '05', '05', 'CONILA', 'Distrito'),
(268, '01', '05', '06', 'INGUILPATA', 'Distrito'),
(269, '01', '05', '07', 'LONGUITA', 'Distrito'),
(270, '01', '05', '08', 'LONYA CHICO', 'Distrito'),
(271, '01', '05', '09', 'LUYA', 'Distrito'),
(272, '01', '05', '10', 'LUYA VIEJO', 'Distrito'),
(273, '01', '05', '11', 'MARIA', 'Distrito'),
(274, '01', '05', '12', 'OCALLI', 'Distrito'),
(275, '01', '05', '13', 'OCUMAL', 'Distrito'),
(276, '01', '05', '14', 'PISUQUIA', 'Distrito'),
(277, '01', '05', '15', 'PROVIDENCIA', 'Distrito'),
(278, '01', '05', '16', 'SAN CRISTOBAL', 'Distrito'),
(279, '01', '05', '17', 'SAN FRANCISCO DEL YESO', 'Distrito'),
(280, '01', '05', '18', 'SAN JERONIMO', 'Distrito'),
(281, '01', '05', '19', 'SAN JUAN DE LOPECANCHA', 'Distrito'),
(282, '01', '05', '20', 'SANTA CATALINA', 'Distrito'),
(283, '01', '05', '21', 'SANTO TOMAS', 'Distrito'),
(284, '01', '05', '22', 'TINGO', 'Distrito'),
(285, '01', '05', '23', 'TRITA', 'Distrito'),
(286, '01', '06', '01', 'SAN NICOLAS', 'Distrito'),
(287, '01', '06', '02', 'CHIRIMOTO', 'Distrito'),
(288, '01', '06', '03', 'COCHAMAL', 'Distrito'),
(289, '01', '06', '04', 'HUAMBO', 'Distrito'),
(290, '01', '06', '05', 'LIMABAMBA', 'Distrito'),
(291, '01', '06', '06', 'LONGAR', 'Distrito'),
(292, '01', '06', '07', 'MARISCAL BENAVIDES', 'Distrito'),
(293, '01', '06', '08', 'MILPUC', 'Distrito'),
(294, '01', '06', '09', 'OMIA', 'Distrito'),
(295, '01', '06', '10', 'SANTA ROSA', 'Distrito'),
(296, '01', '06', '11', 'TOTORA', 'Distrito'),
(297, '01', '06', '12', 'VISTA ALEGRE', 'Distrito'),
(298, '01', '07', '01', 'BAGUA GRANDE', 'Distrito'),
(299, '01', '07', '02', 'CAJARURO', 'Distrito'),
(300, '01', '07', '03', 'CUMBA', 'Distrito'),
(301, '01', '07', '04', 'EL MILAGRO', 'Distrito'),
(302, '01', '07', '05', 'JAMALCA', 'Distrito'),
(303, '01', '07', '06', 'LONYA GRANDE', 'Distrito'),
(304, '01', '07', '07', 'YAMON', 'Distrito'),
(305, '02', '01', '01', 'HUARAZ', 'Distrito'),
(306, '02', '01', '02', 'COCHABAMBA', 'Distrito'),
(307, '02', '01', '03', 'COLCABAMBA', 'Distrito'),
(308, '02', '01', '04', 'HUANCHAY', 'Distrito'),
(309, '02', '01', '05', 'INDEPENDENCIA', 'Distrito'),
(310, '02', '01', '06', 'JANGAS', 'Distrito'),
(311, '02', '01', '07', 'LA LIBERTAD', 'Distrito'),
(312, '02', '01', '08', 'OLLEROS', 'Distrito'),
(313, '02', '01', '09', 'PAMPAS', 'Distrito'),
(314, '02', '01', '10', 'PARIACOTO', 'Distrito'),
(315, '02', '01', '11', 'PIRA', 'Distrito'),
(316, '02', '01', '12', 'TARICA', 'Distrito'),
(317, '02', '02', '01', 'AIJA', 'Distrito'),
(318, '02', '02', '02', 'CORIS', 'Distrito'),
(319, '02', '02', '03', 'HUACLLAN', 'Distrito'),
(320, '02', '02', '04', 'LA MERCED', 'Distrito'),
(321, '02', '02', '05', 'SUCCHA', 'Distrito'),
(322, '02', '03', '01', 'LLAMELLIN', 'Distrito'),
(323, '02', '03', '02', 'ACZO', 'Distrito'),
(324, '02', '03', '03', 'CHACCHO', 'Distrito'),
(325, '02', '03', '04', 'CHINGAS', 'Distrito'),
(326, '02', '03', '05', 'MIRGAS', 'Distrito'),
(327, '02', '03', '06', 'SAN JUAN DE RONTOY', 'Distrito'),
(328, '02', '04', '01', 'CHACAS', 'Distrito'),
(329, '02', '04', '02', 'ACOCHACA', 'Distrito'),
(330, '02', '05', '01', 'CHIQUIAN', 'Distrito'),
(331, '02', '05', '02', 'ABELARDO PARDO LEZAMETA', 'Distrito'),
(332, '02', '05', '03', 'ANTONIO RAYMONDI', 'Distrito'),
(333, '02', '05', '04', 'AQUIA', 'Distrito'),
(334, '02', '05', '05', 'CAJACAY', 'Distrito'),
(335, '02', '05', '06', 'CANIS', 'Distrito'),
(336, '02', '05', '07', 'COLQUIOC', 'Distrito'),
(337, '02', '05', '08', 'HUALLANCA', 'Distrito'),
(338, '02', '05', '09', 'HUASTA', 'Distrito'),
(339, '02', '05', '10', 'HUAYLLACAYAN', 'Distrito'),
(340, '02', '05', '11', 'LA PRIMAVERA', 'Distrito'),
(341, '02', '05', '12', 'MANGAS', 'Distrito'),
(342, '02', '05', '13', 'PACLLON', 'Distrito'),
(343, '02', '05', '14', 'SAN MIGUEL DE CORPANQUI', 'Distrito'),
(344, '02', '05', '15', 'TICLLOS', 'Distrito'),
(345, '02', '06', '01', 'CARHUAZ', 'Distrito'),
(346, '02', '06', '02', 'ACOPAMPA', 'Distrito'),
(347, '02', '06', '03', 'AMASHCA', 'Distrito'),
(348, '02', '06', '04', 'ANTA', 'Distrito'),
(349, '02', '06', '05', 'ATAQUERO', 'Distrito'),
(350, '02', '06', '06', 'MARCARA', 'Distrito'),
(351, '02', '06', '07', 'PARIAHUANCA', 'Distrito'),
(352, '02', '06', '08', 'SAN MIGUEL DE ACO', 'Distrito'),
(353, '02', '06', '09', 'SHILLA', 'Distrito'),
(354, '02', '06', '10', 'TINCO', 'Distrito'),
(355, '02', '06', '11', 'YUNGAR', 'Distrito'),
(356, '02', '07', '01', 'SAN LUIS', 'Distrito'),
(357, '02', '07', '02', 'SAN NICOLAS', 'Distrito'),
(358, '02', '07', '03', 'YAUYA', 'Distrito'),
(359, '02', '08', '01', 'CASMA', 'Distrito'),
(360, '02', '08', '02', 'BUENA VISTA ALTA', 'Distrito'),
(361, '02', '08', '03', 'COMANDANTE NOEL', 'Distrito'),
(362, '02', '08', '04', 'YAUTAN', 'Distrito'),
(363, '02', '09', '01', 'CORONGO', 'Distrito'),
(364, '02', '09', '02', 'ACO', 'Distrito'),
(365, '02', '09', '03', 'BAMBAS', 'Distrito'),
(366, '02', '09', '04', 'CUSCA', 'Distrito'),
(367, '02', '09', '05', 'LA PAMPA', 'Distrito'),
(368, '02', '09', '06', 'YANAC', 'Distrito'),
(369, '02', '09', '07', 'YUPAN', 'Distrito'),
(370, '02', '10', '01', 'HUARI', 'Distrito'),
(371, '02', '10', '02', 'ANRA', 'Distrito'),
(372, '02', '10', '03', 'CAJAY', 'Distrito'),
(373, '02', '10', '04', 'CHAVIN DE HUANTAR', 'Distrito'),
(374, '02', '10', '05', 'HUACACHI', 'Distrito'),
(375, '02', '10', '06', 'HUACCHIS', 'Distrito'),
(376, '02', '10', '07', 'HUACHIS', 'Distrito'),
(377, '02', '10', '08', 'HUANTAR', 'Distrito'),
(378, '02', '10', '09', 'MASIN', 'Distrito'),
(379, '02', '10', '10', 'PAUCAS', 'Distrito'),
(380, '02', '10', '11', 'PONTO', 'Distrito'),
(381, '02', '10', '12', 'RAHUAPAMPA', 'Distrito'),
(382, '02', '10', '13', 'RAPAYAN', 'Distrito'),
(383, '02', '10', '14', 'SAN MARCOS', 'Distrito'),
(384, '02', '10', '15', 'SAN PEDRO DE CHANA', 'Distrito'),
(385, '02', '10', '16', 'UCO', 'Distrito'),
(386, '02', '11', '01', 'HUARMEY', 'Distrito'),
(387, '02', '11', '02', 'COCHAPETI', 'Distrito'),
(388, '02', '11', '03', 'CULEBRAS', 'Distrito'),
(389, '02', '11', '04', 'HUAYAN', 'Distrito'),
(390, '02', '11', '05', 'MALVAS', 'Distrito'),
(391, '02', '12', '01', 'CARAZ', 'Distrito'),
(392, '02', '12', '02', 'HUALLANCA', 'Distrito'),
(393, '02', '12', '03', 'HUATA', 'Distrito'),
(394, '02', '12', '04', 'HUAYLAS', 'Distrito'),
(395, '02', '12', '05', 'MATO', 'Distrito'),
(396, '02', '12', '06', 'PAMPAROMAS', 'Distrito'),
(397, '02', '12', '07', 'PUEBLO LIBRE  / 1 ', 'Distrito'),
(398, '02', '12', '08', 'SANTA CRUZ', 'Distrito'),
(399, '02', '12', '09', 'SANTO TORIBIO', 'Distrito'),
(400, '02', '12', '10', 'YURACMARCA', 'Distrito'),
(401, '02', '13', '01', 'PISCOBAMBA', 'Distrito'),
(402, '02', '13', '02', 'CASCA', 'Distrito'),
(403, '02', '13', '03', 'ELEAZAR GUZMAN BARRON', 'Distrito'),
(404, '02', '13', '04', 'FIDEL OLIVAS ESCUDERO', 'Distrito'),
(405, '02', '13', '05', 'LLAMA', 'Distrito'),
(406, '02', '13', '06', 'LLUMPA', 'Distrito'),
(407, '02', '13', '07', 'LUCMA', 'Distrito'),
(408, '02', '13', '08', 'MUSGA', 'Distrito'),
(409, '02', '14', '01', 'OCROS', 'Distrito'),
(410, '02', '14', '02', 'ACAS', 'Distrito'),
(411, '02', '14', '03', 'CAJAMARQUILLA', 'Distrito'),
(412, '02', '14', '04', 'CARHUAPAMPA', 'Distrito'),
(413, '02', '14', '05', 'COCHAS', 'Distrito'),
(414, '02', '14', '06', 'CONGAS', 'Distrito'),
(415, '02', '14', '07', 'LLIPA', 'Distrito'),
(416, '02', '14', '08', 'SAN CRISTOBAL DE RAJAN', 'Distrito'),
(417, '02', '14', '09', 'SAN PEDRO', 'Distrito'),
(418, '02', '14', '10', 'SANTIAGO DE CHILCAS', 'Distrito'),
(419, '02', '15', '01', 'CABANA', 'Distrito'),
(420, '02', '15', '02', 'BOLOGNESI', 'Distrito'),
(421, '02', '15', '03', 'CONCHUCOS', 'Distrito'),
(422, '02', '15', '04', 'HUACASCHUQUE', 'Distrito'),
(423, '02', '15', '05', 'HUANDOVAL', 'Distrito'),
(424, '02', '15', '06', 'LACABAMBA', 'Distrito'),
(425, '02', '15', '07', 'LLAPO', 'Distrito'),
(426, '02', '15', '08', 'PALLASCA', 'Distrito'),
(427, '02', '15', '09', 'PAMPAS', 'Distrito'),
(428, '02', '15', '10', 'SANTA ROSA', 'Distrito'),
(429, '02', '15', '11', 'TAUCA', 'Distrito'),
(430, '02', '16', '01', 'POMABAMBA', 'Distrito'),
(431, '02', '16', '02', 'HUAYLLAN', 'Distrito'),
(432, '02', '16', '03', 'PAROBAMBA', 'Distrito'),
(433, '02', '16', '04', 'QUINUABAMBA', 'Distrito'),
(434, '02', '17', '01', 'RECUAY', 'Distrito'),
(435, '02', '17', '02', 'CATAC', 'Distrito'),
(436, '02', '17', '03', 'COTAPARACO', 'Distrito'),
(437, '02', '17', '04', 'HUAYLLAPAMPA', 'Distrito'),
(438, '02', '17', '05', 'LLACLLIN', 'Distrito'),
(439, '02', '17', '06', 'MARCA', 'Distrito'),
(440, '02', '17', '07', 'PAMPAS CHICO', 'Distrito'),
(441, '02', '17', '08', 'PARARIN', 'Distrito'),
(442, '02', '17', '09', 'TAPACOCHA', 'Distrito'),
(443, '02', '17', '10', 'TICAPAMPA', 'Distrito'),
(444, '02', '18', '01', 'CHIMBOTE', 'Distrito'),
(445, '02', '18', '02', 'CACERES DEL PERU', 'Distrito'),
(446, '02', '18', '03', 'COISHCO', 'Distrito'),
(447, '02', '18', '04', 'MACATE', 'Distrito'),
(448, '02', '18', '05', 'MORO', 'Distrito'),
(449, '02', '18', '06', 'NEPEÃ‘A', 'Distrito'),
(450, '02', '18', '07', 'SAMANCO', 'Distrito'),
(451, '02', '18', '08', 'SANTA', 'Distrito'),
(452, '02', '18', '09', 'NUEVO CHIMBOTE', 'Distrito'),
(453, '02', '19', '01', 'SIHUAS', 'Distrito'),
(454, '02', '19', '02', 'ACOBAMBA', 'Distrito'),
(455, '02', '19', '03', 'ALFONSO UGARTE', 'Distrito'),
(456, '02', '19', '04', 'CASHAPAMPA', 'Distrito'),
(457, '02', '19', '05', 'CHINGALPO', 'Distrito'),
(458, '02', '19', '06', 'HUAYLLABAMBA', 'Distrito'),
(459, '02', '19', '07', 'QUICHES', 'Distrito'),
(460, '02', '19', '08', 'RAGASH', 'Distrito'),
(461, '02', '19', '09', 'SAN JUAN', 'Distrito'),
(462, '02', '19', '10', 'SICSIBAMBA', 'Distrito'),
(463, '02', '20', '01', 'YUNGAY', 'Distrito'),
(464, '02', '20', '02', 'CASCAPARA', 'Distrito'),
(465, '02', '20', '03', 'MANCOS', 'Distrito'),
(466, '02', '20', '04', 'MATACOTO', 'Distrito'),
(467, '02', '20', '05', 'QUILLO', 'Distrito'),
(468, '02', '20', '06', 'RANRAHIRCA', 'Distrito'),
(469, '02', '20', '07', 'SHUPLUY', 'Distrito'),
(470, '02', '20', '08', 'YANAMA', 'Distrito'),
(471, '03', '01', '01', 'ABANCAY', 'Distrito'),
(472, '03', '01', '02', 'CHACOCHE', 'Distrito'),
(473, '03', '01', '03', 'CIRCA', 'Distrito'),
(474, '03', '01', '04', 'CURAHUASI', 'Distrito'),
(475, '03', '01', '05', 'HUANIPACA', 'Distrito'),
(476, '03', '01', '06', 'LAMBRAMA', 'Distrito'),
(477, '03', '01', '07', 'PICHIRHUA', 'Distrito'),
(478, '03', '01', '08', 'SAN PEDRO DE CACHORA', 'Distrito'),
(479, '03', '01', '09', 'TAMBURCO', 'Distrito'),
(480, '03', '02', '01', 'ANDAHUAYLAS', 'Distrito'),
(481, '03', '02', '02', 'ANDARAPA', 'Distrito'),
(482, '03', '02', '03', 'CHIARA', 'Distrito'),
(483, '03', '02', '04', 'HUANCARAMA', 'Distrito'),
(484, '03', '02', '05', 'HUANCARAY', 'Distrito'),
(485, '03', '02', '06', 'HUAYANA', 'Distrito'),
(486, '03', '02', '07', 'KISHUARA', 'Distrito'),
(487, '03', '02', '08', 'PACOBAMBA', 'Distrito'),
(488, '03', '02', '09', 'PACUCHA', 'Distrito'),
(489, '03', '02', '10', 'PAMPACHIRI', 'Distrito'),
(490, '03', '02', '11', 'POMACOCHA', 'Distrito'),
(491, '03', '02', '12', 'SAN ANTONIO DE CACHI', 'Distrito'),
(492, '03', '02', '13', 'SAN JERONIMO', 'Distrito'),
(493, '03', '02', '14', 'SAN MIGUEL DE CHACCRAMPA', 'Distrito'),
(494, '03', '02', '15', 'SANTA MARIA DE CHICMO', 'Distrito'),
(495, '03', '02', '16', 'TALAVERA', 'Distrito'),
(496, '03', '02', '17', 'TUMAY HUARACA', 'Distrito'),
(497, '03', '02', '18', 'TURPO', 'Distrito'),
(498, '03', '02', '19', 'KAQUIABAMBA', 'Distrito'),
(499, '03', '03', '01', 'ANTABAMBA', 'Distrito'),
(500, '03', '03', '02', 'EL ORO', 'Distrito'),
(501, '03', '03', '03', 'HUAQUIRCA', 'Distrito'),
(502, '03', '03', '04', 'JUAN ESPINOZA MEDRANO', 'Distrito'),
(503, '03', '03', '05', 'OROPESA', 'Distrito'),
(504, '03', '03', '06', 'PACHACONAS', 'Distrito'),
(505, '03', '03', '07', 'SABAINO', 'Distrito'),
(506, '03', '04', '01', 'CHALHUANCA', 'Distrito'),
(507, '03', '04', '02', 'CAPAYA', 'Distrito'),
(508, '03', '04', '03', 'CARAYBAMBA', 'Distrito'),
(509, '03', '04', '04', 'CHAPIMARCA', 'Distrito'),
(510, '03', '04', '05', 'COLCABAMBA', 'Distrito'),
(511, '03', '04', '06', 'COTARUSE', 'Distrito'),
(512, '03', '04', '07', 'HUAYLLO', 'Distrito'),
(513, '03', '04', '08', 'JUSTO APU SAHUARAURA', 'Distrito'),
(514, '03', '04', '09', 'LUCRE', 'Distrito'),
(515, '03', '04', '10', 'POCOHUANCA', 'Distrito'),
(516, '03', '04', '11', 'SAN JUAN DE CHACÃ‘A', 'Distrito'),
(517, '03', '04', '12', 'SAÃ‘AYCA', 'Distrito'),
(518, '03', '04', '13', 'SORAYA', 'Distrito'),
(519, '03', '04', '14', 'TAPAIRIHUA', 'Distrito'),
(520, '03', '04', '15', 'TINTAY', 'Distrito'),
(521, '03', '04', '16', 'TORAYA', 'Distrito'),
(522, '03', '04', '17', 'YANACA', 'Distrito'),
(523, '03', '05', '01', 'TAMBOBAMBA', 'Distrito'),
(524, '03', '05', '02', 'COTABAMBAS', 'Distrito'),
(525, '03', '05', '03', 'COYLLURQUI', 'Distrito'),
(526, '03', '05', '04', 'HAQUIRA', 'Distrito'),
(527, '03', '05', '05', 'MARA', 'Distrito'),
(528, '03', '05', '06', 'CHALLHUAHUACHO', 'Distrito'),
(529, '03', '06', '01', 'CHINCHEROS', 'Distrito'),
(530, '03', '06', '02', 'ANCO-HUALLO', 'Distrito'),
(531, '03', '06', '03', 'COCHARCAS', 'Distrito'),
(532, '03', '06', '04', 'HUACCANA', 'Distrito'),
(533, '03', '06', '05', 'OCOBAMBA', 'Distrito'),
(534, '03', '06', '06', 'ONGOY', 'Distrito'),
(535, '03', '06', '07', 'URANMARCA', 'Distrito'),
(536, '03', '06', '08', 'RANRACANCHA', 'Distrito'),
(537, '03', '07', '01', 'CHUQUIBAMBILLA', 'Distrito'),
(538, '03', '07', '02', 'CURPAHUASI', 'Distrito'),
(539, '03', '07', '03', 'GAMARRA', 'Distrito'),
(540, '03', '07', '04', 'HUAYLLATI', 'Distrito'),
(541, '03', '07', '05', 'MAMARA', 'Distrito'),
(542, '03', '07', '06', 'MICAELA BASTIDAS', 'Distrito'),
(543, '03', '07', '07', 'PATAYPAMPA', 'Distrito'),
(544, '03', '07', '08', 'PROGRESO', 'Distrito'),
(545, '03', '07', '09', 'SAN ANTONIO', 'Distrito'),
(546, '03', '07', '10', 'SANTA ROSA', 'Distrito'),
(547, '03', '07', '11', 'TURPAY', 'Distrito'),
(548, '03', '07', '12', 'VILCABAMBA', 'Distrito'),
(549, '03', '07', '13', 'VIRUNDO', 'Distrito'),
(550, '03', '07', '14', 'CURASCO', 'Distrito'),
(551, '04', '01', '01', 'AREQUIPA', 'Distrito'),
(552, '04', '01', '02', 'ALTO SELVA ALEGRE', 'Distrito'),
(553, '04', '01', '03', 'CAYMA', 'Distrito'),
(554, '04', '01', '04', 'CERRO COLORADO', 'Distrito'),
(555, '04', '01', '05', 'CHARACATO', 'Distrito'),
(556, '04', '01', '06', 'CHIGUATA', 'Distrito'),
(557, '04', '01', '07', 'JACOBO HUNTER', 'Distrito'),
(558, '04', '01', '08', 'LA JOYA', 'Distrito'),
(559, '04', '01', '09', 'MARIANO MELGAR', 'Distrito'),
(560, '04', '01', '10', 'MIRAFLORES', 'Distrito'),
(561, '04', '01', '11', 'MOLLEBAYA', 'Distrito'),
(562, '04', '01', '12', 'PAUCARPATA', 'Distrito'),
(563, '04', '01', '13', 'POCSI', 'Distrito'),
(564, '04', '01', '14', 'POLOBAYA', 'Distrito'),
(565, '04', '01', '15', 'QUEQUEÃ‘A', 'Distrito'),
(566, '04', '01', '16', 'SABANDIA', 'Distrito'),
(567, '04', '01', '17', 'SACHACA', 'Distrito'),
(568, '04', '01', '18', 'SAN JUAN DE SIGUAS /1', 'Distrito'),
(569, '04', '01', '19', 'SAN JUAN DE TARUCANI', 'Distrito'),
(570, '04', '01', '20', 'SANTA ISABEL DE SIGUAS', 'Distrito'),
(571, '04', '01', '21', 'SANTA RITA DE SIGUAS', 'Distrito'),
(572, '04', '01', '22', 'SOCABAYA', 'Distrito'),
(573, '04', '01', '23', 'TIABAYA', 'Distrito'),
(574, '04', '01', '24', 'UCHUMAYO', 'Distrito'),
(575, '04', '01', '25', 'VITOR ', 'Distrito'),
(576, '04', '01', '26', 'YANAHUARA', 'Distrito'),
(577, '04', '01', '27', 'YARABAMBA', 'Distrito'),
(578, '04', '01', '28', 'YURA', 'Distrito'),
(579, '04', '01', '29', 'JOSE LUIS BUSTAMANTE Y RIVERO', 'Distrito'),
(580, '04', '02', '01', 'CAMANA', 'Distrito'),
(581, '04', '02', '02', 'JOSE MARIA QUIMPER', 'Distrito'),
(582, '04', '02', '03', 'MARIANO NICOLAS VALCARCEL', 'Distrito'),
(583, '04', '02', '04', 'MARISCAL CACERES', 'Distrito'),
(584, '04', '02', '05', 'NICOLAS DE PIEROLA', 'Distrito'),
(585, '04', '02', '06', 'OCOÃ‘A', 'Distrito'),
(586, '04', '02', '07', 'QUILCA', 'Distrito'),
(587, '04', '02', '08', 'SAMUEL PASTOR', 'Distrito'),
(588, '04', '03', '01', 'CARAVELI', 'Distrito'),
(589, '04', '03', '02', 'ACARI', 'Distrito'),
(590, '04', '03', '03', 'ATICO', 'Distrito'),
(591, '04', '03', '04', 'ATIQUIPA', 'Distrito'),
(592, '04', '03', '05', 'BELLA UNION', 'Distrito'),
(593, '04', '03', '06', 'CAHUACHO', 'Distrito'),
(594, '04', '03', '07', 'CHALA', 'Distrito'),
(595, '04', '03', '08', 'CHAPARRA', 'Distrito'),
(596, '04', '03', '09', 'HUANUHUANU', 'Distrito'),
(597, '04', '03', '10', 'JAQUI', 'Distrito'),
(598, '04', '03', '11', 'LOMAS', 'Distrito'),
(599, '04', '03', '12', 'QUICACHA', 'Distrito'),
(600, '04', '03', '13', 'YAUCA', 'Distrito'),
(601, '04', '04', '01', 'APLAO', 'Distrito'),
(602, '04', '04', '02', 'ANDAGUA', 'Distrito'),
(603, '04', '04', '03', 'AYO', 'Distrito'),
(604, '04', '04', '04', 'CHACHAS', 'Distrito'),
(605, '04', '04', '05', 'CHILCAYMARCA', 'Distrito'),
(606, '04', '04', '06', 'CHOCO', 'Distrito'),
(607, '04', '04', '07', 'HUANCARQUI', 'Distrito'),
(608, '04', '04', '08', 'MACHAGUAY', 'Distrito'),
(609, '04', '04', '09', 'ORCOPAMPA', 'Distrito'),
(610, '04', '04', '10', 'PAMPACOLCA', 'Distrito'),
(611, '04', '04', '11', 'TIPAN', 'Distrito'),
(612, '04', '04', '12', 'UÃ‘ON', 'Distrito'),
(613, '04', '04', '13', 'URACA', 'Distrito'),
(614, '04', '04', '14', 'VIRACO', 'Distrito'),
(615, '04', '05', '01', 'CHIVAY', 'Distrito'),
(616, '04', '05', '02', 'ACHOMA', 'Distrito'),
(617, '04', '05', '03', 'CABANACONDE', 'Distrito'),
(618, '04', '05', '04', 'CALLALLI', 'Distrito'),
(619, '04', '05', '05', 'CAYLLOMA', 'Distrito'),
(620, '04', '05', '06', 'COPORAQUE', 'Distrito'),
(621, '04', '05', '07', 'HUAMBO', 'Distrito'),
(622, '04', '05', '08', 'HUANCA', 'Distrito'),
(623, '04', '05', '09', 'ICHUPAMPA', 'Distrito'),
(624, '04', '05', '10', 'LARI', 'Distrito'),
(625, '04', '05', '11', 'LLUTA', 'Distrito'),
(626, '04', '05', '12', 'MACA', 'Distrito'),
(627, '04', '05', '13', 'MADRIGAL', 'Distrito'),
(628, '04', '05', '14', 'SAN ANTONIO DE CHUCA  2/', 'Distrito'),
(629, '04', '05', '15', 'SIBAYO', 'Distrito'),
(630, '04', '05', '16', 'TAPAY', 'Distrito'),
(631, '04', '05', '17', 'TISCO', 'Distrito'),
(632, '04', '05', '18', 'TUTI', 'Distrito'),
(633, '04', '05', '19', 'YANQUE', 'Distrito'),
(634, '04', '05', '20', 'MAJES', 'Distrito'),
(635, '04', '06', '01', 'CHUQUIBAMBA', 'Distrito'),
(636, '04', '06', '02', 'ANDARAY', 'Distrito'),
(637, '04', '06', '03', 'CAYARANI', 'Distrito'),
(638, '04', '06', '04', 'CHICHAS', 'Distrito'),
(639, '04', '06', '05', 'IRAY', 'Distrito'),
(640, '04', '06', '06', 'RIO GRANDE', 'Distrito'),
(641, '04', '06', '07', 'SALAMANCA', 'Distrito'),
(642, '04', '06', '08', 'YANAQUIHUA', 'Distrito'),
(643, '04', '07', '01', 'MOLLENDO', 'Distrito'),
(644, '04', '07', '02', 'COCACHACRA', 'Distrito'),
(645, '04', '07', '03', 'DEAN VALDIVIA', 'Distrito'),
(646, '04', '07', '04', 'ISLAY', 'Distrito'),
(647, '04', '07', '05', 'MEJIA', 'Distrito'),
(648, '04', '07', '06', 'PUNTA DE BOMBON', 'Distrito'),
(649, '04', '08', '01', 'COTAHUASI', 'Distrito'),
(650, '04', '08', '02', 'ALCA', 'Distrito'),
(651, '04', '08', '03', 'CHARCANA', 'Distrito'),
(652, '04', '08', '04', 'HUAYNACOTAS', 'Distrito'),
(653, '04', '08', '05', 'PAMPAMARCA', 'Distrito'),
(654, '04', '08', '06', 'PUYCA', 'Distrito'),
(655, '04', '08', '07', 'QUECHUALLA', 'Distrito'),
(656, '04', '08', '08', 'SAYLA', 'Distrito'),
(657, '04', '08', '09', 'TAURIA', 'Distrito'),
(658, '04', '08', '10', 'TOMEPAMPA', 'Distrito'),
(659, '04', '08', '11', 'TORO', 'Distrito'),
(660, '05', '01', '01', 'AYACUCHO', 'Distrito'),
(661, '05', '01', '02', 'ACOCRO', 'Distrito'),
(662, '05', '01', '03', 'ACOS VINCHOS', 'Distrito'),
(663, '05', '01', '04', 'CARMEN ALTO', 'Distrito'),
(664, '05', '01', '05', 'CHIARA', 'Distrito'),
(665, '05', '01', '06', 'OCROS', 'Distrito'),
(666, '05', '01', '07', 'PACAYCASA', 'Distrito'),
(667, '05', '01', '08', 'QUINUA', 'Distrito'),
(668, '05', '01', '09', 'SAN JOSE DE TICLLAS', 'Distrito'),
(669, '05', '01', '10', 'SAN JUAN BAUTISTA', 'Distrito'),
(670, '05', '01', '11', 'SANTIAGO DE PISCHA', 'Distrito'),
(671, '05', '01', '12', 'SOCOS', 'Distrito'),
(672, '05', '01', '13', 'TAMBILLO', 'Distrito'),
(673, '05', '01', '14', 'VINCHOS', 'Distrito'),
(674, '05', '01', '15', 'JESUS NAZARENO', 'Distrito'),
(675, '05', '02', '01', 'CANGALLO', 'Distrito'),
(676, '05', '02', '02', 'CHUSCHI', 'Distrito'),
(677, '05', '02', '03', 'LOS MOROCHUCOS', 'Distrito'),
(678, '05', '02', '04', 'MARIA PARADO DE BELLIDO', 'Distrito'),
(679, '05', '02', '05', 'PARAS', 'Distrito'),
(680, '05', '02', '06', 'TOTOS', 'Distrito'),
(681, '05', '03', '01', 'SANCOS', 'Distrito'),
(682, '05', '03', '02', 'CARAPO', 'Distrito'),
(683, '05', '03', '03', 'SACSAMARCA', 'Distrito'),
(684, '05', '03', '04', 'SANTIAGO DE LUCANAMARCA', 'Distrito'),
(685, '05', '04', '01', 'HUANTA', 'Distrito'),
(686, '05', '04', '02', 'AYAHUANCO', 'Distrito'),
(687, '05', '04', '03', 'HUAMANGUILLA', 'Distrito'),
(688, '05', '04', '04', 'IGUAIN', 'Distrito'),
(689, '05', '04', '05', 'LURICOCHA', 'Distrito'),
(690, '05', '04', '06', 'SANTILLANA', 'Distrito'),
(691, '05', '04', '07', 'SIVIA', 'Distrito'),
(692, '05', '04', '08', 'LLOCHEGUA', 'Distrito'),
(693, '05', '05', '01', 'SAN MIGUEL', 'Distrito'),
(694, '05', '05', '02', 'ANCO', 'Distrito'),
(695, '05', '05', '03', 'AYNA', 'Distrito'),
(696, '05', '05', '04', 'CHILCAS', 'Distrito'),
(697, '05', '05', '05', 'CHUNGUI', 'Distrito'),
(698, '05', '05', '06', 'LUIS CARRANZA', 'Distrito'),
(699, '05', '05', '07', 'SANTA ROSA', 'Distrito'),
(700, '05', '05', '08', 'TAMBO', 'Distrito'),
(701, '05', '06', '01', 'PUQUIO', 'Distrito'),
(702, '05', '06', '02', 'AUCARA', 'Distrito'),
(703, '05', '06', '03', 'CABANA', 'Distrito'),
(704, '05', '06', '04', 'CARMEN SALCEDO', 'Distrito'),
(705, '05', '06', '05', 'CHAVIÃ‘A', 'Distrito'),
(706, '05', '06', '06', 'CHIPAO', 'Distrito'),
(707, '05', '06', '07', 'HUAC-HUAS', 'Distrito'),
(708, '05', '06', '08', 'LARAMATE', 'Distrito'),
(709, '05', '06', '09', 'LEONCIO PRADO', 'Distrito'),
(710, '05', '06', '10', 'LLAUTA', 'Distrito'),
(711, '05', '06', '11', 'LUCANAS', 'Distrito'),
(712, '05', '06', '12', 'OCAÃ‘A', 'Distrito'),
(713, '05', '06', '13', 'OTOCA', 'Distrito'),
(714, '05', '06', '14', 'SAISA', 'Distrito'),
(715, '05', '06', '15', 'SAN CRISTOBAL', 'Distrito'),
(716, '05', '06', '16', 'SAN JUAN', 'Distrito'),
(717, '05', '06', '17', 'SAN PEDRO', 'Distrito'),
(718, '05', '06', '18', 'SAN PEDRO DE PALCO', 'Distrito'),
(719, '05', '06', '19', 'SANCOS', 'Distrito'),
(720, '05', '06', '20', 'SANTA ANA DE HUAYCAHUACHO', 'Distrito'),
(721, '05', '06', '21', 'SANTA LUCIA', 'Distrito'),
(722, '05', '07', '01', 'CORACORA', 'Distrito'),
(723, '05', '07', '02', 'CHUMPI', 'Distrito'),
(724, '05', '07', '03', 'CORONEL CASTAÃ‘EDA', 'Distrito'),
(725, '05', '07', '04', 'PACAPAUSA', 'Distrito'),
(726, '05', '07', '05', 'PULLO', 'Distrito'),
(727, '05', '07', '06', 'PUYUSCA', 'Distrito'),
(728, '05', '07', '07', 'SAN FRANCISCO DE RAVACAYCO', 'Distrito'),
(729, '05', '07', '08', 'UPAHUACHO', 'Distrito'),
(730, '05', '08', '01', 'PAUSA', 'Distrito'),
(731, '05', '08', '02', 'COLTA', 'Distrito'),
(732, '05', '08', '03', 'CORCULLA', 'Distrito'),
(733, '05', '08', '04', 'LAMPA', 'Distrito'),
(734, '05', '08', '05', 'MARCABAMBA', 'Distrito'),
(735, '05', '08', '06', 'OYOLO', 'Distrito'),
(736, '05', '08', '07', 'PARARCA', 'Distrito'),
(737, '05', '08', '08', 'SAN JAVIER DE ALPABAMBA', 'Distrito'),
(738, '05', '08', '09', 'SAN JOSE DE USHUA', 'Distrito'),
(739, '05', '08', '10', 'SARA SARA', 'Distrito'),
(740, '05', '09', '01', 'QUEROBAMBA', 'Distrito'),
(741, '05', '09', '02', 'BELEN', 'Distrito'),
(742, '05', '09', '03', 'CHALCOS', 'Distrito'),
(743, '05', '09', '04', 'CHILCAYOC', 'Distrito'),
(744, '05', '09', '05', 'HUACAÃ‘A', 'Distrito'),
(745, '05', '09', '06', 'MORCOLLA', 'Distrito'),
(746, '05', '09', '07', 'PAICO', 'Distrito'),
(747, '05', '09', '08', 'SAN PEDRO DE LARCAY', 'Distrito'),
(748, '05', '09', '09', 'SAN SALVADOR DE QUIJE', 'Distrito'),
(749, '05', '09', '10', 'SANTIAGO DE PAUCARAY', 'Distrito'),
(750, '05', '09', '11', 'SORAS', 'Distrito'),
(751, '05', '10', '01', 'HUANCAPI', 'Distrito'),
(752, '05', '10', '02', 'ALCAMENCA', 'Distrito'),
(753, '05', '10', '03', 'APONGO', 'Distrito'),
(754, '05', '10', '04', 'ASQUIPATA', 'Distrito'),
(755, '05', '10', '05', 'CANARIA', 'Distrito'),
(756, '05', '10', '06', 'CAYARA', 'Distrito'),
(757, '05', '10', '07', 'COLCA', 'Distrito'),
(758, '05', '10', '08', 'HUAMANQUIQUIA', 'Distrito'),
(759, '05', '10', '09', 'HUANCARAYLLA', 'Distrito'),
(760, '05', '10', '10', 'HUAYA', 'Distrito'),
(761, '05', '10', '11', 'SARHUA', 'Distrito'),
(762, '05', '10', '12', 'VILCANCHOS', 'Distrito'),
(763, '05', '11', '01', 'VILCAS HUAMAN', 'Distrito'),
(764, '05', '11', '02', 'ACCOMARCA', 'Distrito'),
(765, '05', '11', '03', 'CARHUANCA', 'Distrito'),
(766, '05', '11', '04', 'CONCEPCION', 'Distrito'),
(767, '05', '11', '05', 'HUAMBALPA', 'Distrito'),
(768, '05', '11', '06', 'INDEPENDENCIA /1', 'Distrito'),
(769, '05', '11', '07', 'SAURAMA', 'Distrito'),
(770, '05', '11', '08', 'VISCHONGO', 'Distrito'),
(771, '06', '01', '01', 'CAJAMARCA', 'Distrito'),
(772, '06', '01', '02', 'ASUNCION', 'Distrito'),
(773, '06', '01', '03', 'CHETILLA', 'Distrito'),
(774, '06', '01', '04', 'COSPAN', 'Distrito'),
(775, '06', '01', '05', 'ENCAÃ‘ADA', 'Distrito'),
(776, '06', '01', '06', 'JESUS', 'Distrito'),
(777, '06', '01', '07', 'LLACANORA', 'Distrito'),
(778, '06', '01', '08', 'LOS BAÃ‘OS DEL INCA', 'Distrito'),
(779, '06', '01', '09', 'MAGDALENA', 'Distrito'),
(780, '06', '01', '10', 'MATARA', 'Distrito'),
(781, '06', '01', '11', 'NAMORA', 'Distrito'),
(782, '06', '01', '12', 'SAN JUAN', 'Distrito'),
(783, '06', '02', '01', 'CAJABAMBA', 'Distrito'),
(784, '06', '02', '02', 'CACHACHI', 'Distrito'),
(785, '06', '02', '03', 'CONDEBAMBA', 'Distrito'),
(786, '06', '02', '04', 'SITACOCHA', 'Distrito'),
(787, '06', '03', '01', 'CELENDIN', 'Distrito'),
(788, '06', '03', '02', 'CHUMUCH', 'Distrito'),
(789, '06', '03', '03', 'CORTEGANA', 'Distrito'),
(790, '06', '03', '04', 'HUASMIN', 'Distrito'),
(791, '06', '03', '05', 'JORGE CHAVEZ', 'Distrito'),
(792, '06', '03', '06', 'JOSE GALVEZ', 'Distrito'),
(793, '06', '03', '07', 'MIGUEL IGLESIAS', 'Distrito'),
(794, '06', '03', '08', 'OXAMARCA', 'Distrito'),
(795, '06', '03', '09', 'SOROCHUCO', 'Distrito'),
(796, '06', '03', '10', 'SUCRE', 'Distrito'),
(797, '06', '03', '11', 'UTCO', 'Distrito'),
(798, '06', '03', '12', 'LA LIBERTAD DE PALLAN', 'Distrito'),
(799, '06', '04', '01', 'CHOTA', 'Distrito'),
(800, '06', '04', '02', 'ANGUIA', 'Distrito'),
(801, '06', '04', '03', 'CHADIN', 'Distrito'),
(802, '06', '04', '04', 'CHIGUIRIP', 'Distrito'),
(803, '06', '04', '05', 'CHIMBAN', 'Distrito'),
(804, '06', '04', '06', 'CHOROPAMPA', 'Distrito'),
(805, '06', '04', '07', 'COCHABAMBA', 'Distrito'),
(806, '06', '04', '08', 'CONCHAN', 'Distrito'),
(807, '06', '04', '09', 'HUAMBOS', 'Distrito'),
(808, '06', '04', '10', 'LAJAS', 'Distrito'),
(809, '06', '04', '11', 'LLAMA', 'Distrito'),
(810, '06', '04', '12', 'MIRACOSTA', 'Distrito'),
(811, '06', '04', '13', 'PACCHA', 'Distrito'),
(812, '06', '04', '14', 'PION', 'Distrito'),
(813, '06', '04', '15', 'QUEROCOTO', 'Distrito'),
(814, '06', '04', '16', 'SAN JUAN DE LICUPIS', 'Distrito'),
(815, '06', '04', '17', 'TACABAMBA', 'Distrito'),
(816, '06', '04', '18', 'TOCMOCHE', 'Distrito'),
(817, '06', '04', '19', 'CHALAMARCA', 'Distrito'),
(818, '06', '05', '01', 'CONTUMAZA', 'Distrito'),
(819, '06', '05', '02', 'CHILETE', 'Distrito'),
(820, '06', '05', '03', 'CUPISNIQUE', 'Distrito'),
(821, '06', '05', '04', 'GUZMANGO', 'Distrito'),
(822, '06', '05', '05', 'SAN BENITO', 'Distrito'),
(823, '06', '05', '06', 'SANTA CRUZ DE TOLED', 'Distrito'),
(824, '06', '05', '07', 'TANTARICA', 'Distrito'),
(825, '06', '05', '08', 'YONAN', 'Distrito'),
(826, '06', '06', '01', 'CUTERVO', 'Distrito'),
(827, '06', '06', '02', 'CALLAYUC', 'Distrito'),
(828, '06', '06', '03', 'CHOROS', 'Distrito'),
(829, '06', '06', '04', 'CUJILLO', 'Distrito'),
(830, '06', '06', '05', 'LA RAMADA', 'Distrito'),
(831, '06', '06', '06', 'PIMPINGOS', 'Distrito'),
(832, '06', '06', '07', 'QUEROCOTILLO', 'Distrito'),
(833, '06', '06', '08', 'SAN ANDRES DE CUTERVO', 'Distrito'),
(834, '06', '06', '09', 'SAN JUAN DE CUTERVO', 'Distrito'),
(835, '06', '06', '10', 'SAN LUIS DE LUCMA', 'Distrito'),
(836, '06', '06', '11', 'SANTA CRUZ', 'Distrito'),
(837, '06', '06', '12', 'SANTO DOMINGO DE LA CAPILLA', 'Distrito'),
(838, '06', '06', '13', 'SANTO TOMAS', 'Distrito'),
(839, '06', '06', '14', 'SOCOTA', 'Distrito'),
(840, '06', '06', '15', 'TORIBIO CASANOVA', 'Distrito'),
(841, '06', '07', '01', 'BAMBAMARCA', 'Distrito'),
(842, '06', '07', '02', 'CHUGUR', 'Distrito'),
(843, '06', '07', '03', 'HUALGAYOC', 'Distrito'),
(844, '06', '08', '01', 'JAEN', 'Distrito'),
(845, '06', '08', '02', 'BELLAVISTA', 'Distrito'),
(846, '06', '08', '03', 'CHONTALI', 'Distrito'),
(847, '06', '08', '04', 'COLASAY', 'Distrito'),
(848, '06', '08', '05', 'HUABAL', 'Distrito'),
(849, '06', '08', '06', 'LAS PIRIAS', 'Distrito'),
(850, '06', '08', '07', 'POMAHUACA', 'Distrito'),
(851, '06', '08', '08', 'PUCARA', 'Distrito'),
(852, '06', '08', '09', 'SALLIQUE', 'Distrito'),
(853, '06', '08', '10', 'SAN FELIPE', 'Distrito'),
(854, '06', '08', '11', 'SAN JOSE DEL ALTO', 'Distrito'),
(855, '06', '08', '12', 'SANTA ROSA', 'Distrito'),
(856, '06', '09', '01', 'SAN IGNACIO', 'Distrito'),
(857, '06', '09', '02', 'CHIRINOS', 'Distrito'),
(858, '06', '09', '03', 'HUARANGO', 'Distrito'),
(859, '06', '09', '04', 'LA COIPA', 'Distrito'),
(860, '06', '09', '05', 'NAMBALLE', 'Distrito'),
(861, '06', '09', '06', 'SAN JOSE DE LOURDES', 'Distrito'),
(862, '06', '09', '07', 'TABACONAS', 'Distrito'),
(863, '06', '10', '01', 'PEDRO GALVEZ', 'Distrito'),
(864, '06', '10', '02', 'CHANCAY', 'Distrito'),
(865, '06', '10', '03', 'EDUARDO VILLANUEVA', 'Distrito'),
(866, '06', '10', '04', 'GREGORIO PITA', 'Distrito'),
(867, '06', '10', '05', 'ICHOCAN', 'Distrito'),
(868, '06', '10', '06', 'JOSE MANUEL QUIROZ', 'Distrito'),
(869, '06', '10', '07', 'JOSE SABOGAL', 'Distrito'),
(870, '06', '11', '01', 'SAN MIGUEL', 'Distrito'),
(871, '06', '11', '02', 'BOLIVAR', 'Distrito'),
(872, '06', '11', '03', 'CALQUIS', 'Distrito'),
(873, '06', '11', '04', 'CATILLUC', 'Distrito'),
(874, '06', '11', '05', 'EL PRADO', 'Distrito'),
(875, '06', '11', '06', 'LA FLORIDA', 'Distrito'),
(876, '06', '11', '07', 'LLAPA', 'Distrito'),
(877, '06', '11', '08', 'NANCHOC', 'Distrito'),
(878, '06', '11', '09', 'NIEPOS', 'Distrito'),
(879, '06', '11', '10', 'SAN GREGORIO', 'Distrito'),
(880, '06', '11', '11', 'SAN SILVESTRE DE COCHAN', 'Distrito'),
(881, '06', '11', '12', 'TONGOD', 'Distrito'),
(882, '06', '11', '13', 'UNION AGUA BLANCA', 'Distrito'),
(883, '06', '12', '01', 'SAN PABLO', 'Distrito'),
(884, '06', '12', '02', 'SAN BERNARDINO', 'Distrito'),
(885, '06', '12', '03', 'SAN LUIS', 'Distrito'),
(886, '06', '12', '04', 'TUMBADEN', 'Distrito'),
(887, '06', '13', '01', 'SANTA CRUZ', 'Distrito'),
(888, '06', '13', '02', 'ANDABAMBA', 'Distrito'),
(889, '06', '13', '03', 'CATACHE', 'Distrito'),
(890, '06', '13', '04', 'CHANCAYBAÃ‘OS', 'Distrito'),
(891, '06', '13', '05', 'LA ESPERANZA', 'Distrito'),
(892, '06', '13', '06', 'NINABAMBA', 'Distrito'),
(893, '06', '13', '07', 'PULAN', 'Distrito'),
(894, '06', '13', '08', 'SAUCEPAMPA', 'Distrito'),
(895, '06', '13', '09', 'SEXI', 'Distrito'),
(896, '06', '13', '10', 'UTICYACU', 'Distrito'),
(897, '06', '13', '11', 'YAUYUCAN', 'Distrito'),
(898, '07', '01', '01', 'CALLAO', 'Distrito'),
(899, '07', '01', '02', 'BELLAVISTA', 'Distrito'),
(900, '07', '01', '03', 'CARMEN DE LA LEGUA REYNOSO', 'Distrito'),
(901, '07', '01', '04', 'LA PERLA', 'Distrito'),
(902, '07', '01', '05', 'LA PUNTA', 'Distrito'),
(903, '07', '01', '06', 'VENTANILLA', 'Distrito'),
(904, '08', '01', '01', 'CUSCO', 'Distrito'),
(905, '08', '01', '02', 'CCORCA', 'Distrito'),
(906, '08', '01', '03', 'POROY', 'Distrito'),
(907, '08', '01', '04', 'SAN JERONIMO', 'Distrito'),
(908, '08', '01', '05', 'SAN SEBASTIAN', 'Distrito'),
(909, '08', '01', '06', 'SANTIAGO', 'Distrito'),
(910, '08', '01', '07', 'SAYLLA', 'Distrito'),
(911, '08', '01', '08', 'WANCHAQ', 'Distrito'),
(912, '08', '02', '01', 'ACOMAYO', 'Distrito'),
(913, '08', '02', '02', 'ACOPIA', 'Distrito'),
(914, '08', '02', '03', 'ACOS', 'Distrito'),
(915, '08', '02', '04', 'MOSOC LLACTA', 'Distrito'),
(916, '08', '02', '05', 'POMACANCHI', 'Distrito'),
(917, '08', '02', '06', 'RONDOCAN', 'Distrito'),
(918, '08', '02', '07', 'SANGARARA', 'Distrito'),
(919, '08', '03', '01', 'ANTA', 'Distrito'),
(920, '08', '03', '02', 'ANCAHUASI', 'Distrito'),
(921, '08', '03', '03', 'CACHIMAYO', 'Distrito'),
(922, '08', '03', '04', 'CHINCHAYPUJIO', 'Distrito'),
(923, '08', '03', '05', 'HUAROCONDO', 'Distrito'),
(924, '08', '03', '06', 'LIMATAMBO', 'Distrito'),
(925, '08', '03', '07', 'MOLLEPATA', 'Distrito'),
(926, '08', '03', '08', 'PUCYURA', 'Distrito'),
(927, '08', '03', '09', 'ZURITE', 'Distrito'),
(928, '08', '04', '01', 'CALCA', 'Distrito'),
(929, '08', '04', '02', 'COYA', 'Distrito'),
(930, '08', '04', '03', 'LAMAY', 'Distrito'),
(931, '08', '04', '04', 'LARES', 'Distrito'),
(932, '08', '04', '05', 'PISAC', 'Distrito'),
(933, '08', '04', '06', 'SAN SALVADOR', 'Distrito'),
(934, '08', '04', '07', 'TARAY', 'Distrito'),
(935, '08', '04', '08', 'YANATILE', 'Distrito'),
(936, '08', '05', '01', 'YANAOCA', 'Distrito'),
(937, '08', '05', '02', 'CHECCA', 'Distrito'),
(938, '08', '05', '03', 'KUNTURKANKI', 'Distrito'),
(939, '08', '05', '04', 'LANGUI', 'Distrito'),
(940, '08', '05', '05', 'LAYO', 'Distrito'),
(941, '08', '05', '06', 'PAMPAMARCA', 'Distrito'),
(942, '08', '05', '07', 'QUEHUE', 'Distrito'),
(943, '08', '05', '08', 'TUPAC AMARU', 'Distrito'),
(944, '08', '06', '01', 'SICUANI', 'Distrito'),
(945, '08', '06', '02', 'CHECACUPE', 'Distrito'),
(946, '08', '06', '03', 'COMBAPATA', 'Distrito'),
(947, '08', '06', '04', 'MARANGANI', 'Distrito'),
(948, '08', '06', '05', 'PITUMARCA', 'Distrito'),
(949, '08', '06', '06', 'SAN PABLO', 'Distrito'),
(950, '08', '06', '07', 'SAN PEDRO', 'Distrito'),
(951, '08', '06', '08', 'TINTA', 'Distrito'),
(952, '08', '07', '01', 'SANTO TOMAS', 'Distrito'),
(953, '08', '07', '02', 'CAPACMARCA', 'Distrito'),
(954, '08', '07', '03', 'CHAMACA', 'Distrito'),
(955, '08', '07', '04', 'COLQUEMARCA', 'Distrito'),
(956, '08', '07', '05', 'LIVITACA', 'Distrito'),
(957, '08', '07', '06', 'LLUSCO', 'Distrito'),
(958, '08', '07', '07', 'QUIÃ‘OTA', 'Distrito'),
(959, '08', '07', '08', 'VELILLE', 'Distrito'),
(960, '08', '08', '01', 'ESPINAR', 'Distrito'),
(961, '08', '08', '02', 'CONDOROMA', 'Distrito'),
(962, '08', '08', '03', 'COPORAQUE', 'Distrito'),
(963, '08', '08', '04', 'OCORURO', 'Distrito'),
(964, '08', '08', '05', 'PALLPATA', 'Distrito'),
(965, '08', '08', '06', 'PICHIGUA', 'Distrito'),
(966, '08', '08', '07', 'SUYCKUTAMBO 3/', 'Distrito'),
(967, '08', '08', '08', 'ALTO PICHIGUA', 'Distrito'),
(968, '08', '09', '01', 'SANTA ANA', 'Distrito'),
(969, '08', '09', '02', 'ECHARATE', 'Distrito'),
(970, '08', '09', '03', 'HUAYOPATA /1', 'Distrito'),
(971, '08', '09', '04', 'MARANURA', 'Distrito'),
(972, '08', '09', '05', 'OCOBAMBA  /2', 'Distrito'),
(973, '08', '09', '06', 'QUELLOUNO', 'Distrito'),
(974, '08', '09', '07', 'KIMBIRI', 'Distrito'),
(975, '08', '09', '08', 'SANTA TERESA', 'Distrito'),
(976, '08', '09', '09', 'VILCABAMBA', 'Distrito'),
(977, '08', '09', '10', 'PICHARI', 'Distrito'),
(978, '08', '10', '01', 'PARURO', 'Distrito'),
(979, '08', '10', '02', 'ACCHA', 'Distrito'),
(980, '08', '10', '03', 'CCAPI', 'Distrito'),
(981, '08', '10', '04', 'COLCHA', 'Distrito'),
(982, '08', '10', '05', 'HUANOQUITE', 'Distrito'),
(983, '08', '10', '06', 'OMACHA', 'Distrito'),
(984, '08', '10', '07', 'PACCARITAMBO', 'Distrito'),
(985, '08', '10', '08', 'PILLPINTO', 'Distrito'),
(986, '08', '10', '09', 'YAURISQUE', 'Distrito'),
(987, '08', '11', '01', 'PAUCARTAMBO', 'Distrito'),
(988, '08', '11', '02', 'CAICAY', 'Distrito'),
(989, '08', '11', '03', 'CHALLABAMBA', 'Distrito'),
(990, '08', '11', '04', 'COLQUEPATA', 'Distrito'),
(991, '08', '11', '05', 'HUANCARANI', 'Distrito'),
(992, '08', '11', '06', 'KOSÃ‘IPATA', 'Distrito'),
(993, '08', '12', '01', 'URCOS', 'Distrito'),
(994, '08', '12', '02', 'ANDAHUAYLILLAS', 'Distrito'),
(995, '08', '12', '03', 'CAMANTI', 'Distrito'),
(996, '08', '12', '04', 'CCARHUAYO', 'Distrito'),
(997, '08', '12', '05', 'CCATCA', 'Distrito'),
(998, '08', '12', '06', 'CUSIPATA', 'Distrito'),
(999, '08', '12', '07', 'HUARO', 'Distrito'),
(1000, '08', '12', '08', 'LUCRE', 'Distrito'),
(1001, '08', '12', '09', 'MARCAPATA', 'Distrito'),
(1002, '08', '12', '10', 'OCONGATE', 'Distrito'),
(1003, '08', '12', '11', 'OROPESA', 'Distrito'),
(1004, '08', '12', '12', 'QUIQUIJANA', 'Distrito'),
(1005, '08', '13', '01', 'URUBAMBA', 'Distrito'),
(1006, '08', '13', '02', 'CHINCHERO', 'Distrito'),
(1007, '08', '13', '03', 'HUAYLLABAMBA', 'Distrito'),
(1008, '08', '13', '04', 'MACHUPICCHU', 'Distrito'),
(1009, '08', '13', '05', 'MARAS', 'Distrito'),
(1010, '08', '13', '06', 'OLLANTAYTAMBO', 'Distrito'),
(1011, '08', '13', '07', 'YUCAY', 'Distrito'),
(1012, '09', '01', '01', 'HUANCAVELICA', 'Distrito'),
(1013, '09', '01', '02', 'ACOBAMBILLA', 'Distrito'),
(1014, '09', '01', '03', 'ACORIA', 'Distrito'),
(1015, '09', '01', '04', 'CONAYCA', 'Distrito'),
(1016, '09', '01', '05', 'CUENCA', 'Distrito'),
(1017, '09', '01', '06', 'HUACHOCOLPA', 'Distrito'),
(1018, '09', '01', '07', 'HUAYLLAHUARA', 'Distrito'),
(1019, '09', '01', '08', 'IZCUCHACA', 'Distrito'),
(1020, '09', '01', '09', 'LARIA', 'Distrito'),
(1021, '09', '01', '10', 'MANTA', 'Distrito'),
(1022, '09', '01', '11', 'MARISCAL CACERES', 'Distrito'),
(1023, '09', '01', '12', 'MOYA', 'Distrito'),
(1024, '09', '01', '13', 'NUEVO OCCORO', 'Distrito'),
(1025, '09', '01', '14', 'PALCA', 'Distrito'),
(1026, '09', '01', '15', 'PILCHACA', 'Distrito'),
(1027, '09', '01', '16', 'VILCA', 'Distrito'),
(1028, '09', '01', '17', 'YAULI', 'Distrito'),
(1029, '09', '01', '18', 'ASCENSION', 'Distrito'),
(1030, '09', '01', '19', 'HUANDO', 'Distrito'),
(1031, '09', '02', '01', 'ACOBAMBA', 'Distrito'),
(1032, '09', '02', '02', 'ANDABAMBA', 'Distrito'),
(1033, '09', '02', '03', 'ANTA', 'Distrito'),
(1034, '09', '02', '04', 'CAJA', 'Distrito'),
(1035, '09', '02', '05', 'MARCAS', 'Distrito'),
(1036, '09', '02', '06', 'PAUCARA', 'Distrito'),
(1037, '09', '02', '07', 'POMACOCHA', 'Distrito');
INSERT INTO `cs_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(1038, '09', '02', '08', 'ROSARIO', 'Distrito'),
(1039, '09', '03', '01', 'LIRCAY', 'Distrito'),
(1040, '09', '03', '02', 'ANCHONGA', 'Distrito'),
(1041, '09', '03', '03', 'CALLANMARCA', 'Distrito'),
(1042, '09', '03', '04', 'CCOCHACCASA', 'Distrito'),
(1043, '09', '03', '05', 'CHINCHO', 'Distrito'),
(1044, '09', '03', '06', 'CONGALLA', 'Distrito'),
(1045, '09', '03', '07', 'HUANCA-HUANCA', 'Distrito'),
(1046, '09', '03', '08', 'HUAYLLAY GRANDE', 'Distrito'),
(1047, '09', '03', '09', 'JULCAMARCA', 'Distrito'),
(1048, '09', '03', '10', 'SAN ANTONIO DE ANTAPARCO', 'Distrito'),
(1049, '09', '03', '11', 'SANTO TOMAS DE PATA', 'Distrito'),
(1050, '09', '03', '12', 'SECCLLA', 'Distrito'),
(1051, '09', '04', '01', 'CASTROVIRREYNA', 'Distrito'),
(1052, '09', '04', '02', 'ARMA', 'Distrito'),
(1053, '09', '04', '03', 'AURAHUA', 'Distrito'),
(1054, '09', '04', '04', 'CAPILLAS', 'Distrito'),
(1055, '09', '04', '05', 'CHUPAMARCA', 'Distrito'),
(1056, '09', '04', '06', 'COCAS', 'Distrito'),
(1057, '09', '04', '07', 'HUACHOS', 'Distrito'),
(1058, '09', '04', '08', 'HUAMATAMBO', 'Distrito'),
(1059, '09', '04', '09', 'MOLLEPAMPA', 'Distrito'),
(1060, '09', '04', '10', 'SAN JUAN', 'Distrito'),
(1061, '09', '04', '11', 'SANTA ANA', 'Distrito'),
(1062, '09', '04', '12', 'TANTARA', 'Distrito'),
(1063, '09', '04', '13', 'TICRAPO', 'Distrito'),
(1064, '09', '05', '01', 'CHURCAMPA', 'Distrito'),
(1065, '09', '05', '02', 'ANCO', 'Distrito'),
(1066, '09', '05', '03', 'CHINCHIHUASI', 'Distrito'),
(1067, '09', '05', '04', 'EL CARMEN', 'Distrito'),
(1068, '09', '05', '05', 'LA MERCED', 'Distrito'),
(1069, '09', '05', '06', 'LOCROJA', 'Distrito'),
(1070, '09', '05', '07', 'PAUCARBAMBA', 'Distrito'),
(1071, '09', '05', '08', 'SAN MIGUEL DE MAYOCC', 'Distrito'),
(1072, '09', '05', '09', 'SAN PEDRO DE CORIS', 'Distrito'),
(1073, '09', '05', '10', 'PACHAMARCA ', 'Distrito'),
(1074, '09', '06', '01', 'HUAYTARA', 'Distrito'),
(1075, '09', '06', '02', 'AYAVI', 'Distrito'),
(1076, '09', '06', '03', 'CORDOVA', 'Distrito'),
(1077, '09', '06', '04', 'HUAYACUNDO ARMA', 'Distrito'),
(1078, '09', '06', '05', 'LARAMARCA', 'Distrito'),
(1079, '09', '06', '06', 'OCOYO', 'Distrito'),
(1080, '09', '06', '07', 'PILPICHACA', 'Distrito'),
(1081, '09', '06', '08', 'QUERCO', 'Distrito'),
(1082, '09', '06', '09', 'QUITO-ARMA', 'Distrito'),
(1083, '09', '06', '10', 'SAN ANTONIO DE CUSICANCHA', 'Distrito'),
(1084, '09', '06', '11', 'SAN FRANCISCO DE SANGAYAICO', 'Distrito'),
(1085, '09', '06', '12', 'SAN ISIDRO', 'Distrito'),
(1086, '09', '06', '13', 'SANTIAGO DE CHOCORVOS', 'Distrito'),
(1087, '09', '06', '14', 'SANTIAGO DE QUIRAHUARA', 'Distrito'),
(1088, '09', '06', '15', 'SANTO DOMINGO DE CAPILLAS', 'Distrito'),
(1089, '09', '06', '16', 'TAMBO', 'Distrito'),
(1090, '09', '07', '01', 'PAMPAS', 'Distrito'),
(1091, '09', '07', '02', 'ACOSTAMBO', 'Distrito'),
(1092, '09', '07', '03', 'ACRAQUIA', 'Distrito'),
(1093, '09', '07', '04', 'AHUAYCHA', 'Distrito'),
(1094, '09', '07', '05', 'COLCABAMBA', 'Distrito'),
(1095, '09', '07', '06', 'DANIEL HERNANDEZ', 'Distrito'),
(1096, '09', '07', '07', 'HUACHOCOLPA', 'Distrito'),
(1097, '09', '07', '09', 'HUARIBAMBA', 'Distrito'),
(1098, '09', '07', '10', 'Ã‘AHUIMPUQUIO', 'Distrito'),
(1099, '09', '07', '11', 'PAZOS', 'Distrito'),
(1100, '09', '07', '13', 'QUISHUAR', 'Distrito'),
(1101, '09', '07', '14', 'SALCABAMBA', 'Distrito'),
(1102, '09', '07', '15', 'SALCAHUASI', 'Distrito'),
(1103, '09', '07', '16', 'SAN MARCOS DE ROCCHAC', 'Distrito'),
(1104, '09', '07', '17', 'SURCUBAMBA', 'Distrito'),
(1105, '09', '07', '18', 'TINTAY PUNCU', 'Distrito'),
(1106, '10', '01', '01', 'HUANUCO', 'Distrito'),
(1107, '10', '01', '02', 'AMARILIS', 'Distrito'),
(1108, '10', '01', '03', 'CHINCHAO', 'Distrito'),
(1109, '10', '01', '04', 'CHURUBAMBA', 'Distrito'),
(1110, '10', '01', '05', 'MARGOS', 'Distrito'),
(1111, '10', '01', '06', 'QUISQUI', 'Distrito'),
(1112, '10', '01', '07', 'SAN FRANCISCO DE CAYRAN', 'Distrito'),
(1113, '10', '01', '08', 'SAN PEDRO DE CHAULAN', 'Distrito'),
(1114, '10', '01', '09', 'SANTA MARIA DEL VALLE', 'Distrito'),
(1115, '10', '01', '10', 'YARUMAYO', 'Distrito'),
(1116, '10', '01', '11', 'PILLCO MARCA', 'Distrito'),
(1117, '10', '02', '01', 'AMBO', 'Distrito'),
(1118, '10', '02', '02', 'CAYNA', 'Distrito'),
(1119, '10', '02', '03', 'COLPAS', 'Distrito'),
(1120, '10', '02', '04', 'CONCHAMARCA', 'Distrito'),
(1121, '10', '02', '05', 'HUACAR', 'Distrito'),
(1122, '10', '02', '06', 'SAN FRANCISCO', 'Distrito'),
(1123, '10', '02', '07', 'SAN RAFAEL', 'Distrito'),
(1124, '10', '02', '08', 'TOMAY KICHWA', 'Distrito'),
(1125, '10', '03', '01', 'LA UNION', 'Distrito'),
(1126, '10', '03', '07', 'CHUQUIS', 'Distrito'),
(1127, '10', '03', '11', 'MARIAS', 'Distrito'),
(1128, '10', '03', '13', 'PACHAS', 'Distrito'),
(1129, '10', '03', '16', 'QUIVILLA', 'Distrito'),
(1130, '10', '03', '17', 'RIPAN', 'Distrito'),
(1131, '10', '03', '21', 'SHUNQUI', 'Distrito'),
(1132, '10', '03', '22', 'SILLAPATA', 'Distrito'),
(1133, '10', '03', '23', 'YANAS', 'Distrito'),
(1134, '10', '04', '01', 'HUACAYBAMBA', 'Distrito'),
(1135, '10', '04', '02', 'CANCHABAMBA', 'Distrito'),
(1136, '10', '04', '03', 'COCHABAMBA', 'Distrito'),
(1137, '10', '04', '04', 'PINRA', 'Distrito'),
(1138, '10', '05', '01', 'LLATA', 'Distrito'),
(1139, '10', '05', '02', 'ARANCAY', 'Distrito'),
(1140, '10', '05', '03', 'CHAVIN DE PARIARCA', 'Distrito'),
(1141, '10', '05', '04', 'JACAS GRANDE', 'Distrito'),
(1142, '10', '05', '05', 'JIRCAN', 'Distrito'),
(1143, '10', '05', '06', 'MIRAFLORES', 'Distrito'),
(1144, '10', '05', '07', 'MONZON', 'Distrito'),
(1145, '10', '05', '08', 'PUNCHAO', 'Distrito'),
(1146, '10', '05', '09', 'PUÃ‘OS', 'Distrito'),
(1147, '10', '05', '10', 'SINGA', 'Distrito'),
(1148, '10', '05', '11', 'TANTAMAYO', 'Distrito'),
(1149, '10', '06', '01', 'RUPA-RUPA', 'Distrito'),
(1150, '10', '06', '02', 'DANIEL ALOMIA ROBLES', 'Distrito'),
(1151, '10', '06', '03', 'HERMILIO VALDIZAN', 'Distrito'),
(1152, '10', '06', '04', 'JOSE CRESPO Y CASTILLO', 'Distrito'),
(1153, '10', '06', '05', 'LUYANDO 1/', 'Distrito'),
(1154, '10', '06', '06', 'MARIANO DAMASO BERAUN', 'Distrito'),
(1155, '10', '07', '01', 'HUACRACHUCO', 'Distrito'),
(1156, '10', '07', '02', 'CHOLON', 'Distrito'),
(1157, '10', '07', '03', 'SAN BUENAVENTURA', 'Distrito'),
(1158, '10', '08', '01', 'PANAO', 'Distrito'),
(1159, '10', '08', '02', 'CHAGLLA', 'Distrito'),
(1160, '10', '08', '03', 'MOLINO', 'Distrito'),
(1161, '10', '08', '04', 'UMARI  ', 'Distrito'),
(1162, '10', '09', '01', 'PUERTO INCA', 'Distrito'),
(1163, '10', '09', '02', 'CODO DEL POZUZO', 'Distrito'),
(1164, '10', '09', '03', 'HONORIA', 'Distrito'),
(1165, '10', '09', '04', 'TOURNAVISTA', 'Distrito'),
(1166, '10', '09', '05', 'YUYAPICHIS', 'Distrito'),
(1167, '10', '10', '01', 'JESUS', 'Distrito'),
(1168, '10', '10', '02', 'BAÃ‘OS', 'Distrito'),
(1169, '10', '10', '03', 'JIVIA', 'Distrito'),
(1170, '10', '10', '04', 'QUEROPALCA', 'Distrito'),
(1171, '10', '10', '05', 'RONDOS', 'Distrito'),
(1172, '10', '10', '06', 'SAN FRANCISCO DE ASIS', 'Distrito'),
(1173, '10', '10', '07', 'SAN MIGUEL DE CAURI', 'Distrito'),
(1174, '10', '11', '01', 'CHAVINILLO', 'Distrito'),
(1175, '10', '11', '02', 'CAHUAC', 'Distrito'),
(1176, '10', '11', '03', 'CHACABAMBA', 'Distrito'),
(1177, '10', '11', '04', 'APARICIO POMARES', 'Distrito'),
(1178, '10', '11', '05', 'JACAS CHICO', 'Distrito'),
(1179, '10', '11', '06', 'OBAS', 'Distrito'),
(1180, '10', '11', '07', 'PAMPAMARCA', 'Distrito'),
(1181, '10', '11', '08', 'CHORAS', 'Distrito'),
(1182, '11', '01', '01', 'ICA', 'Distrito'),
(1183, '11', '01', '02', 'LA TINGUIÃ‘A', 'Distrito'),
(1184, '11', '01', '03', 'LOS AQUIJES', 'Distrito'),
(1185, '11', '01', '04', 'OCUCAJE', 'Distrito'),
(1186, '11', '01', '05', 'PACHACUTEC', 'Distrito'),
(1187, '11', '01', '06', 'PARCONA', 'Distrito'),
(1188, '11', '01', '07', 'PUEBLO NUEVO', 'Distrito'),
(1189, '11', '01', '08', 'SALAS', 'Distrito'),
(1190, '11', '01', '09', 'SAN JOSE DE LOS MOLINOS', 'Distrito'),
(1191, '11', '01', '10', 'SAN JUAN BAUTISTA', 'Distrito'),
(1192, '11', '01', '11', 'SANTIAGO', 'Distrito'),
(1193, '11', '01', '12', 'SUBTANJALLA', 'Distrito'),
(1194, '11', '01', '13', 'TATE', 'Distrito'),
(1195, '11', '01', '14', 'YAUCA DEL ROSARIO  1/', 'Distrito'),
(1196, '11', '02', '01', 'CHINCHA ALTA', 'Distrito'),
(1197, '11', '02', '02', 'ALTO LARAN', 'Distrito'),
(1198, '11', '02', '03', 'CHAVIN', 'Distrito'),
(1199, '11', '02', '04', 'CHINCHA BAJA', 'Distrito'),
(1200, '11', '02', '05', 'EL CARMEN', 'Distrito'),
(1201, '11', '02', '06', 'GROCIO PRADO', 'Distrito'),
(1202, '11', '02', '07', 'PUEBLO NUEVO', 'Distrito'),
(1203, '11', '02', '08', 'SAN JUAN DE YANAC', 'Distrito'),
(1204, '11', '02', '09', 'SAN PEDRO DE HUACARPANA', 'Distrito'),
(1205, '11', '02', '10', 'SUNAMPE', 'Distrito'),
(1206, '11', '02', '11', 'TAMBO DE MORA', 'Distrito'),
(1207, '11', '03', '01', 'NAZCA', 'Distrito'),
(1208, '11', '03', '02', 'CHANGUILLO', 'Distrito'),
(1209, '11', '03', '03', 'EL INGENIO', 'Distrito'),
(1210, '11', '03', '04', 'MARCONA', 'Distrito'),
(1211, '11', '03', '05', 'VISTA ALEGRE', 'Distrito'),
(1212, '11', '04', '01', 'PALPA', 'Distrito'),
(1213, '11', '04', '02', 'LLIPATA', 'Distrito'),
(1214, '11', '04', '03', 'RIO GRANDE', 'Distrito'),
(1215, '11', '04', '04', 'SANTA CRUZ', 'Distrito'),
(1216, '11', '04', '05', 'TIBILLO', 'Distrito'),
(1217, '11', '05', '01', 'PISCO', 'Distrito'),
(1218, '11', '05', '02', 'HUANCANO', 'Distrito'),
(1219, '11', '05', '03', 'HUMAY', 'Distrito'),
(1220, '11', '05', '04', 'INDEPENDENCIA', 'Distrito'),
(1221, '11', '05', '05', 'PARACAS', 'Distrito'),
(1222, '11', '05', '06', 'SAN ANDRES', 'Distrito'),
(1223, '11', '05', '07', 'SAN CLEMENTE', 'Distrito'),
(1224, '11', '05', '08', 'TUPAC AMARU INCA', 'Distrito'),
(1225, '12', '01', '01', 'HUANCAYO', 'Distrito'),
(1226, '12', '01', '04', 'CARHUACALLANGA', 'Distrito'),
(1227, '12', '01', '05', 'CHACAPAMPA', 'Distrito'),
(1228, '12', '01', '06', 'CHICCHE', 'Distrito'),
(1229, '12', '01', '07', 'CHILCA', 'Distrito'),
(1230, '12', '01', '08', 'CHONGOS ALTO', 'Distrito'),
(1231, '12', '01', '11', 'CHUPURO', 'Distrito'),
(1232, '12', '01', '12', 'COLCA', 'Distrito'),
(1233, '12', '01', '13', 'CULLHUAS', 'Distrito'),
(1234, '12', '01', '14', 'EL TAMBO', 'Distrito'),
(1235, '12', '01', '16', 'HUACRAPUQUIO', 'Distrito'),
(1236, '12', '01', '17', 'HUALHUAS', 'Distrito'),
(1237, '12', '01', '19', 'HUANCAN', 'Distrito'),
(1238, '12', '01', '20', 'HUASICANCHA', 'Distrito'),
(1239, '12', '01', '21', 'HUAYUCACHI', 'Distrito'),
(1240, '12', '01', '22', 'INGENIO', 'Distrito'),
(1241, '12', '01', '24', 'PARIAHUANCA   1/', 'Distrito'),
(1242, '12', '01', '25', 'PILCOMAYO', 'Distrito'),
(1243, '12', '01', '26', 'PUCARA', 'Distrito'),
(1244, '12', '01', '27', 'QUICHUAY', 'Distrito'),
(1245, '12', '01', '28', 'QUILCAS', 'Distrito'),
(1246, '12', '01', '29', 'SAN AGUSTIN', 'Distrito'),
(1247, '12', '01', '30', 'SAN JERONIMO DE TUNAN', 'Distrito'),
(1248, '12', '01', '32', 'SAÃ‘O', 'Distrito'),
(1249, '12', '01', '33', 'SAPALLANGA', 'Distrito'),
(1250, '12', '01', '34', 'SICAYA', 'Distrito'),
(1251, '12', '01', '35', 'SANTO DOMINGO DE ACOBAMBA', 'Distrito'),
(1252, '12', '01', '36', 'VIQUES', 'Distrito'),
(1253, '12', '02', '01', 'CONCEPCION', 'Distrito'),
(1254, '12', '02', '02', 'ACO', 'Distrito'),
(1255, '12', '02', '03', 'ANDAMARCA', 'Distrito'),
(1256, '12', '02', '04', 'CHAMBARA', 'Distrito'),
(1257, '12', '02', '05', 'COCHAS', 'Distrito'),
(1258, '12', '02', '06', 'COMAS', 'Distrito'),
(1259, '12', '02', '07', 'HEROINAS TOLEDO', 'Distrito'),
(1260, '12', '02', '08', 'MANZANARES', 'Distrito'),
(1261, '12', '02', '09', 'MARISCAL CASTILLA', 'Distrito'),
(1262, '12', '02', '10', 'MATAHUASI', 'Distrito'),
(1263, '12', '02', '11', 'MITO', 'Distrito'),
(1264, '12', '02', '12', 'NUEVE DE JULIO', 'Distrito'),
(1265, '12', '02', '13', 'ORCOTUNA', 'Distrito'),
(1266, '12', '02', '14', 'SAN JOSE DE QUERO', 'Distrito'),
(1267, '12', '02', '15', 'SANTA ROSA DE OCOPA', 'Distrito'),
(1268, '12', '03', '01', 'CHANCHAMAYO', 'Distrito'),
(1269, '12', '03', '02', 'PERENE', 'Distrito'),
(1270, '12', '03', '03', 'PICHANAQUI', 'Distrito'),
(1271, '12', '03', '04', 'SAN LUIS DE SHUARO', 'Distrito'),
(1272, '12', '03', '05', 'SAN RAMON', 'Distrito'),
(1273, '12', '03', '06', 'VITOC', 'Distrito'),
(1274, '12', '04', '01', 'JAUJA', 'Distrito'),
(1275, '12', '04', '02', 'ACOLLA', 'Distrito'),
(1276, '12', '04', '03', 'APATA', 'Distrito'),
(1277, '12', '04', '04', 'ATAURA', 'Distrito'),
(1278, '12', '04', '05', 'CANCHAYLLO', 'Distrito'),
(1279, '12', '04', '06', 'CURICACA', 'Distrito'),
(1280, '12', '04', '07', 'EL MANTARO', 'Distrito'),
(1281, '12', '04', '08', 'HUAMALI', 'Distrito'),
(1282, '12', '04', '09', 'HUARIPAMPA', 'Distrito'),
(1283, '12', '04', '10', 'HUERTAS', 'Distrito'),
(1284, '12', '04', '11', 'JANJAILLO', 'Distrito'),
(1285, '12', '04', '12', 'JULCAN', 'Distrito'),
(1286, '12', '04', '13', 'LEONOR ORDOÃ‘EZ', 'Distrito'),
(1287, '12', '04', '14', 'LLOCLLAPAMPA', 'Distrito'),
(1288, '12', '04', '15', 'MARCO', 'Distrito'),
(1289, '12', '04', '16', 'MASMA', 'Distrito'),
(1290, '12', '04', '17', 'MASMA CHICCHE', 'Distrito'),
(1291, '12', '04', '18', 'MOLINOS', 'Distrito'),
(1292, '12', '04', '19', 'MONOBAMBA', 'Distrito'),
(1293, '12', '04', '20', 'MUQUI', 'Distrito'),
(1294, '12', '04', '21', 'MUQUIYAUYO', 'Distrito'),
(1295, '12', '04', '22', 'PACA', 'Distrito'),
(1296, '12', '04', '23', 'PACCHA', 'Distrito'),
(1297, '12', '04', '24', 'PANCAN', 'Distrito'),
(1298, '12', '04', '25', 'PARCO', 'Distrito'),
(1299, '12', '04', '26', 'POMACANCHA', 'Distrito'),
(1300, '12', '04', '27', 'RICRAN', 'Distrito'),
(1301, '12', '04', '28', 'SAN LORENZO', 'Distrito'),
(1302, '12', '04', '29', 'SAN PEDRO DE CHUNAN', 'Distrito'),
(1303, '12', '04', '30', 'SAUSA', 'Distrito'),
(1304, '12', '04', '31', 'SINCOS', 'Distrito'),
(1305, '12', '04', '32', 'TUNAN MARCA', 'Distrito'),
(1306, '12', '04', '33', 'YAULI', 'Distrito'),
(1307, '12', '04', '34', 'YAUYOS', 'Distrito'),
(1308, '12', '05', '01', 'JUNIN', 'Distrito'),
(1309, '12', '05', '02', 'CARHUAMAYO', 'Distrito'),
(1310, '12', '05', '03', 'ONDORES', 'Distrito'),
(1311, '12', '05', '04', 'ULCUMAYO', 'Distrito'),
(1312, '12', '06', '01', 'SATIPO', 'Distrito'),
(1313, '12', '06', '02', 'COVIRIALI', 'Distrito'),
(1314, '12', '06', '03', 'LLAYLLA', 'Distrito'),
(1315, '12', '06', '04', 'MAZAMARI', 'Distrito'),
(1316, '12', '06', '05', 'PAMPA HERMOSA', 'Distrito'),
(1317, '12', '06', '06', 'PANGOA', 'Distrito'),
(1318, '12', '06', '07', 'RIO NEGRO', 'Distrito'),
(1319, '12', '06', '08', 'RIO TAMBO', 'Distrito'),
(1320, '12', '07', '01', 'TARMA', 'Distrito'),
(1321, '12', '07', '02', 'ACOBAMBA', 'Distrito'),
(1322, '12', '07', '03', 'HUARICOLCA', 'Distrito'),
(1323, '12', '07', '04', 'HUASAHUASI', 'Distrito'),
(1324, '12', '07', '05', 'LA UNION', 'Distrito'),
(1325, '12', '07', '06', 'PALCA', 'Distrito'),
(1326, '12', '07', '07', 'PALCAMAYO', 'Distrito'),
(1327, '12', '07', '08', 'SAN PEDRO DE CAJAS', 'Distrito'),
(1328, '12', '07', '09', 'TAPO', 'Distrito'),
(1329, '12', '08', '01', 'LA OROYA', 'Distrito'),
(1330, '12', '08', '02', 'CHACAPALPA', 'Distrito'),
(1331, '12', '08', '03', 'HUAY-HUAY', 'Distrito'),
(1332, '12', '08', '04', 'MARCAPOMACOCHA', 'Distrito'),
(1333, '12', '08', '05', 'MOROCOCHA', 'Distrito'),
(1334, '12', '08', '06', 'PACCHA', 'Distrito'),
(1335, '12', '08', '07', 'SANTA BARBARA DE CARHUACAYAN', 'Distrito'),
(1336, '12', '08', '08', 'SANTA ROSA DE SACCO', 'Distrito'),
(1337, '12', '08', '09', 'SUITUCANCHA', 'Distrito'),
(1338, '12', '08', '10', 'YAULI', 'Distrito'),
(1339, '12', '09', '01', 'CHUPACA', 'Distrito'),
(1340, '12', '09', '02', 'AHUAC', 'Distrito'),
(1341, '12', '09', '03', 'CHONGOS BAJO', 'Distrito'),
(1342, '12', '09', '04', 'HUACHAC', 'Distrito'),
(1343, '12', '09', '05', 'HUAMANCACA CHICO', 'Distrito'),
(1344, '12', '09', '06', 'SAN JUAN DE ISCOS', 'Distrito'),
(1345, '12', '09', '07', 'SAN JUAN DE JARPA', 'Distrito'),
(1346, '12', '09', '08', 'TRES DE DICIEMBRE', 'Distrito'),
(1347, '12', '09', '09', 'YANACANCHA', 'Distrito'),
(1348, '13', '01', '01', 'TRUJILLO', 'Distrito'),
(1349, '13', '01', '02', 'EL PORVENIR', 'Distrito'),
(1350, '13', '01', '03', 'FLORENCIA DE MORA', 'Distrito'),
(1351, '13', '01', '04', 'HUANCHACO', 'Distrito'),
(1352, '13', '01', '05', 'LA ESPERANZA', 'Distrito'),
(1353, '13', '01', '06', 'LAREDO', 'Distrito'),
(1354, '13', '01', '07', 'MOCHE', 'Distrito'),
(1355, '13', '01', '08', 'POROTO', 'Distrito'),
(1356, '13', '01', '09', 'SALAVERRY', 'Distrito'),
(1357, '13', '01', '10', 'SIMBAL', 'Distrito'),
(1358, '13', '01', '11', 'VICTOR LARCO HERRERA', 'Distrito'),
(1359, '13', '02', '01', 'ASCOPE', 'Distrito'),
(1360, '13', '02', '02', 'CHICAMA', 'Distrito'),
(1361, '13', '02', '03', 'CHOCOPE', 'Distrito'),
(1362, '13', '02', '04', 'MAGDALENA DE CAO', 'Distrito'),
(1363, '13', '02', '05', 'PAIJAN', 'Distrito'),
(1364, '13', '02', '06', 'RAZURI', 'Distrito'),
(1365, '13', '02', '07', 'SANTIAGO DE CAO', 'Distrito'),
(1366, '13', '02', '08', 'CASA GRANDE', 'Distrito'),
(1367, '13', '03', '01', 'BOLIVAR', 'Distrito'),
(1368, '13', '03', '02', 'BAMBAMARCA', 'Distrito'),
(1369, '13', '03', '03', 'CONDORMARCA /1', 'Distrito'),
(1370, '13', '03', '04', 'LONGOTEA', 'Distrito'),
(1371, '13', '03', '05', 'UCHUMARCA', 'Distrito'),
(1372, '13', '03', '06', 'UCUNCHA', 'Distrito'),
(1373, '13', '04', '01', 'CHEPEN', 'Distrito'),
(1374, '13', '04', '02', 'PACANGA', 'Distrito'),
(1375, '13', '04', '03', 'PUEBLO NUEVO', 'Distrito'),
(1376, '13', '05', '01', 'JULCAN', 'Distrito'),
(1377, '13', '05', '02', 'CALAMARCA', 'Distrito'),
(1378, '13', '05', '03', 'CARABAMBA', 'Distrito'),
(1379, '13', '05', '04', 'HUASO', 'Distrito'),
(1380, '13', '06', '01', 'OTUZCO', 'Distrito'),
(1381, '13', '06', '02', 'AGALLPAMPA', 'Distrito'),
(1382, '13', '06', '04', 'CHARAT', 'Distrito'),
(1383, '13', '06', '05', 'HUARANCHAL', 'Distrito'),
(1384, '13', '06', '06', 'LA CUESTA', 'Distrito'),
(1385, '13', '06', '08', 'MACHE', 'Distrito'),
(1386, '13', '06', '10', 'PARANDAY', 'Distrito'),
(1387, '13', '06', '11', 'SALPO', 'Distrito'),
(1388, '13', '06', '13', 'SINSICAP', 'Distrito'),
(1389, '13', '06', '14', 'USQUIL', 'Distrito'),
(1390, '13', '07', '01', 'SAN PEDRO DE LLOC', 'Distrito'),
(1391, '13', '07', '02', 'GUADALUPE', 'Distrito'),
(1392, '13', '07', '03', 'JEQUETEPEQUE', 'Distrito'),
(1393, '13', '07', '04', 'PACASMAYO', 'Distrito'),
(1394, '13', '07', '05', 'SAN JOSE', 'Distrito'),
(1395, '13', '08', '01', 'TAYABAMBA', 'Distrito'),
(1396, '13', '08', '02', 'BULDIBUYO', 'Distrito'),
(1397, '13', '08', '03', 'CHILLIA', 'Distrito'),
(1398, '13', '08', '04', 'HUANCASPATA', 'Distrito'),
(1399, '13', '08', '05', 'HUAYLILLAS', 'Distrito'),
(1400, '13', '08', '06', 'HUAYO', 'Distrito'),
(1401, '13', '08', '07', 'ONGON', 'Distrito'),
(1402, '13', '08', '08', 'PARCOY', 'Distrito'),
(1403, '13', '08', '09', 'PATAZ', 'Distrito'),
(1404, '13', '08', '10', 'PIAS', 'Distrito'),
(1405, '13', '08', '11', 'SANTIAGO DE CHALLAS', 'Distrito'),
(1406, '13', '08', '12', 'TAURIJA', 'Distrito'),
(1407, '13', '08', '13', 'URPAY', 'Distrito'),
(1408, '13', '09', '01', 'HUAMACHUCO', 'Distrito'),
(1409, '13', '09', '02', 'CHUGAY', 'Distrito'),
(1410, '13', '09', '03', 'COCHORCO', 'Distrito'),
(1411, '13', '09', '04', 'CURGOS', 'Distrito'),
(1412, '13', '09', '05', 'MARCABAL', 'Distrito'),
(1413, '13', '09', '06', 'SANAGORAN', 'Distrito'),
(1414, '13', '09', '07', 'SARIN', 'Distrito'),
(1415, '13', '09', '08', 'SARTIMBAMBA', 'Distrito'),
(1416, '13', '10', '01', 'SANTIAGO DE CHUCO', 'Distrito'),
(1417, '13', '10', '02', 'ANGASMARCA', 'Distrito'),
(1418, '13', '10', '03', 'CACHICADAN', 'Distrito'),
(1419, '13', '10', '04', 'MOLLEBAMBA', 'Distrito'),
(1420, '13', '10', '05', 'MOLLEPATA', 'Distrito'),
(1421, '13', '10', '06', 'QUIRUVILCA', 'Distrito'),
(1422, '13', '10', '07', 'SANTA CRUZ DE CHUCA', 'Distrito'),
(1423, '13', '10', '08', 'SITABAMBA', 'Distrito'),
(1424, '13', '11', '01', 'CASCAS', 'Distrito'),
(1425, '13', '11', '02', 'LUCMA', 'Distrito'),
(1426, '13', '11', '03', 'COMPIN', 'Distrito'),
(1427, '13', '11', '04', 'SAYAPULLO', 'Distrito'),
(1428, '13', '12', '01', 'VIRU', 'Distrito'),
(1429, '13', '12', '02', 'CHAO', 'Distrito'),
(1430, '13', '12', '03', 'GUADALUPITO', 'Distrito'),
(1431, '14', '01', '01', 'CHICLAYO', 'Distrito'),
(1432, '14', '01', '02', 'CHONGOYAPE', 'Distrito'),
(1433, '14', '01', '03', 'ETEN', 'Distrito'),
(1434, '14', '01', '04', 'ETEN PUERTO', 'Distrito'),
(1435, '14', '01', '05', 'JOSE LEONARDO ORTIZ', 'Distrito'),
(1436, '14', '01', '06', 'LA VICTORIA', 'Distrito'),
(1437, '14', '01', '07', 'LAGUNAS   ', 'Distrito'),
(1438, '14', '01', '08', 'MONSEFU', 'Distrito'),
(1439, '14', '01', '09', 'NUEVA ARICA', 'Distrito'),
(1440, '14', '01', '10', 'OYOTUN', 'Distrito'),
(1441, '14', '01', '11', 'PICSI', 'Distrito'),
(1442, '14', '01', '12', 'PIMENTEL', 'Distrito'),
(1443, '14', '01', '13', 'REQUE', 'Distrito'),
(1444, '14', '01', '14', 'SANTA ROSA', 'Distrito'),
(1445, '14', '01', '15', 'SAÃ‘A', 'Distrito'),
(1446, '14', '01', '16', 'CAYALTI', 'Distrito'),
(1447, '14', '01', '17', 'PATAPO', 'Distrito'),
(1448, '14', '01', '18', 'POMALCA', 'Distrito'),
(1449, '14', '01', '19', 'PUCALA', 'Distrito'),
(1450, '14', '01', '20', 'TUMAN', 'Distrito'),
(1451, '14', '02', '01', 'FERREÃ‘AFE', 'Distrito'),
(1452, '14', '02', '02', 'CAÃ‘ARIS', 'Distrito'),
(1453, '14', '02', '03', 'INCAHUASI', 'Distrito'),
(1454, '14', '02', '04', 'MANUEL ANTONIO MESONES MURO', 'Distrito'),
(1455, '14', '02', '05', 'PITIPO', 'Distrito'),
(1456, '14', '02', '06', 'PUEBLO NUEVO', 'Distrito'),
(1457, '14', '03', '01', 'LAMBAYEQUE', 'Distrito'),
(1458, '14', '03', '02', 'CHOCHOPE', 'Distrito'),
(1459, '14', '03', '03', 'ILLIMO', 'Distrito'),
(1460, '14', '03', '04', 'JAYANCA', 'Distrito'),
(1461, '14', '03', '05', 'MOCHUMI', 'Distrito'),
(1462, '14', '03', '06', 'MORROPE', 'Distrito'),
(1463, '14', '03', '07', 'MOTUPE', 'Distrito'),
(1464, '14', '03', '08', 'OLMOS', 'Distrito'),
(1465, '14', '03', '09', 'PACORA', 'Distrito'),
(1466, '14', '03', '10', 'SALAS', 'Distrito'),
(1467, '14', '03', '11', 'SAN JOSE', 'Distrito'),
(1468, '14', '03', '12', 'TUCUME', 'Distrito'),
(1469, '15', '01', '01', 'LIMA', 'Distrito'),
(1470, '15', '01', '02', 'ANCON', 'Distrito'),
(1471, '15', '01', '03', 'ATE', 'Distrito'),
(1472, '15', '01', '04', 'BARRANCO', 'Distrito'),
(1473, '15', '01', '05', 'BREÃ‘A', 'Distrito'),
(1474, '15', '01', '06', 'CARABAYLLO', 'Distrito'),
(1475, '15', '01', '07', 'CHACLACAYO', 'Distrito'),
(1476, '15', '01', '08', 'CHORRILLOS', 'Distrito'),
(1477, '15', '01', '09', 'CIENEGUILLA', 'Distrito'),
(1478, '15', '01', '10', 'COMAS', 'Distrito'),
(1479, '15', '01', '11', 'EL AGUSTINO', 'Distrito'),
(1480, '15', '01', '12', 'INDEPENDENCIA', 'Distrito'),
(1481, '15', '01', '13', 'JESUS MARIA', 'Distrito'),
(1482, '15', '01', '14', 'LA MOLINA', 'Distrito'),
(1483, '15', '01', '15', 'LA VICTORIA', 'Distrito'),
(1484, '15', '01', '16', 'LINCE', 'Distrito'),
(1485, '15', '01', '17', 'LOS OLIVOS', 'Distrito'),
(1486, '15', '01', '18', 'LURIGANCHO', 'Distrito'),
(1487, '15', '01', '19', 'LURIN', 'Distrito'),
(1488, '15', '01', '20', 'MAGDALENA DEL MAR', 'Distrito'),
(1489, '15', '01', '21', 'PUEBLO LIBRE', 'Distrito'),
(1490, '15', '01', '22', 'MIRAFLORES', 'Distrito'),
(1491, '15', '01', '23', 'PACHACAMAC', 'Distrito'),
(1492, '15', '01', '24', 'PUCUSANA', 'Distrito'),
(1493, '15', '01', '25', 'PUENTE PIEDRA', 'Distrito'),
(1494, '15', '01', '26', 'PUNTA HERMOSA', 'Distrito'),
(1495, '15', '01', '27', 'PUNTA NEGRA', 'Distrito'),
(1496, '15', '01', '28', 'RIMAC', 'Distrito'),
(1497, '15', '01', '29', 'SAN BARTOLO', 'Distrito'),
(1498, '15', '01', '30', 'SAN BORJA', 'Distrito'),
(1499, '15', '01', '31', 'SAN ISIDRO', 'Distrito'),
(1500, '15', '01', '32', 'SAN JUAN DE LURIGANCHO', 'Distrito'),
(1501, '15', '01', '33', 'SAN JUAN DE MIRAFLORES', 'Distrito'),
(1502, '15', '01', '34', 'SAN LUIS', 'Distrito'),
(1503, '15', '01', '35', 'SAN MARTIN DE PORRES', 'Distrito'),
(1504, '15', '01', '36', 'SAN MIGUEL', 'Distrito'),
(1505, '15', '01', '37', 'SANTA ANITA', 'Distrito'),
(1506, '15', '01', '38', 'SANTA MARIA DEL MAR', 'Distrito'),
(1507, '15', '01', '39', 'SANTA ROSA', 'Distrito'),
(1508, '15', '01', '40', 'SANTIAGO DE SURCO', 'Distrito'),
(1509, '15', '01', '41', 'SURQUILLO', 'Distrito'),
(1510, '15', '01', '42', 'VILLA EL SALVADOR', 'Distrito'),
(1511, '15', '01', '43', 'VILLA MARIA DEL TRIUNFO', 'Distrito'),
(1512, '15', '02', '01', 'BARRANCA', 'Distrito'),
(1513, '15', '02', '02', 'PARAMONGA', 'Distrito'),
(1514, '15', '02', '03', 'PATIVILCA', 'Distrito'),
(1515, '15', '02', '04', 'SUPE', 'Distrito'),
(1516, '15', '02', '05', 'SUPE PUERTO', 'Distrito'),
(1517, '15', '03', '01', 'CAJATAMBO', 'Distrito'),
(1518, '15', '03', '02', 'COPA', 'Distrito'),
(1519, '15', '03', '03', 'GORGOR', 'Distrito'),
(1520, '15', '03', '04', 'HUANCAPON', 'Distrito'),
(1521, '15', '03', '05', 'MANAS', 'Distrito'),
(1522, '15', '04', '01', 'CANTA', 'Distrito'),
(1523, '15', '04', '02', 'ARAHUAY', 'Distrito'),
(1524, '15', '04', '03', 'HUAMANTANGA', 'Distrito'),
(1525, '15', '04', '04', 'HUAROS', 'Distrito'),
(1526, '15', '04', '05', 'LACHAQUI', 'Distrito'),
(1527, '15', '04', '06', 'SAN BUENAVENTURA', 'Distrito'),
(1528, '15', '04', '07', 'SANTA ROSA DE QUIVES', 'Distrito'),
(1529, '15', '05', '01', 'SAN VICENTE DE CAÃ‘ETE', 'Distrito'),
(1530, '15', '05', '02', 'ASIA', 'Distrito'),
(1531, '15', '05', '03', 'CALANGO', 'Distrito'),
(1532, '15', '05', '04', 'CERRO AZUL', 'Distrito'),
(1533, '15', '05', '05', 'CHILCA', 'Distrito'),
(1534, '15', '05', '06', 'COAYLLO', 'Distrito'),
(1535, '15', '05', '07', 'IMPERIAL', 'Distrito'),
(1536, '15', '05', '08', 'LUNAHUANA', 'Distrito'),
(1537, '15', '05', '09', 'MALA', 'Distrito'),
(1538, '15', '05', '10', 'NUEVO IMPERIAL', 'Distrito'),
(1539, '15', '05', '11', 'PACARAN', 'Distrito'),
(1540, '15', '05', '12', 'QUILMANA', 'Distrito'),
(1541, '15', '05', '13', 'SAN ANTONIO', 'Distrito'),
(1542, '15', '05', '14', 'SAN LUIS', 'Distrito'),
(1543, '15', '05', '15', 'SANTA CRUZ DE FLORES', 'Distrito'),
(1544, '15', '05', '16', 'ZUÃ‘IGA', 'Distrito'),
(1545, '15', '06', '01', 'HUARAL', 'Distrito'),
(1546, '15', '06', '02', 'ATAVILLOS ALTO', 'Distrito'),
(1547, '15', '06', '03', 'ATAVILLOS BAJO', 'Distrito'),
(1548, '15', '06', '04', 'AUCALLAMA', 'Distrito'),
(1549, '15', '06', '05', 'CHANCAY', 'Distrito'),
(1550, '15', '06', '06', 'IHUARI', 'Distrito'),
(1551, '15', '06', '07', 'LAMPIAN', 'Distrito'),
(1552, '15', '06', '08', 'PACARAOS', 'Distrito'),
(1553, '15', '06', '09', 'SAN MIGUEL DE ACOS', 'Distrito'),
(1554, '15', '06', '10', 'SANTA CRUZ DE ANDAMARCA', 'Distrito'),
(1555, '15', '06', '11', 'SUMBILCA', 'Distrito'),
(1556, '15', '06', '12', 'VEINTISIETE DE NOVIEMBRE', 'Distrito'),
(1557, '15', '07', '01', 'MATUCANA', 'Distrito'),
(1558, '15', '07', '02', 'ANTIOQUIA', 'Distrito'),
(1559, '15', '07', '03', 'CALLAHUANCA', 'Distrito'),
(1560, '15', '07', '04', 'CARAMPOMA', 'Distrito'),
(1561, '15', '07', '05', 'CHICLA', 'Distrito'),
(1562, '15', '07', '06', 'CUENCA', 'Distrito'),
(1563, '15', '07', '07', 'HUACHUPAMPA', 'Distrito'),
(1564, '15', '07', '08', 'HUANZA', 'Distrito'),
(1565, '15', '07', '09', 'HUAROCHIRI', 'Distrito'),
(1566, '15', '07', '10', 'LAHUAYTAMBO', 'Distrito'),
(1567, '15', '07', '11', 'LANGA', 'Distrito'),
(1568, '15', '07', '12', 'LARAOS', 'Distrito'),
(1569, '15', '07', '13', 'MARIATANA', 'Distrito'),
(1570, '15', '07', '14', 'RICARDO PALMA', 'Distrito'),
(1571, '15', '07', '15', 'SAN ANDRES DE TUPICOCHA', 'Distrito'),
(1572, '15', '07', '16', 'SAN ANTONIO', 'Distrito'),
(1573, '15', '07', '17', 'SAN BARTOLOME', 'Distrito'),
(1574, '15', '07', '18', 'SAN DAMIAN', 'Distrito'),
(1575, '15', '07', '19', 'SAN JUAN DE IRIS', 'Distrito'),
(1576, '15', '07', '20', 'SAN JUAN DE TANTARANCHE', 'Distrito'),
(1577, '15', '07', '21', 'SAN LORENZO DE QUINTI', 'Distrito'),
(1578, '15', '07', '22', 'SAN MATEO', 'Distrito'),
(1579, '15', '07', '23', 'SAN MATEO DE OTAO', 'Distrito'),
(1580, '15', '07', '24', 'SAN PEDRO DE CASTA', 'Distrito'),
(1581, '15', '07', '25', 'SAN PEDRO DE HUANCAYRE', 'Distrito'),
(1582, '15', '07', '26', 'SANGALLAYA', 'Distrito'),
(1583, '15', '07', '27', 'SANTA CRUZ DE COCACHACRA', 'Distrito'),
(1584, '15', '07', '28', 'SANTA EULALIA', 'Distrito'),
(1585, '15', '07', '29', 'SANTIAGO DE ANCHUCAYA', 'Distrito'),
(1586, '15', '07', '30', 'SANTIAGO DE TUNA', 'Distrito'),
(1587, '15', '07', '31', 'SANTO DOMINGO DE LOS OLLEROS', 'Distrito'),
(1588, '15', '07', '32', 'SURCO', 'Distrito'),
(1589, '15', '08', '01', 'HUACHO', 'Distrito'),
(1590, '15', '08', '02', 'AMBAR', 'Distrito'),
(1591, '15', '08', '03', 'CALETA DE CARQUIN', 'Distrito'),
(1592, '15', '08', '04', 'CHECRAS', 'Distrito'),
(1593, '15', '08', '05', 'HUALMAY', 'Distrito'),
(1594, '15', '08', '06', 'HUAURA', 'Distrito'),
(1595, '15', '08', '07', 'LEONCIO PRADO', 'Distrito'),
(1596, '15', '08', '08', 'PACCHO', 'Distrito'),
(1597, '15', '08', '09', 'SANTA LEONOR', 'Distrito'),
(1598, '15', '08', '10', 'SANTA MARIA', 'Distrito'),
(1599, '15', '08', '11', 'SAYAN', 'Distrito'),
(1600, '15', '08', '12', 'VEGUETA', 'Distrito'),
(1601, '15', '09', '01', 'OYON', 'Distrito'),
(1602, '15', '09', '02', 'ANDAJES', 'Distrito'),
(1603, '15', '09', '03', 'CAUJUL', 'Distrito'),
(1604, '15', '09', '04', 'COCHAMARCA', 'Distrito'),
(1605, '15', '09', '05', 'NAVAN', 'Distrito'),
(1606, '15', '09', '06', 'PACHANGARA', 'Distrito'),
(1607, '15', '10', '01', 'YAUYOS', 'Distrito'),
(1608, '15', '10', '02', 'ALIS', 'Distrito'),
(1609, '15', '10', '03', 'ALLAUCA', 'Distrito'),
(1610, '15', '10', '04', 'AYAVIRI', 'Distrito'),
(1611, '15', '10', '05', 'AZANGARO', 'Distrito'),
(1612, '15', '10', '06', 'CACRA', 'Distrito'),
(1613, '15', '10', '07', 'CARANIA', 'Distrito'),
(1614, '15', '10', '08', 'CATAHUASI', 'Distrito'),
(1615, '15', '10', '09', 'CHOCOS', 'Distrito'),
(1616, '15', '10', '10', 'COCHAS', 'Distrito'),
(1617, '15', '10', '11', 'COLONIA', 'Distrito'),
(1618, '15', '10', '12', 'HONGOS', 'Distrito'),
(1619, '15', '10', '13', 'HUAMPARA', 'Distrito'),
(1620, '15', '10', '14', 'HUANCAYA', 'Distrito'),
(1621, '15', '10', '15', 'HUANGASCAR', 'Distrito'),
(1622, '15', '10', '16', 'HUANTAN', 'Distrito'),
(1623, '15', '10', '17', 'HUAÃ‘EC', 'Distrito'),
(1624, '15', '10', '18', 'LARAOS', 'Distrito'),
(1625, '15', '10', '19', 'LINCHA', 'Distrito'),
(1626, '15', '10', '20', 'MADEAN', 'Distrito'),
(1627, '15', '10', '21', 'MIRAFLORES', 'Distrito'),
(1628, '15', '10', '22', 'OMAS', 'Distrito'),
(1629, '15', '10', '23', 'PUTINZA', 'Distrito'),
(1630, '15', '10', '24', 'QUINCHES', 'Distrito'),
(1631, '15', '10', '25', 'QUINOCAY', 'Distrito'),
(1632, '15', '10', '26', 'SAN JOAQUIN', 'Distrito'),
(1633, '15', '10', '27', 'SAN PEDRO DE PILAS', 'Distrito'),
(1634, '15', '10', '28', 'TANTA', 'Distrito'),
(1635, '15', '10', '29', 'TAURIPAMPA', 'Distrito'),
(1636, '15', '10', '30', 'TOMAS', 'Distrito'),
(1637, '15', '10', '31', 'TUPE', 'Distrito'),
(1638, '15', '10', '32', 'VIÃ‘AC', 'Distrito'),
(1639, '15', '10', '33', 'VITIS', 'Distrito'),
(1640, '16', '01', '01', 'IQUITOS', 'Distrito'),
(1641, '16', '01', '02', 'ALTO NANAY', 'Distrito'),
(1642, '16', '01', '03', 'FERNANDO LORES', 'Distrito'),
(1643, '16', '01', '04', 'INDIANA', 'Distrito'),
(1644, '16', '01', '05', 'LAS AMAZONAS', 'Distrito'),
(1645, '16', '01', '06', 'MAZAN', 'Distrito'),
(1646, '16', '01', '07', 'NAPO', 'Distrito'),
(1647, '16', '01', '08', 'PUNCHANA', 'Distrito'),
(1648, '16', '01', '09', 'PUTUMAYO    ', 'Distrito'),
(1649, '16', '01', '10', 'TORRES CAUSANA', 'Distrito'),
(1650, '16', '01', '12', 'BELEN', 'Distrito'),
(1651, '16', '01', '13', 'SAN JUAN BAUTISTA', 'Distrito'),
(1652, '16', '01', '14', 'TENIENTE MANUEL CLAVERO', 'Distrito'),
(1653, '16', '02', '01', 'YURIMAGUAS', 'Distrito'),
(1654, '16', '02', '02', 'BALSAPUERTO', 'Distrito'),
(1655, '16', '02', '05', 'JEBEROS', 'Distrito'),
(1656, '16', '02', '06', 'LAGUNAS', 'Distrito'),
(1657, '16', '02', '10', 'SANTA CRUZ', 'Distrito'),
(1658, '16', '02', '11', 'TENIENTE CESAR LOPEZ ROJAS', 'Distrito'),
(1659, '16', '03', '01', 'NAUTA', 'Distrito'),
(1660, '16', '03', '02', 'PARINARI ', 'Distrito'),
(1661, '16', '03', '03', 'TIGRE', 'Distrito'),
(1662, '16', '03', '04', 'TROMPETEROS', 'Distrito'),
(1663, '16', '03', '05', 'URARINAS', 'Distrito'),
(1664, '16', '04', '01', 'RAMON CASTILLA', 'Distrito'),
(1665, '16', '04', '02', 'PEBAS', 'Distrito'),
(1666, '16', '04', '03', 'YAVARI  /1', 'Distrito'),
(1667, '16', '04', '04', 'SAN PABLO', 'Distrito'),
(1668, '16', '05', '01', 'REQUENA', 'Distrito'),
(1669, '16', '05', '02', 'ALTO TAPICHE', 'Distrito'),
(1670, '16', '05', '03', 'CAPELO', 'Distrito'),
(1671, '16', '05', '04', 'EMILIO SAN MARTIN', 'Distrito'),
(1672, '16', '05', '05', 'MAQUIA', 'Distrito'),
(1673, '16', '05', '06', 'PUINAHUA', 'Distrito'),
(1674, '16', '05', '07', 'SAQUENA', 'Distrito'),
(1675, '16', '05', '08', 'SOPLIN', 'Distrito'),
(1676, '16', '05', '09', 'TAPICHE', 'Distrito'),
(1677, '16', '05', '10', 'JENARO HERRERA', 'Distrito'),
(1678, '16', '05', '11', 'YAQUERANA    ', 'Distrito'),
(1679, '16', '06', '01', 'CONTAMANA', 'Distrito'),
(1680, '16', '06', '02', 'INAHUAYA', 'Distrito'),
(1681, '16', '06', '03', 'PADRE MARQUEZ', 'Distrito'),
(1682, '16', '06', '04', 'PAMPA HERMOSA', 'Distrito'),
(1683, '16', '06', '05', 'SARAYACU', 'Distrito'),
(1684, '16', '06', '06', 'VARGAS GUERRA', 'Distrito'),
(1685, '16', '07', '01', 'BARRANCA', 'Distrito'),
(1686, '16', '07', '02', 'CAHUAPANAS', 'Distrito'),
(1687, '16', '07', '03', 'MANSERICHE', 'Distrito'),
(1688, '16', '07', '04', 'MORONA', 'Distrito'),
(1689, '16', '07', '05', 'PASTAZA', 'Distrito'),
(1690, '16', '07', '06', 'ANDOAS', 'Distrito'),
(1691, '17', '01', '01', 'TAMBOPATA', 'Distrito'),
(1692, '17', '01', '02', 'INAMBARI ', 'Distrito'),
(1693, '17', '01', '03', 'LAS PIEDRAS', 'Distrito'),
(1694, '17', '01', '04', 'LABERINTO', 'Distrito'),
(1695, '17', '02', '01', 'MANU    ', 'Distrito'),
(1696, '17', '02', '02', 'FITZCARRALD    ', 'Distrito'),
(1697, '17', '02', '03', 'MADRE DE DIOS    ', 'Distrito'),
(1698, '17', '02', '04', 'HUEPETUHE', 'Distrito'),
(1699, '17', '03', '01', 'IÃ‘APARI', 'Distrito'),
(1700, '17', '03', '02', 'IBERIA', 'Distrito'),
(1701, '17', '03', '03', 'TAHUAMANU', 'Distrito'),
(1702, '18', '01', '01', 'MOQUEGUA', 'Distrito'),
(1703, '18', '01', '02', 'CARUMAS', 'Distrito'),
(1704, '18', '01', '03', 'CUCHUMBAYA', 'Distrito'),
(1705, '18', '01', '04', 'SAMEGUA', 'Distrito'),
(1706, '18', '01', '05', 'SAN CRISTOBAL', 'Distrito'),
(1707, '18', '01', '06', 'TORATA', 'Distrito'),
(1708, '18', '02', '01', 'OMATE', 'Distrito'),
(1709, '18', '02', '02', 'CHOJATA', 'Distrito'),
(1710, '18', '02', '03', 'COALAQUE', 'Distrito'),
(1711, '18', '02', '04', 'ICHUÃ‘A', 'Distrito'),
(1712, '18', '02', '05', 'LA CAPILLA', 'Distrito'),
(1713, '18', '02', '06', 'LLOQUE', 'Distrito'),
(1714, '18', '02', '07', 'MATALAQUE', 'Distrito'),
(1715, '18', '02', '08', 'PUQUINA', 'Distrito'),
(1716, '18', '02', '09', 'QUINISTAQUILLAS', 'Distrito'),
(1717, '18', '02', '10', 'UBINAS', 'Distrito'),
(1718, '18', '02', '11', 'YUNGA', 'Distrito'),
(1719, '18', '03', '01', 'ILO', 'Distrito'),
(1720, '18', '03', '02', 'EL ALGARROBAL', 'Distrito'),
(1721, '18', '03', '03', 'PACOCHA', 'Distrito'),
(1722, '19', '01', '01', 'CHAUPIMARCA', 'Distrito'),
(1723, '19', '01', '02', 'HUACHON', 'Distrito'),
(1724, '19', '01', '03', 'HUARIACA', 'Distrito'),
(1725, '19', '01', '04', 'HUAYLLAY', 'Distrito'),
(1726, '19', '01', '05', 'NINACACA', 'Distrito'),
(1727, '19', '01', '06', 'PALLANCHACRA', 'Distrito'),
(1728, '19', '01', '07', 'PAUCARTAMBO', 'Distrito'),
(1729, '19', '01', '08', 'SAN FRANCISCO DE ASIS DE YARUSYACAN', 'Distrito'),
(1730, '19', '01', '09', 'SIMON BOLIVAR', 'Distrito'),
(1731, '19', '01', '10', 'TICLACAYAN', 'Distrito'),
(1732, '19', '01', '11', 'TINYAHUARCO', 'Distrito'),
(1733, '19', '01', '12', 'VICCO', 'Distrito'),
(1734, '19', '01', '13', 'YANACANCHA', 'Distrito'),
(1735, '19', '02', '01', 'YANAHUANCA', 'Distrito'),
(1736, '19', '02', '02', 'CHACAYAN', 'Distrito'),
(1737, '19', '02', '03', 'GOYLLARISQUIZGA', 'Distrito'),
(1738, '19', '02', '04', 'PAUCAR', 'Distrito'),
(1739, '19', '02', '05', 'SAN PEDRO DE PILLAO', 'Distrito'),
(1740, '19', '02', '06', 'SANTA ANA DE TUSI', 'Distrito'),
(1741, '19', '02', '07', 'TAPUC', 'Distrito'),
(1742, '19', '02', '08', 'VILCABAMBA', 'Distrito'),
(1743, '19', '03', '01', 'OXAPAMPA', 'Distrito'),
(1744, '19', '03', '02', 'CHONTABAMBA', 'Distrito'),
(1745, '19', '03', '03', 'HUANCABAMBA', 'Distrito'),
(1746, '19', '03', '04', 'PALCAZU', 'Distrito'),
(1747, '19', '03', '05', 'POZUZO', 'Distrito'),
(1748, '19', '03', '06', 'PUERTO BERMUDEZ', 'Distrito'),
(1749, '19', '03', '07', 'VILLA RICA', 'Distrito'),
(1750, '20', '01', '01', 'PIURA', 'Distrito'),
(1751, '20', '01', '04', 'CASTILLA', 'Distrito'),
(1752, '20', '01', '05', 'CATACAOS', 'Distrito'),
(1753, '20', '01', '07', 'CURA MORI', 'Distrito'),
(1754, '20', '01', '08', 'EL TALLAN', 'Distrito'),
(1755, '20', '01', '09', 'LA ARENA', 'Distrito'),
(1756, '20', '01', '10', 'LA UNION', 'Distrito'),
(1757, '20', '01', '11', 'LAS LOMAS', 'Distrito'),
(1758, '20', '01', '14', 'TAMBO GRANDE', 'Distrito'),
(1759, '20', '02', '01', 'AYABACA', 'Distrito'),
(1760, '20', '02', '02', 'FRIAS', 'Distrito'),
(1761, '20', '02', '03', 'JILILI', 'Distrito'),
(1762, '20', '02', '04', 'LAGUNAS', 'Distrito'),
(1763, '20', '02', '05', 'MONTERO', 'Distrito'),
(1764, '20', '02', '06', 'PACAIPAMPA', 'Distrito'),
(1765, '20', '02', '07', 'PAIMAS', 'Distrito'),
(1766, '20', '02', '08', 'SAPILLICA', 'Distrito'),
(1767, '20', '02', '09', 'SICCHEZ', 'Distrito'),
(1768, '20', '02', '10', 'SUYO', 'Distrito'),
(1769, '20', '03', '01', 'HUANCABAMBA', 'Distrito'),
(1770, '20', '03', '02', 'CANCHAQUE', 'Distrito'),
(1771, '20', '03', '03', 'EL CARMEN DE LA FRONTERA', 'Distrito'),
(1772, '20', '03', '04', 'HUARMACA', 'Distrito'),
(1773, '20', '03', '05', 'LALAQUIZ', 'Distrito'),
(1774, '20', '03', '06', 'SAN MIGUEL DE EL FAIQUE', 'Distrito'),
(1775, '20', '03', '07', 'SONDOR', 'Distrito'),
(1776, '20', '03', '08', 'SONDORILLO', 'Distrito'),
(1777, '20', '04', '01', 'CHULUCANAS', 'Distrito'),
(1778, '20', '04', '02', 'BUENOS AIRES', 'Distrito'),
(1779, '20', '04', '03', 'CHALACO', 'Distrito'),
(1780, '20', '04', '04', 'LA MATANZA', 'Distrito'),
(1781, '20', '04', '05', 'MORROPON', 'Distrito'),
(1782, '20', '04', '06', 'SALITRAL', 'Distrito'),
(1783, '20', '04', '07', 'SAN JUAN DE BIGOTE', 'Distrito'),
(1784, '20', '04', '08', 'SANTA CATALINA DE MOSSA', 'Distrito'),
(1785, '20', '04', '09', 'SANTO DOMINGO', 'Distrito'),
(1786, '20', '04', '10', 'YAMANGO', 'Distrito'),
(1787, '20', '05', '01', 'PAITA', 'Distrito'),
(1788, '20', '05', '02', 'AMOTAPE', 'Distrito'),
(1789, '20', '05', '03', 'ARENAL', 'Distrito'),
(1790, '20', '05', '04', 'COLAN', 'Distrito'),
(1791, '20', '05', '05', 'LA HUACA', 'Distrito'),
(1792, '20', '05', '06', 'TAMARINDO', 'Distrito'),
(1793, '20', '05', '07', 'VICHAYAL', 'Distrito'),
(1794, '20', '06', '01', 'SULLANA', 'Distrito'),
(1795, '20', '06', '02', 'BELLAVISTA', 'Distrito'),
(1796, '20', '06', '03', 'IGNACIO ESCUDERO', 'Distrito'),
(1797, '20', '06', '04', 'LANCONES', 'Distrito'),
(1798, '20', '06', '05', 'MARCAVELICA', 'Distrito'),
(1799, '20', '06', '06', 'MIGUEL CHECA', 'Distrito'),
(1800, '20', '06', '07', 'QUERECOTILLO', 'Distrito'),
(1801, '20', '06', '08', 'SALITRAL', 'Distrito'),
(1802, '20', '07', '01', 'PARIÃ‘AS', 'Distrito'),
(1803, '20', '07', '02', 'EL ALTO', 'Distrito'),
(1804, '20', '07', '03', 'LA BREA', 'Distrito'),
(1805, '20', '07', '04', 'LOBITOS', 'Distrito'),
(1806, '20', '07', '05', 'LOS ORGANOS', 'Distrito'),
(1807, '20', '07', '06', 'MANCORA', 'Distrito'),
(1808, '20', '08', '01', 'SECHURA', 'Distrito'),
(1809, '20', '08', '02', 'BELLAVISTA DE LA UNION', 'Distrito'),
(1810, '20', '08', '03', 'BERNAL', 'Distrito'),
(1811, '20', '08', '04', 'CRISTO NOS VALGA', 'Distrito'),
(1812, '20', '08', '05', 'VICE', 'Distrito'),
(1813, '20', '08', '06', 'RINCONADA LLICUAR', 'Distrito'),
(1814, '21', '01', '01', 'PUNO', 'Distrito'),
(1815, '21', '01', '02', 'ACORA', 'Distrito'),
(1816, '21', '01', '03', 'AMANTANI', 'Distrito'),
(1817, '21', '01', '04', 'ATUNCOLLA', 'Distrito'),
(1818, '21', '01', '05', 'CAPACHICA', 'Distrito'),
(1819, '21', '01', '06', 'CHUCUITO', 'Distrito'),
(1820, '21', '01', '07', 'COATA', 'Distrito'),
(1821, '21', '01', '08', 'HUATA', 'Distrito'),
(1822, '21', '01', '09', 'MAÃ‘AZO', 'Distrito'),
(1823, '21', '01', '10', 'PAUCARCOLLA', 'Distrito'),
(1824, '21', '01', '11', 'PICHACANI', 'Distrito'),
(1825, '21', '01', '12', 'PLATERIA', 'Distrito'),
(1826, '21', '01', '13', 'SAN ANTONIO  /1', 'Distrito'),
(1827, '21', '01', '14', 'TIQUILLACA', 'Distrito'),
(1828, '21', '01', '15', 'VILQUE', 'Distrito'),
(1829, '21', '02', '01', 'AZANGARO', 'Distrito'),
(1830, '21', '02', '02', 'ACHAYA', 'Distrito'),
(1831, '21', '02', '03', 'ARAPA', 'Distrito'),
(1832, '21', '02', '04', 'ASILLO', 'Distrito'),
(1833, '21', '02', '05', 'CAMINACA', 'Distrito'),
(1834, '21', '02', '06', 'CHUPA', 'Distrito'),
(1835, '21', '02', '07', 'JOSE DOMINGO CHOQUEHUANCA', 'Distrito'),
(1836, '21', '02', '08', 'MUÃ‘ANI', 'Distrito'),
(1837, '21', '02', '09', 'POTONI', 'Distrito'),
(1838, '21', '02', '10', 'SAMAN', 'Distrito'),
(1839, '21', '02', '11', 'SAN ANTON', 'Distrito'),
(1840, '21', '02', '12', 'SAN JOSE', 'Distrito'),
(1841, '21', '02', '13', 'SAN JUAN DE SALINAS', 'Distrito'),
(1842, '21', '02', '14', 'SANTIAGO DE PUPUJA', 'Distrito'),
(1843, '21', '02', '15', 'TIRAPATA', 'Distrito'),
(1844, '21', '03', '01', 'MACUSANI', 'Distrito'),
(1845, '21', '03', '02', 'AJOYANI', 'Distrito'),
(1846, '21', '03', '03', 'AYAPATA', 'Distrito'),
(1847, '21', '03', '04', 'COASA', 'Distrito'),
(1848, '21', '03', '05', 'CORANI', 'Distrito'),
(1849, '21', '03', '06', 'CRUCERO', 'Distrito'),
(1850, '21', '03', '07', 'ITUATA   2/', 'Distrito'),
(1851, '21', '03', '08', 'OLLACHEA', 'Distrito'),
(1852, '21', '03', '09', 'SAN GABAN', 'Distrito'),
(1853, '21', '03', '10', 'USICAYOS', 'Distrito'),
(1854, '21', '04', '01', 'JULI', 'Distrito'),
(1855, '21', '04', '02', 'DESAGUADERO', 'Distrito'),
(1856, '21', '04', '03', 'HUACULLANI', 'Distrito'),
(1857, '21', '04', '04', 'KELLUYO', 'Distrito'),
(1858, '21', '04', '05', 'PISACOMA', 'Distrito'),
(1859, '21', '04', '06', 'POMATA', 'Distrito'),
(1860, '21', '04', '07', 'ZEPITA', 'Distrito'),
(1861, '21', '05', '01', 'ILAVE', 'Distrito'),
(1862, '21', '05', '02', 'CAPAZO', 'Distrito'),
(1863, '21', '05', '03', 'PILCUYO', 'Distrito'),
(1864, '21', '05', '04', 'SANTA ROSA', 'Distrito'),
(1865, '21', '05', '05', 'CONDURIRI', 'Distrito'),
(1866, '21', '06', '01', 'HUANCANE', 'Distrito'),
(1867, '21', '06', '02', 'COJATA', 'Distrito'),
(1868, '21', '06', '03', 'HUATASANI', 'Distrito'),
(1869, '21', '06', '04', 'INCHUPALLA', 'Distrito'),
(1870, '21', '06', '05', 'PUSI', 'Distrito'),
(1871, '21', '06', '06', 'ROSASPATA', 'Distrito'),
(1872, '21', '06', '07', 'TARACO', 'Distrito'),
(1873, '21', '06', '08', 'VILQUE CHICO', 'Distrito'),
(1874, '21', '07', '01', 'LAMPA', 'Distrito'),
(1875, '21', '07', '02', 'CABANILLA', 'Distrito'),
(1876, '21', '07', '03', 'CALAPUJA', 'Distrito'),
(1877, '21', '07', '04', 'NICASIO', 'Distrito'),
(1878, '21', '07', '05', 'OCUVIRI', 'Distrito'),
(1879, '21', '07', '06', 'PALCA', 'Distrito'),
(1880, '21', '07', '07', 'PARATIA', 'Distrito'),
(1881, '21', '07', '08', 'PUCARA', 'Distrito'),
(1882, '21', '07', '09', 'SANTA LUCIA', 'Distrito'),
(1883, '21', '07', '10', 'VILAVILA', 'Distrito'),
(1884, '21', '08', '01', 'AYAVIRI', 'Distrito'),
(1885, '21', '08', '02', 'ANTAUTA', 'Distrito'),
(1886, '21', '08', '03', 'CUPI', 'Distrito'),
(1887, '21', '08', '04', 'LLALLI', 'Distrito'),
(1888, '21', '08', '05', 'MACARI', 'Distrito'),
(1889, '21', '08', '06', 'NUÃ‘OA', 'Distrito'),
(1890, '21', '08', '07', 'ORURILLO', 'Distrito'),
(1891, '21', '08', '08', 'SANTA ROSA', 'Distrito'),
(1892, '21', '08', '09', 'UMACHIRI', 'Distrito'),
(1893, '21', '09', '01', 'MOHO', 'Distrito'),
(1894, '21', '09', '02', 'CONIMA', 'Distrito'),
(1895, '21', '09', '03', 'HUAYRAPATA', 'Distrito'),
(1896, '21', '09', '04', 'TILALI', 'Distrito'),
(1897, '21', '10', '01', 'PUTINA', 'Distrito'),
(1898, '21', '10', '02', 'ANANEA', 'Distrito'),
(1899, '21', '10', '03', 'PEDRO VILCA APAZA', 'Distrito'),
(1900, '21', '10', '04', 'QUILCAPUNCU', 'Distrito'),
(1901, '21', '10', '05', 'SINA', 'Distrito'),
(1902, '21', '11', '01', 'JULIACA', 'Distrito'),
(1903, '21', '11', '02', 'CABANA', 'Distrito'),
(1904, '21', '11', '03', 'CABANILLAS', 'Distrito'),
(1905, '21', '11', '04', 'CARACOTO', 'Distrito'),
(1906, '21', '12', '01', 'SANDIA', 'Distrito'),
(1907, '21', '12', '02', 'CUYOCUYO', 'Distrito'),
(1908, '21', '12', '03', 'LIMBANI', 'Distrito'),
(1909, '21', '12', '04', 'PATAMBUCO', 'Distrito'),
(1910, '21', '12', '05', 'PHARA', 'Distrito'),
(1911, '21', '12', '06', 'QUIACA', 'Distrito'),
(1912, '21', '12', '07', 'SAN JUAN DEL ORO', 'Distrito'),
(1913, '21', '12', '08', 'YANAHUAYA', 'Distrito'),
(1914, '21', '12', '09', 'ALTO INAMBARI', 'Distrito'),
(1915, '21', '12', '10', 'SAN PEDRO DE PUTINA PUNCO', 'Distrito'),
(1916, '21', '13', '01', 'YUNGUYO', 'Distrito'),
(1917, '21', '13', '02', 'ANAPIA', 'Distrito'),
(1918, '21', '13', '03', 'COPANI', 'Distrito'),
(1919, '21', '13', '04', 'CUTURAPI', 'Distrito'),
(1920, '21', '13', '05', 'OLLARAYA', 'Distrito'),
(1921, '21', '13', '06', 'TINICACHI', 'Distrito'),
(1922, '21', '13', '07', 'UNICACHI', 'Distrito'),
(1923, '22', '01', '01', 'MOYOBAMBA', 'Distrito'),
(1924, '22', '01', '02', 'CALZADA', 'Distrito'),
(1925, '22', '01', '03', 'HABANA', 'Distrito'),
(1926, '22', '01', '04', 'JEPELACIO', 'Distrito'),
(1927, '22', '01', '05', 'SORITOR', 'Distrito'),
(1928, '22', '01', '06', 'YANTALO', 'Distrito'),
(1929, '22', '02', '01', 'BELLAVISTA', 'Distrito'),
(1930, '22', '02', '02', 'ALTO BIAVO', 'Distrito'),
(1931, '22', '02', '03', 'BAJO BIAVO', 'Distrito'),
(1932, '22', '02', '04', 'HUALLAGA', 'Distrito'),
(1933, '22', '02', '05', 'SAN PABLO', 'Distrito'),
(1934, '22', '02', '06', 'SAN RAFAEL', 'Distrito'),
(1935, '22', '03', '01', 'SAN JOSE DE SISA', 'Distrito'),
(1936, '22', '03', '02', 'AGUA BLANCA', 'Distrito'),
(1937, '22', '03', '03', 'SAN MARTIN', 'Distrito'),
(1938, '22', '03', '04', 'SANTA ROSA', 'Distrito'),
(1939, '22', '03', '05', 'SHATOJA', 'Distrito'),
(1940, '22', '04', '01', 'SAPOSOA', 'Distrito'),
(1941, '22', '04', '02', 'ALTO SAPOSOA', 'Distrito'),
(1942, '22', '04', '03', 'EL ESLABON', 'Distrito'),
(1943, '22', '04', '04', 'PISCOYACU', 'Distrito'),
(1944, '22', '04', '05', 'SACANCHE', 'Distrito'),
(1945, '22', '04', '06', 'TINGO DE SAPOSOA', 'Distrito'),
(1946, '22', '05', '01', 'LAMAS', 'Distrito'),
(1947, '22', '05', '02', 'ALONSO DE ALVARADO', 'Distrito'),
(1948, '22', '05', '03', 'BARRANQUITA', 'Distrito'),
(1949, '22', '05', '04', 'CAYNARACHI   1/', 'Distrito'),
(1950, '22', '05', '05', 'CUÃ‘UMBUQUI', 'Distrito'),
(1951, '22', '05', '06', 'PINTO RECODO', 'Distrito'),
(1952, '22', '05', '07', 'RUMISAPA', 'Distrito'),
(1953, '22', '05', '08', 'SAN ROQUE DE CUMBAZA', 'Distrito'),
(1954, '22', '05', '09', 'SHANAO', 'Distrito'),
(1955, '22', '05', '10', 'TABALOSOS', 'Distrito'),
(1956, '22', '05', '11', 'ZAPATERO', 'Distrito'),
(1957, '22', '06', '01', 'JUANJUI', 'Distrito'),
(1958, '22', '06', '02', 'CAMPANILLA', 'Distrito'),
(1959, '22', '06', '03', 'HUICUNGO', 'Distrito'),
(1960, '22', '06', '04', 'PACHIZA', 'Distrito'),
(1961, '22', '06', '05', 'PAJARILLO', 'Distrito'),
(1962, '22', '07', '01', 'PICOTA', 'Distrito'),
(1963, '22', '07', '02', 'BUENOS AIRES', 'Distrito'),
(1964, '22', '07', '03', 'CASPISAPA', 'Distrito'),
(1965, '22', '07', '04', 'PILLUANA', 'Distrito'),
(1966, '22', '07', '05', 'PUCACACA', 'Distrito'),
(1967, '22', '07', '06', 'SAN CRISTOBAL', 'Distrito'),
(1968, '22', '07', '07', 'SAN HILARION', 'Distrito'),
(1969, '22', '07', '08', 'SHAMBOYACU', 'Distrito'),
(1970, '22', '07', '09', 'TINGO DE PONASA', 'Distrito'),
(1971, '22', '07', '10', 'TRES UNIDOS', 'Distrito'),
(1972, '22', '08', '01', 'RIOJA', 'Distrito'),
(1973, '22', '08', '02', 'AWAJUN', 'Distrito'),
(1974, '22', '08', '03', 'ELIAS SOPLIN VARGAS', 'Distrito'),
(1975, '22', '08', '04', 'NUEVA CAJAMARCA', 'Distrito'),
(1976, '22', '08', '05', 'PARDO MIGUEL', 'Distrito'),
(1977, '22', '08', '06', 'POSIC', 'Distrito'),
(1978, '22', '08', '07', 'SAN FERNANDO', 'Distrito'),
(1979, '22', '08', '08', 'YORONGOS', 'Distrito'),
(1980, '22', '08', '09', 'YURACYACU', 'Distrito'),
(1981, '22', '09', '01', 'TARAPOTO', 'Distrito'),
(1982, '22', '09', '02', 'ALBERTO LEVEAU', 'Distrito'),
(1983, '22', '09', '03', 'CACATACHI', 'Distrito'),
(1984, '22', '09', '04', 'CHAZUTA', 'Distrito'),
(1985, '22', '09', '05', 'CHIPURANA', 'Distrito'),
(1986, '22', '09', '06', 'EL PORVENIR', 'Distrito'),
(1987, '22', '09', '07', 'HUIMBAYOC', 'Distrito'),
(1988, '22', '09', '08', 'JUAN GUERRA', 'Distrito'),
(1989, '22', '09', '09', 'LA BANDA DE SHILCAYO', 'Distrito'),
(1990, '22', '09', '10', 'MORALES', 'Distrito'),
(1991, '22', '09', '11', 'PAPAPLAYA', 'Distrito'),
(1992, '22', '09', '12', 'SAN ANTONIO', 'Distrito'),
(1993, '22', '09', '13', 'SAUCE', 'Distrito'),
(1994, '22', '09', '14', 'SHAPAJA', 'Distrito'),
(1995, '22', '10', '01', 'TOCACHE', 'Distrito'),
(1996, '22', '10', '02', 'NUEVO PROGRESO', 'Distrito'),
(1997, '22', '10', '03', 'POLVORA', 'Distrito'),
(1998, '22', '10', '04', 'SHUNTE  2/ ', 'Distrito'),
(1999, '22', '10', '05', 'UCHIZA', 'Distrito'),
(2000, '23', '01', '01', 'TACNA', 'Distrito'),
(2001, '23', '01', '02', 'ALTO DE LA ALIANZA', 'Distrito'),
(2002, '23', '01', '03', 'CALANA', 'Distrito'),
(2003, '23', '01', '04', 'CIUDAD NUEVA', 'Distrito'),
(2004, '23', '01', '05', 'INCLAN', 'Distrito'),
(2005, '23', '01', '06', 'PACHIA', 'Distrito'),
(2006, '23', '01', '07', 'PALCA', 'Distrito'),
(2007, '23', '01', '08', 'POCOLLAY', 'Distrito'),
(2008, '23', '01', '09', 'SAMA', 'Distrito'),
(2009, '23', '01', '10', 'CORONEL GREGORIO ALBARRACIN LANCHIPA', 'Distrito'),
(2010, '23', '02', '01', 'CANDARAVE', 'Distrito'),
(2011, '23', '02', '02', 'CAIRANI', 'Distrito'),
(2012, '23', '02', '03', 'CAMILACA', 'Distrito'),
(2013, '23', '02', '04', 'CURIBAYA', 'Distrito'),
(2014, '23', '02', '05', 'HUANUARA', 'Distrito'),
(2015, '23', '02', '06', 'QUILAHUANI', 'Distrito'),
(2016, '23', '03', '01', 'LOCUMBA', 'Distrito'),
(2017, '23', '03', '02', 'ILABAYA', 'Distrito'),
(2018, '23', '03', '03', 'ITE', 'Distrito'),
(2019, '23', '04', '01', 'TARATA', 'Distrito'),
(2020, '23', '04', '02', 'HEROES ALBARRACIN', 'Distrito'),
(2021, '23', '04', '03', 'ESTIQUE', 'Distrito'),
(2022, '23', '04', '04', 'ESTIQUE-PAMPA', 'Distrito'),
(2023, '23', '04', '05', 'SITAJARA', 'Distrito'),
(2024, '23', '04', '06', 'SUSAPAYA', 'Distrito'),
(2025, '23', '04', '07', 'TARUCACHI', 'Distrito'),
(2026, '23', '04', '08', 'TICACO', 'Distrito'),
(2027, '24', '01', '01', 'TUMBES', 'Distrito'),
(2028, '24', '01', '02', 'CORRALES', 'Distrito'),
(2029, '24', '01', '03', 'LA CRUZ', 'Distrito'),
(2030, '24', '01', '04', 'PAMPAS DE HOSPITAL', 'Distrito'),
(2031, '24', '01', '05', 'SAN JACINTO', 'Distrito'),
(2032, '24', '01', '06', 'SAN JUAN DE LA VIRGEN', 'Distrito'),
(2033, '24', '02', '01', 'ZORRITOS', 'Distrito'),
(2034, '24', '02', '02', 'CASITAS', 'Distrito'),
(2035, '24', '02', '03', 'CANOAS DE PUNTA SAL', 'Distrito'),
(2036, '24', '03', '01', 'ZARUMILLA', 'Distrito'),
(2037, '24', '03', '02', 'AGUAS VERDES', 'Distrito'),
(2038, '24', '03', '03', 'MATAPALO', 'Distrito'),
(2039, '24', '03', '04', 'PAPAYAL', 'Distrito'),
(2040, '25', '01', '01', 'CALLERIA', 'Distrito'),
(2041, '25', '01', '02', 'CAMPOVERDE', 'Distrito'),
(2042, '25', '01', '03', 'IPARIA', 'Distrito'),
(2043, '25', '01', '04', 'MASISEA', 'Distrito');
INSERT INTO `cs_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(2044, '25', '01', '05', 'YARINACOCHA', 'Distrito'),
(2045, '25', '01', '06', 'NUEVA REQUENA', 'Distrito'),
(2046, '25', '01', '07', 'MANANTAY', 'Distrito'),
(2047, '25', '02', '01', 'RAYMONDI', 'Distrito'),
(2048, '25', '02', '02', 'SEPAHUA', 'Distrito'),
(2049, '25', '02', '03', 'TAHUANIA', 'Distrito'),
(2050, '25', '02', '04', 'YURUA', 'Distrito'),
(2051, '25', '03', '01', 'PADRE ABAD', 'Distrito'),
(2052, '25', '03', '02', 'IRAZOLA', 'Distrito'),
(2053, '25', '03', '03', 'CURIMANA', 'Distrito'),
(2054, '25', '04', '01', 'PURUS', 'Distrito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_almacen`
--

CREATE TABLE `tb_almacen` (
  `tb_almacen_id` int(11) NOT NULL,
  `tb_almacen_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_almacen_ven` tinyint(4) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_almacen`
--

INSERT INTO `tb_almacen` (`tb_almacen_id`, `tb_almacen_nom`, `tb_almacen_ven`, `tb_empresa_id`) VALUES
(1, 'ALMACEN 1', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_asiento`
--

CREATE TABLE `tb_asiento` (
  `tb_asiento_id` int(11) NOT NULL,
  `tb_asiento_nom` int(50) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_asiento`
--

INSERT INTO `tb_asiento` (`tb_asiento_id`, `tb_asiento_nom`, `tb_empresa_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1),
(42, 42, 1),
(43, 43, 1),
(44, 44, 1),
(45, 45, 1),
(46, 46, 1),
(47, 47, 1),
(48, 48, 1),
(49, 49, 1),
(50, 50, 1),
(51, 51, 1),
(52, 52, 1),
(53, 53, 1),
(54, 54, 1),
(55, 55, 1),
(56, 56, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_asientoestado`
--

CREATE TABLE `tb_asientoestado` (
  `tb_asientoestado_id` int(11) NOT NULL,
  `tb_asiento_id` int(11) NOT NULL,
  `tb_viajehorario_id` int(11) NOT NULL,
  `tb_asientoestado_estado` tinyint(1) NOT NULL,
  `tb_destpar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_asientoestado`
--

INSERT INTO `tb_asientoestado` (`tb_asientoestado_id`, `tb_asiento_id`, `tb_viajehorario_id`, `tb_asientoestado_estado`, `tb_destpar_id`) VALUES
(63, 24, 13, 1, 3),
(64, 45, 13, 1, 2),
(65, 23, 13, 1, 1),
(66, 1, 13, 1, 0),
(67, 22, 14, 1, 0),
(68, 49, 13, 1, 0),
(69, 23, 15, 1, 0),
(70, 39, 13, 1, 3),
(71, 14, 13, 1, 0),
(72, 6, 13, 1, 0),
(73, 3, 13, 1, 0),
(74, 4, 13, 1, 2),
(75, 26, 13, 1, 4),
(76, 27, 26, 1, 2),
(77, 18, 26, 1, 4),
(78, 15, 26, 1, 3),
(79, 35, 23, 1, 2),
(80, 2, 26, 1, 2),
(81, 4, 26, 1, 2),
(82, 2, 28, 1, 4),
(83, 6, 28, 1, 2),
(84, 1, 28, 1, 3),
(85, 3, 26, 1, 2),
(86, 1, 26, 1, 4),
(87, 2, 36, 1, 3),
(88, 3, 36, 1, 3),
(89, 2, 38, 1, 4),
(90, 6, 38, 1, 4),
(91, 30, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_caja`
--

CREATE TABLE `tb_caja` (
  `tb_caja_id` int(11) NOT NULL,
  `tb_caja_xac` tinyint(4) NOT NULL,
  `tb_caja_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_caja_tip` int(11) NOT NULL,
  `tb_caja_estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_caja`
--

INSERT INTO `tb_caja` (`tb_caja_id`, `tb_caja_xac`, `tb_caja_nom`, `tb_caja_tip`, `tb_caja_estado`) VALUES
(1, 1, 'CAJA', 1, 1),
(2, 1, 'CAJA2', 1, 0),
(3, 1, 'CAJA3', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cajadetalle`
--

CREATE TABLE `tb_cajadetalle` (
  `tb_cajadetalle_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_caja_apertura` datetime NOT NULL,
  `tb_caja_cierre` datetime DEFAULT NULL,
  `tb_caja_inicial` decimal(8,2) NOT NULL,
  `tb_caja_estado` tinyint(4) NOT NULL,
  `tb_caja_final` decimal(8,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tb_cajadetalle`
--

INSERT INTO `tb_cajadetalle` (`tb_cajadetalle_id`, `tb_caja_id`, `tb_caja_apertura`, `tb_caja_cierre`, `tb_caja_inicial`, `tb_caja_estado`, `tb_caja_final`) VALUES
(1, 1, '2019-01-30 20:47:00', '2019-01-30 17:11:00', '10.00', 0, '0.00'),
(2, 1, '2019-01-30 17:11:00', '0000-00-00 00:00:00', '0.00', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cajaobs`
--

CREATE TABLE `tb_cajaobs` (
  `tb_cajaobs_id` int(11) NOT NULL,
  `tb_cajaobs_fecreg` datetime NOT NULL,
  `tb_cajaobs_fecmod` datetime NOT NULL,
  `tb_cajaobs_usureg` int(11) NOT NULL,
  `tb_cajaobs_usumod` int(11) NOT NULL,
  `tb_cajaobs_xac` tinyint(1) NOT NULL,
  `tb_cajaobs_fec` date NOT NULL,
  `tb_cajaobs_det` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_cajaobs_est` tinyint(1) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_caja_r`
--

CREATE TABLE `tb_caja_r` (
  `tb_caja_id` int(11) NOT NULL,
  `tb_caja_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_caja_r`
--

INSERT INTO `tb_caja_r` (`tb_caja_id`, `tb_caja_nom`) VALUES
(1, 'TERCERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_catalogo`
--

CREATE TABLE `tb_catalogo` (
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_catalogo_reg` datetime NOT NULL,
  `tb_catalogo_mod` datetime NOT NULL,
  `tb_unidad_id_bas` int(11) NOT NULL,
  `tb_unidad_id_equ` int(11) NOT NULL,
  `tb_catalogo_mul` decimal(6,2) NOT NULL,
  `tb_catalogo_tipcam` decimal(4,3) NOT NULL,
  `tb_catalogo_precosdol` decimal(8,2) NOT NULL,
  `tb_catalogo_preunicom` decimal(8,2) NOT NULL,
  `tb_catalogo_precos` decimal(8,2) NOT NULL,
  `tb_catalogo_uti` decimal(4,2) NOT NULL,
  `tb_catalogo_preven` decimal(8,2) NOT NULL,
  `tb_catalogo_vercom` tinyint(4) NOT NULL,
  `tb_catalogo_verven` tinyint(4) NOT NULL,
  `tb_catalogo_igvcom` tinyint(4) NOT NULL,
  `tb_catalogo_igvven` tinyint(4) NOT NULL,
  `tb_catalogo_est` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_catalogo_unibas` tinyint(4) NOT NULL,
  `tb_presentacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_catalogo`
--

INSERT INTO `tb_catalogo` (`tb_catalogo_id`, `tb_catalogo_reg`, `tb_catalogo_mod`, `tb_unidad_id_bas`, `tb_unidad_id_equ`, `tb_catalogo_mul`, `tb_catalogo_tipcam`, `tb_catalogo_precosdol`, `tb_catalogo_preunicom`, `tb_catalogo_precos`, `tb_catalogo_uti`, `tb_catalogo_preven`, `tb_catalogo_vercom`, `tb_catalogo_verven`, `tb_catalogo_igvcom`, `tb_catalogo_igvven`, `tb_catalogo_est`, `tb_catalogo_unibas`, `tb_presentacion_id`) VALUES
(552, '2019-01-04 21:29:33', '2019-01-04 21:29:33', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 550),
(553, '2019-01-04 21:29:53', '2019-01-04 21:29:53', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 551),
(554, '2019-01-04 21:30:06', '2019-01-04 21:30:06', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 552),
(555, '2019-01-04 21:30:23', '2019-01-04 21:30:23', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 553),
(556, '2019-01-04 21:30:37', '2019-01-04 21:30:37', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 554),
(557, '2019-01-04 21:30:50', '2019-01-04 21:30:50', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 555),
(558, '2019-01-04 21:31:09', '2019-01-04 21:31:09', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 556),
(559, '2019-01-04 21:31:26', '2019-01-04 21:31:26', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 557),
(560, '2019-01-04 21:31:41', '2019-01-04 21:31:41', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 558),
(561, '2019-01-04 21:31:56', '2019-01-04 21:31:56', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 559),
(562, '2019-01-05 18:57:42', '2019-01-05 18:57:42', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 560),
(563, '2019-01-05 18:58:06', '2019-01-05 18:58:06', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 561),
(564, '2019-01-05 18:59:19', '2019-01-05 18:59:19', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '25.00', 1, 1, 0, 0, 'Activo', 1, 562),
(565, '2019-01-05 19:14:58', '2019-01-05 19:14:58', 1, 1, '1.00', '0.000', '0.00', '0.00', '0.00', '0.00', '50.00', 1, 1, 0, 0, 'Activo', 1, 563);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_catalogoimagen`
--

CREATE TABLE `tb_catalogoimagen` (
  `tb_catalogoimagen_id` int(11) NOT NULL,
  `tb_catalogoimagen_tit` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_catalogoimagen_des` tinytext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_catalogoimagendetalle`
--

CREATE TABLE `tb_catalogoimagendetalle` (
  `tb_catalogoimagendetalle_id` int(11) NOT NULL,
  `tb_catalogoimagen_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_catalogoimagenfile`
--

CREATE TABLE `tb_catalogoimagenfile` (
  `tb_catalogoimagenfile_id` int(11) NOT NULL,
  `tb_catalogoimagen_id` int(11) NOT NULL,
  `tb_catalogoimagenfile_url` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_catalogo_cop21ene`
--

CREATE TABLE `tb_catalogo_cop21ene` (
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_catalogo_reg` datetime NOT NULL,
  `tb_catalogo_mod` datetime NOT NULL,
  `tb_unidad_id_bas` int(11) NOT NULL,
  `tb_unidad_id_equ` int(11) NOT NULL,
  `tb_catalogo_mul` decimal(6,2) NOT NULL,
  `tb_catalogo_tipcam` decimal(4,3) NOT NULL,
  `tb_catalogo_precosdol` decimal(8,2) NOT NULL,
  `tb_catalogo_preunicom` decimal(8,2) NOT NULL,
  `tb_catalogo_precos` decimal(8,2) NOT NULL,
  `tb_catalogo_uti` decimal(4,2) NOT NULL,
  `tb_catalogo_preven` decimal(8,2) NOT NULL,
  `tb_catalogo_vercom` tinyint(4) NOT NULL,
  `tb_catalogo_verven` tinyint(4) NOT NULL,
  `tb_catalogo_igvcom` tinyint(4) NOT NULL,
  `tb_catalogo_igvven` tinyint(4) NOT NULL,
  `tb_catalogo_est` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_catalogo_unibas` tinyint(4) NOT NULL,
  `tb_presentacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `tb_categoria_id` int(11) NOT NULL,
  `tb_categoria_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_categoria_idp` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL COMMENT 'campo para filtrar por empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_categoria`
--

INSERT INTO `tb_categoria` (`tb_categoria_id`, `tb_categoria_nom`, `tb_categoria_idp`, `tb_empresa_id`) VALUES
(1, 'NA', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `tb_cliente_id` int(11) NOT NULL,
  `tb_cliente_tip` tinyint(4) NOT NULL,
  `tb_cliente_doc` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_nom` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_dir` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_con` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_tel` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_est` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_precio_id` int(11) NOT NULL,
  `tb_cliente_retiene` int(1) NOT NULL,
  `tb_cliente_cui` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_cliente`
--

INSERT INTO `tb_cliente` (`tb_cliente_id`, `tb_cliente_tip`, `tb_cliente_doc`, `tb_cliente_nom`, `tb_cliente_dir`, `tb_cliente_con`, `tb_cliente_tel`, `tb_cliente_ema`, `tb_cliente_est`, `tb_empresa_id`, `tb_precio_id`, `tb_cliente_retiene`, `tb_cliente_cui`) VALUES
(1, 1, '45513063', 'JHEISON', 'LAS CASUAR', '', '', 'jheisonx@hotmail.com', '', 0, 0, 2, 0),
(2, 1, '29522919', 'ALD', 'CASUA', 'CASUA', '426857', '', '', 0, 0, 0, 0),
(3, 1, '45513067', 'HINOJOSA HUAMANI DELIA', '', '', '', '', '', 0, 0, 0, 0),
(4, 1, '20592919', 'MAMANI DE RAMOS ROSA', '', '', '', '', '', 0, 0, 0, 0),
(5, 1, '20592999', 'HUARINGA QUISPE DE RIVERA ANTONIA', '', '', '', '', '', 0, 0, 0, 0),
(6, 1, '29522920', 'DEL CARPIO DEL CARPIO JORGE RAUL', '', '', '', '', '', 0, 0, 0, 0),
(7, 1, '47092856', 'CHACCA KANA DONAL', '', '', '', '', '', 0, 0, 0, 0),
(8, 2, '20601411076', 'NUEVA EMPRESA', 'NUEVA EMPRESA', '', '', '', '', 0, 0, 0, 0),
(9, 1, '45513064', 'LAURA HUALLPA ALEX LEONARDO', '', '', '', '', '', 0, 0, 0, 0),
(10, 1, '47558106', 'SONCCO PANCA MARLENY', '', '', '', '', '', 0, 0, 0, 0),
(11, 1, '78878767', 'ADRIANA JAZMIN', '', '', '', '', '', 0, 0, 0, 0),
(12, 1, '47097867', 'LOPEZ DIONICIO NESTOR HEDMUNDO', '', '', '', '', '', 0, 0, 0, 0),
(13, 1, '48987656', 'LLONTOP MORALES BRIGHIT SAYURI', '', '', '', '', '', 0, 0, 0, 0),
(14, 1, '47365878', 'VERA RAMOS FIORELLA KIMBERLY', '', '', '', '', '', 0, 0, 0, 0),
(15, 1, '47652598', 'GAMARRA VICOS ADRIANA FIORELLA', '', '', '', '', '', 0, 0, 0, 0),
(16, 1, '44992750', 'DELGADO LOZANO JAIRO', '', '', '', '', '', 0, 0, 0, 0),
(17, 1, '74063420', 'MEDINA MUÃ‘OZ ORFA SADITH', '', '', '', '', '', 0, 0, 0, 0),
(18, 2, '20542350548', 'ADMICONTA ABC E.I.R.L.', 'JR. MANUEL DEL AGUILA NRO. 474 (AL COSTADO COLEGIO GERMAN TEJADA VELA) SAN MARTIN - MOYOBAMBA - MOYOBAMBA', 'DELGADO LOZANO JAIRO', '', '', 'ACTIVO', 0, 0, 0, 0),
(19, 1, '47586526', 'SILVA FERNANDEZ PEDRO PABLO', '', '', '', '', '', 0, 0, 0, 0),
(20, 1, '45695856', 'LEON RAMIRES CELINDA', '', '', '', '', '', 0, 0, 0, 0),
(21, 1, '45685624', 'NAIRA RAMIREZ LUISA YONALI', '', '', '', '', '', 0, 0, 0, 0),
(22, 1, '47265845', 'HUAPAYA MALLQUI JEYMMY PERCY', '', '', '', '', '', 0, 0, 0, 0),
(23, 1, '47356859', 'ZAVALETA CASTRO BENJAMIN GUSTAVO', '', '', '', '', '', 0, 0, 0, 0),
(24, 1, '47265865', 'SAHUARAURA AUCCAPUMA NELSON', '', '', '', '', '', 0, 0, 0, 0),
(25, 1, '45065624', 'NAVARRO JUAREZ DIANA ELIZABETH', '', '', '', '', '', 0, 0, 0, 0),
(26, 1, '47585625', 'GERONIMO TORRES KELIN KELVIS', '', '', '', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_clientecuenta`
--

CREATE TABLE `tb_clientecuenta` (
  `tb_clientecuenta_id` int(11) NOT NULL,
  `tb_clientecuenta_fecreg` datetime NOT NULL,
  `tb_clientecuenta_xac` tinyint(4) NOT NULL,
  `tb_clientecuenta_tipreg` tinyint(2) NOT NULL COMMENT '1 auto 2 manual',
  `tb_clientecuenta_fec` date NOT NULL,
  `tb_clientecuenta_glo` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa',
  `tb_clientecuenta_tip` tinyint(4) NOT NULL COMMENT '1:Entrada; 2: Salida',
  `tb_clientecuenta_mon` decimal(8,2) NOT NULL COMMENT 'Monto',
  `tb_clientecuenta_est` tinyint(4) NOT NULL COMMENT '1:Cancelado; 2:Sin Cancelar; 3: Pago_Parcial; 4: Abonado',
  `tb_clientecuenta_ventip` tinyint(4) NOT NULL COMMENT '1venta 2notaventa',
  `tb_clientecuenta_ven_id` int(11) NOT NULL,
  `tb_formapago_id` int(11) NOT NULL,
  `tb_modopago_id` int(11) NOT NULL,
  `tb_cuentacorriente_id` int(11) NOT NULL,
  `tb_tarjeta_id` int(11) NOT NULL,
  `tb_clientecuenta_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_clientecuenta_numdia` int(11) NOT NULL,
  `tb_clientecuenta_fecven` date NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_clientecuenta_ver` tinyint(4) NOT NULL COMMENT '1:Verificado; 2:Por_Verificar',
  `tb_clientecuenta_idp` int(11) NOT NULL COMMENT 'id padre',
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_clientecuenta`
--

INSERT INTO `tb_clientecuenta` (`tb_clientecuenta_id`, `tb_clientecuenta_fecreg`, `tb_clientecuenta_xac`, `tb_clientecuenta_tipreg`, `tb_clientecuenta_fec`, `tb_clientecuenta_glo`, `tb_clientecuenta_tip`, `tb_clientecuenta_mon`, `tb_clientecuenta_est`, `tb_clientecuenta_ventip`, `tb_clientecuenta_ven_id`, `tb_formapago_id`, `tb_modopago_id`, `tb_cuentacorriente_id`, `tb_tarjeta_id`, `tb_clientecuenta_numope`, `tb_clientecuenta_numdia`, `tb_clientecuenta_fecven`, `tb_cliente_id`, `tb_clientecuenta_ver`, `tb_clientecuenta_idp`, `tb_usuario_id`, `tb_empresa_id`) VALUES
(1, '2019-01-12 13:26:44', 1, 1, '2019-01-12', 'VENTA CONTADO EFECTIVO | BE B001-0426', 1, '30.00', 1, 1, 1, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(2, '2019-01-12 13:26:44', 1, 1, '2019-01-12', 'PAGO CONTADO EFECTIVO | BE B001-0426', 2, '30.00', 0, 1, 1, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 1, 1, 1),
(3, '2019-01-13 20:42:50', 1, 1, '2019-01-13', 'VENTA CONTADO EFECTIVO | BE B001-0431', 1, '50.00', 1, 1, 6, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(4, '2019-01-13 20:42:50', 1, 1, '2019-01-13', 'PAGO CONTADO EFECTIVO | BE B001-0431', 2, '50.00', 0, 1, 6, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 3, 1, 1),
(5, '2019-01-13 20:46:17', 1, 1, '2019-01-13', 'VENTA CONTADO EFECTIVO | BE B001-0432', 1, '20.00', 1, 1, 7, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(6, '2019-01-13 20:46:17', 1, 1, '2019-01-13', 'PAGO CONTADO EFECTIVO | BE B001-0432', 2, '20.00', 0, 1, 7, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 5, 1, 1),
(7, '2019-01-14 18:21:17', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0433', 1, '23.00', 1, 1, 8, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(8, '2019-01-14 18:21:17', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0433', 2, '23.00', 0, 1, 8, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 7, 1, 1),
(9, '2019-01-14 18:25:41', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0434', 1, '32.00', 1, 1, 9, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(10, '2019-01-14 18:25:41', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0434', 2, '32.00', 0, 1, 9, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 9, 1, 1),
(11, '2019-01-14 19:32:20', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0439', 1, '45.00', 1, 1, 14, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(12, '2019-01-14 19:32:20', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0439', 2, '45.00', 0, 1, 14, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 11, 1, 1),
(13, '2019-01-14 19:39:04', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0440', 1, '50.00', 1, 1, 15, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(14, '2019-01-14 19:39:04', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0440', 2, '50.00', 0, 1, 15, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 13, 1, 1),
(15, '2019-01-14 19:46:53', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0441', 1, '45.00', 1, 1, 16, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(16, '2019-01-14 19:46:53', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0441', 2, '45.00', 0, 1, 16, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 15, 1, 1),
(17, '2019-01-14 19:59:37', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0442', 1, '25.00', 1, 1, 17, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(18, '2019-01-14 19:59:38', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0442', 2, '25.00', 0, 1, 17, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 17, 1, 1),
(19, '2019-01-14 20:07:54', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0443', 1, '50.00', 1, 1, 18, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(20, '2019-01-14 20:07:54', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0443', 2, '50.00', 0, 1, 18, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 19, 1, 1),
(21, '2019-01-14 20:10:33', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0444', 1, '50.00', 1, 1, 19, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(22, '2019-01-14 20:10:33', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0444', 2, '50.00', 0, 1, 19, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 21, 1, 1),
(23, '2019-01-14 20:13:28', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0445', 1, '40.00', 1, 1, 20, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(24, '2019-01-14 20:13:28', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0445', 2, '40.00', 0, 1, 20, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 23, 1, 1),
(25, '2019-01-14 20:14:05', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0446', 1, '10.00', 1, 1, 21, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(26, '2019-01-14 20:14:05', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0446', 2, '10.00', 0, 1, 21, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 25, 1, 1),
(27, '2019-01-14 20:21:33', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0447', 1, '25.00', 1, 1, 22, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(28, '2019-01-14 20:21:33', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0447', 2, '25.00', 0, 1, 22, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 27, 1, 1),
(29, '2019-01-14 20:24:14', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0448', 1, '52.00', 1, 1, 23, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(30, '2019-01-14 20:24:14', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0448', 2, '52.00', 0, 1, 23, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 29, 1, 1),
(31, '2019-01-14 20:27:36', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0449', 1, '40.00', 1, 1, 24, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(32, '2019-01-14 20:27:36', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0449', 2, '40.00', 0, 1, 24, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 31, 1, 1),
(33, '2019-01-14 20:34:55', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0450', 1, '40.00', 1, 1, 25, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(34, '2019-01-14 20:34:55', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0450', 2, '40.00', 0, 1, 25, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 33, 1, 1),
(35, '2019-01-15 10:37:33', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0451', 1, '22.00', 1, 1, 26, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(36, '2019-01-15 10:37:33', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0451', 2, '22.00', 0, 1, 26, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 35, 1, 1),
(37, '2019-01-15 10:47:28', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0452', 1, '24.00', 1, 1, 27, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(38, '2019-01-15 10:47:28', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0452', 2, '24.00', 0, 1, 27, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 37, 1, 1),
(39, '2019-01-15 10:49:24', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0453', 1, '40.00', 1, 1, 28, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(40, '2019-01-15 10:49:24', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0453', 2, '40.00', 0, 1, 28, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 39, 1, 1),
(41, '2019-01-15 10:52:15', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0454', 1, '34.00', 1, 1, 29, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(42, '2019-01-15 10:52:15', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0454', 2, '34.00', 0, 1, 29, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 41, 1, 1),
(43, '2019-01-15 10:56:18', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0455', 1, '23.00', 1, 1, 30, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(44, '2019-01-15 10:56:18', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0455', 2, '23.00', 0, 1, 30, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 43, 1, 1),
(45, '2019-01-14 11:12:48', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0456', 1, '47.00', 1, 1, 31, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(46, '2019-01-14 11:12:48', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0456', 2, '47.00', 0, 1, 31, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 45, 1, 1),
(47, '2019-01-14 11:13:30', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0457', 1, '47.00', 1, 1, 32, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(48, '2019-01-14 11:13:30', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0457', 2, '47.00', 0, 1, 32, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 47, 1, 1),
(49, '2019-01-14 11:14:48', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0458', 1, '40.00', 1, 1, 33, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(50, '2019-01-14 11:14:48', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0458', 2, '40.00', 0, 1, 33, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 49, 1, 1),
(51, '2019-01-14 11:17:55', 1, 1, '2019-01-14', 'VENTA CONTADO EFECTIVO | BE B001-0459', 1, '50.00', 1, 1, 34, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(52, '2019-01-14 11:17:55', 1, 1, '2019-01-14', 'PAGO CONTADO EFECTIVO | BE B001-0459', 2, '50.00', 0, 1, 34, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 51, 1, 1),
(53, '2019-01-15 11:21:55', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0460', 1, '20.00', 1, 1, 35, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(54, '2019-01-15 11:21:55', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0460', 2, '20.00', 0, 1, 35, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 53, 1, 1),
(55, '2019-01-15 11:23:39', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0461', 1, '23.00', 1, 1, 36, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(56, '2019-01-15 11:23:39', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0461', 2, '23.00', 0, 1, 36, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 55, 1, 1),
(57, '2019-01-15 11:24:28', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0462', 1, '23.00', 1, 1, 37, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(58, '2019-01-15 11:24:28', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0462', 2, '23.00', 0, 1, 37, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 57, 1, 1),
(59, '2019-01-15 11:26:31', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0463', 1, '23.00', 1, 1, 38, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(60, '2019-01-15 11:26:31', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0463', 2, '23.00', 0, 1, 38, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 59, 1, 1),
(61, '2019-01-15 11:30:27', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0464', 1, '34.00', 1, 1, 39, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(62, '2019-01-15 11:30:27', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0464', 2, '34.00', 0, 1, 39, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 61, 1, 1),
(63, '2019-01-15 13:07:26', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0465', 1, '22.00', 1, 1, 40, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(64, '2019-01-15 13:07:26', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0465', 2, '22.00', 0, 1, 40, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 63, 1, 1),
(65, '2019-01-15 13:15:19', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0466', 1, '33.00', 1, 1, 41, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(66, '2019-01-15 13:15:19', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0466', 2, '33.00', 0, 1, 41, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 65, 1, 1),
(67, '2019-01-15 13:28:42', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0467', 1, '33.00', 1, 1, 42, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(68, '2019-01-15 13:28:42', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0467', 2, '33.00', 0, 1, 42, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 67, 1, 1),
(69, '2019-01-15 15:32:08', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0468', 1, '22.00', 1, 1, 43, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(70, '2019-01-15 15:32:08', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0468', 2, '22.00', 0, 1, 43, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 69, 1, 1),
(71, '2019-01-15 15:43:24', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0469', 1, '23.00', 1, 1, 44, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(72, '2019-01-15 15:43:25', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0469', 2, '23.00', 0, 1, 44, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 71, 1, 1),
(73, '2019-01-15 15:59:23', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0470', 1, '23.00', 1, 1, 45, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(74, '2019-01-15 15:59:23', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0470', 2, '23.00', 0, 1, 45, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 73, 1, 1),
(75, '2019-01-15 15:59:56', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0471', 1, '23.00', 1, 1, 46, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(76, '2019-01-15 15:59:56', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0471', 2, '23.00', 0, 1, 46, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 75, 1, 1),
(77, '2019-01-15 16:00:11', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0472', 1, '23.00', 1, 1, 47, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(78, '2019-01-15 16:00:11', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0472', 2, '23.00', 0, 1, 47, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 77, 1, 1),
(79, '2019-01-15 17:08:52', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0473', 1, '23.00', 1, 1, 48, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(80, '2019-01-15 17:08:52', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0473', 2, '23.00', 0, 1, 48, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 79, 1, 1),
(81, '2019-01-15 18:50:48', 1, 1, '2019-01-15', 'VENTA CONTADO EFECTIVO | BE B001-0474', 1, '45.00', 1, 1, 49, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(82, '2019-01-15 18:50:48', 1, 1, '2019-01-15', 'PAGO CONTADO EFECTIVO | BE B001-0474', 2, '45.00', 0, 1, 49, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 81, 1, 1),
(83, '2019-01-16 15:01:00', 1, 1, '2019-01-16', 'VENTA CONTADO EFECTIVO | BE B001-0475', 1, '22.00', 1, 1, 50, 1, 1, 0, 0, '', 0, '0000-00-00', 6, 1, 0, 1, 1),
(84, '2019-01-16 15:01:01', 1, 1, '2019-01-16', 'PAGO CONTADO EFECTIVO | BE B001-0475', 2, '22.00', 0, 1, 50, 1, 1, 0, 0, '', 0, '0000-00-00', 6, 1, 83, 1, 1),
(85, '2019-01-16 18:49:44', 1, 1, '2019-01-16', 'VENTA CONTADO EFECTIVO | FE F001-00065', 1, '33.00', 1, 1, 51, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(86, '2019-01-16 18:49:44', 1, 1, '2019-01-16', 'PAGO CONTADO EFECTIVO | FE F001-00065', 2, '33.00', 0, 1, 51, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 85, 1, 1),
(87, '2019-01-16 19:05:51', 1, 1, '2019-01-16', 'VENTA CONTADO EFECTIVO | BE B001-0476', 1, '54.00', 1, 1, 52, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(88, '2019-01-16 19:05:51', 1, 1, '2019-01-16', 'PAGO CONTADO EFECTIVO | BE B001-0476', 2, '54.00', 0, 1, 52, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 87, 1, 1),
(89, '2019-01-17 13:16:11', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0477', 1, '10.00', 1, 1, 53, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(90, '2019-01-17 13:16:11', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0477', 2, '10.00', 0, 1, 53, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 89, 1, 1),
(91, '2019-01-17 13:17:57', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0478', 1, '10.00', 1, 1, 54, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(92, '2019-01-17 13:17:57', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0478', 2, '10.00', 0, 1, 54, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 91, 1, 1),
(93, '2019-01-17 13:19:55', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0479', 1, '10.00', 1, 1, 55, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(94, '2019-01-17 13:19:55', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0479', 2, '10.00', 0, 1, 55, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 93, 1, 1),
(95, '2019-01-17 13:29:04', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | FE F001-00066', 1, '10.00', 1, 1, 56, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(96, '2019-01-17 13:29:04', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | FE F001-00066', 2, '10.00', 0, 1, 56, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 95, 1, 1),
(97, '2019-01-17 17:27:32', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0480', 1, '20.00', 1, 1, 57, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(98, '2019-01-17 17:27:32', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0480', 2, '20.00', 0, 1, 57, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 97, 1, 1),
(99, '2019-01-17 19:40:23', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0481', 1, '40.00', 1, 1, 58, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(100, '2019-01-17 19:40:24', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0481', 2, '40.00', 0, 1, 58, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 99, 1, 1),
(101, '2019-01-17 19:53:04', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | FE F001-00067', 1, '40.00', 1, 1, 59, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(102, '2019-01-17 19:53:04', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | FE F001-00067', 2, '40.00', 0, 1, 59, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 101, 1, 1),
(103, '2019-01-17 19:59:53', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | FE F001-00068', 1, '106.20', 1, 1, 60, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(104, '2019-01-17 19:59:54', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | FE F001-00068', 2, '106.20', 0, 1, 60, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 103, 1, 1),
(105, '2019-01-17 21:12:34', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0101', 1, '30.00', 1, 1, 61, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(106, '2019-01-17 21:12:34', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0101', 2, '30.00', 0, 1, 61, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 105, 1, 1),
(107, '2019-01-17 21:18:35', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0102', 1, '60.00', 1, 1, 62, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(108, '2019-01-17 21:18:35', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0102', 2, '60.00', 0, 1, 62, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 107, 1, 1),
(109, '2019-01-17 21:24:18', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0103', 1, '45.00', 1, 1, 63, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(110, '2019-01-17 21:24:18', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0103', 2, '45.00', 0, 1, 63, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 109, 1, 1),
(111, '2019-01-17 21:38:00', 1, 1, '2019-01-17', 'VENTA CONTADO EFECTIVO | BE B001-0104', 1, '180.00', 1, 1, 64, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(112, '2019-01-17 21:38:00', 1, 1, '2019-01-17', 'PAGO CONTADO EFECTIVO | BE B001-0104', 2, '180.00', 0, 1, 64, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 111, 1, 1),
(113, '2019-01-18 13:26:08', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0482', 1, '34.00', 1, 1, 65, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(114, '2019-01-18 13:26:08', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0482', 2, '34.00', 0, 1, 65, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 113, 1, 1),
(115, '2019-01-18 14:50:43', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0483', 1, '22.00', 1, 1, 66, 1, 1, 0, 0, '', 0, '0000-00-00', 9, 1, 0, 1, 1),
(116, '2019-01-18 14:50:43', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0483', 2, '22.00', 0, 1, 66, 1, 1, 0, 0, '', 0, '0000-00-00', 9, 1, 115, 1, 1),
(117, '2019-01-18 14:51:28', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | FE F001-00069', 1, '22.00', 1, 1, 67, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(118, '2019-01-18 14:51:28', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | FE F001-00069', 2, '22.00', 0, 1, 67, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 117, 1, 1),
(119, '2019-01-18 14:52:47', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0484', 1, '58.00', 1, 1, 68, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(120, '2019-01-18 14:52:47', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0484', 2, '58.00', 0, 1, 68, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 119, 1, 1),
(121, '2019-01-18 15:01:19', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0485', 1, '22.00', 1, 1, 69, 1, 1, 0, 0, '', 0, '0000-00-00', 9, 1, 0, 1, 1),
(122, '2019-01-18 15:01:19', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0485', 2, '22.00', 0, 1, 69, 1, 1, 0, 0, '', 0, '0000-00-00', 9, 1, 121, 1, 1),
(123, '2019-01-18 15:02:43', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | FE F001-00070', 1, '22.00', 1, 1, 70, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(124, '2019-01-18 15:02:43', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | FE F001-00070', 2, '22.00', 0, 1, 70, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 123, 1, 1),
(125, '2019-01-18 15:17:11', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0486', 1, '20.00', 1, 1, 71, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(126, '2019-01-18 15:17:11', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0486', 2, '20.00', 0, 1, 71, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 125, 1, 1),
(127, '2019-01-18 15:18:50', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | FE F001-00071', 1, '30.00', 1, 1, 72, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(128, '2019-01-18 15:18:50', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | FE F001-00071', 2, '30.00', 0, 1, 72, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 127, 1, 1),
(129, '2019-01-18 16:10:32', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0487', 1, '23.00', 1, 1, 73, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(130, '2019-01-18 16:10:32', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0487', 2, '23.00', 0, 1, 73, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 129, 1, 1),
(131, '2019-01-18 16:11:40', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | FE F001-00072', 1, '23.00', 1, 1, 74, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(132, '2019-01-18 16:11:40', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | FE F001-00072', 2, '23.00', 0, 1, 74, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 131, 1, 1),
(133, '2019-01-18 16:28:28', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0488', 1, '33.00', 1, 1, 75, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(134, '2019-01-18 16:28:28', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0488', 2, '33.00', 0, 1, 75, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 133, 1, 1),
(135, '2019-01-18 16:29:46', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0489', 1, '43.00', 1, 1, 76, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(136, '2019-01-18 16:29:46', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0489', 2, '43.00', 0, 1, 76, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 135, 1, 1),
(137, '2019-01-18 17:56:00', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0490', 1, '33.00', 1, 1, 77, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(138, '2019-01-18 17:56:00', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0490', 2, '33.00', 0, 1, 77, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 137, 1, 1),
(139, '2019-01-18 18:37:59', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0491', 1, '33.00', 1, 1, 78, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(140, '2019-01-18 18:37:59', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0491', 2, '33.00', 0, 1, 78, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 139, 1, 1),
(141, '2019-01-18 20:32:33', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0492', 1, '33.00', 1, 1, 79, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(142, '2019-01-18 20:32:33', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0492', 2, '33.00', 0, 1, 79, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 141, 1, 1),
(143, '2019-01-18 20:39:52', 1, 1, '2019-01-18', 'VENTA CONTADO EFECTIVO | BE B001-0493', 1, '36.00', 1, 1, 80, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(144, '2019-01-18 20:39:52', 1, 1, '2019-01-18', 'PAGO CONTADO EFECTIVO | BE B001-0493', 2, '36.00', 0, 1, 80, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 143, 1, 1),
(145, '2019-01-19 13:12:10', 1, 1, '2019-01-19', 'VENTA CONTADO EFECTIVO | BE B001-0494', 1, '25.00', 1, 1, 81, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(146, '2019-01-19 13:12:10', 1, 1, '2019-01-19', 'PAGO CONTADO EFECTIVO | BE B001-0494', 2, '25.00', 0, 1, 81, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 145, 1, 1),
(147, '2019-01-20 13:05:32', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0495', 1, '25.00', 1, 1, 82, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(148, '2019-01-20 13:05:32', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0495', 2, '25.00', 0, 1, 82, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 147, 1, 1),
(149, '2019-01-20 13:06:33', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0496', 1, '25.00', 1, 1, 83, 1, 1, 0, 0, '', 0, '0000-00-00', 10, 1, 0, 1, 1),
(150, '2019-01-20 13:06:34', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0496', 2, '25.00', 0, 1, 83, 1, 1, 0, 0, '', 0, '0000-00-00', 10, 1, 149, 1, 1),
(151, '2019-01-20 13:31:37', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0497', 1, '25.00', 1, 1, 84, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(152, '2019-01-20 13:31:37', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0497', 2, '25.00', 0, 1, 84, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 151, 1, 1),
(153, '2019-01-20 13:32:25', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0498', 1, '3300.00', 1, 1, 85, 1, 1, 0, 0, '', 0, '0000-00-00', 10, 1, 0, 1, 1),
(154, '2019-01-20 13:32:25', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0498', 2, '3300.00', 0, 1, 85, 1, 1, 0, 0, '', 0, '0000-00-00', 10, 1, 153, 1, 1),
(155, '2019-01-20 13:35:41', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0499', 1, '15.00', 1, 1, 86, 1, 1, 0, 0, '', 0, '0000-00-00', 11, 1, 0, 1, 1),
(156, '2019-01-20 13:35:41', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0499', 2, '15.00', 0, 1, 86, 1, 1, 0, 0, '', 0, '0000-00-00', 11, 1, 155, 1, 1),
(157, '2019-01-20 13:39:28', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0500', 1, '77.00', 1, 1, 87, 1, 1, 0, 0, '', 0, '0000-00-00', 12, 1, 0, 1, 1),
(158, '2019-01-20 13:39:28', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0500', 2, '77.00', 0, 1, 87, 1, 1, 0, 0, '', 0, '0000-00-00', 12, 1, 157, 1, 1),
(159, '2019-01-20 13:43:43', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0501', 1, '25.00', 1, 1, 88, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(160, '2019-01-20 13:43:43', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0501', 2, '25.00', 0, 1, 88, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 159, 1, 1),
(161, '2019-01-20 13:46:39', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0502', 1, '10.00', 1, 1, 89, 1, 1, 0, 0, '', 0, '0000-00-00', 13, 1, 0, 1, 1),
(162, '2019-01-20 13:46:39', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0502', 2, '10.00', 0, 1, 89, 1, 1, 0, 0, '', 0, '0000-00-00', 13, 1, 161, 1, 1),
(163, '2019-01-20 21:41:01', 1, 1, '2019-01-20', 'VENTA CONTADO EFECTIVO | BE B001-0503', 1, '25.00', 1, 1, 90, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(164, '2019-01-20 21:41:01', 1, 1, '2019-01-20', 'PAGO CONTADO EFECTIVO | BE B001-0503', 2, '25.00', 0, 1, 90, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 163, 1, 1),
(165, '2019-01-22 16:13:43', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0504', 1, '33.00', 1, 1, 91, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(166, '2019-01-22 16:13:43', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0504', 2, '33.00', 0, 1, 91, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 165, 1, 1),
(167, '2019-01-22 16:14:02', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0505', 1, '33.00', 1, 1, 92, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(168, '2019-01-22 16:14:02', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0505', 2, '33.00', 0, 1, 92, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 167, 1, 1),
(169, '2019-01-22 16:14:27', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0506', 1, '33.00', 1, 1, 93, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(170, '2019-01-22 16:14:27', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0506', 2, '33.00', 0, 1, 93, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 169, 1, 1),
(171, '2019-01-22 16:16:40', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0507', 1, '33.00', 1, 1, 94, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(172, '2019-01-22 16:16:40', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0507', 2, '33.00', 0, 1, 94, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 171, 1, 1),
(173, '2019-01-22 16:21:58', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0508', 1, '23.00', 1, 1, 95, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(174, '2019-01-22 16:21:58', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0508', 2, '23.00', 0, 1, 95, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 173, 1, 1),
(175, '2019-01-22 16:32:06', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0509', 1, '23.00', 1, 1, 96, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(176, '2019-01-22 16:32:06', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0509', 2, '23.00', 0, 1, 96, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 175, 1, 1),
(177, '2019-01-22 21:33:46', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0510', 1, '45.00', 1, 1, 97, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(178, '2019-01-22 21:33:46', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0510', 2, '45.00', 0, 1, 97, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 177, 1, 1),
(179, '2019-01-22 21:34:21', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0511', 1, '30.00', 1, 1, 98, 1, 1, 0, 0, '', 0, '0000-00-00', 14, 1, 0, 1, 1),
(180, '2019-01-22 21:34:21', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0511', 2, '30.00', 0, 1, 98, 1, 1, 0, 0, '', 0, '0000-00-00', 14, 1, 179, 1, 1),
(181, '2019-01-22 21:34:58', 1, 1, '2019-01-22', 'VENTA CONTADO EFECTIVO | BE B001-0512', 1, '35.00', 1, 1, 99, 1, 1, 0, 0, '', 0, '0000-00-00', 15, 1, 0, 1, 1),
(182, '2019-01-22 21:34:58', 1, 1, '2019-01-22', 'PAGO CONTADO EFECTIVO | BE B001-0512', 2, '35.00', 0, 1, 99, 1, 1, 0, 0, '', 0, '0000-00-00', 15, 1, 181, 1, 1),
(183, '2019-01-23 11:06:35', 1, 1, '2019-01-23', 'VENTA CONTADO EFECTIVO | BE B001-0513', 1, '106.20', 1, 1, 100, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(184, '2019-01-23 11:06:35', 1, 1, '2019-01-23', 'PAGO CONTADO EFECTIVO | BE B001-0513', 2, '106.20', 0, 1, 100, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 183, 1, 1),
(185, '2019-01-23 11:09:54', 1, 1, '2019-01-23', 'VENTA CONTADO EFECTIVO | BE B001-0514', 1, '30.00', 1, 1, 101, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(186, '2019-01-23 11:09:54', 1, 1, '2019-01-23', 'PAGO CONTADO EFECTIVO | BE B001-0514', 2, '30.00', 0, 1, 101, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 185, 1, 1),
(187, '2019-01-23 11:10:45', 1, 1, '2019-01-23', 'VENTA CONTADO EFECTIVO | BE B001-0515', 1, '33.00', 1, 1, 102, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(188, '2019-01-23 11:10:45', 1, 1, '2019-01-23', 'PAGO CONTADO EFECTIVO | BE B001-0515', 2, '33.00', 0, 1, 102, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 187, 1, 1),
(189, '2019-01-26 16:35:44', 1, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | BE B001-0516', 1, '40.00', 1, 1, 103, 1, 1, 0, 0, '', 0, '0000-00-00', 16, 1, 0, 1, 1),
(190, '2019-01-26 16:35:44', 1, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | BE B001-0516', 2, '40.00', 0, 1, 103, 1, 1, 0, 0, '', 0, '0000-00-00', 16, 1, 189, 1, 1),
(191, '2019-01-26 16:41:57', 0, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | FE F001-00073', 1, '40.00', 1, 1, 104, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(192, '2019-01-26 16:41:57', 0, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | FE F001-00073', 2, '40.00', 0, 1, 104, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 191, 1, 1),
(193, '2019-01-26 16:49:01', 1, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | NS NS01-00001', 1, '20.00', 1, 1, 105, 1, 1, 0, 0, '', 0, '0000-00-00', 19, 1, 0, 1, 1),
(194, '2019-01-26 16:49:01', 1, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | NS NS01-00001', 2, '20.00', 0, 1, 105, 1, 1, 0, 0, '', 0, '0000-00-00', 19, 1, 193, 1, 1),
(195, '2019-01-26 16:50:42', 0, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | BE B001-0517', 1, '25.00', 1, 1, 106, 1, 1, 0, 0, '', 0, '0000-00-00', 20, 1, 0, 1, 1),
(196, '2019-01-26 16:50:42', 0, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | BE B001-0517', 2, '25.00', 0, 1, 106, 1, 1, 0, 0, '', 0, '0000-00-00', 20, 1, 195, 1, 1),
(197, '2019-01-26 16:51:47', 1, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | BE B001-0518', 1, '30.00', 1, 1, 107, 1, 1, 0, 0, '', 0, '0000-00-00', 21, 1, 0, 1, 1),
(198, '2019-01-26 16:51:47', 1, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | BE B001-0518', 2, '30.00', 0, 1, 107, 1, 1, 0, 0, '', 0, '0000-00-00', 21, 1, 197, 1, 1),
(199, '2019-01-26 17:06:16', 1, 1, '2019-01-26', 'VENTA CONTADO EFECTIVO | BE B001-0519', 1, '22.00', 1, 1, 108, 1, 1, 0, 0, '', 0, '0000-00-00', 19, 1, 0, 1, 1),
(200, '2019-01-26 17:06:16', 1, 1, '2019-01-26', 'PAGO CONTADO EFECTIVO | BE B001-0519', 2, '22.00', 0, 1, 108, 1, 1, 0, 0, '', 0, '0000-00-00', 19, 1, 199, 1, 1),
(201, '2019-01-30 15:48:03', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | BE B001-0520', 1, '30.00', 1, 1, 109, 1, 1, 0, 0, '', 0, '0000-00-00', 22, 1, 0, 1, 1),
(202, '2019-01-30 15:48:03', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | BE B001-0520', 2, '30.00', 0, 1, 109, 1, 1, 0, 0, '', 0, '0000-00-00', 22, 1, 201, 1, 1),
(203, '2019-01-30 15:49:50', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00074', 1, '34.00', 1, 1, 110, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(204, '2019-01-30 15:49:50', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00074', 2, '34.00', 0, 1, 110, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 203, 1, 1),
(205, '2019-01-30 15:53:21', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | BE B001-0521', 1, '60.00', 1, 1, 111, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(206, '2019-01-30 15:53:21', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | BE B001-0521', 2, '60.00', 0, 1, 111, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 205, 1, 1),
(207, '2019-01-30 16:34:42', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00075', 1, '15.00', 1, 1, 112, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(208, '2019-01-30 16:34:42', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00075', 2, '15.00', 0, 1, 112, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 207, 1, 1),
(209, '2019-01-30 16:45:04', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | BE B001-0522', 1, '20.00', 1, 1, 113, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(210, '2019-01-30 16:45:04', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | BE B001-0522', 2, '20.00', 0, 1, 113, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 209, 1, 1),
(211, '2019-01-30 17:12:39', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | BE B001-0523', 1, '106.20', 1, 1, 114, 1, 1, 0, 0, '', 0, '0000-00-00', 20, 1, 0, 1, 1),
(212, '2019-01-30 17:12:39', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | BE B001-0523', 2, '106.20', 0, 1, 114, 1, 1, 0, 0, '', 0, '0000-00-00', 20, 1, 211, 1, 1),
(213, '2019-01-30 19:46:08', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00076', 1, '12.00', 1, 1, 115, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(214, '2019-01-30 19:46:08', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00076', 2, '12.00', 0, 1, 115, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 213, 1, 1),
(215, '2019-01-30 19:54:18', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00077', 1, '100.00', 1, 1, 116, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(216, '2019-01-30 19:54:18', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00077', 2, '100.00', 0, 1, 116, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 215, 1, 1),
(217, '2019-01-30 20:50:48', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00078', 1, '7.50', 1, 1, 1, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(218, '2019-01-30 20:50:48', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00078', 2, '7.50', 0, 1, 1, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 217, 1, 1),
(219, '2019-01-30 21:19:24', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00079', 1, '7.50', 1, 1, 2, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 0, 1, 1),
(220, '2019-01-30 21:19:24', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00079', 2, '7.50', 0, 1, 2, 1, 1, 0, 0, '', 0, '0000-00-00', 8, 1, 219, 1, 1),
(221, '2019-01-30 21:26:12', 1, 1, '2019-01-30', 'VENTA CONTADO EFECTIVO | FE F001-00080', 1, '7.50', 1, 1, 3, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(222, '2019-01-30 21:26:12', 1, 1, '2019-01-30', 'PAGO CONTADO EFECTIVO | FE F001-00080', 2, '7.50', 0, 1, 3, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 221, 1, 1),
(223, '2019-01-31 15:45:54', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | FE F001-00081', 1, '7.50', 1, 1, 4, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 0, 1, 1),
(224, '2019-01-31 15:45:54', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | FE F001-00081', 2, '7.50', 0, 1, 4, 1, 1, 0, 0, '', 0, '0000-00-00', 18, 1, 223, 1, 1),
(225, '2019-01-31 16:24:18', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | BE B001-0524', 1, '5.00', 1, 1, 5, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(226, '2019-01-31 16:24:18', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | BE B001-0524', 2, '5.00', 0, 1, 5, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 225, 1, 1),
(227, '2019-01-31 16:27:28', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | BE B001-0525', 1, '10.00', 1, 1, 6, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(228, '2019-01-31 16:27:28', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | BE B001-0525', 2, '10.00', 0, 1, 6, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 227, 1, 1),
(229, '2019-01-31 16:55:35', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | BE B001-0526', 1, '15.00', 1, 1, 7, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 0, 1, 1),
(230, '2019-01-31 16:55:35', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | BE B001-0526', 2, '15.00', 0, 1, 7, 1, 1, 0, 0, '', 0, '0000-00-00', 7, 1, 229, 1, 1),
(231, '2019-01-31 17:18:45', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | BE B001-0527', 1, '30.00', 1, 1, 8, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 0, 1, 1),
(232, '2019-01-31 17:18:45', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | BE B001-0527', 2, '30.00', 0, 1, 8, 1, 1, 0, 0, '', 0, '0000-00-00', 3, 1, 231, 1, 1),
(233, '2019-01-31 18:24:24', 1, 1, '2019-01-31', 'VENTA CONTADO EFECTIVO | BE B001-0528', 1, '30.00', 1, 1, 9, 1, 1, 0, 0, '', 0, '0000-00-00', 24, 1, 0, 1, 1),
(234, '2019-01-31 18:24:24', 1, 1, '2019-01-31', 'PAGO CONTADO EFECTIVO | BE B001-0528', 2, '30.00', 0, 1, 9, 1, 1, 0, 0, '', 0, '0000-00-00', 24, 1, 233, 1, 1),
(235, '2019-02-20 10:53:12', 1, 1, '2019-02-20', 'VENTA CONTADO EFECTIVO | NS NS01-00002', 1, '34.00', 1, 1, 10, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(236, '2019-02-20 10:53:12', 1, 1, '2019-02-20', 'PAGO CONTADO EFECTIVO | NS NS01-00002', 2, '34.00', 0, 1, 10, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 235, 1, 1),
(237, '2019-02-20 10:53:34', 1, 1, '2019-02-20', 'VENTA CONTADO EFECTIVO | BE B001-0529', 1, '34.00', 1, 1, 11, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 0, 1, 1),
(238, '2019-02-20 10:53:34', 1, 1, '2019-02-20', 'PAGO CONTADO EFECTIVO | BE B001-0529', 2, '34.00', 0, 1, 11, 1, 1, 0, 0, '', 0, '0000-00-00', 1, 1, 237, 1, 1),
(239, '2019-06-10 21:37:35', 1, 1, '2019-06-10', 'VENTA CONTADO EFECTIVO | BE B001-0530', 1, '100.00', 1, 1, 12, 1, 1, 0, 0, '', 0, '0000-00-00', 16, 1, 0, 1, 1),
(240, '2019-06-10 21:37:35', 1, 1, '2019-06-10', 'PAGO CONTADO EFECTIVO | BE B001-0530', 2, '100.00', 0, 1, 12, 1, 1, 0, 0, '', 0, '0000-00-00', 16, 1, 239, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_clientedireccion`
--

CREATE TABLE `tb_clientedireccion` (
  `tb_clientedireccion_id` int(11) NOT NULL,
  `tb_clientedireccion_dir` varchar(800) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tb_clientedireccion`
--

INSERT INTO `tb_clientedireccion` (`tb_clientedireccion_id`, `tb_clientedireccion_dir`, `tb_cliente_id`) VALUES
(1, '28 DE AGOSTO. LOTE NRO. A-15 C.P. LA YARADA TACNA - LA YARADA LOS PALOS', 43),
(2, 'CALLE LOS ANGAMOS 456 LORETO PERU', 43),
(3, 'hula', 43),
(4, 'poo', 43),
(5, 'dir', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_combaja`
--

CREATE TABLE `tb_combaja` (
  `tb_combaja_id` int(11) NOT NULL,
  `tb_combaja_reg` datetime NOT NULL,
  `tb_combaja_mod` datetime NOT NULL,
  `tb_combaja_usureg` int(11) NOT NULL,
  `tb_combaja_usumod` int(11) NOT NULL,
  `tb_combaja_fec` date NOT NULL,
  `tb_combaja_fecref` date NOT NULL,
  `tb_combaja_cod` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_num` int(3) NOT NULL,
  `tb_combaja_tic` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_faucod` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_digval` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_sigval` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_val` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_combaja_fecenvsun` datetime NOT NULL,
  `tb_combaja_estsun` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_combaja`
--

INSERT INTO `tb_combaja` (`tb_combaja_id`, `tb_combaja_reg`, `tb_combaja_mod`, `tb_combaja_usureg`, `tb_combaja_usumod`, `tb_combaja_fec`, `tb_combaja_fecref`, `tb_combaja_cod`, `tb_combaja_num`, `tb_combaja_tic`, `tb_combaja_faucod`, `tb_combaja_digval`, `tb_combaja_sigval`, `tb_combaja_val`, `tb_combaja_fecenvsun`, `tb_combaja_estsun`) VALUES
(1, '2019-01-26 17:29:04', '2019-01-26 17:29:04', 1, 1, '2019-01-26', '2019-01-26', 'RA-20190126-001', 1, '1548541749310', '0', 'w7uEv0lRy09a9ekyzPEIkw071gA=', 'ukw0gqWLyNv9sZ02fj6Oj7TEAmqrD/WloujJu8DKhr2kgjCta7xRQauEvKYArAlKr8Tx1QyLh1xH0TRK/Eyv5WoccKCDKDZst/dLGvo4B8AwzcGqRFBxfbCGcgHJ3AM5HkO+Yj2IUlbzyqW9WNJy04FG3W6qUY4uda5N3qFLaHHirsKqr/F5S+Mo1FzV6fdD1B0Hp2DaY6sEJXtchRt4ogs6fJgtlLRUfc2eXQgV7Qc1I305+dOWj5IMhWkcUvrhy+wmF+TLdCC8Dw5LAo3fnngKuuniW8QqJZ4E2lFu+XPUh2ZAzi1xqrNx6+FOm6u/g6fIhCL/FEL7T1G/vPwdCQ==', '1', '2019-01-26 17:29:09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_combajadetalle`
--

CREATE TABLE `tb_combajadetalle` (
  `tb_combajadetalle_id` int(11) NOT NULL,
  `tb_combaja_id` int(11) NOT NULL,
  `tb_combajadetalle_num` int(3) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_combajadetalle_ser` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `tb_combajadetalle_numdoc` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `tb_combajadetalle_mot` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_combajadetalle`
--

INSERT INTO `tb_combajadetalle` (`tb_combajadetalle_id`, `tb_combaja_id`, `tb_combajadetalle_num`, `cs_tipodocumento_id`, `tb_combajadetalle_ser`, `tb_combajadetalle_numdoc`, `tb_combajadetalle_mot`, `tb_venta_id`) VALUES
(1, 1, 1, 1, 'F001', '00073', 'CANCELACION', 104);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compra`
--

CREATE TABLE `tb_compra` (
  `tb_compra_id` int(11) NOT NULL,
  `tb_compra_reg` datetime NOT NULL,
  `tb_compra_mod` datetime NOT NULL,
  `tb_compra_fec` date NOT NULL,
  `tb_compra_fecven` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_compra_numdoc` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_compra_mon` tinyint(1) NOT NULL,
  `tb_compra_tipcam` decimal(4,3) NOT NULL,
  `tb_compra_tipcam2` decimal(4,3) NOT NULL,
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_compra_subtot` decimal(8,2) NOT NULL,
  `tb_compra_des` decimal(4,2) NOT NULL,
  `tb_compra_descal` decimal(8,2) NOT NULL,
  `tb_compra_fle` decimal(8,2) NOT NULL,
  `tb_compra_tipfle` tinyint(1) NOT NULL,
  `tb_compra_ajupos` decimal(5,2) NOT NULL,
  `tb_compra_ajuneg` decimal(5,2) NOT NULL,
  `tb_compra_valven` decimal(8,2) NOT NULL,
  `tb_compra_igv` decimal(8,2) NOT NULL,
  `tb_compra_tot` decimal(8,2) NOT NULL,
  `tb_compra_tipper` tinyint(4) NOT NULL,
  `tb_compra_per` decimal(8,2) NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_compra_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_compra_exo` decimal(8,2) NOT NULL,
  `tb_compra_ina` decimal(8,2) NOT NULL,
  `tb_compra_isc` decimal(8,2) NOT NULL,
  `tb_compra_gra` decimal(8,2) NOT NULL,
  `tb_compra_orden` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_compra_ser_nota` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tb_compra_num_nota` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tb_compra_fec_nota` date NOT NULL,
  `tb_compra_tip_nota` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compracosto`
--

CREATE TABLE `tb_compracosto` (
  `tb_compracosto_id` int(11) NOT NULL,
  `tb_compra_id` int(11) NOT NULL,
  `tb_compra_relacionada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_compracosto`
--

INSERT INTO `tb_compracosto` (`tb_compracosto_id`, `tb_compra_id`, `tb_compra_relacionada`) VALUES
(1, 70, 71),
(2, 70, 72),
(3, 70, 73),
(4, 70, 74),
(5, 75, 76),
(6, 75, 77),
(7, 75, 78),
(8, 75, 79),
(9, 80, 81),
(10, 80, 82),
(11, 80, 83),
(12, 80, 84),
(13, 85, 86),
(14, 85, 87),
(15, 85, 88),
(16, 85, 89),
(17, 85, 90),
(18, 91, 92),
(19, 91, 93),
(20, 91, 94),
(21, 91, 95),
(22, 91, 96),
(23, 91, 97),
(24, 98, 99),
(25, 98, 100),
(26, 98, 101),
(27, 98, 102),
(28, 98, 103),
(29, 98, 104),
(30, 105, 106),
(31, 105, 107),
(32, 105, 108),
(33, 105, 109),
(34, 105, 110),
(35, 105, 111),
(36, 112, 113),
(37, 112, 114),
(38, 112, 115),
(39, 112, 116),
(40, 112, 117),
(41, 112, 118),
(42, 119, 120),
(43, 119, 121),
(44, 119, 122),
(45, 119, 123),
(46, 119, 124),
(47, 119, 125),
(48, 126, 127),
(49, 126, 128),
(50, 126, 129),
(51, 126, 130),
(52, 126, 131),
(53, 126, 132),
(54, 133, 134),
(55, 133, 135),
(56, 133, 136),
(57, 133, 137),
(58, 133, 138),
(59, 133, 139),
(60, 140, 141),
(61, 140, 142),
(62, 140, 143),
(63, 140, 144),
(64, 140, 145),
(65, 140, 146),
(66, 147, 148),
(67, 147, 149),
(68, 147, 150),
(69, 147, 151),
(70, 147, 152),
(71, 147, 153),
(72, 154, 155),
(73, 154, 156),
(74, 154, 157),
(75, 154, 158),
(76, 154, 159),
(77, 154, 160),
(78, 163, 164),
(79, 163, 165),
(80, 163, 166),
(81, 163, 167),
(82, 163, 168),
(83, 163, 169),
(84, 170, 171),
(85, 170, 172),
(86, 170, 173),
(87, 170, 174),
(88, 170, 175),
(89, 170, 176),
(90, 177, 178),
(91, 177, 179),
(92, 177, 180),
(93, 177, 181),
(94, 177, 182),
(95, 177, 183),
(96, 184, 185),
(97, 184, 186),
(98, 184, 187),
(99, 184, 188),
(100, 184, 189),
(101, 184, 190),
(102, 191, 192),
(103, 191, 193),
(104, 191, 194),
(105, 191, 195),
(106, 191, 196),
(107, 191, 197),
(108, 200, 201),
(109, 200, 202),
(110, 200, 203),
(111, 200, 204),
(112, 200, 205),
(113, 200, 206),
(114, 207, 208),
(115, 207, 209),
(116, 207, 210),
(117, 207, 211),
(118, 207, 212),
(119, 207, 213),
(120, 214, 215),
(121, 214, 216),
(122, 214, 217),
(123, 214, 218),
(124, 214, 219),
(125, 214, 220),
(126, 221, 222),
(127, 221, 223),
(128, 221, 224),
(129, 221, 225),
(130, 221, 226),
(131, 221, 227),
(132, 338, 339),
(133, 338, 340),
(134, 338, 341),
(135, 338, 342),
(136, 338, 343),
(137, 338, 344),
(138, 348, 349),
(139, 348, 350),
(140, 348, 351),
(141, 348, 352),
(142, 348, 353),
(143, 348, 354),
(144, 355, 356),
(145, 355, 357),
(146, 355, 358),
(147, 355, 359),
(148, 355, 360),
(149, 355, 361),
(150, 364, 365),
(151, 364, 366),
(152, 364, 367),
(153, 364, 368),
(154, 364, 369),
(155, 364, 370);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compradetalle`
--

CREATE TABLE `tb_compradetalle` (
  `tb_compradetalle_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_compradetalle_can` decimal(8,4) NOT NULL,
  `tb_compradetalle_preuni` decimal(8,4) NOT NULL,
  `tb_compradetalle_des` decimal(4,4) NOT NULL,
  `tb_compradetalle_imp` decimal(8,4) NOT NULL,
  `tb_compradetalle_igv` decimal(8,4) NOT NULL,
  `tb_compradetalle_fle` decimal(8,4) NOT NULL,
  `tb_compradetalle_per` decimal(8,4) NOT NULL,
  `tb_compradetalle_cosuni` decimal(8,4) NOT NULL,
  `tb_compra_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_compradetalle_lote`
--

CREATE TABLE `tb_compradetalle_lote` (
  `tb_compradetalle_lote_id` int(11) NOT NULL,
  `tb_compradetalle_id` int(11) NOT NULL,
  `tb_fecha_fab` date NOT NULL,
  `tb_fecha_ven` date NOT NULL,
  `tb_compradetalle_exisact` int(11) NOT NULL,
  `tb_compradetalle_lotenum` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_compradetalle_lote`
--

INSERT INTO `tb_compradetalle_lote` (`tb_compradetalle_lote_id`, `tb_compradetalle_id`, `tb_fecha_fab`, `tb_fecha_ven`, `tb_compradetalle_exisact`, `tb_compradetalle_lotenum`) VALUES
(1, 209, '0000-00-00', '2019-04-19', 20, 'A016AJ13'),
(2, 210, '0000-00-00', '2019-06-01', 13, '0213A091'),
(3, 210, '0000-00-00', '2019-06-30', 12, '0213091'),
(4, 211, '0000-00-00', '2019-09-01', 273, '9059A075'),
(5, 218, '0000-00-00', '2019-06-15', 2, '9059A065'),
(6, 218, '0000-00-00', '2019-09-01', 120, '9059A075'),
(7, 219, '2018-10-25', '2019-04-30', 20, 'A016AJ13'),
(8, 220, '2018-10-25', '2019-06-01', 13, '0213A091'),
(9, 220, '2018-10-25', '2019-06-30', 12, '0213091'),
(10, 221, '2018-10-25', '2019-09-01', 273, '9059A075'),
(11, 222, '2018-10-25', '2019-06-15', 2, '9059A065'),
(12, 222, '2018-10-25', '2019-09-01', 120, '9059A075'),
(13, 223, '2018-10-25', '2018-10-11', 20, '000511120'),
(14, 224, '2018-10-25', '2019-06-30', 50, '0213091'),
(15, 225, '2018-10-25', '2019-06-30', 50, 'A268CM01'),
(16, 226, '2018-10-25', '2019-08-31', 50, 'A276AJ01'),
(17, 227, '2018-10-25', '2019-04-30', 100, 'A228AM01'),
(18, 228, '2018-10-25', '2019-06-30', 20, 'A046AJ01'),
(19, 229, '2018-10-25', '2019-11-30', 100, 'A138AJ01'),
(20, 231, '2018-10-25', '2019-11-01', 105, '9059A079'),
(21, 232, '2018-10-25', '2019-11-01', 400, '9059A079'),
(22, 233, '2018-10-25', '2019-02-28', 21, '02570157'),
(23, 234, '2018-10-25', '2020-04-30', 42, 'A891B'),
(24, 235, '2018-10-25', '2019-04-30', 11, '172237642'),
(25, 236, '2018-10-25', '2019-09-30', 42, 'A230BJ02'),
(26, 237, '2018-10-25', '2019-10-31', 9, 'A181AN02'),
(27, 240, '2018-10-25', '2019-02-28', 13, '02570157'),
(28, 241, '2018-10-25', '2019-04-30', 13, '172237642'),
(29, 242, '2018-10-25', '2020-04-30', 23, 'A891B'),
(30, 243, '2018-10-25', '2018-02-15', 5, '94340114'),
(31, 247, '2018-10-25', '2020-04-30', 3, 'A891B'),
(32, 248, '2018-10-25', '2019-04-13', 20, '00681389'),
(33, 249, '2018-10-25', '2019-11-15', 259, '9059A082'),
(34, 249, '2018-10-25', '2019-11-01', 141, '9059A079'),
(35, 250, '2018-10-25', '2020-04-30', 200, 'E364A01'),
(36, 251, '2018-10-25', '2019-11-30', 100, 'A138AJ01'),
(37, 252, '2018-10-25', '2020-03-31', 6, 'S371ZA12'),
(38, 253, '2018-10-25', '2018-06-30', 6, 'E395A14'),
(39, 264, '2018-10-25', '2019-11-15', 450, '9059A082'),
(40, 267, '2018-10-25', '2019-11-15', 400, '9059A081'),
(41, 268, '2018-10-25', '2019-09-30', 100, 'A239AM01'),
(42, 272, '2018-10-25', '2019-02-28', 22, '02570157'),
(43, 273, '2018-10-25', '2020-04-30', 44, 'A891B'),
(44, 275, '2018-10-25', '2019-09-30', 44, 'A230BJ02'),
(45, 279, '2018-10-25', '2019-03-19', 8, '02570159'),
(46, 281, '2018-10-25', '2019-04-30', 8, '172237642'),
(47, 283, '2018-10-25', '2018-12-31', 8, 'A220BM01'),
(48, 284, '2018-10-25', '2020-01-31', 8, 'A179AM01'),
(49, 290, '2018-10-25', '2019-10-31', 7, 'A181AN02'),
(50, 291, '2018-10-25', '2020-01-31', 6, 'A179AM01'),
(51, 292, '2018-10-25', '2019-09-30', 14, 'A230BJ02'),
(52, 293, '2018-10-25', '2019-09-30', 7, 'A235BN01'),
(53, 294, '2018-10-25', '2019-11-30', 10, 'A047AJ01'),
(54, 295, '2018-10-25', '2019-10-15', 25, '0213A100'),
(55, 296, '2018-10-25', '2019-09-30', 40, 'A235BN01'),
(56, 297, '2018-10-25', '2018-06-30', 10, 'E395A14'),
(57, 298, '2018-10-25', '2019-06-30', 50, 'A268CM01'),
(58, 299, '2018-10-25', '2020-10-31', 6, 'S387ZA05'),
(59, 300, '2018-10-25', '2019-08-31', 50, 'A831A'),
(60, 304, '2018-10-25', '2019-11-15', 400, '9059A081'),
(61, 305, '2018-10-25', '2018-12-31', 10, 'A220BM01'),
(62, 306, '2018-10-25', '2019-02-28', 17, '02570157'),
(63, 308, '2018-10-25', '2019-04-30', 17, '172237642'),
(64, 309, '2018-10-25', '2019-09-30', 7, 'A235BN01'),
(65, 310, '2018-10-25', '2019-10-31', 7, 'A181AN02'),
(66, 311, '2018-10-25', '2020-04-30', 34, 'A891B'),
(67, 313, '2018-10-25', '2019-04-30', 20, 'A018A01'),
(68, 315, '2018-10-25', '2019-03-29', 15, '91790162'),
(69, 319, '2018-10-25', '2019-10-31', 12, 'A181AN02'),
(70, 320, '2018-10-25', '2020-01-31', 3, 'A179AM01'),
(71, 321, '2018-10-25', '2019-09-30', 14, 'A230BJ02'),
(72, 322, '2018-10-25', '2019-12-31', 11, 'A237EN01'),
(73, 328, '2018-10-25', '2018-09-30', 9, 'A315A07'),
(74, 329, '2018-10-25', '2020-02-01', 425, '9059A090'),
(75, 330, '2018-10-25', '2020-02-01', 75, '9059A090'),
(76, 331, '2018-10-25', '2019-07-05', 10, '00681391'),
(77, 332, '2018-10-25', '2019-10-31', 10, 'A017AJ01'),
(78, 334, '2018-10-25', '2020-04-30', 200, 'E364A01'),
(79, 335, '2018-10-25', '2020-11-30', 6, 'S393ZA06'),
(80, 336, '2018-10-25', '2019-12-31', 40, 'A237EN01'),
(81, 337, '2018-10-25', '2019-10-15', 25, '0213A100'),
(82, 338, '2018-10-25', '2019-08-31', 50, 'A831A'),
(83, 345, '2018-10-25', '2020-02-01', 200, '9059A090'),
(84, 347, '2018-10-25', '2020-02-01', 200, '9059A090'),
(85, 356, '2018-10-25', '2019-02-28', 18, '02570157'),
(86, 357, '2018-10-25', '2019-01-31', 18, '170847641'),
(87, 358, '2018-10-25', '2020-08-31', 36, 'A921A'),
(88, 362, '2018-10-25', '2020-02-01', 314, '9059A090'),
(89, 362, '2018-10-25', '2020-04-03', 86, '9059A089'),
(90, 363, '2018-10-25', '2018-06-30', 10, 'E395A14'),
(91, 364, '2018-10-25', '2019-07-28', 25, '91790175'),
(92, 367, '2018-10-25', '2020-01-31', 31, 'A179CM01'),
(93, 368, '2018-10-25', '2019-09-30', 19, 'A230BJ02'),
(94, 369, '2018-10-25', '2019-12-31', 10, 'A237EN01'),
(95, 370, '2018-10-25', '2019-07-31', 25, 'F005A06'),
(96, 371, '2018-10-25', '2019-08-31', 50, 'A831A'),
(97, 375, '2018-10-25', '2019-02-28', 20, '01150062'),
(98, 376, '2018-10-25', '2019-12-31', 40, 'A237EN01'),
(99, 377, '2018-10-25', '2020-02-01', 400, '9059A089'),
(100, 378, '2018-10-25', '2019-04-30', 20, 'A018A01'),
(101, 379, '2018-10-25', '2018-06-27', 10, 'E395A14'),
(102, 381, '2018-10-25', '2020-02-01', 200, '9059A089'),
(103, 382, '2018-10-25', '2019-08-31', 56, 'A831A'),
(104, 383, '2018-10-25', '2019-07-28', 18, '91790175'),
(105, 387, '2018-10-25', '2019-09-30', 50, 'A239AM01'),
(106, 388, '2018-10-25', '2020-04-30', 30, 'A183DM01'),
(107, 389, '2018-10-25', '2019-04-30', 20, 'A018A01'),
(108, 392, '2018-10-25', '2020-02-29', 50, 'A294AM02'),
(109, 393, '2018-10-25', '2020-03-31', 50, 'A295BJ01'),
(110, 394, '2018-10-25', '2018-11-30', 4, 'E574A12'),
(111, 395, '2018-10-25', '2019-03-31', 4, 'A121AJ02'),
(112, 397, '2018-10-25', '2019-04-30', 20, 'A018A01'),
(113, 398, '2018-10-25', '2020-04-30', 32, 'A183DM01'),
(114, 399, '2018-10-25', '2019-09-30', 14, 'A230BJ02'),
(115, 400, '2018-10-25', '2019-12-31', 13, 'A237EN01'),
(116, 401, '2018-10-25', '2019-08-11', 26, '91790189'),
(117, 405, '2018-10-25', '2019-04-19', 18, '02570162'),
(118, 406, '2018-10-25', '2020-10-30', 36, 'A933C'),
(119, 407, '2018-10-25', '2019-04-30', 18, '172237642'),
(120, 409, '2018-10-25', '2019-11-15', 500, '9059A081'),
(121, 410, '2018-10-25', '2019-04-19', 13, '02570162'),
(122, 411, '2018-10-25', '2019-04-30', 13, '172237642'),
(123, 412, '2018-10-25', '2020-10-30', 26, 'A93C'),
(124, 413, '2018-10-25', '2018-11-26', 5, '94340127'),
(125, 416, '2018-10-25', '2019-11-15', 1000, '9059A081'),
(126, 417, '2018-10-25', '2021-01-31', 5, 'S402ZA03'),
(127, 418, '2018-10-25', '2020-01-31', 10, 'A047BJ01'),
(128, 419, '2018-10-25', '2020-03-31', 50, 'A295BJ01'),
(129, 420, '2018-10-25', '2020-02-29', 5, 'A294SM02'),
(130, 420, '2018-10-25', '2020-03-31', 45, 'A294DM01'),
(131, 421, '2018-10-25', '2018-06-27', 8, 'E395A14'),
(132, 422, '2018-10-25', '2019-08-31', 50, 'A831A'),
(133, 426, '2018-10-25', '2019-11-15', 128, '9059A081'),
(134, 426, '2018-10-25', '2020-05-01', 372, '9059A093'),
(135, 427, '2018-10-25', '2019-10-31', 20, 'A017AJ01'),
(136, 429, '2018-10-25', '2019-08-11', 20, '91790189'),
(137, 437, '2018-10-25', '2018-11-30', 5, 'E548A22'),
(138, 438, '2018-10-25', '2020-03-31', 100, 'A294DM01'),
(139, 439, '2018-10-25', '2020-03-31', 50, 'A245AN01'),
(140, 440, '2018-10-25', '2020-05-01', 200, '9059A093'),
(141, 441, '2018-10-25', '2019-08-31', 50, 'A831A'),
(142, 446, '2018-10-25', '2019-10-01', 20, '02570177'),
(143, 447, '2018-10-25', '2019-06-30', 20, '172927642'),
(144, 448, '2018-10-25', '2020-05-31', 16, 'A184BM01'),
(145, 449, '2018-10-25', '2019-10-27', 16, 'A224CM01'),
(146, 451, '2018-10-25', '2019-09-30', 11, 'A230BJ02'),
(147, 452, '2018-10-25', '2020-03-31', 7, 'A245AN01'),
(148, 453, '2018-10-25', '2019-09-21', 20, '91790192'),
(149, 457, '2018-10-25', '2020-05-01', 200, '9059A093'),
(150, 462, '2018-10-26', '2020-05-01', 600, '9059A093'),
(151, 463, '2018-10-26', '2019-08-31', 50, 'A831A'),
(152, 467, '2018-10-26', '2019-09-21', 20, '91790192'),
(153, 471, '2018-10-26', '2020-05-01', 200, '9059A093'),
(154, 472, '2018-10-26', '2020-07-31', 38, 'A176DJ01'),
(155, 473, '2018-10-26', '2019-03-31', 16, 'A224CM01'),
(156, 474, '2018-10-26', '2021-01-31', 19, 'A951A'),
(157, 475, '2018-10-26', '2020-05-01', 300, '9059A093'),
(158, 476, '2018-10-26', '2020-05-01', 25, '0213A113'),
(159, 477, '2018-10-26', '2019-09-30', 100, 'A230BJ02'),
(160, 478, '2018-10-26', '2019-09-02', 20, '006811398'),
(161, 479, '2018-10-26', '2020-01-31', 10, 'A047BJ01'),
(162, 480, '2018-10-26', '2019-08-31', 60, 'A831A'),
(163, 484, '2018-10-26', '2020-05-31', 32, 'A248AN01'),
(164, 485, '2018-10-26', '2019-03-31', 10, 'A224CM01'),
(165, 486, '2018-10-26', '2021-03-31', 6, 'S409ZA03'),
(166, 487, '2018-10-26', '2020-05-01', 100, '9059A093'),
(167, 488, '2018-10-26', '2019-12-31', 25, 'F122A02'),
(168, 489, '2018-10-26', '2019-04-30', 20, 'A018A01'),
(169, 492, '2018-10-26', '2019-09-30', 50, 'A239AM01'),
(170, 493, '2018-10-26', '2020-08-31', 100, 'A184CJ01'),
(171, 494, '2018-10-26', '2019-09-30', 100, 'A230BJ02'),
(172, 495, '2018-10-26', '2020-05-01', 350, '9059A093'),
(173, 496, '2018-10-26', '2018-11-30', 10, 'E548A22'),
(174, 497, '2018-10-26', '2020-03-31', 70, 'A245AN01'),
(175, 498, '2018-10-26', '2019-09-30', 50, 'A230BJ01'),
(176, 499, '2018-10-26', '2020-07-31', 62, 'A176DJ01'),
(177, 500, '2018-10-26', '2020-07-31', 125, 'A176DJ01'),
(178, 501, '2018-10-26', '2020-05-31', 24, 'A184BM01'),
(179, 502, '2018-10-26', '2019-09-30', 7, 'A230BJ02'),
(180, 503, '2018-10-26', '2020-03-31', 9, 'A245AN01'),
(181, 504, '2018-10-26', '2019-12-31', 100, 'A237EN01'),
(182, 505, '2018-10-26', '2019-09-30', 30, 'A230BJ02'),
(183, 506, '2018-10-26', '2019-12-31', 50, 'A142AN01'),
(184, 507, '2018-10-26', '2020-02-29', 100, 'A143DJ01'),
(185, 508, '2018-10-26', '2019-12-01', 25, '0213A104'),
(186, 509, '2018-10-26', '2020-02-01', 200, '9059A089'),
(187, 513, '2018-10-26', '2018-06-27', 4, 'E395A14'),
(188, 550, '2018-10-27', '2018-10-31', 4, 'F0966'),
(189, 550, '2018-10-27', '2018-10-31', 6, 'AB5667'),
(190, 551, '2018-10-29', '2018-10-31', 4, '567567'),
(191, 551, '2018-10-29', '2018-10-31', 6, '44334656'),
(192, 552, '2018-11-02', '2018-12-30', 2, '45645654'),
(193, 552, '2018-11-02', '2018-11-23', 1, 'AER45566'),
(194, 569, '2018-11-26', '2019-04-19', 2, 'A016AJ13'),
(195, 570, '2018-10-25', '2019-10-31', 2, 'A017AJ01'),
(196, 570, '2018-10-25', '2019-10-31', 2, 'A017AJ01'),
(197, 577, '2018-10-25', '2019-10-31', 3, 'A017AJ01'),
(198, 578, '2018-10-25', '2019-10-31', 3, 'A017AJ01'),
(199, 578, '2018-10-25', '2019-10-31', 3, 'A017AJ01'),
(200, 579, '2018-10-25', '2019-10-31', 2, 'A017AJ01'),
(201, 579, '2018-10-25', '2019-10-31', 2, 'A017AJ01'),
(202, 580, '2018-10-25', '2019-10-31', 4, 'A017AJ01'),
(203, 581, '0000-00-00', '2019-04-19', 2, 'A016AJ13'),
(204, 581, '0000-00-00', '2019-04-19', 2, 'A016AJ13'),
(205, 582, '0000-00-00', '2019-04-19', 3, 'A016AJ13'),
(206, 591, '2019-01-02', '2019-01-31', 50, '0213A116'),
(207, 592, '2019-01-02', '2020-06-15', 150, '9059A095');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_conductor`
--

CREATE TABLE `tb_conductor` (
  `tb_conductor_id` int(11) NOT NULL,
  `tb_conductor_tip` tinyint(4) NOT NULL,
  `tb_conductor_nom` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_doc` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_dir` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_tel` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_lic` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_conductor_cat` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transporte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_conductor`
--

INSERT INTO `tb_conductor` (`tb_conductor_id`, `tb_conductor_tip`, `tb_conductor_nom`, `tb_conductor_doc`, `tb_conductor_dir`, `tb_conductor_tel`, `tb_conductor_ema`, `tb_conductor_lic`, `tb_conductor_cat`, `tb_transporte_id`) VALUES
(1, 1, 'mario salas', '45513063', 'lasc casuarinas d-14', '978004360', 'carmezsac@hotmail.com', '56676567878', 'AII', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_contingencia`
--

CREATE TABLE `tb_contingencia` (
  `tb_contingencia_id` int(11) NOT NULL,
  `tb_contingencia_reg` datetime NOT NULL,
  `tb_contingencia_mod` datetime NOT NULL,
  `tb_contingencia_usureg` int(11) NOT NULL,
  `tb_contingencia_usumod` int(11) NOT NULL,
  `tb_contingencia_fec` date NOT NULL,
  `tb_contingencia_fecref` date NOT NULL,
  `tb_contingencia_cod` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_contingencia_num` int(3) NOT NULL,
  `tb_contingencia_mot` tinyint(1) NOT NULL,
  `tb_contingencia_lin` int(11) NOT NULL,
  `tb_contingencia_txt` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_costo`
--

CREATE TABLE `tb_costo` (
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_catalogo_tipcam` decimal(4,3) NOT NULL,
  `tb_catalogo_precosdol` decimal(8,2) NOT NULL,
  `tb_catalogo_precos` decimal(8,2) NOT NULL,
  `tb_catalogo_preven` decimal(8,2) NOT NULL,
  `tb_catalogo_cospro` decimal(8,2) NOT NULL,
  `tb_catalogo_cosprodol` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cotizacion`
--

CREATE TABLE `tb_cotizacion` (
  `tb_cotizacion_id` int(11) NOT NULL,
  `tb_cotizacion_reg` datetime NOT NULL,
  `tb_cotizacion_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_cotizacion_numdoc` varchar(30) CHARACTER SET utf8 NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_cotizacion_valven` decimal(8,2) NOT NULL,
  `tb_cotizacion_des` decimal(8,2) NOT NULL,
  `tb_cotizacion_igv` decimal(8,2) NOT NULL,
  `tb_cotizacion_tot` decimal(8,2) NOT NULL,
  `tb_cotizacion_est` varchar(15) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_lab1` varchar(20) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_lab2` varchar(8) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_lab3` varchar(20) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_may` tinyint(4) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntocotizacion_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_cotizacion_ser` varchar(6) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_num` varchar(10) CHARACTER SET utf8 NOT NULL,
  `cs_tipomoneda_id` int(11) NOT NULL,
  `tb_cotizacion_gra` decimal(8,2) NOT NULL,
  `tb_cotizacion_ina` decimal(8,2) NOT NULL,
  `tb_cotizacion_exo` decimal(8,2) NOT NULL,
  `tb_cotizacion_grat` decimal(8,2) NOT NULL,
  `tb_cotizacion_isc` decimal(8,2) NOT NULL,
  `tb_cotizacion_otrtri` decimal(8,2) NOT NULL,
  `tb_cotizacion_otrcar` decimal(8,2) NOT NULL,
  `tb_cotizacion_desglo` decimal(8,2) NOT NULL,
  `cs_tipooperacion_id` int(11) NOT NULL,
  `cs_documentosrelacionados_id` int(11) NOT NULL,
  `tb_cotizacion_faucod` tinytext CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_digval` tinytext CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_sigval` text CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_val` varchar(200) CHARACTER SET utf8 NOT NULL,
  `tb_cotizacion_fecenvsun` datetime NOT NULL,
  `tb_cotizacion_estsun` tinyint(1) NOT NULL,
  `tb_cotizacion_plazoentrega` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cotizaciondetalle`
--

CREATE TABLE `tb_cotizaciondetalle` (
  `tb_cotizaciondetalle_id` int(11) NOT NULL,
  `tb_cotizaciondetalle_tipven` tinyint(4) NOT NULL COMMENT '1:Producto; 2: Servicio',
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL,
  `tb_cotizaciondetalle_nom` tinytext CHARACTER SET utf8 NOT NULL,
  `tb_cotizaciondetalle_preuni` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_can` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_tipdes` tinyint(4) NOT NULL COMMENT '1:Porcentaje; 2:Soles',
  `tb_cotizaciondetalle_des` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_preunilin` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_valven` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_igv` decimal(8,2) NOT NULL,
  `tb_cotizacion_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `cs_tipounidadmedida_id` int(11) NOT NULL,
  `cs_tiposistemacalculoisc_id` int(11) NOT NULL,
  `tb_cotizaciondetalle_isc` decimal(8,2) NOT NULL,
  `tb_cotizaciondetalle_nro` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cuenta`
--

CREATE TABLE `tb_cuenta` (
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_cuenta_cod` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_ord` tinyint(4) NOT NULL,
  `tb_elemento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_cuenta`
--

INSERT INTO `tb_cuenta` (`tb_cuenta_id`, `tb_cuenta_cod`, `tb_cuenta_des`, `tb_cuenta_ord`, `tb_elemento_id`) VALUES
(1, 'REM', 'REMUNERACIONES', 1, 2),
(2, 'DSO', 'BENEFICIOS SOCIALES', 2, 2),
(3, 'LSO', 'LEYES SOCIALES', 3, 2),
(5, 'DEV', 'DEVOLUCIONES', 14, 2),
(6, 'ACE', 'AHORROS - CERTIFICADOS', 20, 2),
(7, 'PAR', 'PARTICIPACIONES', 12, 2),
(8, 'TRFI', 'TRASLADO FONDOS INTERNO', 18, 2),
(9, 'SRV', 'SERVICIOS', 6, 2),
(10, 'GOP', 'GASTOS OPERACION', 7, 2),
(11, 'GAD', 'GASTOS ADMINISTRATIVOS', 11, 2),
(12, 'IND', 'INDUMENTARIA', 5, 2),
(13, 'VIA', 'VIATICOS ', 19, 2),
(14, 'HER', 'HERRAMIENTAS', 21, 2),
(15, 'GFI', 'GASTOS FINANCIEROS', 8, 2),
(16, 'IMP', 'IMPUESTOS', 13, 2),
(17, 'CAP_T', 'CAPITAL DE TRABAJO', 22, 2),
(18, 'DON', 'DONACIONES', 23, 2),
(19, 'BIN', 'BIENES INMUEBLES', 24, 2),
(20, 'VBN', 'VENTA DE BIENES', 1, 0),
(21, 'VBN', 'VENTA DE BIENES', 1, 0),
(22, 'VBN', 'VENTAS', 2, 1),
(23, 'NVT', 'NOTAS DE VENTA', 3, 1),
(24, 'PRE', 'PRESTAMOS', 4, 1),
(25, 'SAN', 'SALDO ANTERIOR', 1, 1),
(28, 'OTR', 'INGRESOS VARIOS', 5, 1),
(29, 'BIEN', 'GASTOS COMERCIALIZACION', 25, 2),
(30, 'TFIN', 'INGRESO X TRASLADO FONDOS IN', 6, 1),
(31, 'DEV', 'DEVOLUCIONES', 7, 1),
(32, 'GVAR', 'GASTOS VARIOS', 26, 2),
(33, 'PGP', 'PAGO PROVEEDORES', 27, 2),
(34, 'NTV', 'NOTAS DE VENTA CANJEADAS', 28, 2),
(35, 'PREST', 'PRESTAMOS', 29, 2),
(36, 'CLG', 'CONSTRUCCION LOCAL GRAU', 30, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cuentacorriente`
--

CREATE TABLE `tb_cuentacorriente` (
  `tb_cuentacorriente_id` int(11) NOT NULL,
  `tb_cuentacorriente_nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_cuentacorriente`
--

INSERT INTO `tb_cuentacorriente` (`tb_cuentacorriente_id`, `tb_cuentacorriente_nom`, `tb_caja_id`, `tb_empresa_id`) VALUES
(1, 'CTA CTE BCP', 1, 0),
(2, 'CUENTA INTERBANK', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cuenta_r`
--

CREATE TABLE `tb_cuenta_r` (
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_cuenta_cod` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_ord` tinyint(4) NOT NULL,
  `tb_elemento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_cuenta_r`
--

INSERT INTO `tb_cuenta_r` (`tb_cuenta_id`, `tb_cuenta_cod`, `tb_cuenta_des`, `tb_cuenta_ord`, `tb_elemento_id`) VALUES
(1, 'CAP', 'SALDO INICIAL', 1, 1),
(2, 'CPA', 'PAGO A PROVEEDORES', 1, 2),
(3, 'ITR', 'INGRESO POR TRANSFERENCIA', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detallelistaprecio`
--

CREATE TABLE `tb_detallelistaprecio` (
  `tb_detallelistaprecio_id` int(11) NOT NULL,
  `tb_producto_id` int(11) NOT NULL,
  `tb_precio_id` int(11) NOT NULL,
  `tb_detallelistaprecio_precos` decimal(18,2) NOT NULL,
  `tb_detallelistaprecio_preven` decimal(18,2) NOT NULL,
  `tb_detallelistaprecio_uti` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_direccion`
--

CREATE TABLE `tb_direccion` (
  `tb_direccion_id` int(11) NOT NULL,
  `tb_direccion_dir` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_cod` char(6) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_direccion`
--

INSERT INTO `tb_direccion` (`tb_direccion_id`, `tb_direccion_dir`, `tb_ubigeo_cod`, `tb_usuario_id`) VALUES
(1, 'las casuarinas d-14', '040129', 30),
(3, 'sdfsdfs', '020508', 30),
(4, 'saaaaa', '050303', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_distribucionasiento`
--

CREATE TABLE `tb_distribucionasiento` (
  `tb_distribucionasiento_id` int(11) NOT NULL,
  `tb_distribucionasiento_lugar` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_distribucionasiento_fila` int(11) NOT NULL,
  `tb_vehiculo_id` int(11) NOT NULL,
  `tb_distribucionasiento_piso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_distribucionasiento`
--

INSERT INTO `tb_distribucionasiento` (`tb_distribucionasiento_id`, `tb_distribucionasiento_lugar`, `tb_distribucionasiento_fila`, `tb_vehiculo_id`, `tb_distribucionasiento_piso`) VALUES
(1, 'item_1;item_2;item_3;item_4;item_5;item_6;item_7;item_8;item_9;item_10;item_11;item_12;item_13;item_49;item_14', 1, 1, 1),
(2, 'item_15;item_16;item_17;item_18;item_19;item_20;item_21;item_22;item_23;item_24;item_25;item_26;item_27;item_28', 2, 1, 1),
(3, 'item_36;item_37;item_38;item_39;item_40;item_41;item_42;item_43;item_44;item_45;item_46;item_47;item_48', 3, 1, 1),
(4, 'item_29;item_30;item_31;item_32;item_33;item_34;item_35;item_36;item_37;item_38;item_39;item_40;item_41;item_42', 1, 2, 1),
(7, 'item_7;item_3', 2, 2, 1),
(8, 'item_8;item_4', 3, 2, 1),
(27, 'item_1;item_2', 1, 3, 1),
(28, 'item_7;item_3', 2, 3, 1),
(29, 'item_8;item_4', 3, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_documento`
--

CREATE TABLE `tb_documento` (
  `tb_documento_id` int(11) NOT NULL,
  `tb_documento_xac` tinyint(1) NOT NULL,
  `tb_documento_abr` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_documento_nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_documento_tip` int(11) NOT NULL,
  `tb_documento_def` tinyint(4) NOT NULL,
  `tb_documento_ele` tinyint(1) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_documento_mos` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_documento`
--

INSERT INTO `tb_documento` (`tb_documento_id`, `tb_documento_xac`, `tb_documento_abr`, `tb_documento_nom`, `tb_documento_tip`, `tb_documento_def`, `tb_documento_ele`, `cs_tipodocumento_id`, `tb_documento_mos`) VALUES
(1, 1, 'FC', 'FACTURA COMPRA', 1, 1, 0, 1, 1),
(2, 1, 'FV', 'FACTURA', 2, 0, 0, 1, 1),
(3, 1, 'BV', 'BOLETA', 2, 0, 0, 2, 1),
(4, 1, 'NV', 'NOTA DE VENTA', 3, 1, 0, 0, 1),
(5, 1, 'OT', 'OTROS', 4, 1, 0, 0, 1),
(6, 1, 'TR', 'TRASPASO', 5, 1, 0, 0, 1),
(7, 1, 'NV', 'NOTA DE ABONO PROV', 1, 0, 0, 0, 1),
(8, 1, 'OI', 'OTROS INGRESOS', 6, 1, 0, 0, 1),
(9, 1, 'OE', 'OTROS EGRESOS', 7, 1, 0, 0, 1),
(10, 1, 'TRF', 'TRANSFERENCIA', 8, 1, 0, 0, 1),
(11, 1, 'FE', 'FACTURA ELECTRONICA', 2, 0, 1, 1, 1),
(12, 1, 'BE', 'BOLETA ELECTRONICA', 2, 1, 1, 2, 1),
(13, 1, 'NC', 'NOTA DE CREDITO', 9, 1, 1, 3, 1),
(14, 1, 'CT', 'COTIZACION', 11, 1, 0, 0, 1),
(15, 1, 'NS', 'NOTA DE SALIDA', 2, 0, 0, 0, 1),
(16, 1, 'ND', 'NOTA DE DEBITO', 10, 1, 1, 4, 1),
(17, 1, 'OT', 'OTROS DOCUMENTOS', 1, 0, 0, 0, 1),
(18, 1, 'LQ', 'LIQUIDACION DE COMPRA', 1, 0, 0, 5, 1),
(19, 1, 'IN', 'INVOICE', 1, 0, 0, 6, 1),
(20, 1, 'NC', 'NOTA DE CREDITO', 1, 0, 0, 3, 1),
(21, 1, 'ND', 'NOTA DE DEBITO', 1, 0, 0, 4, 1),
(22, 1, 'GUIA REM', 'GUIA DE REMISION REMITENTE', 2, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_egreso`
--

CREATE TABLE `tb_egreso` (
  `tb_egreso_id` int(11) NOT NULL,
  `tb_egreso_fecreg` datetime NOT NULL,
  `tb_egreso_fecmod` datetime NOT NULL,
  `tb_egreso_usureg` int(11) NOT NULL,
  `tb_egreso_usumod` int(11) NOT NULL,
  `tb_egreso_xac` tinyint(1) NOT NULL,
  `tb_egreso_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_egreso_numdoc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_egreso_det` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_egreso_imp` decimal(11,2) NOT NULL,
  `tb_egreso_est` tinyint(1) NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_modulo_id` int(11) NOT NULL,
  `tb_egreso_modide` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_egreso`
--

INSERT INTO `tb_egreso` (`tb_egreso_id`, `tb_egreso_fecreg`, `tb_egreso_fecmod`, `tb_egreso_usureg`, `tb_egreso_usumod`, `tb_egreso_xac`, `tb_egreso_fec`, `tb_documento_id`, `tb_egreso_numdoc`, `tb_egreso_det`, `tb_egreso_imp`, `tb_egreso_est`, `tb_cuenta_id`, `tb_subcuenta_id`, `tb_proveedor_id`, `tb_caja_id`, `tb_moneda_id`, `tb_modulo_id`, `tb_egreso_modide`, `tb_empresa_id`) VALUES
(1, '2019-01-26 17:20:12', '2019-01-26 17:20:12', 1, 1, 1, '2019-01-26', 9, '00000', 'COMBUSTIBLE', '30.00', 1, 32, 0, 1, 1, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_elemento`
--

CREATE TABLE `tb_elemento` (
  `tb_elemento_id` int(11) NOT NULL,
  `tb_elemento_cod` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_elemento_des` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_elemento_ord` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_elemento`
--

INSERT INTO `tb_elemento` (`tb_elemento_id`, `tb_elemento_cod`, `tb_elemento_des`, `tb_elemento_ord`) VALUES
(1, 'ENT', 'ENTRADAS', 1),
(2, 'SAL', 'SALIDAS', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_empresa`
--

CREATE TABLE `tb_empresa` (
  `tb_empresa_id` int(11) NOT NULL,
  `tb_empresa_ruc` char(11) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_nomcom` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_razsoc` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_dir` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_dir2` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_tel` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_rep` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_fir` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_logo` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'ruta de la imagen del logo',
  `tb_empresa_regimen` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_empresa`
--

INSERT INTO `tb_empresa` (`tb_empresa_id`, `tb_empresa_ruc`, `tb_empresa_nomcom`, `tb_empresa_razsoc`, `tb_empresa_dir`, `tb_empresa_dir2`, `tb_empresa_tel`, `tb_empresa_ema`, `tb_empresa_rep`, `tb_empresa_fir`, `tb_empresa_logo`, `tb_empresa_regimen`) VALUES
(1, '20601411076', '-', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'Av. Lima Nro 4799 Camana-Arequipa', '', '054-448015', 'rep.marvic@gmail.com', 'ZIRENA BEJARANO VICTOR ALFREDO', '', 'logos/1_logoamplio.png', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_encarte`
--

CREATE TABLE `tb_encarte` (
  `tb_encarte_id` int(11) NOT NULL,
  `tb_encarte_reg` datetime NOT NULL,
  `tb_encarte_mod` datetime NOT NULL,
  `tb_encarte_fecini` date NOT NULL,
  `tb_encarte_fecfin` date NOT NULL,
  `tb_encarte_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_encarte_despor` decimal(4,2) NOT NULL COMMENT 'descuento porcentaje',
  `tb_encarte_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_encartedetalle`
--

CREATE TABLE `tb_encartedetalle` (
  `tb_encartedetalle_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_encartedetalle_cos` decimal(8,2) NOT NULL,
  `tb_encartedetalle_despor` decimal(4,2) NOT NULL,
  `tb_encartedetalle_uti1` decimal(4,2) NOT NULL,
  `tb_encartedetalle_preven1` decimal(8,2) NOT NULL,
  `tb_encartedetalle_uti2` decimal(4,2) NOT NULL,
  `tb_encartedetalle_preven2` decimal(8,2) NOT NULL,
  `tb_encarte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_encomiendaventa`
--

CREATE TABLE `tb_encomiendaventa` (
  `tb_encomiendaventa_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_remitente_id` int(11) NOT NULL,
  `tb_origen_id` int(11) NOT NULL,
  `tb_destino_id` int(11) NOT NULL,
  `tb_encomiendaventa_clave` varchar(5) NOT NULL,
  `tb_estado` tinyint(1) NOT NULL,
  `tb_destinatario_nom` varchar(255) NOT NULL,
  `tb_encomiendaventa_pagado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tb_encomiendaventa`
--

INSERT INTO `tb_encomiendaventa` (`tb_encomiendaventa_id`, `tb_venta_id`, `tb_remitente_id`, `tb_origen_id`, `tb_destino_id`, `tb_encomiendaventa_clave`, `tb_estado`, `tb_destinatario_nom`, `tb_encomiendaventa_pagado`) VALUES
(1, 53, 1, 3, 1, '', 1, '', NULL),
(2, 54, 1, 3, 1, '', 0, '', NULL),
(3, 55, 3, 1, 2, '', 0, '', NULL),
(4, 56, 1, 1, 2, '', 0, '', NULL),
(5, 57, 3, 1, 2, '', 0, '', NULL),
(6, 60, 7, 1, 3, '', 0, '', NULL),
(7, 61, 7, 1, 4, '', 0, '', NULL),
(8, 62, 7, 1, 2, '', 0, '', NULL),
(9, 64, 7, 1, 2, '1234', 1, '', NULL),
(10, 71, 3, 1, 2, '', 0, '', NULL),
(11, 72, 3, 1, 2, '', 0, '', NULL),
(14, 100, 3, 1, 2, '345', 0, '', NULL),
(15, 101, 3, 1, 3, '333', 0, '', NULL),
(16, 108, 19, 1, 2, '12345', 1, '', NULL),
(17, 111, 7, 1, 2, '12345', 1, 'JUANA PARI TORRES', NULL),
(18, 112, 7, 1, 2, '1223', 0, 'juan', NULL),
(19, 113, 7, 1, 2, '1111', 0, 'luis', NULL),
(20, 114, 20, 1, 3, '00000', 0, 'verificar', NULL),
(21, 115, 7, 1, 2, '12455', 0, 'juan peres chavez', NULL),
(22, 116, 7, 1, 2, '1234', 0, 'chaves loza', NULL),
(23, 1, 7, 1, 2, '11111', 0, 'juan', NULL),
(24, 2, 7, 1, 2, '33333', 0, 'luis', NULL),
(25, 3, 7, 1, 3, '4444', 0, 'dfgfg', NULL),
(26, 4, 7, 1, 2, '1244', 0, 'peres guardiola', NULL),
(27, 6, 7, 1, 3, '11111', 0, 'jose 454554', NULL),
(28, 7, 7, 1, 2, '4444', 0, 'ghjghhj', NULL),
(29, 8, 3, 1, 2, '1234', 0, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_entfinanciera`
--

CREATE TABLE `tb_entfinanciera` (
  `tb_entfinanciera_id` int(11) NOT NULL,
  `tb_entfinanciera_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_entfinanciera`
--

INSERT INTO `tb_entfinanciera` (`tb_entfinanciera_id`, `tb_entfinanciera_nom`) VALUES
(1, 'BBVA'),
(2, 'BCP'),
(3, 'NACION'),
(4, 'SCTBNK'),
(5, 'DIRECTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_form`
--

CREATE TABLE `tb_form` (
  `tb_form_id` int(11) NOT NULL,
  `tb_form_ele` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_form_cat` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_form_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_form_ord` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_form`
--

INSERT INTO `tb_form` (`tb_form_id`, `tb_form_ele`, `tb_form_cat`, `tb_form_des`, `tb_form_ord`) VALUES
(1, 'Ingresos', 'Estado', 'EMITIDO', 1),
(2, 'Ingresos', 'Estado', 'CANCELADO', 0),
(3, 'Gastos', 'Estado', 'EMITIDO', 0),
(4, 'Gastos', 'Estado', 'CANCELADO', 0),
(5, 'Gastos', 'Modo Pago', 'EFECTIVO', 0),
(6, 'Gastos', 'Modo Pago', 'TARJETA', 0),
(7, 'Gastos', 'Modo Pago', 'CAR. CTA.', 0),
(8, 'Gastos', 'Modo Pago', 'TRANSFERENCIA', 0),
(9, 'Gastos', 'Modo Pago', 'CHEQUE', 0),
(10, 'Gastos', 'Modo Pago', 'DEPOSITO', 0),
(11, 'Ingresos', 'Suma_Flujo', '\'CANCELADO\'', 0),
(12, 'Gastos', 'Suma_Flujo', '\'CANCELADO\'', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_formapago`
--

CREATE TABLE `tb_formapago` (
  `tb_formapago_id` int(11) NOT NULL,
  `tb_formapago_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_formapago`
--

INSERT INTO `tb_formapago` (`tb_formapago_id`, `tb_formapago_nom`) VALUES
(1, 'CONTADO'),
(2, 'CREDITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_formula`
--

CREATE TABLE `tb_formula` (
  `tb_formula_id` int(11) NOT NULL,
  `tb_formula_ele` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_formula_ide` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_formula_dat` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_formula_des` tinytext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_formula`
--

INSERT INTO `tb_formula` (`tb_formula_id`, `tb_formula_ele`, `tb_formula_ide`, `tb_formula_dat`, `tb_formula_des`) VALUES
(1, 'General', 'IGV', '18', '% Por ciento.'),
(2, 'Administrador', 'MOS_TIPO_CAMBIO', '0', 'Permite mostrar una ventana al iniciar sesiÃ³n para registrar el tipo de cambio del dÃ­a. Valores del Dato: 1=Activado, 0=Desactivado.'),
(3, 'Ventas', 'VEN_TIPO_IMPRESION', '0', 'Configura el modo de impresiÃ³n de los comprobantes de venta. Valores del Dato: 1=Activado, 0=Desactivado.'),
(4, 'Ventas', 'VEN_IMP_DIR', '1', 'Muestra en la impresiÃ³n del comprobante de venta la direcciÃ³n. 1=Activado 0=Desactivado'),
(5, 'Ventas', 'VEN_VENTAS_NEGATIVAS', '1', 'Permite vender productos sin stock');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_gasto`
--

CREATE TABLE `tb_gasto` (
  `tb_gasto_id` int(11) NOT NULL,
  `tb_gasto_fecreg` datetime NOT NULL,
  `tb_gasto_fecmod` datetime NOT NULL,
  `tb_gasto_fec` date NOT NULL,
  `tb_gasto_doc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_des` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_imp` decimal(11,2) NOT NULL,
  `tb_gasto_modpag` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_est` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_entfinanciera_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_referencia_id` int(11) NOT NULL,
  `tb_transferencia_id` int(11) NOT NULL,
  `tb_transferencia_id_ter` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_usuario_id_reg` int(11) NOT NULL,
  `tb_usuario_id_mod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_gasto_r`
--

CREATE TABLE `tb_gasto_r` (
  `tb_gasto_id` int(11) NOT NULL,
  `tb_gasto_fecreg` datetime NOT NULL,
  `tb_gasto_fecmod` datetime NOT NULL,
  `tb_gasto_fec` date NOT NULL,
  `tb_gasto_doc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_des` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_imp` decimal(11,2) NOT NULL,
  `tb_gasto_modpag` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_gasto_est` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_entfinanciera_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_transferencia_id` int(11) NOT NULL,
  `tb_compra_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_usuario_id_reg` int(11) NOT NULL,
  `tb_usuario_id_mod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_gasto_r`
--

INSERT INTO `tb_gasto_r` (`tb_gasto_id`, `tb_gasto_fecreg`, `tb_gasto_fecmod`, `tb_gasto_fec`, `tb_gasto_doc`, `tb_gasto_des`, `tb_gasto_imp`, `tb_gasto_modpag`, `tb_gasto_numope`, `tb_gasto_est`, `tb_cuenta_id`, `tb_subcuenta_id`, `tb_proveedor_id`, `tb_entfinanciera_id`, `tb_caja_id`, `tb_moneda_id`, `tb_transferencia_id`, `tb_compra_id`, `tb_empresa_id`, `tb_usuario_id_reg`, `tb_usuario_id_mod`) VALUES
(1, '2018-09-07 18:09:58', '2018-09-07 18:09:58', '2018-09-07', 'doc', 'PAGO DE FC 656565', '23.60', 'DEPOSITO', '5645665', 'CANCELADO', 2, 0, 0, 1, 1, 1, 0, 41, 1, 1, 1),
(2, '2018-12-21 14:38:55', '2018-12-21 14:38:55', '2018-12-21', 'f004-456', 'PAGO DE FC f004-456, cancelado', '60.18', 'TARJETA', 'NO45645656', 'CANCELADO', 2, 0, 0, 2, 1, 1, 0, 379, 1, 1, 1),
(3, '2018-12-21 14:43:39', '2018-12-21 14:43:39', '2018-12-21', 'f102-8989', 'PAGO DE FC f102-8989', '100.00', 'EFECTIVO', '00000', 'CANCELADO', 2, 0, 0, 0, 1, 1, 0, 380, 1, 1, 1),
(4, '2018-12-21 15:00:27', '2018-12-21 15:00:27', '2018-12-21', 'f102-8989', 'PAGO DE FC f102-8989, pagado deposito, soles, bcp', '4620.00', 'DEPOSITO', '20', 'CANCELADO', 2, 0, 17, 2, 1, 1, 0, 380, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_guia`
--

CREATE TABLE `tb_guia` (
  `tb_guia_id` int(11) NOT NULL,
  `tb_guia_reg` datetime NOT NULL,
  `tb_guia_mod` datetime NOT NULL,
  `tb_guia_fec` datetime NOT NULL,
  `tb_guia_rem` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Remitente',
  `tb_guia_des` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Destinatario',
  `tb_guia_punpar` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Punto Partida',
  `tb_guia_punlle` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Punto Llegada',
  `tb_guia_serie` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_num` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_obs` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_pla` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_mar` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guia_tipope` tinyint(11) NOT NULL COMMENT '1:Transferencia; 2:Venta',
  `tb_venta_id` int(11) NOT NULL,
  `tb_traspaso_id` int(11) NOT NULL,
  `tb_guia_numdoc` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero Documento ó Código de Transferencia',
  `tb_conductor_id` int(11) NOT NULL,
  `tb_transporte_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_guia`
--

INSERT INTO `tb_guia` (`tb_guia_id`, `tb_guia_reg`, `tb_guia_mod`, `tb_guia_fec`, `tb_guia_rem`, `tb_guia_des`, `tb_guia_punpar`, `tb_guia_punlle`, `tb_guia_serie`, `tb_guia_num`, `tb_guia_obs`, `tb_guia_pla`, `tb_guia_mar`, `tb_guia_est`, `tb_guia_tipope`, `tb_venta_id`, `tb_traspaso_id`, `tb_guia_numdoc`, `tb_conductor_id`, `tb_transporte_id`, `tb_usuario_id`, `tb_empresa_id`) VALUES
(1, '2019-01-16 18:49:44', '2019-01-16 18:49:44', '2019-01-16 00:00:00', 'REP VET MARVIC E.I.R.L.', 'NUEVA EMPRESA', 'CAL.PRINCIPAL NRO. 345 (CERCA A LA PLAZA DE SABANDIA) AREQUIPA - AREQUIPA - SABANDIA', '', '0001', '00035', '', '', '', 'CONCLUIDA', 2, 51, 0, 'F001-00065', 0, 0, 1, 1),
(2, '2019-01-17 13:29:04', '2019-01-17 13:29:04', '2019-01-17 00:00:00', 'REP VET MARVIC E.I.R.L.', 'NUEVA EMPRESA', 'CAL.PRINCIPAL NRO. 345 (CERCA A LA PLAZA DE SABANDIA) AREQUIPA - AREQUIPA - SABANDIA', '', '0001', '00036', '', '', '', 'CONCLUIDA', 2, 56, 0, 'F001-00066', 0, 0, 1, 1),
(3, '2019-01-17 19:53:04', '2019-01-17 19:53:04', '2019-01-17 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00037', '', '', '', 'CONCLUIDA', 2, 59, 0, 'F001-00067', 0, 0, 1, 1),
(4, '2019-01-17 19:59:53', '2019-01-17 19:59:53', '2019-01-17 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00038', '', '', '', 'CONCLUIDA', 2, 60, 0, 'F001-00068', 0, 0, 1, 1),
(5, '2019-01-18 14:51:28', '2019-01-18 14:51:28', '2019-01-18 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00039', '', '', '', 'CONCLUIDA', 2, 67, 0, 'F001-00069', 0, 0, 1, 1),
(6, '2019-01-18 15:02:43', '2019-01-18 15:02:43', '2019-01-18 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00040', '', '', '', 'CONCLUIDA', 2, 70, 0, 'F001-00070', 0, 0, 1, 1),
(7, '2019-01-18 15:18:49', '2019-01-18 15:18:49', '2019-01-18 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00041', '', '', '', 'CONCLUIDA', 2, 72, 0, 'F001-00071', 0, 0, 1, 1),
(8, '2019-01-18 16:11:40', '2019-01-18 16:11:40', '2019-01-18 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'NUEVA EMPRESA', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00042', '', '', '', 'CONCLUIDA', 2, 74, 0, 'F001-00072', 0, 0, 1, 1),
(9, '2019-01-26 16:41:57', '2019-01-26 16:41:57', '2019-01-26 00:00:00', 'TRANSPORTES Y TURISMO ANGELES TOURS JUL PERU SAC', 'ADMICONTA ABC E.I.R.L.', 'Av. Lima Nro 4799 Camana-Arequipa', '', '0001', '00043', '', '', '', 'CONCLUIDA', 2, 104, 0, 'F001-00073', 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_guiadetalle`
--

CREATE TABLE `tb_guiadetalle` (
  `tb_guiadetalle_id` int(11) NOT NULL,
  `tb_guiadetalle_can` decimal(8,2) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_guia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_guiapagonota`
--

CREATE TABLE `tb_guiapagonota` (
  `tb_guiapagonota_id` int(11) NOT NULL,
  `tb_guiapagonota_xac` tinyint(1) NOT NULL,
  `tb_guiapagonota_fecreg` datetime NOT NULL,
  `tb_guiapagonota_fecmod` datetime NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_periodo_id` int(11) NOT NULL,
  `tb_ejercicio_id` int(11) NOT NULL,
  `tb_guiapagonota_tip` tinyint(1) NOT NULL,
  `tb_guiapagonota_coremi` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guiapagonota_cor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guiapagonota_corcop` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guiapagonota_asu` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_guiapagonota_men` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_guiapagonota_adj` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_horario`
--

CREATE TABLE `tb_horario` (
  `tb_horario_id` int(11) NOT NULL,
  `tb_horario_reg` datetime NOT NULL,
  `tb_horario_mod` datetime NOT NULL,
  `tb_horario_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_horario_fecini` date NOT NULL,
  `tb_horario_fecfin` date NOT NULL,
  `tb_horario_lun` tinyint(4) NOT NULL,
  `tb_horario_mar` tinyint(4) NOT NULL,
  `tb_horario_mie` tinyint(4) NOT NULL,
  `tb_horario_jue` tinyint(4) NOT NULL,
  `tb_horario_vie` tinyint(4) NOT NULL,
  `tb_horario_sab` tinyint(4) NOT NULL,
  `tb_horario_dom` tinyint(4) NOT NULL,
  `tb_horario_horini1` time DEFAULT NULL,
  `tb_horario_horfin1` time DEFAULT NULL,
  `tb_horario_horini2` time DEFAULT NULL,
  `tb_horario_horfin2` time DEFAULT NULL,
  `tb_horario_est` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_horario`
--

INSERT INTO `tb_horario` (`tb_horario_id`, `tb_horario_reg`, `tb_horario_mod`, `tb_horario_nom`, `tb_horario_fecini`, `tb_horario_fecfin`, `tb_horario_lun`, `tb_horario_mar`, `tb_horario_mie`, `tb_horario_jue`, `tb_horario_vie`, `tb_horario_sab`, `tb_horario_dom`, `tb_horario_horini1`, `tb_horario_horfin1`, `tb_horario_horini2`, `tb_horario_horfin2`, `tb_horario_est`, `tb_empresa_id`) VALUES
(1, '2013-01-02 00:29:58', '2018-03-16 19:18:25', 'HORARIO STANDAR', '2018-01-01', '2018-12-31', 1, 1, 1, 1, 1, 1, 1, '08:30:00', '23:59:00', NULL, NULL, 'ACTIVO', 0),
(2, '2014-05-22 02:16:42', '2018-03-16 19:19:22', 'HORARIO VENDEDOR', '2015-01-01', '2018-12-31', 1, 1, 1, 1, 1, 1, 1, '01:00:00', '23:59:00', NULL, NULL, 'ACTIVO', 0),
(3, '2018-04-03 16:16:42', '2018-04-03 16:16:55', 'horario de trabajo', '2018-04-02', '2018-04-27', 1, 1, 0, 1, 1, 1, 0, '03:00:00', '08:00:00', '16:00:00', '23:00:00', 'ACTIVO', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingreso`
--

CREATE TABLE `tb_ingreso` (
  `tb_ingreso_id` int(11) NOT NULL,
  `tb_ingreso_fecreg` datetime NOT NULL,
  `tb_ingreso_fecmod` datetime NOT NULL,
  `tb_ingreso_usureg` int(11) NOT NULL,
  `tb_ingreso_usumod` int(11) NOT NULL,
  `tb_ingreso_xac` tinyint(1) NOT NULL,
  `tb_ingreso_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_ingreso_numdoc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ingreso_det` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_ingreso_imp` decimal(11,2) NOT NULL,
  `tb_ingreso_est` tinyint(1) NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_modulo_id` int(11) NOT NULL,
  `tb_ingreso_modide` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ingreso`
--

INSERT INTO `tb_ingreso` (`tb_ingreso_id`, `tb_ingreso_fecreg`, `tb_ingreso_fecmod`, `tb_ingreso_usureg`, `tb_ingreso_usumod`, `tb_ingreso_xac`, `tb_ingreso_fec`, `tb_documento_id`, `tb_ingreso_numdoc`, `tb_ingreso_det`, `tb_ingreso_imp`, `tb_ingreso_est`, `tb_cuenta_id`, `tb_subcuenta_id`, `tb_cliente_id`, `tb_caja_id`, `tb_moneda_id`, `tb_modulo_id`, `tb_ingreso_modide`, `tb_empresa_id`) VALUES
(1, '2019-01-12 13:26:44', '2019-01-12 13:26:44', 1, 1, 1, '2019-01-12', 12, 'B001-0426', 'VENTA BE B001-0426 | EFECTIVO', '30.00', 1, 22, 157, 1, 1, 1, 1, 1, 1),
(2, '2019-01-13 20:42:51', '2019-01-13 20:42:51', 1, 1, 1, '2019-01-13', 12, 'B001-0431', 'VENTA BE B001-0431 | EFECTIVO', '50.00', 1, 22, 157, 1, 1, 1, 1, 6, 1),
(3, '2019-01-13 20:46:17', '2019-01-13 20:46:17', 1, 1, 1, '2019-01-13', 12, 'B001-0432', 'VENTA BE B001-0432 | EFECTIVO', '20.00', 1, 22, 157, 1, 1, 1, 1, 7, 1),
(4, '2019-01-14 18:21:17', '2019-01-14 18:21:17', 1, 1, 1, '2019-01-14', 12, 'B001-0433', 'VENTA BE B001-0433 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 8, 1),
(5, '2019-01-14 18:25:41', '2019-01-14 18:25:41', 1, 1, 1, '2019-01-14', 12, 'B001-0434', 'VENTA BE B001-0434 | EFECTIVO', '32.00', 1, 22, 157, 1, 1, 1, 1, 9, 1),
(6, '2019-01-14 19:32:20', '2019-01-14 19:32:20', 1, 1, 1, '2019-01-14', 12, 'B001-0439', 'VENTA BE B001-0439 | EFECTIVO', '45.00', 1, 22, 157, 1, 1, 1, 1, 14, 1),
(7, '2019-01-14 19:39:04', '2019-01-14 19:39:04', 1, 1, 1, '2019-01-14', 12, 'B001-0440', 'VENTA BE B001-0440 | EFECTIVO', '50.00', 1, 22, 157, 1, 1, 1, 1, 15, 1),
(8, '2019-01-14 19:46:53', '2019-01-14 19:46:53', 1, 1, 1, '2019-01-14', 12, 'B001-0441', 'VENTA BE B001-0441 | EFECTIVO', '45.00', 1, 22, 157, 1, 1, 1, 1, 16, 1),
(9, '2019-01-14 19:59:38', '2019-01-14 19:59:38', 1, 1, 1, '2019-01-14', 12, 'B001-0442', 'VENTA BE B001-0442 | EFECTIVO', '25.00', 1, 22, 157, 1, 1, 1, 1, 17, 1),
(10, '2019-01-14 20:07:54', '2019-01-14 20:07:54', 1, 1, 1, '2019-01-14', 12, 'B001-0443', 'VENTA BE B001-0443 | EFECTIVO', '50.00', 1, 22, 157, 1, 1, 1, 1, 18, 1),
(11, '2019-01-14 20:10:33', '2019-01-14 20:10:33', 1, 1, 1, '2019-01-14', 12, 'B001-0444', 'VENTA BE B001-0444 | EFECTIVO', '50.00', 1, 22, 157, 1, 1, 1, 1, 19, 1),
(12, '2019-01-14 20:13:28', '2019-01-14 20:13:28', 1, 1, 1, '2019-01-14', 12, 'B001-0445', 'VENTA BE B001-0445 | EFECTIVO', '40.00', 1, 22, 157, 1, 1, 1, 1, 20, 1),
(13, '2019-01-14 20:14:05', '2019-01-14 20:14:05', 1, 1, 1, '2019-01-14', 12, 'B001-0446', 'VENTA BE B001-0446 | EFECTIVO', '10.00', 1, 22, 157, 1, 1, 1, 1, 21, 1),
(14, '2019-01-14 20:21:33', '2019-01-14 20:21:33', 1, 1, 1, '2019-01-14', 12, 'B001-0447', 'VENTA BE B001-0447 | EFECTIVO', '25.00', 1, 22, 157, 1, 1, 1, 1, 22, 1),
(15, '2019-01-14 20:24:14', '2019-01-14 20:24:14', 1, 1, 1, '2019-01-14', 12, 'B001-0448', 'VENTA BE B001-0448 | EFECTIVO', '52.00', 1, 22, 157, 1, 1, 1, 1, 23, 1),
(16, '2019-01-14 20:27:36', '2019-01-14 20:27:36', 1, 1, 1, '2019-01-14', 12, 'B001-0449', 'VENTA BE B001-0449 | EFECTIVO', '40.00', 1, 22, 157, 1, 1, 1, 1, 24, 1),
(17, '2019-01-14 20:34:56', '2019-01-14 20:34:56', 1, 1, 1, '2019-01-14', 12, 'B001-0450', 'VENTA BE B001-0450 | EFECTIVO', '40.00', 1, 22, 157, 1, 1, 1, 1, 25, 1),
(18, '2019-01-15 10:37:33', '2019-01-15 10:37:33', 1, 1, 1, '2019-01-15', 12, 'B001-0451', 'VENTA BE B001-0451 | EFECTIVO', '22.00', 1, 22, 157, 1, 1, 1, 1, 26, 1),
(19, '2019-01-15 10:47:28', '2019-01-15 10:47:28', 1, 1, 1, '2019-01-15', 12, 'B001-0452', 'VENTA BE B001-0452 | EFECTIVO', '24.00', 1, 22, 157, 1, 1, 1, 1, 27, 1),
(20, '2019-01-15 10:49:25', '2019-01-15 10:49:25', 1, 1, 1, '2019-01-15', 12, 'B001-0453', 'VENTA BE B001-0453 | EFECTIVO', '40.00', 1, 22, 157, 1, 1, 1, 1, 28, 1),
(21, '2019-01-15 10:52:15', '2019-01-15 10:52:15', 1, 1, 1, '2019-01-15', 12, 'B001-0454', 'VENTA BE B001-0454 | EFECTIVO', '34.00', 1, 22, 157, 1, 1, 1, 1, 29, 1),
(22, '2019-01-15 10:56:18', '2019-01-15 10:56:18', 1, 1, 1, '2019-01-15', 12, 'B001-0455', 'VENTA BE B001-0455 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 30, 1),
(23, '2019-01-14 11:12:49', '2019-01-14 11:12:49', 1, 1, 1, '2019-01-14', 12, 'B001-0456', 'VENTA BE B001-0456 | EFECTIVO', '47.00', 1, 22, 157, 1, 1, 1, 1, 31, 1),
(24, '2019-01-14 11:13:30', '2019-01-14 11:13:30', 1, 1, 1, '2019-01-14', 12, 'B001-0457', 'VENTA BE B001-0457 | EFECTIVO', '47.00', 1, 22, 157, 1, 1, 1, 1, 32, 1),
(25, '2019-01-14 11:14:48', '2019-01-14 11:14:48', 1, 1, 1, '2019-01-14', 12, 'B001-0458', 'VENTA BE B001-0458 | EFECTIVO', '40.00', 1, 22, 157, 1, 1, 1, 1, 33, 1),
(26, '2019-01-14 11:17:55', '2019-01-14 11:17:55', 1, 1, 1, '2019-01-14', 12, 'B001-0459', 'VENTA BE B001-0459 | EFECTIVO', '50.00', 1, 22, 157, 1, 1, 1, 1, 34, 1),
(27, '2019-01-15 11:21:55', '2019-01-15 11:21:55', 1, 1, 1, '2019-01-15', 12, 'B001-0460', 'VENTA BE B001-0460 | EFECTIVO', '20.00', 1, 22, 157, 1, 1, 1, 1, 35, 1),
(28, '2019-01-15 11:23:40', '2019-01-15 11:23:40', 1, 1, 1, '2019-01-15', 12, 'B001-0461', 'VENTA BE B001-0461 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 36, 1),
(29, '2019-01-15 11:24:28', '2019-01-15 11:24:28', 1, 1, 1, '2019-01-15', 12, 'B001-0462', 'VENTA BE B001-0462 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 37, 1),
(30, '2019-01-15 11:26:31', '2019-01-15 11:26:31', 1, 1, 1, '2019-01-15', 12, 'B001-0463', 'VENTA BE B001-0463 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 38, 1),
(31, '2019-01-15 11:30:28', '2019-01-15 11:30:28', 1, 1, 1, '2019-01-15', 12, 'B001-0464', 'VENTA BE B001-0464 | EFECTIVO', '34.00', 1, 22, 157, 1, 1, 1, 1, 39, 1),
(32, '2019-01-15 13:07:26', '2019-01-15 13:07:26', 1, 1, 1, '2019-01-15', 12, 'B001-0465', 'VENTA BE B001-0465 | EFECTIVO', '22.00', 1, 22, 157, 1, 1, 1, 1, 40, 1),
(33, '2019-01-15 13:15:20', '2019-01-15 13:15:20', 1, 1, 1, '2019-01-15', 12, 'B001-0466', 'VENTA BE B001-0466 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 41, 1),
(34, '2019-01-15 13:28:42', '2019-01-15 13:28:42', 1, 1, 1, '2019-01-15', 12, 'B001-0467', 'VENTA BE B001-0467 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 42, 1),
(35, '2019-01-15 15:32:08', '2019-01-15 15:32:08', 1, 1, 1, '2019-01-15', 12, 'B001-0468', 'VENTA BE B001-0468 | EFECTIVO', '22.00', 1, 22, 157, 1, 1, 1, 1, 43, 1),
(36, '2019-01-15 15:43:25', '2019-01-15 15:43:25', 1, 1, 1, '2019-01-15', 12, 'B001-0469', 'VENTA BE B001-0469 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 44, 1),
(37, '2019-01-15 15:59:23', '2019-01-15 15:59:23', 1, 1, 1, '2019-01-15', 12, 'B001-0470', 'VENTA BE B001-0470 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 45, 1),
(38, '2019-01-15 15:59:56', '2019-01-15 15:59:56', 1, 1, 1, '2019-01-15', 12, 'B001-0471', 'VENTA BE B001-0471 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 46, 1),
(39, '2019-01-15 16:00:11', '2019-01-15 16:00:11', 1, 1, 1, '2019-01-15', 12, 'B001-0472', 'VENTA BE B001-0472 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 47, 1),
(40, '2019-01-15 17:08:52', '2019-01-15 17:08:52', 1, 1, 1, '2019-01-15', 12, 'B001-0473', 'VENTA BE B001-0473 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 48, 1),
(41, '2019-01-15 18:50:48', '2019-01-15 18:50:48', 1, 1, 1, '2019-01-15', 12, 'B001-0474', 'VENTA BE B001-0474 | EFECTIVO', '45.00', 1, 22, 157, 1, 1, 1, 1, 49, 1),
(42, '2019-01-16 15:01:01', '2019-01-16 15:01:01', 1, 1, 1, '2019-01-16', 12, 'B001-0475', 'VENTA BE B001-0475 | EFECTIVO', '22.00', 1, 22, 157, 6, 1, 1, 1, 50, 1),
(43, '2019-01-16 18:49:44', '2019-01-16 18:49:44', 1, 1, 1, '2019-01-16', 11, 'F001-00065', 'VENTA FE F001-00065 | EFECTIVO', '33.00', 1, 22, 157, 8, 1, 1, 1, 51, 1),
(44, '2019-01-16 19:05:51', '2019-01-16 19:05:51', 1, 1, 1, '2019-01-16', 12, 'B001-0476', 'VENTA BE B001-0476 | EFECTIVO', '54.00', 1, 22, 157, 7, 1, 1, 1, 52, 1),
(45, '2019-01-17 13:16:12', '2019-01-17 13:16:12', 1, 1, 1, '2019-01-17', 12, 'B001-0477', 'VENTA BE B001-0477 | EFECTIVO', '10.00', 1, 22, 157, 3, 1, 1, 1, 53, 1),
(46, '2019-01-17 13:17:57', '2019-01-17 13:17:57', 1, 1, 1, '2019-01-17', 12, 'B001-0478', 'VENTA BE B001-0478 | EFECTIVO', '10.00', 1, 22, 157, 3, 1, 1, 1, 54, 1),
(47, '2019-01-17 13:19:55', '2019-01-17 13:19:55', 1, 1, 1, '2019-01-17', 12, 'B001-0479', 'VENTA BE B001-0479 | EFECTIVO', '10.00', 1, 22, 157, 3, 1, 1, 1, 55, 1),
(48, '2019-01-17 13:29:04', '2019-01-17 13:29:04', 1, 1, 1, '2019-01-17', 11, 'F001-00066', 'VENTA FE F001-00066 | EFECTIVO', '10.00', 1, 22, 157, 8, 1, 1, 1, 56, 1),
(49, '2019-01-17 17:27:32', '2019-01-17 17:27:32', 1, 1, 1, '2019-01-17', 12, 'B001-0480', 'VENTA BE B001-0480 | EFECTIVO', '20.00', 1, 22, 157, 3, 1, 1, 1, 57, 1),
(50, '2019-01-17 19:40:24', '2019-01-17 19:40:24', 1, 1, 1, '2019-01-17', 12, 'B001-0481', 'VENTA BE B001-0481 | EFECTIVO', '40.00', 1, 22, 157, 7, 1, 1, 1, 58, 1),
(51, '2019-01-17 19:53:04', '2019-01-17 19:53:04', 1, 1, 1, '2019-01-17', 11, 'F001-00067', 'VENTA FE F001-00067 | EFECTIVO', '40.00', 1, 22, 157, 8, 1, 1, 1, 59, 1),
(52, '2019-01-17 19:59:54', '2019-01-17 19:59:54', 1, 1, 1, '2019-01-17', 11, 'F001-00068', 'VENTA FE F001-00068 | EFECTIVO', '106.20', 1, 22, 157, 8, 1, 1, 1, 60, 1),
(53, '2019-01-17 21:12:34', '2019-01-17 21:12:34', 1, 1, 1, '2019-01-17', 12, 'B001-0101', 'VENTA BE B001-0101 | EFECTIVO', '30.00', 1, 22, 157, 7, 2, 1, 1, 61, 1),
(54, '2019-01-17 21:18:35', '2019-01-17 21:18:35', 1, 1, 1, '2019-01-17', 12, 'B001-0102', 'VENTA BE B001-0102 | EFECTIVO', '60.00', 1, 22, 157, 7, 2, 1, 1, 62, 1),
(55, '2019-01-17 21:24:18', '2019-01-17 21:24:18', 1, 1, 1, '2019-01-17', 12, 'B001-0103', 'VENTA BE B001-0103 | EFECTIVO', '45.00', 1, 22, 157, 7, 2, 1, 1, 63, 1),
(56, '2019-01-17 21:38:00', '2019-01-17 21:38:00', 1, 1, 1, '2019-01-17', 12, 'B001-0104', 'VENTA BE B001-0104 | EFECTIVO', '180.00', 1, 22, 157, 7, 2, 1, 1, 64, 1),
(57, '2019-01-18 13:26:08', '2019-01-18 13:26:08', 1, 1, 1, '2019-01-18', 12, 'B001-0482', 'VENTA BE B001-0482 | EFECTIVO', '34.00', 1, 22, 157, 1, 1, 1, 1, 65, 1),
(58, '2019-01-18 14:50:43', '2019-01-18 14:50:43', 1, 1, 1, '2019-01-18', 12, 'B001-0483', 'VENTA BE B001-0483 | EFECTIVO', '22.00', 1, 22, 157, 9, 1, 1, 1, 66, 1),
(59, '2019-01-18 14:51:28', '2019-01-18 14:51:28', 1, 1, 1, '2019-01-18', 11, 'F001-00069', 'VENTA FE F001-00069 | EFECTIVO', '22.00', 1, 22, 157, 8, 1, 1, 1, 67, 1),
(60, '2019-01-18 14:52:47', '2019-01-18 14:52:47', 1, 1, 1, '2019-01-18', 12, 'B001-0484', 'VENTA BE B001-0484 | EFECTIVO', '58.00', 1, 22, 157, 7, 1, 1, 1, 68, 1),
(61, '2019-01-18 15:01:19', '2019-01-18 15:01:19', 1, 1, 1, '2019-01-18', 12, 'B001-0485', 'VENTA BE B001-0485 | EFECTIVO', '22.00', 1, 22, 157, 9, 1, 1, 1, 69, 1),
(62, '2019-01-18 15:02:43', '2019-01-18 15:02:43', 1, 1, 1, '2019-01-18', 11, 'F001-00070', 'VENTA FE F001-00070 | EFECTIVO', '22.00', 1, 22, 157, 8, 1, 1, 1, 70, 1),
(63, '2019-01-18 15:17:11', '2019-01-18 15:17:11', 1, 1, 1, '2019-01-18', 12, 'B001-0486', 'VENTA BE B001-0486 | EFECTIVO', '20.00', 1, 22, 157, 3, 1, 1, 1, 71, 1),
(64, '2019-01-18 15:18:50', '2019-01-18 15:18:50', 1, 1, 1, '2019-01-18', 11, 'F001-00071', 'VENTA FE F001-00071 | EFECTIVO', '30.00', 1, 22, 157, 8, 1, 1, 1, 72, 1),
(65, '2019-01-18 16:10:33', '2019-01-18 16:10:33', 1, 1, 1, '2019-01-18', 12, 'B001-0487', 'VENTA BE B001-0487 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 73, 1),
(66, '2019-01-18 16:11:41', '2019-01-18 16:11:41', 1, 1, 1, '2019-01-18', 11, 'F001-00072', 'VENTA FE F001-00072 | EFECTIVO', '23.00', 1, 22, 157, 8, 1, 1, 1, 74, 1),
(67, '2019-01-18 16:28:28', '2019-01-18 16:28:28', 1, 1, 1, '2019-01-18', 12, 'B001-0488', 'VENTA BE B001-0488 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 75, 1),
(68, '2019-01-18 16:29:46', '2019-01-18 16:29:46', 1, 1, 1, '2019-01-18', 12, 'B001-0489', 'VENTA BE B001-0489 | EFECTIVO', '43.00', 1, 22, 157, 1, 1, 1, 1, 76, 1),
(69, '2019-01-18 17:56:00', '2019-01-18 17:56:00', 1, 1, 1, '2019-01-18', 12, 'B001-0490', 'VENTA BE B001-0490 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 77, 1),
(70, '2019-01-18 18:37:59', '2019-01-18 18:37:59', 1, 1, 1, '2019-01-18', 12, 'B001-0491', 'VENTA BE B001-0491 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 78, 1),
(71, '2019-01-18 20:32:33', '2019-01-18 20:32:33', 1, 1, 1, '2019-01-18', 12, 'B001-0492', 'VENTA BE B001-0492 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 79, 1),
(72, '2019-01-18 20:39:52', '2019-01-18 20:39:52', 1, 1, 1, '2019-01-18', 12, 'B001-0493', 'VENTA BE B001-0493 | EFECTIVO', '36.00', 1, 22, 157, 1, 1, 1, 1, 80, 1),
(73, '2019-01-19 13:12:10', '2019-01-19 13:12:10', 1, 1, 1, '2019-01-19', 12, 'B001-0494', 'VENTA BE B001-0494 | EFECTIVO', '25.00', 1, 22, 157, 7, 1, 1, 1, 81, 1),
(74, '2019-01-20 13:05:33', '2019-01-20 13:05:33', 1, 1, 1, '2019-01-20', 12, 'B001-0495', 'VENTA BE B001-0495 | EFECTIVO', '25.00', 1, 22, 157, 7, 1, 1, 1, 82, 1),
(75, '2019-01-20 13:06:34', '2019-01-20 13:06:34', 1, 1, 1, '2019-01-20', 12, 'B001-0496', 'VENTA BE B001-0496 | EFECTIVO', '25.00', 1, 22, 157, 10, 1, 1, 1, 83, 1),
(76, '2019-01-20 13:31:37', '2019-01-20 13:31:37', 1, 1, 1, '2019-01-20', 12, 'B001-0497', 'VENTA BE B001-0497 | EFECTIVO', '25.00', 1, 22, 157, 7, 1, 1, 1, 84, 1),
(77, '2019-01-20 13:32:25', '2019-01-20 13:32:25', 1, 1, 1, '2019-01-20', 12, 'B001-0498', 'VENTA BE B001-0498 | EFECTIVO', '3300.00', 1, 22, 157, 10, 1, 1, 1, 85, 1),
(78, '2019-01-20 13:35:41', '2019-01-20 13:35:41', 1, 1, 1, '2019-01-20', 12, 'B001-0499', 'VENTA BE B001-0499 | EFECTIVO', '15.00', 1, 22, 157, 11, 1, 1, 1, 86, 1),
(79, '2019-01-20 13:39:28', '2019-01-20 13:39:28', 1, 1, 1, '2019-01-20', 12, 'B001-0500', 'VENTA BE B001-0500 | EFECTIVO', '77.00', 1, 22, 157, 12, 1, 1, 1, 87, 1),
(80, '2019-01-20 13:43:43', '2019-01-20 13:43:43', 1, 1, 1, '2019-01-20', 12, 'B001-0501', 'VENTA BE B001-0501 | EFECTIVO', '25.00', 1, 22, 157, 7, 1, 1, 1, 88, 1),
(81, '2019-01-20 13:46:39', '2019-01-20 13:46:39', 1, 1, 1, '2019-01-20', 12, 'B001-0502', 'VENTA BE B001-0502 | EFECTIVO', '10.00', 1, 22, 157, 13, 1, 1, 1, 89, 1),
(82, '2019-01-20 21:41:01', '2019-01-20 21:41:01', 1, 1, 1, '2019-01-20', 12, 'B001-0503', 'VENTA BE B001-0503 | EFECTIVO', '25.00', 1, 22, 157, 7, 1, 1, 1, 90, 1),
(83, '2019-01-22 16:13:43', '2019-01-22 16:13:43', 1, 1, 1, '2019-01-22', 12, 'B001-0504', 'VENTA BE B001-0504 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 91, 1),
(84, '2019-01-22 16:14:02', '2019-01-22 16:14:02', 1, 1, 1, '2019-01-22', 12, 'B001-0505', 'VENTA BE B001-0505 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 92, 1),
(85, '2019-01-22 16:14:27', '2019-01-22 16:14:27', 1, 1, 1, '2019-01-22', 12, 'B001-0506', 'VENTA BE B001-0506 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 93, 1),
(86, '2019-01-22 16:16:40', '2019-01-22 16:16:40', 1, 1, 1, '2019-01-22', 12, 'B001-0507', 'VENTA BE B001-0507 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 94, 1),
(87, '2019-01-22 16:21:59', '2019-01-22 16:21:59', 1, 1, 1, '2019-01-22', 12, 'B001-0508', 'VENTA BE B001-0508 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 95, 1),
(88, '2019-01-22 16:32:06', '2019-01-22 16:32:06', 1, 1, 1, '2019-01-22', 12, 'B001-0509', 'VENTA BE B001-0509 | EFECTIVO', '23.00', 1, 22, 157, 1, 1, 1, 1, 96, 1),
(89, '2019-01-22 21:33:46', '2019-01-22 21:33:46', 1, 1, 1, '2019-01-22', 12, 'B001-0510', 'VENTA BE B001-0510 | EFECTIVO', '45.00', 1, 22, 157, 7, 1, 1, 1, 97, 1),
(90, '2019-01-22 21:34:21', '2019-01-22 21:34:21', 1, 1, 1, '2019-01-22', 12, 'B001-0511', 'VENTA BE B001-0511 | EFECTIVO', '30.00', 1, 22, 157, 14, 1, 1, 1, 98, 1),
(91, '2019-01-22 21:34:58', '2019-01-22 21:34:58', 1, 1, 1, '2019-01-22', 12, 'B001-0512', 'VENTA BE B001-0512 | EFECTIVO', '35.00', 1, 22, 157, 15, 1, 1, 1, 99, 1),
(92, '2019-01-23 11:06:35', '2019-01-23 11:06:35', 1, 1, 1, '2019-01-23', 12, 'B001-0513', 'VENTA BE B001-0513 | EFECTIVO', '106.20', 1, 22, 157, 3, 1, 1, 1, 100, 1),
(93, '2019-01-23 11:09:54', '2019-01-23 11:09:54', 1, 1, 1, '2019-01-23', 12, 'B001-0514', 'VENTA BE B001-0514 | EFECTIVO', '30.00', 1, 22, 157, 3, 1, 1, 1, 101, 1),
(94, '2019-01-23 11:10:45', '2019-01-23 11:10:45', 1, 1, 1, '2019-01-23', 12, 'B001-0515', 'VENTA BE B001-0515 | EFECTIVO', '33.00', 1, 22, 157, 1, 1, 1, 1, 102, 1),
(95, '2019-01-26 16:35:44', '2019-01-26 16:35:44', 1, 1, 1, '2019-01-26', 12, 'B001-0516', 'VENTA BE B001-0516 | EFECTIVO', '40.00', 1, 22, 157, 16, 1, 1, 1, 103, 1),
(96, '2019-01-26 16:41:57', '2019-01-26 17:28:24', 1, 1, 0, '2019-01-26', 11, 'F001-00073', 'VENTA FE F001-00073 | EFECTIVO', '40.00', 1, 22, 157, 18, 1, 1, 1, 104, 1),
(97, '2019-01-26 16:49:01', '2019-01-26 16:49:01', 1, 1, 1, '2019-01-26', 15, 'NS01-00001', 'VENTA NS NS01-00001 | EFECTIVO', '20.00', 1, 22, 157, 19, 1, 1, 1, 105, 1),
(98, '2019-01-26 16:50:42', '2019-01-26 17:26:39', 1, 1, 0, '2019-01-26', 12, 'B001-0517', 'VENTA BE B001-0517 | EFECTIVO', '25.00', 1, 22, 157, 20, 1, 1, 1, 106, 1),
(99, '2019-01-26 16:51:47', '2019-01-26 16:51:47', 1, 1, 1, '2019-01-26', 12, 'B001-0518', 'VENTA BE B001-0518 | EFECTIVO', '30.00', 1, 22, 157, 21, 1, 1, 1, 107, 1),
(100, '2019-01-26 17:06:16', '2019-01-26 17:06:16', 1, 1, 1, '2019-01-26', 12, 'B001-0519', 'VENTA BE B001-0519 | EFECTIVO', '22.00', 1, 22, 157, 19, 1, 1, 1, 108, 1),
(101, '2019-01-26 17:16:48', '2019-01-26 17:16:48', 1, 1, 1, '2019-01-26', 8, '000000', 'SALIDA CAROO 07', '15.00', 1, 28, 0, 5, 1, 1, 0, 0, 1),
(102, '2019-01-30 15:48:03', '2019-01-30 15:48:03', 1, 1, 1, '2019-01-30', 12, 'B001-0520', 'VENTA BE B001-0520 | EFECTIVO', '30.00', 1, 22, 157, 22, 1, 1, 1, 109, 1),
(103, '2019-01-30 15:49:50', '2019-01-30 15:49:50', 1, 1, 1, '2019-01-30', 11, 'F001-00074', 'VENTA FE F001-00074 | EFECTIVO', '34.00', 1, 22, 157, 18, 1, 1, 1, 110, 1),
(104, '2019-01-30 15:53:21', '2019-01-30 15:53:21', 1, 1, 1, '2019-01-30', 12, 'B001-0521', 'VENTA BE B001-0521 | EFECTIVO', '60.00', 1, 22, 157, 7, 1, 1, 1, 111, 1),
(105, '2019-01-30 16:34:42', '2019-01-30 16:34:42', 1, 1, 1, '2019-01-30', 11, 'F001-00075', 'VENTA FE F001-00075 | EFECTIVO', '15.00', 1, 22, 157, 8, 1, 1, 1, 112, 1),
(106, '2019-01-30 16:45:04', '2019-01-30 16:45:04', 1, 1, 1, '2019-01-30', 12, 'B001-0522', 'VENTA BE B001-0522 | EFECTIVO', '20.00', 1, 22, 157, 7, 1, 1, 1, 113, 1),
(107, '2019-01-30 17:12:39', '2019-01-30 17:12:39', 1, 1, 1, '2019-01-30', 12, 'B001-0523', 'VENTA BE B001-0523 | EFECTIVO', '106.20', 1, 22, 157, 20, 1, 1, 1, 114, 1),
(108, '2019-01-30 19:46:09', '2019-01-30 19:46:09', 1, 1, 1, '2019-01-30', 11, 'F001-00076', 'VENTA FE F001-00076 | EFECTIVO', '12.00', 1, 22, 157, 8, 1, 1, 1, 115, 1),
(109, '2019-01-30 19:54:18', '2019-01-30 19:54:18', 1, 1, 1, '2019-01-30', 11, 'F001-00077', 'VENTA FE F001-00077 | EFECTIVO', '100.00', 1, 22, 157, 18, 1, 1, 1, 116, 1),
(110, '2019-01-30 20:50:48', '2019-01-30 20:50:48', 1, 1, 1, '2019-01-30', 11, 'F001-00078', 'VENTA FE F001-00078 | EFECTIVO', '7.50', 1, 22, 157, 18, 1, 1, 1, 1, 1),
(111, '2019-01-30 21:19:24', '2019-01-30 21:19:24', 1, 1, 1, '2019-01-30', 11, 'F001-00079', 'VENTA FE F001-00079 | EFECTIVO', '7.50', 1, 22, 157, 8, 1, 1, 1, 2, 1),
(112, '2019-01-30 21:26:12', '2019-01-30 21:26:12', 1, 1, 1, '2019-01-30', 11, 'F001-00080', 'VENTA FE F001-00080 | EFECTIVO', '7.50', 1, 22, 157, 18, 1, 1, 1, 3, 1),
(113, '2019-01-31 15:45:54', '2019-01-31 15:45:54', 1, 1, 1, '2019-01-31', 11, 'F001-00081', 'VENTA FE F001-00081 | EFECTIVO', '7.50', 1, 22, 157, 18, 1, 1, 1, 4, 1),
(114, '2019-01-31 16:24:18', '2019-01-31 16:24:18', 1, 1, 1, '2019-01-31', 12, 'B001-0524', 'VENTA BE B001-0524 | EFECTIVO', '5.00', 1, 22, 157, 7, 1, 1, 1, 5, 1),
(115, '2019-01-31 16:27:28', '2019-01-31 16:27:28', 1, 1, 1, '2019-01-31', 12, 'B001-0525', 'VENTA BE B001-0525 | EFECTIVO', '10.00', 1, 22, 157, 7, 1, 1, 1, 6, 1),
(116, '2019-01-31 16:55:35', '2019-01-31 16:55:35', 1, 1, 1, '2019-01-31', 12, 'B001-0526', 'VENTA BE B001-0526 | EFECTIVO', '15.00', 1, 22, 157, 7, 1, 1, 1, 7, 1),
(117, '2019-01-31 17:18:46', '2019-01-31 17:18:46', 1, 1, 1, '2019-01-31', 12, 'B001-0527', 'VENTA BE B001-0527 | EFECTIVO', '30.00', 1, 22, 157, 3, 1, 1, 1, 8, 1),
(118, '2019-01-31 18:24:24', '2019-01-31 18:24:24', 1, 1, 1, '2019-01-31', 12, 'B001-0528', 'VENTA BE B001-0528 | EFECTIVO', '30.00', 1, 22, 157, 24, 1, 1, 1, 9, 1),
(119, '2019-02-20 10:53:12', '2019-02-20 10:53:12', 1, 1, 1, '2019-02-20', 15, 'NS01-00002', 'VENTA NS NS01-00002 | EFECTIVO', '34.00', 1, 22, 157, 1, 1, 1, 1, 10, 1),
(120, '2019-02-20 10:53:34', '2019-02-20 10:53:34', 1, 1, 1, '2019-02-20', 12, 'B001-0529', 'VENTA BE B001-0529 | EFECTIVO', '34.00', 1, 22, 157, 1, 1, 1, 1, 11, 1),
(121, '2019-06-10 21:37:35', '2019-06-10 21:37:35', 1, 1, 1, '2019-06-10', 12, 'B001-0530', 'VENTA BE B001-0530 | EFECTIVO', '100.00', 1, 22, 157, 16, 1, 1, 1, 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ingreso_r`
--

CREATE TABLE `tb_ingreso_r` (
  `tb_ingreso_id` int(11) NOT NULL,
  `tb_ingreso_fecreg` datetime NOT NULL,
  `tb_ingreso_fecmod` datetime NOT NULL,
  `tb_ingreso_fecemi` date NOT NULL,
  `tb_ingreso_feccon` date NOT NULL,
  `tb_ingreso_doc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ingreso_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_ingreso_mon` decimal(11,2) NOT NULL,
  `tb_ingreso_est` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL,
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_entfinanciera_id` int(11) NOT NULL,
  `tb_ingreso_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_referencia_id` int(11) NOT NULL,
  `tb_transferencia_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_usuario_id_reg` int(11) NOT NULL,
  `tb_usuario_id_mod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_kardex`
--

CREATE TABLE `tb_kardex` (
  `tb_kardex_id` int(11) NOT NULL,
  `tb_kardex_xac` tinyint(1) NOT NULL,
  `tb_kardex_reg` datetime NOT NULL,
  `tb_kardex_tipreg` tinyint(11) NOT NULL COMMENT '1:automatico 2:manual',
  `tb_kardex_cod` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT '99-9999-99999',
  `tb_kardex_fec` date NOT NULL,
  `tb_kardex_tip` tinyint(4) NOT NULL COMMENT '1:entrada 2:salida',
  `tb_documento_id` int(11) NOT NULL,
  `tb_kardex_numdoc` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_tipoperacion_id` int(11) NOT NULL,
  `tb_kardex_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_operacion_id` int(11) NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_kardex`
--

INSERT INTO `tb_kardex` (`tb_kardex_id`, `tb_kardex_xac`, `tb_kardex_reg`, `tb_kardex_tipreg`, `tb_kardex_cod`, `tb_kardex_fec`, `tb_kardex_tip`, `tb_documento_id`, `tb_kardex_numdoc`, `tb_tipoperacion_id`, `tb_kardex_des`, `tb_operacion_id`, `tb_almacen_id`, `tb_usuario_id`, `tb_empresa_id`) VALUES
(1, 1, '2019-01-12 13:26:44', 1, '1', '2019-01-12', 2, 12, 'B001-0426', 3, 'VENTA', 1, 1, 0, 1),
(2, 1, '2019-01-13 20:42:51', 1, '2', '2019-01-13', 2, 12, 'B001-0431', 3, 'VENTA', 6, 1, 0, 1),
(3, 1, '2019-01-13 20:46:17', 1, '3', '2019-01-13', 2, 12, 'B001-0432', 3, 'VENTA', 7, 1, 0, 1),
(4, 1, '2019-01-14 18:21:19', 1, '4', '2019-01-14', 2, 12, 'B001-0433', 3, 'VENTA', 8, 1, 0, 1),
(5, 1, '2019-01-14 18:25:43', 1, '5', '2019-01-14', 2, 12, 'B001-0434', 3, 'VENTA', 9, 1, 0, 1),
(6, 1, '2019-01-14 19:32:20', 1, '6', '2019-01-14', 2, 12, 'B001-0439', 3, 'VENTA', 14, 1, 0, 1),
(7, 1, '2019-01-14 19:39:04', 1, '7', '2019-01-14', 2, 12, 'B001-0440', 3, 'VENTA', 15, 1, 0, 1),
(8, 1, '2019-01-14 19:46:53', 1, '8', '2019-01-14', 2, 12, 'B001-0441', 3, 'VENTA', 16, 1, 0, 1),
(9, 1, '2019-01-14 19:59:38', 1, '9', '2019-01-14', 2, 12, 'B001-0442', 3, 'VENTA', 17, 1, 0, 1),
(10, 1, '2019-01-14 20:07:54', 1, '10', '2019-01-14', 2, 12, 'B001-0443', 3, 'VENTA', 18, 1, 0, 1),
(11, 1, '2019-01-14 20:10:33', 1, '11', '2019-01-14', 2, 12, 'B001-0444', 3, 'VENTA', 19, 1, 0, 1),
(12, 1, '2019-01-14 20:13:28', 1, '12', '2019-01-14', 2, 12, 'B001-0445', 3, 'VENTA', 20, 1, 0, 1),
(13, 1, '2019-01-14 20:14:05', 1, '13', '2019-01-14', 2, 12, 'B001-0446', 3, 'VENTA', 21, 1, 0, 1),
(14, 1, '2019-01-14 20:21:33', 1, '14', '2019-01-14', 2, 12, 'B001-0447', 3, 'VENTA', 22, 1, 0, 1),
(15, 1, '2019-01-14 20:24:14', 1, '15', '2019-01-14', 2, 12, 'B001-0448', 3, 'VENTA', 23, 1, 0, 1),
(16, 1, '2019-01-14 20:27:37', 1, '16', '2019-01-14', 2, 12, 'B001-0449', 3, 'VENTA', 24, 1, 0, 1),
(17, 1, '2019-01-14 20:34:56', 1, '17', '2019-01-14', 2, 12, 'B001-0450', 3, 'VENTA', 25, 1, 0, 1),
(18, 1, '2019-01-15 10:37:36', 1, '18', '2019-01-15', 2, 12, 'B001-0451', 3, 'VENTA', 26, 1, 0, 1),
(19, 1, '2019-01-15 10:47:31', 1, '19', '2019-01-15', 2, 12, 'B001-0452', 3, 'VENTA', 27, 1, 0, 1),
(20, 1, '2019-01-15 10:49:25', 1, '20', '2019-01-15', 2, 12, 'B001-0453', 3, 'VENTA', 28, 1, 0, 1),
(21, 1, '2019-01-15 10:52:18', 1, '21', '2019-01-15', 2, 12, 'B001-0454', 3, 'VENTA', 29, 1, 0, 1),
(22, 1, '2019-01-15 10:56:21', 1, '22', '2019-01-15', 2, 12, 'B001-0455', 3, 'VENTA', 30, 1, 0, 1),
(23, 1, '2019-01-14 11:12:49', 1, '23', '2019-01-14', 2, 12, 'B001-0456', 3, 'VENTA', 31, 1, 0, 1),
(24, 1, '2019-01-14 11:13:30', 1, '24', '2019-01-14', 2, 12, 'B001-0457', 3, 'VENTA', 32, 1, 0, 1),
(25, 1, '2019-01-14 11:14:48', 1, '25', '2019-01-14', 2, 12, 'B001-0458', 3, 'VENTA', 33, 1, 0, 1),
(26, 1, '2019-01-14 11:17:55', 1, '26', '2019-01-14', 2, 12, 'B001-0459', 3, 'VENTA', 34, 1, 0, 1),
(27, 1, '2019-01-15 11:21:55', 1, '27', '2019-01-15', 2, 12, 'B001-0460', 3, 'VENTA', 35, 1, 0, 1),
(28, 1, '2019-01-15 11:23:40', 1, '28', '2019-01-15', 2, 12, 'B001-0461', 3, 'VENTA', 36, 1, 0, 1),
(29, 1, '2019-01-15 11:24:29', 1, '29', '2019-01-15', 2, 12, 'B001-0462', 3, 'VENTA', 37, 1, 0, 1),
(30, 1, '2019-01-15 11:26:31', 1, '30', '2019-01-15', 2, 12, 'B001-0463', 3, 'VENTA', 38, 1, 0, 1),
(31, 1, '2019-01-15 11:30:28', 1, '31', '2019-01-15', 2, 12, 'B001-0464', 3, 'VENTA', 39, 1, 0, 1),
(32, 1, '2019-01-15 13:07:26', 1, '32', '2019-01-15', 2, 12, 'B001-0465', 3, 'VENTA', 40, 1, 0, 1),
(33, 1, '2019-01-15 13:15:19', 1, '33', '2019-01-15', 2, 12, 'B001-0466', 3, 'VENTA', 41, 1, 0, 1),
(34, 1, '2019-01-15 13:28:42', 1, '34', '2019-01-15', 2, 12, 'B001-0467', 3, 'VENTA', 42, 1, 0, 1),
(35, 1, '2019-01-15 15:32:08', 1, '35', '2019-01-15', 2, 12, 'B001-0468', 3, 'VENTA', 43, 1, 0, 1),
(36, 1, '2019-01-15 15:43:25', 1, '36', '2019-01-15', 2, 12, 'B001-0469', 3, 'VENTA', 44, 1, 0, 1),
(37, 1, '2019-01-15 15:59:24', 1, '37', '2019-01-15', 2, 12, 'B001-0470', 3, 'VENTA', 45, 1, 0, 1),
(38, 1, '2019-01-15 15:59:56', 1, '38', '2019-01-15', 2, 12, 'B001-0471', 3, 'VENTA', 46, 1, 0, 1),
(39, 1, '2019-01-15 16:00:11', 1, '39', '2019-01-15', 2, 12, 'B001-0472', 3, 'VENTA', 47, 1, 0, 1),
(40, 1, '2019-01-15 17:08:52', 1, '40', '2019-01-15', 2, 12, 'B001-0473', 3, 'VENTA', 48, 1, 0, 1),
(41, 1, '2019-01-15 18:50:48', 1, '41', '2019-01-15', 2, 12, 'B001-0474', 3, 'VENTA', 49, 1, 0, 1),
(42, 1, '2019-01-16 15:01:00', 1, '42', '2019-01-16', 2, 12, 'B001-0475', 3, 'VENTA', 50, 1, 0, 1),
(43, 1, '2019-01-16 18:49:43', 1, '43', '2019-01-16', 2, 11, 'F001-00065', 3, 'VENTA', 51, 1, 0, 1),
(44, 1, '2019-01-16 19:05:51', 1, '44', '2019-01-16', 2, 12, 'B001-0476', 3, 'VENTA', 52, 1, 0, 1),
(45, 1, '2019-01-17 13:16:11', 1, '45', '2019-01-17', 2, 12, 'B001-0477', 3, 'VENTA', 53, 1, 0, 1),
(46, 1, '2019-01-17 13:17:57', 1, '46', '2019-01-17', 2, 12, 'B001-0478', 3, 'VENTA', 54, 1, 0, 1),
(47, 1, '2019-01-17 13:19:55', 1, '47', '2019-01-17', 2, 12, 'B001-0479', 3, 'VENTA', 55, 1, 0, 1),
(48, 1, '2019-01-17 13:29:04', 1, '48', '2019-01-17', 2, 11, 'F001-00066', 3, 'VENTA', 56, 1, 0, 1),
(49, 1, '2019-01-17 17:27:31', 1, '49', '2019-01-17', 2, 12, 'B001-0480', 3, 'VENTA', 57, 1, 0, 1),
(50, 1, '2019-01-17 19:40:24', 1, '50', '2019-01-17', 2, 12, 'B001-0481', 3, 'VENTA', 58, 1, 0, 1),
(51, 1, '2019-01-17 19:53:04', 1, '51', '2019-01-17', 2, 11, 'F001-00067', 3, 'VENTA', 59, 1, 0, 1),
(52, 1, '2019-01-17 19:59:54', 1, '52', '2019-01-17', 2, 11, 'F001-00068', 3, 'VENTA', 60, 1, 0, 1),
(53, 1, '2019-01-17 21:12:34', 1, '53', '2019-01-17', 2, 12, 'B001-0101', 3, 'VENTA', 61, 1, 0, 1),
(54, 1, '2019-01-17 21:18:35', 1, '54', '2019-01-17', 2, 12, 'B001-0102', 3, 'VENTA', 62, 1, 0, 1),
(55, 1, '2019-01-17 21:24:18', 1, '55', '2019-01-17', 2, 12, 'B001-0103', 3, 'VENTA', 63, 1, 0, 1),
(56, 1, '2019-01-17 21:38:00', 1, '56', '2019-01-17', 2, 12, 'B001-0104', 3, 'VENTA', 64, 1, 0, 1),
(57, 1, '2019-01-18 13:26:08', 1, '57', '2019-01-18', 2, 12, 'B001-0482', 3, 'VENTA', 65, 1, 0, 1),
(58, 1, '2019-01-18 14:50:44', 1, '58', '2019-01-18', 2, 12, 'B001-0483', 3, 'VENTA', 66, 1, 0, 1),
(59, 1, '2019-01-18 14:51:29', 1, '59', '2019-01-18', 2, 11, 'F001-00069', 3, 'VENTA', 67, 1, 0, 1),
(60, 1, '2019-01-18 14:52:47', 1, '60', '2019-01-18', 2, 12, 'B001-0484', 3, 'VENTA', 68, 1, 0, 1),
(61, 1, '2019-01-18 15:01:19', 1, '61', '2019-01-18', 2, 12, 'B001-0485', 3, 'VENTA', 69, 1, 0, 1),
(62, 1, '2019-01-18 15:02:44', 1, '62', '2019-01-18', 2, 11, 'F001-00070', 3, 'VENTA', 70, 1, 0, 1),
(63, 1, '2019-01-18 15:17:11', 1, '63', '2019-01-18', 2, 12, 'B001-0486', 3, 'VENTA', 71, 1, 0, 1),
(64, 1, '2019-01-18 15:18:50', 1, '64', '2019-01-18', 2, 11, 'F001-00071', 3, 'VENTA', 72, 1, 0, 1),
(65, 1, '2019-01-18 16:10:33', 1, '65', '2019-01-18', 2, 12, 'B001-0487', 3, 'VENTA', 73, 1, 0, 1),
(66, 1, '2019-01-18 16:11:41', 1, '66', '2019-01-18', 2, 11, 'F001-00072', 3, 'VENTA', 74, 1, 0, 1),
(67, 1, '2019-01-18 16:28:29', 1, '67', '2019-01-18', 2, 12, 'B001-0488', 3, 'VENTA', 75, 1, 0, 1),
(68, 1, '2019-01-18 16:29:47', 1, '68', '2019-01-18', 2, 12, 'B001-0489', 3, 'VENTA', 76, 1, 0, 1),
(69, 1, '2019-01-18 17:56:00', 1, '69', '2019-01-18', 2, 12, 'B001-0490', 3, 'VENTA', 77, 1, 0, 1),
(70, 1, '2019-01-18 18:37:59', 1, '70', '2019-01-18', 2, 12, 'B001-0491', 3, 'VENTA', 78, 1, 0, 1),
(71, 1, '2019-01-18 20:32:33', 1, '71', '2019-01-18', 2, 12, 'B001-0492', 3, 'VENTA', 79, 1, 0, 1),
(72, 1, '2019-01-18 20:39:52', 1, '72', '2019-01-18', 2, 12, 'B001-0493', 3, 'VENTA', 80, 1, 0, 1),
(73, 1, '2019-01-19 13:12:10', 1, '73', '2019-01-19', 2, 12, 'B001-0494', 3, 'VENTA', 81, 1, 0, 1),
(74, 1, '2019-01-20 13:05:33', 1, '74', '2019-01-20', 2, 12, 'B001-0495', 3, 'VENTA', 82, 1, 0, 1),
(75, 1, '2019-01-20 13:06:34', 1, '75', '2019-01-20', 2, 12, 'B001-0496', 3, 'VENTA', 83, 1, 0, 1),
(76, 1, '2019-01-20 13:31:37', 1, '76', '2019-01-20', 2, 12, 'B001-0497', 3, 'VENTA', 84, 1, 0, 1),
(77, 1, '2019-01-20 13:32:25', 1, '77', '2019-01-20', 2, 12, 'B001-0498', 3, 'VENTA', 85, 1, 0, 1),
(78, 1, '2019-01-20 13:35:42', 1, '78', '2019-01-20', 2, 12, 'B001-0499', 3, 'VENTA', 86, 1, 0, 1),
(79, 1, '2019-01-20 13:39:28', 1, '79', '2019-01-20', 2, 12, 'B001-0500', 3, 'VENTA', 87, 1, 0, 1),
(80, 1, '2019-01-20 13:43:43', 1, '80', '2019-01-20', 2, 12, 'B001-0501', 3, 'VENTA', 88, 1, 0, 1),
(81, 1, '2019-01-20 13:46:40', 1, '81', '2019-01-20', 2, 12, 'B001-0502', 3, 'VENTA', 89, 1, 0, 1),
(82, 1, '2019-01-20 21:41:01', 1, '82', '2019-01-20', 2, 12, 'B001-0503', 3, 'VENTA', 90, 1, 0, 1),
(83, 1, '2019-01-22 16:13:44', 1, '83', '2019-01-22', 2, 12, 'B001-0504', 3, 'VENTA', 91, 1, 0, 1),
(84, 1, '2019-01-22 16:14:03', 1, '84', '2019-01-22', 2, 12, 'B001-0505', 3, 'VENTA', 92, 1, 0, 1),
(85, 1, '2019-01-22 16:14:28', 1, '85', '2019-01-22', 2, 12, 'B001-0506', 3, 'VENTA', 93, 1, 0, 1),
(86, 1, '2019-01-22 16:16:41', 1, '86', '2019-01-22', 2, 12, 'B001-0507', 3, 'VENTA', 94, 1, 0, 1),
(87, 1, '2019-01-22 16:21:59', 1, '87', '2019-01-22', 2, 12, 'B001-0508', 3, 'VENTA', 95, 1, 0, 1),
(88, 1, '2019-01-22 16:32:07', 1, '88', '2019-01-22', 2, 12, 'B001-0509', 3, 'VENTA', 96, 1, 0, 1),
(89, 1, '2019-01-22 21:33:46', 1, '89', '2019-01-22', 2, 12, 'B001-0510', 3, 'VENTA', 97, 1, 0, 1),
(90, 1, '2019-01-22 21:34:21', 1, '90', '2019-01-22', 2, 12, 'B001-0511', 3, 'VENTA', 98, 1, 0, 1),
(91, 1, '2019-01-22 21:34:58', 1, '91', '2019-01-22', 2, 12, 'B001-0512', 3, 'VENTA', 99, 1, 0, 1),
(92, 1, '2019-01-23 11:06:36', 1, '92', '2019-01-23', 2, 12, 'B001-0513', 3, 'VENTA', 100, 1, 0, 1),
(93, 1, '2019-01-23 11:09:55', 1, '93', '2019-01-23', 2, 12, 'B001-0514', 3, 'VENTA', 101, 1, 0, 1),
(94, 1, '2019-01-23 11:10:46', 1, '94', '2019-01-23', 2, 12, 'B001-0515', 3, 'VENTA', 102, 1, 0, 1),
(95, 1, '2019-01-26 21:35:44', 1, '95', '2019-01-26', 2, 12, 'B001-0516', 3, 'VENTA', 103, 1, 0, 1),
(96, 0, '2019-01-26 21:41:57', 1, '96', '2019-01-26', 2, 11, 'F001-00073', 3, 'VENTA', 104, 1, 0, 1),
(97, 1, '2019-01-26 21:49:01', 1, '97', '2019-01-26', 2, 15, 'NS01-00001', 3, 'VENTA', 105, 1, 0, 1),
(98, 0, '2019-01-26 21:50:42', 1, '98', '2019-01-26', 2, 12, 'B001-0517', 3, 'VENTA', 106, 1, 0, 1),
(99, 1, '2019-01-26 21:51:47', 1, '99', '2019-01-26', 2, 12, 'B001-0518', 3, 'VENTA', 107, 1, 0, 1),
(100, 1, '2019-01-26 22:06:16', 1, '100', '2019-01-26', 2, 12, 'B001-0519', 3, 'VENTA', 108, 1, 0, 1),
(101, 1, '2019-01-30 20:48:03', 1, '101', '2019-01-30', 2, 12, 'B001-0520', 3, 'VENTA', 109, 1, 0, 1),
(102, 1, '2019-01-30 20:49:50', 1, '102', '2019-01-30', 2, 11, 'F001-00074', 3, 'VENTA', 110, 1, 0, 1),
(103, 1, '2019-01-30 20:53:21', 1, '103', '2019-01-30', 2, 12, 'B001-0521', 3, 'VENTA', 111, 1, 0, 1),
(104, 1, '2019-01-30 21:34:42', 1, '104', '2019-01-30', 2, 11, 'F001-00075', 3, 'VENTA', 112, 1, 0, 1),
(105, 1, '2019-01-30 21:45:04', 1, '105', '2019-01-30', 2, 12, 'B001-0522', 3, 'VENTA', 113, 1, 0, 1),
(106, 1, '2019-01-30 17:12:39', 1, '106', '2019-01-30', 2, 12, 'B001-0523', 3, 'VENTA', 114, 1, 0, 1),
(107, 1, '2019-01-30 19:46:09', 1, '107', '2019-01-30', 2, 11, 'F001-00076', 3, 'VENTA', 115, 1, 0, 1),
(108, 1, '2019-01-30 19:54:18', 1, '108', '2019-01-30', 2, 11, 'F001-00077', 3, 'VENTA', 116, 1, 0, 1),
(109, 1, '2019-01-30 20:50:48', 1, '109', '2019-01-30', 2, 11, 'F001-00078', 3, 'VENTA', 1, 1, 0, 1),
(110, 1, '2019-01-30 21:19:24', 1, '110', '2019-01-30', 2, 11, 'F001-00079', 3, 'VENTA', 2, 1, 0, 1),
(111, 1, '2019-01-30 21:26:12', 1, '111', '2019-01-30', 2, 11, 'F001-00080', 3, 'VENTA', 3, 1, 0, 1),
(112, 1, '2019-01-31 15:45:54', 1, '112', '2019-01-31', 2, 11, 'F001-00081', 3, 'VENTA', 4, 1, 0, 1),
(113, 1, '2019-01-31 16:24:18', 1, '113', '2019-01-31', 2, 12, 'B001-0524', 3, 'VENTA', 5, 1, 0, 1),
(114, 1, '2019-01-31 16:27:29', 1, '114', '2019-01-31', 2, 12, 'B001-0525', 3, 'VENTA', 6, 1, 0, 1),
(115, 1, '2019-01-31 16:55:35', 1, '115', '2019-01-31', 2, 12, 'B001-0526', 3, 'VENTA', 7, 1, 0, 1),
(116, 1, '2019-01-31 17:18:46', 1, '116', '2019-01-31', 2, 12, 'B001-0527', 3, 'VENTA', 8, 1, 0, 1),
(117, 1, '2019-01-31 18:24:24', 1, '117', '2019-01-31', 2, 12, 'B001-0528', 3, 'VENTA', 9, 1, 0, 1),
(118, 1, '2019-02-20 10:53:14', 1, '118', '2019-02-20', 2, 15, 'NS01-00002', 3, 'VENTA', 10, 1, 0, 1),
(119, 1, '2019-02-20 10:53:36', 1, '119', '2019-02-20', 2, 12, 'B001-0529', 3, 'VENTA', 11, 1, 0, 1),
(120, 1, '2019-06-10 21:37:35', 1, '120', '2019-06-10', 2, 12, 'B001-0530', 3, 'VENTA', 12, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_kardexdetalle`
--

CREATE TABLE `tb_kardexdetalle` (
  `tb_kardexdetalle_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_kardexdetalle_can` decimal(8,2) NOT NULL,
  `tb_kardexdetalle_cos` decimal(8,2) NOT NULL,
  `tb_kardexdetalle_pre` decimal(8,2) NOT NULL,
  `tb_kardex_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_letras`
--

CREATE TABLE `tb_letras` (
  `tb_letras_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_letras_fecha` date NOT NULL,
  `tb_letras_monto` decimal(8,2) NOT NULL,
  `tb_letras_orden` int(11) NOT NULL,
  `tb_letras_numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_lote`
--

CREATE TABLE `tb_lote` (
  `tb_lote_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_lote_numero` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_lote_fechafab` date NOT NULL,
  `tb_lote_fechavence` date NOT NULL,
  `tb_lote_exisact` decimal(18,2) NOT NULL,
  `tb_lote_estado` int(11) NOT NULL,
  `tb_almacen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_lugar`
--

CREATE TABLE `tb_lugar` (
  `tb_lugar_id` int(11) NOT NULL,
  `tb_lugar_nom` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `tb_lugar_color` varchar(7) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tb_lugar`
--

INSERT INTO `tb_lugar` (`tb_lugar_id`, `tb_lugar_nom`, `tb_lugar_color`) VALUES
(1, 'Arequipa', '#fff120'),
(2, 'Secocha', '#ffffff'),
(3, 'Santo Tomas', '#ff20d9'),
(4, 'Camana', '#3278be');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_marca`
--

CREATE TABLE `tb_marca` (
  `tb_marca_id` int(11) NOT NULL,
  `tb_marca_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_marca`
--

INSERT INTO `tb_marca` (`tb_marca_id`, `tb_marca_nom`, `tb_empresa_id`) VALUES
(1, 'NA', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_modopago`
--

CREATE TABLE `tb_modopago` (
  `tb_modopago_id` int(11) NOT NULL,
  `tb_modopago_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_modopago`
--

INSERT INTO `tb_modopago` (`tb_modopago_id`, `tb_modopago_nom`) VALUES
(1, 'EFECTIVO'),
(2, 'DEPOSITO'),
(3, 'TARJETA'),
(4, 'CANJE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_modulo`
--

CREATE TABLE `tb_modulo` (
  `tb_modulo_id` int(11) NOT NULL,
  `tb_modulo_xac` tinyint(1) NOT NULL,
  `tb_modulo_nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tb_modulo`
--

INSERT INTO `tb_modulo` (`tb_modulo_id`, `tb_modulo_xac`, `tb_modulo_nom`) VALUES
(1, 1, 'VENTAS'),
(2, 1, 'COMPRAS'),
(3, 1, 'TRANSFERENCIA'),
(4, 1, 'NOTA VENTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notacredito`
--

CREATE TABLE `tb_notacredito` (
  `tb_venta_id` int(11) NOT NULL,
  `tb_venta_reg` datetime NOT NULL,
  `tb_venta_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_venta_numdoc` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_valven` decimal(8,2) NOT NULL,
  `tb_venta_des` decimal(8,2) NOT NULL,
  `tb_venta_igv` decimal(8,2) NOT NULL,
  `tb_venta_tot` decimal(8,2) NOT NULL,
  `tb_venta_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_tip` tinyint(1) NOT NULL,
  `tb_venta_mot` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_ventipdoc` int(2) NOT NULL,
  `tb_venta_vennumdoc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_venta_ser` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_num` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipomoneda_id` int(11) NOT NULL,
  `tb_venta_gra` decimal(8,2) NOT NULL,
  `tb_venta_ina` decimal(8,2) NOT NULL,
  `tb_venta_exo` decimal(8,2) NOT NULL,
  `tb_venta_grat` decimal(8,2) NOT NULL,
  `tb_venta_isc` decimal(8,2) NOT NULL,
  `tb_venta_otrtri` decimal(8,2) NOT NULL,
  `tb_venta_otrcar` decimal(8,2) NOT NULL,
  `tb_venta_desglo` decimal(8,2) NOT NULL,
  `cs_tipooperacion_id` int(11) NOT NULL,
  `cs_documentosrelacionados_id` int(11) NOT NULL,
  `tb_venta_faucod` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_digval` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_sigval` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_val` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_fecenvsun` datetime NOT NULL,
  `tb_venta_estsun` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notacreditocorreo`
--

CREATE TABLE `tb_notacreditocorreo` (
  `tb_ventacorreo_id` int(11) NOT NULL,
  `tb_ventacorreo_xac` tinyint(1) NOT NULL,
  `tb_ventacorreo_fecreg` datetime NOT NULL,
  `tb_ventacorreo_fecmod` datetime NOT NULL,
  `tb_ventacorreo_usureg` int(11) NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_ventacorreo_tip` tinyint(1) NOT NULL,
  `tb_ventacorreo_coremi` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_cor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_corcop` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_asu` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_men` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_adj` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notacreditodetalle`
--

CREATE TABLE `tb_notacreditodetalle` (
  `tb_ventadetalle_id` int(11) NOT NULL,
  `tb_ventadetalle_tipven` tinyint(4) NOT NULL COMMENT '1:Producto; 2: Servicio',
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL,
  `tb_ventadetalle_nom` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventadetalle_preuni` decimal(8,2) NOT NULL,
  `tb_ventadetalle_can` decimal(8,2) NOT NULL,
  `tb_ventadetalle_tipdes` tinyint(4) NOT NULL COMMENT '1:Porcentaje; 2:Soles',
  `tb_ventadetalle_des` decimal(8,2) NOT NULL,
  `tb_ventadetalle_preunilin` decimal(8,2) NOT NULL,
  `tb_ventadetalle_valven` decimal(8,2) NOT NULL,
  `tb_ventadetalle_igv` decimal(8,2) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `cs_tipounidadmedida_id` int(11) NOT NULL,
  `cs_tiposistemacalculoisc_id` int(11) NOT NULL,
  `tb_ventadetalle_isc` decimal(8,2) NOT NULL,
  `tb_ventadetalle_nro` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notadebito`
--

CREATE TABLE `tb_notadebito` (
  `tb_venta_id` int(11) NOT NULL,
  `tb_venta_reg` datetime NOT NULL,
  `tb_venta_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_venta_numdoc` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_valven` decimal(8,2) NOT NULL,
  `tb_venta_des` decimal(8,2) NOT NULL,
  `tb_venta_igv` decimal(8,2) NOT NULL,
  `tb_venta_tot` decimal(8,2) NOT NULL,
  `tb_venta_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_tip` tinyint(1) NOT NULL,
  `tb_venta_mot` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_ventipdoc` int(2) NOT NULL,
  `tb_venta_vennumdoc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_venta_ser` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_num` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipomoneda_id` int(11) NOT NULL,
  `tb_venta_gra` decimal(8,2) NOT NULL,
  `tb_venta_ina` decimal(8,2) NOT NULL,
  `tb_venta_exo` decimal(8,2) NOT NULL,
  `tb_venta_grat` decimal(8,2) NOT NULL,
  `tb_venta_isc` decimal(8,2) NOT NULL,
  `tb_venta_otrtri` decimal(8,2) NOT NULL,
  `tb_venta_otrcar` decimal(8,2) NOT NULL,
  `tb_venta_desglo` decimal(8,2) NOT NULL,
  `cs_tipooperacion_id` int(11) NOT NULL,
  `cs_documentosrelacionados_id` int(11) NOT NULL,
  `tb_venta_faucod` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_digval` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_sigval` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_val` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_fecenvsun` datetime NOT NULL,
  `tb_venta_estsun` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notadebitocorreo`
--

CREATE TABLE `tb_notadebitocorreo` (
  `tb_ventacorreo_id` int(11) NOT NULL,
  `tb_ventacorreo_xac` tinyint(1) NOT NULL,
  `tb_ventacorreo_fecreg` datetime NOT NULL,
  `tb_ventacorreo_fecmod` datetime NOT NULL,
  `tb_ventacorreo_usureg` int(11) NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_ventacorreo_tip` tinyint(1) NOT NULL,
  `tb_ventacorreo_coremi` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_cor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_corcop` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_asu` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_men` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_adj` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notadebitodetalle`
--

CREATE TABLE `tb_notadebitodetalle` (
  `tb_ventadetalle_id` int(11) NOT NULL,
  `tb_ventadetalle_tipven` tinyint(4) NOT NULL COMMENT '1:Producto; 2: Servicio',
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL,
  `tb_ventadetalle_nom` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventadetalle_preuni` decimal(8,2) NOT NULL,
  `tb_ventadetalle_can` decimal(8,2) NOT NULL,
  `tb_ventadetalle_tipdes` tinyint(4) NOT NULL COMMENT '1:Porcentaje; 2:Soles',
  `tb_ventadetalle_des` decimal(8,2) NOT NULL,
  `tb_ventadetalle_preunilin` decimal(8,2) NOT NULL,
  `tb_ventadetalle_valven` decimal(8,2) NOT NULL,
  `tb_ventadetalle_igv` decimal(8,2) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `cs_tipounidadmedida_id` int(11) NOT NULL,
  `cs_tiposistemacalculoisc_id` int(11) NOT NULL,
  `tb_ventadetalle_isc` decimal(8,2) NOT NULL,
  `tb_ventadetalle_nro` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notalmacen`
--

CREATE TABLE `tb_notalmacen` (
  `tb_notalmacen_id` int(11) NOT NULL,
  `tb_notalmacen_reg` datetime NOT NULL,
  `tb_notalmacen_fec` date NOT NULL,
  `tb_notalmacen_tip` tinyint(4) NOT NULL COMMENT '1:entrada 2:salida',
  `tb_documento_id` int(11) NOT NULL,
  `tb_notalmacen_numdoc` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_tipoperacion_id` int(11) NOT NULL,
  `tb_notalmacen_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_notalmacendetalle`
--

CREATE TABLE `tb_notalmacendetalle` (
  `tb_notalmacendetalle_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_notalmacendetalle_can` decimal(8,2) NOT NULL,
  `tb_notalmacendetalle_cos` decimal(8,2) NOT NULL,
  `tb_notalmacendetalle_pre` decimal(8,2) NOT NULL,
  `tb_notalmacen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_precio`
--

CREATE TABLE `tb_precio` (
  `tb_precio_id` int(11) NOT NULL,
  `tb_precio_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_precio_abr` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_precio`
--

INSERT INTO `tb_precio` (`tb_precio_id`, `tb_precio_nom`, `tb_precio_abr`) VALUES
(1, 'PRECIO MINIMO', 'P. MIN'),
(2, 'PRECIO MAYORISTA', 'P. MAY'),
(3, 'PRECIO NORMAL', ''),
(4, 'LISTA 2', ''),
(5, 'LISTA 3', ''),
(6, 'LISTA 4', ''),
(7, 'LISTA 5', ''),
(8, 'LISTA 6', ''),
(9, 'LISTA 7', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_preciodetalle`
--

CREATE TABLE `tb_preciodetalle` (
  `tb_preciodetalle_id` int(11) NOT NULL,
  `tb_preciodetalle_mod` datetime NOT NULL,
  `tb_precio_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_preciodetalle_val` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_presentacion`
--

CREATE TABLE `tb_presentacion` (
  `tb_presentacion_id` int(11) NOT NULL,
  `tb_presentacion_reg` datetime NOT NULL,
  `tb_presentacion_mod` datetime NOT NULL,
  `tb_presentacion_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_presentacion_cod` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_presentacion_stomin` int(11) NOT NULL,
  `tb_presentacion_est` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_presentacion`
--

INSERT INTO `tb_presentacion` (`tb_presentacion_id`, `tb_presentacion_reg`, `tb_presentacion_mod`, `tb_presentacion_nom`, `tb_presentacion_cod`, `tb_presentacion_stomin`, `tb_presentacion_est`, `tb_producto_id`) VALUES
(550, '2019-01-04 21:29:33', '2019-01-04 21:29:33', '1', '', 0, 'Activo', 550),
(551, '2019-01-04 21:29:53', '2019-01-04 21:29:53', '2', '', 0, 'Activo', 551),
(552, '2019-01-04 21:30:05', '2019-01-04 21:30:05', '3', '', 0, 'Activo', 552),
(553, '2019-01-04 21:30:22', '2019-01-04 21:30:22', '4', '', 0, 'Activo', 553),
(554, '2019-01-04 21:30:37', '2019-01-04 21:30:37', '5', '', 0, 'Activo', 554),
(555, '2019-01-04 21:30:50', '2019-01-04 21:30:50', '6', '', 0, 'Activo', 555),
(556, '2019-01-04 21:31:09', '2019-01-04 21:31:09', '7', '', 0, 'Activo', 556),
(557, '2019-01-04 21:31:26', '2019-01-04 21:31:26', '8', '', 0, 'Activo', 557),
(558, '2019-01-04 21:31:41', '2019-01-04 21:31:41', '9', '', 0, 'Activo', 558),
(559, '2019-01-04 21:31:56', '2019-01-04 21:31:56', '10', '', 0, 'Activo', 559),
(560, '2019-01-05 18:57:42', '2019-01-05 18:57:42', '11', '', 0, 'Activo', 560),
(561, '2019-01-05 18:58:06', '2019-01-05 18:58:06', '12', '', 0, 'Activo', 561),
(562, '2019-01-05 18:59:19', '2019-01-05 18:59:19', '13', '', 0, 'Activo', 562),
(563, '2019-01-05 19:14:57', '2019-01-05 19:14:57', '14', '', 0, 'Activo', 563);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_producto`
--

CREATE TABLE `tb_producto` (
  `tb_producto_id` int(11) NOT NULL,
  `tb_producto_reg` datetime NOT NULL,
  `tb_producto_mod` datetime NOT NULL,
  `tb_producto_nom` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `tb_producto_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_producto_est` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_categoria_id` int(11) NOT NULL,
  `tb_marca_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_producto_imagen` varchar(350) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen',
  `tb_empresa_id` int(11) NOT NULL,
  `tb_afectacion_id` int(11) NOT NULL,
  `tb_producto_lote` int(1) NOT NULL COMMENT 'solo para saber si maneja lote o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_producto`
--

INSERT INTO `tb_producto` (`tb_producto_id`, `tb_producto_reg`, `tb_producto_mod`, `tb_producto_nom`, `tb_producto_des`, `tb_producto_est`, `tb_categoria_id`, `tb_marca_id`, `tb_usuario_id`, `tb_producto_imagen`, `tb_empresa_id`, `tb_afectacion_id`, `tb_producto_lote`) VALUES
(550, '2019-01-04 21:29:33', '2019-01-04 21:29:33', '1', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(551, '2019-01-04 21:29:53', '2019-01-04 21:29:53', '2', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(552, '2019-01-04 21:30:05', '2019-01-04 21:30:05', '3', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(553, '2019-01-04 21:30:22', '2019-01-04 21:30:22', '4', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(554, '2019-01-04 21:30:37', '2019-01-04 21:30:37', '5', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(555, '2019-01-04 21:30:50', '2019-01-04 21:30:50', '6', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(556, '2019-01-04 21:31:09', '2019-01-04 21:31:09', '7', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(557, '2019-01-04 21:31:26', '2019-01-04 21:31:26', '8', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(558, '2019-01-04 21:31:41', '2019-01-04 21:31:41', '9', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(559, '2019-01-04 21:31:56', '2019-01-04 21:31:56', '10', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(560, '2019-01-05 18:57:42', '2019-01-05 18:57:42', '11', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(561, '2019-01-05 18:58:06', '2019-01-05 18:58:06', '12', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(562, '2019-01-05 18:59:19', '2019-01-05 18:59:19', '13', '', 'Activo', 1, 1, 1, '', 0, 9, 0),
(563, '2019-01-05 19:14:57', '2019-01-05 19:14:57', '14', '', 'Activo', 1, 1, 1, '', 0, 9, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_productoproveedor`
--

CREATE TABLE `tb_productoproveedor` (
  `tb_productoproveedor_id` int(11) NOT NULL,
  `tb_producto_id` int(11) NOT NULL,
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_productoproveedor_cantmin` decimal(18,2) NOT NULL,
  `tb_productoproveedor_desc` decimal(18,2) NOT NULL,
  `tb_productoproveedor_fechaini` date NOT NULL,
  `tb_productoproveedor_fechafin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_proveedor`
--

CREATE TABLE `tb_proveedor` (
  `tb_proveedor_id` int(11) NOT NULL,
  `tb_proveedor_tip` tinyint(4) NOT NULL,
  `tb_proveedor_nom` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_proveedor_doc` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_proveedor_dir` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_proveedor_con` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_proveedor_tel` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_proveedor_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_proveedor`
--

INSERT INTO `tb_proveedor` (`tb_proveedor_id`, `tb_proveedor_tip`, `tb_proveedor_nom`, `tb_proveedor_doc`, `tb_proveedor_dir`, `tb_proveedor_con`, `tb_proveedor_tel`, `tb_proveedor_ema`, `tb_empresa_id`) VALUES
(1, 1, 'DONAL', '47092856', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_puntoventa`
--

CREATE TABLE `tb_puntoventa` (
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_puntoventa_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_puntoventa`
--

INSERT INTO `tb_puntoventa` (`tb_puntoventa_id`, `tb_puntoventa_nom`, `tb_almacen_id`, `tb_caja_id`, `tb_empresa_id`) VALUES
(1, 'CALLE PRINCIPAL NÂ° 345 - SABANDIA -AREQUIPA', 1, 1, 1),
(2, 'NUEVO PUNTO', 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_referencia`
--

CREATE TABLE `tb_referencia` (
  `tb_referencia_id` int(11) NOT NULL,
  `tb_referencia_nom` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_referencia`
--

INSERT INTO `tb_referencia` (`tb_referencia_id`, `tb_referencia_nom`) VALUES
(1, 'CAJA'),
(2, 'BANCO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_restabclave`
--

CREATE TABLE `tb_restabclave` (
  `tb_restabclave_id` int(11) NOT NULL,
  `tb_restabclave_fec` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tb_restabclave_ema` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_restabclave_cod` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `tb_restabclave_est` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_resumenboleta`
--

CREATE TABLE `tb_resumenboleta` (
  `tb_resumenboleta_id` int(11) NOT NULL,
  `tb_resumenboleta_reg` datetime NOT NULL,
  `tb_resumenboleta_mod` datetime NOT NULL,
  `tb_resumenboleta_usureg` int(11) NOT NULL,
  `tb_resumenboleta_usumod` int(11) NOT NULL,
  `tb_resumenboleta_fec` date NOT NULL,
  `tb_resumenboleta_fecref` date NOT NULL,
  `tb_resumenboleta_cod` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_num` int(3) NOT NULL,
  `tb_resumenboleta_tic` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_faucod` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_digval` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_sigval` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_val` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_fecenvsun` datetime NOT NULL,
  `tb_resumenboleta_estsun` int(1) NOT NULL,
  `tb_resumenboleta_faucod2` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboleta_fecenvsun2` datetime NOT NULL,
  `tb_resumenboleta_estsun2` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_resumenboleta`
--

INSERT INTO `tb_resumenboleta` (`tb_resumenboleta_id`, `tb_resumenboleta_reg`, `tb_resumenboleta_mod`, `tb_resumenboleta_usureg`, `tb_resumenboleta_usumod`, `tb_resumenboleta_fec`, `tb_resumenboleta_fecref`, `tb_resumenboleta_cod`, `tb_resumenboleta_num`, `tb_resumenboleta_tic`, `tb_resumenboleta_faucod`, `tb_resumenboleta_digval`, `tb_resumenboleta_sigval`, `tb_resumenboleta_val`, `tb_resumenboleta_fecenvsun`, `tb_resumenboleta_estsun`, `tb_resumenboleta_faucod2`, `tb_resumenboleta_fecenvsun2`, `tb_resumenboleta_estsun2`) VALUES
(1, '2019-01-26 17:24:57', '2019-01-26 17:24:57', 1, 1, '2019-01-26', '2019-01-26', 'RC-20190126-001', 1, '1548541510460', '0', 'omvBFg+JxtkjoVB6fllfgPjbMZo=', 'EJv+9WercKNBNp8gP6cvAGvTph5LLzrO8Kb19lPa1XS5GgE2N/myTrnCtyJ0oBNHpPwRcyGR7x+oKKVXwrQu8ZmjtaJBGnnRH3VZ437uE13arOtM/ris2IUki4+QiSnW+CeqG4TUnabDHcAPqLlmVQ8Gfe7A5nOsE0Bk913TDcvz/M5gkGfCCERtAHIrjR9VQJJdRi6ev+Sx7R5vPNskcmuFXoKBQPITl36OrqmmIP0nc7xWTIoxQziXkx3MW6r0UPeMlFL6GnC6xx4a2YyIBtA47qsibGMgSxBe39eIykeLnkXjLA4q9SRvoK84a+9MVK6rUkw5+ZJmn6LhboZ9Lw==', '1', '2019-01-26 17:25:10', 1, '', '0000-00-00 00:00:00', 0),
(2, '2019-01-26 17:27:09', '2019-01-26 17:27:09', 1, 1, '2019-01-26', '2019-01-26', 'RC-20190126-002', 2, '1548541634170', '0', 'A+Ga/QZJTCIbaMhSb1DmnC5lgls=', 'Q40I1A8k9md0MH6bvyKzvjW/g9zydEhtWoIbqjByIMPc0lrAH5krSO713lsr+hGOK6zSbRLDq3a5pOXlFDD7Lbk0YBNUV4+Nil0uyFjoL4wciiVCdrUhh3qPqJaMqJW44G+D6u++rDeH0BwAoTHGbEG43BjYGZth4/SdZoN1n32xfjMyA4L9iYob4VHcXYOVj7ukyIEkcghkU/JKCr0jP+vaX5orIF6D9WJ5dTCFFHVsGVaRsUcwRKfeO1UL7NRQJ9tnZjMb4VxFTZPHxrEb1fJdrqt6fV3RcDs5R6gjmxGb06U8LoiI2bcQDPDYjrwOlrvJzGE9O0fotodBYfOpUg==', '1', '2019-01-26 17:27:14', 1, '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_resumenboletadetalle`
--

CREATE TABLE `tb_resumenboletadetalle` (
  `tb_resumenboletadetalle_id` int(11) NOT NULL,
  `tb_resumenboleta_id` int(11) NOT NULL,
  `tb_resumenboletadetalle_num` int(5) NOT NULL,
  `cs_tipodocumento_id` int(1) NOT NULL,
  `tb_resumenboletadetalle_ser` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboletadetalle_cor` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_resumenboletadetalle_tipdocrel` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboletadetalle_docrelser` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `tb_resumenboletadetalle_docrelcor` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipomoneda_id` int(11) NOT NULL,
  `tb_resumenboletadetalle_opegra` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_opeexo` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_opeina` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_otrcar` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_isc` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_igv` decimal(8,2) NOT NULL,
  `tb_resumenboletadetalle_imptot` decimal(8,2) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_resumenboletadetalle_est` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_resumenboletadetalle`
--

INSERT INTO `tb_resumenboletadetalle` (`tb_resumenboletadetalle_id`, `tb_resumenboleta_id`, `tb_resumenboletadetalle_num`, `cs_tipodocumento_id`, `tb_resumenboletadetalle_ser`, `tb_resumenboletadetalle_cor`, `tb_cliente_id`, `tb_resumenboletadetalle_tipdocrel`, `tb_resumenboletadetalle_docrelser`, `tb_resumenboletadetalle_docrelcor`, `cs_tipomoneda_id`, `tb_resumenboletadetalle_opegra`, `tb_resumenboletadetalle_opeexo`, `tb_resumenboletadetalle_opeina`, `tb_resumenboletadetalle_otrcar`, `tb_resumenboletadetalle_isc`, `tb_resumenboletadetalle_igv`, `tb_resumenboletadetalle_imptot`, `tb_venta_id`, `tb_resumenboletadetalle_est`) VALUES
(1, 1, 1, 2, 'B001', '0516', 16, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '40.00', 103, 1),
(2, 1, 2, 2, 'B001', '0517', 20, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '25.00', 106, 1),
(3, 1, 3, 2, 'B001', '0518', 21, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '30.00', 107, 1),
(4, 1, 4, 2, 'B001', '0519', 19, '', '', '', 1, '18.64', '0.00', '0.00', '0.00', '0.00', '3.36', '22.00', 108, 1),
(5, 2, 1, 2, 'B001', '0516', 16, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '40.00', 103, 1),
(6, 2, 2, 2, 'B001', '0517', 20, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '25.00', 106, 1),
(7, 2, 3, 2, 'B001', '0518', 21, '', '', '', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '30.00', 107, 1),
(8, 2, 4, 2, 'B001', '0519', 19, '', '', '', 1, '18.64', '0.00', '0.00', '0.00', '0.00', '3.36', '22.00', 108, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_servicio`
--

CREATE TABLE `tb_servicio` (
  `tb_servicio_id` int(11) NOT NULL,
  `tb_servicio_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_servicio_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_servicio_pre` decimal(8,2) NOT NULL,
  `tb_servicio_est` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_categoria_id` int(11) NOT NULL,
  `tb_servicio_aut` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_servicio`
--

INSERT INTO `tb_servicio` (`tb_servicio_id`, `tb_servicio_nom`, `tb_servicio_des`, `tb_servicio_pre`, `tb_servicio_est`, `tb_categoria_id`, `tb_servicio_aut`) VALUES
(1, 'PASAJE', 'PASAJE', '0.00', 'Activo', 1, 0),
(2, 'CAJAS SE CARTON', '', '106.20', 'Activo', 1, 1),
(3, 'POLLOS FRITOS', '', '30.00', 'Activo', 1, 1),
(4, 'SACOS GIGANTES', '', '45.00', 'Activo', 1, 1),
(5, 'CAJAS DE DINAMITA', '', '5.00', 'Activo', 1, 1),
(6, 'SACO DE PAPAS', '', '12.00', 'Activo', 1, 1),
(7, 'CAJA DE ZAPATOS', '', '30.00', 'Activo', 1, 1),
(8, 'EXONERADO', '', '5.00', 'Activo', 1, 1),
(9, 'CAJAS BLANCAS', '', '5.00', 'Activo', 1, 1),
(10, 'CEBOLLA', '', '10.00', 'Activo', 1, 1),
(11, 'FUNCIONA', '', '15.00', 'Activo', 1, 1),
(12, 'JAUJA A CHILLE IDA Y VUELTA', '', '100.00', 'Activo', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_soporte`
--

CREATE TABLE `tb_soporte` (
  `tb_soporte_id` int(11) NOT NULL,
  `tb_soporte_fecreg` datetime NOT NULL,
  `tb_user_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_soporte_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_asu` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_tem` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_ubi` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_men` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_est` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_soporte_vis` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_stock`
--

CREATE TABLE `tb_stock` (
  `tb_stock_id` int(11) NOT NULL,
  `tb_stock_mod` datetime NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_presentacion_id` int(11) NOT NULL,
  `tb_stock_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_subcuenta`
--

CREATE TABLE `tb_subcuenta` (
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_subcuenta_cod` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_subcuenta_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_subcuenta_ord` tinyint(4) NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_subcuenta_r`
--

CREATE TABLE `tb_subcuenta_r` (
  `tb_subcuenta_id` int(11) NOT NULL,
  `tb_subcuenta_cod` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_subcuenta_des` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_subcuenta_ord` tinyint(4) NOT NULL,
  `tb_cuenta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tag`
--

CREATE TABLE `tb_tag` (
  `tb_tag_id` int(11) NOT NULL,
  `tb_presentacion_id` int(11) NOT NULL,
  `tb_atributo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_talonario`
--

CREATE TABLE `tb_talonario` (
  `tb_talonario_id` int(11) NOT NULL,
  `tb_talonario_reg` datetime NOT NULL,
  `tb_talonario_mod` datetime NOT NULL,
  `tb_talonario_ser` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_talonario_ini` int(11) NOT NULL,
  `tb_talonario_fin` int(11) NOT NULL,
  `tb_talonario_num` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_talonario_est` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_talonario`
--

INSERT INTO `tb_talonario` (`tb_talonario_id`, `tb_talonario_reg`, `tb_talonario_mod`, `tb_talonario_ser`, `tb_talonario_ini`, `tb_talonario_fin`, `tb_talonario_num`, `tb_puntoventa_id`, `tb_documento_id`, `tb_talonario_est`, `tb_empresa_id`) VALUES
(3, '2013-01-07 11:31:00', '2018-12-22 14:02:59', '0002', 1, 99999, 1882, 1, 2, 'ACTIVO', 1),
(4, '2013-01-07 11:32:55', '2018-12-24 13:01:53', '0002', 1, 99999, 636, 1, 3, 'ACTIVO', 1),
(17, '2016-11-26 17:49:45', '2019-01-31 15:45:54', 'F001', 1, 99999, 81, 1, 11, 'ACTIVO', 1),
(19, '2016-11-27 23:12:03', '2019-06-10 21:37:35', 'B001', 1, 1300, 530, 1, 12, 'ACTIVO', 1),
(20, '2018-03-03 12:07:43', '2019-01-17 21:38:00', 'B001', 1, 2333, 104, 2, 12, 'ACTIVO', 1),
(21, '2018-03-23 14:01:45', '2018-06-05 13:19:03', 'CT', 1, 99999, 0, 1, 14, 'ACTIVO', 1),
(22, '2018-04-02 19:37:33', '2018-04-02 19:39:28', 'F001', 1, 99999, 1, 5, 11, 'ACTIVO', 6),
(23, '2018-04-03 18:05:01', '2018-04-04 17:03:37', '999999', 1, 1000, 3, 5, 14, 'ACTIVO', 6),
(24, '2018-04-05 13:05:24', '2018-04-05 13:05:24', '55555', 1, 3333, 20, 3, 14, 'ACTIVO', 1),
(25, '2018-04-05 13:06:37', '2018-04-05 13:06:37', '333333', 1, 33333, 10, 4, 14, 'ACTIVO', 1),
(26, '2018-04-05 13:07:56', '2018-04-05 13:08:26', '3434343', 1, 4434, 1, 2, 14, 'ACTIVO', 1),
(27, '2018-04-12 16:47:03', '2019-02-20 10:53:12', 'NS01', 1, 99999, 2, 1, 15, 'ACTIVO', 1),
(28, '2018-05-22 19:19:35', '2018-10-23 17:10:33', 'F001', 1, 10000, 46, 2, 11, 'ACTIVO', 1),
(29, '2018-10-31 15:10:27', '2019-01-26 16:41:57', '0001', 1, 99999, 43, 1, 22, 'ACTIVO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_talonariointerno`
--

CREATE TABLE `tb_talonariointerno` (
  `tb_talonario_id` int(11) NOT NULL,
  `tb_talonario_reg` datetime NOT NULL,
  `tb_talonario_mod` datetime NOT NULL,
  `tb_talonario_ser` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_talonario_ini` int(11) NOT NULL,
  `tb_talonario_fin` int(11) NOT NULL,
  `tb_talonario_num` int(11) NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_talonario_est` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_almacen_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_talonariointerno`
--

INSERT INTO `tb_talonariointerno` (`tb_talonario_id`, `tb_talonario_reg`, `tb_talonario_mod`, `tb_talonario_ser`, `tb_talonario_ini`, `tb_talonario_fin`, `tb_talonario_num`, `tb_documento_id`, `tb_talonario_est`, `tb_almacen_id`, `tb_puntoventa_id`, `tb_empresa_id`) VALUES
(1, '2013-01-10 04:37:31', '2016-12-27 18:38:47', '01', 1, 999999, 566, 1, 'ACTIVO', 0, 1, 1),
(2, '2013-01-10 04:37:43', '2016-12-28 18:40:45', '01', 1, 999999, 1887, 2, 'ACTIVO', 2, 0, 1),
(3, '2013-01-10 04:55:17', '2016-12-27 18:56:01', '04', 1, 99999, 613, 1, 'ACTIVO', 0, 3, 2),
(4, '2013-01-10 04:55:27', '2015-01-26 17:21:45', '03', 1, 99999, 36, 2, 'ACTIVO', 4, 0, 2),
(5, '2013-01-12 11:57:01', '2018-10-23 13:24:49', '02', 1, 999999, 1339, 2, 'ACTIVO', 1, 0, 1),
(6, '2013-01-12 12:01:25', '2016-12-28 18:40:57', '04', 1, 99999, 640, 2, 'ACTIVO', 3, 0, 2),
(7, '2013-01-16 05:16:54', '2019-01-03 17:31:42', 'A1', 1, 999999, 1092, 3, 'ACTIVO', 1, 0, 1),
(8, '2013-01-16 05:17:16', '2018-10-15 12:34:54', 'A2', 1, 999999, 462, 3, 'ACTIVO', 2, 0, 1),
(9, '2013-01-16 05:20:19', '2018-10-25 11:16:42', 'SD', 1, 999999, 925, 3, 'ACTIVO', 3, 0, 2),
(10, '2013-01-16 05:20:33', '2018-04-03 18:53:31', 'SD', 1, 999999, 372, 3, 'ACTIVO', 4, 0, 2),
(11, '2013-01-17 00:05:48', '2016-12-28 09:41:57', '02', 1, 999999, 334, 1, 'ACTIVO', 0, 2, 1),
(12, '2013-01-17 00:07:58', '2013-02-05 18:08:57', '03', 1, 99999, 1, 1, 'ACTIVO', 0, 4, 2),
(13, '2015-12-18 18:55:05', '2018-10-25 11:35:26', '03', 1, 999999, 0, 1, 'ACTIVO', 2, 7, 1),
(14, '2016-01-01 03:02:22', '2016-01-01 03:02:22', 'A3', 1, 999999, 0, 3, 'ACTIVO', 3, 0, 1),
(15, '2016-01-08 01:53:00', '2016-01-08 01:53:00', '03', 1, 999999, 0, 2, 'ACTIVO', 3, 0, 1),
(16, '2018-10-25 11:37:18', '2018-10-25 11:37:18', 'A4', 1, 999999, 0, 3, 'ACTIVO', 5, 0, 1),
(17, '2018-10-25 11:37:54', '2018-10-25 11:38:39', 'A5', 1, 999999, 1, 3, 'ACTIVO', 6, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_talonarionc`
--

CREATE TABLE `tb_talonarionc` (
  `tb_talonario_id` int(11) NOT NULL,
  `tb_talonario_reg` datetime NOT NULL,
  `tb_talonario_mod` datetime NOT NULL,
  `tb_talonario_ser` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_talonario_ini` int(11) NOT NULL,
  `tb_talonario_fin` int(11) NOT NULL,
  `tb_talonario_num` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_talonario_est` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_talonarionc`
--

INSERT INTO `tb_talonarionc` (`tb_talonario_id`, `tb_talonario_reg`, `tb_talonario_mod`, `tb_talonario_ser`, `tb_talonario_ini`, `tb_talonario_fin`, `tb_talonario_num`, `tb_puntoventa_id`, `tb_documento_id`, `tb_talonario_est`, `tb_empresa_id`) VALUES
(1, '2017-01-13 13:17:58', '2018-12-31 16:50:50', 'F001', 1, 99999, 10, 1, 11, 'ACTIVO', 1),
(2, '2017-01-13 13:18:21', '2018-12-18 10:59:46', 'B001', 1, 99999, 14, 1, 12, 'ACTIVO', 1),
(3, '2017-01-13 13:19:07', '2018-09-10 19:37:50', 'F006', 1, 99999999, 4, 2, 11, 'ACTIVO', 1),
(4, '2017-01-13 13:19:41', '2017-01-13 13:19:41', 'B006', 1, 99999999, 0, 2, 12, 'ACTIVO', 1),
(5, '2017-01-13 13:20:07', '2017-01-13 13:20:07', 'F007', 1, 99999999, 0, 3, 11, 'ACTIVO', 1),
(6, '2017-01-13 13:20:20', '2017-01-20 16:18:23', 'B007', 1, 99999999, 0, 3, 12, 'ACTIVO', 1),
(7, '2018-12-12 20:20:59', '2018-12-12 20:33:22', '0001', 1, 99999, 1, 1, 2, 'ACTIVO', 1),
(8, '2018-12-12 20:21:15', '2018-12-12 20:23:05', '0001', 1, 99999, 0, 1, 3, 'ACTIVO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_talonariond`
--

CREATE TABLE `tb_talonariond` (
  `tb_talonario_id` int(11) NOT NULL,
  `tb_talonario_reg` datetime NOT NULL,
  `tb_talonario_mod` datetime NOT NULL,
  `tb_talonario_ser` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_talonario_ini` int(11) NOT NULL,
  `tb_talonario_fin` int(11) NOT NULL,
  `tb_talonario_num` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_talonario_est` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_talonariond`
--

INSERT INTO `tb_talonariond` (`tb_talonario_id`, `tb_talonario_reg`, `tb_talonario_mod`, `tb_talonario_ser`, `tb_talonario_ini`, `tb_talonario_fin`, `tb_talonario_num`, `tb_puntoventa_id`, `tb_documento_id`, `tb_talonario_est`, `tb_empresa_id`) VALUES
(1, '2017-01-13 13:17:58', '2018-06-07 12:57:08', 'F003', 1, 99999999, 10, 1, 11, 'ACTIVO', 1),
(2, '2017-01-13 13:18:21', '2018-11-12 15:30:23', 'B001', 1, 99999999, 3, 1, 12, 'ACTIVO', 1),
(3, '2017-01-13 13:19:07', '2018-09-01 19:04:04', 'F006', 1, 99999999, 1, 2, 11, 'ACTIVO', 1),
(4, '2017-01-13 13:19:41', '2017-01-13 13:19:41', 'B006', 1, 99999999, 0, 2, 12, 'ACTIVO', 1),
(5, '2017-01-13 13:20:07', '2017-01-13 13:20:07', 'F007', 1, 99999999, 0, 3, 11, 'ACTIVO', 1),
(6, '2017-01-13 13:20:20', '2017-01-20 16:50:08', 'B007', 1, 99999999, 0, 3, 12, 'ACTIVO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tarjeta`
--

CREATE TABLE `tb_tarjeta` (
  `tb_tarjeta_id` int(11) NOT NULL,
  `tb_tarjeta_nom` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_caja_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_tarjeta`
--

INSERT INTO `tb_tarjeta` (`tb_tarjeta_id`, `tb_tarjeta_nom`, `tb_caja_id`, `tb_empresa_id`) VALUES
(1, 'VISA', 4, 0),
(2, 'MASTERCARD', 1, 0),
(3, 'CMR', 5, 0),
(4, 'DEBITO', 1, 0),
(6, 'CREDITO', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_telefono`
--

CREATE TABLE `tb_telefono` (
  `tb_telefono_id` int(11) NOT NULL,
  `tb_telefono_tip` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_telefono_ope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_telefono_num` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipocambio`
--

CREATE TABLE `tb_tipocambio` (
  `tb_tipocambio_id` int(11) NOT NULL,
  `tb_tipocambio_reg` datetime NOT NULL,
  `tb_tipocambio_mod` datetime NOT NULL,
  `tb_tipocambio_fec` date NOT NULL,
  `tb_tipocambio_dolsunv` decimal(4,3) NOT NULL,
  `tb_tipocambio_dolsunc` decimal(4,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_tipoperacion`
--

CREATE TABLE `tb_tipoperacion` (
  `tb_tipoperacion_id` int(11) NOT NULL,
  `tb_tipoperacion_nom` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tb_tipoperacion_tip` tinyint(11) NOT NULL,
  `tb_tipoperacion_man` tinyint(4) NOT NULL COMMENT '1: mostrar 0: ocultar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_tipoperacion`
--

INSERT INTO `tb_tipoperacion` (`tb_tipoperacion_id`, `tb_tipoperacion_nom`, `tb_tipoperacion_tip`, `tb_tipoperacion_man`) VALUES
(1, 'SALDO INICIAL', 1, 0),
(2, 'COMPRA', 1, 0),
(3, 'VENTA', 2, 0),
(4, 'TRANSFERENCIA ENTRADA', 1, 0),
(5, 'TRANSFERENCIA SALIDA', 2, 0),
(6, 'CUADRE (+)', 1, 1),
(7, 'CUADRE (-)', 2, 1),
(8, 'VTA ANTICIPADA', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_transferencia`
--

CREATE TABLE `tb_transferencia` (
  `tb_transferencia_id` int(11) NOT NULL,
  `tb_transferencia_fecreg` datetime NOT NULL,
  `tb_transferencia_fecmod` datetime NOT NULL,
  `tb_transferencia_usureg` int(11) NOT NULL,
  `tb_transferencia_usumod` int(11) NOT NULL,
  `tb_transferencia_xac` tinyint(1) NOT NULL,
  `tb_transferencia_fec` date NOT NULL,
  `tb_transferencia_det` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_transferencia_imp` decimal(11,2) NOT NULL,
  `tb_transferencia_est` tinyint(1) NOT NULL,
  `tb_caja_id_ori` int(11) NOT NULL,
  `tb_caja_id_des` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_transferencia_r`
--

CREATE TABLE `tb_transferencia_r` (
  `tb_transferencia_id` int(11) NOT NULL,
  `tb_transferencia_reg` datetime NOT NULL,
  `tb_transferencia_mod` datetime NOT NULL,
  `tb_transferencia_fec` date NOT NULL,
  `tb_transferencia_cod` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transferencia_des` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_referencia_id` int(11) NOT NULL,
  `tb_entfinanciera_id` int(11) NOT NULL,
  `tb_transferencia_modpag` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transferencia_mon` decimal(11,2) NOT NULL,
  `tb_transferencia_est` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_caja_id_ori` int(11) NOT NULL,
  `tb_caja_id_des` int(11) NOT NULL,
  `tb_moneda_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_usuario_id_reg` int(11) NOT NULL,
  `tb_usuario_id_mod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_transporte`
--

CREATE TABLE `tb_transporte` (
  `tb_transporte_id` int(11) NOT NULL,
  `tb_transporte_razsoc` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transporte_ruc` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_transporte_dir` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transporte_tel` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `tb_transporte_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_transporte`
--

INSERT INTO `tb_transporte` (`tb_transporte_id`, `tb_transporte_razsoc`, `tb_transporte_ruc`, `tb_transporte_dir`, `tb_transporte_tel`, `tb_transporte_ema`) VALUES
(1, 'TRASALTISA SAC', '2056247856', 'DIRECCION TRASPORTISTA', '942443535', 'lusandoval31@outlook.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_traspaso`
--

CREATE TABLE `tb_traspaso` (
  `tb_traspaso_id` int(11) NOT NULL,
  `tb_traspaso_reg` datetime NOT NULL,
  `tb_traspaso_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_traspaso_cod` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_almacen_id_ori` int(11) NOT NULL,
  `tb_almacen_id_des` int(11) NOT NULL,
  `tb_traspaso_ref` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `tb_traspaso_act` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_traspasodetalle`
--

CREATE TABLE `tb_traspasodetalle` (
  `tb_traspasodetalle_id` int(11) NOT NULL,
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_traspasodetalle_can` decimal(8,2) NOT NULL,
  `tb_traspaso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ubigeo`
--

CREATE TABLE `tb_ubigeo` (
  `tb_ubigeo_id` int(11) NOT NULL,
  `tb_ubigeo_coddep` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_codpro` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_coddis` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ubigeo_tip` enum('Departamento','Provincia','Distrito') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ubigeo`
--

INSERT INTO `tb_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(1, '01', '00', '00', 'AMAZONAS', 'Departamento'),
(2, '02', '00', '00', 'ANCASH', 'Departamento'),
(3, '03', '00', '00', 'APURIMAC', 'Departamento'),
(4, '04', '00', '00', 'AREQUIPA', 'Departamento'),
(5, '05', '00', '00', 'AYACUCHO', 'Departamento'),
(6, '06', '00', '00', 'CAJAMARCA', 'Departamento'),
(7, '07', '00', '00', 'CALLAO', 'Departamento'),
(8, '08', '00', '00', 'CUSCO', 'Departamento'),
(9, '09', '00', '00', 'HUANCAVELICA', 'Departamento'),
(10, '10', '00', '00', 'HUANUCO', 'Departamento'),
(11, '11', '00', '00', 'ICA', 'Departamento'),
(12, '12', '00', '00', 'JUNIN', 'Departamento'),
(13, '13', '00', '00', 'LA LIBERTAD', 'Departamento'),
(14, '14', '00', '00', 'LAMBAYEQUE', 'Departamento'),
(15, '15', '00', '00', 'LIMA', 'Departamento'),
(16, '16', '00', '00', 'LORETO', 'Departamento'),
(17, '17', '00', '00', 'MADRE DE DIOS', 'Departamento'),
(18, '18', '00', '00', 'MOQUEGUA', 'Departamento'),
(19, '19', '00', '00', 'PASCO', 'Departamento'),
(20, '20', '00', '00', 'PIURA', 'Departamento'),
(21, '21', '00', '00', 'PUNO', 'Departamento'),
(22, '22', '00', '00', 'SAN MARTIN', 'Departamento'),
(23, '23', '00', '00', 'TACNA', 'Departamento'),
(24, '24', '00', '00', 'TUMBES', 'Departamento'),
(25, '25', '00', '00', 'UCAYALI', 'Departamento'),
(26, '01', '01', '00', 'CHACHAPOYAS', 'Provincia'),
(27, '01', '02', '00', 'BAGUA', 'Provincia'),
(28, '01', '03', '00', 'BONGARA', 'Provincia'),
(29, '01', '04', '00', 'CONDORCANQUI', 'Provincia'),
(30, '01', '05', '00', 'LUYA', 'Provincia'),
(31, '01', '06', '00', 'RODRIGUEZ DE MENDOZA', 'Provincia'),
(32, '01', '07', '00', 'UTCUBAMBA', 'Provincia'),
(33, '02', '01', '00', 'HUARAZ', 'Provincia'),
(34, '02', '02', '00', 'AIJA', 'Provincia'),
(35, '02', '03', '00', 'ANTONIO RAYMONDI', 'Provincia'),
(36, '02', '04', '00', 'ASUNCION', 'Provincia'),
(37, '02', '05', '00', 'BOLOGNESI', 'Provincia'),
(38, '02', '06', '00', 'CARHUAZ', 'Provincia'),
(39, '02', '07', '00', 'CARLOS FERMIN FITZCARRALD', 'Provincia'),
(40, '02', '08', '00', 'CASMA', 'Provincia'),
(41, '02', '09', '00', 'CORONGO', 'Provincia'),
(42, '02', '10', '00', 'HUARI', 'Provincia'),
(43, '02', '11', '00', 'HUARMEY', 'Provincia'),
(44, '02', '12', '00', 'HUAYLAS', 'Provincia'),
(45, '02', '13', '00', 'MARISCAL LUZURIAGA', 'Provincia'),
(46, '02', '14', '00', 'OCROS', 'Provincia'),
(47, '02', '15', '00', 'PALLASCA', 'Provincia'),
(48, '02', '16', '00', 'POMABAMBA', 'Provincia'),
(49, '02', '17', '00', 'RECUAY', 'Provincia'),
(50, '02', '18', '00', 'SANTA', 'Provincia'),
(51, '02', '19', '00', 'SIHUAS', 'Provincia'),
(52, '02', '20', '00', 'YUNGAY', 'Provincia'),
(53, '03', '01', '00', 'ABANCAY', 'Provincia'),
(54, '03', '02', '00', 'ANDAHUAYLAS', 'Provincia'),
(55, '03', '03', '00', 'ANTABAMBA', 'Provincia'),
(56, '03', '04', '00', 'AYMARAES', 'Provincia'),
(57, '03', '05', '00', 'COTABAMBAS', 'Provincia'),
(58, '03', '06', '00', 'CHINCHEROS', 'Provincia'),
(59, '03', '07', '00', 'GRAU', 'Provincia'),
(60, '04', '01', '00', 'AREQUIPA', 'Provincia'),
(61, '04', '02', '00', 'CAMANA', 'Provincia'),
(62, '04', '03', '00', 'CARAVELI', 'Provincia'),
(63, '04', '04', '00', 'CASTILLA', 'Provincia'),
(64, '04', '05', '00', 'CAYLLOMA', 'Provincia'),
(65, '04', '06', '00', 'CONDESUYOS', 'Provincia'),
(66, '04', '07', '00', 'ISLAY', 'Provincia'),
(67, '04', '08', '00', 'LA UNION', 'Provincia'),
(68, '05', '01', '00', 'HUAMANGA', 'Provincia'),
(69, '05', '02', '00', 'CANGALLO', 'Provincia'),
(70, '05', '03', '00', 'HUANCA SANCOS', 'Provincia'),
(71, '05', '04', '00', 'HUANTA', 'Provincia'),
(72, '05', '05', '00', 'LA MAR', 'Provincia'),
(73, '05', '06', '00', 'LUCANAS', 'Provincia'),
(74, '05', '07', '00', 'PARINACOCHAS', 'Provincia'),
(75, '05', '08', '00', 'PAUCAR DEL SARA SARA', 'Provincia'),
(76, '05', '09', '00', 'SUCRE', 'Provincia'),
(77, '05', '10', '00', 'VICTOR FAJARDO', 'Provincia'),
(78, '05', '11', '00', 'VILCAS HUAMAN', 'Provincia'),
(79, '06', '01', '00', 'CAJAMARCA', 'Provincia'),
(80, '06', '02', '00', 'CAJABAMBA', 'Provincia'),
(81, '06', '03', '00', 'CELENDIN', 'Provincia'),
(82, '06', '04', '00', 'CHOTA', 'Provincia'),
(83, '06', '05', '00', 'CONTUMAZA', 'Provincia'),
(84, '06', '06', '00', 'CUTERVO', 'Provincia'),
(85, '06', '07', '00', 'HUALGAYOC', 'Provincia'),
(86, '06', '08', '00', 'JAEN', 'Provincia'),
(87, '06', '09', '00', 'SAN IGNACIO', 'Provincia'),
(88, '06', '10', '00', 'SAN MARCOS', 'Provincia'),
(89, '06', '11', '00', 'SAN MIGUEL', 'Provincia'),
(90, '06', '12', '00', 'SAN PABLO', 'Provincia'),
(91, '06', '13', '00', 'SANTA CRUZ', 'Provincia'),
(92, '07', '01', '00', 'PROV. CONST. DEL CALLAO', 'Provincia'),
(93, '08', '01', '00', 'CUSCO', 'Provincia'),
(94, '08', '02', '00', 'ACOMAYO', 'Provincia'),
(95, '08', '03', '00', 'ANTA', 'Provincia'),
(96, '08', '04', '00', 'CALCA', 'Provincia'),
(97, '08', '05', '00', 'CANAS', 'Provincia'),
(98, '08', '06', '00', 'CANCHIS', 'Provincia'),
(99, '08', '07', '00', 'CHUMBIVILCAS', 'Provincia'),
(100, '08', '08', '00', 'ESPINAR', 'Provincia'),
(101, '08', '09', '00', 'LA CONVENCION', 'Provincia'),
(102, '08', '10', '00', 'PARURO', 'Provincia'),
(103, '08', '11', '00', 'PAUCARTAMBO', 'Provincia'),
(104, '08', '12', '00', 'QUISPICANCHI', 'Provincia'),
(105, '08', '13', '00', 'URUBAMBA', 'Provincia'),
(106, '09', '01', '00', 'HUANCAVELICA', 'Provincia'),
(107, '09', '02', '00', 'ACOBAMBA', 'Provincia'),
(108, '09', '03', '00', 'ANGARAES', 'Provincia'),
(109, '09', '04', '00', 'CASTROVIRREYNA', 'Provincia'),
(110, '09', '05', '00', 'CHURCAMPA', 'Provincia'),
(111, '09', '06', '00', 'HUAYTARA', 'Provincia'),
(112, '09', '07', '00', 'TAYACAJA', 'Provincia'),
(113, '10', '01', '00', 'HUANUCO', 'Provincia'),
(114, '10', '02', '00', 'AMBO', 'Provincia'),
(115, '10', '03', '00', 'DOS DE MAYO', 'Provincia'),
(116, '10', '04', '00', 'HUACAYBAMBA', 'Provincia'),
(117, '10', '05', '00', 'HUAMALIES', 'Provincia'),
(118, '10', '06', '00', 'LEONCIO PRADO', 'Provincia'),
(119, '10', '07', '00', 'MARAÃ‘ON', 'Provincia'),
(120, '10', '08', '00', 'PACHITEA', 'Provincia'),
(121, '10', '09', '00', 'PUERTO INCA', 'Provincia'),
(122, '10', '10', '00', 'LAURICOCHA', 'Provincia'),
(123, '10', '11', '00', 'YAROWILCA', 'Provincia'),
(124, '11', '01', '00', 'ICA', 'Provincia'),
(125, '11', '02', '00', 'CHINCHA', 'Provincia'),
(126, '11', '03', '00', 'NAZCA', 'Provincia'),
(127, '11', '04', '00', 'PALPA', 'Provincia'),
(128, '11', '05', '00', 'PISCO', 'Provincia'),
(129, '12', '01', '00', 'HUANCAYO', 'Provincia'),
(130, '12', '02', '00', 'CONCEPCION', 'Provincia'),
(131, '12', '03', '00', 'CHANCHAMAYO', 'Provincia'),
(132, '12', '04', '00', 'JAUJA', 'Provincia'),
(133, '12', '05', '00', 'JUNIN', 'Provincia'),
(134, '12', '06', '00', 'SATIPO', 'Provincia'),
(135, '12', '07', '00', 'TARMA', 'Provincia'),
(136, '12', '08', '00', 'YAULI', 'Provincia'),
(137, '12', '09', '00', 'CHUPACA', 'Provincia'),
(138, '13', '01', '00', 'TRUJILLO', 'Provincia'),
(139, '13', '02', '00', 'ASCOPE', 'Provincia'),
(140, '13', '03', '00', 'BOLIVAR', 'Provincia'),
(141, '13', '04', '00', 'CHEPEN', 'Provincia'),
(142, '13', '05', '00', 'JULCAN', 'Provincia'),
(143, '13', '06', '00', 'OTUZCO', 'Provincia'),
(144, '13', '07', '00', 'PACASMAYO', 'Provincia'),
(145, '13', '08', '00', 'PATAZ', 'Provincia'),
(146, '13', '09', '00', 'SANCHEZ CARRION', 'Provincia'),
(147, '13', '10', '00', 'SANTIAGO DE CHUCO', 'Provincia'),
(148, '13', '11', '00', 'GRAN CHIMU', 'Provincia'),
(149, '13', '12', '00', 'VIRU', 'Provincia'),
(150, '14', '01', '00', 'CHICLAYO', 'Provincia'),
(151, '14', '02', '00', 'FERREÃ‘AFE', 'Provincia'),
(152, '14', '03', '00', 'LAMBAYEQUE', 'Provincia'),
(153, '15', '01', '00', 'LIMA', 'Provincia'),
(154, '15', '02', '00', 'BARRANCA', 'Provincia'),
(155, '15', '03', '00', 'CAJATAMBO', 'Provincia'),
(156, '15', '04', '00', 'CANTA', 'Provincia'),
(157, '15', '05', '00', 'CAÃ‘ETE', 'Provincia'),
(158, '15', '06', '00', 'HUARAL', 'Provincia'),
(159, '15', '07', '00', 'HUAROCHIRI', 'Provincia'),
(160, '15', '08', '00', 'HUAURA', 'Provincia'),
(161, '15', '09', '00', 'OYON', 'Provincia'),
(162, '15', '10', '00', 'YAUYOS', 'Provincia'),
(163, '16', '01', '00', 'MAYNAS', 'Provincia'),
(164, '16', '02', '00', 'ALTO AMAZONAS', 'Provincia'),
(165, '16', '03', '00', 'LORETO', 'Provincia'),
(166, '16', '04', '00', 'MARISCAL RAMON CASTILLA', 'Provincia'),
(167, '16', '05', '00', 'REQUENA', 'Provincia'),
(168, '16', '06', '00', 'UCAYALI', 'Provincia'),
(169, '16', '07', '00', 'DATEM DEL MARAÃ‘ON', 'Provincia'),
(170, '17', '01', '00', 'TAMBOPATA', 'Provincia'),
(171, '17', '02', '00', 'MANU', 'Provincia'),
(172, '17', '03', '00', 'TAHUAMANU', 'Provincia'),
(173, '18', '01', '00', 'MARISCAL NIETO', 'Provincia'),
(174, '18', '02', '00', 'GENERAL SANCHEZ CERRO', 'Provincia'),
(175, '18', '03', '00', 'ILO', 'Provincia'),
(176, '19', '01', '00', 'PASCO', 'Provincia'),
(177, '19', '02', '00', 'DANIEL ALCIDES CARRION', 'Provincia'),
(178, '19', '03', '00', 'OXAPAMPA', 'Provincia'),
(179, '20', '01', '00', 'PIURA', 'Provincia'),
(180, '20', '02', '00', 'AYABACA', 'Provincia'),
(181, '20', '03', '00', 'HUANCABAMBA', 'Provincia'),
(182, '20', '04', '00', 'MORROPON', 'Provincia'),
(183, '20', '05', '00', 'PAITA', 'Provincia'),
(184, '20', '06', '00', 'SULLANA', 'Provincia'),
(185, '20', '07', '00', 'TALARA', 'Provincia'),
(186, '20', '08', '00', 'SECHURA', 'Provincia'),
(187, '21', '01', '00', 'PUNO', 'Provincia'),
(188, '21', '02', '00', 'AZANGARO', 'Provincia'),
(189, '21', '03', '00', 'CARABAYA', 'Provincia'),
(190, '21', '04', '00', 'CHUCUITO', 'Provincia'),
(191, '21', '05', '00', 'EL COLLAO', 'Provincia'),
(192, '21', '06', '00', 'HUANCANE', 'Provincia'),
(193, '21', '07', '00', 'LAMPA', 'Provincia'),
(194, '21', '08', '00', 'MELGAR', 'Provincia'),
(195, '21', '09', '00', 'MOHO', 'Provincia'),
(196, '21', '10', '00', 'SAN ANTONIO DE PUTINA', 'Provincia'),
(197, '21', '11', '00', 'SAN ROMAN', 'Provincia'),
(198, '21', '12', '00', 'SANDIA', 'Provincia'),
(199, '21', '13', '00', 'YUNGUYO', 'Provincia'),
(200, '22', '01', '00', 'MOYOBAMBA', 'Provincia'),
(201, '22', '02', '00', 'BELLAVISTA', 'Provincia'),
(202, '22', '03', '00', 'EL DORADO', 'Provincia'),
(203, '22', '04', '00', 'HUALLAGA', 'Provincia'),
(204, '22', '05', '00', 'LAMAS', 'Provincia'),
(205, '22', '06', '00', 'MARISCAL CACERES', 'Provincia'),
(206, '22', '07', '00', 'PICOTA', 'Provincia'),
(207, '22', '08', '00', 'RIOJA', 'Provincia'),
(208, '22', '09', '00', 'SAN MARTIN', 'Provincia'),
(209, '22', '10', '00', 'TOCACHE', 'Provincia'),
(210, '23', '01', '00', 'TACNA', 'Provincia'),
(211, '23', '02', '00', 'CANDARAVE', 'Provincia'),
(212, '23', '03', '00', 'JORGE BASADRE', 'Provincia'),
(213, '23', '04', '00', 'TARATA', 'Provincia'),
(214, '24', '01', '00', 'TUMBES', 'Provincia'),
(215, '24', '02', '00', 'CONTRALMIRANTE VILLAR', 'Provincia'),
(216, '24', '03', '00', 'ZARUMILLA', 'Provincia'),
(217, '25', '01', '00', 'CORONEL PORTILLO', 'Provincia'),
(218, '25', '02', '00', 'ATALAYA', 'Provincia'),
(219, '25', '03', '00', 'PADRE ABAD', 'Provincia'),
(220, '25', '04', '00', 'PURUS', 'Provincia'),
(221, '01', '01', '01', 'CHACHAPOYAS', 'Distrito'),
(222, '01', '01', '02', 'ASUNCION', 'Distrito'),
(223, '01', '01', '03', 'BALSAS', 'Distrito'),
(224, '01', '01', '04', 'CHETO', 'Distrito'),
(225, '01', '01', '05', 'CHILIQUIN', 'Distrito'),
(226, '01', '01', '06', 'CHUQUIBAMBA', 'Distrito'),
(227, '01', '01', '07', 'GRANADA', 'Distrito'),
(228, '01', '01', '08', 'HUANCAS', 'Distrito'),
(229, '01', '01', '09', 'LA JALCA', 'Distrito'),
(230, '01', '01', '10', 'LEIMEBAMBA', 'Distrito'),
(231, '01', '01', '11', 'LEVANTO', 'Distrito'),
(232, '01', '01', '12', 'MAGDALENA', 'Distrito'),
(233, '01', '01', '13', 'MARISCAL CASTILLA', 'Distrito'),
(234, '01', '01', '14', 'MOLINOPAMPA', 'Distrito'),
(235, '01', '01', '15', 'MONTEVIDEO', 'Distrito'),
(236, '01', '01', '16', 'OLLEROS', 'Distrito'),
(237, '01', '01', '17', 'QUINJALCA', 'Distrito'),
(238, '01', '01', '18', 'SAN FRANCISCO DE DAGUAS', 'Distrito'),
(239, '01', '01', '19', 'SAN ISIDRO DE MAINO', 'Distrito'),
(240, '01', '01', '20', 'SOLOCO', 'Distrito'),
(241, '01', '01', '21', 'SONCHE', 'Distrito'),
(242, '01', '02', '01', 'BAGUA', 'Distrito'),
(243, '01', '02', '02', 'ARAMANGO', 'Distrito'),
(244, '01', '02', '03', 'COPALLIN', 'Distrito'),
(245, '01', '02', '04', 'EL PARCO', 'Distrito'),
(246, '01', '02', '05', 'IMAZA', 'Distrito'),
(247, '01', '02', '06', 'LA PECA', 'Distrito'),
(248, '01', '03', '01', 'JUMBILLA', 'Distrito'),
(249, '01', '03', '02', 'CHISQUILLA', 'Distrito'),
(250, '01', '03', '03', 'CHURUJA', 'Distrito'),
(251, '01', '03', '04', 'COROSHA', 'Distrito'),
(252, '01', '03', '05', 'CUISPES', 'Distrito'),
(253, '01', '03', '06', 'FLORIDA', 'Distrito'),
(254, '01', '03', '07', 'JAZAN', 'Distrito'),
(255, '01', '03', '08', 'RECTA', 'Distrito'),
(256, '01', '03', '09', 'SAN CARLOS', 'Distrito'),
(257, '01', '03', '10', 'SHIPASBAMBA', 'Distrito'),
(258, '01', '03', '11', 'VALERA', 'Distrito'),
(259, '01', '03', '12', 'YAMBRASBAMBA', 'Distrito'),
(260, '01', '04', '01', 'NIEVA', 'Distrito'),
(261, '01', '04', '02', 'EL CENEPA', 'Distrito'),
(262, '01', '04', '03', 'RIO SANTIAGO', 'Distrito'),
(263, '01', '05', '01', 'LAMUD', 'Distrito'),
(264, '01', '05', '02', 'CAMPORREDONDO', 'Distrito'),
(265, '01', '05', '03', 'COCABAMBA', 'Distrito'),
(266, '01', '05', '04', 'COLCAMAR', 'Distrito'),
(267, '01', '05', '05', 'CONILA', 'Distrito'),
(268, '01', '05', '06', 'INGUILPATA', 'Distrito'),
(269, '01', '05', '07', 'LONGUITA', 'Distrito'),
(270, '01', '05', '08', 'LONYA CHICO', 'Distrito'),
(271, '01', '05', '09', 'LUYA', 'Distrito'),
(272, '01', '05', '10', 'LUYA VIEJO', 'Distrito'),
(273, '01', '05', '11', 'MARIA', 'Distrito'),
(274, '01', '05', '12', 'OCALLI', 'Distrito'),
(275, '01', '05', '13', 'OCUMAL', 'Distrito'),
(276, '01', '05', '14', 'PISUQUIA', 'Distrito'),
(277, '01', '05', '15', 'PROVIDENCIA', 'Distrito'),
(278, '01', '05', '16', 'SAN CRISTOBAL', 'Distrito'),
(279, '01', '05', '17', 'SAN FRANCISCO DEL YESO', 'Distrito'),
(280, '01', '05', '18', 'SAN JERONIMO', 'Distrito'),
(281, '01', '05', '19', 'SAN JUAN DE LOPECANCHA', 'Distrito'),
(282, '01', '05', '20', 'SANTA CATALINA', 'Distrito'),
(283, '01', '05', '21', 'SANTO TOMAS', 'Distrito'),
(284, '01', '05', '22', 'TINGO', 'Distrito'),
(285, '01', '05', '23', 'TRITA', 'Distrito'),
(286, '01', '06', '01', 'SAN NICOLAS', 'Distrito'),
(287, '01', '06', '02', 'CHIRIMOTO', 'Distrito'),
(288, '01', '06', '03', 'COCHAMAL', 'Distrito'),
(289, '01', '06', '04', 'HUAMBO', 'Distrito'),
(290, '01', '06', '05', 'LIMABAMBA', 'Distrito'),
(291, '01', '06', '06', 'LONGAR', 'Distrito'),
(292, '01', '06', '07', 'MARISCAL BENAVIDES', 'Distrito'),
(293, '01', '06', '08', 'MILPUC', 'Distrito'),
(294, '01', '06', '09', 'OMIA', 'Distrito'),
(295, '01', '06', '10', 'SANTA ROSA', 'Distrito'),
(296, '01', '06', '11', 'TOTORA', 'Distrito'),
(297, '01', '06', '12', 'VISTA ALEGRE', 'Distrito'),
(298, '01', '07', '01', 'BAGUA GRANDE', 'Distrito'),
(299, '01', '07', '02', 'CAJARURO', 'Distrito'),
(300, '01', '07', '03', 'CUMBA', 'Distrito'),
(301, '01', '07', '04', 'EL MILAGRO', 'Distrito'),
(302, '01', '07', '05', 'JAMALCA', 'Distrito'),
(303, '01', '07', '06', 'LONYA GRANDE', 'Distrito'),
(304, '01', '07', '07', 'YAMON', 'Distrito'),
(305, '02', '01', '01', 'HUARAZ', 'Distrito'),
(306, '02', '01', '02', 'COCHABAMBA', 'Distrito'),
(307, '02', '01', '03', 'COLCABAMBA', 'Distrito'),
(308, '02', '01', '04', 'HUANCHAY', 'Distrito'),
(309, '02', '01', '05', 'INDEPENDENCIA', 'Distrito'),
(310, '02', '01', '06', 'JANGAS', 'Distrito'),
(311, '02', '01', '07', 'LA LIBERTAD', 'Distrito'),
(312, '02', '01', '08', 'OLLEROS', 'Distrito'),
(313, '02', '01', '09', 'PAMPAS', 'Distrito'),
(314, '02', '01', '10', 'PARIACOTO', 'Distrito'),
(315, '02', '01', '11', 'PIRA', 'Distrito'),
(316, '02', '01', '12', 'TARICA', 'Distrito'),
(317, '02', '02', '01', 'AIJA', 'Distrito'),
(318, '02', '02', '02', 'CORIS', 'Distrito'),
(319, '02', '02', '03', 'HUACLLAN', 'Distrito'),
(320, '02', '02', '04', 'LA MERCED', 'Distrito'),
(321, '02', '02', '05', 'SUCCHA', 'Distrito'),
(322, '02', '03', '01', 'LLAMELLIN', 'Distrito'),
(323, '02', '03', '02', 'ACZO', 'Distrito'),
(324, '02', '03', '03', 'CHACCHO', 'Distrito'),
(325, '02', '03', '04', 'CHINGAS', 'Distrito'),
(326, '02', '03', '05', 'MIRGAS', 'Distrito'),
(327, '02', '03', '06', 'SAN JUAN DE RONTOY', 'Distrito'),
(328, '02', '04', '01', 'CHACAS', 'Distrito'),
(329, '02', '04', '02', 'ACOCHACA', 'Distrito'),
(330, '02', '05', '01', 'CHIQUIAN', 'Distrito'),
(331, '02', '05', '02', 'ABELARDO PARDO LEZAMETA', 'Distrito'),
(332, '02', '05', '03', 'ANTONIO RAYMONDI', 'Distrito'),
(333, '02', '05', '04', 'AQUIA', 'Distrito'),
(334, '02', '05', '05', 'CAJACAY', 'Distrito'),
(335, '02', '05', '06', 'CANIS', 'Distrito'),
(336, '02', '05', '07', 'COLQUIOC', 'Distrito'),
(337, '02', '05', '08', 'HUALLANCA', 'Distrito'),
(338, '02', '05', '09', 'HUASTA', 'Distrito'),
(339, '02', '05', '10', 'HUAYLLACAYAN', 'Distrito'),
(340, '02', '05', '11', 'LA PRIMAVERA', 'Distrito'),
(341, '02', '05', '12', 'MANGAS', 'Distrito'),
(342, '02', '05', '13', 'PACLLON', 'Distrito'),
(343, '02', '05', '14', 'SAN MIGUEL DE CORPANQUI', 'Distrito'),
(344, '02', '05', '15', 'TICLLOS', 'Distrito'),
(345, '02', '06', '01', 'CARHUAZ', 'Distrito'),
(346, '02', '06', '02', 'ACOPAMPA', 'Distrito'),
(347, '02', '06', '03', 'AMASHCA', 'Distrito'),
(348, '02', '06', '04', 'ANTA', 'Distrito'),
(349, '02', '06', '05', 'ATAQUERO', 'Distrito'),
(350, '02', '06', '06', 'MARCARA', 'Distrito'),
(351, '02', '06', '07', 'PARIAHUANCA', 'Distrito'),
(352, '02', '06', '08', 'SAN MIGUEL DE ACO', 'Distrito'),
(353, '02', '06', '09', 'SHILLA', 'Distrito'),
(354, '02', '06', '10', 'TINCO', 'Distrito'),
(355, '02', '06', '11', 'YUNGAR', 'Distrito'),
(356, '02', '07', '01', 'SAN LUIS', 'Distrito'),
(357, '02', '07', '02', 'SAN NICOLAS', 'Distrito'),
(358, '02', '07', '03', 'YAUYA', 'Distrito'),
(359, '02', '08', '01', 'CASMA', 'Distrito'),
(360, '02', '08', '02', 'BUENA VISTA ALTA', 'Distrito'),
(361, '02', '08', '03', 'COMANDANTE NOEL', 'Distrito'),
(362, '02', '08', '04', 'YAUTAN', 'Distrito'),
(363, '02', '09', '01', 'CORONGO', 'Distrito'),
(364, '02', '09', '02', 'ACO', 'Distrito'),
(365, '02', '09', '03', 'BAMBAS', 'Distrito'),
(366, '02', '09', '04', 'CUSCA', 'Distrito'),
(367, '02', '09', '05', 'LA PAMPA', 'Distrito'),
(368, '02', '09', '06', 'YANAC', 'Distrito'),
(369, '02', '09', '07', 'YUPAN', 'Distrito'),
(370, '02', '10', '01', 'HUARI', 'Distrito'),
(371, '02', '10', '02', 'ANRA', 'Distrito'),
(372, '02', '10', '03', 'CAJAY', 'Distrito'),
(373, '02', '10', '04', 'CHAVIN DE HUANTAR', 'Distrito'),
(374, '02', '10', '05', 'HUACACHI', 'Distrito'),
(375, '02', '10', '06', 'HUACCHIS', 'Distrito'),
(376, '02', '10', '07', 'HUACHIS', 'Distrito'),
(377, '02', '10', '08', 'HUANTAR', 'Distrito'),
(378, '02', '10', '09', 'MASIN', 'Distrito'),
(379, '02', '10', '10', 'PAUCAS', 'Distrito'),
(380, '02', '10', '11', 'PONTO', 'Distrito'),
(381, '02', '10', '12', 'RAHUAPAMPA', 'Distrito'),
(382, '02', '10', '13', 'RAPAYAN', 'Distrito'),
(383, '02', '10', '14', 'SAN MARCOS', 'Distrito'),
(384, '02', '10', '15', 'SAN PEDRO DE CHANA', 'Distrito'),
(385, '02', '10', '16', 'UCO', 'Distrito'),
(386, '02', '11', '01', 'HUARMEY', 'Distrito'),
(387, '02', '11', '02', 'COCHAPETI', 'Distrito'),
(388, '02', '11', '03', 'CULEBRAS', 'Distrito'),
(389, '02', '11', '04', 'HUAYAN', 'Distrito'),
(390, '02', '11', '05', 'MALVAS', 'Distrito'),
(391, '02', '12', '01', 'CARAZ', 'Distrito'),
(392, '02', '12', '02', 'HUALLANCA', 'Distrito'),
(393, '02', '12', '03', 'HUATA', 'Distrito'),
(394, '02', '12', '04', 'HUAYLAS', 'Distrito'),
(395, '02', '12', '05', 'MATO', 'Distrito'),
(396, '02', '12', '06', 'PAMPAROMAS', 'Distrito'),
(397, '02', '12', '07', 'PUEBLO LIBRE  / 1 ', 'Distrito'),
(398, '02', '12', '08', 'SANTA CRUZ', 'Distrito'),
(399, '02', '12', '09', 'SANTO TORIBIO', 'Distrito'),
(400, '02', '12', '10', 'YURACMARCA', 'Distrito'),
(401, '02', '13', '01', 'PISCOBAMBA', 'Distrito'),
(402, '02', '13', '02', 'CASCA', 'Distrito'),
(403, '02', '13', '03', 'ELEAZAR GUZMAN BARRON', 'Distrito'),
(404, '02', '13', '04', 'FIDEL OLIVAS ESCUDERO', 'Distrito'),
(405, '02', '13', '05', 'LLAMA', 'Distrito'),
(406, '02', '13', '06', 'LLUMPA', 'Distrito'),
(407, '02', '13', '07', 'LUCMA', 'Distrito'),
(408, '02', '13', '08', 'MUSGA', 'Distrito'),
(409, '02', '14', '01', 'OCROS', 'Distrito'),
(410, '02', '14', '02', 'ACAS', 'Distrito'),
(411, '02', '14', '03', 'CAJAMARQUILLA', 'Distrito'),
(412, '02', '14', '04', 'CARHUAPAMPA', 'Distrito'),
(413, '02', '14', '05', 'COCHAS', 'Distrito'),
(414, '02', '14', '06', 'CONGAS', 'Distrito'),
(415, '02', '14', '07', 'LLIPA', 'Distrito'),
(416, '02', '14', '08', 'SAN CRISTOBAL DE RAJAN', 'Distrito'),
(417, '02', '14', '09', 'SAN PEDRO', 'Distrito'),
(418, '02', '14', '10', 'SANTIAGO DE CHILCAS', 'Distrito'),
(419, '02', '15', '01', 'CABANA', 'Distrito'),
(420, '02', '15', '02', 'BOLOGNESI', 'Distrito'),
(421, '02', '15', '03', 'CONCHUCOS', 'Distrito'),
(422, '02', '15', '04', 'HUACASCHUQUE', 'Distrito'),
(423, '02', '15', '05', 'HUANDOVAL', 'Distrito'),
(424, '02', '15', '06', 'LACABAMBA', 'Distrito'),
(425, '02', '15', '07', 'LLAPO', 'Distrito'),
(426, '02', '15', '08', 'PALLASCA', 'Distrito'),
(427, '02', '15', '09', 'PAMPAS', 'Distrito'),
(428, '02', '15', '10', 'SANTA ROSA', 'Distrito'),
(429, '02', '15', '11', 'TAUCA', 'Distrito'),
(430, '02', '16', '01', 'POMABAMBA', 'Distrito'),
(431, '02', '16', '02', 'HUAYLLAN', 'Distrito'),
(432, '02', '16', '03', 'PAROBAMBA', 'Distrito'),
(433, '02', '16', '04', 'QUINUABAMBA', 'Distrito'),
(434, '02', '17', '01', 'RECUAY', 'Distrito'),
(435, '02', '17', '02', 'CATAC', 'Distrito'),
(436, '02', '17', '03', 'COTAPARACO', 'Distrito'),
(437, '02', '17', '04', 'HUAYLLAPAMPA', 'Distrito'),
(438, '02', '17', '05', 'LLACLLIN', 'Distrito'),
(439, '02', '17', '06', 'MARCA', 'Distrito'),
(440, '02', '17', '07', 'PAMPAS CHICO', 'Distrito'),
(441, '02', '17', '08', 'PARARIN', 'Distrito'),
(442, '02', '17', '09', 'TAPACOCHA', 'Distrito'),
(443, '02', '17', '10', 'TICAPAMPA', 'Distrito'),
(444, '02', '18', '01', 'CHIMBOTE', 'Distrito'),
(445, '02', '18', '02', 'CACERES DEL PERU', 'Distrito'),
(446, '02', '18', '03', 'COISHCO', 'Distrito'),
(447, '02', '18', '04', 'MACATE', 'Distrito'),
(448, '02', '18', '05', 'MORO', 'Distrito'),
(449, '02', '18', '06', 'NEPEÃ‘A', 'Distrito'),
(450, '02', '18', '07', 'SAMANCO', 'Distrito'),
(451, '02', '18', '08', 'SANTA', 'Distrito'),
(452, '02', '18', '09', 'NUEVO CHIMBOTE', 'Distrito'),
(453, '02', '19', '01', 'SIHUAS', 'Distrito'),
(454, '02', '19', '02', 'ACOBAMBA', 'Distrito'),
(455, '02', '19', '03', 'ALFONSO UGARTE', 'Distrito'),
(456, '02', '19', '04', 'CASHAPAMPA', 'Distrito'),
(457, '02', '19', '05', 'CHINGALPO', 'Distrito'),
(458, '02', '19', '06', 'HUAYLLABAMBA', 'Distrito'),
(459, '02', '19', '07', 'QUICHES', 'Distrito'),
(460, '02', '19', '08', 'RAGASH', 'Distrito'),
(461, '02', '19', '09', 'SAN JUAN', 'Distrito'),
(462, '02', '19', '10', 'SICSIBAMBA', 'Distrito'),
(463, '02', '20', '01', 'YUNGAY', 'Distrito'),
(464, '02', '20', '02', 'CASCAPARA', 'Distrito'),
(465, '02', '20', '03', 'MANCOS', 'Distrito'),
(466, '02', '20', '04', 'MATACOTO', 'Distrito'),
(467, '02', '20', '05', 'QUILLO', 'Distrito'),
(468, '02', '20', '06', 'RANRAHIRCA', 'Distrito'),
(469, '02', '20', '07', 'SHUPLUY', 'Distrito'),
(470, '02', '20', '08', 'YANAMA', 'Distrito'),
(471, '03', '01', '01', 'ABANCAY', 'Distrito'),
(472, '03', '01', '02', 'CHACOCHE', 'Distrito'),
(473, '03', '01', '03', 'CIRCA', 'Distrito'),
(474, '03', '01', '04', 'CURAHUASI', 'Distrito'),
(475, '03', '01', '05', 'HUANIPACA', 'Distrito'),
(476, '03', '01', '06', 'LAMBRAMA', 'Distrito'),
(477, '03', '01', '07', 'PICHIRHUA', 'Distrito'),
(478, '03', '01', '08', 'SAN PEDRO DE CACHORA', 'Distrito'),
(479, '03', '01', '09', 'TAMBURCO', 'Distrito'),
(480, '03', '02', '01', 'ANDAHUAYLAS', 'Distrito'),
(481, '03', '02', '02', 'ANDARAPA', 'Distrito'),
(482, '03', '02', '03', 'CHIARA', 'Distrito'),
(483, '03', '02', '04', 'HUANCARAMA', 'Distrito'),
(484, '03', '02', '05', 'HUANCARAY', 'Distrito'),
(485, '03', '02', '06', 'HUAYANA', 'Distrito'),
(486, '03', '02', '07', 'KISHUARA', 'Distrito'),
(487, '03', '02', '08', 'PACOBAMBA', 'Distrito'),
(488, '03', '02', '09', 'PACUCHA', 'Distrito'),
(489, '03', '02', '10', 'PAMPACHIRI', 'Distrito'),
(490, '03', '02', '11', 'POMACOCHA', 'Distrito'),
(491, '03', '02', '12', 'SAN ANTONIO DE CACHI', 'Distrito'),
(492, '03', '02', '13', 'SAN JERONIMO', 'Distrito'),
(493, '03', '02', '14', 'SAN MIGUEL DE CHACCRAMPA', 'Distrito'),
(494, '03', '02', '15', 'SANTA MARIA DE CHICMO', 'Distrito'),
(495, '03', '02', '16', 'TALAVERA', 'Distrito'),
(496, '03', '02', '17', 'TUMAY HUARACA', 'Distrito'),
(497, '03', '02', '18', 'TURPO', 'Distrito'),
(498, '03', '02', '19', 'KAQUIABAMBA', 'Distrito'),
(499, '03', '03', '01', 'ANTABAMBA', 'Distrito'),
(500, '03', '03', '02', 'EL ORO', 'Distrito'),
(501, '03', '03', '03', 'HUAQUIRCA', 'Distrito'),
(502, '03', '03', '04', 'JUAN ESPINOZA MEDRANO', 'Distrito'),
(503, '03', '03', '05', 'OROPESA', 'Distrito'),
(504, '03', '03', '06', 'PACHACONAS', 'Distrito'),
(505, '03', '03', '07', 'SABAINO', 'Distrito'),
(506, '03', '04', '01', 'CHALHUANCA', 'Distrito'),
(507, '03', '04', '02', 'CAPAYA', 'Distrito'),
(508, '03', '04', '03', 'CARAYBAMBA', 'Distrito'),
(509, '03', '04', '04', 'CHAPIMARCA', 'Distrito'),
(510, '03', '04', '05', 'COLCABAMBA', 'Distrito'),
(511, '03', '04', '06', 'COTARUSE', 'Distrito'),
(512, '03', '04', '07', 'HUAYLLO', 'Distrito'),
(513, '03', '04', '08', 'JUSTO APU SAHUARAURA', 'Distrito'),
(514, '03', '04', '09', 'LUCRE', 'Distrito'),
(515, '03', '04', '10', 'POCOHUANCA', 'Distrito'),
(516, '03', '04', '11', 'SAN JUAN DE CHACÃ‘A', 'Distrito'),
(517, '03', '04', '12', 'SAÃ‘AYCA', 'Distrito'),
(518, '03', '04', '13', 'SORAYA', 'Distrito'),
(519, '03', '04', '14', 'TAPAIRIHUA', 'Distrito'),
(520, '03', '04', '15', 'TINTAY', 'Distrito'),
(521, '03', '04', '16', 'TORAYA', 'Distrito'),
(522, '03', '04', '17', 'YANACA', 'Distrito'),
(523, '03', '05', '01', 'TAMBOBAMBA', 'Distrito'),
(524, '03', '05', '02', 'COTABAMBAS', 'Distrito'),
(525, '03', '05', '03', 'COYLLURQUI', 'Distrito'),
(526, '03', '05', '04', 'HAQUIRA', 'Distrito'),
(527, '03', '05', '05', 'MARA', 'Distrito'),
(528, '03', '05', '06', 'CHALLHUAHUACHO', 'Distrito'),
(529, '03', '06', '01', 'CHINCHEROS', 'Distrito'),
(530, '03', '06', '02', 'ANCO-HUALLO', 'Distrito'),
(531, '03', '06', '03', 'COCHARCAS', 'Distrito'),
(532, '03', '06', '04', 'HUACCANA', 'Distrito'),
(533, '03', '06', '05', 'OCOBAMBA', 'Distrito'),
(534, '03', '06', '06', 'ONGOY', 'Distrito'),
(535, '03', '06', '07', 'URANMARCA', 'Distrito'),
(536, '03', '06', '08', 'RANRACANCHA', 'Distrito'),
(537, '03', '07', '01', 'CHUQUIBAMBILLA', 'Distrito'),
(538, '03', '07', '02', 'CURPAHUASI', 'Distrito'),
(539, '03', '07', '03', 'GAMARRA', 'Distrito'),
(540, '03', '07', '04', 'HUAYLLATI', 'Distrito'),
(541, '03', '07', '05', 'MAMARA', 'Distrito'),
(542, '03', '07', '06', 'MICAELA BASTIDAS', 'Distrito'),
(543, '03', '07', '07', 'PATAYPAMPA', 'Distrito'),
(544, '03', '07', '08', 'PROGRESO', 'Distrito'),
(545, '03', '07', '09', 'SAN ANTONIO', 'Distrito'),
(546, '03', '07', '10', 'SANTA ROSA', 'Distrito'),
(547, '03', '07', '11', 'TURPAY', 'Distrito'),
(548, '03', '07', '12', 'VILCABAMBA', 'Distrito'),
(549, '03', '07', '13', 'VIRUNDO', 'Distrito'),
(550, '03', '07', '14', 'CURASCO', 'Distrito'),
(551, '04', '01', '01', 'AREQUIPA', 'Distrito'),
(552, '04', '01', '02', 'ALTO SELVA ALEGRE', 'Distrito'),
(553, '04', '01', '03', 'CAYMA', 'Distrito'),
(554, '04', '01', '04', 'CERRO COLORADO', 'Distrito'),
(555, '04', '01', '05', 'CHARACATO', 'Distrito'),
(556, '04', '01', '06', 'CHIGUATA', 'Distrito'),
(557, '04', '01', '07', 'JACOBO HUNTER', 'Distrito'),
(558, '04', '01', '08', 'LA JOYA', 'Distrito'),
(559, '04', '01', '09', 'MARIANO MELGAR', 'Distrito'),
(560, '04', '01', '10', 'MIRAFLORES', 'Distrito'),
(561, '04', '01', '11', 'MOLLEBAYA', 'Distrito'),
(562, '04', '01', '12', 'PAUCARPATA', 'Distrito'),
(563, '04', '01', '13', 'POCSI', 'Distrito'),
(564, '04', '01', '14', 'POLOBAYA', 'Distrito'),
(565, '04', '01', '15', 'QUEQUEÃ‘A', 'Distrito'),
(566, '04', '01', '16', 'SABANDIA', 'Distrito'),
(567, '04', '01', '17', 'SACHACA', 'Distrito'),
(568, '04', '01', '18', 'SAN JUAN DE SIGUAS /1', 'Distrito'),
(569, '04', '01', '19', 'SAN JUAN DE TARUCANI', 'Distrito'),
(570, '04', '01', '20', 'SANTA ISABEL DE SIGUAS', 'Distrito'),
(571, '04', '01', '21', 'SANTA RITA DE SIGUAS', 'Distrito'),
(572, '04', '01', '22', 'SOCABAYA', 'Distrito'),
(573, '04', '01', '23', 'TIABAYA', 'Distrito'),
(574, '04', '01', '24', 'UCHUMAYO', 'Distrito'),
(575, '04', '01', '25', 'VITOR ', 'Distrito'),
(576, '04', '01', '26', 'YANAHUARA', 'Distrito'),
(577, '04', '01', '27', 'YARABAMBA', 'Distrito'),
(578, '04', '01', '28', 'YURA', 'Distrito'),
(579, '04', '01', '29', 'JOSE LUIS BUSTAMANTE Y RIVERO', 'Distrito'),
(580, '04', '02', '01', 'CAMANA', 'Distrito'),
(581, '04', '02', '02', 'JOSE MARIA QUIMPER', 'Distrito'),
(582, '04', '02', '03', 'MARIANO NICOLAS VALCARCEL', 'Distrito'),
(583, '04', '02', '04', 'MARISCAL CACERES', 'Distrito'),
(584, '04', '02', '05', 'NICOLAS DE PIEROLA', 'Distrito'),
(585, '04', '02', '06', 'OCOÃ‘A', 'Distrito'),
(586, '04', '02', '07', 'QUILCA', 'Distrito'),
(587, '04', '02', '08', 'SAMUEL PASTOR', 'Distrito'),
(588, '04', '03', '01', 'CARAVELI', 'Distrito'),
(589, '04', '03', '02', 'ACARI', 'Distrito'),
(590, '04', '03', '03', 'ATICO', 'Distrito'),
(591, '04', '03', '04', 'ATIQUIPA', 'Distrito'),
(592, '04', '03', '05', 'BELLA UNION', 'Distrito'),
(593, '04', '03', '06', 'CAHUACHO', 'Distrito'),
(594, '04', '03', '07', 'CHALA', 'Distrito'),
(595, '04', '03', '08', 'CHAPARRA', 'Distrito'),
(596, '04', '03', '09', 'HUANUHUANU', 'Distrito'),
(597, '04', '03', '10', 'JAQUI', 'Distrito'),
(598, '04', '03', '11', 'LOMAS', 'Distrito'),
(599, '04', '03', '12', 'QUICACHA', 'Distrito'),
(600, '04', '03', '13', 'YAUCA', 'Distrito'),
(601, '04', '04', '01', 'APLAO', 'Distrito'),
(602, '04', '04', '02', 'ANDAGUA', 'Distrito'),
(603, '04', '04', '03', 'AYO', 'Distrito'),
(604, '04', '04', '04', 'CHACHAS', 'Distrito'),
(605, '04', '04', '05', 'CHILCAYMARCA', 'Distrito'),
(606, '04', '04', '06', 'CHOCO', 'Distrito'),
(607, '04', '04', '07', 'HUANCARQUI', 'Distrito'),
(608, '04', '04', '08', 'MACHAGUAY', 'Distrito'),
(609, '04', '04', '09', 'ORCOPAMPA', 'Distrito'),
(610, '04', '04', '10', 'PAMPACOLCA', 'Distrito'),
(611, '04', '04', '11', 'TIPAN', 'Distrito'),
(612, '04', '04', '12', 'UÃ‘ON', 'Distrito'),
(613, '04', '04', '13', 'URACA', 'Distrito'),
(614, '04', '04', '14', 'VIRACO', 'Distrito'),
(615, '04', '05', '01', 'CHIVAY', 'Distrito'),
(616, '04', '05', '02', 'ACHOMA', 'Distrito'),
(617, '04', '05', '03', 'CABANACONDE', 'Distrito'),
(618, '04', '05', '04', 'CALLALLI', 'Distrito'),
(619, '04', '05', '05', 'CAYLLOMA', 'Distrito'),
(620, '04', '05', '06', 'COPORAQUE', 'Distrito'),
(621, '04', '05', '07', 'HUAMBO', 'Distrito'),
(622, '04', '05', '08', 'HUANCA', 'Distrito'),
(623, '04', '05', '09', 'ICHUPAMPA', 'Distrito'),
(624, '04', '05', '10', 'LARI', 'Distrito'),
(625, '04', '05', '11', 'LLUTA', 'Distrito'),
(626, '04', '05', '12', 'MACA', 'Distrito'),
(627, '04', '05', '13', 'MADRIGAL', 'Distrito'),
(628, '04', '05', '14', 'SAN ANTONIO DE CHUCA  2/', 'Distrito'),
(629, '04', '05', '15', 'SIBAYO', 'Distrito'),
(630, '04', '05', '16', 'TAPAY', 'Distrito'),
(631, '04', '05', '17', 'TISCO', 'Distrito'),
(632, '04', '05', '18', 'TUTI', 'Distrito'),
(633, '04', '05', '19', 'YANQUE', 'Distrito'),
(634, '04', '05', '20', 'MAJES', 'Distrito'),
(635, '04', '06', '01', 'CHUQUIBAMBA', 'Distrito'),
(636, '04', '06', '02', 'ANDARAY', 'Distrito'),
(637, '04', '06', '03', 'CAYARANI', 'Distrito'),
(638, '04', '06', '04', 'CHICHAS', 'Distrito'),
(639, '04', '06', '05', 'IRAY', 'Distrito'),
(640, '04', '06', '06', 'RIO GRANDE', 'Distrito'),
(641, '04', '06', '07', 'SALAMANCA', 'Distrito'),
(642, '04', '06', '08', 'YANAQUIHUA', 'Distrito'),
(643, '04', '07', '01', 'MOLLENDO', 'Distrito'),
(644, '04', '07', '02', 'COCACHACRA', 'Distrito'),
(645, '04', '07', '03', 'DEAN VALDIVIA', 'Distrito'),
(646, '04', '07', '04', 'ISLAY', 'Distrito'),
(647, '04', '07', '05', 'MEJIA', 'Distrito'),
(648, '04', '07', '06', 'PUNTA DE BOMBON', 'Distrito'),
(649, '04', '08', '01', 'COTAHUASI', 'Distrito'),
(650, '04', '08', '02', 'ALCA', 'Distrito'),
(651, '04', '08', '03', 'CHARCANA', 'Distrito'),
(652, '04', '08', '04', 'HUAYNACOTAS', 'Distrito'),
(653, '04', '08', '05', 'PAMPAMARCA', 'Distrito'),
(654, '04', '08', '06', 'PUYCA', 'Distrito'),
(655, '04', '08', '07', 'QUECHUALLA', 'Distrito'),
(656, '04', '08', '08', 'SAYLA', 'Distrito'),
(657, '04', '08', '09', 'TAURIA', 'Distrito'),
(658, '04', '08', '10', 'TOMEPAMPA', 'Distrito'),
(659, '04', '08', '11', 'TORO', 'Distrito'),
(660, '05', '01', '01', 'AYACUCHO', 'Distrito'),
(661, '05', '01', '02', 'ACOCRO', 'Distrito'),
(662, '05', '01', '03', 'ACOS VINCHOS', 'Distrito'),
(663, '05', '01', '04', 'CARMEN ALTO', 'Distrito'),
(664, '05', '01', '05', 'CHIARA', 'Distrito'),
(665, '05', '01', '06', 'OCROS', 'Distrito'),
(666, '05', '01', '07', 'PACAYCASA', 'Distrito'),
(667, '05', '01', '08', 'QUINUA', 'Distrito'),
(668, '05', '01', '09', 'SAN JOSE DE TICLLAS', 'Distrito'),
(669, '05', '01', '10', 'SAN JUAN BAUTISTA', 'Distrito'),
(670, '05', '01', '11', 'SANTIAGO DE PISCHA', 'Distrito'),
(671, '05', '01', '12', 'SOCOS', 'Distrito'),
(672, '05', '01', '13', 'TAMBILLO', 'Distrito'),
(673, '05', '01', '14', 'VINCHOS', 'Distrito'),
(674, '05', '01', '15', 'JESUS NAZARENO', 'Distrito'),
(675, '05', '02', '01', 'CANGALLO', 'Distrito'),
(676, '05', '02', '02', 'CHUSCHI', 'Distrito'),
(677, '05', '02', '03', 'LOS MOROCHUCOS', 'Distrito'),
(678, '05', '02', '04', 'MARIA PARADO DE BELLIDO', 'Distrito'),
(679, '05', '02', '05', 'PARAS', 'Distrito'),
(680, '05', '02', '06', 'TOTOS', 'Distrito'),
(681, '05', '03', '01', 'SANCOS', 'Distrito'),
(682, '05', '03', '02', 'CARAPO', 'Distrito'),
(683, '05', '03', '03', 'SACSAMARCA', 'Distrito'),
(684, '05', '03', '04', 'SANTIAGO DE LUCANAMARCA', 'Distrito'),
(685, '05', '04', '01', 'HUANTA', 'Distrito'),
(686, '05', '04', '02', 'AYAHUANCO', 'Distrito'),
(687, '05', '04', '03', 'HUAMANGUILLA', 'Distrito'),
(688, '05', '04', '04', 'IGUAIN', 'Distrito'),
(689, '05', '04', '05', 'LURICOCHA', 'Distrito'),
(690, '05', '04', '06', 'SANTILLANA', 'Distrito'),
(691, '05', '04', '07', 'SIVIA', 'Distrito'),
(692, '05', '04', '08', 'LLOCHEGUA', 'Distrito'),
(693, '05', '05', '01', 'SAN MIGUEL', 'Distrito'),
(694, '05', '05', '02', 'ANCO', 'Distrito'),
(695, '05', '05', '03', 'AYNA', 'Distrito'),
(696, '05', '05', '04', 'CHILCAS', 'Distrito'),
(697, '05', '05', '05', 'CHUNGUI', 'Distrito'),
(698, '05', '05', '06', 'LUIS CARRANZA', 'Distrito'),
(699, '05', '05', '07', 'SANTA ROSA', 'Distrito'),
(700, '05', '05', '08', 'TAMBO', 'Distrito'),
(701, '05', '06', '01', 'PUQUIO', 'Distrito'),
(702, '05', '06', '02', 'AUCARA', 'Distrito'),
(703, '05', '06', '03', 'CABANA', 'Distrito'),
(704, '05', '06', '04', 'CARMEN SALCEDO', 'Distrito'),
(705, '05', '06', '05', 'CHAVIÃ‘A', 'Distrito'),
(706, '05', '06', '06', 'CHIPAO', 'Distrito'),
(707, '05', '06', '07', 'HUAC-HUAS', 'Distrito'),
(708, '05', '06', '08', 'LARAMATE', 'Distrito'),
(709, '05', '06', '09', 'LEONCIO PRADO', 'Distrito'),
(710, '05', '06', '10', 'LLAUTA', 'Distrito'),
(711, '05', '06', '11', 'LUCANAS', 'Distrito'),
(712, '05', '06', '12', 'OCAÃ‘A', 'Distrito'),
(713, '05', '06', '13', 'OTOCA', 'Distrito'),
(714, '05', '06', '14', 'SAISA', 'Distrito'),
(715, '05', '06', '15', 'SAN CRISTOBAL', 'Distrito'),
(716, '05', '06', '16', 'SAN JUAN', 'Distrito'),
(717, '05', '06', '17', 'SAN PEDRO', 'Distrito'),
(718, '05', '06', '18', 'SAN PEDRO DE PALCO', 'Distrito'),
(719, '05', '06', '19', 'SANCOS', 'Distrito'),
(720, '05', '06', '20', 'SANTA ANA DE HUAYCAHUACHO', 'Distrito'),
(721, '05', '06', '21', 'SANTA LUCIA', 'Distrito'),
(722, '05', '07', '01', 'CORACORA', 'Distrito'),
(723, '05', '07', '02', 'CHUMPI', 'Distrito'),
(724, '05', '07', '03', 'CORONEL CASTAÃ‘EDA', 'Distrito'),
(725, '05', '07', '04', 'PACAPAUSA', 'Distrito'),
(726, '05', '07', '05', 'PULLO', 'Distrito'),
(727, '05', '07', '06', 'PUYUSCA', 'Distrito'),
(728, '05', '07', '07', 'SAN FRANCISCO DE RAVACAYCO', 'Distrito'),
(729, '05', '07', '08', 'UPAHUACHO', 'Distrito'),
(730, '05', '08', '01', 'PAUSA', 'Distrito'),
(731, '05', '08', '02', 'COLTA', 'Distrito'),
(732, '05', '08', '03', 'CORCULLA', 'Distrito'),
(733, '05', '08', '04', 'LAMPA', 'Distrito'),
(734, '05', '08', '05', 'MARCABAMBA', 'Distrito'),
(735, '05', '08', '06', 'OYOLO', 'Distrito'),
(736, '05', '08', '07', 'PARARCA', 'Distrito'),
(737, '05', '08', '08', 'SAN JAVIER DE ALPABAMBA', 'Distrito'),
(738, '05', '08', '09', 'SAN JOSE DE USHUA', 'Distrito'),
(739, '05', '08', '10', 'SARA SARA', 'Distrito'),
(740, '05', '09', '01', 'QUEROBAMBA', 'Distrito'),
(741, '05', '09', '02', 'BELEN', 'Distrito'),
(742, '05', '09', '03', 'CHALCOS', 'Distrito'),
(743, '05', '09', '04', 'CHILCAYOC', 'Distrito'),
(744, '05', '09', '05', 'HUACAÃ‘A', 'Distrito'),
(745, '05', '09', '06', 'MORCOLLA', 'Distrito'),
(746, '05', '09', '07', 'PAICO', 'Distrito'),
(747, '05', '09', '08', 'SAN PEDRO DE LARCAY', 'Distrito'),
(748, '05', '09', '09', 'SAN SALVADOR DE QUIJE', 'Distrito'),
(749, '05', '09', '10', 'SANTIAGO DE PAUCARAY', 'Distrito'),
(750, '05', '09', '11', 'SORAS', 'Distrito'),
(751, '05', '10', '01', 'HUANCAPI', 'Distrito'),
(752, '05', '10', '02', 'ALCAMENCA', 'Distrito'),
(753, '05', '10', '03', 'APONGO', 'Distrito'),
(754, '05', '10', '04', 'ASQUIPATA', 'Distrito'),
(755, '05', '10', '05', 'CANARIA', 'Distrito'),
(756, '05', '10', '06', 'CAYARA', 'Distrito'),
(757, '05', '10', '07', 'COLCA', 'Distrito'),
(758, '05', '10', '08', 'HUAMANQUIQUIA', 'Distrito'),
(759, '05', '10', '09', 'HUANCARAYLLA', 'Distrito'),
(760, '05', '10', '10', 'HUAYA', 'Distrito'),
(761, '05', '10', '11', 'SARHUA', 'Distrito'),
(762, '05', '10', '12', 'VILCANCHOS', 'Distrito'),
(763, '05', '11', '01', 'VILCAS HUAMAN', 'Distrito'),
(764, '05', '11', '02', 'ACCOMARCA', 'Distrito'),
(765, '05', '11', '03', 'CARHUANCA', 'Distrito'),
(766, '05', '11', '04', 'CONCEPCION', 'Distrito'),
(767, '05', '11', '05', 'HUAMBALPA', 'Distrito'),
(768, '05', '11', '06', 'INDEPENDENCIA /1', 'Distrito'),
(769, '05', '11', '07', 'SAURAMA', 'Distrito'),
(770, '05', '11', '08', 'VISCHONGO', 'Distrito'),
(771, '06', '01', '01', 'CAJAMARCA', 'Distrito'),
(772, '06', '01', '02', 'ASUNCION', 'Distrito'),
(773, '06', '01', '03', 'CHETILLA', 'Distrito'),
(774, '06', '01', '04', 'COSPAN', 'Distrito'),
(775, '06', '01', '05', 'ENCAÃ‘ADA', 'Distrito'),
(776, '06', '01', '06', 'JESUS', 'Distrito'),
(777, '06', '01', '07', 'LLACANORA', 'Distrito'),
(778, '06', '01', '08', 'LOS BAÃ‘OS DEL INCA', 'Distrito'),
(779, '06', '01', '09', 'MAGDALENA', 'Distrito'),
(780, '06', '01', '10', 'MATARA', 'Distrito'),
(781, '06', '01', '11', 'NAMORA', 'Distrito'),
(782, '06', '01', '12', 'SAN JUAN', 'Distrito'),
(783, '06', '02', '01', 'CAJABAMBA', 'Distrito'),
(784, '06', '02', '02', 'CACHACHI', 'Distrito'),
(785, '06', '02', '03', 'CONDEBAMBA', 'Distrito'),
(786, '06', '02', '04', 'SITACOCHA', 'Distrito'),
(787, '06', '03', '01', 'CELENDIN', 'Distrito'),
(788, '06', '03', '02', 'CHUMUCH', 'Distrito'),
(789, '06', '03', '03', 'CORTEGANA', 'Distrito'),
(790, '06', '03', '04', 'HUASMIN', 'Distrito'),
(791, '06', '03', '05', 'JORGE CHAVEZ', 'Distrito'),
(792, '06', '03', '06', 'JOSE GALVEZ', 'Distrito'),
(793, '06', '03', '07', 'MIGUEL IGLESIAS', 'Distrito'),
(794, '06', '03', '08', 'OXAMARCA', 'Distrito'),
(795, '06', '03', '09', 'SOROCHUCO', 'Distrito'),
(796, '06', '03', '10', 'SUCRE', 'Distrito'),
(797, '06', '03', '11', 'UTCO', 'Distrito'),
(798, '06', '03', '12', 'LA LIBERTAD DE PALLAN', 'Distrito'),
(799, '06', '04', '01', 'CHOTA', 'Distrito'),
(800, '06', '04', '02', 'ANGUIA', 'Distrito'),
(801, '06', '04', '03', 'CHADIN', 'Distrito'),
(802, '06', '04', '04', 'CHIGUIRIP', 'Distrito'),
(803, '06', '04', '05', 'CHIMBAN', 'Distrito'),
(804, '06', '04', '06', 'CHOROPAMPA', 'Distrito'),
(805, '06', '04', '07', 'COCHABAMBA', 'Distrito'),
(806, '06', '04', '08', 'CONCHAN', 'Distrito'),
(807, '06', '04', '09', 'HUAMBOS', 'Distrito'),
(808, '06', '04', '10', 'LAJAS', 'Distrito'),
(809, '06', '04', '11', 'LLAMA', 'Distrito'),
(810, '06', '04', '12', 'MIRACOSTA', 'Distrito'),
(811, '06', '04', '13', 'PACCHA', 'Distrito'),
(812, '06', '04', '14', 'PION', 'Distrito'),
(813, '06', '04', '15', 'QUEROCOTO', 'Distrito'),
(814, '06', '04', '16', 'SAN JUAN DE LICUPIS', 'Distrito'),
(815, '06', '04', '17', 'TACABAMBA', 'Distrito'),
(816, '06', '04', '18', 'TOCMOCHE', 'Distrito'),
(817, '06', '04', '19', 'CHALAMARCA', 'Distrito'),
(818, '06', '05', '01', 'CONTUMAZA', 'Distrito'),
(819, '06', '05', '02', 'CHILETE', 'Distrito'),
(820, '06', '05', '03', 'CUPISNIQUE', 'Distrito'),
(821, '06', '05', '04', 'GUZMANGO', 'Distrito'),
(822, '06', '05', '05', 'SAN BENITO', 'Distrito'),
(823, '06', '05', '06', 'SANTA CRUZ DE TOLED', 'Distrito'),
(824, '06', '05', '07', 'TANTARICA', 'Distrito'),
(825, '06', '05', '08', 'YONAN', 'Distrito'),
(826, '06', '06', '01', 'CUTERVO', 'Distrito'),
(827, '06', '06', '02', 'CALLAYUC', 'Distrito'),
(828, '06', '06', '03', 'CHOROS', 'Distrito'),
(829, '06', '06', '04', 'CUJILLO', 'Distrito'),
(830, '06', '06', '05', 'LA RAMADA', 'Distrito'),
(831, '06', '06', '06', 'PIMPINGOS', 'Distrito'),
(832, '06', '06', '07', 'QUEROCOTILLO', 'Distrito'),
(833, '06', '06', '08', 'SAN ANDRES DE CUTERVO', 'Distrito'),
(834, '06', '06', '09', 'SAN JUAN DE CUTERVO', 'Distrito'),
(835, '06', '06', '10', 'SAN LUIS DE LUCMA', 'Distrito'),
(836, '06', '06', '11', 'SANTA CRUZ', 'Distrito'),
(837, '06', '06', '12', 'SANTO DOMINGO DE LA CAPILLA', 'Distrito'),
(838, '06', '06', '13', 'SANTO TOMAS', 'Distrito'),
(839, '06', '06', '14', 'SOCOTA', 'Distrito'),
(840, '06', '06', '15', 'TORIBIO CASANOVA', 'Distrito'),
(841, '06', '07', '01', 'BAMBAMARCA', 'Distrito'),
(842, '06', '07', '02', 'CHUGUR', 'Distrito'),
(843, '06', '07', '03', 'HUALGAYOC', 'Distrito'),
(844, '06', '08', '01', 'JAEN', 'Distrito'),
(845, '06', '08', '02', 'BELLAVISTA', 'Distrito'),
(846, '06', '08', '03', 'CHONTALI', 'Distrito'),
(847, '06', '08', '04', 'COLASAY', 'Distrito'),
(848, '06', '08', '05', 'HUABAL', 'Distrito'),
(849, '06', '08', '06', 'LAS PIRIAS', 'Distrito'),
(850, '06', '08', '07', 'POMAHUACA', 'Distrito'),
(851, '06', '08', '08', 'PUCARA', 'Distrito'),
(852, '06', '08', '09', 'SALLIQUE', 'Distrito'),
(853, '06', '08', '10', 'SAN FELIPE', 'Distrito'),
(854, '06', '08', '11', 'SAN JOSE DEL ALTO', 'Distrito'),
(855, '06', '08', '12', 'SANTA ROSA', 'Distrito'),
(856, '06', '09', '01', 'SAN IGNACIO', 'Distrito'),
(857, '06', '09', '02', 'CHIRINOS', 'Distrito'),
(858, '06', '09', '03', 'HUARANGO', 'Distrito'),
(859, '06', '09', '04', 'LA COIPA', 'Distrito'),
(860, '06', '09', '05', 'NAMBALLE', 'Distrito'),
(861, '06', '09', '06', 'SAN JOSE DE LOURDES', 'Distrito'),
(862, '06', '09', '07', 'TABACONAS', 'Distrito'),
(863, '06', '10', '01', 'PEDRO GALVEZ', 'Distrito'),
(864, '06', '10', '02', 'CHANCAY', 'Distrito'),
(865, '06', '10', '03', 'EDUARDO VILLANUEVA', 'Distrito'),
(866, '06', '10', '04', 'GREGORIO PITA', 'Distrito'),
(867, '06', '10', '05', 'ICHOCAN', 'Distrito'),
(868, '06', '10', '06', 'JOSE MANUEL QUIROZ', 'Distrito'),
(869, '06', '10', '07', 'JOSE SABOGAL', 'Distrito'),
(870, '06', '11', '01', 'SAN MIGUEL', 'Distrito'),
(871, '06', '11', '02', 'BOLIVAR', 'Distrito'),
(872, '06', '11', '03', 'CALQUIS', 'Distrito'),
(873, '06', '11', '04', 'CATILLUC', 'Distrito'),
(874, '06', '11', '05', 'EL PRADO', 'Distrito'),
(875, '06', '11', '06', 'LA FLORIDA', 'Distrito'),
(876, '06', '11', '07', 'LLAPA', 'Distrito'),
(877, '06', '11', '08', 'NANCHOC', 'Distrito'),
(878, '06', '11', '09', 'NIEPOS', 'Distrito'),
(879, '06', '11', '10', 'SAN GREGORIO', 'Distrito'),
(880, '06', '11', '11', 'SAN SILVESTRE DE COCHAN', 'Distrito'),
(881, '06', '11', '12', 'TONGOD', 'Distrito'),
(882, '06', '11', '13', 'UNION AGUA BLANCA', 'Distrito'),
(883, '06', '12', '01', 'SAN PABLO', 'Distrito'),
(884, '06', '12', '02', 'SAN BERNARDINO', 'Distrito'),
(885, '06', '12', '03', 'SAN LUIS', 'Distrito'),
(886, '06', '12', '04', 'TUMBADEN', 'Distrito'),
(887, '06', '13', '01', 'SANTA CRUZ', 'Distrito'),
(888, '06', '13', '02', 'ANDABAMBA', 'Distrito'),
(889, '06', '13', '03', 'CATACHE', 'Distrito'),
(890, '06', '13', '04', 'CHANCAYBAÃ‘OS', 'Distrito'),
(891, '06', '13', '05', 'LA ESPERANZA', 'Distrito'),
(892, '06', '13', '06', 'NINABAMBA', 'Distrito'),
(893, '06', '13', '07', 'PULAN', 'Distrito'),
(894, '06', '13', '08', 'SAUCEPAMPA', 'Distrito'),
(895, '06', '13', '09', 'SEXI', 'Distrito'),
(896, '06', '13', '10', 'UTICYACU', 'Distrito'),
(897, '06', '13', '11', 'YAUYUCAN', 'Distrito'),
(898, '07', '01', '01', 'CALLAO', 'Distrito'),
(899, '07', '01', '02', 'BELLAVISTA', 'Distrito'),
(900, '07', '01', '03', 'CARMEN DE LA LEGUA REYNOSO', 'Distrito'),
(901, '07', '01', '04', 'LA PERLA', 'Distrito'),
(902, '07', '01', '05', 'LA PUNTA', 'Distrito'),
(903, '07', '01', '06', 'VENTANILLA', 'Distrito'),
(904, '08', '01', '01', 'CUSCO', 'Distrito'),
(905, '08', '01', '02', 'CCORCA', 'Distrito'),
(906, '08', '01', '03', 'POROY', 'Distrito'),
(907, '08', '01', '04', 'SAN JERONIMO', 'Distrito'),
(908, '08', '01', '05', 'SAN SEBASTIAN', 'Distrito'),
(909, '08', '01', '06', 'SANTIAGO', 'Distrito'),
(910, '08', '01', '07', 'SAYLLA', 'Distrito'),
(911, '08', '01', '08', 'WANCHAQ', 'Distrito'),
(912, '08', '02', '01', 'ACOMAYO', 'Distrito'),
(913, '08', '02', '02', 'ACOPIA', 'Distrito'),
(914, '08', '02', '03', 'ACOS', 'Distrito'),
(915, '08', '02', '04', 'MOSOC LLACTA', 'Distrito'),
(916, '08', '02', '05', 'POMACANCHI', 'Distrito'),
(917, '08', '02', '06', 'RONDOCAN', 'Distrito'),
(918, '08', '02', '07', 'SANGARARA', 'Distrito'),
(919, '08', '03', '01', 'ANTA', 'Distrito'),
(920, '08', '03', '02', 'ANCAHUASI', 'Distrito'),
(921, '08', '03', '03', 'CACHIMAYO', 'Distrito'),
(922, '08', '03', '04', 'CHINCHAYPUJIO', 'Distrito'),
(923, '08', '03', '05', 'HUAROCONDO', 'Distrito'),
(924, '08', '03', '06', 'LIMATAMBO', 'Distrito'),
(925, '08', '03', '07', 'MOLLEPATA', 'Distrito'),
(926, '08', '03', '08', 'PUCYURA', 'Distrito'),
(927, '08', '03', '09', 'ZURITE', 'Distrito'),
(928, '08', '04', '01', 'CALCA', 'Distrito'),
(929, '08', '04', '02', 'COYA', 'Distrito'),
(930, '08', '04', '03', 'LAMAY', 'Distrito'),
(931, '08', '04', '04', 'LARES', 'Distrito'),
(932, '08', '04', '05', 'PISAC', 'Distrito'),
(933, '08', '04', '06', 'SAN SALVADOR', 'Distrito'),
(934, '08', '04', '07', 'TARAY', 'Distrito'),
(935, '08', '04', '08', 'YANATILE', 'Distrito'),
(936, '08', '05', '01', 'YANAOCA', 'Distrito'),
(937, '08', '05', '02', 'CHECCA', 'Distrito'),
(938, '08', '05', '03', 'KUNTURKANKI', 'Distrito'),
(939, '08', '05', '04', 'LANGUI', 'Distrito'),
(940, '08', '05', '05', 'LAYO', 'Distrito'),
(941, '08', '05', '06', 'PAMPAMARCA', 'Distrito'),
(942, '08', '05', '07', 'QUEHUE', 'Distrito'),
(943, '08', '05', '08', 'TUPAC AMARU', 'Distrito'),
(944, '08', '06', '01', 'SICUANI', 'Distrito'),
(945, '08', '06', '02', 'CHECACUPE', 'Distrito'),
(946, '08', '06', '03', 'COMBAPATA', 'Distrito'),
(947, '08', '06', '04', 'MARANGANI', 'Distrito'),
(948, '08', '06', '05', 'PITUMARCA', 'Distrito'),
(949, '08', '06', '06', 'SAN PABLO', 'Distrito'),
(950, '08', '06', '07', 'SAN PEDRO', 'Distrito'),
(951, '08', '06', '08', 'TINTA', 'Distrito'),
(952, '08', '07', '01', 'SANTO TOMAS', 'Distrito'),
(953, '08', '07', '02', 'CAPACMARCA', 'Distrito'),
(954, '08', '07', '03', 'CHAMACA', 'Distrito'),
(955, '08', '07', '04', 'COLQUEMARCA', 'Distrito'),
(956, '08', '07', '05', 'LIVITACA', 'Distrito'),
(957, '08', '07', '06', 'LLUSCO', 'Distrito'),
(958, '08', '07', '07', 'QUIÃ‘OTA', 'Distrito'),
(959, '08', '07', '08', 'VELILLE', 'Distrito'),
(960, '08', '08', '01', 'ESPINAR', 'Distrito'),
(961, '08', '08', '02', 'CONDOROMA', 'Distrito'),
(962, '08', '08', '03', 'COPORAQUE', 'Distrito'),
(963, '08', '08', '04', 'OCORURO', 'Distrito'),
(964, '08', '08', '05', 'PALLPATA', 'Distrito'),
(965, '08', '08', '06', 'PICHIGUA', 'Distrito'),
(966, '08', '08', '07', 'SUYCKUTAMBO 3/', 'Distrito'),
(967, '08', '08', '08', 'ALTO PICHIGUA', 'Distrito'),
(968, '08', '09', '01', 'SANTA ANA', 'Distrito'),
(969, '08', '09', '02', 'ECHARATE', 'Distrito'),
(970, '08', '09', '03', 'HUAYOPATA /1', 'Distrito'),
(971, '08', '09', '04', 'MARANURA', 'Distrito'),
(972, '08', '09', '05', 'OCOBAMBA  /2', 'Distrito'),
(973, '08', '09', '06', 'QUELLOUNO', 'Distrito'),
(974, '08', '09', '07', 'KIMBIRI', 'Distrito'),
(975, '08', '09', '08', 'SANTA TERESA', 'Distrito'),
(976, '08', '09', '09', 'VILCABAMBA', 'Distrito'),
(977, '08', '09', '10', 'PICHARI', 'Distrito'),
(978, '08', '10', '01', 'PARURO', 'Distrito'),
(979, '08', '10', '02', 'ACCHA', 'Distrito'),
(980, '08', '10', '03', 'CCAPI', 'Distrito'),
(981, '08', '10', '04', 'COLCHA', 'Distrito'),
(982, '08', '10', '05', 'HUANOQUITE', 'Distrito'),
(983, '08', '10', '06', 'OMACHA', 'Distrito'),
(984, '08', '10', '07', 'PACCARITAMBO', 'Distrito'),
(985, '08', '10', '08', 'PILLPINTO', 'Distrito'),
(986, '08', '10', '09', 'YAURISQUE', 'Distrito'),
(987, '08', '11', '01', 'PAUCARTAMBO', 'Distrito'),
(988, '08', '11', '02', 'CAICAY', 'Distrito'),
(989, '08', '11', '03', 'CHALLABAMBA', 'Distrito'),
(990, '08', '11', '04', 'COLQUEPATA', 'Distrito'),
(991, '08', '11', '05', 'HUANCARANI', 'Distrito'),
(992, '08', '11', '06', 'KOSÃ‘IPATA', 'Distrito'),
(993, '08', '12', '01', 'URCOS', 'Distrito'),
(994, '08', '12', '02', 'ANDAHUAYLILLAS', 'Distrito'),
(995, '08', '12', '03', 'CAMANTI', 'Distrito'),
(996, '08', '12', '04', 'CCARHUAYO', 'Distrito'),
(997, '08', '12', '05', 'CCATCA', 'Distrito'),
(998, '08', '12', '06', 'CUSIPATA', 'Distrito'),
(999, '08', '12', '07', 'HUARO', 'Distrito'),
(1000, '08', '12', '08', 'LUCRE', 'Distrito'),
(1001, '08', '12', '09', 'MARCAPATA', 'Distrito'),
(1002, '08', '12', '10', 'OCONGATE', 'Distrito'),
(1003, '08', '12', '11', 'OROPESA', 'Distrito'),
(1004, '08', '12', '12', 'QUIQUIJANA', 'Distrito'),
(1005, '08', '13', '01', 'URUBAMBA', 'Distrito'),
(1006, '08', '13', '02', 'CHINCHERO', 'Distrito'),
(1007, '08', '13', '03', 'HUAYLLABAMBA', 'Distrito'),
(1008, '08', '13', '04', 'MACHUPICCHU', 'Distrito'),
(1009, '08', '13', '05', 'MARAS', 'Distrito'),
(1010, '08', '13', '06', 'OLLANTAYTAMBO', 'Distrito'),
(1011, '08', '13', '07', 'YUCAY', 'Distrito'),
(1012, '09', '01', '01', 'HUANCAVELICA', 'Distrito'),
(1013, '09', '01', '02', 'ACOBAMBILLA', 'Distrito'),
(1014, '09', '01', '03', 'ACORIA', 'Distrito'),
(1015, '09', '01', '04', 'CONAYCA', 'Distrito'),
(1016, '09', '01', '05', 'CUENCA', 'Distrito'),
(1017, '09', '01', '06', 'HUACHOCOLPA', 'Distrito'),
(1018, '09', '01', '07', 'HUAYLLAHUARA', 'Distrito'),
(1019, '09', '01', '08', 'IZCUCHACA', 'Distrito'),
(1020, '09', '01', '09', 'LARIA', 'Distrito'),
(1021, '09', '01', '10', 'MANTA', 'Distrito'),
(1022, '09', '01', '11', 'MARISCAL CACERES', 'Distrito'),
(1023, '09', '01', '12', 'MOYA', 'Distrito'),
(1024, '09', '01', '13', 'NUEVO OCCORO', 'Distrito'),
(1025, '09', '01', '14', 'PALCA', 'Distrito'),
(1026, '09', '01', '15', 'PILCHACA', 'Distrito'),
(1027, '09', '01', '16', 'VILCA', 'Distrito'),
(1028, '09', '01', '17', 'YAULI', 'Distrito'),
(1029, '09', '01', '18', 'ASCENSION', 'Distrito'),
(1030, '09', '01', '19', 'HUANDO', 'Distrito'),
(1031, '09', '02', '01', 'ACOBAMBA', 'Distrito'),
(1032, '09', '02', '02', 'ANDABAMBA', 'Distrito'),
(1033, '09', '02', '03', 'ANTA', 'Distrito'),
(1034, '09', '02', '04', 'CAJA', 'Distrito'),
(1035, '09', '02', '05', 'MARCAS', 'Distrito'),
(1036, '09', '02', '06', 'PAUCARA', 'Distrito'),
(1037, '09', '02', '07', 'POMACOCHA', 'Distrito');
INSERT INTO `tb_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(1038, '09', '02', '08', 'ROSARIO', 'Distrito'),
(1039, '09', '03', '01', 'LIRCAY', 'Distrito'),
(1040, '09', '03', '02', 'ANCHONGA', 'Distrito'),
(1041, '09', '03', '03', 'CALLANMARCA', 'Distrito'),
(1042, '09', '03', '04', 'CCOCHACCASA', 'Distrito'),
(1043, '09', '03', '05', 'CHINCHO', 'Distrito'),
(1044, '09', '03', '06', 'CONGALLA', 'Distrito'),
(1045, '09', '03', '07', 'HUANCA-HUANCA', 'Distrito'),
(1046, '09', '03', '08', 'HUAYLLAY GRANDE', 'Distrito'),
(1047, '09', '03', '09', 'JULCAMARCA', 'Distrito'),
(1048, '09', '03', '10', 'SAN ANTONIO DE ANTAPARCO', 'Distrito'),
(1049, '09', '03', '11', 'SANTO TOMAS DE PATA', 'Distrito'),
(1050, '09', '03', '12', 'SECCLLA', 'Distrito'),
(1051, '09', '04', '01', 'CASTROVIRREYNA', 'Distrito'),
(1052, '09', '04', '02', 'ARMA', 'Distrito'),
(1053, '09', '04', '03', 'AURAHUA', 'Distrito'),
(1054, '09', '04', '04', 'CAPILLAS', 'Distrito'),
(1055, '09', '04', '05', 'CHUPAMARCA', 'Distrito'),
(1056, '09', '04', '06', 'COCAS', 'Distrito'),
(1057, '09', '04', '07', 'HUACHOS', 'Distrito'),
(1058, '09', '04', '08', 'HUAMATAMBO', 'Distrito'),
(1059, '09', '04', '09', 'MOLLEPAMPA', 'Distrito'),
(1060, '09', '04', '10', 'SAN JUAN', 'Distrito'),
(1061, '09', '04', '11', 'SANTA ANA', 'Distrito'),
(1062, '09', '04', '12', 'TANTARA', 'Distrito'),
(1063, '09', '04', '13', 'TICRAPO', 'Distrito'),
(1064, '09', '05', '01', 'CHURCAMPA', 'Distrito'),
(1065, '09', '05', '02', 'ANCO', 'Distrito'),
(1066, '09', '05', '03', 'CHINCHIHUASI', 'Distrito'),
(1067, '09', '05', '04', 'EL CARMEN', 'Distrito'),
(1068, '09', '05', '05', 'LA MERCED', 'Distrito'),
(1069, '09', '05', '06', 'LOCROJA', 'Distrito'),
(1070, '09', '05', '07', 'PAUCARBAMBA', 'Distrito'),
(1071, '09', '05', '08', 'SAN MIGUEL DE MAYOCC', 'Distrito'),
(1072, '09', '05', '09', 'SAN PEDRO DE CORIS', 'Distrito'),
(1073, '09', '05', '10', 'PACHAMARCA ', 'Distrito'),
(1074, '09', '06', '01', 'HUAYTARA', 'Distrito'),
(1075, '09', '06', '02', 'AYAVI', 'Distrito'),
(1076, '09', '06', '03', 'CORDOVA', 'Distrito'),
(1077, '09', '06', '04', 'HUAYACUNDO ARMA', 'Distrito'),
(1078, '09', '06', '05', 'LARAMARCA', 'Distrito'),
(1079, '09', '06', '06', 'OCOYO', 'Distrito'),
(1080, '09', '06', '07', 'PILPICHACA', 'Distrito'),
(1081, '09', '06', '08', 'QUERCO', 'Distrito'),
(1082, '09', '06', '09', 'QUITO-ARMA', 'Distrito'),
(1083, '09', '06', '10', 'SAN ANTONIO DE CUSICANCHA', 'Distrito'),
(1084, '09', '06', '11', 'SAN FRANCISCO DE SANGAYAICO', 'Distrito'),
(1085, '09', '06', '12', 'SAN ISIDRO', 'Distrito'),
(1086, '09', '06', '13', 'SANTIAGO DE CHOCORVOS', 'Distrito'),
(1087, '09', '06', '14', 'SANTIAGO DE QUIRAHUARA', 'Distrito'),
(1088, '09', '06', '15', 'SANTO DOMINGO DE CAPILLAS', 'Distrito'),
(1089, '09', '06', '16', 'TAMBO', 'Distrito'),
(1090, '09', '07', '01', 'PAMPAS', 'Distrito'),
(1091, '09', '07', '02', 'ACOSTAMBO', 'Distrito'),
(1092, '09', '07', '03', 'ACRAQUIA', 'Distrito'),
(1093, '09', '07', '04', 'AHUAYCHA', 'Distrito'),
(1094, '09', '07', '05', 'COLCABAMBA', 'Distrito'),
(1095, '09', '07', '06', 'DANIEL HERNANDEZ', 'Distrito'),
(1096, '09', '07', '07', 'HUACHOCOLPA', 'Distrito'),
(1097, '09', '07', '09', 'HUARIBAMBA', 'Distrito'),
(1098, '09', '07', '10', 'Ã‘AHUIMPUQUIO', 'Distrito'),
(1099, '09', '07', '11', 'PAZOS', 'Distrito'),
(1100, '09', '07', '13', 'QUISHUAR', 'Distrito'),
(1101, '09', '07', '14', 'SALCABAMBA', 'Distrito'),
(1102, '09', '07', '15', 'SALCAHUASI', 'Distrito'),
(1103, '09', '07', '16', 'SAN MARCOS DE ROCCHAC', 'Distrito'),
(1104, '09', '07', '17', 'SURCUBAMBA', 'Distrito'),
(1105, '09', '07', '18', 'TINTAY PUNCU', 'Distrito'),
(1106, '10', '01', '01', 'HUANUCO', 'Distrito'),
(1107, '10', '01', '02', 'AMARILIS', 'Distrito'),
(1108, '10', '01', '03', 'CHINCHAO', 'Distrito'),
(1109, '10', '01', '04', 'CHURUBAMBA', 'Distrito'),
(1110, '10', '01', '05', 'MARGOS', 'Distrito'),
(1111, '10', '01', '06', 'QUISQUI', 'Distrito'),
(1112, '10', '01', '07', 'SAN FRANCISCO DE CAYRAN', 'Distrito'),
(1113, '10', '01', '08', 'SAN PEDRO DE CHAULAN', 'Distrito'),
(1114, '10', '01', '09', 'SANTA MARIA DEL VALLE', 'Distrito'),
(1115, '10', '01', '10', 'YARUMAYO', 'Distrito'),
(1116, '10', '01', '11', 'PILLCO MARCA', 'Distrito'),
(1117, '10', '02', '01', 'AMBO', 'Distrito'),
(1118, '10', '02', '02', 'CAYNA', 'Distrito'),
(1119, '10', '02', '03', 'COLPAS', 'Distrito'),
(1120, '10', '02', '04', 'CONCHAMARCA', 'Distrito'),
(1121, '10', '02', '05', 'HUACAR', 'Distrito'),
(1122, '10', '02', '06', 'SAN FRANCISCO', 'Distrito'),
(1123, '10', '02', '07', 'SAN RAFAEL', 'Distrito'),
(1124, '10', '02', '08', 'TOMAY KICHWA', 'Distrito'),
(1125, '10', '03', '01', 'LA UNION', 'Distrito'),
(1126, '10', '03', '07', 'CHUQUIS', 'Distrito'),
(1127, '10', '03', '11', 'MARIAS', 'Distrito'),
(1128, '10', '03', '13', 'PACHAS', 'Distrito'),
(1129, '10', '03', '16', 'QUIVILLA', 'Distrito'),
(1130, '10', '03', '17', 'RIPAN', 'Distrito'),
(1131, '10', '03', '21', 'SHUNQUI', 'Distrito'),
(1132, '10', '03', '22', 'SILLAPATA', 'Distrito'),
(1133, '10', '03', '23', 'YANAS', 'Distrito'),
(1134, '10', '04', '01', 'HUACAYBAMBA', 'Distrito'),
(1135, '10', '04', '02', 'CANCHABAMBA', 'Distrito'),
(1136, '10', '04', '03', 'COCHABAMBA', 'Distrito'),
(1137, '10', '04', '04', 'PINRA', 'Distrito'),
(1138, '10', '05', '01', 'LLATA', 'Distrito'),
(1139, '10', '05', '02', 'ARANCAY', 'Distrito'),
(1140, '10', '05', '03', 'CHAVIN DE PARIARCA', 'Distrito'),
(1141, '10', '05', '04', 'JACAS GRANDE', 'Distrito'),
(1142, '10', '05', '05', 'JIRCAN', 'Distrito'),
(1143, '10', '05', '06', 'MIRAFLORES', 'Distrito'),
(1144, '10', '05', '07', 'MONZON', 'Distrito'),
(1145, '10', '05', '08', 'PUNCHAO', 'Distrito'),
(1146, '10', '05', '09', 'PUÃ‘OS', 'Distrito'),
(1147, '10', '05', '10', 'SINGA', 'Distrito'),
(1148, '10', '05', '11', 'TANTAMAYO', 'Distrito'),
(1149, '10', '06', '01', 'RUPA-RUPA', 'Distrito'),
(1150, '10', '06', '02', 'DANIEL ALOMIA ROBLES', 'Distrito'),
(1151, '10', '06', '03', 'HERMILIO VALDIZAN', 'Distrito'),
(1152, '10', '06', '04', 'JOSE CRESPO Y CASTILLO', 'Distrito'),
(1153, '10', '06', '05', 'LUYANDO 1/', 'Distrito'),
(1154, '10', '06', '06', 'MARIANO DAMASO BERAUN', 'Distrito'),
(1155, '10', '07', '01', 'HUACRACHUCO', 'Distrito'),
(1156, '10', '07', '02', 'CHOLON', 'Distrito'),
(1157, '10', '07', '03', 'SAN BUENAVENTURA', 'Distrito'),
(1158, '10', '08', '01', 'PANAO', 'Distrito'),
(1159, '10', '08', '02', 'CHAGLLA', 'Distrito'),
(1160, '10', '08', '03', 'MOLINO', 'Distrito'),
(1161, '10', '08', '04', 'UMARI  ', 'Distrito'),
(1162, '10', '09', '01', 'PUERTO INCA', 'Distrito'),
(1163, '10', '09', '02', 'CODO DEL POZUZO', 'Distrito'),
(1164, '10', '09', '03', 'HONORIA', 'Distrito'),
(1165, '10', '09', '04', 'TOURNAVISTA', 'Distrito'),
(1166, '10', '09', '05', 'YUYAPICHIS', 'Distrito'),
(1167, '10', '10', '01', 'JESUS', 'Distrito'),
(1168, '10', '10', '02', 'BAÃ‘OS', 'Distrito'),
(1169, '10', '10', '03', 'JIVIA', 'Distrito'),
(1170, '10', '10', '04', 'QUEROPALCA', 'Distrito'),
(1171, '10', '10', '05', 'RONDOS', 'Distrito'),
(1172, '10', '10', '06', 'SAN FRANCISCO DE ASIS', 'Distrito'),
(1173, '10', '10', '07', 'SAN MIGUEL DE CAURI', 'Distrito'),
(1174, '10', '11', '01', 'CHAVINILLO', 'Distrito'),
(1175, '10', '11', '02', 'CAHUAC', 'Distrito'),
(1176, '10', '11', '03', 'CHACABAMBA', 'Distrito'),
(1177, '10', '11', '04', 'APARICIO POMARES', 'Distrito'),
(1178, '10', '11', '05', 'JACAS CHICO', 'Distrito'),
(1179, '10', '11', '06', 'OBAS', 'Distrito'),
(1180, '10', '11', '07', 'PAMPAMARCA', 'Distrito'),
(1181, '10', '11', '08', 'CHORAS', 'Distrito'),
(1182, '11', '01', '01', 'ICA', 'Distrito'),
(1183, '11', '01', '02', 'LA TINGUIÃ‘A', 'Distrito'),
(1184, '11', '01', '03', 'LOS AQUIJES', 'Distrito'),
(1185, '11', '01', '04', 'OCUCAJE', 'Distrito'),
(1186, '11', '01', '05', 'PACHACUTEC', 'Distrito'),
(1187, '11', '01', '06', 'PARCONA', 'Distrito'),
(1188, '11', '01', '07', 'PUEBLO NUEVO', 'Distrito'),
(1189, '11', '01', '08', 'SALAS', 'Distrito'),
(1190, '11', '01', '09', 'SAN JOSE DE LOS MOLINOS', 'Distrito'),
(1191, '11', '01', '10', 'SAN JUAN BAUTISTA', 'Distrito'),
(1192, '11', '01', '11', 'SANTIAGO', 'Distrito'),
(1193, '11', '01', '12', 'SUBTANJALLA', 'Distrito'),
(1194, '11', '01', '13', 'TATE', 'Distrito'),
(1195, '11', '01', '14', 'YAUCA DEL ROSARIO  1/', 'Distrito'),
(1196, '11', '02', '01', 'CHINCHA ALTA', 'Distrito'),
(1197, '11', '02', '02', 'ALTO LARAN', 'Distrito'),
(1198, '11', '02', '03', 'CHAVIN', 'Distrito'),
(1199, '11', '02', '04', 'CHINCHA BAJA', 'Distrito'),
(1200, '11', '02', '05', 'EL CARMEN', 'Distrito'),
(1201, '11', '02', '06', 'GROCIO PRADO', 'Distrito'),
(1202, '11', '02', '07', 'PUEBLO NUEVO', 'Distrito'),
(1203, '11', '02', '08', 'SAN JUAN DE YANAC', 'Distrito'),
(1204, '11', '02', '09', 'SAN PEDRO DE HUACARPANA', 'Distrito'),
(1205, '11', '02', '10', 'SUNAMPE', 'Distrito'),
(1206, '11', '02', '11', 'TAMBO DE MORA', 'Distrito'),
(1207, '11', '03', '01', 'NAZCA', 'Distrito'),
(1208, '11', '03', '02', 'CHANGUILLO', 'Distrito'),
(1209, '11', '03', '03', 'EL INGENIO', 'Distrito'),
(1210, '11', '03', '04', 'MARCONA', 'Distrito'),
(1211, '11', '03', '05', 'VISTA ALEGRE', 'Distrito'),
(1212, '11', '04', '01', 'PALPA', 'Distrito'),
(1213, '11', '04', '02', 'LLIPATA', 'Distrito'),
(1214, '11', '04', '03', 'RIO GRANDE', 'Distrito'),
(1215, '11', '04', '04', 'SANTA CRUZ', 'Distrito'),
(1216, '11', '04', '05', 'TIBILLO', 'Distrito'),
(1217, '11', '05', '01', 'PISCO', 'Distrito'),
(1218, '11', '05', '02', 'HUANCANO', 'Distrito'),
(1219, '11', '05', '03', 'HUMAY', 'Distrito'),
(1220, '11', '05', '04', 'INDEPENDENCIA', 'Distrito'),
(1221, '11', '05', '05', 'PARACAS', 'Distrito'),
(1222, '11', '05', '06', 'SAN ANDRES', 'Distrito'),
(1223, '11', '05', '07', 'SAN CLEMENTE', 'Distrito'),
(1224, '11', '05', '08', 'TUPAC AMARU INCA', 'Distrito'),
(1225, '12', '01', '01', 'HUANCAYO', 'Distrito'),
(1226, '12', '01', '04', 'CARHUACALLANGA', 'Distrito'),
(1227, '12', '01', '05', 'CHACAPAMPA', 'Distrito'),
(1228, '12', '01', '06', 'CHICCHE', 'Distrito'),
(1229, '12', '01', '07', 'CHILCA', 'Distrito'),
(1230, '12', '01', '08', 'CHONGOS ALTO', 'Distrito'),
(1231, '12', '01', '11', 'CHUPURO', 'Distrito'),
(1232, '12', '01', '12', 'COLCA', 'Distrito'),
(1233, '12', '01', '13', 'CULLHUAS', 'Distrito'),
(1234, '12', '01', '14', 'EL TAMBO', 'Distrito'),
(1235, '12', '01', '16', 'HUACRAPUQUIO', 'Distrito'),
(1236, '12', '01', '17', 'HUALHUAS', 'Distrito'),
(1237, '12', '01', '19', 'HUANCAN', 'Distrito'),
(1238, '12', '01', '20', 'HUASICANCHA', 'Distrito'),
(1239, '12', '01', '21', 'HUAYUCACHI', 'Distrito'),
(1240, '12', '01', '22', 'INGENIO', 'Distrito'),
(1241, '12', '01', '24', 'PARIAHUANCA   1/', 'Distrito'),
(1242, '12', '01', '25', 'PILCOMAYO', 'Distrito'),
(1243, '12', '01', '26', 'PUCARA', 'Distrito'),
(1244, '12', '01', '27', 'QUICHUAY', 'Distrito'),
(1245, '12', '01', '28', 'QUILCAS', 'Distrito'),
(1246, '12', '01', '29', 'SAN AGUSTIN', 'Distrito'),
(1247, '12', '01', '30', 'SAN JERONIMO DE TUNAN', 'Distrito'),
(1248, '12', '01', '32', 'SAÃ‘O', 'Distrito'),
(1249, '12', '01', '33', 'SAPALLANGA', 'Distrito'),
(1250, '12', '01', '34', 'SICAYA', 'Distrito'),
(1251, '12', '01', '35', 'SANTO DOMINGO DE ACOBAMBA', 'Distrito'),
(1252, '12', '01', '36', 'VIQUES', 'Distrito'),
(1253, '12', '02', '01', 'CONCEPCION', 'Distrito'),
(1254, '12', '02', '02', 'ACO', 'Distrito'),
(1255, '12', '02', '03', 'ANDAMARCA', 'Distrito'),
(1256, '12', '02', '04', 'CHAMBARA', 'Distrito'),
(1257, '12', '02', '05', 'COCHAS', 'Distrito'),
(1258, '12', '02', '06', 'COMAS', 'Distrito'),
(1259, '12', '02', '07', 'HEROINAS TOLEDO', 'Distrito'),
(1260, '12', '02', '08', 'MANZANARES', 'Distrito'),
(1261, '12', '02', '09', 'MARISCAL CASTILLA', 'Distrito'),
(1262, '12', '02', '10', 'MATAHUASI', 'Distrito'),
(1263, '12', '02', '11', 'MITO', 'Distrito'),
(1264, '12', '02', '12', 'NUEVE DE JULIO', 'Distrito'),
(1265, '12', '02', '13', 'ORCOTUNA', 'Distrito'),
(1266, '12', '02', '14', 'SAN JOSE DE QUERO', 'Distrito'),
(1267, '12', '02', '15', 'SANTA ROSA DE OCOPA', 'Distrito'),
(1268, '12', '03', '01', 'CHANCHAMAYO', 'Distrito'),
(1269, '12', '03', '02', 'PERENE', 'Distrito'),
(1270, '12', '03', '03', 'PICHANAQUI', 'Distrito'),
(1271, '12', '03', '04', 'SAN LUIS DE SHUARO', 'Distrito'),
(1272, '12', '03', '05', 'SAN RAMON', 'Distrito'),
(1273, '12', '03', '06', 'VITOC', 'Distrito'),
(1274, '12', '04', '01', 'JAUJA', 'Distrito'),
(1275, '12', '04', '02', 'ACOLLA', 'Distrito'),
(1276, '12', '04', '03', 'APATA', 'Distrito'),
(1277, '12', '04', '04', 'ATAURA', 'Distrito'),
(1278, '12', '04', '05', 'CANCHAYLLO', 'Distrito'),
(1279, '12', '04', '06', 'CURICACA', 'Distrito'),
(1280, '12', '04', '07', 'EL MANTARO', 'Distrito'),
(1281, '12', '04', '08', 'HUAMALI', 'Distrito'),
(1282, '12', '04', '09', 'HUARIPAMPA', 'Distrito'),
(1283, '12', '04', '10', 'HUERTAS', 'Distrito'),
(1284, '12', '04', '11', 'JANJAILLO', 'Distrito'),
(1285, '12', '04', '12', 'JULCAN', 'Distrito'),
(1286, '12', '04', '13', 'LEONOR ORDOÃ‘EZ', 'Distrito'),
(1287, '12', '04', '14', 'LLOCLLAPAMPA', 'Distrito'),
(1288, '12', '04', '15', 'MARCO', 'Distrito'),
(1289, '12', '04', '16', 'MASMA', 'Distrito'),
(1290, '12', '04', '17', 'MASMA CHICCHE', 'Distrito'),
(1291, '12', '04', '18', 'MOLINOS', 'Distrito'),
(1292, '12', '04', '19', 'MONOBAMBA', 'Distrito'),
(1293, '12', '04', '20', 'MUQUI', 'Distrito'),
(1294, '12', '04', '21', 'MUQUIYAUYO', 'Distrito'),
(1295, '12', '04', '22', 'PACA', 'Distrito'),
(1296, '12', '04', '23', 'PACCHA', 'Distrito'),
(1297, '12', '04', '24', 'PANCAN', 'Distrito'),
(1298, '12', '04', '25', 'PARCO', 'Distrito'),
(1299, '12', '04', '26', 'POMACANCHA', 'Distrito'),
(1300, '12', '04', '27', 'RICRAN', 'Distrito'),
(1301, '12', '04', '28', 'SAN LORENZO', 'Distrito'),
(1302, '12', '04', '29', 'SAN PEDRO DE CHUNAN', 'Distrito'),
(1303, '12', '04', '30', 'SAUSA', 'Distrito'),
(1304, '12', '04', '31', 'SINCOS', 'Distrito'),
(1305, '12', '04', '32', 'TUNAN MARCA', 'Distrito'),
(1306, '12', '04', '33', 'YAULI', 'Distrito'),
(1307, '12', '04', '34', 'YAUYOS', 'Distrito'),
(1308, '12', '05', '01', 'JUNIN', 'Distrito'),
(1309, '12', '05', '02', 'CARHUAMAYO', 'Distrito'),
(1310, '12', '05', '03', 'ONDORES', 'Distrito'),
(1311, '12', '05', '04', 'ULCUMAYO', 'Distrito'),
(1312, '12', '06', '01', 'SATIPO', 'Distrito'),
(1313, '12', '06', '02', 'COVIRIALI', 'Distrito'),
(1314, '12', '06', '03', 'LLAYLLA', 'Distrito'),
(1315, '12', '06', '04', 'MAZAMARI', 'Distrito'),
(1316, '12', '06', '05', 'PAMPA HERMOSA', 'Distrito'),
(1317, '12', '06', '06', 'PANGOA', 'Distrito'),
(1318, '12', '06', '07', 'RIO NEGRO', 'Distrito'),
(1319, '12', '06', '08', 'RIO TAMBO', 'Distrito'),
(1320, '12', '07', '01', 'TARMA', 'Distrito'),
(1321, '12', '07', '02', 'ACOBAMBA', 'Distrito'),
(1322, '12', '07', '03', 'HUARICOLCA', 'Distrito'),
(1323, '12', '07', '04', 'HUASAHUASI', 'Distrito'),
(1324, '12', '07', '05', 'LA UNION', 'Distrito'),
(1325, '12', '07', '06', 'PALCA', 'Distrito'),
(1326, '12', '07', '07', 'PALCAMAYO', 'Distrito'),
(1327, '12', '07', '08', 'SAN PEDRO DE CAJAS', 'Distrito'),
(1328, '12', '07', '09', 'TAPO', 'Distrito'),
(1329, '12', '08', '01', 'LA OROYA', 'Distrito'),
(1330, '12', '08', '02', 'CHACAPALPA', 'Distrito'),
(1331, '12', '08', '03', 'HUAY-HUAY', 'Distrito'),
(1332, '12', '08', '04', 'MARCAPOMACOCHA', 'Distrito'),
(1333, '12', '08', '05', 'MOROCOCHA', 'Distrito'),
(1334, '12', '08', '06', 'PACCHA', 'Distrito'),
(1335, '12', '08', '07', 'SANTA BARBARA DE CARHUACAYAN', 'Distrito'),
(1336, '12', '08', '08', 'SANTA ROSA DE SACCO', 'Distrito'),
(1337, '12', '08', '09', 'SUITUCANCHA', 'Distrito'),
(1338, '12', '08', '10', 'YAULI', 'Distrito'),
(1339, '12', '09', '01', 'CHUPACA', 'Distrito'),
(1340, '12', '09', '02', 'AHUAC', 'Distrito'),
(1341, '12', '09', '03', 'CHONGOS BAJO', 'Distrito'),
(1342, '12', '09', '04', 'HUACHAC', 'Distrito'),
(1343, '12', '09', '05', 'HUAMANCACA CHICO', 'Distrito'),
(1344, '12', '09', '06', 'SAN JUAN DE ISCOS', 'Distrito'),
(1345, '12', '09', '07', 'SAN JUAN DE JARPA', 'Distrito'),
(1346, '12', '09', '08', 'TRES DE DICIEMBRE', 'Distrito'),
(1347, '12', '09', '09', 'YANACANCHA', 'Distrito'),
(1348, '13', '01', '01', 'TRUJILLO', 'Distrito'),
(1349, '13', '01', '02', 'EL PORVENIR', 'Distrito'),
(1350, '13', '01', '03', 'FLORENCIA DE MORA', 'Distrito'),
(1351, '13', '01', '04', 'HUANCHACO', 'Distrito'),
(1352, '13', '01', '05', 'LA ESPERANZA', 'Distrito'),
(1353, '13', '01', '06', 'LAREDO', 'Distrito'),
(1354, '13', '01', '07', 'MOCHE', 'Distrito'),
(1355, '13', '01', '08', 'POROTO', 'Distrito'),
(1356, '13', '01', '09', 'SALAVERRY', 'Distrito'),
(1357, '13', '01', '10', 'SIMBAL', 'Distrito'),
(1358, '13', '01', '11', 'VICTOR LARCO HERRERA', 'Distrito'),
(1359, '13', '02', '01', 'ASCOPE', 'Distrito'),
(1360, '13', '02', '02', 'CHICAMA', 'Distrito'),
(1361, '13', '02', '03', 'CHOCOPE', 'Distrito'),
(1362, '13', '02', '04', 'MAGDALENA DE CAO', 'Distrito'),
(1363, '13', '02', '05', 'PAIJAN', 'Distrito'),
(1364, '13', '02', '06', 'RAZURI', 'Distrito'),
(1365, '13', '02', '07', 'SANTIAGO DE CAO', 'Distrito'),
(1366, '13', '02', '08', 'CASA GRANDE', 'Distrito'),
(1367, '13', '03', '01', 'BOLIVAR', 'Distrito'),
(1368, '13', '03', '02', 'BAMBAMARCA', 'Distrito'),
(1369, '13', '03', '03', 'CONDORMARCA /1', 'Distrito'),
(1370, '13', '03', '04', 'LONGOTEA', 'Distrito'),
(1371, '13', '03', '05', 'UCHUMARCA', 'Distrito'),
(1372, '13', '03', '06', 'UCUNCHA', 'Distrito'),
(1373, '13', '04', '01', 'CHEPEN', 'Distrito'),
(1374, '13', '04', '02', 'PACANGA', 'Distrito'),
(1375, '13', '04', '03', 'PUEBLO NUEVO', 'Distrito'),
(1376, '13', '05', '01', 'JULCAN', 'Distrito'),
(1377, '13', '05', '02', 'CALAMARCA', 'Distrito'),
(1378, '13', '05', '03', 'CARABAMBA', 'Distrito'),
(1379, '13', '05', '04', 'HUASO', 'Distrito'),
(1380, '13', '06', '01', 'OTUZCO', 'Distrito'),
(1381, '13', '06', '02', 'AGALLPAMPA', 'Distrito'),
(1382, '13', '06', '04', 'CHARAT', 'Distrito'),
(1383, '13', '06', '05', 'HUARANCHAL', 'Distrito'),
(1384, '13', '06', '06', 'LA CUESTA', 'Distrito'),
(1385, '13', '06', '08', 'MACHE', 'Distrito'),
(1386, '13', '06', '10', 'PARANDAY', 'Distrito'),
(1387, '13', '06', '11', 'SALPO', 'Distrito'),
(1388, '13', '06', '13', 'SINSICAP', 'Distrito'),
(1389, '13', '06', '14', 'USQUIL', 'Distrito'),
(1390, '13', '07', '01', 'SAN PEDRO DE LLOC', 'Distrito'),
(1391, '13', '07', '02', 'GUADALUPE', 'Distrito'),
(1392, '13', '07', '03', 'JEQUETEPEQUE', 'Distrito'),
(1393, '13', '07', '04', 'PACASMAYO', 'Distrito'),
(1394, '13', '07', '05', 'SAN JOSE', 'Distrito'),
(1395, '13', '08', '01', 'TAYABAMBA', 'Distrito'),
(1396, '13', '08', '02', 'BULDIBUYO', 'Distrito'),
(1397, '13', '08', '03', 'CHILLIA', 'Distrito'),
(1398, '13', '08', '04', 'HUANCASPATA', 'Distrito'),
(1399, '13', '08', '05', 'HUAYLILLAS', 'Distrito'),
(1400, '13', '08', '06', 'HUAYO', 'Distrito'),
(1401, '13', '08', '07', 'ONGON', 'Distrito'),
(1402, '13', '08', '08', 'PARCOY', 'Distrito'),
(1403, '13', '08', '09', 'PATAZ', 'Distrito'),
(1404, '13', '08', '10', 'PIAS', 'Distrito'),
(1405, '13', '08', '11', 'SANTIAGO DE CHALLAS', 'Distrito'),
(1406, '13', '08', '12', 'TAURIJA', 'Distrito'),
(1407, '13', '08', '13', 'URPAY', 'Distrito'),
(1408, '13', '09', '01', 'HUAMACHUCO', 'Distrito'),
(1409, '13', '09', '02', 'CHUGAY', 'Distrito'),
(1410, '13', '09', '03', 'COCHORCO', 'Distrito'),
(1411, '13', '09', '04', 'CURGOS', 'Distrito'),
(1412, '13', '09', '05', 'MARCABAL', 'Distrito'),
(1413, '13', '09', '06', 'SANAGORAN', 'Distrito'),
(1414, '13', '09', '07', 'SARIN', 'Distrito'),
(1415, '13', '09', '08', 'SARTIMBAMBA', 'Distrito'),
(1416, '13', '10', '01', 'SANTIAGO DE CHUCO', 'Distrito'),
(1417, '13', '10', '02', 'ANGASMARCA', 'Distrito'),
(1418, '13', '10', '03', 'CACHICADAN', 'Distrito'),
(1419, '13', '10', '04', 'MOLLEBAMBA', 'Distrito'),
(1420, '13', '10', '05', 'MOLLEPATA', 'Distrito'),
(1421, '13', '10', '06', 'QUIRUVILCA', 'Distrito'),
(1422, '13', '10', '07', 'SANTA CRUZ DE CHUCA', 'Distrito'),
(1423, '13', '10', '08', 'SITABAMBA', 'Distrito'),
(1424, '13', '11', '01', 'CASCAS', 'Distrito'),
(1425, '13', '11', '02', 'LUCMA', 'Distrito'),
(1426, '13', '11', '03', 'COMPIN', 'Distrito'),
(1427, '13', '11', '04', 'SAYAPULLO', 'Distrito'),
(1428, '13', '12', '01', 'VIRU', 'Distrito'),
(1429, '13', '12', '02', 'CHAO', 'Distrito'),
(1430, '13', '12', '03', 'GUADALUPITO', 'Distrito'),
(1431, '14', '01', '01', 'CHICLAYO', 'Distrito'),
(1432, '14', '01', '02', 'CHONGOYAPE', 'Distrito'),
(1433, '14', '01', '03', 'ETEN', 'Distrito'),
(1434, '14', '01', '04', 'ETEN PUERTO', 'Distrito'),
(1435, '14', '01', '05', 'JOSE LEONARDO ORTIZ', 'Distrito'),
(1436, '14', '01', '06', 'LA VICTORIA', 'Distrito'),
(1437, '14', '01', '07', 'LAGUNAS   ', 'Distrito'),
(1438, '14', '01', '08', 'MONSEFU', 'Distrito'),
(1439, '14', '01', '09', 'NUEVA ARICA', 'Distrito'),
(1440, '14', '01', '10', 'OYOTUN', 'Distrito'),
(1441, '14', '01', '11', 'PICSI', 'Distrito'),
(1442, '14', '01', '12', 'PIMENTEL', 'Distrito'),
(1443, '14', '01', '13', 'REQUE', 'Distrito'),
(1444, '14', '01', '14', 'SANTA ROSA', 'Distrito'),
(1445, '14', '01', '15', 'SAÃ‘A', 'Distrito'),
(1446, '14', '01', '16', 'CAYALTI', 'Distrito'),
(1447, '14', '01', '17', 'PATAPO', 'Distrito'),
(1448, '14', '01', '18', 'POMALCA', 'Distrito'),
(1449, '14', '01', '19', 'PUCALA', 'Distrito'),
(1450, '14', '01', '20', 'TUMAN', 'Distrito'),
(1451, '14', '02', '01', 'FERREÃ‘AFE', 'Distrito'),
(1452, '14', '02', '02', 'CAÃ‘ARIS', 'Distrito'),
(1453, '14', '02', '03', 'INCAHUASI', 'Distrito'),
(1454, '14', '02', '04', 'MANUEL ANTONIO MESONES MURO', 'Distrito'),
(1455, '14', '02', '05', 'PITIPO', 'Distrito'),
(1456, '14', '02', '06', 'PUEBLO NUEVO', 'Distrito'),
(1457, '14', '03', '01', 'LAMBAYEQUE', 'Distrito'),
(1458, '14', '03', '02', 'CHOCHOPE', 'Distrito'),
(1459, '14', '03', '03', 'ILLIMO', 'Distrito'),
(1460, '14', '03', '04', 'JAYANCA', 'Distrito'),
(1461, '14', '03', '05', 'MOCHUMI', 'Distrito'),
(1462, '14', '03', '06', 'MORROPE', 'Distrito'),
(1463, '14', '03', '07', 'MOTUPE', 'Distrito'),
(1464, '14', '03', '08', 'OLMOS', 'Distrito'),
(1465, '14', '03', '09', 'PACORA', 'Distrito'),
(1466, '14', '03', '10', 'SALAS', 'Distrito'),
(1467, '14', '03', '11', 'SAN JOSE', 'Distrito'),
(1468, '14', '03', '12', 'TUCUME', 'Distrito'),
(1469, '15', '01', '01', 'LIMA', 'Distrito'),
(1470, '15', '01', '02', 'ANCON', 'Distrito'),
(1471, '15', '01', '03', 'ATE', 'Distrito'),
(1472, '15', '01', '04', 'BARRANCO', 'Distrito'),
(1473, '15', '01', '05', 'BREÃ‘A', 'Distrito'),
(1474, '15', '01', '06', 'CARABAYLLO', 'Distrito'),
(1475, '15', '01', '07', 'CHACLACAYO', 'Distrito'),
(1476, '15', '01', '08', 'CHORRILLOS', 'Distrito'),
(1477, '15', '01', '09', 'CIENEGUILLA', 'Distrito'),
(1478, '15', '01', '10', 'COMAS', 'Distrito'),
(1479, '15', '01', '11', 'EL AGUSTINO', 'Distrito'),
(1480, '15', '01', '12', 'INDEPENDENCIA', 'Distrito'),
(1481, '15', '01', '13', 'JESUS MARIA', 'Distrito'),
(1482, '15', '01', '14', 'LA MOLINA', 'Distrito'),
(1483, '15', '01', '15', 'LA VICTORIA', 'Distrito'),
(1484, '15', '01', '16', 'LINCE', 'Distrito'),
(1485, '15', '01', '17', 'LOS OLIVOS', 'Distrito'),
(1486, '15', '01', '18', 'LURIGANCHO', 'Distrito'),
(1487, '15', '01', '19', 'LURIN', 'Distrito'),
(1488, '15', '01', '20', 'MAGDALENA DEL MAR', 'Distrito'),
(1489, '15', '01', '21', 'PUEBLO LIBRE', 'Distrito'),
(1490, '15', '01', '22', 'MIRAFLORES', 'Distrito'),
(1491, '15', '01', '23', 'PACHACAMAC', 'Distrito'),
(1492, '15', '01', '24', 'PUCUSANA', 'Distrito'),
(1493, '15', '01', '25', 'PUENTE PIEDRA', 'Distrito'),
(1494, '15', '01', '26', 'PUNTA HERMOSA', 'Distrito'),
(1495, '15', '01', '27', 'PUNTA NEGRA', 'Distrito'),
(1496, '15', '01', '28', 'RIMAC', 'Distrito'),
(1497, '15', '01', '29', 'SAN BARTOLO', 'Distrito'),
(1498, '15', '01', '30', 'SAN BORJA', 'Distrito'),
(1499, '15', '01', '31', 'SAN ISIDRO', 'Distrito'),
(1500, '15', '01', '32', 'SAN JUAN DE LURIGANCHO', 'Distrito'),
(1501, '15', '01', '33', 'SAN JUAN DE MIRAFLORES', 'Distrito'),
(1502, '15', '01', '34', 'SAN LUIS', 'Distrito'),
(1503, '15', '01', '35', 'SAN MARTIN DE PORRES', 'Distrito'),
(1504, '15', '01', '36', 'SAN MIGUEL', 'Distrito'),
(1505, '15', '01', '37', 'SANTA ANITA', 'Distrito'),
(1506, '15', '01', '38', 'SANTA MARIA DEL MAR', 'Distrito'),
(1507, '15', '01', '39', 'SANTA ROSA', 'Distrito'),
(1508, '15', '01', '40', 'SANTIAGO DE SURCO', 'Distrito'),
(1509, '15', '01', '41', 'SURQUILLO', 'Distrito'),
(1510, '15', '01', '42', 'VILLA EL SALVADOR', 'Distrito'),
(1511, '15', '01', '43', 'VILLA MARIA DEL TRIUNFO', 'Distrito'),
(1512, '15', '02', '01', 'BARRANCA', 'Distrito'),
(1513, '15', '02', '02', 'PARAMONGA', 'Distrito'),
(1514, '15', '02', '03', 'PATIVILCA', 'Distrito'),
(1515, '15', '02', '04', 'SUPE', 'Distrito'),
(1516, '15', '02', '05', 'SUPE PUERTO', 'Distrito'),
(1517, '15', '03', '01', 'CAJATAMBO', 'Distrito'),
(1518, '15', '03', '02', 'COPA', 'Distrito'),
(1519, '15', '03', '03', 'GORGOR', 'Distrito'),
(1520, '15', '03', '04', 'HUANCAPON', 'Distrito'),
(1521, '15', '03', '05', 'MANAS', 'Distrito'),
(1522, '15', '04', '01', 'CANTA', 'Distrito'),
(1523, '15', '04', '02', 'ARAHUAY', 'Distrito'),
(1524, '15', '04', '03', 'HUAMANTANGA', 'Distrito'),
(1525, '15', '04', '04', 'HUAROS', 'Distrito'),
(1526, '15', '04', '05', 'LACHAQUI', 'Distrito'),
(1527, '15', '04', '06', 'SAN BUENAVENTURA', 'Distrito'),
(1528, '15', '04', '07', 'SANTA ROSA DE QUIVES', 'Distrito'),
(1529, '15', '05', '01', 'SAN VICENTE DE CAÃ‘ETE', 'Distrito'),
(1530, '15', '05', '02', 'ASIA', 'Distrito'),
(1531, '15', '05', '03', 'CALANGO', 'Distrito'),
(1532, '15', '05', '04', 'CERRO AZUL', 'Distrito'),
(1533, '15', '05', '05', 'CHILCA', 'Distrito'),
(1534, '15', '05', '06', 'COAYLLO', 'Distrito'),
(1535, '15', '05', '07', 'IMPERIAL', 'Distrito'),
(1536, '15', '05', '08', 'LUNAHUANA', 'Distrito'),
(1537, '15', '05', '09', 'MALA', 'Distrito'),
(1538, '15', '05', '10', 'NUEVO IMPERIAL', 'Distrito'),
(1539, '15', '05', '11', 'PACARAN', 'Distrito'),
(1540, '15', '05', '12', 'QUILMANA', 'Distrito'),
(1541, '15', '05', '13', 'SAN ANTONIO', 'Distrito'),
(1542, '15', '05', '14', 'SAN LUIS', 'Distrito'),
(1543, '15', '05', '15', 'SANTA CRUZ DE FLORES', 'Distrito'),
(1544, '15', '05', '16', 'ZUÃ‘IGA', 'Distrito'),
(1545, '15', '06', '01', 'HUARAL', 'Distrito'),
(1546, '15', '06', '02', 'ATAVILLOS ALTO', 'Distrito'),
(1547, '15', '06', '03', 'ATAVILLOS BAJO', 'Distrito'),
(1548, '15', '06', '04', 'AUCALLAMA', 'Distrito'),
(1549, '15', '06', '05', 'CHANCAY', 'Distrito'),
(1550, '15', '06', '06', 'IHUARI', 'Distrito'),
(1551, '15', '06', '07', 'LAMPIAN', 'Distrito'),
(1552, '15', '06', '08', 'PACARAOS', 'Distrito'),
(1553, '15', '06', '09', 'SAN MIGUEL DE ACOS', 'Distrito'),
(1554, '15', '06', '10', 'SANTA CRUZ DE ANDAMARCA', 'Distrito'),
(1555, '15', '06', '11', 'SUMBILCA', 'Distrito'),
(1556, '15', '06', '12', 'VEINTISIETE DE NOVIEMBRE', 'Distrito'),
(1557, '15', '07', '01', 'MATUCANA', 'Distrito'),
(1558, '15', '07', '02', 'ANTIOQUIA', 'Distrito'),
(1559, '15', '07', '03', 'CALLAHUANCA', 'Distrito'),
(1560, '15', '07', '04', 'CARAMPOMA', 'Distrito'),
(1561, '15', '07', '05', 'CHICLA', 'Distrito'),
(1562, '15', '07', '06', 'CUENCA', 'Distrito'),
(1563, '15', '07', '07', 'HUACHUPAMPA', 'Distrito'),
(1564, '15', '07', '08', 'HUANZA', 'Distrito'),
(1565, '15', '07', '09', 'HUAROCHIRI', 'Distrito'),
(1566, '15', '07', '10', 'LAHUAYTAMBO', 'Distrito'),
(1567, '15', '07', '11', 'LANGA', 'Distrito'),
(1568, '15', '07', '12', 'LARAOS', 'Distrito'),
(1569, '15', '07', '13', 'MARIATANA', 'Distrito'),
(1570, '15', '07', '14', 'RICARDO PALMA', 'Distrito'),
(1571, '15', '07', '15', 'SAN ANDRES DE TUPICOCHA', 'Distrito'),
(1572, '15', '07', '16', 'SAN ANTONIO', 'Distrito'),
(1573, '15', '07', '17', 'SAN BARTOLOME', 'Distrito'),
(1574, '15', '07', '18', 'SAN DAMIAN', 'Distrito'),
(1575, '15', '07', '19', 'SAN JUAN DE IRIS', 'Distrito'),
(1576, '15', '07', '20', 'SAN JUAN DE TANTARANCHE', 'Distrito'),
(1577, '15', '07', '21', 'SAN LORENZO DE QUINTI', 'Distrito'),
(1578, '15', '07', '22', 'SAN MATEO', 'Distrito'),
(1579, '15', '07', '23', 'SAN MATEO DE OTAO', 'Distrito'),
(1580, '15', '07', '24', 'SAN PEDRO DE CASTA', 'Distrito'),
(1581, '15', '07', '25', 'SAN PEDRO DE HUANCAYRE', 'Distrito'),
(1582, '15', '07', '26', 'SANGALLAYA', 'Distrito'),
(1583, '15', '07', '27', 'SANTA CRUZ DE COCACHACRA', 'Distrito'),
(1584, '15', '07', '28', 'SANTA EULALIA', 'Distrito'),
(1585, '15', '07', '29', 'SANTIAGO DE ANCHUCAYA', 'Distrito'),
(1586, '15', '07', '30', 'SANTIAGO DE TUNA', 'Distrito'),
(1587, '15', '07', '31', 'SANTO DOMINGO DE LOS OLLEROS', 'Distrito'),
(1588, '15', '07', '32', 'SURCO', 'Distrito'),
(1589, '15', '08', '01', 'HUACHO', 'Distrito'),
(1590, '15', '08', '02', 'AMBAR', 'Distrito'),
(1591, '15', '08', '03', 'CALETA DE CARQUIN', 'Distrito'),
(1592, '15', '08', '04', 'CHECRAS', 'Distrito'),
(1593, '15', '08', '05', 'HUALMAY', 'Distrito'),
(1594, '15', '08', '06', 'HUAURA', 'Distrito'),
(1595, '15', '08', '07', 'LEONCIO PRADO', 'Distrito'),
(1596, '15', '08', '08', 'PACCHO', 'Distrito'),
(1597, '15', '08', '09', 'SANTA LEONOR', 'Distrito'),
(1598, '15', '08', '10', 'SANTA MARIA', 'Distrito'),
(1599, '15', '08', '11', 'SAYAN', 'Distrito'),
(1600, '15', '08', '12', 'VEGUETA', 'Distrito'),
(1601, '15', '09', '01', 'OYON', 'Distrito'),
(1602, '15', '09', '02', 'ANDAJES', 'Distrito'),
(1603, '15', '09', '03', 'CAUJUL', 'Distrito'),
(1604, '15', '09', '04', 'COCHAMARCA', 'Distrito'),
(1605, '15', '09', '05', 'NAVAN', 'Distrito'),
(1606, '15', '09', '06', 'PACHANGARA', 'Distrito'),
(1607, '15', '10', '01', 'YAUYOS', 'Distrito'),
(1608, '15', '10', '02', 'ALIS', 'Distrito'),
(1609, '15', '10', '03', 'ALLAUCA', 'Distrito'),
(1610, '15', '10', '04', 'AYAVIRI', 'Distrito'),
(1611, '15', '10', '05', 'AZANGARO', 'Distrito'),
(1612, '15', '10', '06', 'CACRA', 'Distrito'),
(1613, '15', '10', '07', 'CARANIA', 'Distrito'),
(1614, '15', '10', '08', 'CATAHUASI', 'Distrito'),
(1615, '15', '10', '09', 'CHOCOS', 'Distrito'),
(1616, '15', '10', '10', 'COCHAS', 'Distrito'),
(1617, '15', '10', '11', 'COLONIA', 'Distrito'),
(1618, '15', '10', '12', 'HONGOS', 'Distrito'),
(1619, '15', '10', '13', 'HUAMPARA', 'Distrito'),
(1620, '15', '10', '14', 'HUANCAYA', 'Distrito'),
(1621, '15', '10', '15', 'HUANGASCAR', 'Distrito'),
(1622, '15', '10', '16', 'HUANTAN', 'Distrito'),
(1623, '15', '10', '17', 'HUAÃ‘EC', 'Distrito'),
(1624, '15', '10', '18', 'LARAOS', 'Distrito'),
(1625, '15', '10', '19', 'LINCHA', 'Distrito'),
(1626, '15', '10', '20', 'MADEAN', 'Distrito'),
(1627, '15', '10', '21', 'MIRAFLORES', 'Distrito'),
(1628, '15', '10', '22', 'OMAS', 'Distrito'),
(1629, '15', '10', '23', 'PUTINZA', 'Distrito'),
(1630, '15', '10', '24', 'QUINCHES', 'Distrito'),
(1631, '15', '10', '25', 'QUINOCAY', 'Distrito'),
(1632, '15', '10', '26', 'SAN JOAQUIN', 'Distrito'),
(1633, '15', '10', '27', 'SAN PEDRO DE PILAS', 'Distrito'),
(1634, '15', '10', '28', 'TANTA', 'Distrito'),
(1635, '15', '10', '29', 'TAURIPAMPA', 'Distrito'),
(1636, '15', '10', '30', 'TOMAS', 'Distrito'),
(1637, '15', '10', '31', 'TUPE', 'Distrito'),
(1638, '15', '10', '32', 'VIÃ‘AC', 'Distrito'),
(1639, '15', '10', '33', 'VITIS', 'Distrito'),
(1640, '16', '01', '01', 'IQUITOS', 'Distrito'),
(1641, '16', '01', '02', 'ALTO NANAY', 'Distrito'),
(1642, '16', '01', '03', 'FERNANDO LORES', 'Distrito'),
(1643, '16', '01', '04', 'INDIANA', 'Distrito'),
(1644, '16', '01', '05', 'LAS AMAZONAS', 'Distrito'),
(1645, '16', '01', '06', 'MAZAN', 'Distrito'),
(1646, '16', '01', '07', 'NAPO', 'Distrito'),
(1647, '16', '01', '08', 'PUNCHANA', 'Distrito'),
(1648, '16', '01', '09', 'PUTUMAYO    ', 'Distrito'),
(1649, '16', '01', '10', 'TORRES CAUSANA', 'Distrito'),
(1650, '16', '01', '12', 'BELEN', 'Distrito'),
(1651, '16', '01', '13', 'SAN JUAN BAUTISTA', 'Distrito'),
(1652, '16', '01', '14', 'TENIENTE MANUEL CLAVERO', 'Distrito'),
(1653, '16', '02', '01', 'YURIMAGUAS', 'Distrito'),
(1654, '16', '02', '02', 'BALSAPUERTO', 'Distrito'),
(1655, '16', '02', '05', 'JEBEROS', 'Distrito'),
(1656, '16', '02', '06', 'LAGUNAS', 'Distrito'),
(1657, '16', '02', '10', 'SANTA CRUZ', 'Distrito'),
(1658, '16', '02', '11', 'TENIENTE CESAR LOPEZ ROJAS', 'Distrito'),
(1659, '16', '03', '01', 'NAUTA', 'Distrito'),
(1660, '16', '03', '02', 'PARINARI ', 'Distrito'),
(1661, '16', '03', '03', 'TIGRE', 'Distrito'),
(1662, '16', '03', '04', 'TROMPETEROS', 'Distrito'),
(1663, '16', '03', '05', 'URARINAS', 'Distrito'),
(1664, '16', '04', '01', 'RAMON CASTILLA', 'Distrito'),
(1665, '16', '04', '02', 'PEBAS', 'Distrito'),
(1666, '16', '04', '03', 'YAVARI  /1', 'Distrito'),
(1667, '16', '04', '04', 'SAN PABLO', 'Distrito'),
(1668, '16', '05', '01', 'REQUENA', 'Distrito'),
(1669, '16', '05', '02', 'ALTO TAPICHE', 'Distrito'),
(1670, '16', '05', '03', 'CAPELO', 'Distrito'),
(1671, '16', '05', '04', 'EMILIO SAN MARTIN', 'Distrito'),
(1672, '16', '05', '05', 'MAQUIA', 'Distrito'),
(1673, '16', '05', '06', 'PUINAHUA', 'Distrito'),
(1674, '16', '05', '07', 'SAQUENA', 'Distrito'),
(1675, '16', '05', '08', 'SOPLIN', 'Distrito'),
(1676, '16', '05', '09', 'TAPICHE', 'Distrito'),
(1677, '16', '05', '10', 'JENARO HERRERA', 'Distrito'),
(1678, '16', '05', '11', 'YAQUERANA    ', 'Distrito'),
(1679, '16', '06', '01', 'CONTAMANA', 'Distrito'),
(1680, '16', '06', '02', 'INAHUAYA', 'Distrito'),
(1681, '16', '06', '03', 'PADRE MARQUEZ', 'Distrito'),
(1682, '16', '06', '04', 'PAMPA HERMOSA', 'Distrito'),
(1683, '16', '06', '05', 'SARAYACU', 'Distrito'),
(1684, '16', '06', '06', 'VARGAS GUERRA', 'Distrito'),
(1685, '16', '07', '01', 'BARRANCA', 'Distrito'),
(1686, '16', '07', '02', 'CAHUAPANAS', 'Distrito'),
(1687, '16', '07', '03', 'MANSERICHE', 'Distrito'),
(1688, '16', '07', '04', 'MORONA', 'Distrito'),
(1689, '16', '07', '05', 'PASTAZA', 'Distrito'),
(1690, '16', '07', '06', 'ANDOAS', 'Distrito'),
(1691, '17', '01', '01', 'TAMBOPATA', 'Distrito'),
(1692, '17', '01', '02', 'INAMBARI ', 'Distrito'),
(1693, '17', '01', '03', 'LAS PIEDRAS', 'Distrito'),
(1694, '17', '01', '04', 'LABERINTO', 'Distrito'),
(1695, '17', '02', '01', 'MANU    ', 'Distrito'),
(1696, '17', '02', '02', 'FITZCARRALD    ', 'Distrito'),
(1697, '17', '02', '03', 'MADRE DE DIOS    ', 'Distrito'),
(1698, '17', '02', '04', 'HUEPETUHE', 'Distrito'),
(1699, '17', '03', '01', 'IÃ‘APARI', 'Distrito'),
(1700, '17', '03', '02', 'IBERIA', 'Distrito'),
(1701, '17', '03', '03', 'TAHUAMANU', 'Distrito'),
(1702, '18', '01', '01', 'MOQUEGUA', 'Distrito'),
(1703, '18', '01', '02', 'CARUMAS', 'Distrito'),
(1704, '18', '01', '03', 'CUCHUMBAYA', 'Distrito'),
(1705, '18', '01', '04', 'SAMEGUA', 'Distrito'),
(1706, '18', '01', '05', 'SAN CRISTOBAL', 'Distrito'),
(1707, '18', '01', '06', 'TORATA', 'Distrito'),
(1708, '18', '02', '01', 'OMATE', 'Distrito'),
(1709, '18', '02', '02', 'CHOJATA', 'Distrito'),
(1710, '18', '02', '03', 'COALAQUE', 'Distrito'),
(1711, '18', '02', '04', 'ICHUÃ‘A', 'Distrito'),
(1712, '18', '02', '05', 'LA CAPILLA', 'Distrito'),
(1713, '18', '02', '06', 'LLOQUE', 'Distrito'),
(1714, '18', '02', '07', 'MATALAQUE', 'Distrito'),
(1715, '18', '02', '08', 'PUQUINA', 'Distrito'),
(1716, '18', '02', '09', 'QUINISTAQUILLAS', 'Distrito'),
(1717, '18', '02', '10', 'UBINAS', 'Distrito'),
(1718, '18', '02', '11', 'YUNGA', 'Distrito'),
(1719, '18', '03', '01', 'ILO', 'Distrito'),
(1720, '18', '03', '02', 'EL ALGARROBAL', 'Distrito'),
(1721, '18', '03', '03', 'PACOCHA', 'Distrito'),
(1722, '19', '01', '01', 'CHAUPIMARCA', 'Distrito'),
(1723, '19', '01', '02', 'HUACHON', 'Distrito'),
(1724, '19', '01', '03', 'HUARIACA', 'Distrito'),
(1725, '19', '01', '04', 'HUAYLLAY', 'Distrito'),
(1726, '19', '01', '05', 'NINACACA', 'Distrito'),
(1727, '19', '01', '06', 'PALLANCHACRA', 'Distrito'),
(1728, '19', '01', '07', 'PAUCARTAMBO', 'Distrito'),
(1729, '19', '01', '08', 'SAN FRANCISCO DE ASIS DE YARUSYACAN', 'Distrito'),
(1730, '19', '01', '09', 'SIMON BOLIVAR', 'Distrito'),
(1731, '19', '01', '10', 'TICLACAYAN', 'Distrito'),
(1732, '19', '01', '11', 'TINYAHUARCO', 'Distrito'),
(1733, '19', '01', '12', 'VICCO', 'Distrito'),
(1734, '19', '01', '13', 'YANACANCHA', 'Distrito'),
(1735, '19', '02', '01', 'YANAHUANCA', 'Distrito'),
(1736, '19', '02', '02', 'CHACAYAN', 'Distrito'),
(1737, '19', '02', '03', 'GOYLLARISQUIZGA', 'Distrito'),
(1738, '19', '02', '04', 'PAUCAR', 'Distrito'),
(1739, '19', '02', '05', 'SAN PEDRO DE PILLAO', 'Distrito'),
(1740, '19', '02', '06', 'SANTA ANA DE TUSI', 'Distrito'),
(1741, '19', '02', '07', 'TAPUC', 'Distrito'),
(1742, '19', '02', '08', 'VILCABAMBA', 'Distrito'),
(1743, '19', '03', '01', 'OXAPAMPA', 'Distrito'),
(1744, '19', '03', '02', 'CHONTABAMBA', 'Distrito'),
(1745, '19', '03', '03', 'HUANCABAMBA', 'Distrito'),
(1746, '19', '03', '04', 'PALCAZU', 'Distrito'),
(1747, '19', '03', '05', 'POZUZO', 'Distrito'),
(1748, '19', '03', '06', 'PUERTO BERMUDEZ', 'Distrito'),
(1749, '19', '03', '07', 'VILLA RICA', 'Distrito'),
(1750, '20', '01', '01', 'PIURA', 'Distrito'),
(1751, '20', '01', '04', 'CASTILLA', 'Distrito'),
(1752, '20', '01', '05', 'CATACAOS', 'Distrito'),
(1753, '20', '01', '07', 'CURA MORI', 'Distrito'),
(1754, '20', '01', '08', 'EL TALLAN', 'Distrito'),
(1755, '20', '01', '09', 'LA ARENA', 'Distrito'),
(1756, '20', '01', '10', 'LA UNION', 'Distrito'),
(1757, '20', '01', '11', 'LAS LOMAS', 'Distrito'),
(1758, '20', '01', '14', 'TAMBO GRANDE', 'Distrito'),
(1759, '20', '02', '01', 'AYABACA', 'Distrito'),
(1760, '20', '02', '02', 'FRIAS', 'Distrito'),
(1761, '20', '02', '03', 'JILILI', 'Distrito'),
(1762, '20', '02', '04', 'LAGUNAS', 'Distrito'),
(1763, '20', '02', '05', 'MONTERO', 'Distrito'),
(1764, '20', '02', '06', 'PACAIPAMPA', 'Distrito'),
(1765, '20', '02', '07', 'PAIMAS', 'Distrito'),
(1766, '20', '02', '08', 'SAPILLICA', 'Distrito'),
(1767, '20', '02', '09', 'SICCHEZ', 'Distrito'),
(1768, '20', '02', '10', 'SUYO', 'Distrito'),
(1769, '20', '03', '01', 'HUANCABAMBA', 'Distrito'),
(1770, '20', '03', '02', 'CANCHAQUE', 'Distrito'),
(1771, '20', '03', '03', 'EL CARMEN DE LA FRONTERA', 'Distrito'),
(1772, '20', '03', '04', 'HUARMACA', 'Distrito'),
(1773, '20', '03', '05', 'LALAQUIZ', 'Distrito'),
(1774, '20', '03', '06', 'SAN MIGUEL DE EL FAIQUE', 'Distrito'),
(1775, '20', '03', '07', 'SONDOR', 'Distrito'),
(1776, '20', '03', '08', 'SONDORILLO', 'Distrito'),
(1777, '20', '04', '01', 'CHULUCANAS', 'Distrito'),
(1778, '20', '04', '02', 'BUENOS AIRES', 'Distrito'),
(1779, '20', '04', '03', 'CHALACO', 'Distrito'),
(1780, '20', '04', '04', 'LA MATANZA', 'Distrito'),
(1781, '20', '04', '05', 'MORROPON', 'Distrito'),
(1782, '20', '04', '06', 'SALITRAL', 'Distrito'),
(1783, '20', '04', '07', 'SAN JUAN DE BIGOTE', 'Distrito'),
(1784, '20', '04', '08', 'SANTA CATALINA DE MOSSA', 'Distrito'),
(1785, '20', '04', '09', 'SANTO DOMINGO', 'Distrito'),
(1786, '20', '04', '10', 'YAMANGO', 'Distrito'),
(1787, '20', '05', '01', 'PAITA', 'Distrito'),
(1788, '20', '05', '02', 'AMOTAPE', 'Distrito'),
(1789, '20', '05', '03', 'ARENAL', 'Distrito'),
(1790, '20', '05', '04', 'COLAN', 'Distrito'),
(1791, '20', '05', '05', 'LA HUACA', 'Distrito'),
(1792, '20', '05', '06', 'TAMARINDO', 'Distrito'),
(1793, '20', '05', '07', 'VICHAYAL', 'Distrito'),
(1794, '20', '06', '01', 'SULLANA', 'Distrito'),
(1795, '20', '06', '02', 'BELLAVISTA', 'Distrito'),
(1796, '20', '06', '03', 'IGNACIO ESCUDERO', 'Distrito'),
(1797, '20', '06', '04', 'LANCONES', 'Distrito'),
(1798, '20', '06', '05', 'MARCAVELICA', 'Distrito'),
(1799, '20', '06', '06', 'MIGUEL CHECA', 'Distrito'),
(1800, '20', '06', '07', 'QUERECOTILLO', 'Distrito'),
(1801, '20', '06', '08', 'SALITRAL', 'Distrito'),
(1802, '20', '07', '01', 'PARIÃ‘AS', 'Distrito'),
(1803, '20', '07', '02', 'EL ALTO', 'Distrito'),
(1804, '20', '07', '03', 'LA BREA', 'Distrito'),
(1805, '20', '07', '04', 'LOBITOS', 'Distrito'),
(1806, '20', '07', '05', 'LOS ORGANOS', 'Distrito'),
(1807, '20', '07', '06', 'MANCORA', 'Distrito'),
(1808, '20', '08', '01', 'SECHURA', 'Distrito'),
(1809, '20', '08', '02', 'BELLAVISTA DE LA UNION', 'Distrito'),
(1810, '20', '08', '03', 'BERNAL', 'Distrito'),
(1811, '20', '08', '04', 'CRISTO NOS VALGA', 'Distrito'),
(1812, '20', '08', '05', 'VICE', 'Distrito'),
(1813, '20', '08', '06', 'RINCONADA LLICUAR', 'Distrito'),
(1814, '21', '01', '01', 'PUNO', 'Distrito'),
(1815, '21', '01', '02', 'ACORA', 'Distrito'),
(1816, '21', '01', '03', 'AMANTANI', 'Distrito'),
(1817, '21', '01', '04', 'ATUNCOLLA', 'Distrito'),
(1818, '21', '01', '05', 'CAPACHICA', 'Distrito'),
(1819, '21', '01', '06', 'CHUCUITO', 'Distrito'),
(1820, '21', '01', '07', 'COATA', 'Distrito'),
(1821, '21', '01', '08', 'HUATA', 'Distrito'),
(1822, '21', '01', '09', 'MAÃ‘AZO', 'Distrito'),
(1823, '21', '01', '10', 'PAUCARCOLLA', 'Distrito'),
(1824, '21', '01', '11', 'PICHACANI', 'Distrito'),
(1825, '21', '01', '12', 'PLATERIA', 'Distrito'),
(1826, '21', '01', '13', 'SAN ANTONIO  /1', 'Distrito'),
(1827, '21', '01', '14', 'TIQUILLACA', 'Distrito'),
(1828, '21', '01', '15', 'VILQUE', 'Distrito'),
(1829, '21', '02', '01', 'AZANGARO', 'Distrito'),
(1830, '21', '02', '02', 'ACHAYA', 'Distrito'),
(1831, '21', '02', '03', 'ARAPA', 'Distrito'),
(1832, '21', '02', '04', 'ASILLO', 'Distrito'),
(1833, '21', '02', '05', 'CAMINACA', 'Distrito'),
(1834, '21', '02', '06', 'CHUPA', 'Distrito'),
(1835, '21', '02', '07', 'JOSE DOMINGO CHOQUEHUANCA', 'Distrito'),
(1836, '21', '02', '08', 'MUÃ‘ANI', 'Distrito'),
(1837, '21', '02', '09', 'POTONI', 'Distrito'),
(1838, '21', '02', '10', 'SAMAN', 'Distrito'),
(1839, '21', '02', '11', 'SAN ANTON', 'Distrito'),
(1840, '21', '02', '12', 'SAN JOSE', 'Distrito'),
(1841, '21', '02', '13', 'SAN JUAN DE SALINAS', 'Distrito'),
(1842, '21', '02', '14', 'SANTIAGO DE PUPUJA', 'Distrito'),
(1843, '21', '02', '15', 'TIRAPATA', 'Distrito'),
(1844, '21', '03', '01', 'MACUSANI', 'Distrito'),
(1845, '21', '03', '02', 'AJOYANI', 'Distrito'),
(1846, '21', '03', '03', 'AYAPATA', 'Distrito'),
(1847, '21', '03', '04', 'COASA', 'Distrito'),
(1848, '21', '03', '05', 'CORANI', 'Distrito'),
(1849, '21', '03', '06', 'CRUCERO', 'Distrito'),
(1850, '21', '03', '07', 'ITUATA   2/', 'Distrito'),
(1851, '21', '03', '08', 'OLLACHEA', 'Distrito'),
(1852, '21', '03', '09', 'SAN GABAN', 'Distrito'),
(1853, '21', '03', '10', 'USICAYOS', 'Distrito'),
(1854, '21', '04', '01', 'JULI', 'Distrito'),
(1855, '21', '04', '02', 'DESAGUADERO', 'Distrito'),
(1856, '21', '04', '03', 'HUACULLANI', 'Distrito'),
(1857, '21', '04', '04', 'KELLUYO', 'Distrito'),
(1858, '21', '04', '05', 'PISACOMA', 'Distrito'),
(1859, '21', '04', '06', 'POMATA', 'Distrito'),
(1860, '21', '04', '07', 'ZEPITA', 'Distrito'),
(1861, '21', '05', '01', 'ILAVE', 'Distrito'),
(1862, '21', '05', '02', 'CAPAZO', 'Distrito'),
(1863, '21', '05', '03', 'PILCUYO', 'Distrito'),
(1864, '21', '05', '04', 'SANTA ROSA', 'Distrito'),
(1865, '21', '05', '05', 'CONDURIRI', 'Distrito'),
(1866, '21', '06', '01', 'HUANCANE', 'Distrito'),
(1867, '21', '06', '02', 'COJATA', 'Distrito'),
(1868, '21', '06', '03', 'HUATASANI', 'Distrito'),
(1869, '21', '06', '04', 'INCHUPALLA', 'Distrito'),
(1870, '21', '06', '05', 'PUSI', 'Distrito'),
(1871, '21', '06', '06', 'ROSASPATA', 'Distrito'),
(1872, '21', '06', '07', 'TARACO', 'Distrito'),
(1873, '21', '06', '08', 'VILQUE CHICO', 'Distrito'),
(1874, '21', '07', '01', 'LAMPA', 'Distrito'),
(1875, '21', '07', '02', 'CABANILLA', 'Distrito'),
(1876, '21', '07', '03', 'CALAPUJA', 'Distrito'),
(1877, '21', '07', '04', 'NICASIO', 'Distrito'),
(1878, '21', '07', '05', 'OCUVIRI', 'Distrito'),
(1879, '21', '07', '06', 'PALCA', 'Distrito'),
(1880, '21', '07', '07', 'PARATIA', 'Distrito'),
(1881, '21', '07', '08', 'PUCARA', 'Distrito'),
(1882, '21', '07', '09', 'SANTA LUCIA', 'Distrito'),
(1883, '21', '07', '10', 'VILAVILA', 'Distrito'),
(1884, '21', '08', '01', 'AYAVIRI', 'Distrito'),
(1885, '21', '08', '02', 'ANTAUTA', 'Distrito'),
(1886, '21', '08', '03', 'CUPI', 'Distrito'),
(1887, '21', '08', '04', 'LLALLI', 'Distrito'),
(1888, '21', '08', '05', 'MACARI', 'Distrito'),
(1889, '21', '08', '06', 'NUÃ‘OA', 'Distrito'),
(1890, '21', '08', '07', 'ORURILLO', 'Distrito'),
(1891, '21', '08', '08', 'SANTA ROSA', 'Distrito'),
(1892, '21', '08', '09', 'UMACHIRI', 'Distrito'),
(1893, '21', '09', '01', 'MOHO', 'Distrito'),
(1894, '21', '09', '02', 'CONIMA', 'Distrito'),
(1895, '21', '09', '03', 'HUAYRAPATA', 'Distrito'),
(1896, '21', '09', '04', 'TILALI', 'Distrito'),
(1897, '21', '10', '01', 'PUTINA', 'Distrito'),
(1898, '21', '10', '02', 'ANANEA', 'Distrito'),
(1899, '21', '10', '03', 'PEDRO VILCA APAZA', 'Distrito'),
(1900, '21', '10', '04', 'QUILCAPUNCU', 'Distrito'),
(1901, '21', '10', '05', 'SINA', 'Distrito'),
(1902, '21', '11', '01', 'JULIACA', 'Distrito'),
(1903, '21', '11', '02', 'CABANA', 'Distrito'),
(1904, '21', '11', '03', 'CABANILLAS', 'Distrito'),
(1905, '21', '11', '04', 'CARACOTO', 'Distrito'),
(1906, '21', '12', '01', 'SANDIA', 'Distrito'),
(1907, '21', '12', '02', 'CUYOCUYO', 'Distrito'),
(1908, '21', '12', '03', 'LIMBANI', 'Distrito'),
(1909, '21', '12', '04', 'PATAMBUCO', 'Distrito'),
(1910, '21', '12', '05', 'PHARA', 'Distrito'),
(1911, '21', '12', '06', 'QUIACA', 'Distrito'),
(1912, '21', '12', '07', 'SAN JUAN DEL ORO', 'Distrito'),
(1913, '21', '12', '08', 'YANAHUAYA', 'Distrito'),
(1914, '21', '12', '09', 'ALTO INAMBARI', 'Distrito'),
(1915, '21', '12', '10', 'SAN PEDRO DE PUTINA PUNCO', 'Distrito'),
(1916, '21', '13', '01', 'YUNGUYO', 'Distrito'),
(1917, '21', '13', '02', 'ANAPIA', 'Distrito'),
(1918, '21', '13', '03', 'COPANI', 'Distrito'),
(1919, '21', '13', '04', 'CUTURAPI', 'Distrito'),
(1920, '21', '13', '05', 'OLLARAYA', 'Distrito'),
(1921, '21', '13', '06', 'TINICACHI', 'Distrito'),
(1922, '21', '13', '07', 'UNICACHI', 'Distrito'),
(1923, '22', '01', '01', 'MOYOBAMBA', 'Distrito'),
(1924, '22', '01', '02', 'CALZADA', 'Distrito'),
(1925, '22', '01', '03', 'HABANA', 'Distrito'),
(1926, '22', '01', '04', 'JEPELACIO', 'Distrito'),
(1927, '22', '01', '05', 'SORITOR', 'Distrito'),
(1928, '22', '01', '06', 'YANTALO', 'Distrito'),
(1929, '22', '02', '01', 'BELLAVISTA', 'Distrito'),
(1930, '22', '02', '02', 'ALTO BIAVO', 'Distrito'),
(1931, '22', '02', '03', 'BAJO BIAVO', 'Distrito'),
(1932, '22', '02', '04', 'HUALLAGA', 'Distrito'),
(1933, '22', '02', '05', 'SAN PABLO', 'Distrito'),
(1934, '22', '02', '06', 'SAN RAFAEL', 'Distrito'),
(1935, '22', '03', '01', 'SAN JOSE DE SISA', 'Distrito'),
(1936, '22', '03', '02', 'AGUA BLANCA', 'Distrito'),
(1937, '22', '03', '03', 'SAN MARTIN', 'Distrito'),
(1938, '22', '03', '04', 'SANTA ROSA', 'Distrito'),
(1939, '22', '03', '05', 'SHATOJA', 'Distrito'),
(1940, '22', '04', '01', 'SAPOSOA', 'Distrito'),
(1941, '22', '04', '02', 'ALTO SAPOSOA', 'Distrito'),
(1942, '22', '04', '03', 'EL ESLABON', 'Distrito'),
(1943, '22', '04', '04', 'PISCOYACU', 'Distrito'),
(1944, '22', '04', '05', 'SACANCHE', 'Distrito'),
(1945, '22', '04', '06', 'TINGO DE SAPOSOA', 'Distrito'),
(1946, '22', '05', '01', 'LAMAS', 'Distrito'),
(1947, '22', '05', '02', 'ALONSO DE ALVARADO', 'Distrito'),
(1948, '22', '05', '03', 'BARRANQUITA', 'Distrito'),
(1949, '22', '05', '04', 'CAYNARACHI   1/', 'Distrito'),
(1950, '22', '05', '05', 'CUÃ‘UMBUQUI', 'Distrito'),
(1951, '22', '05', '06', 'PINTO RECODO', 'Distrito'),
(1952, '22', '05', '07', 'RUMISAPA', 'Distrito'),
(1953, '22', '05', '08', 'SAN ROQUE DE CUMBAZA', 'Distrito'),
(1954, '22', '05', '09', 'SHANAO', 'Distrito'),
(1955, '22', '05', '10', 'TABALOSOS', 'Distrito'),
(1956, '22', '05', '11', 'ZAPATERO', 'Distrito'),
(1957, '22', '06', '01', 'JUANJUI', 'Distrito'),
(1958, '22', '06', '02', 'CAMPANILLA', 'Distrito'),
(1959, '22', '06', '03', 'HUICUNGO', 'Distrito'),
(1960, '22', '06', '04', 'PACHIZA', 'Distrito'),
(1961, '22', '06', '05', 'PAJARILLO', 'Distrito'),
(1962, '22', '07', '01', 'PICOTA', 'Distrito'),
(1963, '22', '07', '02', 'BUENOS AIRES', 'Distrito'),
(1964, '22', '07', '03', 'CASPISAPA', 'Distrito'),
(1965, '22', '07', '04', 'PILLUANA', 'Distrito'),
(1966, '22', '07', '05', 'PUCACACA', 'Distrito'),
(1967, '22', '07', '06', 'SAN CRISTOBAL', 'Distrito'),
(1968, '22', '07', '07', 'SAN HILARION', 'Distrito'),
(1969, '22', '07', '08', 'SHAMBOYACU', 'Distrito'),
(1970, '22', '07', '09', 'TINGO DE PONASA', 'Distrito'),
(1971, '22', '07', '10', 'TRES UNIDOS', 'Distrito'),
(1972, '22', '08', '01', 'RIOJA', 'Distrito'),
(1973, '22', '08', '02', 'AWAJUN', 'Distrito'),
(1974, '22', '08', '03', 'ELIAS SOPLIN VARGAS', 'Distrito'),
(1975, '22', '08', '04', 'NUEVA CAJAMARCA', 'Distrito'),
(1976, '22', '08', '05', 'PARDO MIGUEL', 'Distrito'),
(1977, '22', '08', '06', 'POSIC', 'Distrito'),
(1978, '22', '08', '07', 'SAN FERNANDO', 'Distrito'),
(1979, '22', '08', '08', 'YORONGOS', 'Distrito'),
(1980, '22', '08', '09', 'YURACYACU', 'Distrito'),
(1981, '22', '09', '01', 'TARAPOTO', 'Distrito'),
(1982, '22', '09', '02', 'ALBERTO LEVEAU', 'Distrito'),
(1983, '22', '09', '03', 'CACATACHI', 'Distrito'),
(1984, '22', '09', '04', 'CHAZUTA', 'Distrito'),
(1985, '22', '09', '05', 'CHIPURANA', 'Distrito'),
(1986, '22', '09', '06', 'EL PORVENIR', 'Distrito'),
(1987, '22', '09', '07', 'HUIMBAYOC', 'Distrito'),
(1988, '22', '09', '08', 'JUAN GUERRA', 'Distrito'),
(1989, '22', '09', '09', 'LA BANDA DE SHILCAYO', 'Distrito'),
(1990, '22', '09', '10', 'MORALES', 'Distrito'),
(1991, '22', '09', '11', 'PAPAPLAYA', 'Distrito'),
(1992, '22', '09', '12', 'SAN ANTONIO', 'Distrito'),
(1993, '22', '09', '13', 'SAUCE', 'Distrito'),
(1994, '22', '09', '14', 'SHAPAJA', 'Distrito'),
(1995, '22', '10', '01', 'TOCACHE', 'Distrito'),
(1996, '22', '10', '02', 'NUEVO PROGRESO', 'Distrito'),
(1997, '22', '10', '03', 'POLVORA', 'Distrito'),
(1998, '22', '10', '04', 'SHUNTE  2/ ', 'Distrito'),
(1999, '22', '10', '05', 'UCHIZA', 'Distrito'),
(2000, '23', '01', '01', 'TACNA', 'Distrito'),
(2001, '23', '01', '02', 'ALTO DE LA ALIANZA', 'Distrito'),
(2002, '23', '01', '03', 'CALANA', 'Distrito'),
(2003, '23', '01', '04', 'CIUDAD NUEVA', 'Distrito'),
(2004, '23', '01', '05', 'INCLAN', 'Distrito'),
(2005, '23', '01', '06', 'PACHIA', 'Distrito'),
(2006, '23', '01', '07', 'PALCA', 'Distrito'),
(2007, '23', '01', '08', 'POCOLLAY', 'Distrito'),
(2008, '23', '01', '09', 'SAMA', 'Distrito'),
(2009, '23', '01', '10', 'CORONEL GREGORIO ALBARRACIN LANCHIPA', 'Distrito'),
(2010, '23', '02', '01', 'CANDARAVE', 'Distrito'),
(2011, '23', '02', '02', 'CAIRANI', 'Distrito'),
(2012, '23', '02', '03', 'CAMILACA', 'Distrito'),
(2013, '23', '02', '04', 'CURIBAYA', 'Distrito'),
(2014, '23', '02', '05', 'HUANUARA', 'Distrito'),
(2015, '23', '02', '06', 'QUILAHUANI', 'Distrito'),
(2016, '23', '03', '01', 'LOCUMBA', 'Distrito'),
(2017, '23', '03', '02', 'ILABAYA', 'Distrito'),
(2018, '23', '03', '03', 'ITE', 'Distrito'),
(2019, '23', '04', '01', 'TARATA', 'Distrito'),
(2020, '23', '04', '02', 'HEROES ALBARRACIN', 'Distrito'),
(2021, '23', '04', '03', 'ESTIQUE', 'Distrito'),
(2022, '23', '04', '04', 'ESTIQUE-PAMPA', 'Distrito'),
(2023, '23', '04', '05', 'SITAJARA', 'Distrito'),
(2024, '23', '04', '06', 'SUSAPAYA', 'Distrito'),
(2025, '23', '04', '07', 'TARUCACHI', 'Distrito'),
(2026, '23', '04', '08', 'TICACO', 'Distrito'),
(2027, '24', '01', '01', 'TUMBES', 'Distrito'),
(2028, '24', '01', '02', 'CORRALES', 'Distrito'),
(2029, '24', '01', '03', 'LA CRUZ', 'Distrito'),
(2030, '24', '01', '04', 'PAMPAS DE HOSPITAL', 'Distrito'),
(2031, '24', '01', '05', 'SAN JACINTO', 'Distrito'),
(2032, '24', '01', '06', 'SAN JUAN DE LA VIRGEN', 'Distrito'),
(2033, '24', '02', '01', 'ZORRITOS', 'Distrito'),
(2034, '24', '02', '02', 'CASITAS', 'Distrito'),
(2035, '24', '02', '03', 'CANOAS DE PUNTA SAL', 'Distrito'),
(2036, '24', '03', '01', 'ZARUMILLA', 'Distrito'),
(2037, '24', '03', '02', 'AGUAS VERDES', 'Distrito'),
(2038, '24', '03', '03', 'MATAPALO', 'Distrito'),
(2039, '24', '03', '04', 'PAPAYAL', 'Distrito'),
(2040, '25', '01', '01', 'CALLERIA', 'Distrito'),
(2041, '25', '01', '02', 'CAMPOVERDE', 'Distrito'),
(2042, '25', '01', '03', 'IPARIA', 'Distrito'),
(2043, '25', '01', '04', 'MASISEA', 'Distrito');
INSERT INTO `tb_ubigeo` (`tb_ubigeo_id`, `tb_ubigeo_coddep`, `tb_ubigeo_codpro`, `tb_ubigeo_coddis`, `tb_ubigeo_nom`, `tb_ubigeo_tip`) VALUES
(2044, '25', '01', '05', 'YARINACOCHA', 'Distrito'),
(2045, '25', '01', '06', 'NUEVA REQUENA', 'Distrito'),
(2046, '25', '01', '07', 'MANANTAY', 'Distrito'),
(2047, '25', '02', '01', 'RAYMONDI', 'Distrito'),
(2048, '25', '02', '02', 'SEPAHUA', 'Distrito'),
(2049, '25', '02', '03', 'TAHUANIA', 'Distrito'),
(2050, '25', '02', '04', 'YURUA', 'Distrito'),
(2051, '25', '03', '01', 'PADRE ABAD', 'Distrito'),
(2052, '25', '03', '02', 'IRAZOLA', 'Distrito'),
(2053, '25', '03', '03', 'CURIMANA', 'Distrito'),
(2054, '25', '04', '01', 'PURUS', 'Distrito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_unidad`
--

CREATE TABLE `tb_unidad` (
  `tb_unidad_id` int(11) NOT NULL,
  `tb_unidad_abr` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tb_unidad_nom` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tb_unidad_tip` tinyint(4) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_unidad`
--

INSERT INTO `tb_unidad` (`tb_unidad_id`, `tb_unidad_abr`, `tb_unidad_nom`, `tb_unidad_tip`, `tb_empresa_id`) VALUES
(1, 'UN', 'UNIDAD', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `tb_usuario_id` int(11) NOT NULL,
  `tb_usuario_use` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_pas` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_apepat` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_apemat` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_ema` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_reg` datetime NOT NULL,
  `tb_usuario_mod` datetime NOT NULL,
  `tb_usuario_ultvis` datetime NOT NULL,
  `tb_usuario_blo` tinyint(4) NOT NULL,
  `tb_usuariogrupo_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuario`
--

INSERT INTO `tb_usuario` (`tb_usuario_id`, `tb_usuario_use`, `tb_usuario_pas`, `tb_usuario_apepat`, `tb_usuario_apemat`, `tb_usuario_nom`, `tb_usuario_ema`, `tb_usuario_reg`, `tb_usuario_mod`, `tb_usuario_ultvis`, `tb_usuario_blo`, `tb_usuariogrupo_id`, `tb_empresa_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '.', '.', 'REP VET MARVIC E.I.R.L.', 'rep.marvic@gmail.com', '0000-00-00 00:00:00', '2018-10-23 20:53:14', '2019-06-10 20:22:20', 0, 2, 1),
(29, 'superusuario', '261a7d80916532797f8735dd198d4ada', 'APELLIDO PATERNO', 'APELIIDO MATERNO', 'SUPER', 'gerencia@a-zetasoft.com', '0000-00-00 00:00:00', '2018-03-03 12:28:53', '2018-12-27 18:54:26', 0, 1, 1),
(30, 'vendedor', 'a60c36fc7c825e68bb5371a0e08f828a', 'ZIRENA', 'BEJARANO', 'ALFREDO', 'alfredzb@gmail.com', '0000-00-00 00:00:00', '2018-10-26 22:58:22', '2018-04-19 14:23:49', 0, 3, 1),
(33, 'liquidador', '221b3a9e09a367bb69f7c7c1141c1dd9', 'PALOMINO', 'SANCHEZ', 'JOSE', 'rrpalomino65@hotmail.com', '2018-01-31 11:00:40', '2018-01-31 11:01:05', '2018-03-17 11:24:17', 0, 4, 1),
(34, 'correo@gmail.com', '9fb49d1fb3f585794fb9ca7f39263773', 'APP', 'MAT', 'NOM', 'correo@gmail.com', '2018-12-27 18:58:24', '2018-12-27 18:58:24', '0000-00-00 00:00:00', 0, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuariodetalle`
--

CREATE TABLE `tb_usuariodetalle` (
  `tb_usuario_id` int(11) NOT NULL,
  `tb_usuario_dni` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_fot` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_horario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuariodetalle`
--

INSERT INTO `tb_usuariodetalle` (`tb_usuario_id`, `tb_usuario_dni`, `tb_usuario_fot`, `tb_puntoventa_id`, `tb_horario_id`) VALUES
(1, '', '', 1, 0),
(29, '', '', 1, 0),
(30, '', '', 1, 2),
(33, '43219752', '', 0, 0),
(34, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuariogrupo`
--

CREATE TABLE `tb_usuariogrupo` (
  `tb_usuariogrupo_id` int(11) NOT NULL,
  `tb_usuariogrupo_nom` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuariogrupo_des` varchar(150) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuariogrupo`
--

INSERT INTO `tb_usuariogrupo` (`tb_usuariogrupo_id`, `tb_usuariogrupo_nom`, `tb_usuariogrupo_des`) VALUES
(1, 'Super Usuario', 'GestiÃ³n general de la aplicaciÃ³n.'),
(2, 'Administrador', 'Mantenimiento de la aplicaciÃ³n, registra compras, ventas. Gestiona los usuarios.'),
(3, 'Vendedor', 'Realiza el registro de ventas. Imprime documento de venta.'),
(4, 'Ejecutor', 'Realiza pagos caja terceros.'),
(5, 'Almacen', 'Ingresa Compras, hace traslados entre almacenes, ajustes de stock en alamcenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuariopv`
--

CREATE TABLE `tb_usuariopv` (
  `tb_usuariopv_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuariopv`
--

INSERT INTO `tb_usuariopv` (`tb_usuariopv_id`, `tb_usuario_id`, `tb_puntoventa_id`) VALUES
(1, 1, 1),
(4, 33, 0),
(7, 30, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_vehiculo`
--

CREATE TABLE `tb_vehiculo` (
  `tb_vehiculo_id` int(11) NOT NULL,
  `tb_vehiculo_placa` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `tb_conductor_id` int(11) NOT NULL,
  `tb_vehiculo_marca` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tb_vehiculo_modelo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tb_vehiculo_numasi` int(11) NOT NULL,
  `tb_vehiculo_pisos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tb_vehiculo`
--

INSERT INTO `tb_vehiculo` (`tb_vehiculo_id`, `tb_vehiculo_placa`, `tb_conductor_id`, `tb_vehiculo_marca`, `tb_vehiculo_modelo`, `tb_vehiculo_numasi`, `tb_vehiculo_pisos`) VALUES
(1, 'V3V-968', 1, 'YARIS', '', 4, 1),
(2, 'V5L-958', 2, 'ERTICA', '', 6, 1),
(3, 'A3W-756', 2, 'AVANZA', '', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_venta`
--

CREATE TABLE `tb_venta` (
  `tb_venta_id` int(11) NOT NULL,
  `tb_venta_reg` datetime NOT NULL,
  `tb_venta_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_venta_numdoc` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_valven` decimal(8,2) NOT NULL,
  `tb_venta_des` decimal(8,2) NOT NULL,
  `tb_venta_igv` decimal(8,2) NOT NULL,
  `tb_venta_tot` decimal(8,2) NOT NULL,
  `tb_venta_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_lab1` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_lab2` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_lab3` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_may` tinyint(4) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL,
  `cs_tipodocumento_id` int(11) NOT NULL,
  `tb_venta_ser` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_num` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cs_tipomoneda_id` int(11) NOT NULL,
  `tb_venta_gra` decimal(8,2) NOT NULL,
  `tb_venta_ina` decimal(8,2) NOT NULL,
  `tb_venta_exo` decimal(8,2) NOT NULL,
  `tb_venta_grat` decimal(8,2) NOT NULL,
  `tb_venta_isc` decimal(8,2) NOT NULL,
  `tb_venta_otrtri` decimal(8,2) NOT NULL,
  `tb_venta_otrcar` decimal(8,2) NOT NULL,
  `tb_venta_desglo` decimal(8,2) NOT NULL,
  `cs_tipooperacion_id` int(11) NOT NULL,
  `cs_documentosrelacionados_id` int(11) NOT NULL,
  `tb_venta_faucod` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_digval` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_sigval` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_val` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_venta_fecenvsun` datetime NOT NULL,
  `tb_venta_estsun` tinyint(1) NOT NULL,
  `tb_vendedor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_venta`
--

INSERT INTO `tb_venta` (`tb_venta_id`, `tb_venta_reg`, `tb_venta_fec`, `tb_documento_id`, `tb_venta_numdoc`, `tb_cliente_id`, `tb_venta_valven`, `tb_venta_des`, `tb_venta_igv`, `tb_venta_tot`, `tb_venta_est`, `tb_venta_lab1`, `tb_venta_lab2`, `tb_venta_lab3`, `tb_venta_may`, `tb_usuario_id`, `tb_puntoventa_id`, `tb_empresa_id`, `cs_tipodocumento_id`, `tb_venta_ser`, `tb_venta_num`, `cs_tipomoneda_id`, `tb_venta_gra`, `tb_venta_ina`, `tb_venta_exo`, `tb_venta_grat`, `tb_venta_isc`, `tb_venta_otrtri`, `tb_venta_otrcar`, `tb_venta_desglo`, `cs_tipooperacion_id`, `cs_documentosrelacionados_id`, `tb_venta_faucod`, `tb_venta_digval`, `tb_venta_sigval`, `tb_venta_val`, `tb_venta_fecenvsun`, `tb_venta_estsun`, `tb_vendedor_id`) VALUES
(1, '2019-01-30 20:50:47', '2019-01-30', 11, 'F001-00078', 18, '0.00', '0.00', '0.00', '7.50', 'CANCELADA', '', '', '', 0, 1, 1, 1, 1, 'F001', '00078', 1, '0.00', '0.00', '7.50', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '0', 'ddhLxkRopcEnTL9EE0zyt2BGixo=', 'FPuD6Ayw6/aEHOHBRBGIuQOLnOMxUkR6uRsd5fGkkdIb+1zRjgKmrFwAEAsuF9qtNKb7pQoCFiJbINc0dmK7uiFkHGPJseBUPs70wdC4lvwxQ4n/IVyOIUT5Ef/+MNuwFJiP9s3gRKl8SQULhL1XwdRWi9+m/QtmsRV0urGgZtHbaWfHF132Xt5yMA55197oJh51J+7uBnw/ZkhHcTfjknyyKcWF5L6Y/tqLFY1N5X3nK+D+j0LMR3ctiM+sovZEUm2kXorjhD5fvfINsCXPLIEgGdzql/+TYsB1gf4nQBKMWuHeZpIQyu32k+/JcPFusANIQU5oFF3Bn9DBFoxJ7g==', '1', '2019-01-30 20:53:44', 1, 1),
(2, '2019-01-30 21:19:24', '2019-01-30', 11, 'F001-00079', 8, '0.00', '0.00', '0.00', '7.50', 'CANCELADA', '', '', '', 0, 1, 1, 1, 1, 'F001', '00079', 1, '0.00', '0.00', '7.50', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '0', 'mw1zLjKeMBtw2mr5EM83rkC5r08=', 'mRuyLwFUwis0wLiQuzdSfgDpktnuIvmbM/oh0qgT0bqgE6PuGHMLmokPzOymXYDIf8xPqIRykgPlvSaXf1cEqRzm5tG8OJBpfZ9I0QXW9ujt3brjTgHVqUO9BvVjQLJ29N4ls0B4PzZeb4G9Ynus/bkBY2DPLlEqpRpJ6Fyk3Xboo9Kc3J4M9Su8PvDN11nDadUBdOA+g7MbBGOCHK7ioSYcPvW2wLMmHWFGt1zR9fR0zJPiB3S6YvhO+fQbfPr/VliD8i0lBTilQlvbqmXkckS7p/4C0Itf7NHDZY6AmEj4YI1KDhki8SKVcvH8t0cSonpSjgSDPV1fwGMRxajiNA==', '1', '2019-01-30 21:19:25', 1, 1),
(3, '2019-01-30 21:26:12', '2019-01-30', 11, 'F001-00080', 18, '0.00', '0.00', '0.00', '7.50', 'CANCELADA', '', '', '', 0, 1, 1, 1, 1, 'F001', '00080', 1, '0.00', '0.00', '7.50', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '0', 'lFluXinLhM9S76ChQwlHJRK31FQ=', 'OTy//xuPci+mwCeUH/VvzVlgJ7b5gR06aufZh1JF60JeSeIu85fBm8M1NkBsUmsLtnxWeB2r0J2zEgbca+2oFDPuSSySjjyIG05J5b5OerYQuj4np+qRJURKSqHAFAwPqFDhbp9/SmT4h9qUk5ps29pvmFKYhYDkloIBEMaJv63ci6QXTbHahfhzWIpb9hpE7vHD8yWknUwZAF20VLtrR4TO75f6P986sd4TSZrxfwUhB039vQca7UIHIptn6tAH1MrlDLlybJivbkoixhPLowrzyWKCA2scGDsbQL/kzm873WFzKZNXVaK3WOKE3zPF6ibHC6CuHFV73jfLNX6xIA==', '1', '2019-01-30 21:45:27', 1, 1),
(4, '2019-01-31 15:45:54', '2019-01-31', 11, 'F001-00081', 18, '0.00', '0.00', '0.00', '7.50', 'CANCELADA', '', '', '', 0, 1, 1, 1, 1, 'F001', '00081', 1, '0.00', '0.00', '7.50', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '0', 'YoqjNLZkKHi4bHyJRv5kj+PT4u4=', 'IQyvzMamNVBzcwtMMTRq3kLJG/cJW1frWClZal/VFXEMpYfUj0Hw9T1F69Jct2vXd4NdmnF4lCnOJTSNOX9+n2uXnZTcJnRpCffCv7CoiRxFgqsKuaF8PitNFS8Srv9UR20QqNTBSbyUjCsKx+L4nDtPnc/nBkI2tW1xUKHGmD0VpQyM3nlJEWpQ72/b3XxQEplI+Fnk8BpBjZ41BzdFw9YAwVaV2R4lg2apHHfs79khxfxFuhlmCbcFpTZ7Mv2y0Jwp6tBDpBr4Dy1NpwowJMSzU5BWi94aY6tI3K6ffkFjQjl+Af2m6AZV4OJ2V7vTI/WpsTY35ObEDgg2TwNO3Q==', '1', '2019-01-31 15:45:56', 1, 1),
(5, '2019-01-31 16:24:17', '2019-01-31', 12, 'B001-0524', 7, '0.00', '0.00', '0.00', '5.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0524', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '-1', '4NCIkLf/Ua++9FH6Z3L/be9FEnQ=', 'WStrzsiI1iAKV7JY5PfTrh78dneycxEJ20z9AblKnvpmOovOGePSAi2vbugAKVP2Q6bXjejoimL3hpv57A1gLDIjU7Urw1b8mKC78PiyCdELiIBhUQRAWWXxLkYmgKAKfdRYzlb/3n20wzuNexhyv6fra0VbMNC3a0/f/CE1adFAwNYss4O+0f0WU5Wzy4r90w+T/K5Kk5JWXdF0BQx+OnLs2DqZZ98PZq1jT0YGmtSOJMTTuCqZriP0zVo8mxg5QGJiEMMzcZ7IO1kikpZV38xueyfKiQGIvm6XfOQfDOnYgHVc+1hLK930+Q78dKrNqQaag5yjCPz/i+DGYuWIaQ==', '1', '2019-01-31 16:24:19', 10, 1),
(6, '2019-01-31 16:27:28', '2019-01-31', 12, 'B001-0525', 7, '0.00', '0.00', '0.00', '10.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0525', 1, '0.00', '0.00', '10.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '-1', '0GJTrtJFWJ7BsxqijX426csb0mI=', 'wZHFsTNTjWWw5au52ncCvmguiJJp+Vjfs/WAXOwkMsXoohdyRXIlG60Z441PQzlxgFjuR/NQoOnaUZxu63tHpejfgeguob6XU6vmxpByneXi2p0Fj4KIn5sXFRdiPIhKzVruem2CQgYbk0qXUxM/UIS84E4jJoyBQFWieBBE/sG9XFKB9IyCYrtRoCdWWPIRhcld+3yz+IWyeUozQZ7XljUPuYN599FNsE9TDelMRqeb4XKX0EpV2zSOO6wONTkZA57VQ33i1f9meqYLpOwn1EXonu+Eb74ECCv2wA2SdB8wPWkdfujWSzyL4hQ6aIi1r41PU1InJPqpl8coHH9CKg==', '1', '2019-01-31 16:27:29', 10, 1),
(7, '2019-01-31 16:55:34', '2019-01-31', 12, 'B001-0526', 7, '0.00', '0.00', '0.00', '15.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0526', 1, '0.00', '0.00', '15.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '-1', 'TSHhwY0kaE7Hq4fXKvl1snVd7Hw=', 'nMMn2Y1cZzFApbIsLxL5tdBL54o32/yoBLPwTZqP+YRj7vu+kUZhiXW7uxF6UgPCbupOUF/aK6FyK3Q7c3++9OmfGfOucCfzYB8UTzovwMWmn49BYHFJ7bY4RcnkGEVZXvOdS35fTEh6OR3SyOjqVAaaf7QPXzMvudfOtBBwRnCOFCOPLu1HtzLP/jxlOTwu7hqfOJEt93bwC0LK/8szIhQC5mpLVkOMhXNGt+nZfESMgHpL2Yeqi1NRWLpINXqDjET7iVLpu6cGVVioVQNOxuxWWtLswQWt8qywsyu1k+qrk3EC/6iA9tb2Rqtoj8Lv1SPM6kemxOs62UZBmLPZ6w==', '1', '2019-01-31 16:55:35', 10, 1),
(8, '2019-01-31 17:18:45', '2019-01-31', 12, 'B001-0527', 3, '0.00', '0.00', '0.00', '30.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0527', 1, '0.00', '0.00', '30.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '', '', '', '', '0000-00-00 00:00:00', 10, 1),
(9, '2019-01-31 18:24:24', '2019-01-31', 12, 'B001-0528', 24, '0.00', '0.00', '0.00', '30.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0528', 1, '0.00', '0.00', '30.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '-1', 'Bm1LitE8RSNAPkEVyLiiWGraphM=', 'HVTLDaMqaABFyGDb/7ixwTdbSCWw9Y+lXUkwBC746VRJTRWluJeIsSKpqjdABVIxgvwjhNN9CDVZh8jtlAgdab/fITCTduSldM+LinG1wWbreFtD6AE8atHQ8HKuFD7b8ndUSPRl5h1y7UZ4vJ/2lcPk+o0Q8JJnhk2yNme5oblACeWAuliKEi+CLPnHxVHcVmphgLHNo2ZDVxXpDkrp71erIGR0w8BoAmsJuPO4/5haMxofuEHdQu7ir81AxqjmCNZX1GGGLLJnHnfgETf+E/sBTCZvausUNA3OSu+6w2t7xGIJ9iXY1tDe+CcGBBUcwyVjOACeOBqYYSSwyTgy0w==', '1', '2019-01-31 18:24:25', 10, 1),
(10, '2019-02-20 10:53:12', '2019-02-20', 15, 'NS01-00002', 1, '0.00', '0.00', '0.00', '34.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 0, 'NS01', '00002', 1, '0.00', '0.00', '34.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '', '', '', '', '0000-00-00 00:00:00', 0, 1),
(11, '2019-02-20 10:53:34', '2019-02-20', 12, 'B001-0529', 1, '0.00', '0.00', '0.00', '34.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0529', 1, '0.00', '0.00', '34.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '', '', '', '', '0000-00-00 00:00:00', 10, 1),
(12, '2019-06-10 21:37:34', '2019-06-10', 12, 'B001-0530', 16, '0.00', '0.00', '0.00', '100.00', 'CANCELADA', '', '', '', 0, 1, 1, 1, 2, 'B001', '0530', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, '-1', 'mToACnl+cTlFQweQVXw426o6tSY=', 'TiS7mE13djuv8QWeukSW83ws3whV/Kv/evZj2XntcFJt44XlJpfsruGDfESAGSmsCSuYLzIcYT2AwZ3O3SQ+T37SCJ53XjvpsR5vloQ5gfKHgrAfS32wUei/hdUg0P78GmXcXH8YdltL4m1+mjD/teXovURPZNZndmLPdGRw/jGQV6YCXOadysojmD9s39K90eGiOl4PqBObuM7EC2HfNq2XSfIEPpRsNKmPDderyXgJU+NQWkrkIrdXx+/OiL+DDI4XHloa6inXd8C3dpFxBX8/u2QVRW6QGRvhv5XcY1tGNFfmoH4+qoP+vTjbDtnS3LEUb5QaFHt1whtugrePaw==', '1', '2019-06-10 21:37:36', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventacanje`
--

CREATE TABLE `tb_ventacanje` (
  `tb_ventacanje_id` int(11) NOT NULL,
  `tb_ventacanje_reg` datetime NOT NULL,
  `tb_ventacanje_fec` date NOT NULL,
  `tb_ventanota_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventacorreo`
--

CREATE TABLE `tb_ventacorreo` (
  `tb_ventacorreo_id` int(11) NOT NULL,
  `tb_ventacorreo_xac` tinyint(1) NOT NULL,
  `tb_ventacorreo_fecreg` datetime NOT NULL,
  `tb_ventacorreo_fecmod` datetime NOT NULL,
  `tb_ventacorreo_usureg` int(11) NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_ventacorreo_tip` tinyint(1) NOT NULL,
  `tb_ventacorreo_coremi` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_cor` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_corcop` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_asu` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_men` text COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventacorreo_adj` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventadetalle`
--

CREATE TABLE `tb_ventadetalle` (
  `tb_ventadetalle_id` int(11) NOT NULL,
  `tb_ventadetalle_tipven` tinyint(4) NOT NULL COMMENT '1:Producto; 2: Servicio',
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL,
  `tb_ventadetalle_nom` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventadetalle_preuni` decimal(8,2) NOT NULL,
  `tb_ventadetalle_can` decimal(8,2) NOT NULL,
  `tb_ventadetalle_tipdes` tinyint(4) NOT NULL COMMENT '1:Porcentaje; 2:Soles',
  `tb_ventadetalle_des` decimal(8,2) NOT NULL,
  `tb_ventadetalle_preunilin` decimal(8,2) NOT NULL,
  `tb_ventadetalle_valven` decimal(8,2) NOT NULL,
  `tb_ventadetalle_igv` decimal(8,2) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `cs_tipoafectacionigv_id` int(11) NOT NULL,
  `cs_tipounidadmedida_id` int(11) NOT NULL,
  `cs_tiposistemacalculoisc_id` int(11) NOT NULL,
  `tb_ventadetalle_isc` decimal(8,2) NOT NULL,
  `tb_ventadetalle_nro` int(3) NOT NULL,
  `tb_ventadetalle_serie` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventadetalle`
--

INSERT INTO `tb_ventadetalle` (`tb_ventadetalle_id`, `tb_ventadetalle_tipven`, `tb_catalogo_id`, `tb_servicio_id`, `tb_ventadetalle_nom`, `tb_ventadetalle_preuni`, `tb_ventadetalle_can`, `tb_ventadetalle_tipdes`, `tb_ventadetalle_des`, `tb_ventadetalle_preunilin`, `tb_ventadetalle_valven`, `tb_ventadetalle_igv`, `tb_venta_id`, `cs_tipoafectacionigv_id`, `cs_tipounidadmedida_id`, `cs_tiposistemacalculoisc_id`, `tb_ventadetalle_isc`, `tb_ventadetalle_nro`, `tb_ventadetalle_serie`) VALUES
(1, 2, 0, 8, 'EXONERADO ', '5.00', '1.50', 0, '0.00', '4.24', '6.36', '1.14', 1, 9, 13, 0, '0.00', 1, ''),
(2, 2, 0, 8, 'EXONERADO ', '5.00', '1.50', 0, '0.00', '4.24', '6.36', '0.00', 2, 9, 13, 0, '0.00', 1, ''),
(3, 2, 0, 8, 'EXONERADO ', '5.00', '1.50', 0, '0.00', '4.24', '6.36', '1.14', 3, 9, 13, 0, '0.00', 1, ''),
(4, 2, 0, 9, 'CAJAS BLANCAS ', '5.00', '1.50', 0, '0.00', '4.24', '6.36', '1.14', 4, 1, 13, 0, '0.00', 1, ''),
(5, 2, 0, 1, 'PASAJE-Arequipa-Santo Tomas ', '5.00', '1.00', 0, '0.00', '5.00', '5.00', '0.90', 5, 9, 13, 0, '0.00', 1, ''),
(6, 2, 0, 10, 'CEBOLLA ', '10.00', '1.00', 0, '0.00', '8.47', '8.47', '1.53', 6, 1, 13, 0, '0.00', 1, ''),
(7, 2, 0, 11, 'FUNCIONA ', '15.00', '1.00', 0, '0.00', '12.71', '12.71', '2.29', 7, 1, 13, 0, '0.00', 1, ''),
(8, 2, 0, 3, 'POLLOS FRITOS ', '30.00', '1.00', 0, '0.00', '30.00', '30.00', '5.40', 8, 9, 13, 0, '0.00', 1, ''),
(9, 2, 0, 1, 'PASAJE-Arequipa-Santo Tomas ', '30.00', '1.00', 0, '0.00', '30.00', '30.00', '5.40', 9, 9, 13, 0, '0.00', 1, ''),
(10, 2, 0, 1, 'PASAJE-Arequipa-Camana ', '34.00', '1.00', 0, '0.00', '34.00', '34.00', '6.12', 10, 9, 13, 0, '0.00', 1, ''),
(11, 2, 0, 1, 'PASAJE-Arequipa-Camana ', '34.00', '1.00', 0, '0.00', '34.00', '34.00', '6.12', 11, 9, 13, 0, '0.00', 1, ''),
(12, 2, 0, 12, 'JAUJA A CHILLE IDA Y VUELTA', '100.00', '1.00', 0, '0.00', '100.00', '100.00', '18.00', 12, 9, 13, 0, '0.00', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventadetalle_lote`
--

CREATE TABLE `tb_ventadetalle_lote` (
  `tb_ventadetalle_lote_id` int(11) NOT NULL,
  `tb_ventadetalle_id` int(11) NOT NULL,
  `tb_fecha_fab` date NOT NULL,
  `tb_fecha_ven` date NOT NULL,
  `tb_ventadetalle_exisact` int(11) NOT NULL,
  `tb_ventadetalle_lotenum` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventadetalle_lote`
--

INSERT INTO `tb_ventadetalle_lote` (`tb_ventadetalle_lote_id`, `tb_ventadetalle_id`, `tb_fecha_fab`, `tb_fecha_ven`, `tb_ventadetalle_exisact`, `tb_ventadetalle_lotenum`) VALUES
(1, 31, '1969-12-31', '2019-04-19', 40, 'A016AJ13'),
(2, 31, '2018-10-25', '2019-10-31', 30, 'A017AJ01'),
(3, 32, '2018-10-25', '2019-07-31', 25, 'F005A06'),
(4, 33, '2018-10-26', '2019-12-31', 25, 'F122A02'),
(5, 34, '2018-10-25', '2019-07-31', 15, 'F005A06'),
(6, 35, '2018-10-26', '2019-12-31', 20, 'F122A02'),
(7, 36, '2018-10-26', '2019-12-31', 10, 'F122A02'),
(8, 37, '2018-10-26', '2019-12-31', 5, 'F122A02'),
(9, 38, '2018-10-25', '2019-07-31', 5, 'F005A06'),
(10, 39, '2018-10-25', '2019-07-31', 7, 'F005A06'),
(11, 40, '2018-10-27', '2018-10-31', 2, 'F0966'),
(12, 40, '2018-10-27', '2018-10-31', 3, 'AB5667'),
(13, 49, '1969-12-31', '2019-04-19', 10, 'A016AJ13'),
(14, 49, '2018-10-25', '2019-10-31', 5, 'A017AJ01'),
(15, 50, '1969-12-31', '2019-04-19', 4, 'A016AJ13'),
(16, 50, '2018-10-25', '2019-10-31', 5, 'A017AJ01'),
(17, 51, '2018-10-25', '2019-10-31', 3, 'A017AJ01'),
(18, 51, '1969-12-31', '2019-04-19', 4, 'A016AJ13'),
(19, 56, '1969-12-31', '2019-04-19', 3, 'A016AJ13'),
(20, 56, '2018-10-25', '2019-10-31', 5, 'A017AJ01'),
(21, 58, '1969-12-31', '2019-04-19', 1, 'A016AJ13'),
(22, 59, '1969-12-31', '2019-04-19', 2, 'A016AJ13'),
(23, 60, '1969-12-31', '2019-04-19', 2, 'A016AJ13'),
(24, 63, '2018-10-25', '2019-11-30', 1, 'A138AJ01'),
(25, 64, '1969-12-31', '2019-04-19', 5, 'A016AJ13'),
(26, 68, '1969-12-31', '2019-04-19', 3, 'A016AJ13'),
(27, 69, '2018-10-26', '2020-02-29', 3, 'A143DJ01'),
(28, 70, '2018-10-25', '2019-11-30', 5, 'A138AJ01'),
(29, 81, '2018-10-26', '2019-12-31', 2, 'A142AN01'),
(30, 83, '2018-11-02', '2018-11-23', 1, 'AER45566'),
(31, 83, '2018-10-25', '2019-11-30', 2, 'A138AJ01'),
(32, 131, '2018-10-25', '2019-03-29', 2, '91790162'),
(33, 133, '2018-10-25', '2019-03-29', 13, '91790162'),
(34, 134, '2018-10-25', '2019-07-28', 5, '91790175'),
(35, 135, '2018-11-30', '2018-11-16', 1, 'E'),
(36, 136, '2019-12-31', '2018-11-16', 3, 'F'),
(37, 137, '2018-10-25', '2019-10-27', 2, 'A'),
(38, 138, '2018-10-25', '2019-09-30', 2, 'A235BN01'),
(39, 139, '2018-10-25', '2020-03-31', 1, 'A245AN01'),
(40, 140, '2018-10-25', '2019-04-30', 5, '172237642');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventanota`
--

CREATE TABLE `tb_ventanota` (
  `tb_venta_id` int(11) NOT NULL,
  `tb_venta_reg` datetime NOT NULL,
  `tb_venta_fec` date NOT NULL,
  `tb_documento_id` int(11) NOT NULL,
  `tb_venta_numdoc` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_venta_valven` decimal(8,2) NOT NULL,
  `tb_venta_des` decimal(8,2) NOT NULL,
  `tb_venta_igv` decimal(8,2) NOT NULL,
  `tb_venta_tot` decimal(8,2) NOT NULL,
  `tb_venta_est` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `tb_usuario_id` int(11) NOT NULL,
  `tb_puntoventa_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventanotadetalle`
--

CREATE TABLE `tb_ventanotadetalle` (
  `tb_ventadetalle_id` int(11) NOT NULL,
  `tb_ventadetalle_tipven` tinyint(4) NOT NULL COMMENT '1:Producto; 2: Servicio',
  `tb_catalogo_id` int(11) NOT NULL,
  `tb_servicio_id` int(11) NOT NULL,
  `tb_ventadetalle_preuni` decimal(8,2) NOT NULL,
  `tb_ventadetalle_can` int(11) NOT NULL,
  `tb_ventadetalle_tipdes` tinyint(4) NOT NULL COMMENT '1:Porcentaje; 2:Soles',
  `tb_ventadetalle_des` decimal(8,2) NOT NULL,
  `tb_ventadetalle_preunilin` decimal(8,2) NOT NULL,
  `tb_ventadetalle_valven` decimal(8,2) NOT NULL,
  `tb_ventadetalle_igv` decimal(8,2) NOT NULL,
  `tb_venta_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventanotapago`
--

CREATE TABLE `tb_ventanotapago` (
  `tb_ventanotapago_id` int(11) NOT NULL,
  `tb_ventapago_fecreg` datetime NOT NULL,
  `tb_formapago_id` int(11) NOT NULL,
  `tb_modopago_id` int(11) NOT NULL,
  `tb_ventapago_fec` date NOT NULL,
  `tb_ventapago_mon` decimal(8,2) NOT NULL,
  `tb_cuentacorriente_id` int(11) NOT NULL,
  `tb_tarjeta_id` int(11) NOT NULL,
  `tb_ventapago_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventapago_numdia` int(11) NOT NULL,
  `tb_ventapago_fecven` date NOT NULL,
  `tb_ventanota_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_ventapago`
--

CREATE TABLE `tb_ventapago` (
  `tb_ventapago_id` int(11) NOT NULL,
  `tb_ventapago_fecreg` datetime NOT NULL,
  `tb_formapago_id` int(11) NOT NULL,
  `tb_modopago_id` int(11) NOT NULL,
  `tb_ventapago_fec` date NOT NULL,
  `tb_ventapago_mon` decimal(8,2) NOT NULL,
  `tb_cuentacorriente_id` int(11) NOT NULL,
  `tb_tarjeta_id` int(11) NOT NULL,
  `tb_ventapago_numope` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tb_ventapago_numdia` int(11) NOT NULL,
  `tb_ventapago_fecven` date NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tb_ventapago`
--

INSERT INTO `tb_ventapago` (`tb_ventapago_id`, `tb_ventapago_fecreg`, `tb_formapago_id`, `tb_modopago_id`, `tb_ventapago_fec`, `tb_ventapago_mon`, `tb_cuentacorriente_id`, `tb_tarjeta_id`, `tb_ventapago_numope`, `tb_ventapago_numdia`, `tb_ventapago_fecven`, `tb_venta_id`, `tb_empresa_id`) VALUES
(1, '2019-01-12 13:26:44', 1, 1, '2019-01-12', '30.00', 0, 0, '', 0, '0000-00-00', 1, 1),
(2, '2019-01-13 20:42:50', 1, 1, '2019-01-13', '50.00', 0, 0, '', 0, '0000-00-00', 6, 1),
(3, '2019-01-13 20:46:17', 1, 1, '2019-01-13', '20.00', 0, 0, '', 0, '0000-00-00', 7, 1),
(4, '2019-01-14 18:21:17', 1, 1, '2019-01-14', '23.00', 0, 0, '', 0, '0000-00-00', 8, 1),
(5, '2019-01-14 18:25:41', 1, 1, '2019-01-14', '32.00', 0, 0, '', 0, '0000-00-00', 9, 1),
(6, '2019-01-14 19:32:20', 1, 1, '2019-01-14', '45.00', 0, 0, '', 0, '0000-00-00', 14, 1),
(7, '2019-01-14 19:39:04', 1, 1, '2019-01-14', '50.00', 0, 0, '', 0, '0000-00-00', 15, 1),
(8, '2019-01-14 19:46:53', 1, 1, '2019-01-14', '45.00', 0, 0, '', 0, '0000-00-00', 16, 1),
(9, '2019-01-14 19:59:37', 1, 1, '2019-01-14', '25.00', 0, 0, '', 0, '0000-00-00', 17, 1),
(10, '2019-01-14 20:07:54', 1, 1, '2019-01-14', '50.00', 0, 0, '', 0, '0000-00-00', 18, 1),
(11, '2019-01-14 20:10:33', 1, 1, '2019-01-14', '50.00', 0, 0, '', 0, '0000-00-00', 19, 1),
(12, '2019-01-14 20:13:27', 1, 1, '2019-01-14', '40.00', 0, 0, '', 0, '0000-00-00', 20, 1),
(13, '2019-01-14 20:14:05', 1, 1, '2019-01-14', '10.00', 0, 0, '', 0, '0000-00-00', 21, 1),
(14, '2019-01-14 20:21:33', 1, 1, '2019-01-14', '25.00', 0, 0, '', 0, '0000-00-00', 22, 1),
(15, '2019-01-14 20:24:14', 1, 1, '2019-01-14', '52.00', 0, 0, '', 0, '0000-00-00', 23, 1),
(16, '2019-01-14 20:27:36', 1, 1, '2019-01-14', '40.00', 0, 0, '', 0, '0000-00-00', 24, 1),
(17, '2019-01-14 20:34:55', 1, 1, '2019-01-14', '40.00', 0, 0, '', 0, '0000-00-00', 25, 1),
(18, '2019-01-15 10:37:33', 1, 1, '2019-01-15', '22.00', 0, 0, '', 0, '0000-00-00', 26, 1),
(19, '2019-01-15 10:47:27', 1, 1, '2019-01-15', '24.00', 0, 0, '', 0, '0000-00-00', 27, 1),
(20, '2019-01-15 10:49:24', 1, 1, '2019-01-15', '40.00', 0, 0, '', 0, '0000-00-00', 28, 1),
(21, '2019-01-15 10:52:15', 1, 1, '2019-01-15', '34.00', 0, 0, '', 0, '0000-00-00', 29, 1),
(22, '2019-01-15 10:56:18', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 30, 1),
(23, '2019-01-14 11:12:48', 1, 1, '2019-01-14', '47.00', 0, 0, '', 0, '0000-00-00', 31, 1),
(24, '2019-01-14 11:13:30', 1, 1, '2019-01-14', '47.00', 0, 0, '', 0, '0000-00-00', 32, 1),
(25, '2019-01-14 11:14:48', 1, 1, '2019-01-14', '40.00', 0, 0, '', 0, '0000-00-00', 33, 1),
(26, '2019-01-14 11:17:55', 1, 1, '2019-01-14', '50.00', 0, 0, '', 0, '0000-00-00', 34, 1),
(27, '2019-01-15 11:21:55', 1, 1, '2019-01-15', '20.00', 0, 0, '', 0, '0000-00-00', 35, 1),
(28, '2019-01-15 11:23:39', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 36, 1),
(29, '2019-01-15 11:24:28', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 37, 1),
(30, '2019-01-15 11:26:31', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 38, 1),
(31, '2019-01-15 11:30:27', 1, 1, '2019-01-15', '34.00', 0, 0, '', 0, '0000-00-00', 39, 1),
(32, '2019-01-15 13:07:26', 1, 1, '2019-01-15', '22.00', 0, 0, '', 0, '0000-00-00', 40, 1),
(33, '2019-01-15 13:15:19', 1, 1, '2019-01-15', '33.00', 0, 0, '', 0, '0000-00-00', 41, 1),
(34, '2019-01-15 13:28:41', 1, 1, '2019-01-15', '33.00', 0, 0, '', 0, '0000-00-00', 42, 1),
(35, '2019-01-15 15:32:08', 1, 1, '2019-01-15', '22.00', 0, 0, '', 0, '0000-00-00', 43, 1),
(36, '2019-01-15 15:43:24', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 44, 1),
(37, '2019-01-15 15:59:23', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 45, 1),
(38, '2019-01-15 15:59:55', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 46, 1),
(39, '2019-01-15 16:00:10', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 47, 1),
(40, '2019-01-15 17:08:51', 1, 1, '2019-01-15', '23.00', 0, 0, '', 0, '0000-00-00', 48, 1),
(41, '2019-01-15 18:50:48', 1, 1, '2019-01-15', '45.00', 0, 0, '', 0, '0000-00-00', 49, 1),
(42, '2019-01-16 15:01:00', 1, 1, '2019-01-16', '22.00', 0, 0, '', 0, '0000-00-00', 50, 1),
(43, '2019-01-16 18:49:44', 1, 1, '2019-01-16', '33.00', 0, 0, '', 0, '0000-00-00', 51, 1),
(44, '2019-01-16 19:05:51', 1, 1, '2019-01-16', '54.00', 0, 0, '', 0, '0000-00-00', 52, 1),
(45, '2019-01-17 13:16:11', 1, 1, '2019-01-17', '10.00', 0, 0, '', 0, '0000-00-00', 53, 1),
(46, '2019-01-17 13:17:57', 1, 1, '2019-01-17', '10.00', 0, 0, '', 0, '0000-00-00', 54, 1),
(47, '2019-01-17 13:19:55', 1, 1, '2019-01-17', '10.00', 0, 0, '', 0, '0000-00-00', 55, 1),
(48, '2019-01-17 13:29:04', 1, 1, '2019-01-17', '10.00', 0, 0, '', 0, '0000-00-00', 56, 1),
(49, '2019-01-17 17:27:32', 1, 1, '2019-01-17', '20.00', 0, 0, '', 0, '0000-00-00', 57, 1),
(50, '2019-01-17 19:40:23', 1, 1, '2019-01-17', '40.00', 0, 0, '', 0, '0000-00-00', 58, 1),
(51, '2019-01-17 19:53:04', 1, 1, '2019-01-17', '40.00', 0, 0, '', 0, '0000-00-00', 59, 1),
(52, '2019-01-17 19:59:53', 1, 1, '2019-01-17', '106.20', 0, 0, '', 0, '0000-00-00', 60, 1),
(53, '2019-01-17 21:12:34', 1, 1, '2019-01-17', '30.00', 0, 0, '', 0, '0000-00-00', 61, 1),
(54, '2019-01-17 21:18:35', 1, 1, '2019-01-17', '60.00', 0, 0, '', 0, '0000-00-00', 62, 1),
(55, '2019-01-17 21:24:18', 1, 1, '2019-01-17', '45.00', 0, 0, '', 0, '0000-00-00', 63, 1),
(56, '2019-01-17 21:38:00', 1, 1, '2019-01-17', '180.00', 0, 0, '', 0, '0000-00-00', 64, 1),
(57, '2019-01-18 13:26:07', 1, 1, '2019-01-18', '34.00', 0, 0, '', 0, '0000-00-00', 65, 1),
(58, '2019-01-18 14:50:43', 1, 1, '2019-01-18', '22.00', 0, 0, '', 0, '0000-00-00', 66, 1),
(59, '2019-01-18 14:51:28', 1, 1, '2019-01-18', '22.00', 0, 0, '', 0, '0000-00-00', 67, 1),
(60, '2019-01-18 14:52:47', 1, 1, '2019-01-18', '58.00', 0, 0, '', 0, '0000-00-00', 68, 1),
(61, '2019-01-18 15:01:19', 1, 1, '2019-01-18', '22.00', 0, 0, '', 0, '0000-00-00', 69, 1),
(62, '2019-01-18 15:02:43', 1, 1, '2019-01-18', '22.00', 0, 0, '', 0, '0000-00-00', 70, 1),
(63, '2019-01-18 15:17:11', 1, 1, '2019-01-18', '20.00', 0, 0, '', 0, '0000-00-00', 71, 1),
(64, '2019-01-18 15:18:50', 1, 1, '2019-01-18', '30.00', 0, 0, '', 0, '0000-00-00', 72, 1),
(65, '2019-01-18 16:10:32', 1, 1, '2019-01-18', '23.00', 0, 0, '', 0, '0000-00-00', 73, 1),
(66, '2019-01-18 16:11:40', 1, 1, '2019-01-18', '23.00', 0, 0, '', 0, '0000-00-00', 74, 1),
(67, '2019-01-18 16:28:28', 1, 1, '2019-01-18', '33.00', 0, 0, '', 0, '0000-00-00', 75, 1),
(68, '2019-01-18 16:29:46', 1, 1, '2019-01-18', '43.00', 0, 0, '', 0, '0000-00-00', 76, 1),
(69, '2019-01-18 17:56:00', 1, 1, '2019-01-18', '33.00', 0, 0, '', 0, '0000-00-00', 77, 1),
(70, '2019-01-18 18:37:59', 1, 1, '2019-01-18', '33.00', 0, 0, '', 0, '0000-00-00', 78, 1),
(71, '2019-01-18 20:32:33', 1, 1, '2019-01-18', '33.00', 0, 0, '', 0, '0000-00-00', 79, 1),
(72, '2019-01-18 20:39:52', 1, 1, '2019-01-18', '36.00', 0, 0, '', 0, '0000-00-00', 80, 1),
(73, '2019-01-19 13:12:10', 1, 1, '2019-01-19', '25.00', 0, 0, '', 0, '0000-00-00', 81, 1),
(74, '2019-01-20 13:05:32', 1, 1, '2019-01-20', '25.00', 0, 0, '', 0, '0000-00-00', 82, 1),
(75, '2019-01-20 13:06:33', 1, 1, '2019-01-20', '25.00', 0, 0, '', 0, '0000-00-00', 83, 1),
(76, '2019-01-20 13:31:37', 1, 1, '2019-01-20', '25.00', 0, 0, '', 0, '0000-00-00', 84, 1),
(77, '2019-01-20 13:32:25', 1, 1, '2019-01-20', '3300.00', 0, 0, '', 0, '0000-00-00', 85, 1),
(78, '2019-01-20 13:35:41', 1, 1, '2019-01-20', '15.00', 0, 0, '', 0, '0000-00-00', 86, 1),
(79, '2019-01-20 13:39:28', 1, 1, '2019-01-20', '77.00', 0, 0, '', 0, '0000-00-00', 87, 1),
(80, '2019-01-20 13:43:42', 1, 1, '2019-01-20', '25.00', 0, 0, '', 0, '0000-00-00', 88, 1),
(81, '2019-01-20 13:46:39', 1, 1, '2019-01-20', '10.00', 0, 0, '', 0, '0000-00-00', 89, 1),
(82, '2019-01-20 21:41:01', 1, 1, '2019-01-20', '25.00', 0, 0, '', 0, '0000-00-00', 90, 1),
(83, '2019-01-22 16:13:43', 1, 1, '2019-01-22', '33.00', 0, 0, '', 0, '0000-00-00', 91, 1),
(84, '2019-01-22 16:14:02', 1, 1, '2019-01-22', '33.00', 0, 0, '', 0, '0000-00-00', 92, 1),
(85, '2019-01-22 16:14:27', 1, 1, '2019-01-22', '33.00', 0, 0, '', 0, '0000-00-00', 93, 1),
(86, '2019-01-22 16:16:40', 1, 1, '2019-01-22', '33.00', 0, 0, '', 0, '0000-00-00', 94, 1),
(87, '2019-01-22 16:21:58', 1, 1, '2019-01-22', '23.00', 0, 0, '', 0, '0000-00-00', 95, 1),
(88, '2019-01-22 16:32:06', 1, 1, '2019-01-22', '23.00', 0, 0, '', 0, '0000-00-00', 96, 1),
(89, '2019-01-22 21:33:46', 1, 1, '2019-01-22', '45.00', 0, 0, '', 0, '0000-00-00', 97, 1),
(90, '2019-01-22 21:34:21', 1, 1, '2019-01-22', '30.00', 0, 0, '', 0, '0000-00-00', 98, 1),
(91, '2019-01-22 21:34:58', 1, 1, '2019-01-22', '35.00', 0, 0, '', 0, '0000-00-00', 99, 1),
(92, '2019-01-23 11:06:35', 1, 1, '2019-01-23', '106.20', 0, 0, '', 0, '0000-00-00', 100, 1),
(93, '2019-01-23 11:09:53', 1, 1, '2019-01-23', '30.00', 0, 0, '', 0, '0000-00-00', 101, 1),
(94, '2019-01-23 11:10:45', 1, 1, '2019-01-23', '33.00', 0, 0, '', 0, '0000-00-00', 102, 1),
(95, '2019-01-26 16:35:44', 1, 1, '2019-01-26', '40.00', 0, 0, '', 0, '0000-00-00', 103, 1),
(96, '2019-01-26 16:41:57', 1, 1, '2019-01-26', '40.00', 0, 0, '', 0, '0000-00-00', 104, 1),
(97, '2019-01-26 16:49:01', 1, 1, '2019-01-26', '20.00', 0, 0, '', 0, '0000-00-00', 105, 1),
(98, '2019-01-26 16:50:42', 1, 1, '2019-01-26', '25.00', 0, 0, '', 0, '0000-00-00', 106, 1),
(99, '2019-01-26 16:51:47', 1, 1, '2019-01-26', '30.00', 0, 0, '', 0, '0000-00-00', 107, 1),
(100, '2019-01-26 17:06:16', 1, 1, '2019-01-26', '22.00', 0, 0, '', 0, '0000-00-00', 108, 1),
(101, '2019-01-30 15:48:03', 1, 1, '2019-01-30', '30.00', 0, 0, '', 0, '0000-00-00', 109, 1),
(102, '2019-01-30 15:49:50', 1, 1, '2019-01-30', '34.00', 0, 0, '', 0, '0000-00-00', 110, 1),
(103, '2019-01-30 15:53:21', 1, 1, '2019-01-30', '60.00', 0, 0, '', 0, '0000-00-00', 111, 1),
(104, '2019-01-30 16:34:42', 1, 1, '2019-01-30', '15.00', 0, 0, '', 0, '0000-00-00', 112, 1),
(105, '2019-01-30 16:45:04', 1, 1, '2019-01-30', '20.00', 0, 0, '', 0, '0000-00-00', 113, 1),
(106, '2019-01-30 17:12:39', 1, 1, '2019-01-30', '106.20', 0, 0, '', 0, '0000-00-00', 114, 1),
(107, '2019-01-30 19:46:08', 1, 1, '2019-01-30', '12.00', 0, 0, '', 0, '0000-00-00', 115, 1),
(108, '2019-01-30 19:54:18', 1, 1, '2019-01-30', '100.00', 0, 0, '', 0, '0000-00-00', 116, 1),
(109, '2019-01-30 20:50:48', 1, 1, '2019-01-30', '7.50', 0, 0, '', 0, '0000-00-00', 1, 1),
(110, '2019-01-30 21:19:24', 1, 1, '2019-01-30', '7.50', 0, 0, '', 0, '0000-00-00', 2, 1),
(111, '2019-01-30 21:26:12', 1, 1, '2019-01-30', '7.50', 0, 0, '', 0, '0000-00-00', 3, 1),
(112, '2019-01-31 15:45:54', 1, 1, '2019-01-31', '7.50', 0, 0, '', 0, '0000-00-00', 4, 1),
(113, '2019-01-31 16:24:18', 1, 1, '2019-01-31', '5.00', 0, 0, '', 0, '0000-00-00', 5, 1),
(114, '2019-01-31 16:27:28', 1, 1, '2019-01-31', '10.00', 0, 0, '', 0, '0000-00-00', 6, 1),
(115, '2019-01-31 16:55:34', 1, 1, '2019-01-31', '15.00', 0, 0, '', 0, '0000-00-00', 7, 1),
(116, '2019-01-31 17:18:45', 1, 1, '2019-01-31', '30.00', 0, 0, '', 0, '0000-00-00', 8, 1),
(117, '2019-01-31 18:24:24', 1, 1, '2019-01-31', '30.00', 0, 0, '', 0, '0000-00-00', 9, 1),
(118, '2019-02-20 10:53:12', 1, 1, '2019-02-20', '34.00', 0, 0, '', 0, '0000-00-00', 10, 1),
(119, '2019-02-20 10:53:34', 1, 1, '2019-02-20', '34.00', 0, 0, '', 0, '0000-00-00', 11, 1),
(120, '2019-06-10 21:37:35', 1, 1, '2019-06-10', '100.00', 0, 0, '', 0, '0000-00-00', 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_viajehorario`
--

CREATE TABLE `tb_viajehorario` (
  `tb_viajehorario_id` int(11) NOT NULL,
  `tb_viajehorario_salida` int(11) NOT NULL,
  `tb_viajehorario_llegada` int(11) NOT NULL,
  `tb_viajehorario_fecha` date NOT NULL,
  `tb_viajehorario_horario` time NOT NULL,
  `tb_vehiculo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tb_viajehorario`
--

INSERT INTO `tb_viajehorario` (`tb_viajehorario_id`, `tb_viajehorario_salida`, `tb_viajehorario_llegada`, `tb_viajehorario_fecha`, `tb_viajehorario_horario`, `tb_vehiculo_id`) VALUES
(13, 1, 2, '2019-01-20', '18:00:00', 1),
(14, 1, 3, '2019-01-20', '22:45:00', 5),
(15, 1, 3, '2019-01-21', '06:00:00', 2),
(16, 1, 3, '2019-01-21', '10:00:00', 3),
(17, 1, 2, '2019-01-21', '00:30:00', 3),
(18, 1, 4, '2019-01-21', '16:00:00', 1),
(19, 1, 4, '2019-01-21', '20:00:00', 4),
(20, 1, 3, '2019-01-21', '17:00:00', 1),
(21, 1, 4, '2019-01-22', '08:00:00', 2),
(22, 1, 3, '2019-01-23', '13:00:00', 1),
(23, 1, 2, '2019-01-23', '16:00:00', 1),
(24, 1, 3, '2019-01-21', '16:00:00', 3),
(25, 1, 3, '2019-01-26', '19:00:00', 2),
(26, 1, 2, '2019-01-31', '13:00:00', 2),
(27, 1, 3, '2019-04-05', '04:00:00', 1),
(28, 1, 3, '2019-01-27', '12:00:00', 1),
(29, 1, 4, '2019-01-21', '00:41:00', 3),
(30, 1, 3, '2019-01-21', '09:00:00', 2),
(31, 1, 3, '2019-01-22', '16:00:00', 1),
(32, 1, 2, '2019-01-23', '08:00:00', 3),
(33, 1, 3, '2019-01-27', '05:00:00', 2),
(34, 1, 2, '2019-01-31', '13:00:00', 3),
(35, 1, 4, '2019-01-26', '05:00:00', 2),
(36, 1, 3, '2019-01-31', '11:00:00', 3),
(37, 1, 2, '2019-02-14', '20:00:00', 1),
(38, 1, 4, '2019-02-20', '08:00:00', 1),
(39, 1, 2, '2019-06-10', '07:25:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_viajeventa`
--

CREATE TABLE `tb_viajeventa` (
  `tb_viajeventa_id` int(11) NOT NULL,
  `tb_venta_id` int(11) NOT NULL,
  `tb_viajehorario_id` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `tb_asiento_nom` int(11) NOT NULL,
  `tb_viajeventa_fecha` date NOT NULL,
  `tb_cliente_id` int(11) NOT NULL,
  `tb_viajeventa_parada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tb_viajeventa`
--

INSERT INTO `tb_viajeventa` (`tb_viajeventa_id`, `tb_venta_id`, `tb_viajehorario_id`, `tb_asiento_nom`, `tb_viajeventa_fecha`, `tb_cliente_id`, `tb_viajeventa_parada`) VALUES
(1, 9, '36', 3, '2019-01-31', 24, 0),
(2, 10, '38', 2, '2019-02-20', 1, 0),
(3, 11, '38', 6, '2019-02-20', 1, 0),
(4, 12, '', 30, '2019-07-10', 16, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `va_cliente`
--

CREATE TABLE `va_cliente` (
  `cliente_id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `dni` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `va_cliente`
--

INSERT INTO `va_cliente` (`cliente_id`, `nombre`, `dni`, `correo`) VALUES
(1, 'JHEOPN', '45513063', 'jheisonx@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `va_detalle`
--

CREATE TABLE `va_detalle` (
  `detalle_id` int(11) NOT NULL,
  `vale_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `codigo` char(4) COLLATE utf8_spanish_ci NOT NULL,
  `codigo2` char(14) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` tinyint(4) NOT NULL COMMENT '1 emitido, 2 atendido, 3 anulado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `va_detalle`
--

INSERT INTO `va_detalle` (`detalle_id`, `vale_id`, `cliente_id`, `codigo`, `codigo2`, `fecha`, `estado`) VALUES
(1, 1, 1, '1', '45513063010001', '2018-05-23 12:51:53', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `va_vale`
--

CREATE TABLE `va_vale` (
  `vale_id` int(11) NOT NULL,
  `registro` datetime NOT NULL,
  `titulo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `condiciones` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(4) NOT NULL COMMENT '1 monto , 2 porcentaje',
  `dato` decimal(6,2) NOT NULL,
  `estado_vale` tinyint(4) NOT NULL COMMENT '1 activo, 0 inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cs_codigopais`
--
ALTER TABLE `cs_codigopais`
  ADD PRIMARY KEY (`cs_codigopais_id`);

--
-- Indices de la tabla `cs_documentosrelacionados`
--
ALTER TABLE `cs_documentosrelacionados`
  ADD PRIMARY KEY (`cs_documentosrelacionados_id`);

--
-- Indices de la tabla `cs_elementosadicionales`
--
ALTER TABLE `cs_elementosadicionales`
  ADD PRIMARY KEY (`cs_elementosadicionales_id`);

--
-- Indices de la tabla `cs_modalidadtranslado`
--
ALTER TABLE `cs_modalidadtranslado`
  ADD PRIMARY KEY (`cs_modalidadtranslado_id`);

--
-- Indices de la tabla `cs_motivostranslado`
--
ALTER TABLE `cs_motivostranslado`
  ADD PRIMARY KEY (`cs_motivostranslado_id`);

--
-- Indices de la tabla `cs_otrosconceptos`
--
ALTER TABLE `cs_otrosconceptos`
  ADD PRIMARY KEY (`cs_otrosconceptos_id`);

--
-- Indices de la tabla `cs_resumendiario`
--
ALTER TABLE `cs_resumendiario`
  ADD PRIMARY KEY (`cs_resumendiario_id`);

--
-- Indices de la tabla `cs_resumendiarioboletas`
--
ALTER TABLE `cs_resumendiarioboletas`
  ADD PRIMARY KEY (`cs_resumendiarioboletas_id`);

--
-- Indices de la tabla `cs_tipoafectacionigv`
--
ALTER TABLE `cs_tipoafectacionigv`
  ADD PRIMARY KEY (`cs_tipoafectacionigv_id`);

--
-- Indices de la tabla `cs_tipodocumento`
--
ALTER TABLE `cs_tipodocumento`
  ADD PRIMARY KEY (`cs_tipodocumento_id`);

--
-- Indices de la tabla `cs_tipodocumentoidentidad`
--
ALTER TABLE `cs_tipodocumentoidentidad`
  ADD PRIMARY KEY (`cs_tipodocumentoidentidad_id`);

--
-- Indices de la tabla `cs_tipomoneda`
--
ALTER TABLE `cs_tipomoneda`
  ADD PRIMARY KEY (`cs_tipomoneda_id`);

--
-- Indices de la tabla `cs_tiponotacreditoelectronica`
--
ALTER TABLE `cs_tiponotacreditoelectronica`
  ADD PRIMARY KEY (`cs_tiponotacreditoelectronica_id`);

--
-- Indices de la tabla `cs_tiponotadedebitoelectronica`
--
ALTER TABLE `cs_tiponotadedebitoelectronica`
  ADD PRIMARY KEY (`cs_tiponotadedebitoelectronica_id`);

--
-- Indices de la tabla `cs_tipooperacion`
--
ALTER TABLE `cs_tipooperacion`
  ADD PRIMARY KEY (`cs_tipooperacion_id`);

--
-- Indices de la tabla `cs_tipoprecioventa`
--
ALTER TABLE `cs_tipoprecioventa`
  ADD PRIMARY KEY (`cs_tipoprecioventa_id`);

--
-- Indices de la tabla `cs_tiposistemacalculoisc`
--
ALTER TABLE `cs_tiposistemacalculoisc`
  ADD PRIMARY KEY (`cs_tiposistemacalculoisc_id`);

--
-- Indices de la tabla `cs_tipotributo`
--
ALTER TABLE `cs_tipotributo`
  ADD PRIMARY KEY (`cs_tipoatributo_id`);

--
-- Indices de la tabla `cs_tipounidadmedida`
--
ALTER TABLE `cs_tipounidadmedida`
  ADD PRIMARY KEY (`cs_tipounidadmedida_id`);

--
-- Indices de la tabla `cs_ubigeo`
--
ALTER TABLE `cs_ubigeo`
  ADD PRIMARY KEY (`tb_ubigeo_id`);

--
-- Indices de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  ADD PRIMARY KEY (`tb_almacen_id`);

--
-- Indices de la tabla `tb_asiento`
--
ALTER TABLE `tb_asiento`
  ADD PRIMARY KEY (`tb_asiento_id`);

--
-- Indices de la tabla `tb_asientoestado`
--
ALTER TABLE `tb_asientoestado`
  ADD PRIMARY KEY (`tb_asientoestado_id`);

--
-- Indices de la tabla `tb_caja`
--
ALTER TABLE `tb_caja`
  ADD PRIMARY KEY (`tb_caja_id`);

--
-- Indices de la tabla `tb_cajadetalle`
--
ALTER TABLE `tb_cajadetalle`
  ADD PRIMARY KEY (`tb_cajadetalle_id`);

--
-- Indices de la tabla `tb_cajaobs`
--
ALTER TABLE `tb_cajaobs`
  ADD PRIMARY KEY (`tb_cajaobs_id`);

--
-- Indices de la tabla `tb_caja_r`
--
ALTER TABLE `tb_caja_r`
  ADD PRIMARY KEY (`tb_caja_id`);

--
-- Indices de la tabla `tb_catalogo`
--
ALTER TABLE `tb_catalogo`
  ADD PRIMARY KEY (`tb_catalogo_id`);

--
-- Indices de la tabla `tb_catalogoimagen`
--
ALTER TABLE `tb_catalogoimagen`
  ADD PRIMARY KEY (`tb_catalogoimagen_id`);

--
-- Indices de la tabla `tb_catalogoimagendetalle`
--
ALTER TABLE `tb_catalogoimagendetalle`
  ADD PRIMARY KEY (`tb_catalogoimagendetalle_id`);

--
-- Indices de la tabla `tb_catalogoimagenfile`
--
ALTER TABLE `tb_catalogoimagenfile`
  ADD PRIMARY KEY (`tb_catalogoimagenfile_id`);

--
-- Indices de la tabla `tb_catalogo_cop21ene`
--
ALTER TABLE `tb_catalogo_cop21ene`
  ADD PRIMARY KEY (`tb_catalogo_id`);

--
-- Indices de la tabla `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`tb_categoria_id`);

--
-- Indices de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`tb_cliente_id`);

--
-- Indices de la tabla `tb_clientecuenta`
--
ALTER TABLE `tb_clientecuenta`
  ADD PRIMARY KEY (`tb_clientecuenta_id`);

--
-- Indices de la tabla `tb_clientedireccion`
--
ALTER TABLE `tb_clientedireccion`
  ADD PRIMARY KEY (`tb_clientedireccion_id`),
  ADD UNIQUE KEY `tb_clientedireccion_id` (`tb_clientedireccion_id`);

--
-- Indices de la tabla `tb_combaja`
--
ALTER TABLE `tb_combaja`
  ADD PRIMARY KEY (`tb_combaja_id`);

--
-- Indices de la tabla `tb_combajadetalle`
--
ALTER TABLE `tb_combajadetalle`
  ADD PRIMARY KEY (`tb_combajadetalle_id`);

--
-- Indices de la tabla `tb_compra`
--
ALTER TABLE `tb_compra`
  ADD PRIMARY KEY (`tb_compra_id`);

--
-- Indices de la tabla `tb_compracosto`
--
ALTER TABLE `tb_compracosto`
  ADD PRIMARY KEY (`tb_compracosto_id`);

--
-- Indices de la tabla `tb_compradetalle`
--
ALTER TABLE `tb_compradetalle`
  ADD PRIMARY KEY (`tb_compradetalle_id`);

--
-- Indices de la tabla `tb_compradetalle_lote`
--
ALTER TABLE `tb_compradetalle_lote`
  ADD PRIMARY KEY (`tb_compradetalle_lote_id`);

--
-- Indices de la tabla `tb_conductor`
--
ALTER TABLE `tb_conductor`
  ADD PRIMARY KEY (`tb_conductor_id`);

--
-- Indices de la tabla `tb_contingencia`
--
ALTER TABLE `tb_contingencia`
  ADD PRIMARY KEY (`tb_contingencia_id`);

--
-- Indices de la tabla `tb_costo`
--
ALTER TABLE `tb_costo`
  ADD PRIMARY KEY (`tb_catalogo_id`);

--
-- Indices de la tabla `tb_cotizacion`
--
ALTER TABLE `tb_cotizacion`
  ADD PRIMARY KEY (`tb_cotizacion_id`);

--
-- Indices de la tabla `tb_cotizaciondetalle`
--
ALTER TABLE `tb_cotizaciondetalle`
  ADD PRIMARY KEY (`tb_cotizaciondetalle_id`);

--
-- Indices de la tabla `tb_cuenta`
--
ALTER TABLE `tb_cuenta`
  ADD PRIMARY KEY (`tb_cuenta_id`);

--
-- Indices de la tabla `tb_cuentacorriente`
--
ALTER TABLE `tb_cuentacorriente`
  ADD PRIMARY KEY (`tb_cuentacorriente_id`),
  ADD KEY `tb_tarjeta_id` (`tb_cuentacorriente_id`);

--
-- Indices de la tabla `tb_cuenta_r`
--
ALTER TABLE `tb_cuenta_r`
  ADD PRIMARY KEY (`tb_cuenta_id`);

--
-- Indices de la tabla `tb_detallelistaprecio`
--
ALTER TABLE `tb_detallelistaprecio`
  ADD PRIMARY KEY (`tb_detallelistaprecio_id`);

--
-- Indices de la tabla `tb_direccion`
--
ALTER TABLE `tb_direccion`
  ADD PRIMARY KEY (`tb_direccion_id`);

--
-- Indices de la tabla `tb_distribucionasiento`
--
ALTER TABLE `tb_distribucionasiento`
  ADD PRIMARY KEY (`tb_distribucionasiento_id`);

--
-- Indices de la tabla `tb_documento`
--
ALTER TABLE `tb_documento`
  ADD PRIMARY KEY (`tb_documento_id`);

--
-- Indices de la tabla `tb_egreso`
--
ALTER TABLE `tb_egreso`
  ADD PRIMARY KEY (`tb_egreso_id`);

--
-- Indices de la tabla `tb_elemento`
--
ALTER TABLE `tb_elemento`
  ADD PRIMARY KEY (`tb_elemento_id`);

--
-- Indices de la tabla `tb_empresa`
--
ALTER TABLE `tb_empresa`
  ADD PRIMARY KEY (`tb_empresa_id`);

--
-- Indices de la tabla `tb_encarte`
--
ALTER TABLE `tb_encarte`
  ADD PRIMARY KEY (`tb_encarte_id`);

--
-- Indices de la tabla `tb_encartedetalle`
--
ALTER TABLE `tb_encartedetalle`
  ADD PRIMARY KEY (`tb_encartedetalle_id`);

--
-- Indices de la tabla `tb_encomiendaventa`
--
ALTER TABLE `tb_encomiendaventa`
  ADD PRIMARY KEY (`tb_encomiendaventa_id`);

--
-- Indices de la tabla `tb_entfinanciera`
--
ALTER TABLE `tb_entfinanciera`
  ADD PRIMARY KEY (`tb_entfinanciera_id`);

--
-- Indices de la tabla `tb_form`
--
ALTER TABLE `tb_form`
  ADD PRIMARY KEY (`tb_form_id`);

--
-- Indices de la tabla `tb_formapago`
--
ALTER TABLE `tb_formapago`
  ADD PRIMARY KEY (`tb_formapago_id`);

--
-- Indices de la tabla `tb_formula`
--
ALTER TABLE `tb_formula`
  ADD PRIMARY KEY (`tb_formula_id`);

--
-- Indices de la tabla `tb_gasto`
--
ALTER TABLE `tb_gasto`
  ADD PRIMARY KEY (`tb_gasto_id`);

--
-- Indices de la tabla `tb_gasto_r`
--
ALTER TABLE `tb_gasto_r`
  ADD PRIMARY KEY (`tb_gasto_id`);

--
-- Indices de la tabla `tb_guia`
--
ALTER TABLE `tb_guia`
  ADD PRIMARY KEY (`tb_guia_id`);

--
-- Indices de la tabla `tb_guiadetalle`
--
ALTER TABLE `tb_guiadetalle`
  ADD PRIMARY KEY (`tb_guiadetalle_id`);

--
-- Indices de la tabla `tb_guiapagonota`
--
ALTER TABLE `tb_guiapagonota`
  ADD PRIMARY KEY (`tb_guiapagonota_id`);

--
-- Indices de la tabla `tb_horario`
--
ALTER TABLE `tb_horario`
  ADD PRIMARY KEY (`tb_horario_id`);

--
-- Indices de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  ADD PRIMARY KEY (`tb_ingreso_id`);

--
-- Indices de la tabla `tb_ingreso_r`
--
ALTER TABLE `tb_ingreso_r`
  ADD PRIMARY KEY (`tb_ingreso_id`);

--
-- Indices de la tabla `tb_kardex`
--
ALTER TABLE `tb_kardex`
  ADD PRIMARY KEY (`tb_kardex_id`);

--
-- Indices de la tabla `tb_kardexdetalle`
--
ALTER TABLE `tb_kardexdetalle`
  ADD PRIMARY KEY (`tb_kardexdetalle_id`);

--
-- Indices de la tabla `tb_letras`
--
ALTER TABLE `tb_letras`
  ADD PRIMARY KEY (`tb_letras_id`);

--
-- Indices de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  ADD PRIMARY KEY (`tb_lote_id`);

--
-- Indices de la tabla `tb_lugar`
--
ALTER TABLE `tb_lugar`
  ADD PRIMARY KEY (`tb_lugar_id`);

--
-- Indices de la tabla `tb_marca`
--
ALTER TABLE `tb_marca`
  ADD PRIMARY KEY (`tb_marca_id`);

--
-- Indices de la tabla `tb_modopago`
--
ALTER TABLE `tb_modopago`
  ADD PRIMARY KEY (`tb_modopago_id`);

--
-- Indices de la tabla `tb_modulo`
--
ALTER TABLE `tb_modulo`
  ADD PRIMARY KEY (`tb_modulo_id`);

--
-- Indices de la tabla `tb_notacredito`
--
ALTER TABLE `tb_notacredito`
  ADD PRIMARY KEY (`tb_venta_id`);

--
-- Indices de la tabla `tb_notacreditocorreo`
--
ALTER TABLE `tb_notacreditocorreo`
  ADD PRIMARY KEY (`tb_ventacorreo_id`);

--
-- Indices de la tabla `tb_notacreditodetalle`
--
ALTER TABLE `tb_notacreditodetalle`
  ADD PRIMARY KEY (`tb_ventadetalle_id`);

--
-- Indices de la tabla `tb_notadebito`
--
ALTER TABLE `tb_notadebito`
  ADD PRIMARY KEY (`tb_venta_id`);

--
-- Indices de la tabla `tb_notadebitocorreo`
--
ALTER TABLE `tb_notadebitocorreo`
  ADD PRIMARY KEY (`tb_ventacorreo_id`);

--
-- Indices de la tabla `tb_notadebitodetalle`
--
ALTER TABLE `tb_notadebitodetalle`
  ADD PRIMARY KEY (`tb_ventadetalle_id`);

--
-- Indices de la tabla `tb_notalmacen`
--
ALTER TABLE `tb_notalmacen`
  ADD PRIMARY KEY (`tb_notalmacen_id`);

--
-- Indices de la tabla `tb_notalmacendetalle`
--
ALTER TABLE `tb_notalmacendetalle`
  ADD PRIMARY KEY (`tb_notalmacendetalle_id`);

--
-- Indices de la tabla `tb_precio`
--
ALTER TABLE `tb_precio`
  ADD PRIMARY KEY (`tb_precio_id`);

--
-- Indices de la tabla `tb_preciodetalle`
--
ALTER TABLE `tb_preciodetalle`
  ADD PRIMARY KEY (`tb_preciodetalle_id`);

--
-- Indices de la tabla `tb_presentacion`
--
ALTER TABLE `tb_presentacion`
  ADD PRIMARY KEY (`tb_presentacion_id`);

--
-- Indices de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  ADD PRIMARY KEY (`tb_producto_id`);

--
-- Indices de la tabla `tb_productoproveedor`
--
ALTER TABLE `tb_productoproveedor`
  ADD PRIMARY KEY (`tb_productoproveedor_id`);

--
-- Indices de la tabla `tb_proveedor`
--
ALTER TABLE `tb_proveedor`
  ADD PRIMARY KEY (`tb_proveedor_id`);

--
-- Indices de la tabla `tb_puntoventa`
--
ALTER TABLE `tb_puntoventa`
  ADD PRIMARY KEY (`tb_puntoventa_id`);

--
-- Indices de la tabla `tb_referencia`
--
ALTER TABLE `tb_referencia`
  ADD PRIMARY KEY (`tb_referencia_id`);

--
-- Indices de la tabla `tb_restabclave`
--
ALTER TABLE `tb_restabclave`
  ADD PRIMARY KEY (`tb_restabclave_id`);

--
-- Indices de la tabla `tb_resumenboleta`
--
ALTER TABLE `tb_resumenboleta`
  ADD PRIMARY KEY (`tb_resumenboleta_id`);

--
-- Indices de la tabla `tb_resumenboletadetalle`
--
ALTER TABLE `tb_resumenboletadetalle`
  ADD PRIMARY KEY (`tb_resumenboletadetalle_id`);

--
-- Indices de la tabla `tb_servicio`
--
ALTER TABLE `tb_servicio`
  ADD PRIMARY KEY (`tb_servicio_id`);

--
-- Indices de la tabla `tb_soporte`
--
ALTER TABLE `tb_soporte`
  ADD PRIMARY KEY (`tb_soporte_id`);

--
-- Indices de la tabla `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`tb_stock_id`);

--
-- Indices de la tabla `tb_subcuenta`
--
ALTER TABLE `tb_subcuenta`
  ADD PRIMARY KEY (`tb_subcuenta_id`);

--
-- Indices de la tabla `tb_subcuenta_r`
--
ALTER TABLE `tb_subcuenta_r`
  ADD PRIMARY KEY (`tb_subcuenta_id`);

--
-- Indices de la tabla `tb_tag`
--
ALTER TABLE `tb_tag`
  ADD PRIMARY KEY (`tb_tag_id`);

--
-- Indices de la tabla `tb_talonario`
--
ALTER TABLE `tb_talonario`
  ADD PRIMARY KEY (`tb_talonario_id`);

--
-- Indices de la tabla `tb_talonariointerno`
--
ALTER TABLE `tb_talonariointerno`
  ADD PRIMARY KEY (`tb_talonario_id`);

--
-- Indices de la tabla `tb_talonarionc`
--
ALTER TABLE `tb_talonarionc`
  ADD PRIMARY KEY (`tb_talonario_id`);

--
-- Indices de la tabla `tb_talonariond`
--
ALTER TABLE `tb_talonariond`
  ADD PRIMARY KEY (`tb_talonario_id`);

--
-- Indices de la tabla `tb_tarjeta`
--
ALTER TABLE `tb_tarjeta`
  ADD PRIMARY KEY (`tb_tarjeta_id`),
  ADD KEY `tb_tarjeta_id` (`tb_tarjeta_id`);

--
-- Indices de la tabla `tb_telefono`
--
ALTER TABLE `tb_telefono`
  ADD PRIMARY KEY (`tb_telefono_id`);

--
-- Indices de la tabla `tb_tipocambio`
--
ALTER TABLE `tb_tipocambio`
  ADD PRIMARY KEY (`tb_tipocambio_id`);

--
-- Indices de la tabla `tb_tipoperacion`
--
ALTER TABLE `tb_tipoperacion`
  ADD PRIMARY KEY (`tb_tipoperacion_id`);

--
-- Indices de la tabla `tb_transferencia`
--
ALTER TABLE `tb_transferencia`
  ADD PRIMARY KEY (`tb_transferencia_id`);

--
-- Indices de la tabla `tb_transferencia_r`
--
ALTER TABLE `tb_transferencia_r`
  ADD PRIMARY KEY (`tb_transferencia_id`);

--
-- Indices de la tabla `tb_transporte`
--
ALTER TABLE `tb_transporte`
  ADD PRIMARY KEY (`tb_transporte_id`);

--
-- Indices de la tabla `tb_traspaso`
--
ALTER TABLE `tb_traspaso`
  ADD PRIMARY KEY (`tb_traspaso_id`);

--
-- Indices de la tabla `tb_traspasodetalle`
--
ALTER TABLE `tb_traspasodetalle`
  ADD PRIMARY KEY (`tb_traspasodetalle_id`);

--
-- Indices de la tabla `tb_ubigeo`
--
ALTER TABLE `tb_ubigeo`
  ADD PRIMARY KEY (`tb_ubigeo_id`);

--
-- Indices de la tabla `tb_unidad`
--
ALTER TABLE `tb_unidad`
  ADD PRIMARY KEY (`tb_unidad_id`);

--
-- Indices de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`tb_usuario_id`);

--
-- Indices de la tabla `tb_usuariodetalle`
--
ALTER TABLE `tb_usuariodetalle`
  ADD PRIMARY KEY (`tb_usuario_id`);

--
-- Indices de la tabla `tb_usuariogrupo`
--
ALTER TABLE `tb_usuariogrupo`
  ADD PRIMARY KEY (`tb_usuariogrupo_id`);

--
-- Indices de la tabla `tb_usuariopv`
--
ALTER TABLE `tb_usuariopv`
  ADD PRIMARY KEY (`tb_usuariopv_id`);

--
-- Indices de la tabla `tb_vehiculo`
--
ALTER TABLE `tb_vehiculo`
  ADD PRIMARY KEY (`tb_vehiculo_id`);

--
-- Indices de la tabla `tb_venta`
--
ALTER TABLE `tb_venta`
  ADD PRIMARY KEY (`tb_venta_id`);

--
-- Indices de la tabla `tb_ventacanje`
--
ALTER TABLE `tb_ventacanje`
  ADD PRIMARY KEY (`tb_ventacanje_id`);

--
-- Indices de la tabla `tb_ventacorreo`
--
ALTER TABLE `tb_ventacorreo`
  ADD PRIMARY KEY (`tb_ventacorreo_id`);

--
-- Indices de la tabla `tb_ventadetalle`
--
ALTER TABLE `tb_ventadetalle`
  ADD PRIMARY KEY (`tb_ventadetalle_id`);

--
-- Indices de la tabla `tb_ventadetalle_lote`
--
ALTER TABLE `tb_ventadetalle_lote`
  ADD PRIMARY KEY (`tb_ventadetalle_lote_id`);

--
-- Indices de la tabla `tb_ventanota`
--
ALTER TABLE `tb_ventanota`
  ADD PRIMARY KEY (`tb_venta_id`);

--
-- Indices de la tabla `tb_ventanotadetalle`
--
ALTER TABLE `tb_ventanotadetalle`
  ADD PRIMARY KEY (`tb_ventadetalle_id`);

--
-- Indices de la tabla `tb_ventanotapago`
--
ALTER TABLE `tb_ventanotapago`
  ADD PRIMARY KEY (`tb_ventanotapago_id`);

--
-- Indices de la tabla `tb_ventapago`
--
ALTER TABLE `tb_ventapago`
  ADD PRIMARY KEY (`tb_ventapago_id`);

--
-- Indices de la tabla `tb_viajehorario`
--
ALTER TABLE `tb_viajehorario`
  ADD PRIMARY KEY (`tb_viajehorario_id`);

--
-- Indices de la tabla `tb_viajeventa`
--
ALTER TABLE `tb_viajeventa`
  ADD PRIMARY KEY (`tb_viajeventa_id`);

--
-- Indices de la tabla `va_cliente`
--
ALTER TABLE `va_cliente`
  ADD PRIMARY KEY (`cliente_id`),
  ADD UNIQUE KEY `dni` (`dni`,`correo`);

--
-- Indices de la tabla `va_detalle`
--
ALTER TABLE `va_detalle`
  ADD PRIMARY KEY (`detalle_id`);

--
-- Indices de la tabla `va_vale`
--
ALTER TABLE `va_vale`
  ADD PRIMARY KEY (`vale_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cs_codigopais`
--
ALTER TABLE `cs_codigopais`
  MODIFY `cs_codigopais_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cs_documentosrelacionados`
--
ALTER TABLE `cs_documentosrelacionados`
  MODIFY `cs_documentosrelacionados_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cs_elementosadicionales`
--
ALTER TABLE `cs_elementosadicionales`
  MODIFY `cs_elementosadicionales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cs_modalidadtranslado`
--
ALTER TABLE `cs_modalidadtranslado`
  MODIFY `cs_modalidadtranslado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cs_motivostranslado`
--
ALTER TABLE `cs_motivostranslado`
  MODIFY `cs_motivostranslado_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cs_otrosconceptos`
--
ALTER TABLE `cs_otrosconceptos`
  MODIFY `cs_otrosconceptos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cs_resumendiario`
--
ALTER TABLE `cs_resumendiario`
  MODIFY `cs_resumendiario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cs_resumendiarioboletas`
--
ALTER TABLE `cs_resumendiarioboletas`
  MODIFY `cs_resumendiarioboletas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cs_tipoafectacionigv`
--
ALTER TABLE `cs_tipoafectacionigv`
  MODIFY `cs_tipoafectacionigv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cs_tipodocumento`
--
ALTER TABLE `cs_tipodocumento`
  MODIFY `cs_tipodocumento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cs_tipodocumentoidentidad`
--
ALTER TABLE `cs_tipodocumentoidentidad`
  MODIFY `cs_tipodocumentoidentidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cs_tipomoneda`
--
ALTER TABLE `cs_tipomoneda`
  MODIFY `cs_tipomoneda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cs_tiponotacreditoelectronica`
--
ALTER TABLE `cs_tiponotacreditoelectronica`
  MODIFY `cs_tiponotacreditoelectronica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cs_tiponotadedebitoelectronica`
--
ALTER TABLE `cs_tiponotadedebitoelectronica`
  MODIFY `cs_tiponotadedebitoelectronica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cs_tipooperacion`
--
ALTER TABLE `cs_tipooperacion`
  MODIFY `cs_tipooperacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cs_tipoprecioventa`
--
ALTER TABLE `cs_tipoprecioventa`
  MODIFY `cs_tipoprecioventa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cs_tiposistemacalculoisc`
--
ALTER TABLE `cs_tiposistemacalculoisc`
  MODIFY `cs_tiposistemacalculoisc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cs_tipotributo`
--
ALTER TABLE `cs_tipotributo`
  MODIFY `cs_tipoatributo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cs_tipounidadmedida`
--
ALTER TABLE `cs_tipounidadmedida`
  MODIFY `cs_tipounidadmedida_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cs_ubigeo`
--
ALTER TABLE `cs_ubigeo`
  MODIFY `tb_ubigeo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2055;

--
-- AUTO_INCREMENT de la tabla `tb_almacen`
--
ALTER TABLE `tb_almacen`
  MODIFY `tb_almacen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_asiento`
--
ALTER TABLE `tb_asiento`
  MODIFY `tb_asiento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `tb_asientoestado`
--
ALTER TABLE `tb_asientoestado`
  MODIFY `tb_asientoestado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `tb_caja`
--
ALTER TABLE `tb_caja`
  MODIFY `tb_caja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_cajadetalle`
--
ALTER TABLE `tb_cajadetalle`
  MODIFY `tb_cajadetalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_cajaobs`
--
ALTER TABLE `tb_cajaobs`
  MODIFY `tb_cajaobs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_caja_r`
--
ALTER TABLE `tb_caja_r`
  MODIFY `tb_caja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_catalogo`
--
ALTER TABLE `tb_catalogo`
  MODIFY `tb_catalogo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT de la tabla `tb_catalogoimagen`
--
ALTER TABLE `tb_catalogoimagen`
  MODIFY `tb_catalogoimagen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_catalogoimagendetalle`
--
ALTER TABLE `tb_catalogoimagendetalle`
  MODIFY `tb_catalogoimagendetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_catalogoimagenfile`
--
ALTER TABLE `tb_catalogoimagenfile`
  MODIFY `tb_catalogoimagenfile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_catalogo_cop21ene`
--
ALTER TABLE `tb_catalogo_cop21ene`
  MODIFY `tb_catalogo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `tb_categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `tb_cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tb_clientecuenta`
--
ALTER TABLE `tb_clientecuenta`
  MODIFY `tb_clientecuenta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `tb_clientedireccion`
--
ALTER TABLE `tb_clientedireccion`
  MODIFY `tb_clientedireccion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_combaja`
--
ALTER TABLE `tb_combaja`
  MODIFY `tb_combaja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_combajadetalle`
--
ALTER TABLE `tb_combajadetalle`
  MODIFY `tb_combajadetalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_compra`
--
ALTER TABLE `tb_compra`
  MODIFY `tb_compra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_compracosto`
--
ALTER TABLE `tb_compracosto`
  MODIFY `tb_compracosto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `tb_compradetalle`
--
ALTER TABLE `tb_compradetalle`
  MODIFY `tb_compradetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_compradetalle_lote`
--
ALTER TABLE `tb_compradetalle_lote`
  MODIFY `tb_compradetalle_lote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT de la tabla `tb_conductor`
--
ALTER TABLE `tb_conductor`
  MODIFY `tb_conductor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_contingencia`
--
ALTER TABLE `tb_contingencia`
  MODIFY `tb_contingencia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_costo`
--
ALTER TABLE `tb_costo`
  MODIFY `tb_catalogo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_cotizacion`
--
ALTER TABLE `tb_cotizacion`
  MODIFY `tb_cotizacion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_cotizaciondetalle`
--
ALTER TABLE `tb_cotizaciondetalle`
  MODIFY `tb_cotizaciondetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_cuenta`
--
ALTER TABLE `tb_cuenta`
  MODIFY `tb_cuenta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `tb_cuentacorriente`
--
ALTER TABLE `tb_cuentacorriente`
  MODIFY `tb_cuentacorriente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_cuenta_r`
--
ALTER TABLE `tb_cuenta_r`
  MODIFY `tb_cuenta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_detallelistaprecio`
--
ALTER TABLE `tb_detallelistaprecio`
  MODIFY `tb_detallelistaprecio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_direccion`
--
ALTER TABLE `tb_direccion`
  MODIFY `tb_direccion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_distribucionasiento`
--
ALTER TABLE `tb_distribucionasiento`
  MODIFY `tb_distribucionasiento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tb_documento`
--
ALTER TABLE `tb_documento`
  MODIFY `tb_documento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tb_egreso`
--
ALTER TABLE `tb_egreso`
  MODIFY `tb_egreso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_elemento`
--
ALTER TABLE `tb_elemento`
  MODIFY `tb_elemento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_empresa`
--
ALTER TABLE `tb_empresa`
  MODIFY `tb_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_encarte`
--
ALTER TABLE `tb_encarte`
  MODIFY `tb_encarte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_encartedetalle`
--
ALTER TABLE `tb_encartedetalle`
  MODIFY `tb_encartedetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_encomiendaventa`
--
ALTER TABLE `tb_encomiendaventa`
  MODIFY `tb_encomiendaventa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tb_entfinanciera`
--
ALTER TABLE `tb_entfinanciera`
  MODIFY `tb_entfinanciera_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_form`
--
ALTER TABLE `tb_form`
  MODIFY `tb_form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_formapago`
--
ALTER TABLE `tb_formapago`
  MODIFY `tb_formapago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_formula`
--
ALTER TABLE `tb_formula`
  MODIFY `tb_formula_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_gasto`
--
ALTER TABLE `tb_gasto`
  MODIFY `tb_gasto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_gasto_r`
--
ALTER TABLE `tb_gasto_r`
  MODIFY `tb_gasto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_guia`
--
ALTER TABLE `tb_guia`
  MODIFY `tb_guia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_guiadetalle`
--
ALTER TABLE `tb_guiadetalle`
  MODIFY `tb_guiadetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_guiapagonota`
--
ALTER TABLE `tb_guiapagonota`
  MODIFY `tb_guiapagonota_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_horario`
--
ALTER TABLE `tb_horario`
  MODIFY `tb_horario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso`
--
ALTER TABLE `tb_ingreso`
  MODIFY `tb_ingreso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `tb_ingreso_r`
--
ALTER TABLE `tb_ingreso_r`
  MODIFY `tb_ingreso_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_kardex`
--
ALTER TABLE `tb_kardex`
  MODIFY `tb_kardex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `tb_kardexdetalle`
--
ALTER TABLE `tb_kardexdetalle`
  MODIFY `tb_kardexdetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_letras`
--
ALTER TABLE `tb_letras`
  MODIFY `tb_letras_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_lote`
--
ALTER TABLE `tb_lote`
  MODIFY `tb_lote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_lugar`
--
ALTER TABLE `tb_lugar`
  MODIFY `tb_lugar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_marca`
--
ALTER TABLE `tb_marca`
  MODIFY `tb_marca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_modopago`
--
ALTER TABLE `tb_modopago`
  MODIFY `tb_modopago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_modulo`
--
ALTER TABLE `tb_modulo`
  MODIFY `tb_modulo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tb_notacredito`
--
ALTER TABLE `tb_notacredito`
  MODIFY `tb_venta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notacreditocorreo`
--
ALTER TABLE `tb_notacreditocorreo`
  MODIFY `tb_ventacorreo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notacreditodetalle`
--
ALTER TABLE `tb_notacreditodetalle`
  MODIFY `tb_ventadetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notadebito`
--
ALTER TABLE `tb_notadebito`
  MODIFY `tb_venta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notadebitocorreo`
--
ALTER TABLE `tb_notadebitocorreo`
  MODIFY `tb_ventacorreo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notadebitodetalle`
--
ALTER TABLE `tb_notadebitodetalle`
  MODIFY `tb_ventadetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notalmacen`
--
ALTER TABLE `tb_notalmacen`
  MODIFY `tb_notalmacen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_notalmacendetalle`
--
ALTER TABLE `tb_notalmacendetalle`
  MODIFY `tb_notalmacendetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_precio`
--
ALTER TABLE `tb_precio`
  MODIFY `tb_precio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tb_preciodetalle`
--
ALTER TABLE `tb_preciodetalle`
  MODIFY `tb_preciodetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_presentacion`
--
ALTER TABLE `tb_presentacion`
  MODIFY `tb_presentacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=564;

--
-- AUTO_INCREMENT de la tabla `tb_producto`
--
ALTER TABLE `tb_producto`
  MODIFY `tb_producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=564;

--
-- AUTO_INCREMENT de la tabla `tb_productoproveedor`
--
ALTER TABLE `tb_productoproveedor`
  MODIFY `tb_productoproveedor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_proveedor`
--
ALTER TABLE `tb_proveedor`
  MODIFY `tb_proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_puntoventa`
--
ALTER TABLE `tb_puntoventa`
  MODIFY `tb_puntoventa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_referencia`
--
ALTER TABLE `tb_referencia`
  MODIFY `tb_referencia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_restabclave`
--
ALTER TABLE `tb_restabclave`
  MODIFY `tb_restabclave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_resumenboleta`
--
ALTER TABLE `tb_resumenboleta`
  MODIFY `tb_resumenboleta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_resumenboletadetalle`
--
ALTER TABLE `tb_resumenboletadetalle`
  MODIFY `tb_resumenboletadetalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tb_servicio`
--
ALTER TABLE `tb_servicio`
  MODIFY `tb_servicio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_soporte`
--
ALTER TABLE `tb_soporte`
  MODIFY `tb_soporte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `tb_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_subcuenta`
--
ALTER TABLE `tb_subcuenta`
  MODIFY `tb_subcuenta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_subcuenta_r`
--
ALTER TABLE `tb_subcuenta_r`
  MODIFY `tb_subcuenta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_tag`
--
ALTER TABLE `tb_tag`
  MODIFY `tb_tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_talonario`
--
ALTER TABLE `tb_talonario`
  MODIFY `tb_talonario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tb_talonariointerno`
--
ALTER TABLE `tb_talonariointerno`
  MODIFY `tb_talonario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tb_talonarionc`
--
ALTER TABLE `tb_talonarionc`
  MODIFY `tb_talonario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tb_talonariond`
--
ALTER TABLE `tb_talonariond`
  MODIFY `tb_talonario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_tarjeta`
--
ALTER TABLE `tb_tarjeta`
  MODIFY `tb_tarjeta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_telefono`
--
ALTER TABLE `tb_telefono`
  MODIFY `tb_telefono_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_tipocambio`
--
ALTER TABLE `tb_tipocambio`
  MODIFY `tb_tipocambio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_tipoperacion`
--
ALTER TABLE `tb_tipoperacion`
  MODIFY `tb_tipoperacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tb_transferencia`
--
ALTER TABLE `tb_transferencia`
  MODIFY `tb_transferencia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_transferencia_r`
--
ALTER TABLE `tb_transferencia_r`
  MODIFY `tb_transferencia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_transporte`
--
ALTER TABLE `tb_transporte`
  MODIFY `tb_transporte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_traspaso`
--
ALTER TABLE `tb_traspaso`
  MODIFY `tb_traspaso_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_traspasodetalle`
--
ALTER TABLE `tb_traspasodetalle`
  MODIFY `tb_traspasodetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ubigeo`
--
ALTER TABLE `tb_ubigeo`
  MODIFY `tb_ubigeo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2055;

--
-- AUTO_INCREMENT de la tabla `tb_unidad`
--
ALTER TABLE `tb_unidad`
  MODIFY `tb_unidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `tb_usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tb_usuariodetalle`
--
ALTER TABLE `tb_usuariodetalle`
  MODIFY `tb_usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tb_usuariogrupo`
--
ALTER TABLE `tb_usuariogrupo`
  MODIFY `tb_usuariogrupo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tb_usuariopv`
--
ALTER TABLE `tb_usuariopv`
  MODIFY `tb_usuariopv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tb_vehiculo`
--
ALTER TABLE `tb_vehiculo`
  MODIFY `tb_vehiculo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_venta`
--
ALTER TABLE `tb_venta`
  MODIFY `tb_venta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_ventacanje`
--
ALTER TABLE `tb_ventacanje`
  MODIFY `tb_ventacanje_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ventacorreo`
--
ALTER TABLE `tb_ventacorreo`
  MODIFY `tb_ventacorreo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ventadetalle`
--
ALTER TABLE `tb_ventadetalle`
  MODIFY `tb_ventadetalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tb_ventadetalle_lote`
--
ALTER TABLE `tb_ventadetalle_lote`
  MODIFY `tb_ventadetalle_lote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `tb_ventanota`
--
ALTER TABLE `tb_ventanota`
  MODIFY `tb_venta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ventanotadetalle`
--
ALTER TABLE `tb_ventanotadetalle`
  MODIFY `tb_ventadetalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ventanotapago`
--
ALTER TABLE `tb_ventanotapago`
  MODIFY `tb_ventanotapago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_ventapago`
--
ALTER TABLE `tb_ventapago`
  MODIFY `tb_ventapago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `tb_viajehorario`
--
ALTER TABLE `tb_viajehorario`
  MODIFY `tb_viajehorario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tb_viajeventa`
--
ALTER TABLE `tb_viajeventa`
  MODIFY `tb_viajeventa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `va_cliente`
--
ALTER TABLE `va_cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `va_detalle`
--
ALTER TABLE `va_detalle`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `va_vale`
--
ALTER TABLE `va_vale`
  MODIFY `vale_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
