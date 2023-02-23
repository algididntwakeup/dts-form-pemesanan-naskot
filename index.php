<?php
	//	Instruksi Kerja Nomor 1.
	//	fungsi dibawah ini mempunyai 2 parameter yg berupa harga dan jumlah  lalu
	// nilai tagihan awal tersebut dikembalikan menggunakan pernyataan return.
		function hitung_tagihan_awal($harga, $jumlah) {
			$tagihan_awal = $harga * $jumlah;
			return $tagihan_awal;
		}
		

	//	Instruksi Kerja Nomor 2.
	//	Variabel $cabang berisi data kota lokasi cabang restoran dalam bentuk array.
	$cabang = array("Harmoni", "Sarinah", "Grogol", "Senayan", "Pluit", "Cempaka");


	//	Instruksi Kerja Nomor 3.
	//	Mengurutkan array $cabang sesuai abjad A-Z.
		sort($cabang); 
    foreach($cabang as $cab)
    {
        // echo $cab; //digunakan jika ingin menampilkan secara langsung urutannya
    }

	//	Instruksi Kerja Nomor 4.
	//	Variabel untuk menyimpan harga satuan nasi kotak.
	$hargaSatuan = 50000;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Form Pemesanan Nasi Kotak</title>
		<!-- Instruksi Kerja Nomor 5. -->
		<!-- Menghubungkan dengan library/berkas CSS. -->
		<link rel="stylesheet" href="./css/bootstrap.css">
	</head>
	
	<body>
	<div class="container border mx-auto">
		<!-- Menampilkan judul halaman -->
		<h3>Form Pemesanan Nasi Kotak</h3>
		
		<!-- Instruksi Kerja Nomor 6. -->
		<!-- Menampilkan logo restoran -->
		<img src="./img/logo.png" alt="terserah" class=" mb-4 mt-3">
		
		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formPemesanan" autocomplete="off">
			<div class="row">
				<!-- Masukan pilihan lokasi cabang resto. -->
				<div class="col-lg-2"><label for="tipe">Cabang:</label></div>
				<div class="col-lg-2">
					<select id="cabang" name="cabang">
					<option value="">- Pilih Cabang -</option>
					<?php foreach ($cabang as $cab): ?>
        				<option value="<?php echo $cab; ?>"><?php echo $cab; ?></option>
    						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="row">
				<!-- Masukan data nama pelanggan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pelanggan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan data nomor HP pelanggan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Nomor HP:</label></div>
				<div class="col-lg-2"><input type="number" id="noHP" name="noHP" maxlength="16"></div>
			</div>
			<div class="row">
				<!-- Masukan data jumlah kotak pesanan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Jumlah Kotak:</label></div>
				<div class="col-lg-2"><input type="number" id="jumlahPesanan" name="jumlahPesanan" maxlength="4"></div>
			</div>
			<div class="row mt-6">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPemesanan" value="Pesan" name="Pesan">Pesan</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
	<?php
		//	Kode berikut dieksekusi setelah tombol Hitung ditekan.
		if(isset($_POST['Pesan'])) {
			
			//	Variabel $dataPesanan berisi data-data pemesanan dari form dalam bentuk array.
			$dataPesanan = array(
				'cabang' => $_POST['cabang'],
				'nama' => $_POST['nama'],
				'noHP' => $_POST['noHP'],
				'jumlahPesanan' => $_POST['jumlahPesanan']
			);
			
			//	Variabel berisi path file data.json yang digunakan untuk menyimpan data pemesanan.
			$berkas = "data.json";
			
			//	Mengubah data pemesanan yang berbentuk array PHP menjadi bentuk JSON.
			$dataJson = json_encode($dataPesanan, JSON_PRETTY_PRINT);
			
			//	Instruksi Kerja Nomor 8.
			//	Menyimpan data pemesanan yang berbentuk JSON ke dalam file JSON
			file_put_contents('./data/data.json',$dataJson);
			
			//	Instruksi Kerja Nomor 9.
			//	Mengambil data pemesanan dari file JSON
			$dataJson = file_get_contents('./data/data.json');
			
			//	Mengubah data pemesanan dalam format JSON ke dalam format array PHP.
			$dataPesanan = json_decode($dataJson, true);

			//	Variabel $tagihanAwal berisi nilai tagihan awal (sebelum diskon) yang dihitung dengan menggunakan fungsi hitung_tagihan_awal().
			$tagihanAwal = hitung_tagihan_awal($dataPesanan['jumlahPesanan'], $hargaSatuan);

			//	Menginisiasi variabel $diskon dengan nilai awal 0.
			
			//	Instruksi Kerja Nomor 10.
			//	Menghitung diskon.
			
			if ($tagihanAwal >= 1000000) {
				$diskon = (5/100) * $tagihanAwal; 
			} else {
				$diskon = 0;
			}
			
			//	Variabel $tagihanAkhir berisi nilai tagihan akhir yang didapat dari nilai tagihan awal dikurangi diskon.
			$tagihanAkhir = $tagihanAwal - $diskon;
			
			//	Menampilkan data pemesanan dan hasil perhitungan diskon dan tagihan.
			echo "
				<br/>
				<div class='container'>
					<div class='row'>
						<!-- Menampilkan lokasi cabang restoran. -->
						<div class='col-lg-2'>Cabang:</div>
						<div class='col-lg-2'>".$dataPesanan['cabang']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan nama pelanggan. -->
						<div class='col-lg-2'>Nama Pelanggan:</div>
						<div class='col-lg-2'>".$dataPesanan['nama']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan nomor HP pelanggan. -->
						<div class='col-lg-2'>Nomor HP:</div>
						<div class='col-lg-2'>".$dataPesanan['noHP']."</div>
					</div>
					<div class='row'>
						<!-- Menampilkan jumlah kotak pesanan. -->
						<div class='col-lg-2'>Jumlah Kotak:</div>
						<div class='col-lg-2'>".$dataPesanan['jumlahPesanan']." box</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tagihan awal (sebelum diskon). -->
						<div class='col-lg-2'>Tagihan Awal:</div>
						<div class='col-lg-2'>Rp".number_format($tagihanAwal, 0, ".", ".").",-</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tarif pemesanan. -->
						<div class='col-lg-2'>Diskon:</div>
						<div class='col-lg-2'>Rp".number_format($diskon, 0, ".", ".").",-</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tagihan akhir (setelah diskon). -->
						<div class='col-lg-2'>Tagihan Akhir:</div>
						<div class='col-lg-2'>Rp".number_format($tagihanAkhir, 0, ".", ".").",-</div>
					</div>
			</div>
			";
		}
	?>
	</body>
</html>