<?php
require_once('../vendor/Faker/src/autoload.php');
require_once('../config/Db.php');

$db = new Db;
$dosen_exist = $db->selectQuery('tbl_penilaian', ['id_dosen'])->column();
$data_dosen = $db->selectQuery('tbl_dosen', ['id'])->whereIn('id', $dosen_exist, 'NOT IN')->column();
$data_kriteria = $db->selectQuery('tbl_kriteria', ['id'])->column();
$faker = Faker\Factory::create('id_ID');

$count = 0;
for ($i = 0; $i < sizeof($data_dosen); $i++) {
    $nilai = [];
    foreach ($data_kriteria as $kri) {
    	$sub_kriteria = $db->selectQuery('tbl_kriteria')->where(['id' => $kri])->one()->sub_kriteria;
    	if ($sub_kriteria) {
    		$sub_kriteria = json_decode($sub_kriteria, true);
    		$nilai[$kri] = $faker->randomElement(array_keys($sub_kriteria));
    	} else {
        	$nilai[$kri] = $faker->biasedNumberBetween($min = 20, $max = 99, $function = 'sqrt');
        }
    }
    $insert = $db->insertQuery('tbl_penilaian', [
        'id_dosen' => $data_dosen[$i],
        'nilai' => json_encode($nilai),
    ]);
    if ($insert) $count++;
}


echo "Berhasil Insert {$count} Data";