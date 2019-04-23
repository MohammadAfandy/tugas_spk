<?php
require_once('../config/db.php');
$db = new Db;

$result = [
	'status' => false,
	'message' => 'Terjadi Kesalahan Sistem',
	'data' => [],
];

$not_empty = ['nama_kriteria'];
$post_data = $_POST;

foreach ($post_data as $field => $record) {
	if (in_array($field, $not_empty) && $record == '') {
		$result['message'] = strtoupper(str_replace('_', ' ', $field)) . " Tidak Boleh Kosong";
		echo json_encode($result);exit();
	}
}

switch ($_GET['op']) {
	case 'tambah':
		$insert = $db->insertQuery('tbl_kriteria', $post_data);

		if ($insert) {
			$result['status'] = true;
			$result['message'] = "Data Kriteria Berhasil Ditambahkan";
		} else {
			$result['message'] = "Data Kriteria Gagal Ditambahkan";
		}
		break;

	case 'update':
		$update = $db->updateQuery('tbl_kriteria', $post_data);

		if ($update) {
			$result['status'] = true;
			$result['message'] = "Data Kriteria Berhasil Diupdate";
		} else {
			$result['message'] = "Data Kriteria Gagal Diupdate";
		}
		break;

	case 'set':
		$post_data['bobot'] = isset($post_data['bobot']) ? $post_data['bobot'] / 100 : null;
		foreach ($post_data['data_bobot'] as $data_bobot) {
			$data_bobot['bobot'] = $data_bobot['bobot'] / 100;
			$db->updateQuery('tbl_kriteria', $data_bobot);
		}
		$result['status'] = true;
		$result['message'] = "Bobot Kriteria Berhasil Diset";
		break;

	case 'reset':
		$data_kriteria = $db->selectQuery('tbl_kriteria')->all();
		foreach ($data_kriteria as $kriteria) {
			$db->updateQuery('tbl_kriteria', ['id' => $kriteria->id, 'bobot' => 0]);
		}

		$result['status'] = true;
		$result['message'] = "Bobot Kriteria Berhasil Direset";
		break;

	case 'delete':
		$delete = $db->deleteQuery('tbl_kriteria', $post_data['id']);
		if ($delete) {
			$result['status'] = true;
			$result['message'] = "Data Kriteria Berhasil Dihapus";
			$result['data'] = $post_data['id'];
		} else {
			$result['message'] = "Data Kriteria Gagal Dihapus";
		}
		break;

}

echo json_encode($result);