<div class="row">
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

    <div class="box-header">

      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Top sale award</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/edit' ?>"><i class="glyphicon glyphicon-plus"></i></a>
        <a class="btn-close" href="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group form-inline filter">
          </div>
        </div>

      </div>
      <table class="table table-striped table-bordered">
        <form>
          <tr>
            <th style="width: 10px;">STT</th>
            <th style="width: 20px;">Publisher</th>
            <th style="width: 20px;">Amount</th>
            <th style="width: 20px;">Reward</th>
            <th style="width: 200px;">Actions</th>
          </tr>
          <?php $stt = 1;
          foreach ($users as $user) : ?>
            <tr>
              <td><?= $stt++; ?></td>
              <td><?= $user->username ?></td>
              <td><?= number_format($user->amount, 2) ?></td>
              <td><?= number_format($user->reward, 2) ?></td>
              <td>
                <!--edit>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/edit/' . $user->id; ?>" class="btn btn-info btn-xs">
                  <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                </a>
                <!--delete>>>-->
                <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/delete/' . $user->id; ?>" class="btn btn-danger btn-xs">
                  <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </form>
      </table><!-- end table content-->
      <div class="row">
        <!--div class="col-md-12">
                    Showing 1 to 10 of 32 entries
                </div--->
        <div class="col-md-6">
          <ul class=" pagination">

          </ul>
        </div>
      </div>
    </div>