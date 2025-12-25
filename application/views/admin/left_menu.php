<div class="col-sm-1 col-xs-1 col-md-2 menuleft">
    <ul class="nav nav-pills nav-stacked main-menu">
        <li role="presentation">
            <a href="<?php echo base_url($this->config->item('admin')); ?>">
                <span class="glyphicon glyphicon-home"></span>
                <span class="hidden-xs hidden-sm">Home</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/showev/report/list'); ?>">
                <span class="glyphicon glyphicon-search"></span>
                <span class="hidden-xs hidden-sm">Offer Report </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('proxy_report'); ?>">
                <span class="glyphicon glyphicon-zoom-in"></span>
                <span class="hidden-xs hidden-sm">Conversions Report </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('/ipreport/show'); ?>">
                <span class="glyphicon glyphicon-zoom-in"></span>
                <span class="hidden-xs hidden-sm">Click Report </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/dashboard/show'); ?>">
                <span style=" display:inline-block; width:22px; text-align:center; font-weight:bold;">⚠</span>
                <span class="hidden-xs hidden-sm">Violation Report</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/route/users/list'); ?>">
                <span class="glyphicon glyphicon-user"></span>
                <span class="hidden-xs hidden-sm">Affiliate</span>
            </a>
        </li>
        <!-- Advertiser -->
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-user"></span>
                <span class="hidden-xs hidden-sm">Advertiser</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/advertiser/list_account'); ?>">
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="hidden-xs hidden-sm">List Avertiser</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/network/listNetwork'); ?>">
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="hidden-xs hidden-sm">Avertiser Network</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/advertiser/list_payments'); ?>">
                        <span class="glyphicon glyphicon-gbp"></span>
                        <span class="hidden-xs hidden-sm">Invoice</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/offers/listoffer'); ?>">

                        <span class="glyphicon glyphicon-gift"></span>
                        <span class="hidden-xs hidden-sm">Products</span>
                    </a>
                </li> -->
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/help_and_support/list_request_advertiser'); ?>">
                        <span class="glyphicon glyphicon-comment"></span>
                        <span class="hidden-xs hidden-sm">Help And Support</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom/publisher_titles'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">ADV Side Titles</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom/publisher_banners'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">ADV Site Banners</span>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Publisher -->
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-user"></span>
                <span class="hidden-xs hidden-sm">Publisher</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/banners/list'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">Publisher Side Banners </span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom/offer_titles'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">Publisher Side Titles</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/help_and_support/list_request_publisher'); ?>">
                        <span class="glyphicon glyphicon-comment"></span>
                        <span class="hidden-xs hidden-sm">Help And Support</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/product/list_request'); ?>">
                        <span class="glyphicon glyphicon-envelope"></span>
                        <span class="hidden-xs hidden-sm">List request</span>
                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/route/network/list'); ?>">
                <span class="glyphicon glyphicon-inbox"></span>
                <span class="hidden-xs hidden-sm">Network</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/advertiser/list_products'); ?>">
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
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/disoffer/list'); ?>">
                        <span class=" glyphicon glyphicon-remove"></span>
                        <span class="hidden-xs hidden-sm">Disabled/Enable </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/country/list'); ?>">
                        <span class="glyphicon glyphicon-globe"></span>
                        <span class="hidden-xs hidden-sm">Country</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/device/list'); ?>">
                        <span class="glyphicon glyphicon-inbox"></span>
                        <span class="hidden-xs hidden-sm">Device</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/offertype/list'); ?>">
                        <span class="glyphicon glyphicon-sound-dolby"></span>
                        <span class="hidden-xs hidden-sm">Offer type</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/offercat/list'); ?>">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <span class="hidden-xs hidden-sm">Offer Categories</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/paymterm/list'); ?>">
                        <span class="glyphicon glyphicon-usd"></span>
                        <span class="hidden-xs hidden-sm">Payment term</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/route/manager/list'); ?>">
                <span class="glyphicon glyphicon-phone-alt"></span>
                <span class="hidden-xs hidden-sm">Manager</span>
            </a>
        </li>
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-compressed"></span>
                <span class="hidden-xs hidden-sm">Pending Request</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/invited_publishers/list/'); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                        <span class="hidden-xs hidden-sm">Pending Invites Adv</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/route/request/list'); ?>">
                        <span class="glyphicon glyphicon-eye-open"></span>
                        <span class="hidden-xs hidden-sm">Pending Request Publisher</span>
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/invoice/invoicedt/'); ?>">
                <span class="glyphicon glyphicon-gbp"></span>
                <span class="hidden-xs hidden-sm">Invoice</span>
            </a>
        </li>
        <!-- Email tools -->
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-envelope"></span>
                <span class="hidden-xs hidden-sm">Email Tools</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/emailtool'); ?>">
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="hidden-xs hidden-sm">Publisher</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/emailtool_adv'); ?>">
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="hidden-xs hidden-sm">Advertiser</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--  -->
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/resetip/'); ?>">
                <span class="glyphicon glyphicon-refresh"></span>
                <span class="hidden-xs hidden-sm">Reset Ip</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/offers/smartlinks'); ?>">
                <span class="glyphicon glyphicon-screenshot"></span>
                <span class="hidden-xs hidden-sm">Smartlink</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/offers/smartoffers'); ?>">
                <span class="glyphicon glyphicon-phone"></span>
                <span class="hidden-xs hidden-sm">SmartOffer</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url($this->config->item('admin') . '/route/content/list'); ?>">
                <span class="glyphicon glyphicon-folder-open"></span>
                <span class="hidden-xs hidden-sm">News</span>
            </a>
        </li>
        <li>
            <!-- Partner Management -->
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-thumbs-up"></span>
                <span class="hidden-xs hidden-sm">Partner Management</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/partner/'); ?>">
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="hidden-xs hidden-sm">Partners</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/partner/type'); ?>">
                        <span class="glyphicon glyphicon-book"></span>
                        <span class="hidden-xs hidden-sm">Partner Types</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Other tools -->
        <li>
            <a href="#" class="dropmenu">
                <span class="glyphicon glyphicon-compressed"></span>
                <span class="hidden-xs hidden-sm">Other</span>
            </a>
            <ul>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom_balance_rewards/view'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">Custom Top 10 Balance</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom_sale_rewards/view'); ?>">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="hidden-xs hidden-sm">Custom Top 10 Sales</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url($this->config->item('admin') . '/custom/view'); ?>">
                        <span class="glyphicon glyphicon-wrench"></span>
                        <span class="hidden-xs hidden-sm"> Custom Themes and Traffic Type</span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>
</div>