<link href="<?php echo base_url('temp/default/fSelect'); ?>/fSelect.css" rel="stylesheet">
<link href="<?php echo base_url('temp/default/css/add_offer.css') . '?v=' . time(); ?>" rel="stylesheet">
<script src="<?php echo base_url('temp/default/fSelect'); ?>/fSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'ckeditor/ckfinder/ckfinder.js' ?>"></script>
<?php
$advertiser = $this->session->userdata('user');
?>
<br>

<div class="toast position-fixed" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
   <div class="toast-header">
      <strong class="me-auto">Errors</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
   </div>
   <div class="toast-body">

   </div>
</div>

<div class="col-sm-12 col-xs-12 col-md-12" style="background:white">
   <div class="row">
      <div class="box col-md-12">
         <div class="box-header">
            <h2><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                  <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
               </svg><span class="break"></span>Please fill in your product detail below (Note: Star for required fields)</h2>

         </div>
         <div class="box-content">
            <form style="color: cecece;" method="POST" action="<?= base_url('v2/product') ?>">
               <div class="form-group">
                  <?php if ($this->session->userdata('flash:old:success')) : ?>
                     <div class="alert alert-success" role="alert">
                        <?= $this->session->userdata('flash:old:success'); ?>
                     </div>
                  <?php endif; ?>

                  <?php if ($this->session->userdata('flash:old:error') || $errors != '') : ?>
                     <div class="alert alert-danger" role="alert">
                        <?= $this->session->userdata('flash:old:error'); ?>
                        <?= $errors ?>
                     </div>
                  <?php endif; ?>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group alert alert-info">
                        <label>Product Name*</label>
                        <input type="title" class="form-control" id="title" name="title" placeholder="Product Name" />
                     </div>
                     <div class="form-group">
                        <label>Payment Terms</label>
                        <label><input type="radio" name="paymterm_calc" value="1" checked> Monthly</label>
                        <label><input type="radio" name="paymterm_calc" value="2"> Weekly</label>
                     </div>

                     <div id="paymentFields">
                        <div class="form-group">
                           <label>Confirm Date (days) <span data-bs-toggle="tooltip" title="Since the end of the working month" id="confirm-tooltip">❓</span></label>
                           <input type="number" name="confirm_date" class="form-control" placeholder="e.g., 7">
                        </div>
                        <div class="form-group">
                           <label>Pay Date (days) <span data-bs-toggle="tooltip" title="Since the end of the working month" id="hold-tooltip">❓</span></label>
                           <input type="number" name="hold_period" class="form-control" placeholder="e.g., 5">
                        </div>
                     </div>
                     <div class="form-group row mb-3 mt-3">

                        <div class="col-md-3">
                           <label>Advertiser</label>
                           <div class="input-group">
                              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                                 </svg></span>
                              <select name="idnet" class="form-control net_change">
                                 <?php if ($networks) {
                                    foreach ($networks as $category) {
                                       echo '<option value="' . $category->id . '"';
                                       if (!empty($dulieu)) {
                                          echo $dulieu->idnet == $category->id ? ' selected' : '';
                                       }
                                       echo '>';
                                       echo $category->title;
                                       echo '</option>';
                                    }
                                 } else {
                                    echo '<option value="">None</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <label>Product Type*</label>
                           <select name="type" class="form-control">
                              <option>None</option>
                              <?php foreach ($types as $type) : ?>
                                 <option value="<?= $type->id ?>"><?= $type->type ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>

                        <div class="col-md-2">
                           <label>Device*</label>
                           <select name="device" class="form-control">
                              <option value="0">ALL</option>
                              <?php foreach ($devices as $device) : ?>
                                 <option value="<?= $device->id ?>"><?= $device->device ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>


                     </div>
                     <div class="form-group">
                        <label>Tracking link*</label>
                        <div class="input-group">
                           <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                 <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                              </svg></span>
                           <input type="text" class="form-control" id="url" name="url" placeholder="Product URL" />
                        </div>
                     </div>
                     <button class="btn btn-primary" type="button" id="addpreviewlanding" style="padding:0 10px;font-size:15px;">Add</button>
                     <div class="form-group row" id="preview_landing">
                        <div class="col-md-6">
                           <label class="labelLanding">Preview Name 1*</label>
                           <div class="input-group">
                              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                                 </svg></span>
                              <input type="text" class="form-control preview_name" id="preview" name="preview[0][name]" placeholder="Preview Name 1" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="labelLanding">Preview Link 1*</label>
                           <div class="input-group">
                              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                                 </svg></span>
                              <input type="text" class="form-control" id="preview" name="preview[0][value]" placeholder="Preview Link 1" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="labelLanding">Landing Page Name 1</label>
                           <div class="input-group">
                              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                                 </svg></span>
                              <input type="text" class="form-control" id="landingpagename" name="landingpage[0][name]" placeholder="Landing Page Name 1" />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label class="labelLanding">Landing Page Link 1</label>
                           <div class="input-group">
                              <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
                                 </svg></span>
                              <input type="text" class="form-control" id="landingpage" name="landingpage[0][value]" placeholder="Landing Page Link 1" />
                           </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <label>Image(.jpg,.png)* </label>
                        <div class="input-group">
                           <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                 <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                 <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                              </svg></span>
                           <input type="text" name="img" placeholder="Logo" id="xFilePath" class="form-control" />
                           <span class="input-group-btn">
                           </span>
                        </div>
                     </div>
                     <input id="off_on" type='hidden' name="request" value="1" />
                     <input id="off_on" type='hidden' name="smartlink" value="0" />
                     <input id="off_on" type='hidden' name="smartoff" value="0" />
                     <input id="off_on" type='hidden' name="apion" value="1" />
                     <input id="off_on" type='hidden' name="show" value="1" />

                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group alert alert-info">
                              <label>Description*</label>
                              <span style="font-size: 10px;font-style: italic;">Please Introduce your product features</span>


                              <input type='hidden' name="description" id="description_id" />
                              <textarea id="description" class="form-control " rows="3"></textarea>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group alert alert-info">
                              <label>Conversion Flow*</label>
                              <span style="font-size: 10px;font-style: italic;">How conversions is calculated</span>
                              <input type="text" hidden name="convert_on" id="convert_on">
                              <textarea id="convert_on_id" class="form-control " rows="3"></textarea>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="form-group alert alert-success">
                              <label>Allowed Traffic Sources*</label>
                              <select name="traffic_source[]" class="selectpicker" multiple aria-label="size 3 select example">
                                 <?php foreach ($trafficTypes as $type) : ?>
                                    <option value="<?= $type->content ?>"><?= $type->content ?></option>
                                 <?php endforeach ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group alert alert-success">
                              <label>Restricted Traffic Sources*</label>
                              <select class="selectpicker" multiple aria-label="size 3 select example" name="restriced_traffics[]">
                                 <?php foreach ($trafficTypes as $type) : ?>
                                    <option value="<?= $type->content ?>"><?= $type->content ?></option>
                                 <?php endforeach ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <div class="panel panel-default">
                              <div class="panel-body">
                                 <label>Product Geo and Payout Attached*</label>
                                 <span style="font-size: 10px;font-style: italic;">You only need to enter the payout in numbers or percentages, do not enter both boxes at the same time</span>
                                 <input type="text" class="form-control input-sm" id="sgeo" placeholder="Search GEOS">
                                 <!-- chon ca list country-->
                                 <div class="catscroll geocontent ">
                                    <p><input type="checkbox" value="all" name="country[]">
                                       <span class="title_keycode">ALL</span>
                                       <input name="point_geos[all]" type="text" class="form-control input-sm amount point_ct" value="" placeholder="Payout">
                                       <input name="percent_geos[all]" type="text" class="form-control input-sm amount point_ct" placeholder="%">
                                    </p>
                                    <?php foreach ($countries as $country) : ?>
                                       <p><input type="checkbox" value="<?= $country->id ?>" name="country[]">
                                          <span class="title_keycode"><?= $country->keycode ?></span>
                                          <input name="point_geos[<?= $country->keycode ?>]" type="text" class="form-control input-sm amount point_ct" value="" placeholder="Payout">
                                          <input name="percent_geos[<?= $country->keycode ?>]" type="text" class="form-control input-sm amount point_ct" placeholder="%">
                                       </p>
                                    <?php endforeach; ?>
                                 </div>
                                 <!-- end chon ca list country-->
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="panel panel-default">
                              <div class="panel-body">
                                 <label>Product Category*</label>
                                 <span style="font-size: 10px;font-style: italic;color:white">12121</span>
                                 <input type="text" class="form-control input-sm" id="scats" placeholder="Product Category">
                                 <div class="catscroll search-cats">
                                    <div class="row">
                                       <?php foreach ($categories as $category) : ?>
                                          <p class="col-5"><input type="checkbox" size="40" value="<?= $category->id ?>" name="offercat[]"><?= $category->offercat ?></p>
                                       <?php endforeach; ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="alert alert-success posbacklink" role="alert"></div>
                     <div class="col-md-3 pb-2">
                        <label>Wwaff’s commision </label>
                        <div class="input-group">
                           <span class="input-group-text">%</span>
                           <input type="text" class="form-control" id="percent" name="percent" placeholder="Percent" value="20" />
                        </div>
                     </div>
                     <div style="display:flex; margin-top: 15px; gap: 10px;">
                        <input class="" type="checkbox" value="1" name="agree_with_term" id="agree_with_term_2">
                        <label for="agree_with_term_2">
                           <span>You will agree to let World Wide Affiliate receive 20% commission (deducted directly from payout) when agreeing to add the product.</span></label>
                     </div>
                     <br>
                     <button type="submit" class="btn btn-dark">Submit</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   var parentElement = $('#preview_landing');

   document.getElementById('addpreviewlanding').addEventListener('click', function() {
      let current_preview = $('.preview_name').length - 1;

      var htmlToInsert = `
   <div class="col-md-6">
      <label class="labelLanding" >Preview Name ${current_preview + 2}</label>
      <div class="input-group">
         <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
               fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
               <path
                  d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
            </svg></span>
         <input type="text" class="form-control preview_name" id="preview" name="preview[${current_preview + 1}][name]"
            placeholder="Preview Name ${current_preview + 2}" />
      </div>
   </div>
   <div class="col-md-6">
      <label class="labelLanding" > Preview Link ${current_preview + 2}</label>
      <div class="input-group">
         <span class="input-group-text">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
         </svg>
         </span>
         <input type="text" class="form-control" id="preview" name="preview[${current_preview + 1}][value]" placeholder="Preview Link ${current_preview + 2}" />
      </div>
   </div>
   <div class="col-md-6">
      <label class="labelLanding" >Landing Page Name ${current_preview + 2}</label>
      <div class="input-group">
         <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
               fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
               <path
                  d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
            </svg></span>
         <input type="text" class="form-control" id="landingpagename" name="landingpage[${current_preview + 1}][name]"
            placeholder="Landing Page Name ${current_preview + 2}" />
      </div>
   </div>
   <div class="col-md-6">
      <label class="labelLanding" >Landing Page Link ${current_preview + 2}</label>
      <div class="input-group">
         <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
               fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
               <path
                  d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.162.158-.242.234-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z" />
            </svg></span>
         <input type="text" class="form-control" id="landingpage" name="landingpage[${current_preview + 1}][value]"
            placeholder="Landing Page Link ${current_preview + 2}" />
      </div>
   </div>
   `;
      parentElement.append(htmlToInsert);
   });
</script>

<script>
   $(document).ready(function() {
      validateForm();
      $('.box_switch').click(function() {
         event.preventDefault();
         const switch_box = $(this)
         const input = switch_box.find('input')
         const current_value = input.val()
         if (current_value == 1) {
            switch_box.removeClass('on')
            switch_box.addClass('off')
            input.val(0)
         } else {
            switch_box.removeClass('off')
            switch_box.addClass('on')
            input.val(1)
         }
      });

      $("#sgeo").on("keyup", function() {
         var value = $(this).val().toLowerCase();
         $(".geocontent p").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
         });
      });

      $("#scats").on("keyup", function() {
         var value = $(this).val().toLowerCase();
         $('.search-cats p').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
         });
      });

      var textarea = document.getElementById('description');
      textarea.addEventListener('input', function() {
         var enteredText = textarea.value;
         var formattedText = enteredText.replace(/\n/g, '<br>');

         $("#description_id").val(formattedText)
      });

      var textarea_convert = document.getElementById('convert_on_id');
      textarea_convert.addEventListener('input', function() {
         var enteredText_convert = textarea_convert.value;
         var formattedText_convert = enteredText_convert.replace(/\n/g, '<br>');
         $("#convert_on").val(formattedText_convert)
      });
   });

   function handleSelectChange() {
      var selectedOption = document.getElementById('restricted_select');
   }

   function BrowseServer() {
      var finder = new CKFinder();
      finder.basePath = '../';
      finder.selectActionFunction = SetFileField;
      finder.popup();
   }

   function SetFileField(fileUrl) {
      document.getElementById('xFilePath').value = fileUrl;
   }

   function validateForm() {
      $('form').submit(function() {
         event.preventDefault();
         const formData = new FormData(this)

         $.ajax({
            method: 'POST',
            url: `<?= base_url('/v2/product/') ?>`,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
               if (response == 1) {
                  const content = 'Inserted Successfully'
                  showToast('success', content);
                  setTimeout(() => window.location.href = `<?= base_url('/v2/offers/available') ?>`, 1000);
               } else {
                  const content = String(response).replaceAll('\n', '<br>');
                  showToast('error', content);
               }
            }

         })
      })
   }

   $('input[name="paymterm_calc"]').on('change', function() {
      var value = $('input[name="paymterm_calc"]:checked').val();
      if (value == '1') {
         $('#paymentFields span').attr('data-bs-original-title', '‘’Since the end of the working month’’');
      } else {
         $('#paymentFields span').attr('data-bs-original-title', '‘’Since the end of the working week’’');
      }
   });

   function showToast(type, content) {
      const myToastEl = $('#toast');
      var myToast = new bootstrap.Toast(myToastEl, {
         animation: true,
         delay: 5000,
         autohide: true
      });

      if (type == 'success') {
         $('#toast .toast-header').removeClass('bg-danger')
         $('#toast .toast-body').removeClass('bg-danger')
         $('#toast .toast-header').removeClass('bg-success')
         $('#toast .toast-body').removeClass('bg-success')
         $('#toast .toast-header').addClass('bg-success')
         $('#toast .toast-body').addClass('bg-success')
         $('.toast-header strong').html('Successfully');
         $('.toast-body').html(content);
      } else {
         $('#toast .toast-header').removeClass('bg-danger')
         $('#toast .toast-body').removeClass('bg-danger')
         $('#toast .toast-header').removeClass('bg-success')
         $('#toast .toast-body').removeClass('bg-success')
         $('#toast .toast-header').addClass('bg-danger')
         $('#toast .toast-body').addClass('bg-danger')
         $('.toast-header strong').html('Errors');
         $('.toast-body').html(content);
      }
      myToast.show();
   }

   document.addEventListener('DOMContentLoaded', function() {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach(function(tooltipTriggerEl) {
         new bootstrap.Tooltip(tooltipTriggerEl);
      });
   });

   $('input[name="paymterm_calc"]').on('change', function() {
      var value = $('input[name="paymterm_calc"]:checked').val();
      var tooltipText = '';

      if (value == '1') {
         tooltipText = 'Since the end of the working month';
      } else {
         tooltipText = 'Since the end of the working week';
      }

      $('#confirm-tooltip').attr('data-bs-original-title', tooltipText);
      $('#hold-tooltip').attr('data-bs-original-title', tooltipText);
      $('#confirm-tooltip').attr('title', tooltipText);
      $('#hold-tooltip').attr('title', tooltipText);

      var tooltipElements = [document.getElementById('confirm-tooltip'), document.getElementById('hold-tooltip')];
      tooltipElements.forEach(function(element) {
         var existingTooltip = bootstrap.Tooltip.getInstance(element);
         if (existingTooltip) {
            existingTooltip.dispose();
         }
         new bootstrap.Tooltip(element);
      });
   });
   
</script>