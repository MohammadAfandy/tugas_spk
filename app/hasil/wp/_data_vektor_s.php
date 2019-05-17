<table class="table table-hover table-striped table-bordered" id="table_vektor_s">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Vektor S</th>
    </thead>
    <tbody>
        <?php if (count($data_hasil) > 0): ?>
            <?php foreach ($data_hasil as $key => $data): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data['nama_dosen'] ?></td>
                    <td class="text-center"><?= isset($data['vektor_s']) ? $data['vektor_s'] : '-'?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="3">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>