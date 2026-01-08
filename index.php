<?php

include_once("config.php");

if(isset($_GET['search'])){
    $cari = $_GET['search'];
    $result = mysqli_query($mysqli, "SELECT * FROM mahasiswati where nama like '%".$cari."%' OR nim like '%".$cari."%'");				
}else{
    $result = mysqli_query($mysqli, "SELECT * FROM mahasiswati ORDER BY no ASC");		
}

?>

<html>
<head>    
    <title>INDEX TABEL MAHASISWA</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
 
<body class="bg-secondary">
    <div class="container px-4 mt-4">
        <?php
            if (isset($_SESSION['alert_message'])) {
                $message = $_SESSION['alert_message'];
                $type = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'info'; // Default type
                echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION['alert_message']); // Clear the message after displaying
                unset($_SESSION['alert_type']);
            }
        ?>
        <div class="row">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <span class='fa fa-plus'></span> Tambah data mahasiswa
                </button>
            </div>
            <div class="col-md-6">
                <form action="index.php" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan NIM atau Nama" name="search">
                        <button class="btn btn-primary" type="submit" name="Submit"><span class='fa fa-search'></span> Cari</button>
                        <a class="btn btn-light" href="/php-db/">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card px-2 mt-2">
            <table border=2 id="hasil-pencarian" class="table table-bordered mt-2 px-2">
        
            <tr class="bg-dark text-white">
                <th>NIM</th> <th>Nama</th> <th>Umur</th> <th>Jenis Kelamin</th> <th>Sekolah Asal</th> <th>Manage Data</th>
            </tr>
            <?php  
            while($user_data = mysqli_fetch_array($result)) {         
                echo "<tr><a data-bs-toggle='modal' data-bs-target='#showModal$user_data[no]'>";
                echo "<td>".$user_data['nim']."</td>";
                echo "<td>".$user_data['nama']."</td>";
                echo "<td>".$user_data['umur']." <small>tahun</small></td>";
                if($user_data['jeniskelamin'] == 'laki-laki')
                    echo "<td><span class='fa fa-male'></span> Laki-laki</td>";
                else
                    echo "<td><span class='fa fa-female'></span> Perempuan</td>";
                echo "<td>".$user_data['sekolahasal']."</td>";     
                echo "<td>
                <button type='button' class='badge bg-primary' data-bs-toggle='modal' data-bs-target='#showModal$user_data[no]'>
                    <span class='fa fa-eye'></span> Details
                </button>";
                if(!isset($_SESSION["user"])){
                echo "
                <button type='button' class='badge bg-success' data-bs-toggle='modal' data-bs-target='#editModal$user_data[no]'>
                    <span class='fa fa-pencil'></span> Edit
                </button>
                <a class='badge bg-danger' href='delete.php?no=$user_data[no]' onClick=\"javascript: return confirm('ingin hapus data Mahasiswa : $user_data[nim]');\"><span class='fa fa-trash'></span> Delete</a></td></a></tr>";
                }else{}
                //MODAL SHOW
                echo "<div class='modal fade' id='showModal$user_data[no]' tabindex='-1' aria-labelledby='showModalLabel' aria-hidden='true'>";
                echo "  <div class='modal-dialog'>";
                echo "    <div class='modal-content'>";
                echo "      <div class='modal-header'>";
                echo "        <h5 class='modal-title' id='showModalLabel'><span class='fa fa-eye'></span> Detail Data Mahasiswa</h5>";
                echo "      </div>";
                echo "      <div class='modal-body'>";
                echo "        <p><strong>NIM :</strong> $user_data[nim]</p>";
                echo "        <p><strong>Nama :</strong> $user_data[nama]</p>";
                echo "        <p><strong>Umur :</strong> $user_data[umur] <small>tahun</small></p>";
                if($user_data['jeniskelamin'] == 'laki-laki')
                    echo "        <p><strong>Jenis Kelamin :</strong> <span class='fa fa-male'></span> Laki-laki</p>";
                else
                    echo "        <p><strong>Jenis Kelamin :</strong> <span class='fa fa-female'></span> Perempuan</p>";
                echo "        <p><strong>Sekolah Asal :</strong> $user_data[sekolahasal]</p>";   
                echo "      </div>";
                echo "      <div class='modal-footer'>";
                echo "        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                echo "      </div>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
                
                //MODAL EDIT
                echo'<div class="modal fade" id="editModal'.$user_data['no'].'" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"><span class="fa fa-pencil"></span> Edit Data Mahasiswa</h5>
                    </div>
                    <div class="modal-body">
                        <form action="edit.php?no='.$user_data['no'].'" method="post" name="update_user">
                                    <label for="nim">NIM</label>
                                    <input class="form-control" type="number" name="nim" maxlength="12" value="'.$user_data['nim'].'">

                                    <label for="nama">Nama</label>
                                    <input class="form-control" type="text" name="nama" value="'.$user_data['nama'].'">

                                    <label for="umur">Umur</label>
                                    <input class="form-control" type="number" name="umur" maxlength="2" value="'.$user_data['umur'].'">

                                    <label for="jk">Jenis Kelamin:</label>
                                    
                                        <select class="form-control" id="jk" name="jeniskelamin">
                                            <option '.($user_data['jeniskelamin'] == "laki-laki" ? 'selected="selected"' :'').' value="laki-laki">Laki-Laki</option>
                                            <option '.($user_data['jeniskelamin'] == "perempuan" ? 'selected="selected"' :'').' value="perempuan">Perempuan</option>
                                        </select>

                                    <label for="sekolahasal">Sekolah Asal</label>
                                    <input class="form-control" type="text" name="sekolahasal" value="'.$user_data['sekolahasal'].'">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="hidden" name="no" value="'.$user_data['no'].'">
                                <input class="btn btn-success" type="submit" name="Submit" value="Edit">
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>';
            }
            ?>
            </table>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel"><span class='fa fa-plus'></span> Tambah Data Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="add.php" method="post" name="form1">
            <table border="0">
                <tr> 
                    <td>NIM</td>
                    <td><input class="form-control" type="number" name="nim" maxlength="12"></td>
                </tr>
                <tr> 
                    <td>Nama</td>
                    <td><input class="form-control" type="text" name="nama"></td>
                </tr>
                <tr> 
                    <td>Umur</td>
                    <td><input class="form-control" type="number" name="umur" maxlength="2"></td>
                </tr>
                <tr> 
                    <td><label for="jk">Jenis Kelamin:</label></td>
                    <td>
                        <select class="form-control" id="jk" name="jeniskelamin">
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr> 
                    <td>Sekolah Asal</td>
                    <td><input class="form-control" type="text" name="sekolahasal"></td>
                </tr>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input class="btn btn-primary" type="submit" name="Submit" value="Add">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html>