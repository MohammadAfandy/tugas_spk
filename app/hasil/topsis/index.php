<?php
$data_hasil = json_decode($_POST['hasil'], true);
$data_kriteria = $_POST['kriteria'];
?>
<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab1">Penilaian</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab2">Normalisasi</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab3">Normalisasi Terbobot</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab4">Solusi Ideal</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab5">Jarak Solusi Ideal</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab6">Nilai Preferensi</a></li>
</ul>

<div class="tab-content">
    <div id="tab1" class="tab-pane fade">
        <?php require_once('../_data_penilaian.php'); ?>
    </div>
    <div id="tab2" class="tab-pane fade">
        <?php require_once('_data_normalisasi.php'); ?>
    </div>
    <div id="tab3" class="tab-pane fade">
        <?php require_once('_data_normalisasi_terbobot.php'); ?>
    </div>
    <div id="tab4" class="tab-pane fade">
        <?php require_once('_data_solusi_ideal.php'); ?>
    </div>
    <div id="tab5" class="tab-pane fade">
        <?php require_once('_data_jarak_solusi_ideal.php'); ?>
    </div>
    <div id="tab6" class="tab-pane fade">
        <?php require_once('_data_nilai_preferensi.php'); ?>
    </div>
</div>
