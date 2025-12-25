<span class="card-offers-stitle">Offers</span>
<form id="form_loc">
         <div class="card-offers-sboxs mb-3">
            <input name="oName" type="text" value="<?php echo $this->session->userdata('oName');?>" placeholder="Search" class="card-offers-sinput">
            <span class="nut">/</span>
         </div>
         <div class="row">
            <div class="col-lg-2 col-sm-6 pe-1 mb-2">
               <select name="oCat" data-placeholder="Categories..." class="chosen-select filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrcategory = $this->session->userdata('oCat');
                     $mOfferCat = array();
                     if($category){
                        foreach($category as $category){
                           if(!empty($arrcategory) && in_array($category->id,$arrcategory)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }
                           $mOfferCat[$category->id] = $category->offercat;
                           echo '<option value="'.$category->id.'" '.$sl.'>'.$category->offercat.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>
            <div class="col-lg-2 col-sm-6  pe-1 mb-2">
               <select name="oCountry" data-placeholder="Countries..." class="chosen-select2 filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrCountry = $this->session->userdata('oCountry');
                     $mCountryKeycode = array();
                     if($country){
                        foreach($country as $country){
                           
                           if(!empty($arrCountry) && in_array($country->id,$arrCountry)){
                              $sl = 'selected';
                           }else{
                              $sl = '';
                           }
                           $mCountryKeycode[$country->id] = strtolower($country->keycode);
                           echo '<option value="'.$country->id.'" '.$sl.'>'.$country->country.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>

            <div class="col-lg-2 col-sm-6  pe-1 mb-2">
               <select name="opaymterm" data-placeholder="Payment Term..." class="chosen-select3 filteroff d-none" multiple tabindex="4">
                  <option value=""></option>
                  <?php
                     $arrpaymterm = $this->session->userdata('opaymterm');
                     $marrpaymterm = array();
                     $termcat='';
                     if($paymterm){
                        foreach($paymterm as $paymterm){
                           $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
                           if(!empty($arrpaymterm) && in_array($paymterm->id,$arrpaymterm)){
                              $sl = 'selected';                             
                             
                           }else{
                              $sl = '';
                           }
                           
                           echo '<option value="'.$paymterm->id.'" '.$sl.'>'.$paymterm->payment_term.'</option>';
                        }
                     }
                     ?>
               </select>
            </div>

            <!-- menu smlink-->            
            <div class="smlinks">            
               <a href="<?php echo base_url('v2/smartlinks')?>" class="nav-link link-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-coin" viewBox="0 0 18 18">
                  <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                  </svg>
                  <span class="text_slidebar_h">Smartlinks</span>
                  
               </a>                  
            </div>
            <div class="smlinks">            
               <a href="<?php echo base_url('v2/smartoffers')?>" class="nav-link link-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash" viewBox="0 0 18 18">
                     <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                     <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                  </svg>
                  <span class="text_slidebar_h">SmartOffers</span>                        
               </a>                  
            </div>


         </div>
      </form>