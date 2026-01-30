<style>
  .section-head{
    display:flex; 
    align-items:center; 
    justify-content:space-between;
    margin: 10px 0 10px;
  }
  .section-title{
    font-weight:800; 
    letter-spacing:.3px;
    display: inline-block; 
    padding:10px 16px;
    border-radius:8px 8px 0px 0px;
    border: 1px solid rgba(0,0,0,.08);
    background:#fff;
    position:relative;
  }
  .section-title:after{
    content:""; 
    position:absolute; 
    left:0; bottom:-2px; 
    height:3px; 
    width:100%;
    background: linear-gradient(90deg, #f3b61d, #FFDF00);
    border-radius:0 0 8px 8px;
  }
  .track-wrap{
    overflow:hidden;
    border-radius:10px;
  }

   .track{
      display:flex; gap:14px;
      width:max-content;
      animation: scrollX var(--marquee-duration, 42s) linear infinite;
      will-change: transform;
   }
   .track-wrap:hover .track{ animation-play-state: paused; }

   @keyframes scrollX{
      0%{ transform: translateX(0); }
      100%{ transform: translateX(calc(-1 * var(--marquee-distance, 40%))); }
   }

   .track.no-animate{
      animation: none !important;
      transform: none !important;
   }

  .p-card{
    width: 320px;
    background:#fff;
    border-radius:10px;
    border:1px solid rgba(0,0,0,.08);
    overflow:hidden;
   }
  .p-thumb{
    height:160px; background:#f3f4f6;
   }
  .p-thumb img{
    width:100%; height:100%; object-fit:cover;
    display:block;
   }
  .p-body{
      padding:10px !important;
      flex-direction:column;
   }

   .p-action{
      margin-top:auto;             
      display:flex;
      flex-direction:row;
      align-items:center;           
      gap:10px;                    
      padding-bottom:6px; 
      justify-content:space-between;         
   }

   .p-sub{
      color:#6b7280;
      font-size:13px;
      margin:0;                  
      display:-webkit-box;
      -webkit-line-clamp:2;
      -webkit-box-orient:vertical;
      overflow:hidden;
      text-align:center;
   }

   .p-btn{
      width: 120px;                 
      flex:0 0 120px;           
      text-align:center;
      border: 1px solid #ffdf00;
      color: #FFDF00;
      background: #fff;
      border-radius:8px;
      padding: 8px 10px;
      font-weight:700;
      text-decoration:none;
      transition: transform 0.2s ease, background 0.2s ease;
   }
   .p-btn:hover{
      border: none;
      background: #FFDF00;
      color: #000;
      transform: scale(1.1);
   }

   .p-title {
      font-weight: 700;
      font-size: 16px;
      margin-bottom: 8px;
      display: -webkit-box;
      -webkit-line-clamp: 2;     
      -webkit-box-orient: vertical;
      overflow: hidden;
   }

</style>
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

<?php include __DIR__ . '/../components/reward_ranking.php'; ?>

<?php
function render_slider($title, $offers) {
  if (!$offers) return;
  $title = trim((string)$title);
?>
  <div class="mb-4">
    <?php if ($title !== ''): ?>
      <div class="section-head">
        <div class="section-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></div>
      </div>
    <?php endif; ?>

    <div class="track-wrap">
      <div class="track js-marquee" data-count="<?php echo (int)count($offers); ?>">
        <?php foreach($offers as $offer): ?>
          <div class="p-card">
            <div class="p-thumb">
              <img src="<?php echo $offer->img; ?>" alt="<?php echo $offer->title ?>">
            </div>
            <div class="p-body">
               <div class="p-title">
                  (<?php echo $offer->id; ?>) <?php echo $offer->title; ?>
               </div>

               <div class="p-action">
                  <div class="p-sub">
                     <?php echo $offer->convert_on; ?>
                  </div>
                  <a href="javascript:void(0)"
                     class="p-btn"
                     data-bs-toggle="modal"
                     data-bs-target="#sliderOfferModal<?php echo (int)$offer->id; ?>">
                     Get link
                  </a>
               </div>
            </div>
          </div>
        <?php endforeach; ?>

        <?php foreach($offers as $offer): ?>
          <div class="p-card">
            <div class="p-thumb">
              <img src="<?php echo $offer->img; ?>" alt="<?php echo $offer->title ?>">
            </div>
            <div class="p-body">
               <div class="p-title">
                  (<?php echo $offer->id; ?>) <?php echo $offer->title; ?>
               </div>

               <div class="p-action">
                  <div class="p-sub">
                     <?php echo $offer->convert_on; ?>
                  </div>
                  <a href="javascript:void(0)"
                     class="p-btn"
                     data-bs-toggle="modal"
                     data-bs-target="#sliderOfferModal<?php echo (int)$offer->id; ?>">
                     Get link
                  </a>
               </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php } ?>

<!-- hanle show list product -->
<?php
$sliderModalOffers = array();

if (!empty($topoffers)) {
  foreach ($topoffers as $o) {
    $sliderModalOffers[(int)$o->id] = $o;
  }
}

if (!empty($newoffers)) {
  foreach ($newoffers as $o) {
    $sliderModalOffers[(int)$o->id] = $o;
  }
}

if (!empty($catSections)) {
  foreach ($catSections as $catId => $offers) {
    if (!$offers) continue;
    foreach ($offers as $o) {
      $sliderModalOffers[(int)$o->id] = $o;
    }
  }
}
?>

<?php
render_slider('Top Products', $topoffers);
render_slider('New Products', $newoffers);
?>

<?php if (!empty($catSections)): ?>
  <div class="mb-4">
    <div class="section-head">
      <div class="section-title">Your Category</div>
    </div>

    <ul class="nav nav-tabs" id="catTabs" role="tablist" style="margin-bottom:12px;">
      <?php $i = 0; foreach ($catSections as $catId => $offers): ?>
        <?php if (empty($offers)) continue; ?>
        <?php
          $i++;
          $active = ($i === 1) ? 'active' : '';
          $selected = ($i === 1) ? 'true' : 'false';
          $tabId = 'cat-tab-' . (int)$catId;
          $paneId = 'cat-pane-' . (int)$catId;

          $tabName = !empty($catNames[(int)$catId]) ? $catNames[(int)$catId] : ('Category #' . (int)$catId);
        ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link <?php echo $active; ?>"
                  id="<?php echo $tabId; ?>"
                  data-bs-toggle="tab"
                  data-bs-target="#<?php echo $paneId; ?>"
                  type="button"
                  role="tab"
                  aria-controls="<?php echo $paneId; ?>"
                  aria-selected="<?php echo $selected; ?>">
            <?php echo htmlspecialchars($tabName, ENT_QUOTES, 'UTF-8'); ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="tab-content" id="catTabsContent">
      <?php $j = 0; foreach ($catSections as $catId => $offers): ?>
        <?php if (empty($offers)) continue; ?>
        <?php
          $j++;
          $activePane = ($j === 1) ? 'show active' : '';
          $paneId = 'cat-pane-' . (int)$catId;
        ?>
        <div class="tab-pane fade <?php echo $activePane; ?>"
             id="<?php echo $paneId; ?>"
             role="tabpanel"
             aria-labelledby="<?php echo 'cat-tab-' . (int)$catId; ?>">

          <?php
            render_slider('', $offers);
          ?>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>


<?php if (!empty($sliderModalOffers)): ?>
  <?php foreach ($sliderModalOffers as $offer): ?>
    <div class="modal fade"
         id="sliderOfferModal<?php echo (int)$offer->id; ?>"
         tabindex="-1"
         aria-labelledby="sliderOfferModalLabel<?php echo (int)$offer->id; ?>"
         aria-hidden="true"
         style="margin-top: 2.8rem;">
      <div class="modal-dialog modal-xl">
        <div class="modal-content mb-5">
          <div class="m-3">
            <?php include dirname(__FILE__) . '/../offers/campaign_view.php'; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
<!-- end handle show list product -->
<?php include __DIR__ . '/../components/partners.php'; ?>

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
<script>
(function(){
  var SPEED = 50;

  function setup(track){
    if (!track) return;

    var count = parseInt(track.getAttribute('data-count') || '0', 10);

    if (count <= 4){
      track.classList.add('no-animate');
      track.style.removeProperty('--marquee-distance');
      track.style.removeProperty('--marquee-duration');
      return;
    } else {
      track.classList.remove('no-animate');
    }

    var half = track.scrollWidth / 2;
    if (!half || half <= 0){
      return;
    }

    var duration = Math.max(10, Math.round(half / SPEED));
    track.style.setProperty('--marquee-distance', half + 'px');
    track.style.setProperty('--marquee-duration', duration + 's');
  }

  function setupAllVisible(){
    var tracks = document.querySelectorAll('.js-marquee');
    for (var i=0;i<tracks.length;i++){
      var rect = tracks[i].getBoundingClientRect();
      if (rect.width > 0) setup(tracks[i]);
    }
  }

  function setupInPane(pane){
    if (!pane) return;
    var tracks = pane.querySelectorAll('.js-marquee');
    for (var i=0;i<tracks.length;i++) setup(tracks[i]);
  }

  function init(){
    setupAllVisible();

    document.addEventListener('shown.bs.tab', function(e){
      var targetSel = e.target && e.target.getAttribute('data-bs-target');
      if (!targetSel) return;
      var pane = document.querySelector(targetSel);
      setupInPane(pane);
    });

    window.addEventListener('resize', function(){
      setupAllVisible();
    });
  }

  if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>