<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class = "container mt-5">
        <h1 class="mb-4"> <i class="bi bi-book"> <i/> Array Data Buku Perpustakaan</h1>

        <?php
        // 1. ARRAY INDEXED - Daftar Buku
        $judul_buku = [
            "Pemrograman PHP Untuk Pemula",
            "Mastering MySQL Database",
            "Laravel Framework Advanced",
            "JavaScript Fundamentals",
            "Web Design Principles"
        ];
        ?>

        <!-- Array Indexed -->
         <div class="car mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">1. Array Indexed - Daftar Judul Buku</h5>
            </div>

            <div class="card-body">
                <p><strong>Total Buku :</strong> <?php echo count($judul_buku); ?></p>
                <ol>
                    <?php foreach ($judul_buku as $index => $judul) : ?>
                        <li><?php echo $judul; ?></li>
                    <?php endforeach; ?>
                </ol>

                <hr>

                <h6>Akses Elemen Spesifik :</h6>
                <ul>
                    <li>Buku Pertama : <strong><?php echo $judul_buku[0]; ?></strong></li>
                    <li>Buku Ketiga : <strong><?php echo $judul_buku[2]; ?></strong></li>
                    <li>Buku Terakhir : <strong><?php echo $judul_buku[0]; ?></strong></li>
                </ul>

            </div> 
         </div>
    </div>

    <?php
    // 2. ARRAY ASSOCIATIVE - Data Buku Lengkap
    $buku1 = [
        "kode" => "BK-001",
        "judul" => "Pemrograman PHP Untuk Pemula",
        "kategori" => "Pemrograman",
        "pengarang" => "Andi Setiawan",
        "penerbit" => "Informatika",
        "tahun" => 2023,
        "isbn" => "978-602-1234-56-7",
        "harga" => 75000,
        "stok" => 10,
        "bahasa" => "Indonesia"
    ];
    ?>
    
    <!-- Array Associative -->
     <div class="card mb-4">
        <div class="card-header bg-succes text-white"></div>
     </div>
</body>
</html>