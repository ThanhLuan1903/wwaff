<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "home";
$route['v2/terms'] = 'news/terms';
$route['v2/privacy'] = 'news/terms';

$route['v2'] = 'members/dashboard';
$route['v2/'] = 'members/dashboard';

$route['v2/offers'] = 'members/offers/list_offers';
$route['v2/offers/(:num)'] = 'members/offers/list_offers/$1';//phan trang
$route['v2/offers/available'] = 'members/offers/available';//offer active
$route['v2/offers/available/(:num)'] = 'members/offers/available/$1';//offer active
$route['v2/offers/available/update-status'] = 'members/offers/update_status';//offer active
$route['v2/offers/live'] = 'members/offers/live';
$route['v2/offers/ajax_serach_offer'] = 'members/offers/ajax_serach_offer';
$route['v2/offers/request/(:num)'] = 'members/offers/request/$1';//offer request
$route['v2/offers/request/update'] = 'members/offers/update_request';//offer request
$route['v2/offers/search'] = 'members/offers/search_offer';
$route['v2/offers/invites'] = 'members/offers/list_invites';
$route['v2/offers/invites/(:num)'] = 'members/offers/list_invites/$1';

$route['v2/offer/(:num)'] = 'members/offers/offer_view/$1';//chi tiết offer - offer k có S
$route['v2/favorite/offer/(:num)'] = 'members/favorites/offer/$1';

$route['v2/publishers'] = 'members/publisher';
$route['v2/publishers/search'] = 'members/ajax_search_publisher';
$route['v2/publishers/invite'] = 'members/invite_publishers/';
$route['v2/publishers/rating'] = 'members/rating_publishers';
$route['v2/publishers/my-publishers'] = 'members/my_publishers';
$route['v2/publishers/invited-publishers'] = 'members/invited_publishers';
$route['v2/publishers/update-my-publishers'] = 'members/update_my_publisher';
$route['v2/product'] = 'members/add_product';
$route['v2/product/(:num)'] = 'members/update_product/$1';

//profile
$route['v2/profile/profile'] = 'members/profile';
$route['v2/profile/aj_update_info'] = 'members/profile';
$route['v2/profile/changepass'] = 'members/profile';
$route['v2/profile/api-key'] = 'members/profile';
$route['members/ajax_test_postback'] = 'members/ajax_test_postback';
$route['v2/profile/locale'] = 'members/profile';
$route['v2/profile/payment'] = 'members/profile';
$route['v2/profile/post_payment'] = 'members/post_payment';
$route['v2/profile/resetApi'] = 'members/resetApi';

// Notification Center
$route['v2/notifications'] = 'notifications/notifications/index';
$route['v2/notifications/mark-as-read'] = 'notifications/notifications/mark_as_read';

// Placement
$route['v2/placements'] = 'placements/placements/index';
$route['v2/placements/(:num)'] = 'placements/placements/show/$1';
$route['v2/placements/send-request'] = 'placements/placements/send_request';
$route['v2/placements/update'] = 'placements/placements/update';
$route['v2/placements/publisher'] = 'placements/placements/placement';


//payments
$route['v2/payments'] = 'members/payments/payment_list';
$route['v2/payments/'] = 'members/payments/payment_list';
$route['v2/request_payouts'] = 'members/payments/request_payouts';
$route['v2/edit_payouts'] = 'members/payments/edit_payouts';

$route['v2/smartlinks'] = 'members/smartlinks/list_offers';
$route['v2/smartlinks/(:num)'] = 'members/smartlinks/list_offers/$1';//offer active
$route['v2/smartlinks/(:any)'] = 'members/smartlinks/$1';
$route['v2/smartlinks/request/(:any)'] = 'members/smartlinks/request/$1';//phan trang
$route['v2/offers/search'] = 'members/offers/search_offer';

//smartofff
$route['v2/smartoffers'] = 'members/smartoffers/list_offers';
$route['v2/smartoffers/(:num)'] = 'members/smartoffers/list_offers/$1';//phan trang
$route['v2/smartoffers/(:any)'] = 'members/smartoffers/$1';
$route['v2/smartoffers/request/(:num)'] = 'members/smartoffers/request/$1';//offer request

//request_products
$route['v2/request_products'] = 'members/products/index'; //list request_products
$route['v2/request_products/(:num)'] = 'members/products/index/$1'; //list request_products
$route['v2/request_products/add'] = 'members/products/add';

//help&support
$route['v2/help_and_support'] = 'members/help_and_support/index'; //list conversation
$route['v2/help_and_support/(:num)'] = 'members/help_and_support/index/$1';  //list conversation
$route['v2/help_and_support/add'] = 'members/help_and_support/add'; // add new conversation
$route['v2/help_and_support/detail/(:num)'] = 'members/help_and_support/show/$1'; 
$route['v2/help_and_support/detail/(:num)/comments/(:num)'] = 'members/help_and_support/getListComment/$1/$2'; 
$route['v2/help_and_support/reply/(:num)'] = 'members/help_and_support/reply/$1'; //reply conversation

//ref
$route['v2/referrals'] = 'members/referrals';
//newa
$route['v2/news'] = 'news/news_list';
$route['v2/news/'] = 'news/news_list';
$route['v2/news/(:any)'] = 'news/views/$1';

//statistics
$route['v2/statistics'] = 'members/statistics/dayli';
$route['v2/statistics/'] = 'members/statistics/dayli';
$route['v2/statistics/ajax_static_dayli'] = 'members/statistics/ajax_static_dayli';

$route['v2/statistics/smartlinks'] = 'members/statistics/smartlinks';
$route['v2/statistics/smartoffers'] = 'members/statistics/smartoffers';
$route['v2/statistics/goals'] = 'members/statistics/nodata';
$route['v2/statistics/referrals'] = 'members/statistics/nodata';
$route['v2/statistics/mobile_carrier'] = 'members/statistics/nodata';
$route['v2/statistics/sub(:num)'] = 'members/statistics/sub/$1';

$route['v2/statistics/(:any)'] = 'members/statistics/$1';

$route['v2/sign/in'] = 'members/auth/login';
$route['v2/sign/up'] = 'members/auth/register';
$route['v2/regmanager/(:num)'] = 'members/auth/regm/$1';
$route['v2/sign/password/reset'] = 'members/auth/resetpass';
$route['confirmation/(:any)'] = 'members/auth/activate/$1';

$route['v2/logout'] = 'members/auth/logout';
$route['v2/postbackLog'] = 'members/postbacks/postbackLog';
$route['v2/postback'] = 'members/postbacks/postback';
$route['v2/postback/advAddPostback'] = 'members/postbacks/advAddPostback';
$route['v2/postback/advDelPostback'] = 'members/postbacks/advDelPostback';
$route['v2/postback/getListAdvPostback'] = 'members/postbacks/getListAdvPostback';
$route['v2/profile/postbacks'] = '/postbacks/postback';
$route['v/(:any)'] = 'home/view_content/$1';
$route['v/'] = 'home/view_content';

$route['v2/advertiser/sign-up'] = 'advertiser/auth/sign_up';
$route['advPostbackTest'] = 'tracktest/advPostbackTest';
$route['click/testpb?(:any)'] = 'click/testpb/$1';
$route['click'] = 'click/index';
$route['smartlink?(:any)'] = 'smartlink/index/$1';
$route['smartlink(:any)'] = 'smartlink/index/$1';
$route['smartoffer?(:any)'] = 'smartoffer/index/$1';
$route['smartoffer(:any)'] = 'smartoffer/index/$1';
$route['proxy_report'] = 'proxy_report/index';
$route['proxy_report/filtdata'] = 'proxy_report/filtdata';
$route['proxy_report/rvdata'] = 'proxy_report/rvdata';
$route['proxy_report/(:any)'] = 'proxy_report/index/$1';

$route['ad_user'] = 'ad_user/index/$1';
$route['ad_user/(:any)'] = 'ad_user/$1';

$route['api/offer_feed_json?(:any)'] = 'api/index/$1';
$route['api'] = 'api/document';

$route['advApi'] = 'api/api_adv/index';
$route['advApiDocument'] = 'api/api_adv/document';
$route['api/adv/conversions'] = 'api/api_adv/conversions';
$route['api/adv/statistics'] = 'api/api_adv/statistics';

$route['contact'] = "mod_contact/mod_contact/index";
$route['postback/(:any)'] = 'postback/$1';
$route['advpostback/(:any)'] = 'postback/$1';

$route[$this->config->item('admin').'/(:any)'] = 'adm_adc/$1';
$route[$this->config->item('admin')] = 'adm_adc';

$route[$this->config->item('manager').'/(:any)'] = 'adm_mng/$1';
$route[$this->config->item('manager')] = 'adm_mng';

$route['advertiser/singup'] = 'mod_adv/singup';

$route['404_override'] = 'members/index';

$route['cron-jobs/calculator/all'] = 'api/calculator/all';
$route['cron-jobs/calculator/publishers/(:num)'] = 'api/calculator/calc_publisher/$1';
$route['cron-jobs/calculator/advertisers/(:num)'] = 'api/calculator/calc_advertiser/$1';
$route['cron-jobs/calculator/publishers/all'] = 'api/calculator/all_publishers';
$route['cron-jobs/calculator/advertisers/all'] = 'api/calculator/all_advertisers';
$route['cron-jobs/calculator/payments/near-expired'] = 'api/payment/noti_near_expired_offer';
$route['cron-jobs/calculator/payments/expired'] = 'api/payment/noti_expired_offer';
$route['cron-jobs/calculator/payments/pending'] = 'api/payment/pending_offer';
$route['cron-jobs/calculator/ranking'] = 'api/calculator/calc_pub_ranking';


/* End of file routes.php */
/* Location: ./application/config/routes.php */