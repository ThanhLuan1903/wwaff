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
    <h6 class="text-center" style="margin-botton:0px"><?= substr($left_title->content, 0, 3) ?></h6>
    <h6 class="text-center"><?= substr($left_title->content, 4) ?></h6>
    <div class="row" style="margin-top:20px">
      <?php foreach ($left_banners as $banner) : ?>
        <a href="<?= $banner->link_page ?>" target="_blank">
          <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="custom-container">
    <br><br><br>
    <div class="row" id="list_offers">
      <?php include('notification.php'); ?>
    </div>
  </div>
  <div class="right-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?></h6>
    <h6 class="text-center"><?= substr($right_title->content, 4) ?></h6>
    <div class="row" style="margin-top:20px">
      <?php foreach ($right_banners as $banner) : ?>
        <a href="<?= $banner->link_page ?>" target="_blank">
          <div class="col-12 pb-3">
            <img class="w-100" src="<?= $banner->image_url ?>">
          </div>
        </a>
      <?php endforeach; ?>
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

      $.ajax({
        method: "POST",
        url: `<?= base_url('/v2/offers/request/update') ?>`,
        data: {
          request_id,
          field,
          value
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