<?php
// array_anggota.php

$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Aminah",
        "email" => "siti@email.com",
        "telepon" => "081234567891",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-003",
        "nama" => "Andi Pratama",
        "email" => "andi@email.com",
        "telepon" => "081234567892",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-004",
        "nama" => "Rina Kartika",
        "email" => "rina@email.com",
        "telepon" => "081234567893",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-03-20",
        "status" => "Aktif",
        "total_pinjaman" => 10
    ],
    [
        "id" => "AGT-005",
        "nama" => "Dewi Lestari",
        "email" => "dewi@email.com",
        "telepon" => "081234567894",
        "alamat" => "Semarang",
        "tanggal_daftar" => "2024-04-01",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1
    ],
];

// Filter status dari GET
$filter_status = $_GET['status'] ?? 'Semua';

// Hitung statistik
$total_anggota = count($anggota_list);

$jumlah_aktif = 0;
$jumlah_nonaktif = 0;
$total_pinjaman_semua = 0;

foreach ($anggota_list as $anggota) {
    if ($anggota['status'] === 'Aktif') {
        $jumlah_aktif++;
    } else {
        $jumlah_nonaktif++;
    }
    $total_pinjaman_semua += $anggota['total_pinjaman'];
}

$persen_aktif = $total_anggota > 0 ? ($jumlah_aktif / $total_anggota) * 100 : 0;
$persen_nonaktif = $total_anggota > 0 ? ($jumlah_nonaktif / $total_anggota) * 100 : 0;
$rata_rata_pinjaman = $total_anggota > 0 ? $total_pinjaman_semua / $total_anggota : 0;

// Cari anggota dengan total pinjaman terbanyak
$anggota_teraktif = [];
$pinjaman_terbanyak = 0;

foreach ($anggota_list as $anggota) {
    if ($anggota['total_pinjaman'] > $pinjaman_terbanyak) {
        $pinjaman_terbanyak = $anggota['total_pinjaman'];
        $anggota_teraktif = [$anggota];
    } elseif ($anggota['total_pinjaman'] === $pinjaman_terbanyak) {
        $anggota_teraktif[] = $anggota;
    }
}

// Filter data anggota
$anggota_tampil = array_filter($anggota_list, function ($anggota) use ($filter_status) {
    if ($filter_status === 'Semua') return true;
    return $anggota['status'] === $filter_status;
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Data Anggota Perpustakaan</h2>
        <p class="text-muted mb-0">Manajemen data anggota menggunakan multidimensional array</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Anggota</h6>
                    <h3 class="fw-bold"><?= $total_anggota ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Anggota Aktif</h6>
                    <h3 class="fw-bold text-success"><?= number_format($persen_aktif, 1) ?>%</h3>
                    <small><?= $jumlah_aktif ?> anggota</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Anggota Non-Aktif</h6>
                    <h3 class="fw-bold text-danger"><?= number_format($persen_nonaktif, 1) ?>%</h3>
                    <small><?= $jumlah_nonaktif ?> anggota</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Rata-rata Pinjaman</h6>
                    <h3 class="fw-bold text-primary"><?= number_format($rata_rata_pinjaman, 1) ?></h3>
                    <small>pinjaman / anggota</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Anggota Teraktif</h5>
            <?php foreach ($anggota_teraktif as $anggota): ?>
                <div class="alert alert-info mb-2">
                    <strong><?= htmlspecialchars($anggota['nama']) ?></strong>
                    (<?= htmlspecialchars($anggota['id']) ?>) dengan
                    <strong><?= $anggota['total_pinjaman'] ?></strong> pinjaman
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter Berdasarkan Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Semua" <?= $filter_status === 'Semua' ? 'selected' : '' ?>>Semua</option>
                        <option value="Aktif" <?= $filter_status === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Non-Aktif" <?= $filter_status === 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Daftar Anggota</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Total Pinjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($anggota_tampil) > 0): ?>
                            <?php $no = 1; foreach ($anggota_tampil as $anggota): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($anggota['id']) ?></td>
                                    <td><?= htmlspecialchars($anggota['nama']) ?></td>
                                    <td><?= htmlspecialchars($anggota['email']) ?></td>
                                    <td><?= htmlspecialchars($anggota['telepon']) ?></td>
                                    <td><?= htmlspecialchars($anggota['alamat']) ?></td>
                                    <td><?= htmlspecialchars($anggota['tanggal_daftar']) ?></td>
                                    <td>
                                        <span class="badge <?= $anggota['status'] === 'Aktif' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= htmlspecialchars($anggota['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= $anggota['total_pinjaman'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>