<?php
header('Content-Type: application/json');
error_reporting(0);
require_once('../config/db.php');
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
		$insert = $db->insertQuery('tbl_dosen', $post_data);
		if ($insert) {
			$result['status'] = true;
			$result['message'] = "Data Dosen Berhasil Ditambahkan";
		} else {
			$result['message'] = "Data Dosen Gagal Ditambahkan";
		}
		break;

	case 'update':
		formValidation($post_data);
		$update = $db->updateQuery('tbl_dosen', $post_data);

		if ($update) {
			$result['status'] = true;
			$result['message'] = "Data Dosen Berhasil Diupdate";
		} else {
			$result['message'] = "Data Dosen Gagal Diupdate";
		}
		break;

	case 'delete':
		$delete = $db->deleteQuery('tbl_dosen', $post_data['id']);

		if ($delete) {
			$result['status'] = true;
			$result['message'] = "Data Berhasil Dihapus";
			$result['data'] = $post_data['id'];
		} else {
			$result['message'] = "Data Gagal Dihapus";
		}
		break;

}

function formValidation($post_data)
{
	$not_empty = ['nidn', 'nama_dosen'];
	foreach ($post_data as $field => $record) {
		if (in_array($field, $not_empty) && $record == '') {
			$result['message'] = strtoupper(str_replace('_', ' ', $field)) . " Tidak Boleh Kosong";
			echo json_encode($result);exit();
		}
	}
}

echo json_encode($result);