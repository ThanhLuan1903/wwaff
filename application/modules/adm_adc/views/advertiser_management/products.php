<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
  .aaction a {
    margin-bottom: 5px
  }

  .filter-box {
    background: #f8f9fa;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
  }

  .filter-box label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
    color: #495057;
  }

  .filter-box .form-control {
    border-radius: 4px;
  }

  .filter-box .btn-group-filter {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
  }

  .select2-container {
    width: 100% !important;
  }
  .select2-container .select2-selection--single {
    height: 34px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 34px;
  }
  .select2-container .select2-selection--single .select2-selection__arrow {
    height: 32px;
  }
  .select2-container .select2-selection--multiple {
    min-height: 34px;
    max-height: 68px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .select2-container .select2-selection--multiple .select2-selection__rendered {
    max-height: 60px;
    overflow-y: auto;
  }
</style>

<div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-filter"></i> Filter Offers</div>
  <div class="panel-body">
    <form method="POST" action="<?php echo base_url('admin/advertiser/list_products'); ?>">
      <div class="filter-box">
        <div class="row">
          <div class="col-md-3">
            <label>Offer Category</label>
            <select class="form-control select2" name="offercats[]" multiple="multiple">
              <?php foreach ($offercats as $cat): ?>
                <option value="<?= $cat->id ?>" <?= !empty($filter['offercats']) && is_array($filter['offercats']) && in_array($cat->id, $filter['offercats']) ? 'selected' : '' ?>><?= $cat->offercat ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Offer Name</label>
            <input type="text" class="form-control" name="title" placeholder="Enter name..." value="<?= !empty($filter['title']) ? $filter['title'] : '' ?>">
          </div>
          <div class="col-md-3">
            <label>Offer ID</label>
            <input type="text" class="form-control" name="id" placeholder="Enter ID..." value="<?= !empty($filter['id']) ? $filter['id'] : '' ?>">
          </div>
          <div class="col-md-3">
            <label>Network</label>
            <select class="form-control select2" name="network[]" multiple="multiple">
              <?php foreach ($networks as $net): ?>
                <option value="<?= $net->id ?>" <?= !empty($filter['network']) && is_array($filter['network']) && in_array($net->id, $filter['network']) ? 'selected' : '' ?>><?= $net->title ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 btn-group-filter text-center">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            <button type="button" class="btn btn-default btn-reset"><i class="fa fa-refresh"></i> Reset</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="box">
  <div class="box-header">
    <h2><i class="glyphicon glyphicon-gift"></i><span class="break"></span>Offers</h2>
    <div class="box-icon">Add offer
      <a class="btn-add" href="<?php echo base_url() . $this->config->item('admin') . '/route/offer/add'; ?>">
        <i class="glyphicon glyphicon-plus"></i>
      </a>
    </div>
  </div>

  <div class="box-content">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group form-inline filter">
          <select title="<?php echo $this->uri->segment(3); ?>" name="show_num" size="1" class="form-control input-sm">
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
          <th>Confirm Date</th>
          <th>Pay Date</th>
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
              <a href="<?php echo base_url() . $this->config->item('admin') . '/route/offer/edit/' . $product->id; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Edit offer">
                <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
              </a>
              <a href="<?php echo base_url() . $this->config->item('admin') . '/coppy_offer/' . $product->id; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Coppy offer">
                <i class="glyphicon glyphicon-retweet glyphicon glyphicon-white"></i>
              </a>
              <a href="<?php echo base_url() . $this->config->item('admin') . '/route/offer/delete/' . $product->id; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete offer">
                <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="col-md-6">
    <ul class="pagination">
      <?php echo $this->pagination->create_links(); ?>
    </ul>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Init Select2
    $('.select2').select2({
        placeholder: "-- Select --",
        allowClear: true
    });

    // Reset button
    $('.btn-reset').click(function() {
        var $form = $(this).closest('form');
        $form.find('input[type="text"]').val('');
        $form.find('.select2').val(null).trigger('change');
        $form.append('<input type="hidden" name="reset_filter" value="1">');
        $form.submit();
    });

    // Update status
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
            url: `<?= base_url('admin/advertiser/update_status_product') ?>`,
            data: {
                action,
                offer_id,
                role
            },
            success: function(response) {
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
        });
    });
});
</script>