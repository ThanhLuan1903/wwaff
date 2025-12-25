<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-list-alt"></i><span class="break"></span>Partner</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/partner/'; ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/partner/store/' .  $partner->id ?>">

        <?php if ($partner) {
          echo '<input class="hide" value="' . $partner->id . '" name="id"/>';
        } ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="name" value="<?= $partner->name ?>" placeholder="Partner Name" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Logo</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="logo" value="<?= $partner->logo ?>" placeholder="Logo" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Partner Type</label>
          <div class="col-sm-10">
            <select name="partner_type_id" class="form-control">
              <option value="0">None</option>
              <?php if ($partner_types) {
                foreach ($partner_types as $partner_type) {
                  echo '<option value="' . $partner_type->id . '"';
                  if (!empty($partner_type)) {
                    echo $partner->partner_type_id == $partner_type->id ? ' selected' : '';
                  }
                  echo '>';
                  echo $partner_type->title;
                  echo '</option>';
                }
              } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Website</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="link_profile" value="<?= $partner->link_profile ?>" placeholder="Website" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><span class="label label-success ajaxst">Show / Hide</span></label>
          <div class="col-sm-10">
            <span class="box_switch <?= $partner->show == 1 || empty($partner) ? '' : 'off' ?>">
              <a href="">switch off</a>
              <input id="off_on" type='hidden' name="show" value="1" />
            </span>
          </div>
        </div>


        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>