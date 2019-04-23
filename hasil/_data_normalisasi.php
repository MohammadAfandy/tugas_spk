<?php
$post_data = $_POST['data'];
$data_penilaian = $post_data['penilaian'];
$data_kriteria = $post_data['kriteria'];
$data_normalisasi = $post_data['hasil']['normalisasi'];

?>

<table class="table table-hover table-striped table-bordered" id="table_hasil">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Dosen</th>
            <th colspan="<?= count($data_kriteria) ?>">Normalisasi</th>
        </tr>
        <tr>
            <?php foreach($data_kriteria as $kriteria): ?>
                <th><?= ucfirst($kriteria['nama_kriteria']) . "<br>({$kriteria['tipe']})" ?></th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data_penilaian) > 0): ?>
            <?php foreach ($data_penilaian as $key => $data): ?>
                <tr id="<?= $data['id'] ?>">
                    <td><?= $key + 1 ?></td>
                    <td><?= $data['nama_dosen'] ?></td>
                    <?php if (!empty($data_normalisasi) && is_array($data_normalisasi)): ?>
                        <?php foreach ($data_kriteria as $id_kri => $kri): ?>
                            <td class="text-center">
                                <?= isset($data_normalisasi[$data['id']][$id_kri]) ? round($data_normalisasi[$data['id']][$id_kri], 3) : '-'?>
                                    
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="<?= count($data_kriteria) + 3 ?>">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>