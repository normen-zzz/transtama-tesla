<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label"><?= $title . ' ' . $generate[0]['customer'] ?>
                            <span class="d-block text-muted pt-2 font-size-sm"></span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="<?= base_url('superadmin/order/generate') ?>" class="btn font-weight-bolder text-light" style="background-color: #9c223b;">
                            <span class="svg-icon svg-icon-md">
                                <i class="fa fa-arrow-left text-light"></i>
                                <!--end::Svg Icon-->
                            </span>Back</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body" style="overflow: auto;">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="myTable">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <thead>
                            <tr>
                                <th>Shipment ID</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($generate as $gn) {
                            ?>
                                <tr>

                                    <td><?php if ($gn['status'] == 0) { ?><a href="<?= base_url('superadmin/Order/printSatuanGenerateResi/' . $gn['shipment_id']) ?>"><?= $gn['shipment_id'] ?></a><?php } else {
                                                                                                                                                                                                    echo $gn['shipment_id'];
                                                                                                                                                                                                } ?></td>
                                    <td>
                                        <?php if ($gn['status'] == 0) {
                                            echo ' <span class="label label-success label-inline font-weight-lighter">Available</span>';
                                        } else {
                                            echo ' <span class="label label-danger label-inline font-weight-lighter">Unavailable</span>';
                                        } ?>


                                    </td>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>