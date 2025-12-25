<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<style>
   #example_wrapper .dataTables_paginate {
      margin-top: 15px;
      text-align: center;
   }

   #example_wrapper .dataTables_paginate .paginate_button {
      display: inline-block;
      padding: 4px 8px;
      margin: 0 1px;
      border: 1px solid #ddd;
      background: #f9f9f9;
      color: #333;
      text-decoration: none;
      border-radius: 3px;
      cursor: pointer;
      font-size: 12px;
   }

   #example_wrapper .dataTables_paginate .paginate_button:hover {
      background: #e9e9e9;
      border-color: #999;
   }

   #example_wrapper .dataTables_paginate .paginate_button.current {
      background: #007bff;
      color: white;
      border-color: #007bff;
   }

   #example_wrapper .dataTables_paginate .paginate_button.disabled {
      color: #999;
      cursor: not-allowed;
      background: #f5f5f5;
   }

   #example_wrapper .dataTables_info {
      margin-top: 10px;
      font-size: 12px;
      color: #666;
   }

   #example_wrapper .dataTables_length,
   #example_wrapper .dataTables_filter {
      display: none;
   }
</style>

<script>
   $(document).ready(function() {
      $("#example").DataTable({
         searching: false,
         paging: true,
         pageLength: 50,
         lengthChange: false,
         info: true,
         order: [
            [0, 'desc']
         ],
         language: {
            paginate: {
               next: "Next",
               previous: "Previous"
            },
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
         }
      });

      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl)
      })
   });

   $("#checkAll").click(function() {
      $(".check").prop('checked', true);
   });
   $("#clearAll").click(function() {
      $(".check").prop('checked', false);
   });
</script>
<?php
include('filter.php');
if (!empty($data)) { ?>

   <style>
      .toast {
         top: 100px;
         right: 10px;
      }

      .toast .bg-success,
      .toast .bg-danger {
         color: white;
      }

      form div>input {
         width: 384px;
      }
   </style>

   <?php
   if ($this->session->userdata('role') == 2) include('conversions_adv.php');
   else include('conversions_pub.php')

   ?>

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