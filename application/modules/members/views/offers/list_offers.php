<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/temp/default/css/offer_list.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
<script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>

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
</style>

<div class="full-width">
   <div class="left-banners sticky-banners">
      <?php if (!empty($left_title) && isset($left_title->content)): ?>
         <h6 class="text-center" style="margin-bottom:0px"><?= htmlspecialchars(substr($left_title->content, 0, 3), ENT_QUOTES, 'UTF-8') ?></h6>
         <h6 class="text-center"><?= htmlspecialchars(substr($left_title->content, 4), ENT_QUOTES, 'UTF-8') ?></h6>
      <?php else: ?>
         <h6 class="text-center">No title available.</h6>
      <?php endif; ?>
      <div class="row" style="margin-top:20px">
         <?php if (!empty($left_banners) && is_array($left_banners)): ?>
            <?php foreach ($left_banners as $banner): ?>
               <a href="<?= htmlspecialchars($banner->link_page, ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                  <div class="col-12 pb-3">
                     <img src="<?= htmlspecialchars($banner->image_url, ENT_QUOTES, 'UTF-8') ?>" width="100%">
                  </div>
               </a>
            <?php endforeach; ?>
         <?php else: ?>
            <p class="text-center">No banners available.</p>
         <?php endif; ?>
      </div>
   </div>

   <div class="custom-container">

      <div class="card mt-5">
         <div class="card-body">
            <?php include('filters/input_search.php'); ?>
            <div class="border-top mt-1 pt-1 d-flex align-items-center justify-content-between">
               <div class="d-flex flex-column">
                  <span class="card-offers-sresult">Quick sort</span>
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

               // <!-- ĐAY LÀ CÁI CỤC CẦN XỬ LÝ -->
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
                        $tmp = $point_geos[$geo_code];
                        $calc_result = $tmp - $tmp * $offer->percent / 100;
                        $point = '$' . round($calc_result);
                     } else {
                        if (!empty($percent_geos[$geo_code])) {
                           $tmp = $percent_geos[$geo_code];
                           /* $calc_result = $tmp - $tmp * $offer->percent / 100; */
                           $point = round($tmp)  . '% Revshare';
                        } else {
                           $point = '$0';
                        }
                     }

                     if ($mIdCountry == 'all') {
                        $Icon = 'All Countries ';
                        if (!empty($point_geos['all'])) {
                           $tmp = $point_geos['all'];
                           $calc_result = $tmp - $tmp * $offer->percent / 100;
                           $point = '$' . round($calc_result);
                        }
                        if (!empty($percent_geos['all'])) {
                           $tmp = $percent_geos['all'];
                           /* $calc_result = $tmp - $tmp * $offer->percent / 100; */
                           $point = round($tmp) . '% Revshare';
                        }
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
                              </div>
                           
                           ';
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

               include('modal_offer.php');
            }

            echo '
                  <div id="loading-section" >
                  <div class="row d-flex justify-content-center align-items-center" >
                     <div class="col-1 text-center" style="width: 70px;">
                        <img src="' . base_url("temp/default/images/loading.gif") . '" width="100%" />
                        </div>
                        <div class="col-2">Loading more data</div>
                     </div>
                  </div>
               ';
         } else {
            echo '
               <div class="col-12 my-5">
                  <div class="d-flex justify-content-center"><h6>There are no offers</h6></div>
               </div>
               ';
         }
         ?>
      </div>
   </div>

   <div class="right-banners sticky-banners">
      <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?></h5>
         <h6 class="text-center"><?= substr($right_title->content, 4) ?></h5>
            <div class="row" style="margin-top:20px">
               <?php if (!empty($right_banners) && is_array($right_banners)): ?>
                  <?php foreach ($right_banners as $banner): ?>
                     <a href="<?= htmlspecialchars($banner->link_page, ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                        <div class="col-12 pb-3">
                           <img class="w-100" src="<?= htmlspecialchars($banner->image_url, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                     </a>
                  <?php endforeach; ?>
               <?php else: ?>
                  <p class="text-center">No banners available.</p>
               <?php endif; ?>
            </div>
   </div>

   <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 99999;">
      <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">

         <div class="toast-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
               <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
            <span id="toastContent">
               Copy to clipboard
            </span>
         </div>
      </div>
   </div>
</div>

<script>
   var page = 0;
   var is_more_data = true;
   var is_process_running = false;
   var end_product = false;
   const lazy_load = () => {
      $('#loading-section').hide();

      $('div').scroll(function() {
         if (($(this).scrollTop() * 1.4) >= $(document).height() * page * 1.4) {
            if (!is_process_running) {
               is_process_running = true;
               page++;

               if (is_more_data && !end_product) {
                  $('#loading-section').show();
                  load_more_data(page);
               }
            }
         }
      })
      const load_more_data = (page) => {
         const current_path = window.location.pathname
         const url = current_path.endsWith('\/') ? `${current_path}${page}` : `${current_path}/${page}`;
         $.ajax({
            type: 'GET',
            url,
            success: function(response) {
               $('#loading-section').remove()
               $('#list_offers').append(response);
            },
            complete: function(response) {
               is_process_running = false;

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

               favorite_action();
            }
         })
      }
   }

   $(document).ready(function() {
      lazy_load();
      favorite_action();

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
   });

   const favorite_action = () => {
      $('.heart-icon').one('click', (e) => {
         const el = e.currentTarget
         let isLiked = $(el).data('isliked');
         let offerId = $(el).data('id');
         const url = `<?php echo base_url('v2/favorite/offer') ?>/${offerId}`

         $.ajax({
            type: "POST",
            url: url,
            success: (response) => {
               if (isLiked == 1) {
                  $(el).attr('data-isliked', "0")
                  $(el).data('isliked', "0")
                  $(el).find('svg').removeClass('fill')
                  $(el).find('svg path').attr('d', "m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z")

               }
               if (isLiked == 0) {
                  $(el).attr('data-isliked', "1")
                  $(el).data('isliked', "1")
                  $(el).find('svg').addClass('fill')
                  $(el).find('svg path').attr('d', "M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z")
               }
            }
         })
      });
   }

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