<?php include('styles.php') ?>
<div class="full-width">
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
               <?php foreach ($categories as $category): ?>
                  <span class="badge bg-light tag-cats text-dark handle_click <?= $category->id == $this->session->userdata('offercat') ? 'is_activated' : '' ?>" data-name="offercat" data-id="<?= $category->id ?>"><?= $category->offercat ?></span>
               <?php endforeach;?>
               <div class="border-top mt-1 pt-1 d-flex align-items-center justify-content-between">Product</div>
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
                        <?php foreach ($types as $offer_type): ?>
                           <option value="<?= $offer_type->id ?>" <?= in_array($offer_type->id, $this->session->userdata('offer_types')) ? 'selected' : '' ?>><?= $offer_type->type ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>

                  <!-- Row -->
                  <div class="row">
                  <!-- Search By ID -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                           ID <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="id" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="id" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
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
                     <!-- Order By Best Converting -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                        Best Converting <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="converting" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="converting" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>
                     <!-- Order By Favortie -->
                     <div class="col-sm-2 dropdown">
                        <a href="#" class="d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false">
                        Favortie <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-small sort-option">
                           <li data-sort="converting" data-type="desc"><a class="dropdown-item order_wrap_list_items">DESC</a></li>
                           <li data-sort="converting" data-type="asc"><a class="dropdown-item order_wrap_list_items">ASC</a></li>
                        </ul>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      <div class="row" id="list_publishers"> <?php include('product_list.php'); ?>
      </div>
   </div>
</div>
<?php include('js.php'); ?>