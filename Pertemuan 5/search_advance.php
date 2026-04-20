<?php
// ================================
// DATA BUKU (minimal 10)
// ================================
$buku_list = [
    [
        'kode' => 'B001',
        'judul' => 'Dasar Pemrograman PHP',
        'kategori' => 'Pemrograman',
        'pengarang' => 'Andi Wijaya',
        'penerbit' => 'Informatika',
        'tahun' => 2020,
        'harga' => 85000,
        'stok' => 7
    ],
    [
        'kode' => 'B002',
        'judul' => 'Algoritma dan Struktur Data',
        'kategori' => 'Pemrograman',
        'pengarang' => 'Budi Santoso',
        'penerbit' => 'Erlangga',
        'tahun' => 2019,
        'harga' => 95000,
        'stok' => 0
    ],
    [
        'kode' => 'B003',
        'judul' => 'Basis Data Modern',
        'kategori' => 'Database',
        'pengarang' => 'Siti Rahayu',
        'penerbit' => 'Gramedia',
        'tahun' => 2021,
        'harga' => 110000,
        'stok' => 4
    ],
    [
        'kode' => 'B004',
        'judul' => 'Jaringan Komputer Dasar',
        'kategori' => 'Jaringan',
        'pengarang' => 'Dedi Pratama',
        'penerbit' => 'Informatika',
        'tahun' => 2018,
        'harga' => 78000,
        'stok' => 2
    ],
    [
        'kode' => 'B005',
        'judul' => 'Pemrograman Web dengan Laravel',
        'kategori' => 'Pemrograman',
        'pengarang' => 'Rina Marlina',
        'penerbit' => 'Gramedia',
        'tahun' => 2022,
        'harga' => 125000,
        'stok' => 5
    ],
    [
        'kode' => 'B006',
        'judul' => 'Manajemen Perpustakaan',
        'kategori' => 'Manajemen',
        'pengarang' => 'Hadi Firmansyah',
        'penerbit' => 'Salemba',
        'tahun' => 2017,
        'harga' => 67000,
        'stok' => 1
    ],
    [
        'kode' => 'B007',
        'judul' => 'Kecerdasan Buatan',
        'kategori' => 'Artificial Intelligence',
        'pengarang' => 'Maya Putri',
        'penerbit' => 'Andi',
        'tahun' => 2023,
        'harga' => 145000,
        'stok' => 8
    ],
    [
        'kode' => 'B008',
        'judul' => 'Desain Grafis untuk Pemula',
        'kategori' => 'Desain',
        'pengarang' => 'Farhan Akbar',
        'penerbit' => 'Elex Media',
        'tahun' => 2016,
        'harga' => 72000,
        'stok' => 0
    ],
    [
        'kode' => 'B009',
        'judul' => 'Sistem Informasi Akuntansi',
        'kategori' => 'Akuntansi',
        'pengarang' => 'Nia Kurnia',
        'penerbit' => 'Erlangga',
        'tahun' => 2021,
        'harga' => 99000,
        'stok' => 6
    ],
    [
        'kode' => 'B010',
        'judul' => 'Statistika untuk Informatika',
        'kategori' => 'Statistika',
        'pengarang' => 'Agus Setiawan',
        'penerbit' => 'Informatika',
        'tahun' => 2015,
        'harga' => 65000,
        'stok' => 3
    ],
    [
        'kode' => 'B011',
        'judul' => 'Pemrograman JavaScript Lanjutan',
        'kategori' => 'Pemrograman',
        'pengarang' => 'Indah Lestari',
        'penerbit' => 'Gramedia',
        'tahun' => 2024,
        'harga' => 135000,
        'stok' => 9
    ],
    [
        'kode' => 'B012',
        'judul' => 'Administrasi Sistem Komputer',
        'kategori' => 'Sistem Operasi',
        'pengarang' => 'Teguh Prakoso',
        'penerbit' => 'Andi',
        'tahun' => 2020,
        'harga' => 89000,
        'stok' => 0
    ],
];

// ================================
// AMBIL PARAMETER GET
// ================================
$keyword   = trim($_GET['keyword'] ?? '');
$kategori  = trim($_GET['kategori'] ?? '');
$min_harga = trim($_GET['min_harga'] ?? '');
$max_harga = trim($_GET['max_harga'] ?? '');
$tahun     = trim($_GET['tahun'] ?? '');
$status    = $_GET['status'] ?? 'semua';
$sort      = $_GET['sort'] ?? 'judul';
$page      = max(1, (int)($_GET['page'] ?? 1));

// ================================
// VALIDASI
// ================================
$errors = [];
$current_year = (int)date('Y');

if ($min_harga !== '' && $max_harga !== '') {
    if ((int)$min_harga > (int)$max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum.";
    }
}

if ($tahun !== '') {
    if (!is_numeric($tahun) || (int)$tahun < 1900 || (int)$tahun > $current_year) {
        $errors[] = "Tahun harus valid (1900 - " . $current_year . ").";
    }
}

// ================================
// FILTER DATA
// ================================
$hasil = $buku_list;

if (empty($errors)) {
    $hasil = array_filter($buku_list, function ($buku) use ($keyword, $kategori, $min_harga, $max_harga, $tahun, $status) {
        $cocok = true;

        // Keyword: judul/pengarang
        if ($keyword !== '') {
            $kw = strtolower($keyword);
            $cocok = $cocok && (
                str_contains(strtolower($buku['judul']), $kw) ||
                str_contains(strtolower($buku['pengarang']), $kw)
            );
        }

        // Kategori
        if ($kategori !== '') {
            $cocok = $cocok && ($buku['kategori'] === $kategori);
        }

        // Range harga
        if ($min_harga !== '') {
            $cocok = $cocok && ($buku['harga'] >= (int)$min_harga);
        }
        if ($max_harga !== '') {
            $cocok = $cocok && ($buku['harga'] <= (int)$max_harga);
        }

        // Tahun terbit
        if ($tahun !== '') {
            $cocok = $cocok && ((int)$buku['tahun'] === (int)$tahun);
        }

        // Status ketersediaan
        if ($status === 'tersedia') {
            $cocok = $cocok && ($buku['stok'] > 0);
        } elseif ($status === 'habis') {
            $cocok = $cocok && ($buku['stok'] == 0);
        }

        return $cocok;
    });

    $hasil = array_values($hasil);

    // ================================
    // SORTING
    // ================================
    usort($hasil, function ($a, $b) use ($sort) {
        switch ($sort) {
            case 'harga':
                return $a['harga'] <=> $b['harga'];
            case 'tahun':
                return $a['tahun'] <=> $b['tahun'];
            case 'judul':
            default:
                return strcmp($a['judul'], $b['judul']);
        }
    });
}

// ================================
// PAGINATION
// ================================
$per_page = 10;
$total_hasil = count($hasil);
$total_page = max(1, (int)ceil($total_hasil / $per_page));
$page = min($page, $total_page);

$offset = ($page - 1) * $per_page;
$hasil_tampil = array_slice($hasil, $offset, $per_page);

// ================================
// HELPER
// ================================
function e($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function highlight_keyword($text, $keyword)
{
    if ($keyword === '') return e($text);

    $safe_text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $pattern = '/' . preg_quote(htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'), '/') . '/i';

    return preg_replace($pattern, '<mark>$0</mark>', $safe_text);
}

// ambil kategori unik untuk dropdown
$kategori_list = array_values(array_unique(array_map(fn($b) => $b['kategori'], $buku_list)));
sort($kategori_list);

// query string untuk pagination
function build_query($page, $keyword, $kategori, $min_harga, $max_harga, $tahun, $status, $sort)
{
    return http_build_query([
        'keyword' => $keyword,
        'kategori' => $kategori,
        'min_harga' => $min_harga,
        'max_harga' => $max_harga,
        'tahun' => $tahun,
        'status' => $status,
        'sort' => $sort,
        'page' => $page
    ]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pencarian & Filter Buku</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Keyword (judul/pengarang)</label>
                                <input type="text" name="keyword" class="form-control" value="<?= e($keyword) ?>" placeholder="Cari judul atau pengarang">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($kategori_list as $kat): ?>
                                        <option value="<?= e($kat) ?>" <?= $kategori === $kat ? 'selected' : '' ?>>
                                            <?= e($kat) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Harga Minimum</label>
                                <input type="number" name="min_harga" class="form-control" value="<?= e($min_harga) ?>" min="0">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Harga Maksimum</label>
                                <input type="number" name="max_harga" class="form-control" value="<?= e($max_harga) ?>" min="0">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun" class="form-control" value="<?= e($tahun) ?>" min="1900" max="<?= $current_year ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Sorting</label>
                                <select name="sort" class="form-select">
                                    <option value="judul" <?= $sort === 'judul' ? 'selected' : '' ?>>Judul</option>
                                    <option value="harga" <?= $sort === 'harga' ? 'selected' : '' ?>>Harga</option>
                                    <option value="tahun" <?= $sort === 'tahun' ? 'selected' : '' ?>>Tahun</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label d-block">Status Ketersediaan</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="semua" id="status_semua" <?= $status === 'semua' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_semua">Semua</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="tersedia" id="status_tersedia" <?= $status === 'tersedia' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_tersedia">Tersedia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="habis" id="status_habis" <?= $status === 'habis' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_habis">Habis</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= e($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold">
                    Ditemukan <span class="text-primary"><?= $total_hasil ?></span> buku
                </div>
                <div class="text-muted">
                    Halaman <?= $page ?> dari <?= $total_page ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($total_hasil > 0 && empty($errors)): ?>
                                    <?php foreach ($hasil_tampil as $buku): ?>
                                        <tr>
                                            <td><?= e($buku['kode']) ?></td>
                                            <td><?= highlight_keyword($buku['judul'], $keyword) ?></td>
                                            <td><?= e($buku['kategori']) ?></td>
                                            <td><?= highlight_keyword($buku['pengarang'], $keyword) ?></td>
                                            <td><?= e($buku['penerbit']) ?></td>
                                            <td><?= e($buku['tahun']) ?></td>
                                            <td>Rp <?= number_format($buku['harga'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php if ($buku['stok'] > 0): ?>
                                                    <span class="badge bg-success"><?= e($buku['stok']) ?> tersedia</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php elseif (empty($errors)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Tidak ada data yang cocok.</td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Perbaiki input filter terlebih dahulu.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($total_page > 1 && empty($errors)): ?>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= build_query($page - 1, $keyword, $kategori, $min_harga, $max_harga, $tahun, $status, $sort) ?>">Previous</a>
                        </li>

                        <?php for ($i = 1; $i <= $total_page; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= build_query($i, $keyword, $kategori, $min_harga, $max_harga, $tahun, $status, $sort) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $page >= $total_page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= build_query($page + 1, $keyword, $kategori, $min_harga, $max_harga, $tahun, $status, $sort) ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>