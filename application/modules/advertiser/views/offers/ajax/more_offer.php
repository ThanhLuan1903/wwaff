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

<?php

$mCountryKeycode = array();
if ($country) {
    foreach ($country as $country_item) {
        $mCountryKeycode[$country_item->id] = strtolower($country_item->keycode);
    }
}

if (!empty($offer)) {
    foreach ($offer as $offer) {

        $termcat = '
        <a href="#" class="align-items-center me-3 tag-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span class="tag-text tag-text-pay d-inline" name="opaymterm" value="' . $offer->paymterm . '">' . $marrpaymterm[$offer->paymterm] . '</span>
        </a>';

        $Icon = '';
        $point_geos_s = '';
        $mIdCountry = explode('o', substr($offer->country, 1, -1));
        $point_geos = unserialize($offer->point_geos);
        $percent_geos = unserialize($offer->percent_geos);
        $mCountryKeycode['all'] = '';

        if ($mIdCountry) {
            $dem = 0;
            $cll = '';
            $soluong = count($mIdCountry);

            foreach ($mIdCountry as $mIdCountry) {
                $geo_code = strtoupper($mCountryKeycode[$mIdCountry]);

                if (!empty($point_geos[$geo_code])) {
                    $point = '$' . round($point_geos[$geo_code]);
                } else {
                    if (!empty($percent_geos[$geo_code])) {
                        $point = round($percent_geos[$geo_code]) . '% Revshare';
                    } else {
                        $point = '$0';
                    }
                }

                if ($mIdCountry == 'all') {
                    $Icon = 'All Countries ';
                    if (!empty($point_geos['all'])) $point = '$' . $point_geos['all'];
                    if (!empty($percent_geos['all'])) $point = $percent_geos['all'] . '% Revshare';
                } else {
                    $Icon = '<img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/' . $mCountryKeycode[$mIdCountry] . '.svg">';
                }

                $dem++;
                if ($dem == $soluong) {
                    $cll = 'enditem';
                }

                if ($dem < 3) {
                    $point_geos_s .= '
                    <div class="flag_icon_country ' . $cll . '">
                        <span class="boffer_point" style="font-size:12px;"><span>' . $point . '</span></span>&nbsp;—
                        ' . $Icon . '
                    </div>';
                }
            }
        }

        if ($dem >= 3) {
            $soluong = $soluong - 2;
            $point_geos_s .= "<div><span>&nbsp+" . $soluong . "</span></div>";
        }

        $cat_tag = '';
        $mIdCat = explode('o', substr($offer->offercat, 1, -1));
        if ($mIdCat) {
            foreach ($mIdCat as $mIdCat) {
                $cat_tag .= '
                <a href="#" class="align-items-center me-3 tag-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                    <span class="tag-text tag-text-cat d-inline" name="oCat" value="' . $mIdCat . '">' . $mOfferCat[$mIdCat] . '</span>
                </a>';
            }
        }

        if ($offer->request && $offer->status != 'Approved') {
            if ($offer->status == 'Pending') {
                $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-warning btn-sm">Pending</a>';
            } else {
                $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-primary btn-sm">Request Access</a>';
            }
        } else {
            $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-success btn-sm">Get Link</a>';
        }

        if ($offer->smtype == 2) {
            $badge = '<span class="badge bg-success"> Smart Offer </span>';
        } elseif ($offer->smtype == 3) {
            $badge = '<span class="badge bg-info"> Smart Link </span>';
        } else {
            $badge = '';
        }
?>

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
                                echo '<a href="' . base_url('v2/product') . "/" . $offer->id . '" id="button_href_' . $offer->id . '">
                                    <button class="btn_prv_link btn_prv_link_2">
                                    <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                    <span class="btn_prv_link_2_child_span color_blue_nice button_' . $offer->id . '">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </span>
                                    <span class="btn_prv_link_2_child2 color_blue_nice button_' . $offer->id . '">Edit</span>
                                </button>
                                </a>';
                            } else {
                                echo '<a href="' . base_url('v2/product') . "/" . $offer->id . '" id="button_href_' . $offer->id . '" style="pointer-events: none;">
                                        <button class="btn_prv_link btn_prv_link_2" id="button_href_' . $offer->id . '">
                                            <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                                            <span class="btn_prv_link_2_child_span color_blue_nice button_' . $offer->id . '" style="background:#667278">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </span>
                                            <span class="btn_prv_link_2_child2 color_blue_nice button_' . $offer->id . '" style="background:#667278">Edit</span>
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

        <!-- MODAL -->
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

<?php
    }
} else {
    echo '
    <div class="col-12 my-5">
        <div class="d-flex justify-content-center"><h6>There are no offers</h6></div>
    </div>';
}
?>

<input type="hidden" id="final_page_indicator" value="<?= $final_page ? 'true' : 'false' ?>">