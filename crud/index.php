<?php
	//koneksi database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "ruangsimulasi";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//pengujian apakah data akan diedit/simpan baru
		if($_GET['hal'] == "edit")
		{
			//data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE member set
											 	nama = '$_POST[tnama]',
											 	paketbelajar = '$_POST[tpaketbelajar]',
											 	telp = '$_POST[ttelp]',
											 	email = '$_POST[temail]'
											 WHERE nip = '$_GET[id]'	
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit Data Sukses !');
						document.location='index.php';
				</script>";
			}
			else
			{
				echo "<script>
						alert('Edit Data Gagal !');
						document.location='index.php';
				</script>";
			}
		}else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO member (nama, paketbelajar, telp, email)
										  VALUES ('$_POST[tnama]', 
										  		 '$_POST[tpaketbelajar]', 
										  		 '$_POST[ttelp]', 
										  		 '$_POST[temail]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan Data Sukses !');
						document.location='index.php';
				</script>";
			}
			else
			{
				echo "<script>
						alert('Simpan Data Gagal !');
						document.location='index.php';
				</script>";
			}
		}


		
	}


	//pengujian jika tombol edit/hapus diklik
	if(isset($_GET['hal']))
	{
		//pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM member WHERE nip = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan, maka data ditampung kedalam variabel
				$vnama = $data['nama'];
				$vpaketbelajar = $data['paketbelajar'];
				$vtelp = $data['telp'];
				$vemail = $data['email'];			
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM member WHERE nip = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Sukses !');
						document.location='index.php';
				</script>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>bismillah crud tuntas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">


	<h1 class="text-center">REGISTRASI CALON SISWA</h1>
	<h2 class="text-center">@RuangSimulasi</h2>

	<!-- awal card form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Siswa RuangSimulasi
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="masukkan nama anda !" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Paket Belajar</label>
	    		<select class="form-control" name="tpaketbelajar">
	    			<option value="<?=@$vpaketbelajar?>"><?=@$vpaketbelajar?></option>
	    			<option value="Reguler">Reguler</option>
	    			<option value="Express">Express</option>
	    			<option value="VVIP">VVIP</option>
	    		</select>
	    	</div>
	    	<div class="form-group">
	    		<label>No Telp</label>
	    		<input type="text" name="ttelp" value="<?=@$vtelp?>" class="form-control" placeholder="masukkan nomor telp anda !" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Email</label>
	    		<input type="text" name="temail" value="<?=@$vemail?>" class="form-control" placeholder="masukkan email anda !" required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- akhir card form -->

	<!-- awal card tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Siswa RuangSimulasi
	  </div>
	  <div class="card-body">

	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No</th>
	  			<th>Nama</th>
	  			<th>Paket Belajar</th>
	  			<th>No Telp</th>
	  			<th>Email</th>
	  			<th>Aksi</th>
	  		</tr>
	  		<?php
	  			$no = 1;
	  			$tampil = mysqli_query($koneksi, "SELECT * from member order by nip desc");
	  			while($data = mysqli_fetch_array($tampil)) :

	  		?>
	  		<tr>
	  			<td><?=$no++;?></td>
	  			<td><?=$data['nama']?></td>
	  			<td><?=$data['paketbelajar']?></td>
	  			<td><?=$data['telp']?></td>
	  			<td><?=$data['email']?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['nip']?>" class="btn btn-warning"> Edit </a>
	  				<a href="index.php?hal=hapus&id=<?=$data['nip']?>" 
	  				   onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	  			</td>
	  		</tr>
	  	<?php endwhile; //penutup perulangan while?>
	  	</table>
	    
	  </div>
	</div>
	<!-- akhir card tabel -->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>