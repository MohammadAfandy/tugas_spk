<?php
header('Content-Type: application/json');
// error_reporting(0);

require_once('../../config/Db.php');
require_once('../../components/Helpers.php');

$result = [
    'status' => false,
    'message' => 'Terjadi Kesalahan Sistem',
    'data' => [],
];

$post_data = $_POST;
$metode = $post_data['metode'];

if (!$metode) {
    $result['message'] = "Metode Tidak Boleh Kosong";
    echo json_encode($result);exit();
}

$result['data'] = getHasil($metode);

if ($result['data']) {
    $result['status'] = true;
    $result['message'] = "SPK Penerimaan Dosen Menggunakan Metode " . strtoupper($metode);
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

    if (Helpers::cekPenilaianKosong($penilaian, count($kriteria))) {
        $result['message'] = "Nilai di Data Penilaian Masih ada yang Kosong atau 0";
        echo json_encode($result);exit();
    }

    $list_detail_kriteria = getListDetailKriteria($penilaian, $kriteria);
    $list_kriteria = $list_detail_kriteria['list_kriteria'];
    $detail_kriteria = $list_detail_kriteria['detail_kriteria'];

    $hasil = [];
    
    if ($metode === 'saw') {
        foreach ($penilaian as $pen) {
            $data_nilai = [];

            $data_nilai['id'] = $pen->id;
            $data_nilai['nama_dosen'] = $pen->nama_dosen;
            $data_nilai['nilai'] = json_decode($pen->nilai, true);
            $data_nilai['normalisasi'] = getNormalisasiSaw($data_nilai['nilai'], $detail_kriteria);
            $data_nilai['rank'] = getRank($data_nilai['normalisasi'], $detail_kriteria);

            $hasil[] = $data_nilai;
        }
    } else if ($metode === 'wp') {
        foreach ($penilaian as $pen) {
            $data_nilai = [];

            $data_nilai['id'] = $pen->id;
            $data_nilai['nama_dosen'] = $pen->nama_dosen;
            $data_nilai['nilai'] = json_decode($pen->nilai, true);
            $data_nilai['vektor_s'] = getVektorS($data_nilai['nilai'], $detail_kriteria);

            $hasil[] = $data_nilai;
        }
    
        $vektor_v = getVektorV($hasil);
        
        foreach ($hasil as $key => $has) {
            $hasil[$key]['vektor_v'] = $vektor_v[$has['id']];
        }
    } else if ($metode === 'topsis') {
        foreach ($penilaian as $pen) {
            $data_nilai = [];

            $data_nilai['id'] = $pen->id;
            $data_nilai['nama_dosen'] = $pen->nama_dosen;
            $data_nilai['nilai'] = json_decode($pen->nilai, true);
            $normalisasi_topsis = getNormalisasiTopsis($data_nilai['nilai'], $list_detail_kriteria);
            $data_nilai['normalisasi'] = $normalisasi_topsis['normalisasi'];
            $data_nilai['normalisasi_terbobot'] = $normalisasi_topsis['normalisasi_terbobot'];

            $hasil[] = $data_nilai;
        }

        $solusi_ideal = getSolusiIdeal($hasil, $detail_kriteria);

        foreach ($kriteria as $key => $kri) {
            $kriteria[$key]->solusi_ideal = $solusi_ideal[$key];
        }

        $jarak_solusi_ideal = getJarakSolusiIdeal($hasil, $solusi_ideal);
        $nilai_preferensi = getNilaiPreferensi($jarak_solusi_ideal);

        foreach ($hasil as $key => $has) {
            $hasil[$key]['jarak_solusi_ideal'] = $jarak_solusi_ideal[$has['id']];
            $hasil[$key]['nilai_preferensi'] = $nilai_preferensi[$has['id']];
        }
    }

    $dosen_terbaik = getDosenTerbaik($hasil, $metode);

    return [
        'hasil' => json_encode($hasil),
        'kriteria' => $kriteria,
        'dosen_terbaik' => $dosen_terbaik,
        'detail_kriteria' => $detail_kriteria,
    ];
}

function getListDetailKriteria($penilaian, $kriteria)
{
    $detail_kriteria = $list_kriteria = [];
    foreach ($kriteria as $id_kri => $kri) {
        foreach ($penilaian as $pen) {
            $nilai = json_decode($pen->nilai, true);
            $list_kriteria[$id_kri][] = $nilai[$id_kri];
        }
        $detail_kriteria[$id_kri]['minmax'] = $kri->tipe === 'COST' ? min($list_kriteria[$id_kri]) : max($list_kriteria[$id_kri]);
        $detail_kriteria[$id_kri]['tipe'] = $kri->tipe === 'COST' ? 'cost' : 'benefit';
        $detail_kriteria[$id_kri]['bobot'] = $kri->bobot;
    }

    return [
        'list_kriteria' => $list_kriteria,
        'detail_kriteria' => $detail_kriteria,
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

/*
==================================================================================
=============================   METODE SAW ======================================= 
==================================================================================
*/
function getNormalisasiSaw($nilai, $detail_kriteria)
{
    $normalisasi = [];

    foreach ($nilai as $id_kri => $nil) {
        $normalisasi[$id_kri] = ($detail_kriteria[$id_kri]['tipe'] === 'cost') ? $detail_kriteria[$id_kri]['minmax'] / $nil : $nil / $detail_kriteria[$id_kri]['minmax'];
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


/*
==================================================================================
=============================   METODE WP ========================================
==================================================================================
*/
function getVektorS($nilai, $detail_kriteria)
{
    $vektor_s = [];

    foreach ($nilai as $id_kri => $nil) {
        $vektor_s[$id_kri] = ($detail_kriteria[$id_kri]['tipe'] === 'cost') ? pow($nil, -($detail_kriteria[$id_kri]['bobot'])) : pow($nil, $detail_kriteria[$id_kri]['bobot']);
    }

    $vektor_s = array_product($vektor_s);

    return $vektor_s;
}

function getVektorV($hasil)
{
    $vektor_v = [];
    $sum = 0;

    foreach ($hasil as $has) {
        $sum += $has['vektor_s'];
    }

    foreach ($hasil as $has) {
        $vektor_v[$has['id']] = $has['vektor_s'] / $sum;
    }

    return $vektor_v;
}


/*
==================================================================================
=============================   METODE TOPSIS ==================================== 
==================================================================================
*/
function getNormalisasiTopsis($nilai, $list_detail_kriteria)
{
    $normalisasi_topsis = [];
    foreach ($nilai as $id_kri => $nil) {

        $pembagi = array_map(function($val) {
            return ($val * $val);
        }, $list_detail_kriteria['list_kriteria'][$id_kri]);

        $pembagi = array_sum($pembagi);

        $normalisasi_topsis['normalisasi'][$id_kri] = $nil / (sqrt($pembagi));
        $normalisasi_topsis['normalisasi_terbobot'][$id_kri] = $normalisasi_topsis['normalisasi'][$id_kri] * $list_detail_kriteria['detail_kriteria'][$id_kri]['bobot'];
    }

    return $normalisasi_topsis;
}

function getSolusiIdeal($hasil, $detail_kriteria)
{
    $solusi_ideal = $result = [];

    foreach ($hasil as $has) {
        foreach ($has['normalisasi_terbobot'] as $id_kri => $nt) {
            $solusi_ideal[$id_kri][] = $nt;
        }
    }

    foreach ($solusi_ideal as $id_kri => $si) {
        if ($detail_kriteria[$id_kri]['tipe'] == 'benefit') {
            $result[$id_kri]['pos'] = max($si);
            $result[$id_kri]['neg'] = min($si);    
        } else {
            $result[$id_kri]['pos'] = min($si);
            $result[$id_kri]['neg'] = max($si);
        }
    }

    return $result;
}

function getJarakSolusiIdeal($hasil, $solusi_ideal)
{
    $jarak_solusi_ideal = [];

    foreach ($hasil as $has) {
        foreach ($has['normalisasi_terbobot'] as $id_kri => $nt) {
            $jarak_solusi_ideal[$has['id']]['pos'][] = pow(($solusi_ideal[$id_kri]['pos'] - $nt), 2);
            $jarak_solusi_ideal[$has['id']]['neg'][] = pow(($solusi_ideal[$id_kri]['neg'] - $nt), 2);
        }
        $jarak_solusi_ideal[$has['id']]['pos'] = array_sum($jarak_solusi_ideal[$has['id']]['pos']);
        $jarak_solusi_ideal[$has['id']]['neg'] = array_sum($jarak_solusi_ideal[$has['id']]['neg']);
    }

    return $jarak_solusi_ideal;
}

function getNilaiPreferensi($jarak_solusi_ideal)
{
    $nilai_preferensi = [];

    foreach ($jarak_solusi_ideal as $id => $jsi) {
        $nilai_preferensi[$id] = $jsi['neg'] / ($jsi['neg'] + $jsi['pos']);
    }

    return $nilai_preferensi;
}


/*
==================================================================================
=============================   Hasil Terbaik ==================================== 
==================================================================================
*/
function getDosenTerbaik($hasil, $metode)
{
    $data = [];
    $mapping_metode = [
        'saw' => 'rank',
        'wp' => 'vektor_v',
        'topsis' => 'nilai_preferensi',
    ];

    foreach ($hasil as $has) {
        $data[$has['nama_dosen']] = $has[$mapping_metode[$metode]];
    }

    $bests = array_keys($data, max($data));

    return $bests;
}

echo json_encode($result);exit();