<form class="needs-validation" id="form" novalidate method="POST" enctype="multipart/form-data" action="<?php echo base_url($this->uri->segment(1) . '/advertiser/update_request_product/' . $request_product->id); ?>">
  <div class="mb-2">
    <label for="input1" class="form-label">Name</label>
    <input class="form-control" id="input1" name="name" type="text" maxlength="255" required value="<?= $request_product->name ?>">
    <div class="invalid-feedback" id="error_name"></div>
  </div>
  <div class="mb-2">
    <label for="input2" class="form-label">Preview Link</label>
    <input class="form-control" id="input2" name="preview_link" type="text" maxlength="255" required value="<?= $request_product->preview_link ?>">
    <div class="invalid-feedback" id="error_preview_link"></div>
  </div>
  <div class="mb-2">
    <label for="input3" class="form-label">Payout</label>
    <div class="input-group">
      <input class="form-control" id="input3" name="payout" type="text" maxlength="11" required value="<?= $request_product->payout ?>">
      <span class="input-group-addon">USD</span>
    </div>
  </div>
  <div class="mb-2">
    <label for="formFileSm" class="form-label">Image URL</label>
    <input class="form-control" id="input4" name="image_url" type="text" maxlength="255" required value="<?= $request_product->image_url ?>">
    <!-- <input class="form-control " id="formFileSm" type="file" name="image_url" accept="image/jpeg"> -->
    <img class="image-preview mt-3 " src="" class="img-thumbnail" alt="">
    <div class="invalid-feedback" id="error_image_url"></div>
  </div>
  <button class="btn btn-default" data-bs-dismiss="modal" id="close">
    <span class="btn-text">Close</span>
  </button>
  <button class="btn btn-primary" id="submit_form">
    <span class="btn-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
      </svg>
    </span>
    <span class="btn-text">Save</span>
  </button>
</form>

<script>
  $('#close').click(function() {
        event.preventDefault();
        $('.request-modal').modal('toggle');
    });
</script>