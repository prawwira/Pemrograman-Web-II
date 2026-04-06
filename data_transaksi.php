<?php
date_default_timezone_set('Asia/Jakarta');

// Statistik awal
$total_transaksi = 0;
$total_dipinjam = 0;
$total_dikembalikan = 0;

// Loop pertama untuk hitung statistik
for ($i = 1; $i <= 10; $i++) {
    if ($i % 2 == 0) {
        continue; // skip transaksi genap
    }

    if ($i == 8) {
        break; // stop di transaksi ke-8
    }

    $total_transaksi++;

    $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";
    if ($status == "Dipinjam") {
        $total_dipinjam++;
    } else {
        $total_dikembalikan++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,.08);
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card card-stat text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <h2 class="card-text"><?= $total_transaksi; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-stat text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Masih Dipinjam</h5>
                        <h2 class="card-text"><?= $total_dipinjam; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card card-stat text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Sudah Dikembalikan</h5>
                        <h2 class="card-text"><?= $total_dikembalikan; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Hari</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    for ($i = 1; $i <= 10; $i++) {
                        if ($i % 2 == 0) {
                            continue; // skip transaksi genap
                        }

                        if ($i == 8) {
                            break; // stop di transaksi ke-8
                        }

                        $id_transaksi = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
                        $nama_peminjam = "Anggota " . $i;
                        $judul_buku = "Buku Teknologi Vol. " . $i;
                        $tanggal_pinjam = date('Y-m-d', strtotime("-$i days"));
                        $tanggal_kembali = date('Y-m-d', strtotime("+7 days", strtotime($tanggal_pinjam)));
                        $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

                        $jumlah_hari = floor((time() - strtotime($tanggal_pinjam)) / 86400);

                        if ($status == "Dikembalikan") {
                            $badge = "bg-success";
                        } else {
                            $badge = "bg-warning text-dark";
                        }
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $id_transaksi; ?></td>
                        <td><?= $nama_peminjam; ?></td>
                        <td><?= $judul_buku; ?></td>
                        <td><?= $tanggal_pinjam; ?></td>
                        <td><?= $tanggal_kembali; ?></td>
                        <td><?= $jumlah_hari; ?> hari</td>
                        <td><span class="badge <?= $badge; ?>"><?= $status; ?></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>