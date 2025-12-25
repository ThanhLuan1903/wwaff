<div class="box col-md-12">
    <?php if ($this->session->userdata('flash:old:success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $this->session->userdata('flash:old:success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->userdata('flash:old:error') || validation_errors() != "") : ?>
        <div class="alert alert-danger" role="alert">
            <?= $this->session->userdata('flash:old:error'); ?>
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>
</div>

<section>
    <h3>Custom Publisher Banner</h3>
    <div class="row">
        <div class="box col-md-12">
            <div class="box-header">
                <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Banners</h2>
                <div class="box-icon">
                    <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/banners/add/is_adv'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                    <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                    <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a class="btn-close" href="<?php echo base_url() . $this->config->item('manager') . '/custom/view' ?>"><i class="glyphicon glyphicon-remove"></i></a>
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
                <?php $mcategory['0']->title = 'none'; ?>
                <table class="table table-striped table-bordered">
                    <form>
                        <tr>
                            <th style="width: 10px;">Position</th>
                            <th style="width: 10px;">Location</th>
                            <th>Banner</th>
                            <th style="width: 20px;">Status</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                        <?php foreach ($banners as $banner): ?>
                            <tr>
                                <td><?= $banner->position ?></td>
                                <td><?= $banner->location ?></td>
                                <td><img src="<?= $banner->image_url ?>" width="250px" height="auto" /></td>
                                <td>
                                    <?php
                                    if ($banner->show == 0) {
                                        echo '<span data="id=' . $banner->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                                    }
                                    if ($banner->show == 1) {
                                        echo '<span data="id=' . $banner->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <!--edit>>>-->
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_publisher_banner/' . $banner->id . '/is_adv' ?>" class="btn btn-info btn-xs">
                                        <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                                    </a>
                                    <!--delete>>>-->
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/route/banners/delete/' . $banner->id; ?>" class="btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </form>
                </table>
            </div>
        </div>
    </div>
</section>