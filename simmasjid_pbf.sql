-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 02 Jun 2025 pada 13.50
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simmasjid_pbf`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `acara`
--

CREATE TABLE `acara` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_acara` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` decimal(12,2) NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('tersedia','tidaktersedia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `acara`
--

INSERT INTO `acara` (`id`, `nama_acara`, `deskripsi`, `harga`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pesta Pernikahan', NULL, 30000000.00, 'acara/XVO2XbjGIDc21Fjyx6sJOvU8BptD122ZJhBmt4GP.jpg', 'tersedia', '2025-06-02 12:30:20', '2025-06-02 12:30:20'),
(2, 'Wisuda', NULL, 25000000.00, 'acara/Smugj7zpV9TOeoN4Ffi4yxB1ENZL9yXhgJrU67ZZ.jpg', 'tersedia', '2025-06-02 12:30:49', '2025-06-02 12:30:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Publikasi','Draft') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `konten`, `gambar`, `tanggal`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kucing Mati Suri', 'Lorem ipsum dolor sit amet. Ut eaque doloribus aut cumque pariatur ut exercitationem iusto et Quis obcaecati. Est asperiores Quis nam accusamus tempore a soluta commodi vel reiciendis veniam vel iste corrupti. Aut illo deserunt cum omnis accusantium cum eius autem hic ratione provident aut architecto totam eos fuga facilis aut rerum quia.\r\n\r\nSed consequatur explicabo ut totam eveniet sed suscipit iusto et perspiciatis internos ex inventore quaerat aut magni adipisci est fugit enim. Et asperiores quasi ut nihil placeat rem voluptatem dolores qui provident perferendis ut fuga recusandae.\r\n\r\nEst libero omnis qui incidunt obcaecati ut enim voluptas est excepturi commodi. Est perspiciatis incidunt rem vero magni non voluptas temporibus est omnis sunt?', 'images/KTVI7JOAPB8iyNExeqFI4grxG9gAmTit4t2t1vju.jpg', '2025-06-06', 'Publikasi', '2025-06-02 12:47:08', '2025-06-02 12:47:08'),
(2, 'Kucing Bingung', 'Lorem ipsum dolor sit amet. Ut eaque doloribus aut cumque pariatur ut exercitationem iusto et Quis obcaecati. Est asperiores Quis nam accusamus tempore a soluta commodi vel reiciendis veniam vel iste corrupti. Aut illo deserunt cum omnis accusantium cum eius autem hic ratione provident aut architecto totam eos fuga facilis aut rerum quia.\r\n\r\nSed consequatur explicabo ut totam eveniet sed suscipit iusto et perspiciatis internos ex inventore quaerat aut magni adipisci est fugit enim. Et asperiores quasi ut nihil placeat rem voluptatem dolores qui provident perferendis ut fuga recusandae.\r\n\r\nEst libero omnis qui incidunt obcaecati ut enim voluptas est excepturi commodi. Est perspiciatis incidunt rem vero magni non voluptas temporibus est omnis sunt?', 'images/QBvz9R7yIKBC8nogNMQwm0bN86Z5q7SbHSCXyZz8.jpg', '2025-06-12', 'Publikasi', '2025-06-02 12:47:41', '2025-06-02 12:47:41'),
(3, 'Kucing Mabok', 'Lorem ipsum dolor sit amet. Ut eaque doloribus aut cumque pariatur ut exercitationem iusto et Quis obcaecati. Est asperiores Quis nam accusamus tempore a soluta commodi vel reiciendis veniam vel iste corrupti. Aut illo deserunt cum omnis accusantium cum eius autem hic ratione provident aut architecto totam eos fuga facilis aut rerum quia.\r\n\r\nSed consequatur explicabo ut totam eveniet sed suscipit iusto et perspiciatis internos ex inventore quaerat aut magni adipisci est fugit enim. Et asperiores quasi ut nihil placeat rem voluptatem dolores qui provident perferendis ut fuga recusandae.\r\n\r\nEst libero omnis qui incidunt obcaecati ut enim voluptas est excepturi commodi. Est perspiciatis incidunt rem vero magni non voluptas temporibus est omnis sunt?', 'images/pyl4neidp0q5iEej5F3OwcyNp6dSiVLwIpK9SSZw.jpg', '2025-06-26', 'Publikasi', '2025-06-02 12:48:05', '2025-06-02 12:48:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_fasilitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('tersedia','tidaktersedia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `keterangan`, `harga`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gedung A', NULL, 2500000.00, 'fasilitas/tEQ5ecr24sITKfOjghCBw6zczsTDyVIU0SVGdyNc.jpg', 'tersedia', '2025-06-02 12:31:14', '2025-06-02 12:31:14'),
(2, 'Gedung B', NULL, 1000000.00, 'fasilitas/OxSAbqRAiVoZbiXXF5lBvk17e3dvrpZmBsK6zzJj.jpg', 'tersedia', '2025-06-02 12:31:34', '2025-06-02 12:31:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Publikasi','Draft') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `nama_kegiatan`, `tanggal`, `waktu`, `tempat`, `penanggung_jawab`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lomba Tartil', '2025-06-04', '07:43:00', 'Halaman Masjid', 'sukardi', '-', 'Publikasi', '2025-06-02 12:43:30', '2025-06-02 12:43:30'),
(2, 'Makan Besar', '2025-06-14', '08:04:00', 'Halaman Masjid', 'Pak Yakult', '-', 'Publikasi', '2025-06-02 12:44:10', '2025-06-02 12:44:10'),
(4, 'Masak Masak', '2025-06-16', '06:29:00', 'Halaman Masjid', 'Mei Mei dan Mail', '-', 'Publikasi', '2025-06-02 12:44:57', '2025-06-02 12:44:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuangan`
--

CREATE TABLE `keuangan` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('infaq','sedekah','donasi','zakat','wakaf','dana kegiatan','reservasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `total_masuk` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_keluar` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dompet` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `keuangan`
--

INSERT INTO `keuangan` (`id`, `tanggal`, `jenis`, `deskripsi`, `total_masuk`, `total_keluar`, `dompet`, `created_at`, `updated_at`) VALUES
(1, '2025-06-11', 'reservasi', NULL, 32500000.00, 0.00, 32500000.00, '2025-06-02 12:42:43', '2025-06-02 12:42:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_11_041802_create_personal_access_tokens_table', 1),
(5, '2025_03_11_055411_buat_berita', 1),
(6, '2025_03_12_072946_jadwal_kegiatan', 1),
(7, '2025_03_18_150410_fasilitas', 1),
(8, '2025_03_18_151744_buat_keuangan', 1),
(9, '2025_03_18_165443_buat_acaraa', 1),
(10, '2025_03_20_024445_buat_sesi', 1),
(11, '2025_04_17_110839_buat_reservasi', 1),
(12, '2025_05_19_025319_create_reservasi_fasilitas_sesi_table', 1),
(13, '2025_05_19_025739_buat_pembayaran', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `reservasi_fasilitas_id` bigint UNSIGNED NOT NULL,
  `jenis` enum('dp','pelunasan','lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pembayaran` enum('transfer','tunai','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','belum lunas','paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `reservasi_fasilitas_id`, `jenis`, `metode_pembayaran`, `jumlah_pembayaran`, `bukti_transfer`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'lunas', 'transfer', 32500000.00, 'bukti_transfer/8amGh6ijo0WA7OlsejQ7TIGOagRKrbtBacQrkn2S.png', 'paid', '2025-06-02 12:40:23', '2025-06-02 12:40:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '43df1280946198918b51371eb7e01a900f31db08389a4869fda9bdbed90eabf6', '[\"*\"]', NULL, NULL, '2025-06-02 12:28:46', '2025-06-02 12:28:46'),
(2, 'App\\Models\\User', 2, 'auth_token', 'a6f80b9ea773580caf2d4d905e795c18fc9820e5e247cce497711961e3c7f864', '[\"*\"]', NULL, NULL, '2025-06-02 12:29:09', '2025-06-02 12:29:09'),
(4, 'App\\Models\\User', 2, 'auth_token', '2579b084020225292105c66a5f429c6c54569a928a9073356eea0a9541d6f892', '[\"*\"]', '2025-06-02 12:34:07', NULL, '2025-06-02 12:33:59', '2025-06-02 12:34:07'),
(11, 'App\\Models\\User', 1, 'auth_token', '942c643ae4370897b96af74a6ab0e647fd35bd5c4dbc39b86c37babd8c3f230f', '[\"*\"]', '2025-06-02 12:49:34', NULL, '2025-06-02 12:49:30', '2025-06-02 12:49:34'),
(12, 'App\\Models\\User', 2, 'auth_token', '96140e603c0e5a33329f5b116293838df2b72138a1678139c0909b21f9379f1c', '[\"*\"]', '2025-06-02 12:49:44', NULL, '2025-06-02 12:49:39', '2025-06-02 12:49:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi_fasilitas`
--

CREATE TABLE `reservasi_fasilitas` (
  `id` bigint UNSIGNED NOT NULL,
  `acara_id` bigint UNSIGNED NOT NULL,
  `fasilitas_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tgl_reservasi` date NOT NULL,
  `status_reservasi` enum('pending','ditolak','disetujui','menunggu lunas','siap digunakan','sedang berlangsung','dibatalkan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `harga` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasi_fasilitas`
--

INSERT INTO `reservasi_fasilitas` (`id`, `acara_id`, `fasilitas_id`, `user_id`, `tgl_reservasi`, `status_reservasi`, `harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2025-06-11', 'disetujui', 32500000.00, '2025-06-02 12:38:24', '2025-06-02 12:39:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi_fasilitas_sesi`
--

CREATE TABLE `reservasi_fasilitas_sesi` (
  `id` bigint UNSIGNED NOT NULL,
  `reservasi_fasilitas_id` bigint UNSIGNED NOT NULL,
  `sesi_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reservasi_fasilitas_sesi`
--

INSERT INTO `reservasi_fasilitas_sesi` (`id`, `reservasi_fasilitas_id`, `sesi_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi`
--

CREATE TABLE `sesi` (
  `id` bigint UNSIGNED NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sesi`
--

INSERT INTO `sesi` (`id`, `jam_mulai`, `jam_selesai`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, '09:00:00', '11:00:00', 'Sesi-1', '2025-06-02 12:32:28', '2025-06-02 12:32:28'),
(2, '12:00:00', '14:00:00', 'Sesi-2', '2025-06-02 12:32:54', '2025-06-02 12:32:54'),
(3, '15:00:00', '17:00:00', 'Sesi-3', '2025-06-02 12:33:30', '2025-06-02 12:33:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('14oq66sS1PKuzULGjZeDpFXXTiT1WpP2xdFmtJuu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzh3a0ZzZzdFdGNoSkR5QTc0ZWxXa2JiWURjRHppTXUwN0xBbGZJeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867398),
('akYzkIwWaw7kXGhMZAafmNmpsFRlrTW5VGrGcC3n', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicklJcHFueUxodXNrZHEwZTRFZmZyR2tGVTloaU9BTUZuQmhSREhvcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748868513),
('bHjtj7fgVYwGxnfiTPPXxWpwe0vwlZNKTftq2kVY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTThZTDI5M01hNzRsZVVZUGF0SWJjbENDaTJYUWltbHdpMllEdUJWSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867991),
('Ckjf3GEYXywojU9ewe4pU7bcKaCVO535yqWAdea2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1JZUnBTNWtNTlRMMHFGUHhkaUFVdFJCR0lKb0YzRHBra3VPQ3B0aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867343),
('F0p93VuQtQEEOJITP3jMI4QzTlTmlqUEGK1Wuq2h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicVVjS0xXRWZITnFZaXp5ZVA5M0RsQ2JRaVJyd2lXM1Q5SjRaZ1BLUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867348),
('h4fn0QvqEQtKW9CqXO76ux6NN9MSmZswu80DjwjD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjNlSjgwZVZXZ3RZNWtVV1J0d2ZtQXE0bGNRUU1ETFpLVHBlWmtyaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867325),
('K97SnXS2Bv3IieE7RriHk408oPgG16gziymsCI3t', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2hYQk9hb2pSSkpTa2w0QUlITExpdUdpbVFJd1B3aHZYU0poTkc4ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867667),
('MTQdOvmq8nMuxe7RwuyVBIhizPXhijthf3PYDEc8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUtoTFV3Tm1Sbm81MXRJTjJhcnViOU1JWlFJMHlUUGlVZGxldlRVMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748868569),
('MWNpbVb0FeOA70n9Rq1CkVacGE7AOQVruOSnvCD0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWpIOHNaZjA1cmpGc0Y4WWc3aTMxd2pXOHhaYnNLOHV3d3VPOGdrRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867946),
('N7nhwOJIPTl5dL2knriNkLeS3lWR6rYkfQ66sr2C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0lXN21pdDJoaFMxaHNNNGJoSXZ4VnJkMFdMcnZ6ZFlKMGlwVXM5cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748868578),
('qJ9jrkmo0alBK8fQUD7z8y1lomBknaCbk9eKqSi2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0NERUpnS2VocFhEeEZ3d1J1N0ZxVnlPZ1pLeGk3c2RVa1VoVlJkRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867639),
('uI9rgi6ZtYWxELcGUoWBJK9VesOS7YALxjnXSVLM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFh3UXk0TUJKSDlKNkgzS3hxUE5VUlpFVkxSS3ZRblRwbk5LZ0VwbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748868046),
('wH383HnKn2ZR3Xj1QugDTTBw8ewlyFYeayR4BNVf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid21Obnc1ZEpXYnhXU2NacEl2cGV6SjFUYnZtY0F6MFFqVDZrUDFKViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748867638);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','jemaah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone`, `address`, `image`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ja\'far Malik Ibrahim', 'admin@gmail.com', NULL, '08237413400', 'DSN. TORJUN TIMUR', NULL, 'admin', '$2y$12$ctuozIofNxNcVPOgC4xogOHpLSl654D2igEZ02jbygKHnxHtz8iRi', NULL, '2025-06-02 12:28:45', '2025-06-02 12:28:45'),
(2, 'Frederick Shin', 'user@gmail.com', NULL, '08237413408665', 'Gunong Sekar', NULL, 'jemaah', '$2y$12$xuxYLzAlkiJFrEQ0mZ10je/uUOowM545WkAh2UN1Z9.CjtfviB8bK', NULL, '2025-06-02 12:29:09', '2025-06-02 12:29:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_reservasi_fasilitas_id_foreign` (`reservasi_fasilitas_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `reservasi_fasilitas`
--
ALTER TABLE `reservasi_fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservasi_fasilitas_acara_id_foreign` (`acara_id`),
  ADD KEY `reservasi_fasilitas_fasilitas_id_foreign` (`fasilitas_id`),
  ADD KEY `reservasi_fasilitas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `reservasi_fasilitas_sesi`
--
ALTER TABLE `reservasi_fasilitas_sesi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservasi_fasilitas_sesi_reservasi_fasilitas_id_sesi_id_unique` (`reservasi_fasilitas_id`,`sesi_id`),
  ADD KEY `reservasi_fasilitas_sesi_sesi_id_foreign` (`sesi_id`);

--
-- Indeks untuk tabel `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `acara`
--
ALTER TABLE `acara`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `reservasi_fasilitas`
--
ALTER TABLE `reservasi_fasilitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `reservasi_fasilitas_sesi`
--
ALTER TABLE `reservasi_fasilitas_sesi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_reservasi_fasilitas_id_foreign` FOREIGN KEY (`reservasi_fasilitas_id`) REFERENCES `reservasi_fasilitas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi_fasilitas`
--
ALTER TABLE `reservasi_fasilitas`
  ADD CONSTRAINT `reservasi_fasilitas_acara_id_foreign` FOREIGN KEY (`acara_id`) REFERENCES `acara` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_fasilitas_fasilitas_id_foreign` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_fasilitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi_fasilitas_sesi`
--
ALTER TABLE `reservasi_fasilitas_sesi`
  ADD CONSTRAINT `reservasi_fasilitas_sesi_reservasi_fasilitas_id_foreign` FOREIGN KEY (`reservasi_fasilitas_id`) REFERENCES `reservasi_fasilitas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_fasilitas_sesi_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `sesi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
