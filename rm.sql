-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Mar 2025 pada 08.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `distributors`
--

CREATE TABLE `distributors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_distributor` varchar(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `distributors`
--

INSERT INTO `distributors` (`id`, `kode_distributor`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'HS001', 'Kimia Farma', '2025-03-05 07:58:32', '2025-03-05 07:58:32'),
(2, 'HS002', 'Bina San Prima', '2025-03-06 17:12:09', '2025-03-06 17:12:09'),
(4, 'HS003', 'Hexapharm Jaya', '2025-03-06 21:00:50', '2025-03-06 21:00:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'dr. Hisyam Rifki', NULL, NULL),
(2, 'dr. Ivan Iqbal Baidowi', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jenis_pasien` enum('BARU','LAMA') NOT NULL,
  `diagnosa` text NOT NULL,
  `dokter` varchar(100) NOT NULL,
  `jenis_pembiayaan` enum('BPJS','UMUM','BKKBN') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan_poli_umum`
--

CREATE TABLE `kunjungan_poli_umum` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jenis_pasien` enum('Baru','Lama') NOT NULL,
  `diagnosis` text NOT NULL,
  `pembiayaan` enum('BPJS','Umum') NOT NULL,
  `dokter_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kunjungan_poli_umum`
--

INSERT INTO `kunjungan_poli_umum` (`id`, `pasien_id`, `tanggal_kunjungan`, `jenis_pasien`, `diagnosis`, `pembiayaan`, `dokter_id`, `created_at`, `updated_at`) VALUES
(3, 1, '2025-03-09', 'Baru', 'Faringitis Akut', 'BPJS', 1, '2025-03-09 00:07:23', '2025-03-09 00:07:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_03_14_create_distributors_table', 1),
(5, '2025_01_15_134211_create_pasien_table', 1),
(6, '2025_01_15_134212_create_kunjungan_table', 1),
(7, '2025_03_05_024254_create_obat_table', 2),
(8, '2025_03_05_024255_create_penjualan_details_table', 2),
(9, '2025_03_05_024255_create_penjualan_table', 2),
(10, '2025_03_06_134537_add_diskon_to_penjualans_table', 3),
(11, '2025_03_09_003929_create_dokter_table', 4),
(12, '2025_03_09_003940_create_kunjungan_poli_umum_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `distributor_id` bigint(20) UNSIGNED NOT NULL,
  `kode_obat` varchar(255) NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah_stok` int(11) NOT NULL,
  `lokasi_stok` varchar(255) NOT NULL,
  `tanggal_faktur` datetime NOT NULL DEFAULT '2025-03-05 02:46:10',
  `tanggal_expired` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `distributor_id`, `kode_obat`, `nama_obat`, `harga`, `jumlah_stok`, `lokasi_stok`, `tanggal_faktur`, `tanggal_expired`, `created_at`, `updated_at`) VALUES
(6, 1, 'OBT-0001', 'Amoxilin', 1000.00, 150, 'Default Lokasi', '2025-03-05 02:46:10', '2025-03-19', '2025-03-05 07:59:11', '2025-03-07 21:20:28'),
(7, 1, 'OBT-0002', 'Paracetamol', 3000.00, 133, 'Default Lokasi', '2025-03-05 02:46:10', '2025-03-29', '2025-03-05 13:29:17', '2025-03-07 21:19:50'),
(8, 2, 'OBT-0003', 'Amoxan 500 mg', 5000.00, 138, 'Default Lokasi', '2025-03-05 02:46:10', '2025-03-31', '2025-03-06 17:13:09', '2025-03-08 01:30:01'),
(9, 4, 'OBT-0004', 'Ketorolac 200 mg', 3000.00, 1024, 'Gudang Farmasi', '2025-03-05 02:46:10', '2025-04-01', '2025-03-06 21:10:05', '2025-03-07 21:19:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('PEREMPUAN','LAKI-LAKI') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `no_rm`, `nama`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, '000001', 'Mohammad Maulana Rifki Fadilah', 'Dusun Krajan RT 001, RW 002, Gumuksari, Kalisat', '2003-02-27', 'LAKI-LAKI', '2025-03-08 01:55:16', '2025-03-08 16:55:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `lokasi_penjualan` varchar(255) NOT NULL DEFAULT 'Farmasi RJ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id`, `nama_pasien`, `lokasi_penjualan`, `created_at`, `updated_at`) VALUES
(4, 'Rifki', 'Farmasi RJ', '2025-03-07 21:20:12', '2025-03-07 21:20:12'),
(5, 'Yuni', 'Farmasi RJ', '2025-03-08 00:47:28', '2025-03-08 00:47:28'),
(6, 'Lely', 'Farmasi RJ', '2025-03-08 01:29:15', '2025-03-08 01:29:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_details`
--

CREATE TABLE `penjualan_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penjualan_id` bigint(20) UNSIGNED NOT NULL,
  `obat_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjualan_details`
--

INSERT INTO `penjualan_details` (`id`, `penjualan_id`, `obat_id`, `jumlah`, `total_harga`, `created_at`, `updated_at`) VALUES
(13, 4, 6, 10, 11100, '2025-03-07 21:20:28', '2025-03-07 21:20:28'),
(14, 5, 8, 10, 49950, '2025-03-08 00:57:18', '2025-03-08 00:57:18'),
(15, 6, 8, 10, 44400, '2025-03-08 01:30:01', '2025-03-08 01:30:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `distributors_kode_distributor_unique` (`kode_distributor`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungan_pasien_id_foreign` (`pasien_id`);

--
-- Indeks untuk tabel `kunjungan_poli_umum`
--
ALTER TABLE `kunjungan_poli_umum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungan_poli_umum_pasien_id_foreign` (`pasien_id`),
  ADD KEY `kunjungan_poli_umum_dokter_id_foreign` (`dokter_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `obat_kode_obat_unique` (`kode_obat`),
  ADD KEY `obat_distributor_id_foreign` (`distributor_id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penjualan_details`
--
ALTER TABLE `penjualan_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualan_details_penjualan_id_foreign` (`penjualan_id`),
  ADD KEY `penjualan_details_obat_id_foreign` (`obat_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kunjungan_poli_umum`
--
ALTER TABLE `kunjungan_poli_umum`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `penjualan_details`
--
ALTER TABLE `penjualan_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kunjungan_poli_umum`
--
ALTER TABLE `kunjungan_poli_umum`
  ADD CONSTRAINT `kunjungan_poli_umum_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kunjungan_poli_umum_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan_details`
--
ALTER TABLE `penjualan_details`
  ADD CONSTRAINT `penjualan_details_obat_id_foreign` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penjualan_details_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
