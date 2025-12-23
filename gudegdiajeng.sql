-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Des 2025 pada 12.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudegdiajeng`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`, `no_telepon`, `created_at`, `updated_at`) VALUES
(2, 'Admin Gudeg Diajeng', 'admin@example.com', '$2y$10$D99HUTgXppSOlyJH13GwmOoXbaHMbaxUVro4Y9WLdZZ4Th29m6Azy', '081234567890', '2025-11-11 12:01:40', '2025-11-11 06:31:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti_pembayaran`
--

CREATE TABLE `bukti_pembayaran` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_verifikasi` enum('Menunggu','Diterima','Ditolak') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bukti_pembayaran`
--

INSERT INTO `bukti_pembayaran` (`id`, `pesanan_id`, `file_path`, `upload_at`, `status_verifikasi`) VALUES
(3, NULL, 'uploads/bukti/1763593407_051bee522627ada4b7be.jpg', '2025-11-19 23:03:27', 'Menunggu'),
(4, NULL, 'uploads/bukti/1763593598_0c266d47b088aff6c72b.jpg', '2025-11-19 23:06:38', 'Menunggu'),
(5, NULL, 'uploads/bukti/1763594246_e81e2f9c44031be4b05a.jpg', '2025-11-19 23:17:26', 'Diterima'),
(6, NULL, 'uploads/bukti/1763597427_a12a58603cddf6cdd98f.jpg', '2025-11-20 00:10:27', 'Diterima'),
(7, NULL, 'uploads/bukti/1763599634_5c2d4b64c18e15095b18.jpg', '2025-11-20 00:47:14', 'Menunggu'),
(8, NULL, 'uploads/bukti/1763599805_2eff8f1102ec16f0ea7f.jpg', '2025-11-20 00:50:05', 'Diterima'),
(9, NULL, 'uploads/bukti/1763611298_ddaf17cd1a4c91cd022b.jpg', '2025-11-20 04:01:39', 'Diterima'),
(10, NULL, 'uploads/bukti/1763651133_7656c31745ea7e613f31.jpg', '2025-11-20 15:05:33', 'Diterima'),
(11, NULL, 'uploads/bukti/1763651869_2fed05e427c1d04ea412.jpg', '2025-11-20 15:17:49', 'Diterima'),
(12, NULL, 'uploads/bukti/1765135586_14a2ac35d8b8c690b315.jpg', '2025-12-07 19:26:26', 'Menunggu'),
(13, NULL, 'uploads/bukti/1765135775_863f6a4ff1abc79a2531.jpg', '2025-12-07 19:29:35', 'Diterima'),
(14, NULL, 'uploads/bukti/1765173245_4fb0af4a8d7e7c0c98f0.jpg', '2025-12-08 05:54:05', 'Diterima'),
(15, NULL, 'uploads/bukti/1765173977_2b85af3d81a374e6c473.jpg', '2025-12-08 06:06:17', 'Diterima'),
(16, NULL, 'uploads/bukti/1765184505_5e3317a6684590466acc.jpg', '2025-12-08 09:01:45', 'Diterima'),
(17, NULL, 'uploads/bukti/1765184797_6bed51bc23dfa5cd9f93.jpg', '2025-12-08 09:06:37', 'Diterima'),
(18, NULL, 'uploads/bukti/1765184828_98cc4bc11c771f50f4da.jpg', '2025-12-08 09:07:08', 'Diterima'),
(19, NULL, 'uploads/bukti/1765184888_0d6504d28378b7f68745.jpg', '2025-12-08 09:08:08', 'Diterima'),
(20, NULL, 'uploads/bukti/1765184956_e6ebe4833dbc57e8ea31.jpg', '2025-12-08 09:09:16', 'Diterima'),
(21, NULL, 'uploads/bukti/1765251084_142b0452fd9dd34b1418.jpg', '2025-12-09 03:31:24', 'Diterima'),
(22, NULL, 'uploads/bukti/1765256352_0ca6f0753eccdd8ffcca.jpg', '2025-12-09 04:59:12', 'Diterima'),
(23, NULL, 'uploads/bukti/1766242877_b26bec0d6efd01ae46b6.jpg', '2025-12-20 15:01:17', 'Diterima');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_menu`
--

CREATE TABLE `detail_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `komposisi` text DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `status_tersedia` enum('Tersedia','Habis') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_menu`
--

INSERT INTO `detail_menu` (`id`, `menu_id`, `deskripsi`, `komposisi`, `stok`, `status_tersedia`) VALUES
(1, 1, 'Paket lengkap berisi nasi putih hangat dengan gudeg autentik Jogja, dilengkapi sambal goreng krecek, telur pindang, dan ayam (ayam opor / ayam bakar madu / ayam bacem). Cocok untuk makan siang maupun makan malam yang mengenyangkan.', 'Nasi putih, gudeg nangka muda, sambal goreng krecek, telur pindang, ayam.', 11, 'Tersedia'),
(2, 13, 'Telur pindang adalah lauk pendamping khas gudeg yang dimasak dengan cara direbus dalam campuran bumbu rempah dan daun jati hingga warnanya kecokelatan. Rasanya gurih dengan aroma rempah yang khas, cocok dipadukan dengan manisnya gudeg.', 'Telur ayam, daun jati, kecap manis, bawang putih, bawang merah, lengkuas, daun salam, garam', 16, 'Tersedia'),
(3, 11, 'Tempe bacem adalah lauk tradisional Jawa yang dibuat dari tempe direbus dalam bumbu bacem berbasis gula jawa dan rempah, kemudian digoreng hingga kecokelatan. Rasanya manis gurih dan sangat cocok sebagai pendamping gudeg.', 'Tempe, gula jawa, kecap manis, bawang putih, ketumbar, lengkuas, daun salam, garam', 15, 'Tersedia'),
(4, 10, 'Tahu bacem adalah lauk tradisional Jawa yang dibuat dari tahu direbus dalam bumbu bacem berbasis gula jawa dan rempah, kemudian digoreng hingga kecokelatan. Rasanya manis gurih dan sangat cocok sebagai pendamping gudeg.', 'Tahu, gula jawa, kecap manis, bawang putih, ketumbar, lengkuas, daun salam, garam', 15, 'Tersedia'),
(5, 6, 'Sayur lombok adalah sayur khas Jawa berbahan dasar cabai hijau panjang yang dimasak dengan kuah santan. Rasanya gurih pedas ringan, sangat cocok sebagai pelengkap gudeg manis untuk memberikan sensasi rasa seimbang.', 'Cabai hijau besar, santan, bawang putih, bawang merah, lengkuas, daun salam, teri/ikan asin (opsional), garam', 6, 'Tersedia'),
(6, 3, 'Krecek adalah lauk pendamping khas Jogja berupa kulit sapi yang dimasak menjadi sambal goreng. Teksturnya kenyal dan rasanya gurih pedas, berpadu dengan santan serta bumbu rempah tradisional. Cocok untuk menyeimbangkan manisnya gudeg', 'Kulit sapi, cabai merah, santan, bawang merah, bawang putih, lengkuas, daun salam', 6, 'Tersedia'),
(7, 7, 'Mangut lele adalah hidangan khas Jawa berupa ikan lele yang digoreng kemudian dimasak dalam kuah santan pedas dengan bumbu rempah. Rasanya gurih pedas dengan aroma asap yang khas, cocok sebagai lauk pendamping gudeg.', 'Lele goreng, santan, cabai merah, cabai rawit, bawang merah, bawang putih, lengkuas, daun salam, daun jeruk', 6, 'Tersedia'),
(8, 8, 'Gudeg Nangka adalah makanan khas Yogyakarta yang terbuat dari nangka muda yang dimasak sangat lama dengan santan kelapa dan gula merah hingga empuk, berwarna cokelat tua, dan rasanya manis-gurih,', 'Nangka muda dimasak santan, gula merah dan daun jati', 7, 'Tersedia'),
(9, 5, 'Ayam opor adalah hidangan ayam yang dimasak dengan kuah santan berbumbu rempah seperti ketumbar, kunyit, jahe, dan serai. Teksturnya lembut dengan rasa gurih yang khas, menjadikannya salah satu lauk populer untuk melengkapi gudeg Jogja.', 'Ayam kampung, santan, bawang merah, bawang putih, kunyit, jahe, lengkuas, ketumbar, serai, daun salam, daun jeruk', 2, 'Tersedia'),
(10, 9, 'Ayam bakar madu dimasak dengan bumbu manis gurih khas Jawa yang dipadukan dengan madu asli, menghasilkan aroma bakaran yang harum dan cita rasa manis gurih yang lezat. Sangat cocok dipadukan dengan gudeg dan nasi hangat.', 'Ayam kampung, madu, kecap manis, bawang putih, bawang merah, ketumbar, lengkuas, garam', 10, 'Tersedia'),
(11, 4, 'Ayam goreng bacem dimasak dengan teknik perendaman bumbu bacem khas Jawa menggunakan gula merah, bawang putih, ketumbar, lengkuas, daun salam, dan kecap. Rasanya manis gurih yang meresap hingga ke dalam daging, lalu digoreng hingga cokelat keemasan', 'Ayam kampung, gula merah, bawang putih, ketumbar, lengkuas, kecap, daun salam', 4, 'Tersedia'),
(13, 15, 'Pepaya muda yang direbus, diisi dengan campuran kelapa parut berbumbu pedas dan ikan teri/udang rebon. Rasanya gurih, pedas, sedikit pahit alami dari daun pepaya, dan aroma kelapa sangrai yang khas.', 'Daun pepaya muda, kelapa parut setengah tua, ikan teri nasi/teri jengki atau udang rebon, dan cabai merah keriting', 3, 'Tersedia'),
(14, 16, 'Buncis segar yang renyah ditumis bersama ati ampela ayam yang sudah direbus dan dipotong dadu, dibumbui manis-pedas dengan kecap manis. Rasanya gurih, sedikit manis, pedas ringan, dan aroma bawang yang kuat', 'Buncis segar, ati ampela ayam, bawang merah & bawang putih, dan cabai merah besar & cabai rawit ', 1, 'Tersedia'),
(15, 17, 'Daun pepaya muda yang sudah direbus, ditumis dengan buncis renyah, bumbu bawang, cabai, dan sedikit terasi/gula. Rasanya gurih, sedikit pahit khas pepaya, pedas ringan, sangat cocok jadi lauk hemat nasi hangat.', 'Daun pepaya muda, bawang merah & putih iris, cabai merah/rawit iris, terasi bakar sedikit, garam, gula, sedikit air.', 1, 'Tersedia'),
(16, 18, 'Gembus (ampas tahu) yang manis gurih, empuk, dan legit karena dibacem lama dengan air kelapa + gula merah. Warna cokelat mengkilat, aroma kecap manis kuat, cocok jadi lauk hemat atau camilan.', 'Gembus (potong kotak), air kelapa, gula merah sisir, kecap manis, bawang merah & putih geprek, lengkuas, daun salam, ketumbar bubuk', 5, 'Tersedia'),
(17, 19, 'Botok kukus dari daun mlanding (daun lamtoro) yang harum, dicampur parutan kelapa & teri, dibungkus daun pisang. Rasa gurih, sedikit manis-pahit alami, tekstur lembap & wangi daun pisang.', 'Daun mlanding/lamtoro muda, kelapa parut setengah tua, teri nasi/teri medan (sangrai), bawang merah-putih, cabai, kencur, daun jeruk, garam, gula, sedikit terasi', 3, 'Tersedia'),
(18, 20, 'Kikil sapi empuk yang ditumis pedas menyegarkan dengan cabai hijau besar. Rasa pedas gurih, sedikit manis, tekstur kenyal, cocok buat lauk nasi panas.', 'Kikil sapi (direbus empuk, potong kotak), cabai hijau besar (iris serong), bawang merah & putih iris, lengkuas & serai geprek, daun jeruk, kecap manis sedikit, garam, gula, kaldu bubuk', 0, 'Habis'),
(19, 21, 'Ayam kampung segar yang segar-asam pedas, dikukus sebentar dengan belimbing wuluh & cabai hijau. Kuah bening ringan, aroma daun jeruk kuat, rasa asam segar dan pedas.', 'Ayam kampung, belimbing wuluh, cabai hijau besar & rawit utuh, bawang merah-putih iris, serai, lengkuas, daun jeruk, daun salam.', 3, 'Tersedia'),
(20, 22, 'Paket berisi nasi putih hangat dengan gudeg autentik Jogja, dilengkapi sambal goreng krecek, dan telur pindang. Cocok untuk makan siang maupun makan malam yang mengenyangkan.', 'Nasi putih, gudeg nangka muda, sambal goreng krecek, telur pindang.', 4, 'Tersedia'),
(21, 23, 'Nasi hangat, gudeg nangka manis gurih, krecek kulit sapi renyah pedas, pilihan (tumisan daun pepaya / buncis ati ampela / kikil cabai hijau. Lengkap, manis-pedas-gurih dalam satu piring!', 'Nasi putih, gudeg nangka muda, sambal goreng krecek, aneka tumisan', 1, 'Tersedia'),
(22, 24, 'Paket berisi nasi putih hangat dengan gudeg autentik Jogja, dilengkapi sambal goreng krecek. Cocok untuk makan siang maupun makan malam yang mengenyangkan.', 'Nasi putih, gudeg nangka muda, sambal goreng krecek.', 2, 'Tersedia'),
(23, 25, 'Gorengan kentang, renyah luar-empuk dalam, gurih & wangi bawang. Lauk pendamping wajib nasi uduk, soto, atau lontong sayur.', 'Kentang (rebus/goreng, haluskan), daging sapi giling, bawang merah & putih goreng, telur, seledri iris, pala bubuk, merica, garam', 5, 'Tersedia'),
(24, 26, 'Teh celup dingin yang manis legit, harum, segar, cocok temani semua menu.', 'Teh celup, gula pasir, es batu', 3, 'Tersedia'),
(25, 27, 'Pare iris tipis rasanya renyah, gurih-manis-pedas dan pahitnya ringan.', 'Pare, bawang merah & putih iris cabai merah/rawit iris, kecap manis sedikit, garam, gula.', 0, 'Habis'),
(27, 31, 'Tahu kukus dibungkus daun pisang dengan bumbu rempah kuning pedas, harum daun kemangi. Rasa gurih lembut, pedas mantap, wangi daun pisang khas.', 'Tahu, Kelapa parut, bawang merah-putih, kunyit, cabai, daun kemangi, daun jeruk, dan serai.', 6, 'Tersedia'),
(28, 32, 'Ikan mas dibumbu kuning pedas rempah, dibungkus daun pisang lalu dikukus. Rasa gurih pedas asam, daging empuk berbumbu meresap, harum daun pisang super khas.', 'Ikan mas segar, kelapa parut setengah tua, bawang merah-putih, kunyit, cabai merah-rawit, serai, lengkuas, daun jeruk, daun salam, tomat, kemangi, garam, dan gula.', 4, 'Tersedia'),
(29, 33, 'Ikan peda dibumbu pedas rempah, dibungkus daun pisang lalu dikukus/bakar. Rasa asin gurih pedas, daging empuk meresap bumbu, harum daun pisang.', 'Ikan peda asin, bawang merah-putih, cabai merah-rawit, tomat, daun kemangi, daun salam, serai, lengkuas, kunyit, garam, dan gula.', 1, 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(12,0) NOT NULL,
  `catatan_item` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `pesanan_id`, `menu_id`, `jumlah`, `subtotal`, `catatan_item`) VALUES
(2, 6, 1, 1, 25000, NULL),
(3, 7, 1, 2, 50000, NULL),
(4, 7, 3, 2, 40000, NULL),
(5, 8, 8, 3, 60000, NULL),
(6, 8, 7, 1, 18000, NULL),
(7, 9, 4, 2, 60000, NULL),
(8, 9, 1, 5, 125000, NULL),
(9, 9, 6, 2, 24000, NULL),
(10, 10, 8, 1, 20000, NULL),
(11, 11, 9, 3, 75000, NULL),
(12, 12, 5, 2, 50000, NULL),
(13, 13, 9, 2, 50000, NULL),
(14, 14, 3, 1, 20000, NULL),
(15, 14, 7, 3, 54000, NULL),
(16, 14, 8, 2, 40000, NULL),
(17, 14, 6, 1, 12000, NULL),
(18, 15, 5, 1, 25000, NULL),
(19, 16, 8, 2, 40000, NULL),
(20, 17, 3, 2, 40000, NULL),
(21, 18, 9, 2, 50000, NULL),
(22, 18, 8, 2, 40000, NULL),
(23, 18, 1, 2, 50000, NULL),
(24, 19, 9, 1, 25000, NULL),
(25, 20, 9, 1, 25000, NULL),
(26, 21, 8, 1, 20000, NULL),
(27, 22, 7, 3, 54000, NULL),
(28, 23, 6, 2, 24000, NULL),
(29, 23, 8, 3, 60000, NULL),
(30, 24, 8, 2, 40000, NULL),
(31, 25, 9, 3, 75000, NULL),
(32, 26, 7, 1, 18000, NULL),
(33, 26, 6, 3, 36000, NULL),
(45, 37, 3, 1, 67000, NULL),
(46, 36, 4, 1, 85000, NULL),
(47, 35, 7, 1, 45000, NULL),
(48, 34, 1, 2, 150000, NULL),
(49, 33, 8, 1, 30000, NULL),
(50, 32, 6, 3, 120000, NULL),
(51, 31, 9, 1, 25000, NULL),
(52, 30, 4, 1, 50000, NULL),
(53, 27, 1, 2, 150000, NULL),
(54, 28, 4, 1, 30000, NULL),
(55, 29, 7, 3, 120000, NULL),
(56, 38, 1, 1, 15000, NULL),
(57, 38, 3, 2, 30000, NULL),
(58, 39, 4, 1, 20000, NULL),
(59, 39, 7, 2, 40000, NULL),
(60, 40, 1, 2, 30000, NULL),
(61, 41, 8, 2, 50000, NULL),
(62, 41, 10, 1, 30000, NULL),
(63, 42, 5, 2, 20000, NULL),
(64, 42, 1, 3, 45000, NULL),
(65, 43, 9, 1, 18000, NULL),
(66, 43, 3, 1, 20000, NULL),
(67, 44, 4, 2, 40000, NULL),
(68, 44, 6, 1, 25000, NULL),
(69, 45, 11, 2, 40000, NULL),
(70, 45, 13, 1, 20000, NULL),
(71, 46, 7, 3, 75000, NULL),
(72, 47, 10, 1, 30000, NULL),
(73, 47, 4, 1, 20000, NULL),
(74, 48, 6, 2, 50000, NULL),
(75, 48, 1, 1, 15000, NULL),
(76, 49, 8, 3, 90000, NULL),
(77, 50, 5, 2, 20000, NULL),
(78, 50, 9, 1, 18000, NULL),
(79, 51, 10, 2, 60000, NULL),
(80, 52, 13, 1, 20000, NULL),
(81, 52, 3, 2, 40000, NULL),
(82, 53, 11, 2, 40000, NULL),
(83, 54, 7, 2, 50000, NULL),
(84, 54, 1, 1, 15000, NULL),
(85, 55, 4, 3, 60000, NULL),
(86, 56, 6, 1, 25000, NULL),
(87, 56, 8, 2, 50000, NULL),
(88, 57, 3, 3, 60000, NULL),
(89, 57, 5, 1, 10000, NULL),
(90, 58, 10, 1, 30000, NULL),
(91, 58, 7, 2, 40000, NULL),
(92, 59, 9, 3, 54000, NULL),
(93, 60, 11, 2, 40000, NULL),
(94, 60, 1, 1, 15000, NULL),
(95, 61, 6, 3, 75000, NULL),
(96, 62, 13, 1, 20000, NULL),
(97, 62, 8, 3, 75000, NULL),
(98, 63, 4, 2, 40000, NULL),
(99, 63, 3, 1, 20000, NULL),
(100, 64, 7, 2, 50000, NULL),
(101, 65, 5, 2, 20000, NULL),
(102, 65, 11, 1, 20000, NULL),
(103, 66, 8, 3, 90000, NULL),
(104, 67, 10, 2, 60000, NULL),
(105, 67, 3, 1, 20000, NULL),
(106, 68, 3, 1, 15000, NULL),
(107, 68, 7, 2, 30000, NULL),
(108, 69, 4, 1, 20000, NULL),
(109, 69, 10, 1, 25000, NULL),
(110, 69, 1, 1, 15000, NULL),
(111, 70, 5, 2, 24000, NULL),
(112, 71, 8, 1, 18000, NULL),
(113, 71, 9, 2, 36000, NULL),
(114, 72, 11, 1, 22000, NULL),
(115, 72, 3, 1, 15000, NULL),
(116, 72, 6, 1, 18000, NULL),
(117, 73, 7, 1, 15000, NULL),
(118, 74, 10, 2, 50000, NULL),
(119, 74, 4, 1, 20000, NULL),
(120, 75, 1, 1, 15000, NULL),
(121, 75, 5, 2, 24000, NULL),
(122, 76, 11, 1, 22000, NULL),
(123, 76, 9, 1, 18000, NULL),
(124, 76, 7, 1, 15000, NULL),
(125, 77, 3, 1, 15000, NULL),
(126, 78, 8, 1, 18000, NULL),
(127, 78, 5, 2, 24000, NULL),
(128, 79, 13, 1, 25000, NULL),
(129, 79, 9, 2, 36000, NULL),
(130, 80, 4, 2, 40000, NULL),
(131, 80, 6, 1, 18000, NULL),
(132, 81, 1, 1, 15000, NULL),
(133, 81, 7, 1, 15000, NULL),
(134, 81, 11, 1, 22000, NULL),
(135, 82, 5, 1, 12000, NULL),
(136, 83, 13, 2, 50000, NULL),
(137, 83, 3, 1, 15000, NULL),
(138, 84, 10, 1, 25000, NULL),
(139, 84, 1, 1, 15000, NULL),
(140, 85, 6, 2, 36000, NULL),
(141, 85, 8, 1, 18000, NULL),
(142, 86, 9, 1, 18000, NULL),
(143, 87, 11, 1, 22000, NULL),
(144, 87, 4, 1, 20000, NULL),
(145, 87, 5, 1, 12000, NULL),
(146, 88, 3, 1, 15000, NULL),
(147, 89, 7, 2, 30000, NULL),
(148, 89, 8, 1, 18000, NULL),
(149, 90, 10, 1, 25000, NULL),
(150, 90, 5, 1, 12000, NULL),
(151, 91, 1, 1, 15000, NULL),
(152, 92, 3, 1, 15000, NULL),
(153, 92, 9, 1, 18000, NULL),
(154, 92, 13, 1, 25000, NULL),
(155, 93, 6, 2, 36000, NULL),
(156, 93, 8, 1, 18000, NULL),
(157, 94, 11, 1, 22000, NULL),
(158, 94, 10, 2, 50000, NULL),
(159, 95, 7, 1, 15000, NULL),
(160, 96, 4, 1, 20000, NULL),
(161, 96, 3, 1, 15000, NULL),
(162, 97, 5, 2, 24000, NULL),
(163, 97, 8, 1, 18000, NULL),
(164, 98, 5, 1, 25000, NULL),
(165, 98, 8, 2, 20000, NULL),
(166, 99, 3, 1, 30000, NULL),
(167, 99, 11, 2, 30000, NULL),
(168, 100, 1, 1, 15000, NULL),
(169, 101, 7, 2, 40000, NULL),
(170, 101, 4, 1, 20000, NULL),
(171, 102, 10, 1, 20000, NULL),
(172, 102, 8, 1, 15000, NULL),
(173, 103, 6, 2, 30000, NULL),
(174, 104, 9, 2, 40000, NULL),
(175, 104, 1, 1, 15000, NULL),
(176, 105, 13, 1, 25000, NULL),
(177, 105, 4, 1, 20000, NULL),
(178, 106, 5, 1, 25000, NULL),
(179, 106, 7, 2, 40000, NULL),
(180, 107, 3, 1, 30000, NULL),
(181, 108, 8, 2, 20000, NULL),
(182, 108, 10, 1, 20000, NULL),
(183, 109, 11, 1, 35000, NULL),
(184, 109, 7, 2, 40000, NULL),
(185, 110, 4, 1, 20000, NULL),
(186, 110, 9, 2, 40000, NULL),
(187, 111, 5, 1, 25000, NULL),
(188, 111, 13, 1, 25000, NULL),
(189, 111, 3, 1, 30000, NULL),
(190, 112, 6, 2, 30000, NULL),
(191, 113, 7, 1, 20000, NULL),
(192, 113, 9, 2, 40000, NULL),
(193, 114, 5, 1, 25000, NULL),
(194, 114, 8, 1, 15000, NULL),
(195, 115, 10, 2, 40000, NULL),
(196, 115, 3, 1, 30000, NULL),
(197, 116, 6, 2, 30000, NULL),
(198, 116, 11, 1, 35000, NULL),
(199, 117, 4, 1, 20000, NULL),
(200, 117, 5, 1, 25000, NULL),
(201, 118, 13, 1, 25000, NULL),
(202, 119, 7, 2, 40000, NULL),
(203, 119, 9, 1, 20000, NULL),
(204, 120, 3, 1, 30000, NULL),
(205, 120, 10, 1, 20000, NULL),
(206, 121, 1, 2, 30000, NULL),
(207, 122, 4, 1, 20000, NULL),
(208, 122, 11, 2, 70000, NULL),
(209, 123, 6, 2, 30000, NULL),
(210, 123, 9, 1, 20000, NULL),
(211, 124, 7, 1, 20000, NULL),
(212, 124, 13, 2, 50000, NULL),
(213, 125, 8, 1, 15000, NULL),
(214, 125, 5, 1, 25000, NULL),
(215, 126, 3, 1, 30000, NULL),
(216, 126, 10, 1, 20000, NULL),
(217, 127, 4, 1, 20000, NULL),
(218, 127, 11, 1, 35000, NULL),
(219, 128, 9, 3, 75000, NULL),
(220, 128, 13, 5, 40000, NULL),
(221, 128, 6, 1, 12000, NULL),
(222, 128, 8, 1, 20000, NULL),
(223, 128, 3, 2, 40000, NULL),
(224, 129, 7, 1, 18000, NULL),
(227, 131, 4, 1, 18000, NULL),
(228, 131, 7, 1, 20000, NULL),
(229, 132, 5, 2, 30000, NULL),
(230, 133, 9, 1, 12000, NULL),
(231, 133, 10, 1, 25000, NULL),
(232, 134, 11, 1, 22000, NULL),
(233, 134, 1, 1, 15000, NULL),
(234, 135, 13, 2, 40000, NULL),
(235, 135, 3, 1, 15000, NULL),
(236, 136, 6, 1, 18000, NULL),
(237, 136, 4, 1, 18000, NULL),
(238, 136, 9, 1, 12000, NULL),
(239, 136, 1, 1, 15000, NULL),
(240, 136, 7, 1, 20000, NULL),
(241, 137, 1, 3, 135000, NULL),
(242, 137, 22, 1, 27000, NULL),
(243, 138, 15, 2, 30000, NULL),
(244, 139, 1, 1, 45000, NULL),
(245, 140, 10, 2, 10000, NULL),
(246, 140, 13, 2, 12000, NULL),
(247, 141, 3, 2, 50000, NULL),
(248, 141, 19, 2, 22000, NULL),
(249, 142, 9, 1, 23000, NULL),
(250, 143, 23, 2, 56000, NULL),
(251, 144, 33, 2, 34000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_menu`
--

INSERT INTO `kategori_menu` (`id`, `nama_kategori`, `created_at`) VALUES
(1, 'Aneka Lauk', '2025-12-17 17:14:31'),
(2, 'Aneka Pepes', '2025-12-17 17:14:31'),
(3, 'Aneka Tumisan', '2025-12-17 17:14:31'),
(4, 'Paket Nasi', '2025-12-17 17:14:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `kategori_id`, `nama_menu`, `harga`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 4, 'Nasi Gudeg Krecek + Ayam + Telur', 45000, '1762947456_ef7c349ad5088ec2fb86.jpg', '2025-11-12 04:13:20', '2025-12-17 17:26:14'),
(3, 1, 'Sambal Goreng Krecek', 25000, '1762947877_9dd638399fd7d0ac3c0a.jpg', '2025-11-12 04:44:37', '2025-12-17 17:20:04'),
(4, 1, 'Ayam Goreng Bacem', 23000, '1762975541_493c2ed4e96641ffb657.jpg', '2025-11-12 12:25:41', '2025-12-17 17:20:04'),
(5, 1, 'Ayam Opor', 23000, '1765175308_f8a56d2e455c491a4c6d.png', '2025-11-12 12:26:35', '2025-12-17 17:20:04'),
(6, 1, 'Sayur Lombok Tahu Tempe', 20000, '1762975640_b59edb40af196627d4bf.jpg', '2025-11-12 12:27:20', '2025-12-17 17:20:04'),
(7, 1, 'Mangut Lele', 18000, '1762975683_9bff3498ac46ee96386b.jpg', '2025-11-12 12:28:03', '2025-12-17 17:20:04'),
(8, 1, 'Gudeg', 25000, '1762975725_cf6051b75bb192137d03.jpg', '2025-11-12 12:28:45', '2025-12-17 17:20:04'),
(9, 1, 'Ayam Bakar Madu', 23000, '1765175261_ec97572d40c309965d14.png', '2025-11-12 12:29:26', '2025-12-17 18:45:36'),
(10, 1, 'Tahu Bacem', 5000, '1762975832_36bc788927da0ba0f0cd.jpg', '2025-11-12 12:30:32', '2025-12-17 17:20:04'),
(11, 1, 'Tempe Bacem', 6000, '1765175537_7c03a03a6884dbddf7de.png', '2025-11-12 12:30:56', '2025-12-17 17:20:04'),
(13, 1, 'Telur Pindang', 6000, '1763585519_e2c3e470db5f20596a1d.jpg', '2025-11-19 13:51:59', '2025-12-17 17:20:04'),
(15, 1, 'Buntil Daun Pepaya', 15000, '1765175770_a88a1c8f8b182358e572.jpg', '2025-12-08 06:36:10', '2025-12-17 17:20:04'),
(16, 3, 'Tumis Buncis Ati Ampela', 15000, '1765175987_f802d38aae65ec07af45.jpg', '2025-12-08 06:39:47', '2025-12-17 17:31:07'),
(17, 3, 'Tumis Daun Pepaya', 15000, '1765176211_4f85f6e46c261a518491.png', '2025-12-08 06:43:31', '2025-12-17 17:31:07'),
(18, 1, 'Gembus Bacem', 6000, '1765176414_c440a547e37529069a89.jpg', '2025-12-08 06:46:54', '2025-12-17 17:20:04'),
(19, 2, 'Botok Mlanding', 11000, '1765176539_e400609611ffc6c12bb3.png', '2025-12-08 06:48:59', '2025-12-17 17:32:20'),
(20, 3, 'Tumis Kikil Cabai Hijau', 18000, '1765176673_9442dafc95843c543abb.png', '2025-12-08 06:51:13', '2025-12-17 17:31:07'),
(21, 1, 'Garang Asem Ayam Kampung', 30000, '1765176851_736ed46896bde41242d5.png', '2025-12-08 06:54:11', '2025-12-17 17:20:04'),
(22, 4, 'Nasi Gudeg Krecek + Telur', 27000, '1765177114_bece3d88cb2e704819d0.jpg', '2025-12-08 06:58:34', '2025-12-17 17:27:57'),
(23, 4, 'Nasi Gudeg Krecek + Tumisan', 28000, '1765177313_8f505197283a56393c48.jpg', '2025-12-08 07:01:53', '2025-12-17 17:27:57'),
(24, 4, 'Nasi Gudeg Krecek', 23000, '1765177535_5b30b447a5a4ef85df1c.png', '2025-12-08 07:05:35', '2025-12-17 17:27:57'),
(25, 1, 'Perkedel', 6000, '1765177690_6dadbce7b59f8761796d.png', '2025-12-08 07:08:10', '2025-12-17 17:20:04'),
(26, 1, 'Teh Manis', 4000, '1765178088_a5d9b6996471e261521e.jpg', '2025-12-08 07:14:48', '2025-12-17 17:20:04'),
(27, 3, 'Tumis Pare', 15000, '1765178391_3b8ee295acc38edb72be.jpg', '2025-12-08 07:19:51', '2025-12-17 17:31:07'),
(31, 2, 'Pepes Tahu', 8000, '1765996792_2b7f8cd7b833515a3e4c.jpg', '2025-12-17 18:39:52', '2025-12-17 18:45:19'),
(32, 2, 'Pepes Ikan Mas', 25000, '1765997374_e3b00dd95d013ed679ee.jpg', '2025-12-17 18:49:34', '2025-12-17 18:49:34'),
(33, 2, 'Pepes Ikan Asin', 17000, '1765997531_1726780536c4e994060a.jpeg', '2025-12-17 18:52:11', '2025-12-17 18:52:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id` int(11) NOT NULL,
  `nama_metode` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id`, `nama_metode`, `deskripsi`) VALUES
(1, 'QRIS', 'Pembayaran via QRIS'),
(2, 'COD', 'Cash On Delivery');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama_pelanggan`, `no_telepon`, `alamat`, `email`, `password`, `created_at`, `updated_at`) VALUES
(3, 'dimaas', '08211367081', 'jalan joglo raya2', 'dimas@gmail.com', '$2y$10$WhwI24FjyTe1DzCYQUiAS.0vRy8jj9.fuNgoNDp2KCEu2qQyyoYxG', '2025-11-12 11:48:31', '2025-11-12 18:48:31'),
(4, 'adit', '08211367005', 'Jalan Haji Saaba', 'adit@gmail.com', '$2y$10$zOzacomTPllBglS.EEdlkuXwuhb3eKZjgJV3XPELiMog8/VIda.wG', '2025-11-12 11:51:35', '2025-11-12 18:51:35'),
(5, 'test1', '0821136709876', 'Jalan jalan di pasar', 'test123@gmail.com', '$2y$10$d3E/xHptgjCptz40XyvNS.COHgpnPeMlHg5zjUdF4RLh8.eheNPSu', '2025-11-12 19:44:48', '2025-11-13 02:44:48'),
(6, 'test3', '082113670968', 'jalan test', 'test3@gmail.com', '$2y$10$S5epl.LCHgP8ZkBgJNy0vOvV9kNvWD/WDlqbH7.a2psA7/nZqYIMO', '2025-11-12 20:03:42', '2025-11-13 03:03:42'),
(7, 'tes0', '08211367010', 'jalan test000', 'tes0@gmail.com', '$2y$10$JVIeHk/PX3R4/92Pwjb4gOpVys3mWZk/ADj7Of87tRBuABHXZz1uS', '2025-11-13 00:39:20', '2025-11-13 07:39:20'),
(8, 'reinerius', '08211367768', 'Jalan Meruya iliir', 'rei@gmail.com', '$2y$10$BX0flpCY4QnnPftIC8Nb1egMew31GXqO5YM.6rTJiZsqu2/ttbwqm', '2025-11-13 01:09:26', '2025-11-13 08:09:26'),
(9, 'tes123', '08211367077', 'jalan tess', 'tes123@gmail.com', '$2y$10$qAiKzpVYklQiZ4OcQrVWAuBpUbylcU9ehGMo/vw6eydQeun72CyHO', '2025-11-13 01:25:54', '2025-11-13 08:25:54'),
(10, 'yong', '08211367126', 'jalan meruya ilir2', 'yong@gmail.com', '$2y$10$PKMuGlZ7bZdc5IJIyOJLqepBBFzvTS.wkovyXUtuRSb7s8varNukO', '2025-11-17 02:47:38', '2025-11-17 09:47:38'),
(11, 'sutya', '08211367152', 'jalan joglo', 'sutya@gmail.com', '$2y$10$IR3CFG8NqpjJip3ru5Nfq.oFcpwJhjsnv6w3rCyAao6HEI91FqOxC', '2025-11-17 06:59:28', '2025-11-17 13:59:28'),
(12, 'ayu', '082113670787', 'jalan jogglo 1', 'ayu@gmail.com', '$2y$10$QPE1D6AJNOAB.liGj.06VOGK16dkLrF9dyysV.EETn3P0Wcx6Oc/e', '2025-11-17 07:56:42', '2025-11-17 14:56:42'),
(13, 'user', '08211367557', 'jalan user kembangan', 'user@gmail.com', '$2y$10$b46hmPB5JFhTGT7kUgeDvuM2edXfAuBB8WX3Wd4rP4FBWzM015yc2', '2025-11-17 19:49:10', '2025-11-18 02:49:10'),
(14, 'viona', '0821136701455', 'jalan bandung', 'viona@gmail.com', '$2y$10$AtuhQvY2DZPNWWEpkWYfM.gsceLR9K/QNVfODeRJoPlF1YCaYcGvm', '2025-11-19 08:06:24', '2025-11-19 15:06:24'),
(15, 'kori', '082113679872', 'Jalan Komplek dep', 'kori@gmail.com', '$2y$10$UyPQDai/mc89YRCyuqpZVOpieYDB/cYf/qZEyrKDEblloCoDTIEXe', '2025-11-19 14:32:26', '2025-11-19 21:32:26'),
(16, 'mon', '082113674721', 'Jalan BSD Raya No 2', 'mon@gmail.com', '$2y$10$NQ3m3.FFfwXSgmmGdnJjOuxItfmG9QcaA/C5oW3YLPC1DZhYbvwQu', '2025-11-19 17:48:21', '2025-11-20 00:48:21'),
(17, 'kika', '082113670104', 'Jalan Cengkareng', 'kika@gmail.com', '$2y$10$m.GKHTH8e/mt.9Z6hqh7/Ox/R42COPavgYCqvN1AMV1AFSV2cXvrK', '2025-11-19 20:55:07', '2025-11-20 03:55:07'),
(18, 'dimas', '08211367321', 'Jalan Joglo No D2', 'dimass@gmail.com', '$2y$10$zv06G5YO.Dp62uoX7lzf9OOxWDy.NTGuwVJbGhUNGWoodhnztQXve', '2025-11-20 08:01:46', '2025-11-20 15:01:46'),
(19, 'rosalia', '08211367999', 'Jalan Meruya Ilir', 'rosa@gmail.com', '$2y$10$vYOWU0WuIUbBIYhieDzr/uTs4ZTDNRdQssrdbwN3PGBqSGqxpfdSS', '2025-11-20 08:15:27', '2025-11-20 15:15:27'),
(20, 'viona', '08211367844', 'Jalan Bandung Raya No,123', 'vio@gmail.com', '$2y$10$dBH6MXBA4O1NK1i18nquOONtIq0yCdgGnhT5OfU2U9HTYqWEyV7ae', '2025-12-07 12:28:27', '2025-12-07 19:28:27'),
(21, 'ahmed', '082113671134', 'Jalan Graha raya No. 92', 'ahmed@gmail.com', '$2y$10$m/bjNau1mtHsD2CKuthbjemDH2Ome2WUV3JvrilR6FDlmLSqbijbS', '2025-12-07 22:50:20', '2025-12-08 05:50:20'),
(22, 'kilu', '08211367895', 'Jalan baru 1234', 'kilu@gmail.com', '$2y$10$Sx27eSdpq5qay1MfiQwT9.m3HvQlhf6vG9mUNy70IIEbGiWGQH482', '2025-12-09 03:29:08', '2025-12-09 10:29:08'),
(23, 'julio', '08211367874', 'Jalan Baru tes', 'julio@gmail.com', '$2y$10$uX9VGeZyxWBCyBOgfXKUieDxXrTDFbU.HxddS990PIVfvLV/anSEK', '2025-12-09 04:55:58', '2025-12-09 11:55:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(12,0) NOT NULL,
  `ongkir` decimal(10,0) DEFAULT 0,
  `total_harga` decimal(12,0) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_pesanan_id` int(11) NOT NULL,
  `metode_pembayaran_id` int(11) NOT NULL,
  `bukti_pembayaran_id` int(11) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `jarak_km` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `pelanggan_id`, `admin_id`, `tanggal_pesanan`, `subtotal`, `ongkir`, `total_harga`, `alamat_pengiriman`, `catatan`, `created_at`, `updated_at`, `status_pesanan_id`, `metode_pembayaran_id`, `bukti_pembayaran_id`, `latitude`, `longitude`, `jarak_km`) VALUES
(6, 3, NULL, '2025-11-13 01:49:56', 25000, 5000, 30000, 'jalan joglo raya2', '', '2025-11-12 11:49:56', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(7, 4, NULL, '2025-11-13 01:52:40', 90000, 5000, 95000, 'Jalan Haji Saaba', '', '2025-11-12 11:52:40', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(8, 5, NULL, '2025-11-13 09:50:29', 78000, 5000, 83000, 'Jalan jalan di pasar', 'hati hati dijalan', '2025-11-12 19:50:29', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(9, 6, NULL, '2025-11-13 10:06:38', 209000, 5000, 214000, 'jalan test', 'test', '2025-11-12 20:06:38', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(10, 7, NULL, '2025-11-13 14:41:52', 20000, 5000, 25000, 'jalan test000', '', '2025-11-13 00:41:52', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(11, 11, NULL, '2025-11-17 20:59:55', 75000, 5000, 80000, 'jalan joglo', '', '2025-11-17 06:59:55', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(12, 11, NULL, '2025-11-17 21:11:56', 50000, 5000, 55000, 'jalan joglo', '', '2025-11-17 07:11:56', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(13, 12, NULL, '2025-11-17 21:57:42', 50000, 5000, 55000, 'jalan jogglo 1', '', '2025-11-17 07:57:42', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(14, 13, NULL, '2025-11-18 11:30:54', 126000, 5000, 131000, 'jalan user kembangan', '', '2025-11-17 21:30:54', '2025-11-19 13:11:09', 4, 1, NULL, NULL, NULL, NULL),
(15, 14, NULL, '2025-11-19 22:09:11', 25000, 5000, 30000, 'jalan bandung', '', '2025-11-19 08:09:11', '2025-11-19 13:10:57', 4, 1, NULL, NULL, NULL, NULL),
(16, 14, NULL, '2025-11-19 22:52:20', 40000, 5000, 45000, 'jalan bandung', '', '2025-11-19 08:52:20', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(17, 14, NULL, '2025-11-19 23:03:56', 40000, 5000, 45000, 'jalan bandung', 'tes123', '2025-11-19 09:03:56', '2025-11-19 17:25:12', 1, 1, NULL, NULL, NULL, NULL),
(18, 15, NULL, '2025-11-20 06:03:27', 140000, 12000, 152000, 'Jalan Komplek dep', NULL, '2025-11-19 16:03:27', '2025-11-19 16:03:27', 1, 1, NULL, -6.3045632, 106.6500096, 13),
(19, 15, NULL, '2025-11-20 06:06:38', 25000, 12000, 37000, 'Jalan Komplek dep', NULL, '2025-11-19 16:06:38', '2025-11-19 16:06:38', 1, 1, NULL, -6.3045632, 106.6500096, 13),
(20, 15, NULL, '2025-11-20 06:17:26', 25000, 12000, 37000, 'Jalan Komplek dep', NULL, '2025-11-19 16:17:26', '2025-11-19 20:33:42', 3, 1, 5, -6.3045632, 106.6500096, 13),
(21, 15, NULL, '2025-11-20 07:10:27', 20000, 0, 20000, 'Jalan Komplek dep', NULL, '2025-11-19 17:10:27', '2025-11-19 20:33:16', 3, 1, 6, -6.2203105, 106.7201657, 1),
(22, 16, NULL, '2025-11-20 07:50:05', 54000, 12000, 66000, 'Jalan BSD Raya No 2', NULL, '2025-11-19 17:50:05', '2025-11-19 17:51:32', 3, 1, 8, -6.3045632, 106.6500096, 13),
(23, 17, NULL, '2025-11-20 11:01:39', 84000, 12000, 96000, 'Jalan Cengkareng', NULL, '2025-11-19 21:01:39', '2025-11-19 21:01:39', 1, 1, 9, -6.22592, 106.8302336, 13),
(24, 18, NULL, '2025-11-20 22:05:33', 40000, 12000, 52000, 'Jalan Joglo No D2', NULL, '2025-11-20 08:05:33', '2025-11-20 08:11:47', 3, 1, 10, -6.3045632, 106.6500096, 13),
(25, 19, NULL, '2025-11-20 22:17:49', 75000, 12000, 87000, 'Jalan Meruya Ilir', NULL, '2025-11-20 08:17:49', '2025-11-20 08:22:36', 3, 1, 11, -6.3045632, 106.6500096, 13),
(26, 20, NULL, '2025-12-08 02:29:35', 54000, 0, 54000, 'Jalan Bandung Raya No,123', NULL, '2025-12-07 12:29:35', '2025-12-07 12:41:48', 3, 1, 13, -6.2203281, 106.7201658, 1),
(27, 14, NULL, '2025-11-01 09:15:20', 25000, 5000, 30000, 'Jl Mawar No 10', NULL, '2025-11-01 02:15:20', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 5),
(28, 15, NULL, '2025-11-03 14:22:10', 50000, 8000, 58000, 'Jl Melati No 5', 'Pedas', '2025-11-03 07:22:10', '2025-12-08 05:46:22', 3, 1, NULL, -6.31, 106.66, 7),
(29, 16, NULL, '2025-11-05 18:45:55', 75000, 12000, 87000, 'Jl Anggrek No 2', NULL, '2025-11-05 11:45:55', '2025-11-05 11:45:55', 3, 1, NULL, -6.33, 106.67, 9),
(30, 17, NULL, '2025-11-07 11:05:40', 30000, 6000, 36000, 'Jl Teratai No 7', '', '2025-11-07 04:05:40', '2025-12-08 05:46:22', 3, 1, NULL, -6.29, 106.64, 4),
(31, 18, NULL, '2025-11-10 20:10:00', 90000, 15000, 105000, 'Jl Pelita No 11', 'Tanpa sambal', '2025-11-10 13:10:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.32, 106.63, 10),
(32, 19, NULL, '2025-11-12 08:25:19', 27000, 5000, 32000, 'Jl Cendana No 4', NULL, '2025-11-12 01:25:19', '2025-11-12 01:25:19', 3, 1, NULL, -6.28, 106.62, 3),
(33, 14, NULL, '2025-11-15 17:50:05', 25000, 12000, 37000, 'Jl Kaliurang No 18', NULL, '2025-11-15 10:50:05', '2025-12-08 05:46:22', 3, 1, NULL, -6.305, 106.65, 13),
(34, 16, NULL, '2025-11-18 13:14:44', 150000, 10000, 160000, 'Jl Cipto No 12', '', '2025-11-18 06:14:44', '2025-11-18 06:14:44', 3, 1, NULL, -6.31, 106.645, 6),
(35, 15, NULL, '2025-11-22 10:34:21', 45000, 7000, 52000, 'Jl Harapan No 19', 'Level 2', '2025-11-22 03:34:21', '2025-12-08 05:46:22', 3, 1, NULL, -6.315, 106.655, 8),
(36, 17, NULL, '2025-11-27 19:40:33', 85000, 9000, 94000, 'Jl Budi No 3', NULL, '2025-11-27 12:40:33', '2025-12-08 05:46:22', 3, 1, NULL, -6.298, 106.661, 12),
(37, 18, NULL, '2025-11-30 12:59:11', 67000, 8000, 75000, 'Jl Merdeka No 20', NULL, '2025-11-30 05:59:11', '2025-11-30 05:59:11', 3, 1, NULL, -6.291, 106.658, 11),
(38, 14, NULL, '2025-11-01 10:15:00', 45000, 5000, 50000, 'Alamat Hari 1', NULL, '2025-11-01 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 5),
(39, 15, NULL, '2025-11-02 11:20:00', 60000, 7000, 67000, 'Alamat Hari 2', NULL, '2025-11-02 04:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.31, 106.64, 7),
(40, 16, NULL, '2025-11-03 09:55:00', 30000, 5000, 35000, 'Alamat Hari 3', NULL, '2025-11-03 02:55:00', '2025-11-03 02:55:00', 3, 1, NULL, -6.29, 106.63, 4),
(41, 17, NULL, '2025-11-04 14:10:00', 80000, 9000, 89000, 'Alamat Hari 4', NULL, '2025-11-04 07:10:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.62, 9),
(42, 18, NULL, '2025-11-05 12:30:00', 65000, 7000, 72000, 'Alamat Hari 5', NULL, '2025-11-05 05:30:00', '2025-11-05 05:30:00', 3, 1, NULL, -6.33, 106.61, 7),
(43, 19, NULL, '2025-11-06 16:45:00', 40000, 6000, 46000, 'Alamat Hari 6', NULL, '2025-11-06 09:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.66, 6),
(44, 20, NULL, '2025-11-07 10:05:00', 70000, 8000, 78000, 'Alamat Hari 7', NULL, '2025-11-07 03:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 8),
(45, 14, NULL, '2025-11-08 11:50:00', 50000, 6000, 56000, 'Alamat Hari 8', NULL, '2025-11-08 04:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.28, 106.67, 6),
(46, 15, NULL, '2025-11-09 13:25:00', 85000, 9000, 94000, 'Alamat Hari 9', NULL, '2025-11-09 06:25:00', '2025-11-09 06:25:00', 3, 2, NULL, -6.34, 106.62, 9),
(47, 16, NULL, '2025-11-10 17:40:00', 30000, 5000, 35000, 'Alamat Hari 10', NULL, '2025-11-10 10:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.31, 106.63, 4),
(48, 17, NULL, '2025-11-11 09:20:00', 55000, 6000, 61000, 'Alamat Hari 11', NULL, '2025-11-11 02:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.6, 6),
(49, 18, NULL, '2025-11-12 12:10:00', 90000, 10000, 100000, 'Alamat Hari 12', NULL, '2025-11-12 05:10:00', '2025-11-12 05:10:00', 3, 1, NULL, -6.32, 106.64, 10),
(50, 19, NULL, '2025-11-13 15:00:00', 60000, 7000, 67000, 'Alamat Hari 13', NULL, '2025-11-13 08:00:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.63, 7),
(51, 20, NULL, '2025-11-14 18:25:00', 75000, 8000, 83000, 'Alamat Hari 14', NULL, '2025-11-14 11:25:00', '2025-11-14 11:25:00', 3, 1, NULL, -6.31, 106.61, 8),
(52, 14, NULL, '2025-11-15 11:45:00', 40000, 5000, 45000, 'Alamat Hari 15', NULL, '2025-11-15 04:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.29, 106.62, 5),
(53, 15, NULL, '2025-11-16 14:55:00', 85000, 9000, 94000, 'Alamat Hari 16', NULL, '2025-11-16 07:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.66, 9),
(54, 16, NULL, '2025-11-17 09:10:00', 70000, 8000, 78000, 'Alamat Hari 17', NULL, '2025-11-17 02:10:00', '2025-11-17 02:10:00', 3, 1, NULL, -6.28, 106.67, 8),
(55, 17, NULL, '2025-11-18 13:15:00', 90000, 11000, 101000, 'Alamat Hari 18', NULL, '2025-11-18 06:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.32, 106.61, 11),
(56, 18, NULL, '2025-11-19 16:40:00', 60000, 7000, 67000, 'Alamat Hari 19', NULL, '2025-11-19 09:40:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.6, 7),
(57, 19, NULL, '2025-11-20 10:00:00', 70000, 9000, 79000, 'Alamat Hari 20', NULL, '2025-11-20 03:00:00', '2025-11-20 03:00:00', 3, 2, NULL, -6.31, 106.63, 9),
(58, 20, NULL, '2025-11-21 12:40:00', 30000, 5000, 35000, 'Alamat Hari 21', NULL, '2025-11-21 05:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 4),
(59, 14, NULL, '2025-11-22 14:30:00', 95000, 11000, 106000, 'Alamat Hari 22', NULL, '2025-11-22 07:30:00', '2025-11-22 07:30:00', 3, 1, NULL, -6.28, 106.66, 11),
(60, 15, NULL, '2025-11-23 17:55:00', 80000, 9000, 89000, 'Alamat Hari 23', NULL, '2025-11-23 10:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 9),
(61, 16, NULL, '2025-11-24 09:05:00', 40000, 5000, 45000, 'Alamat Hari 24', NULL, '2025-11-24 02:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.64, 5),
(62, 17, NULL, '2025-11-25 13:50:00', 85000, 10000, 95000, 'Alamat Hari 25', NULL, '2025-11-25 06:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.33, 106.63, 10),
(63, 18, NULL, '2025-11-26 16:30:00', 60000, 7000, 67000, 'Alamat Hari 26', NULL, '2025-11-26 09:30:00', '2025-11-26 09:30:00', 3, 2, NULL, -6.31, 106.62, 7),
(64, 19, NULL, '2025-11-27 10:15:00', 90000, 11000, 101000, 'Alamat Hari 27', NULL, '2025-11-27 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.6, 11),
(65, 20, NULL, '2025-11-28 12:25:00', 50000, 6000, 56000, 'Alamat Hari 28', NULL, '2025-11-28 05:25:00', '2025-11-28 05:25:00', 3, 2, NULL, -6.29, 106.61, 6),
(66, 14, NULL, '2025-11-29 15:55:00', 75000, 9000, 84000, 'Alamat Hari 29', NULL, '2025-11-29 08:55:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.34, 106.62, 9),
(67, 15, NULL, '2025-11-30 11:10:00', 65000, 7000, 72000, 'Alamat Hari 30', NULL, '2025-11-30 04:10:00', '2025-11-30 04:10:00', 3, 2, NULL, -6.33, 106.64, 7),
(68, 14, NULL, '2025-10-01 10:15:00', 45000, 5000, 50000, 'Alamat Hari 1', NULL, '2025-10-01 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 5),
(69, 15, NULL, '2025-10-02 11:20:00', 60000, 7000, 67000, 'Alamat Hari 2', NULL, '2025-10-02 04:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.31, 106.64, 7),
(70, 16, NULL, '2025-10-03 09:55:00', 30000, 5000, 35000, 'Alamat Hari 3', NULL, '2025-10-03 02:55:00', '2025-10-03 02:55:00', 3, 1, NULL, -6.29, 106.63, 4),
(71, 17, NULL, '2025-10-04 14:10:00', 80000, 9000, 89000, 'Alamat Hari 4', NULL, '2025-10-04 07:10:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.62, 9),
(72, 18, NULL, '2025-10-05 12:30:00', 65000, 7000, 72000, 'Alamat Hari 5', NULL, '2025-10-05 05:30:00', '2025-10-05 05:30:00', 3, 1, NULL, -6.33, 106.61, 7),
(73, 19, NULL, '2025-10-06 16:45:00', 40000, 6000, 46000, 'Alamat Hari 6', NULL, '2025-10-06 09:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.66, 6),
(74, 20, NULL, '2025-10-07 10:05:00', 70000, 8000, 78000, 'Alamat Hari 7', NULL, '2025-10-07 03:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 8),
(75, 14, NULL, '2025-10-08 11:50:00', 50000, 6000, 56000, 'Alamat Hari 8', NULL, '2025-10-08 04:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.28, 106.67, 6),
(76, 15, NULL, '2025-10-09 13:25:00', 85000, 9000, 94000, 'Alamat Hari 9', NULL, '2025-10-09 06:25:00', '2025-10-09 06:25:00', 3, 2, NULL, -6.34, 106.62, 9),
(77, 16, NULL, '2025-10-10 17:40:00', 30000, 5000, 35000, 'Alamat Hari 10', NULL, '2025-10-10 10:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.31, 106.63, 4),
(78, 17, NULL, '2025-10-11 09:20:00', 55000, 6000, 61000, 'Alamat Hari 11', NULL, '2025-10-11 02:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.6, 6),
(79, 18, NULL, '2025-10-12 12:10:00', 90000, 10000, 100000, 'Alamat Hari 12', NULL, '2025-10-12 05:10:00', '2025-10-12 05:10:00', 3, 1, NULL, -6.32, 106.64, 10),
(80, 19, NULL, '2025-10-13 15:00:00', 60000, 7000, 67000, 'Alamat Hari 13', NULL, '2025-10-13 08:00:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.63, 7),
(81, 20, NULL, '2025-10-14 18:25:00', 75000, 8000, 83000, 'Alamat Hari 14', NULL, '2025-10-14 11:25:00', '2025-10-14 11:25:00', 3, 1, NULL, -6.31, 106.61, 8),
(82, 14, NULL, '2025-10-15 11:45:00', 40000, 5000, 45000, 'Alamat Hari 15', NULL, '2025-10-15 04:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.29, 106.62, 5),
(83, 15, NULL, '2025-10-16 14:55:00', 85000, 9000, 94000, 'Alamat Hari 16', NULL, '2025-10-16 07:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.66, 9),
(84, 16, NULL, '2025-10-17 09:10:00', 70000, 8000, 78000, 'Alamat Hari 17', NULL, '2025-10-17 02:10:00', '2025-10-17 02:10:00', 3, 1, NULL, -6.28, 106.67, 8),
(85, 17, NULL, '2025-10-18 13:15:00', 90000, 11000, 101000, 'Alamat Hari 18', NULL, '2025-10-18 06:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.32, 106.61, 11),
(86, 18, NULL, '2025-10-19 16:40:00', 60000, 7000, 67000, 'Alamat Hari 19', NULL, '2025-10-19 09:40:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.6, 7),
(87, 19, NULL, '2025-10-20 10:00:00', 70000, 9000, 79000, 'Alamat Hari 20', NULL, '2025-10-20 03:00:00', '2025-10-20 03:00:00', 3, 2, NULL, -6.31, 106.63, 9),
(88, 20, NULL, '2025-10-21 12:40:00', 30000, 5000, 35000, 'Alamat Hari 21', NULL, '2025-10-21 05:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 4),
(89, 14, NULL, '2025-10-22 14:30:00', 95000, 11000, 106000, 'Alamat Hari 22', NULL, '2025-10-22 07:30:00', '2025-10-22 07:30:00', 3, 1, NULL, -6.28, 106.66, 11),
(90, 15, NULL, '2025-10-23 17:55:00', 80000, 9000, 89000, 'Alamat Hari 23', NULL, '2025-10-23 10:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 9),
(91, 16, NULL, '2025-10-24 09:05:00', 40000, 5000, 45000, 'Alamat Hari 24', NULL, '2025-10-24 02:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.64, 5),
(92, 17, NULL, '2025-10-25 13:50:00', 85000, 10000, 95000, 'Alamat Hari 25', NULL, '2025-10-25 06:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.33, 106.63, 10),
(93, 18, NULL, '2025-10-26 16:30:00', 60000, 7000, 67000, 'Alamat Hari 26', NULL, '2025-10-26 09:30:00', '2025-10-26 09:30:00', 3, 2, NULL, -6.31, 106.62, 7),
(94, 19, NULL, '2025-10-27 10:15:00', 90000, 11000, 101000, 'Alamat Hari 27', NULL, '2025-10-27 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.6, 11),
(95, 20, NULL, '2025-10-28 12:25:00', 50000, 6000, 56000, 'Alamat Hari 28', NULL, '2025-10-28 05:25:00', '2025-10-28 05:25:00', 3, 2, NULL, -6.29, 106.61, 6),
(96, 14, NULL, '2025-10-29 15:55:00', 75000, 9000, 84000, 'Alamat Hari 29', NULL, '2025-10-29 08:55:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.34, 106.62, 9),
(97, 15, NULL, '2025-10-30 11:10:00', 65000, 7000, 72000, 'Alamat Hari 30', NULL, '2025-10-30 04:10:00', '2025-10-30 04:10:00', 3, 2, NULL, -6.33, 106.64, 7),
(98, 14, NULL, '2025-09-01 10:15:00', 45000, 5000, 50000, 'Alamat Hari 1', NULL, '2025-09-01 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 5),
(99, 15, NULL, '2025-09-02 11:20:00', 60000, 7000, 67000, 'Alamat Hari 2', NULL, '2025-09-02 04:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.31, 106.64, 7),
(100, 16, NULL, '2025-09-03 09:55:00', 30000, 5000, 35000, 'Alamat Hari 3', NULL, '2025-09-03 02:55:00', '2025-09-03 02:55:00', 3, 1, NULL, -6.29, 106.63, 4),
(101, 17, NULL, '2025-09-04 14:10:00', 80000, 9000, 89000, 'Alamat Hari 4', NULL, '2025-09-04 07:10:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.62, 9),
(102, 18, NULL, '2025-09-05 12:30:00', 65000, 7000, 72000, 'Alamat Hari 5', NULL, '2025-09-05 05:30:00', '2025-09-05 05:30:00', 3, 1, NULL, -6.33, 106.61, 7),
(103, 19, NULL, '2025-09-06 16:45:00', 40000, 6000, 46000, 'Alamat Hari 6', NULL, '2025-09-06 09:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.66, 6),
(104, 20, NULL, '2025-09-07 10:05:00', 70000, 8000, 78000, 'Alamat Hari 7', NULL, '2025-09-07 03:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 8),
(105, 14, NULL, '2025-09-08 11:50:00', 50000, 6000, 56000, 'Alamat Hari 8', NULL, '2025-09-08 04:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.28, 106.67, 6),
(106, 15, NULL, '2025-09-09 13:25:00', 85000, 9000, 94000, 'Alamat Hari 9', NULL, '2025-09-09 06:25:00', '2025-09-09 06:25:00', 3, 2, NULL, -6.34, 106.62, 9),
(107, 16, NULL, '2025-09-10 17:40:00', 30000, 5000, 35000, 'Alamat Hari 10', NULL, '2025-09-10 10:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.31, 106.63, 4),
(108, 17, NULL, '2025-09-11 09:20:00', 55000, 6000, 61000, 'Alamat Hari 11', NULL, '2025-09-11 02:20:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.6, 6),
(109, 18, NULL, '2025-09-12 12:10:00', 90000, 10000, 100000, 'Alamat Hari 12', NULL, '2025-09-12 05:10:00', '2025-09-12 05:10:00', 3, 1, NULL, -6.32, 106.64, 10),
(110, 19, NULL, '2025-09-13 15:00:00', 60000, 7000, 67000, 'Alamat Hari 13', NULL, '2025-09-13 08:00:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.63, 7),
(111, 20, NULL, '2025-09-14 18:25:00', 75000, 8000, 83000, 'Alamat Hari 14', NULL, '2025-09-14 11:25:00', '2025-09-14 11:25:00', 3, 1, NULL, -6.31, 106.61, 8),
(112, 14, NULL, '2025-09-15 11:45:00', 40000, 5000, 45000, 'Alamat Hari 15', NULL, '2025-09-15 04:45:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.29, 106.62, 5),
(113, 15, NULL, '2025-09-16 14:55:00', 85000, 9000, 94000, 'Alamat Hari 16', NULL, '2025-09-16 07:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.3, 106.66, 9),
(114, 16, NULL, '2025-09-17 09:10:00', 70000, 8000, 78000, 'Alamat Hari 17', NULL, '2025-09-17 02:10:00', '2025-09-17 02:10:00', 3, 1, NULL, -6.28, 106.67, 8),
(115, 17, NULL, '2025-09-18 13:15:00', 90000, 11000, 101000, 'Alamat Hari 18', NULL, '2025-09-18 06:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.32, 106.61, 11),
(116, 18, NULL, '2025-09-19 16:40:00', 60000, 7000, 67000, 'Alamat Hari 19', NULL, '2025-09-19 09:40:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.33, 106.6, 7),
(117, 19, NULL, '2025-09-20 10:00:00', 70000, 9000, 79000, 'Alamat Hari 20', NULL, '2025-09-20 03:00:00', '2025-09-20 03:00:00', 3, 2, NULL, -6.31, 106.63, 9),
(118, 20, NULL, '2025-09-21 12:40:00', 30000, 5000, 35000, 'Alamat Hari 21', NULL, '2025-09-21 05:40:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.65, 4),
(119, 14, NULL, '2025-09-22 14:30:00', 95000, 11000, 106000, 'Alamat Hari 22', NULL, '2025-09-22 07:30:00', '2025-09-22 07:30:00', 3, 1, NULL, -6.28, 106.66, 11),
(120, 15, NULL, '2025-09-23 17:55:00', 80000, 9000, 89000, 'Alamat Hari 23', NULL, '2025-09-23 10:55:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.29, 106.65, 9),
(121, 16, NULL, '2025-09-24 09:05:00', 40000, 5000, 45000, 'Alamat Hari 24', NULL, '2025-09-24 02:05:00', '2025-12-08 05:46:22', 3, 2, NULL, -6.32, 106.64, 5),
(122, 17, NULL, '2025-09-25 13:50:00', 85000, 10000, 95000, 'Alamat Hari 25', NULL, '2025-09-25 06:50:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.33, 106.63, 10),
(123, 18, NULL, '2025-09-26 16:30:00', 60000, 7000, 67000, 'Alamat Hari 26', NULL, '2025-09-26 09:30:00', '2025-09-26 09:30:00', 3, 2, NULL, -6.31, 106.62, 7),
(124, 19, NULL, '2025-09-27 10:15:00', 90000, 11000, 101000, 'Alamat Hari 27', NULL, '2025-09-27 03:15:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.3, 106.6, 11),
(125, 20, NULL, '2025-09-28 12:25:00', 50000, 6000, 56000, 'Alamat Hari 28', NULL, '2025-09-28 05:25:00', '2025-09-28 05:25:00', 3, 2, NULL, -6.29, 106.61, 6),
(126, 14, NULL, '2025-09-29 15:55:00', 75000, 9000, 84000, 'Alamat Hari 29', NULL, '2025-09-29 08:55:00', '2025-12-08 05:46:22', 3, 1, NULL, -6.34, 106.62, 9),
(127, 15, NULL, '2025-09-30 11:10:00', 65000, 7000, 72000, 'Alamat Hari 30', NULL, '2025-09-30 04:10:00', '2025-09-30 04:10:00', 3, 2, NULL, -6.33, 106.64, 7),
(128, 21, NULL, '2025-12-08 12:54:05', 187000, 0, 187000, 'Jalan Graha raya No. 92', NULL, '2025-12-07 22:54:05', '2025-12-08 06:10:24', 3, 1, 14, -6.2203258, 106.7201565, 1),
(129, 21, NULL, '2025-12-08 13:06:17', 18000, 0, 18000, 'Jalan Graha raya No. 92', NULL, '2025-12-08 06:06:17', '2025-12-08 09:00:33', 3, 1, 15, -6.2203258, 106.7201565, 1),
(130, 14, NULL, '2025-12-01 10:20:00', 55000, 6000, 61000, 'Alamat Hari 1 Desember', NULL, '2025-12-01 03:20:00', '2025-12-01 03:20:00', 3, 1, NULL, -6.3, 106.65, 6),
(131, 15, NULL, '2025-12-02 12:10:00', 75000, 7000, 82000, 'Alamat Hari 2 Desember', NULL, '2025-12-02 05:10:00', '2025-12-02 05:10:00', 3, 2, NULL, -6.31, 106.64, 7),
(132, 16, NULL, '2025-12-03 09:35:00', 45000, 5000, 50000, 'Alamat Hari 3 Desember', NULL, '2025-12-03 02:35:00', '2025-12-03 02:35:00', 3, 1, NULL, -6.29, 106.63, 4),
(133, 17, NULL, '2025-12-04 14:20:00', 90000, 9000, 99000, 'Alamat Hari 4 Desember', NULL, '2025-12-04 07:20:00', '2025-12-04 07:20:00', 3, 2, NULL, -6.32, 106.62, 9),
(134, 18, NULL, '2025-12-05 11:55:00', 68000, 7000, 75000, 'Alamat Hari 5 Desember', NULL, '2025-12-05 04:55:00', '2025-12-05 04:55:00', 3, 1, NULL, -6.33, 106.61, 7),
(135, 19, NULL, '2025-12-06 16:40:00', 52000, 6000, 58000, 'Alamat Hari 6 Desember', NULL, '2025-12-06 09:40:00', '2025-12-06 09:40:00', 3, 1, NULL, -6.3, 106.66, 6),
(136, 20, NULL, '2025-12-07 13:10:00', 80000, 9000, 89000, 'Alamat Hari 7 Desember', NULL, '2025-12-07 06:10:00', '2025-12-07 06:10:00', 3, 2, NULL, -6.29, 106.65, 9),
(137, 17, NULL, '2025-12-08 16:01:45', 162000, 0, 162000, 'Jalan Cengkareng', NULL, '2025-12-08 09:01:45', '2025-12-08 09:03:47', 3, 1, 16, -6.2203238, 106.7201563, 1),
(138, 21, NULL, '2025-12-08 16:06:37', 30000, 0, 30000, 'Jalan Graha raya No. 92', NULL, '2025-12-08 09:06:37', '2025-12-08 13:07:38', 3, 1, 17, -6.220317, 106.7201556, 1),
(139, 20, NULL, '2025-12-08 16:07:08', 45000, 0, 45000, 'Jalan Bandung Raya No,123', NULL, '2025-12-08 09:07:08', '2025-12-08 13:07:45', 3, 1, 18, -6.220326, 106.7201571, 1),
(140, 19, NULL, '2025-12-08 16:08:08', 22000, 0, 22000, 'Jalan Meruya Ilir', NULL, '2025-12-08 09:08:08', '2025-12-09 03:32:23', 3, 1, 19, -6.2203234, 106.7201579, 1),
(141, 18, NULL, '2025-12-08 16:09:16', 72000, 0, 72000, 'Jalan Joglo No D2', NULL, '2025-12-08 09:09:16', '2025-12-09 03:32:43', 3, 1, 20, -6.2203234, 106.7201579, 1),
(142, 22, NULL, '2025-12-09 10:31:24', 23000, 9000, 32000, 'Jalan baru 1234', NULL, '2025-12-09 03:31:24', '2025-12-20 15:02:01', 3, 1, 21, -6.1675795, 106.7824544, 10),
(143, 23, NULL, '2025-12-09 11:59:12', 56000, 9000, 65000, 'Jalan Baru tes', NULL, '2025-12-09 04:59:12', '2025-12-20 15:01:58', 3, 1, 22, -6.1735288, 106.7927773, 10),
(144, 4, NULL, '2025-12-20 22:01:17', 34000, 0, 34000, 'Jalan Haji Saaba', NULL, '2025-12-20 15:01:17', '2025-12-20 15:01:49', 3, 1, 23, -6.2203259, 106.7201611, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_pesanan`
--

CREATE TABLE `status_pesanan` (
  `id` int(11) NOT NULL,
  `nama_status` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status_pesanan`
--

INSERT INTO `status_pesanan` (`id`, `nama_status`, `keterangan`) VALUES
(1, 'Diproses', 'Pesanan sedang diproses'),
(2, 'Pengiriman', 'Pesanan dalam perjalanan'),
(3, 'Selesai', 'Pesanan selesai'),
(4, 'Dibatalkan', 'Pesanan dibatalkan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bukti_pesanan` (`pesanan_id`);

--
-- Indeks untuk tabel `detail_menu`
--
ALTER TABLE `detail_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `fk_detail_pesanan_menu` (`menu_id`);

--
-- Indeks untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_kategori` (`kategori_id`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `fk_status_pesanan` (`status_pesanan_id`),
  ADD KEY `fk_metode_pembayaran` (`metode_pembayaran_id`),
  ADD KEY `fk_pesanan_bukti` (`bukti_pembayaran_id`);

--
-- Indeks untuk tabel `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `detail_menu`
--
ALTER TABLE `detail_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT untuk tabel `status_pesanan`
--
ALTER TABLE `status_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD CONSTRAINT `fk_bukti_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_menu`
--
ALTER TABLE `detail_menu`
  ADD CONSTRAINT `detail_menu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_menu` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_metode_pembayaran` FOREIGN KEY (`metode_pembayaran_id`) REFERENCES `metode_pembayaran` (`id`),
  ADD CONSTRAINT `fk_pesanan_bukti` FOREIGN KEY (`bukti_pembayaran_id`) REFERENCES `bukti_pembayaran` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_status_pesanan` FOREIGN KEY (`status_pesanan_id`) REFERENCES `status_pesanan` (`id`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
