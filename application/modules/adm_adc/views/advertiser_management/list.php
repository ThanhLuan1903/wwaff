<?php $managers = $this->Home_model->get_data('manager'); ?>
<style>
    .flex-justify-center {
        display: flex;
        justify-content: center;
    }

    .table-center tbody tr td,
    .table-center tbody tr th {
        vertical-align: middle !important;
    }

    .custom-filter {
        display: flex;
        align-items: center;
    }

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
</style>
<?php
$sort = $this->session->userdata('sort');
$order = $this->session->userdata('order');
?>
<div class="row">
    <div class="draw-back">
        <img src="<?php echo base_url(); ?>temp/admin/images/loading.gif" alt="" height="100px" width="100px">
        Loading...
    </div>
    <div class="box col-md-12">
        <?php if ($this->session->userdata('flash:old:success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= $this->session->userdata('flash:old:success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->userdata('flash:old:error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->userdata('flash:old:error'); ?>
            </div>
        <?php endif; ?>

        <div class="box-header">
            <h2><i class="glyphicon glyphicon-user"></i><span class="break"></span>List Avertiser</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/advertiser/add_new_advertiser/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <br>
            <div class="row">
                <div class="col-md-4">
                    <form action="<?= base_url('admin/advertiser/list_account') ?>" method="POST">
                        <div class="col-md-10"><input name="keycode" class="form-control" id="keys" placeholder="ID or Email" value="<?= $this->session->userdata('keycode') ?>" /></div>
                        <div class="col-md-2"><button class="btn btn-default">Search</button></div>
                    </form>
                </div>
                <div class="col-md-2 row custom-filter">
                    <label class="col-md-4" for="">Balance</label>
                    <div class="col-md-8">
                        <select class="form-control input-sm sorting" name="balance">
                            <option value="">Sorting...</option>
                            <option value="desc" <?= $sort == 'balance' && $order == 'desc' ? 'selected' : '' ?>>DESC</option>
                            <option value="asc" <?= $sort == 'balance' && $order == 'asc' ? 'selected' : '' ?>>ASC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 row custom-filter">
                    <label class="col-md-4" for="">Available</label>
                    <div class="col-md-8">
                        <select class="form-control input-sm sorting" name="available">
                            <option value="">Sorting...</option>
                            <option value="desc" <?= $sort == 'available' && $order == 'desc' ? 'selected' : '' ?>>DESC</option>
                            <option value="asc" <?= $sort == 'available' && $order == 'asc' ? 'selected' : '' ?>>ASC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 row custom-filter">
                    <label class="col-md-4" for="">Holding</label>
                    <div class="col-md-8">
                        <select class="form-control input-sm  sorting" name="holding">
                            <option value="">Sorting...</option>
                            <option value="desc" <?= $sort == 'holding' && $order == 'desc' ? 'selected' : '' ?>>DESC</option>
                            <option value="asc" <?= $sort == 'holding' && $order == 'asc' ? 'selected' : '' ?>>ASC</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <table class="table table-striped table-bordered table-center">
                <thead>
                    <tr role="row">
                        <th scope="col" style="width: 50px">ID</th>
                        <th scope="col" style="width: 50px">Avatar</th>
                        <th scope="col" style="width: 50px">Email</th>
                        <th scope="col" style="width: 50px">UserName</th>
                        <th scope="col" style="width: 100px">Fullname</th>
                        <th scope="col" style="width: 50px">Phone</th>
                        <th scope="col" style="width: 150px">Account Type</th>
                        <th scope="col" id="sort-balance">Balance</th>
                        <th scope="col" id="sort-pending">Pending</th>
                        <th scope="col" id="sort-avaliable">Available</th>
                        <th scope="col" style="width: 50px">Manager</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 100px">Last Update</th>
                        <th scope="col" style="width: 50px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)) { ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No data.</td>
                        </tr>
                    <?php } else { ?>
                        <?php
                        foreach ($data as $dt) {
                        ?>
                            <tr>
                                <th scope="row">
                                    <!-- <a href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"> -->
                                    <?php echo $dt->id ?>
                                    <!-- </a> -->
                                </th>
                                <td>
                                    <?php if ($dt->avatar_url) { ?>
                                        <img src="<?php echo $dt->avatar_url; ?>" class="img-thumbnail product-img" alt="">
                                    <?php } ?>
                                </td>
                                <td><?php echo $dt->email; ?></td>
                                <td><?php echo $dt->username; ?></td>

                                <td><?php echo $dt->first_name . ' ' . $dt->last_name; ?></td>
                                <td>
                                    <a href="tel:<?php echo $dt->phone ?>"><?php echo $dt->phone ?></a>
                                </td>
                                <td><?php echo $dt->is_company ? 'Company' : 'Personal'; ?></td>
                                <td><?= $dt->pending + $dt->available ?></td>
                                <td><?= $dt->pending ?></td>
                                <td><?= $dt->available - $dt->invoice ?></td>
                                <td class="manager">
                                    <select id="<?php echo $dt->id; ?>" class="manager" data-advertiser="1">
                                        <option value="0">None</option>
                                        <?php foreach ($managers as $manager) {
                                            echo '
                                    <option value="' . $manager->id . '" ';
                                            echo $manager->id == $dt->manager ? ' selected ' : '';
                                            echo ' >' . $manager->username . '</option>
                                ';
                                        } ?>
                                    </select>
                                </td>

                                <td class="approv">
                                    <?php
                                    switch ($dt->status) {
                                        case 0:
                                            echo '<span class="label label-warning">Pending</span>';
                                            break;
                                        case 1:
                                            echo '<span class="label label-success">Approved</span>';
                                            break;
                                        case 2:
                                            echo '<span class="label label-default">Pause</span>';
                                            break;
                                        case 3:
                                            echo '<span class="label label-danger">Banned</span>';
                                            break;
                                        case 4:
                                            echo '<span class="label label-danger">Rejected</span>';
                                            break;
                                        default:
                                            echo '<span class="label label-default">Unknown</span>';
                                            break;
                                    }
                                    ?>
                                    <span class="glyphicon glyphicon-cog approved" style="float: right;position:relative;cursor: pointer;"></span>
                                    <select id="<?php echo $dt->id; ?>" class="update-user-status" style="display: none;">
                                        <option value="0" <?php echo $dt->status == 0 ? 'selected' : ''; ?>>Pending</option>
                                        <option value="1" <?php echo $dt->status == 1 ? 'selected' : ''; ?>>Approved</option>
                                        <option value="2" <?php echo $dt->status == 2 ? 'selected' : ''; ?>>Pause</option>
                                        <option value="3" <?php echo $dt->status == 3 ? 'selected' : ''; ?>>Banned</option>
                                        <option value="4" <?php echo $dt->status == 4 ? 'selected' : ''; ?>>Reject</option>
                                    </select>
                                </td>


                                <td><?php echo $dt->updated_at; ?></td>
                                <td>
                                    <!--invoicebhhhhhhhhhn>>>-->
                                    <a data-email="<?php echo $dt->email; ?>" title="<?php echo $dt->id; ?>" class="btn btn-success btn-xs invoice-adv">
                                        <i class="glyphicon glyphicon-euro glyphicon-white"></i>
                                    </a>
                                    <!--login acc membert>>>-->
                                    <a href="<?php echo base_url() . $this->config->item('admin') . '/viewmember/advertiser/' . $dt->id; ?>" class="btn btn-success btn-xs" target=_blank>
                                        <i class="glyphicon glyphicon-eye-open glyphicon-white"></i>
                                    </a>
                                    <!--edit>>>-->
                                    <a class="btn btn-info btn-xs advmodal" title="<?php echo $dt->id; ?>">
                                        <i class="glyphicon glyphicon-edit glyphicon-white"></i>
                                    </a>
                                    <!--delete>>>-->
                                    <a href="<?php echo base_url() . $this->config->item('admin') . '/route/' . $this->uri->segment(2) . '/delete/' . $dt->id; ?>" class="btn btn-danger btn-xs del">
                                        <i class="glyphicon glyphicon-trash glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . 'cron-jobs/calculator/advertisers/' . $dt->id; ?>" class="btn btn-success btn-xs refresh">
                                        <i class="glyphicon glyphicon-refresh glyphicon-white"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!empty($data)) { ?>
                <div class="row flex-justify-center">
                    <div class="col-md-6">
                        <?php echo 'Showing ' . $from . ' to ' . $to . ' of ' . $this->pagination->total_rows . ' entries' ?>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination">
                            <?php echo $this->pagination->create_links(); ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.draw-back').fadeOut();
        $('[data-toggle="tooltip"]').tooltip()

        $('.update-user-status').change(function() {
            const id = $(this).attr('id');
            const status = $(this).val();
            var th = $(this);
            var cl = '';
            var txt = '';
            $.ajax({
                type: 'POST',
                url: "<?= base_url('/admin/advertiser/update_status') ?>",
                data: {
                    id,
                    status
                },
                success: function(data) {
                    $(th).hide();
                    $(th).parent().find('span').show();
                    if (data == 0) {
                        cl = 'label label-warning';
                        txt = 'Pending';
                    }
                    if (data == 1) {
                        cl = 'label label-success';
                        txt = 'Approved';
                    }
                    if (data == 2) {
                        cl = 'label label-default';
                        txt = 'Pause';
                    }
                    if (data == 3) {
                        cl = 'label label-danger';
                        txt = 'Banned';
                    }
                    if (data == 4) {
                        cl = 'label label-danger';
                        txt = 'Rejected';
                    }
                    $(th).parent().find('.label').removeClass().addClass(cl).text(txt);
                },
                error: function(error) {
                    
                }
            })
        });

        sorting();
        refresh();
    })

    function sorting() {
        $('.sorting').change(function() {
            const value = $(this).val();
            const name = $(this).attr('name');

            $.ajax({
                method: 'POST',
                url: `<?= base_url('admin/advertiser/list_account') ?>`,
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
        $('.refresh').click(function() {
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
</script>