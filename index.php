<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Intruksi Kerja Nomor 1 CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<title>Hitung Biaya Parkir Mall</title>
</head>

<body>
	<div class="container border">
		<!-- Instruksi Kerja Nomor 2. -->
		<!-- Menampilkan logo Mall -->
		<img src="img/logo.png" alt="Logo Parkir Mall" class="float-left">


		<h2 class="mb-5">Hitung Biaya Parkir Mall</h2>
		<br>
		<form action="index.php" method="post" id="formPerhitungan">
			<div class="row mt-5">
				<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat"></div>
			</div>

			<div class="row">
				<!-- Masukan pilihan jenis kendaraan. -->
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
					<?php
					// Instruksi kerja nomor 3
					$jenis_kendaraan = array("Truk", "Motor", "Mobil");

					// Instruksi kerja nomor 4
					sort($jenis_kendaraan);

					// Instrukti kerja nomor 5
					foreach ($jenis_kendaraan as $kendaraan) {
					?>
						<input type="radio" name="kendaraan" id="kendaraan" value="<?= $kendaraan; ?>"><?= $kendaraan; ?> <br>
					<?php
					}

					?>


				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Masuk Kendaraan -->
				<div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
				<div class="col-lg-2">
					<select id="masuk" name="masuk">
						<option value="">- Jam Masuk -</option>

						<!-- Instruksi Kerja Nomor 6 -->

						<?php
						for ($jam = 1; $jam <= 24; $jam++) {
							echo "<option value='" . $jam . "'>" . $jam . "</option>";
						}
						?>

					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Keluar Kendaraan. -->
				<div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
				<div class="col-lg-2">
					<select id="keluar" name="keluar">
						<option value="">- Jam Keluar -</option>

						<!-- Instruksi Kerja Nomor 6 -->

						<?php
						for ($jam = 1; $jam <= 24; $jam++) {
							echo "<option value='" . $jam . "'>" . $jam . "</option>";
						}
						?>


					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan pilihan Member. -->
				<div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
				<div class="col-lg-2">
					<input type='radio' name='member' value='Member'> Member <br>
					<input type='radio' name='member' value='Non-Member'> Non Member <br>

				</div>
			</div>

			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button></div>
				<div class="col-lg-2"></div>
			</div>
		</form>
	</div>

	<?php

	if (isset($_POST['hitung'])) {

		// variabel dibawah ini diambil dari yang sudah dikirimkan di form menggunakan method post
		$plat = $_POST['plat'];
		$kendaraan = $_POST['kendaraan'];
		$masuk = $_POST['masuk'];
		$keluar = $_POST['keluar'];
		$member = $_POST['member'];



		// Instruksi Kerja Nomor 7 (hitung durasi)
		// variabel keluar dan variabel masuk diambil dari $_POST['masuk'] dan $_POST['keluar']
		$durasi = $keluar - $masuk;



		// Instruksi Kerja Nomor 8 (fungsi)
		// fungsi ini untuk menghitung biaya parkir kendaraan berdasarkan durasi dan jenis kendaraan
		function hitung_parkir($durasi, $kendaraan)
		{
			$biaya = 0;
			// Instruksi Kerja Nomor 9 (kontrol percabangan)
			if ($kendaraan == "Mobil") {
				// $biaya = jam pertama + jam berikutnya[(durasi - jam pertama=1) * harga jam berikutnya]
				$biaya = 5000 + ($durasi - 1) * 3000;
			} elseif ($kendaraan == "Motor") {
				$biaya = 2000 + ($durasi - 1) * 1000;
			} elseif ($kendaraan == "Truk") {
				$biaya = 6000 * $durasi;
			} else {
				$biaya = 0;
			}

			// mengembalikan variabel $biaya
			return $biaya;
		}

		// Instruksi Kerja Nomor 10 ($biaya_parkir)
		$biaya_parkir = hitung_parkir($durasi, $kendaraan);


		// Instruksi Kerja Nomor 11 (hitung diskon dan simpal hasil akhir setelah diskon pada variabel $biaya_akhir)
		if ($member == "Member") {
			// 0.1 = 10%
			$diskon = 0.1;
		} else {
			$diskon = 0;
		}

		// hasil perhitungan setelah diskon
		$biaya_akhir = $biaya_parkir - ($biaya_parkir * $diskon);


		$dataParkir = array(
			'plat' => $_POST['plat'],
			'kendaraan' => $_POST['kendaraan'],
			'masuk' => $_POST['masuk'],
			'keluar' => $_POST['keluar'],
			'durasi' => $durasi,
			'member' => $_POST['member'],
		);

		// Instruksi Kerja Nomor 12 (menyimpan ke json)
		$berkas = "data/data.json";
		$dataJson = json_encode($dataParkir);
		file_put_contents($berkas, $dataJson);
		$dataJson = file_get_contents($berkas);
		$dataParkir = json_decode($dataJson, true);


		//	Menampilkan data parkir kendaraan.
		//  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
		echo "
		<br/>
		<div class='container'>
		<div class='row'>
		<!-- Menampilkan Plat Nomor Kendaraan. -->
		<div class='col-lg-2'>Plat Nomor Kendaraan:</div>
		<div class='col-lg-2'>" . $dataParkir['plat'] . "</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Kendaraan. -->
		<div class='col-lg-2'>Jenis Kendaraan:</div>
		<div class='col-lg-2'>" . $dataParkir['kendaraan'] . "</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Durasi Parkir. -->
		<div class='col-lg-2'>Durasi Parkir:</div>
		<div class='col-lg-2'>" . $dataParkir['durasi'] . " jam</div>
		</div>
		<div class='row'>
		<!-- Menampilkan Jenis Keanggotaan. -->
		<div class='col-lg-2'>Keanggotaan:</div>
		<div class='col-lg-2'>" . $dataParkir['member'] . " </div>
		</div>
		<div class='row'>
		<!-- Menampilkan Total Biaya Parkir. -->
		<div class='col-lg-2'>Total Biaya Parkir:</div>
		<div class='col-lg-2'>Rp" . number_format($biaya_akhir, 0, ".", ".") . ",-</div>
		</div>

		</div>
		";
	}
	?>

</body>

</html>
