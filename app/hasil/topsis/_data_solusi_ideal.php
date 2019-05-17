<table class="table table-hover table-striped table-bordered" id="table_solusi_ideal_positif">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kriteria</th>
            <th>Tipe</th>
            <th>Y+</th>
            <th>Y-</th>
    </thead>
    <tbody>
        <?php if (count($data_kriteria) > 0): ?>
            <?php $no = 1; ?>
            <?php foreach ($data_kriteria as $data): ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $data['nama_kriteria'] ?></td>
                    <td><?= $data['tipe'] ?></td>
                    <td class="text-center"><?= isset($data['solusi_ideal']['pos']) ? round($data['solusi_ideal']['pos'], 3) : '-'?></td>
                    <td class="text-center"><?= isset($data['solusi_ideal']['neg']) ? round($data['solusi_ideal']['neg'], 3) : '-'?></td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="5">Data Tidak Ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>