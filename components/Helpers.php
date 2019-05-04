<?php

class Helpers
{

    public static function _curl($url, $post = [], $is_json = false)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);
        curl_close($ch);

        return $is_json ? json_decode($response, true) : $response;
    }

    public static function getCurrentPage()
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $current_uri = preg_replace('/.php$/i', '', $uri_segments[2]);
        
        return $current_uri;
    }

    public static function getUrlSegment($segment = false)
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        
        return $segment ? $uri_segments[$segment] : $uri_segments;
    }

    /**
     * Convert date to date format Indonesia
     * @param string date
     * @return string result
     */
    public static function dateIndo($date) 
    {
        $result = '';
        if(!empty($date) && $date !== '0000-00-00') {
            $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); 
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tgl   = substr($date, 8, 2);
         
            $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
            
        }
        return $result;
    }

    public static function baseUrl($url = '')
    {
        return 'http://localhost/tugas_spk/' . $url;
    }

    /**
     * cek apakah semua bobot kriteria sudah diset atau belum (masih 0)
     * sudah = false, belum = true
     * @param array $kriteria
     * @return boolean
     */
    public static function cekBobotKosong($kriteria)
    {
        $arr_bobot = [];

        foreach ($kriteria as $kri) {
            $arr_bobot[] = $kri->bobot;
        }

        if (in_array(0, $arr_bobot)) {
            return true;
        }

        return false;
    }

    /**
     * cek apakah semua nilai penilaian sudah diset atau belum (masih 0)
     * sudah = false, belum = true
     * @param array $kriteria
     * @return boolean
     */
    public static function cekPenilaianKosong($penilaian, $jumlah_kriteria)
    {
        $arr_jml_nilai = [];

        foreach ($penilaian as $pen) {
            $arr_jml_nilai[] = count(json_decode($pen->nilai, true));
        }

        foreach ($arr_jml_nilai as $jml) {
            if ($jumlah_kriteria != $jml) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Convert nilai sub_kriteria to nama sub_kriteria
     * @param double nilai_sub_kriteria
     * @param int id_kriteria
     * @return string nama_sub_kriteria
     */
    public static function getNamaSubFromNilai($db, $nilai_sub_kriteria, $id_kriteria)
    {
        $sub_kriteria = $db->selectQuery('tbl_kriteria')->where(['id' => $id_kriteria])->one()->sub_kriteria;

        if ($sub_kriteria) {
            $sub_kriteria = json_decode($sub_kriteria, true);
            return $sub_kriteria[$nilai_sub_kriteria]; 
        }

        return $nilai_sub_kriteria;
    }

    public static function generatePagination($table, $count_all_data, $count_page = 10, $items_per_page = 10)
    {
        if ($count_all_data <= $items_per_page) {
            $file = '';    
        } else {
            $file = __DIR__ . '/../template/pagination.php';
            if (!$file) return '';   
        }

        $modul = Helpers::getUrlSegment(3);
        $key = isset($_GET['key']) ? $_GET['key'] : NULL;
        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $start = $current_page > 1 ? ($current_page * $items_per_page) - $items_per_page : 0;
        $last_page = ceil($count_all_data / $items_per_page);

        $start_page = 1;
        if ($count_all_data < $count_page * $items_per_page) {
            $count_page = $max_page = $last_page;
        } else {
            // biar ga minus pas di batas bawah star_page nya
            if ($current_page <= ceil($count_page / 2)) {
                $start_page = 1;
                $max_page = ($start_page + $count_page) - 1;

            // biar ga lebih halaman terakhirnya pas di batas atas
            } else if ($current_page > $last_page - floor($count_page / 2)) {
                $start_page = $last_page - $count_page;
                $max_page = $start_page + $count_page;

            // Biar current_page tetep ditengah
            } else {
                $start_page = $current_page - floor($count_page / 2);
                $max_page = ($start_page + $count_page) - 1;
            }
        }

        if ($file) {   
            ob_start();
            include $file;
            $html = ob_get_clean();   
        } else {
            $html = '';
        }

        return [
            'start' => $start,
            'items_per_page' => $items_per_page,
            'key' => $key,
            'html' => $html,
        ];
    }
}