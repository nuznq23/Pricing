<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed body-masuk">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">INVENT.ID</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
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
                             <a class="nav-link" href="riwayat.php"> 
                                <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div> 
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
                                <div class="container">
                                <h2>Stock Barang Masuk</h2>
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang Masuk
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $ambilsemuadatastock = mysqli_query($conn, "SELECT m.tanggal, s.namabarang, m.qyt, m.keterangan FROM masuk m JOIN stock s ON s.idbarang = m.idbarang WHERE s.status_aktif = 1 ORDER BY m.tanggal DESC"); // PERUBAHAN DI SINI
                                                while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                    $tanggal = $data['tanggal'];
                                                    $namabarang = $data['namabarang'];
                                                    $qyt = $data['qyt'];
                                                    $keterangan = $data['keterangan'];

                                                 ?>
                                            <tr>
                                                <td><?=$tanggal?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$qyt;?></td>
                                                <td><?=$keterangan;?></td>
                                            </tr>
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

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang Masuk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">

        <select name="barangnya" class="form-control">
    <?php
    // Hanya ambil barang yang statusnya aktif (status_aktif = 1)
    $ambilsemuadatanya = mysqli_query($conn, "select * from stock WHERE status_aktif = 1");
    while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
        $namabarangnya = $fetcharray['namabarang'];
        $idbarangnya = $fetcharray['idbarang'];
    ?>
    <option value= "<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
    <?php
        }
    ?>
    </select>
        <br>
        <input type="number" name="qyt" class="form-control" placeholder="Quantity" required min="0">
        <br>
        <input type="text" name="penerima" class="form-control" placeholder="Penerima" required>
        <br>
        <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
        </div>
        </form>
        
        </div>
      </div>
     </div>
        
      </div>
    </div>
  </div>
  
</html>
