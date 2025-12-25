<script>
   var page = 0; 
   var is_more_data = true;
   var is_process_running = false;

   const lazy_load = () => {
      $('#loading-section').hide();

      $('div').scroll(function() {
         if (($(this).scrollTop()) >= $(document).height() * page * 1.4) {
            if (!is_process_running) {
               is_process_running = true;
               page++;

               if (is_more_data) {
                  $('#loading-section').show();
                  load_more_data(page);
               }
            }
         }
      })
      const load_more_data = (page) => {
         const current_path = window.location.pathname
         const url = current_path.endsWith('\/') ? `${current_path}${page}` : `${current_path}/?page=${page}`;
         $.ajax({
            type: 'GET',
            url,
            success: function(response) {
               $('#loading-section').remove()
               $('#list_publishers').append(response);
            },
            complete: function(response) {
               is_process_running = false;

               $('.tag-text-pay').click(function() {
                  // var data = $('.chosen-select3').val();
                  var data = [$(this).attr('value')];
                  var name = $(this).attr('name');
                  ajaxFilterO(data, name);
               })
               $('.tag-text-cat').click(function() {
                  // var data = $('.chosen-select3').val();
                  var data = [$(this).attr('value')];
                  var name = $(this).attr('name');
                  ajaxFilterO(data, name);
               })

               rating_publisher();
            }
         })
      }
   }

   function ajaxFilter(name, value) {
      $.ajax({
         type: "GET",
         url: '<?= base_url('v2/publishers/search') ?>',
         data: {
            value,
            name
         },
         success: function(response) {
            location.reload();
         }
      })
   }

   function handle_click() {
      $('.handle_click').click(function() {
         const isActivated = $(this).hasClass('is_activated');
         const value = isActivated ? '' : $(this).data('id');
         const name = $(this).data('name');
         ajaxFilter(name, value);
      })
   }

   function rating_publisher() {
      $(".rating").click(function() {
         event.preventDefault();
         const publisher_id = $(this).data('id');
         const rating = $(this).data('rating')

         $.ajax({
            type: 'POST',
            url: '<?= base_url('v2/publishers/rating') ?>',
            data: {
               publisher_id,
               rating
            },
            success: function(data) {}
         })
      })
   }

   $(document).ready(function() {
      lazy_load();
      handle_click();
      rating_publisher();

      $('.card-offers-sinput').focusin(function() {
         $('.nut').text('Enter');
         $('.nut').addClass('focus-input-span');
         $('.card-offers-sboxs').addClass('focus-input');
      })
      $('.card-offers-sinput').focusout(function() {
         $('.nut').text('/');
         $('.nut').removeClass('focus-input-span');
         $('.card-offers-sboxs').removeClass('focus-input');

         const value = $(this).val();
         const name = 'search_input';
         ajaxFilter(name, value);
      });

      $('.chosen-select').select2({
         theme: "classic",
         width: '100%'
      });
      $('.chosen-select2').select2({
         theme: "classic",
         width: '100%'
      });
      $('.chosen-select3').select2({
         theme: "classic",
         width: '100%'
      });
      $('.chosen-select-types').select2({
         theme: "classic",
         width: '100%'
      });

      $('.filteroff').change(function() {
         var name = $(this).attr('name');
         var value = $(this).val();
         ajaxFilter(name, value);
      });

      $('.sort-option li').click(function() {
         const value = $(this).data('type');
         const name = `sort-by-${$(this).data('sort')}`;
         ajaxFilter(name, value)
      })
   })
</script>