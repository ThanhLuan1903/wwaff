<style>
   .aff-hero{
      border-radius: 14px;
      overflow: hidden;
      border: 1px solid rgba(0,0,0,.08);
      box-shadow: 0 10px 30px rgba(0,0,0,.08);
      margin: 12px 0 18px;
      position: relative;
      background: #0b1220;
   }

   .aff-hero:before{
      content:"";
      position:absolute; inset:0;
      background: linear-gradient(90deg, rgba(11,18,32,.92) 0%, rgba(11,18,32,.78) 45%, rgba(11,18,32,.25) 100%);
      z-index:1;
   }

   .aff-hero-inner{
      position:relative;
      z-index:2;
      padding: 28px 26px;
      min-height: 460px;
      display:flex;
      align-items:center;
   }

   .aff-hero-title{
      color:#fff;
      font-weight: 800;
      letter-spacing: .2px;
      margin: 0 0 14px;
      line-height: 1.2;
      font-size: 28px;
   }

   .aff-hero-sub{
      color: rgba(255,255,255,.75);
      margin: 0 0 18px;
      font-size: 14px;
   }

   .aff-search{
      max-width: 720px;
   }

   .aff-input-group{
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.16);
      border-radius: 12px;
      padding: 8px;
      display:flex;
      gap: 8px;
      backdrop-filter: blur(6px);
   }

   .aff-input{
      flex: 1;
      height: 46px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,.18);
      background: rgba(255,255,255,.94);
      padding: 0 14px;
      outline: none;
      font-weight: 600;
   }

   .aff-input:focus{
      border-color: #FFDF00;
      box-shadow: 0 0 0 4px rgba(255,223,0,.18);
   }

   .aff-btn{
      height: 46px;
      border-radius: 10px;
      padding: 0 16px;
      font-weight: 800;
      border: 1px solid #FFDF00;
      background: #FFDF00;
      color: #111;
      display:flex;
      align-items:center;
      gap: 8px;
      transition: transform .15s ease, filter .15s ease;
      white-space: nowrap;
   }

   .aff-btn:hover{
      transform: translateY(-1px);
      filter: brightness(1.02);
   }

   .aff-btn svg{ width:18px; height:18px; }

   .aff-chips{
      margin-top: 12px;
      display:flex; flex-wrap:wrap;
      gap: 8px;
   }
   .aff-chip{
      font-size: 12px;
      color: rgba(255,255,255,.86);
      border: 1px solid rgba(255,255,255,.18);
      background: rgba(255,255,255,.10);
      padding: 6px 10px;
      border-radius: 999px;
   }

   @media (max-width: 992px){
      .aff-hero-inner{ padding: 22px 18px; min-height: 200px; }
      .aff-hero-title{ font-size: 22px; }
   }
   @media (max-width: 576px){
      .aff-input-group{ flex-direction: column; }
      .aff-btn{ width: 100%; justify-content:center; }
   }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.5rem;">
   <div class="modal-dialog modal-xl">
      <div class="modal-content mb-5">
         <div id="show-content"></div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<div class="row my-3 g-4 row-cols-lg-1 ">
   <div class="col-xl-6 col-lg-12 vien">
      <div class="manager  db_info  py-2 px-4 d-flex flex-column align-content-between">
         <div class="row d-flex justify-content-between my-sm-3">
            <div class="d-flex col-md-8 col-sm-12 lign-items-start">
               <div class="manager-avatar icon-square bg-light text-dark flex-shrink-0 me-3">
                  <img src="<?php if ($manager) {
                                 echo $manager->images;
                              }
                              ?>" alt="" wdith="100%">
               </div>
               <div class="manager-info">
                  <?php
                  if (!empty($manager)) {
                     echo '
                                            <p class="mtp">Personal Manager</p>
                                            <p class="m-name">' . $manager->name . '</p>
                                            <p class="email"><span>Email:</span> ' . $manager->email . '</p>
                                            <p class="skype"><span>Skype:</span> ' . $manager->skype . '</p>
                                          ';
                  }
                  ?>

               </div>

            </div>
            <div class="d-flex flex-md-row-reverse mb-3 col-md-4 col-sm-12">
               <div class="text-start">
                  Balance
                  <div class="diem d-flex">
                     <span class="epoint"><?php
                                          $balance = round($this->member->curent + $this->member->available, 2);
                                          echo $balance;
                                          ?></span>
                     <span class="ttusd align-self-center">USD
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="T_-OwGeVQ2tvt69C7mvbY css-4k7dfu">
                           <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>

                     </span>
                  </div>

               </div>
            </div>
         </div>


         <div class="row  row-cols-1 row-cols-sm-1 row-cols-md-4 balance" style="margin-top: auto;">
            <div class="col">
               <span class="text-warning">
                  Balance
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD <?php echo $balance; ?>
                  </div>

               </div>

            </div>
            <div class="col">
               <span class="text-warning">
                  Hold
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD <?php echo round($this->member->curent, 2); ?>
                  </div>

               </div>

            </div>
            <div class="col">
               <span class="text-warning">
                  Available
               </span>
               <div class="blance_c">
                  <div class="blan_usd">
                     USD<b> <?php echo round($this->member->available, 2); ?></b>
                  </div>
               </div>
            </div>
            <div class="col">
               <?php
               if (floatval($this->pub_config['minpay']) > floatval($this->member->available)) {
                  echo '<button style="margin-top:5px" class="btn btn btn-primary btn-sm" disabled>Withdraw</button>';
               } else {
                  echo '<a href="' . base_url('v2/payments') . '" style="margin-top:5px" class="btn btn btn-success btn-sm" disabled>Withdraw</a>';
               }
               ?>

            </div>



         </div>
      </div>
   </div>

   <div class="col-xl-6 col-lg-12 vien">
      <div class="card" style="height: 100%;">
         <div class="card-header text-uppercase">
            Statistics for the last 10 days
         </div>
         <div class="card-body">

            <canvas id="myChart" style="height:100hv"></canvas>
            <div id="my-legend-con"></div>

         </div>
      </div>

   </div>

</div>
<!-- Search -->
<form method="POST" action="<?php echo base_url('v2/offers/search'); ?>">
  <div class="aff-hero" style="background-image: url('https://i.postimg.cc/mDJ2thjN/skin.png'); background-size:cover; background-position:center;">
    <div class="aff-hero-inner">
      <div class="aff-search">
        <h3 class="aff-hero-title">Find the perfect freelance services for your business</h3>
        <p class="aff-hero-sub">Search by offer name, vertical, brand, or keyword.</p>

        <div class="aff-input-group">
          <input
            type="search"
            name="oName"
            class="aff-input"
            placeholder="Search offers…"
            aria-label="Search offers"
          />
          <button type="submit" class="aff-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
            Search
          </button>
        </div>

        <!-- optional chips -->
        <div class="aff-chips">
          <span class="aff-chip">🔥 Top CPS</span>
          <span class="aff-chip">🌍 Worldwide</span>
          <span class="aff-chip">⚡ Fast approval</span>
          <span class="aff-chip">💰 High payout</span>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Sale Rewards Ranking -->
<?php include 'components/reward_ranking.php'; ?>
<!-- Product categories -->
<?php include 'components/partners.php'; ?>
<!-- New Product -->
<?php include 'components/new_active_product.php'; ?>


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

<script src="<?php echo base_url(); ?>temp/default/js/chart.js"></script>
<?php
//tạo data cho chart
$lb = $click = $lead = $reve = '';
if ($chart) {
   foreach ($chart as $chart) {
      $lb[]    = $chart->dayli;
      $click[] = $chart->click;
      $lead[]  = $chart->lead;
      $reve[]  = $chart->reve;
   }
   $lb    = '\'' . implode("','", $lb) . '\'';
   $click = implode(",", $click);
   $lead  = implode(",", $lead);
   $reve  = implode(",", $reve);
}

?>
<script>
   var ctx = document.getElementById('myChart');
   var config = {
      type: 'line',
      data: {
         labels: [<?php echo $lb; ?>],
         datasets: [{
               label: ' Conversions',
               data: [<?php echo $lead; ?>],
               backgroundColor: [
                  'rgba(255, 99, 132, 0.2)'
               ],
               borderColor: [
                  'rgba(255, 99, 132, 1)'
               ],
               borderWidth: 1,
               tension: 0.4,
            },
            {
               label: ' Clicks',
               data: [<?php echo $click; ?>],
               backgroundColor: [
                  'rgb(61, 118, 185,0.2)'
               ],
               borderColor: [
                  'rgb(61, 118, 185,1)'
               ],
               borderWidth: 1,
               tension: 0.4,
            },
            {
               label: ' Revenue',
               data: [<?php echo $reve; ?>],
               backgroundColor: [
                  'rgb(191 189 19,0.2)'
               ],
               borderColor: [
                  'rgb(191 189 19),1'
               ],
               borderWidth: 1,
               tension: 0.4,
            }
         ]
      },
      options: {
         maintainAspectRatio: false,
         interaction: {
            intersect: false,
            mode: 'index',
         },
         scales: {
            y: {
               beginAtZero: true
            }
         },
         plugins: {
            legend: {
               position: 'bottom',
               labels: {
                  usePointStyle: true,
                  pointStyle: "line"
               },

            }
         }
      }
   }

   var myChart = new Chart(ctx, config);
</script>