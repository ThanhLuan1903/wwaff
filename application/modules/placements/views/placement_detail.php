<?php $advertiser_id = $this->session->userdata('user')->id;
$is_depends = true ?>
<link href="<?php echo base_url(); ?>/temp/default/css/custom.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/ckeditor5-build-classic-base64-upload-adapter@1.0.1/build/ckeditor.min.js"></script>
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>

<style>
  .full-width {
    display: flex;
    justify-content: space-between;
  }

  .custom-container {
    width: 70%;
  }

  .sticky-banners {
    padding-top: 40px;
    height: 300px;
    width: 200px;
    top: 50px;
  }

  .custom-container {
    width: 70%;
  }

  .Active,
  .Approve {
    background: green
  }

  .Reject {
    background: red
  }

  .Pending {
    background: orange
  }

  .Pause {
    background: orange
  }
</style>

<div class="full-width">
  <div class="left-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($left_title->content, 0, 3) ?></h5>
      <h6 class="text-center"><?= substr($left_title->content, 4) ?></h5>
        <div class="row" style="margin-top:20px">
          <?php foreach ($left_banners as $banner) : ?>
            <a href="<?= $banner->link_page ?>" target="_blank">
              <div class="col-12 pb-3"><img src="<?= $banner->image_url ?>" width="100%"></div>
            </a>
          <?php endforeach; ?>
        </div>
  </div>
  <div class="custom-container">
    <div class="card mt-5"></div>
    <div class="row" id="list_offers">
      <div class="col-12 mt-3">
        <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
          <div class="box-offers-container d-block">
            <div class="box-offers-container">
              <div class="box-offers-detail">
                <span class="badge bg-success" style="font-size:14px">#TICKET NO.<?= $placement->id; ?></span>
                <br>
                <br>
                <span> OFFER NAME AUDIT: <?= $placement->title ?></span>
                <br>
                <br>
                <p>Placement detail for: <b><?= $placement->traffic_source; ?></b></p>
                <div class="box-offers-point mt-2 pt-2 d-flex">
                  <div class="comment mt-4">
                    <div id="editor"></div>
                    <div class="flex-justify-right mt-2">
                      <?php if ($this->session->userdata('role') == 1): ?>
                        <button class="btn-cus" id="reply" data-placement="<?= $placement->id ?>">
                          <span class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                          </span>
                          <span class="btn-text">SEND</span>
                        </button>
                      <?php endif; ?>
                      <?php if ($this->session->userdata('role') == 2): ?>
                        <a href="#" class="btn-send-request"
                          data-request="<?= $placement->request_id ?>"
                          data-publisher="<?= $placement->publisher_id ?>"
                          data-offer="<?= $placement->offer_id ?>"
                          data-placement_id="<?= $placement->id ?>">
                          <button class="btn_prv_link btn_prv_link_2">
                            <div class="btn_prv_link_2_child" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
                            <span class="btn_prv_link_2_child_span color_blue_nice">
                              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                              </svg>
                            </span>
                            <span class="btn_prv_link_2_child2 color_blue_nice">Request Again</span>
                          </button>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-offers-container">
              <table class="table table-bordered">
                <thead style="background:#cdcdcd">
                  <tr>
                    <th class="col-2">SENT</th>
                    <th class="col-10">CONTENT</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($placement_details as $detail): ?>
                    <tr>
                      <td><?= $placement->username ?> (<?= $detail->created_at ?> )</td>
                      <td style="max-width: 0px;overflow-x: scroll;"><?= $detail->note ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <br>
        </div>
        <div class="modal fade" id="modal-<?= $publisher->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 2.8rem;">
          <div class="modal-dialog modal-xl">
            <div class="modal-content mb-5">
              <div class="modal-header">
                <h5 class="modal-title">#<?= $publisher->id ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="right-banners sticky-banners">
    <h6 class="text-center" style="margin-botton:0px"><?= substr($right_title->content, 0, 3) ?></h6>
    <h6 class="text-center"><?= substr($right_title->content, 4) ?></h6>
    <div class="row" style="margin-top:20px">
      <?php foreach ($right_banners as $banner) : ?>
        <a href="<?= $banner->link_page ?>" target="_blank">
          <div class="col-12 pb-3"><img class="w-100" src="<?= $banner->image_url ?>"></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="position-fixed bottom-0 end-0 p-5 hide" style="z-index: 99999;">
    <div class="toast fade alert-info" role="alert" aria-live="assertive" aria-atomic="true" id="thongBao">
      <div class="toast-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <span id="toastContent">Copy to clipboard</span>
      </div>
    </div>
  </div>

</div>
<br><br><br>

<script>
  $(document).ready(function() {
    $('.order_wrap_list_items').on('click', function() {
      var urla = '<?php echo base_url('v2/smartlinks/ajorder'); ?>';
      $dt = $(this).attr('data-sort');
      $.ajax({
        type: "POST",
        url: urla,
        data: {
          data: $dt
        },
        success: function() {
          location.reload();
        }
      });
    })

  })
</script>

<script>
  let editor;
  ClassicEditor
    .create(document.querySelector('#editor'), {
      toolbar: {
        items: [
          'heading', '|',
          'bold', 'italic',
          'bulletedList', 'numberedList',
          'outdent', 'indent', '|',
          'undo', 'redo',
          'link', 'blockQuote', 'insertTable', 'imageUpload', '|',
        ],
        shouldNotGroupWhenFull: true
      },
      image: {
        toolbar: [
          'imageStyle:full',
          'imageStyle:side',
          '|',
          'imageTextAlternative'
        ]

      },
      // Changing the language of the interface requires loading the language file using the <script> tag.
      // language: 'es',
      list: {
        properties: {
          styles: true,
          startIndex: true,
          reversed: true
        }
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
      heading: {
        options: [{
            model: 'paragraph',
            title: 'Paragraph',
            class: 'ck-heading_paragraph'
          },
          {
            model: 'heading1',
            view: 'h1',
            title: 'Heading 1',
            class: 'ck-heading_heading1'
          },
          {
            model: 'heading2',
            view: 'h2',
            title: 'Heading 2',
            class: 'ck-heading_heading2'
          },
          {
            model: 'heading3',
            view: 'h3',
            title: 'Heading 3',
            class: 'ck-heading_heading3'
          },
          {
            model: 'heading4',
            view: 'h4',
            title: 'Heading 4',
            class: 'ck-heading_heading4'
          },
          {
            model: 'heading5',
            view: 'h5',
            title: 'Heading 5',
            class: 'ck-heading_heading5'
          },
          {
            model: 'heading6',
            view: 'h6',
            title: 'Heading 6',
            class: 'ck-heading_heading6'
          }
        ]
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
      placeholder: '',
      // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
      fontFamily: {
        options: [
          'default',
          'Arial, Helvetica, sans-serif',
          'Courier New, Courier, monospace',
          'Georgia, serif',
          'Lucida Sans Unicode, Lucida Grande, sans-serif',
          'Tahoma, Geneva, sans-serif',
          'Times New Roman, Times, serif',
          'Trebuchet MS, Helvetica, sans-serif',
          'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
      fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
      },
      // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
      // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
      htmlSupport: {
        allow: [{
          name: /.*/,
          attributes: true,
          classes: true,
          styles: true
        }]
      },
      // Be careful with enabling previews
      // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
      htmlEmbed: {
        showPreviews: true
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
      link: {
        decorators: {
          addTargetToExternalLinks: true,
          defaultProtocol: 'https://',
          toggleDownloadable: {
            mode: 'manual',
            label: 'Downloadable',
            attributes: {
              download: 'file'
            }
          }
        }
      },
      // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
      mention: {
        feeds: [{
          marker: '@',
          feed: [
            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
            '@chocolate',
            '@cookie', '@cotton', '@cream',
            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
            '@gummi',
            '@ice', '@jelly-o',
            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
            '@sesame', '@snaps', '@soufflé',
            '@sugar', '@sweet', '@topping', '@wafer'
          ],
          minimumCharacters: 1
        }]
      },
      // The "super-build" contains more premium features that require additional configuration, disable them below.
      // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.

    })
    .then(newEditor => {
      editor = newEditor;
      editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
        if (!isFocused) {
          const content = editor.getData()
          if (!content.length) {
            $("#reply").attr('disabled', true);
          } else {
            $("#reply").attr('disabled', false);
          }
        }
      });

      editor.image.on('fileUploadResponse', function(event) {
        alert('hello');
      });
    })
    .catch(error => {
      console.error(error);
    });

  $(document).ready(function() {
    $("#reply").on('click', submit);
    handle_check_button();
    handle_send_button();
    send_request();
  })
  let offset = 2;

  function submit() {
    $("#reply").attr('disabled', true);
    const url = $("#reply").attr('action');
    const content = editor.getData();
    const formData = new FormData();
    formData.append('content', content);
    if (!content.length) return $("#reply").attr('disabled', false);
    $.ajax({
      url: url,
      type: "Post",
      data: formData,
      async: true,
      contentType: false,
      processData: false,
      cache: false,
      success: function(data) {
        const res = data && JSON.parse(data);
        if (res['error'] == true) {
          const errors = res.data
          alert(errors.content);
        } else {
          window.location.reload();

        }
        $("#reply").attr('disabled', false);
      },
      error: function(xhr, exception) {
        var msg = "";
        if (xhr.status === 0) {
          msg = "Not connect.\n Verify Network." + xhr.responseText;
        } else if (xhr.status == 404) {
          msg = "Requested page not found. [404]" + xhr.responseText;
        } else if (xhr.status == 500) {
          msg = "Internal Server Error [500]." + xhr.responseText;
        } else if (exception === "parsererror") {
          msg = "Requested JSON parse failed.";
        } else if (exception === "timeout") {
          msg = "Time out error." + xhr.responseText;
        } else if (exception === "abort") {
          msg = "Ajax request aborted.";
        } else {
          msg = "Error:" + xhr.status + " " + xhr.responseText;
        }
        $("#reply").attr('disabled', false);
      }
    });
  }

  document.querySelectorAll('oembed[url]').forEach(element => {

    const anchor = document.createElement('a');

    anchor.setAttribute('href', element.getAttribute('url'));
    anchor.className = 'embedly-card';

    element.appendChild(anchor);
  });

  function handle_send_button() {
    $('#reply').click(function() {
      event.preventDefault();
      const id = $(this).data('placement');
      const note = editor.getData();

      $.ajax({
        method: "POST",
        url: `<?= base_url() ?>v2/placements/update`,
        data: {
          id,
          note
        },
        success: function(response) {
          location.reload();
        },
        error: function(err) {}
      })
    })
  }

  function handle_check_button() {
    $('#check-action').click(function() {
      event.preventDefault();
      const id = $(this).data('placement');

      $.ajax({
        method: "POST",
        url: `<?= base_url() ?>v2/placements/update`,
        data: {
          id
        },
        success: function(response) {
          location.reload();
        },
        error: function(err) {}
      })
    })
  }

  const send_request = () => {
    $('.btn-send-request').click(function() {
      const request_id = $(this).data('request');
      const offer_id = $(this).data('offer');
      const publisher_id = $(this).data('publisher');
      const placement_id = $(this).data('placement_id');
      const re_request = 1;

      $.ajax({
        method: "POST",
        url: `<?= base_url() ?>v2/placements/send-request`,
        data: {
          request_id,
          offer_id,
          publisher_id,
          placement_id,
          re_request
        },
        success: function(response) {
          location.href = `<?= base_url('v2/placements')  ?>`;
        }
      })
    });
  }
</script>