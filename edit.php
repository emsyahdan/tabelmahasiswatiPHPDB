<?php
session_start();
 
$no = $_GET['no'];
if(isset($_POST['Submit']))
{	
	
	$nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $sekolahasal = $_POST['sekolahasal'];
		
	include_once("config.php");
	$result = mysqli_query($mysqli, "UPDATE mahasiswati SET nim='$nim',nama='$nama',umur='$umur',jeniskelamin='$jeniskelamin',sekolahasal='$sekolahasal' WHERE no=$no");
	
	
	header('Location: /php-db/index.php');
    if ($result) {
        $_SESSION['alert_message'] = "Sukses Update Data Mahasiswa!";
        $_SESSION['alert_type'] = "success";
    } else {
        $_SESSION['alert_message'] = "Error: " . mysqli_error($mysqli);
        $_SESSION['alert_type'] = "danger";
    }
}

?>