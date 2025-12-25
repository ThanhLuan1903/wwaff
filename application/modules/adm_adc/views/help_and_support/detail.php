<link href="<?php echo base_url(); ?>/temp/default/css/custom.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>

<style>
    .mt-2 {
        margin-top: 8px;
    }

    .flex-justify-right {
        display: flex;
        justify-content: right;
    }

    .table-center tbody tr td,
    .table-center tbody tr th {
        vertical-align: middle !important;
    }
</style>

<div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
    <input type="hidden" name="email" value="<?php echo '' ?>" />
    <div class="conversation_author">
        <span class="conversation_author--name">
            <?php echo $data->name ?>
        </span>
        <span class="conversation_author--email">
            <?php echo $data->email ?>
        </span>
    </div>
    <div class="conversation">
        <?= $data->content ?>
    </div>
    <?php if ($totalComment > 0) { ?>
        <div class="total-comment">
            <span><?php echo $totalComment . ' comments'; ?></span>
        </div>
    <?php } ?>

    <div id="comment_block" class=" w-100">
        <?php
        foreach ($comments as $dt) {
        ?>
            <div class="comment_views--list">
                <div class="comment_tile--block">
                    <div class="comment_tile--author">
                        <span class="comment_tile--author__name">
                            <?php echo $dt->email ?>
                        </span>
                        <span class="comment_tile--author__time">
                            <!-- 8 minutes ago -->
                            <?php echo timeAgo($dt->created_at) ?>
                        </span>
                    </div>
                    <div class="comment_tile--msg ck-content">
                        <?= $dt->content ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if ($totalComment > $perPage) { ?>
        <div class="d-flex justify-content-end mt-4 w-100">
            <a href="javascript:void(0)" id="btnViewMore"
                action="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $data->id . '/comments'); ?>">View
                more...</a>
        </div>
    <?php } ?>
    <div class="comment mt-4">
        <div id="editor"></div>
        <div class="flex-justify-right mt-2">
            <button class="btn-cus" id="reply" disabled
                action="<?php echo base_url($this->uri->segment(1) . '/help_and_support/reply/' . $data->id); ?>">
                <span class="btn-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </span>
                <span class="btn-text">Reply</span>
            </button>
        </div>
    </div>
</div>

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
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                ],
                shouldNotGroupWhenFull: true
            },
           
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },

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
            placeholder: '',
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
           
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            
            htmlEmbed: {
                showPreviews: true
            },
           
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
        })
        .catch(error => {
            console.error(error);
        });
    $(document).ready(function() {
        $("#reply").on('click', submit);
        $("#btnViewMore").on('click', viewMoreComment);
    })
    let offset = 2;

    function viewMoreComment() {
        const url = $("#btnViewMore").attr('action');
        $.ajax({
            url: url + "/" + offset,
            type: "Get",
            async: true,
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                const res = data && JSON.parse(data);
                const commentBlock = $("#comment_block")
                res.comments.forEach(i => {
                    const content = `
                <div class="comment_views--list">
                    <div class="comment_tile--block">
                        <div class="comment_tile--author">
                            <span class="comment_tile--author__name">
                                ${i.email}
                            </span>
                            <span class="comment_tile--author__time">
                                8 minutes ago
                            </span>
                        </div>
                        <div class="comment_tile--msg">
                            ${i.content}
                        </div>
                    </div>
                </div>`
                    commentBlock.append(content)
                })
                if (!res.can_next) {
                    $("#btnViewMore").css("display", "none");
                    return;
                }
                offset++;
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
        })
    }

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
</script>