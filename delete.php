<?php
session_start();
include_once("config.php");
 

$no = $_GET['no'];
 

$result = mysqli_query($mysqli, "DELETE FROM mahasiswati WHERE no=$no");
 

header("Location:index.php");
    if ($result) {
        $_SESSION['alert_message'] = "Sukses Hapus Data Mahasiswa!";
        $_SESSION['alert_type'] = "danger";
    } else {
        $_SESSION['alert_message'] = "Error: " . mysqli_error($mysqli);
        $_SESSION['alert_type'] = "danger";
    }
?>