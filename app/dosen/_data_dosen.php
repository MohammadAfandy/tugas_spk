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
        $items_per_page = 10;
        $page = $_GET['page'];
        $start = $page > 1 ? ($page * $items_per_page) - $items_per_page : 0;
        $total = count($db->selectQuery('tbl_dosen')->all());
        $pages = ceil($total / $items_per_page);
        $datas = $db->selectQuery('tbl_dosen')->limit($start, $items_per_page)->all();
        ?>
        <?php if ($total > 0): ?>
            <?php foreach ($datas as $key => $data): ?>
                <tr id="<?= $data->id ?>">
                    <td><?= $start + $key + 1 ?></td>
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

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <li class="page-item">
            <a class="page-link" href="dosen.php" tabindex="-1">First</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="dosen.php?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
        </li>
        <?php for ($i = $page; $i <= $pages - ($pages - ($page + 5)); $i++): ?>
            <li class="<?= $i == $page ? 'page-item active' : 'page-item' ?>"><a class="page-link" href="dosen.php?page=<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>
        <li class="page-item">
            <a class="page-link" href="dosen.php?page=<?= $page + 1 ?>">Next</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="dosen.php?page=<?= $pages ?>">Last</a>
        </li>
    </ul>
</nav>