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
  <div class="box-header">
    <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Publisher Titles</h2>
    <div class="box-icon">
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_publisher_title' ?>"><i class="glyphicon glyphicon-plus"></i></a>
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
          <th style="width: 10px;">Position</th>
          <th style="width: 20px;">Title</th>
          <th style="width: 200px;">Actions</th>
        </tr>
        <?php foreach ($titles as $title) : ?>
          <tr>
            <td><?= end(explode('-', $title->type)); ?></td>
            <td><?= $title->content ?></td>
            <td>
              <a href="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_publisher_title/' . $title->type; ?>" class="btn btn-info btn-xs">
                <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </form>
    </table>
</section>