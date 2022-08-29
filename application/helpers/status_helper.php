<?php

function status($status)
{
    if ($status == 0) {
        return 'Pengajuan';
    } elseif ($status == 1) {
        return 'Divalidasi BAAK';
    } elseif ($status == 2) {
        return 'Terverifikasi';
    } else {
        return 'Sudah Dicetak';
    }
}


function statusAp($status, $is_approve)
{
    if ($status == 0) {
        return '<span class="label label-danger label-inline font-weight-lighter" style="height:30px">Request Ap</span>';
    } elseif ($status == 1) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px">Approve Manager</span>';
    } elseif ($status == 2) {
        if ($is_approve == 0) {
            return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px">Approve Manager</span>';
        } else {
            return '<span class="label label-secondary label-inline font-weight-lighter" style="height:30px">Approve SM</span>';
        }
    } elseif ($status == 3) {
        return '<span class="label label-warning label-inline font-weight-lighter" style="height:30px">Received Finance</span>';
    } elseif ($status == 6) {
        return '<span class="label label-secondary label-inline font-weight-lighter">Void</span>';
    } elseif ($status == 5) {
        return '<span class="label label-success label-inline font-weight-lighter" style="height:30px">Approve GM</span>';
    } elseif ($status == 7) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:40px">Approve Manager Finance</span>';
    } else {
        return '<span class="label label-success label-inline font-weight-lighter">Paid</span> <br>
        ';
    }
}
