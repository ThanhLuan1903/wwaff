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
                           <div class="col-12">
                              <?php if (!empty($landing_pages[$i]['name']) && !empty($landing_pages[$i]['value'])): ?>
                                 <span><strong><?= $landing_pages[$i]['name'] ?>:</strong></span><br>
                                 <a href="<?= $landing_pages[$i]['value'] ?>" type="button" class="btn btn-outline-primary btn-sm me-2 mt-2">Landing link</a>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endfor; ?>
            </div>
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
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>' . round($point_geos['all']) . '</span>USD</div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>' . $dv . '</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
                  break;
               } else {
                  if (!empty($point_geos[$moCountry[$mIdCat]])) {
                     $point = '$ ' . round($point_geos[$moCountry[$mIdCat]]);
                  } else {
                     if (!empty($percent_geos[$moCountry[$mIdCat]])) {
                        $point = round($percent_geos[$moCountry[$mIdCat]]) . '% Revshare';
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


         </div>
      </div>
      <div class="mt-3">
         <?php $status = $this->db->get_where('advertiser_offer_status', ['offer_id' => $offer->id])->row(); ?>
         <div class="d-flex justify-content-between align-items-end mt-2">
            <div></div>
         </div>
      </div>
      <?php
      if ($t) {
         include('approved2.php');
      }
      ?>
   </div>
   <!--end card-body-->
</div>
<!-- endoffer content-->