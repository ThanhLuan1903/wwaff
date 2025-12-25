<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .card-category .card-body h6 {
    padding: 0;
    margin: 0;
    cursor: pointer;
  }
</style>
<?php
// $categories = $this->Home_model->get_data('offer_categories', ['status' => 1]);
$partner_types = $this->Partner_model->get_all_partner_type();
$uid = $this->member->id;
?>
<section>
  <br>
  <h4>Wwaff's Friend</h4>
  <?php foreach ($partner_types as $partner_type) : ?>

    <?php $partners = $this->Partner_model->find_partner_by_type($partner_type->id); ?>
    <!-- Show products of the category -->
    <div class="row">
      <?php foreach ($partners as $partner) : ?>
        <div style="width: 12.5%">
          <div class="card card-category">
            <a href="<?= $partner->link_profile ?>" style="color: inherit; text-decoration: none;">
            <img class="card-img-top" style="height:140px" src="<?= $partner->logo ?>" alt="Card image cap">
              <div class="d-flex justify-content-between align-items-center card-body bg-light">
                <h6 style="font-size: 15px" <?= $partner->id ?>><?= $partner->name ?></h6>
                <a href="<?= $partner->link_profile ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
              </div>
            </a>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="catProduct<?= $partner->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
          <div class="modal-dialog modal-xl">
            <div class="modal-content mb-5">
              <div class="m-3">
                <?php include dirname(__FILE__) .'/../offers/campaign_view.php'; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endforeach; ?>
</section>