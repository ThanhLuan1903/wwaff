<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Offer Cat</div>
  <div class="panel-body">
    <!-- loc offer type-->
    <form method="post" class="form-inline" action="<?php echo base_url('manager/advertiser/list_products'); ?>">
      <div class="form-group col-sm-12" style="margin:5px;">
        <?php foreach ($offercats as $offercat): ?>
          <div class="form-group col-sm-3">
            <label class="checkbox-inline">
              <input type="checkbox" id="inlineCheckbox1" name="offercats[]" value="<?= $offercat->id ?>" <?= in_array($offercat->id, $this->input->post('offercats')) ? 'checked' : '' ?> />
              <?= $offercat->offercat ?>
            </label>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="form-group col-sm-12" style="margin:5px;"> Search
        <input name="key" class="form-control input-sm" id="keys" placeholder="ID or Name" value="<?= $this->input->post('key') ?>" />
        <button id="guioffertype" type="submit" class="btn btn-primary input-sm">Search</button>
      </div>
    </form>
    <!--end loc theo offer type-->
  </div>
</div>
<div class="box">

  <div class="box-header">
    <h2><i class="glyphicon glyphicon-gift"></i><span class="break"></span>Offers</h2>
    <div class="box-icon">Add offer
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/add'; ?>">
        <i class="glyphicon glyphicon-plus"></i>
      </a>
    </div>
  </div>

  <div class="box-content">

    <div class="row">
      <div class="col-md-3">
        <div class="form-group form-inline filter">
          <select title="<?php echo $this->uri->segment(3); ?>" name="show_num" size="1"
            class="form-control input-sm">
            <?php
            $limit = $this->session->userdata('limit');
            for ($i = 1; $i < 11; $i++) {
              echo '<option value="' . $i * (10) . '"';
              echo $i * (10) == $limit['0'] ? ' selected="selected"' : '';
              echo '>' . $i * (10) . '</option>';
            }
            ?>
          </select>
          <label>records per page</label>
        </div>
      </div>
    </div>

    <table class="table table-striped table-bordered">
      <thead>
        <tr role="row">
          <th>Id</th>
          <th>Name</th>
          <th>Network</th>
          <th>Confirm Date </th>
          <th>Pay Date </th>
          <th>Point</th>
          <th>Cap</th>
          <th>Click</th>
          <th>Lead</th>
          <th>M_Cr</th>
          <th>CR</th>
          <th>EPC</th>
          <th>Percent</th>
          <th>Soff</th>
          <th>Slink</th>
          <th>ApiOn</th>
          <th>Home</th>
          <th>Top</th>
          <th>New</th>
          <th style="width:10px;">Request</th>
          <th style="width: 50px;">Show</th>
          <th style="width: 50px;">Status</th>
          <th style="width: 100px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) : ?>
          <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->title ?></td>
            <td><?= $product->nettile ?></td>
            <td><?= $product->confirm_date ?></td>
            <td><?= $product->hold_period ?></td>
            <td><?= unserialize($product->point_geos) ?></td>
            <td><?= $product->capped ?></td>
            <td><?= $product->click ?></td>
            <td><?= $product->lead ?></td>
            <td>
              <?php
              if ($product->auto_cr == 0) {
                echo '<span data="id=' . $product->id . '&field=auto_cr&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->auto_cr == 1) {
                echo '<span data="id=' . $product->id . '&field=auto_cr&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td><?= round($product->cr, 2); ?>%</td>
            <td>$<?= round($product->epc, 2); ?></td>
            <td><?= $product->percent ?></td>
            <td>
              <?php
              if ($product->smartoff == 0) {
                echo '<span data="id=' . $product->id . '&field=smartoff&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->smartoff == 1) {
                echo '<span data="id=' . $product->id . '&field=smartoff&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->smartlink == 0) {
                echo '<span data="id=' . $product->id . '&field=smartlink&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->smartlink == 1) {
                echo '<span data="id=' . $product->id . '&field=smartlink&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->apion == 0) {
                echo '<span data="id=' . $product->id . '&field=apion&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->apion == 1) {
                echo '<span data="id=' . $product->id . '&field=apion&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->home == 0) {
                echo '<span data="id=' . $product->id . '&field=home&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->home == 1) {
                echo '<span data="id=' . $product->id . '&field=home&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->top == 0) {
                echo '<span data="id=' . $product->id . '&field=top&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->top == 1) {
                echo '<span data="id=' . $product->id . '&field=top&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->new == 0) {
                echo '<span data="id=' . $product->id . '&field=new&change=OnOff" class="label label-warning ajaxst">Off</span>';
              }
              if ($product->new == 1) {
                echo '<span data="id=' . $product->id . '&field=new&change=OnOff" class="label label-success ajaxst">On</span>';
              }
              ?>
            </td>
            <td style="text-align:center">
              <?php
              if ($product->request == 0) {
                echo '<span data="id=' . $product->id . '&field=request&change=YesNo" class="label label-warning ajaxst">No</span>';
              }
              if ($product->request == 1) {
                echo '<span data="id=' . $product->id . '&field=request&change=YesNo" class="label label-success ajaxst">Yes</span>';
              }
              ?>
            </td>
            <td>
              <?php
              if ($product->show == 0) {
                echo '<span data="id=' . $product->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
              }
              if ($product->show == 1) {
                echo '<span data="id=' . $product->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
              }
              ?>
            </td>
            <td class="approv">
              <?php
              if ($product->product_status == 'Pending' || !$product->product_status) {
                echo '<span class="label label-warning">Pending</span>';
              }
              if ($product->product_status == 'Approve') {
                echo '<span class="label label-success">Approved</span>';
              }
              if ($product->product_status == 'Active') {
                echo '<span class="label label-success">Active</span>';
              }
              if ($product->product_status == 'Pause') {
                echo '<span class="label label-default">Pause</span>';
              }
              if ($product->product_status == 'Reject') {
                echo '<span class="label label-danger">Reject</span>';
              }
              ?>
              <span class="glyphicon glyphicon-cog approved" style="float: right;position:relative;cursor: pointer;"></span>
              <select id="<?php echo $product->id; ?>" class="update-status" style="display: none;">
                <option value="Pending">Pending</option>
                <option value="Approve" <?php echo $product->product_status == 'Approve' ? 'selected' : ''; ?>>Approved</option>
                <option value="Pause" <?php echo $product->product_status == 'Pause' ? 'selected' : ''; ?>>Pause</option>
                <option value="Reject" <?php echo $product->product_status == 'Reject' ? 'selected' : ''; ?>>Reject</option>
              </select>
            </td>
            <td class="aaction">
              <a href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/edit/' . $product->id; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Edit offer">
                <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
              </a>

              <a href="<?php echo base_url() . $this->config->item('manager') . '/coppy_offer/' . $product->id; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Coppy offer">
                <i class="glyphicon glyphicon-retweet glyphicon glyphicon-white"></i>
              </a>

              <a href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/delete/' . $product->id; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete offer">
                <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="col-md-6">
      <ul class="pagination">
        <?php echo $this->pagination->create_links(); ?>
      </ul>
    </div>

  </div>
</div>


<script>
  $(document).ready(function() {
    $('.update-status').change(function() {
      event.preventDefault();
      const offer_id = $(this).attr('id');
      const action = $(this).val();
      const role = '1';
      var th = $(this);
      var cl = '';
      var txt = '';
      $.ajax({
        type: "POST",
        url: `<?= base_url('manager/advertiser/update_status_product') ?>`,
        data: {
          action,
          offer_id,
          role
        },
        success: function(resposne) {
          $(th).hide();
          $(th).parent().find('span').show();
          if (action == 'Pending') {
            cl = 'label label-warning';
            txt = 'Pending';
          }
          if (action == 'Approve') {
            cl = 'label label-success';
            txt = 'Approved';
          }
          if (action == 'Pause') {
            cl = 'label label-default';
            txt = 'Pause';
          }
          if (action == 'Reject') {
            cl = 'label label-danger';
            txt = 'Rejected';
          }
          $(th).parent().find('.label').removeClass().addClass(cl).text(txt);
        }
      })

    })
  })
</script>