<style>
  .top-10-list {
    position: relative;
  }

  .loading-drawback {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    z-index: 9;
    background-color: white;
    opacity: 0.8;
    display: none;
  }

  .loading-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }

  .loading-content {
    display: flex;
    flex-direction: column;
  }
</style>
<section>
  <div class="row">
    <div class="box col-md-12 top-10-list">
      <div class="loading-drawback">
        <div class="loading-icon">
          <div class="loading-content">
            <img src="<?= base_url('temp/admin/images/loading.gif') ?>" />
            <h3>Refreshing...</h3>
          </div>
        </div>

      </div>
      <div class="box-header">
        <h2>Top 10 Balance this month</h2>
        <div class="box-icon">
          <a class="btn-add" id="refresh-ranking" href="#"><i class="glyphicon glyphicon-refresh glyphicon-white"></i></a>
        </div>
      </div>
      <div class="box-content">
        <table class="table table-striped table-bordered">
          <tr>
            <th style="width: 10px;">Ranking</th>
            <th style="width: 20px;">Publisher</th>
            <th style="width: 20px;">Amount</th>
            <th style="width: 20px;">Reward</th>
          </tr>
          <?php $stt = 1;
          foreach ($balance_users as $user) : ?>
            <tr>
              <td><?= $stt; ?></td>
              <td><?= $user->username ?></td>
              <td><?= number_format(round($user->finance, 2), 3) ?></td>
              <td><?= number_format($top10_rewards[$stt]) ?></td>
            </tr>
          <?php $stt++;
          endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>

<section style="margin-top: 50px">
  <div class="box-header">

    <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Add Custom Balance User</h2>
    <div class="box-icon">
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/custom_user/' ?>"><i class="glyphicon glyphicon-plus"></i></a>
      <a class="btn-close" href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/custom_user/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
  </div>
  <div class="box">
    <?php if ($this->session->userdata('flash:old:success_custom_user')) : ?>
      <div class="alert alert-success" role="alert">
        <?= $this->session->userdata('flash:old:success_custom_user'); ?>
      </div>
    <?php endif; ?>
    <?php if ($this->session->userdata('flash:old:error_custom_user') || validation_errors() != "") : ?>
      <div class="alert alert-danger" role="alert">
        <?= $this->session->userdata('flash:old:error_custom_user'); ?>
        <?= validation_errors() ?>
      </div>
    <?php endif; ?>
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
          <th style="width: 200px;">Actions</th>
        </tr>
        <?php $stt = 1;
        foreach ($custom_users as $user) : ?>
          <tr>
            <td><?= $stt++; ?></td>
            <td><?= $user->username ?></td>
            <td><?= number_format($user->amount, 2) ?></td>
            <td>
              <!--edit>>>-->
              <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/custom_user/' . $user->id; ?>" class="btn btn-info btn-xs">
                <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
              </a>
              <!--delete>>>-->
              <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/custom_user/' . $user->id . '/delete' ?>" class="btn btn-danger btn-xs">
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

        </ul>
      </div>
    </div>
</section>

<section style="margin-top: 50px">
  <div class="box-header">
    <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Setting Awards</h2>
    <div class="box-icon">
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/reward/' ?>"><i class="glyphicon glyphicon-plus"></i></a>
      <a class="btn-close" href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/reward/' . $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
  </div>

  <div class="box-content">
    <div class="box">
      <?php if ($this->session->userdata('flash:old:success_reward')) : ?>
        <div class="alert alert-success" role="alert">
          <?= $this->session->userdata('flash:old:success_reward'); ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->userdata('flash:old:error_reward') || validation_errors() != "") : ?>
        <div class="alert alert-danger" role="alert">
          <?= $this->session->userdata('flash:old:error_reward'); ?>
          <?= validation_errors() ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group form-inline filter">
        </div>
      </div>
    </div>
    <table class="table table-striped table-bordered">
      <tr>
        <th style="width: 10px;">Ranking</th>
        <th style="width: 20px;">Award</th>
        <th style="width: 20px;">Actions</th>
      </tr>
      <?php foreach ($rewards as $reward) : ?>
        <tr>
          <td><?= $reward->ranking ?></td>
          <td><?= number_format($reward->reward, 2) ?></td>
          <td>
            <!--edit>>>-->
            <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/reward/' . $reward->ranking; ?>" class="btn btn-info btn-xs">
              <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
            </a>
            <!--delete>>>-->
            <a href="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/reward/' . $reward->ranking . '/delete' ?>" class="btn btn-danger btn-xs">
              <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table><!-- end table content-->
    <div class="row">
     
      <div class="col-md-6">
        <ul class=" pagination">

        </ul>
      </div>
    </div>
</section>

<script>
  $(document).ready(function() {
    $('#refresh-ranking').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: 'GET',
        url: `<?= base_url('/api/calculator/calc_pub_ranking') ?>`,
        beforeSend: function() {
          $('.loading-drawback').css('display', 'block');
        },
        success: function(response) {
          setTimeout(() => {
            window.location.reload()
          }, 5000);
        },
      })
    });
  });
</script>