<?php

class Helpers
{

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

    public static function baseUrl($url)
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
}