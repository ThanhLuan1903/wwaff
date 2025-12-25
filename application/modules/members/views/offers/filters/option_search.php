<div class="row mt-2">
   <div class="col-lg-2 col-sm-6  pe-1 mb-2">
      <select name="oCountry" data-placeholder="Countries..." class="chosen-select2 filteroff d-none" multiple tabindex="4">
         <option value=""></option>
         <?php
         $arrCountry = $this->session->userdata('oCountry');
         $mCountryKeycode = array();
         if ($country) {
            foreach ($country as $country) {

               if (!empty($arrCountry) && in_array($country->id, $arrCountry)) {
                  $sl = 'selected';
               } else {
                  $sl = '';
               }
               $mCountryKeycode[$country->id] = strtolower($country->keycode);
               echo '<option value="' . $country->id . '" ' . $sl . '>' . $country->country . '</option>';
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
         $termcat = '';
         if ($paymterm) {
            foreach ($paymterm as $paymterm) {
               $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
               if (!empty($arrpaymterm) && in_array($paymterm->id, $arrpaymterm)) {
                  $sl = 'selected';
               } else {
                  $sl = '';
               }

               echo '<option value="' . $paymterm->id . '" ' . $sl . '>' . $paymterm->payment_term . '</option>';
            }
         }
         ?>
      </select>
   </div>
   <div class="col-lg-2 col-sm-6  pe-1 mb-2">
      <select name="oTypes" data-placeholder="Product Types..." class="chosen-select-types filteroff d-none" multiple tabindex="4">
         <option value=""></option>
         <?php
         $arrTypes = $this->session->userdata('oTypes');
         $marrTypes = array();
         $termcat = '';
         if ($types) {
            foreach ($types as $type) {
               $marrTypes[$type->id] = $type->type;
               if (!empty($marrTypes) && in_array($type->id, $arrTypes)) {
                  $sl = 'selected';
               } else {
                  $sl = '';
               }

               echo '<option value="' . $type->id . '" ' . $sl . '>' . $type->type . '</option>';
            }
         }
         ?>
      </select>
   </div>
   <div class="row">
      <!-- Search By ID -->
      <div class="col-sm-2 dropdown">
         <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
            ID
            <i class="bi bi-chevron-down"></i>
         </a>
         <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item order_wrap_list_items" data-sort="id-desc">DESC</a></li>
            <li><a class="dropdown-item order_wrap_list_items" data-sort="id-asc">ASC</a></li>
         </ul>
      </div>

      <!-- Search by EPC -->
      <div class="col-sm-2 dropdown">
         <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
            EPC
         </a>
         <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item order_wrap_list_items" data-sort="epc-desc">DESC</a></li>
            <li><a class="dropdown-item order_wrap_list_items" data-sort="epc-asc">ASC</a></li>
         </ul>
      </div>
      <!-- Search By CR -->
      <div class="col-sm-2 dropdown ">
         <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
            CR
         </a>
         <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item order_wrap_list_items" data-sort="cr-desc">DESC</a></li>
            <li><a class="dropdown-item order_wrap_list_items" data-sort="cr-asc">ASC</a></li>
         </ul>
      </div>
      <!-- Search By Best Converting -->

      <div class="col-sm-2 dropdown ">
         <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
            Best Converting
         </a>
         <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item order_wrap_list_items" data-sort="lead-desc">DESC</a></li>
            <li><a class="dropdown-item order_wrap_list_items" data-sort="lead-asc">ASC</a></li>
         </ul>
      </div>
      <!-- Search By Favorite -->
      <div class="col-sm-2 dropdown ">
         <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
            Favorite
         </a>
         <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item order_wrap_list_items" data-sort="favorite-desc">DESC</a></li>
            <li><a class="dropdown-item order_wrap_list_items" data-sort="favorite-asc">ASC</a></li>
         </ul>
      </div>
   </div>
</div>