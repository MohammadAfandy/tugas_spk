<?php
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
        $post_data['nilai'] = json_encode($post_data['nilai']);
        $insert = $db->insertQuery('tbl_penilaian', $post_data);

        if ($insert) {
            $result['status'] = true;
            $result['message'] = "Data Penilaian Berhasil Ditambahkan";
        } else {
            $result['message'] = "Data Penilaian Gagal Ditambahkan";
        }
        break;

    case 'update':
        formValidation($post_data);
        $post_data['nilai'] = json_encode($post_data['nilai']);
        $update = $db->updateQuery('tbl_penilaian', $post_data);

        if ($update) {
            $result['status'] = true;
            $result['message'] = "Data Penilaian Berhasil Diupdate";
        } else {
            $result['message'] = "Data Penilaian Gagal Diupdate";
        }
        break;

    case 'delete':
        $delete = $db->deleteQuery('tbl_penilaian', $post_data['id']);
        if ($delete) {
            $result['status'] = true;
            $result['message'] = "Data Berhasil Dihapus";
            $result['data'] = $post_data['id'];
        } else {
            $result['message'] = "Data Gagal Dihapus";
        }
        break;

    case 'deleteall':
        if (isset($post_data["post"]) && $post_data["post"] == "delete_all") {
            $truncate = $db->query("TRUNCATE TABLE tbl_penilaian");
            $result['status'] = true;
            $result['message'] = "Semua Data Penilaian Berhasil Dihapus";
            $result['data'] = $post_data['id'];
        }
        
        break;

}

function formValidation($post_data)
{
    $not_empty = ['id_dosen'];

    foreach ($post_data as $field => $record) {
        if (in_array($field, $not_empty) && $record == '') {
            $result['message'] = strtoupper(str_replace('_', ' ', preg_replace('/^id/i', 'nama', $field))) . " Tidak Boleh Kosong";
            echo json_encode($result);exit();
        }
        if ($field == "nilai") {
            foreach ($record as $id_kri => $nilai) {
                if (empty(intval($nilai))) {
                    $result['message'] = "Nilai Tidak Boleh Kosong atau 0";
                    echo json_encode($result);exit();
                }
            }
        }
    }
}

echo json_encode($result);