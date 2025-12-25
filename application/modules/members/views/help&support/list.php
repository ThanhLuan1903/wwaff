<link href="<?php echo base_url(); ?>/temp/default/css/nhap.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<div class="modal fade" id="modalRequestSupport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Request Support</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="form" novalidate method="POST"
                    action="<?php echo base_url($this->uri->segment(1) . '/help_and_support/add'); ?>">
                    <div class="mb-2">
                        <label for="input1" class="form-label">Name</label>
                        <input class="form-control" id="input1" name="name" type="text" maxlength="100" required>
                        <div class="invalid-feedback" id="error_name"></div>
                    </div>
                    <div class="mb-2">
                        <label for="input1" class="form-label">Email</label>
                        <input class="form-control" id="input1" name="email" type="email" maxlength="100" required
                            value="<?php echo $user->email; ?>" readonly>
                        <div class="invalid-feedback" id="error_email"></div>
                    </div>
                    <div class="mb-2">
                        <label for="input2" class="form-label">Title</label>
                        <input class="form-control" id="input2" name="title" type="text" maxlength="255" required>
                        <div class="invalid-feedback" id="error_title"></div>
                    </div>
                    <div class="mb-2">
                        <label for="input2" class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="editor"></textarea>
                        <div class="invalid-feedback" id="error_content"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-cus close" data-bs-dismiss="modal">
                    <span class="btn-text">Close</span>
                </button>
                <button class="btn-cus" id="submit_form">
                    <span class="btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </span>
                    <span class="btn-text">SEND</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="mt-5 mb-4" id="product_wrapper">
    <div class="sc-dlyikq hrvHfq ">
        <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV" id="name_title">Help and
            support</span>
        <div class="_1haMCIeKQlOTIl_pWtBGbw _1ye-KTmlb5GAdCMzA76WiG">
            <div class="css-15tqd4u hfK7mk6VgJGa8JX5PvVeJ hide_mobile">
                <div class="_3eOZ58qg6Kp88DgJr1zNp_">
                    <div class="tab_header tab_header_active">
                        <a class="tab_link" href="#">List</a>
                    </div>
                </div>
            </div>
            <!---content tab-->
            <div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent profile">
                <div class="d-flex justify-content-end w-100 mb-2">
                    <button class="btn-cus" data-bs-toggle="modal" data-bs-target="#modalRequestSupport">
                        <span class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 448 512"
                                fill="#fff">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>

                        </span>
                        <span class="btn-text">New Support</span>
                    </button>
                </div>
                <table class="table table-striped table-center  table-bordered">
                    <thead>
                        <tr style="background:#cdcdcd">
                            <th scope="col" style="width: 50px">ID</th>
                            <th scope="col" style="width: 200px">Name</th>
                            <th scope="col" style="width: 200px">Email</th>
                            <th scope="col">Title</th>
                            <th scope="col" style="width: 150px">Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)) { ?><tr>
                                <td colspan="5" class="text-center">No Data.</td>
                            </tr> <?php } ?>
                        <?php
                        foreach ($data as $dt) {
                        ?>
                            <tr>
                                <th scope="row">
                                    <a
                                        href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"><?php echo $dt->id ?></a>
                                </th>
                                <td><?php echo $dt->name; ?></td>
                                <td><?php echo $dt->email; ?></td>
                                <td>
                                    <a
                                        href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"><?php echo $dt->title ?></a>
                                </td>
                                <td><?php echo $dt->updated_at; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if (!empty($data)) { ?>
                    <div class="d-flex justify-content-center w-100">
                        <!-- Pagination -->
                        <nav aria-label="Page navigation example mt-5">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if ($pagination['page'] <= 1) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <a class="page-link"
                                        href="<?php if ($pagination['page'] <= 1) {
                                                    echo '#';
                                                } else {
                                                    echo $pagination['prev_link'];
                                                } ?>">&lt;
                                        prev</a>
                                </li>
                                <?php for ($i = 1; $i <= $pagination['total_page']; $i++): ?>
                                    <li class="page-item <?php if ($pagination['page'] == $i) {
                                                                echo 'active';
                                                            } ?>">
                                        <a class="page-link" href="<?php echo $pagination['base_link'] . '/' . $i ?>"> <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <li
                                    class="page-item <?php if ($pagination['page'] >= $pagination['total_page']) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <a class="page-link"
                                        href="<?php if ($pagination['page'] >= $pagination['total_page']) {
                                                    echo '#';
                                                } else {
                                                    echo $pagination['next_link'];
                                                } ?>">next
                                        &gt;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
            </div>

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
                    '-',
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
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate',
                        '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi',
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
        })
        .catch(error => {
            console.error(error);
        });
    $(document).ready(function() {
        $('#modalRequestSupport').modal({
            focus: false,
        });
    })
    $("#submit_form").on('click', submit)
    $('#modalRequestSupport').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        resetErr();
    })
    const addClassToFormControl = (classStr, name) => {
        if (!$(`.form-control[name='${name}']`).hasClass(classStr)) {
            $(`.form-control[name='${name}']`).addClass(classStr);
        }
    }
    const removeClassFromFormControl = (classStr, name) => {
        $(`.form-control[name='${name}']`).removeClass(classStr);
    }

    function resetErr() {
        ['name', 'title', 'email', 'content'].forEach(name => {
            $(`.form-control[name='${name}']`).removeClass('is-valid');
            $(`.form-control[name='${name}']`).removeClass('is-invalid');
            $(`#form #error_${name}`).html('');
        })
    }

    function submit() {
        $("#submit_form").attr('disabled', true);
        const form = $("#form")
        const url = form.attr('action')
        const formData = new FormData();
        ['name', 'email', 'title', 'content'].forEach(key => {
            if (key === 'content') {
                formData.append('content', editor.getData());
            } else {
                formData.append(key, $(`[name='${key}']`).val());
            }
        })
        resetErr();
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
                    Object.keys(errors).forEach((key) => {
                        if (errors[key]) {
                            $("#form #error_" + key).html(errors[key])
                            addClassToFormControl('is-invalid', key)
                        } else {
                            $("#form #error_" + key).html('')
                            removeClassFromFormControl('is-invalid', key)
                            addClassToFormControl('is-valid', key)
                        }
                    })
                } else {
                    window.location.reload();
                }
                $("#submit_form").attr('disabled', false);
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
                $("#submit_form").attr('disabled', false);
            }
        });
    }
</script>