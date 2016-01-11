-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Szerver verzió: 5.5.46-MariaDB-log
-- PHP verzió: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tábla szerkezet ehhez a táblához `danceg_lego_sets`
--

CREATE TABLE IF NOT EXISTS `danceg_lego_sets` (
`id` int(100) NOT NULL,
  `lego_set_name` varchar(200) NOT NULL DEFAULT '',
  `lego_set_img` varchar(255) NOT NULL DEFAULT '',
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- A tábla adatainak kiíratása `danceg_lego_sets`
--

INSERT INTO `danceg_lego_sets` (`id`, `lego_set_name`, `lego_set_img`, `modify_date`) VALUES
(1, 'Lego star wars julekalender 75097', '/productImages/205x205/2184380.jpg', '2016-01-11 15:40:41'),
(2, 'Lego Star Wars General Grievous 75112', '/productImages/205x205/2184387.jpg', '2016-01-11 15:47:22'),
(3, 'Lego Star Wars Kylo Ren''s Command Shuttle 75104', '/productImages/205x205/2184401.jpg', '2016-01-11 15:47:22'),
(4, 'Lego Star Wars Millennium Falcon 75105', '/productImages/205x205/2184402.jpg', '2016-01-11 15:47:22'),
(5, 'Lego Star Wars Mos Eisley Cantina 75052', '/productImages/205x205/2106282.jpg', '2016-01-11 15:47:22'),
(6, 'Lego Star Wars TM Imperiets Troppetransport 75078', '/productImages/205x205/2160508.jpg', '2016-01-11 15:47:22'),
(7, 'Lego star Wars TM The Inquisitor 75082', '/productImages/205x205/2160511.jpg', '2016-01-11 15:47:22'),
(8, 'Lego Star Wars Imperial Star Destroyer 75055', '/productImages/205x205/2106285.jpg', '2016-01-11 15:47:22'),
(9, 'Lego Star Wars TM Ezras Speederbike 75090', '/productImages/205x205/2160510.jpg', '2016-01-11 15:47:22'),
(10, 'Lego Star Wars Republic AV-7 Anti-Vehicle Cannon 75045', '/productImages/205x205/2091469.jpg', '2016-01-11 15:47:22'),
(11, 'Lego Star Wars TM AAT 75080', '/productImages/205x205/2160512.jpg', '2016-01-11 15:47:22'),
(12, 'Lego Star Wars Jedi Scoutfighter 75051', '/productImages/205x205/2106281.jpg', '2016-01-11 15:47:22'),
(13, 'Lego Star Wars AT-AP 75043', '/productImages/205x205/2091468.jpg', '2016-01-11 15:47:22'),
(14, 'Lego Star Wars TM Shadow Trooper 75079', '/productImages/205x205/2160509.jpg', '2016-01-11 15:47:22'),
(15, 'Lego Star Wars Halifire Droid 75085', '/productImages/205x205/2168185.jpg', '2016-01-11 15:47:22'),
(16, 'Lego Star Wars Obi-Wan Kenobi 75109', '/productImages/205x205/2184383.jpg', '2016-01-11 15:47:22'),
(17, 'Lego Star Wars AT-DP Pilot 75083', '/productImages/205x205/2178736.jpg', '2016-01-11 15:47:22'),
(18, 'Lego Star Wars Wookiee kampskib 75084', '/productImages/205x205/2178737.jpg', '2016-01-11 15:47:22'),
(19, 'Lego Star Wars Jango Fett 75107', '/productImages/205x205/2184381.jpg', '2016-01-11 15:47:22'),
(20, 'Lego Star Wars KlonkommandÃ¸r Cody 75108', '/productImages/205x205/2184382.jpg', '2016-01-11 15:47:22'),
(21, 'Lego Star Wars First Order Snowspeeder 75100', '/productImages/205x205/2184400.jpg', '2016-01-11 15:47:22'),
(22, 'Lego Star Wars Geonosis troopers 75089', '/productImages/205x205/2184373.jpg', '2016-01-11 15:47:22'),
(23, 'Lego Star Wars Luke Skywalker 75110', '/productImages/205x205/2184384.jpg', '2016-01-11 15:47:22'),
(24, 'Lego Star Wars Darth Vader 75111', '/productImages/205x205/2184386.jpg', '2016-01-11 15:47:22'),
(25, '75138 lego star wars angreb pÃ¥ hoth', '/productImages/205x205/2218982.jpg', '2016-01-11 15:47:22');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `danceg_lego_sets_in_shop`
--

CREATE TABLE IF NOT EXISTS `danceg_lego_sets_in_shop` (
`id` int(100) NOT NULL,
  `shop_id` int(100) NOT NULL DEFAULT '0',
  `set_id` int(100) NOT NULL DEFAULT '0',
  `price` double(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- A tábla adatainak kiíratása `danceg_lego_sets_in_shop`
--

INSERT INTO `danceg_lego_sets_in_shop` (`id`, `shop_id`, `set_id`, `price`) VALUES
(1, 1, 2, 299.00),
(2, 1, 3, 999.00),
(3, 1, 4, 999.99),
(4, 1, 5, 749.00),
(5, 1, 6, 129.00),
(6, 1, 7, 449.00),
(7, 1, 8, 999.99),
(8, 1, 9, 229.00),
(9, 1, 10, 449.00),
(10, 1, 11, 249.00),
(11, 1, 12, 649.00),
(12, 1, 13, 649.00),
(13, 1, 14, 129.00),
(14, 1, 15, 229.00),
(15, 1, 16, 229.00),
(16, 1, 17, 549.00),
(17, 1, 18, 649.00),
(18, 1, 19, 179.00),
(19, 1, 20, 179.00),
(20, 1, 21, 449.00),
(21, 1, 22, 129.00),
(22, 1, 23, 179.00),
(23, 1, 24, 249.00),
(24, 1, 25, 199.00),
(25, 1, 1, 249.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `danceg_lego_shops`
--

CREATE TABLE IF NOT EXISTS `danceg_lego_shops` (
`id` int(100) NOT NULL,
  `shop_title` varchar(200) NOT NULL DEFAULT '',
  `shop_url` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- A tábla adatainak kiíratása `danceg_lego_shops`
--

INSERT INTO `danceg_lego_shops` (`id`, `shop_title`, `shop_url`) VALUES
(1, 'Legekaeden', 'http://www.legekaeden.dk/maerker/lego/lego-star-wars/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danceg_lego_sets`
--
ALTER TABLE `danceg_lego_sets`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danceg_lego_sets_in_shop`
--
ALTER TABLE `danceg_lego_sets_in_shop`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danceg_lego_shops`
--
ALTER TABLE `danceg_lego_shops`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danceg_lego_sets`
--
ALTER TABLE `danceg_lego_sets`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `danceg_lego_sets_in_shop`
--
ALTER TABLE `danceg_lego_sets_in_shop`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `danceg_lego_shops`
--
ALTER TABLE `danceg_lego_shops`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
