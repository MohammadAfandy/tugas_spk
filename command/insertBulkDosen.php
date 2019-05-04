<?php
require_once('../vendor/Faker/src/autoload.php');
require_once('../config/Db.php');

$db = new Db;

$faker = Faker\Factory::create('id_ID');

$count = 0;
for ($i = 0; $i < 9000; $i++) {
    $insert = $db->insertQuery('tbl_dosen', [
        'nidn' => $faker->nik(),
        'nama_dosen' => $faker->name,
        'jk' => $faker->randomElement(['Laki - Laki', 'Perempuan']),
        'tempat_lahir' => $faker->city,
        'tgl_lahir' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'alamat' => $faker->address,
        'no_hp' => $faker->phoneNumber,
        'email' => $faker->email,
    ]);
    if ($insert) $count++;
}


echo "Berhasil Insert {$count} Data";