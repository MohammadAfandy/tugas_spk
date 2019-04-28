<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <li class="page-item">
            <button class="page-link" data-href="<?= 'app/' . $modul . '/_data_' . $table . '.php?page=1' . '&key=' . $key ?>" tabindex="-1">First</button>
        </li>
        <li class="<?= $current_page == 1 ? 'page-item disabled' : 'page-item' ?>">
            <button class="page-link" data-href="<?= 'app/' . $modul . '/_data_' . $table . '.php?page=' . ($current_page - 1) . '&key=' . $key ?>" tabindex="-1">Previous</button>
        </li>
        <?php for ($i = $start_page; $i <= $max_page; $i++): ?>
            <li class="<?= $i == $current_page ? 'page-item active' : 'page-item' ?>"><button class="page-link" data-href="<?= 'app/' . $modul . '/_data_' . $table . '.php?page=' . $i . '&key=' . $key ?>"><?= $i ?></button></li>
            
        <?php endfor; ?>
        <li class="<?= $current_page == $last_page ? 'page-item disabled' : 'page-item' ?>">
            <button class="page-link" data-href="<?= 'app/' . $modul . '/_data_' . $table . '.php?page=' . ($current_page + 1) . '&key=' . $key ?>">Next</button>
        </li>
        <li class="page-item">
            <button class="page-link"  data-href="<?= 'app/' . $modul . '/_data_' . $table . '.php?page=' . $last_page . '&key=' . $key ?>">Last</button>
        </li>
    </ul>
</nav>

<script>
    $(function() {
        $("body").one("click", ".page-link", function() {
            $("#data_" + '<?= $table ?>').load($(this).data("href"));
        });
    });
</script>