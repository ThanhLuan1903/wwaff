<div class="row">
  <div class="box col-md-12">
    
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Approved Offers</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/list/'; ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>

    <div class="box-content">
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/' . $this->uri->segment(4); ?>">

        <?php if ($dulieu) {
          echo '<input class="hide" value="' . $dulieu->id . '" name="id"/>';
        } ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Offer's ID</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="offerid" name="offerid" value="<?php if ($dulieu) {
                                                                                          echo $dulieu->offerid;
                                                                                        } ?>" placeholder="offerid" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">User's ID</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="userid" value="<?php if ($dulieu) {
                                                                                      echo $dulieu->userid;
                                                                                    } ?>" placeholder="userid" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Show / Hide</label>
          <div class="col-sm-10">
            <select name="status" class="form-control status">
              <option value="Approved">Approved</option>
              <option value="Pending">Pending</option>
              <option value="Deny">Deny</option>
            </select>
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