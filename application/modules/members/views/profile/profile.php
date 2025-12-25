<?php require_once(APPPATH . '/modules/adm_adc/services/classes/ThemeService.php'); ?>
<link href="<?php echo base_url(); ?>/temp/default/css/nhap.css" rel="stylesheet">
<?php $acc = unserialize($userData->mailling);  ?>
<?php $countries = []; ?>
<?php $product_categories = []; ?>
<?php $conversion_flow = []; ?>
<?php
$product_geos = $this->Home_model->get_data('country', ['show' => 1]);
$traffic_device = $this->Home_model->get_one('device', ['id' => $userData->traffic_device]);
$trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);
$conversion_flows = $this->Home_model->get_data('offercat', ['show' => 1]);
$offer_types = $this->Home_model->get_data('offertype', ['show' => 1]);

?>
<style>
    .bootstrap-select {
        width: 100% !important;
    }

    .filter-option-inner {
        font-size: 14px !important
    }
</style>
<div class="mt-5 mb-4">

    <div class="sc-dlyikq hrvHfq ">
        <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV" id="name_title">Profile</span>
        <div class="_1haMCIeKQlOTIl_pWtBGbw _1ye-KTmlb5GAdCMzA76WiG">

            <div class="css-15tqd4u hfK7mk6VgJGa8JX5PvVeJ hide_mobile">
                <div class="_3eOZ58qg6Kp88DgJr1zNp_">
                    <div class="tab_header tab_header_active" id="profile">
                        <a class="tab_link" href="<?php echo base_url(); ?>v2/profile/profile">Profile</a>
                    </div>
                    <div class="tab_header" id="changepass">
                        <a class="tab_link" href="<?php echo base_url(); ?>/v2/profile/changepass">Change password</a>
                    </div>
                    <div class="tab_header" id="api-key">
                        <a class="tab_link" href="<?php echo base_url(); ?>v2/profile/api-key">Api-Key</a>
                    </div>

                    <div class="tab_header" id="postback_log">
                        <a class="tab_link" href="<?php echo base_url(); ?>v2/profile/postbacks_log">Postback Log</a>
                    </div>
                    <div class="tab_header" id="payment">
                        <a class="tab_link" href="<?php echo base_url(); ?>v2/profile/payment">Payment system</a>
                    </div>
                </div>
            </div>

            <!---content tab-->
            <div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
                <form class="sc-jQMNup hiJcSc" id="formProfile">
                    <div class="sc-ccLTTT cjuVOD" style="display: flex;">
                        <div class="col-6">
                            <input class="form-check-input" type="radio" name="" id=""
                                <?= $profile->is_company == 0 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Personal
                            </label>
                        </div>
                        <div class="col-6">
                            <input class="form-check-input" type="radio" name="" id=""
                                <?= $profile->is_company == 1 ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Company
                            </label>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-bJHhxl gXRQqD">Email</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="email" placeholder="Email" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $userData->email; ?>" <?= !empty($userData->email) ? 'readonly' : '' ?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-bJHhxl gXRQqD">Username</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="username" placeholder="Username" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $userData->username; ?>"
                                <?= !empty($userData->username) ? 'readonly=true' : '' ?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Skype ID/Telegram</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="im_service" maxlength="255" placeholder="Skype ID/Telegram" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php if ($acc['im_service'] == 'skype') echo $acc['im_info'];
                                        else echo $acc['im_service']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Avatar (Please use image with 3x4 size)</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="avartar" maxlength="255" placeholder="Avatar" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php if (!empty($acc['avartar'])) echo $acc['avartar']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">First Name</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="firstname" maxlength="255" placeholder="First Name" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $acc['firstname']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Last Name</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
                            <input name="lastname" maxlength="255" placeholder="Last Name" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $acc['lastname']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>


                    <div>
                        <p class="sc-bJHhxl gXRQqD">Address </p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <input name="ad" placeholder="Address 1" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $acc['ad']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <!-- Volume -->
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Volume /Month</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <input name="volume" placeholder="Volume/Month" type="number" min="1"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $acc['volume']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <!-- Traffic Device -->
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Traffic Device</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <?php $traffic_devices = $this->Home_model->get_data('device', ['show' => 1]); ?>
                            <select name="traffic_device" class="selectpicker" aria-label="size 3 select example">
                                <?php foreach ($traffic_devices as $traffic_device): ?>
                                    <option value="<?= $traffic_device->id ?>"
                                        <?= $traffic_device->id == $userData->traffic_device ? 'selected' : '' ?>>
                                        <?= $traffic_device->device ?></option>
                                <?php endforeach ?>
                            </select>
                            <!-- <input name="traffic_device" placeholder="Traffic Device" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $userData->traffic_device ?>"> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Website</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <input name="website" placeholder="Website" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $acc['website']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Traffic Type</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <?php $aff_types =  unserialize($acc['aff_type']); ?>
                            <select name="aff_type[]" class="selectpicker" multiple aria-label="size 3 select example">
                                <?php foreach ($trafficTypes as $type): ?>
                                    <option value="<?= $type->content ?>"
                                        <?= in_array($type->content, $aff_types) ? 'selected' : '' ?>><?= $type->content ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Product Category</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <select name="product_categories[]" class="selectpicker" multiple
                                aria-label="size 3 select example">
                                <?php $flow_ids =  explode(',', $userData->product_categories); ?>
                                <?php foreach ($conversion_flows as $flow): ?>
                                    <option value="<?= $flow->id ?>" <?= in_array($flow->id, $flow_ids) ? 'selected' : '' ?>>
                                        <?= $flow->offercat ?></option>
                                <?php endforeach ?>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Product Geo</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <select name="product_geos[]" class="selectpicker" multiple
                                aria-label="size 3 select example">
                                <?php $product_geo_ids =  explode(',', $userData->product_geos); ?>
                                <?php foreach ($product_geos as $geo): ?>
                                    <option value="<?= $geo->id ?>"
                                        <?= in_array($geo->id, $product_geo_ids) ? 'selected' : '' ?>><?= $geo->country ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Product Type</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <select name="conversion_flow[]" class="selectpicker" multiple
                                aria-label="size 3 select example">
                                <?php $product_types_ids =  explode(',', $userData->conversion_flow); ?>
                                <?php foreach ($offer_types as $type): ?>
                                    <option value="<?= $type->id ?>"
                                        <?= in_array($type->id, $product_types_ids) ? 'selected' : '' ?>><?= $type->type ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Tel.</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <input name="phone" placeholder="Tel." type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"
                                value="<?php echo $userData->phone; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE"><span>About your business?</span><span
                                class="sc-hlILIN kDoghg">*</span></p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <textarea name="hear_about"
                                placeholder="Please introduce your business, fill more than 200 characters" type="text"
                                class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"><?php echo $acc['hear_about']; ?></textarea>

                        </div>
                    </div>
                    <input type="hidden" name="action" value="update_info">
                    <div class="sc-TuwoP gOhHft">
                        <button class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
                            <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;">
                            </div>
                            <span class="_1pFgCebzxXEI3gItBe_863">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </span>
                            <span class="_3axrJUuPR6Tfk-J1aQF4dm">Save</span>
                        </button>
                    </div>

                </form>
            </div>
            <?php
            include('changepass.php');
            include('api-key.php');
            include('postback.php');
            include('postback_log.php');
            include('payment.php');
            ?>
        </div>
    </div>

</div>

<div class="position-fixed bottom-0 end-0 p-5 hide">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">

        <div class="toast-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                aria-label="Warning:">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
            <span id="toastContent">
                Successfully edited profile
            </span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.tabcontent').hide();
        $('.tab_header').removeClass('tab_header_active');

        var segments = $(location).attr('href').split("/").splice(0, 7).join("/").split('/');
        var curentTab = segments[5];
        $('.' + curentTab).show();
        $('#' + curentTab).addClass('tab_header_active');

        $('.tab_header').on('click', function(e) {
            curentTab = $(this).attr('id');
            $('.tabcontent').hide(); 
            $('.tab_header').removeClass('tab_header_active');
            $('.' + curentTab).show(); 
            $('#' + curentTab).addClass('tab_header_active'); 
            e.preventDefault();
        })

        $('.btn_del_postBack').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            ajurl = "<?php echo base_url('v2/profile/postbacks'); ?>";
            $.ajax({
                type: "POST",
                url: ajurl,
                data: form.serialize(),
                success: ajaxSuccPb,
                error: ajaxErr
            });

        });
        
        $('.data_save2').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            ajurl = "<?php echo base_url('v2/profile/postbacks'); ?>";
            $.ajax({
                type: "POST",
                url: ajurl,
                data: form.serialize(),
                success: ajaxSuccPb, 
                error: ajaxErr
            });

        });
   
        $('.data_save').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            ajurl = "<?php echo base_url('v2/profile/profile'); ?>";
            $.ajax({
                type: "POST",
                url: ajurl,
                data: form.serialize(),
                success: ajaxSuccess,
                error: ajaxErr
            });

        });

        $('#resetApikey').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            ajurl = "<?php echo base_url('v2/profile/resetApi'); ?>";
            $.ajax({
                type: "POST",
                url: ajurl,
                data: 'resetApikey',
                success: function(apikey) {
                    $('#Api-Key').val(apikey);
                },
                error: ajaxErr
            });

        });

    })
    
    function ajaxSuccPb(data) {
        if (data == 1) {
            window.location.replace("<?php echo base_url('v2/profile/postbacks'); ?>");
        } else {
            alert('Error!');
        }
    }

    function ajaxSuccess(data) {
        $('#toastContent').html(data);
        var myAlert = document.getElementById('thongBao'); 
        var bsAlert = new bootstrap.Toast(myAlert, option); 
        bsAlert.show(); 
    }

    function ajaxErr() {
        alert('Update Error!');
    }
    
    var option = {
        animation: true,
        delay: 5000,
        autohide: true
    };
</script>