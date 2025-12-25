<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/temp/default/css/click.css" />
<script>
   $(document).ready(function() {
      $("#example").DataTable({
         searching: false,
         paging: false,
         info: false,
         order: [
            [1, 'desc']
         ]
      });
   });
</script>

<?php
include('clickFilter.php');
if (!empty($data)) { ?>
   <div class="_2JyLbpIPgPwI6RhYP28lbl mb-5 table-responsive">
      <div class="_12e1_3IHEVbMTMaTUzZ7r9">
         <table id="example" role="table" class="table">
            <thead>
               <tr role="row">
                  <?php if ($this->session->userdata('role') == 2) : ?>
                     <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                        <div class="d-flex align-item-center justify-content-between">
                           <span>Approved</span>
                           <i class="fa fa-sort"></i>
                        </div>
                     </th>
                  <?php endif; ?>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Click ID</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Date</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>ID Product</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Product Name</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Geography / IP</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Device</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Status</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Income</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>VIEW </span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>VIEW2</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>VIEW3</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>VIEW4</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Pub_id</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>UserAgent</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>

                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Traffic Type</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Flag</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>

                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>sale_Amount</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Channel url</span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>
                  <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">
                     <div class="d-flex align-item-center justify-content-between">
                        <span>Pay Date </span>
                        <i class="fa fa-sort"></i>
                     </div>
                  </th>

               </tr>
            </thead>
            <tbody role="rowgroup">
               <?php foreach ($data as $data) : ?>
                  <?php
                  if ($data->status == 1) {
                     $status = '<div style="background-color:#916800" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Pending</div>';
                  } elseif ($data->status == 2) {
                     $status = '<div style="background-color:#ffc107" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Declined</div>';
                  } elseif ($data->status == 3) {
                     $status = '<div style="background-color:#5bc0de" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Pay</div>';
                  } elseif ($data->status == 4) {
                     $status = '<div  class="_1zXei-ymiJr9KAeJboeM6O btn-success _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Approved</div>';
                  }
                  ?>
                  <tr role="row">
                     <?php if ($this->session->userdata('role') == 2) : ?>
                        <td role="cell" class="">
                           <?php if ($data->status == 1): ?>
                              <input type="checkbox" name="approved_id[]" class="check" value="<?= $data->id; ?>" <?= $data->status == 1 ? '' : 'disabled' ?>>
                           <?php elseif ($data->status == 2): ?>
                              <input type="checkbox" name="approved_id[]" class="check" value="<?= $data->id; ?>">
                           <?php elseif ($data->status == 3): ?>
                              <!-- pay -->
                              <i class="fa fa-check" style="color: #5bc0de;font-size:20px;"></i>
                           <?php elseif ($data->status == 4): ?>
                              <input type="checkbox" name="approved_id[]" class="check" value="<?= $data->id; ?>">
                           <?php endif; ?>
                        </td>
                     <?php endif; ?>


                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->id ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= date('Y-m-d H:i:s', strtotime($data->date)) ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->offerid ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->oname ?></span></span></td>
                     <td role="cell">
                        <span class="nowrap">
                           <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/<?= strtolower($data->countries) ?>.svg" style="display: inline-block; width: 1em; height: 1em; vertical-align: middle;">
                           <span class="_1WOmcSS9N_e3KUkqfV0NI"><?php echo trim($data->cities) . ' ' . trim($data->ip); ?></span></span>
                     </td>
                     <td role="cell" class="device">
                        <ul>
                           <li>Language: <?php echo $data->user_language; ?><br /></li>
                           <li>Os_name: <?php echo $data->os_name; ?><br /></li>
                           <li>Browser: <?php echo $data->browser; ?><br /></li>
                           <li>Device_type: <?php echo $data->device_type; ?><br /></li>
                           <li>Device_manuf: <?php echo $data->device_manuf; ?><br /></li>
                        </ul>
                     </td>
                     <td role="cell"><?= $status ?></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->amount2 ?> USD</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->s1 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->s2 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->s3 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->s4 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->userid ?></span></span></td>
                     <td role="cell">
                        <span class="_1zXei-ymiJr9KAeJboeM6O _3ZpPE5ZwvUy6QGtl56rIQ6" data-bs-toggle="tooltip" title="<?= $data->useragent ?>">
                           <p data-tip="Mozilla/5.0 (Windows NT 6.0; rv:45.0) Gecko/20100101 Firefox/45.0" currentitem="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <circle cx="12" cy="12" r="10"></circle>
                                 <line x1="12" y1="16" x2="12" y2="12"></line>
                                 <line x1="12" y1="8" x2="12.01" y2="8"></line>
                              </svg>
                           </p>
                        </span>
                     </td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= str_replace(",", ", ", $data->traffic_source) ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI">
                           <?php
                           $message = '';
                           $message .= $data->duplicate_ip ? "Duplicated IP <br>" : "";
                           $message .= $data->duplicate_device ? "Duplicated Device <br>" : "";
                           $message .= $data->diff_language ? "Difference Languages <br>" : "";
                           ?>
                           <?php if ($data->duplicate_ip || ($data->duplicate_device && $data->diff_language)) : ?>
                              <span data-bs-toggle="tooltip" data-bs-html="true" title="<?= $message ?>"><i class="fa fa-flag" style="color: red;font-size:20px;"></i></span>
                           <?php elseif ($data->duplicate_device || $data->diff_language) : ?>
                              <span data-bs-toggle="tooltip" data-bs-html="true" title="<?= $message ?>"><i class="fa fa-flag" style="color: #FFD700;font-size:20px;"></i></span>
                           <?php else : ?>
                              <span><i class="fa fa-flag" data-bs-toggle="tooltip" data-bs-html="true" title="
                              Your quality has met the basic requirements.<br>
                              No duplicate IP in same product. <br>
                              No duplicate device and user agent less than 2 times in offer <br>
                              User_language and IP same region" style="color: #008000;font-size:20px;"></i></span>
                           <?php endif; ?>
                     </td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->lead_amount ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $data->click_url ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><span class="badge bg-danger">Delayed</span> </span></span></td>
                  </tr>

               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>

<?php } else {
   echo '
   <div clas="col-12 d-flex">
   <div class="sc-hMFtBS JjGPM mt-3"><p class="sc-cLQEGU fdNgUv">There are no stats data</p><svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path d="M22.61 16.95A5 5 0 0 0 18 10h-1.26a8 8 0 0 0-7.05-6M5 5a8 8 0 0 0 4 15h9a5 5 0 0 0 1.7-.3"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg></div>
   </div>
   ';
} ?>

<div class="toast position-fixed" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
   <div class="toast-header">
      <strong class="me-auto">Errors</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
   </div>
   <div class="toast-body">

   </div>
</div>

<script>
   $(document).ready(function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl)
      })
   })

   $("#checkAll").click(function() {
      $(".check").prop('checked', true);
   });

   $("#clearAll").click(function() {
      $(".check").prop('checked', false);
   });
</script>