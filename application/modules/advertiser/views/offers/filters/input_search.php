<!--chart-->
<div class="row search-container pb-3" style="row-gap:2px;align-items: flex-end;">

   <div class="col-3" style="padding-left:0px">
      <div class="card-offers-sboxs">
         <input name="oName" type="text" value="<?php echo $this->session->userdata('oName'); ?>" placeholder="Search product by name or id" class="card-offers-sinput">
         <div class="card-offers-sicon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
               <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
         </div>
      </div>
   </div>

   <?php
   $arrcategory = $this->session->userdata('oCat');
   $mOfferCat = array();
   if ($category) {
      foreach ($category as $category) {
         $selected = 'none';
         if (!empty($arrcategory) && in_array($category->id, $arrcategory)) {
            $sl = 'background:#2c91cb!important;';
            $selected = 'selected';
         } else {
            $sl = 'background:#e4e4e4!important;';
         }
         $mOfferCat[$category->id] = $category->offercat;
         echo '<span name="oCat" data="[]" class="badge bg-light text-dark handle_click" data-selected=' . $selected . '  style="align-items: flex-end;width: fit-content;margin-right:10px;font-size:15px;cursor:pointer;font-weight: 300;' . $sl . '" value="' . $category->id . '">' . $category->offercat . ' </span>';
      }
   }
   ?>
</div>