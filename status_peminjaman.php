<?php
// Data Anggota
$nama_anggota = "Budi Santoso";
$total_pinjaman = 2;
$buku_terlambat = 1;
$hari_keterlambatan = 5; // hari

// Aturan
$batas_pinjam = 3;
$denda_per_hari_per_buku = 1000;
$denda_maksimal = 50000;

// Hitung denda
$total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari_per_buku;
if ($total_denda > $denda_maksimal) {
    $total_denda = $denda_maksimal;
}

// Cek status peminjaman (IF-ELSEIF-ELSE)
if ($buku_terlambat > 0) {
    $status_pinjam = "Tidak bisa pinjam lagi karena masih ada buku terlambat.";
} elseif ($total_pinjaman >= $batas_pinjam) {
    $status_pinjam = "Tidak bisa pinjam lagi karena sudah mencapai batas maksimal 3 buku.";
} else {
    $status_pinjam = "Bisa pinjam lagi.";
}

// Tentukan level member (SWITCH)
switch (true) {
    case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
        $level_member = "Bronze";
        break;
    case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
        $level_member = "Silver";
        break;
    default:
        $level_member = "Gold";
        break;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Peminjaman</title>
</head>
<body>

<h2>Status Peminjaman Anggota</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Nama Anggota</th>
        <td><?= $nama_anggota; ?></td>
    </tr>
    <tr>
        <th>Total Pinjaman</th>
        <td><?= $total_pinjaman; ?> buku</td>
    </tr>
    <tr>
        <th>Buku Terlambat</th>
        <td><?= $buku_terlambat; ?> buku</td>
    </tr>
    <tr>
        <th>Hari Keterlambatan</th>
        <td><?= $hari_keterlambatan; ?> hari</td>
    </tr>
    <tr>
        <th>Level Member</th>
        <td><?= $level_member; ?></td>
    </tr>
</table>

<h3>Status:</h3>
<p><?= $status_pinjam; ?></p>

<?php if ($buku_terlambat > 0): ?>
    <p style="color:red;">
        Peringatan: Anda memiliki keterlambatan pengembalian buku.
    </p>
    <p>
        Total Denda: Rp <?= number_format($total_denda, 0, ',', '.'); ?>
    </p>
<?php endif; ?>

</body>
</html>