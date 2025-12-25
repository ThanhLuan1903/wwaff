<!-- offer content-->
<div class="mt-5 mb-2 custom-modal">
   <span class="offer-view-title">Product Information</span>
</div>
<div class="card mb-4">
   <div class="card-body">
      <div class="row campaign-views">
         <div class="col-lg-7 ps-md-3 pe-md-4 vcampaign_left">
            <div class="vcampaign_left_h d-flex flex-column">
               <div class="d-flex justify-content-between">
                  <div class="vcampaign_left_hl">
                     <p class="vcampaign_left_information"></p>
                     <div class="ljzHPa">
                        <p><strong>Description: </strong> <?php echo $offer->description; ?></p>
                        <p><strong>Conversion Flow:</strong>&nbsp; <?php echo $offer->convert_on; ?></p>
                        <p><strong>Allowed Traffic Sources:</strong>&nbsp; <?php echo $offer->traffic_source; ?></p>
                        <p><strong>Restricted Traffic Sources:</strong> <strong>&nbsp;</strong>&nbsp;<?php echo $offer->restriced_traffics; ?></p>
                     </div>
                  </div>
                  <div class="sc-ktHwxA sc-cTjmhe ebomDJ">
                     <img src="<?php echo $offer->img; ?>" alt="<?php echo $offer->title; ?>" width=100%>
                  </div>
               </div>
            </div>
            <div class="vcampaign_left_h d-flex flex-column">
               <?php
               $previews = unserialize($offer->preview);
               $landing_pages = unserialize($offer->landingpage);
               for ($i = 0; $i <= count($previews) - 1; $i++):
               ?>
                  <div class="row mt-3">
                     <div class="col-6">
                        <div class="col-12">
                           <span><strong><?= $previews[$i]['name'] ?>:</strong></span><br>
                           <a href="<?= $previews[$i]['value'] ?>" type="button" class="btn btn-success btn-sm  me-2 mt-2">Preview link</a>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="col-12">
                           <?php if (!empty($landing_pages[$i]['name']) && !empty($landing_pages[$i]['value'])): ?>
                              <span><strong><?= $landing_pages[$i]['name'] ?>:</strong></span><br>
                              <a href="<?= $landing_pages[$i]['value'] ?>" type="button" class="btn btn-outline-primary btn-sm me-2 mt-2">Landing link</a>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               <?php endfor; ?>
            </div>
            <?php if ($this->session->userdata('role') == 1): ?>
               <?php if ($offer->request): $offer_status = $offer->status;
                  $t = 0; ?>
                  <?php if ($offer_status == 'Pending'): ?>
                     <?php
                     $is_invited = $this->db->query(
                        "
                        SELECT * FROM cpalead_request
                        INNER JOIN cpalead_invited_publishers ON cpalead_request.id = cpalead_invited_publishers.request_id
                        WHERE userid = {$this->member->id} AND offerid = {$offer->id}"
                     )->row();
                     ?>
                     <div class="mt-4">
                        <p class="text-primary" style="color:#ffc107 !important">
                           Product pending approval !<br />
                           <b>Ticket already exists. You can know status at <?= !empty($is_invited) ? 'Invites' : 'My Product' ?></b>
                        </p>
                     </div>
                  <?php elseif ($offer_status == 'Deny'): ?>
                     <div class="mt-3">
                        <p class="text-primary" style="color:red !important">
                           Product has been Rejected !<br />
                           <b>Your requested has been rejected by advertiser, maybe your traffic don’t reach them KPI. Please try again later!</b>
                        </p>
                        <form class="form-rq" method="POST" action="<?= base_url('v2/offers/request/' . $offer->id) ?>">
                           <textarea class="textarea-event" name="request_" placeholder="To receive approval at the nearest time, please provide a full traffic description to your manager. "></textarea>
                           <input type="text" hidden name="request">
                           <div class="d-flex justify-content-between align-items-end mt-2">
                              <?php $allowed_traffic_types = explode(',', $offer->traffic_source); ?>
                              <div>
                                 <select name="traffic_source" style="font-size:12px" class="form-select">
                                    <?php foreach ($allowed_traffic_types as $type): ?>
                                       <option style="font-size:12px" value="<?= $type ?>"><?= $type ?></option>
                                    <?php endforeach ?>
                                 </select>
                              </div>
                              <div class="d-flex align-items-center">
                                 <span class="rqqqq">No less than 5 characters are required</span>
                                 <button type="submit" class="btn_prv_link btn_prv_link_2" name="re-apply" value="true">
                                    <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                    <span class="btn_prv_link_2_child_span color_blue_nice">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                          <line x1="12" y1="5" x2="12" y2="19"></line>
                                          <line x1="5" y1="12" x2="19" y2="12"></line>
                                       </svg>
                                    </span>
                                    <span class="btn_prv_link_2_child2 color_blue_nice">Re-Apply</span>
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>

                  <?php elseif ($offer_status == 'Approved'): ?>
                     <?php goto apploved ?>
                  <?php else: ?>
                     <div class="mt-3">
                        <form class="form-rq" method="POST" action="<?= base_url('v2/offers/request/' . $offer->id) ?>">
                           <textarea class="textarea-event" name="request_" placeholder="To receive approval at the nearest time, please provide a full traffic description to your manager. "></textarea>
                           <input type="text" hidden name="request">
                           <div class="d-flex justify-content-between align-items-end mt-2">
                              <?php $allowed_traffic_types = explode(',', $offer->traffic_source); ?>
                              <div>
                                 <select name="traffic_source" style="font-size:12px" class="form-select">
                                    <?php foreach ($allowed_traffic_types as $type): ?>
                                       <option style="font-size:12px" value="<?= $type ?>"><?= $type ?></option>
                                    <?php endforeach ?>
                                 </select>
                              </div>
                              <div class="d-flex align-items-center">
                                 <span class="rqqqq">No less than 5 characters are required</span>
                                 <button type="submit" class="btn_prv_link btn_prv_link_2">
                                    <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                    <span class="btn_prv_link_2_child_span color_blue_nice">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                          <line x1="12" y1="5" x2="12" y2="19"></line>
                                          <line x1="5" y1="12" x2="19" y2="12"></line>
                                       </svg>
                                    </span>
                                    <span class="btn_prv_link_2_child2 color_blue_nice">Apply</span>
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  <?php endif; ?>
               <?php else: ?>
                  <?php $t = 1;
                  apploved:
                  include('approved1.php'); ?>
               <?php endif; ?>
            <?php endif; ?>
         </div>
         <?php
         //xuwr lys device
         $dv = $this->db->where('id', $offer->device)->get('device')->row();
         if ($dv) $dv = $dv->device;
         else $dv = 'All Device';
         //xử lý country
         $point_geos = unserialize($offer->point_geos);
         $percent_geos = unserialize($offer->percent_geos);
         $moCountry_tag = '';
         $mIdCat = explode('o', substr($offer->country, 1, -1));
         if ($mIdCat) {
            $oCountry = $this->db->where_in('id', $mIdCat)->get('country')->result();
            $moCountry = array();
            if ($oCountry) {
               foreach ($oCountry as $oCountry) {
                  $moCountry[$oCountry->id] = $oCountry->keycode;
               }
            }
            foreach ($mIdCat as $mIdCat) {
               if ($mIdCat == 'all') {
                  $moCountry_tag .= '
                        <div data-test-id="affise-ui-geography-row" class="sc-eXNvrr gDsdmm">
                           <div data-test-id="affise-ui-geography-row-country" class="sc-cpmKsF jRKgwY">
                              <div class="d-flex flag_detail_of">
                                 <div class="d-flex align-items-center">
                                    <span class="sc-gVyKpa bbnMFd">All GEO</span>
                                 </div>                        
                              </div>
                           </div>
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>' . round(($point_geos['all'] - ($point_geos['all'] * $offer->percent / 100))) . '</span>USD</div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>' . $dv . '</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
               } else {
                  if (!empty($point_geos[$moCountry[$mIdCat]])) {
                     $tmp_point = $point_geos[$moCountry[$mIdCat]];
                     $calc_result = $tmp_point - $tmp_point * $offer->percent / 100;
                     $point = '$ ' . round($calc_result);
                  } else {
                     //check %
                     if (!empty($percent_geos[$moCountry[$mIdCat]])) {
                        $tmp_point = $percent_geos[$moCountry[$mIdCat]];
                        /* $calc_result = $tmp_point - $tmp_point * $offer->percent / 100; */
                        $point =  round($tmp_point) . '% Revshare';
                     } else {
                        $point = '$0';
                     }
                  }
                  $moCountry_tag .= '
                        <div data-test-id="affise-ui-geography-row" class="sc-eXNvrr gDsdmm">
                           <div data-test-id="affise-ui-geography-row-country" class="sc-cpmKsF jRKgwY">
                              <div class="d-flex flag_detail_of">
                                 <div class="d-flex align-items-center">
                                    <img class="icon-flag-cpview" src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/' . strtolower($moCountry[$mIdCat]) . '.svg">
                                    <span class="sc-gVyKpa bbnMFd">' . $moCountry[$mIdCat] . '</span>
                                 </div>                        
                              </div>
                           </div>
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>' . $point . '</span></div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>' . $dv . '</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
               }
            }
         }
         ?>
         <div class="col-lg-5 EnqEY">
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-hUfwpO jhJgNj">Conversions</p>
               <?php echo $moCountry_tag; ?>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">Conversion rates</p>
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                     <span><?php echo round($offer->cr, 2); ?></span>
                  </div>
                  <span>%</span>

               </div>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">EPC</p>
               <div class="sc-drMfKT bOjCqL">
                  <div class="" style="width:160px">
                     <span><?php echo round($offer->epc, 2); ?></span>
                  </div>
                  <span>$</span>

               </div>
            </div>
            <div class="sc-fnwBNb iCueaH">
               <p class="sc-iNhVCk gmVVGK">Limits</p>
               <div class="sc-ugnQR hWFfaR">
                  <div class="sc-eIHaNI eVOlRG">Day</div>
                  <div class="sc-eIHaNI sc-eTpRJs cQUeis">Conversions</div>
                  <div class="sc-eIHaNI eVOlRG"><?php echo $offer->capped; ?></div>
                  <div class="sc-eIHaNI sc-dxZgTM cShRxf">All Goals</div>
                  <div class="sc-eIHaNI eVOlRG"></div>
               </div>
            </div>
            <?php
            if (!empty($offer) && $this->session->userdata('role') == 1) {
               $invitation = $this->db->query(
                  "SELECT * 
                        FROM cpalead_invited_publishers
                        INNER JOIN cpalead_advertiser on cpalead_advertiser.id = cpalead_invited_publishers.advertiser_id
                        WHERE cpalead_invited_publishers.publisher_id = {$this->member->id} AND cpalead_invited_publishers.product_id = $offer->id
                     "
               )->row();
            } else {
               $invitation = null;
            }
            ?>
         </div>
      </div>
      <?php
      if ($t) {
         include('approved2.php');
      }
      ?>
   </div>
   <script>
      $(document).ready(function() {
         $('.textarea-event').change(function() {
            var value = $(this).val();
            var formattedText = value.replace(/\n/g, '<br>');
            $('input[name^="request"]').val(formattedText)
         });
      })
   </script>
</div>
<!-- endoffer content-->