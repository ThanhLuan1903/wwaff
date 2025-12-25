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
      </div>
    <?php endif; ?>

    <div class="box-header">

      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Partners</h2>

      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/partner/store/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
        <a class="btn-close" href="<?php echo base_url() . $this->config->item('admin') . '/partner/delete/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
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
            <th style="width: 10px;">Name</th>
            <th style="width: 10px;">Logo</th>
            <th style="width: 10px;">Partner Type</th>
            <th style="width: 10px;">Website</th>
            <th style="width: 20px;">Status</th>
            <th style="width: 200px;">Actions</th>
          </tr>
          <?php foreach ($partners as $partner) : ?>
            <tr>
              <td><?= $partner->id ?></td>
              <td><?= $partner->name ?></td>
              <td><?= $partner->logo ?></td>
              <td><?= $partner->partner_type ?></td>
              <td><?= $partner->link_profile ?></td>
              <td>
                <?php
                if ($partner->show == 0) {
                  echo '<span data="id=' . $partner->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                }
                if ($partner->show == 1) {
                  echo '<span data="id=' . $partner->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                }
                ?>
              </td>
              <td>
                <!--edit>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/partner/store/' . $partner->id; ?>" class="btn btn-info btn-xs">
                  <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                </a>
                <!--delete>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/partner/delete/partner/' . $partner->id; ?>" class="btn btn-danger btn-xs">
                  <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </form>
      </table><!-- end table content-->
      <div class="row">
        <div class="col-md-6">
          <ul class=" pagination">
            <?php echo $this->pagination->create_links(); ?>
          </ul>
        </div>
      </div>
    </div>