<table class="table table-separate table-head-custom table-checkable" id="myTable">
    <h3>GENERATE RESI NUMBER <?= $generate[0]['customer'] ?></h3>

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <thead>
        <tr>
            <th>Shipment ID</th>
            <th>Status</th>
            <th>Created At</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($generate as $gn) {
        ?>
            <tr>

                <td><?= $gn['shipment_id'] ?></td>
                <td><?= ($gn['status'] == 1) ? 'Unavailable' : 'Available'; ?></td>
                <td><?= $gn['created_at'] ?></td>

            </tr>
        <?php } ?>

    </tbody>
</table>