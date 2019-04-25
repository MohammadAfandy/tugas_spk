<div class="row mb-5">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="./index.php">SPK - Seleksi Penerimaan Dosen</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>   
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php $url = Helpers::getCurrentPage(); ?>
                    <li class="nav-item <?= $url == 'index' ? 'active' : '' ?>">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item <?= $url == 'dosen' ? 'active' : '' ?>">
                        <a class="nav-link" href="./dosen.php">Dosen</a>
                    </li>
                    <li class="nav-item <?= $url == 'kriteria' ? 'active' : '' ?>">
                        <a class="nav-link" href="./kriteria.php">Kriteria</a>
                    </li>
                    <li class="nav-item <?= $url == 'penilaian' ? 'active' : '' ?>">
                        <a class="nav-link" href="./penilaian.php">Penilaian</a>
                    </li>
                    <li class="nav-item <?= $url == 'hasil' ? 'active' : '' ?>">
                        <a class="nav-link" href="./hasil.php">Hasil</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<div class="row">
    <div class="container" id="content">