<?php
$post_data = $_POST['data'];
$data_hasil = $post_data['hasil'];
$data_kriteria = $post_data['kriteria'];
?>

<table class="table table-hover table-striped table-bordered" id="table_hasil">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Dosen</th>
            <th colspan="<?= count($data_kriteria) ?>">Penilaian</th>
        </tr>
        <tr>
            <?php foreach($data_kriteria as $kriteria): ?>
                <th><?= ucfirst($kriteria['nama_kriteria']) . "<br>({$kriteria['tipe']})" ?></th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data_hasil) > 0): ?>
            <?php foreach ($data_hasil as $key => $data): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data['nama_dosen'] ?></td>
                    <?php foreach ($data_kriteria as $id_kri => $kri): ?>
                        <td class="text-center">
                            <?= isset($data['nilai'][$id_kri]) ? $data['nilai'][$id_kri] : '-'?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="<?= count($data_kriteria) + 3 ?>">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>