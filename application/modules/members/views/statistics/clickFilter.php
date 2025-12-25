<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="<?php echo base_url(); ?>/temp/default/css/statistics.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/temp/default/css/clickfilter.css" rel="stylesheet">

<div class="card mt-5">
   <div class="card-body">
      <!--chart-->
      <span class="card-offers-stitle"><?php echo ucfirst($this->uri->segment(3)) ?></span>
      <form id="form_loc" method="POST" action="">
         <div class="card-offers-sboxs mb-3">
            <input name="sdate" id="date_range" type="text" placeholder="Search" class="card-offers-sinput">
         </div>
         <div class="row">
            <div class="row">
               <div class="col-4 pe-1 mb-2 tttesst">
                  <label for="ips" class="form-label">Click Id</label>
                  <textarea class="form-control" rows="3" name="clickid"><?php echo $this->session->userdata('clickid') ?></textarea>
               </div>
               <div class="col-4 pe-1 mb-2 tttesst">
                  <label for="ips" class="form-label">Product Id</label>
                  <textarea class="form-control" rows="3" name="sOffer"><?php echo $this->session->userdata('sOffer') ?></textarea>
               </div>

               <div class="mb-3 col-4">
                  <label for="ips" class="form-label">Ips (ip1,ip2,..)</label>
                  <textarea class="form-control" id="ips" rows="3" name="ips"></textarea>
               </div>
            </div>
            <div class="row">

            </div>
         </div>
      </form>
      <link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
      <script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>
      <script>
         $(document).ready(function() {
            $('#date_range').daterangepicker({
                  "maxSpan": {
                     "year": 2
                  },
                  minYear: 2020,
                  maxYear: <?php echo date("Y"); ?>,
                  ranges: {
                     'Today': [moment(), moment()],
                     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                     'This Month': [moment().startOf('month'), moment().endOf('month')],
                     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  "locale": {
                     "format": "YYYY/MM/DD",
                     "separator": " - "
                  },
                  autoUpdateInput: true,
                  "alwaysShowCalendars": true,
                  "startDate": "<?php echo $this->session->userdata('from'); ?>",
                  "endDate": "<?php echo $this->session->userdata('to'); ?>"
               },
               function(start, end, label) {
                  let data = start.format('YYYY-MM-DD') + '#' + end.format('YYYY-MM-DD');
                  var name = 'date';
                  ajaxFilterO(data, name);
               });

            $('body').click(function() {
               $('#menu_sapxep').removeClass('show');

            })

            $('.chosen-select').select2({
               theme: "classic",
               width: '100%'
            });
            $('.chosen-select2').select2({
               theme: "classic",
               width: '100%'
            });
            $('.chosen-select4').select2({
               theme: "classic",
               width: '100%'
            });

            $('.filteroff').change(function() {
               var data = $(this).val();
               var name = $(this).attr('name');
               ajaxFilterO(data, name);
            });

            $('body').on('click', '.icon_plus_click', function() {
               var date = $(this).attr('id');
               $('.sub_dayli_' + date).toggleClass("hide_content");
               var act = $('.sub_dayli_' + date).hasClass("hide_content");
               if (act) {
                  $(this).children(".icon_congtru").html('<line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>');

               } else {
                  $(this).children(".icon_congtru").html('<line x1="5" y1="12" x2="19" y2="12"></line>');
               }
            });

            $('body').on('click', '.icon_plus', function() {
               var date = $(this).attr('id');
               var ajurl = "<?php echo base_url('/v2/statistics/ajax_sub_dayli'); ?>";

               $(this).children(".icon_congtru").html('<line x1="5" y1="12" x2="19" y2="12"></line>');
               $.ajax({
                  type: "POST",
                  url: ajurl,
                  data: {
                     date: date
                  },
                  success: function(data) {
                     $('#data-' + date).after(data);
                  }

               });
               $(this).addClass('icon_plus_click');
               $(this).removeClass('icon_plus');
            });

         })

         function ajaxFilterO(data, name) {
            var ajurl = "<?php echo base_url('/v2/statistics/ajax_static_dayli'); ?>";
            var loading = '<div class="d-flex justify-content-center mt-2"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            $('#list_offers').html(loading);
            $.ajax({
               type: "POST",
               url: ajurl,
               data: {
                  gt: data,
                  name: name
               },
               success: function() {
                  location.reload();
               }

            });
         }
      </script>

      <style>
         .hide_content {
            display: none
         }

         .icon_plus_click {
            display: block;
            width: 18px;
            height: 18px;
         }
      </style>

      <div class="border-top mt-3 pt-3 d-flex align-items-center justify-content-between">
         <div class="d-flex flex-column">
            <span class="card-offers-sresult">Result</span>
            <span><?php if (!empty($this->total_rows)) echo $this->total_rows;
                  else echo 0; ?>&nbsp;Field</span>
         </div>
         <div style="position:relative" class="menu_sort">
            <button type="button" name="submit" value="1" class="btn btn-success btn-sm ">Search</button>
            <?php if ($this->session->userdata('role') == 2) : ?>
               <button type="button" class="btn btn-primary btn-sm " id="checkAll">Select All</button>
               <button type="button" class="btn btn-secondary btn-sm" id="clearAll">Clear</button>
            <?php endif; ?>
            <button type="button" class="btn btn-primary btn-sm refresh-filter">Refresh</button>
         </div>
      </div>
   </div>
</div>
<!--Mmember f-->
<script>
   var startDate;
   var endDate;
   $(document).ready(function() {
      handleApprove();
      handleRefreshFilter();
      $('#date_range').on('change.datepicker', function(ev) {
         var picker = $(ev.target).data('daterangepicker');
         startDate = picker.startDate;
         endDate = picker.endDate;
      });
      $('.menu_sort button[name="submit"]').on('click', function() {
         $('#form_loc').submit();
      })
   });

   const handleApprove = () => {
      $('.approve-tracklink').click(function() {
         const tracklinkIds = $('input[name="approved_id[]"]:checked').map(function(index, element) {
            return element.value;
         });
         const status = $(this).data('status');

         $.ajax({
            type: "POST",
            url: `<?= base_url(); ?>/v2/statistics/Conversions`,
            data: {
               ids: tracklinkIds.toArray(),
               status
            },
            success: function(response) {
               const content = 'Approved'
               showToast('success', content);
               setTimeout(() => window.location.reload(), 3000);
               $.ajax({
                  type: "GET",
                  url: `<?= base_url(); ?>/cron-jobs/calculator/advertisers/<?= $this->session->userdata('user')->id ?>`,
                  success: function(response) {

                  },
                  error: function(error) {

                  }
               })
            },
            error: function(error) {

            }
         })

      });
   }

   const handleRefreshFilter = () => {
      $('.refresh-filter').click(function() {
         const el = $('#date_range').data('daterangepicker');
         el.setStartDate(moment().subtract(7, 'days'))
         el.setEndDate(moment());

         let data = startDate.format('YYYY-MM-DD') + '#' + endDate.format('YYYY-MM-DD');
         var name = 'date';
         ajaxFilterO(data, name);
      });
   }

   const showToast = (type, content) => {
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
</script>