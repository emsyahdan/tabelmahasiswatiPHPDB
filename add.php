
	<?php
    
	session_start();
	if(isset($_POST['Submit'])) {
		$nim = $_POST['nim'];
		$nama = $_POST['nama'];
        $umur = $_POST['umur'];
        $jeniskelamin = $_POST['jeniskelamin'];
        $sekolahasal = $_POST['sekolahasal'];
		
		
		include_once("config.php");
				
		
		$result = mysqli_query($mysqli, "INSERT INTO mahasiswati(nim,nama,umur,jeniskelamin,sekolahasal) VALUES('$nim','$nama','$umur','$jeniskelamin','$sekolahasal')");
		
		
		header('Location: /php-db/');
        if ($result) {
            $_SESSION['alert_message'] = "Sukses Menambahkan Data Mahasiswa!";
            $_SESSION['alert_type'] = "info";
        } else {
            $_SESSION['alert_message'] = "Error: " . mysqli_error($mysqli);
            $_SESSION['alert_type'] = "danger";
        }
	}
	?>
