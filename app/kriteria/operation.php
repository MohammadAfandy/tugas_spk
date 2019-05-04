<?php
ini_set('max_execution_time', 3000);
header('Content-Type: application/json');
error_reporting(0);

require_once('../../config/db.php');
$db = new Db;

$result = [
    'status' => false,
    'message' => 'Terjadi Kesalahan Sistem',
    'data' => [],
];

$post_data = $_POST;

switch ($_GET['op']) {
    case 'tambah':
        formValidation($post_data);
        $insert = $db->insertQuery('tbl_kriteria', $post_data);

        if ($insert) {
            $reset = resetBobot($db);
            $result['status'] = true;
            $result['message'] = "Data Kriteria Berhasil Ditambahkan";
        } else {
            $result['message'] = "Data Kriteria Gagal Ditambahkan";
        }
        break;

    case 'update':
        formValidation($post_data);
        $update = $db->updateQuery('tbl_kriteria', $post_data);

        if ($update) {
            $result['status'] = true;
            $result['message'] = "Data Kriteria Berhasil Diupdate";
        } else {
            $result['message'] = "Data Kriteria Gagal Diupdate";
        }
        break;

    case 'set':
        setBobotValidation($post_data['data_bobot']);
        foreach ($post_data['data_bobot'] as $data_bobot) {
            $data_bobot['bobot'] = $data_bobot['bobot'] / 100;
            $db->updateQuery('tbl_kriteria', $data_bobot);
        }
        $result['status'] = true;
        $result['message'] = "Bobot Kriteria Berhasil Diset";
        break;

    case 'reset':
        $reset = resetBobot($db);
        if ($reset) {
            $result['status'] = true;
            $result['message'] = "Bobot Kriteria Berhasil Direset";
        } else {
            $result['message'] = "Bobot Kriteria Gagal Direset";
        }
        break;

    case 'delete':
        // remove json key id kriteria di kolom nilai di table penilaian
        $data_penilaian = $db->selectQuery('tbl_penilaian')->all();
        foreach ($data_penilaian as $pen) {
            $nilai = json_decode($pen->nilai, true);
            if (isset($nilai[$post_data['id']])) {
                unset($nilai[$post_data['id']]);
                $update_penilaian = $db->updateQuery('tbl_penilaian', ['id' => $pen->id, 'nilai' => json_encode($nilai)]);
                if (!$update_penilaian) {
                    $result['message'] = "Data Kriteria Gagal Dihapus";
                    echo json_encode($result);exit();
                }
            }
        }
        $delete = $db->deleteQuery('tbl_kriteria', $post_data['id']);
        if ($delete) {
            $result['status'] = true;
            $result['message'] = "Data Kriteria Berhasil Dihapus Tapi Bobot Gagal Direset";

            $reset = resetBobot($db);
            if ($reset) {
                $result['message'] = "Data Kriteria Berhasil Dihapus dan Bobot Berhasil Direset";
            }
        } else {
            $result['message'] = "Data Kriteria Gagal Dihapus";
        }
        break;

    case 'savesub':
        if (isset($post_data['sub_kriteria']) && is_array($post_data['sub_kriteria'])) {
            $sub_kriteria = [];
            foreach ($post_data['sub_kriteria'] as $sub) {
                if ($sub['nama'] == '' || !$sub['nilai']) {
                    $result['message'] = "Nama dan Nilai Sub Kriteria Tidak Boleh Kosong";
                    echo json_encode($result);exit();
                }
                $sub_kriteria[$sub['nilai']] = $sub['nama'];
            }
            $post_data['sub_kriteria'] = json_encode($sub_kriteria);
        }
        $savesub = $db->updateQuery('tbl_kriteria', $post_data);

        if ($savesub) {
            $result['status'] = true;
            $result['message'] = "Data Sub Kriteria Berhasil Disimpan";
        } else {
            $result['message'] = "Data Sub Kriteria Gagal Disimpan";
        }
        break;

}

function formValidation($post_data)
{
    $not_empty = ['nama_kriteria', 'tipe'];

    foreach ($post_data as $field => $record) {
        if (in_array($field, $not_empty) && $record == '') {
            $result['message'] = strtoupper(str_replace('_', ' ', $field)) . " Tidak Boleh Kosong";
            echo json_encode($result);exit();
        }
    }
}

function setBobotValidation($bobot)
{
    foreach ($bobot as $data_bobot) {
        if (empty(intval($data_bobot['bobot']))) {
            $result['message'] = "Bobot Tidak Boleh Kosong / 0";
            echo json_encode($result);exit();
        }
    }
}

function resetBobot(&$db)
{
    $data_kriteria = $db->selectQuery('tbl_kriteria')->all();
    foreach ($data_kriteria as $kriteria) {
        if (!$db->updateQuery('tbl_kriteria', ['id' => $kriteria->id, 'bobot' => 0])) {
            return false;
        }
    }

    return true;
}

echo json_encode($result);exit();