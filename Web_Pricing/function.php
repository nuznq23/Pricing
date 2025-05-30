<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "pricing");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = 0;

    $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock) values('$namabarang', '$deskripsi', '$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};


//menambah barang masuk

if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qyt = $_POST['qyt'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qyt;


    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qyt) values ('$barangnya', '$penerima', '$qyt')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang= '$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}





//menambah barang keluar

if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qyt = $_POST['qyt'];
    $status_penjualan = $_POST['status_terjual']; // Ambil nilai dari dropdown baru

    // Cek stock sekarang
    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qyt;

    // Tambahkan validasi untuk stock (opsional tapi disarankan)
    if ($qyt > $stocksekarang) {
        echo 'Stock tidak mencukupi.';
        header('location:keluar.php'); // Redirect kembali jika stock tidak cukup
        exit(); // Hentikan eksekusi script
    }

    // Insert ke tabel keluar. Pastikan urutan kolom sesuai dengan tabel 'keluar' Anda.
    // Asumsi tabel 'keluar' memiliki kolom id, tanggal, idbarang, penerima, qyt, status_penjualan
    // Jika kolom 'tanggal' otomatis diisi oleh database, Anda tidak perlu memasukkannya di query.
    // Jika tidak, Anda perlu menambahkannya: insert into keluar (tanggal, idbarang, penerima, qyt, status_penjualan) values(NOW(), '$barangnya', '$penerima', '$qyt', '$status_penjualan')
    $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qyt, status_penjualan) values ('$barangnya', '$penerima', '$qyt', '$status_penjualan')");

    // Update stock di tabel stock
    $updatestock = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang= '$barangnya'");

    if($addtokeluar && $updatestock){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}


// Mengubah status barang menjadi tidak aktif (Soft Delete)
if(isset($_POST['hapusbarang'])){
    $idbarang = $_POST['idb'];

    // Query UPDATE untuk mengubah status_aktif menjadi 0
    $update_status = mysqli_query($conn, "UPDATE stock SET status_aktif = 0 WHERE idbarang='$idbarang'");

    if($update_status){
        header('location:index.php'); // Redirect kembali ke halaman dashboard
        exit();
    } else {
        echo 'Gagal mengupdate status barang: ' . mysqli_error($conn);
        exit();
    }
}

?>
