<link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
<script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>
<style>
   .full-width {
      display: flex;
      justify-content: space-between;
   }

   .custom-container {
      width: 70%;
   }

   .tag-cats {
      align-items: flex-end;
      width: fit-content;
      margin-right: 10px;
      font-size: 15px;
      cursor: pointer;
      font-weight: 300;
      background: #e4e4e4 !important;
   }

   .is_activated {
      background: #2c91cb !important;
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

   .order_wrap_list_items {
      width: 100%;
   }

   .sticky-banners {
      padding-top: 40px;
      height: 300px;
      width: 200px;
      top: 50px;
   }
</style>
<div class="full-width">
   <div class="left-banners sticky-banners">
      <h6 class="text-center" style="margin-botton:0px"><?= substr($left_title->content, 0, 3) ?></h5>
         <h6 class="text-center"><?= substr($left_title->content, 4) ?></h5>
            <div class="row" style="margin-top:20px">
               <?php foreach ($left_banners as $banner): ?>
                  <a href="<?= $banner->link_page ?>" target="_blank">
                     <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
                  </a>
               <? endforeach; ?>
            </div>
   </div>
   <div class="custom-container">
      <div class="card mt-5">
         <div class="card-body">
            <div class="row search-container pb-3" style="row-gap:2px;align-items: flex-end;">
               <div class="col-3" style="padding-left:0px">
                  <div class="card-offers-sboxs">
                     <input name="oName" type="text" value="<?= $this->session->userdata('search_input'); ?>" placeholder="Search product by name or id" class="card-offers-sinput">
                     <div class="card-offers-sicon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                           <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                     </div>
                  </div>
               </div>
               <?php foreach ($offcats as $cat) : ?>
                  <span class="badge bg-light tag-cats text-dark handle_click <?= $cat->id == $this->session->userdata('offercat') ? 'is_activated' : '' ?>" data-name="offercat" data-id="<?= $cat->id ?>"><?= $cat->offercat ?></span>
               <?php endforeach ?>
               <div class="row mt-2">
                  <div class="col-lg-2 col-sm-6  pe-1 mb-2">
                     <select name="countries" data-placeholder="Countries..." class="chosen-select2 filteroff d-none" multiple tabindex="4">
                        <option value=""></option>
                        <?php foreach ($countries as $country): ?>
                           <option value="<?= $country->id ?>" <?= in_array($country->id, $this->session->userdata('countries')) ? 'selected' : '' ?>><?= $country->country ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="col-lg-2 col-sm-6  pe-1 mb-2">
                     <select name="offer_types" data-placeholder="Product Types..." class="chosen-select-types filteroff d-none" multiple tabindex="4">
                        <option value=""></option>
                        <?php foreach ($offer_types as $offer_type): ?>
                           <option value="<?= $offer_type->id ?>" <?= in_array($offer_type->id, $this->session->userdata('offer_types')) ? 'selected' : '' ?>><?= $offer_type->type ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="row">
                     <!-- Order By ID -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           ID <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="id" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="id" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>
                     <!-- Order By Rating -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           Rating <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="rating" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="rating" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>
                     <!-- Order By Level -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           Level <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="level" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="level" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>

                     <!-- Order By EPC -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           EPC <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="epc" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="epc" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>

                     <!-- Order By CR -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           CR <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="cr" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="cr" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>

                  </div>
               </div>
            </div>
         </div>
         <div class="row" id="list_publishers"> <?php include('modal_offer.php'); ?>
         </div>
      </div>
   </div>
   <div class="right-banners sticky-banners">
      <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?> </h5>
         <h6 class="text-center"><?= substr($right_title->content, 4) ?></h5>
            <div class="row" style="margin-top:20px">
               <?php foreach ($right_banners as $banner): ?>
                  <a href="<?= $banner->link_page ?>" target="_blank">
                     <div class="col-12 pb-3">
                        <img class="w-100" src="<?= $banner->image_url ?>">
                     </div>
                  </a>
               <? endforeach; ?>
            </div>
   </div>
</div>

<script>
   var page = 0; 
   var is_more_data = true;
   var is_process_running = false;

   const lazy_load = () => {
      $('#loading-section').hide();

      $('div').scroll(function() {
         if (($(this).scrollTop()) >= $(document).height() * page * 1.4) {
            if (!is_process_running) {
               is_process_running = true;
               page++;

               if (is_more_data) {
                  $('#loading-section').show();
                  load_more_data(page);
               }
            }
         }
      })
      const load_more_data = (page) => {
         const current_path = window.location.pathname
         const url = current_path.endsWith('\/') ? `${current_path}${page}` : `${current_path}/?page=${page}`;
         $.ajax({
            type: 'GET',
            url,
            success: function(response) {
               $('#loading-section').remove()
               $('#list_publishers').append(response);
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

               rating_publisher();
            }
         })
      }
   }

   function ajaxFilter(name, value) {
      $.ajax({
         type: "GET",
         url: '<?= base_url('v2/publishers/search') ?>',
         data: {
            value,
            name
         },
         success: function(response) {
            location.reload();
         }
      })
   }

   function handle_click() {
      $('.handle_click').click(function() {
         const isActivated = $(this).hasClass('is_activated');
         const value = isActivated ? '' : $(this).data('id');
         const name = $(this).data('name');
         ajaxFilter(name, value);
      })
   }

   function handle_click_type() {
      $('.handle_click_type').click(function() {
         const isActivated = $(this).hasClass('is_activated');
         const value = isActivated ? '' : $(this).data('id');
         const name = $(this).data('name');
         ajaxFilter(name, value);
      })
   }

   function rating_publisher() {
      $(".rating").click(function() {
         event.preventDefault();
         const publisher_id = $(this).data('id');
         const rating = $(this).data('rating')

         $.ajax({
            type: 'POST',
            url: '<?= base_url('v2/publishers/rating') ?>',
            data: {
               publisher_id,
               rating
            },
            success: function(data) {
               
            }
         })
      })
   }

   function responseMessage(msg, publisher_id) {
      $('.success-box').fadeIn(200);
      $(`.text-message-${publisher_id}`).html(msg);
   }

   $(document).ready(function() {
      lazy_load();
      handle_click();
      rating_publisher();

      $('.card-offers-sinput').focusin(function() {
         $('.nut').text('Enter');
         $('.nut').addClass('focus-input-span');
         $('.card-offers-sboxs').addClass('focus-input');
      })
      $('.card-offers-sinput').focusout(function() {
         $('.nut').text('/');
         $('.nut').removeClass('focus-input-span');
         $('.card-offers-sboxs').removeClass('focus-input');

         const value = $(this).val();
         const name = 'search_input';
         ajaxFilter(name, value);
      });

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

      $('.filteroff').change(function() {
         var name = $(this).attr('name');
         var value = $(this).val();
         ajaxFilter(name, value);
      });
     
      $('.sort-option li').click(function() {
         const value = $(this).data('type');
         const name = `sort-by-${$(this).data('sort')}`;
         ajaxFilter(name, value)
      });

      $('#stars li').on('mouseover', function() {
         var onStar = parseInt($(this).data('value'), 10);

         $(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
               $(this).addClass('hover');
            } else {
               $(this).removeClass('hover');
            }
         });

      }).on('mouseout', function() {
         $(this).parent().children('li.star').each(function(e) {
            $(this).removeClass('hover');
         });
      });

      $('#stars li').one('click', function() {
         const votedField = $(this).parent().find('#voted');
         const isVoted = votedField.data('voted') === 'voted' ? true : false;
         if (isVoted) {
            alert('You voted');
            return;
         }
         var onStar = parseInt($(this).data('value'), 10);
         var stars = $(this).parent().children('li.star');

         for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
         }

         for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
         }

         var ratingValue = parseInt($(this).last().data('value'), 10);
         var msg = "";
         if (ratingValue > 1) {
            msg = "Thanks! You rated this " + ratingValue + " stars.";
         } else {
            msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
         }

         const publisher_id = $(this).data('publisher');
         const rating = ratingValue;
         $.ajax({
            type: 'POST',
            url: '<?= base_url('v2/publishers/rating') ?>',
            data: {
               publisher_id,
               rating
            },
            success: function(response) {
               votedField.data('voted', 'voted');
            }
         })
         responseMessage(msg, publisher_id);

      });


   })
</script>