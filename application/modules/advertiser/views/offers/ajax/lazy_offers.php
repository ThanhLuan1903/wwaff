<?php
if (!empty($offer)) {
    $marrpaymterm = array();
    $mOfferCat = array();

    if ($paymterm) {
        foreach ($paymterm as $paymterm) {
            $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
        }
    }

    if ($category) {
        foreach ($category as $category) {
            $mOfferCat[$category->id] = $category->offercat;
        }
    }

    foreach ($offer as $offer) {
        $termcat = '
                    <a href="#" class="align-items-center me-3 tag-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tag-icons">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <span class="tag-text tag-text-pay d-inline" name="opaymterm" value="' . $offer->paymterm . '">' . $marrpaymterm[$offer->paymterm] . '</span>
                    </a>';

        //xử lý cuntry
        $Icon = '';
        $point_geos_s = '';
        $mIdCountry = explode('o', substr($offer->country, 1, -1));
        $point_geos = unserialize($offer->point_geos);
        $percent_geos = unserialize($offer->percent_geos);
        $mCountryKeycode['all'] = '';

        if (is_array($country) || is_object($country)) {
            foreach ($country as $country) {
                $mCountryKeycode[$country->id] = strtolower($country->keycode);
            }
        }

        if ($mIdCountry) {
            $dem = 0;
            $cll = '';
            $soluong = count($mIdCountry);
            foreach ($mIdCountry as $mIdCountry) {
                $geo_code = strtoupper($mCountryKeycode[$mIdCountry]);
                if (!empty($point_geos[$geo_code])) {
                    $point = '$' . round($point_geos[$geo_code]);
                } else {
                    //lấy %
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
                if ($dem < 3) { //chỉ lấy 2 cái
                    $point_geos_s .= '                     
                              <div class="flag_icon_country ' . $cll . '">
                                 <span class="boffer_point" style="font-size:12px;"><span>' . $point . '</span></span>&nbsp—
                                 ' . $Icon . '
                              </div>
                           
                           ';
                }
            }
        }
        if ($dem >= 3) {
            $soluong = $soluong - 2;
            $point_geos_s .= "<div><span>&nbsp+" . $soluong . "</span></div>";
        }

        //;xử lý category
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
        //kieemr tra reqeusst
        if ($offer->request && $offer->status != 'Approved') {
            if ($offer->status == 'Pending') {
                $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-warning btn-sm">Pending</a> ';
            } else {
                $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-primary btn-sm">Request Access</a> ';
            }
        } else {
            $link = '<a href="' . base_url('/v2/offer/' . $offer->id) . '" type="button" class="btn btn-success btn-sm">Get Link</a>';
        }
        //check xem smartoffer với smartlink
        if ($offer->smtype == 2) {
            $badge = '<span class="badge bg-success"> Smart Offer </span>';
        } elseif ($offer->smtype == 3) {
            $badge = '<span class="badge bg-info"> Smart Link </span>';
        } else {
            $badge = '';
        }
        include(dirname(__FILE__) . '/../modal_offer.php');
    }
    if (! $final_page) {
        echo '
                  <div id="loading-section" >
                  <div class="row d-flex justify-content-center align-items-center" >
                     <div class="col-1 text-center" style="width: 70px;">
                        <img src="' . base_url("temp/default/images/loading.gif") . '" width="100%" />
                        </div>
                        <div class="col-2">Loading more data</div>
                     </div>
                  </div>

            ';
    }
} else {
    echo '
        <div class="col-12 my-5">
            <div class="d-flex justify-content-center"><h6>There are no offers</h6></div>
        </div>';
}
