<style>
  .product-card {
    display: block;
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    cursor: pointer
  }
</style>
<?php if (!empty($products)): ?>
  <?php foreach ($products as $product) : ?>
    <div class="col-3 p-2">
      <div class="card" style="height: 100%;">
        <img class="card-img-top" src="<?= $product->img ?>" alt="Card image cap" height="250px">
        <div class="card-body" style="padding-bottom:0">
          <a class="box-offers-links product-card" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $product->id ?>" data-toggle="tooltip" data-placement="top" title="<?= $product->title ?>">
            <?= $product->title ?>
          </a>

          <script>
            $(function() {
              $('[data-toggle="tooltip"]').tooltip()
            })
          </script>
          <div class="box-offers-container" style="flex-direction: column;height: calc(100% - 10px);">
            <div class="box-offers-detail">
              <div class="box-offers-ticons">
                <?php
                if ($offer->smtype == 2) {
                  $badge = '<span class="badge bg-success"> Smart Offer </span>';
                } elseif ($offer->smtype == 3) {
                  $badge = '<span class="badge bg-info"> Smart Link </span>';
                } else {
                  $badge = '';
                }
                ?>
                <div class="align-items-center">
                  <span class="box-offers-id">#&nbsp;<?= $badge ?> &nbsp; <?= $product->id ?>&nbsp;<span>—</span></span>
                  <!-- tag--->
                  <?= $cat_tag ?>
                  <span>— &nbsp;</span>
                  <?= $termcat ?>
                  <!--end tag-->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 star-icon">
                <?php include('rating.php'); ?>
                <span class="text-muted">&nbsp;(<?= $product->lead ?>)</span>
              </div>
              <div class="col-4 <?= $product->ranking ? 'ranking-icon' : '' ?>">
                <div class="ranking-icon__text"><?= $product->ranking ?></div>
              </div>
              <div class="col-2 heart-icon" data-id="<?= $product->id ?>" data-isLiked="<?= $product->is_liked ? 1 : 0 ?>">
                <!-- is_liked = true -->
                <?php if ($product->is_liked) : ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                  </svg>
                  <!-- is_liked = null or 0 -->
                <?php else : ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                  </svg>
                <?php endif; ?>
              </div>
              <i class="glyphicon glyphicon-trash glyphicon-white"></i>
            </div>
          </div>
        </div>

        <div class="card-footer" style="padding:0;">
          <div class="box-offers-point mt-2 pt-2 d-flex" style="background:#2c91cb;padding:2%">
            <?= $point_geos_s ?>
          </div>
        </div>

      </div>
    </div>

    <div class="modal fade" id="exampleModal<?= $product->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
      <div class="modal-dialog modal-xl">
        <div class="modal-content mb-5">
          <div class="modal-header">
            <h5 class="modal-title">#<?= $product->id ?>-<?= $product->title ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="m-3">
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
                          <div class="ljzHPa">
                            <p><strong>Description: </strong> <?php echo $product->description; ?></p>
                            <p><strong>Conversion Flow:</strong>&nbsp; <?php echo $product->convert_on; ?></p>
                            <p><strong>Allowed Traffic Sources:</strong>&nbsp; <?php echo $product->traffic_source; ?></p>
                            <p><strong>Restricted Traffic Sources:</strong> <strong>&nbsp;</strong>&nbsp;<?php echo $product->restriced_traffics; ?></p>
                          </div>
                        </div>
                        <div class="sc-ktHwxA sc-cTjmhe ebomDJ">
                          <img src="<?php echo $product->img; ?>" alt="<?php echo $product->title; ?>" width=100%>
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
                              <span><strong>Offer preview <?= $previews[$i]['name'] ?>:</strong></span><br>
                              <a href="<?= $previews[$i]['value'] ?>" type="button" class="btn btn-success btn-sm  me-2 mt-2">Offer Preview</a>
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
                  $dv = $this->db->where('id', $product->device)->get('device')->row();
                  if ($dv) $dv = $dv->device;
                  else $dv = 'All Device';
                  //xử lý country
                  $point_geos = unserialize($product->point_geos);
                  $percent_geos = unserialize($product->percent_geos);
                  $moCountry_tag = '';
                  $mIdCat = explode('o', substr($product->country, 1, -1));
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
                           <div data-test-id="affise-ui-geography-row-revenue" class="sc-cpmKsF sc-jrIrqw iWDZfO"><span>' . $point_geos['all'] . '</span>USD</div>
                           <div data-test-id="affise-ui-geography-row-device" class="sc-cpmKsF jRKgwY"><span>' . $dv . '</span></div>
                           <div data-test-id="affise-ui-geography-row-os" class="sc-cpmKsF jRKgwY"><span>All OS</span></div>
                        </div>
                        ';
                        break;
                      } else {
                        if (!empty($point_geos[$moCountry[$mIdCat]])) {
                          $point = '$ ' . round($point_geos[$moCountry[$mIdCat]]);
                        } else {
                          //check %
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
                          <span><?php echo round($product->cr, 2); ?></span>
                        </div>
                        <span>%</span>

                      </div>
                    </div>
                    <div class="sc-fnwBNb iCueaH">
                      <p class="sc-iNhVCk gmVVGK">EPC</p>
                      <div class="sc-drMfKT bOjCqL">
                        <div class="" style="width:160px">
                          <span><?php echo round($product->epc, 2); ?></span>
                        </div>
                        <span>$</span>

                      </div>
                    </div>
                    <div class="sc-fnwBNb iCueaH">
                      <p class="sc-iNhVCk gmVVGK">Limits</p>
                      <div class="sc-ugnQR hWFfaR">
                        <div class="sc-eIHaNI eVOlRG">Day</div>
                        <div class="sc-eIHaNI sc-eTpRJs cQUeis">Conversions</div>
                        <div class="sc-eIHaNI eVOlRG"><?php echo $product->capped; ?></div>
                        <div class="sc-eIHaNI sc-dxZgTM cShRxf">All Goals</div>
                        <div class="sc-eIHaNI eVOlRG"></div>
                      </div>
                    </div>


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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

<?php else: ?>
  <div class="col-12 my-5">
    <div class="d-flex justify-content-center">
      <h6>There are no offers</h6>
    </div>
  </div>
<?php endif; ?>