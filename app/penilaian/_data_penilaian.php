<?php
require_once('../../config/db.php');
require_once('../../components/Helpers.php');

$db = new Db;
$data_kriteria = $db->selectQuery('tbl_kriteria')->all();

$all_data = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
                ->join('tbl_dosen d')
                ->on('p.id_dosen = d.id')
                ->all();

$count_all_data = count($all_data);
$pagination = Helpers::generatePagination('penilaian', $count_all_data);
$datas = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
            ->join('tbl_dosen d')
            ->on('p.id_dosen = d.id')
            ->limit($pagination['start'], $pagination['items_per_page'])
            ->all();

$search = isset($pagination['key']) && $pagination['key'] ? $pagination['key'] : '';
if ($search) {
    $all_data = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
                   ->join('tbl_dosen d')
                   ->on('p.id_dosen = d.id')
                   ->where(['d.nama_dosen' => '%' . $search . '%'], 'like')
                   ->all();

    $count_all_data = count($all_data);
    $pagination = Helpers::generatePagination('penilaian', $count_all_data);
    $datas = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
            ->join('tbl_dosen d')
            ->on('p.id_dosen = d.id')
            ->where(['d.nama_dosen' => '%' . $search . '%'], 'like')
            ->limit($pagination['start'], $pagination['items_per_page'])
            ->all();
}
?>
<div class="form-group has-search float-right" style="width: 500px;">
    <input type="text" class="form-control" placeholder="Search" id="btn_search" value="<?= $search ?>">
</div>
<table class="table table-hover table-striped table-bordered" id="table_penilaian">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Dosen</th>
            <th colspan="<?= count($data_kriteria) ?>">Penilaian</th>
            <th rowspan="2">Aksi</th>
        </tr>
        <tr>
            <?php foreach($data_kriteria as $kriteria): ?>
                <th><?= ucfirst($kriteria->nama_kriteria) . "<br>({$kriteria->tipe})" ?></th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php if ($count_all_data > 0): ?>
            <?php foreach ($datas as $key => $data): ?>
                <?php
                $nilai = json_decode($data->nilai, true);
                ?>
                <tr id="<?= $data->id ?>">
                    <td><?= $pagination['start'] + $key + 1 ?></td>
                    <td><?= $data->nama_dosen ?></td>
                    <?php if (!empty($nilai) && is_array($nilai)): ?>
                        <?php foreach ($data_kriteria as $kriteria): ?>
                            <td class="text-center"><?= isset($nilai[$kriteria->id]) ? $nilai[$kriteria->id] : '-'?></td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <td>
                        <a href="penilaian.php?act=edit&id=<?= $data->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" id="btn_penilaian_delete" data-id="<?= $data->id ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="<?= count($data_kriteria) + 3 ?>">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $pagination['html'] ?>