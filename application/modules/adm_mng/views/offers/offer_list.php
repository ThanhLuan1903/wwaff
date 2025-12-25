<?php
$osearch = $this->session->userdata('osearch');
?>

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

<div class="row">
    <div class="col-md-12">
        <?php
        $mes = $this->session->userdata('messenger');
        if ($mes) {
            $class = 'alert-success';
            if ($mes == 'Error!') {
                $class = 'alert-warning';
            }
            echo '<div class="alert ' . $class . '" role="alert">' . $mes . '</div>';
            $this->session->unset_userdata('messenger');
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-filter"></i> Filter Offers</div>
            <div class="panel-body">
                <form method="post" action="<?php echo base_url($this->uri->segment(1)); ?>/offers/search/">
                    <div class="filter-box">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Offer Category</label>
                                <select class="form-control select2" name="data[]" multiple="multiple">
                                    <?php
                                    $wherein = array();
                                    if (!empty($osearch['offercat'])) $wherein = $osearch['offercat'];
                                    $typeo = $this->Admin_model->get_data('offercat');
                                    if (!empty($typeo)) {
                                        foreach ($typeo as $cat) {
                                            $selected = in_array($cat->id, $wherein) ? 'selected' : '';
                                            echo '<option value="' . $cat->id . '" ' . $selected . '>' . $cat->offercat . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Offer Name</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter name..." value="<?= !empty($osearch['title']) ? $osearch['title'] : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Offer ID</label>
                                <input type="text" class="form-control" name="id" placeholder="Enter ID..." value="<?= !empty($osearch['id']) ? $osearch['id'] : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Network</label>
                                <select class="form-control select2" name="idnet[]" multiple="multiple">
                                    <?php
                                    $netsel = array();
                                    if (!empty($osearch['idnet'])) $netsel = (array)$osearch['idnet'];
                                    if (!empty($net)) {
                                        foreach ($net as $n) {
                                            $selected = in_array($n->id, $netsel) ? 'selected' : '';
                                            echo '<option value="' . $n->id . '" ' . $selected . '>' . $n->title . '</option>';
                                        }
                                    }
                                    ?>
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
    </div>

    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-gift"></i><span class="break"></span>Offers</h2>
            <div class="box-icon">
                <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/add/'; ?>"><i class="glyphicon glyphicon-plus"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
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
                        <th>DisLead</th>
                        <th>Point</th>
                        <th>Cap</th>
                        <th>Click</th>
                        <th>Lead</th>
                        <th>CR</th>
                        <th>EPC</th>
                        <th>Percent</th>
                        <th>Soff</th>
                        <th>Slink</th>
                        <th>ApiOn</th>
                        <th>Home</th>
                        <th>Top</th>
                        <th>New</th>
                        <th style="width:10px;">request</th>
                        <th style="width: 50px;">Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dulieu)) {
                        foreach ($dulieu as $dulieu) { ?>
                            <tr>
                                <td><?php echo $dulieu->id; ?></td>
                                <td><?php echo $dulieu->title; ?></td>
                                <td><?php echo $dulieu->nettitle; ?></td>
                                <td><?php echo $dulieu->dislead; ?></td>
                                <td>
                                    <?php
                                    $point_geo = unserialize($dulieu->point_geos);
                                    if ($point_geo) {
                                        $dem = 0;
                                        foreach ($point_geo as $key => $value) {
                                            if ($value > 0) {
                                                $dem++;
                                                if ($dem == 1) {
                                                    $phay = '';
                                                } else {
                                                    $phay = ', ';
                                                }
                                                echo $phay . $key . ': $' . $value;
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $dulieu->capped; ?></td>
                                <td><?php echo $dulieu->click; ?></td>
                                <td><?php echo $dulieu->lead; ?></td>
                                <td><?php echo round($dulieu->cr, 2); ?>%</td>
                                <td>$<?php echo round($dulieu->epc, 2); ?></td>
                                <td><?php echo $dulieu->percent; ?></td>
                                <td>
                                    <?php
                                    if ($dulieu->smartoff == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=smartoff&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->smartoff == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=smartoff&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->smartlink == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=smartlink&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->smartlink == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=smartlink&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->apion == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=apion&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->apion == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=apion&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->home == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=home&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->home == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=home&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->top == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=top&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->top == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=top&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->new == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=new&change=OnOff" class="label label-warning ajaxst">Off</span>';
                                    }
                                    if ($dulieu->new == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=new&change=OnOff" class="label label-success ajaxst">On</span>';
                                    }
                                    ?>
                                </td>
                                <td style="text-align:center">
                                    <?php
                                    if ($dulieu->request == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=request&change=YesNo" class="label label-warning ajaxst">No</span>';
                                    }
                                    if ($dulieu->request == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=request&change=YesNo" class="label label-success ajaxst">Yes</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($dulieu->show == 0) {
                                        echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-warning ajaxst">Hide</span>';
                                    }
                                    if ($dulieu->show == 1) {
                                        echo '<span data="id=' . $dulieu->id . '&field=show&change=ShowHide" class="label label-success ajaxst">Show</span>';
                                    }
                                    ?>
                                </td>
                                <td class="aaction">
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/edit/' . $dulieu->id; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Edit offer">
                                        <i class="glyphicon glyphicon-edit glyphicon glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/coppy_offer/' . $dulieu->id; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Coppy offer">
                                        <i class="glyphicon glyphicon-retweet glyphicon glyphicon-white"></i>
                                    </a>
                                    <a href="<?php echo base_url() . $this->config->item('manager') . '/route/offer/delete/' . $dulieu->id; ?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete offer">
                                        <i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php   }
                    } ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <ul class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

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
});
</script>