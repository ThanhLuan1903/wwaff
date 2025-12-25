<div class="row">
  <div class="box col-md-12">
    <?php if ($this->session->userdata('flash:old:success')) : ?>
      <div class="alert alert-success" role="alert">
        <?= $this->session->userdata('flash:old:success'); ?>
      </div>
    <?php endif; ?>
    <?php if ($this->session->userdata('flash:old:error')) : ?>
      <div class="alert alert-danger" role="alert">
        <?= $this->session->userdata('flash:old:error'); ?>
        <?= validation_errors() ?>
      </div>
    <?php endif; ?>

    <div class="box-header">

      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Partner Types</h2>

      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/partner/edit_type'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="<?php echo base_url() . $this->config->item('admin') . '/partner/' ?>"><i class="glyphicon glyphicon-remove"></i></a>
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
                echo '
                                <option value="' . $i * (10) . '"';
                echo $i * (10) == $limit['0'] ? ' selected="selected"' : '';
                echo
                '>' . $i * (10) . '</option>
                                ';
              }
              ?>
            </select>
            <label>records per page</label>
          </div>
        </div>

      </div>
      <table class="table table-striped table-bordered">
        <form>
          <tr>
            <th style="width: 10px;">ID</th>
            <th style="width: 10px;">Title</th>
            <th style="width: 20px;">Status</th>
            <th style="width: 200px;">Actions</th>
          </tr>
          <?php foreach ($types as $type) : ?>
            <tr>
              <td><?= $type->id ?></td>
              <td><?= $type->title ?></td>
              <td>
                <?php
                if ($type->status == 0) {
                  echo '<span data="id=' . $type->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                }
                if ($type->status == 1) {
                  echo '<span data="id=' . $type->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                }
                ?>
              </td>
              <td>
                <!--edit>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/partner/edit_type/' . $type->id; ?>" class="btn btn-info btn-xs">
                  <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                </a>
                <!--delete>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/partner/delete/type/' . $type->id; ?>" class="btn btn-danger btn-xs">
                  <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </form>
      </table>
      <div class="row">
        <div class="col-md-6">
          <ul class=" pagination">
            <?php echo $this->pagination->create_links(); ?>
          </ul>
        </div>
      </div>
    </div>