<div class="row">
    <div class="col-md-12">
        <?php
        $mes = $this->session->userdata('messenger');
        if ($mes) {
            $class = 'alert-success';
            if ($mes == 'Error!') {
                $class = 'alert-warning';
            }
            echo '<div class="alert ' . $class . '" role="alert">' . $mes . '</div>';
            $this->session->unset_userdata('messenger');
        }
        ?>
    </div>
</div>

<div class="box col-md-12">
    <div class="box-header">
        <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>Network</h2>
        <div class="box-icon">
            <a class="btn-add" href="<?php echo base_url() . $this->uri->segment(1) . '/network/create'; ?>"><i class="glyphicon glyphicon-plus">Create</i></a>
            <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
            <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>

    <div class="box-content">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-inline filter">
                    <select title="<?php echo $this->uri->segment(3); ?>" name="show_num" size="1"
                        class="form-control input-sm">
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
                <tr role="row">
                    <th>Id</th>
                    <th>Advertiser</th>
                    <th>Postback_Name</th>
                    <th>Postback Url</th>
                    <th>Affsub</th>
                    <th style="width: 50px;">Status</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dulieu)) {
                    foreach ($dulieu as $dulieu) { ?>
                        <tr>
                            <td><?php echo $dulieu->id; ?></td>
                            <td><?php echo $dulieu->first_name . ' ' . $dulieu->last_name; ?></td>
                            <td><?php echo $dulieu->title; ?></td>
                            <td><?php echo $dulieu->linkadd; ?></td>
                            <td><?php echo $dulieu->subid; ?></td>
                            <td>
                                <?php
                                if ($dulieu->show == 0) {
                                    echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                                }
                                if ($dulieu->show == 1) {
                                    echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . $this->config->item('admin') . '/' . $this->uri->segment(2) . '/edit/' . $dulieu->id; ?>"
                                    class="btn btn-info btn-xs">
                                    <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                                </a>
                                <a href="<?php echo base_url() . $this->config->item('admin') . '/' . $this->uri->segment(2) . '/delete/' . $dulieu->id; ?>"
                                    class="btn btn-danger btn-xs">
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
                    <select title="<?php echo $this->uri->segment(3); ?>" name="filter_cat" size="1"
                        class="form-control input-sm">
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
                <ul class=" pagination"><?php echo $this->pagination->create_links(); ?></ul>
            </div>
        </div>
    </div>
    
</div>
</div>