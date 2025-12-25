<div class="row  mt-5 " id="postback_container">
    <div class="col-12">
        <h3>Postbacks</h3>
        <div id="messenger">
            <?php
            if (form_error('postback') || $flash = $this->session->flashdata('success')) {

                if ($flash) echo '
                 <div class="alert alert-success" role="alert">
                    ' . $flash . '
                 </div>
                ';
                else
                    echo '
                  <div class="alert alert-danger" role="alert">
                     ' . form_error('postback') . '<br/>
                  </div>
                 ';
            }

            ?>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Transaction Notifications</b>
            </div>
            <div class="card-body" id="postbackData">
                <p>
                    Choose which transaction notifications you wish to receive and how you want to receive the data.
                    For
                    more information, please read the Transaction Notifications Success Center article.
                </p>
                <div class="row">
                    <?php
                    $tableData0 = ['clickid', 'commission', 'sale_amount', 'pub_id'];
                    $namePlace = ['Your Clickid', 'Your commission', 'Your Sale Amount'];
                    $tableData1 = ['view2', 'view3', 'view4', 'view5',];
                    $tableData2 = ['lead_date', 'click_date', 'click_url', 'lead_Geo', 'click_Geo', 'city', 'useragent', 'ip', 'device_And_os'];
                    ?>

                    <div class="col-sm-12 col-md-6">

                        <table class="table table-warning table-bordered">
                            <thead>

                            </thead>
                            <tbody id="formRequire">
                                <tr>
                                    <td colspan="2">
                                        <label class="form-label">Postback Name</label>
                                        <input name="title" class="form-control form-control-sm" type="text" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>Variable Name</th>
                                    <th>Value</th>
                                </tr>
                                <?php $this->load->view('postback/subview/tablePostbackParram', ['tableData' => $tableData0]); ?>

                            </tbody>
                        </table>

                        <table class="table table-success table-bordered">
                            <thead>
                                <tr>
                                    <th>Variable Name</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $this->load->view('postback/subview/tablePostbackParram', ['tableData' => $tableData1]); ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-sm-12 col-md-6">

                        <table class="table table-success table-bordered">
                            <thead>
                                <tr>
                                    <th>Variable Name</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $this->load->view('postback/subview/tablePostbackParram', ['tableData' => $tableData2]); ?>
                            </tbody>
                        </table>
                        <div class="row-12">
                            <button type="button" class="btn btn-primary btn-sm" id="save_data">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2z" />
                                    <path
                                        d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                                </svg>
                                Save
                            </button>
                        </div>



                    </div>
                    <hr />
                    <div class="col-12 row p-3">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Test Postback</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">Postback
                                    Logs</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent"
                            style="border-width:0px 1px 1px 1px;border-style: solid; border-color:#dee2e6">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 col-3">
                                            <label for="testOfferUrl" class="form-label">PostbackId</label>
                                            <select class="form-select" aria-label="Default select example"
                                                id="postbackId">

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="testOfferUrl" class="form-label">Your Offer</label>
                                            <input type="text" class="form-control" id="testOfferUrl"
                                                placeholder="https://exampleOffers.com?clickid={view}&pubid={pubid}&commission={commission}&sale_amount={sale_amount}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="testTrackLink" class="form-label">Test Url</label>
                                            <textarea class="form-control" id="testTrackLink" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <pre>
                                    <?php
                                    print_r($postback_logs);
                                    ?>
                                </pre>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>List Postbacks</b>
            </div>
            <div class="card-body" id="listPostback">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Url</th>
                            <th class="col text-end" style="width:160px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mt-2">
            <div class="card-header">
                <b>Parameter setting:</b>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {view}
                            </td>
                            <td>
                                Click/View identifier/reference specified by the Publisher.
                                <span class="text-warning">(Use to get publisher’s clickid)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {view2}
                            </td>
                            <td>
                                Click/View identifier/reference specified by the Publisher.
                                <span class="text-warning">(Use to get publisher's source id)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {view3}
                            </td>
                            <td>
                                Click/View identifier/reference specified by the Publisher.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {view4}
                            </td>
                            <td>
                                Click/View identifier/reference specified by the Publisher.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {view5}
                            </td>
                            <td>
                                Click/View identifier/reference specified by the Publisher.
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {lead_date}
                            </td>
                            <td>
                                Date and time of conversion committing in format %Y-%m-%d %H:%i:%s (timezone: UTC)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {click_date}
                            </td>
                            <td>
                                Date and time of click committing in format %Y-%m-%d %H:%i:%s (timezone: UTC)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {commission}
                            </td>
                            <td>
                                Commission amount awarded for the transaction
                                <span class="text-warning"> (Use to get product's payout)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {sale_amount}
                            </td>
                            <td>
                                Total sale amount in the currency of the Producer program
                                <span class="text-warning">(Use to get product’s sale amount)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {click_url}
                            </td>
                            <td>
                                Ad click locations are tracked using URL format
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {pub_id}
                            </td>
                            <td>
                                The Publisher ID associated to the transaction send via Postback <span
                                    class="text-warning">(Use to get wwaff's publisher ID)</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {lead_Geo}
                            </td>
                            <td>
                                The geographic location associated with the lead, sent via Postback.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {click_Geo}
                            </td>
                            <td>
                                The geographic location where the click occurred, sent via Postback.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {city}
                            </td>
                            <td>
                                The city associated with the transaction, sent via Postback
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {useragent}
                            </td>
                            <td>
                                The user agent string of the user's browser or device, sent via Postback.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {ip}
                            </td>
                            <td>
                                The IP address of the user, sent via Postback.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {device_And_os}
                            </td>
                            <td>
                                Information about the user's device and operating system, sent via Postback.
                            </td>
                        </tr>



                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<!-- Modal EDIT -->
<div class="modal fade" id="editPostback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Postbacks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-edit-postback">
                <table class="table table-warning table-bordered">
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <label class="form-label">Postback Name</label>
                                <input name="title" data-name="vpb" class="form-control form-control-sm" type="text" required="">
                            </td>
                        </tr>
                        <tr>
                            <th>Variable Name</th>
                            <th>Value</th>
                        </tr>

                        <tr>
                            <td>
                                <input value="clickid" name="pb_value[clickid][]" class="form-control form-control-sm"
                                    type="text" readonly="">
                            </td>
                            <td>
                                <input name="pb_value[clickid][]" data-name="vpb" class="form-control form-control-sm" type="text"
                                    placeholder="Ex: {clickid}">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input value="commission" name="pb_value[commission][]"
                                    class="form-control form-control-sm" type="text" readonly="">
                            </td>
                            <td>
                                <input name="pb_value[commission][]" data-name="vpb" class="form-control form-control-sm" type="text"
                                    placeholder="Ex: {commission}">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input value="sale_amount" name="pb_value[sale_amount][]"
                                    class="form-control form-control-sm" type="text" readonly="">
                            </td>
                            <td>
                                <input name="pb_value[sale_amount][]" data-name="vpb" class="form-control form-control-sm" type="text"
                                    placeholder="Ex: {sale_amount}">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input value="pub_id" name="pb_value[pub_id][]" class="form-control form-control-sm"
                                    type="text" readonly="">
                            </td>
                            <td>
                                <input name="pb_value[pub_id][]" data-name="vpb" class="form-control form-control-sm" type="text"
                                    placeholder="Ex: {pub_id}">
                                <input name="pb_id" data-name="vpb" class="form-control form-control-sm" type="hidden">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-action="save-edit-Postback">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var elContainer = '#postback_container'
        var saveButton = '#save_data'
        var elListpostback = '#listPostback'
        var listPostbackData;
        getListPostback()

        function getListPostback() {
            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('v2/postback/getListAdvPostback'); ?>"
                })
                .done(function(data) {
                    listPostbackData = data.listPostback
                    $(elListpostback).find('tbody').html(data.tableList)
                    $('#postbackId').html(data.selectbox)
                })
                .fail(function(data) {

                })
        }
        $(document).on('click', elListpostback + ' button[data-action="edit"]', function() {
            var td = $(this).closest('td')
            var postback_id = td.data('postback_id')
            var qr = td.data('item')
        })
        $(document).on('click', elListpostback + ' button[data-action="delete"]', function() {
            var postback_id = $(this).closest('td').data('postback_id')
            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('v2/postback/advDelPostback'); ?>",
                    data: {
                        postback_id: postback_id
                    }
                })
                .done(function(data) {
                    if (data.status = 'success') {
                        var mess =
                            `<div class="alert alert-danger" role="alert">
                    ${data.messenger}
                </div>`
                        $('#messenger').html(mess)
                        getListPostback();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.messenger ?? 'Error',
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        })
                    }
                })
                .fail(function(data) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Do you want to continue',
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    })
                })
        })
        $(saveButton).click(function() {
            var button = $(this)
            $(button).prop('disabled', true)
            var title = $(elContainer).find('input[name="title"]').val()
            if (!title) {
                alert('Please enter network name!')
                $(button).prop('disabled', false)
                return;
            }

            var formData = $('#postbackData').find('input').serialize();

            addSaveData(button, formData)

        })

        function addSaveData(button, formData, modal = '') {
            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('v2/postback/advAddPostback'); ?>",
                    data: formData
                })
                .done(function(data) {
                    if (data.status = 'success') {
                        var mess =
                            `<div class="alert alert-success" role="alert">
                    ${data.messenger}
                </div>`
                        $('#messenger').html(mess)
                        getListPostback();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.messenger ?? 'Error',
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        })
                    }
                })
                .fail(function(data) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Do you want to continue',
                        icon: 'error',
                        confirmButtonText: 'Cool'
                    })
                })
                .always(function() {
                    if (modal) $(modal).modal('hide')
                    $(button).prop('disabled', false)
                });
        }
        //edit network
        $(document).on('click', 'button[data-action="edit"]', function() {
            var postback_id = $(this).closest('td').data('postback_id')
            var listInput = $('.modal-edit-postback')
            listInput.find('input[data-name="vpb"]').val('');
            var pbValue = listPostbackData[postback_id]
            if (pbValue != undefined) {
                $(listInput).find('input[data-name="vpb"][name="pb_id"]').val(postback_id)
                $(listInput).find('input[data-name="vpb"][name="title"]').val(pbValue.name)
                $(listInput).find('input[data-name="vpb"][name="pb_value[clickid][]"]').val(pbValue.clickid[1])
                $(listInput).find('input[data-name="vpb"][name="pb_value[commission][]"]').val(pbValue.commission[1])
                $(listInput).find('input[data-name="vpb"][name="pb_value[sale_amount][]"]').val(pbValue.sale_amount[1])
                $(listInput).find('input[data-name="vpb"][name="pb_value[pub_id][]"]').val(pbValue.pub_id[1])
            }
            $('#editPostback').modal('show')
        })
        $(document).on('click', '#editPostback button[data-action="save-edit-Postback"]', function() {
            var button = $(this)
            $(button).prop('disabled', true)
            var title = $('.modal-edit-postback').find('input[name="title"]').val()
            if (!title) {
                alert('Please enter network name!')
                $(button).prop('disabled', false)
                return;
            }

            var formData = $('.modal-edit-postback').find('input').serialize();
            addSaveData(button, formData, '#editPostback')
        })
        //offer test
        $('#testOfferUrl').on('change', function() {
            var offerLink = encodeURIComponent($(this).val());
            var base_url = "<?php echo base_url('tracktest/advPostbackTest?adv=' . $this->member->id); ?>"
            var postbackId = parseInt($('#postbackId').val())
            $('#testTrackLink').val(base_url + '&postback_id=' + postbackId + '&offerurl=' + offerLink)
        })

    })
</script>