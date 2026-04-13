<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php
    require_once 'functions_anggota.php';

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

    // Ambil input search dan sort
    $keyword = $_GET['search'] ?? '';
    $urutkan = $_GET['sort'] ?? 'default';

    // Data awal
    $data_tampil = $anggota_list;

    // Search by nama
    if (!empty($keyword)) {
        $data_tampil = search_anggota_by_nama($data_tampil, $keyword);
    }

    // Sort by nama A-Z
    if ($urutkan === 'nama') {
        $data_tampil = sort_anggota_by_nama($data_tampil);
    }

    // Statistik
    $total_anggota = hitung_total_anggota($anggota_list);
    $anggota_aktif = hitung_anggota_aktif($anggota_list);
    $anggota_nonaktif = $total_anggota - $anggota_aktif;
    $persen_aktif = $total_anggota > 0 ? ($anggota_aktif / $total_anggota) * 100 : 0;
    $persen_nonaktif = $total_anggota > 0 ? ($anggota_nonaktif / $total_anggota) * 100 : 0;
    $rata_rata_pinjaman = hitung_rata_rata_pinjaman($anggota_list);
    $anggota_teraktif = cari_anggota_teraktif($anggota_list);

    // Pisahkan anggota aktif dan non-aktif
    $list_aktif = filter_by_status($anggota_list, 'Aktif');
    $list_nonaktif = filter_by_status($anggota_list, 'Non-Aktif');
    ?>

    <div class="container py-5">
        <h1 class="mb-4 fw-bold"><i class="bi bi-people-fill"></i> Sistem Anggota Perpustakaan</h1>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Anggota</h6>
                        <h3 class="fw-bold"><?= $total_anggota ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Aktif</h6>
                        <h3 class="fw-bold text-success"><?= number_format($persen_aktif, 1) ?>%</h3>
                        <small><?= $anggota_aktif ?> anggota</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Anggota Non-Aktif</h6>
                        <h3 class="fw-bold text-danger"><?= number_format($persen_nonaktif, 1) ?>%</h3>
                        <small><?= $anggota_nonaktif ?> anggota</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Rata-rata Pinjaman</h6>
                        <h3 class="fw-bold text-primary"><?= number_format($rata_rata_pinjaman, 1) ?></h3>
                        <small>pinjaman / anggota</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Anggota Teraktif</h5>
            </div>
            <div class="card-body">
                <?php if ($anggota_teraktif): ?>
                    <div class="alert alert-success mb-0">
                        <strong><?= htmlspecialchars($anggota_teraktif['nama']) ?></strong>
                        (<?= htmlspecialchars($anggota_teraktif['id']) ?>) adalah anggota teraktif dengan
                        <strong><?= $anggota_teraktif['total_pinjaman'] ?></strong> total pinjaman.
                    </div>
                <?php else: ?>
                    <p class="mb-0">Data anggota tidak tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Anggota</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari anggota berdasarkan nama..." value="<?= htmlspecialchars($keyword) ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="sort" class="form-select">
                            <option value="default" <?= $urutkan === 'default' ? 'selected' : '' ?>>Urutan Default</option>
                            <option value="nama" <?= $urutkan === 'nama' ? 'selected' : '' ?>>Nama A-Z</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>

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
                            <?php if (count($data_tampil) > 0): ?>
                                <?php $no = 1; foreach ($data_tampil as $anggota): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($anggota['id']) ?></td>
                                        <td><?= htmlspecialchars($anggota['nama']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($anggota['email']) ?>
                                            <?php if (!validasi_email($anggota['email'])): ?>
                                                <span class="badge bg-warning text-dark">Email tidak valid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($anggota['telepon']) ?></td>
                                        <td><?= htmlspecialchars($anggota['alamat']) ?></td>
                                        <td><?= format_tanggal_indo($anggota['tanggal_daftar']) ?></td>
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

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Anggota Aktif</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($list_aktif as $anggota): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($anggota['nama']) ?>
                                    <span class="badge bg-success rounded-pill"><?= $anggota['total_pinjaman'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Anggota Non-Aktif</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($list_nonaktif as $anggota): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($anggota['nama']) ?>
                                    <span class="badge bg-danger rounded-pill"><?= $anggota['total_pinjaman'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>