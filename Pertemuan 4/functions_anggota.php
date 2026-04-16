<?php
// functions_anggota.php

// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $jumlah = 0;
    foreach ($anggota_list as $anggota) {
        if (isset($anggota['status']) && $anggota['status'] === 'Aktif') {
            $jumlah++;
        }
    }
    return $jumlah;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    $jumlah = count($anggota_list);

    if ($jumlah === 0) {
        return 0;
    }

    foreach ($anggota_list as $anggota) {
        $total += $anggota['total_pinjaman'] ?? 0;
    }

    return $total / $jumlah;
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if (isset($anggota['id']) && $anggota['id'] === $id) {
            return $anggota;
        }
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    if (empty($anggota_list)) {
        return null;
    }

    $teraktif = $anggota_list[0];

    foreach ($anggota_list as $anggota) {
        if (($anggota['total_pinjaman'] ?? 0) > ($teraktif['total_pinjaman'] ?? 0)) {
            $teraktif = $anggota;
        }
    }

    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $hasil = [];
    foreach ($anggota_list as $anggota) {
        if (isset($anggota['status']) && $anggota['status'] === $status) {
            $hasil[] = $anggota;
        }
    }
    return $hasil;
}

// 7. Function untuk validasi email
function validasi_email($email) {
    if (empty($email)) {
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    $pecah = explode('-', $tanggal);
    if (count($pecah) !== 3) {
        return $tanggal;
    }

    $tahun = $pecah[0];
    $bulan_num = $pecah[1];
    $hari = $pecah[2];

    return $hari . ' ' . ($bulan[$bulan_num] ?? $bulan_num) . ' ' . $tahun;
}

// Bonus 9. Function untuk sort anggota by nama (A-Z)
function sort_anggota_by_nama($anggota_list) {
    usort($anggota_list, function ($a, $b) {
        return strcmp(strtolower($a['nama']), strtolower($b['nama']));
    });
    return $anggota_list;
}

// Bonus 10. Function untuk search anggota by nama (partial match)
function search_anggota_by_nama($anggota_list, $keyword) {
    $hasil = [];
    $keyword = strtolower(trim($keyword));

    foreach ($anggota_list as $anggota) {
        if (strpos(strtolower($anggota['nama']), $keyword) !== false) {
            $hasil[] = $anggota;
        }
    }

    return $hasil;
}
?>