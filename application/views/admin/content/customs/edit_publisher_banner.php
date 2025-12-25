<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Banner</h2>
      <div class="box-icon">
        <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/route/' . $this->uri->segment(3) . '/list/'; ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
        <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
        <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
        <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <!--- noi dung--->
      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/custom/edit_publisher_banner/' . $banner->id ?>">
        <input type="text" name="is_adv" hidden value="1">
        <?php if ($banner) {
          echo '<input class="hide" value="' . $banner->id . '" name="id"/>';
        } ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Banner URL</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="image_url" value="<?php if ($banner) {
                                                                                          echo $banner->image_url;
                                                                                        } ?>" placeholder="Banner URL" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Link</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="link_page" value="<?php if ($banner) {
                                                                                          echo $banner->link_page;
                                                                                        } ?>" placeholder="Link Page" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Ordinal Numbers</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="keycode" name="position" value="<?php if ($banner) {
                                                                                          echo $banner->position;
                                                                                        } ?>" placeholder="Position" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Position</label>
          <div class="col-sm-10">
            <input type="radio" name="location" value="Left" <?= $banner->location == 'Left' ? 'checked' : null ?>>
            <label>Left</label><br>
            <input type="radio" name="location" value="Right" <?= $banner->location == 'Right' ? 'checked' : null ?>>
            <label>Right</label><br>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Show / Hide</label>
          <div class="col-sm-10">
            <span class="box_switch<?php if ($banner) {
                                      echo $banner->show == 1 ? '' : ' off';
                                    } ?>">
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



      <!--noi dung --->
    </div>
  </div>
  <!--/span-->
</div>