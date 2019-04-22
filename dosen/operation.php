<?php
require_once('../config/db.php');
$db = new Db;

$result = [
	'status' => false,
	'message' => 'Terjadi Kesalahan Sistem',
	'data' => [],
];

$not_empty = ['nidn', 'nama_dosen'];
$post_data = $_POST;

foreach ($post_data as $field => $record) {
	if (in_array($field, $not_empty) && $record == '') {
		$result['message'] = strtoupper(str_replace('_', ' ', $field)) . " Tidak Boleh Kosong";
		echo json_encode($result);exit();
	}
}

switch ($_GET['op']) {
	case 'tambah':
		$insert = $db->insertQuery('tbl_dosen', $post_data);

		if ($insert) {
			$result['status'] = true;
			$result['message'] = "Data Dosen Berhasil Ditambahkan";
		} else {
			$result['message'] = "Data Dosen Gagal Ditambahkan";
		}
		break;

	case 'update':
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

echo json_encode($result);