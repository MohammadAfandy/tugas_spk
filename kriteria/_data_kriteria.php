<?php
require_once('../config/db.php');
?>
<table class="table table-hover table-striped table-bordered" id="table_kriteria">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kriteria</th>
            <th>Tipe</th>
            <th>Bobot (Persen)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $db = new Db;
        $datas = $db->selectQuery('tbl_kriteria')->all();
        ?>
        <?php if (count($datas) > 0): ?>
            <?php $tab_index = 1; foreach ($datas as $key => $data): ?>
                <tr id="<?= $data->id ?>">
                    <td><?= $key + 1 ?></td>
                    <td><?= $data->nama_kriteria ?></td>
                    <td><?= $data->tipe ?></td>
                    <td width="15%">
                        <input type="number" class="form-control text-right bobot-kriteria" style="width: 100%" id="bobot" data-id="<?= $data->id ?>" value="<?= $data->bobot * 100 ?>" tabindex="<?= $tab_index ?>">        
                    </td>
                    <td>
                        <a href="kriteria.php?act=edit&id=<?= $data->id ?>" class="btn btn-success btn-sm">Sub Kriteria</a>
                        <a href="kriteria.php?act=edit&id=<?= $data->id ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" id="btn_kriteria_delete" data-id="<?= $data->id ?>">Delete</button>
                    </td>
                    <?php $tab_index++; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="5">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>