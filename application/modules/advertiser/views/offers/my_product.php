<script>
   $(document).ready(function() {
      $('.order_wrap_list_items').on('click', function() {
         var urla = '<?php echo base_url('v2/smartlinks/ajorder'); ?>';
         $dt = $(this).attr('data-sort');
         $.ajax({
            type: "POST",
            url: urla,
            data: {
               data: $dt
            },
            success: function() {
               location.reload();
            }
         });
      })

   })
</script>

<style>
   .custom-container {
      width: 70%;
   }

   .flag_icon_country {
      border-right: 1px solid #cacaca;
      padding: 0 5px;
   }

   .enditem {
      border-right: 0px !important;
   }

   .select2-selection--multiple:before {
      content: "";
      position: absolute;
      right: 7px;
      top: 42%;
      border-top: 5px solid #888;
      border-left: 4px solid transparent;
      border-right: 4px solid transparent;
   }

   .select2-selection {
      border-radius: 4px;
      background: transparent;
   }

   .select2-search__field {
      background: transparent;
   }

   .select2-selection {
      background: transparent;
   }

   .smlinks {
      border: 1px solid #cacaca;
      width: 150px;
      height: 32px;
      line-height: 32px;
      margin: 0 5px;
      border-radius: 4px;
   }

   .smlinks:hover {
      border-color: #56bf85;
   }

   .smlinks a {
      padding: 0 !important
   }

   .card-footer {
      background-color: #ffffff;
      border-top: none;
   }

   .show-detail:hover {
      cursor: pointer;
   }

   .order_wrap_list_items {
      width: 100%;
   }

   .custom-modal {
      margin: 0 !important;
   }

   .heart-icon {
      display: flex;
      align-items: center;
   }

   .heart-icon:hover {
      color: red;
      cursor: pointer;
   }

   .heart-icon .fill {
      color: red;
   }

   .ranking-icon {
      background-image: url('<?php echo base_url(); ?>/temp/ranking.png');
      min-height: 40px;
      height: 100%;
      background-position: center;
      background-repeat: no-repeat;
      background-size: contain;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .ranking-icon__text {
      font-size: 1.55em;
      color: #d7a942;
   }

   .full-width {
      display: flex;
      justify-content: space-between;
   }

   .custom-container {
      width: 70%;
   }

   .sticky-banners {
      padding-top: 40px;
      height: 300px;
      width: 200px;
      top: 50px;
   }

   #load-more-btn {
      background: linear-gradient(135deg, #FFD832 0%, #FFC107 100%);
      border: none;
      border-radius: 50px;
      padding: 10px 25px;
      font-weight: 500;
      color: #666;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 8px 25px rgba(255, 216, 50, 0.4);
      position: relative;
      overflow: hidden;
   }

   #load-more-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 12px 35px rgba(255, 216, 50, 0.6);
   }

   #load-more-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      transition: left 0.5s;
   }

   #load-more-btn:hover::before {
      left: 100%;
   }

   .no-more-offers {
      background: linear-gradient(135deg, #FFD832 0%, #FFC107 100%);
      color: #666;
      padding: 12px 20px;
      border-radius: 25px;
      font-weight: 500;
      text-align: center;
      font-size: 14px;
      box-shadow: 0 8px 25px rgba(255, 216, 50, 0.4);
      border: 3px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
      animation: fadeInUp 0.6s ease-out;
   }

   @keyframes fadeInUp {
      from {
         opacity: 0;
         transform: translateY(30px);
      }

      to {
         opacity: 1;
         transform: translateY(0);
      }
   }
</style>

<div class="full-width">
   <div class="left-banners sticky-banners">
      <h6 class="text-center" style="margin-botton:0px"><?= isset($left_title->content) ? substr($left_title->content, 0, 3) : '' ?></h6>
      <h6 class="text-center"><?= isset($left_title->content) ? substr($left_title->content, 4) : '' ?></h6>
      <div class="row" style="margin-top:20px">
         <?php foreach ($left_banners ? $left_banners : [] as $banner): ?>
            <a href="<?= $banner->link_page ?>" target="_blank">
               <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
            </a>
         <?php endforeach; ?>
      </div>
   </div>

   <div class="custom-container">
      <div class="card mt-5">
         <div class="card-body">
            <?php include('filters/input_search.php'); ?>
            <link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
            <script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>
            <script>
               $(document).ready(function() {
                  $('.card-offers-sinput').focusin(function() {
                     $('.nut').text('Enter');
                     $('.nut').addClass('focus-input-span');
                     $('.card-offers-sboxs').addClass('focus-input');
                  })
                  $('.card-offers-sinput').focusout(function() {
                     $('.nut').text('/');
                     $('.nut').removeClass('focus-input-span');
                     $('.card-offers-sboxs').removeClass('focus-input');
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
                  $('.chosen-select3').select2({
                     theme: "classic",
                     width: '100%'
                  });
                  $('.chosen-select-types').select2({
                     theme: "classic",
                     width: '100%'
                  });

                  $('.handle_click').click(function() {
                     const isSelected = $(this).data('selected') === 'none' ? false : true;
                     var data = isSelected ? [] : [$(this).attr('value')];
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  })

                  $('.filteroff').change(function() {
                     var data = $(this).val();
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  })

                  $('.tag-text-pay').click(function() {
                     var data = [$(this).attr('value')];
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  })
                  $('.tag-text-cat').click(function() {
                     var data = [$(this).attr('value')];
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  })

                  $('.card-offers-sicon').click(function() {
                     const data = $('.card-offers-sinput').val()
                     var name = $('.card-offers-sinput').attr('name');
                     ajaxFilterO(data, name);
                  });
               })

               function ajaxFilterO(data, name) {
                  var ajurl = "<?php echo base_url('/v2/offers/ajax_serach_offer'); ?>";
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

            <div class="border-top mt-1 pt-1 d-flex align-items-center justify-content-between">
               <div class="d-flex flex-column">
                  <span class="card-offers-sresult">Quick sort for my product</span>
                  <span><?php if (!empty($totals)) echo $totals;
                        else echo 0; ?>&nbsp;Product</span>
                  <?php include('filters/option_search.php'); ?>
               </div>
            </div>
         </div>
      </div>
      <div class="row" id="list_offers">
         <?php
         if (!empty($offer)) {
            foreach ($offer as $offer) {
               $termcat = '
                              <a href="#" class="align-items-center me-3 tag-link">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                 </svg>
                                 <span class="tag-text tag-text-pay d-inline" name="opaymterm" value="' . $offer->paymterm . '">' . $marrpaymterm[$offer->paymterm] . '</span>
                              </a>';

               $Icon = '';
               $point_geos_s = '';
               $mIdCountry = explode('o', substr($offer->country, 1, -1));
               $point_geos = unserialize($offer->point_geos);
               $percent_geos = unserialize($offer->percent_geos);
               $mCountryKeycode['all'] = '';
               if ($mIdCountry) {
                  $dem = 0;
                  $cll = '';
                  $soluong = count($mIdCountry);
                  foreach ($mIdCountry as $mIdCountry) {
                     $geo_code = strtoupper($mCountryKeycode[$mIdCountry]);
                     if (!empty($point_geos[$geo_code])) {
                        $point = '$' . round($point_geos[$geo_code]);
                     } else {
                        if (!empty($percent_geos[$geo_code])) {
                           $point = round($percent_geos[$geo_code]) . '% Revshare';
                        } else {
                           $point = '$0';
                        }
                     }

                     if ($mIdCountry == 'all') {
                        $Icon = 'All Countries ';
                        if (!empty($point_geos['all'])) $point = '$' . $point_geos['all'];
                        if (!empty($percent_geos['all'])) $point = $percent_geos['all'] . '% Revshare';
                     } else {
                        $Icon = '<img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/' . $mCountryKeycode[$mIdCountry] . '.svg">';
                     }

                     $dem++;
                     if ($dem == $soluong) {
                        $cll = 'enditem';
                     }
                     if ($dem < 3) {
                        $point_geos_s .= '                     
                              <div class="flag_icon_country ' . $cll . '">
                                 <span class="boffer_point" style="font-size:12px;"><span>' . $point . '</span></span>&nbsp—
                                 ' . $Icon . '
                              </div>';
                     }
                  }
               }
               if ($dem >= 3) {
                  $soluong = $soluong - 2;
                  $point_geos_s .= "<div><span>&nbsp+" . $soluong . "</span></div>";
               }

               $cat_tag = '';
               $mIdCat = explode('o', substr($offer->offercat, 1, -1));
               if ($mIdCat) {
                  foreach ($mIdCat as $mIdCat) {
                     $cat_tag .= '
                                 <a href="#" class="align-items-center me-3 tag-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                                       <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                       <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                    </svg>
                                    <span class="tag-text tag-text-cat d-inline" name="oCat" value="' . $mIdCat . '">' . $mOfferCat[$mIdCat] . '</span>                                    
                                 </a>';
                  }
               }

               if ($offer->request && $offer->status != 'Approved') {
                  if ($offer->status == 'Pending') {
                     $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-warning btn-sm">Pending</a> ';
                  } else {
                     $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-primary btn-sm">Request Access</a> ';
                  }
               } else {
                  $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-success btn-sm">Get Link</a>';
               }

               if ($offer->smtype == 2) {
                  $badge = '<span class="badge bg-success"> Smart Offer </span>';
               } elseif ($offer->smtype == 3) {
                  $badge = '<span class="badge bg-info"> Smart Link </span>';
               } else {
                  $badge = '';
               }
               include('model_myproduct.php');
            }
         } else {
            echo '
               <div class="col-12 my-5">
                  <div class="d-flex justify-content-center"><h6>There are no offers</h6></div>
               </div>';
         }
         ?>
      </div>

      <?php if (!$final_page): ?>
         <div class="text-center my-4" id="load-more-section">
            <button class="btn btn-primary btn-lg" id="load-more-btn">
               <span class="load-more-text">Load More Offers</span>
               <span class="load-more-spinner d-none">
                  <img src="<?= base_url('temp/default/images/loading.gif') ?>" width="20" height="20" class="me-2">
                  Loading...
               </span>
            </button>
         </div>
      <?php endif; ?>

      <?php if ($final_page && empty($offer)): ?>
         <div class="text-center my-4 no-more-offers">
            🎉 No offers available at the moment.
         </div>
      <?php elseif ($final_page): ?>
         <div class="text-center my-4 no-more-offers">
            🎉 All offers loaded! No more offers available.
         </div>
      <?php endif; ?>

   </div>

   <div class="right-banners sticky-banners">
      <h6 class="text-center" style="margin-botton:0px"><?php echo isset($right_title) ? substr($right_title->content, 0, 3) : '' ?></h6>
      <h6 class="text-center"><?php echo isset($right_title) ? substr($right_title->content, 4) : '' ?></h6>
      <div class="row" style="margin-top:20px">
         <?php foreach ($right_banners ? $right_banners : [] as $banner): ?>
            <a href="<?= $banner->link_page ?>" target="_blank">
               <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
            </a>
         <?php endforeach; ?>
      </div>
   </div>

   <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 99999;">
      <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
         <div class="toast-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
               <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
            <span id="toastContent">Copy to clipboard</span>
         </div>
      </div>
   </div>

</div>

<script>
   var page = 0;
   var is_loading = false;
   if ($('#load-more-btn').is(':visible')) {
      $('#load-more-btn').prop('disabled', false);
   }

   $(document).ready(function() {
      $('#load-more-btn').click(function() {
         if (!is_loading) {
            is_loading = true;
            page++;
            $('.load-more-text').addClass('d-none');
            $('.load-more-spinner').removeClass('d-none');
            $('#load-more-btn').prop('disabled', true);
            load_more_offers(page);
         }
      });

      function load_more_offers(page) {
         const url = `<?= base_url('v2/offers/available') ?>/${page}`;
         $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
               if (response && response.trim() !== '') {
                  $('#list_offers').append(response);
                  $('.tag-text-pay').off('click').on('click', function() {
                     var data = [$(this).attr('value')];
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  });
                  $('.tag-text-cat').off('click').on('click', function() {
                     var data = [$(this).attr('value')];
                     var name = $(this).attr('name');
                     ajaxFilterO(data, name);
                  });

                  if ($('#final_page_indicator').val() === 'true') {
                     $('#load-more-section').hide();
                  }
               } else {
                  $('#load-more-section').hide();
               }
            },
            error: function() {
               $('#load-more-section').hide();
            },
            complete: function() {
               is_loading = false;
               $('.load-more-text').removeClass('d-none');
               $('.load-more-spinner').addClass('d-none');

               if ($('#load-more-section').is(':visible')) {
                  $('#load-more-btn').prop('disabled', false);
               } else {
                  $('#list_offers').append('<div class="text-center my-4 no-more-offers">🎉 All offers loaded! No more offers available.</div>');
               }
            }
         });
      }
   });
</script>