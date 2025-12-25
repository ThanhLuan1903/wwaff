<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Custom Reward</h2>
    </div>
    <div class="box-content">
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/custom_balance_rewards/reward/' . $reward->ranking ?>">
        <div class="form-group">
          <label class="col-sm-2 control-label">Ranking</label>
          <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" id="amount" name="ranking" placeholder="Input your ranking" value="<?= $reward->ranking ?>" <?= $reward->ranking ? 'disabled' : '' ?> />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Reward</label>
          <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" id="reward" name="reward" placeholder="Reward" value="<?= $reward->reward ?>" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" value="<?= $type ?>" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>