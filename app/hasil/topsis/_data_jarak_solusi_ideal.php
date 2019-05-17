<table class="table table-hover table-striped table-bordered" id="table_jarak_solusi_ideal">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Jarak Solusi Ideal Positif</th>
            <th>Jarak Solusi Ideal Negatif</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data_hasil) > 0): ?>
            <?php foreach ($data_hasil as $key => $data): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data['nama_dosen'] ?></td>
                    <td class="text-center"><?= isset($data['jarak_solusi_ideal']['pos']) ? $data['jarak_solusi_ideal']['pos'] : '-'?></td>
                    <td class="text-center"><?= isset($data['jarak_solusi_ideal']['neg']) ? $data['jarak_solusi_ideal']['neg'] : '-'?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="4">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>