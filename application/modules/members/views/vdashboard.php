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
   <div class="col-12 d-flex header">

      <div class="col-md-10 col-lg-8 col-xl-5 banner-input" style="margin-left:100px">
         <h3 style="font-family: cursive;">Find the perfect freelance services for your business </h3>
         <div class="card" style="border-radius: 0.5em;background: transparent">
            <div class="card-body p-2">
               <div class="input-group">
                  <input type="search" name="oName" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                  <button type="submit" style="color:gray;border-color:gray" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" style="color:gray" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                     </svg></button>

               </div>
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