<?php

require_once "../config.php";
require_once "../helpers/response.php";

//mahasiswa.php?nim=7
// get by id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $q = "SELECT 
            m.id, 
            m.nama, 
            m.nim, 
            j.nama_jurusan AS jurusan 
            FROM mahasiswa m 
            LEFT JOIN jurusan j ON m.jurusan_id = j.id 
            where m.id ='$id'";

    $r = mysqli_query($koneksi, $q);

    if (!$r)  {
        sendResponse(
            false, 
            "query gagal: " . mysqli_error($koneksi), 
            null, 
            500
            );
        }

        $data = mysqli_fetch_assoc($r);

    if (!$data) {
            sendResponse(false, "mahasiswa tidak 
            ditemukan", null, 404);
        }
        sendResponse(true, "berhasil", $data, 200);
}

//search
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    
    $q = "SELECT 
            m.id, 
            m.nama, 
            m.nim, 
            j.nama_jurusan AS jurusan 
            FROM mahasiswa m 
            LEFT JOIN jurusan j 
            ON m.jurusan_id = j.id 
            where m.nama LIKE '%$search%'
            OR m.nim LIKE '%$search%'
            ORDER BY m.id DESC";

    $r = mysqli_query($koneksi, $q);

    if (!$r)  {
        sendResponse(
            false, 
            "query gagal: " . mysqli_error($koneksi), 
            null, 
            500
            );
        }

        $data = [];

    while ($row = mysqli_fetch_assoc($r)) {
            $data[] = $row;
    }   
        sendResponse(true, 
        "berhasil", 
        $data, 
        200);
}