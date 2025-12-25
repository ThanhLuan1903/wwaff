<?php
$advertiser_id = $this->session->userdata('user')->id;
$is_depends = true
?>

<style>
  .full-width {
    display: flex;
    justify-content: space-between;
  }

  .custom-container {
    width: 70%;
  }

  .sticky-banners {
    padding-top: 40px;
    height: 300px;
    width: 200px;
    top: 50px;
  }

  .custom-container {
    width: 70%;
  }

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

<div class="full-width">
  <div class="left-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($left_title->content, 0, 3) ?></h5>
      <h6 class="text-center"><?= substr($left_title->content, 4) ?></h5>
        <div class="row" style="margin-top:20px">
          <?php foreach ($left_banners as $banner) : ?>
            <a href="<?= $banner->link_page ?>" target="_blank">
              <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
            </a>
          <?php endforeach; ?>
        </div>
  </div>
  <div class="custom-container">
    <div class="card mt-5"></div>
    <div class="row" id="list_offers">
      <?php
      foreach ($placements as $placement):
        $mailling = unserialize($placement->mailling);
        $avatar = $mailling['avartar'];
      ?>
        <div class="col-12 mt-3">
          <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
            <div class="box-offers-images d-lg-flex flex-column align-items-center justify-content-center flex-shrink-0 me-3">
              <img class="box-offers-img" src="<?= $avatar ?>" alt="">
            </div>
            <div class="box-offers-container d-block">
              <div class="box-offers-container">
                <div class="box-offers-detail">
                  <span class="badge bg-success" style="font-size:14px">#<?= $placement->userid ?></span>
                  <span style="font-size:14px;background: linear-gradient(to right, #34A3D4, #30D827); " class="badge bg-info text-dark"><?= $placement->username ?></span>
                  <span style="font-size:14px;background: linear-gradient(to right, #34A3D4, #30D827); " class="badge bg-info text-dark">Product name: <?= $placement->title ?></span>
                  <span style="font-size:14px;background: linear-gradient(to right, #34A3D4, #30D827); " class="badge bg-info text-dark">Date Approve: <?= $placement->request_updated_at ?> </span>
                  <div class="box-offers-point mt-2 pt-2 d-flex">
                    <div class="flag_icon_country ">
                      <span class="boffer_point" style="font-size:12px;"><span>Level:</span> <?= $placement->level ?> |</span>
                    </div>
                    <div class="flag_icon_country ">
                      <span class="boffer_point" style="font-size:12px;"><span>EPC:</span> <?= $placement->epc ?> |</span>
                    </div>
                    <div class="flag_icon_country ">
                      <span class="boffer_point" style="font-size:12px;"><span>CR:</span> <?= $placement->cr ?> | </span>
                    </div>
                    <div class="flag_icon_country ">
                      <span class="boffer_point" style="font-size:12px;"><span>Offer ID:</span> <?= $placement->offer_id ?> |</span>
                    </div>
                  </div>
                </div>
                <div class="sc-TFwJa eSDKjj d-flex flex-column">
                  <div class="col-sm-2 center">
                    <?php
                    $requested = $this->Home_model->get_one('placements', [
                      'advertiser_id' => $this->session->userdata('user')->id,
                      'publisher_id' => $placement->userid,
                      'offer_id' => $placement->offer_id
                    ]);
                    ?>
                    <?php if ($requested->status == 'Submitted'): ?>
                      <a href="<?= base_url('v2/placements/' . $requested->id) ?>" data-request="<?= $placement->request_id ?>" data-publisher="<?= $placement->userid ?>" data-offer="<?= $placement->offer_id ?>">
                        <button class="btn_prv_link btn_prv_link_2"><span class="btn_prv_link_2_child2 btn-warning">Check</span></button>
                      </a>
                    <?php elseif ($requested->status === 'Requested'): ?>
                      <a href="<?= base_url('v2/placements/' . $requested->id) ?>" data-request="<?= $placement->request_id ?>" data-publisher="<?= $placement->userid ?>" data-offer="<?= $placement->offer_id ?>">
                        <button class="btn_prv_link btn_prv_link_2"><span class="btn_prv_link_2_child2 btn-warning">Request Sent</span></button>
                      </a>
                    <?php elseif ($requested->status === 'Checked'): ?>
                      <a href="<?= base_url('v2/placements/' . $requested->id) ?>" data-request="<?= $placement->request_id ?>" data-publisher="<?= $placement->userid ?>" data-offer="<?= $placement->offer_id ?>">
                        <button class="btn_prv_link btn_prv_link_2"><span class="btn_prv_link_2_child2 btn-warning">Check</span></button>
                      </a>
                    <?php else: ?>
                      <a href="#" class="btn-send-request" data-request="<?= $placement->request_id ?>" data-publisher="<?= $placement->userid ?>" data-offer="<?= $placement->offer_id ?>">
                        <button class="btn_prv_link btn_prv_link_2">
                          <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                          <span class="btn_prv_link_2_child_span color_blue_nice">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                              <line x1="12" y1="5" x2="12" y2="19"></line>
                              <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                          </span>
                          <span class="btn_prv_link_2_child2 color_blue_nice">Request</span>
                        </button>
                      </a>
                    <?php endif; ?>
                  </div>
                  <br>
                </div>
              </div>
            </div>
            <br>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="right-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?></h6>
    <h6 class="text-center"><?= substr($right_title->content, 4) ?></h6>
    <div class="row" style="margin-top:20px">
      <?php foreach ($right_banners as $banner): ?>
        <a href="<?= $banner->link_page ?>" target="_blank">
          <div class="col-12 pb-3"><img class="w-100" src="<?= $banner->image_url ?>"></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 99999;">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
      <div class="toast-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <span id="toastContent">Copy to clipboard</span>
      </div>
    </div>
  </div>
</div>
<br><br><br>

<script>
  $(document).ready(function() {
    send_request();
  })

  const send_request = () => {
    $('.btn-send-request').click(function() {
      const request_id = $(this).data('request');
      const offer_id = $(this).data('offer');
      const publisher_id = $(this).data('publisher');

      $.ajax({
        method: "POST",
        url: `<?= base_url() ?>v2/placements/send-request`,
        data: {
          request_id,
          offer_id,
          publisher_id,
        },
        success: function(response) {
          location.reload();
        }
      })
    });
  }
</script>