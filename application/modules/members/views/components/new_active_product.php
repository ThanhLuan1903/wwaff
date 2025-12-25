<div class="col-12 d-flex">
            <!--  new offer -->
               <div class="card col-6 mt-3 d-inline-block">
                  <div class="card-header text-uppercase">
                     NEW PRODUCTS
                  </div>
                  <div class="card-body" >
                  <!-- new offer contents-->
                  <div class="card_newoffer " style="padding:0">
                     <div class="card_newoffer_ct d-block" style="height:780px;overflow-y:scroll">
                        <?php   
                           if($newoffers): $count = 0;
                              foreach($newoffers as $offer): 
                                 $p = '';
                                 $count++;
                                 $point_geo = unserialize($offer->point_geos);
                                 $applyButton = $offer->status != 'Pending'  ? '<button type="submit" class="btn btn-outline-primary btn-sm">Apply</button>' : '<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#newProductModal'.$offer->id.'">'.$offer->status.'</a>';
                                 $detailButton = $offer->status != 'Pending' ? '<a class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newProductModal'.$offer->id.'" >Details</a>' : '';
                                 $getLinkButton = '<a class="btn btn-primary btn-sm color_blue_nice" data-bs-toggle="modal" data-bs-target="#newProductModal'.$offer->id.'">Get link</a>';
                                 
                                 if($point_geo){
                                    $dem = 0;
                                    foreach($point_geo as $key=>$value){
                                       if($value>0){
                                             $dem++;
                                             if($dem==1){
                                                $phay = '';
                                             }else{
                                                $phay = ', ';
                                             }
                                             $p .= $phay. $key.': $'.$value;
                                       }
                                    }
                                 }
                           ?>     
                                    <div class="card_noffer_item">
                                          <p style="padding-right:10px;"><?= $count ?></p>
                                          <div class="card_noffer_img">
                                             <img src="<?= $offer->img ?>">
                                          </div>
                                          <div class="card_noffer_title_box">
                                          <p class="card_noffer_title">
                                             <span class="card_noffer_title_txt">(<?=$offer->id ?>)</span>
                                             <?= $offer->title ?>
                                          </p>
                                          <p class="card_noffer_points" style="display: inline-block;
                                          overflow: hidden;
                                          text-overflow: ellipsis;
                                          max-height: 35px;
                                          "><span><?= $p ?></span></p>
                                          </div>
                                          <div class="card_noffer_content_hv card_noffer_contents">
                                          <div class="card_noffer_content_wr">
                                             <div class="card_noffer_content_slide">                                            
                                                <p><strong>Conversion Flow:</strong> <strong> </strong> <?= $offer->convert_on ?></p>
                                                <p><strong>Allowed Traffic Sources:</strong> <?= $offer->traffic_source ?></p>
                                                <p><strong>Restricted Traffic Sources:</strong> <?= $offer->restriced_traffics ?></p>
                                                <p><strong>Description:&nbsp;&nbsp;</strong><?= $offer->description ?></p>
                                                <p><strong>Browser</strong>: All&nbsp;</p>
                                             </div>
                                             <div>
                                                <form method="POST" action="<? echo base_url('v2/offers/request/'.$offer->id) ?>">
                                                   <input hidden name="request" value="" />
                                                   <?php if ($offer->request == 0): echo $getLinkButton; ?>
                                                      
                                                   <?php elseif ($offer->request == 1): echo $detailButton; ?>
                                                   <?= $applyButton ?>
                                                   <?php endif ?>
                                                </form>
                                             </div>
                                             <div class="mt-3">
                                             
                                             </div>        
                                          </div>
                                          </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="newProductModal<?= $offer->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
                                       <div class="modal-dialog modal-xl">
                                          <div class="modal-content mb-5">
                                                <div class="m-3">
                                                <?php include('offers/campaign_view.php'); ?>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php endforeach; endif; ?>
                     </div>
                  </div>
               </div>
               </div>
            <!-- new offer -->
            

            <!-- active offer -->
            <div class="card col-6 mt-3 d-inline-block">
                  <div class="card-header text-uppercase">
                     YOUR ACTIVE PRODUCTS
                  </div>
                  
                  <div class="card-body" >
                  <!-- new offer contents-->
                     <div class="card_newoffer " style="padding:0">
                        <div class="card_newoffer_ct d-block"  style="height:780px;overflow-y:scroll">
                           <?php if($activities): ?>
                              <?php foreach($activities as $offer): 
                                 $count = 1;
                                 $p = '';
                                 $count = $count++;
                                 $point_geo = unserialize($offer->point_geos);
                                 if($point_geo){
                                    $dem = 0;
                                    foreach($point_geo as $key=>$value){
                                       
                                       if($value>0){
                                             $dem++;
                                             if($dem==1){
                                                $phay = '';
                                             }else{
                                                $phay = ', ';
                                             }
                                             $p .= $phay. $key.': $'.$value;
                                       }
                                    }
                                 }
                                 
                              ?>
                                 <div class="card_noffer_item">
                                       <p class="" style="padding-right:10px;"><?= $count ?> </p>
                                       <div class="card_noffer_img">
                                          <img src="<?= $offer->img ?>">
                                       </div>
                                       <div class="card_noffer_title_box">
                                       <p class="card_noffer_title">
                                          <span class="card_noffer_title_txt">(<?= $offer->id ?>)</span>
                                          <?= $offer->title ?>
                                       </p>
                                       <p class="card_noffer_points"><span><?= $p ?></span></p>
                                       </div>
                                       <div class="card_noffer_content_hv card_noffer_contents">
                                       <div class="card_noffer_content_wr">
                                          <div class="card_noffer_content_slide">                                            
                                             <p><strong>Conversion Flow:</strong> <strong> </strong><?= $offer->convert_on ?></p>
                                             <p><strong>Allowed Traffic Sources:</strong> <?= $offer->traffic_source ?></p>
                                             <p><strong>Restricted Traffic Sources:</strong><?= $offer->restriced_traffics ?></p>
                                             <p><strong>Description:&nbsp;&nbsp;</strong><?= $offer->description ?></p>
                                             <p><strong>Browser</strong>: All&nbsp;</p>
                                          </div>
                                          <div>
                                             <a class="btn btn-primary btn-sm show-detail color_blue_nice" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $offer->id ?>">Get link</a>
                                          </div>
                                          <div class="mt-3">
                                          
                                          </div>        
                                       </div>
                                       <!-- Modal -->
                                       <div class="modal fade" id="exampleModal<?= $offer->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
                                          <div class="modal-dialog modal-xl">
                                             <div class="modal-content mb-5">
                                                   <div class="m-3">
                                                   <?php include('offers/campaign_view.php'); ?>
                                                   </div>
                                                   <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                   </div>
                                             </div>
                                          </div>
                                       </div>
                                       </div>
                                 </div>
                                    <?php $count = $count + 1; ?>
                                 <?php endforeach; ?>
                              <?php endif; ?>

                        </div>
                     </div>
                  </div>
            </div>
         </div>