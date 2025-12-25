<!-- Box Alerts -->
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

<!-- Theme Management -->
<section>
  <h3>Login Background Management</h3>
  <div class="col-12">
    <div class="box col-md-12">
      <form action="<?php echo base_url() . $this->config->item('manager') . '/custom/update/theme' ?>" method="POST">
        <div class="row">
          <div class="col-md-3"><img src="<?= $loginTheme->content ?>" width="100%"></div>
          <div class="col-md-9">
            <div class="form-group">
              <label for="content">Image URL</label>
              <input type="text" name="content" value="<?= $loginTheme->content ?>" class="form-control">
            </div>
            <div class="form-actions">
              <button type="submit" name="type" value="<?= $loginTheme->type ?>" class="btn btn-default">Update</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<section>
  <h3>Custom Register Page</h3>
  <div class="box-header">

    <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Select Traffic Types</h2>
    <div class="box-icon">
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_register_page' ?>"><i class="glyphicon glyphicon-plus"></i></a>
      <a class="btn-close" href="<?php echo base_url() . $this->config->item('manager') . '/custom/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
  </div>
  <div class="box-content">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group form-inline filter"></div>
      </div>
    </div>
    <table class="table table-striped table-bordered">
      <form>
        <tr>
          <th style="width: 20px;">Option</th>
          <th style="width: 200px;">Actions</th>
        </tr>
        <?php foreach ($trafficTypes as $traffic) : ?>
          <tr>
            <td><?= $traffic->content; ?></td>
            <td>
              <!--edit>>>-->
              <a href="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_register_page/' . $traffic->id; ?>" class="btn btn-info btn-xs">
                <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
              </a>
              <!--delete>>>-->
              <a href="<?php echo base_url() . $this->config->item('manager') . '/custom/delete/theme/' . $traffic->id; ?>" class="btn btn-danger btn-xs">
                <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </form>
    </table>
</section>