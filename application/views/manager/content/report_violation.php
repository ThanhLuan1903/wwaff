<style>
    .table,
    .table th,
    .table td,
    .table thead tr th,
    .table tbody tr td {
        font-size: 12px !important;
        padding: 4px !important;
    }

    .details-cell {
        white-space: nowrap !important;
        text-align: center !important;
    }

    .details-info {
        display: inline-flex !important;
        flex-wrap: nowrap !important;
        justify-content: center !important;
        overflow: hidden !important;
        width: 100% !important;
    }

    .details-info span {
        display: inline-block !important;
        margin: 0 2px !important;
        flex-shrink: 0 !important;
    }

    .details-info span {
        background-color: #fafafa;
        padding: 2px 4px;
        border-radius: 4px;
        font-size: 12px;
        border: 1px solid #d1e7dd;
    }

    tr[role="row"] th {
        text-align: center;
        vertical-align: middle;
    }

    .col-md-12 .btn-active {
        background: #044264;
        box-shadow: 0px 2px 3px 0px #337ab7;
        color: #fafafa;
    }

    .back_device {
        background-color: #FFFBEA !important;
    }

    .back_cr {
        background-color: #e0f7fa !important;
    }

    .back_ip {
        background-color: #E8F6F3 !important;
    }
</style>
<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-exclamation-triangle"></i><span class="break"></span>Error Notification</h2>
            <div class="box-icon">
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">

                <div class="col-md-12" style="margin-bottom: 15px; margin-top: 15px; ">
                    <div class="btn-group" role="group">
                        <a href="<?= base_url('manager/dashboard/show/all') ?>"
                            class="btn btn-sm <?= (!isset($current_type) || $current_type == 'all') ? 'btn-active' : 'btn-default' ?>">
                            All Violations
                        </a>
                        <a href="<?= base_url('manager/dashboard/show/brower') ?>"
                            class="btn btn-sm <?= (isset($current_type) && $current_type == 'brower') ? 'btn-active' : 'btn-default' ?>">
                            Unknow Browser
                        </a>
                        <a href="<?= base_url('manager/dashboard/show/device') ?>"
                            class="btn btn-sm <?= (isset($current_type) && $current_type == 'device') ? 'btn-active' : 'btn-default' ?>">
                            Duplicate Device
                        </a>
                        <a href="<?= base_url('manager/dashboard/show/cr') ?>"
                            class="btn btn-sm <?= (isset($current_type) && $current_type == 'cr') ? 'btn-active' : 'btn-default' ?>">
                            CR Violations
                        </a>
                        <a href="<?= base_url('manager/dashboard/show/ip') ?>"
                            class="btn btn-sm <?= (isset($current_type) && $current_type == 'ip') ? 'btn-active' : 'btn-default' ?>">
                            Duplicate IP
                        </a>
                        <a href="<?= base_url('manager/dashboard/charts') ?>" class="btn btn-sm btn-info">
                            <i class="glyphicon glyphicon-stats"></i> Analytics
                        </a>
                        <!-- <a href="<?= base_url('manager/dashboard/contact') ?>" class="btn btn-sm" style="background-color: #9c54e5; color:#fafafa;">
                            <i class="glyphicon glyphicon-comment"></i> Contact
                        </a> -->
                    </div>
                </div>

                <div class="col-md-12">
                    <form class="form-inline" method="post" action="<?php echo base_url('adm_mng/dashboard/search'); ?>" role="form">
                        <span class="form-group col-md-2">
                            <label>Start Date</label>
                            <input id="startdate" type="text" name="from" class="form-control input-sm" value="<?php
                                                                                                                if ($this->session->userdata('error_from')) {
                                                                                                                    echo $this->session->userdata('error_from');
                                                                                                                } else {
                                                                                                                    echo date('Y-m-d', strtotime('-7 days')); // Mặc định 7 ngày trước
                                                                                                                }
                                                                                                                ?>" />
                        </span>
                        <span class="form-group col-md-2">
                            <label>End Date</label>
                            <input id="enddate" type="text" name="to" class="form-control input-sm" value="<?php
                                                                                                            if ($this->session->userdata('error_to')) {
                                                                                                                echo $this->session->userdata('error_to');
                                                                                                            } else {
                                                                                                                echo date('Y-m-d'); // Mặc định ngày hiện tại
                                                                                                            }
                                                                                                            ?>" />
                        </span>
                        <span class="form-group col-md-2">
                            <label>Pub ID</label>
                            <input class="form-control input-sm" name="pubid" type="text" value="<?php echo $this->session->userdata('error_pubid') ?>" />
                        </span>
                        <span class="form-group col-md-2">
                            <label>Offer ID</label>
                            <input class="form-control input-sm" name="oid" type="text" value="<?php echo $this->session->userdata('error_oid') ?>" />
                        </span>
                        <span class="form-group col-md-2">
                            <label>Sub 2</label>
                            <input class="form-control input-sm" name="sub2" type="text" value="<?php echo $this->session->userdata('error_sub2') ?>" />
                        </span>
                        <span class="form-group col-md-2" style="margin:20px 0;flex-direction: column">
                            <label>Status</label>
                            <select class="form-control input-sm" name="status" style="margin-left:10px">
                                <option value="all">All</option>
                                <option value="warning" <?php echo ($this->session->userdata('error_status') == 'warning') ? 'selected' : ''; ?>>Warning</option>
                                <option value="paused" <?php echo ($this->session->userdata('error_status') == 'paused') ? 'selected' : ''; ?>>Paused</option>
                            </select>
                        </span>
                        <div class="col-md-12 text-right" style="margin-top: 15px; margin-bottom: 15px;">
                            <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                            <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm">Reset</button>
                            <button type="submit" name="export" value="1" class="btn btn-info btn-sm">Export Excel</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th width="5%">No.</th>
                                <th width="10%">Pub ID</th>
                                <th width="10%">Offer ID</th>
                                <th width="10%">Sub 2</th>
                                <th width="15%">Error Type</th>
                                <th width="10%">Violation Count</th>
                                <th width="20%">Details</th>
                                <th width="10%">Status</th>
                                <th width="12%">Violation Time</th>
                                <th width="12%">Suspension Until</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = isset($start_count) ? $start_count : 1;
                            if (!empty($dulieu)) {
                                foreach ($dulieu as $item) {
                                    $rowClass = '';
                                    if ($item['error_type'] == 'CR Require') {
                                        $rowClass = 'back_cr';
                                    } elseif ($item['error_type'] == 'Duplicate Device' || $item['error_type'] == 'Spam') {
                                        $rowClass = 'back_device';
                                    } elseif ($item['error_type'] == 'Duplicate IP') {
                                        $rowClass = 'back_ip';
                                    }
                            ?>
                                    <tr class="count <?= $rowClass ?>">
                                        <td style="text-align: center; vertical-align: middle; padding: 5px"><?php echo $count++; ?></td>
                                        <td style="text-align: center; vertical-align: middle; padding: 5px"><?php echo $item['userid']; ?></td>
                                        <td style="text-align: center; vertical-align: middle; padding: 5px"><?php echo $item['offerid']; ?></td>
                                        <td style="text-align: center; vertical-align: middle; padding: 5px"><?php echo isset($item['sub2']) ? $item['sub2'] : ''; ?></td>
                                        <td style="text-align: center; vertical-align: middle; font-weight: 600; padding: 5px"><?php echo $item['error_type']; ?></td>
                                        <td style="text-align: center; vertical-align: middle;"> <?php echo $item['violation_count']; ?> </td>
                                        <td class="details-cell" style="vertical-align: middle;">
                                            <div class="details-info">
                                                <?php if ($item['error_type'] == 'CR Require'): ?>
                                                    <span>Click: <?php echo isset($item['clicks']) ? $item['clicks'] : '0'; ?></span>
                                                    <span>Lead: <?php echo isset($item['leads']) ? $item['leads'] : '0'; ?></span>
                                                    <span>CR: <?php echo isset($item['cr_value']) ? $item['cr_value'] : '0'; ?>%</span>
                                                <?php elseif ($item['error_type'] == 'Duplicate Device' || $item['error_type'] == 'Spam'): ?>
                                                    <span>OS Name: <?php echo isset($item['os_name']) ? $item['os_name'] : ''; ?></span>
                                                    <span>Browser: <?php echo isset($item['browser']) ? $item['browser'] : ''; ?></span>
                                                    <span>Version: <?php echo isset($item['browserversion']) ? $item['browserversion'] : ''; ?></span>
                                                    <?php if ($item['count']): ?>
                                                        <span>Duplicate count: <?php echo isset($item['count']) ? $item['count'] : ''; ?></span>
                                                    <?php endif; ?>
                                                <?php elseif ($item['error_type'] == 'Duplicate IP'): ?>
                                                    <span>IP: <?php echo isset($item['ip_address']) ? $item['ip_address'] : ''; ?></span>
                                                    <span>Duplicate count: <?php echo isset($item['duplicate_count']) ? $item['duplicate_count'] : ''; ?></span>
                                                    <span>Month: <?php echo isset($item['month_period']) ? $item['month_period'] : ''; ?></span>
                                                <?php elseif ($item['error_type'] == 'Unknow Browser'): ?>
                                                    <span>Browser: <?php echo isset($item['Browser']) ? $item['Browser'] : ''; ?></span>
                                                    <span>OS Name: <?php echo isset($item['OS']) ? $item['OS'] : ''; ?></span>
                                                    <span>Leads: <?php echo isset($item['leads']) ? $item['leads'] : ''; ?></span>
                                                <?php else: ?>
                                                    <?php echo isset($item['details']) ? $item['details'] : ''; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <span style="padding: 3px 8px; border-radius: 4px; font-size: 13px;"><?php echo ucfirst($item['status']); ?></span>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle; font-size: 14px; color: #6c757d;">
                                            <?php echo date('d/m/Y', strtotime($item['violation_time'])); ?><br>
                                            <?php echo date('H:i:s', strtotime($item['violation_time'])); ?>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle; font-size: 14px; color: #6c757d;">
                                            <?php echo date('d/m/Y', strtotime($item['suspension_until'])); ?><br>
                                            <?php echo date('H:i:s', strtotime($item['suspension_until'])); ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10" style="text-align: center;">No data found</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div style="margin:20px 0;float:left" class="form-group form-inline filters">
                        <select name="filter_cat" size="1" class="form-control">
                            <option value="0">All</option>
                            <option value="warning">Warning</option>
                            <option value="paused">Paused</option>
                        </select>
                        <label>Status Filter</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script>
    $(function() {
        $("#startdate").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: <?php echo json_encode(date('Y-m-d', strtotime('-7 days'))); ?>
        });

        $("#enddate").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: <?php echo json_encode(date('Y-m-d')); ?>
        });

        $("table tbody tr").each(function() {
            var statusCell = $(this).find("td:nth-child(8)");
            var statusText = statusCell.find("span").text().trim().toLowerCase();

            if (statusText === "warning" || statusText === "suspended") {
                $(this).css("background-color", "#fff8e8");

                statusCell.find("span").css({
                    "background-color": "#fff3cd",
                    "color": "#856404",
                    "border": "1px solid #ffeeba",
                });
            } else if (statusText === "paused" || statusText === "denied") {
                $(this).css("background-color", "#fee8e7");

                statusCell.find("span").css({
                    "background-color": "#f8d7da",
                    "color": "#721c24",
                    "border": "1px solid #f5c6cb",
                });
            }
        });

        $('select[name="filter_cat"]').on('change', function(e) {
            e.preventDefault();
            var selectedStatus = $(this).val();
            console.log("Đã chọn trạng thái:", selectedStatus);

            if (selectedStatus === '0') {
                $('table tbody tr').show();
                return;
            }

            $('table tbody tr').hide();

            $('table tbody tr').each(function() {
                var rowStatus = $(this).find('td:nth-child(8) span').text().trim().toLowerCase();
                if (rowStatus === selectedStatus.toLowerCase()) {
                    $(this).show();
                }
            });
        });
    });
</script>