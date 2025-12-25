<style>
    #capExceptionModal.modal {
        text-align: center;
        padding: 0 !important;
    }

    #capExceptionModal.modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    #capExceptionModal .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
        max-width: 600px;
        width: 90%;
    }

    #capExceptionModal .modal-content {
        box-shadow: 0 5px 14px rgba(0, 0, 0, .5);
        border: none;
        border-radius: 6px;
    }

    #capExceptionModal .modal-header {
        background-color: #f8f8f8;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-bottom: 1px solid #e5e5e5;
        padding: 15px;
    }

    #capExceptionModal .input-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-bottom: 0;
    }

    #capExceptionModal .input-row .form-group {
        flex: 1;
        min-width: 120px;
        margin-right: 10px;
        margin-bottom: 0;
    }

    #capExceptionModal .input-row button {
        height: 34px;
        margin-bottom: 0;
    }

    #capExceptionModal .exceptions-table-container {
        max-height: 150px;
        overflow-y: auto;
        margin-top: 15px;
        border: 1px solid #ddd;
    }

    #capExceptionModal .exception-table-cap {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
        table-layout: fixed;
    }

    #capExceptionModal .exception-table-cap th,
    #capExceptionModal .exception-table-cap td {
        padding: 8px 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        word-wrap: break-word;
        vertical-align: middle;
    }


    #capExceptionModal .exception-table-cap th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #ddd;
    }

    #capExceptionModal .exception-table-cap tr:last-child td {
        border-bottom: none;
    }

    #capExceptionModal .exception-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #eee;
        border-radius: 4px;
    }

    #capExceptionModal .exception-section h5 {
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: bold;
        color: #333;
        font-size: 13px;
    }

    #capExceptionModal .exception-section label {
        font-size: 12px;
        font-weight: 600;
    }

    #capExceptionModal .exception-table-cap th:last-child,
    #capExceptionModal .exception-table-cap td:last-child {
        text-align: center;
    }
</style>
<!-- Popup of Cap Exception -->
<div class="modal fade" id="capExceptionModal" tabindex="-1" role="dialog" aria-labelledby="CapLabel" data-period="<?php echo (isset($period)) ? $period : '' ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""><?php echo ($period == 0) ? 'Daily' : 'Monthly' ?> Cap Limit Exceptions</h4>
            </div>
            <div class="modal-body">
                <!-- Add Publisher ID Exception -->
                <div class="exception-section">
                    <h5>Add Publisher Cap Exception</h5>
                    <div class="input-row">
                        <div class="form-group">
                            <label for="publisherIdCap">Publisher ID</label>
                            <input type="text" class="form-control" id="publisherIdCap" placeholder="Enter Publisher ID">
                        </div>
                        <div class="form-group">
                            <label for="customCapValue">Custom Cap</label>
                            <input type="number" class="form-control" id="customCapValue" placeholder="New cap value">
                        </div>
                        <button type="button" class="btn btn-success" id="addexccap">Add</button>
                    </div>
                </div>

                <!-- Add Sub2 Exception -->
                <div class="exception-section">
                    <h5>Add Publisher and Sub2 Cap Exception</h5>
                    <div class="input-row">
                        <div class="form-group">
                            <label for="publisherIdCap">Publisher ID</label>
                            <input type="text" class="form-control" id="publisherIdCap" placeholder="Enter Publisher ID">
                        </div>
                        <div class="form-group">
                            <label for="sub2ValueCap">Sub2</label>
                            <input type="text" class="form-control" id="sub2ValueCap" placeholder="Enter Sub2">
                            <input type="hidden" class="form-control" id="iss2" value=1>
                        </div>
                        <div class="form-group">
                            <label for="customCapValue">Custom Cap</label>
                            <input type="number" class="form-control" id="customCapValue" placeholder="New cap value">
                        </div>
                        <button type="button" class="btn btn-success" id="addexccap">Add</button>
                    </div>
                </div>

                <!-- Current Cap Exceptions Table -->
                <h5>Current Cap Exceptions</h5>
                <div class="exceptions-table-container">
                    <table class="exception-table-cap">
                        <thead>
                            <tr>
                                <th width="30%">Publisher ID</th>
                                <th width="30%">Sub2</th>
                                <th width="20%">Custom Cap</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($exceptions) && !empty($exceptions)): ?>
                                <?php foreach ($exceptions as $item): ?>
                                    <tr data-id="<?php echo isset($item['id']) ? $item['id'] : 'new'; ?>">
                                        <td><?php echo isset($item['pub_id']) ? $item['pub_id'] : ''; ?></td>
                                        <td><?php echo isset($item['s2']) && $item['s2'] ? $item['s2'] : 'All'; ?></td>
                                        <td><?php echo isset($item['custom_cap']) ? $item['custom_cap'] : ''; ?></td>
                                        <td><button type="button" id="removecap" class="btn btn-xs btn-danger">Remove</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr id="nocapdata">
                                    <td colspan="4" class="text-center">No cap exceptions found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Hidden input to store exception data -->
                <input type="hidden" id="capExceptionsData" name="cap_exceptions" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Popup of Cap Exception -->