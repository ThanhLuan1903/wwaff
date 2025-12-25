<style>
    .modal {
        text-align: center;
        padding: 0 !important;
    }

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
        max-width: 500px;
        width: 90%;
    }

    .modal .modal-content {
        box-shadow: 0 5px 14px rgba(0, 0, 0, .5);
        border: none;
        border-radius: 6px;
    }

    .modal .modal-header {
        background-color: #f8f8f8;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom: 1px solid #e5e5e5;
        padding: 15px;
    }

    .exception-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 4px;
    }

    .exception-section h5 {
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: bold;
        color: #333;
        font-size: 13px;
    }

    .exception-section label {
        font-size: 12px;
        font-weight: 600;
    }

    .pub-input-row,
    .sub2-input-row {
        display: flex;
        align-items: flex-end;
        margin-bottom: 0;
    }

    .pub-input-row .form-group,
    .sub2-input-row .form-group {
        margin-bottom: 0;
        margin-right: 10px;
        flex: 1;
    }

    .pub-input-row button,
    .sub2-input-row button {
        height: 34px;
        margin-bottom: 0;
    }

    .input-group-custom {
        display: flex;
        width: 100%;
    }

    .input-group-custom input {
        flex: 1;
        margin-right: 10px;
    }

    .exceptions-table-container {
        max-height: 150px;
        overflow-y: auto;
        margin-top: 15px;
        border: 1px solid #ddd;
    }

    .exception-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 12px;
    }

    .exception-table thead {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
    }

    .exception-table th,
    .exception-table td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .exception-table th {
        background-color: #f5f5f5;
        text-align: left;
    }

    .exception-table tr:last-child td {
        border-bottom: none;
    }
</style>
<!-- Popup of Exception -->
<div class="modal fade" id="exceptionModal" tabindex="-1" role="dialog" aria-labelledby="Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Exception to <?php echo isset($title) ? $title : 'Rule'; ?> policy</h4>
            </div>
            <div class="modal-body">
                <!-- Add Publisher ID Exception -->
                <div class="exception-section">
                    <h5>Add Publisher ID Exception</h5>
                    <div class="pub-input-row">
                        <div class="form-group" style="flex: 1;">
                            <label for="publisherId">Publisher ID</label>
                            <div class="input-group-custom">
                                <input type="text" class="form-control pub-input" placeholder="Enter Publisher ID">
                                <button class="btn btn-success add-exception" type="button">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Publisher ID with Sub2 Exception -->
                <div class="exception-section">
                    <h5>Add Publisher ID with Sub2 Exception</h5>
                    <div class="sub2-input-row">
                        <div class="form-group">
                            <label for="publisherIdForSub2">Publisher ID</label>
                            <input type="text" class="form-control pub-input" placeholder="Enter Publisher ID">
                        </div>
                        <div class="form-group">
                            <label for="sub2Value">Sub2</label>
                            <input type="text" class="form-control sub2-input" placeholder="Enter Sub2">
                        </div>
                        <button type="button" class="btn btn-success add-exception">Add</button>
                    </div>
                </div>
                <!-- Current Exceptions Table -->
                <h5>Current Exceptions</h5>
                <div class="exceptions-table-container">
                    <table class="exception-table">
                        <thead>
                            <tr>
                                <th width="40%">Publisher ID</th>
                                <th width="40%">Sub2</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data) && $data) {
                                foreach ($data as $item) { ?>
                                    <tr data-id="<?php echo isset($item->id) ? $item->id : ''; ?>">
                                        <td><?php echo isset($item->pub_id) ? $item->pub_id : ''; ?></td>
                                        <td><?php echo isset($item->sub2) && $item->sub2 ? $item->sub2 : 'All'; ?></td>
                                        <td><button type="button" class="btn btn-xs btn-danger">Remove</button></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="3" id="nodata" class="text-center">No exceptions found</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- Hidden input to store exception data -->
                <input type="hidden" id="crExceptionsData" name="cr_exceptions" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Popup of Exception -->