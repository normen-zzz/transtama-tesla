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
                    <form action="<?= base_url('shipper/Order/asignDriverGenerateResi') ?>" method="post">
                        <div class="col ml-0 mb-2">
                            <?php $users =  $this->db->get_where('tb_user', ['id_role' => 2])->result_array(); ?>
                            <label for="id_driver"></label>
                            <select name="id_driver" class="form-control" style="width: 200px;">
                                <?php foreach ($users as $u) {
                                ?>
                                    <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                                <?php    } ?>
                            </select>

                        </div>
                        <input type="hidden" name="group" value="<?= $this->uri->segment(4) ?>">


                        <button type="submit" class="btn btn-success mb-2"> <i class="fa fa-plus"></i> Assign Driver</button>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="myTable">

                            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No</th>
                                    <th>Shipment ID</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($generate as $gn) {
                                    $driver = $this->db->get_where('tb_user', array('id_user' => $gn['id_driver']))->row_array();
                                ?>
                                    <?php if ($gn['status'] == 0) { ?>
                                        <tr>
                                            <td><input type="checkbox" value="<?= $gn['shipment_id'] ?>" name="shipment_id[]" id=""></td>
                                            <td><?= $no; ?></td>

                                            <td><?php if ($gn['status'] == 0) { ?><a href="<?= base_url('shipper/Order/printSatuanGenerateResi/' . $gn['shipment_id']) ?>"><?= $gn['shipment_id'] ?></a><?php } else {
                                                                                                                                                                                                        echo $gn['shipment_id'];
                                                                                                                                                                                                    } ?></td>
                                            <td>
                                                <span class="label label-success label-inline font-weight-lighter mb-2">Available</span>
                                                <?php if ($gn['id_driver'] > 0) { ?>
                                                    <span class="label label-warning label-inline font-weight-lighter">Assigned To <?= $driver['nama_user'] ?></span>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                <?php $no++;
                                    }
                                } ?>

                            </tbody>
                        </table>
                        <!--end: Datatable-->
                </div>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>