-- ============================================
-- schema.sql : Database Perpustakaan
-- ============================================
DROP DATABASE IF EXISTS perpustakaan;
CREATE DATABASE perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE perpustakaan;

-- ---------- DDL ----------

-- Tabel 1 (Master): Kategori
CREATE TABLE kategori (
    id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50)  NOT NULL,
    deskripsi     VARCHAR(150),
    rak           VARCHAR(10)
);

-- Tabel 2 (Master): Buku  (Kategori 1 : N Buku)
CREATE TABLE buku (
    id_buku      INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori  INT NOT NULL,
    judul        VARCHAR(100) NOT NULL,
    penulis      VARCHAR(80)  NOT NULL,
    penerbit     VARCHAR(80),
    tahun_terbit YEAR,
    CONSTRAINT fk_buku_kategori FOREIGN KEY (id_kategori)
        REFERENCES kategori(id_kategori)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Tabel 3 (Master): Peminjam
CREATE TABLE peminjam (
    id_peminjam INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(80) NOT NULL,
    alamat      VARCHAR(150),
    no_hp       VARCHAR(15),
    email       VARCHAR(80)
);

-- Tabel 4 (Transaksi): Peminjaman  (FK ke Buku & Peminjam)
CREATE TABLE peminjaman (
    id_peminjaman   INT AUTO_INCREMENT PRIMARY KEY,
    id_buku         INT NOT NULL,
    id_peminjam     INT NOT NULL,
    tanggal_pinjam  DATE NOT NULL,
    tanggal_kembali DATE,
    status          ENUM('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
    CONSTRAINT fk_pinjam_buku FOREIGN KEY (id_buku)
        REFERENCES buku(id_buku) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_pinjam_peminjam FOREIGN KEY (id_peminjam)
        REFERENCES peminjam(id_peminjam) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- ---------- DML (minimal 5 baris per tabel) ----------

INSERT INTO kategori (nama_kategori, deskripsi, rak) VALUES
('Novel',       'Fiksi dan cerita panjang',        'A1'),
('Teknologi',   'Pemrograman dan komputer',        'B1'),
('Sains',       'Ilmu pengetahuan alam',           'C1'),
('Sejarah',     'Sejarah dunia dan Indonesia',     'D1'),
('Bisnis',      'Manajemen dan kewirausahaan',     'E1');

INSERT INTO buku (id_kategori, judul, penulis, penerbit, tahun_terbit) VALUES
(1, 'Laskar Pelangi',            'Andrea Hirata',     'Bentang Pustaka', 2005),
(1, 'Bumi Manusia',              'Pramoedya A. Toer', 'Hasta Mitra',     1980),
(2, 'Belajar PHP dan MySQL',     'Budi Raharjo',      'Informatika',     2019),
(2, 'Dasar Pemrograman Web',     'Andi Sunyoto',      'Andi Offset',     2020),
(3, 'Fisika Dasar',              'Halliday',          'Erlangga',        2014),
(4, 'Sejarah Indonesia Modern',  'M.C. Ricklefs',     'Serambi',         2008),
(5, 'Zero to One',               'Peter Thiel',       'Gramedia',        2015);

INSERT INTO peminjam (nama, alamat, no_hp, email) VALUES
('Rizal Fadli',    'Surabaya',  '081234567801', 'rizal@mail.com'),
('Siti Aminah',    'Sidoarjo',  '081234567802', 'siti@mail.com'),
('Budi Santoso',   'Gresik',    '081234567803', 'budi@mail.com'),
('Dewi Lestari',   'Malang',    '081234567804', 'dewi@mail.com'),
('Agus Pratama',   'Surabaya',  '081234567805', 'agus@mail.com');

INSERT INTO peminjaman (id_buku, id_peminjam, tanggal_pinjam, tanggal_kembali, status) VALUES
(1, 1, '2026-09-20', '2026-09-27', 'Dikembalikan'),
(3, 2, '2026-09-25', NULL,         'Dipinjam'),
(4, 1, '2026-10-01', NULL,         'Dipinjam'),
(2, 3, '2026-10-02', '2026-10-06', 'Dikembalikan'),
(5, 4, '2026-10-05', NULL,         'Dipinjam'),
(7, 5, '2026-10-06', NULL,         'Dipinjam');

-- ---------- QUERY SAMPLE ----------

-- SELECT sederhana
SELECT * FROM buku;

-- JOIN: buku beserta kategorinya (1-to-Many)
SELECT b.judul, b.penulis, k.nama_kategori
FROM buku b
JOIN kategori k ON b.id_kategori = k.id_kategori;

-- JOIN 3 tabel: data peminjaman lengkap
SELECT p.id_peminjaman, pm.nama, b.judul, p.tanggal_pinjam, p.status
FROM peminjaman p
JOIN peminjam pm ON p.id_peminjam = pm.id_peminjam
JOIN buku b      ON p.id_buku = b.id_buku;

-- UPDATE: kembalikan buku
UPDATE peminjaman
SET status = 'Dikembalikan', tanggal_kembali = CURDATE()
WHERE id_peminjaman = 2;

-- DELETE: hapus transaksi tertentu
DELETE FROM peminjaman WHERE id_peminjaman = 6;
