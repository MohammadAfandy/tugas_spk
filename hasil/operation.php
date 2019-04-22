<?php
require_once('../config/Db.php');
require_once('../components/Helpers.php');
$db = new Db;

$result = [
	'status' => false,
	'message' => 'Terjadi Kesalahan Sistem',
	'data' => [],
];

$post_data = $_POST;

getHasil($db, $post_data['metode']);


function getHasil($db, $metode)
{
	$penilaian = $kriteria = $nilai = $hasil = $dosen_terbaik = null;

	$penilaian = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
                    ->join('tbl_dosen d')
                    ->on('p.id_dosen = d.id')
                    ->all();

	$kriteria = $db->selectQuery('tbl_kriteria')->all();

	if ($penilaian && !Helpers::cekBobotKosong($kriteria)) {
		$nilai = getNilai($penilaian);

		if ($metode === 'saw') {
			$hasil = generateSaw($nilai, $kriteria);
		} else if ($metode === 'wp') {
			$hasil = generateWp($nilai, $kriteria);
		}

		// $dosen_terbaik = getDosenTerbaik($hasil, $metode);

	}

	return [
		'penilaian' => $penilaian,
		'kriteria' => $kriteria,
		'nilai' => $nilai,
		'hasil' => $hasil,
		'dosen_terbaik' => $dosen_terbaik,
	];
}

function getNilai($penilaian)
{
	$nilai = [];

	foreach ($penilaian as $pen) {
		$nilai[$pen->id] = json_decode($pen->nilai, true);
	}

	return $nilai;
}

function generateSaw($nilai, $kriteria)
{
	$normalisasi = getNormalisasi($nilai, $kriteria);
	var_dump($normalisasi);die();
	$rank = $this->getRank($normalisasi, $kriteria, $jenis_bobot);

	return [
		'normalisasi' => $normalisasi,
		'rank' => $rank,
	];
}

function getNormalisasi($nilai, $kriteria)
{
	var_dump($nilai, $kriteria);die();
	$normalisasi = [];
	$min_max = [];

	foreach ($nilai as $key => $nil) {
		foreach ($nil as $k => $n) {
			$min_max[$k][] = $n;
		}
	}

	foreach ($min_max as $k => $m) {
		$min_max[$k] = ($kriteria[$k]->tipe == "COST") ? min($m) : max($m);
	}

	foreach ($nilai as $key => $nil) {
		foreach ($nil as $k => $n) {
			$normalisasi[$key][$k] = ($kriteria[$k]->tipe == "COST") ? $min_max[$k] / $n : $n / $min_max[$k];  
		}
	}

	return $normalisasi;
}

echo json_encode($result);