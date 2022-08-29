<table border="1">
    <thead>
        <tr>
            <th>Shipment ID</th>
            <th>Shipper</th>
            <th>Consignee</th>
            <th>Freight/Kg</th>
            <th>Special Freight/Kg</th>
            <th>Packing</th>
            <th>Insurance</th>
            <th>Surcharge</th>
            <th>Discount</th>
            <th>Commision (%)</th>
            <th>Other</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shipments as $shp) {
        ?>
            <tr>
                <td><?= $shp['shipment_id'] ?></td>
                <td><?= $shp['shipper'] ?></td>
                <td><?= $shp['consigne'] ?>/ <?= $shp['city_consigne'] ?></td>
                <td>
                    <?= $shp['freight_kg'] ?>
                </td>
                <td>
                    <?= $shp['special_freight'] ?>
                </td>
                <td>
                    <?= $shp['packing'] ?>
                </td>
                <td>
                    <?= $shp['insurance'] ?>
                </td>
                <td>
                    <?= $shp['surcharge'] ?>
                </td>
                <td>
                    <?= $shp['disc'] ?>
                </td>
                <td>
                    <?= $shp['cn'] ?>
                </td>
                <td>
                    <?= $shp['others'] ?>
                </td>
                <td>
                    <?= $shp['so_note'] ?>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>