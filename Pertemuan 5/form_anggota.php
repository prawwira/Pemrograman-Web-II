<?php
// Inisialisasi variabel
$nama = $email = $telepon = $alamat = $jenis_kelamin = $tanggal_lahir = $pekerjaan = "";

$errors = [
    'nama' => '',
    'email' => '',
    'telepon' => '',
    'alamat' => '',
    'jenis_kelamin' => '',
    'tanggal_lahir' => '',
    'pekerjaan' => ''
];

$success = false;
$umur = 0;
$data = [];

function bersihkan_input($data) {
    return htmlspecialchars(trim($data));
}

function hitung_umur($tanggal_lahir) {
    $lahir = new DateTime($tanggal_lahir);
    $hari_ini = new DateTime();
    return $hari_ini->diff($lahir)->y;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = bersihkan_input($_POST['nama'] ?? '');
    $email = bersihkan_input($_POST['email'] ?? '');
    $telepon = bersihkan_input($_POST['telepon'] ?? '');
    $alamat = bersihkan_input($_POST['alamat'] ?? '');
    $jenis_kelamin = bersihkan_input($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = bersihkan_input($_POST['tanggal_lahir'] ?? '');
    $pekerjaan = bersihkan_input($_POST['pekerjaan'] ?? '');

    // Validasi Nama
    if (empty($nama)) {
        $errors['nama'] = "Nama lengkap wajib diisi.";
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = "Nama minimal 3 karakter.";
    }

    // Validasi Email
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid.";
    }

    // Validasi Telepon
    if (empty($telepon)) {
        $errors['telepon'] = "Telepon wajib diisi.";
    } elseif (!preg_match('/^08\d{8,11}$/', $telepon)) {
        $errors['telepon'] = "Telepon harus format 08xxxxxxxxxx (10-13 digit).";
    }

    // Validasi Alamat
    if (empty($alamat)) {
        $errors['alamat'] = "Alamat wajib diisi.";
    } elseif (strlen($alamat) < 10) {
        $errors['alamat'] = "Alamat minimal 10 karakter.";
    }

    // Validasi Jenis Kelamin
    if (empty($jenis_kelamin)) {
        $errors['jenis_kelamin'] = "Jenis kelamin wajib dipilih.";
    }

    // Validasi Tanggal Lahir + Umur minimal 10 tahun
    if (empty($tanggal_lahir)) {
        $errors['tanggal_lahir'] = "Tanggal lahir wajib diisi.";
    } else {
        $umur = hitung_umur($tanggal_lahir);
        if ($umur < 10) {
            $errors['tanggal_lahir'] = "Umur minimal 10 tahun.";
        }
    }

    // Validasi Pekerjaan
    $opsi_pekerjaan = ['Pelajar', 'Mahasiswa', 'Pegawai', 'Lainnya'];
    if (empty($pekerjaan)) {
        $errors['pekerjaan'] = "Pekerjaan wajib dipilih.";
    } elseif (!in_array($pekerjaan, $opsi_pekerjaan)) {
        $errors['pekerjaan'] = "Pilihan pekerjaan tidak valid.";
    }

    // Jika semua valid
    if (!array_filter($errors)) {
        $success = true;
        $data = [
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon,
            'alamat' => $alamat,
            'jenis_kelamin' => $jenis_kelamin,
            'tanggal_lahir' => $tanggal_lahir,
            'umur' => $umur,
            'pekerjaan' => $pekerjaan
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrasi Anggota Perpustakaan</h4>
                </div>
                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            Registrasi berhasil disimpan.
                        </div>

                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <strong>Data Anggota</strong>
                            </div>
                            <div class="card-body">
                                <p><strong>Nama Lengkap:</strong> <?= $data['nama']; ?></p>
                                <p><strong>Email:</strong> <?= $data['email']; ?></p>
                                <p><strong>Telepon:</strong> <?= $data['telepon']; ?></p>
                                <p><strong>Alamat:</strong><br><?= nl2br($data['alamat']); ?></p>
                                <p><strong>Jenis Kelamin:</strong> <?= $data['jenis_kelamin']; ?></p>
                                <p><strong>Tanggal Lahir:</strong> <?= date('d-m-Y', strtotime($data['tanggal_lahir'])); ?></p>
                                <p><strong>Umur:</strong> <?= $data['umur']; ?> tahun</p>
                                <p><strong>Pekerjaan:</strong> <?= $data['pekerjaan']; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control <?= !empty($errors['nama']) ? 'is-invalid' : ''; ?>" value="<?= $nama; ?>">
                            <div class="invalid-feedback"><?= $errors['nama']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : ''; ?>" value="<?= $email; ?>">
                            <div class="invalid-feedback"><?= $errors['email']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control <?= !empty($errors['telepon']) ? 'is-invalid' : ''; ?>" value="<?= $telepon; ?>" placeholder="08xxxxxxxxxx">
                            <div class="invalid-feedback"><?= $errors['telepon']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="3" class="form-control <?= !empty($errors['alamat']) ? 'is-invalid' : ''; ?>"><?= $alamat; ?></textarea>
                            <div class="invalid-feedback"><?= $errors['alamat']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input <?= !empty($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" value="Laki-laki" <?= ($jenis_kelamin == 'Laki-laki') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input <?= !empty($errors['jenis_kelamin']) ? 'is-invalid' : ''; ?>" type="radio" name="jenis_kelamin" value="Perempuan" <?= ($jenis_kelamin == 'Perempuan') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Perempuan</label>
                            </div>
                            <div class="text-danger small mt-1"><?= $errors['jenis_kelamin']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control <?= !empty($errors['tanggal_lahir']) ? 'is-invalid' : ''; ?>" value="<?= $tanggal_lahir; ?>">
                            <div class="invalid-feedback"><?= $errors['tanggal_lahir']; ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <select name="pekerjaan" class="form-select <?= !empty($errors['pekerjaan']) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Pekerjaan --</option>
                                <option value="Pelajar" <?= ($pekerjaan == 'Pelajar') ? 'selected' : ''; ?>>Pelajar</option>
                                <option value="Mahasiswa" <?= ($pekerjaan == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                                <option value="Pegawai" <?= ($pekerjaan == 'Pegawai') ? 'selected' : ''; ?>>Pegawai</option>
                                <option value="Lainnya" <?= ($pekerjaan == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <div class="invalid-feedback"><?= $errors['pekerjaan']; ?></div>
                        </div>

                        <button type="submit" class="btn btn-primary">Daftar</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>