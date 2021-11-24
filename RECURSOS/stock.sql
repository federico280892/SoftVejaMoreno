-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2021 a las 01:40:36
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stockveja`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `id_grupo` int(100) NOT NULL,
  `id_rubro` int(100) NOT NULL,
  `codigo_barra` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_costo` varchar(100) NOT NULL,
  `n_lote` varchar(100) NOT NULL,
  `vencimiento` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `stockMin` varchar(50) NOT NULL,
  `observaciones` varchar(100) NOT NULL,
  `activo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `id_grupo`, `id_rubro`, `codigo_barra`, `nombre`, `precio_costo`, `n_lote`, `vencimiento`, `marca`, `img`, `stockMin`, `observaciones`, `activo`) VALUES
(1, 2, 2, '132', 'LENTE 1', '500.00', '158', '2025-09-16', 'FOCUS', 'default_product.jpg', '15', '', 1),
(2, 2, 2, '258', 'LENTE 2', '620.00', '25', '2025-03-14', 'FOCUSPRO', 'default_product.jpg', '15', 'SDF', 1),
(3, 4, 1, '235', 'GUANTE 1', '30.00', '', '', '', 'default_product.jpg', '10', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantidades_cargadas`
--

CREATE TABLE `cantidades_cargadas` (
  `id` int(255) NOT NULL,
  `id_comprobante` int(255) NOT NULL,
  `id_articulo` int(255) NOT NULL,
  `cantidad_cargada` int(100) NOT NULL,
  `fecha_comprobante` varchar(100) NOT NULL,
  `fecha_carga` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cantidades_cargadas`
--

INSERT INTO `cantidades_cargadas` (`id`, `id_comprobante`, `id_articulo`, `cantidad_cargada`, `fecha_comprobante`, `fecha_carga`) VALUES
(1, 1, 3, 10, '2021-05-11', '12-05-2021 00:53:39'),
(2, 1, 1, 30, '2021-05-11', '12-05-2021 00:53:39'),
(3, 1, 2, 15, '2021-05-11', '12-05-2021 00:53:39'),
(4, 2, 3, 25, '2021-05-11', '12-05-2021 00:54:31'),
(5, 3, 3, 6, '2021-05-11', '12-05-2021 00:55:12'),
(6, 3, 1, 1, '2021-05-11', '12-05-2021 00:55:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` int(255) NOT NULL,
  `tipo_comprobante` int(10) NOT NULL,
  `n_comprobante` varchar(50) NOT NULL,
  `importe` varchar(100) NOT NULL,
  `proveedor` varchar(10) NOT NULL,
  `fecha_comprobante` varchar(100) NOT NULL,
  `fecha_carga` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id`, `tipo_comprobante`, `n_comprobante`, `importe`, `proveedor`, `fecha_comprobante`, `fecha_carga`, `usuario`) VALUES
(1, 0, '0000-00000000', '25800', '10', '2021-05-11', '12-05-2021 00:53:39', '1'),
(2, 0, '0000-00000000', '750', '10', '2021-05-11', '12-05-2021 00:54:30', '1'),
(3, 3, 'USO', '680', '-', '2021-05-11', '12-05-2021 00:55:12', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencias`
--

CREATE TABLE `existencias` (
  `id` int(11) NOT NULL,
  `id_articulo` int(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `existencias`
--

INSERT INTO `existencias` (`id`, `id_articulo`, `cantidad`) VALUES
(1, 1, '29'),
(2, 2, '15'),
(3, 3, '29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `rubro` int(10) NOT NULL,
  `observaciones` varchar(100) NOT NULL,
  `activo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`, `descripcion`, `rubro`, `observaciones`, `activo`) VALUES
(1, 'GENERAL - DESCARTABLES', '', 3, '-', 1),
(2, 'GENERAL - INSUMOS QX', '', 3, '-', 1),
(3, 'AGUJAS', '', 3, '-', 1),
(4, 'GUANTES', '', 3, '-', 1),
(5, 'JERINGAS', '', 3, '-', 1),
(6, 'LENTE ESTANDAR', 'EYEOL', 1, '-', 1),
(7, 'LENTE PREMIUM', 'PREMIUM', 1, '-', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `CUIT_CUIL` varchar(100) NOT NULL,
  `domicilio` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `CBU` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `observacion` varchar(100) NOT NULL,
  `activo` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `razon_social`, `CUIT_CUIL`, `domicilio`, `telefono`, `celular`, `CBU`, `alias`, `banco`, `mail`, `observacion`, `activo`) VALUES
(1, '7DF - PEÑA GALVAN EZEQUIEL', '', '20-29911908-5', '', '', '', '0170341040000030482092', '', '11', 'contacto@sietedefebrero.com', '', 1),
(2, 'AGÜERO ANDREA - Alq. Jachal', '', '27-29707418-6', '', '', '', '0450500602800050157431', '', '1', 'anyi_aguero@hotmail.com', '', 1),
(3, 'AGUSTINA - LIMPIEZA', 'RESPONSABLE MONOTRIBUTO', '27-43952052-9', '', '', '', '0450500602800068061531', '', '14', 'agustinaaromero2018@gmail.com', '', 1),
(4, 'ALCON Lab. Arg. S.A.', '', '30-51684266-7', '', '', '', '0720086120000000228486', '', '9', 'patricia.cuartas_cardenas@alcon.com', '', 1),
(5, 'ALMAZAN ABALLAY FERNANDO DANIEL ', '', '23-34921176-9', '', '', '', '0110259030025912419451', 'COMIDA.PIOLA.COLLAR', '10', 'almazanfernandodaniel@gmail.com', '', 1),
(6, 'ANDINA S.A. - DIONICIO GONZALEZ', '', '30-70737824-3', '', '', '', '2990108910800048120004', '', '2', 'maciasalicia240@gmail.com', '', 1),
(7, 'ANDRE MASY S.A.', '', '30-71414857-1', '', '', '', '0070041220000015649975', '', '12', 'laura.santiso@andremasy.com', '', 1),
(8, 'ARCE ALCIDES ANTONIO', '', '20-25252215-9', '', '', '', '0000013000003226274402', '', '3', '', '', 1),
(9, 'ARIEL ORTEGA - Cartuchos', '', '20-25319544-5', '', '', '', '0450500602800059355973', '', '1', 'pepecortez72@yahoo.com', '', 1),
(10, 'ARIEL VIDAL', '', '20-26510225-6', '', '', '', '0170072540000050379183', '', '11', 'arielevidal@gmail.com', '', 1),
(11, 'ARJONA SILVANA', '', '27-30932862-6', '', '', '', '0450020901800030634896', 'PRISMA.FUTBOL.LUPA', '1', '', '', 1),
(12, 'ASAAR - Asoc de Anestesia ', '', '30-67329964-0', '', '', '', '0070112520000031960339', '', '12', 'asjdeanestesiologia@speedy.com.ar', '', 1),
(13, 'ASISTEL - Montes Diego Salvador', '', '20-21876701-0', '', '', '', '0450500601800020945829', '', '1', 'conectateasistel@gmail.com', '', 1),
(14, 'ATELIER - Jara Gonzalez Martin', '', '20-32351162-5', '', '', '', '2850410440095243926978', '', '4', 'ateliersif@hotmail.com', '', 1),
(15, 'ATSA - San Juan', '', '30-51987563-9', '', '', '', '0450500601800012654630', '', '1', 'atsasajuan@hotmail.com', '', 1),
(16, 'Axs Solutions SAS', '', '33-71591751-9 ', '', '', '', '0450500602800058929999', '', '1', 'info@axssolutions.com.ar', '', 1),
(17, 'BARRAZA RAUL GUSTAVO', '', '20-35938384-4', '', '', '', '0000003100064118943684', '', '5', 'r.saldivar32@yahoo.com', '', 1),
(18, 'BIO ASIST S.A.', '', '30-70786557-8', '', '', '', '0150810702000100962312', '', '16', 'info@bioasist.com.ar', '', 1),
(19, 'BIO MAT INST. SRL', '', '30-70827872-2', '', '', '', '0070021420000005064724', '', '12', 'cobranzas@biomat.com.ar', '', 1),
(20, 'BOETTI JOSE ANTONIO - Toner', '', '20-32033820-5', '', '', '', '0720179630000038364001', '', '9', 'jaboetti@gmail.com', '', 1),
(21, 'BUSTOS ORDUÑA, MANUEL DAVID', '', '20-35506789-1', '', '', '', '0000003100086311005417', 'cruza.bigas.ataja.mp', '5', 'gestionescam@yahoo.com.ar', '', 1),
(22, 'CAMPAYO JUAN MANUEL', '', '20-23763365-3', '', '', '', '0070213530004001442785', '', '12', 'camjua@gmail.com', '', 1),
(23, 'CAO - Dr. JM', '', '30-65432871-0', '', '', '', '2850506030006321102011', 'ANANA.PASCUA.MORADO', '4', 'agustin.protas@oftalmologos.org.ar', '', 1),
(24, 'CASA VIGO - J.C. Giugni', '', '20-07936039-3', '', '', '', '0450500601800020392847', '', '1', 'casavigovidrios@hotmail.com', '', 1),
(25, 'CASALE JULIA CRISTINA', '', '27-18077823-9', '', '', '', '0070165130004009719588', '', '12', 'barbijosanticovidconicet@gmail.com', '', 1),
(26, 'CASAS LUCAS - VITRECTOS', ' ', '20-26453731-3', '', '', '', '0720064988000013949268', 'GALERA.FAJA.ALFIL', '9', 'drlucascasas@gmail.com', '', 1),
(27, 'CASTRO ARTURO HORACIO', '', '20-17923538-3', '', '', '', '0450018601800086496909', '', '1', 'acastrosund@yahoo.com.ar', '', 1),
(28, 'CASTRO DANIEL', '', '20-22011750-3', '', '', '', '0450500602800070067011', 'DUPLA.MEDIA.CARNE', '1', 'dcastro.riv@hotmail.com', '', 1),
(29, 'CASTRO JESICA CELINA', '', '27-16550919-1', '', '', '', '0450002501800082362727', '', '1', 'cjesicacelina@gmail.com', '', 1),
(30, 'CENTRO OPTICO CASIN S.A.', '', '30-64539856-0', '', '', '', '0170468020000000029706', '', '11', '', '', 1),
(31, 'CERDERA CINTHIA MARISEL - Viandas', '', '27-32446986-4', '', '', '', '0150810702000104369751', '', '16', 'gerardosotomayor01@gmail.com', '', 1),
(32, 'CERRAJERIA HERMES - Roberto Gonzalez', '', '20-13107084-6', '', '', '', '0070112530004160525956', '', '12', '', '', 1),
(33, 'CIR MEDICA S.R.L.', '', '33-71081402-9', '', '', '', '0720217120000000228240', '', '9', 'hugolan@cirmedica.com', '', 1),
(34, 'CLANPA S.A.', '', '30-71546988-6', '', '', '', '0170471020000000088792', '', '11', 'leonardo.pantano1@gmail.com', '', 1),
(35, 'CLINORD SOCIEDAD ANONIMA ', '', '30-69189070-4', '', '', '', '0720707720000000343954', '', '9', 'anadelatorre@gmail.com', '', 1),
(36, 'CPCE - Arancel Balance', '', '30-56277896-5', '', '', '', '0720707720000000166586', '', '', 'rcarabajal@cpcesj.org.ar', '', 1),
(37, 'CRISTINA ARRIETA ', '', '', '', '', '', '', '', '', 'mcarrieta_53@hotmail.com', '', 1),
(38, 'DESTER ARGENTINA SA', '', '30-70747084-0', '', '', '', '0150836702000102382495', '', '16', 'anitamatar2@gmail.com', '', 1),
(39, 'DISTRIBUIDORA ALCALDE - Impresión Lentes', '', '27-36252602-2', '', '', '', '0720179688000038442904', 'sellosalcalde', '9', 'administracion@distalcalde.com.ar', '', 1),
(40, 'DOMINGUEZ, DIEGO', '', '20-29327032-6', '', '', '', '0070112530004182848747', '', '12', 'diego.domin2013@gmail.com', '', 1),
(41, 'DRA. MUÑOZ STELLA', '', '27-12664905-9', '', '', '', '0070112530004169590867', '', '12', 'stellamarismunoz12@gmail.con', '', 1),
(42, 'DROGUERIA DEL OESTE S.R.L.', '', '30-70805174-4', '', '', '', '1910063655006301629050', '', '14', 'ivanaroitmanav@gmail.com', '', 1),
(43, 'DROGUERIA INTEGRAL', '', '27-17011615-7', '', '', '', '0150810702000101786908', '', '16', 'drogueriaintegralsj@speedy.com.ar', '', 1),
(44, 'El Triunfo Seguros', '', '30-50006577-6', '', '', '', '0270066310000218790064', '', '6', 'leonardosolimano@gmail.com', '', 1),
(45, 'EL VINILO - DECORACIONES', '', '20-31442224-5', '', '', '', '0000003100191210107479', '', '11', 'elvinilo.decoraciones@gmail.com', '', 1),
(46, 'ELENA PUY', '', '27-28005134-4', '', '', '', '0170381640000000547336', '', '1', 'puyelena04@Gmail.com', '', 1),
(47, 'ELIANA FERNANDEZ', '', '27-34054111-7', '', '', '', '0450500602800055949031', '', '', 'elufern_13@hotmail.com', '', 1),
(48, 'ENERGIA SAN JUAN S.A.', '', '30-68168854-0', '', '', '', '', '', '9', '', '', 1),
(49, 'ESTEBAN TEMOLI - Cadeteria', '', '20-25166915-6', '', '', '', '0720567588000035353836', '', '9', 'estebanlute@hotmail.com', '', 1),
(50, 'Etam - Camisas Secretarias ', '', '30-70748987-8', '', '', '', '0720511820000000017822', '', '9', 'sanjuan@etam.com.ar', '', 1),
(51, 'Farmacia Colón S.R.L.', '', '30-53261098-9', '', '', '', '0720760220000000031772', 'Petit1779', '16', 'laboratorio@farmaciacolon.com.ar', '', 1),
(52, 'Farmacia del Senado - Farmacia Pozos 77 S.C.S.', '', '33-64469364-9', 'Estética', '', '', '0150501602000019847779', '', '10', 'delsenado77@gmail.com', '', 1),
(53, 'FARMACIA LOS ANGELES SRL', '', '30-70833202-6', '', '', '', '0720179620000001970218', 'METRO.MENTA.PATO', '9', 'farmlosangeles@live.com.ar', '', 1),
(54, 'FERNANDEZ, Josefina Dra.', '', '27-35318892-0', '', '', '', '0110474930047436585247', '', '10', 'mjosefinafd@gmail.com', '', 1),
(55, 'FERRUFINO MAIRA', '', '27-34054320-9', '', '', '', '0720507188000035414436', '', '4', 'mferrufino@hotmail.com', '', 1),
(56, 'FERVID SRL - Dragomen', '', '30-70703988-0', '', '', '', '2850410430000000010323', '', '12', 'dragomen@hotmail.com', '', 1),
(57, 'FORNES Noelia Dra.', '', '23-32689533-4', '', '', '', '0070213530004005393706', 'ISLOTE.CARTEL.ORDEN', '1', 'noealefornes@gmail.com', '', 1),
(58, 'FRANCISCO MONTES S.A.C.I.F.', '', '30-50012729-1', '', '', '', '0450500601800001133737', '', '9', '', '', 1),
(59, 'G Y C Insumos Médicos ', '', '20-23453924-9', '', '', '', '0720179688000038544372', '', '12', 'g.c.insumosmedicos@gmail.com', '', 1),
(60, 'GALLARDO ANDRES DR.', '', '20-22958911-4', '', '', '', '0070112530004148707882', '', '1', 'andresalbertogallardo@gmail.com', '', 1),
(61, 'GARAY ADOLFO JOSE', '', '20-08327199-0', '', '', '', '0450002501800082043277', '', '', 'pamegaray18@gmail.com', '', 1),
(62, 'GASTROSOLUCIONES SRL', '', '30-71242165-3', '', '', '', '0070112520000036650066', 'gastrosolucionessrl', '1', 'telloeduardo00@hotmail.com', '', 1),
(63, 'GIMENEZ ESTELA JOSEFINA', '', '27-32929679-8', '', '', '', '0450500602800098022331', '', '12', '', '', 1),
(64, 'GIMENO ERNESTO AGUSTIN', '', '30-58449976-8', '', '', '', '0070225820000000007913', '', '9', '', '', 1),
(65, 'GOMEZ FEDERICO L.', '', '20-23616103-0', '', '', '', '0720507188000035471990', 'PASTEL.ABEDUL.NUCLEO', '11', '', '', 1),
(66, 'Gonzalez Estefania Luciana', '', '27-28146146-5', '', '', '', '0170066440000032544730', '', '9', 'ventas@burletescentro.com.ar', '', 1),
(67, 'HALFING - Juan Pablo Bruschi', '', '20-29331158-8', '', '', '', '0720281288000036765618', 'halfing', '12', '', '', 1),
(68, 'IMPLANTEC S.A.', '', '30-70701602-3', '', '', '', '0070154520000004034975', '', '1', 'cobranzas@implantecinsumos.com', '', 1),
(69, 'INSTITUTO DE NARIZ GARGANTA Y OIDO SRL', '', '33-62890407-9', '', '', '', '0450500601800020956915', '', '12', 'csanchezvallecillo@gmail.com', '', 1),
(70, 'ISKOWITZ Instrumental SRL', '', '33-71026075-9', '', '', '', '0070022120000004867157', '', '12', 'cobranzas@iisrl.com.ar', '', 1),
(71, 'ITURRIETA, MARIA PAULA Dra', '', '27-27548123-3', '', '', '', '0070112530004176748828', '', '11', 'paulaitu@hotmail.com', '', 1),
(72, 'IVANA VILLEGAS (PEÑA SERGIO A.)', '', '23-23977324-9', '', '', '', '0170072540000045899779', 'MELON.SODA.OGRO', '10', 'ivana.villegas81@gmail.com', '', 1),
(73, 'JERARQUICOS SALUD', '', ' 33-71018560-9', '', '', '', '0110491620049100941783', '', '11', 'fiscalizaciones@jerarquicos.com', '', 1),
(74, 'JERONIMO LOPEZ ', '', '20-26095641-9', '', '', '', '0170381640000000195672', '', '11', '', '', 1),
(75, 'JOFRE DANTE FCO. - Farmacia CURIER', '', '20-12069686-7', '', '', '', '1910063655006301518028', '', '9', '', '', 1),
(76, 'KADI RODRIGUEZ JORGE GUIDO', '', '23-21610037-9', '', '', '', '0720179688000038280854', '', '9', 'graficacentral13@gmail.com', '', 1),
(77, 'LA PLATENSE SA', '', '30-50369689-0', '', '', '', '0720179620000001820636', '', '9', 'clientes@laplatensesa.com.ar', '', 1),
(78, 'LA REINA DEL TEPEYAC SRL', '', '30-71467777-9', '', '', '', '2990108910800118760002', '', '9', 'lorenaveracontadores@gmail.com', '', 1),
(79, 'LH INSTRUMENTAL SRL', '', '30-70787897-1', '', '', '', '0720196320000000145772', '', '9', 'facturacion@lhinstrumental.com.ar', '', 1),
(80, 'LOHN, Carlota Dra.', '', '27-17052076-4', '', '', '', '0720179688000023660340', '', '12', 'dralohn@gmail.com', '', 1),
(81, 'LOPEZ CARLOS ALBERTO', '', '20-21485774-0', '', '', '', '0070112530004173074601', 'solucionesnash', '9', 'calopez@solucionesnash.com.ar', '', 1),
(82, 'LUVION - Silvina Maschio', '', '27-24111866-0', '', '', '', '0720265288000036813454', '', '9', '', '', 1),
(83, 'MALAISI VICTOR H.', '', '20-07944473-2', '', '', '', '0720707788000035375872', 'MELON.MUELLE.METRO', '12', 'alejandrorubino@live.com.ar', '', 1),
(84, 'MARQUEZ, MARINA Dra', '', '27-36423201-8', '', '', '', '0070213530004002906893', '', '9', 'marquezmarinaalejandra@gmail.com', '', 1),
(85, 'MARTIN GUSTAVO - CRISA', '', '20-23058180-1', '', '', '', '0720567520000000099154', '', '11', 'crisa@crisa-protege.com', '', 1),
(86, 'MAT SRL - La Salmuera', '', '30-70925678-1', '', '', '', '0170471020000000069410', '', '', '', '', 1),
(87, 'MEDITEX - PICCOLI GABRIELA', '', '27-25144617-8', '', '', '', '0170193320000000234119', '', '1', 'meditex.argentina@gmail.com', '', 1),
(88, 'MERCEDARIO TELE SRL', '', '30-59774202-5', '', '', '', '0450500601800004313941', 'BUFALO.CONEJO.BIGOTE', '1', 'ricardo13588@hotmail.com', '', 1),
(89, 'Miras Javier Alejandro', '', '20-32033785-3', '', '', '', '0450018601800097464087', '', '10', 'javiermiras@gmail.com', '', 1),
(90, 'MOLINA MONICA PATRICIA', '', '27-35505967-2', '', '', '', '0110474930047441143865', '', '1', 'aldi_suarez@hotmail.com', '', 1),
(91, 'MORALES, Gemma Dra.', '', '27-36423428-2', '', '', '', '0450020901800054922038', '', '6', 'moralesgemma@hotmail.com.ar', '', 1),
(92, 'MUÑOZ PABLO', '', '20-42163947-8', '', '', '', '0000003100025433660681', '', '', 'munozemanuel992@gmail.com', '', 1),
(93, 'MURO EDGARDO', '', '23-22063253-9', '', '', '', '', '', '11', 'muroedgardo00@gmail.com', '', 1),
(94, 'NOBLE CIA DE SEGURO SA', '', '30-70812715-5', '', '', '', '0170342720000030219739', '', '4', 'cobranzas@nobleseguros.com', '', 1),
(95, 'OFCOR SRL', '', '30-64425320-8', '', '', '', '2850350740094636322708', '', '9', 'ofcorsrl@gmail.com', '', 1),
(96, 'OFPAK SA', '', '33-71027839-9', '', '', '', '0720068720000001768422', '', '12', 'ofpaksa@gmail.com', '', 1),
(97, 'OMAR NEDAWAR', '', '20-21016688-3', '', '', '', '0070112530004171509705', '', '14', 'medawaromar@hotmail.com', '', 1),
(98, 'ON NUTRIVE - Robledo Marcela Ines', '', '27-28005963-9', '', '', '', '1910063655006300895432', '', '14', 'viandas@onnutrive.com.ar', '', 1),
(99, 'ORBILENT S.R.L.', '', '30-70746084-5', '', '', '', '0070103320000031305657', '', '10', 'info@orbilent.com.ar', '', 1),
(100, 'ORDENEZ MARIA BELEN - Estudios', '', '27-34920027-4', '', '', '', '0110474930047443780815', '', '10', 'mariabelen.ordenez@gmail.com', '', 1),
(101, 'OSECAC - Delegación San Juan', '', '30-55027355-8', '', '', '', '0110474920047411525618', '', '9', 'roxanabeatriz1974@hotmail.com', '', 1),
(102, 'OXAPHARMA S.A.', '', '30-54187298-8', '', '', '', '0720454220000000445322', 'URANO.RAMA.ABEJA', '12', 'lourdes.seguy@oxapharma.com', '', 1),
(103, 'PAÑERO EMILIO Dr.', '', '20-32808466-0', '', '', '', '0070213530004005388014', '', '15', 'emilioepk87@gmail.com', '', 1),
(104, 'PAPELERIA SALOMON - Salomon Jason SA', '', '30-67328909-2', '', '', '', '1500676100067632057446', '', '9', 'adrianaballay17@gmail.com', '', 1),
(105, 'PAULA TERZI', '', '23-33759515-4', '', '', '', '0720707788000035427290', '', '12', 'paulystl@hotmail.com', '', 1),
(106, 'PERSEO SRL', '', '33-70955894-9', '', '', '', '0070112520000033000499', '', '9', 'admgral@sion.com', '', 1),
(107, 'POTENCIA SAS', '', '30-71658544-8', '', '', '', '0720567520000000019422', '', '14', 'federicomolina@busst.co', '', 1),
(108, 'PRUDENCIA SEGUROS - ACLISA', '', '30-58442807-0', '', '', '', '1910063655006300313464', '', '7', 'josegimbernat@aclisa.com.ar', '', 1),
(109, 'PUIGGROS MARIA FLORENCIA', '', '27-27042213-1', '', '', '', '0450500602800066548773', '', '1', 'florenciap27@gmail.com', '', 1),
(110, 'RIERA MARIA DANIELA \"Popi\"', '', '27-26678672-2', '', '', '', '0450500602800068034865', '', '9', 'popiriera@yahoo.com', '', 1),
(111, 'RIVEROS RODOLFO ( Honorarios Dra. Marquez )', '', '20-20302453-4', '', '', '', '0720179688000036647554', 'FORO.RETINA.TIENTO', '13', 'marquezmarinaalejandra@gmail.com', '', 1),
(112, 'RODRIGUEZ HNOS TRANS. S.A.', '', '30-71215569-4', '', '', '', '0270066310026195420017', '', '11', 'distribucionsj@rht.com.ar', '', 1),
(113, 'RODRIGUEZ MARIA DANIELA', '', '27-29108605-0', '', '', '', '0110474930047438006979', 'danielarodriguezph', '12', '', '', 1),
(114, 'RODRIGUEZ RITA M.', '', '27-28262816-9', '', '', '', '0070112530004157630577', '', '9', 'paoyamilavidal_@hotmail.com', '', 1),
(115, 'ROMERA JOSE MARIA', '', '20-24518266-0', '', '', '', '0720026788000036229536', '', '12', 'info@byrproducciones.com.ar', '', 1),
(116, 'RUBIÑO ALEJANDRO', '', '20-25938579-3', '', '', '', '0170381640000000597768', '', '10', 'alejandrorubino@live.com.ar', '', 1),
(117, 'RUIZ JOSE GUILLERMO', '', '20-10940659-8', '', '', '', '0110474920047413261662', '', '9', '', '', 1),
(118, 'SANTIAGO VEJA', '', '20-33147067-9', '', '', '', '0720179688000038919754', '', '9', 'santiago.veja@gmail.com', '', 1),
(119, 'SANTILLAN OLIVERA - Electricista', '', '20-33045891-8', '', '', '', '2850410440094959599898', '', '12', 'giordanojulian0@gmail.com', '', 1),
(120, 'SDMI SAS', '', '30-71621552-7', '', '', '', '0070112520000039024640', '', '1', 'electronicabios@gmail.com', '', 1),
(121, 'SEAyDS - Sec de Ambiente', '', '30-99901516-2', '', '', '', '0450018601800000179341', '', '14', 'emanuelstrambach@gmail.com', '', 1),
(122, 'SEMEBI SRL', '', '30-71205124-4', '', '', '', '1910063655006300485082', '', '11', 'serviciosemebi@gmail.com', '', 1),
(123, 'SERVICIOS EMPRESARIOS S.A.', '', '30-70893133-7', '', '', '', '0170471020000000050474', '', '1', 'ecruz@eficienciaempresaria.com', '', 1),
(124, 'SILVA VANINA PAOLA - Viandas', '', '27-28570792-2', '', '', '', '0450500601800091831553', '', '11', 'cafeypausa@gmail.com', '', 1),
(125, 'SIM - Serv de Limpieza', '', '30-70850371-8', '', '', '', '0170072520000032258479', '', '14', 'recepcionsim@simsanjuan.com', '', 1),
(126, 'SMI - Area Protegida', '', '30-70818302-0', '', '', '', '1910063655006301739782', '', '4', 'cobranzas@smisanjuan.com.ar', '', 1),
(127, 'SOLUCIONES DESCARTABLES', '', '23-32689441-9', '', '', '', '2850410440094910446498', '', '9', 'rodriguezorland27@gmail.com', '', 1),
(128, 'SPINER CLAUDIO NORBERTO', '', '20-16225174-1', '', '', '', '0720480188000035211518', '', '1', 'dialza@gmail.com', '', 1),
(129, 'STRAMBACH MAURO - Perfect Vision', '', '20-32653109-0', '', '', '', '0450500602800056867299', '', '13', 'emanuelstrambach@gmail.com', '', 1),
(130, 'TeCMA San Juan SA', '', '30-69190333-4', '', '', '', '0270091510002935130011', '', '14', 'contable@tecmasanjuan.com.ar', '', 1),
(131, 'Todo Medica San Juan SA', '', '30-70076327-3', '', '', '', '1910063655006301059150', '', '1', 'todomedicasanjuan@gmail.com', '', 1),
(132, 'TORRES BUSTAMANTE FEDERICO - KOKY', '', '23-35507751-9', '', '', '', '0450020902800060238890', '', '14', 'kokytorressonido@gmail.com', '', 1),
(133, 'TV ABIERTA LRJ 518 - CANAL 4', '', '30-70805189-2', '', '', '', '0270091510005804390013', '', '13', '', '', 1),
(134, 'UNO MEDIOS S.A. Canal 8', '', '30-70896122-8', '', '', '', '1910115855011500216196', 'Tienen un poder de J. Estornell ', '1', 'garcia.joseluis@canal8sanjuan.com.ar', '', 1),
(135, 'VAREA ADRIANA V. - Ayudante Quirófano', '', '23-29832027-4', '', '', '', '0450500601800003077529', '', '12', 'adrianavarea@gmail.com', '', 1),
(136, 'VEJA MORENO Juan R. - Alquiler', '', '20-07936312-0', '', '', '', '0070112530004159787615', '', '17', 'jrvejamoreno@gmail.com', '', 1),
(137, 'VELEZ JOSE - Factura pendiente', '', '20-25252215-9', '', '', '', '0000013000003226274402', '', '8', '', '', 1),
(138, 'VIDABLE SEBASTIAN - PC HARDWARE', '', '20-29557749-6', '', '', '', '0340210000210011892008', '', '16', 'pchard.gerencia@gmail.com', '', 1),
(139, 'VILLARROEL MARTIN - Perfect Vision ', '', '20-37517093-1', '', '', '', '0150810701000124230261', '', '4', 'martinvillarroel639@gmail.com', '', 1),
(140, 'Vision 2000 Medica SA - Gamma Vision', '', '30-71106724-4', '', '', '', '2850329330094082148281', '', '10', 'cobranzas@gammavision.com.ar', '', 1),
(141, 'VSA ALTA COMPLEJIDAD S.A.', '', '30-70820479-6', '', '', '', '0110077820007700132525', '', '14', 'info@vsa-ac.com.ar', '', 1),
(142, 'ZANPER SA', '', '30-71439888-8', '', '', '', '1910113455011300786400', '', '12', 'ventas@zanper.com.ar', '', 1),
(143, 'ZARATE DIEGO ALEJANDRO', '', '20-21951657-7', '', '', '', '0720747388000035848590', '', '10', 'dialza@gmail.com', '', 1),
(144, 'ZERDÁ, Ailen Dra. ', '', '23-33621781-4', '', '', '', '0110474930047438812547', '', '14', 'ailenzerda@hotmail.com.ar', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon_social`
--

CREATE TABLE `razon_social` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `razon_social`
--

INSERT INTO `razon_social` (`id`, `nombre`) VALUES
(1, 'IVA Responsable Inscripto'),
(2, 'IVA Sujeto Exento'),
(3, 'Consumidor Final'),
(4, 'Responsable Monotributo'),
(5, 'Monotributista Social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE `rubros` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `dioptria` int(10) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `activo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`id`, `nombre`, `dioptria`, `observacion`, `activo`) VALUES
(1, 'ESTETICA', 0, '', 1),
(2, 'LENTES', 1, 'LENTES INTRAOCULARES', 1),
(3, 'DESCARTABLES', 0, '', 1),
(4, 'MEDICACION', 0, '', 1),
(5, 'INSUMOS QX', 0, 'INSUMOS QUIROFANO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(255) NOT NULL,
  `id_articulo` int(255) NOT NULL,
  `id_comprobante` int(255) NOT NULL,
  `fecha_carga` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `id_articulo`, `id_comprobante`, `fecha_carga`) VALUES
(1, 3, 1, '12-05-2021 00:53:39'),
(2, 1, 1, '12-05-2021 00:53:39'),
(3, 2, 1, '12-05-2021 00:53:39'),
(4, 3, 2, '12-05-2021 00:54:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_conectados`
--

CREATE TABLE `usuarios_conectados` (
  `id` int(255) NOT NULL,
  `id_usuario` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cantidades_cargadas`
--
ALTER TABLE `cantidades_cargadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `existencias`
--
ALTER TABLE `existencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_conectados`
--
ALTER TABLE `usuarios_conectados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cantidades_cargadas`
--
ALTER TABLE `cantidades_cargadas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `existencias`
--
ALTER TABLE `existencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `razon_social`
--
ALTER TABLE `razon_social`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios_conectados`
--
ALTER TABLE `usuarios_conectados`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
