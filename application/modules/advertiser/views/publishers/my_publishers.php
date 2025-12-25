<?php $advertiser_id = $this->session->userdata('user')->id;
$is_depends = true ?>
<script>
  $(document).ready(function() {
    $('.order_wrap_list_items').on('click', function() {
      var urla = '<?php echo base_url('v2/smartlinks/ajorder'); ?>';
      $dt = $(this).attr('data-sort');
      $.ajax({
        type: "POST",
        url: urla,
        data: {
          data: $dt
        },
        success: function() {
          location.reload();
        }
      });
    })

  })
</script>
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
  }

  .sticky-banners {
    padding-top: 40px;
    height: 300px;
    width: 200px;
    top: 50px;
  }

  .readmore {
    color: black;
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
          <? endforeach; ?>
        </div>
  </div>
  <div class="custom-container">
    <div class="card mt-5">
      <div class="card-body">
        <?php include(dirname(__FILE__) . '/filters/input_search.php'); ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/temp/default/css/select2.css" />
        <script src="<?php echo base_url(); ?>/temp/default/js/multiple/select2.min.js"></script>
        <script>
          $(document).ready(function() {
            $('.card-offers-sinput').focusin(function() {
              $('.nut').text('Enter');
              $('.nut').addClass('focus-input-span');
              $('.card-offers-sboxs').addClass('focus-input');

            })
            $('.card-offers-sinput').focusout(function() {
              $('.nut').text('/');
              $('.nut').removeClass('focus-input-span');
              $('.card-offers-sboxs').removeClass('focus-input');
            });

            //tắt menu orderby
            $('body').click(function() {
              $('#menu_sapxep').removeClass('show');

            })

            $('.chosen-select').select2({
              theme: "classic",
              width: '100%'
            });
            $('.chosen-select2').select2({
              theme: "classic",
              width: '100%'
            });
            $('.chosen-select3').select2({
              theme: "classic",
              width: '100%'
            });
            $('.chosen-select-types').select2({
              theme: "classic",
              width: '100%'
            });
            //lựa chọn country hoặc category
            $('.handle_click').click(function() {
              const isSelected = $(this).data('selected') === 'none' ? false : true;
              var data = isSelected ? [] : [$(this).attr('value')];
              var name = $(this).attr('name');
              ajaxFilterO(data, name);
            })

            $('.filteroff').change(function() {
              var data = $(this).val();
              var name = $(this).attr('name');
              ajaxFilterO(data, name);
            })

            $('.tag-text-pay').click(function() {
              var data = [$(this).attr('value')];
              var name = $(this).attr('name');
              ajaxFilterO(data, name);
            })
            $('.tag-text-cat').click(function() {
              var data = [$(this).attr('value')];
              var name = $(this).attr('name');
              ajaxFilterO(data, name);
            })
            $('.card-offers-sicon').click(function() {
              const data = $('.card-offers-sinput').val()
              var name = $('.card-offers-sinput').attr('name');
              ajaxFilterO(data, name);
            });

          })

          function ajaxFilterO(data, name) {

            var ajurl = "<?php echo base_url('/v2/offers/ajax_serach_offer'); ?>";
            $.ajax({
              type: "POST",
              url: ajurl,
              data: {
                gt: data,
                name: name
              },
              success: function() {
                location.reload();
              }

            });
          }
        </script>
      </div>
    </div>
    <div class="row" id="list_offers">
      <?php if (!empty($my_publishers)): ?>
        <?php
        foreach ($my_publishers as $publisher) :
          $mailling = unserialize($publisher->mailling);
          $avatar = $mailling['avartar'];
          $applied_products = $this->db->query("
        SELECT cpalead_offer.*, 
          cpalead_request.id as request_id, 
          cpalead_request.status, 
          cpalead_request.ip, 
          cpalead_request.crequest, 
          cpalead_request.date,
          cpalead_request.show as request_show,
          cpalead_request.traffic_source
        FROM cpalead_offer
        INNER JOIN cpalead_request ON cpalead_request.offerid = cpalead_offer.id
        WHERE cpalead_request.userid = $publisher->id AND cpalead_offer.is_adv = $advertiser_id
        AND NOT EXISTS (SELECT 1 FROM cpalead_invited_publishers WHERE product_id=cpalead_offer.id AND cpalead_invited_publishers.publisher_id = cpalead_request.userid)
        ORDER BY cpalead_request.id DESC
          ")->result();
          $epc = $publisher->epc;
          $rating = $publisher->rating;
          $convertion_rate = $publisher->conversion_rate;
        ?>
          <div class="col-12 mt-3">
            <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
              <div class="box-offers-images d-lg-flex flex-column align-items-center justify-content-center flex-shrink-0 me-3">
                <img class="box-offers-img" src="<?= $avatar ?>" alt="">
              </div>
              <div class="box-offers-container d-block">
                <div class="box-offers-container">
                  <div class="box-offers-detail">
                    <a style="display: block;width:400px;cursor: pointer;" class="box-offers-links" data-bs-toggle="modal" data-bs-target="#modal-<?= $publisher->id ?>" data-toggle="tooltip" data-placement="top" title="(web/wap) V2 US/AU/UK/NZ - Sextingpartners - SOI">
                      <span class="badge bg-success" style="font-size:14px">#<?= $publisher->id ?></span> <span style="font-size:14px;background: linear-gradient(to right, #34A3D4, #30D827); " class="badge bg-info text-dark"><?= $publisher->username ?> </span> </a>
                    <div class="box-offers-point mt-2 pt-2 d-flex">
                      <div class="flag_icon_country ">
                        <span class="boffer_point" style="font-size:12px;"><span>Level:</span> <?= $publisher->level ?></span>
                      </div>
                      <div class="flag_icon_country ">
                        <span class="boffer_point" style="font-size:12px;"><span>EPC:</span> <?= $publisher->epc ?></span>
                      </div>
                      <div class="flag_icon_country ">
                        <span class="boffer_point" style="font-size:12px;"><span>CR:</span> <?= $publisher->conversion_rate ?> </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th style="width:20%">Product Name</th>
                        <th style="width:5%">Product Id</th>
                        <th style="width:10%">Status</th>
                        <th style="width:10%">IP</th>
                        <th style="width:20%">Request Message</th>
                        <th style="width:15%">Date</th>
                        <th style="width:15%">Type</th>
                        <th style="width:10%">Show</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($applied_products as $product) : ?>
                        <tr class="<?= $product->status ?>">
                          <td><?= $product->title ?></td>
                          <td><?= $product->id ?></td>

                          <td>
                            <select id="<?= $product->request_id ?>" class="rqst update-status">
                              <option value="Pending" <?= $product->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                              <option value="Approved" <?= $product->status == 'Approved' ? 'selected' : '' ?>>Approved</option>
                              <option value="Deny" <?= $product->status == 'Deny' ? 'selected' : '' ?>>Deny</option>
                            </select>
                          </td>
                          <td><?= $product->ip ?></td>
                          <td><?= $product->crequest ?></td>
                          <td><?= $product->date ?></td>
                          <td><?= $product->traffic_source ?></td>
                          <td>
                            <div class="sc-TFwJa eSDKjj d-flex flex-column">
                              <div class="form-check form-switch mx-auto">
                                <input class="form-check-input show-product" data-id="<?= $product->request_id ?>" type="checkbox" <?= $product->request_show == 1 ? 'checked' : '' ?> role="switch" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <br>
            </div>
            <div class="modal fade" id="modal-<?= $publisher->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
              <div class="modal-dialog modal-xl">
                <div class="modal-content mb-5">
                  <div class="modal-header">
                    <h5 class="modal-title">#<?= $publisher->id ?></h5>
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
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 my-5">
          <div class="d-flex justify-content-center">
            <h6>There are no publishers</h6>
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
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
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
  $(document).ready(function() {
    $('#stars li').on('mouseover', function() {
      var onStar = parseInt($(this).data('value'), 10);

      $(this).parent().children('li.star').each(function(e) {
        if (e < onStar) {
          $(this).addClass('hover');
        } else {
          $(this).removeClass('hover');
        }
      });

    }).on('mouseout', function() {
      $(this).parent().children('li.star').each(function(e) {
        $(this).removeClass('hover');
      });
    });

    $('#stars li').one('click', function() {
      const votedField = $(this).parent().find('#voted');
      const isVoted = votedField.data('voted') === 'voted' ? true : false;
      if (isVoted) {
        alert('You voted');
        return;
      }
      var onStar = parseInt($(this).data('value'), 10);
      var stars = $(this).parent().children('li.star');

      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
      }

      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      }

      var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      var msg = "";
      if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
      } else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
      }

      const publisher_id = $(this).data('publisher');
      const rating = ratingValue;
      $.ajax({
        type: 'POST',
        url: '<?= base_url('v2/publishers/rating') ?>',
        data: {
          publisher_id,
          rating
        },
        success: function(response) {
          votedField.data('voted', 'voted');
        }
      })
      responseMessage(msg);

    });

    function responseMessage(msg) {
      $('.success-box').fadeIn(200);
      $('.text-message').html(msg);
    }

    /******************* *****************************/
    $('.heart-icon').click((e) => {
      const el = e.currentTarget
      let isLiked = $(el).data('isliked');
      let offerId = $(el).data('id');
      const url = `<?php echo base_url('v2/favorite/offer') ?>/${offerId}`

      $.ajax({
        type: "POST",
        url: url,
        success: (response) => {
          if (isLiked == 1) {
            $(el).attr('data-isliked', "0")
            $(el).data('isliked', "0")
            $(el).find('svg').removeClass('fill')
            $(el).find('svg path').attr('d',
              "m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"
            )

          }
          if (isLiked == 0) {
            $(el).attr('data-isliked', "1")
            $(el).data('isliked', "1")
            $(el).find('svg').addClass('fill')
            $(el).find('svg path').attr('d',
              "M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z")
          }
        }
      })
    });

    $('.show-product').change(function() {
      const show = $(this).is(':checked') ? 1 : 0;
      const request_id = $(this).data('id');
      $.ajax({
        method: "POST",
        url: `<?= base_url('v2/publishers/update-my-publishers') ?>`,
        data: {
          request_id,
          show
        },
        success: function(response) {
          const myAlert = $('#thongBao')
          $('#toastContent').html('Update Successfully');
          myAlert.addClass('toast-top-left');

          var option = {
            animation: true,
            delay: 5000,
            autohide: true,
            position: 'top-start'
          };
          var bsAlert = new bootstrap.Toast(myAlert, option); //inizialize it
          bsAlert.show();
        }
      })
    });

    $('.update-status').change(function() {
      const request_id = $(this).attr('id');
      const status = $(this).val();

      $.ajax({
        method: "POST",
        url: `<?= base_url('v2/publishers/update-my-publishers') ?>`,
        data: {
          request_id,
          status
        },
        success: function(response) {
          const myAlert = $('#thongBao')
          $('#toastContent').html('Update Successfully');
          myAlert.addClass('toast-top-left');

          var option = {
            animation: true,
            delay: 5000,
            autohide: true,
            position: 'top-start'
          };
          var bsAlert = new bootstrap.Toast(myAlert, option); //inizialize it
          bsAlert.show();
        }
      })
    });

    readMoreButton();
  });

  const readMoreButton = () => {
    $('.readmore').click(function() {
      if ($(this).text() == 'Read less') {
        $(this).parent().find('.more').css('display', 'none');
        $(this).parent().find('.dots').css('display', 'inline');
        $(this).text('Read more');
      } else {
        $(this).parent().find('.more').css('display', 'inline');
        $(this).parent().find('.dots').css('display', 'none');
        $(this).text('Read less');
      }

    })
  }
</script>