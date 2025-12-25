<div class="modal fade" id="exampleModal<?= $offer->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content mb-5">
      <div class="m-3">
        <?php include( dirname(__FILE__) . '/../offers/campaign_view.php'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>