<!-- Modal -->
<link href="<?php echo base_url(); ?>/temp/default/css/nhap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/temp/default/css/custom.css" rel="stylesheet">
<div class="modal fade" id="modalAddNewRequest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Request a product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="form" novalidate method="POST" enctype="multipart/form-data"
                    action="<?php echo base_url($this->uri->segment(1) . '/request_products/add'); ?>">
                    <div class="mb-2">
                        <label for="input1" class="form-label">Name</label>
                        <input class="form-control" id="input1" name="name" type="text" maxlength="255" required>
                        <div class="invalid-feedback" id="error_name"></div>
                    </div>
                    <div class="mb-2">
                        <label for="input2" class="form-label">Preview Link</label>
                        <input class="form-control" id="input2" name="preview_link" type="text" maxlength="255"
                            required>
                        <div class="invalid-feedback" id="error_preview_link"></div>
                    </div>
                    <div class="mb-2">
                        <label for="input3" class="form-label">Payout</label>
                        <div class="input-group">
                            <input class="form-control" id="input3" name="payout" type="text" maxlength="11" required>
                            <span class="input-group-text">USD</span>
                            <div class="invalid-feedback" id="error_payout"></div>
                        </div>

                    </div>
                    <div class="mb-2">
                        <label for="formFileSm" class="form-label">Image URL</label>
                        <input class="form-control" id="input4" name="image_url" type="text" maxlength="255" required>
                        <img class="image-preview mt-3 " src="" class="img-thumbnail" alt="">
                        <div class="invalid-feedback" id="error_image_url"></div>
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
                    <span class="btn-text">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="mt-5 mb-4">

    <div class="sc-dlyikq hrvHfq ">
        <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV" id="name_title">Request a
            product</span>
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
                    <button class="btn-cus" data-bs-toggle="modal" data-bs-target="#modalAddNewRequest">
                        <span class="btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 448 512"
                                fill="#fff">
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>

                        </span>
                        <span class="btn-text">ADD</span>
                    </button>
                </div>
                <table class="table table-striped table-center">
                    <thead>
                        <tr style="border-top: 1px solid">
                            <th scope="col" style="width: 50px">#</th>
                            <th scope="col" style="width: 150px">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Preview Link</th>
                            <th scope="col" style="width: 150px">Payout</th>
                            <th scope="col" style="width: 100px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)) { ?><tr>
                                <td colspan="6" class="text-center">No Data.</td>
                            </tr> <?php } ?>
                        <?php
                        foreach ($data as $dt) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $dt->id; ?></th>
                                <td>
                                    <img src="<?php echo $dt->image_url; ?>" class="img-thumbnail product-img" alt="">
                                </td>
                                <td><?php echo $dt->name; ?></td>
                                <td>
                                    <a href="<?php echo $dt->preview_link ?>" target="_blank">
                                        <?php echo $dt->preview_link ?>
                                    </a>
                                </td>
                                <td><?php echo $dt->cust_payout; ?></td>
                                <td>
                                    <?php
                                    if ($dt->status == 1) {
                                        echo '<span class="status pending">Pending</span>';
                                    }
                                    if ($dt->status == 2) {
                                        echo '<span class="status unsuccessful">Unsuccessful</span>';
                                    }
                                    if ($dt->status == 3) {
                                        echo '<span class="status succeeded">Succeeded</span>';
                                    }
                                    ?>
                                </td>
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
    $('#modalAddNewRequest').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $(".image-preview").attr('src', '')
        $('.image-preview').css('display', 'none');
        resetErr();
    })

    $("#input3").keyup(function(event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
        });
    })

    $("#submit_form").on('click', submit)
    $('input[name="image_url"').on('blur', (e) => {
        const value = event.target.value;
        $(".image-preview").css('display', value ? 'block' : 'none')
        $(".image-preview").attr('src', value || '')
    });
    const addClassToFormControl = (classStr, name) => {
        if (!$(`.form-control[name='${name}']`).hasClass(classStr)) {
            $(`.form-control[name='${name}']`).addClass(classStr);
        }
    }
    const removeClassFromFormControl = (classStr, name) => {
        $(`.form-control[name='${name}']`).removeClass(classStr);
    }

    function validateTypeFile(type) {
        let allowedExtension = ['image/jpeg', 'image/jpg', 'image/png'];
        return allowedExtension.indexOf(type) > -1
    }

    function validateSizeFile(size) {
        const maxSize = 2 * 1024 * 1024;
        return size <= maxSize
    }

    function resetErr() {
        ['name', 'preview_link', 'payout', 'image_url'].forEach(name => {
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
        ['name', 'preview_link', 'payout', 'image_url'].forEach(key => {
            formData.append(key, $(`[name='${key}']`).val());
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