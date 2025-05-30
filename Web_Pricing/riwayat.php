<?php
require 'function.php';
require 'cek.php'; // Pastikan file cek.php Anda berfungsi untuk otentikasi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Riwayat Transaksi</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed body-riwayat">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">INVENT.ID</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-down"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-up"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link active" href="riwayat.php"> <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Transaksi
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="container">
    <h2 class="d-inline-block">Riwayat Transaksi Barang</h2>
</div>
                        <div class="card-body">
                            <div class="table-responsive" style="height: 480px; overflow-y: scroll;">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Tipe Transaksi</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan/Penerima</th>
                                            <th>Status (Keluar)</th> </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Mengambil semua data dari masuk dan keluar, gabungkan dengan stock
                                        $query_masuk = "SELECT m.tanggal, s.namabarang, 'Masuk' AS tipe_transaksi, m.qyt, m.keterangan AS keterangan_penerima, NULL AS status_penjualan
                                                        FROM masuk m JOIN stock s ON s.idbarang = m.idbarang";

                                        $query_keluar = "SELECT k.tanggal, s.namabarang, 'Keluar' AS tipe_transaksi, k.qyt, k.penerima AS keterangan_penerima, k.status_penjualan
                                                        FROM keluar k JOIN stock s ON s.idbarang = k.idbarang";

                                        // Gabungkan kedua query (UNION ALL)
                                        // Penting: jumlah kolom dan tipe harus sama
                                        $ambilsemuatransaksi = mysqli_query($conn, "($query_masuk) UNION ALL ($query_keluar) ORDER BY tanggal DESC");

                                        while($data=mysqli_fetch_array($ambilsemuatransaksi)){
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $tipe_transaksi = $data['tipe_transaksi'];
                                            $jumlah = $data['qyt'];
                                            $keterangan_penerima = $data['keterangan_penerima'];
                                            $status_penjualan = $data['status_penjualan'];
                                        ?>
                                        <tr>
                                            <td><?=$tanggal?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$tipe_transaksi;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td><?=$keterangan_penerima;?></td>
                                            <td><?=$status_penjualan ?: '-';?></td> </tr>
                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>
</html>