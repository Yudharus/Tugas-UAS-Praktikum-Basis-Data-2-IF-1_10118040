<?php
    //koneksi database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "akademik";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die (mysqli_error($koneksi));

    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //pengujian apakah data akan diedit / disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan diedit
       
             $edit = mysqli_query($koneksi, " UPDATE data_mahasiswa set
                                              nim = '$_POST[tnim]',
                                              nama = '$_POST[tnama]',
                                              alamat = '$_POST[talamat]',
                                              jenis_kelamin = '$_POST[tkelamin]',
                                              kelas = '$_POST[tkelas]'
                                              WHERE nim = '$_GET[nim]'
                                            ");
             if($edit) //edit sukses
             {
                 echo "<script>
                 alert('edit data sukses!');
                 document.location='index.php';
                 </script>";
             }
             else
             {
                 echo "<script>
                 alert('edit data gagal!');
                 document.location='index.php';
                 </script>";
             }
        }
        else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO data_mahasiswa (nim, nama, alamat, jenis_kelamin, kelas)
            VALUES ('$_POST[tnim]',
                   '$_POST[tnama]',
                   '$_POST[talamat]',
                   '$_POST[tkelamin]',
                   '$_POST[tkelas]')
                          ");
            if($simpan) //simpan sukses
            {
                echo "<script>
                alert('simpan data sukses!');
                document.location='index.php';
                </script>";
            }
            else
            {
                echo "<script>
                alert('simpan data gagal!');
                document.location='index.php';
                </script>";
            }
        }

       
    }

    //pengujian jika tombol edit atau hapus di klik
    if(isset($_GET['hal']))
    {
        //pengujian edit data
        if($_GET['hal'] == "edit")
        {
            //tampil data yang akan di edit
            $tampil = mysqli_query($koneksi, "SELECT * FROM data_mahasiswa WHERE nim = '$_GET[nim]'");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan,maka data ditampung ke variabel 
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vjenis_kelamin = $data['jenis_kelamin'];
                $vkelas = $data['kelas'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE  FROM data_mahasiswa WHERE nim = '$_GET[nim]' ");
            if($hapus)
            {
                echo "<script>
                        alert('hapus data sukses!');
                        document.location='index.php';
                      </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tugas Pengganti UAS Praktikum Basis Data 2 </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <h1 class="text-center"> Moch Yudha Rusdian </h1>
    <h2 class="text-center"> 10118040 </h2>
    <h2 class="text-center"> IF-1 </h2>
<!-- awalcard form -->
<div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Form input Data mahasiswa
  </div>
  <div class="card-body">
        <form method="post" action="">
            <div class="form-group">
                <label>nim</label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input Nim">
            </div>
            <div class="form-group">
                <label>nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama">
            </div>
            <div class="form-group">
                <label>alamat</label>
                <textarea class="form-control" name="talamat" placeholder="Input Alamat"><?=@$valamat?></textarea>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="tkelamin"> 
                    <option value="<?=@$vjenis_kelamin?>"> <?=@$vjenis_kelamin?> </option>
                    <option value="laki-laki">laki-laki</option>
                    <option value="perempuan">perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="tkelas" value="<?=@$vkelas?>" class="form-control" placeholder="Input Kelas">
            </div>
            
            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

        </form>    
    </div>
</div>    
<!-- akhir card form -->
<!-- awalcard tabel -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Data Mahasiswa
  </div>
  <div class="card-body">
        
        <table class="table table-bordered table-stripped">
            <tr>
                <th>nim</th>
                <th>nama</th>
                <th>alamat</th>
                <th>jenis kelamin</th>
                <th>kelas</th>
                <th>Aksi</th>
            </tr>
            <?php
                $nim = 1;
                $tampil = mysqli_query($koneksi, "SELECT* FROM data_mahasiswa order by nim desc");
                while ($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
                <td> <?=$data['nim']?> </td>
                <td> <?=$data['nama']?> </td>
                <td> <?=$data['alamat']?>  </td>
                <td> <?=$data['jenis_kelamin']?> </td>
                <td> <?=$data['kelas']?> </td>
                <td> 
                    <a href ="index.php?hal=edit&nim=<?=$data['nim']?>" class="btn btn-warning">Edit </a>
                    <a href ="index.php?hal=hapus&nim=<?=$data['nim']?>" 
                    onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">hapus </a>
                </td>
            </tr>
                <?php endwhile; //penutup perulangan while ?>
        </table>

    </div>
</div>    
<!-- akhircard table -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"> </sript>
</body>
</html>