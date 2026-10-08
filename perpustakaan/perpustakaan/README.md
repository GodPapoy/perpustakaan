# Perpustakaan Digital

Web sederhana (PHP + MySQL) yang menampilkan data dari database perpustakaan.

## Struktur Project

```
perpustakaan/
├── services/config.php   → koneksi database
├── database/schema.sql   → DDL + DML + query sample
├── css/style.css         → styling (1 warna brand, flexbox, responsive)
├── index.php             → halaman utama (menampilkan tabel)
└── README.md
```

> Catatan: pada tugas tertulis `style.css` di root / `css/style.css`. Di sini disimpan di folder `css/`
> dan dipanggil dengan `<link rel="stylesheet" href="css/style.css">`.

## Cara Menjalankan

1. Install **XAMPP**, jalankan **Apache** dan **MySQL**.
2. Salin folder `perpustakaan` ke `C:\xampp\htdocs\` (Mac: `/Applications/XAMPP/htdocs/`).
3. Buka `http://localhost/phpmyadmin` → tab **Import** → pilih `database/schema.sql` → **Go**.
4. Sesuaikan user/password di `services/config.php` bila perlu.
5. Buka `http://localhost/perpustakaan/` di browser.

## Entitas dan Atribut

| Entitas | Atribut |
|---|---|
| **kategori** (Master) | id_kategori (PK), nama_kategori, deskripsi, rak |
| **buku** (Master) | id_buku (PK), id_kategori (FK), judul, penulis, penerbit, tahun_terbit |
| **peminjam** (Master) | id_peminjam (PK), nama, alamat, no_hp, email |
| **peminjaman** (Transaksi) | id_peminjaman (PK), id_buku (FK), id_peminjam (FK), tanggal_pinjam, tanggal_kembali, status |

## Relasi dan Kardinalitas

| Relasi | Kardinalitas | Penjelasan |
|---|---|---|
| kategori → buku | **1 : N** (One-to-Many) | Satu kategori memiliki banyak buku; satu buku hanya punya satu kategori |
| buku → peminjaman | **1 : N** | Satu buku bisa dipinjam berkali-kali |
| peminjam → peminjaman | **1 : N** | Satu peminjam bisa melakukan banyak peminjaman |
| buku ↔ peminjam | **N : M** | Dihubungkan lewat tabel `peminjaman` |

## ERD (teks)

```
kategori 1 ────< buku 1 ────< peminjaman >──── 1 peminjam
```

## Query Sample

Lihat bagian bawah `database/schema.sql` (SELECT, JOIN, UPDATE, DELETE).

## Fitur

- Koneksi `mysqli`
- SELECT dari 4 tabel dengan JOIN
- Loop `while` + `fetch_assoc()`
- Tabel HTML dinamis
- Styling 1 warna brand, card dengan padding/border/shadow, navbar flexbox, responsive mobile
