<div class="col-sm-1 col-xs-1 col-md-2 menuleft">
   <ul class="nav nav-pills nav-stacked main-menu">
      <li role="presentation">
         <a href="<?php echo base_url($this->config->item('manager')); ?>">
            <span class="glyphicon glyphicon-home"></span>
            <span class="hidden-xs hidden-sm">Home</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/showev/report/list'); ?>">
            <span class="glyphicon glyphicon-search"></span>
            <span class="hidden-xs hidden-sm">Offer Report</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url('proxy_report'); ?>">
            <span class="glyphicon glyphicon-zoom-in"></span>
            <span class="hidden-xs hidden-sm">Conversions Report</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url('/ipreport/show'); ?>">
            <span class="glyphicon glyphicon-zoom-in"></span>
            <span class="hidden-xs hidden-sm">Click Report </span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/dashboard/show'); ?>">
            <span style=" display:inline-block; width:22px; text-align:center; font-weight:bold;">⚠</span>
            <span class="hidden-xs hidden-sm">Violation Report</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/affiliate'); ?>">
            <span class="glyphicon glyphicon-user"></span>
            <span class="hidden-xs hidden-sm">Affiliate</span>
         </a>
      </li>
      <li>
         <a href="#" class="dropmenu">
            <span class="glyphicon glyphicon-user"></span>
            <span class="hidden-xs hidden-sm">Advertiser</span>
         </a>
         <ul>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/advertiser/list_account'); ?>">
                  <span class="glyphicon glyphicon-user"></span>
                  <span class="hidden-xs hidden-sm">List Avertiser</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/network/listNetwork'); ?>">
                  <span class="glyphicon glyphicon-user"></span>
                  <span class="hidden-xs hidden-sm">Avertiser Network</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/advertiser/list_payments'); ?>">
                  <span class="glyphicon glyphicon-gbp"></span>
                  <span class="hidden-xs hidden-sm">Invoice</span>
               </a>
            </li>
            <!-- <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/advertiser/list_products'); ?>">
                  <span class="glyphicon glyphicon-gift"></span>
                  <span class="hidden-xs hidden-sm">Products</span>
               </a>
            </li> -->
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/help_and_support/list_request_advertiser'); ?>">
                  <span class="glyphicon glyphicon-comment"></span>
                  <span class="hidden-xs hidden-sm">Help And Support</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/custom/publisher_titles'); ?>">
                  <span class="glyphicon glyphicon-cog"></span>
                  <span class="hidden-xs hidden-sm">ADV Side Titles</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/custom/publisher_banners'); ?>">
                  <span class="glyphicon glyphicon-cog"></span>
                  <span class="hidden-xs hidden-sm">ADV Site Banners</span>
               </a>
            </li>

         </ul>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/route/network/list'); ?>">
            <span class="glyphicon glyphicon-inbox"></span>
            <span class="hidden-xs hidden-sm">Network</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/offers/listoffer'); ?>">
            <span class="glyphicon glyphicon-gift"></span>
            <span class="hidden-xs hidden-sm">Offer</span>
         </a>
      </li>
      <li>
         <a href="#" class="dropmenu">
            <span class="glyphicon glyphicon-compressed"></span>
            <span class="hidden-xs hidden-sm">Offer tool</span>
         </a>
         <ul>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/disoffer/disoffer/list'); ?>">
                  <span class=" glyphicon glyphicon-remove"></span>
                  <span class="hidden-xs hidden-sm">Disabled/Enable </span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/country/list'); ?>">
                  <span class="glyphicon glyphicon-globe"></span>
                  <span class="hidden-xs hidden-sm">Country</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/device/list'); ?>">
                  <span class="glyphicon glyphicon-inbox"></span>
                  <span class="hidden-xs hidden-sm">Device</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/offertype/list'); ?>">
                  <span class="glyphicon glyphicon-sound-dolby"></span>
                  <span class="hidden-xs hidden-sm">Offer type</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/offercat/list'); ?>">
                  <span class="glyphicon glyphicon-list-alt"></span>
                  <span class="hidden-xs hidden-sm">Offer Categories</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/paymterm/list'); ?>">
                  <span class="glyphicon glyphicon-usd"></span>
                  <span class="hidden-xs hidden-sm">Payment term</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager') . '/route/banners/list'); ?>">
                  <span class="glyphicon glyphicon-usd"></span>
                  <span class="hidden-xs hidden-sm">Offer Banners</span>
               </a>
            </li>
         </ul>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/offerRequest'); ?>">
            <span class="glyphicon glyphicon-eye-open"></span>
            <span class="hidden-xs hidden-sm">Pending offer rq</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/route/manager/list'); ?>">
            <span class="glyphicon glyphicon-user"></span>
            <span class="hidden-xs hidden-sm">Sub Manager</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/invoice/invoicedt/'); ?>">
            <span class="glyphicon glyphicon-gbp"></span>
            <span class="hidden-xs hidden-sm">Invoice</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/offers/smartlinks'); ?>">
            <span class="glyphicon glyphicon-refresh"></span>
            <span class="hidden-xs hidden-sm">Smartlink</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/offers/smartoffers'); ?>">
            <span class="glyphicon glyphicon-phone"></span>
            <span class="hidden-xs hidden-sm">SmartOffer</span>
         </a>
      </li>
      <li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager') . '/emailtool'); ?>">
            <span class="glyphicon glyphicon-envelope"></span>
            <span class="hidden-xs hidden-sm">Email Tool</span>
         </a>
      </li>
   </ul>
</div>