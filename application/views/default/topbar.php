<?php $acc = isset($userData) ? unserialize($userData->mailling) : null;  ?>
<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item p-2">
            <a class="nav-link text-dark" href="<?php echo base_url('v2'); ?>">Dashboard</a>
        </li>

        <?php if ($this->session->userdata('role') == 2): ?>
            <div class="dropdown text-end d-lg-block m-auto p-2 ">
                <a href="#" class="d-block link-dark text-dark text-decoration-none dropdown-toggle" id="dropDownProduct"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Publisher
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropDownProduct">
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/publishers'); ?>">List Publishers</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/publishers/my-publishers'); ?>">My Publishers</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/publishers/invited-publishers'); ?>">Invites Publisher</a></li>
                </ul>
            </div>
            <div class="dropdown text-end d-lg-block m-auto p-2">
                <a href="#" class="d-block link-dark text-dark text-decoration-none dropdown-toggle" id="dropDownProduct"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Statistics
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropDownProduct">
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics'); ?>">Daily</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/Conversions'); ?>">Conversions</a> </li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/offers'); ?>">Offers</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/clicks'); ?>">Clicks</a></li>
                    <!--li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/browsers'); ?>">Browsers</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/os'); ?>">OS</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/devices'); ?>">Devices</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/countries'); ?>">Countries</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub1') ?>">Sub1</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub2') ?>">Sub2</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub3') ?>">Sub3</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub4') ?>">Sub4</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub5') ?>">Sub5</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/goals') ?>">Goals</a></li-->
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/referrals') ?>">Referrals</a></li>
                    <!--li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/mobile_carrier') ?>">Mobile ISP</a-->
                </ul>
            </div>
        <?php endif; ?>
        <div class="dropdown text-end d-lg-block m-auto p-2 ">
            <a href="#" class="d-block link-dark text-dark text-decoration-none dropdown-toggle" id="dropDownProduct"
                data-bs-toggle="dropdown" aria-expanded="false">
                Products
            </a>
            <ul class="dropdown-menu text-small" aria-labelledby="dropDownProduct">
                <?php if ($this->session->userdata('role') == 2):  ?><li><a class="dropdown-item" href="<?= base_url('v2/product') ?>">Add Product</a></li><?php endif; ?>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/offers'); ?>">Find product</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/offers/available'); ?>">My product</a></li>
                <?php if ($this->session->userdata('role') == 1):  ?>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/offers/live'); ?>">Live</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('v2/offers/invites'); ?>">Invites</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <?php if ($this->session->userdata('role') == 1): ?>
            <div class="dropdown text-end d-lg-block m-auto p-2">
                <a href="#" class="d-block link-dark text-dark text-decoration-none dropdown-toggle" id="dropDownProduct"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Statistics
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropDownProduct">
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics'); ?>">Daily</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/Conversions'); ?>">Conversions</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/offers'); ?>">Offers</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/clicks'); ?>">Clicks</a></li>
                    <!--li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/browsers'); ?>">Browsers</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/os'); ?>">OS</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/devices'); ?>">Devices</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/countries'); ?>">Countries</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub1') ?>">Sub1</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub2') ?>">Sub2</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub3') ?>">Sub3</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub4') ?>">Sub4</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/sub5') ?>">Sub5</a></li>
                <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/goals') ?>">Goals</a></li-->
                    <li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/referrals') ?>">Referrals</a></li>
                    <!--li><a class="dropdown-item" href="<?php echo base_url('v2/statistics/mobile_carrier') ?>">Mobile ISP</a-->
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($this->session->userdata('role') == 2):  ?><li class="nav-item p-2">
                <a class="nav-link text-dark" href="<?php echo base_url('v2/placements') ?>">Placement Manager </a>
            </li><?php endif; ?>
        <li class="nav-item p-2">
            <a class="nav-link text-dark" href="<?php echo base_url('v2/payments') ?>">Payments</a>
        </li>
        <li class="nav-item p-2">
            <a class="nav-link text-dark" href="<?php echo base_url('v2/postback') ?>">Postback </a>
        </li>
        <?php if ($this->session->userdata('role') == 2):  ?><li class="nav-item p-2">
                <a class="nav-link text-dark" href="<?php echo base_url('advApi') ?>">API </a>
            </li><?php endif; ?>
    </ul>
</div>