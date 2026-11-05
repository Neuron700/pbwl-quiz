-- ============================================================
-- Sistem Informasi Laundry
-- Pemrograman Berbasis Web Lanjutan (Quiz & Tugas)
-- Skema identik; hanya nama database yang berbeda.
-- ============================================================

CREATE DATABASE IF NOT EXISTS laundry_quiz
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE laundry_quiz;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";

-- ------------------------------------------------------------
-- Tabel: pelanggan
-- ------------------------------------------------------------
CREATE TABLE tb_pelanggan (
  pel_id     INT(11) NOT NULL AUTO_INCREMENT,
  pel_nama   VARCHAR(100) NOT NULL,
  pel_alamat TEXT DEFAULT NULL,
  pel_hp     VARCHAR(30) NOT NULL,
  PRIMARY KEY (pel_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Tabel: layanan
-- ------------------------------------------------------------
CREATE TABLE tb_layanan (
  lay_id    INT(11) NOT NULL AUTO_INCREMENT,
  lay_jenis VARCHAR(100) NOT NULL,
  lay_harga INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (lay_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Tabel: users
-- ------------------------------------------------------------
CREATE TABLE tb_users (
  user_id          INT(11) NOT NULL AUTO_INCREMENT,
  user_name        VARCHAR(50) NOT NULL,
  user_password    VARCHAR(256) NOT NULL,
  user_namalengkap VARCHAR(100) NOT NULL,
  user_aktif       TINYINT(3) NOT NULL DEFAULT 1,
  PRIMARY KEY (user_id),
  UNIQUE KEY user_name (user_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Tabel: transaksi
-- ------------------------------------------------------------
CREATE TABLE tb_transaksi (
  trans_id            INT(11) NOT NULL AUTO_INCREMENT,
  trans_id_pelanggan  INT(11) NOT NULL,
  trans_id_layanan    INT(11) NOT NULL,
  trans_tgl_masuk     DATE NOT NULL,
  trans_tgl_selesai   DATE DEFAULT NULL,
  trans_berat         INT(11) NOT NULL DEFAULT 0,
  trans_total         INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (trans_id),
  KEY trans_id_pelanggan (trans_id_pelanggan),
  KEY trans_id_layanan (trans_id_layanan),
  CONSTRAINT fk_transaksi_pelanggan
    FOREIGN KEY (trans_id_pelanggan) REFERENCES tb_pelanggan (pel_id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_transaksi_layanan
    FOREIGN KEY (trans_id_layanan) REFERENCES tb_layanan (lay_id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Data contoh (seed)
-- ------------------------------------------------------------
INSERT INTO tb_users (user_name, user_password, user_namalengkap, user_aktif) VALUES
  ('admin', '$2y$10$WPRBP/x1k9ARJ09xz6IjPe.ubRM//jrzPs1y85.ST6sAlpDL.hdq6', 'Administrator Laundry', 1);

INSERT INTO tb_layanan (lay_jenis, lay_harga) VALUES
  ('Cuci Kering', 5000),
  ('Cuci + Setrika', 12000),
  ('Setrika Saja', 4000),
  ('Cuci Express', 20000),
  ('Cuci Satuan', 15000);

INSERT INTO tb_pelanggan (pel_nama, pel_alamat, pel_hp) VALUES
  ('Ahmad Fauzi', 'Jl. Merdeka No. 10, Medan', '081234567890'),
  ('Siti Rahma', 'Jl. Sudirman No. 25, Binjai', '082234567891'),
  ('Budi Santoso', 'Jl. Diponegoro No. 7, Medan', '083234567892'),
  ('Dewi Lestari', 'Jl. Pahlawan No. 15, Deli Serdang', '084234567893');

INSERT INTO tb_transaksi (trans_id_pelanggan, trans_id_layanan, trans_tgl_masuk, trans_tgl_selesai, trans_berat, trans_total) VALUES
  (1, 1, '2026-11-01', '2026-11-03', 5, 25000),
  (2, 2, '2026-11-02', '2026-11-04', 6, 72000),
  (3, 3, '2026-11-02', NULL, 4, 16000),
  (4, 4, '2026-11-03', '2026-11-04', 3, 60000),
  (1, 5, '2026-11-04', NULL, 2, 30000),
  (3, 2, '2026-11-05', NULL, 8, 96000);