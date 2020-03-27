<?php

// ambil nilai-nilai variable di koneksi.php
include('koneksi.php');

// membuat koneksi ke database MYSQL
$connection = mysqli_connect($server, $username, $password, $database);
// membuat variable untuk JSON
$hasil = array();    
$result = false;
$code = "000";
$message = "";

// Store NILAI dari Metode POST ----- NEW
$alamat = $_POST['carialamat'];

// cek apakah koneksi error, jika error maka keluar dari script test1.php menggunakan return
// tampilkan pesan error
if( !$connection)
{
    return;
}

// jika tidak error maka code-code di bawah ini akan di akses
// 1. membuat query 
$query = "SELECT * FROM m_mahasiswa WHERE alamat = '$alamat'";
// 2. eksekusi query ke DB melalui connection
$result = mysqli_query($connection, $query);
// 3. cek apakah data lebih dari 0
if( mysqli_num_rows($result) > 0)
{    
    // 4. tarik data setiap rows, store ke $rows dari fungsi dengan parameter $result    
    while($rows = mysqli_fetch_assoc($result))
    {
        // 5. simpan variable $rows untuk masing-masing data ke array $hasil
        $hasil[] = array(
            "NPM" => $rows['npm'],
            "Nama" => $rows['nama'],
            "Domisili" => $rows['alamat']
        );
    }

    // 5.b. Set nilai penyerta untuk JSON
    $result = true;
    $code = 800;        
}
else    // jika tidak ada data, <= 0 data
{
    $result = true;
    $code = 801;
    $message = $hasil;
}

// 6. Tampilkan variable array $hasil ke dalam bentuk JSON menggunakan 
// json_encode(var);    
echo json_encode(
    array(
        "result"=>$result,
        "code" => $code,
        "message" => $hasil
    )  
);

?>