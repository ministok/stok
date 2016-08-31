-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 Ağu 2016, 14:14:45
-- Sunucu sürümü: 10.1.9-MariaDB
-- PHP Sürümü: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `stok`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `birimler`
--

CREATE TABLE `birimler` (
  `id` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='adet , kilo , metre';

--
-- Tablo döküm verisi `birimler`
--

INSERT INTO `birimler` (`id`, `ad`) VALUES
(1, 'kilo'),
(2, 'adet');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borclar`
--

CREATE TABLE `borclar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `tip` int(11) NOT NULL COMMENT 'onların bize borcu var , bizim onlara borcumuz var',
  `tarih` int(11) NOT NULL COMMENT 'borç giriş tarihi',
  `g_tarih` int(11) NOT NULL COMMENT 'güncellenme tarihi',
  `o_tarih` int(11) NOT NULL COMMENT 'ödeme tarihi',
  `onay` int(11) NOT NULL COMMENT 'işlem tamamlandı mı?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cari`
--

CREATE TABLE `cari` (
  `id` int(11) NOT NULL,
  `tip` int(11) NOT NULL COMMENT 'girdi , çıktı',
  `bas_tarih` date NOT NULL,
  `bit_tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='malların cirosu karı belli zaman aralığına göre';

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cihazlar`
--

CREATE TABLE `cihazlar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `api_key` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='api ile bağlanacak cihazlar';

--
-- Tablo döküm verisi `cihazlar`
--

INSERT INTO `cihazlar` (`id`, `ad`, `rol`, `api_key`) VALUES
(1, 'Rıza', 'admin', '123456');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `firmalar`
--

CREATE TABLE `firmalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `fiyat_id` int(11) NOT NULL COMMENT 'tedarikçi veya satıcı(fiyat için)',
  `tel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='mal çıkışı veya mal girişi yapılan firma';

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fiyatlar`
--

CREATE TABLE `fiyatlar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bayi Fiyatı , Müşteri Fiyatı , Komşu Fiyatı';

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hareketler`
--

CREATE TABLE `hareketler` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `firma_id` int(11) NOT NULL,
  `tip` int(11) NOT NULL COMMENT '(firma giriş irsaliyesi , çıkış irsaliyesi) , (firma içi giriş çıkış;üst kat alt kat veya sahip olunan başka birdükkan gibi)',
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `ad`, `email`, `sifre`, `rol`) VALUES
(1, 'Rıza', 'a@a.com', '123', 'yönetici');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `islem` varchar(100) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stoklar`
--

CREATE TABLE `stoklar` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `depo` varchar(100) NOT NULL COMMENT 'stoğun hangi depoda olduğu',
  `kat` varchar(100) NOT NULL,
  `raf` varchar(100) NOT NULL,
  `goz` varchar(100) NOT NULL,
  `g_tarih` datetime NOT NULL COMMENT 'güncellenme tarihi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `barkod` text NOT NULL,
  `ad` varchar(100) NOT NULL,
  `fiyat` int(11) NOT NULL,
  `birim_id` int(11) NOT NULL,
  `seviye` int(11) NOT NULL,
  `kdv` int(11) NOT NULL,
  `iskonto` int(11) NOT NULL,
  `aciklama` text NOT NULL,
  `uzanti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `barkod`, `ad`, `fiyat`, `birim_id`, `seviye`, `kdv`, `iskonto`, `aciklama`, `uzanti`) VALUES
(2, '3523253235532', 'deneme', 1, 1, 1, 1, 1, '1', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `birimler`
--
ALTER TABLE `birimler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `borclar`
--
ALTER TABLE `borclar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cari`
--
ALTER TABLE `cari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cihazlar`
--
ALTER TABLE `cihazlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `firmalar`
--
ALTER TABLE `firmalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fiyatlar`
--
ALTER TABLE `fiyatlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `hareketler`
--
ALTER TABLE `hareketler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stoklar`
--
ALTER TABLE `stoklar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `birim_id` (`birim_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `birimler`
--
ALTER TABLE `birimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `borclar`
--
ALTER TABLE `borclar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `cari`
--
ALTER TABLE `cari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `cihazlar`
--
ALTER TABLE `cihazlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `firmalar`
--
ALTER TABLE `firmalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `fiyatlar`
--
ALTER TABLE `fiyatlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `hareketler`
--
ALTER TABLE `hareketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `stoklar`
--
ALTER TABLE `stoklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `urunler`
--
ALTER TABLE `urunler`
  ADD CONSTRAINT `urunler_ibfk_1` FOREIGN KEY (`birim_id`) REFERENCES `birimler` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
