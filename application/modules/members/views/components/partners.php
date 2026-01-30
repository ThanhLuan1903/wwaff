<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.wwaff-friend h4 {
  font-weight: 800;
  letter-spacing: .3px;
  margin-bottom: 16px;
}

.card-category {
  border-radius: 12px;
  border: 1px solid rgba(0,0,0,.08);
  overflow: hidden;
  background: #fff;
  transition: all .25s ease;
  box-shadow: 0 1px 0 rgba(0,0,0,.04);
  height: 100%;
}

.card-category:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0,0,0,.12);
}

.card-category .card-img-top {
  height: 140px;
  width: 100%;
  object-fit: contain;
  background: linear-gradient(135deg,#f8fafc,#eef2f7);
  padding: 18px;
}

.card-category .card-body {
  padding: 10px 12px;
  background: #fff !important;
}

.card-category .card-body h6 {
  font-size: 15px;
  font-weight: 700;
  margin: 0;
  line-height: 1.2;
  color: #111827;
}

.card-category .card-body i {
  color: #2563eb;
  font-size: 14px;
  transition: transform .2s ease;
}

.card-category:hover .card-body i {
  transform: translateX(4px);
}

.partner-col {
  width: 12.5%;
  padding: 6px;
}

@media (max-width: 1400px) {
  .partner-col { width: 16.66%; }
}
@media (max-width: 1200px) {
  .partner-col { width: 20%; }
}
@media (max-width: 992px) {
  .partner-col { width: 25%; }
}
@media (max-width: 768px) {
  .partner-col { width: 33.33%; }
}
@media (max-width: 576px) {
  .partner-col { width: 50%; }
}
</style>

<?php
// $categories = $this->Home_model->get_data('offer_categories', ['status' => 1]);
$partner_types = $this->Partner_model->get_all_partner_type();
$uid = $this->member->id;
?>
<section class="wwaff-friend">
  <br>
  <h4>Wwaff's Friend</h4>
  <?php foreach ($partner_types as $partner_type) : ?>

    <?php $partners = $this->Partner_model->find_partner_by_type($partner_type->id); ?>
    <!-- Show products of the category -->
    <div class="row">
      <?php foreach ($partners as $partner) : ?>
        <div class ="partner-col">
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