<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Title Banner</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/custom_sale_rewards/view' ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('manager') . '/custom/edit_publisher_title/' . $title->id ?>">
        <div class="form-group">
          <label class="col-sm-2 control-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="top" name="content" placeholder="Title" value="<?= $title->content ?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Location</label>
          <div class="col-sm-10">
            <select name="type" class="form-control input-sm">
              <option value="title-publisher-left" <?= $title->type == 'title-publisher-left' ? 'selected' : '' ?>>Left</option>
              <option value="title-publisher-right" <?= $title->type == 'title-publisher-right' ? 'selected' : '' ?>>Right</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">Submit</button></div>
        </div>
      </form>
    </div>
  </div>
</div>