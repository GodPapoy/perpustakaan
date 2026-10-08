<?php
require_once __DIR__ . '/services/config.php';

// Query 1: Kategori
$q_kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori");

// Query 2: Buku (JOIN kategori)
$q_buku = mysqli_query($conn, "
    SELECT b.id_buku, b.judul, b.penulis, b.penerbit, b.tahun_terbit, k.nama_kategori
    FROM buku b
    JOIN kategori k ON b.id_kategori = k.id_kategori
    ORDER BY b.id_buku
");

// Query 3: Peminjaman (JOIN buku & peminjam)
$q_pinjam = mysqli_query($conn, "
    SELECT p.id_peminjaman, pm.nama, b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
    FROM peminjaman p
    JOIN peminjam pm ON p.id_peminjam = pm.id_peminjam
    JOIN buku b      ON p.id_buku = b.id_buku
    ORDER BY p.id_peminjaman
");

// Query 4: Peminjam
$q_peminjam = mysqli_query($conn, "SELECT * FROM peminjam ORDER BY id_peminjam");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <h1>📚 Perpustakaan Digital</h1>
    <nav>
        <a href="#kategori">Kategori</a>
        <a href="#buku">Buku</a>
        <a href="#peminjam">Peminjam</a>
        <a href="#peminjaman">Peminjaman</a>
    </nav>
</header>

<main class="container">

    <!-- TABEL 1: KATEGORI -->
    <section class="card" id="kategori">
        <h2>Data Kategori</h2>
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Nama Kategori</th><th>Deskripsi</th><th>Rak</th></tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($q_kategori)) : ?>
                <tr>
                    <td><?= $row['id_kategori'] ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= htmlspecialchars($row['rak']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>

    <!-- TABEL 2: BUKU -->
    <section class="card" id="buku">
        <h2>Data Buku</h2>
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Kategori</th></tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($q_buku)) : ?>
                <tr>
                    <td><?= $row['id_buku'] ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['penulis']) ?></td>
                    <td><?= htmlspecialchars($row['penerbit']) ?></td>
                    <td><?= $row['tahun_terbit'] ?></td>
                    <td><span class="badge"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>

    <!-- TABEL 3: PEMINJAM -->
    <section class="card" id="peminjam">
        <h2>Data Peminjam</h2>
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Nama</th><th>Alamat</th><th>No. HP</th><th>Email</th></tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($q_peminjam)) : ?>
                <tr>
                    <td><?= $row['id_peminjam'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>

    <!-- TABEL 4: PEMINJAMAN (TRANSAKSI) -->
    <section class="card" id="peminjaman">
        <h2>Data Peminjaman</h2>
        <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Peminjam</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($q_pinjam)) : ?>
                <tr>
                    <td><?= $row['id_peminjaman'] ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= $row['tanggal_pinjam'] ?></td>
                    <td><?= $row['tanggal_kembali'] ?? '-' ?></td>
                    <td>
                        <span class="status <?= $row['status'] == 'Dipinjam' ? 'pinjam' : 'kembali' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>

</main>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> Perpustakaan Digital - Tugas Web & Database</p>
</footer>

</body>
</html>
