<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

if (!function_exists('bulan_sort')) {
    function bulan_sort($bln)
    {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ags";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }
}
if (!function_exists('longdate_indo')) {
    function longdate_indo($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);

        $nama =  date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } elseif ($nama == "Monday") {
            $nama_hari = "Senin";
        } elseif ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } elseif ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } elseif ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } elseif ($nama == "Friday") {
            $nama_hari = "Jumat";
        } elseif ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari . ', ' . $tgl . ' ' . $bulan . ' ' . $thn;
    }

    if (!function_exists('bulan_indo')) {
        function bulan_indo($tanggal)
        {
            date_default_timezone_set('Asia/Jakarta');
            $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
            $pecah = explode("-", $ubah);
            $tgl = $pecah[2];
            $thn = $pecah[0];
            $bulan = bulan($pecah[1]);
            return $tgl . ' ' . $bulan . ' ' . $thn;
        }
    }
    if (!function_exists('bulan_indo2')) {
        function bulan_indo2($tanggal)
        {
            date_default_timezone_set('Asia/Jakarta');
            $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
            $pecah = explode("-", $ubah);
            $tgl = $pecah[2];
            $thn = $pecah[0];
            $bulan = bulan_sort($pecah[1]);
            return $tgl . ' ' . $bulan;
        }
    }

    if (!function_exists('bulan_indo_miring')) {
        function bulan_indo_miring($tanggal)
        {
            date_default_timezone_set('Asia/Jakarta');
            $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
            $pecah = explode("-", $ubah);
            $tgl = $pecah[2];
            $thn = $pecah[0];
            $bulan = $pecah[1];
            return $tgl . '/' . $bulan . '/' . $thn;
        }
    }

    if (!function_exists('nilai_mutu')) {
        function nilai_mutu($nilai)
        {

            if ($nilai >= 85 && $nilai <= 100) {
                return 'A';
            } elseif ($nilai >= 75 && $nilai <= 84.9) {
                return 'B';
            } elseif ($nilai >= 60 && $nilai <= 74.9) {
                return 'C';
            } elseif ($nilai >= 50.1 && $nilai <= 59.9) {
                return 'D';
            } else {
                return 'E';
            }
        }
    }
    if (!function_exists('hari')) {
        function hari($tanggal)
        {
            $hari   = date('l', microtime($tanggal));
            $hari_indonesia = array(
                'Monday'  => 'Senin',
                'Tuesday'  => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu'
            );
            return $hari_indonesia[$hari];
        }
    }
    if (!function_exists('deadline')) {
        function deadline($tanggal_deadline)
        {
            $date = date('Y-m-d');
            // 25 < 26 = benar
            // 25 > 26 = salah
            if ($date <= $tanggal_deadline) {
                return true;
            } else {
                return false;
            }
        }
    }
}
