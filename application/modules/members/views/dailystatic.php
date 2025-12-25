<div class=" db_info  p-4 d-flex flex-column card-daily-static">
   <div class="col card-daily-s  flex-shrink-0">
      <p class="card-daily-sname">Daily Statistics</p>
      <p class="card-daily-sdate mb-2"><?php echo date('F d, Y'); ?></p>
   </div>
   <div class="col row align-items-start flex-grow-1 staticdb">

      <div class="col-4 d-flex justify-content-center">
         <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->click) echo 'len'; ?>">
            <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
               <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
            </g>
         </svg>
         <div>
            <p class="card-daily-num"><?php if ($dayli_static->click) echo $dayli_static->click;
                                       else echo 0; ?></p>
            <p class="card-daily-num-type">Clicks</p>
         </div>
      </div>

      <div class="col-4 d-flex justify-content-center">
         <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->hosts) echo 'len'; ?>">
            <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
               <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
            </g>
         </svg>
         <div>
            <p class="card-daily-num"><?php if ($dayli_static->hosts) echo $dayli_static->hosts;
                                       else echo 0; ?></p>
            <p class="card-daily-num-type">Hosts</p>
         </div>
      </div>

      <div class="col-4 d-flex justify-content-center">
         <svg direction="down" width="15px" height="27px" viewBox="0 0 9 27" version="1.1" xmlns="http://www.w3.org/2000/svg" class="muiten <?php if ($dayli_static->lead) echo 'len'; ?>">
            <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
               <path direction="down" id="line" d="M5,0 L5,18 L9,18 L4.5,27 L-8.8817842e-16,18 L4,18 L4,0 L5,0 Z" fill-rule="nonzero" class="maumuiten"></path>
            </g>
         </svg>
         <div>
            <p class="card-daily-num"><?php if ($dayli_static->lead) echo $dayli_static->lead;
                                       else echo 0; ?></p>
            <p class="card-daily-num-type">Conversions</p>
         </div>
      </div>


   </div>

</div>