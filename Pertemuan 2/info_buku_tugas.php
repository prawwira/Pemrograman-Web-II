<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manipulasi String - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Data Buku Perpustakaan</h1>

    <?php
    // Data buku dalam array
    $books = [
        [
            "judul" => "pemrograman web dengan php dan mysql",
            "pengarang" => "BUDI RAHARJO",
            "deskripsi" => "Buku ini membahas pemrograman web menggunakan PHP dan MySQL secara lengkap",
            "kategori" => "Programming",
            "bahasa" => "Indonesia",
            "halaman" => 320,
            "berat" => 500
        ],
        [
            "judul" => "belajar database mysql untuk pemula",
            "pengarang" => "ANDI SETIAWAN",
            "deskripsi" => "Panduan dasar memahami database MySQL dengan mudah",
            "kategori" => "Database",
            "bahasa" => "Indonesia",
            "halaman" => 250,
            "berat" => 400
        ],
        [
            "judul" => "modern web design with html css",
            "pengarang" => "JOHN DOE",
            "deskripsi" => "Learn modern web design using HTML and CSS",
            "kategori" => "Web Design",
            "bahasa" => "Inggris",
            "halaman" => 280,
            "berat" => 450
        ],
        [
            "judul" => "advanced php programming",
            "pengarang" => "MICHAEL SMITH",
            "deskripsi" => "Deep dive into advanced PHP programming techniques",
            "kategori" => "Programming",
            "bahasa" => "Inggris",
            "halaman" => 400,
            "berat" => 600
        ]
    ];

    // fungsi warna badge
    function badgeColor($kategori) {
        switch($kategori) {
            case "Programming": return "primary";
            case "Database": return "success";
            case "Web Design": return "warning";
            default: return "secondary";
        }
    }
    ?>

    <div class="row">
        <?php foreach($books as $buku): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    
                    <div class="card-header">
                        <span class="badge bg-<?php echo badgeColor($buku['kategori']); ?>">
                            <?php echo $buku['kategori']; ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <p><strong>Judul:</strong> <?php echo ucwords($buku['judul']); ?></p>
                        <p><strong>Pengarang:</strong> <?php echo ucwords(strtolower($buku['pengarang'])); ?></p>
                        <p><strong>Deskripsi:</strong> <?php echo ucfirst($buku['deskripsi']); ?></p>

                        <hr>

                        <p><strong>Bahasa:</strong> <?php echo $buku['bahasa']; ?></p>
                        <p><strong>Jumlah Halaman:</strong> <?php echo $buku['halaman']; ?> halaman</p>
                        <p><strong>Berat:</strong> <?php echo $buku['berat']; ?> gram</p>

                        <hr>

                        <!-- Manipulasi string -->
                        <p><strong>Uppercase:</strong> <?php echo strtoupper($buku['judul']); ?></p>
                        <p><strong>Panjang Judul:</strong> <?php echo strlen($buku['judul']); ?> karakter</p>
                        <p><strong>Jumlah Kata:</strong> <?php echo str_word_count($buku['judul']); ?> kata</p>
                        <p><strong>20 Karakter Deskripsi:</strong> <?php echo substr($buku['deskripsi'],0,20) . "..."; ?></p>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>