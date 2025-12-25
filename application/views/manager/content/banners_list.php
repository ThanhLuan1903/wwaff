<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Banners</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/add/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
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
                    <?php foreach ($dulieu as $banner): ?>
                        <tr>
                            <td><?= $banner->position ?></td>
                            <td><?= $banner->location ?></td>
                            <td><img src="<?= $banner->image_url ?>" width="250px" height="auto" /></td>
                            <td>
                                <?php
                                if ($banner->show == 0) {
                                    echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                                }
                                if ($banner->show == 1) {
                                    echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <!--edit>>>-->
                                <a href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/edit/' . $banner->id; ?>" class="btn btn-info btn-xs">
                                    <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                                </a>
                                <!--delete>>>-->
                                <a href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/delete/' . $banner->id; ?>" class="btn btn-danger btn-xs">
                                    <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </form>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <ul class=" pagination"><?php echo $this->pagination->create_links(); ?></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>temp/manager/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>temp/manager/js/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>temp/manager/css/jquery.fancybox.css?v=2.1.5" media="screen" />