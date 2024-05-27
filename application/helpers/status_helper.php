<?php




function statusAp($status, $is_approve)
{
    if ($status == 0) {
        return '<span class="label label-danger label-inline font-weight-lighter" style="height:30px; ">Request Ap</span>';
    } elseif ($status == 1) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px;background-color:#00a9bf;">Approved By Manager</span>';
    } elseif ($status == 2) {
        if ($is_approve == 0) {
            return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px;background-color:#00a9bf;">Approved By Manager</span>';
        } else {
            return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px; background-color:#ff4d00">Approved By SM</span>';
        }
    } elseif ($status == 3) {
        return '<span class="label label-warning label-inline font-weight-lighter" style="height:30px">Received By Finance</span>';
    } elseif ($status == 6) {
        return '<span class="label label-secondary label-inline font-weight-lighter">Void</span>';
    } elseif ($status == 5) {
        return '<span class="label label-success label-inline font-weight-lighter" style="height:30px; background-color:#7c4dff;">Approved By GM</span>';
    } elseif ($status == 7) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:40px">Approved By Manager Finance</span>';
    } else {
        return '<span class="label label-success label-inline font-weight-lighter">Paid</span>
        ';
    }
}

function statusRequestPrice($status)
{
    if ($status == 0) {
        return '<span class="label label-danger label-inline font-weight-lighter" style="height:30px; ">Requested</span>';
    } elseif ($status == 1) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px;background-color:#00a9bf;">Submitted By CS</span>';
    } elseif ($status == 2) {
        return '<span class="label label-primary label-inline font-weight-lighter" style="height:30px; background-color:#ff4d00">Approved By Sales</span>';
    } elseif ($status == 3) {
        return '<span class="label label-void label-inline font-weight-lighter" style="height:30px">Decline By Sales</span>';
    } elseif ($status == 4) {
        return '<span class="label label-warning label-inline font-weight-lighter">SO Created</span>';
    } elseif ($status == 5) {
        return '<span class="label label-void label-inline font-weight-lighter" style="height:30px">Decline By Cs</span>';
    }
}
