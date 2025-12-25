<link href="<?php echo base_url('temp/default/fselect'); ?>/fSelect.css" rel="stylesheet">
<link href="<?php echo base_url('temp/manager/css/offer-edit.css') . '?v=' . time(); ?>" rel="stylesheet">
<script src="<?php echo base_url('temp/default/fselect'); ?>/fSelect.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
   $(function() {
      $('.selectpicker').selectpicker();
   });
</script>

<?php
$trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);
$moc = array();
if ($dulieu) {
   $idnet = $dulieu->idnet;
} else $idnet = 0;

$country = $this->Admin_model->get_data('country', array('show' => 1));
$type = $this->Admin_model->get_data('offertype', array('show' => 1));
$offercat = $this->Admin_model->get_data('offercat', array('show' => 1));
$device = $this->Admin_model->get_data('device', array('show' => 1));
$paymterm = $this->Admin_model->get_data('paymterm', array('show' => 1));

if (!empty($dulieu)) {
   $moc = explode('o', $dulieu->offercat);
}

if (!empty($offercat)) {
   $cat = '';
   foreach ($offercat as $offercat) {
      $cat .= offercatdt($offercat, 'offercat[]', $moc);
   }
}

/**
 * @param object $offercat
 * @param string $name
 * @param array $moc
 * @return string
 */
function offercatdt($offercat, $name = '', $moc = '')
{
   $dt = '<p><input type="checkbox" size="40" value="' . $offercat->id . '" name="' . $name . '" ';
   if (!empty($moc)) {
      if (in_array($offercat->id, $moc)) {
         $dt .= ' checked';
      }
   }

   $dt .= '/>' . $offercat->offercat . '</p>';
   return $dt;
}
?>
<div class="row">
   <div class="box col-md-12">

      <div class="box-header">
         <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Offers</h2>
         <div class="box-icon">
            <a class="btn-add" href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/list/'; ?>"><i class="glyphicon glyphicon-list-alt"></i></a>
            <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
            <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
            <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
         </div>
      </div>

      <div class="box-content">
         <form style="color: cecece;" method="POST" action="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/' . $this->uri->segment(4); ?>">
            <?php if ($dulieu) {
               echo '<input class="hide" value="' . $dulieu->id . '" name="id"/>';
            } ?>
            <input class="hide" value="0" name="point" />

            <div class="row">
               <div class="col-md-12">

                  <div class="form-group alert alert-info">
                     <label>Title</label>
                     <input type="title" class="form-control" id="title" name="title" value="<?php if ($dulieu) {
                                                                                                echo $dulieu->title;
                                                                                             } ?>" placeholder="Title" />
                  </div>

                  <div class="form-group row">

                     <div class="col-md-3">
                        <label>Network</label>
                        <select name="idnet" class="form-control net_change">
                           <option value="0">None</option>
                           <?php
                           /** @var array $category */
                           if ($category) {
                              foreach ($category as $category) {
                                 echo '<option value="' . $category->id . '"';
                                 if (!empty($dulieu)) {
                                    echo $dulieu->idnet == $category->id ? ' selected' : '';
                                 }
                                 echo '>';
                                 echo $category->title;
                                 echo '</option>';
                              }
                           } ?>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label>Offer type</label>
                        <select name="type" class="form-control">
                           <option value="0">None</option>
                           <?php if ($type) {
                              foreach ($type as $type) {
                                 echo '<option value="' . $type->id . '"';
                                 if (!empty($dulieu)) {
                                    echo $dulieu->type == $type->id ? ' selected' : '';
                                 }
                                 echo '>';
                                 echo $type->type;
                                 echo '</option>';
                              }
                           } ?>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label>Payment Term</label>
                        <select name="paymterm" class="form-control">
                           <option value="0">None</option>
                           <?php if ($paymterm) {
                              foreach ($paymterm as $paymterm) {
                                 echo '<option value="' . $paymterm->id . '"';
                                 if (!empty($dulieu)) {
                                    echo $dulieu->paymterm == $paymterm->id ? ' selected' : '';
                                 }
                                 echo '>';
                                 echo $paymterm->payment_term;
                                 echo '</option>';
                              }
                           } ?>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label>Device</label>
                        <select name="device" class="form-control">
                           <option value="0">ALL</option>
                           <?php if ($device) {
                              foreach ($device as $device) {
                                 echo '<option value="' . $device->id . '"';
                                 if (!empty($dulieu)) {
                                    echo $dulieu->device == $device->id ? ' selected' : '';
                                 }
                                 echo '>';
                                 echo $device->device;
                                 echo '</option>';
                              }
                           } ?>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label>Percent</label>
                        <div class="input-group">
                           <span class="input-group-addon">%</span>
                           <input type="text" class="form-control" id="percent" name="percent" value="<?php if ($dulieu) {
                                                                                                         echo $dulieu->percent;
                                                                                                      } ?>" placeholder="Percent" />
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label>Dis lead/100</label>
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                           <input type="text" class="form-control" id="url" name="dislead" value="<?php if (!empty($dulieu->dislead)) {
                                                                                                      echo $dulieu->dislead;
                                                                                                   } else echo 0; ?>" placeholder="S? l�?ng lead ch?n /100 lead" />
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label>CR</label>
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-leaf"></span></span>
                           <input type="text" class="form-control" id="url" name="cr" value="<?php if (!empty($dulieu->cr)) {
                                                                                                echo $dulieu->cr;
                                                                                             } else echo 0; ?>" placeholder="CR" />
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label>EPC</label>
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                           <input type="text" class="form-control" id="url" name="epc" value="<?php if (!empty($dulieu->epc)) {
                                                                                                   echo $dulieu->epc;
                                                                                                } else echo 0; ?>" placeholder="EPC" />
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label>Daily cap/offer</label>
                        <div class="input-group">
                           <span class="input-group-addon">%</span>
                           <input type="text" class="form-control" id="url" name="allpubDailyCap" value="<?php if (!empty($dulieu->allpubDailyCap)) {
                                                                                                            echo $dulieu->allpubDailyCap;
                                                                                                         } else echo 0; ?>" />
                        </div>
                     </div>

                     <div class="col-md-3">
                        <label>Budget</label>
                        <div class="input-group">
                           <span class="input-group-addon">$</span>
                           <input type="text" class="form-control" id="budget" name="budget" value="<?php if (!empty($dulieu->budget)) {
                                                                                                         echo $dulieu->budget;
                                                                                                      } else echo 0; ?>" />
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-md-3">
                        <label>Daily Cap/ Pub</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
                           <input type="text" class="form-control" id="daycap" name="daycap" value="<?php if (!empty($dulieu->daycap)) {
                                                                                                         echo $dulieu->daycap;
                                                                                                      } else echo 0; ?>" />
                        </div>
                     </div>
                     <div class="col-md-1" style="padding-top:26px;padding-left:0">
                        <button type="button" class="info-btn cap-btn" data-toggle="modal" data-period=0 data-target="#capExceptionModal" id='exccap' style="min-height:32px">
                           <i class="glyphicon glyphicon-cog"></i>
                        </button>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-md-3">
                        <label class="monthcap_lable">Monthly Cap/ Pub</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
                           <input type="text" class="form-control" id="monthcap" name="monthcap" value="<?php if (!empty($dulieu->monthcap)) {
                                                                                                            echo $dulieu->monthcap;
                                                                                                         } else echo 0; ?>" />
                        </div>
                     </div>
                     <div class="col-md-1" style="padding-top:26px;padding-left:0">
                        <button type="button" class="info-btn cap-btn" data-toggle="modal" data-period=1 data-target="#capExceptionModal" id='monthexccap' style="min-height:32px">
                           <i class="glyphicon glyphicon-cog"></i>
                        </button>
                     </div>
                  </div>

                  <div class="form-group">
                     <label style="margin-right:15px">Payment Terms:</label>
                     <label style="margin-right:10px"><input type="radio" name="paymterm_calc" value="1" <?= $dulieu->paymterm_calc == '1' ? 'checked' : "" ?>> Monthly</label>
                     <label><input type="radio" name="paymterm_calc" value="2" <?= $dulieu->paymterm_calc == '2' ? 'checked' : "" ?>> Weekly</label>
                  </div>

                  <div id="form-group">
                     <div class="form-group">
                        <label>Confirm Date (days)</label>
                        <input type="number" name="confirm_date" value="<?php echo $dulieu->confirm_date; ?>" class="form-control" placeholder="e.g., 7">
                     </div>
                     <div class="form-group">
                        <label>Pay Date (days)</label>
                        <input type="number" name="hold_period" value="<?php echo $dulieu->hold_period; ?>" class="form-control" placeholder="e.g., 5">
                     </div>
                  </div>

                  <button class="btn btn-primary" type="button" id="addpreviewlanding">Add</button>

                  <div class="form-group row" id="preview_landing">
                     <?php
                     $previews = unserialize($dulieu->preview);
                     $landing_pages = unserialize($dulieu->landingpage);
                     ?>
                     <?php if ($previews): for ($i = 0; $i <= count($previews) - 1; $i++): ?>
                           <div class="col-md-6">
                              <label class="landingLabel">Preview name #<?= $i + 1 ?></label>
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                 <input type="text" class="form-control preview-input" id="previewname" value="<?= $previews[$i]['name'] ?>" name="preview[<?= $i ?>][name]" placeholder="Preview URL" />
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label class="landingLabel">Preview offer #<?= $i + 1 ?></label>
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                 <input type="text" class="form-control" id="preview" value="<?= $previews[$i]['value'] ?>" name="preview[<?= $i ?>][value]" placeholder="Preview URL" />
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label class="landingLabel">Landing Page Name #<?= $i + 1 ?></label>
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                 <input type="text" class="form-control" id="landingpagename" name="landingpage[<?= $i ?>][name]"
                                    value="<?= $landing_pages[$i]['name'] ?>" placeholder="Landing Page" />
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label class="landingLabel">Landing Page #<?= $i + 1 ?></label>
                              <div class="input-group">
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                 <input type="text" class="form-control" id="landingpage" name="landingpage[<?= $i ?>][value]"
                                    value="<?= $landing_pages[$i]['value'] ?>" placeholder="Landing Page" />
                              </div>
                           </div>
                     <?php endfor;
                     endif ?>
                  </div>

                  <div class="form-group">
                     <label>Track link</label>
                     <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                        <input type="text" class="form-control" id="url" name="url" value="<?php if ($dulieu) {
                                                                                                echo $dulieu->url;
                                                                                             } ?>" placeholder="Offer URL" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label>Image</label>
                     <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-camera"></span></span>
                        <input type="text" name="img" value="<?php if ($dulieu) {
                                                                  echo $dulieu->img;
                                                               } ?>" placeholder="Logo" id="xFilePath" class="form-control" />
                        <span class="input-group-btn">
                           <button onclick="BrowseServer();" type="button" class="btn btn-default">upload</button>
                        </span>
                     </div>
                  </div>


                  <!-- Container chung cho cả hai hàng -->
                  <div class="request-container">

                     <!-- Request 1 -->
                     <div class="form-group">
                        <div class="request-row">

                           <!-- <div class="request-item">
                              <label>Request</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->request == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="request" value="<?php echo !empty($dulieu->request) ? $dulieu->request : 0; ?>" />
                                 </span>
                              </div>
                           </div>

                           <div class="request-item">
                              <label>Show / Hide</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php if ($dulieu) {
                                                            echo $dulieu->show == 1 ? '' : ' off';
                                                         } ?>">
                                    <a href="">switch off</a>
                                    <input id="off_on" type='hidden' name="show" value="<?php if (!empty($dulieu->show)) {
                                                                                             echo $dulieu->show;
                                                                                          } else {
                                                                                             echo 0;
                                                                                          } ?>" />
                                 </span>
                              </div>
                           </div>

                           <div class="request-item">
                              <label>Referal Require</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php if ($dulieu) {
                                                            echo $dulieu->refrequire == 1 ? '' : ' off';
                                                         } ?>">
                                    <a href="">switch off</a>
                                    <input id="off_on" type='hidden' name="refrequire" value="<?php if (!empty($dulieu->refrequire)) {
                                                                                                   echo $dulieu->refrequire;
                                                                                                } else {
                                                                                                   echo 0;
                                                                                                } ?>" />
                                 </span>
                              </div>
                           </div>

                           <div class="request-item">
                              <label>Request Traffic</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->trafrequire == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="trafrequire" value="<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->trafrequire == 1) ? '1' : '0'; ?>" />
                                 </span>
                              </div>
                           </div> -->

                           <div class="request-item">
                              <label>Language</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->reqlang == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="reqlang" value="<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->reqlang == 1) ? '1' : '0'; ?>" />
                                 </span>
                              </div>
                           </div>

                        </div>
                     </div>

                     <!-- Request 2 -->
                     <div class="form-group">
                        <div class="request-row">

                           <div class="request-item">
                              <label>Request Device</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->reqdev == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="reqdev" value="<?php echo !empty($dulieu->reqdev) ? $dulieu->reqdev : 0; ?>" />
                                 </span>
                                 <button type="button" class="info-btn all-exc" data-toggle="modal" data-target="#reqdevModal" id='device'>
                                    <i class="glyphicon glyphicon-cog"></i>
                                 </button>
                              </div>
                           </div>

                           <div class="request-item">
                              <label>CR Require</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->reqcr == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="reqcr" value="<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->reqcr == 1) ? '1' : '0'; ?>" />
                                 </span>
                                 <button type="button" class="info-btn all-exc" data-toggle="modal" data-target="#crRequireModal" id='cr'>
                                    <i class="glyphicon glyphicon-cog"></i>
                                 </button>
                              </div>
                           </div>

                           <!-- <div class="request-item">
                              <label>Speed Control</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->speed == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="speed" value="<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->speed == 1) ? '1' : '0'; ?>" />
                                 </span>
                                 <button type="button" class="info-btn all-exc" data-toggle="modal" data-target="#speedControlModal" id='speed'>
                                    <i class="glyphicon glyphicon-cog"></i>
                                 </button>
                              </div>
                           </div>

                           <div class="request-item">
                              <label>Working Hours</label>
                              <div class="request-controls">
                                 <span class="box_switch<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->working_hours == 1) ? '' : ' off'; ?>">
                                    <a href="">switch off</a>
                                    <input type="hidden" name="working_hours" value="<?php echo (isset($dulieu) && is_object($dulieu) && $dulieu->working_hours == 1) ? '1' : '0'; ?>" />
                                 </span>
                                 <button type="button" class="info-btn all-exc" data-toggle="modal" data-target="#workingHoursModal" id='hours'>
                                    <i class="glyphicon glyphicon-cog"></i>
                                 </button>
                              </div>
                           </div>

                           <div class="request-item" style="visibility: hidden;">
                              <label>&nbsp;</label>
                              <div class="request-controls">
                                 <span class="box_switch off">
                                    <a href="">switch off</a>
                                    <input type="hidden" value="0" disable />
                                 </span>
                                 <button type="button" class="info-btn">
                                    <i class="glyphicon glyphicon-cog"></i>
                                 </button>
                              </div>
                           </div> -->

                        </div>
                     </div>

                  </div>

                  <!-- Device option -->
                  <div class="form-group" id="device_options_container" style="margin-top:20px;display:none">
                     <div class="panel panel-default">
                        <div class="panel-heading" style="padding:5px">
                           <label class="devicelable">Device Distribution</label>
                        </div>
                        <div class="panel-body">
                           <!-- Desktop only -->
                           <div class="form-group">
                              <div class="radio">
                                 <label class="control-label" style="font-weight: normal;">
                                    <input type="radio" name="mode" value="desktop" class="device-option-radio">
                                    <strong>Desktop Only</strong> - System allows only 100% desktop traffic
                                 </label>
                                 <div class="device-percentages desktop-fields" style="display:none;margin-left:20px; margin-top:10px;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Desktop</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                                             <input type="number" class="form-control" name="desktop[desk_pct]" value="100" readonly>
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Mobile (include tablet)</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                             <input type="number" class="form-control" name="desktop[mob_pct]" value="0" readonly>
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- ------------ -->

                           <!-- Mobile only -->
                           <div class="form-group">
                              <div class="radio">
                                 <label class="control-label" style="font-weight: normal;">
                                    <input type="radio" name="mode" value="mobile" class="device-option-radio">
                                    <strong>Mobile Only</strong> - System allows only 100% mobile & tablet traffic
                                 </label>
                                 <div class="device-percentages mobile-fields" style="display:none; margin-left:20px;margin-top:10px;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Desktop</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                                             <input type="number" class="form-control" name="mobile[desk_pct]" value="0" readonly>
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Mobile (include tablet)</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                             <input type="number" class="form-control" name="mobile[mob_pct]" value="100" readonly>
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- ----------- -->

                           <!-- Mix -->
                           <div class="form-group">
                              <div class="radio">
                                 <label class="control-label" style="font-weight: normal;">
                                    <input type="radio" name="mode" value="all" class="device-option-radio">
                                    <strong>Custom Distribution</strong> - Set your preferred device percentage mix
                                 </label>
                                 <div class="device-percentages all-fields" style="display:none; margin-left:20px; margin-top:10px;">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Desktop</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                                             <input type="number" class="form-control" name="all[desk_pct]" value="<?php if (isset($dev_mode)) {
                                                                                                                        if ($dev_mode->mode == 'all') {
                                                                                                                           echo $dev_mode->desk_pct;
                                                                                                                        }
                                                                                                                     } ?>" min="0" max="100">
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <label style="padding-left:0;margin-bottom:3px">Mobile (include tablet)</label>
                                          <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                             <input type="number" class="form-control" name="all[mob_pct]" value="<?php if (isset($dev_mode)) {
                                                                                                                     if ($dev_mode->mode == 'all') {
                                                                                                                        echo $dev_mode->mob_pct;
                                                                                                                     }
                                                                                                                  } ?>" min="0" max="100">
                                             <span class="input-group-addon">%</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- --- -->
                        </div>
                     </div>
                  </div>
                  <!-- End device option -->

                  <!-- Language Container -->
                  <div class="form-group" id="laguage_container" style="display: none; margin-top:20px">
                     <div class="panel panel-default">
                        <div class="panel-body">
                           <label>Allowed Languages</label>

                           <!-- Search input field -->
                           <input type="text" class="form-control input-sm" id="slang" placeholder="Search Languages">

                           <!-- Select/deselect all button -->
                           <div class="lang-actions" style="margin: 10px 0;">
                              <button type="button" class="btn btn-xs btn-primary" id="select-all-lang">Select All</button>
                              <button type="button" class="btn btn-xs btn-default" id="deselect-all-lang">Deselect All</button>
                           </div>

                           <!-- Scrollable checkbox container -->
                           <div class="catscroll langcontent d-flex" style="padding: 10px; border-radius: 4px; background: #fafafa;">
                              <?php
                              $mangctry = array();

                              if (!empty($selectedctry)) {
                                 foreach ($selectedctry as $ctry) {
                                    $mangctry[] = $ctry->country;
                                 }
                              }

                              if (!empty($lang)) {
                                 foreach ($lang as $language) {
                                    echo '<p style="width: 33%; margin-bottom: 5px;">
                                          <label style="font-weight: normal; margin-bottom: 0; width: 100%; cursor: pointer;">
                                             <input type="checkbox" value="' . $language->name . '" name="lang[]" style="margin-right: 5px;" ';
                                    if (in_array($language->name, $mangctry)) {
                                       echo ' checked';
                                    }
                                    echo ' /> ' . $language->name . '
                                          </label>
                                       </p>';
                                 }
                              }
                              ?>
                           </div>

                           <!-- Keep the hidden input to maintain compatibility -->
                           <input type="hidden" id="all_ctry_name" value="<?php
                                                                           $all_ctry = [];
                                                                           foreach ($lang as $ctry) {
                                                                              $all_ctry[] = $ctry->name;
                                                                           }
                                                                           echo implode(',', $all_ctry);
                                                                           ?>">
                        </div>
                     </div>
                  </div>
                  <!-- --------------- -->

                  <!-- CR option -->
                  <div class="form-group" id="cr_options_container" style="margin-top:20px;display:none">
                     <div class="panel panel-default">
                        <div class="panel-heading" style="padding:5px">
                           <label class="crOption">CR Option</label>
                        </div>
                        <div class="panel-body">
                           <div class="form-group">
                              <div class="radio">
                                 <label class="control-label" style="font-weight: normal;">
                                    <input type="radio" name="cr_mode" value="3-15-5" class="cr-option-radio"
                                       <?php echo (isset($cr_mode) && $cr_mode == '3-15-5') ? 'checked' : ''; ?>>
                                    <strong>3% - 15%</strong> - CR must be between 3% and 15% (check after 5 conversions)
                                 </label>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="radio">
                                 <label class="control-label" style="font-weight: normal;">
                                    <input type="radio" name="cr_mode" value="2-30-10" class="cr-option-radio"
                                       <?php echo (isset($cr_mode) && $cr_mode == '2-30-10') ? 'checked' : ''; ?>>
                                    <strong>2% - 30%</strong> - CR must be between 2% and 30% (check after 10 conversions)
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End CR option -->

                  <input id="off_on" type='hidden' name="smartlink" value="0" />
                  <input id="off_on" type='hidden' name="smartoff" value="0" />
                  <input id="off_on" type='hidden' name="show" value="1" />

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group alert alert-info">
                           <label>Description</label>
                           <textarea name="description" class="form-control" rows="3"><?php if ($dulieu) {
                                                                                          echo $dulieu->description;
                                                                                       } ?></textarea>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group alert alert-info">
                           <label>Conversion Flow</label>
                           <textarea name="convert_on" class="form-control" rows="3"><?php if ($dulieu) {
                                                                                          echo $dulieu->convert_on;
                                                                                       } ?></textarea>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group alert alert-success">
                           <label>Allowed Traffic Sources</label>
                           <select name="traffic_source[]" class="selectpicker" multiple aria-label="size 3 select example">
                              <?php $traffic_sources = explode(',', $dulieu->traffic_source); ?>
                              <?php foreach ($trafficTypes as $type): ?>
                                 <option value="<?= $type->content ?>" <?= in_array($type->content, $traffic_sources) ? 'selected' : '' ?>><?= $type->content ?></option>
                              <?php endforeach ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group alert alert-success">
                           <label>Restricted Traffic Sources</label>
                           <select class="selectpicker" multiple aria-label="size 3 select example" name="restriced_traffics[]">
                              <?php $restricted_traffic_sources = explode(',', $dulieu->restriced_traffics); ?>
                              <?php foreach ($trafficTypes as $type): ?>
                                 <option value="<?= $type->content ?>" <?= in_array($type->content, $restricted_traffic_sources) ? 'selected' : '' ?>><?= $type->content ?></option>
                              <?php endforeach ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <label>country</label>
                              <input type="text" class="form-control input-sm" id="sgeo" placeholder="Search GEOS">
                              <div class="catscroll geocontent d-flex">

                                 <?php
                                 $mangnsx = $pointgeo = array();
                                 if (!empty($dulieu)) $pointgeo = unserialize($dulieu->point_geos);
                                 if (!empty($dulieu)) $percent_geos = unserialize($dulieu->percent_geos);
                                 if (!empty($dulieu)) {
                                    $mangnsx = explode('o', $dulieu->country);
                                 }
                                 if (!empty($pointgeo['all'])) {
                                    $pp = $pointgeo['all'];
                                 } else {
                                    $pp = '';
                                 }
                                 echo '<p><input type="checkbox" value="all" name="country[]" ';
                                 if (in_array('all', $mangnsx)) {
                                    echo ' checked';
                                 }
                                 echo ' />
                                       <span class="title_keycode"> All</span>
                                       <input name="point_geos[all]" type="text" class="form-control input-sm amount point_ct"
                                       value="' . $pp . '"
                                       placeholder="Payout" />';
                                 if (!empty($percent_geos['all'])) {
                                    $pp = $percent_geos['all'];
                                 } else {
                                    $pp = '';
                                 }
                                 echo
                                 '<input name="percent_geos[all]" type="text" class="form-control input-sm amount point_ct"
                                       value="' . $pp . '"
                                       placeholder="%" />
                                       </p>
                                       ';

                                 if (!empty($country)) {
                                    foreach ($country as $country) {
                                       echo '
                                               <p><input type="checkbox" value="' . $country->id . '" name="country[]" ';
                                       if (!empty($mangnsx)) {
                                          if (in_array($country->id, $mangnsx)) {
                                             echo ' checked';
                                          }
                                       }
                                       if (!empty($pointgeo[$country->keycode])) {
                                          $pp = $pointgeo[$country->keycode];
                                       } else {
                                          $pp = '';
                                       }
                                       echo '
                                               />
                                               <span class="title_keycode">' . $country->keycode . '</span>
                                               <input name="point_geos[' . $country->keycode . ']" type="text" class="form-control input-sm amount point_ct"
                                               value ="' . $pp . '"
                                               placeholder="Payout"/>';

                                       if (!empty($percent_geos[$country->keycode])) {
                                          $pp = $percent_geos[$country->keycode];
                                       } else {
                                          $pp = '';
                                       }

                                       echo
                                       '<input name="percent_geos[' . $country->keycode . ']" type="text" class="form-control input-sm amount point_ct"
                                               value ="' . $pp . '"
                                               placeholder="%"/>
                                               </p>
                                               ';
                                    }
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <label>offercattegory</label>
                              <input type="text" class="form-control input-sm" placeholder="">
                              <div class="catscroll pppp">
                                 <?php if (!empty($cat)) {
                                    echo $cat;
                                 } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="alert alert-success posbacklink" role="alert"></div>

                  <button type="submit" class="btn btn-default">Submit</button>
               </div>
            </div>
         </form>
      </div>

   </div>
</div>

<script>
   var selected = <?php echo isset($dev_mode) ? json_encode($dev_mode->mode) : "null"; ?>;

   var capUrl = '<?php echo base_url(); ?>manager/exceptionHandler/show_capModal';
   var savecapPub = '<?php echo base_url(); ?>manager/exceptionHandler/save_cappub';
   var delete_exccap = '<?php echo base_url(); ?>manager/exceptionHandler/delete_exccap';

   var modalUrl = '<?php echo base_url(); ?>manager/exceptionHandler/show_modal';
   var save_exce = '<?php echo base_url(); ?>manager/exceptionHandler/save_exce';
   var delete_exc = '<?php echo base_url(); ?>manager/exceptionHandler/delete_exc';
</script>
<script src="<?php echo base_url('temp/manager/js/offer_edit.js'); ?>?v=<?php echo rand(1000, 9999); ?>"></script>