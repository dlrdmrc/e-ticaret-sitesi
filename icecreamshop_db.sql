-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 Eki 2025, 02:52:31
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `icecreamshop_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` varchar(20) NOT NULL,
  `kullanici_id` varchar(20) NOT NULL,
  `ürün_id` varchar(20) NOT NULL,
  `fiyat` int(50) NOT NULL,
  `adet` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `istek_listesi`
--

CREATE TABLE `istek_listesi` (
  `id` varchar(20) NOT NULL,
  `kullanici_id` varchar(20) NOT NULL,
  `ürün_id` varchar(20) NOT NULL,
  `fiyat` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanıcılar`
--

CREATE TABLE `kullanıcılar` (
  `id` varchar(20) NOT NULL,
  `isim` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `şifre` varchar(50) NOT NULL,
  `resim` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanıcılar`
--

INSERT INTO `kullanıcılar` (`id`, `isim`, `email`, `şifre`, `resim`) VALUES
('KdJUb5HFS?B??8N7?03B', 'dilara', 'dlr.dmrc@gmail.com', '123', 'foto3.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesaj`
--

CREATE TABLE `mesaj` (
  `id` varchar(20) NOT NULL,
  `kullanici_id` varchar(20) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `mesaj` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `satıcılar`
--

CREATE TABLE `satıcılar` (
  `id` varchar(20) NOT NULL,
  `isim` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `şifre` varchar(50) NOT NULL,
  `resim` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `satıcılar`
--

INSERT INTO `satıcılar` (`id`, `isim`, `email`, `şifre`, `resim`) VALUES
('S?6kJzD?m?t?8?hzv?dv', 'Aslı Demir', 'aslidemir@gmail.com', '1234', 'foto1.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparişler`
--

CREATE TABLE `siparişler` (
  `id` varchar(20) NOT NULL,
  `kullanici_id` varchar(20) NOT NULL,
  `satici_id` varchar(20) NOT NULL,
  `isim` varchar(50) NOT NULL,
  `numara` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adres` varchar(200) NOT NULL,
  `adres_türü` varchar(10) NOT NULL,
  `yöntem` varchar(50) NOT NULL,
  `ürün_id` varchar(20) NOT NULL,
  `fiyat` int(10) NOT NULL,
  `adet` int(2) NOT NULL,
  `tarih` date NOT NULL DEFAULT current_timestamp(),
  `dürüm` varchar(50) NOT NULL DEFAULT 'hazırlanıyor',
  `ödeme_dürümü` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ürünler`
--

CREATE TABLE `ürünler` (
  `id` varchar(20) NOT NULL,
  `satici_id` varchar(20) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `fiyat` int(10) NOT NULL,
  `resim` varchar(100) NOT NULL,
  `stok` int(100) NOT NULL,
  `ürün_detay` varchar(1000) NOT NULL,
  `dürüm` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ürünler`
--

INSERT INTO `ürünler` (`id`, `satici_id`, `isim`, `fiyat`, `resim`, `stok`, `ürün_detay`, `dürüm`) VALUES
('t?6GJE?oHßğHß?Hsz', 'S?6kJzD?m?t?8?hzv?dv', 'Vanilyalı Serin Lezzet', 100, 'ürün1.jpg', 50, 'Gerçek vanilya özleriyle hazırlanan bu özel dondurma, klasik tatların asaletini modern dokunuşla buluşturuyor. Kremsi dokusu, yoğun aroması ve ferahlatıcı lezzetiyle ilk kaşıkta sizi etkisi altına alacak.\r\n\r\nHer bir paket, 200 gram saf lezzet içerir ve tazeliğini koruyacak şekilde özel tasarlanmış, soğuk zincire uygun kutularda gönderilir. Dondurmamız, üretimden itibaren -18°C\'de muhafaza edilerek kapınıza kadar güvenle ulaştırılır.\r\n\r\nNeden Bu Dondurma?\r\n\r\n%100 gerçek vanilya aroması\r\n\r\nKatkı maddesi içermez\r\n\r\nTaze ve günlük üretim\r\n\r\nKıvamında tatlılık, kremsi doku\r\n\r\nÖzel soğutmalı ambalajla güvenli teslimat\r\n\r\n', 'active'),
('GpItsa?8Po?k?g2s?gtA', 'S?6kJzD?m?t?8?hzv?dv', 'Yaban Mersinli Serin Lezzet', 100, 'ürün2.jpg', 50, 'Doğanın en lezzetli hediyelerinden biri olan yaban mersiniyle hazırlanan bu eşsiz dondurma, meyveli tatları sevenler için vazgeçilmez bir deneyim sunuyor. Hafif ekşi dokunuşu ve yoğun meyve aromasıyla damağınızda taze bir yaz esintisi bırakacak.\r\n\r\nHer bir paket, 200 gram nefis lezzet içerir ve özel tasarlanmış, soğuk zincire uygun kutularda gönderilir. Dondurmamız üretimden itibaren -18°C’de korunarak size ilk günkü tazeliğiyle ulaşır.\r\n\r\nNeden Bu Dondurma?\r\n\r\nGerçek yaban mersininden üretilmiştir\r\n\r\nRenklendirici ve katkı maddesi içermez\r\n\r\nDoğal meyve aroması ve ferahlatıcı tat\r\n\r\nHafif, meyvemsi ve kıvamında tatlılık\r\n\r\nSoğutmalı ambalajla güvenli ve hijyenik teslimat\r\n\r\n\r\n', 'active'),
('?pIf?Rf?4CH?zv?oTz22', 'S?6kJzD?m?t?8?hzv?dv', 'Ahududulu Serin Lezzet', 100, 'ürün4.jpg', 50, 'Canlı rengi ve kendine has aromasıyla öne çıkan ahududu, bu özel dondurmada tazeliğini ve doğallığını koruyarak sizi serinletici bir tat yolculuğuna çıkarıyor. Hafif ekşi, hafif tatlı bu lezzet; meyveli dondurmaları sevenler için tam bir başyapıt!\r\n\r\nHer bir paket, 200 gram özenle hazırlanmış dondurma içerir ve özel olarak tasarlanmış, soğuk zincire uygun kutularda gönderilir. Üretim sonrası -18°C’de muhafaza edilerek size güvenli ve taze bir şekilde ulaştırılır.\r\n\r\nNeden Bu Dondurma?\r\n\r\nGerçek ahududu meyvesiyle üretilmiştir\r\n\r\nYapay renklendirici ve katkı maddesi içermez\r\n\r\nMeyvemsi, ferah ve doğal tat\r\n\r\nYumuşak dokusu ve dengeli tatlılığıyla ideal bir yaz kaçamağı\r\n\r\nSoğutmalı ambalajla hijyenik ve güvenli teslimat', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
