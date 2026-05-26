-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 03:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u24611400_tripistry`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `Accommodation_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price_PN` decimal(10,2) NOT NULL CHECK (`Price_PN` > 0),
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`Accommodation_ID`, `Name`, `Type`, `Price_PN`, `Image`) VALUES
(1, 'Sea Point Hotel', 'Hotel', 1500.00, 'https://images.com/seapoint.jpg'),
(2, 'Kruger River Lodge', 'Lodge', 3500.00, 'https://images.com/krugerlodge.jpg'),
(3, 'Knysna Guesthouse', 'Guesthouse', 1200.00, 'https://images.com/knysna.jpg'),
(24, 'Granpanorama-Hotel Stephanshof', 'HotelPension', 3913.00, ''),
(25, '10- Bettzimmer im Restaurant Sternen', 'Apartment', 4162.00, 'https://media-v2.discover.swiss/rawmedia/ctd/8705a5326c050244a82e16e30f6b9c8c7ac93e85_9cea1a6d_5876_4e78_9355_8b0aec925087.jpeg'),
(26, '1100 APARTMENT', 'BedBreakfast', 4329.00, ''),
(27, '1477 Reichhalter', 'BedBreakfast', 2681.00, ''),
(28, '164 apt.', 'BedBreakfast', 947.00, 'https://images.pexels.com/photos/17168885/pexels-photo-17168885.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(29, '22 Summits Apartments', 'Apartment', 2653.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010416503159/TDS00020010000158950/TDS00020015218339065.jpg'),
(30, '22 Summits Boutique Hotel', 'HotelPension', 1670.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020011844279793/TDS00020010000158950/TDS00020015648757944.jpg'),
(31, '25hours Hotel Langstrasse', 'HotelPension', 1981.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_25hours_langstrasse_29434.jpg'),
(32, '25hours Hotel Zürich West', 'HotelPension', 4579.00, 'https://www.zuerich.com/sites/default/files/nethotel-images/490006770_14_de65df00-3976-41f3-a14e-59acb30a410e.jpg'),
(33, '3100 Kulmhotel Gornergrat', 'HotelPension', 4900.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010414902255/TDS00020010000158950/TDS00020012517725978.jpg'),
(34, '360 Grad - Bundeswehr Sozialwerk', 'HotelPension', 4886.00, ''),
(35, '5 Apartments', 'BedBreakfast', 3309.00, ''),
(36, '63 Riverside Apartments Basel', 'Notdefined', 1503.00, ''),
(37, '6532 Smart Hotel', 'HotelPension', 1053.00, 'https://media-v2.discover.swiss/rawmedia/hs/00112206_96fd0b66f9bb1db82a830ed05a2bd15d_m.jpg'),
(38, '7132 Glenner', 'HotelPension', 2593.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/798bd6ac-1dda-4ee5-9b1b-1df1d7ec015e.jpg'),
(39, '7132 Hotel', 'HotelPension', 1263.00, ''),
(40, '7132 House of Architects', 'HotelPension', 733.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/8f4d10e2-6277-49c4-af10-52ea41792d8f.jpg'),
(41, '7 Heavens', 'Notdefined', 3758.00, ''),
(42, '9HOTEL PAQUIS', 'HotelPension', 3752.00, 'https://media-v2.discover.swiss/rawmedia/hs/00078709_m.jpg'),
(43, 'A1 Grauholz Hotel Restaurant', 'HotelPension', 2067.00, 'https://media-v2.discover.swiss/rawmedia/hs/00063877_m.jpg'),
(44, 'A & A Apartments Resort', 'BedBreakfast', 3504.00, ''),
(45, 'aarau-WEST Swiss Quality Hotel', 'HotelPension', 4142.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/66d1c2b9-23cf-42ac-a596-6251accc306b.jpg'),
(46, 'Aare Lodge Attisholz Swiss Quality Hotel', 'Notdefined', 3012.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/e00e1028-a2b8-46d6-a059-d9a1c3147040.jpg'),
(47, 'ABC Swiss Quality Hotel', 'HotelPension', 1744.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010350470090/TDS00020010000158950/TDS00020015282616324.jpg'),
(48, 'Abenteuer Turm', 'Apartment', 3775.00, 'https://media-v2.discover.swiss/rawmedia/ctd/831e92ec4e83d9d0fb548c636332fd50bcfe21fc_TDS00020011261282182_sized_800_0.jpg'),
(49, 'Aberle Hof', 'Farm', 4017.00, ''),
(50, 'ABINEA Dolomiti Romantic SPA Hotel', 'HotelPension', 4805.00, ''),
(51, 'abis Dolomites', 'HotelPension', 1524.00, ''),
(52, 'Abrahamhof', 'Farm', 4412.00, ''),
(53, 'a casa di andrea', 'BedBreakfast', 1802.00, ''),
(54, 'A Casa di Cato', 'BedBreakfast', 1938.00, 'https://images.pexels.com/photos/18695266/pexels-photo-18695266.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(55, 'A CASA LUXURY STAY', 'BedBreakfast', 3038.00, ''),
(56, 'Acasa Suites', 'HotelPension', 826.00, 'https://media-v2.discover.swiss/rawmedia/hs/00075319_m.jpg'),
(57, 'achesa homes Glattbrugg', 'HotelPension', 4013.00, 'https://media-v2.discover.swiss/rawmedia/hs/00063762_m.jpg'),
(58, 'Ackpfeiferhof', 'BedBreakfast', 3498.00, ''),
(59, 'Activehotel Diana', 'HotelPension', 3400.00, ''),
(60, 'Adaastra Boutique Hotel', 'HotelPension', 1096.00, 'https://media-v2.discover.swiss/rawmedia/hs/00111453_82e41b51bbdbf9c129095719b1b5a6e8_m.jpg'),
(61, 'ad fontes beauty & wellness', 'Notdefined', 3519.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010376221628/TDS00020010010367324/TDS00020011811858599.jpg'),
(62, 'Adhhoc Hotel', 'HotelPension', 3270.00, 'https://media-v2.discover.swiss/rawmedia/hs/00112488_a1030aec1d3bd5838df673d3baf9f5ce_m.jpg'),
(63, 'Adina Apartment Hotel Geneva', 'HotelPension', 2174.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/83083cea-edd4-4c17-a6d8-201bde0061a1.jpg'),
(64, 'Adler Adelboden', 'HotelPension', 2405.00, 'https://media-v2.discover.swiss/rawmedia/hs/00094195_a0e5799afde7bf35893f298cf6fed0a5_m.jpg'),
(65, 'Adler Boutique Hotel & Pub', 'HotelPension', 4911.00, 'https://media-v2.discover.swiss/rawmedia/hs/00096663_b5566ffb59e34ff0faa3850f01e3b78e_m.jpg'),
(66, 'Adler Historic Guesthouse', 'HotelPension', 665.00, ''),
(67, 'Adlerhorst', 'HotelPension', 1913.00, ''),
(68, 'Adler Hotel', 'HotelPension', 3222.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/e9eb7cc3-5c59-4e09-b6ff-8d5701d69b58.jpg'),
(69, 'Adler Living Attika-Wohnung', 'BedBreakfast', 4540.00, ''),
(70, 'Adler Living Gartenwohnung', 'BedBreakfast', 4210.00, ''),
(71, 'ADLER Lodge Alpe', 'HotelPension', 533.00, ''),
(72, 'Adler Lodge Ritten', 'HotelPension', 2607.00, ''),
(73, 'ADLER Spa Resort BALANCE', 'HotelPension', 3605.00, ''),
(74, 'ADLER Spa Resort DOLOMITI', 'HotelPension', 3520.00, ''),
(75, 'Adler Suite & Stube', 'HotelPension', 3346.00, 'https://images.pexels.com/photos/7478064/pexels-photo-7478064.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(76, 'Adlhof Apartments', 'HotelPension', 505.00, ''),
(77, 'Adolfer Höfl', 'BedBreakfast', 2750.00, ''),
(78, 'Adrenalin Backpackers Hostel', 'HotelPension', 1865.00, 'https://media-v2.discover.swiss/rawmedia/ctd/16832eda2f619ee68c5165111c35b26f5e365f99_Adrenalin_Sommer.jpg'),
(79, 'Adults Only Prunner Luxury Suites', 'HotelPension', 1301.00, ''),
(80, 'Adventure Hostel Klosters', 'HotelPension', 4907.00, 'https://media-v2.discover.swiss/rawmedia/hs/00061959_m.jpg'),
(81, 'ADV HOME', 'BedBreakfast', 1506.00, ''),
(82, 'Aelggialp Berggasthaus', 'Notdefined', 4090.00, ''),
(83, 'AFTERWORK Hotel', 'HotelPension', 4894.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/fde5eac6-efbb-4f25-9795-5b99adbd7841.jpg'),
(84, 'Agalma', 'BedBreakfast', 4305.00, ''),
(85, 'Agenzia BelaVal Apartments - Badia', 'BedBreakfast', 1371.00, ''),
(86, 'Agenzia BelaVal Apartments - Corvara', 'BedBreakfast', 1130.00, ''),
(87, 'Agora Swiss Night by Fassbind', 'HotelPension', 2015.00, ''),
(88, 'Agriturismo - Bed & Breakfast Bertazzi', 'Notdefined', 4810.00, ''),
(89, 'Agriturism Oberbühlhof', 'Farm', 2890.00, ''),
(90, 'Agriturismo E-Cinque', 'Farm', 3722.00, ''),
(91, 'Agriturismo La Munt', 'Farm', 4514.00, 'https://images.pexels.com/photos/35116771/pexels-photo-35116771.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(92, 'Agriturismo Miravalle', 'HotelPension', 1886.00, 'https://resc.deskline.net/images/CH1/1/1c88ba74-cb43-4f4e-a649-92a2626dc218/99/image.jpg'),
(93, 'Agritur Zuveith', 'Farm', 3638.00, ''),
(94, 'Ahner Berghof', 'Farm', 3069.00, ''),
(95, 'AhriaNova Apartments', 'BedBreakfast', 4664.00, ''),
(96, 'AhriaPura Apartments', 'HotelPension', 3031.00, ''),
(97, 'Ahrner Wirt Apartments', 'HotelPension', 4579.00, ''),
(98, 'Ahrn Natur Apartment', 'BedBreakfast', 3299.00, ''),
(99, 'Ahrntal Appartements', 'BedBreakfast', 3807.00, ''),
(100, 'Ahrntalerhof Hotel', 'HotelPension', 1232.00, ''),
(101, 'Aichbühlerhof', 'Farm', 3123.00, ''),
(102, 'Aichhornhof', 'Farm', 661.00, ''),
(103, 'Aichnerhof', 'Farm', 3504.00, ''),
(104, 'Aichnerhof - Valorz-Vieider Maria', 'BedBreakfast', 726.00, 'https://images.pexels.com/photos/34172590/pexels-photo-34172590.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(105, 'Aïda Hôtel & Spa - Adults only', 'HotelPension', 3004.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020013351981932/TDS00020010000158950/TDS00020013785732638.jpg'),
(106, 'Aignerhof', 'Farm', 4260.00, ''),
(107, 'Airbnb Bühler', 'Apartment', 609.00, 'https://media-v2.discover.swiss/rawmedia/ctd/80edb4f8c5348e827c4e1b950695660d1b8ff087_Schlatt_Netstal_MRH_7.jpg'),
(108, 'Air BnB Mountain Haven', 'Apartment', 3526.00, 'https://media-v2.discover.swiss/rawmedia/ctd/bcee85e45af66b0bf58607c29108cc3ba4efe3b1_Mountain_Haven_Aussenansicht.jpg'),
(109, 'AirMusicAttic', 'BedBreakfast', 4753.00, ''),
(110, 'Airport Hotel Basel', 'HotelPension', 1463.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010186568842/TDS00020010000158950/TDS00020011101128443.jpg'),
(111, 'Airport Hotel Bern-Belp', 'Notdefined', 2446.00, ''),
(112, 'airporthotel Grenchen', 'Notdefined', 2610.00, ''),
(113, 'AKI Family Resort PLOSE', 'HotelPension', 812.00, ''),
(114, 'Aktiv & Familienhotel Adlernest', 'HotelPension', 3583.00, ''),
(115, 'Aktivhostel HängeMatt', 'Youth', 2664.00, 'https://media-v2.discover.swiss/rawmedia/ctd/c2b31aac89af15850f59f4efaae737f58b711712_256540523.jpg'),
(116, 'Aktiv Hotel Edelweiss', 'HotelPension', 3963.00, ''),
(117, 'Aktiv Hotel Schönwald', 'HotelPension', 2314.00, ''),
(118, 'Aktiv Hotel & Spa Hannigalp', 'HotelPension', 3497.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010000457759/TDS00020010000158950/TDS00020013835639056.png'),
(119, 'Aktiv Lodge Meran', 'BedBreakfast', 3134.00, ''),
(120, 'Aktiv & Relax Hotel Hubertus', 'HotelPension', 1227.00, ''),
(121, 'Aktiv- und Genusshotel Alpenblick', 'HotelPension', 1918.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/a7269aea-d9ac-4c87-bb0d-04a50c93639a.jpg'),
(122, 'Wellnesshotel Lodenwirt', 'HotelPension', 4038.00, ''),
(123, 'Aktiv & Vitalhotel Erica', 'HotelPension', 4422.00, 'https://images.pexels.com/photos/5707183/pexels-photo-5707183.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(124, 'Aktiv & Vitalhotel Taubers Unterwirt', 'HotelPension', 3664.00, ''),
(125, 'Hotel Traube - Post', 'HotelPension', 1259.00, ''),
(126, 'Aktiv- & Wellnesshotel Zentral', 'HotelPension', 1875.00, ''),
(127, 'Alaïa Lodge', 'HotelPension', 3382.00, 'https://media-v2.discover.swiss/rawmedia/hs/00111881_de2d22f6d89c938132b59e583acfe887_m.jpg'),
(128, 'Albana Hotel', 'HotelPension', 4509.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/6b985e05-c2a8-4e51-99dc-e8383f6cc282.jpeg'),
(129, 'Albergo Altavilla', 'HotelPension', 3150.00, 'https://media-v2.discover.swiss/rawmedia/hs/00115173_c5b5d292eaced789a13e9914753da22a_m.jpg'),
(130, 'Albergo Bellavista', 'Notdefined', 4592.00, ''),
(131, 'Albergo Calancasca', 'Notdefined', 2278.00, ''),
(132, 'Albergo Carcani', 'HotelPension', 4853.00, 'https://media-v2.discover.swiss/rawmedia/hs/00035984_m.jpg'),
(133, 'Albergo Cardada', 'Notdefined', 3476.00, ''),
(134, 'Albergo Casa Soledaria', 'Notdefined', 2323.00, ''),
(135, 'Albergo Cereda', 'HotelPension', 1686.00, 'https://media-v2.discover.swiss/rawmedia/hs/00085822_m.jpg'),
(136, 'Albergo Ceresio', 'HotelPension', 3583.00, ''),
(137, 'Albergo Della Posta', 'HotelPension', 3423.00, 'https://media-v2.discover.swiss/rawmedia/hs/00103036_e5c1117b33898b78a7f5251b1365e831_m.jpg'),
(138, 'Albergo Elvezia', 'Notdefined', 4164.00, ''),
(139, 'Albergo e Ristorante Robiei', 'Notdefined', 4095.00, ''),
(140, 'Albergo Federale', 'HotelPension', 1658.00, 'https://media-v2.discover.swiss/rawmedia/hs/00080344_m.jpg'),
(141, 'Albergo Garni Casa Ambica', 'Notdefined', 2888.00, 'https://media-v2.discover.swiss/rawmedia/hs/00064207_m.jpg'),
(142, 'Albergo Garni Elena', 'HotelPension', 2946.00, 'https://media-v2.discover.swiss/rawmedia/hs/00087917_m.jpg'),
(143, 'Albergo Garni Villa del Sole', 'HotelPension', 1315.00, 'https://media-v2.discover.swiss/rawmedia/hs/00102132_c6265ca589a8d38de5ef5057d4321563_m.jpg'),
(144, 'Albergo Lardi', 'Notdefined', 2640.00, ''),
(145, 'Albergo Losone', 'HotelPension', 2128.00, 'https://media-v2.discover.swiss/rawmedia/hs-st/VARIA_c364566.jpg'),
(146, 'Albergo Mirador', 'HotelPension', 1002.00, 'https://images.pexels.com/photos/35057512/pexels-photo-35057512.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(147, 'Albergo Miralago', 'Notdefined', 543.00, 'https://media-v2.discover.swiss/rawmedia/hs/00092970_893a9a3d626319fb77d077245eb85e59_m.jpg'),
(148, 'Albergo Moosmann', 'Notdefined', 3609.00, ''),
(149, 'Albergo Olivone & Posta', 'Notdefined', 2598.00, ''),
(150, 'Albergo Ospizio Bernina', 'Notdefined', 2462.00, 'https://media-v2.discover.swiss/rawmedia/hs/00061568_m.jpg'),
(151, 'Albergo Osteria Ticino', 'HotelPension', 677.00, 'https://media-v2.discover.swiss/rawmedia/hs/00086606_m.jpg'),
(152, 'Albergo Posta', 'Notdefined', 3606.00, ''),
(153, 'Albergo Ristorante campagna', 'Notdefined', 1544.00, ''),
(154, 'Albergo Ristorante Crameri', 'Notdefined', 3469.00, ''),
(155, 'Albergo Ristorante Croce Bianca', 'Notdefined', 2896.00, 'https://resc.deskline.net/images/CH1/1/5bb53419-f39d-478e-961d-482e6aedc36f/99/image.jpg'),
(156, 'Albergo Ristorante La Palma', 'HotelPension', 2819.00, 'https://media-v2.discover.swiss/rawmedia/hs/00017538_m.jpg'),
(157, 'Albergo Ristorante Svizzero', 'HotelPension', 2247.00, 'https://media-v2.discover.swiss/rawmedia/hs/00061323_m.jpg'),
(158, 'Albergo Ristorante Zelindo', 'Notdefined', 1379.00, ''),
(159, 'Albergo Ronco', 'HotelPension', 933.00, 'https://media-v2.discover.swiss/rawmedia/hs/00004294_m.jpg'),
(160, 'Albergo Rovere', 'Notdefined', 551.00, ''),
(161, 'Albergo San Gottardo', 'HotelPension', 1363.00, 'https://media-v2.discover.swiss/rawmedia/hs/00055824_m.jpg'),
(162, 'Albergo Santana e Ristorante', 'Notdefined', 4156.00, ''),
(163, 'Albergo Stazione', 'Notdefined', 3983.00, ''),
(164, 'ALBERGO TRATTORIA HOFER', 'HotelPension', 2436.00, ''),
(165, 'Albergo Vecchia Locarno', 'HotelPension', 3850.00, 'https://media-v2.discover.swiss/rawmedia/hs/00069688_m.jpg'),
(166, 'Albergo Villa Marita', 'Notdefined', 566.00, ''),
(167, 'Albergo Zarera', 'Notdefined', 2532.00, 'https://images.pexels.com/photos/5795005/pexels-photo-5795005.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(168, 'Alberhof', 'Farm', 4312.00, ''),
(169, 'Al cantuccio di Chiara', 'BedBreakfast', 3105.00, ''),
(170, 'Aldeiner Hof', 'HotelPension', 4394.00, ''),
(171, 'Alea-Living', 'HotelPension', 962.00, ''),
(172, 'Alex Alpine Resort – Spa & Sports', 'HotelPension', 2157.00, 'https://media-v2.discover.swiss/rawmedia/hs/00022046_m.jpg'),
(173, 'Alexander Guesthouse', 'HotelPension', 3812.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/d2e5ef5e-4cc7-4de1-a54e-a85c701e90de.jpg'),
(174, 'Alex Bonafe - Apartments Oberhollenzer', 'BedBreakfast', 4908.00, ''),
(175, 'Alex Lake Zürich', 'HotelPension', 3161.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/068b0e98-709a-4161-b14d-f80cb28add8a.jpg'),
(176, 'Alia Vital Appart-Hotel', 'HotelPension', 2216.00, ''),
(177, 'Alla Capanna', 'HotelPension', 4962.00, 'https://media-v2.discover.swiss/rawmedia/hs/00112606_e069c1f7ef4d07ce37a9db37fc21c516_m.jpg'),
(178, 'Allegro Alpin Lodge', 'HotelPension', 2742.00, 'https://www.zuerich.com/sites/default/files/image/2024/web_eyz_hotel_allegro_sihlsee%20%28Andere%29.jpg'),
(179, 'All in Hotel Saas-Fee', 'Notdefined', 2115.00, ''),
(180, 'All In One Hotel Inn Lodge', 'HotelPension', 3226.00, 'https://media-v2.discover.swiss/rawmedia/hs/00110650_26acd7f6caaf523cfa7fc150119c02c5_m.jpg'),
(181, 'ALLOGGIO DOLOMITES', 'BedBreakfast', 4848.00, ''),
(182, 'Alma Alpina Lodge – Adults Only', 'HotelPension', 932.00, ''),
(183, 'Alma Appartements', 'HotelPension', 2240.00, ''),
(184, 'Alma Hotel', 'HotelPension', 1598.00, 'https://media-v2.discover.swiss/rawmedia/hs/00106457_4f706bfc0d4d16874c38be6b59d8e341_m.jpg'),
(185, 'Alma Kuprian', 'BedBreakfast', 2985.00, 'https://images.pexels.com/photos/33708492/pexels-photo-33708492.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(186, 'Alma Mountain Residence', 'HotelPension', 1066.00, ''),
(187, 'Almarett', 'HotelPension', 4402.00, ''),
(188, 'Almchalet Hochgruberhof', 'Farm', 2924.00, ''),
(189, 'Almchalet Sagstallhof', 'Farm', 1765.00, ''),
(190, 'Almchalet Schafhütte', 'BedBreakfast', 4314.00, ''),
(191, 'Almdiele Apparthotel', 'HotelPension', 1363.00, ''),
(192, 'Almdorf Haidenberg', 'BedBreakfast', 3327.00, ''),
(193, 'Almgasthof am Rinderplatz', 'HotelPension', 4104.00, ''),
(194, 'Almgasthof Geisler', 'HotelPension', 4384.00, ''),
(195, 'Almhaus Morgenrast', 'BedBreakfast', 1649.00, ''),
(196, 'Almhaus Pfister OHG-SNC', 'BedBreakfast', 3431.00, ''),
(197, 'Almhof Hotel Call', 'HotelPension', 4523.00, 'https://images.pexels.com/photos/14600014/pexels-photo-14600014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(198, 'Almhotel Bergerhof', 'HotelPension', 2688.00, ''),
(199, 'Almhotel Col Raiser', 'HotelPension', 4752.00, ''),
(200, 'Almhotel Glieshof', 'HotelPension', 1491.00, ''),
(201, 'Almhotel Lenz', 'HotelPension', 3256.00, ''),
(202, 'Almhotel Zallinger', 'HotelPension', 1812.00, ''),
(203, 'Almrausch', 'BedBreakfast', 1203.00, ''),
(204, 'Almresidence Unterrain zum Hartl', 'Farm', 4691.00, ''),
(205, 'Alp Art Hotel', 'HotelPension', 3527.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/b2ee844d-cd62-4adc-92fc-afb5761e11b3.png'),
(206, 'Alp-Ausflugs-Ski-Pistenhotel Klewenstock', 'Notdefined', 4436.00, ''),
(207, 'Alpe di Susi-App. Daniel', 'BedBreakfast', 1108.00, ''),
(208, 'Apart. Alpegger', 'Farm', 3521.00, ''),
(209, 'Alpeggerhof', 'Farm', 2905.00, ''),
(210, 'Alpenappart', 'Farm', 1278.00, 'https://images.pexels.com/photos/14600014/pexels-photo-14600014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(211, 'ALPENBADL OBERFRAUNERHOF', 'Farm', 3005.00, ''),
(212, 'Alpenblick', 'BedBreakfast', 1296.00, ''),
(213, 'Alpenblick Apartements', 'BedBreakfast', 3330.00, ''),
(214, 'Alpenblick Bergrestaurant & Hotel', 'HotelPension', 2553.00, 'https://resc.deskline.net/images/ARO/1/ea65eefe-f4a1-4c66-9a65-6e07dc69948c/99/image.jpg'),
(215, 'Alpenblick Bern - kind of a hotel', 'HotelPension', 3159.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/38ae1d04-5b6c-4cf1-8fb7-9d3d4f2a5186.jpg'),
(216, 'Alpenblick-Breitwieser', 'Farm', 1754.00, ''),
(217, 'Alpenblick Hotel', 'HotelPension', 505.00, ''),
(218, 'Alpenchalet Dolomiten', 'BedBreakfast', 2620.00, ''),
(219, 'Alpenchalets Mair', 'Farm', 1291.00, ''),
(220, 'Alpen Ferienwohnung', 'BedBreakfast', 2635.00, ''),
(221, 'Alpenflair City Meran', 'BedBreakfast', 3400.00, ''),
(222, 'Alpenfrieden Hotel', 'HotelPension', 4295.00, ''),
(223, 'Alpengasthof Alpina', 'Notdefined', 4118.00, ''),
(224, 'Alpengasthof Crusch Alba ed Alvetern', 'HotelPension', 3873.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/f918af73-b873-4abb-bdd0-198109870ba7.jpg'),
(225, 'Alpengasthof Zufritt', 'HotelPension', 782.00, ''),
(226, 'Alpenglanz Deluxe Studio', 'Apartment', 1774.00, 'https://media-v2.discover.swiss/rawmedia/ctd/3981bd2085ebea14fe400d7d1aaf9fd9e8f989c7_Foto.jpg'),
(227, 'Alpenglow Apartments', 'BedBreakfast', 2852.00, 'https://images.pexels.com/photos/10990166/pexels-photo-10990166.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(228, 'AlpenGold Davos', 'HotelPension', 1602.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/5c9f21fc-1f70-47eb-a6e9-9d57d50673d9.jpg'),
(229, 'Alpenheim Charming & Spa Hotel', 'HotelPension', 1894.00, ''),
(230, 'Alpenhof Dolomit Family', 'HotelPension', 4521.00, ''),
(231, 'Alpenhof Lodge', 'HotelPension', 1552.00, ''),
(232, 'Alpenhotel Jù Furcia', 'HotelPension', 1260.00, ''),
(233, 'Alpenhotel Panorama', 'HotelPension', 838.00, ''),
(234, 'Alpenhotel Piz Seteur', 'HotelPension', 4302.00, ''),
(235, 'Alpenhotel Plaza', 'HotelPension', 2706.00, ''),
(236, 'Alpenhotel Ratsberg OHG', 'HotelPension', 2783.00, 'https://doc.lts.it/image-server/api/render-images?ID=72e84be3d029d5193aadfd8339114d31'),
(237, 'Alpenhotel Schlüssel', 'HotelPension', 1958.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010047462407/TDS00020010000158950/TDS00020012957540983.jpg'),
(238, 'Alpenhotel Schönwald', 'HotelPension', 4627.00, ''),
(239, 'Alpenhotel Zur Wildi', 'HotelPension', 3621.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010075699893/TDS00020010000158950/TDS00020015231514648.jpg'),
(240, 'Alpenkaiser', 'BedBreakfast', 675.00, ''),
(241, 'Alpenkräuter Hotel Bären', 'HotelPension', 4265.00, 'https://media-v2.discover.swiss/rawmedia/hs/00087320_m.jpg'),
(242, 'Alpenland Pension', 'HotelPension', 4357.00, ''),
(243, 'Alpenliving', 'BedBreakfast', 5000.00, 'https://images.pexels.com/photos/14600014/pexels-photo-14600014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(244, 'Alpenlodge Grimselpass', 'Notdefined', 4916.00, ''),
(245, 'Alpenlodge Kühboden', 'Notdefined', 2082.00, 'https://media-v2.discover.swiss/rawmedia/hs/00077830_m.jpg'),
(246, 'Alpenlodge Val Gronda', 'HotelPension', 548.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020012348995235/TDS00020010000158950/TDS00020012911183093.jpg'),
(247, 'Alpen Natur Camping', 'Camping', 3782.00, ''),
(248, 'Alpenpalace Luxury Hideaway & Spa Retreat', 'HotelPension', 4890.00, ''),
(249, 'Alpenpalais Kröll', 'HotelPension', 3497.00, ''),
(250, 'Alpenperle Residences', 'HotelPension', 3308.00, 'https://media-v2.discover.swiss/rawmedia/hs/00069978_m.jpg'),
(251, 'Alpenresidence Garni App', 'HotelPension', 4730.00, ''),
(252, 'Alpenresort Eienwäldli Engelberg', 'HotelPension', 2006.00, 'https://media-v2.discover.swiss/rawmedia/hs/00055753_m.jpg'),
(253, 'Alpen Resort Hotel & Spa', 'HotelPension', 2128.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010416503269/TDS00020010010367324/TDS00020012406556494.jpg'),
(254, 'Alpenrose', 'BedBreakfast', 3484.00, ''),
(255, 'Alpenrose Residence', 'HotelPension', 865.00, ''),
(256, 'Alpenrose\'s Dining & Living', 'HotelPension', 2176.00, ''),
(257, 'Alpenrösli Hafling', 'BedBreakfast', 2216.00, ''),
(258, 'Alpenschlössl', 'BedBreakfast', 3315.00, ''),
(259, 'Alpenvilla Large Family Apartment - Pools - 500 meters - by Familiaris', 'BedBreakfast', 1299.00, ''),
(260, 'Alpenwellnesshotel St. Veit', 'HotelPension', 4230.00, 'https://images.pexels.com/photos/30151209/pexels-photo-30151209.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(261, 'Alperlebnis Bächialp', 'Mountain', 3764.00, 'https://media-v2.discover.swiss/rawmedia/ctd/d783aece2d33eb2d925b66f7cc85f73a8523d712_Alp_Boesbaechi_front_xlarge.jpg'),
(262, 'Alpha Palmiers by Fassbind', 'HotelPension', 3305.00, 'https://media-v2.discover.swiss/rawmedia/hs-st/VARIA_b2b6e5b.jpg'),
(263, 'alpha thun', 'HotelPension', 2572.00, 'https://media-v2.discover.swiss/rawmedia/hs/00037622_m.jpg'),
(264, 'Alp-Hof', 'BedBreakfast', 1006.00, ''),
(265, 'Alphotel Biel-Kinzig', 'HotelPension', 3389.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/a6a1c4f0-d479-437d-a801-8fbf8ca393f5.jpg'),
(266, 'Alphotel Eiger Bed and Breakfast', 'Notdefined', 4894.00, ''),
(267, 'Alphotel Panorama', 'HotelPension', 1595.00, ''),
(268, 'Alphotel Stocker', 'HotelPension', 1821.00, ''),
(269, 'Alphütte Amali', 'Notdefined', 1368.00, 'https://media-v2.discover.swiss/rawmedia/ctd/0eb054ba759bed2c5bec630ac72d37aec0e23153_008_05a.jpg'),
(270, 'Alphütten Berglialp', 'Mountain', 3677.00, 'https://media-v2.discover.swiss/rawmedia/ctd/b07caf1867e65d7b46f70ce6353e9ff1223f725c_Wellness_ufem_Gufel___5__Heinrich_und_Ursi_Marti_Kamer.jpg'),
(271, 'ALPIANA Mountain Resort & SPA', 'HotelPension', 3363.00, ''),
(272, 'Alpi Hotel', 'Notdefined', 3213.00, ''),
(273, 'Alpina Ferienhaus, Braunwald', 'BedBreakfast', 3495.00, 'https://media-v2.discover.swiss/rawmedia/ctd/04e3ccca163b6f68ef0e1b386758744f9579eca3_Wohnzimmer.jpg'),
(274, 'Alpina Hotel', 'HotelPension', 4097.00, 'https://media-v2.discover.swiss/rawmedia/hs/00090507_8cc8c8d4b41fd8ec38e41d8e717f42b8_m.jpg'),
(275, 'Alpina Mountain Caravan Park', 'Camping', 4147.00, ''),
(276, 'Alpin Apartments Colfosco', 'BedBreakfast', 4174.00, ''),
(277, 'Alpin Apartments Colfosco - Oberhuber', 'BedBreakfast', 2934.00, ''),
(278, 'Alpin Apartments Heidenberger', 'BedBreakfast', 3143.00, ''),
(279, 'Alpin Apartments Piculin', 'BedBreakfast', 4434.00, ''),
(280, 'Alpina Pensiun & Restaurant', 'HotelPension', 638.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010679092091/TDS00020010000158950/TDS00020010863484804.jpg'),
(281, 'Alpina Residence der Schöpf Rita', 'HotelPension', 617.00, 'https://images.pexels.com/photos/5707183/pexels-photo-5707183.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(282, 'Alpin b&b Villa Melisse', 'HotelPension', 1701.00, ''),
(283, 'Alpin Chalet Frenademetz', 'BedBreakfast', 3590.00, ''),
(284, 'Alpinchalet Ortler', 'BedBreakfast', 683.00, ''),
(285, 'Alpin Chalet Samer', 'BedBreakfast', 4789.00, ''),
(286, 'Alpin Boutique Villa Gabriela', 'BedBreakfast', 567.00, ''),
(287, 'Alpine Chalet Aurora Dolomites', 'BedBreakfast', 3778.00, ''),
(288, 'Alpine Chalets App. Pichlerhof', 'Farm', 3382.00, ''),
(289, 'Alpine Classic Hotel', 'HotelPension', 1178.00, 'https://media-v2.discover.swiss/rawmedia/hs-st/VARIA_a0621a9.jpg'),
(290, 'Alpine Deluxe', 'BedBreakfast', 1963.00, ''),
(291, 'Alpine Hotel Ciasa Lara', 'HotelPension', 2674.00, ''),
(292, 'Alpine Hotel Gran Fodá', 'HotelPension', 2274.00, ''),
(293, 'Alpine Hotel Perren', 'HotelPension', 1339.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/4cdf20d2-9d11-4b5d-b424-f95058f6e291.jpg'),
(294, 'Alpine Inn Davos', 'HotelPension', 4553.00, 'https://media-v2.discover.swiss/rawmedia/hs/00105227_d0f11c7261ffb637e2d6911a0caea382_m.jpg'),
(295, 'Hotel Ambet', 'HotelPension', 2156.00, ''),
(296, 'Alpine Luxury Penthouse', 'BedBreakfast', 2207.00, 'https://images.pexels.com/photos/7745936/pexels-photo-7745936.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(297, 'Alpine Nature Hotel Stoll', 'HotelPension', 3746.00, ''),
(298, 'Alpinence', 'BedBreakfast', 2600.00, ''),
(299, 'Alpine Residence Villa Adler', 'HotelPension', 3628.00, ''),
(300, 'Alpin Fitness Waldcamping OHG & Co.', 'Camping', 2502.00, ''),
(301, 'Alping Apartments', 'BedBreakfast', 1460.00, ''),
(302, 'Alping Apartments 2°', 'BedBreakfast', 1401.00, ''),
(303, 'Alpin Garden Luxury Maison & SPA', 'HotelPension', 4213.00, ''),
(304, 'Alpin Garden Luxury Maison & SPA - Adults Only', 'HotelPension', 3323.00, ''),
(305, 'Alpinhotel Bort', 'HotelPension', 3523.00, 'https://media-v2.discover.swiss/rawmedia/hs/00104573_a816074cc75ab122f1e36b74faa04893_m.jpg'),
(306, 'Alpin Hotel Gudrun', 'HotelPension', 2553.00, ''),
(307, 'Alpinhotel Keil', 'HotelPension', 2632.00, ''),
(308, 'Alpin Hotel Sonnblick', 'HotelPension', 2348.00, ''),
(309, 'Alpinhotel Vajolet', 'HotelPension', 3682.00, 'https://images.pexels.com/photos/13691334/pexels-photo-13691334.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(310, 'Alpin Natur Hotel Brückele', 'HotelPension', 1769.00, ''),
(311, 'Alpin-Residence Amadeus', 'HotelPension', 3857.00, ''),
(312, 'Alpin Royal Hotel', 'HotelPension', 1533.00, 'https://media-v2.discover.swiss/rawmedia/ctd/2009ab321eaf18e2e7f6eab789f36e5a8b2254de_10___KPZ_1297_2.jpg'),
(313, 'Alpin Royal Wellness Refugium & Resort Hotel', 'HotelPension', 4610.00, ''),
(314, 'Alpin Spa Hotel die Post', 'HotelPension', 1503.00, ''),
(315, 'Alpin Sport Apartments', 'BedBreakfast', 3825.00, ''),
(316, 'Alpin Sporthotel Bündnerhof', 'HotelPension', 2741.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010350497629/TDS00020010000158950/TDS00020010773638987.jpg'),
(317, 'Alpin Stile Hotel', 'HotelPension', 4359.00, ''),
(318, 'Alpin & Style Hotel Die Sonne', 'HotelPension', 2456.00, ''),
(319, 'Alpinvilla Keil', 'BedBreakfast', 4637.00, ''),
(320, 'Alpin & Vital Hotel La Perla', 'HotelPension', 3197.00, ''),
(321, 'Al Plan Dolomites Hotel Museum-Osteria-Oldtimer', 'HotelPension', 4241.00, ''),
(322, 'Alplodge', 'Youth', 2565.00, 'https://media-v2.discover.swiss/rawmedia/hs/00085815_m.jpg'),
(323, 'Alp Oberchäseren', 'Apartment', 1189.00, 'https://media-v2.discover.swiss/rawmedia/ctd/67361f8758c8cdfb456abad46959179813bb791e_Oberchaeseren.jpg'),
(324, 'Al Ponte Albergo - Ristorante', 'HotelPension', 3239.00, 'https://media-v2.discover.swiss/rawmedia/hs/00076593_m.jpg'),
(325, 'Alp Residence Pelegrin', 'HotelPension', 3011.00, ''),
(326, 'ALPS APARTMENTS VICTORY', 'BedBreakfast', 1150.00, 'https://images.pexels.com/photos/14600014/pexels-photo-14600014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(327, 'Alpshotel Bergland', 'HotelPension', 4824.00, ''),
(328, 'Alpstay Chalet Hotel Hartmann – Adults Only', 'HotelPension', 1818.00, ''),
(329, 'Alpstay – Hotel Acadia – Adults Only', 'HotelPension', 4244.00, ''),
(330, 'Alpstay – Smart Hotel Saslong', 'HotelPension', 4381.00, ''),
(331, 'Alpura - Rooted in nature. Created for families.', 'HotelPension', 3797.00, ''),
(332, 'Alp Wissboden', 'Apartment', 4816.00, 'https://media-v2.discover.swiss/rawmedia/ctd/c90fdcd0196612f56ce24fb1a330447bc17218af_Wissboden_5.jpg'),
(333, 'Altebner Farm', 'Farm', 882.00, ''),
(334, 'Alte Mühle', 'BedBreakfast', 4010.00, ''),
(335, 'ALTE POST das Gruppenhaus in Matt', 'Apartment', 1313.00, 'https://media-v2.discover.swiss/rawmedia/ctd/834a3a18f39428d4d4d4e6acff389c409fc4093a_Aktuelles_Sommerfoto.jpg'),
(336, 'Alter Fausthof', 'Farm', 3837.00, ''),
(337, 'Alter Schlachthof', 'BedBreakfast', 2895.00, ''),
(338, 'Althauhütte', 'SelfCateredHut', 587.00, 'https://media-v2.discover.swiss/rawmedia/ctd/f4934c20b1a81e48f39d9114b90838b4ee457d6e_Althauhuette_Hallau.jpg'),
(339, 'Althuberhof', 'Farm', 657.00, ''),
(340, 'Altmessnerhof', 'Farm', 1499.00, ''),
(341, 'Altstadtferienhaus in Klausen', 'BedBreakfast', 1047.00, 'https://images.pexels.com/photos/37305911/pexels-photo-37305911.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(342, 'Altstadt Hotel', 'HotelPension', 3126.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_hotel_altstadt_1280x960_31213.jpg'),
(343, 'Altstadt Hotel Krone Luzern', 'HotelPension', 4067.00, 'https://media-v2.discover.swiss/rawmedia/hs/00052084_m.jpg'),
(344, 'Altstadt Hotel Magic Luzern', 'HotelPension', 573.00, 'https://media-v2.discover.swiss/rawmedia/hs/00059820_m.jpg'),
(345, 'Amanita Apartment', 'BedBreakfast', 2817.00, ''),
(346, 'Aman Rosa Alpina', 'HotelPension', 1812.00, ''),
(347, 'AMANTE Flughafenhotel Bern Belp', 'HotelPension', 523.00, 'https://media-v2.discover.swiss/rawmedia/hs/00115785_359d341f5e97bfc8285e8751862f0a7f_m.jpg'),
(348, 'Amaris Suites', 'HotelPension', 2704.00, ''),
(349, 'AMA Stay', 'HotelPension', 4669.00, ''),
(350, 'Ambassador Boutique Hotel', 'HotelPension', 4311.00, 'https://media-v2.discover.swiss/rawmedia/hs-st/WINTER_5ed18ab.jpg'),
(351, 'Ambassador Hotel Zürich', 'HotelPension', 567.00, 'https://media-v2.discover.swiss/rawmedia/hs/00037645_m.jpg'),
(352, 'Ambiente Hotel Freieck', 'HotelPension', 2645.00, 'https://media-v2.discover.swiss/rawmedia/hs/00069515_m.jpg'),
(353, 'Ambiente mit kunstvollem Stil', 'BedBreakfast', 3356.00, ''),
(354, 'Ambiente Villa Mozart', 'BedBreakfast', 707.00, ''),
(355, 'Ambrosia Guesthouse', 'HotelPension', 1212.00, ''),
(356, 'Ambrosia Hüsli', 'Youth', 505.00, 'https://media-v2.discover.swiss/rawmedia/hs/00098779_d29f62866ff6d62c89fe99f7f790a1dc_m.jpg'),
(357, 'Am Brunnen Apartments', 'HotelPension', 3586.00, ''),
(358, 'AmdenLodge Bienenheim', 'Notdefined', 4656.00, 'https://media-v2.discover.swiss/rawmedia/hs/00076911_m.jpg'),
(359, 'Guesthouse Ameiserhof', 'HotelPension', 4341.00, ''),
(360, 'AMERON Luzern Hotel Flora', 'HotelPension', 934.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/0f978f96-b519-47c7-91e8-4ba5e67f2888.jpg'),
(361, 'AMERON Swiss Mountain Hotel Davos', 'HotelPension', 3012.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/0e3256e0-adc0-45f6-806c-56ad22b2e7b6.jpg'),
(362, 'AMERON Zürich Bellerive au Lac', 'HotelPension', 3249.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/c4174c94-3bfc-4412-b871-c592827f08d9.jpg'),
(363, 'Am Gries', 'BedBreakfast', 3888.00, ''),
(364, 'Am Hexenbichl', 'Farm', 2309.00, ''),
(365, 'Am Hof', 'Farm', 1858.00, 'https://images.pexels.com/photos/8778706/pexels-photo-8778706.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(366, 'Amolaris Garden Lodges & Guesthouse', 'HotelPension', 1200.00, ''),
(367, 'Amonti Chalets', 'HotelPension', 2325.00, ''),
(368, 'Amontis', 'BedBreakfast', 1071.00, ''),
(369, 'AMONTI Wellnessresort', 'HotelPension', 2443.00, ''),
(370, 'Amort Suites', 'BedBreakfast', 1357.00, ''),
(371, 'Ampfertalerhof', 'HotelPension', 1726.00, ''),
(372, 'Amplatz 1523 - B&B and Suites', 'HotelPension', 2005.00, ''),
(373, 'Am Platzl Living', 'BedBreakfast', 997.00, ''),
(374, 'Am Schloss', 'BedBreakfast', 1620.00, ''),
(375, 'Am See', 'BedBreakfast', 3799.00, ''),
(376, 'Am See 3', 'BedBreakfast', 4047.00, ''),
(377, 'Amus Chalets', 'HotelPension', 2654.00, 'https://images.pexels.com/photos/14792749/pexels-photo-14792749.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(378, 'Am Wasserfall', 'BedBreakfast', 2218.00, ''),
(379, 'Anabel Alpine Life Hotel', 'HotelPension', 817.00, ''),
(380, 'Anas 126', 'BedBreakfast', 1384.00, ''),
(381, 'An der Aue Apartments', 'BedBreakfast', 1883.00, ''),
(382, 'Helmut Andergassen', 'Farm', 4500.00, ''),
(383, 'An der Goldgassen Loft', 'BedBreakfast', 837.00, ''),
(384, 'Anderlan Hubert', 'BedBreakfast', 3574.00, ''),
(385, 'Anderleithof', 'Farm', 3927.00, ''),
(386, 'Andermatt Alpine Apartments', 'HotelPension', 4967.00, 'https://media-v2.discover.swiss/rawmedia/hs/00073144_m.jpg'),
(387, 'Anders City Loft', 'BedBreakfast', 3922.00, ''),
(388, 'Anders Mountain Suites', 'HotelPension', 1998.00, ''),
(389, 'An der Wiese Haus', 'HotelPension', 2854.00, 'https://images.pexels.com/photos/8778706/pexels-photo-8778706.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(390, 'Andis Appartments', 'BedBreakfast', 2690.00, ''),
(391, 'Andrea Residence', 'HotelPension', 2575.00, ''),
(392, 'Andreas Hofer Hotel', 'HotelPension', 3086.00, ''),
(393, 'ANDREAS HOFER RESIDENCE', 'BedBreakfast', 1812.00, ''),
(394, 'Andreina', 'BedBreakfast', 2431.00, ''),
(395, 'Andreus Golfhotel', 'HotelPension', 4864.00, ''),
(396, 'Andreus Golf Lodge', 'HotelPension', 986.00, ''),
(397, 'Andrianerhof', 'HotelPension', 2086.00, ''),
(398, 'Andrien', 'Farm', 3511.00, ''),
(399, 'Anett Hotel', 'HotelPension', 3352.00, ''),
(400, 'Angelika Raffeiner', 'BedBreakfast', 1763.00, ''),
(401, 'Sparer Stefan', 'Farm', 3924.00, 'https://images.pexels.com/photos/14116757/pexels-photo-14116757.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(402, 'Blumenhotel Ansitz Angerburg', 'HotelPension', 2994.00, ''),
(403, 'Angerer Hotel Garni', 'HotelPension', 1694.00, ''),
(404, 'Angerheim', 'Farm', 1746.00, ''),
(405, 'Angerhof', 'Farm', 511.00, ''),
(406, 'Angerhof am Kalterer See', 'Farm', 1185.00, ''),
(407, 'Angerle Alm', 'Farm', 1005.00, 'https://doc.lts.it/image-server/api/render-images?ID=7045e3efdc123c75c1a0a641dea18390'),
(408, 'Maso Angerle', 'Farm', 523.00, ''),
(409, 'Anger Living', 'BedBreakfast', 2604.00, ''),
(410, 'Anichhof', 'Farm', 3232.00, ''),
(411, 'Anigglhof', 'HotelPension', 3351.00, ''),
(412, 'Anker Hotel & Restaurant', 'HotelPension', 1015.00, 'https://media-v2.discover.swiss/rawmedia/ctd/cf01ba631f1dfd0f4c801a3559af78ad83555e5f_Anker_Teufen_Aussenansicht.jpg'),
(413, 'Anna', 'BedBreakfast', 936.00, ''),
(414, 'Anna Apartments', 'BedBreakfast', 2726.00, ''),
(415, 'Anna Appartements', 'BedBreakfast', 4128.00, 'https://images.pexels.com/photos/14600014/pexels-photo-14600014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(416, 'Anna Dependance', 'BedBreakfast', 541.00, ''),
(417, 'Annaheim Panoramawohnung', 'Farm', 3713.00, ''),
(418, 'Anna Lodges', 'HotelPension', 1218.00, ''),
(419, 'Anna Pension & Appartement', 'HotelPension', 979.00, ''),
(420, 'Annenhof', 'BedBreakfast', 4021.00, ''),
(421, 'ANNETTE\'S APARTMENT', 'BedBreakfast', 783.00, ''),
(422, 'Annex Antika', 'HotelPension', 4805.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010416518679/TDS00020010000158950/TDS00020011073126634.jpg'),
(423, 'Annex Crystal - managed by Jungfrau Lodge', 'HotelPension', 871.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/3205a91b-0497-42bb-99d1-56f0cc49ffb4.jpg'),
(424, 'Anratterhof', 'Farm', 4359.00, ''),
(425, 'Ansitz Aehrental', 'BedBreakfast', 590.00, ''),
(426, 'Ansitz am Eck', 'BedBreakfast', 1681.00, ''),
(427, 'Residence Ansiedl Engelsburg', 'BedBreakfast', 3907.00, ''),
(428, 'Ansitz Baumannhof', 'BedBreakfast', 1545.00, ''),
(429, 'Ansitz Bernard', 'Farm', 4155.00, 'https://images.pexels.com/photos/37497181/pexels-photo-37497181.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(430, 'Ansitz Eggenheim', 'Farm', 1284.00, ''),
(431, 'Tenuta Goldegg', 'Farm', 2950.00, ''),
(432, 'Sparer Thomas', 'Farm', 1504.00, ''),
(433, 'Gurtenhof', 'Farm', 2535.00, ''),
(434, 'Ansitz Helmsdorf', 'Farm', 3030.00, ''),
(435, 'Ansitz Heufler by Norbert Niederkofler', 'HotelPension', 3645.00, ''),
(436, 'Ansitz Jenner', 'BedBreakfast', 881.00, ''),
(437, 'Ansitz Kuensegg', 'Farm', 2134.00, ''),
(438, 'Ansitz Layshof', 'Farm', 3807.00, ''),
(439, 'Ansitz Lichtenthurn', 'BedBreakfast', 3039.00, ''),
(440, 'Ansitz Lidl', 'Farm', 3606.00, 'https://images.pexels.com/photos/6395249/pexels-photo-6395249.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(441, 'Ansitz Mairhof Deluxe Living', 'Farm', 2210.00, ''),
(442, 'Pratzer Elisabeth', 'Farm', 3402.00, ''),
(443, 'Ansitz Oberlahnbach', 'Farm', 2718.00, ''),
(444, 'Ansitz Ranuihof', 'Farm', 1852.00, ''),
(445, 'Ansitz Röfen', 'BedBreakfast', 4000.00, ''),
(446, 'Ansitz Romani', 'BedBreakfast', 977.00, ''),
(447, '\"Ansitz Rynnhof\"', 'Farm', 1451.00, ''),
(448, 'Ansitz Schneeburg', 'Farm', 3218.00, ''),
(449, 'Ansitz Schreckenstein', 'BedBreakfast', 2446.00, ''),
(450, 'Castel Ansitz Steinbock', 'HotelPension', 1996.00, ''),
(451, 'Ansitz Steiner', 'BedBreakfast', 2703.00, ''),
(452, 'Ansitz Stock', 'BedBreakfast', 1099.00, 'https://images.pexels.com/photos/19784751/pexels-photo-19784751.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(453, 'Ansitz Strengherrnhof', 'BedBreakfast', 4984.00, ''),
(454, 'Tenuta Thalerhof', 'BedBreakfast', 1086.00, ''),
(455, 'Ansitz Thierburg', 'BedBreakfast', 2229.00, ''),
(456, 'Ansitz Thierburg Lichtenthurn Srls.', 'BedBreakfast', 3808.00, ''),
(457, 'Ansitz Überbacherhof', 'HotelPension', 4417.00, ''),
(458, 'Ansitz Velseck', 'HotelPension', 783.00, ''),
(459, 'Ansitz Villa Donata', 'BedBreakfast', 3341.00, ''),
(460, 'Ansitz Vogelsang', 'BedBreakfast', 2768.00, ''),
(461, 'Ansitz von Wohlgemuth', 'Farm', 4548.00, ''),
(462, 'Ansitz Waldner Oberwirt', 'Farm', 921.00, ''),
(463, 'Ansitz Weissenheim', 'Farm', 4726.00, ''),
(464, 'Wendelstein', 'BedBreakfast', 4879.00, 'https://images.pexels.com/photos/19139076/pexels-photo-19139076.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(465, 'Ansitz Wieshof', 'BedBreakfast', 2201.00, ''),
(466, 'Ansitz Wildberg', 'HotelPension', 2021.00, ''),
(467, 'Ansitz Zehentner', 'Farm', 2357.00, ''),
(468, 'Ansitz Zinnenberg', 'BedBreakfast', 607.00, ''),
(469, 'Ansitz zum Löwen', 'HotelPension', 2638.00, ''),
(470, 'anstatthotel Business Apartments', 'Notdefined', 1576.00, ''),
(471, 'Anterleghes Arthotel', 'HotelPension', 2644.00, ''),
(472, 'Antermont OHG', 'BedBreakfast', 2809.00, ''),
(473, 'Antholzer Wildsee Haus', 'HotelPension', 4712.00, ''),
(474, 'Antica Osteria Dazio', 'Notdefined', 3302.00, ''),
(475, 'Anton Dolomites Hideaway', 'BedBreakfast', 1134.00, 'https://images.pexels.com/photos/20743263/pexels-photo-20743263.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(476, 'Anton Nature Hideaway', 'BedBreakfast', 4935.00, ''),
(477, 'Antonya Apartments', 'HotelPension', 801.00, ''),
(478, 'Anwalthof', 'BedBreakfast', 2642.00, ''),
(479, 'Apaliving - Das Budgethotel', 'HotelPension', 3440.00, 'https://media-v2.discover.swiss/rawmedia/hs/00061825_m.jpg'),
(480, 'Apartement Chiusa', 'BedBreakfast', 2808.00, ''),
(481, 'Apartement Fill Paul', 'BedBreakfast', 2292.00, ''),
(482, 'Apartement Fingerhut', 'BedBreakfast', 1931.00, ''),
(483, 'Apartement Klosterblick', 'BedBreakfast', 3777.00, ''),
(484, 'Apartement \"Nadia\" Residence Cavour', 'BedBreakfast', 3466.00, ''),
(485, 'Apartement Schlossblick Naturholz', 'BedBreakfast', 2233.00, ''),
(486, 'Apartements Margit', 'HotelPension', 2857.00, ''),
(487, 'Apartement Sonnblick', 'BedBreakfast', 2336.00, ''),
(488, 'Apartement Sunshine', 'BedBreakfast', 2003.00, 'https://images.pexels.com/photos/31728412/pexels-photo-31728412.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(489, 'Apartements Unterburg', 'BedBreakfast', 3366.00, ''),
(490, 'Apart Garni Motnaida', 'HotelPension', 3943.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010502511212/TDS00020010010367324/TDS00020010805219988.jpg'),
(491, 'Apart Hôtel 46a', 'HotelPension', 3034.00, ''),
(492, 'APARTHOTEL aarau-WEST Swiss Quality', 'HotelPension', 974.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/18dfae19-078c-4534-83b5-6cda41615c71.jpg'),
(493, 'Aparthotel abinà', 'HotelPension', 2745.00, ''),
(494, 'Aparthotel Adagio Basel City', 'HotelPension', 871.00, 'https://media-v2.discover.swiss/rawmedia/hs/00087898_m.jpg'),
(495, 'Aparthotel Adagio Geneve Mont Blanc', 'HotelPension', 1899.00, ''),
(496, 'Aparthotel Adagio Zürich City Center', 'HotelPension', 800.00, 'https://media-v2.discover.swiss/rawmedia/hs/00103566_c4a71b4cbda19bad600afbc356750b54_m.jpg'),
(497, 'Apart Hotel Adelboden', 'HotelPension', 1538.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/feccb571-7157-4405-b60c-5b1fbbe931fc.jpg'),
(498, 'Aparthotel Al Lago', 'HotelPension', 3158.00, 'https://media-v2.discover.swiss/rawmedia/hs/00065398_m.jpg'),
(499, 'Aparthotel Alpenspitz', 'HotelPension', 2027.00, ''),
(500, 'Aparthotel Alpine Lodge Colosseo', 'Notdefined', 4149.00, ''),
(501, 'Aparthotel Ambassador', 'HotelPension', 2449.00, 'https://resc.deskline.net/images/SAA/1/d2732eab-5c45-4788-a277-b539726e8436/99/image.jpg'),
(502, 'Aparthotel Baden', 'HotelPension', 3503.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020012930671612/TDS00020010000158950/TDS00020012951001709.jpg'),
(503, 'Aparthotel Beinwil am See', 'HotelPension', 4619.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/c642a676-3c99-4708-8ba5-d6462ae91e43.jpg'),
(504, 'Aparthotel Castle', 'Notdefined', 2685.00, ''),
(505, 'Aparthotel Chesa Grischuna', 'HotelPension', 1182.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010497664997/TDS00020010000158950/TDS00020014547186706.jpg'),
(506, 'Aparthotel Edy Bruggmann', 'HotelPension', 971.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010376221880/TDS00020010000158950/TDS00020011184087396.jpg'),
(507, 'Aparthotel Familiaris - Family Apartments - Pools & Spa in Dolomites', 'HotelPension', 1499.00, ''),
(508, 'APARTHOTEL Familie Hugenschmidt', 'HotelPension', 1105.00, 'https://www.zuerich.com/sites/default/files/imagegallery/web_aussenansicht.jpg'),
(509, 'Aparthotel Garni Chasa Alvetern', 'HotelPension', 4353.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010350501567/TDS00020010000158950/TDS00020011914450746.jpg'),
(510, 'Aparthotel Garni Christophorus', 'HotelPension', 689.00, ''),
(511, 'Aparthotel Garni Hubertus', 'HotelPension', 4098.00, ''),
(512, 'Aparthotel Il Momento Bern Expo', 'Notdefined', 2035.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/a626d3ed-c20f-410f-97d4-473a79be63d9.jpg'),
(513, 'Aparthotel Laurena', 'HotelPension', 1780.00, 'https://images.pexels.com/photos/27497695/pexels-photo-27497695.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(514, 'Aparthotel Maso Corto', 'HotelPension', 4912.00, ''),
(515, 'Aparthotel Monte Rosa', 'Notdefined', 4427.00, ''),
(516, 'Aparthotel Muchetta', 'HotelPension', 3088.00, 'https://media-v2.discover.swiss/rawmedia/hs/00083680_m.jpg'),
(517, 'Aparthotel My Daum', 'HotelPension', 1701.00, ''),
(518, 'Aparthotel Panorama', 'HotelPension', 3038.00, ''),
(519, 'Aparthotel Panorama Living Dolomites', 'HotelPension', 2263.00, ''),
(520, 'Aparthotel Pichler', 'HotelPension', 1394.00, ''),
(521, 'Aparthotel Pichlerhof', 'HotelPension', 4305.00, ''),
(522, 'Aparthotel Pöstli', 'HotelPension', 670.00, 'https://media-v2.discover.swiss/rawmedia/hs/00002953_m.jpg'),
(523, 'Aparthotel S-Bernardino', 'Notdefined', 1149.00, ''),
(524, 'Aparthotel Stricker', 'HotelPension', 4786.00, ''),
(525, 'Aparthotel Viktoria', 'HotelPension', 3315.00, ''),
(526, 'Apart Hotel Wiggertal', 'Notdefined', 847.00, ''),
(527, 'Apart-Hotel Zurich Airport', 'HotelPension', 3092.00, 'https://media-v2.discover.swiss/rawmedia/hs/00062712_m.jpg'),
(528, 'Apart. Mainardi', 'BedBreakfast', 3893.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(529, 'Apartment 1', 'BedBreakfast', 2895.00, ''),
(530, 'Apartment 13', 'BedBreakfast', 2701.00, ''),
(531, 'Apartment 16', 'BedBreakfast', 1595.00, ''),
(532, 'Apartment 19', 'BedBreakfast', 2535.00, ''),
(533, 'Apartment 39012', 'BedBreakfast', 2831.00, ''),
(534, 'Apartment 71', 'BedBreakfast', 3954.00, ''),
(535, 'Apartment 901', 'BedBreakfast', 4401.00, ''),
(536, 'Apartment Adele', 'BedBreakfast', 629.00, ''),
(537, 'APARTMENT A.HOFER', 'BedBreakfast', 3601.00, ''),
(538, 'Apartment Aiarëi', 'Farm', 4492.00, ''),
(539, 'Apartment Allium', 'BedBreakfast', 2012.00, ''),
(540, 'Apartment Amalia', 'BedBreakfast', 2404.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(541, 'Apartment Am Hang', 'Farm', 3876.00, ''),
(542, 'Apartment Amie Chalet', 'BedBreakfast', 3446.00, ''),
(543, 'Apartment Am See 1 & 2', 'BedBreakfast', 3468.00, ''),
(544, 'Apartment Ando', 'BedBreakfast', 2120.00, ''),
(545, 'Apartment Anna', 'BedBreakfast', 3158.00, ''),
(546, 'Apartment Argentis Liensberger Bernardette', 'BedBreakfast', 1528.00, ''),
(547, 'Apartment Aucina', 'BedBreakfast', 4923.00, ''),
(548, 'Apartment Aurora', 'BedBreakfast', 1203.00, ''),
(549, 'Apartment Avea', 'BedBreakfast', 973.00, ''),
(550, 'Apartment Avita Loft', 'BedBreakfast', 732.00, ''),
(551, 'Apartment Azalea', 'BedBreakfast', 2574.00, ''),
(552, 'APARTMENT BARBARA', 'BedBreakfast', 1322.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(553, 'Apartment Bären Seengen', 'HotelPension', 2469.00, 'https://media-v2.discover.swiss/rawmedia/hs-my/98a5a528-f77a-4b11-b7ec-ec4c113bae6e.jpg'),
(554, 'APARTMENT BATZEN', 'BedBreakfast', 1439.00, ''),
(555, 'apartment beletage', 'BedBreakfast', 1664.00, ''),
(556, 'APARTMENT BELLA VISTA', 'BedBreakfast', 662.00, ''),
(557, 'Apartment Belvedere by Hoila Guests', 'BedBreakfast', 4073.00, ''),
(558, 'Apartment Bergkristall', 'BedBreakfast', 3285.00, ''),
(559, 'Appartment Bergweg', 'BedBreakfast', 2645.00, ''),
(560, 'Apartment Bergzeit', 'BedBreakfast', 3840.00, ''),
(561, 'Apartment Berta', 'BedBreakfast', 2461.00, ''),
(562, 'APARTMENT BOLZANO', 'BedBreakfast', 1166.00, ''),
(563, 'Apartment Bon Dì - Patrick Demetz', 'BedBreakfast', 912.00, ''),
(564, 'Apartment Brunico Central', 'BedBreakfast', 1028.00, ''),
(565, 'APARTMENT CA\' DE BEZZI', 'BedBreakfast', 4481.00, 'https://images.pexels.com/photos/11933088/pexels-photo-11933088.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(566, 'Apartment Caldara 4', 'BedBreakfast', 3852.00, ''),
(567, 'Apartment Cardini Maria Elisabetta', 'BedBreakfast', 1007.00, ''),
(568, 'Apartment Carmen', 'BedBreakfast', 2714.00, ''),
(569, 'Apartment Cësa Larjëi', 'BedBreakfast', 3203.00, ''),
(570, 'Apartment Cësa Metz', 'BedBreakfast', 2253.00, ''),
(571, 'Apartment Christoph', 'BedBreakfast', 2658.00, ''),
(572, 'APARTMENT CITYFEELING', 'BedBreakfast', 3586.00, ''),
(573, 'Apartment Cristina', 'BedBreakfast', 3062.00, ''),
(574, 'Apartment Dasser', 'BedBreakfast', 4142.00, ''),
(575, 'Apartment \"Delizioso\"', 'BedBreakfast', 3466.00, ''),
(576, 'Apartment Demetz Perathoner Annemarì', 'BedBreakfast', 2634.00, ''),
(577, 'Apartment Domus', 'BedBreakfast', 4466.00, 'https://images.pexels.com/photos/11933088/pexels-photo-11933088.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(578, 'Apartment Donna Diana', 'BedBreakfast', 3144.00, ''),
(579, 'Apartment Dorfruhe', 'BedBreakfast', 4072.00, ''),
(580, 'Apartment Dreiland', 'BedBreakfast', 1533.00, ''),
(581, 'Apartment Edith', 'BedBreakfast', 1579.00, ''),
(582, 'Appartement Egghof', 'BedBreakfast', 2358.00, ''),
(583, 'Apartment Elina', 'BedBreakfast', 4702.00, ''),
(584, 'Apartment Elisa', 'BedBreakfast', 3892.00, ''),
(585, 'Apartment Enrosadira', 'BedBreakfast', 4700.00, ''),
(586, 'APARTMENT EVA', 'BedBreakfast', 838.00, ''),
(587, 'Apartment Eva Verdins', 'BedBreakfast', 606.00, ''),
(588, 'Apartment Falzes 1', 'BedBreakfast', 2056.00, ''),
(589, 'Apartment Falzes 2', 'BedBreakfast', 3194.00, 'https://images.pexels.com/photos/15721826/pexels-photo-15721826.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(590, 'Apartment Finkenhöhe', 'BedBreakfast', 3940.00, ''),
(591, 'Apartment Florian Torggler', 'Farm', 3553.00, ''),
(592, 'Apartment Förster', 'BedBreakfast', 1597.00, ''),
(593, 'Apartment Franzl', 'BedBreakfast', 2112.00, ''),
(594, 'Apartment Frisch', 'BedBreakfast', 2298.00, ''),
(595, 'Apartment Fuchsberger', 'BedBreakfast', 3920.00, ''),
(596, 'Apartment Garden 14', 'BedBreakfast', 2931.00, ''),
(597, 'Apartment Gasser - Mühlenweg', 'BedBreakfast', 4970.00, ''),
(598, 'Apartment Geranie', 'BedBreakfast', 751.00, ''),
(599, 'Holiday flat Gerwies', 'Farm', 4386.00, ''),
(600, 'Apartment Glärnisch', 'Apartment', 4221.00, 'https://media-v2.discover.swiss/rawmedia/ctd/63c43b847dd589d6f5657cf3024d29393430d73a_Apartment_Gl__rnisch_1.jpg'),
(601, 'APARTMENT GOETHE 1', 'BedBreakfast', 2510.00, ''),
(602, 'Apartment Gojer', 'Farm', 789.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(603, 'Apartment Grafenstein', 'BedBreakfast', 3185.00, ''),
(604, 'APARTMENT G. VERDI', 'BedBreakfast', 1634.00, ''),
(605, 'Apartment Hagen', 'BedBreakfast', 3651.00, ''),
(606, 'Apartment Haidenschaft', 'BedBreakfast', 4362.00, ''),
(607, 'Apartment HaNiLe', 'BedBreakfast', 2660.00, ''),
(608, 'Apartment Hanna', 'BedBreakfast', 3880.00, ''),
(609, 'Apartment Hanni', 'BedBreakfast', 602.00, ''),
(610, 'Apartment Happiness', 'BedBreakfast', 3194.00, ''),
(611, 'Apartmenthaus 34', 'BedBreakfast', 2775.00, ''),
(612, 'Apartments Apartmenthaus am Waalweg - Hafele Georg', 'BedBreakfast', 2979.00, ''),
(613, 'Apartment Feyerlin', 'HotelPension', 4228.00, ''),
(614, 'Apartments Fuchsmaurer', 'BedBreakfast', 4708.00, 'https://images.pexels.com/photos/28751482/pexels-photo-28751482.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(615, 'Apartmenthaus Gauenpark (CharmingStay)', 'Apartment', 3626.00, 'https://media-v2.discover.swiss/rawmedia/ctd/f3f5de04dafe10a8478590f38efc8b8bb56b746c_11.jpg'),
(616, 'Apartment Haus Martin', 'BedBreakfast', 1021.00, ''),
(617, 'Apartmenthaus Obermayr', 'HotelPension', 1055.00, ''),
(618, 'Apartment Haus Schloss Tirol Alexandra', 'BedBreakfast', 3513.00, '');
INSERT INTO `accommodations` (`Accommodation_ID`, `Name`, `Type`, `Price_PN`, `Image`) VALUES
(619, 'Apartment Heinz', 'BedBreakfast', 766.00, ''),
(620, 'Apartment Helga', 'BedBreakfast', 880.00, ''),
(621, 'Apartment Hildegard', 'BedBreakfast', 4292.00, ''),
(622, 'Apartment Himmelreich', 'BedBreakfast', 1266.00, ''),
(623, 'Apartment Hofgarten', 'BedBreakfast', 4709.00, ''),
(624, 'Apartment HoPla', 'BedBreakfast', 3170.00, ''),
(625, 'Apartment Hotel Christine', 'HotelPension', 2445.00, ''),
(626, 'Apartmenthotel Ritterhof **** Suites & Breakfast', 'HotelPension', 2896.00, ''),
(627, 'Apartmenthouse Stern', 'BedBreakfast', 2533.00, ''),
(628, 'Apartment Huck', 'BedBreakfast', 1684.00, 'https://images.pexels.com/photos/31728412/pexels-photo-31728412.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(629, 'Apartment Hugo & Elly', 'BedBreakfast', 2728.00, ''),
(630, 'APARTMENT HUITA', 'BedBreakfast', 1658.00, ''),
(631, 'Apartment Iris', 'BedBreakfast', 4643.00, ''),
(632, 'Apartment Irmgard und Fabio', 'BedBreakfast', 1327.00, ''),
(633, 'Apartment Isabel', 'BedBreakfast', 3097.00, ''),
(634, 'APARTMENT ISABEL', 'BedBreakfast', 2983.00, ''),
(635, 'Apartment ISL 22', 'BedBreakfast', 2515.00, ''),
(636, 'Apartment Jade', 'BedBreakfast', 4210.00, ''),
(637, 'Apartment Jägerhaus', 'BedBreakfast', 4722.00, ''),
(638, 'Apartment Karina Lauben Lodge', 'BedBreakfast', 3199.00, ''),
(639, 'Apartment Kastelruth', 'BedBreakfast', 4404.00, ''),
(640, 'Apartment Kevin', 'BedBreakfast', 4978.00, 'https://images.pexels.com/photos/31728412/pexels-photo-31728412.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(641, 'Apartment Kitzbühel', 'BedBreakfast', 871.00, ''),
(642, 'Apartment Klara', 'BedBreakfast', 4271.00, ''),
(643, 'Apartment Kleo - Kerenzerberg', 'Apartment', 941.00, 'https://media-v2.discover.swiss/rawmedia/ctd/78711bd72a6f839c9e4767d543c109be2be1b8d2_Apartement_Kleo_Schild.jpg'),
(644, 'Apartment Kreuzwegerhof', 'BedBreakfast', 4104.00, ''),
(645, 'Apartment Kurhaus', 'BedBreakfast', 1120.00, ''),
(646, 'Apartment La Brunella', 'BedBreakfast', 3626.00, ''),
(647, 'Apartment La Funtana', 'BedBreakfast', 4274.00, ''),
(648, 'APARTMENT LA GIOIOSA', 'BedBreakfast', 3435.00, ''),
(649, 'Apartment Lamondis', 'BedBreakfast', 1711.00, ''),
(650, 'Apartment Lavendel', 'BedBreakfast', 3242.00, ''),
(651, 'Apartment Lea', 'BedBreakfast', 1879.00, ''),
(652, 'APARTMENT LEONARDO', 'BedBreakfast', 3000.00, ''),
(653, 'Apartment Lichtenegg', 'BedBreakfast', 3959.00, 'https://images.pexels.com/photos/28751482/pexels-photo-28751482.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(654, 'Apartment Love', 'BedBreakfast', 4922.00, ''),
(655, 'Apartment Luam', 'BedBreakfast', 3333.00, ''),
(656, 'Apartment Luisa', 'BedBreakfast', 1216.00, ''),
(657, 'Apartment Lumos', 'BedBreakfast', 3752.00, ''),
(658, 'Apartment Maja', 'BedBreakfast', 4835.00, ''),
(659, 'Apartment Manuela Meran', 'BedBreakfast', 564.00, ''),
(660, 'Apartment Marcher - Melisse', 'BedBreakfast', 738.00, ''),
(661, 'APARTMENT MARIE', 'BedBreakfast', 1398.00, ''),
(662, 'Apartment Marillen', 'BedBreakfast', 779.00, ''),
(663, 'APARTMENT MATHILDA', 'BedBreakfast', 3477.00, ''),
(664, 'Apartment Matilde', 'BedBreakfast', 3419.00, ''),
(665, 'Apartment Maximilian', 'BedBreakfast', 2134.00, 'https://images.pexels.com/photos/28575352/pexels-photo-28575352.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(666, 'Apartment Memory', 'BedBreakfast', 3062.00, ''),
(667, 'Apartment Mendelbahn', 'BedBreakfast', 1163.00, ''),
(668, 'Apartment Merano', 'BedBreakfast', 1715.00, ''),
(669, 'Apartment Merano Mitte', 'BedBreakfast', 2227.00, ''),
(670, 'Apartment Mia', 'BedBreakfast', 1810.00, ''),
(671, 'Apartment Mittermanting', 'BedBreakfast', 1794.00, ''),
(672, 'Apartment Moar Mühle', 'BedBreakfast', 550.00, ''),
(673, 'Apartment Mountain Suite', 'BedBreakfast', 2927.00, ''),
(674, 'Apartment Mulin d\'Odun', 'BedBreakfast', 4038.00, ''),
(675, 'Apartment Mulino', 'BedBreakfast', 3578.00, ''),
(676, 'Apartment N.2', 'BedBreakfast', 775.00, ''),
(677, 'Apartment Neuhaus', 'BedBreakfast', 3418.00, ''),
(678, 'Apartment Noldins Scheune', 'BedBreakfast', 2082.00, 'https://images.pexels.com/photos/32940724/pexels-photo-32940724.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(679, 'Appartement Nonstop', 'BedBreakfast', 3453.00, ''),
(680, 'Apartment Nucis', 'BedBreakfast', 3676.00, ''),
(681, 'Apartment Obereggen-Anna', 'BedBreakfast', 4801.00, ''),
(682, 'Apartment Obermair', 'BedBreakfast', 1578.00, ''),
(683, 'Apartment Oberprisch', 'BedBreakfast', 4882.00, ''),
(684, 'Apartment Obkircher', 'BedBreakfast', 4098.00, ''),
(685, 'Apartment Oleander', 'BedBreakfast', 2492.00, ''),
(686, 'Apartment Olympic', 'BedBreakfast', 4715.00, ''),
(687, 'Apartment Panorama', 'BedBreakfast', 1358.00, ''),
(688, 'Apartment Panorama Walensee', 'Apartment', 2744.00, 'https://media-v2.discover.swiss/rawmedia/ctd/52b3300976139bcf0124fbc87a67a21d00790754_Apartment_Panorama_Walensee_1.jpg'),
(689, 'Apartment Paola', 'BedBreakfast', 2680.00, ''),
(690, 'Apartment Patrizia', 'BedBreakfast', 752.00, ''),
(691, 'Apartment Petz', 'BedBreakfast', 1788.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(692, 'Apartment Pfeifhofer', 'BedBreakfast', 1213.00, ''),
(693, 'Apartment Plantitsch', 'BedBreakfast', 3557.00, ''),
(694, 'Apartment Plattwies', 'BedBreakfast', 1423.00, ''),
(695, 'Apartment \"Plose35\"', 'BedBreakfast', 3327.00, ''),
(696, 'APARTMENT QUIREIN', 'BedBreakfast', 983.00, ''),
(697, 'Apartment Raffl', 'BedBreakfast', 2853.00, ''),
(698, 'Apartment Reiterer', 'BedBreakfast', 3381.00, ''),
(699, 'Apartements Residence Alagundis', 'HotelPension', 1113.00, ''),
(700, 'Apartment Roderer', 'BedBreakfast', 525.00, ''),
(701, 'Apartment Roma', 'BedBreakfast', 1890.00, ''),
(702, 'Apartment Römerbrücke', 'BedBreakfast', 2260.00, ''),
(703, 'Apartment Rosmarin', 'BedBreakfast', 3891.00, ''),
(704, 'Apartment Ruprecht', 'HotelPension', 1705.00, 'https://images.pexels.com/photos/15393708/pexels-photo-15393708.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(705, 'Apartments 55', 'BedBreakfast', 1331.00, ''),
(706, 'App. Abfalterer Markus', 'BedBreakfast', 4996.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Booking_Date` date NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  `Booking_Type` enum('Solo','Group') NOT NULL,
  `User_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`Booking_ID`, `Package_ID`, `Booking_Date`, `Start_Date`, `End_Date`, `Booking_Type`, `User_ID`) VALUES
(1, 1, '2026-01-10', '2026-06-01', '2026-06-05', 'Solo', NULL),
(2, 2, '2026-02-15', '2026-07-10', '2026-07-13', 'Solo', NULL),
(3, 3, '2026-03-01', '2026-08-20', '2026-08-26', 'Group', NULL),
(4, 3, '2026-03-01', '2026-08-20', '2026-08-26', 'Solo', NULL),
(5, 1, '2026-03-10', '2026-09-01', '2026-09-05', 'Solo', NULL),
(6, 2, '2026-04-05', '2026-10-15', '2026-10-18', 'Solo', NULL),
(7, 1, '2026-05-20', '2026-05-20', '2026-05-25', 'Group', NULL),
(8, 1, '2026-05-20', '2026-05-20', '2026-05-25', 'Group', NULL),
(9, 1, '2026-05-24', '2026-05-24', '2026-05-29', 'Group', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_travelers`
--

CREATE TABLE `booking_travelers` (
  `Booking_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Joined_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_travelers`
--

INSERT INTO `booking_travelers` (`Booking_ID`, `User_ID`, `Joined_Date`) VALUES
(1, 1, '2026-01-10'),
(2, 2, '2026-02-15'),
(3, 1, '2026-03-01'),
(3, 2, '2026-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `booking_traveller_details`
--

CREATE TABLE `booking_traveller_details` (
  `Detail_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Cell` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `Destination_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`Destination_ID`, `Name`, `Country`, `Image`) VALUES
(1, 'Cape Town', 'South Africa', 'https://images.com/capetown.jpg'),
(2, 'Kruger National Park', 'South Africa', 'https://images.com/kruger.jpg'),
(3, 'Garden Route', 'South Africa', 'https://images.com/gardenroute.jpg'),
(4, 'The Valley', 'Anguilla', 'https://images.pexels.com/photos/27742994/pexels-photo-27742994.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(5, 'Guatemala City', 'Guatemala', 'https://images.pexels.com/photos/11818244/pexels-photo-11818244.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(6, 'Banjul', 'Gambia', 'https://images.pexels.com/photos/32839809/pexels-photo-32839809.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(7, 'Mexico City', 'Mexico', 'https://images.pexels.com/photos/19911890/pexels-photo-19911890.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(8, 'Lilongwe', 'Malawi', 'https://images.pexels.com/photos/34936103/pexels-photo-34936103.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(9, 'Adamstown', 'Pitcairn Islands', 'https://images.pexels.com/photos/33440163/pexels-photo-33440163.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(10, 'Buenos Aires', 'Argentina', 'https://images.pexels.com/photos/22718715/pexels-photo-22718715.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(11, 'Hagåtña', 'Guam', 'https://images.pexels.com/photos/14739830/pexels-photo-14739830.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(12, 'Sofia', 'Bulgaria', 'https://images.pexels.com/photos/18345751/pexels-photo-18345751.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(13, 'Roseau', 'Dominica', 'https://images.pexels.com/photos/29711253/pexels-photo-29711253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(14, 'London', 'United Kingdom', 'https://images.pexels.com/photos/19211707/pexels-photo-19211707.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(15, 'Palikir', 'Micronesia', 'https://images.pexels.com/photos/15829235/pexels-photo-15829235.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(16, 'Ramallah', 'Palestine', 'https://images.pexels.com/photos/35562079/pexels-photo-35562079.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(17, 'Willemstad', 'Curaçao', 'https://images.pexels.com/photos/16215569/pexels-photo-16215569.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(18, 'Kigali', 'Rwanda', 'https://images.pexels.com/photos/31466702/pexels-photo-31466702.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(19, 'City of Victoria', 'Hong Kong', 'https://images.pexels.com/photos/34362624/pexels-photo-34362624.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(20, 'Tashkent', 'Uzbekistan', 'https://images.pexels.com/photos/11014631/pexels-photo-11014631.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(21, 'Beijing', 'China', 'https://images.pexels.com/photos/36541875/pexels-photo-36541875.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(22, 'Nicosia', 'Cyprus', 'https://images.pexels.com/photos/35827647/pexels-photo-35827647.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(23, 'Oranjestad', 'Aruba', 'https://images.pexels.com/photos/16164623/pexels-photo-16164623.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(24, 'Saint-Denis', 'Réunion', 'https://images.pexels.com/photos/32296380/pexels-photo-32296380.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(25, 'Seoul', 'South Korea', 'https://images.pexels.com/photos/18495176/pexels-photo-18495176.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(26, 'Not Available', 'Antarctica', 'https://images.pexels.com/photos/31186568/pexels-photo-31186568.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(27, 'Mogadishu', 'Somalia', 'https://images.pexels.com/photos/33836939/pexels-photo-33836939.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(28, 'Beirut', 'Lebanon', 'https://images.pexels.com/photos/5054955/pexels-photo-5054955.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(29, 'Conakry', 'Guinea', 'https://images.pexels.com/photos/17732544/pexels-photo-17732544.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(30, 'Dushanbe', 'Tajikistan', 'https://images.pexels.com/photos/9376018/pexels-photo-9376018.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(31, 'Kuala Lumpur', 'Malaysia', 'https://images.pexels.com/photos/27118624/pexels-photo-27118624.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(32, 'Pyongyang', 'North Korea', 'https://images.pexels.com/photos/21629276/pexels-photo-21629276.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(33, 'Freetown', 'Sierra Leone', 'https://images.pexels.com/photos/36607739/pexels-photo-36607739.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(34, 'Porto-Novo', 'Benin', 'https://images.pexels.com/photos/34268987/pexels-photo-34268987.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(35, 'Rome', 'Italy', 'https://images.pexels.com/photos/12496253/pexels-photo-12496253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(36, 'Port of Spain', 'Trinidad and Tobago', 'https://images.pexels.com/photos/31113191/pexels-photo-31113191.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(37, 'Riyadh', 'Saudi Arabia', 'https://images.pexels.com/photos/30320203/pexels-photo-30320203.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(38, 'San José', 'Costa Rica', 'https://images.pexels.com/photos/35730891/pexels-photo-35730891.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(39, 'Belgrade', 'Serbia', 'https://images.pexels.com/photos/34432817/pexels-photo-34432817.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(40, 'Fakaofo', 'Tokelau', 'https://images.pexels.com/photos/19844887/pexels-photo-19844887.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(41, 'Ulan Bator', 'Mongolia', 'https://images.pexels.com/photos/8285604/pexels-photo-8285604.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(42, 'Bandar Seri Begawan', 'Brunei', 'https://images.pexels.com/photos/34787043/pexels-photo-34787043.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(43, 'Budapest', 'Hungary', 'https://images.pexels.com/photos/34430996/pexels-photo-34430996.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(44, 'Maputo', 'Mozambique', 'https://images.pexels.com/photos/30188147/pexels-photo-30188147.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(45, 'South Tarawa', 'Kiribati', 'https://images.pexels.com/photos/33661014/pexels-photo-33661014.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(46, 'Port-au-Prince', 'Haiti', 'https://images.pexels.com/photos/18806088/pexels-photo-18806088.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(47, 'Phnom Penh', 'Cambodia', 'https://images.pexels.com/photos/16018464/pexels-photo-16018464.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(48, 'Cairo', 'Egypt', 'https://images.pexels.com/photos/21405346/pexels-photo-21405346.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(49, 'Ashgabat', 'Turkmenistan', 'https://images.pexels.com/photos/37251220/pexels-photo-37251220.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(50, 'Muscat', 'Oman', 'https://images.pexels.com/photos/35738331/pexels-photo-35738331.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(51, 'Kingston', 'Jamaica', 'https://images.pexels.com/photos/33995817/pexels-photo-33995817.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(52, 'Baku', 'Azerbaijan', 'https://images.pexels.com/photos/8412720/pexels-photo-8412720.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(53, 'Bratislava', 'Slovakia', 'https://images.pexels.com/photos/18875067/pexels-photo-18875067.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(54, 'Minsk', 'Belarus', 'https://images.pexels.com/photos/16180503/pexels-photo-16180503.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(55, 'Hanoi', 'Vietnam', 'https://images.pexels.com/photos/19822715/pexels-photo-19822715.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(56, 'Charlotte Amalie', 'United States Virgin Islands', 'https://images.pexels.com/photos/34650332/pexels-photo-34650332.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(57, 'Gibraltar', 'Gibraltar', 'https://images.pexels.com/photos/36800544/pexels-photo-36800544.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(58, 'Philipsburg', 'Sint Maarten', 'https://images.pexels.com/photos/13874216/pexels-photo-13874216.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(59, 'Mariehamn', 'Åland Islands', 'https://images.pexels.com/photos/12568150/pexels-photo-12568150.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(60, 'Damascus', 'Syria', 'https://images.pexels.com/photos/34632813/pexels-photo-34632813.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(61, 'Fort-de-France', 'Martinique', 'https://images.pexels.com/photos/27587791/pexels-photo-27587791.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(62, 'Nuuk', 'Greenland', 'https://images.pexels.com/photos/33348862/pexels-photo-33348862.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(63, 'Tegucigalpa', 'Honduras', 'https://images.pexels.com/photos/13863309/pexels-photo-13863309.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(64, 'Tunis', 'Tunisia', 'https://images.pexels.com/photos/20190784/pexels-photo-20190784.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(65, 'Moroni', 'Comoros', 'https://images.pexels.com/photos/7584205/pexels-photo-7584205.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(66, 'Ljubljana', 'Slovenia', 'https://images.pexels.com/photos/37320095/pexels-photo-37320095.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(67, 'Bern', 'Switzerland', 'https://images.pexels.com/photos/22180919/pexels-photo-22180919.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(68, 'St. Peter Port', 'Guernsey', 'https://images.pexels.com/photos/11953768/pexels-photo-11953768.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(69, 'Naypyidaw', 'Myanmar', 'https://images.pexels.com/photos/30827826/pexels-photo-30827826.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(70, 'Asunción', 'Paraguay', 'https://images.pexels.com/photos/34246665/pexels-photo-34246665.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(71, 'Kralendijk', 'Caribbean Netherlands', 'https://images.pexels.com/photos/31868051/pexels-photo-31868051.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(72, 'Bridgetown', 'Barbados', 'https://images.pexels.com/photos/32115340/pexels-photo-32115340.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(73, 'Not Available', 'Macau', 'https://images.pexels.com/photos/31186568/pexels-photo-31186568.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(74, 'Amman', 'Jordan', ''),
(75, 'Vientiane', 'Laos', 'https://images.pexels.com/photos/27087123/pexels-photo-27087123.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(76, 'Lomé', 'Togo', ''),
(77, 'Rabat', 'Morocco', ''),
(78, 'San Juan', 'Puerto Rico', ''),
(79, 'Cayenne', 'French Guiana', ''),
(80, 'Saint-Pierre', 'Saint Pierre and Miquelon', ''),
(81, 'Marigot', 'Saint Martin', ''),
(82, 'Tallinn', 'Estonia', 'https://images.pexels.com/photos/35838020/pexels-photo-35838020.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(83, 'Jakarta', 'Indonesia', ''),
(84, 'Victoria', 'Seychelles', ''),
(85, 'Bamako', 'Mali', ''),
(86, 'Dili', 'Timor-Leste', 'https://images.pexels.com/photos/36746935/pexels-photo-36746935.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(87, 'Brasília', 'Brazil', ''),
(88, 'Accra', 'Ghana', ''),
(89, 'Nairobi', 'Kenya', ''),
(90, 'Reykjavik', 'Iceland', ''),
(91, 'Antananarivo', 'Madagascar', ''),
(92, 'Dhaka', 'Bangladesh', 'https://images.pexels.com/photos/11576092/pexels-photo-11576092.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(93, 'Kinshasa', 'DR Congo', ''),
(94, 'Harare', 'Zimbabwe', ''),
(95, 'Papeetē', 'French Polynesia', ''),
(96, 'Ankara', 'Turkey', ''),
(97, 'Praia', 'Cape Verde', 'https://images.pexels.com/photos/31643646/pexels-photo-31643646.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(98, 'Santo Domingo', 'Dominican Republic', ''),
(99, 'Nassau', 'Bahamas', ''),
(100, 'Berlin', 'Germany', ''),
(101, 'Paramaribo', 'Suriname', ''),
(102, 'Nuku\'alofa', 'Tonga', ''),
(103, 'Diego Garcia', 'British Indian Ocean Territory', ''),
(104, 'Castries', 'Saint Lucia', 'https://images.pexels.com/photos/16212946/pexels-photo-16212946.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(105, 'Dublin', 'Ireland', ''),
(106, 'Vatican City', 'Vatican City', ''),
(107, 'Bogotá', 'Colombia', ''),
(108, 'Lisbon', 'Portugal', 'https://images.pexels.com/photos/33659330/pexels-photo-33659330.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(109, 'Tórshavn', 'Faroe Islands', ''),
(110, 'São Tomé', 'São Tomé and Príncipe', ''),
(111, 'Saipan', 'Northern Mariana Islands', ''),
(112, 'Saint Helier', 'Jersey', ''),
(113, 'Mamoudzou', 'Mayotte', ''),
(114, 'Sana\'a', 'Yemen', ''),
(115, 'Abuja', 'Nigeria', ''),
(116, 'Kabul', 'Afghanistan', 'https://images.pexels.com/photos/19734671/pexels-photo-19734671.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(117, 'Gaborone', 'Botswana', ''),
(118, 'Douglas', 'Isle of Man', ''),
(119, 'San Salvador', 'El Salvador', 'https://images.pexels.com/photos/36708470/pexels-photo-36708470.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(120, 'Kampala', 'Uganda', ''),
(121, 'Andorra la Vella', 'Andorra', ''),
(122, 'Cockburn Town', 'Turks and Caicos Islands', ''),
(123, 'N\'Djamena', 'Chad', ''),
(124, 'Helsinki', 'Finland', ''),
(125, 'Moscow', 'Russia', ''),
(126, 'Astana', 'Kazakhstan', ''),
(127, 'Longyearbyen', 'Svalbard and Jan Mayen', ''),
(128, 'Caracas', 'Venezuela', 'https://images.pexels.com/photos/29518260/pexels-photo-29518260.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(129, 'Monaco', 'Monaco', ''),
(130, 'Dakar', 'Senegal', ''),
(131, 'Kathmandu', 'Nepal', ''),
(132, 'Abu Dhabi', 'United Arab Emirates', ''),
(133, 'Taipei', 'Taiwan', ''),
(134, 'Nouméa', 'New Caledonia', ''),
(135, 'Sucre', 'Bolivia', ''),
(136, 'Santiago', 'Chile', ''),
(137, 'Yamoussoukro', 'Ivory Coast', ''),
(138, 'Tripoli', 'Libya', ''),
(139, 'Lima', 'Peru', ''),
(140, 'Ottawa', 'Canada', ''),
(141, 'Paris', 'France', 'https://images.pexels.com/photos/5822697/pexels-photo-5822697.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(142, 'Djibouti', 'Djibouti', ''),
(143, 'Gitega', 'Burundi', ''),
(144, 'Pristina', 'Kosovo', ''),
(145, 'Copenhagen', 'Denmark', ''),
(146, 'Athens', 'Greece', ''),
(147, 'Prague', 'Czechia', ''),
(148, 'Asmara', 'Eritrea', ''),
(149, 'Windhoek', 'Namibia', ''),
(150, 'Road Town', 'British Virgin Islands', ''),
(151, 'Tehran', 'Iran', ''),
(152, 'Ciudad de la Paz', 'Equatorial Guinea', ''),
(153, 'Nouakchott', 'Mauritania', 'https://images.pexels.com/photos/33952950/pexels-photo-33952950.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(154, 'Manama', 'Bahrain', ''),
(155, 'West Island', 'Cocos (Keeling) Islands', ''),
(156, 'Addis Ababa', 'Ethiopia', ''),
(157, 'Lusaka', 'Zambia', ''),
(158, 'Sarajevo', 'Bosnia and Herzegovina', ''),
(159, 'Stanley', 'Falkland Islands', ''),
(160, 'St. George\'s', 'Grenada', ''),
(161, 'Bangkok', 'Thailand', ''),
(162, 'Bucharest', 'Romania', ''),
(163, 'Kingstown', 'Saint Vincent and the Grenadines', ''),
(164, 'Monrovia', 'Liberia', ''),
(165, 'Washington, D.C.', 'United States', ''),
(166, 'Juba', 'South Sudan', 'https://images.pexels.com/photos/6921052/pexels-photo-6921052.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(167, 'Not Available', 'Bouvet Island', 'https://images.pexels.com/photos/31186568/pexels-photo-31186568.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(168, 'Yerevan', 'Armenia', ''),
(169, 'Tokyo', 'Japan', ''),
(170, 'Islamabad', 'Pakistan', ''),
(171, 'Mbabane', 'Eswatini', ''),
(172, 'Vaduz', 'Liechtenstein', ''),
(173, 'Jerusalem', 'Israel', ''),
(174, 'Pago Pago', 'American Samoa', ''),
(175, 'Sri Jayawardenepura Kotte', 'Sri Lanka', ''),
(176, 'King Edward Point', 'South Georgia', ''),
(177, 'Tirana', 'Albania', ''),
(178, 'Algiers', 'Algeria', 'https://images.pexels.com/photos/13086946/pexels-photo-13086946.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(179, 'Kyiv', 'Ukraine', ''),
(180, 'Jamestown', 'Saint Helena, Ascension and Tristan da Cunha', ''),
(181, 'Not Available', 'Heard Island and McDonald Islands', 'https://images.pexels.com/photos/31186568/pexels-photo-31186568.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(182, 'City of San Marino', 'San Marino', ''),
(183, 'Havana', 'Cuba', ''),
(184, 'Yaren', 'Nauru', ''),
(185, 'Madrid', 'Spain', ''),
(186, 'Kuwait City', 'Kuwait', ''),
(187, 'Plymouth', 'Montserrat', ''),
(188, 'Port Louis', 'Mauritius', ''),
(189, 'Stockholm', 'Sweden', ''),
(190, 'Canberra', 'Australia', 'https://images.pexels.com/photos/17582203/pexels-photo-17582203.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(191, 'Yaoundé', 'Cameroon', ''),
(192, 'Quito', 'Ecuador', ''),
(193, 'Doha', 'Qatar', ''),
(194, 'Majuro', 'Marshall Islands', ''),
(195, 'Warsaw', 'Poland', ''),
(196, 'George Town', 'Cayman Islands', ''),
(197, 'Pretoria', 'South Africa', ''),
(198, 'Mata-Utu', 'Wallis and Futuna', ''),
(199, 'Apia', 'Samoa', ''),
(200, 'Amsterdam', 'Netherlands', ''),
(201, 'El Aaiún', 'Western Sahara', ''),
(202, 'Podgorica', 'Montenegro', ''),
(203, 'Thimphu', 'Bhutan', 'https://images.pexels.com/photos/31640266/pexels-photo-31640266.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(204, 'Valletta', 'Malta', ''),
(205, 'Port Vila', 'Vanuatu', ''),
(206, 'Dodoma', 'Tanzania', ''),
(207, 'Wellington', 'New Zealand', ''),
(208, 'Ngerulmud', 'Palau', ''),
(209, 'Panama City', 'Panama', ''),
(210, 'Funafuti', 'Tuvalu', ''),
(211, 'Suva', 'Fiji', ''),
(212, 'Managua', 'Nicaragua', ''),
(213, 'Bishkek', 'Kyrgyzstan', ''),
(214, 'Port-aux-Français', 'French Southern and Antarctic Lands', ''),
(215, 'Riga', 'Latvia', 'https://images.pexels.com/photos/37526826/pexels-photo-37526826.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(216, 'Tbilisi', 'Georgia', ''),
(217, 'Luxembourg', 'Luxembourg', ''),
(218, 'Vienna', 'Austria', ''),
(219, 'Skopje', 'North Macedonia', ''),
(220, 'Gustavia', 'Saint Barthélemy', ''),
(221, 'Flying Fish Cove', 'Christmas Island', ''),
(222, 'Honiara', 'Solomon Islands', ''),
(223, 'Saint John\'s', 'Antigua and Barbuda', ''),
(224, 'Baghdad', 'Iraq', ''),
(225, 'Chișinău', 'Moldova', 'https://images.pexels.com/photos/33155046/pexels-photo-33155046.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(226, 'Kingston', 'Norfolk Island', 'https://images.pexels.com/photos/33995817/pexels-photo-33995817.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(227, 'Brazzaville', 'Republic of the Congo', ''),
(228, 'Alofi', 'Niue', ''),
(229, 'Vilnius', 'Lithuania', ''),
(230, 'Niamey', 'Niger', ''),
(231, 'Georgetown', 'Guyana', ''),
(232, 'Hamilton', 'Bermuda', 'https://images.pexels.com/photos/32876087/pexels-photo-32876087.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(233, 'Libreville', 'Gabon', ''),
(234, 'Avarua', 'Cook Islands', ''),
(235, 'Luanda', 'Angola', ''),
(236, 'Oslo', 'Norway', ''),
(237, 'Basse-Terre', 'Guadeloupe', ''),
(238, 'Malé', 'Maldives', ''),
(239, 'Brussels', 'Belgium', ''),
(240, 'Zagreb', 'Croatia', ''),
(241, 'Belmopan', 'Belize', ''),
(242, 'Basseterre', 'Saint Kitts and Nevis', ''),
(243, 'Singapore', 'Singapore', ''),
(244, 'Maseru', 'Lesotho', ''),
(245, 'Montevideo', 'Uruguay', 'https://images.pexels.com/photos/12161968/pexels-photo-12161968.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(246, 'Ouagadougou', 'Burkina Faso', ''),
(247, 'New Delhi', 'India', ''),
(248, 'Manila', 'Philippines', ''),
(249, 'Bangui', 'Central African Republic', ''),
(250, 'Khartoum', 'Sudan', ''),
(251, 'Bissau', 'Guinea-Bissau', ''),
(252, 'Port Moresby', 'Papua New Guinea', ''),
(253, 'Washington DC', 'United States Minor Outlying Islands', '');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `Flight_ID` int(11) NOT NULL,
  `Airline` varchar(100) NOT NULL,
  `Departure_Loc` varchar(100) NOT NULL,
  `Arrival_Loc` varchar(100) NOT NULL,
  `Time_Dept` datetime NOT NULL,
  `Time_Arrive` datetime NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`Flight_ID`, `Airline`, `Departure_Loc`, `Arrival_Loc`, `Time_Dept`, `Time_Arrive`, `Price`) VALUES
(1, 'FlySafair', 'Johannesburg', 'Cape Town', '2026-06-01 08:00:00', '2026-06-01 10:00:00', 1800.00),
(2, 'Airlink', 'Johannesburg', 'Kruger Mpumalanga', '2026-06-02 11:00:00', '2026-06-02 12:30:00', 2500.00),
(3, 'FlySafair', 'Johannesburg', 'George', '2026-06-03 07:00:00', '2026-06-03 09:00:00', 1600.00),
(75, 'Private', 'Kwajalein', '', '2026-05-20 08:45:00', '2026-05-20 09:05:00', 1000.00),
(76, 'Batik Air', 'Kuala Lumpur International Airport (klia)', 'Presidente Nicolau Lobato International', '2026-05-20 02:15:00', '2026-05-20 07:30:00', 1000.00),
(77, 'Pel-Air', 'Dubbo', 'Sydney Kingsford Smith Airport', '2026-05-20 00:20:00', '2026-05-20 01:09:00', 1000.00),
(78, 'Bangkok Airways', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(79, 'SriLankan Airlines', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(80, 'TAP Air Portugal', 'Suvarnabhumi International', 'Brussels Airport', '2026-05-20 00:05:00', '2026-05-20 07:15:00', 1000.00),
(81, 'All Nippon Airways', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(82, 'El Al', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(83, 'Private', 'Adelaide International Airport', 'Port Pirie', '2026-05-20 00:35:00', '2026-05-20 01:01:00', 1000.00),
(84, 'Juneyao Air', 'Shanghai Pudong International', 'Haneda Airport', '2026-05-20 01:50:00', '2026-05-20 05:45:00', 1000.00),
(85, 'Air China', 'Shanghai Pudong International', 'Haneda Airport', '2026-05-20 01:50:00', '2026-05-20 05:45:00', 1000.00),
(86, 'Southwind Airlines', 'Orenburg', 'Antalya', '2026-05-20 01:10:00', '2026-05-20 03:35:00', 1000.00),
(87, 'Eastar Jet', 'Shanghai Pudong International', 'Jeju Airport', '2026-05-20 05:05:00', '2026-05-20 07:15:00', 1000.00),
(88, 'Korean Air', 'Shanghai Pudong International', 'Seoul (Incheon)', '2026-05-20 05:00:00', '2026-05-20 08:10:00', 1000.00),
(89, 'China Cargo Airlines', 'Shanghai Pudong International', 'Charles De Gaulle', '2026-05-20 04:55:00', '2026-05-20 10:35:00', 1000.00),
(90, 'Cathay Pacific', 'Shanghai Pudong International', 'Hong Kong International', '2026-05-20 04:55:00', '2026-05-20 08:05:00', 1000.00),
(91, 'China Cargo Airlines', 'Shanghai Pudong International', 'Suvarnabhumi International', '2026-05-20 04:50:00', '2026-05-20 08:10:00', 1000.00),
(92, 'SF Airlines', 'Shanghai Pudong International', 'Shenzhen', '2026-05-20 04:40:00', '2026-05-20 07:00:00', 1000.00),
(93, 'Cathay Pacific', 'Shanghai Pudong International', 'Zhengzhou', '2026-05-20 04:30:00', '2026-05-20 06:30:00', 1000.00),
(94, 'KlasJet', 'Shanghai Pudong International', 'Seoul (Incheon)', '2026-05-20 04:25:00', '2026-05-20 07:30:00', 1000.00),
(95, 'unknown', 'Port Macquarie', 'Lord Howe Island', '2026-05-20 07:00:00', '2026-05-20 08:44:00', 1000.00),
(96, 'Qantas', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(97, 'China Eastern Airlines', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(98, 'Air New Zealand', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(99, 'Emirates', 'Port Macquarie', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(100, 'Air Niugini', 'Jackson Field', 'Rabaul Airport', '2026-05-20 07:00:00', '2026-05-20 08:25:00', 1000.00),
(101, 'PNG Air', 'Jackson Field', 'Nadzab', '2026-05-20 07:00:00', '2026-05-20 08:10:00', 1000.00),
(102, 'PNG Air', 'Jackson Field', 'Daru', '2026-05-20 06:50:00', '2026-05-20 08:15:00', 1000.00),
(103, 'Air Niugini', 'Jackson Field', 'Brisbane International', '2026-05-20 06:30:00', '2026-05-20 09:40:00', 1000.00),
(104, 'Virgin Atlantic', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(105, 'Qantas', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(106, 'Japan Airlines', 'Bangalore International Airport', 'Lohegaon', '2026-05-20 01:05:00', '2026-05-20 02:35:00', 1000.00),
(107, 'Rex', 'Merimbula', 'Moruya', '2026-05-20 06:30:00', '2026-05-20 07:00:00', 1000.00),
(108, 'Fiji Airways', 'Nadi International', 'Sydney Kingsford Smith Airport', '2026-05-20 09:00:00', '2026-05-20 12:05:00', 1000.00),
(109, 'Qantas', 'Nadi International', 'Sydney Kingsford Smith Airport', '2026-05-20 09:00:00', '2026-05-20 12:05:00', 1000.00),
(110, 'Air Niugini', 'Nadi International', 'Henderson International', '2026-05-20 08:30:00', '2026-05-20 10:30:00', 1000.00),
(111, 'Fiji Airways', 'Nadi International', 'Henderson International', '2026-05-20 08:30:00', '2026-05-20 10:30:00', 1000.00),
(112, 'Fiji Airways', 'Nadi International', 'Melbourne - Tullamarine Airport', '2026-05-20 08:30:00', '2026-05-20 12:25:00', 1000.00),
(113, 'Qantas', 'Nadi International', 'Melbourne - Tullamarine Airport', '2026-05-20 08:30:00', '2026-05-20 12:25:00', 1000.00),
(114, 'Fiji Airways', 'Nadi International', 'Brisbane International', '2026-05-20 08:15:00', '2026-05-20 10:35:00', 1000.00),
(115, 'Qantas', 'Nadi International', 'Brisbane International', '2026-05-20 08:15:00', '2026-05-20 10:35:00', 1000.00),
(116, 'Qantas', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(117, 'China Eastern Airlines', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(118, 'Emirates', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(119, 'Air New Zealand', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(120, 'LATAM Airlines', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:45:00', '2026-05-20 08:00:00', 1000.00),
(121, 'Rex', 'Mildura', 'Melbourne - Tullamarine Airport', '2026-05-20 06:30:00', '2026-05-20 07:50:00', 1000.00),
(122, 'Qantas', 'Mildura', 'Sydney Kingsford Smith Airport', '2026-05-20 06:30:00', '2026-05-20 08:25:00', 1000.00),
(123, 'Philippine Airlines', 'Techo International Airport', 'Ninoy Aquino International', '2026-05-20 01:15:00', '2026-05-20 05:05:00', 1000.00),
(124, 'Singapore Airlines', 'Singapore Changi', 'Ninoy Aquino International', '2026-05-20 00:35:00', '2026-05-20 04:20:00', 1000.00),
(125, 'Cebu Pacific', 'Ninoy Aquino International', 'Noibai International', '2026-05-20 05:05:00', '2026-05-20 07:40:00', 1000.00),
(126, 'Philippine Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(127, 'Malaysia Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(128, 'China Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 05:00:00', '2026-05-20 06:25:00', 1000.00),
(129, 'Philippine Airlines', 'Ninoy Aquino International', 'Dipolog', '2026-05-20 05:00:00', '2026-05-20 06:30:00', 1000.00),
(130, 'Cebu Pacific', 'Ninoy Aquino International', 'Cagayan De Oro Domestic Airport', '2026-05-20 04:55:00', '2026-05-20 06:40:00', 1000.00),
(131, 'Philippine Airlines', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(132, 'All Nippon Airways', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(133, 'Malaysia Airlines', 'Ninoy Aquino International', 'Tagbilaran', '2026-05-20 04:50:00', '2026-05-20 06:20:00', 1000.00),
(134, 'Cebu Pacific', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:50:00', '2026-05-20 06:25:00', 1000.00),
(135, 'Philippine Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(136, 'Malaysia Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(137, 'China Airlines', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:45:00', '2026-05-20 06:40:00', 1000.00),
(138, 'Philippine Airlines', 'Ninoy Aquino International', 'Labo', '2026-05-20 04:40:00', '2026-05-20 06:20:00', 1000.00),
(139, 'Singapore Airlines', 'Ninoy Aquino International', 'Labo', '2026-05-20 04:40:00', '2026-05-20 06:20:00', 1000.00),
(140, 'Philippines AirAsia', 'Ninoy Aquino International', 'Narita International Airport', '2026-05-20 04:35:00', '2026-05-20 10:10:00', 1000.00),
(141, 'Cebu Pacific', 'Ninoy Aquino International', 'Puerto Princesa', '2026-05-20 04:35:00', '2026-05-20 06:05:00', 1000.00),
(142, 'Cebu Pacific', 'Ninoy Aquino International', 'Butuan', '2026-05-20 04:30:00', '2026-05-20 06:15:00', 1000.00),
(143, 'Cebu Pacific', 'Ninoy Aquino International', 'Laoag International Airport', '2026-05-20 04:25:00', '2026-05-20 05:40:00', 1000.00),
(144, 'Cebu Pacific', 'Ninoy Aquino International', 'Francisco Bangoy International', '2026-05-20 04:20:00', '2026-05-20 06:20:00', 1000.00),
(145, 'Cebu Pacific', 'Ninoy Aquino International', 'Bacolod', '2026-05-20 04:20:00', '2026-05-20 05:45:00', 1000.00),
(146, 'Philippine Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(147, 'Royal Brunei Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(148, 'Malaysia Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(149, 'China Airlines', 'Ninoy Aquino International', 'Mactan-Cebu International', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(150, 'Philippine Airlines', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(151, 'Malaysia Airlines', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(152, 'All Nippon Airways', 'Ninoy Aquino International', 'D.Z. Romualdez', '2026-05-20 04:15:00', '2026-05-20 05:40:00', 1000.00),
(153, 'Philippines AirAsia', 'Ninoy Aquino International', 'Iloilo International', '2026-05-20 04:10:00', '2026-05-20 05:25:00', 1000.00),
(154, 'Cebu Pacific', 'Ninoy Aquino International', 'Zamboanga International', '2026-05-20 04:10:00', '2026-05-20 06:00:00', 1000.00),
(155, 'Maldivian', 'Malé International Airport', 'Chengdu Tianfu International Airport', '2026-05-20 01:55:00', '2026-05-20 10:55:00', 1000.00),
(156, 'Virgin Australia', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(157, 'United Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(158, 'Singapore Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(159, 'Qatar Airways', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(160, 'Air Niugini', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(161, 'China Southern Airlines', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(162, 'Air Canada', 'Mackay', 'Brisbane International', '2026-05-20 06:20:00', '2026-05-20 07:50:00', 1000.00),
(163, 'Rex', 'Mount Gambier', 'Melbourne - Tullamarine Airport', '2026-05-20 06:30:00', '2026-05-20 08:05:00', 1000.00),
(164, 'Qantas', 'Melbourne - Tullamarine Airport', 'Canberra', '2026-05-20 07:05:00', '2026-05-20 08:25:00', 1000.00),
(165, 'Jetstar', 'Melbourne - Tullamarine Airport', 'Maroochydore', '2026-05-20 07:05:00', '2026-05-20 09:25:00', 1000.00),
(166, 'Jetstar', 'Melbourne - Tullamarine Airport', 'Adelaide International Airport', '2026-05-20 07:05:00', '2026-05-20 08:00:00', 1000.00),
(167, 'Qantas', 'Melbourne - Tullamarine Airport', 'Brisbane International', '2026-05-20 07:00:00', '2026-05-20 09:20:00', 1000.00),
(168, 'Qantas', 'Melbourne - Tullamarine Airport', 'Sydney Kingsford Smith Airport', '2026-05-20 07:00:00', '2026-05-20 08:40:00', 1000.00),
(169, 'Rex', 'Melbourne - Tullamarine Airport', 'Devonport', '2026-05-20 07:00:00', '2026-05-20 08:20:00', 1000.00),
(170, 'Virgin Australia', 'Melbourne - Tullamarine Airport', 'Sydney Kingsford Smith Airport', '2026-05-20 07:00:00', '2026-05-20 08:25:00', 1000.00),
(171, 'Batik Air Malaysia', 'Melbourne - Tullamarine Airport', 'Ngurah Rai International', '2026-05-20 07:00:00', '2026-05-20 11:25:00', 1000.00),
(172, 'Batik Air', 'Melbourne - Tullamarine Airport', 'Ngurah Rai International', '2026-05-20 07:00:00', '2026-05-20 11:25:00', 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `group_bookings`
--

CREATE TABLE `group_bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Start_Date` date DEFAULT NULL,
  `End_Date` date DEFAULT NULL,
  `Sharing_Code` varchar(20) DEFAULT NULL,
  `Guest_Limit` int(11) NOT NULL CHECK (`Guest_Limit` > 0),
  `Guest_Count` int(11) NOT NULL,
  `Agency_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_bookings`
--

INSERT INTO `group_bookings` (`Booking_ID`, `Package_ID`, `Start_Date`, `End_Date`, `Sharing_Code`, `Guest_Limit`, `Guest_Count`, `Agency_ID`) VALUES
(3, 0, NULL, NULL, NULL, 10, 4, 3),
(7, 0, NULL, NULL, NULL, 10, 1, 3),
(8, 0, NULL, NULL, NULL, 10, 1, 3),
(9, 0, NULL, NULL, NULL, 10, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `Package_ID` int(11) NOT NULL,
  `Agency_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` > 0),
  `Description` text NOT NULL,
  `Duration` int(11) NOT NULL CHECK (`Duration` > 0),
  `Capacity` int(11) NOT NULL DEFAULT 20 CHECK (`Capacity` > 0),
  `Departure_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`Package_ID`, `Agency_ID`, `Name`, `Price`, `Description`, `Duration`, `Capacity`, `Departure_Date`) VALUES
(1, 3, 'Cape Town Getaway', 12500.00, 'Explore the Mother City with Table Mountain, beaches, and wine tours.', 5, 20, '2026-06-25'),
(2, 3, 'Kruger Safari Experience', 22000.00, 'Big 5 game drives, luxury lodge, all meals included.', 4, 20, '2026-06-26'),
(3, 3, 'Garden Route Road Trip', 18000.00, 'Scenic coastal drive from Cape Town to Gqeberha.', 7, 20, '2026-06-27'),
(6, 7, 'Cape Town Explorer', 500.00, 'Discover the beauty of Table Mountain, the V&A Waterfront and the Cape Winelands on this iconic South African city escape.', 8, 20, '2026-06-30'),
(7, 7, 'Kruger Safari Adventure', 700.00, 'Experience the Big Five up close on guided game drives through the world-renowned Kruger National Park.', 10, 12, '2026-07-01'),
(8, 7, 'Garden Route Road Trip', 900.00, 'Journey along one of the world\'s most scenic coastal drives, from Mossel Bay to Storms River.', 2, 15, '2026-07-02'),
(9, 7, 'Winelands Weekend', 800.00, 'Tour the world-class vineyards and Cape Dutch estates of Stellenbosch and Franschhoek.', 14, 30, '2026-07-03'),
(12, 7, 'Winter Singles Deal ', 500.00, 'Package deals for one person!!!! Get it while you can ', 25, 1, '2026-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `package_accommodations`
--

CREATE TABLE `package_accommodations` (
  `Package_ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_accommodations`
--

INSERT INTO `package_accommodations` (`Package_ID`, `Accommodation_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(6, 1),
(6, 3),
(7, 2),
(9, 1),
(12, 304);

-- --------------------------------------------------------

--
-- Table structure for table `package_attractions`
--

CREATE TABLE `package_attractions` (
  `Package_ID` int(11) NOT NULL,
  `Attraction_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_attractions`
--

INSERT INTO `package_attractions` (`Package_ID`, `Attraction_ID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(6, 3),
(7, 38),
(7, 55),
(7, 67),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(9, 23),
(9, 26),
(9, 40),
(9, 52),
(12, 38),
(12, 64),
(12, 90),
(12, 93);

-- --------------------------------------------------------

--
-- Table structure for table `package_destinations`
--

CREATE TABLE `package_destinations` (
  `Package_ID` int(11) NOT NULL,
  `Destination_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_destinations`
--

INSERT INTO `package_destinations` (`Package_ID`, `Destination_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(6, 1),
(7, 2),
(12, 49),
(12, 107),
(12, 132);

-- --------------------------------------------------------

--
-- Table structure for table `package_flights`
--

CREATE TABLE `package_flights` (
  `Package_ID` int(11) NOT NULL,
  `Flight_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_flights`
--

INSERT INTO `package_flights` (`Package_ID`, `Flight_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(6, 1),
(7, 2),
(8, 141),
(8, 155),
(9, 2),
(9, 79),
(9, 86),
(12, 1),
(12, 2),
(12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `package_images`
--

CREATE TABLE `package_images` (
  `Package_ID` int(11) NOT NULL,
  `Image_URL` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_images`
--

INSERT INTO `package_images` (`Package_ID`, `Image_URL`) VALUES
(1, 'https://images.pexels.com/photos/29834261/pexels-photo-29834261.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(1, 'https://images.pexels.com/photos/31917730/pexels-photo-31917730.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(1, 'https://images.pexels.com/photos/34515222/pexels-photo-34515222.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(2, 'https://images.pexels.com/photos/20896462/pexels-photo-20896462.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(2, 'https://images.pexels.com/photos/34269065/pexels-photo-34269065.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(3, 'https://images.com/gardenroute_1.jpg'),
(3, 'https://images.com/gardenroute_2.jpg'),
(6, 'https://images.pexels.com/photos/35398305/pexels-photo-35398305.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(7, 'https://images.pexels.com/photos/13142739/pexels-photo-13142739.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(8, 'https://images.pexels.com/photos/33641653/pexels-photo-33641653.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(9, 'https://images.pexels.com/photos/36823730/pexels-photo-36823730.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(12, 'https://images.pexels.com/photos/35862332/pexels-photo-35862332.jpeg?auto=compress&cs=tinysrgb&h=650&w=940');

-- --------------------------------------------------------

--
-- Table structure for table `package_restaurants`
--

CREATE TABLE `package_restaurants` (
  `Package_ID` int(11) NOT NULL,
  `Restaurant_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_restaurants`
--

INSERT INTO `package_restaurants` (`Package_ID`, `Restaurant_ID`) VALUES
(12, 1),
(12, 16),
(12, 73);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `Restaurant_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Cuisine` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL DEFAULT '',
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`Restaurant_ID`, `Name`, `Cuisine`, `Country`, `Image`) VALUES
(1, 'Chart Farm', 'Various', 'South Africa', 'https://images.pexels.com/photos/29834261/pexels-photo-29834261.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(2, 'Constantia Glen Restaurant', 'Various', 'South Africa', 'https://images.pexels.com/photos/34515222/pexels-photo-34515222.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(3, 'La Colombe', 'Various', 'South Africa', 'https://images.pexels.com/photos/34943320/pexels-photo-34943320.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(4, 'Eagles Nest Wine Sales', 'Various', 'South Africa', 'https://images.pexels.com/photos/37552354/pexels-photo-37552354.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(5, 'Moyo', 'Fast Food', 'South Africa', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(6, 'Tadka', 'Indian', 'South Africa', 'https://images.pexels.com/photos/12737916/pexels-photo-12737916.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(7, 'Banana Jam', 'Caribbean', 'South Africa', 'https://images.pexels.com/photos/31822996/pexels-photo-31822996.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(8, 'Fat Harry\'s', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/31023368/pexels-photo-31023368.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(9, 'Rose Cottage Restaurant', 'Various', 'South Africa', 'https://images.pexels.com/photos/1393250/pexels-photo-1393250.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(10, 'Cool Runnings', 'Takeout', 'South Africa', 'https://images.pexels.com/photos/35278823/pexels-photo-35278823.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(11, 'Restaurante Rancho do Boi', 'Various', 'Brazil', 'https://images.pexels.com/photos/31917730/pexels-photo-31917730.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(12, 'Taika Izakaya', 'Various', 'Brazil', 'https://images.pexels.com/photos/34269065/pexels-photo-34269065.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(13, 'Churrascaria Norma\'s', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/20896462/pexels-photo-20896462.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(14, 'Aromi Restaurante', 'Regional', 'Brazil', 'https://images.pexels.com/photos/36921555/pexels-photo-36921555.png?auto=compress&cs=tinysrgb&h=650&w=940'),
(15, 'Takê', 'Japanese', 'Brazil', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(16, 'Big Nic', 'Various', 'Brazil', 'https://images.pexels.com/photos/37533871/pexels-photo-37533871.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(17, 'Green Food', 'Various', 'Brazil', 'https://images.pexels.com/photos/35117463/pexels-photo-35117463.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(18, 'Dona Lucinha', 'Various', 'Brazil', 'https://images.pexels.com/photos/14616842/pexels-photo-14616842.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(19, 'Pino Restaurante', 'Italian', 'Brazil', 'https://images.pexels.com/photos/2476399/pexels-photo-2476399.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(20, 'Judite', 'Brazilian', 'Brazil', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(21, 'Hibernia Restaurant', 'Various', 'Dominica', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(22, 'Reggae Grill', 'Regional', 'Jamaica', 'https://images.pexels.com/photos/31927206/pexels-photo-31927206.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(23, 'Hank\'s', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(24, 'Pit Stop by Ben', 'Various', 'Gambia', 'https://images.pexels.com/photos/33691237/pexels-photo-33691237.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(25, 'Falcon Nest Bar & Grill', 'Various', 'Gambia', 'https://images.pexels.com/photos/20329664/pexels-photo-20329664.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(26, 'Guyanese Creole Kitchen and Bar', 'Various', 'Guyana', 'https://images.pexels.com/photos/20157989/pexels-photo-20157989.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(27, 'Oishi Delicious Asian Kitchen', 'Various', 'Guyana', 'https://images.pexels.com/photos/8951197/pexels-photo-8951197.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(28, 'Elvis Beach Bar', 'Various', 'Guyana', 'https://images.pexels.com/photos/13004958/pexels-photo-13004958.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(29, 'Jelly BBQ', 'Various', 'Guyana', 'https://images.pexels.com/photos/36846220/pexels-photo-36846220.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(30, 'Wave', 'Various', 'Guyana', 'https://images.pexels.com/photos/14917393/pexels-photo-14917393.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(31, 'Le Café', 'Various', 'Rwanda', 'https://images.pexels.com/photos/19517446/pexels-photo-19517446.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(32, 'Chicharrones Pinula', 'Steak house', 'Guatemala', 'https://images.pexels.com/photos/34147124/pexels-photo-34147124.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(33, 'Arbol de La Vida', 'Vegetarian', 'Guatemala', 'https://images.pexels.com/photos/17056989/pexels-photo-17056989.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(34, 'Vesuvio', 'Pizza', 'Guatemala', 'https://images.pexels.com/photos/34625893/pexels-photo-34625893.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(35, 'San Martin', 'Various', 'Guatemala', 'https://images.pexels.com/photos/36907164/pexels-photo-36907164.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(36, 'El Portal del Angel', 'Various', 'Guatemala', 'https://images.pexels.com/photos/32730672/pexels-photo-32730672.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(37, 'Peke Pig', 'Regional', 'Guatemala', 'https://images.pexels.com/photos/36462144/pexels-photo-36462144.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(38, 'El Pinche', 'Mexican', 'Guatemala', 'https://images.pexels.com/photos/33490827/pexels-photo-33490827.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(39, 'Saúl Paseo Cayala', 'International', 'Guatemala', 'https://images.pexels.com/photos/12332750/pexels-photo-12332750.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(40, 'Arch 22 Restaurant', 'Various', 'Gambia', 'https://images.pexels.com/photos/37025768/pexels-photo-37025768.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(41, 'king Baker The Kitchen', 'Various', 'Gambia', 'https://images.pexels.com/photos/16018417/pexels-photo-16018417.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(42, 'Alphas resturant', 'Various', 'Gambia', 'https://images.pexels.com/photos/11384933/pexels-photo-11384933.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(43, 'Ali Baba', 'Various', 'Jordan', 'https://images.pexels.com/photos/36429453/pexels-photo-36429453.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(44, 'La Casa de Toño', 'Mexican', 'Mexico', 'https://images.pexels.com/photos/13252576/pexels-photo-13252576.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(45, 'Cerezo 163', 'Various', 'Mexico', 'https://images.pexels.com/photos/6537116/pexels-photo-6537116.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(46, 'El Rincón de Veracruz', 'Mexican', 'Mexico', 'https://images.pexels.com/photos/19676137/pexels-photo-19676137.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(47, 'Toks', 'Fast Food', 'Mexico', 'https://images.pexels.com/photos/8295013/pexels-photo-8295013.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(48, 'Beer Factory', 'Fast Food', 'Mexico', 'https://images.pexels.com/photos/20329664/pexels-photo-20329664.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(49, 'Kortasia', 'Korean', 'South Korea', 'https://images.pexels.com/photos/8863183/pexels-photo-8863183.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(50, 'Platinum Restaurant', 'African', 'Malawi', 'https://images.pexels.com/photos/37038390/pexels-photo-37038390.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(51, 'Gazeebos Restaurant', 'Various', 'Malawi', 'https://images.pexels.com/photos/35495061/pexels-photo-35495061.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(52, 'Sana', 'Indian', 'India', 'https://images.pexels.com/photos/35827117/pexels-photo-35827117.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(53, 'Local restaurant', 'Various', 'Malawi', 'https://images.pexels.com/photos/2755/restaurant.jpg?auto=compress&cs=tinysrgb&h=650&w=940'),
(54, 'Courtyard -By Imperial Hotels', 'Indian', 'India', 'https://images.pexels.com/photos/19222804/pexels-photo-19222804.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(55, 'Papaya', 'Limited', 'Malawi', 'https://images.pexels.com/photos/2337835/pexels-photo-2337835.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(56, 'Msungama Building', 'Various', 'Malawi', 'https://images.pexels.com/photos/30005979/pexels-photo-30005979.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(57, 'Land and Lake safaris', 'Various', 'Malawi', 'https://images.pexels.com/photos/18000393/pexels-photo-18000393.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(58, 'Andy\'s Pizzeria', 'Pizza', 'Hong Kong', 'https://images.pexels.com/photos/33499456/pexels-photo-33499456.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(59, 'Bar Argerich', 'Various', 'Argentina', 'https://images.pexels.com/photos/29880935/pexels-photo-29880935.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(60, 'Su Restaurant', 'Various', 'Argentina', 'https://images.pexels.com/photos/35495061/pexels-photo-35495061.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(61, 'Da Vinci', 'Various', 'Argentina', 'https://images.pexels.com/photos/35792767/pexels-photo-35792767.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(62, 'Parrilla El Establo', 'Various', 'Argentina', 'https://images.pexels.com/photos/31752160/pexels-photo-31752160.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(63, 'Hierbabuena', 'Various', 'Argentina', 'https://images.pexels.com/photos/35495061/pexels-photo-35495061.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(64, 'La Piazza', 'Various', 'Argentina', 'https://images.pexels.com/photos/33532793/pexels-photo-33532793.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(65, 'El Viejo Volcano', 'Various', 'Argentina', 'https://images.pexels.com/photos/37291859/pexels-photo-37291859.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(66, 'lo de katy', 'Burger', 'Argentina', 'https://images.pexels.com/photos/37218772/pexels-photo-37218772.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(67, 'Pizzería', 'Pizza', 'Argentina', 'https://images.pexels.com/photos/5713526/pexels-photo-5713526.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(68, 'Sam\'s Steak & Seafood', 'Steak house', 'Hong Kong', 'https://images.pexels.com/photos/36145046/pexels-photo-36145046.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(69, 'Pochon Chicken', 'Various', 'Guam', 'https://images.pexels.com/photos/34110266/pexels-photo-34110266.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(70, 'Meskla Chamoru Fusion Bistro', 'Various', 'Guam', 'https://images.pexels.com/photos/9980751/pexels-photo-9980751.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(71, 'Capricciosa', 'Italian', 'Guam', 'https://images.pexels.com/photos/15878786/pexels-photo-15878786.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(72, 'Tony Roma\'s', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/37043811/pexels-photo-37043811.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(73, 'Tokyo Mart Express', 'Japanese', 'Japan', 'https://images.pexels.com/photos/35837234/pexels-photo-35837234.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(74, 'Froots', 'Various', 'Guam', 'https://images.pexels.com/photos/33948377/pexels-photo-33948377.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(75, 'Carmen\'s Cha Cha Cha', 'Mexican', 'Hong Kong', 'https://images.pexels.com/photos/32715531/pexels-photo-32715531.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(76, 'Kitchen Lingo', 'Various', 'Jamaica', 'https://images.pexels.com/photos/15656542/pexels-photo-15656542.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(77, 'Thai Thai', 'Various', 'Thailand', 'https://images.pexels.com/photos/31530376/pexels-photo-31530376.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(78, 'Сръбска скара', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/15382827/pexels-photo-15382827.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(79, 'Банички и боза', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/22129776/pexels-photo-22129776.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(80, 'Вики', 'Pizza', 'Bulgaria', 'https://images.pexels.com/photos/21175643/pexels-photo-21175643.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(81, 'Гъше Перо', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/35495061/pexels-photo-35495061.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(82, 'Hugo bar & dinner', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/19615779/pexels-photo-19615779.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(83, 'Феникс', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/15382827/pexels-photo-15382827.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(84, 'ЗОХ', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/4255402/pexels-photo-4255402.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(85, 'Комплекс за бързо хранене', 'Various', 'Bulgaria', 'https://images.pexels.com/photos/4491831/pexels-photo-4491831.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(86, 'Fish Shack', 'Various', 'Dominica', 'https://images.pexels.com/photos/36788368/pexels-photo-36788368.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(87, 'Pine Applez Kitchen', 'Various', 'Dominica', 'https://images.pexels.com/photos/5175548/pexels-photo-5175548.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(88, 'The Great Wall Restaurant and Bar', 'Various', 'China', 'https://images.pexels.com/photos/5549519/pexels-photo-5549519.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(89, 'Pearl\'s Cuisine', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/16975190/pexels-photo-16975190.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(90, 'Towdah\'s Kool Table', 'Takeout', 'Hong Kong', 'https://images.pexels.com/photos/13869876/pexels-photo-13869876.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(91, 'Green House Bar and Grill', 'Various', 'Dominica', 'https://images.pexels.com/photos/36782591/pexels-photo-36782591.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(92, 'Annette\'s', 'Regional', 'Hong Kong', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(93, 'M by Smiles of Gourmets', 'Vegetarian', 'Rwanda', 'https://images.pexels.com/photos/34164444/pexels-photo-34164444.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(94, 'River Side Cuisine', 'Various', 'Rwanda', 'https://images.pexels.com/photos/9665029/pexels-photo-9665029.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(95, 'Roxy\'s Mountain Lodge', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/37264043/pexels-photo-37264043.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(96, 'Buddha Sushi', 'Sushi', 'Singapore', 'https://images.pexels.com/photos/34313381/pexels-photo-34313381.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(97, 'Pizza Hut', 'Pizza', 'United Kingdom', 'https://images.pexels.com/photos/18609291/pexels-photo-18609291.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(98, 'Nando\'s', 'Vegetarian', 'South Africa', 'https://images.pexels.com/photos/10352601/pexels-photo-10352601.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(99, 'Food Sky', 'Chinese', 'China', 'https://images.pexels.com/photos/35864624/pexels-photo-35864624.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(100, 'Northeastern Sichuan', 'Chinese', 'China', 'https://images.pexels.com/photos/18764184/pexels-photo-18764184.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(101, 'Gurkha\'s Inn', 'Vegetarian', '', 'https://images.pexels.com/photos/29341547/pexels-photo-29341547.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(102, 'Pathiri', 'Various', 'India', 'https://images.pexels.com/photos/5713526/pexels-photo-5713526.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(103, 'Kawagishi', 'Sushi', 'Japan', 'https://images.pexels.com/photos/31474676/pexels-photo-31474676.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(104, 'Gaucho', 'Fast Food', 'Argentina', 'https://images.pexels.com/photos/37126417/pexels-photo-37126417.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(105, 'Busaba', 'Thai', 'United Kingdom', 'https://images.pexels.com/photos/5531297/pexels-photo-5531297.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(106, 'Town’s Diner', 'Various', 'Bermuda', 'https://images.pexels.com/photos/19963313/pexels-photo-19963313.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(107, 'Eli and Lan\'s Kitchen', 'Various', 'Spain', 'https://images.pexels.com/photos/7701619/pexels-photo-7701619.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(108, 'Cupids Bar & Restaurant', 'Various', 'Bermuda', 'https://images.pexels.com/photos/2290740/pexels-photo-2290740.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(109, 'Fusion', 'Various', 'Bermuda', 'https://images.pexels.com/photos/10296409/pexels-photo-10296409.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(110, 'Nett Ramen', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/36714042/pexels-photo-36714042.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(111, 'China Star', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/35415466/pexels-photo-35415466.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(112, 'Sushi bar', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/34692780/pexels-photo-34692780.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(113, 'Kia´s Restaurant', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/11384933/pexels-photo-11384933.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(114, 'Red Snapper Restaurant', 'Various', 'Curaçao', 'https://images.pexels.com/photos/19615775/pexels-photo-19615775.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(115, 'Broast Chicken', 'Various', 'Jordan', 'https://images.pexels.com/photos/32177596/pexels-photo-32177596.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(116, 'Eivel', 'Various', 'Jordan', 'https://images.pexels.com/photos/31071253/pexels-photo-31071253.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(117, 'Linda', 'Various', 'Jordan', 'https://images.pexels.com/photos/11906265/pexels-photo-11906265.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(118, 'Brosted', 'Various', 'Jordan', 'https://images.pexels.com/photos/27099520/pexels-photo-27099520.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(119, 'Liali Zaman', 'Various', 'Lebanon', 'https://images.pexels.com/photos/37088251/pexels-photo-37088251.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(120, 'Omar', 'Various', 'Lebanon', 'https://images.pexels.com/photos/8681914/pexels-photo-8681914.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(121, 'Ayam Zaman', 'Various', 'Lebanon', 'https://images.pexels.com/photos/37052498/pexels-photo-37052498.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(122, 'مطعم مسلم', 'Various', 'Jordan', 'https://images.pexels.com/photos/29395611/pexels-photo-29395611.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(123, 'Paris Restaurant', 'Chinese', 'Curaçao', 'https://images.pexels.com/photos/19518189/pexels-photo-19518189.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(124, 'Texas Alaparia', 'Various', 'Curaçao', 'https://images.pexels.com/photos/5229768/pexels-photo-5229768.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(125, 'Libanesa Santa Rosa', 'Various', 'Curaçao', 'https://images.pexels.com/photos/5879877/pexels-photo-5879877.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(126, 'Kabuya Terrace Snek', 'Various', 'Rwanda', 'https://images.pexels.com/photos/14333980/pexels-photo-14333980.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(127, 'Landhuis Brakkeput Mei Mei', 'Takeout', 'Curaçao', 'https://images.pexels.com/photos/35033854/pexels-photo-35033854.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(128, 'Brisa Do Mar', 'Various', 'Curaçao', 'https://images.pexels.com/photos/37507105/pexels-photo-37507105.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(129, 'Mama Boy', 'Various', 'Curaçao', 'https://images.pexels.com/photos/12814609/pexels-photo-12814609.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(130, 'Fantastic Restaurant', 'Various', 'Curaçao', 'https://images.pexels.com/photos/33053062/pexels-photo-33053062.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(131, 'FANTASTIC RESTAURANT', 'International', 'Curaçao', 'https://images.pexels.com/photos/33053062/pexels-photo-33053062.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(132, 'Umut', 'Turkish', 'Turkey', 'https://images.pexels.com/photos/8360236/pexels-photo-8360236.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(133, 'Honey Restaurant', 'Various', 'Mauritius', 'https://images.pexels.com/photos/24206930/pexels-photo-24206930.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(134, 'Bamboo Rooftop Restaurant', 'Takeout', 'Mauritius', 'https://images.pexels.com/photos/11669581/pexels-photo-11669581.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(135, 'Fat Mama\'s Kitchen', 'Indian', 'Spain', 'https://images.pexels.com/photos/11384933/pexels-photo-11384933.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(136, 'Indian Curries', 'Various', 'Mauritius', 'https://images.pexels.com/photos/9792458/pexels-photo-9792458.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(137, 'White Horse', 'Various', 'Mauritius', 'https://images.pexels.com/photos/34825410/pexels-photo-34825410.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(138, 'Preet Fast Food (Indian Vegetarian Restaurant)', 'Vegetarian', 'Mauritius', 'https://images.pexels.com/photos/27929056/pexels-photo-27929056.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(139, 'Daphne', 'Various', 'Mauritius', 'https://images.pexels.com/photos/20336656/pexels-photo-20336656.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(140, 'Ming\'s restaurant', 'International', 'Spain', 'https://images.pexels.com/photos/31303295/pexels-photo-31303295.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(141, '洪記士多', 'Taiwanese', 'Hong Kong', 'https://images.pexels.com/photos/19763324/pexels-photo-19763324.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(142, 'Shek O Chinese and Thailand Seafood Restaurant', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/12971913/pexels-photo-12971913.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(143, 'Happy restaurant', 'Thai', 'Hong Kong', 'https://images.pexels.com/photos/35415466/pexels-photo-35415466.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(144, '南丫天虹海鮮酒家 Rainbow Seafood Restaurant', 'Seafood', 'Hong Kong', 'https://images.pexels.com/photos/12971913/pexels-photo-12971913.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(145, 'Wai Kee Seafood Restaurant', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/12971913/pexels-photo-12971913.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(146, 'LoSo Kitchen', 'Takeout', 'Hong Kong', 'https://images.pexels.com/photos/17849429/pexels-photo-17849429.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(147, 'Peach Garden', 'Various', 'Hong Kong', 'https://images.pexels.com/photos/6989863/pexels-photo-6989863.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(148, '\"Анхор\" Национальная кухня', 'Takeout', 'Uzbekistan', 'https://images.pexels.com/photos/37127726/pexels-photo-37127726.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(149, '\"Fayz\" Национальная кухня', 'Regional', 'Uzbekistan', 'https://images.pexels.com/photos/35624591/pexels-photo-35624591.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(150, 'Yaponamama', 'Japanese', 'Uzbekistan', 'https://images.pexels.com/photos/1860200/pexels-photo-1860200.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(151, 'AMOR & FATI', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/7518979/pexels-photo-7518979.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(152, 'Сам Янг Ресторан', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/9248323/pexels-photo-9248323.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(153, 'Munavvar fayz', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/31242121/pexels-photo-31242121.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(154, 'Qora Suv', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/34263625/pexels-photo-34263625.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(155, 'Hayot', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/35495061/pexels-photo-35495061.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(156, 'Островок', 'Korean', 'Uzbekistan', 'https://images.pexels.com/photos/5953549/pexels-photo-5953549.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(157, 'ТАЛЬ ПИЧ', 'Various', 'Uzbekistan', 'https://images.pexels.com/photos/10110713/pexels-photo-10110713.jpeg?auto=compress&cs=tinysrgb&h=650&w=940');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `Review_ID` int(11) NOT NULL,
  `Booking_ID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `Comment` text NOT NULL,
  `Date` date NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`Review_ID`, `Booking_ID`, `Rating`, `Comment`, `Date`, `User_ID`) VALUES
(5, 1, 5, 'Cape Town was incredible! The itinerary was well-planned and the hotel had stunning views of Table Mountain.', '2026-06-10', 1),
(6, 2, 4, 'The Kruger safari was unforgettable. Saw all Big 5! Would have liked an extra game drive though.', '2026-07-18', 2),
(7, 3, 5, 'Garden Route road trip was the best group experience ever. Made new friends and the scenery was breathtaking.', '2026-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `solo_bookings`
--

CREATE TABLE `solo_bookings` (
  `Booking_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solo_bookings`
--

INSERT INTO `solo_bookings` (`Booking_ID`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `tourist_attractions`
--

CREATE TABLE `tourist_attractions` (
  `Attraction_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourist_attractions`
--

INSERT INTO `tourist_attractions` (`Attraction_ID`, `Name`, `Image`) VALUES
(1, 'Table Mountain', 'https://images.com/table_mountain.jpg'),
(2, 'Boulders Beach', 'https://images.com/boulders_beach.jpg'),
(3, 'V&A Waterfront', 'https://images.com/va_waterfront.jpg'),
(4, 'Kruger Gate', 'https://images.com/kruger_gate.jpg'),
(5, 'Blyde River Canyon', 'https://images.com/blyde_canyon.jpg'),
(6, 'Bakoven', ''),
(7, 'Rhodes Memorial', ''),
(8, 'Triangle Boulder', ''),
(9, 'Pulpit Rock', ''),
(10, 'Nhlanganini Dam Viewpoint', ''),
(11, 'Rhidonda Pan Viewpoint', ''),
(12, 'Cachoeira das Duas Quedas', ''),
(13, 'Cascata da Aguinhas', ''),
(14, 'Cascata', ''),
(15, 'Cruzeiro da Boa Vista', 'https://images.pexels.com/photos/29849994/pexels-photo-29849994.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(16, 'Mirante do Mangabeiras', ''),
(17, 'Estátua de Juscelino Kubitschek', ''),
(18, 'Katouche Well', ''),
(19, 'Anguilla Sign', ''),
(20, 'Fountain Cavern Petroglyphs', ''),
(21, 'Road Bay/Sandy Ground', ''),
(22, 'Dolphin Discovery', ''),
(23, '\"El Coloso\" de INMACO', ''),
(24, 'Acceso al Cerro del Guerrero', ''),
(25, 'Izcóatl', ''),
(26, 'Mirador de la basilica de Guadalupe', ''),
(27, 'José María de los Reyes', 'https://images.pexels.com/photos/35403212/pexels-photo-35403212.jpeg?auto=compress&cs=tinysrgb&h=650&w=940'),
(28, 'Kumbali Cultural Village', ''),
(29, 'The Print Shop', ''),
(30, 'Cross Roads Center', ''),
(31, 'Market eatery (Ziboliboli)', ''),
(32, 'Wood market', ''),
(33, 'African Habitat', ''),
(34, 'Dream Land　park and restaurant', ''),
(35, 'Parliament', ''),
(36, 'Capital Kids Play Centre', ''),
(37, 'Airtel', ''),
(38, 'Longboat', ''),
(39, 'Estrella de la Fortuna', ''),
(40, 'Torre del Fantasma', ''),
(41, 'La “Inmortal Polaca” del maestro ajedrecista Miguel Najdorf', ''),
(42, 'La “Inmortal Polaca” del maestro ajedrecista Miguel Najdorf', ''),
(43, 'Al padre de familia', ''),
(44, 'Izando la Bandera', ''),
(45, 'La Madre', ''),
(46, 'José de San Martín', ''),
(47, 'Colón Fábrica', ''),
(48, 'ｽｷﾅｰﾌﾟﾗｻﾞ', ''),
(49, 'ラッテストーン', ''),
(50, 'Guam Museum', ''),
(51, 'General McArthur Bust', ''),
(52, 'Spanish bridge', ''),
(53, 'Blow Hole', ''),
(54, 'Latte stones', ''),
(55, 'Two Lovers Leap', ''),
(56, 'Stone animals', ''),
(57, 'Слънчев Часовник', ''),
(58, 'Румик', ''),
(59, 'Мече', ''),
(60, 'Тодор Попорушев', ''),
(61, 'Никола Котков', ''),
(62, 'Криви огледала', ''),
(63, 'Bishop Arnold Boghaert House', ''),
(64, 'View of Trafalgar Falls', ''),
(65, 'screws sulphuric pools', ''),
(66, 'Old Mill Cultural Centre', ''),
(67, 'Bubble Beach SPA', ''),
(68, 'Rose\'s Lime Factory', ''),
(69, 'archaeology site (private land)', ''),
(70, 'Norwood House', ''),
(71, 'crushed schoolbus', ''),
(72, 'The Optic Cloak', ''),
(73, 'Peninsula Spire', ''),
(74, 'The Mermaid', ''),
(75, 'Fish Out of Water', ''),
(76, 'NICHO Marine Park', ''),
(77, 'The Labyrinth of Mangroves', ''),
(78, 'Japanese WWII Gun', ''),
(79, 'Japanese WWII Gun', ''),
(80, 'Abandoned Colonial Administration Building', ''),
(81, 'Twin Waterfalls', ''),
(82, 'Viewpoint', ''),
(83, 'سلهب تباشيم', ''),
(84, 'אנדרטה לזכר עמנואל מורנו', ''),
(85, 'תצפית גג הארץ', ''),
(86, 'اثريات بيزنطية', ''),
(87, 'مول بيرزيت', ''),
(88, 'منجرة النادي', ''),
(89, 'Natuurfarm scherpenheuvel', ''),
(90, 'Looking Out', ''),
(91, 'Seinpost', ''),
(92, 'Hofi Granville', ''),
(93, 'Caracasbaaiview', ''),
(94, 'Spaanse Water', ''),
(95, 'Mermaid Boat Trips', ''),
(96, 'Caracasbay view', ''),
(97, 'Anti-Corruption Monument', ''),
(98, 'Sonatubes Roundabout', ''),
(99, 'Gikondo Expo Ground', ''),
(100, 'Kigali Golf Course', ''),
(101, 'Motley Healthcare ltd', ''),
(102, 'Kigali Golf Course', ''),
(103, 'Inemas arts gallery', ''),
(104, 'PAROISSE SAINT JEAN PAUL II', ''),
(105, 'Old School', ''),
(106, '赤柱市集 Stanley Market', ''),
(107, 'Лошадиная зона', ''),
(108, 'Кирпич огнеупорный Серёга', ''),
(109, 'Сим база Артур', ''),
(110, 'HAVE A NICE FLIGHT ✈️', ''),
(111, 'Здесь подкармливают нутрий', ''),
(112, 'Aleksandr Pushkin', ''),
(113, 'Колокол Мира', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Cell` varchar(20) NOT NULL,
  `Type` enum('Agency','Traveller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Name`, `Password_Hash`, `Email`, `Cell`, `Type`) VALUES
(1, 'Alice Mabena', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'alice.mabena@gmail.com', '+27831234567', 'Traveller'),
(2, 'Ravi Naidoo', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'ravi.naidoo@outlook.com', '+27829876543', 'Traveller'),
(3, 'Safari & Sun Agency', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'bookings@safarisun.co.za', '+27213456789', 'Agency'),
(4, 'Test1', '$2y$10$5YtlK0fz3P9pueJ3AHbtme5BmYtGHqeco8Fs12mvRPvYjhAl9Ya8W', 'test1@gmail.com', '0835698541', 'Traveller'),
(5, 'agency1', '$2y$10$uKoMRMk0lgRdCYbZh23OqeV3FTOXmVz3B.kQ.3ItQQBZnBl4ajL8q', 'agency1@gmail.com', '0836578952', 'Agency'),
(6, 'Test2', '$2y$10$di1WnNeTs17wRlUiN0u.DOoL2avZobYv/59SQt8pD1bjwyfeJI.eC', 'test2@gmail.com', '0839874587', 'Traveller'),
(7, 'Vashti Pillay', '$2y$10$DK7HNI8M3Z9W3gehrnidLOjo48VZaP5zXYE4m1IHU1iwMHnuXDWF.', 'jet2holiday@gmail.com', '0831234567', 'Agency');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`Accommodation_ID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Package_ID` (`Package_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD PRIMARY KEY (`Booking_ID`,`User_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `booking_traveller_details`
--
ALTER TABLE `booking_traveller_details`
  ADD PRIMARY KEY (`Detail_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`Destination_ID`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`Flight_ID`);

--
-- Indexes for table `group_bookings`
--
ALTER TABLE `group_bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD UNIQUE KEY `Sharing_Code` (`Sharing_Code`),
  ADD KEY `FK_GroupBooking_Agency` (`Agency_ID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`Package_ID`),
  ADD KEY `Agency_ID` (`Agency_ID`);

--
-- Indexes for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD PRIMARY KEY (`Package_ID`,`Accommodation_ID`),
  ADD KEY `Accommodation_ID` (`Accommodation_ID`);

--
-- Indexes for table `package_attractions`
--
ALTER TABLE `package_attractions`
  ADD PRIMARY KEY (`Package_ID`,`Attraction_ID`),
  ADD KEY `Attraction_ID` (`Attraction_ID`);

--
-- Indexes for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD PRIMARY KEY (`Package_ID`,`Destination_ID`),
  ADD KEY `Destination_ID` (`Destination_ID`);

--
-- Indexes for table `package_flights`
--
ALTER TABLE `package_flights`
  ADD PRIMARY KEY (`Package_ID`,`Flight_ID`),
  ADD KEY `Flight_ID` (`Flight_ID`);

--
-- Indexes for table `package_images`
--
ALTER TABLE `package_images`
  ADD PRIMARY KEY (`Package_ID`,`Image_URL`);

--
-- Indexes for table `package_restaurants`
--
ALTER TABLE `package_restaurants`
  ADD PRIMARY KEY (`Package_ID`,`Restaurant_ID`),
  ADD KEY `Restaurant_ID` (`Restaurant_ID`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`Restaurant_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`Review_ID`,`Booking_ID`),
  ADD UNIQUE KEY `Booking_ID` (`Booking_ID`),
  ADD KEY `FK_Review_User` (`User_ID`);

--
-- Indexes for table `solo_bookings`
--
ALTER TABLE `solo_bookings`
  ADD PRIMARY KEY (`Booking_ID`);

--
-- Indexes for table `tourist_attractions`
--
ALTER TABLE `tourist_attractions`
  ADD PRIMARY KEY (`Attraction_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `Accommodation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `booking_traveller_details`
--
ALTER TABLE `booking_traveller_details`
  MODIFY `Detail_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `Destination_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `Flight_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `Package_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `Restaurant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tourist_attractions`
--
ALTER TABLE `tourist_attractions`
  MODIFY `Attraction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `booking_travelers`
--
ALTER TABLE `booking_travelers`
  ADD CONSTRAINT `booking_travelers_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_travelers_fk2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `booking_traveller_details`
--
ALTER TABLE `booking_traveller_details`
  ADD CONSTRAINT `btd_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;

--
-- Constraints for table `group_bookings`
--
ALTER TABLE `group_bookings`
  ADD CONSTRAINT `FK_GroupBooking_Agency` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_fk1` FOREIGN KEY (`Agency_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD CONSTRAINT `package_accommodations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_accommodations_fk2` FOREIGN KEY (`Accommodation_ID`) REFERENCES `accommodations` (`Accommodation_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_attractions`
--
ALTER TABLE `package_attractions`
  ADD CONSTRAINT `package_attractions_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_attractions_fk2` FOREIGN KEY (`Attraction_ID`) REFERENCES `tourist_attractions` (`Attraction_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_destinations`
--
ALTER TABLE `package_destinations`
  ADD CONSTRAINT `package_destinations_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_destinations_fk2` FOREIGN KEY (`Destination_ID`) REFERENCES `destinations` (`Destination_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_flights`
--
ALTER TABLE `package_flights`
  ADD CONSTRAINT `package_flights_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_flights_fk2` FOREIGN KEY (`Flight_ID`) REFERENCES `flights` (`Flight_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_images`
--
ALTER TABLE `package_images`
  ADD CONSTRAINT `package_images_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE;

--
-- Constraints for table `package_restaurants`
--
ALTER TABLE `package_restaurants`
  ADD CONSTRAINT `package_restaurants_fk1` FOREIGN KEY (`Package_ID`) REFERENCES `packages` (`Package_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_restaurants_fk2` FOREIGN KEY (`Restaurant_ID`) REFERENCES `restaurants` (`Restaurant_ID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_Review_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;

--
-- Constraints for table `solo_bookings`
--
ALTER TABLE `solo_bookings`
  ADD CONSTRAINT `solo_bookings_fk1` FOREIGN KEY (`Booking_ID`) REFERENCES `bookings` (`Booking_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
