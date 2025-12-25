<!-- offer content-->
<style>
   .rating-stars ul {
      list-style-type: none;
      padding: 0;
      -moz-user-select: none;
      -webkit-user-select: none;
   }

   .rating-stars ul>li.star {
      display: inline-block;

   }

   .rating-stars ul>li.star>i.fa {
      font-size: 1.5em;
      color: #ccc;
   }

   .rating-stars ul>li.star.hover>i.fa {
      color: #FFCC36;
   }

   .rating-stars ul>li.star.selected>i.fa {
      color: #FF912C;
   }
</style>

<?php
$invited_products = $this->Advertiser_model->get_invited_products($publisher->id);
$requested_products = $this->Advertiser_model->get_requested_products($publisher->id);
$is_checked = [];
foreach ($invited_products as $invited_product) {
   array_push($is_checked, $invited_product->product_id);
}

foreach ($requested_products as $requested_product) {
   array_push($is_checked, $requested_product->offerid);
}

$is_checked = array_unique($is_checked);

?>
<div class="card mb-4">
   <div class="card-body">
      <div class="row campaign-views">
         <div class="col-lg-7 ps-md-3 pe-md-4 vcampaign_left">
            <div class="vcampaign_left_h d-flex flex-column">
               <div class="d-flex justify-content-between">
                  <div class="vcampaign_left_hl">
                     <p class="vcampaign_left_information">Publisher information</p>
                     <div class="ljzHPa">
                        <p><strong>Description : </strong></p>
                        <?php
                        if (!empty($mailling['hear_about'])) {
                           echo '<textarea rows="5" style="width:100%" disabled>' . $mailling['hear_about'] . '</textarea>';
                        }
                        ?>
                        <p><strong>Product Type :</strong> <strong>&nbsp;</strong>&nbsp; <?= join(', ', (explode(',', $publisher->product_type)))  ?></p>
                        <p><strong>Traffic Type :</strong>&nbsp; <?php echo join(', ', (explode(',', $mailling['aff_type']))) ?></p>
                        <p><strong>Volumn :</strong> <strong>&nbsp;</strong>&nbsp; <?php echo $mailling['volume'] ?>$/month</p>
                        <p><strong>Traffic Devide :</strong>&nbsp; <?= $publisher->traffic_device ?></p>
                        <p><strong>Website :</strong> <strong>&nbsp;</strong>&nbsp; <?php echo $mailling['website'] ?></p>
                        <p><strong>Category :</strong> <strong>&nbsp;</strong>&nbsp; <?= join(', ', (explode(',', $publisher->product_cats)))   ?></p>

                     </div>
                  </div>
                  <div class="sc-ktHwxA sc-cTjmhe ebomDJ">
                     <img src="<?= $mailling['avartar'] !== null ? $mailling['avartar'] : base_url("temp/default/images/avt_unknow.jpeg") ?>" width=100%>
                  </div>
               </div>
            </div>
            <div class="mt-3">

               <form class="form-rq" method="POST" action="<?= base_url('v2/publishers/invite/') ?>">
                  <input type="text" name="publisher_id" hidden value="<?= $publisher->id ?>">
                  <input type="text" id="invitation_message" hidden name="invitation_message">
                  <?php $own_products = $this->Advertiser_model->get_my_approved_products(); ?>
                  <div class="card_noffer_content_slide" style="height:120px;width:100%">

                     <?php foreach ($own_products as $product): ?>
                        <div class="form-check">
                           <input class="form-check-input checkbox<?= $publisher->id ?>" type="checkbox" name="products[]" value="<?= $product->id ?>" <?= in_array($product->id, $is_checked) ? 'disabled checked' : '' ?> id="flexCheckDefault">
                           <label class="form-check-label" for="flexCheckDefault">
                              <?= $product->title  ?>
                           </label>
                        </div>
                     <?php endforeach ?>
                  </div>
                  <div class="d-flex justify-content-between align-items-end mt-2">
                     <?php
                     if (count($is_checked) == count($own_products)) {
                        // Do nothing, or display an alternative message
                     } else {

                        echo  '<div class="d-flex align-items-center">
                        <button type="submit" class="btn_prv_link btn_prv_link_2" id="button_invite_' . $publisher->id . '"  disabled >
                           <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                           <span class="btn_prv_link_2_child_span color_blue_nice" id="button_color_x_' . $publisher->id . '" style="background:#86898b">
                              <svg xmlns="http://www.w3.org/2000/svg"   width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                 <line x1="12" y1="5" x2="12" y2="19"></line>
                                 <line x1="5" y1="12" x2="19" y2="12"></line>
                              </svg>
                           </span>
                        <span class="btn_prv_link_2_child2 color_blue_nice" id="button_color_y_' . $publisher->id . '" style="background:#86898b"  >Invite</span> </button>
                        </div>';
                     }
                     ?>

                  </div>
               </form>
            </div>
         </div>

         <div class="col-lg-5 EnqEY">
            <div class="sc-fnwBNb iCueaH">
               <!-- phân loại pub  -->
               <?php
               if ($is_depends) {
                  echo '<p class="sc-hUfwpO jhJgNj">Rating: <span class="text-message-' . $publisher->id . '"></span></p>';
               } else {
                  echo '<p class="sc-hUfwpO jhJgNj">Rating: <span class="text-message">This is not your publisher</span></p>';
               }
               ?>

               <section class='rating-widget'>
                  <!-- Rating Stars Box -->
                  <div class='rating-stars text-center'>
                     <ul id='<?= $is_depends ? 'stars' : '' ?>'>
                        <span hidden id="voted" data-voted="<?= $publisher->rating >= 1 ? 'voted' : 'unvoted' ?>"></span>
                        <li class='star <?= $publisher->rating >= 1 ? "selected" : "" ?>' title='Poor' data-value='1' data-publisher="<?= $publisher->id ?>">
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star <?= $publisher->rating >= 2 ? "selected" : "" ?>' title='Fair' data-value='2' data-publisher="<?= $publisher->id ?>">
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star <?= $publisher->rating >= 3 ? "selected" : "" ?>' title='Good' data-value='3' data-publisher="<?= $publisher->id ?>">
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star <?= $publisher->rating >= 4 ? "selected" : "" ?>' title='Excellent' data-value='4' data-publisher="<?= $publisher->id ?>">
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star <?= $publisher->rating >= 5 ? "selected" : "" ?>' title='WOW!!!' data-value='5' data-publisher="<?= $publisher->id ?>">
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                     </ul>
                  </div>
               </section>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-hUfwpO jhJgNj">Target Geo</p>
               <div class="d-flex">
                  <?php if ($publisher->product_geos):
                     $product_geos = explode(',', $publisher->product_geos);
                     foreach ($product_geos as $index => $keycode):
                  ?>
                        <div class="flag_icon_country">
                           <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/<?= $keycode ?>.svg">
                        </div>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <span class="boffer_point" style="font-size:12px;"> All Countries</span>
                  <?php endif ?>
               </div>
            </div>

            <div class="sc-fnwBNb iCueaH">
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                     <span>EPC</span>
                  </div>
                  <span><?= round($epc, 2) ?> $</span>

               </div>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                     <span>CR</span>
                  </div>
                  <span><?= $convertion_rate ?> %</span>

               </div>
            </div>
            <textarea class="textarea-event" oninput="checkTextarea<?= $publisher->id ?>()" id="textareaContainer<?= $publisher->id ?>" name="request" style="width:100%;display:None" rows="6" placeholder="Please send some messages or introduce your product to the publishers. This field required" <?= count($is_checked) == count($own_products) && !empty($is_checked) ? 'readonly' : '' ?>></textarea>
            <script>
               const textareaContainer<?= $publisher->id ?> = document.getElementById("textareaContainer<?= $publisher->id ?>");
               var checkbox_<?= $publisher->id ?> = document.querySelectorAll('.checkbox<?= $publisher->id ?>');
               checkbox_<?= $publisher->id ?>.forEach(function(input) {
                  input.addEventListener('click', function() {
                     if (input.checked) {
                        textareaContainer<?= $publisher->id ?>.style.display = "block";
                     } else {
                        textareaContainer<?= $publisher->id ?>.style.display = "none";
                     }
                  });
               });

               function checkTextarea<?= $publisher->id ?>() {
                  var textareaValue_<?= $publisher->id ?> = document.getElementById('textareaContainer<?= $publisher->id ?>').value;
                  var button_<?= $publisher->id ?> = document.getElementById('button_invite_<?= $publisher->id ?>');
                  var button_color_x_<?= $publisher->id ?> = document.getElementById('button_color_x_<?= $publisher->id ?>');
                  var button_color_y_<?= $publisher->id ?> = document.getElementById('button_color_y_<?= $publisher->id ?>');
                  if (textareaValue_<?= $publisher->id ?>.trim().length > 0) {
                     button_<?= $publisher->id ?>.disabled = false;
                     button_color_x_<?= $publisher->id ?>.style.background = "#2c91cb";
                     button_color_y_<?= $publisher->id ?>.style.background = "#2c91cb";
                  } else {
                     button_<?= $publisher->id ?>.disabled = true;
                     button_color_x_<?= $publisher->id ?>.style.background = "#86898b";
                     button_color_y_<?= $publisher->id ?>.style.background = "#86898b";
                  }
               }

               $(document).ready(function() {
                  $('.textarea-event').change(function() {
                     var value = $(this).val();
                     var formattedText = value.replace(/\n/g, '<br>');
                     $('input[name^="invitation_message"]').val(formattedText)
                  });
               })
            </script>
         </div>
      </div>

   </div>
   <!--end card-body-->
</div>