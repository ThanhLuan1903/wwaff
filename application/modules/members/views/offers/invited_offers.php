<style>
  .flag_icon_country {
    border-right: 1px solid #cacaca;
    padding: 0 5px;
  }

  .Approved {
    background: #aeddae;
  }

  .Pending {
    background: #ffffd1;
  }

  .Deny {
    background: #f4c9c9;
  }

  .enditem {
    border-right: 0px !important;
  }

  .select2-selection--multiple:before {
    content: "";
    position: absolute;
    right: 7px;
    top: 42%;
    border-top: 5px solid #888;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
  }

  .select2-selection {
    border-radius: 4px;
    background: transparent;
  }

  .select2-search__field {
    background: transparent;
  }

  .select2-selection {
    background: transparent;
  }

  .smlinks {
    border: 1px solid #cacaca;
    width: 150px;
    height: 32px;
    line-height: 32px;
    margin: 0 5px;
    border-radius: 4px;
  }

  .smlinks:hover {
    border-color: #56bf85;
  }

  .smlinks a {
    padding: 0 !important
  }

  .card-footer {
    background-color: #ffffff;
    border-top: none;
  }

  .show-detail:hover {
    cursor: pointer;
  }

  .order_wrap_list_items {
    width: 100%;
  }

  .custom-modal {
    margin: 0 !important;
  }

  .heart-icon {
    display: flex;
    align-items: center;
  }

  .heart-icon:hover {
    color: red;
    cursor: pointer;
  }

  .heart-icon .fill {
    color: red;
  }

  .ranking-icon {
    background-image: url('<?php echo base_url(); ?>/temp/ranking.png');
    min-height: 40px;
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;

    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ranking-icon__text {
    font-size: 1.55em;
    color: #d7a942;
  }

  .full-width {
    display: flex;
    justify-content: space-between;
  }

  .custom-container {
    width: 70%;
    height: 90vh;
  }

  .sticky-banners {
    padding-top: 40px;
    height: 300px;
    width: 200px;
    top: 50px;
  }

  .toast {
    top: 10px;
    right: 10px;
    z-index: 9999;
  }

  .toast .bg-success,
  .toast .bg-danger {
    color: white;
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
          <? endforeach; ?>
        </div>
  </div>
  <div class="custom-container">
    <br><br><br>
    <div class="row" id="list_offers">
      <?php if (!empty($invitation_advertisers)): ?>
        <?php
        foreach ($invitation_advertisers as $advertiser) :
          $query_string = "
        SELECT cpalead_request.id as request_id,
                cpalead_request.ip,
                cpalead_request.status as request_status,
                cpalead_request.date,
                cpalead_request.traffic_source,
                cpalead_offer.title,
                cpalead_offer.id,
                cpalead_invited_publishers.invitation_message
        FROM cpalead_invited_publishers
        INNER JOIN cpalead_offer on cpalead_offer.id = cpalead_invited_publishers.product_id
        INNER JOIN cpalead_request on cpalead_request.id = cpalead_invited_publishers.request_id
        WHERE cpalead_invited_publishers.publisher_id = {$this->member->id} and cpalead_invited_publishers.advertiser_id = $advertiser->id";
          $invited_offers =  $this->db->query($query_string)->result();
        ?>
          <div class="col-12 mt-3">
            <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
              <div class="box-offers-images d-lg-flex flex-column align-items-center justify-content-center flex-shrink-0 me-3">
                <img class="box-offers-img" src="<?= $advertiser->avatar_url ?>" alt="">
              </div>
              <div class="box-offers-container d-block">
                <div class="box-offers-container">
                  <div class="box-offers-detail">
                    <a style="display: block;width:400px" class="box-offers-links" data-bs-toggle="modal" data-bs-target="#modal-<?= $publisher->id ?>" data-toggle="tooltip" data-placement="top" title="(web/wap) V2 US/AU/UK/NZ - Sextingpartners - SOI">
                      #<?= $advertiser->id ?>|<?= $advertiser->username ?> </a>
                  </div>
                </div>
                <div>
                  <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width:20%">Product Name</th>
                        <th style="width:5%">Product Id</th>
                        <th style="width:5%">Traffic Type</th>
                        <th style="width:4%">Status</th>
                        <th style="width:3%">IP</th>
                        <th style="width:10%">Date</th>
                        <th style="width:10%">Description</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $mailling = unserialize($this->member->mailling);
                      $traffic_sources = explode(',', $mailling['aff_type']);
                      ?>
                      <?php foreach ($invited_offers as $offer) : ?>
                        <tr class="<?= $offer->request_status ?>">
                          <td style="width: 10%"><?= $offer->title ?></td>
                          <td style="width: 5%"><?= $offer->id ?></td>
                          <td style="width: 10%">

                            <select data-offer="<?= $offer->id ?>" id="<?= $offer->request_id ?>" name="traffic_source" class="rqst update-request-status">
                              <?php foreach ($traffic_sources as $traffic_source) : ?>
                                <option value="<?= $traffic_source ?>" <?= $offer->traffic_source == $traffic_source ? 'selected' : '' ?>><?= $traffic_source ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td style="width: 10%">
                            <select data-offer="<?= $offer->id ?>" id="<?= $offer->request_id ?>" name="status" class="rqst update-request-status ">
                              <option value="Pending" <?= $offer->request_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                              <option value="Approved" <?= $offer->request_status == 'Approved' ? 'selected' : '' ?>>Agree</option>
                              <option value="Deny" <?= $offer->request_status == 'Deny' ? 'selected' : '' ?>>Deny</option>
                            </select>
                          </td>
                          <td class="ip-address" style="width: 10%"><?= $offer->ip ?></td>
                          <td><?= $offer->date ?></td>
                          <td style="width: 60%;max-width:100px;word-wrap: break-word;"><?= $offer->invitation_message ?></td>
                        </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <br>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 my-5">
          <div class="d-flex justify-content-center">
            <h6>There are no invites</h6>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="right-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?></h5>
      <h6 class="text-center"><?= substr($right_title->content, 4) ?></h5>
        <div class="row" style="margin-top:20px">
          <?php foreach ($right_banners as $banner) : ?>
            <a href="<?= $banner->link_page ?>" target="_blank">
              <div class="col-12 pb-3">
                <img class="w-100" src="<?= $banner->image_url ?>">
              </div>
            </a>
          <? endforeach; ?>

        </div>
  </div>

  <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 99999;">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="toast">
      <div class="toast-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <span id="toastContent">
          Copy to clipboard
        </span>
      </div>
    </div>
  </div>
</div>
<br><br><br>

<script>
  $(document).ready(() => {
    updateRequestProduct();
  });

  const updateRequestProduct = () => {
    $('.update-request-status').change(function() {
      const value = $(this).val();
      const request_id = $(this).attr('id');
      const field = $(this).attr('name');
      const offer_id = $(this).data('offer');


      $.ajax({
        method: "POST",
        url: `<?= base_url('/v2/offers/request/update') ?>`,
        data: {
          request_id,
          field,
          value,
          offer_id
        },
        success: function(res) {
          const content = 'Updated Successfully'
          showToast('success', content);
          setTimeout(() => window.location.reload(), 3000);
        },
        error: function(err) {

        }
      })
    });
  }

  function showToast(type, content) {
    const myToastEl = $('#toast');
    var myToast = new bootstrap.Toast(myToastEl, {
      animation: true,
      delay: 5000,
      autohide: true
    });

    if (type == 'success') {
      $('#toast .toast-header').removeClass('bg-danger')
      $('#toast .toast-body').removeClass('bg-danger')
      $('#toast .toast-header').removeClass('bg-success')
      $('#toast .toast-body').removeClass('bg-success')
      $('#toast .toast-header').addClass('bg-success')
      $('#toast .toast-body').addClass('bg-success')
      $('.toast-header strong').html('Successfully');
      $('.toast-body').html(content);
    } else {
      $('#toast .toast-header').removeClass('bg-danger')
      $('#toast .toast-body').removeClass('bg-danger')
      $('#toast .toast-header').removeClass('bg-success')
      $('#toast .toast-body').removeClass('bg-success')
      $('#toast .toast-header').addClass('bg-danger')
      $('#toast .toast-body').addClass('bg-danger')
      $('.toast-header strong').html('Errors');
      $('.toast-body').html(content);
    }
    myToast.show();
  }
</script>