<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/temp/default/css/click.css" />
<script>
   $(document).ready(function() {
      $("#table-wrapper").DataTable({
         searching: false,
         paging: false,
         info: false
      });
   });
</script>

<?php
include('clickFilter.php');
if (!empty($dulieu)) {
?>

   <div class="_2JyLbpIPgPwI6RhYP28lbl mb-5 table-responsive">
      <div class="_12e1_3IHEVbMTMaTUzZ7r9">
         <table id="table-wrapper" role="table" class="table">
            <thead>
               <tr role="row">
                  <?php if ($this->session->userdata('role') == 2) : ?>
                     <th style="width:50px">#</th>
                     <th style="width:50px">Point</th>
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
               <?php foreach ($dulieu as $dulieu) : ?>
                  <?php
                  if ($dulieu->status == 1) {
                     $status = '<div style="background-color:#916800" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Pending</div>';
                  } elseif ($dulieu->status == 2) {
                     $status = '<div style="background-color:#ffc107" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Declined</div>';
                  } elseif ($dulieu->status == 3) {
                     $status = '<div style="background-color:#5bc0de" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Pay</div>';
                  } elseif ($dulieu->status == 4) {
                     $status = '<div  class="_1zXei-ymiJr9KAeJboeM6O btn-success _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Approved</div>';
                  }
                  ?>
                  <tr role="row">
                     <?php if ($this->session->userdata('role') == 2) : ?>
                        <td class="align-middle"><?php if ($dulieu->flead != 1): ?><input type="checkbox" value="1" name="sendLead[]" class="checkboxWide form-check-input"><?php endif; ?></td>
                        <td style="width:50px" class="align-middle">
                           <?php if ($dulieu->flead != 1): ?><input name="amount2" class="checkboxWide form-check-input" type="text" data-trackid="<?php echo $dulieu->id; ?>" value="<?php echo (float)$dulieu->amount2 ?: ''; ?>"><?php endif; ?>
                        </td>
                     <?php endif; ?>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->id ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= date('Y-m-d H:i:s', strtotime($dulieu->date)) ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->offerid ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->oname ?></span></span></td>
                     <td role="cell">
                        <span class="nowrap">
                           <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/<?= strtolower($dulieu->countries) ?>.svg" style="display: inline-block; width: 1em; height: 1em; vertical-align: middle;">
                           <span class="_1WOmcSS9N_e3KUkqfV0NI"><?php echo trim($dulieu->cities) . ' ' . trim($dulieu->ip); ?></span></span>
                     </td>
                     <td role="cell" class="device">
                        <ul>
                           <li>Language: <?php echo $dulieu->user_language; ?><br /></li>
                           <li>Os_name: <?php echo $dulieu->os_name; ?><br /></li>
                           <li>Browser: <?php echo $dulieu->browser; ?><br /></li>
                           <li>Device_type: <?php echo $dulieu->device_type; ?><br /></li>
                           <li>Device_manuf: <?php echo $dulieu->device_manuf; ?><br /></li>
                        </ul>
                     </td>
                     <td role="cell"><?= $status ?></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->amount2 ?> USD</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->s1 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->s2 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->s3 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->s4 ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->userid ?></span></span></td>
                     <td role="cell">
                        <span class="_1zXei-ymiJr9KAeJboeM6O _3ZpPE5ZwvUy6QGtl56rIQ6" data-bs-toggle="tooltip" title="<?= $dulieu->useragent ?>">
                           <p data-tip="Mozilla/5.0 (Windows NT 6.0; rv:45.0) Gecko/20100101 Firefox/45.0" currentitem="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <circle cx="12" cy="12" r="10"></circle>
                                 <line x1="12" y1="16" x2="12" y2="12"></line>
                                 <line x1="12" y1="8" x2="12.01" y2="8"></line>
                              </svg>
                           </p>
                        </span>
                     </td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= str_replace(",", ", ", $dulieu->traffic_source) ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI">
                           <?php
                           $message = '';
                           $message .= $dulieu->duplicate_ip ? "Duplicated IP <br>" : "";
                           $message .= $dulieu->duplicate_device ? "Duplicated Device <br>" : "";
                           $message .= $dulieu->diff_language ? "Difference Languages <br>" : "";
                           ?>
                           <?php if ($dulieu->duplicate_ip || ($dulieu->duplicate_device && $dulieu->diff_language)) : ?>
                              <span data-bs-toggle="tooltip" data-bs-html="true" title="<?= $message ?>"><i class="fa fa-flag" style="color: red;font-size:20px;"></i></span>
                           <?php elseif ($dulieu->duplicate_device || $dulieu->diff_language) : ?>
                              <span data-bs-toggle="tooltip" data-bs-html="true" title="<?= $message ?>"><i class="fa fa-flag" style="color: #FFD700;font-size:20px;"></i></span>
                           <?php else : ?>
                              <span><i class="fa fa-flag" data-bs-toggle="tooltip" data-bs-html="true" title="
                              Your quality has met the basic requirements.<br>
                              No duplicate IP in same product. <br>
                              No duplicate device and user agent less than 2 times in offer <br>
                              User_language and IP same region" style="color: #008000;font-size:20px;"></i></span>
                           <?php endif; ?>
                     </td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->lead_amount ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?= $dulieu->click_url ?></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><span class="badge bg-danger">Delayed </span> </span></span></td>
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
<?php if ($this->session->userdata('role') == 2) : ?>
   <div class="fixed-bottom-bar">
      <button type="button" class="btn btn-primary btn-sm" id="pushconversion" data-loading-text="<i class='spinner-border'></i> Loading...">Push Conversions</button>
      <button type="button" class="btn btn-success scroll-to-top btn-sm">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-arrow-up" viewBox="0 0 16 16">
            <path d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5" />
            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1" />
         </svg>
      </button>
   </div>
<?php endif; ?>

<script>
   $(document).ready(function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl)
      })

   })

   $("#checkAll").click(function() {
      $('input[name="sendLead[]"]').prop('checked', true);
   });

   $("#clearAll").click(function() {
      $('input[name="sendLead[]"]').prop('checked', false);
   });
   $('.refresh-filter').click(function() {
      location.reload();
   });
</script>


<script>
   $(document).ready(function() {
      var talbeDt = '#table-wrapper '
      $('#pushconversion').on('click', function() {
         var $btn = $(this);
         $btn.data('original-text', $btn.html());
         $btn.html('<i class="spinner-border"></i> Loading...').prop('disabled', true);

         var checkbox = $(talbeDt + ' input[name="sendLead[]"]:checked')
         if (checkbox.length > 0) {
            sendLead(checkbox)
            $btn.html($btn.data('original-text')).prop('disabled', false);
         } else {
            $btn.html($btn.data('original-text')).prop('disabled', false);
            alert('Please check checkbox')
         }
      })

      function sendLead(checkbox) {
         var postData = []
         checkbox.each(function() {
            var tr = $(this).closest('tr')
            var cInput = tr.find('input[name="amount2"]')
            var trackId = cInput.data('trackid')
            var amount2 = cInput.val()
            postData.push({
               trackId: trackId,
               amount2: amount2
            })
         })
         $.ajax({
            type: "POST",
            url: "<?php echo base_url('postback/pushConversion'); ?>",
            data: {
               data: postData
            },
            success: function(data, status) {
               location.reload();
            }
         });

      }

      $(window).scroll(function() {
         if ($(this).scrollTop() > 200) {
            $('.scroll-to-top').fadeIn();
         } else {
            $('.scroll-to-top').fadeOut();
         }
      });

      $('.scroll-to-top').click(function() {
         $('html, body').animate({
            scrollTop: 0
         }, 800);
         return false;
      });
   });
</script>