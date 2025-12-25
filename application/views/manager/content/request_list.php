<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-phone-alt"></i><span class="break"></span>Manager</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/add/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3); ?>" name="show_num" size="1" class="form-control input-sm">
                            <?php
                            $limit = $this->session->userdata('limit');
                            for ($i = 1; $i < 11; $i++) {
                                echo '<option value="' . $i * (10) . '"';
                                echo $i * (10) == $limit['0'] ? ' selected="selected"' : '';
                                echo '>' . $i * (10) . '</option>';
                            }
                            ?>
                        </select>
                        <label>records per page</label>
                    </div>
                </div>

            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Text RQ</th>
                        <th>Offer Name</th>
                        <th>Offer ID</th>
                        <th>Categories</th>
                        <th>User ID</th>
                        <th>Network</th>
                        <th>Status</th>
                        <th>IP</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th style="width: 40px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dulieu)) {
                        foreach ($dulieu as $dulieu) {
                            if ($dulieu->status == 'Approved') {
                                $cllk = "success";
                            } elseif ($dulieu->status == 'Deny') {
                                $cllk = "danger";
                            } elseif ($dulieu->status == 'Pending') {
                                $cllk = "warning";
                            }
                    ?>
                            <tr class="<?php echo $cllk; ?>">
                                <td><?php echo $dulieu->id; ?></td>
                                <td style="overflow-wrap: anywhere;"><?php echo $dulieu->crequest; ?></td>
                                <td><?php echo $dulieu->offer_title; ?></td>
                                <td><?php echo $dulieu->offerid; ?></td>
                                <td><?php echo $dulieu->category_titles; ?></td>
                                <td><?php echo $dulieu->userid; ?></td>
                                <td><?php echo $dulieu->network_title; ?></td>
                                <td>
                                    <select id="<?php echo $dulieu->id; ?>" class="rqst">
                                        <option value="Pending">Pending</option>
                                        <option <?php echo $dulieu->status == 'Approved' ? ' selected ' : ''; ?> value="Approved">Approved</option>
                                        <option <?php echo $dulieu->status == 'Deny' ? ' selected ' : ''; ?> value="Deny">Deny</option>
                                    </select>
                                </td>
                                <td><?php echo $dulieu->ip; ?></td>
                                <td><?php if (strpos($dulieu->check_trung, 'm')) echo 'SmartOff'; ?></td>
                                <td><?php echo $dulieu->date; ?></td>
                                <td>
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/delete/' . $dulieu->id; ?>" class="btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php    }
                    }
                    ?>

                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                        <select title="<?php echo $this->uri->segment(3); ?>" name="filter_cat" size="1" class="form-control input-sm">
                            <option value="0">all</option>
                            <?php
                            if (!empty($category)) {
                                $where = $this->session->userdata('where');

                                foreach ($category as $category1) {
                                    echo '<option value="' . $category1->id . '"';
                                    if (!empty($where['manager'])) {
                                        echo $where['manager'] == $category1->id ? ' selected' : '';
                                    }
                                    echo '>' . $category1->title . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class=" pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>