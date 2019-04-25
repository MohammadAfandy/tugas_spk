<?php
require_once('../../config/db.php');
require_once('../../components/Helpers.php');
?>
<table class="table table-hover table-striped table-bordered" id="table_dosen">
    <thead>
        <tr>
            <th>No</th>
            <th>NIDN</th>
            <th>Nama Dosen</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Tanggal Lahir</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $db = new Db;
        $datas = $db->selectQuery('tbl_dosen')->all();
        ?>
        <?php if (count($datas) > 0): ?>
            <?php foreach ($datas as $key => $data): ?>
                <tr id="<?= $data->id ?>">
                    <td><?= $key + 1 ?></td>
                    <td><?= $data->nidn ?></td>
                    <td><?= $data->nama_dosen ?></td>
                    <td><?= $data->jk ?></td>
                    <td><?= $data->tempat_lahir . ', ' . Helpers::dateIndo($data->tgl_lahir) ?></td>
                    <td><?= $data->no_hp ?></td>
                    <td><?= $data->email ?></td>
                    <td>
                        <a href="dosen.php?act=edit&id=<?= $data->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" id="btn_dosen_delete" data-id="<?= $data->id ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="8">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>