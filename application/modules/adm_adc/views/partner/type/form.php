<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-list-alt"></i><span class="break"></span>Offer Categories</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/route/' . $this->uri->segment(3) . '/list/'; ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <!--- noi dung--->
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/partner/edit_type/' .  $type->id ?>">

        <?php if ($type) {
          echo '<input class="hide" value="' . $type->id . '" name="id"/>';
        } ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Partner Type</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title" value="<?= $type->title ?>" placeholder="Title" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><span class="label label-success ajaxst">Show / Hide</span></label>
          <div class="col-sm-10">
            <span class="box_switch <?= $type->status == 1 ? '' : ' off' ?>">
              <a href="">switch off</a>
              <input id="off_on" type='hidden' name="status" value="1" />
            </span>
          </div>
        </div>


        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>



      <!--noi dung --->
    </div>
  </div>
  <!--/span-->
</div>