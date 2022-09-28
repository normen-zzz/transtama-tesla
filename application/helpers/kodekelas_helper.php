<?php

function generatKode()
{
    $CI = &get_instance();

    $kode_unik = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890zyxwvutsrqponmlkjihgfedcba@!"), 0, 6);
    return $kode_unik;
}
