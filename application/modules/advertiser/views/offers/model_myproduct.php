<style>
    .Active,
    .Approve {
        background: green
    }

    .Reject {
        background: red
    }

    .Pending {
        background: orange
    }

    .Pause {
        background: orange
    }
</style>
<div class="col-12 mt-3">
    <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
        <div class="box-offers-images d-lg-flex flex-column align-items-center justify-content-center flex-shrink-0 me-3">
            <img class="box-offers-img" src="<?= $offer->img ?>" alt="">
        </div>
        <div class="box-offers-container">
            <div class="box-offers-detail">
                <div class="box-offers-ticons" style="flex-wrap: wrap;">

                    <div class="align-items-center">
                        <span class="box-offers-id">#&nbsp;&nbsp;<?= $offer->id ?>&nbsp;<span>—</span></span>
                        <!-- tag--->
                        <?= $cat_tag ?>
                        <span>— &nbsp;</span>
                        <?= $termcat ?>
                        <!--end tag-->
                    </div>
                </div>
                <a style="display: block;width:400px;cursor: pointer;" class="box-offers-links" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $offer->id ?>" data-toggle="tooltip" data-placement="top" title="<?= $offer->title ?>">
                    <?= $offer->title ?>
                </a>
                <div class="box-offers-point mt-2 pt-2 d-flex">

                    <?= $point_geos_s ?>
                </div>


            </div>

            <div class="sc-TFwJa eSDKjj d-flex flex-column">
                <?php $status = $this->db->get_where('advertiser_offer_status', ['offer_id' => $offer->id])->row(); ?>
                <div class="col-sm-2 dropdown">
                    <a href="#" class="<?= $status ? $status->status : "Pending" ?> d-block link-dark text-center text-dark text-decoration-none smlinks" data-bs-toggle="dropdown" aria-expanded="false" id="show-status-<?= $offer->id; ?>">
                        <?= $status ? $status->status : "Pending" ?>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                </div>


                <?php
                if (!empty($t)) {
                    include('approved2.php');
                }
                ?>

                <p class="mt-2 mx-auto">
                    CR: <?php echo round($offer->cr, 2); ?>% - EPC: $<?php echo round($offer->epc, 2); ?>
                </p>
            </div>

            <div class="sc-TFwJa eSDKjj d-flex flex-column">
                <div class="col-sm-2 center">

                    <?php
                    if ($status->status == "Approve" || $status->status == "Pending") {
                        echo '<a  href="' . base_url('v2/product') . "/" . $offer->id . '" id="button_href_' . $offer->id . '">
                                <button  class="btn_prv_link btn_prv_link_2">
                                <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                <span class="btn_prv_link_2_child_span color_blue_nice button_' . $offer->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </span>
                                <span class="btn_prv_link_2_child2 color_blue_nice button_' . $offer->id . '" >Edit</span>
                            </button>
                            </a>';
                    } else {
                        echo '<a  href="' . base_url('v2/product') . "/" . $offer->id . '" id="button_href_' . $offer->id . '" style="pointer-events: none;">
                                    <button   class="btn_prv_link btn_prv_link_2" id="button_href_' . $offer->id . '">
                                        <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                        <span class="btn_prv_link_2_child_span color_blue_nice button_' . $offer->id . '" style="background:#667278">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        </span>
                                        <span class="btn_prv_link_2_child2 color_blue_nice button_' . $offer->id . '" style="background:#667278" >Edit</span>
                                    </button>
                                </a>';
                    }
                    ?>

                </div>
                <br>
                <div class="form-check form-switch mx-auto">
                    <input class="form-check-input show-product" data-id="<?= $offer->id ?>" type="checkbox" <?= $offer->show == 1 ? 'checked' : '' ?> role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal<?= $offer->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content mb-5">
            <div class="modal-header">
                <h5 class="modal-title">#<?= $offer->id ?> - <?= $offer->title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="m-3">
                <?php include('campaign_view.php'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>