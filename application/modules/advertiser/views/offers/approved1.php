<?php
if ($offer->smtype == 2) {
   $url = base_url('smartoffer?pid=' . $this->member->id . '&smid=' . $offer->id);
} elseif ($offer->smtype == 2) {
   $url = base_url('smartlink?pid=' . $this->member->id . '&smid=' . $offer->id);
} else {
   $url = base_url('click?pid=' . $this->member->id . '&offer_id=' . $offer->id);
}
?>
<div class="row track_link_info">
   <div class="track_link">
      <div class="track_link_label d-flex justify-content-between mt-3">
         <p class="vcampaign_left_information">Tracking link</p>
         <a target="_blank" style="color:rgb(131, 131, 131)" href="https://affise.zendesk.com/hc/en-us/sections/201683795">Trackers integration</a>
      </div>
      <div class="input-group mb-3">
         <span class="input-group-text coppy_dt">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
               <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
               <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
         </span>
         <input type="text" id="tracklink" class="form-control" value="<?php echo $url; ?>" disabled>
         <input id="base_tracklink" type="hidden" class="form-control" value="<?php echo $url; ?>" disabled>

         <span class="input-group-text"> SSL </span>
      </div>
   </div>

   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label">Sub 1</label>
      <input type="text" class="form-control sub1 sub_input" />
   </div>
   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label">Sub 2</label>
      <input type="text" class="form-control sub2 sub_input" />
   </div>
   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label sub3">Sub 3</label>
      <input type="text" class="form-control sub3 sub_input" />
   </div>
   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label">Sub 4</label>
      <input type="text" class="form-control sub4 sub_input" />
   </div>
   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label">Sub 5</label>
      <input type="text" class="form-control sub5 sub_input" />
   </div>
   <div class="mb-1 col-md-4 col-sm-6 track_subid">
      <label class="form-label">Sub 6</label>
      <input type="text" class="form-control sub6 sub_input" />
   </div>

</div>

<script>
   $(document).ready(function() {
      var base_tracklink = $('#base_tracklink').val();
      $('.coppy_dt').on('click', function() {
         coppy_track();
      })

      $(".sub_input").keyup(function(event) {
         var duoi = base_tracklink;
         $(".sub_input").each(function(index) {
            if ($(this).val())
               duoi += "&sub" + (index + 1) + "=" + $(this).val();

         });
         $('#tracklink').val(duoi);


      });

      const unsecuredCopyToClipboard = (data) => {
         var $temp = $("<input>");
         $("body").append($temp);
         $temp.val(data).focus().select();
         $temp.remove();
      };


      const copyToClipboard = (data) => {
         if (window.isSecureContext && navigator.clipboard) {
            navigator.clipboard.writeText(data);
         } else {
            unsecuredCopyToClipboard(data);
         }
      };

      function coppy_track() {
         var data = $('#tracklink').val();
         var myAlert = document.getElementById('thongBao');
         var bsAlert = new bootstrap.Toast(myAlert, {
            animation: true,
            delay: 2000,
            autohide: true
         });
         copyToClipboard(data);
         bsAlert.show();
      }
   });
</script>
<style>
   .input-group-text {
      background: #fff
   }

   .coppy_dt {
      cursor: pointer
   }
</style>