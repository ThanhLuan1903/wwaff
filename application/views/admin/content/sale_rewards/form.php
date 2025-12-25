<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Add Sale Rewards</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/view' ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <!--- noi dung--->
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/custom_sale_rewards/update/' . $user->id ?>">
        <div class="form-group">
          <label class="col-sm-2 control-label">Publisher</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" placeholder="Publisher" value="<?= $user->username ?>" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Amount</label>
          <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="Amount" value="<?= $user->amount ?>" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Reward</label>
          <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" id="reward" name="reward" placeholder="Reward" value="<?= $user->reward ?>" />
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" value="<?= $type ?>" name="type" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
      <!--noi dung --->
    </div>
  </div>
  <!--/span-->
</div>