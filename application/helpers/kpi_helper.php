<?php

function cekJenisCustomer($nama_customer, $jumlah_hari, $no_smu)
{
    // cek prioritas
    $prioritas_cek = customerPrioritas($nama_customer);
    if ($prioritas_cek) {
        return kpiPodPrioritas($jumlah_hari);
    }
    // cek reguler
    $Reguler_cek = customerReguler($nama_customer);
    if ($Reguler_cek) {
        return kpiPodReguler($jumlah_hari);
    }
    // agen
    if ($no_smu != "TLX") {
        return kpiPodAgen($jumlah_hari);
    }
}

function kpiPodPrioritas($jumlah_hari)
{
    if ($jumlah_hari >= 0 && $jumlah_hari <= 7) {
        return "A";
    } elseif ($jumlah_hari >= 8 && $jumlah_hari <= 10) {
        return "B";
    } elseif ($jumlah_hari >= 11 && $jumlah_hari <= 14) {
        return "C";
    } else {
        return "D";
    }
}
function kpiPodReguler($jumlah_hari)
{
    if ($jumlah_hari >= 1 && $jumlah_hari <= 10) {
        return "A";
    } elseif ($jumlah_hari >= 11 && $jumlah_hari <= 20) {
        return "B";
    } elseif ($jumlah_hari >= 21 && $jumlah_hari <= 27) {
        return "C";
    } else {
        return "D";
    }
}
function kpiPodAgen($jumlah_hari)
{
    if ($jumlah_hari >= 1 && $jumlah_hari <= 3) {
        return "A";
    } elseif ($jumlah_hari >= 4 && $jumlah_hari <= 5) {
        return "B";
    } elseif ($jumlah_hari >= 6 && $jumlah_hari <= 7) {
        return "C";
    } else {
        return "D";
    }
}


function customerPrioritas($nama_customer)
{
    $customer = [
        'ENDRESS HAUSER', 'ENDRESS TEMPO', 'ENDRESS DIMET BINTARO', 'ENDRESS HAUSER FRISIAN FLAG', 'ENDRESS HAUSER IBU RINDI',
        'ENDRESS HAUSER (INDO WORLD)', 'ENDRESS HAUSER (BDO)', 'DERMANESIA', 'BERCA', 'GEODIS', 'NETZSCH INDONESIA', 'CJ JOHNSON', 'GEODIS(SURABAYA)', 'GEODIS(MUARA ENIM)', 'GEODIS (PREMIER OIL)',
        'GEODIS (MANGGAR)'
    ];
    $cek_customer = in_array($nama_customer, $customer);
    return $cek_customer;
}
function customerReguler($nama_customer)
{
    $customer = [
        'GRAMEDIA', 'SCHENKER MAP', 'SCHENKER GPOG', 'SCHENKER POSB', 'SCHENKER ABB', 'SCHENKER EXPRO', 'SCHENKER AF', 'SCHENKER APPLE', 'SCHENKER MASSIMO',
        'SCHENKER POSB(sorong)', 'SCHENKER AF (ABB SAKTI SUB)', 'SCHENKER AF(JEPARA)', 'Schenker AF(Balikpapan)', 'SCHENKER AF (BANDUNG)', 'TELENET', 'TELENET JAYAPURA',
        'TELENET (DPS)', 'TELENET SORONG', 'Telenet (Prambanan)', 'TAB', 'TAB (CIPTA KRIDA SOMBER)', 'TAB (CIREBON)', 'TAB (SUB)', 'WHO', 'WHO (MAMUJU)', 'MOBILKOM',
        'MOBILKOM (SOROWAKO)', 'MOBILKOM(LUWU)', 'X-SELL', 'YAMATO', 'GRAMEDIA PALMERAH', 'PT GRAMEDIA PALMERAH', 'PT GRAMEDIA', 'TELENET (PRAMBANAN)', 'TELENET SORONG',
        'TAB AJENG', 'TAB SUB'
    ];
    $cek_customer = in_array($nama_customer, $customer);
    return $cek_customer;
}

function customerEndress($nama_customer)
{
    $customer = [
        'ENDRESS HAUSER', 'ENDRESS TEMPO', 'ENDRESS DIMET BINTARO', 'ENDRESS HAUSER FRISIAN FLAG', 'ENDRESS HAUSER IBU RINDI',
        'ENDRESS HAUSER (INDO WORLD)', 'ENDRESS HAUSER (BDO)'
    ];
    $cek_customer = in_array($nama_customer, $customer);
    return $cek_customer;
}
