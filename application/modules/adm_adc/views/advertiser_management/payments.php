<script src="<?php echo base_url(); ?>/temp/default/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/temp/default/css/jquery-ui.css" />

<script>
    $(function() {
        $("#month-year").datepicker({
            dateFormat: "yy-mm",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            },
            beforeShow: function(input, inst) {
                var datestr;
                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length - 4, datestr.length);
                    month = jQuery.inArray(datestr.substring(0, datestr.length - 5), $(this).datepicker('option', 'monthNamesShort'));
                    $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            }
        });
    });

    function viewInvoiceDetails(invoiceId) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('admin/advertiser/get_invoice_details') ?>', 
            data: {
                id: invoiceId
            },
            success: function(response) {
                $('#invoice-details').html(response);
                $('#invoiceModal').modal('show');
            },
            error: function(error) {
                console.error('Error fetching invoice details:', error);
                alert('Failed to load invoice details. Please try again.');
            }
        });
    }
</script>

<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-globe"></i><span class="break"></span>Payments</h2>
            <div class="box-icon">
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-9">
                    <form id="search-form" class="" role="form" method="POST" action="<?php echo base_url($this->uri->segment(1) . '/advertiser/list_payments/' . $this->uri->segment(4)); ?>">
                        <div class="form-group form-inline">
                            <?php $status_filters = $this->input->post('status'); ?>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="Pending" name="status[]" <?php if (in_array('Pending', $status_filters)) echo ' checked '; ?>> Pending
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="Complete" name="status[]" <?php if (in_array('Complete', $status_filters)) echo ' checked '; ?>> Complete
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="Reverse" name="status[]" <?php if (in_array('Reverse', $status_filters)) echo ' checked '; ?>> Reverse
                            </label>
                            <input name="date" class="form-control input-sm" id="month-year" placeholder="Month-Year" value="" />

                            <input name="keycode" class="form-control input-sm" id="keys" placeholder="User's ID" value="<?= $this->input->post('keycode'); ?>" />
                            <button class="btn btn-success btn-sm">Search</button>
                            <button id="reset-filter" onclick="reset_filter()" class="btn btn-warning btn-sm">Reset</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-------------END form creat invoice--------------->
            <?php
            echo $this->session->userdata('thongbao');
            $this->session->unset_userdata('thongbao');

            ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User's Id</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>View</th>
                        <th width="220px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?= $payment->id ?></td>
                            <td><?= $payment->adv_id ?></td>
                            <td><?= $payment->amount ?></td>
                            <td><?= $payment->method ?></td>
                            <td><?= $payment->note ?></td>
                            <td>
                                <?php if ($payment->status === 'Pending'): ?>
                                    <span class="label label-warning"><?= $payment->status ?></span>
                                <?php elseif ($payment->status === 'Complete'): ?>
                                    <span class="label label-success"><?= $payment->status ?></span>
                                <?php elseif ($payment->status === 'Reverse'): ?>
                                    <span class="label label-danger"><?= $payment->status ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $payment->date ?></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="viewInvoiceDetails('<?= $payment->id ?>')">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            <td>
                                <button <?= $payment->status == 'Pending' ? '' : 'disabled' ?> type="button" onclick="complete_payment('<?= $payment->id ?>','<?= $payment->adv_id ?>')" class="btn btn-success btn-xs">Complete</button>
                                <button <?= $payment->status == 'Pending' ? '' : 'disabled' ?> type="button" onclick="reverse_payment('<?= $payment->id ?>')" class="btn btn-warning btn-xs">Reverse</button>
                                <button class="btn btn-danger btn-xs" onclick="delete_payment('<?= $payment->id ?>')">Rejected</button>
                                <i class="loading'.$dt->id.'"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <div class="row flex-justify-center">
                        <div class="col-md-6">
                            <?php echo 'Showing ' . $from . ' to ' . $to . ' of ' . $this->pagination->total_rows . ' entries' ?>
                        </div>
                        <div class="col-md-6">
                            <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="invoiceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="invoiceModalLabel">Invoice Details</h4>
            </div>
            <div class="modal-body">
                <div id="invoice-details">
                    <!-- Nội dung chi tiết invoice sẽ được tải qua AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const url_update = '<?= base_url('admin/advertiser/update_status_payment') ?>';

    function complete_payment(id, adv_id) {
        const status = 'Complete';
        $.ajax({
            type: 'POST',
            url: url_update,
            data: {
                id,
                status
            },
            success: function(data) {
                $.ajax({
                    type: "GET",
                    url: `<?= base_url(); ?>/cron-jobs/calculator/advertisers/${adv_id}`,
                    success: function(response) {

                    },
                    error: function(error) {

                    }
                })
                location.reload()
            },
            error: function(error) {

            }
        })
    }

    function reverse_payment(id) {
        const status = 'Reverse';
        $.ajax({
            type: 'POST',
            url: url_update,
            data: {
                id,
                status
            },
            success: function(data) {
                location.reload()
            },
            error: function(error) {

            }
        })
    }

    function delete_payment(id) {
        $.ajax({
            type: 'POST',
            url: url_update,
            data: {
                id,
                is_delete: 1
            },
            success: function(data) {
                location.reload()
            },
            error: function(error) {

            }
        })
    }

    function reset_filter() {
        event.preventDefault();
        $('input[name="status[]"]').attr('checked', false)
        $('input[name="date"]').val('');
        $('input[name="keycode"]').val('');
        $("#search-form").submit();
    }
</script>