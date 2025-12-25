<div class="row">
  <div class="box col-md-12">
    <div class="box-header">
      <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Add Advertiser</h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">

      <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('admin') . '/advertiser/add_new_advertiser/'; ?>">

        <div class="form-group">
          <label class="col-sm-2 control-label">Account Type</label>
          <div class="col-sm-10" style="display: flex">
            <div class="form-check" style="margin-right: 30px;">
              <input class="form-check-input" type="radio" name="type_account" value="Persional" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">Personal</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="type_account" value="Company" id="flexRadioDefault2" checked>
              <label class="form-check-label" for="flexRadioDefault2">Company</label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Affiliate Program?</label>
          <div class="col-sm-10">
            <div class="row">
              <div class="col-sm-2">
                <div class="radio">
                  <label>
                    <input type="radio" name="user_setting[has_affiliate_program]" value="1" id="radio">Yes, I already have
                  </label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="radio">
                  <label>
                    <input type="radio" name="user_setting[has_affiliate_program]" value="0" id="radio2" checked>No, I don't
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">User Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="username" value="" placeholder="User Name" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">First Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="first_name" value="" placeholder="First Name" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Last Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="last_name" value="" placeholder="LastName" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="email" value="" placeholder="Email" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="keycode" name="password" value="" placeholder="Password" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="keycode" name="address" value="" placeholder="Address" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Skype ID/Linkedin</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="social_network" value="" placeholder="https://www.linkedin.com/in" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Website</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="website" value="" placeholder="https://example.com" />
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