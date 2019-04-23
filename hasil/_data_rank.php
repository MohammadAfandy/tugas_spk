<?php
$post_data = $_POST['data'];
$data_penilaian = $post_data['penilaian'];
$data_kriteria = $post_data['kriteria'];
$data_rank = $post_data['hasil']['rank'];
arsort($data_rank);
var_dump($data_penilaian, $data_rank);
?>

<table class="table table-hover table-striped table-bordered" id="table_hasil">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Rank</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data_rank) > 0): ?>
            <?php foreach ($data_rank as $key => $rank): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data_penilaian[$data_penilaian[$key]['id']]['nama_dosen'] ?></td>
                    <td class="text-center"><?= $rank ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="<?= count($data_kriteria) + 3 ?>">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>