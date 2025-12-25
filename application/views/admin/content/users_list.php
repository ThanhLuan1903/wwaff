<?php
$sort = $this->session->userdata('sort');
$order = $this->session->userdata('order');
$where = $this->session->userdata('where');
?>

<style>
    .draw-back {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: white;
        z-index: 999;
        opacity: 0.7;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .filter-section {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }

    .filter-row:last-child {
        margin-bottom: 0;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .filter-group label {
        margin: 0;
        font-weight: normal;
        white-space: nowrap;
    }

    .filter-group select {
        min-width: 100px;
    }

    .checkbox-filters {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-box {
        display: flex;
        gap: 5px;
    }

    .search-box input {
        width: 200px;
    }

    .sorting-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #ddd;
    }

    .sorting-filters .filter-group {
        gap: 8px;
    }

    .sorting-filters .filter-group select {
        min-width: 100px;
    }
</style>

<div class="row">
    <div class="draw-back">
        <img src="<?php echo base_url(); ?>temp/admin/images/loading.gif" alt="" height="100px" width="100px">
        Loading...
    </div>
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>Members</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/addusers/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <!-- Filter Section -->
            <div class="filter-section">
                <form class="form-inline" role="form" id="sdt">
                    <!-- Row 1: Records per page, Checkboxes, Search -->
                    <div class="filter-row">
                        <div class="filter-group">
                            <select name="show_num" class="form-control input-sm">
                                <?php
                                $limit = $this->session->userdata('limit');
                                for ($i = 1; $i < 11; $i++) {
                                    $val = $i * 10;
                                    $selected = ($val == $limit['0']) ? ' selected' : '';
                                    echo "<option value=\"{$val}\"{$selected}>{$val}</option>";
                                }
                                ?>
                            </select>
                            <label>per page</label>
                        </div>

                        <div class="checkbox-filters">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="balance" value="1" <?= !empty($where['balance >']) ? 'checked' : '' ?>> Balance
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="pending" value="1" <?= !empty($where['pending >']) ? 'checked' : '' ?>> Pending
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="curent" value="1" <?= !empty($where['curent >']) ? 'checked' : '' ?>> Current
                            </label>
                        </div>

                        <div class="search-box">
                            <input name="keycode" class="form-control input-sm" id="keys" placeholder="ID or Email"
                                value="<?= $this->session->userdata('like') ?: '' ?>" />
                            <a class="timkiem btn btn-primary btn-sm">Search</a>
                            <a class="reset-filter btn btn-warning btn-sm">Reset</a>
                        </div>
                    </div>

                    <!-- Row 2: Sorting -->
                    <div class="sorting-filters">
                        <strong><i class="glyphicon glyphicon-sort"></i> Sort by:</strong>

                        <div class="filter-group">
                            <label>Level</label>
                            <select class="form-control input-sm sorting" name="level">
                                <option value="">--</option>
                                <option value="desc" <?= $sort == 'level' && $order == 'desc' ? 'selected' : '' ?>>High-Low</option>
                                <option value="asc" <?= $sort == 'level' && $order == 'asc' ? 'selected' : '' ?>>Low-High</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>EPC</label>
                            <select class="form-control input-sm sorting" name="epc">
                                <option value="">--</option>
                                <option value="desc" <?= $sort == 'epc' && $order == 'desc' ? 'selected' : '' ?>>High-Low</option>
                                <option value="asc" <?= $sort == 'epc' && $order == 'asc' ? 'selected' : '' ?>>Low-High</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>CR</label>
                            <select class="form-control input-sm sorting" name="conversion_rate">
                                <option value="">--</option>
                                <option value="desc" <?= $sort == 'conversion_rate' && $order == 'desc' ? 'selected' : '' ?>>High-Low</option>
                                <option value="asc" <?= $sort == 'conversion_rate' && $order == 'asc' ? 'selected' : '' ?>>Low-High</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Rating</label>
                            <select class="form-control input-sm sorting" name="rating">
                                <option value="">--</option>
                                <option value="desc" <?= $sort == 'rating' && $order == 'desc' ? 'selected' : '' ?>>High-Low</option>
                                <option value="asc" <?= $sort == 'rating' && $order == 'asc' ? 'selected' : '' ?>>Low-High</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Decline Rate</label>
                            <select class="form-control input-sm sorting" name="decline_rate">
                                <option value="">--</option>
                                <option value="desc" <?= $sort == 'decline_rate' && $order == 'desc' ? 'selected' : '' ?>>High-Low</option>
                                <option value="asc" <?= $sort == 'decline_rate' && $order == 'asc' ? 'selected' : '' ?>>Low-High</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Filter Section -->

            <table class="table table-striped table-bordered">
                <thead>
                    <tr role="row">
                        <th>Id</th>
                        <th>Decline Rate</th>
                        <th>Email address</th>
                        <th style="max-width: 60px">Website</th>
                        <th>Skype</th>
                        <th>Date</th>
                        <th>Manager</th>
                        <th>Balance</th>
                        <th>Pending</th>
                        <th>Current</th>
                        <th>Level</th>
                        <th>Rating</th>
                        <th>EPC</th>
                        <th>CR</th>
                        <th style="width: 97px;">DisLead(%)</th>
                        <th style="width: 105px;">Status</th>
                        <th style="width: 105px;">Last Update</th>
                        <th style="width: 105px;">Registered Date</th>
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dulieu)) {
                        foreach ($dulieu as $dulieu) {
                            $info = unserialize($dulieu->mailling);
                    ?>
                            <tr>
                                <td><?php echo $dulieu->id; ?></td>
                                <td>
                                    <?php
                                    if ($dulieu->decline_rate === null) {
                                        echo '<span class="label label-default">N/A</span>';
                                    } elseif ($dulieu->decline_rate >= 50) {
                                        echo '<span class="label label-danger">' . $dulieu->decline_rate . '%</span>';
                                    } elseif ($dulieu->decline_rate >= 30) {
                                        echo '<span class="label label-warning">' . $dulieu->decline_rate . '%</span>';
                                    } else {
                                        echo '<span class="label label-success">' . $dulieu->decline_rate . '%</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $dulieu->email; ?></td>
                                <td><?php echo $info['website']; ?></td>
                                <td><?php echo $info['im_service']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($dulieu->created)); ?></td>
                                <td class="manager">
                                    <select id="<?php echo $dulieu->id; ?>" class="manager">
                                        <option value="0">None</option>
                                        <?php
                                        /** @var array $category */
                                        foreach ($category as $manager) {
                                            echo '<option value="' . $manager->id . '" ';
                                            echo $manager->id == $dulieu->manager ? ' selected ' : '';
                                            echo ' >' . $manager->title . '</option>';
                                        } ?>
                                    </select>
                                </td>
                                <td>$
                                    <span class="s-<?php echo $dulieu->id; ?>">
                                        <?php echo round($dulieu->balance, 2); ?>
                                    </span>
                                    <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id; ?>"></span>
                                </td>
                                <td>$
                                    <span class="s-<?php echo $dulieu->id; ?>">
                                        <?php echo round($dulieu->pending, 2); ?>
                                    </span>
                                    <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id; ?>"></span>
                                </td>
                                <td>$
                                    <span class="s-<?php echo $dulieu->id; ?>">
                                        <?php echo round($dulieu->curent, 2); ?>
                                    </span>
                                    <span style="color: #5cb85c;" class="sl-<?php echo $dulieu->id; ?>"></span>
                                </td>
                                <td><?= $dulieu->level ?></td>
                                <td><?= $dulieu->rating ?></td>
                                <td><?= $dulieu->epc ?></td>
                                <td><?= round($dulieu->conversion_rate, 2) ?>%</td>
                                <td>
                                    <input style="width: 50px;" value="<?php echo $dulieu->dislead; ?>" />
                                    <a id="<?php echo $dulieu->id; ?>" class="btn btn-info btn-xs dislead" title="OK">
                                        <i class="glyphicon glyphicon-plus glyphicon-white"></i>
                                    </a>
                                </td>
                                <td class="approv">
                                    <?php
                                    if ($dulieu->status == 0) {
                                        echo '<span class="label label-warning">Pending</span>';
                                    }
                                    if ($dulieu->status == 1) {
                                        echo '<span class="label label-success">Approved</span>';
                                    }
                                    if ($dulieu->status == 2) {
                                        echo '<span class="label label-default">Pause</span>';
                                    }
                                    if ($dulieu->status == 3) {
                                        echo '<span class="label label-danger">Banned</span>';
                                    }
                                    if ($dulieu->status == 4) {
                                        echo '<span class="label label-danger">Rejected</span>';
                                    }
                                    ?>
                                    <span class="glyphicon glyphicon-cog approved" style="float: right;position:relative;cursor: pointer;"></span>
                                    <select id="<?php echo $dulieu->id; ?>" class="sapproved update-user-status" style="display: none;">
                                        <option value="0">Pending</option>
                                        <option value="1" <?php echo $dulieu->status == 1 ? 'selected' : ''; ?>>Approved</option>
                                        <option value="2" <?php echo $dulieu->status == 2 ? 'selected' : ''; ?>>Pause</option>
                                        <option value="3" <?php echo $dulieu->status == 3 ? 'selected' : ''; ?>>Banned</option>
                                        <option value="4" <?php echo $dulieu->status == 4 ? 'selected' : ''; ?>>Reject</option>
                                    </select>
                                </td>
                                <td><?= $dulieu->updated_at; ?></td>
                                <td><?= $dulieu->created_at; ?></td>
                                <td>
                                    <a data-email="<?php echo $dulieu->email; ?>" title="<?php echo $dulieu->id; ?>" class="btn btn-success btn-xs invoice">
                                        <i class="glyphicon glyphicon-euro glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . $this->config->item('admin') . '/viewmember/publisher/' . $dulieu->id; ?>" class="btn btn-success btn-xs" target=_blank>
                                        <i class="glyphicon glyphicon-eye-open glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . $this->config->item('admin') . '/showev/tracklink/' . $dulieu->id; ?>" class="btn btn-success btn-xs">
                                        <i class="glyphicon glyphicon-zoom-in glyphicon-white"></i>
                                    </a>
                                    <a class="btn btn-info btn-xs usermodal" title="<?php echo $dulieu->id; ?>">
                                        <i class="glyphicon glyphicon-edit glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . $this->config->item('admin') . '/route/' . $this->uri->segment(3) . '/delete/' . $dulieu->id; ?>" class="btn btn-danger btn-xs del">
                                        <i class="glyphicon glyphicon-trash glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . 'cron-jobs/calculator/publishers/' . $dulieu->id; ?>" class="btn btn-success btn-xs refresh">
                                        <i class="glyphicon glyphicon-refresh glyphicon-white"></i>
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

<script>
    $(document).ready(function() {
        $('.draw-back').fadeOut();
        sorting();
        refresh();
        resetFilter();
    });

    const sorting = () => {
        $('.sorting').change(function() {
            const value = $(this).val();
            const name = $(this).attr('name');

            $.ajax({
                method: 'POST',
                url: `<?= base_url('admin/search/users') ?>`,
                data: {
                    sort: name,
                    order: value,
                },
                success: function(data) {
                    window.location.reload();
                }
            })
        })
    }

    const refresh = () => {
        $('.refresh').click(function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            $.ajax({
                method: "GET",
                url,
                beforeSend: function() {
                    $('.draw-back').fadeIn();
                },
                success: function(data) {
                    window.location.reload();
                }
            })
        });
    }

    const resetFilter = () => {
        $('.reset-filter').click(function() {
            // Reset checkboxes
            $('input[name="balance"]').prop('checked', false);
            $('input[name="pending"]').prop('checked', false);
            $('input[name="curent"]').prop('checked', false);

            // Reset search input
            $('input[name="keycode"]').val('');

            // Reset all sorting dropdowns
            $('.sorting').val('');

            // Submit to server to clear session
            $.ajax({
                method: 'POST',
                url: `<?= base_url('admin/search/users') ?>`,
                data: {
                    reset: 1
                },
                beforeSend: function() {
                    $('.draw-back').fadeIn();
                },
                success: function(data) {
                    // Redirect về trang 1
                    window.location.href = '<?= base_url('admin/route/users/list') ?>';
                }
            });
        });
    }
</script>