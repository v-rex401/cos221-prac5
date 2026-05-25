-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2026 at 04:20 AM
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
(14, 'Granpanorama-Hotel Stephanshof', 'HotelPension', 1000.00, ''),
(15, '10- Bettzimmer im Restaurant Sternen', 'Apartment', 1000.00, 'https://media-v2.discover.swiss/rawmedia/ctd/8705a5326c050244a82e16e30f6b9c8c7ac93e85_9cea1a6d_5876_4e78_9355_8b0aec925087.jpeg'),
(16, '1100 APARTMENT', 'BedBreakfast', 1000.00, ''),
(17, '1477 Reichhalter', 'BedBreakfast', 1000.00, ''),
(18, '164 apt.', 'BedBreakfast', 1000.00, ''),
(19, '22 Summits Apartments', 'Apartment', 1000.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020010416503159/TDS00020010000158950/TDS00020015218339065.jpg'),
(20, '22 Summits Boutique Hotel', 'HotelPension', 1000.00, 'https://cdn.tomas-travel.com/tds/repository/TDS00020011844279793/TDS00020010000158950/TDS00020015648757944.jpg'),
(21, '25hours Hotel Langstrasse', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_25hours_langstrasse_29434.jpg'),
(22, '25hours Hotel Langstrasse', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/web_zuerich_25hours_langstrasse_29434.jpg'),
(23, '25hours Hotel Zürich West', 'HotelPension', 1000.00, 'https://www.zuerich.com/sites/default/files/nethotel-images/490006770_14_de65df00-3976-41f3-a14e-59acb30a410e.jpg');

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
(1254, 'The Valley', 'Anguilla', ''),
(1255, 'Guatemala City', 'Guatemala', ''),
(1256, 'Banjul', 'Gambia', ''),
(1257, 'Mexico City', 'Mexico', ''),
(1258, 'Lilongwe', 'Malawi', ''),
(1259, 'Adamstown', 'Pitcairn Islands', ''),
(1260, 'Buenos Aires', 'Argentina', ''),
(1261, 'Hagåtña', 'Guam', ''),
(1262, 'Sofia', 'Bulgaria', ''),
(1263, 'Roseau', 'Dominica', ''),
(1264, 'London', 'United Kingdom', ''),
(1265, 'Palikir', 'Micronesia', ''),
(1266, 'Ramallah', 'Palestine', ''),
(1267, 'Willemstad', 'Curaçao', ''),
(1268, 'Kigali', 'Rwanda', ''),
(1269, 'City of Victoria', 'Hong Kong', ''),
(1270, 'Tashkent', 'Uzbekistan', ''),
(1271, 'Beijing', 'China', ''),
(1272, 'Nicosia', 'Cyprus', ''),
(1273, 'Oranjestad', 'Aruba', ''),
(1274, 'Saint-Denis', 'Réunion', ''),
(1275, 'Seoul', 'South Korea', ''),
(1276, 'Not Available', 'Antarctica', ''),
(1277, 'Mogadishu', 'Somalia', ''),
(1278, 'Beirut', 'Lebanon', ''),
(1279, 'Conakry', 'Guinea', ''),
(1280, 'Dushanbe', 'Tajikistan', ''),
(1281, 'Kuala Lumpur', 'Malaysia', ''),
(1282, 'Pyongyang', 'North Korea', ''),
(1283, 'Freetown', 'Sierra Leone', ''),
(1284, 'Porto-Novo', 'Benin', ''),
(1285, 'Rome', 'Italy', ''),
(1286, 'Port of Spain', 'Trinidad and Tobago', ''),
(1287, 'Riyadh', 'Saudi Arabia', ''),
(1288, 'San José', 'Costa Rica', ''),
(1289, 'Belgrade', 'Serbia', ''),
(1290, 'Fakaofo', 'Tokelau', ''),
(1291, 'Ulan Bator', 'Mongolia', ''),
(1292, 'Bandar Seri Begawan', 'Brunei', ''),
(1293, 'Budapest', 'Hungary', ''),
(1294, 'Maputo', 'Mozambique', ''),
(1295, 'South Tarawa', 'Kiribati', ''),
(1296, 'Port-au-Prince', 'Haiti', ''),
(1297, 'Phnom Penh', 'Cambodia', ''),
(1298, 'Cairo', 'Egypt', ''),
(1299, 'Ashgabat', 'Turkmenistan', ''),
(1300, 'Muscat', 'Oman', ''),
(1301, 'Kingston', 'Jamaica', ''),
(1302, 'Baku', 'Azerbaijan', ''),
(1303, 'Bratislava', 'Slovakia', ''),
(1304, 'Minsk', 'Belarus', ''),
(1305, 'Hanoi', 'Vietnam', ''),
(1306, 'Charlotte Amalie', 'United States Virgin Islands', ''),
(1307, 'Gibraltar', 'Gibraltar', ''),
(1308, 'Philipsburg', 'Sint Maarten', ''),
(1309, 'Mariehamn', 'Åland Islands', ''),
(1310, 'Damascus', 'Syria', ''),
(1311, 'Fort-de-France', 'Martinique', ''),
(1312, 'Nuuk', 'Greenland', ''),
(1313, 'Tegucigalpa', 'Honduras', ''),
(1314, 'Tunis', 'Tunisia', ''),
(1315, 'Moroni', 'Comoros', ''),
(1316, 'Ljubljana', 'Slovenia', ''),
(1317, 'Bern', 'Switzerland', ''),
(1318, 'St. Peter Port', 'Guernsey', ''),
(1319, 'Naypyidaw', 'Myanmar', ''),
(1320, 'Asunción', 'Paraguay', ''),
(1321, 'Kralendijk', 'Caribbean Netherlands', ''),
(1322, 'Bridgetown', 'Barbados', ''),
(1323, 'Not Available', 'Macau', ''),
(1324, 'Amman', 'Jordan', ''),
(1325, 'Vientiane', 'Laos', ''),
(1326, 'Lomé', 'Togo', ''),
(1327, 'Rabat', 'Morocco', ''),
(1328, 'San Juan', 'Puerto Rico', ''),
(1329, 'Cayenne', 'French Guiana', ''),
(1330, 'Saint-Pierre', 'Saint Pierre and Miquelon', ''),
(1331, 'Marigot', 'Saint Martin', ''),
(1332, 'Tallinn', 'Estonia', ''),
(1333, 'Jakarta', 'Indonesia', ''),
(1334, 'Victoria', 'Seychelles', ''),
(1335, 'Bamako', 'Mali', ''),
(1336, 'Dili', 'Timor-Leste', ''),
(1337, 'Brasília', 'Brazil', ''),
(1338, 'Accra', 'Ghana', ''),
(1339, 'Nairobi', 'Kenya', ''),
(1340, 'Reykjavik', 'Iceland', ''),
(1341, 'Antananarivo', 'Madagascar', ''),
(1342, 'Dhaka', 'Bangladesh', ''),
(1343, 'Kinshasa', 'DR Congo', ''),
(1344, 'Harare', 'Zimbabwe', ''),
(1345, 'Papeetē', 'French Polynesia', ''),
(1346, 'Ankara', 'Turkey', ''),
(1347, 'Praia', 'Cape Verde', ''),
(1348, 'Santo Domingo', 'Dominican Republic', ''),
(1349, 'Nassau', 'Bahamas', ''),
(1350, 'Berlin', 'Germany', ''),
(1351, 'Paramaribo', 'Suriname', ''),
(1352, 'Nuku\'alofa', 'Tonga', ''),
(1353, 'Diego Garcia', 'British Indian Ocean Territory', ''),
(1354, 'Castries', 'Saint Lucia', ''),
(1355, 'Dublin', 'Ireland', ''),
(1356, 'Vatican City', 'Vatican City', ''),
(1357, 'Bogotá', 'Colombia', ''),
(1358, 'Lisbon', 'Portugal', ''),
(1359, 'Tórshavn', 'Faroe Islands', ''),
(1360, 'São Tomé', 'São Tomé and Príncipe', ''),
(1361, 'Saipan', 'Northern Mariana Islands', ''),
(1362, 'Saint Helier', 'Jersey', ''),
(1363, 'Mamoudzou', 'Mayotte', ''),
(1364, 'Sana\'a', 'Yemen', ''),
(1365, 'Abuja', 'Nigeria', ''),
(1366, 'Kabul', 'Afghanistan', ''),
(1367, 'Gaborone', 'Botswana', ''),
(1368, 'Douglas', 'Isle of Man', ''),
(1369, 'San Salvador', 'El Salvador', ''),
(1370, 'Kampala', 'Uganda', ''),
(1371, 'Andorra la Vella', 'Andorra', ''),
(1372, 'Cockburn Town', 'Turks and Caicos Islands', ''),
(1373, 'N\'Djamena', 'Chad', ''),
(1374, 'Helsinki', 'Finland', ''),
(1375, 'Moscow', 'Russia', ''),
(1376, 'Astana', 'Kazakhstan', ''),
(1377, 'Longyearbyen', 'Svalbard and Jan Mayen', ''),
(1378, 'Caracas', 'Venezuela', ''),
(1379, 'Monaco', 'Monaco', ''),
(1380, 'Dakar', 'Senegal', ''),
(1381, 'Kathmandu', 'Nepal', ''),
(1382, 'Abu Dhabi', 'United Arab Emirates', ''),
(1383, 'Taipei', 'Taiwan', ''),
(1384, 'Nouméa', 'New Caledonia', ''),
(1385, 'Sucre', 'Bolivia', ''),
(1386, 'Santiago', 'Chile', ''),
(1387, 'Yamoussoukro', 'Ivory Coast', ''),
(1388, 'Tripoli', 'Libya', ''),
(1389, 'Lima', 'Peru', ''),
(1390, 'Ottawa', 'Canada', ''),
(1391, 'Paris', 'France', ''),
(1392, 'Djibouti', 'Djibouti', ''),
(1393, 'Gitega', 'Burundi', ''),
(1394, 'Pristina', 'Kosovo', ''),
(1395, 'Copenhagen', 'Denmark', ''),
(1396, 'Athens', 'Greece', ''),
(1397, 'Prague', 'Czechia', ''),
(1398, 'Asmara', 'Eritrea', ''),
(1399, 'Windhoek', 'Namibia', ''),
(1400, 'Road Town', 'British Virgin Islands', ''),
(1401, 'Tehran', 'Iran', ''),
(1402, 'Ciudad de la Paz', 'Equatorial Guinea', ''),
(1403, 'Nouakchott', 'Mauritania', ''),
(1404, 'Manama', 'Bahrain', ''),
(1405, 'West Island', 'Cocos (Keeling) Islands', ''),
(1406, 'Addis Ababa', 'Ethiopia', ''),
(1407, 'Lusaka', 'Zambia', ''),
(1408, 'Sarajevo', 'Bosnia and Herzegovina', ''),
(1409, 'Stanley', 'Falkland Islands', ''),
(1410, 'St. George\'s', 'Grenada', ''),
(1411, 'Bangkok', 'Thailand', ''),
(1412, 'Bucharest', 'Romania', ''),
(1413, 'Kingstown', 'Saint Vincent and the Grenadines', ''),
(1414, 'Monrovia', 'Liberia', ''),
(1415, 'Washington, D.C.', 'United States', ''),
(1416, 'Juba', 'South Sudan', ''),
(1417, 'Not Available', 'Bouvet Island', ''),
(1418, 'Yerevan', 'Armenia', ''),
(1419, 'Tokyo', 'Japan', ''),
(1420, 'Islamabad', 'Pakistan', ''),
(1421, 'Mbabane', 'Eswatini', ''),
(1422, 'Vaduz', 'Liechtenstein', ''),
(1423, 'Jerusalem', 'Israel', ''),
(1424, 'Pago Pago', 'American Samoa', ''),
(1425, 'Sri Jayawardenepura Kotte', 'Sri Lanka', ''),
(1426, 'King Edward Point', 'South Georgia', ''),
(1427, 'Tirana', 'Albania', ''),
(1428, 'Algiers', 'Algeria', ''),
(1429, 'Kyiv', 'Ukraine', ''),
(1430, 'Jamestown', 'Saint Helena, Ascension and Tristan da Cunha', ''),
(1431, 'Not Available', 'Heard Island and McDonald Islands', ''),
(1432, 'City of San Marino', 'San Marino', ''),
(1433, 'Havana', 'Cuba', ''),
(1434, 'Yaren', 'Nauru', ''),
(1435, 'Madrid', 'Spain', ''),
(1436, 'Kuwait City', 'Kuwait', ''),
(1437, 'Plymouth', 'Montserrat', ''),
(1438, 'Port Louis', 'Mauritius', ''),
(1439, 'Stockholm', 'Sweden', ''),
(1440, 'Canberra', 'Australia', ''),
(1441, 'Yaoundé', 'Cameroon', ''),
(1442, 'Quito', 'Ecuador', ''),
(1443, 'Doha', 'Qatar', ''),
(1444, 'Majuro', 'Marshall Islands', ''),
(1445, 'Warsaw', 'Poland', ''),
(1446, 'George Town', 'Cayman Islands', ''),
(1447, 'Pretoria', 'South Africa', ''),
(1448, 'Mata-Utu', 'Wallis and Futuna', ''),
(1449, 'Apia', 'Samoa', ''),
(1450, 'Amsterdam', 'Netherlands', ''),
(1451, 'El Aaiún', 'Western Sahara', ''),
(1452, 'Podgorica', 'Montenegro', ''),
(1453, 'Thimphu', 'Bhutan', ''),
(1454, 'Valletta', 'Malta', ''),
(1455, 'Port Vila', 'Vanuatu', ''),
(1456, 'Dodoma', 'Tanzania', ''),
(1457, 'Wellington', 'New Zealand', ''),
(1458, 'Ngerulmud', 'Palau', ''),
(1459, 'Panama City', 'Panama', ''),
(1460, 'Funafuti', 'Tuvalu', ''),
(1461, 'Suva', 'Fiji', ''),
(1462, 'Managua', 'Nicaragua', ''),
(1463, 'Bishkek', 'Kyrgyzstan', ''),
(1464, 'Port-aux-Français', 'French Southern and Antarctic Lands', ''),
(1465, 'Riga', 'Latvia', ''),
(1466, 'Tbilisi', 'Georgia', ''),
(1467, 'Luxembourg', 'Luxembourg', ''),
(1468, 'Vienna', 'Austria', ''),
(1469, 'Skopje', 'North Macedonia', ''),
(1470, 'Gustavia', 'Saint Barthélemy', ''),
(1471, 'Flying Fish Cove', 'Christmas Island', ''),
(1472, 'Honiara', 'Solomon Islands', ''),
(1473, 'Saint John\'s', 'Antigua and Barbuda', ''),
(1474, 'Baghdad', 'Iraq', ''),
(1475, 'Chișinău', 'Moldova', ''),
(1476, 'Kingston', 'Norfolk Island', ''),
(1477, 'Brazzaville', 'Republic of the Congo', ''),
(1478, 'Alofi', 'Niue', ''),
(1479, 'Vilnius', 'Lithuania', ''),
(1480, 'Niamey', 'Niger', ''),
(1481, 'Georgetown', 'Guyana', ''),
(1482, 'Hamilton', 'Bermuda', ''),
(1483, 'Libreville', 'Gabon', ''),
(1484, 'Avarua', 'Cook Islands', ''),
(1485, 'Luanda', 'Angola', ''),
(1486, 'Oslo', 'Norway', ''),
(1487, 'Basse-Terre', 'Guadeloupe', ''),
(1488, 'Malé', 'Maldives', ''),
(1489, 'Brussels', 'Belgium', ''),
(1490, 'Zagreb', 'Croatia', ''),
(1491, 'Belmopan', 'Belize', ''),
(1492, 'Basseterre', 'Saint Kitts and Nevis', ''),
(1493, 'Singapore', 'Singapore', ''),
(1494, 'Maseru', 'Lesotho', ''),
(1495, 'Montevideo', 'Uruguay', ''),
(1496, 'Ouagadougou', 'Burkina Faso', ''),
(1497, 'New Delhi', 'India', ''),
(1498, 'Manila', 'Philippines', ''),
(1499, 'Bangui', 'Central African Republic', ''),
(1500, 'Khartoum', 'Sudan', ''),
(1501, 'Bissau', 'Guinea-Bissau', ''),
(1502, 'Port Moresby', 'Papua New Guinea', ''),
(1503, 'Washington DC', 'United States Minor Outlying Islands', '');

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
(75, 'unknown', 'Kwajalein', '', '2026-05-20 08:45:00', '2026-05-20 09:05:00', 1000.00),
(76, 'Batik Air', 'Kuala Lumpur International Airport (klia)', 'Presidente Nicolau Lobato International', '2026-05-20 02:15:00', '2026-05-20 07:30:00', 1000.00),
(77, 'Pel-Air', 'Dubbo', 'Sydney Kingsford Smith Airport', '2026-05-20 00:20:00', '2026-05-20 01:09:00', 1000.00),
(78, 'Bangkok Airways', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(79, 'SriLankan Airlines', 'Suvarnabhumi International', 'Kansai International', '2026-05-20 00:30:00', '2026-05-20 07:55:00', 1000.00),
(80, 'TAP Air Portugal', 'Suvarnabhumi International', 'Brussels Airport', '2026-05-20 00:05:00', '2026-05-20 07:15:00', 1000.00),
(81, 'All Nippon Airways', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(82, 'El Al', 'Suvarnabhumi International', 'Chu-Bu Centrair International (Central Japan International)', '2026-05-20 00:05:00', '2026-05-20 08:00:00', 1000.00),
(83, 'unknown', 'Adelaide International Airport', 'Port Pirie', '2026-05-20 00:35:00', '2026-05-20 01:01:00', 1000.00),
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
  `Capacity` int(11) NOT NULL DEFAULT 20 CHECK (`Capacity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`Package_ID`, `Agency_ID`, `Name`, `Price`, `Description`, `Duration`, `Capacity`) VALUES
(1, 3, 'Cape Town Getaway', 12500.00, 'Explore the Mother City with Table Mountain, beaches, and wine tours.', 5, 20),
(2, 3, 'Kruger Safari Experience', 22000.00, 'Big 5 game drives, luxury lodge, all meals included.', 4, 20),
(3, 3, 'Garden Route Road Trip', 18000.00, 'Scenic coastal drive from Cape Town to Gqeberha.', 7, 20),
(6, 7, 'Cape Town Explorer', 500.00, 'Discover the beauty of Table Mountain, the V&A Waterfront and the Cape Winelands on this iconic South African city escape.', 8, 20),
(7, 7, 'Kruger Safari Adventure', 700.00, 'Experience the Big Five up close on guided game drives through the world-renowned Kruger National Park.', 10, 12),
(8, 7, 'Garden Route Road Trip', 900.00, 'Journey along one of the world\'s most scenic coastal drives, from Mossel Bay to Storms River.', 2, 15),
(9, 7, 'Winelands Weekend', 800.00, 'Tour the world-class vineyards and Cape Dutch estates of Stellenbosch and Franschhoek.', 14, 30);

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
(7, 20),
(8, 14),
(8, 15),
(8, 16),
(9, 1),
(9, 22),
(9, 23);

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
(9, 52);

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
(8, 1259),
(9, 1259),
(9, 1382),
(9, 1406);

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
(9, 86);

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
(1, 'https://images.com/capetown_1.jpg'),
(1, 'https://images.com/capetown_2.jpg'),
(1, 'https://images.com/capetown_3.jpg'),
(2, 'https://images.com/kruger_1.jpg'),
(2, 'https://images.com/kruger_2.jpg'),
(3, 'https://images.com/gardenroute_1.jpg'),
(3, 'https://images.com/gardenroute_2.jpg');

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
(1, 1),
(2, 2),
(3, 3),
(6, 1),
(6, 2),
(6, 144),
(7, 7),
(7, 20),
(7, 28),
(8, 31),
(8, 32),
(8, 40),
(8, 45),
(9, 10),
(9, 12),
(9, 13),
(9, 14),
(9, 21),
(9, 29);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `Restaurant_ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Cuisine` varchar(100) NOT NULL,
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`Restaurant_ID`, `Name`, `Cuisine`, `Image`) VALUES
(1, 'The Test Kitchen', 'Fine Dining', 'https://images.com/testkitchen.jpg'),
(2, 'Cattle Baron', 'Steakhouse', 'https://images.com/cattlebaron.jpg'),
(3, 'Freshline Fisheries', 'Seafood', 'https://images.com/freshline.jpg'),
(4, 'Chart Farm', 'Array', ''),
(5, 'Constantia Glen Restaurant', 'Array', ''),
(6, 'La Colombe', 'Array', ''),
(7, 'Eagles Nest Wine Sales', 'Various', ''),
(8, 'Moyo', 'Array', ''),
(9, 'Tadka', 'Array', ''),
(10, 'Banana Jam', 'Array', ''),
(11, 'Fat Harry\'s', 'Various', ''),
(12, 'Rose Cottage Restaurant', 'Array', ''),
(13, 'Cool Runnings', 'Array', ''),
(14, 'Restaurante Rancho do Boi', 'Various', ''),
(15, 'Taika Izakaya', 'Various', ''),
(16, 'Churrascaria Norma\'s', 'Various', ''),
(17, 'Aromi Restaurante', 'Array', ''),
(18, 'Takê', 'Array', ''),
(19, 'Big Nic', 'Various', ''),
(20, 'Green Food', 'Various', ''),
(21, 'Dona Lucinha', 'Various', ''),
(22, 'Pino Restaurante', 'Array', ''),
(23, 'Judite', 'Array', ''),
(24, 'Hibernia Restaurant', 'Array', ''),
(25, 'Reggae Grill', 'Array', ''),
(26, 'Hank\'s', 'Various', ''),
(27, 'Pit Stop by Ben', 'Various', ''),
(28, 'Falcon Nest Bar & Grill', 'Various', ''),
(29, 'Guyanese Creole Kitchen and Bar', 'Various', ''),
(30, 'Oishi Delicious Asian Kitchen', 'Various', ''),
(31, 'Elvis Beach Bar', 'Various', ''),
(32, 'Jelly BBQ', 'Various', ''),
(33, 'Wave', 'Various', ''),
(34, 'Le Café', 'Various', ''),
(35, 'Chicharrones Pinula', 'Array', ''),
(36, 'Arbol de La Vida', 'Array', ''),
(37, 'Vesuvio', 'Array', ''),
(38, 'San Martin', 'Various', ''),
(39, 'El Portal del Angel', 'Various', ''),
(40, 'Peke Pig', 'Array', ''),
(41, 'El Pinche', 'Array', ''),
(42, 'Saúl Paseo Cayala', 'Array', ''),
(43, 'Vesuvio', 'Array', ''),
(44, 'Arch 22 Restaurant', 'Various', ''),
(45, 'king Baker The Kitchen', 'Various', ''),
(46, 'Alphas resturant', 'Various', ''),
(47, 'Ali Baba', 'Various', ''),
(48, 'La Casa de Toño', 'Array', ''),
(49, 'Cerezo 163', 'Various', ''),
(50, 'El Rincón de Veracruz', 'Array', ''),
(51, 'Toks', 'Array', ''),
(52, 'Beer Factory', 'Various', ''),
(53, 'Toks', 'Array', ''),
(54, 'Toks', 'Array', ''),
(55, 'Kortasia', 'Array', ''),
(56, 'Platinum Restaurant', 'Array', ''),
(57, 'Gazeebos Restaurant', 'Various', ''),
(58, 'Sana', 'Array', ''),
(59, 'Ali Baba', 'Various', ''),
(60, 'Local restaurant', 'Various', ''),
(61, 'Courtyard -By Imperial Hotels', 'Array', ''),
(62, 'Papaya', 'Array', ''),
(63, 'Msungama Building', 'Various', ''),
(64, 'Land and Lake safaris', 'Various', ''),
(65, 'Andy\'s Pizzeria', 'Array', ''),
(66, 'Bar Argerich', 'Various', ''),
(67, 'Su Restaurant', 'Various', ''),
(68, 'Da Vinci', 'Various', ''),
(69, 'Parrilla El Establo', 'Various', ''),
(70, 'Hierbabuena', 'Various', ''),
(71, 'La Piazza', 'Various', ''),
(72, 'El Viejo Volcano', 'Various', ''),
(73, 'lo de katy', 'Array', ''),
(74, 'Pizzería', 'Array', ''),
(75, 'Sam\'s Steak & Seafood', 'Array', ''),
(76, 'Pochon Chicken', 'Various', ''),
(77, 'Meskla Chamoru Fusion Bistro', 'Various', ''),
(78, 'Capricciosa', 'Array', ''),
(79, 'Tony Roma\'s', 'Various', ''),
(80, 'Tokyo Mart Express', 'Array', ''),
(81, 'Froots', 'Various', ''),
(82, 'Carmen\'s Cha Cha Cha', 'Array', ''),
(83, 'Kitchen Lingo', 'Various', ''),
(84, 'Thai Thai', 'Various', ''),
(85, 'Сръбска скара', 'Various', ''),
(86, 'Банички и боза', 'Various', ''),
(87, 'Сръбска скара', 'Various', ''),
(88, 'Вики', 'Array', ''),
(89, 'Гъше Перо', 'Various', ''),
(90, 'Hugo bar & dinner', 'Various', ''),
(91, 'Феникс', 'Various', ''),
(92, 'ЗОХ', 'Various', ''),
(93, 'Комплекс за бързо хранене', 'Various', ''),
(94, 'Fish Shack', 'Various', ''),
(95, 'Pine Applez Kitchen', 'Various', ''),
(96, 'The Great Wall Restaurant and Bar', 'Various', ''),
(97, 'Pearl\'s Cuisine', 'Various', ''),
(98, 'Towdah\'s Kool Table', 'Various', ''),
(99, 'Green House Bar and Grill', 'Various', ''),
(100, 'Annette\'s', 'Array', ''),
(101, 'M by Smiles of Gourmets', 'Array', ''),
(102, 'River Side Cuisine', 'Various', ''),
(103, 'Roxy\'s Mountain Lodge', 'Various', ''),
(104, 'Buddha Sushi', 'Array', ''),
(105, 'Pizza Hut', 'Array', ''),
(106, 'Nando\'s', 'Array', ''),
(107, 'Food Sky', 'Array', ''),
(108, 'Northeastern Sichuan', 'Array', ''),
(109, 'Gurkha\'s Inn', 'Array', ''),
(110, 'Pathiri', 'Array', ''),
(111, 'Kawagishi', 'Array', ''),
(112, 'Gaucho', 'Array', ''),
(113, 'Busaba', 'Array', ''),
(114, 'Town’s Diner', 'Various', ''),
(115, 'Eli and Lan\'s Kitchen', 'Various', ''),
(116, 'Cupids Bar & Restaurant', 'Various', ''),
(117, 'Fusion', 'Various', ''),
(118, 'Nett Ramen', 'Various', ''),
(119, 'China Star', 'Various', ''),
(120, 'Sushi bar', 'Array', ''),
(121, 'Kia´s Restaurant', 'Various', ''),
(122, 'Red Snapper Restaurant', 'Various', ''),
(123, 'Broast Chicken', 'Various', ''),
(124, 'Eivel', 'Various', ''),
(125, 'Linda', 'Various', ''),
(126, 'Brosted', 'Various', ''),
(127, 'Liali Zaman', 'Various', ''),
(128, 'Omar', 'Various', ''),
(129, 'Ayam Zaman', 'Various', ''),
(130, 'مطعم مسلم', 'Various', ''),
(131, 'Paris Restaurant', 'Array', ''),
(132, 'Texas Alaparia', 'Various', ''),
(133, 'Libanesa Santa Rosa', 'Various', ''),
(134, 'Kabuya Terrace Snek', 'Various', ''),
(135, 'Landhuis Brakkeput Mei Mei', 'Array', ''),
(136, 'Brisa Do Mar', 'Various', ''),
(137, 'Mama Boy', 'Various', ''),
(138, 'Fantastic Restaurant', 'Various', ''),
(139, 'FANTASTIC RESTAURANT', 'Array', ''),
(140, 'Umut', 'Array', ''),
(141, 'Honey Restaurant', 'Various', ''),
(142, 'Bamboo Rooftop Restaurant', 'Array', ''),
(143, 'Fat Mama\'s Kitchen', 'Array', ''),
(144, 'Indian Curries', 'Various', ''),
(145, 'White Horse', 'Various', ''),
(146, 'Preet Fast Food (Indian Vegetarian Restaurant)', 'Array', ''),
(147, 'Daphne', 'Various', ''),
(148, 'Ming\'s restaurant', 'Array', ''),
(149, '洪記士多', 'Array', ''),
(150, 'Shek O Chinese and Thailand Seafood Restaurant', 'Various', ''),
(151, 'Happy restaurant', 'Array', ''),
(152, '南丫天虹海鮮酒家 Rainbow Seafood Restaurant', 'Array', ''),
(153, 'Wai Kee Seafood Restaurant', 'Various', ''),
(154, 'LoSo Kitchen', 'Various', ''),
(155, 'Peach Garden', 'Various', ''),
(156, '\"Анхор\" Национальная кухня', 'Array', ''),
(157, '\"Fayz\" Национальная кухня', 'Array', ''),
(158, 'Yaponamama', 'Array', ''),
(159, 'AMOR & FATI', 'Various', ''),
(160, 'Сам Янг Ресторан', 'Various', ''),
(161, 'Munavvar fayz', 'Various', ''),
(162, 'Qora Suv', 'Various', ''),
(163, 'Hayot', 'Various', ''),
(164, 'Островок', 'Array', ''),
(165, 'ТАЛЬ ПИЧ', 'Various', ''),
(166, '老来顺饭庄(太平路店)', 'Array', ''),
(167, '必胜客', 'Array', ''),
(168, '比格披萨', 'Array', ''),
(169, '东兴楼(六里桥)', 'Array', ''),
(170, '六里桥地摊儿', 'Array', ''),
(171, '鸽子窝(六里桥店)', 'Various', ''),
(172, '南城香', 'Array', ''),
(173, '呷哺呷哺', 'Array', ''),
(174, '疆味缘阿依莎美食', 'Various', ''),
(175, '渝都家厨', 'Array', ''),
(176, 'Ταβέρνα Κρεατομπερδέματα', 'Array', ''),
(177, 'Ψησταρια', 'Various', ''),
(178, 'Γυρος Ο Σαλονικιος', 'Various', ''),
(179, 'Bona Vita Restaurant', 'Various', ''),
(180, 'Tabepma', 'Various', ''),
(181, 'Toronto Pizza', 'Various', ''),
(182, 'Wok In A Box', 'Array', ''),
(183, 'Pizza Hut', 'Array', ''),
(184, 'απλά & ωραία', 'Various', ''),
(185, 'Φουρνοι', 'Various', ''),
(186, 'Irian Bar Restaurant', 'Various', ''),
(187, 'Big Happy', 'Various', ''),
(188, 'Marina Pirata', 'Array', ''),
(189, 'Huchada', 'Various', ''),
(190, 'Sensei Sushi Bar', 'Array', ''),
(191, 'Urataka Center', 'Array', ''),
(192, 'Casibari Cafe', 'Various', ''),
(193, 'Patrizia\'s of New York', 'Array', ''),
(194, 'Le Cheval Blanc', 'Various', ''),
(195, 'Le Marakech', 'Array', ''),
(196, 'Wok AWL', 'Array', ''),
(197, 'O\'Cozy6', 'Various', ''),
(198, 'La Grotte', 'Array', ''),
(199, 'Pizzeria Le Capri', 'Various', ''),
(200, 'O\'Slice Pizza', 'Array', ''),
(201, 'L\'Antenne', 'Array', ''),
(202, 'Chez Laxmi', 'Array', ''),
(203, 'Indian Tandoori Masala', 'Array', ''),
(204, 'Chart Farm', 'Various', ''),
(205, 'Constantia Glen Restaurant', 'Various', ''),
(206, 'La Colombe', 'Various', ''),
(207, 'Eagles Nest Wine Sales', 'Various', ''),
(208, 'Moyo', 'Various', ''),
(209, 'Tadka', 'Various', ''),
(210, 'Banana Jam', 'Various', ''),
(211, 'Fat Harry\'s', 'Various', ''),
(212, 'Rose Cottage Restaurant', 'Various', ''),
(213, 'Cool Runnings', 'Various', ''),
(214, '떡사랑', 'Various', ''),
(215, '마포감자국', 'Various', ''),
(216, '영즉석떡볶이', 'Various', ''),
(217, '참치애난', 'Various', ''),
(218, '다미분식', 'Various', ''),
(219, '또래오래', 'Various', ''),
(220, '고향빈대떡', 'Various', ''),
(221, '해천', 'Various', ''),
(222, '부부숯불구이', 'Various', ''),
(223, '엘림죽', 'Various', ''),
(224, 'El Gitano Mexican Restaurant & Lounge', 'Array', ''),
(225, 'Chelo\'s', 'Various', ''),
(226, 'Hawaii BBQ & Noodle House', 'Array', ''),
(227, 'Round Table Pizza', 'Array', ''),
(228, 'Applebee\'s', 'Array', ''),
(229, 'Zen Sushi', 'Array', ''),
(230, 'On Rice Thai Cuisine', 'Array', ''),
(231, 'El Botas', 'Various', ''),
(232, 'Homeschool BBQ', 'Array', ''),
(233, 'Restaurante Rancho do Boi', 'Various', ''),
(234, 'Taika Izakaya', 'Various', ''),
(235, 'Churrascaria Norma\'s', 'Various', ''),
(236, 'Aromi Restaurante', 'Various', ''),
(237, 'Takê', 'Various', ''),
(238, 'Big Nic', 'Various', ''),
(239, 'Green Food', 'Various', ''),
(240, 'Dona Lucinha', 'Various', ''),
(241, 'Pino Restaurante', 'Various', ''),
(242, 'Judite', 'Various', ''),
(243, 'مطعم حضرمي للمندي', 'Various', ''),
(244, 'ChicKing', 'Various', ''),
(245, 'TAYO HOTEL', 'Various', ''),
(246, 'GOLD HOTEL', 'Various', ''),
(247, 'جريا سمي', 'Array', ''),
(248, 'The Villas Restaurants & Hall', 'Array', ''),
(249, 'Liido Beach Restaurants مطاعم الشاطئ', 'Array', ''),
(250, 'FATXI KM4 BAR & RESTAURANT', 'Various', ''),
(251, 'Village Restaurant', 'Various', ''),
(252, 'Hibernia Restaurant', 'Various', ''),
(253, 'Reggae Grill', 'Various', ''),
(254, 'Hank\'s', 'Various', ''),
(255, 'Pit Stop by Ben', 'Various', ''),
(256, 'Falcon Nest Bar & Grill', 'Various', ''),
(257, 'Guyanese Creole Kitchen and Bar', 'Various', ''),
(258, 'Oishi Delicious Asian Kitchen', 'Various', ''),
(259, 'Elvis Beach Bar', 'Various', ''),
(260, 'Jelly BBQ', 'Various', ''),
(261, 'Wave', 'Various', ''),
(262, 'al-ostora', 'Various', ''),
(263, 'مطعم المحطة', 'Various', ''),
(264, 'ka3ket abo-jaafar', 'Various', ''),
(265, 'abo youssef bakery', 'Various', ''),
(266, 'الهلال', 'Various', ''),
(267, 'سناك أبو سعيد الحدث', 'Various', ''),
(268, 'Just Fajita', 'Various', ''),
(269, 'al-ghadeer', 'Various', ''),
(270, 'رد دير', 'Various', ''),
(271, 'Club des Officiers de Yarzé', 'Various', ''),
(272, 'Le Café', 'Various', ''),
(273, 'Chicharrones Pinula', 'Various', ''),
(274, 'Arbol de La Vida', 'Various', ''),
(275, 'Vesuvio', 'Various', ''),
(276, 'San Martin', 'Various', ''),
(277, 'El Portal del Angel', 'Various', ''),
(278, 'Peke Pig', 'Various', ''),
(279, 'El Pinche', 'Various', ''),
(280, 'Saúl Paseo Cayala', 'Various', ''),
(281, 'Vesuvio', 'Various', ''),
(282, 'Restaurant Venise', 'Various', ''),
(283, 'Pacifique restaurant', 'Various', ''),
(284, 'La brioche de Ratoma', 'Various', ''),
(285, 'Restaurant Togolais Deo Gratias', 'Various', ''),
(286, 'Restaurant mme Keita', 'Various', ''),
(287, 'Restaurant Sow plus', 'Various', ''),
(288, 'Restaurant le Repère', 'Various', ''),
(289, 'Arch 22 Restaurant', 'Various', ''),
(290, 'king Baker The Kitchen', 'Various', ''),
(291, 'Alphas resturant', 'Various', ''),
(292, 'Ali Baba', 'Various', ''),
(293, 'Сафо', 'Various', ''),
(294, 'Панҷ дег', 'Array', ''),
(295, 'O', 'Various', ''),
(296, 'Чойхонаи Даврон', 'Array', ''),
(297, 'Шоми Зебо', 'Various', ''),
(298, 'Ресторан Зайтун', 'Various', ''),
(299, 'Атлас', 'Various', ''),
(300, 'Саховат 24 часа', 'Various', ''),
(301, 'Restoran Fatty Chong', 'Array', ''),
(302, 'Restoran 109', 'Array', ''),
(303, 'Nasi Kandar JMT', 'Various', ''),
(304, 'Sentosa Curry House', 'Various', ''),
(305, 'Restoran Sahabudin', 'Various', ''),
(306, 'Veng Soon', 'Array', ''),
(307, 'Kiow Jie Hakka Yong Taufu', 'Various', ''),
(308, 'Pizza Hut', 'Array', ''),
(309, 'La Casa de Toño', 'Various', ''),
(310, 'Hakka Lui Char', 'Array', ''),
(311, 'Cerezo 163', 'Various', ''),
(312, 'Devi\'s Corner', 'Array', ''),
(313, 'El Rincón de Veracruz', 'Various', ''),
(314, 'Toks', 'Various', ''),
(315, 'Beer Factory', 'Various', ''),
(316, 'Toks', 'Various', ''),
(317, 'Toks', 'Various', ''),
(318, '송신식당', 'Array', ''),
(319, '양각도골프회사식당', 'Array', ''),
(320, '양각도국제호텔 중국료리식사칸', 'Array', ''),
(321, '양각도국제호텔 마카오식당', 'Array', ''),
(322, '양각도국제호텔 1호식사칸', 'Array', ''),
(323, '만수대 미술관 레스토랑', 'Array', ''),
(324, '쑥섬밥공장', 'Array', ''),
(325, '천석식당', 'Array', ''),
(326, 'Konnyu islet Restaurant', 'Array', ''),
(327, 'Kortasia', 'Various', ''),
(328, 'Platinum Restaurant', 'Various', ''),
(329, 'Gazeebos Restaurant', 'Various', ''),
(330, 'Sana', 'Various', ''),
(331, 'Ali Baba', 'Various', ''),
(332, 'Local restaurant', 'Various', ''),
(333, 'Courtyard -By Imperial Hotels', 'Various', ''),
(334, 'Papaya', 'Various', ''),
(335, 'Msungama Building', 'Various', ''),
(336, 'Land and Lake safaris', 'Various', ''),
(337, 'Andy\'s Pizzeria', 'Various', ''),
(338, 'Bar Argerich', 'Various', ''),
(339, 'Su Restaurant', 'Various', ''),
(340, 'Da Vinci', 'Various', ''),
(341, 'Parrilla El Establo', 'Various', ''),
(342, 'Hierbabuena', 'Various', ''),
(343, 'La Piazza', 'Various', ''),
(344, 'El Viejo Volcano', 'Various', ''),
(345, 'lo de katy', 'Various', ''),
(346, 'Pizzería', 'Various', ''),
(347, 'Sam\'s Steak & Seafood', 'Various', ''),
(348, 'Pochon Chicken', 'Various', ''),
(349, 'Meskla Chamoru Fusion Bistro', 'Various', ''),
(350, 'Capricciosa', 'Various', ''),
(351, 'Tony Roma\'s', 'Various', ''),
(352, 'Tokyo Mart Express', 'Various', ''),
(353, 'Froots', 'Various', ''),
(354, 'Carmen\'s Cha Cha Cha', 'Various', ''),
(355, 'Kitchen Lingo', 'Various', ''),
(356, 'Thai Thai', 'Various', ''),
(357, 'Сръбска скара', 'Various', ''),
(358, 'Банички и боза', 'Various', ''),
(359, 'Сръбска скара', 'Various', ''),
(360, 'Вики', 'Various', ''),
(361, 'Гъше Перо', 'Various', ''),
(362, 'Hugo bar & dinner', 'Various', ''),
(363, 'Феникс', 'Various', ''),
(364, 'ЗОХ', 'Various', ''),
(365, 'Комплекс за бързо хранене', 'Various', ''),
(366, 'Fish Shack', 'Various', ''),
(367, 'Pine Applez Kitchen', 'Various', ''),
(368, 'The Great Wall Restaurant and Bar', 'Various', ''),
(369, 'Pearl\'s Cuisine', 'Various', ''),
(370, 'Towdah\'s Kool Table', 'Various', ''),
(371, 'Green House Bar and Grill', 'Various', ''),
(372, 'Annette\'s', 'Various', ''),
(373, 'M by Smiles of Gourmets', 'Various', ''),
(374, 'River Side Cuisine', 'Various', ''),
(375, 'Roxy\'s Mountain Lodge', 'Various', ''),
(376, 'Buddha Sushi', 'Various', ''),
(377, 'Pizza Hut', 'Various', ''),
(378, 'Nando\'s', 'Various', ''),
(379, 'Food Sky', 'Various', ''),
(380, 'Northeastern Sichuan', 'Various', ''),
(381, 'Gurkha\'s Inn', 'Various', ''),
(382, 'Pathiri', 'Various', ''),
(383, 'Kawagishi', 'Various', ''),
(384, 'Gaucho', 'Various', ''),
(385, 'Busaba', 'Various', ''),
(386, 'Town’s Diner', 'Various', ''),
(387, 'Eli and Lan\'s Kitchen', 'Various', ''),
(388, 'Cupids Bar & Restaurant', 'Various', ''),
(389, 'Fusion', 'Various', ''),
(390, 'Nett Ramen', 'Various', ''),
(391, 'China Star', 'Various', ''),
(392, 'Sushi bar', 'Various', ''),
(393, 'Kia´s Restaurant', 'Various', ''),
(394, 'Red Snapper Restaurant', 'Various', ''),
(395, 'Broast Chicken', 'Various', ''),
(396, 'Eivel', 'Various', ''),
(397, 'Linda', 'Various', ''),
(398, 'Brosted', 'Various', ''),
(399, 'Liali Zaman', 'Various', ''),
(400, 'Omar', 'Various', ''),
(401, 'Ayam Zaman', 'Various', ''),
(402, 'مطعم مسلم', 'Various', ''),
(403, 'Paris Restaurant', 'Various', ''),
(404, 'Texas Alaparia', 'Various', ''),
(405, 'Libanesa Santa Rosa', 'Various', ''),
(406, 'Kabuya Terrace Snek', 'Various', ''),
(407, 'Landhuis Brakkeput Mei Mei', 'Various', ''),
(408, 'Brisa Do Mar', 'Various', ''),
(409, 'Mama Boy', 'Various', ''),
(410, 'Fantastic Restaurant', 'Various', ''),
(411, 'FANTASTIC RESTAURANT', 'Various', ''),
(412, 'Umut', 'Various', ''),
(413, 'Honey Restaurant', 'Various', ''),
(414, 'Bamboo Rooftop Restaurant', 'Various', ''),
(415, 'Fat Mama\'s Kitchen', 'Various', ''),
(416, 'Indian Curries', 'Various', ''),
(417, 'White Horse', 'Various', ''),
(418, 'Preet Fast Food (Indian Vegetarian Restaurant)', 'Various', ''),
(419, 'Daphne', 'Various', ''),
(420, 'Ming\'s restaurant', 'Various', ''),
(421, '洪記士多', 'Various', ''),
(422, 'Shek O Chinese and Thailand Seafood Restaurant', 'Various', ''),
(423, 'Happy restaurant', 'Various', ''),
(424, '南丫天虹海鮮酒家 Rainbow Seafood Restaurant', 'Various', ''),
(425, 'Wai Kee Seafood Restaurant', 'Various', ''),
(426, 'LoSo Kitchen', 'Various', ''),
(427, 'Peach Garden', 'Various', ''),
(428, '\"Анхор\" Национальная кухня', 'Various', ''),
(429, '\"Fayz\" Национальная кухня', 'Various', ''),
(430, 'Yaponamama', 'Various', ''),
(431, 'AMOR & FATI', 'Various', ''),
(432, 'Сам Янг Ресторан', 'Various', ''),
(433, 'Munavvar fayz', 'Various', ''),
(434, 'Qora Suv', 'Various', ''),
(435, 'Hayot', 'Various', ''),
(436, 'Островок', 'Various', ''),
(437, 'ТАЛЬ ПИЧ', 'Various', ''),
(438, '老来顺饭庄(太平路店)', 'Various', ''),
(439, '必胜客', 'Various', ''),
(440, '比格披萨', 'Various', ''),
(441, '东兴楼(六里桥)', 'Various', ''),
(442, '六里桥地摊儿', 'Various', ''),
(443, '鸽子窝(六里桥店)', 'Various', ''),
(444, '南城香', 'Various', ''),
(445, '呷哺呷哺', 'Various', ''),
(446, '疆味缘阿依莎美食', 'Various', ''),
(447, '渝都家厨', 'Various', ''),
(448, 'Ταβέρνα Κρεατομπερδέματα', 'Various', ''),
(449, 'Ψησταρια', 'Various', ''),
(450, 'Γυρος Ο Σαλονικιος', 'Various', ''),
(451, 'Bona Vita Restaurant', 'Various', ''),
(452, 'Tabepma', 'Various', ''),
(453, 'Toronto Pizza', 'Various', ''),
(454, 'Wok In A Box', 'Various', ''),
(455, 'Pizza Hut', 'Various', ''),
(456, 'απλά & ωραία', 'Various', ''),
(457, 'Φουρνοι', 'Various', ''),
(458, 'Irian Bar Restaurant', 'Various', ''),
(459, 'Big Happy', 'Various', ''),
(460, 'Marina Pirata', 'Various', ''),
(461, 'Huchada', 'Various', ''),
(462, 'Sensei Sushi Bar', 'Various', ''),
(463, 'Urataka Center', 'Various', ''),
(464, 'Casibari Cafe', 'Various', ''),
(465, 'Patrizia\'s of New York', 'Various', ''),
(466, 'Le Cheval Blanc', 'Various', ''),
(467, 'Le Marakech', 'Various', ''),
(468, 'Wok AWL', 'Various', ''),
(469, 'O\'Cozy6', 'Various', ''),
(470, 'La Grotte', 'Various', ''),
(471, 'Pizzeria Le Capri', 'Various', ''),
(472, 'O\'Slice Pizza', 'Various', ''),
(473, 'L\'Antenne', 'Various', ''),
(474, 'Chez Laxmi', 'Various', ''),
(475, 'Indian Tandoori Masala', 'Various', ''),
(476, '떡사랑', 'Various', ''),
(477, '마포감자국', 'Various', ''),
(478, '영즉석떡볶이', 'Various', ''),
(479, '참치애난', 'Various', ''),
(480, '다미분식', 'Various', ''),
(481, '또래오래', 'Various', ''),
(482, '고향빈대떡', 'Various', ''),
(483, '해천', 'Various', ''),
(484, '부부숯불구이', 'Various', ''),
(485, '엘림죽', 'Various', ''),
(486, 'El Gitano Mexican Restaurant & Lounge', 'Various', ''),
(487, 'Chelo\'s', 'Various', ''),
(488, 'Hawaii BBQ & Noodle House', 'Various', ''),
(489, 'Round Table Pizza', 'Various', ''),
(490, 'Applebee\'s', 'Various', ''),
(491, 'Zen Sushi', 'Various', ''),
(492, 'On Rice Thai Cuisine', 'Various', ''),
(493, 'El Botas', 'Various', ''),
(494, 'Homeschool BBQ', 'Various', ''),
(495, 'مطعم حضرمي للمندي', 'Various', ''),
(496, 'ChicKing', 'Various', ''),
(497, 'TAYO HOTEL', 'Various', ''),
(498, 'GOLD HOTEL', 'Various', ''),
(499, 'جريا سمي', 'Various', ''),
(500, 'The Villas Restaurants & Hall', 'Various', ''),
(501, 'Liido Beach Restaurants مطاعم الشاطئ', 'Various', ''),
(502, 'FATXI KM4 BAR & RESTAURANT', 'Various', ''),
(503, 'Village Restaurant', 'Various', ''),
(504, 'al-ostora', 'Various', ''),
(505, 'مطعم المحطة', 'Various', ''),
(506, 'ka3ket abo-jaafar', 'Various', ''),
(507, 'abo youssef bakery', 'Various', ''),
(508, 'الهلال', 'Various', ''),
(509, 'سناك أبو سعيد الحدث', 'Various', ''),
(510, 'Just Fajita', 'Various', ''),
(511, 'al-ghadeer', 'Various', ''),
(512, 'رد دير', 'Various', ''),
(513, 'Club des Officiers de Yarzé', 'Various', ''),
(514, 'Restaurant Venise', 'Various', ''),
(515, 'Pacifique restaurant', 'Various', ''),
(516, 'La brioche de Ratoma', 'Various', ''),
(517, 'Restaurant Togolais Deo Gratias', 'Various', ''),
(518, 'Restaurant mme Keita', 'Various', ''),
(519, 'Restaurant Sow plus', 'Various', ''),
(520, 'Restaurant le Repère', 'Various', ''),
(521, 'Сафо', 'Various', ''),
(522, 'Панҷ дег', 'Various', ''),
(523, 'O', 'Various', ''),
(524, 'Чойхонаи Даврон', 'Various', ''),
(525, 'Шоми Зебо', 'Various', ''),
(526, 'Ресторан Зайтун', 'Various', ''),
(527, 'Атлас', 'Various', ''),
(528, 'Саховат 24 часа', 'Various', ''),
(529, 'Restoran Fatty Chong', 'Various', ''),
(530, 'Restoran 109', 'Various', ''),
(531, 'Nasi Kandar JMT', 'Various', ''),
(532, 'Sentosa Curry House', 'Various', ''),
(533, 'Restoran Sahabudin', 'Various', ''),
(534, 'Veng Soon', 'Various', ''),
(535, 'Kiow Jie Hakka Yong Taufu', 'Various', ''),
(536, 'Pizza Hut', 'Various', ''),
(537, 'Hakka Lui Char', 'Various', ''),
(538, 'Devi\'s Corner', 'Various', ''),
(539, '송신식당', 'Various', ''),
(540, '양각도골프회사식당', 'Various', ''),
(541, '양각도국제호텔 중국료리식사칸', 'Various', ''),
(542, '양각도국제호텔 마카오식당', 'Various', ''),
(543, '양각도국제호텔 1호식사칸', 'Various', ''),
(544, '만수대 미술관 레스토랑', 'Various', ''),
(545, '쑥섬밥공장', 'Various', ''),
(546, '천석식당', 'Various', ''),
(547, 'Konnyu islet Restaurant', 'Various', '');

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
(15, 'Cruzeiro da Boa Vista', ''),
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
(27, 'José María de los Reyes', ''),
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
  MODIFY `Accommodation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `Destination_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1504;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `Flight_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `Package_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `Restaurant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=548;

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
