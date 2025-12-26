<?php $user_setting = unserialize($profile->user_setting); ?>
<link href="<?php echo base_url(); ?>/temp/default/css/nhap.css" rel="stylesheet">

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
                    <div class="tab_header" id="postbacks">
                        <a class="tab_link" href="<?php echo base_url(); ?>v2/profile/postbacks">Global postbacks</a>
                    </div>
                </div>
            </div>

            <div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
                <form class="sc-jQMNup hiJcSc" id="formProfile" enctype="multipart/form-data">
                    <div>
                        <div class="row col-12 mx-auto">
                            <div class="col-6 form-check mx-auto">
                <input class="form-check-input" type="radio" name=""
                  id="" <?= $profile->is_company == 0 ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Personal
                                </label>
                            </div>
                            <div class="col-6 form-check mx-auto">
                <input class="form-check-input" type="radio" name=""
                  id="" <?= $profile->is_company == 1 ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Company
                                </label>
                            </div>
                            <div class="col-6 form-check mx-auto">
                <input class="form-check-input" type="radio" name=""
                  id="" <?= $user_setting['has_affiliate_program'] == 0 ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    No Affiliate Program
                                </label>
                            </div>
                            <div class="col-6 form-check mx-auto">
                <input class="form-check-input" type="radio" name=""
                  id="" <?= $user_setting['has_affiliate_program'] == 1 ? 'checked' : '' ?> disabled>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Affiliate Program
                                </label>
                            </div>
                        </div>
                        <p class="sc-bJHhxl gXRQqD">Username</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <input name="username" placeholder="Username" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->username ?>" <?= !empty($profile->username) ? 'readonly=true' : '' ?>>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-bJHhxl gXRQqD">Email</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
              <input name="email" placeholder="Email" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?php echo $profile->email; ?>" <?= !empty($profile->email) ? 'readonly=true' : '' ?>>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Skype ID/Telegram</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
              <input name="social_network" maxlength="255" placeholder="Skype ID/Telegram" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->social_network ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>


                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Avatar (Please use image with 3x4 size)</p>

                        <?php
                          $avatarSrc = !empty($profile->avatar_url)
                            ? base_url($profile->avatar_url)
                            : base_url('temp/default/images/avt_unknow.jpeg');
                        ?>

                        <div style="display:flex; gap:12px; align-items:center;">
                            <img id="avatarPreview" src="<?= $avatarSrc ?>" alt="avatar"
                                style="width:70px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;" />

                            <div style="flex:1;">
                                <!-- FILE INPUT: KHÔNG được đặt name avatar_url -->
                                <input type="file" id="avatar_file" name="avatar_file"
                                    accept="image/png,image/jpeg,image/jpg" style="width:100%;" />

                                <small style="display:block;margin-top:6px;opacity:.75">
                                    Allowed: JPG/PNG. Max 2MB.
                                </small>

                                <!-- HIDDEN PATH: cái này mới update vào DB -->
                                <input type="hidden" name="avatar_url" id="avatar_url_hidden"
                                    value="<?= !empty($profile->avatar_url) ? htmlspecialchars($profile->avatar_url) : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">First Name</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
              <input name="first_name" maxlength="255" placeholder="First Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->first_name ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
                        <p class="sc-hARARD cKOZpE">Last Name</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-1vr8bhw">
              <input name="last_name" maxlength="255" placeholder="Last Name" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->last_name ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Phone</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <input name="phone" placeholder="Phone" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->phone; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Address</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <input name="address" placeholder="Address" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->address; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Website</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <input name="website" placeholder="Website" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" value="<?= $profile->website; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Traffic Type</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <?php
              $traffic_sources = $this->db
                ->select('cpalead_custom_features.*')
                ->from('cpalead_advertiser_traffic')
                ->join('cpalead_custom_features', 'cpalead_advertiser_traffic.traffic_source_id = cpalead_custom_features.id')
                ->where('cpalead_advertiser_traffic.advertiser_id', $profile->id)
                ->get();

              $traffics = [];
              foreach ($traffic_sources ? $traffic_sources->result() : [] as $traffic) {
                array_push($traffics, $traffic->id);
              }
              ?>
              <select name="traffic_source[]" class="selectpicker" multiple aria-label="size 3 select example">
                                <?php foreach ($trafficTypes as $type): ?>
                  <option value="<?= $type->id ?>" <?= in_array($type->id, $traffics) ? 'selected' : '' ?>><?= $type->content ?></option>
                                <?php endforeach ?>
                            </select>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <?php
            $current_product_cats = $this->Home_model->get_data('advertiser_pcategories', ['advertiser_id' => $profile->id]);
            $product_cats = [];

            foreach ($current_product_cats as $cat) {
              array_push($product_cats, $cat->product_category_id);
            }
            ?>
                        <p class="sc-bJHhxl gXRQqD">Product Category</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <select name="product_categories[]" class="selectpicker" multiple aria-label="size 3 select example">
                                <?php foreach ($offer_cats as $cat): ?>
                  <option value="<?= $cat->id ?>" <?= in_array($cat->id, $product_cats) ? 'selected' : '' ?>><?= $cat->offercat ?></option>
                                <?php endforeach ?>
                            </select>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="sc-bJHhxl gXRQqD">Product Geo</p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
                            <?php $product_geos = unserialize($profile->product_geo_ids) ?>
              <select name="product_geo_ids[]" class="selectpicker" multiple aria-label="size 3 select example">
                                <?php foreach ($countries as $country): ?>
                  <option value="<?= $country->id ?>" <?= in_array($country->id, $product_geos) ?  'selected' : "" ?>><?= $country->country ?></option>
                                <?php endforeach ?>
                            </select>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                    </div>
                    <div class="sc-ccLTTT cjuVOD">
            <p class="sc-hARARD cKOZpE"><span>About your business:</span><span class="sc-hlILIN kDoghg">*</span></p>
                        <div class="_3WCfA5WYRlXEJAXoSGLCJM css-gd4v6g">
              <textarea name="how_to_get_traffic" placeholder="Please introduce your business, fill more than 200 characters" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c"><?= $profile->how_to_get_traffic ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="update_info">
                    <div class="sc-TuwoP gOhHft">
                        <button class="data_save K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_">
              <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                            <span class="_1pFgCebzxXEI3gItBe_863">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
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
      include('change_password.php');
      include('api_key.php');
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

    $('#avatar_file').on('change', function() {
        const file = this.files && this.files[0];
        if (!file) return;

        const url = URL.createObjectURL(file);
        $('#avatarPreview').attr('src', url);
    });

    $('.data_save').on('click', function(e) {
        e.preventDefault();

        const formEl = $('#formProfile')[0];
        const formData = new FormData(formEl);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('v2/profile/profile'); ?>",
            data: formData,
            processData: false,
            contentType: false,
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