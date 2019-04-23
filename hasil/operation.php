<?php
require_once('../config/Db.php');
require_once('../components/Helpers.php');

$result = [
	'status' => false,
	'message' => 'Terjadi Kesalahan Sistem',
	'data' => [],
];

$post_data = $_POST;
$metode = $post_data['metode'];
$result['data'] = getHasil($metode);

if ($result['data']) {
	$result['status'] = true;
	$result['message'] = "Hasil SPK Penerimaan Dosen Menggunakan Metode {$metode}";
}

function getHasil($metode)
{
	$db = new Db;

	$kriteria = $db->selectQuery('tbl_kriteria')->indexIdAll();

	if (!$kriteria) {
		$result['message'] = "Data Kriteria Kosong";
    	echo json_encode($result);exit();
	}

	if (Helpers::cekBobotKosong($kriteria)) {
		$result['message'] = "Bobot Kriteria Masih ada yang Kosong atau 0";
    	echo json_encode($result);exit();
	}

	$penilaian = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
                    ->join('tbl_dosen d')
                    ->on('p.id_dosen = d.id')
                    ->all();

    if (!$penilaian) {
    	$result['message'] = "Data Penilaian Kosong";
    	echo json_encode($result);exit();
    }

	$detail_kriteria = getDetailKriteria($penilaian, $kriteria);
	$hasil = [];
	
	if ($metode === 'saw') {
		foreach ($penilaian as $key => $pen) {
			$data_nilai = [];

			$data_nilai['id'] = $pen->id;
			$data_nilai['nama_dosen'] = $pen->nama_dosen;
			$data_nilai['nilai'] = json_decode($pen->nilai, true);
			$data_nilai['normalisasi'] = getNormalisasi($data_nilai['nilai'], $detail_kriteria);
			$data_nilai['rank'] = getRank($data_nilai['normalisasi'], $detail_kriteria);

			$hasil[] = $data_nilai;
		}
	}
	$dosen_terbaik = getDosenTerbaik($hasil, $metode);

	return [
		'hasil' => $hasil,
		'kriteria' => $kriteria,
		'dosen_terbaik' => $dosen_terbaik,
	];
}

function getDetailKriteria($penilaian, $kriteria)
{
	$detail_kriteria = [];
	foreach ($kriteria as $id_kri => $kri) {
		foreach ($penilaian as $pen) {
			$nilai = json_decode($pen->nilai, true);
			$detail_kriteria[$id_kri][] = $nilai[$id_kri];
		}
		$detail_kriteria[$id_kri]['nilai'] = $kri->tipe === 'COST' ? min($detail_kriteria[$id_kri]) : max($detail_kriteria[$id_kri]);
		$detail_kriteria[$id_kri]['tipe'] = $kri->tipe === 'COST' ? 'min' : 'max';
		$detail_kriteria[$id_kri]['bobot'] = $kri->bobot;
	}

	return $detail_kriteria;
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
	$rank = getRank($normalisasi, $kriteria);

	return [
		'normalisasi' => $normalisasi,
		'rank' => $rank,
	];
}

function getNormalisasi($nilai, $detail_kriteria)
{
	$normalisasi = [];

	foreach ($nilai as $id_kri => $nil) {
		$normalisasi[$id_kri] = ($detail_kriteria[$id_kri]['tipe'] === 'min') ? $detail_kriteria[$id_kri]['nilai'] / $nil : $nil / $detail_kriteria[$id_kri]['nilai'];
	}

	return $normalisasi;
}

function getRank($normalisasi, $detail_kriteria)
{
	$rank = [];

	foreach ($normalisasi as $id_kri => $norm) {
		$rank[$id_kri] = $norm * $detail_kriteria[$id_kri]['bobot'];
	}

	$rank = array_sum($rank);

	return $rank;
}

function getDosenTerbaik($hasil, $metode)
{
	$data = [];
	if ($metode === 'saw') {
		foreach ($hasil as $row) {
			$data[$row['nama_dosen']] = $row['rank'];
		}
	} else {

	}
	$bests = array_keys($data, max($data));

	return $bests;
}

echo json_encode($result);