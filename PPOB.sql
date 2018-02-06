-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 Feb 2018 pada 09.31
-- Versi Server: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppob`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `kode_pegawai` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kodetarif` varchar(20) NOT NULL,
  `kwhterbaru` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `kode_pegawai`, `nama`, `alamat`, `kodetarif`, `kwhterbaru`) VALUES
('PL0001', 'LK0007', 'nesia agatha', 'lumajang', 'R1/1200VA', NULL),
('PL0002', 'LK0002', 'bagus bf', 'yoso', 'R1/450VA', NULL),
('PL0003', 'LK0005', 'rica', 'surabaya', 'R1/900VA', NULL),
('PL0004', 'LK0006', 'anya', 'kediri', 'R1/450VA', NULL),
('PL0005', 'LK0007', 'glaudis', 'banyuwangi', 'R1/900VA-RTM', NULL),
('PL0006', 'LK0005', 'Nanda', 'kuto renon', 'R1/450VA', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(11) NOT NULL,
  `id_pelanggan` varchar(20) NOT NULL,
  `id_loket` varchar(20) NOT NULL,
  `jml_tagihan` int(50) NOT NULL,
  `biaya_pln` varchar(20) NOT NULL,
  `biaya_loket` int(50) NOT NULL,
  `total` int(50) NOT NULL,
  `uang_bayar` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tglbayar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pelanggan`, `id_loket`, `jml_tagihan`, `biaya_pln`, `biaya_loket`, `total`, `uang_bayar`, `status`, `tglbayar`) VALUES
('BR0001', 'PL0006', 'LK0005', 1658755, '5000', 2500, 1666255, '2000000', 'lunas', '2017-01-28 13:49:37'),
('BR0002', 'PL0002', 'LK0002', 1231720, '5000', 2500, 1239220, '1300000', 'lunas', '2018-01-28 15:19:37'),
('BR0003', 'PL0006', 'LK0005', 373500, '5000', 2500, 381000, '381000', 'lunas', '2018-01-29 01:29:22'),
('BR0004', 'PL0002', 'LK0005', 822115, '5000', 2500, 829615, '1000000', 'lunas', '2018-01-29 07:35:35'),
('BR0005', 'PL0002', 'LK0005', 535765, '5000', 2500, 543265, '550000', 'lunas', '2018-02-06 05:40:19'),
('BR0006', 'PL0002', 'LK0005', 234890, '5000', 2500, 242390, '300000', 'lunas', '2018-02-06 06:21:06'),
('BR0007', 'PL0006', 'LK0005', 1029615, '5000', 2500, 1037115, '1100000', 'lunas', '2018-02-06 08:18:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_log`
--

CREATE TABLE `tabel_log` (
  `log_id` int(11) NOT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_user` varchar(255) DEFAULT NULL,
  `log_tipe` int(11) DEFAULT NULL,
  `log_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tabel_log`
--

INSERT INTO `tabel_log` (`log_id`, `log_time`, `log_user`, `log_tipe`, `log_desc`) VALUES
(9, '2018-02-06 06:21:06', 'LK0005', 5, 'PL0002 telah melunasi tunggakan listrik'),
(10, '2018-02-06 08:18:27', 'LK0005', 5, 'Pelanggan PL0006 telah melunasi tunggakan listrik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(20) NOT NULL,
  `tgl_tagihan` date NOT NULL,
  `kode_tarif` varchar(20) NOT NULL,
  `pemakaian` int(50) NOT NULL,
  `total_biaya` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_pelanggan` varchar(50) NOT NULL,
  `id_pembayaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `tgl_tagihan`, `kode_tarif`, `pemakaian`, `total_biaya`, `status`, `id_pelanggan`, `id_pembayaran`) VALUES
('TG0001', '2017-01-31', 'R1/900VA-RTM', 1394, '1884688', '0', 'PL0005', ''),
('TG0002', '2017-02-28', 'R1/450VA', 1369, '568135', '1', 'PL0006', 'BR0001'),
('TG0003', '2017-03-31', 'R1/450VA', 1166, '483890', '1', 'PL0006', 'BR0001'),
('TG0004', '2017-04-20', 'R1/450VA', 916, '380140', '1', 'PL0006', 'BR0001'),
('TG0005', '2017-05-16', 'R1/450VA', 546, '226590', '1', 'PL0006', 'BR0001'),
('TG0006', '2018-01-28', 'R1/450VA', 1126, '467290', '1', 'PL0002', 'BR0002'),
('TG0007', '2017-12-27', 'R1/450VA', 804, '333660', '1', 'PL0002', 'BR0002'),
('TG0008', '2017-11-14', 'R1/450VA', 1038, '430770', '1', 'PL0002', 'BR0002'),
('TG0009', '2017-06-30', 'R1/450VA', 900, '373500', '1', 'PL0006', 'BR0003'),
('TG0010', '2018-01-01', 'R1/450VA', 759, '314985', '1', 'PL0002', 'BR0004'),
('TG0011', '2018-01-03', 'R1/450VA', 1222, '507130', '1', 'PL0002', 'BR0004'),
('TG0012', '2018-03-21', 'R1/450VA', 1291, '535765', '1', 'PL0002', 'BR0005'),
('TG0013', '2018-04-25', 'R1/450VA', 566, '234890', '1', 'PL0002', 'BR0006'),
('TG0014', '2018-02-06', 'R1/450VA', 1126, '467290', '1', 'PL0006', 'BR0007'),
('TG0015', '2018-03-21', 'R1/450VA', 1355, '562325', '1', 'PL0006', 'BR0007'),
('TG0016', '2018-04-26', 'R1/450VA', 795, '329925', '0', 'PL0002', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `kode_tarif` varchar(50) NOT NULL,
  `daya` int(10) NOT NULL,
  `tarifperkwh` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `kode_tarif`, `daya`, `tarifperkwh`) VALUES
(1, 'R1/450VA', 450, 415),
(2, 'R1/900VA', 900, 586),
(3, 'R1/900VA-RTM', 900, 1352),
(4, 'R1/1200VA', 1200, 1467);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `kode_pegawai` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `saldo` varchar(50) NOT NULL,
  `level` enum('loket','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `kode_pegawai`, `username`, `password`, `saldo`, `level`) VALUES
(1, 'A00001', 'admin', 'admin', '100000000000', 'admin'),
(16, 'LK0002', 'sayangnya akooh', 'sayang', '100010000000', 'loket'),
(17, 'LK0003', 'Yofandi', '123456', '100000000000', 'loket'),
(18, 'LK0004', 'jovi pascal', 'jovi', '100000000000', 'loket'),
(35, 'LK0005', 'veranda', 'veranda', '99995946000', 'loket'),
(36, 'LK0006', 'veronica', 'veronica', '125000000000', 'loket'),
(37, 'LK0007', 'amda', 'amda', '100000000000', 'loket');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `tabel_log`
--
ALTER TABLE `tabel_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_log`
--
ALTER TABLE `tabel_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
