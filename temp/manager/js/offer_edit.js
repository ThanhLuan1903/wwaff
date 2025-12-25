////////////////////////////////////////// ORIGIN ///////////////////////////////////////////
$(document).ready(function () {

    $("#sgeo").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".geocontent p").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    var id = $('.net_change').val();

    getlinkpb(id);
    $('.net_change').change(function () {
        id = $(this).val();
        getlinkpb(id);
    });
})

var parentElement = $('#preview_landing');
document.getElementById('addpreviewlanding').addEventListener('click', function () {
    let current_preview = $('.preview-input').length > 0 ? $('.preview-input').length : 0;

    var htmlToInsert = `
         <div class="col-md-6">
            <label class="landingLabel">Preview name #${current_preview + 1}</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
               <input type="text" class="form-control preview-input" id="previewname" value="" name="preview[${current_preview}][name]" placeholder="Preview URL" />
            </div>
         </div>
         <div class="col-md-6">
            <label class="landingLabel">Preview offer #${current_preview + 1}</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
               <input type="text" class="form-control" id="preview" value="" name="preview[${current_preview}][value]" placeholder="Preview URL" />
            </div>
         </div>
         <div class="col-md-6">
            <label class="landingLabel">Landing Page Name #${current_preview + 1}</label>
            <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
               <input type="text" class="form-control" id="landingpagename" value="" name="landingpage[${current_preview}][name]" placeholder="Landing Page" />
            </div>
         </div>
         <div class="col-md-6">
            <label class="landingLabel">Landing Page #${current_preview + 1}</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span> 
               <input type="text" class="form-control" id="landingpage" value="" name="landingpage[${current_preview}][value]" placeholder="Landing Page" />
            </div>
         </div>
         `;

    parentElement.append(htmlToInsert);
});

function getlinkpb(id = 0) { }
/////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////// NEW ////////////////////////////////////////////
$(document).ready(function () {
    /* -------------------------- HANDLE CAP -------------------------- */
    $('.cap-btn').click(function () {
        var offer_id = $('input.hide').attr('value');
        var period = $(this).data('period');

        if (!offer_id || offer_id == 0) {
            return;
        }

        $('#capExceptionModal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');

        $.ajax({
            type: "POST",
            url: capUrl,
            data: {
                offer_id: offer_id,
                period: period
            },
            success: function (response) {
                $('body').append(response);
                $('#capExceptionModal').modal('show');
            }
        });

    });

    $(document).on('click', '#addexccap', function () {
        $('#missingpubid, #missingcap, #missingsub2').remove();

        let row = $(this).closest('.input-row');
        var pubid = row.find('#publisherIdCap').val();
        var cap = row.find('#customCapValue').val();
        var iss2 = row.find('#iss2').val();
        var s2 = null;

        if (iss2) {
            var s2 = row.find('#sub2ValueCap').val();
            if (!s2) {
                row.find('label[for="sub2ValueCap"]').append('<small id="missingsub2" class="text-danger percentage-error">  Enter Sub2!</small>')
            }
        }

        if (!pubid) {
            row.find('label[for="publisherIdCap"]').append('<small id="missingpubid" class="text-danger percentage-error">  Enter Pub ID!</small>')
        }

        if (!cap) {
            row.find('label[for="customCapValue"]').append('<small id="missingcap" class="text-danger percentage-error">  Enter new cap!</small>')
        }

        if (pubid && cap) {
            var data = {
                'custom_cap': cap,
                'pub_id': pubid,
                'offer_id': $('input.hide').attr('value'),
                's2': s2,
                'period': $('#capExceptionModal').data('period')
            };

            $.ajax({
                type: "POST",
                url: savecapPub,
                data: data,
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.status == 'success') {
                        $('.exception-table-cap tbody').prepend(result.html);
                        $('#publisherIdCap, #customCapValue, #sub2ValueCap').val('');
                        if ($('#nocapdata').length) {
                            $('#nocapdata').remove();
                        }
                    } else if (result.status == 'duplicate') {
                        alert('Publisher ID này đã có cap exception rồi!');
                    } else {
                        alert('Không thể lưu dữ liệu. Vui lòng thử lại!');
                    }
                },
                error: function () {
                    alert('Không thể lưu dữ liệu. Vui lòng thử lại!');
                }
            });
        }

    });

    $(document).on('click', '#removecap', function () {
        var $row = $(this).closest('tr');
        var dataId = $row.data('id')
            ;
        if (!confirm('Bạn có chắc muốn xóa cap exception này?')) {
            return;
        }

        $.ajax({
            type: "POST",
            url: delete_exccap,
            data: {
                'id': dataId
            },
            success: function (response) {
                if (response == 'success') {
                    $row.remove();
                    if ($('.exception-table-cap tbody tr').length === 0) {
                        $('.exception-table-cap tbody').append('<tr id="nocapdata"><td colspan="4" class="text-center">No cap exceptions found</td></tr>');
                    }
                } else if (response == 'not_found') {
                    alert('Cap exception không tồn tại!');
                } else {
                    alert('Không thể xóa cap exception. Vui lòng thử lại!');
                }
            },
            error: function () {
                alert('Lỗi kết nối! Không thể xóa cap exception.');
            }
        });
    });

    $(document).on('focus input', `#sub2ValueCap,  #publisherIdCap, #customCapValue`, function () {
        $('#missingpubid, #missingcap, #missingsub2').remove();
    });

    function validateCaps() {
        var dailyCap = parseFloat($('#daycap').val()) || 0;
        var monthlyCap = parseFloat($('#monthcap').val()) || 0;

        $('#cap-error').remove();

        if (dailyCap > 0 && monthlyCap > 0) {
            if (monthlyCap <= dailyCap) {
                $('.monthcap_lable').after('<small id="cap-error" class="text-danger"> Monthly cap > daily cap!</small>');
                return false;
            }
        }
        return true;
    }

    $('#daycap, #monthcap').on('input blur', function () {
        validateCaps();
    });
    /* ----------------------------------------------------------------- */

    /* ------------------------- HANDLE CR REQUIRE --------------------- */
    var $reqcrSwitch = $('input[name="reqcr"]').parent('.box_switch');

    checkCRStatus();

    $reqcrSwitch.on('click', function () {
        setTimeout(function () {
            checkCRStatus();
        }, 50);
    });

    function checkCRStatus() {
        var isCROn = !$reqcrSwitch.hasClass('off');
        if (isCROn) {
            $('#cr_options_container').show();
        } else {
            $('input[name="cr_mode"]:checked').prop('checked', false);
            $('#cr_options_container').hide();
        }
    }

    function validateCROnSubmit() {
        $('.crOption + .percentage-error').remove();

        const isCRRequired = $('input[name="reqcr"]').val() === '1';

        if (!isCRRequired) {
            return true;
        }

        if ($('input[name="cr_mode"]:checked').length === 0) {
            $('.crOption').after(
                '<small class="text-danger percentage-error"> Please select a CR mode!</small>'
            );
            return false;
        }

        return true;
    }

    $(document).on('change', 'input[name="cr_mode"]', function () {
        $('.crOption + .percentage-error').remove();
    });
    /* ----------------------------------------------------------------- */

    /* --------------------- HANDLE REQUEST DEVICE --------------------- */
    const $deviceContainer = $('#device_options_container');
    const $reqdevSwitch = $('input[name="reqdev"]').parent('.box_switch');
    const $devicePercentages = $('.device-percentages');
    const $deviceRadios = $('.device-option-radio');

    if (selected) {
        $('#device_options_container').show();
        $('.' + selected + '-fields').show();
        $('input[name="mode"][value="' + selected + '"]').prop('checked', true);
    }

    function initializeDeviceContainer() {
        const isDeviceRequired = $('input[name="reqdev"]').val() === '1';

        if (isDeviceRequired || (typeof selected !== 'undefined' && selected)) {
            showDeviceContainer();

            if (typeof selected !== 'undefined' && selected) {
                showDeviceFields(selected);
            }
        } else {
            hideDeviceContainer();
        }

        handleDeviceInputStates();
    }

    function showDeviceContainer() {
        $deviceContainer.show();
    }

    function hideDeviceContainer() {
        $deviceContainer.hide();
        resetDeviceSelection();
    }

    function showDeviceFields(deviceType) {
        $devicePercentages.hide();
        $(`.${deviceType}-fields`).show();
    }

    function resetDeviceSelection() {
        $('input[name="mode"]').prop('checked', false);
        $('input[name="all[desk_pct]"]').val('');
        $('input[name="all[mob_pct]"]').val('');
        $devicePercentages.hide();
        $('.percentage-error').remove();
    }

    function validateDeviceOnSubmit() {
        $('.percentage-error').remove();

        let isValid = true;
        const isDeviceRequired = $('input[name="reqdev"]').val() === '1';

        if (!isDeviceRequired) {
            return true;
        }

        const selectedMode = $('input[name="mode"]:checked').val();
        if (!selectedMode) {
            $('.devicelable').after(
                '<small class="text-danger percentage-error"> Please select one option.</small>'
            );
            isValid = false;
        }

        if (selectedMode === 'all') {
            const deskPct = $('input[name="all[desk_pct]"]').val();
            const mobPct = $('input[name="all[mob_pct]"]').val();
            const deskPctNum = parseInt(deskPct);
            const mobPctNum = parseInt(mobPct);

            if (deskPct === '' || isNaN(deskPctNum) || deskPctNum < 0 || deskPctNum > 100) {
                $('.all-fields .col-md-6:first label').after(
                    '<small class="text-danger percentage-error">  Please enter a valid percentage (0-100)</small>'
                );
                isValid = false;
            }

            if (mobPct === '' || isNaN(mobPctNum) || mobPctNum < 0 || mobPctNum > 100) {
                $('.all-fields .col-md-6:last label').after(
                    '<small class="text-danger percentage-error">  Please enter a valid percentage (0-100)</small>'
                );
                isValid = false;
            }

            if (isValid && (deskPctNum + mobPctNum !== 100)) {
                $('.all-fields').append(
                    '<small class="text-danger percentage-error" style="display:block;margin-top:10px">Desktop and Mobile percentages must add up to 100%</small>'
                );
                isValid = false;
            }
        }

        return isValid;
    }

    function handleDeviceInputStates() {
        var reqdevValue = $('input[name="reqdev"]').val();
        if (reqdevValue === '0') {
            $('.device-percentages input').prop('disabled', true);
        } else {
            $('.device-percentages input').prop('disabled', false);

            var selectedOption = $('input[name="mode"]:checked').val();
            if (selectedOption) {
                $('.device-percentages input').prop('disabled', true);
                $('.' + selectedOption + '-fields input').prop('disabled', false);
            }
        }
    }

    $reqdevSwitch.on('click', function () {
        setTimeout(() => {
            const newValue = $(this).find('input[name="reqdev"]').val();

            if (newValue === "0") {
                hideDeviceContainer();
                handleDeviceInputStates()
            } else {
                showDeviceContainer();
                handleDeviceInputStates();
            }
        }, 50);
    });

    $deviceRadios.on('change', function () {
        const selectedOption = $('input[name="mode"]:checked').val();

        if (selectedOption) {
            showDeviceFields(selectedOption);

            if (selectedOption !== 'all') {
                $('input[name="all[desk_pct]"], input[name="all[mob_pct]"]').val('');
                $('.all-fields .percentage-error').remove();
            }
        }

        handleDeviceInputStates();
    });

    initializeDeviceContainer();

    $('input[name="all[desk_pct]"]').on('input', function () {
        const desktopPercent = Math.min(parseInt($(this).val()) || 0, 100);
        if (desktopPercent > 100) {
            $(this).val(100);
        }
        $('input[name="all[mob_pct]"]').val(100 - desktopPercent);
    });

    $('input[name="all[mob_pct]"]').on('input', function () {
        const mobilePercent = Math.min(parseInt($(this).val()) || 0, 100);
        if (mobilePercent > 100) {
            $(this).val(100);
        }
        $('input[name="all[desk_pct]"]').val(100 - mobilePercent);
    });

    $('input[name="all[desk_pct]"], input[name="all[mob_pct]"]').on('blur', function () {
        const isDeviceRequired = $('input[name="reqdev"]').val() === '1';
        const selectedMode = $('input[name="mode"]:checked').val();

        if (isDeviceRequired && selectedMode === 'all') {
            validateDeviceOnSubmit();
        }
    });

    $('input[name="all[desk_pct]"], input[name="all[mob_pct]"]').on('focus', function () {
        $('.all-fields .percentage-error').remove();
    });
    /* ----------------------------------------------------------------- */




    /* ------------------------- HANDLE EXCEPTION ---------------------- */

    function validateInputs(pubid, sub2, isCheckSub2) {
        let hasError = false;

        $('#missingsub2pub, #missingsub2, #missingpubid').remove();

        if (!pubid) {
            const labelFor = isCheckSub2 ? 'publisherIdForSub2' : 'publisherId';
            const errorId = isCheckSub2 ? 'missingsub2pub' : 'missingpubid';
            const msg = isCheckSub2 ? ' Enter Pub ID' : ' Please enter ID of Pub!';

            $(`label[for="${labelFor}"]`).append(
                `<small id="${errorId}" class="text-danger percentage-error">${msg}</small>`
            );
            hasError = true;
        }

        if (isCheckSub2 && !sub2) {
            $('label[for="sub2Value"]').append(
                '<small id="missingsub2" class="text-danger percentage-error"> Enter Sub2</small>'
            );
            hasError = true;
        }

        return !hasError;
    }

    function addRowToTable(id, pubid, sub2) {
        const sub2Display = sub2 ? sub2 : 'All';

        const html = `
        <tr data-id="${id}">
            <td>${pubid}</td>
            <td>${sub2Display}</td>
            <td>
                <button type="button" class="btn btn-xs btn-danger remove-exception">Remove</button>
            </td>
        </tr>
    `;

        $('.exception-table tbody').prepend(html);

        if ($('#nodata').length) {
            $('#nodata').closest('tr').remove();
        }
    }

    $('.all-exc').click(function () {
        var data = {
            rule_type: $(this).attr('id'),
            offer_id: $('input.hide').attr('value')
        };

        if (!data['offer_id'] || data['offer_id'] == 0) {
            return;
        }

        $.ajax({
            type: "POST",
            url: modalUrl,
            data: data,
            success: function (response) {
                if ($('#exceptionModal').length) {
                    $('#exceptionModal').remove();
                }
                $('body').append(response);
                $('#exceptionModal').modal('show');
                $('#exceptionModal').data('rule_type', data.rule_type);
            }
        })
    });

    $(document).on('click', '.add-exception', function () {
        const section = $(this).closest('.exception-section');
        const pubid = section.find('.pub-input').val();
        const elsub2 = section.find('.sub2-input');
        const sub2 = elsub2.val() || null;
        const isCheckSub2 = elsub2.length > 0 ? 1 : 0;

        if (!validateInputs(pubid, sub2, isCheckSub2)) return;

        var data = {
            pub_id: pubid,
            offer_id: $('input.hide').attr('value'),
            rule_type: $('#exceptionModal').data('rule_type')
        };

        if (sub2) data.sub2 = sub2;

        $.ajax({
            type: "POST",
            url: save_exce,
            data: data,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status == 'success') {
                    addRowToTable(result.id, pubid, sub2);
                    section.find('.pub-input, .sub2-input').val('');
                    $('#missingsub2pub, #missingsub2, #missingpubid').remove();
                } else if (result.status == 'duplicate') {
                    alert(sub2
                        ? 'Publisher ID + Sub2 này đã có exception rồi!'
                        : 'Publisher ID này đã có exception rồi!');
                } else {
                    alert('Không thể lưu dữ liệu. Vui lòng thử lại!');
                }
            },
            error: function () {
                alert('Không thể lưu dữ liệu. Vui lòng thử lại!');
            }
        });

    });

    $(document).on('click', '.btn-danger', function () {
        var $row = $(this).closest('tr');
        var dataId = $row.data('id');

        if (!confirm('Bạn có chắc muốn xóa exception này?')) {
            return;
        }

        $.ajax({
            type: "POST",
            url: delete_exc,
            data: {
                id: dataId,
            },
            success: function (response) {
                if (response == 'success') {
                    $row.remove();

                    if ($('.exception-table tbody tr').length === 0) {
                        $('.exception-table tbody').append(
                            '<tr><td colspan="3" id="nodata" class="text-center">No exceptions found</td></tr>'
                        );
                    }
                } else if (response == 'not_found') {
                    alert('Exception không tồn tại!');
                } else {
                    alert('Không thể xóa exception. Vui lòng thử lại!');
                }
            },
            error: function () {
                alert('Lỗi kết nối! Không thể xóa exception.');
            }
        });
    });

    $(document).on('focus input', `.pub-input,  .sub2-input`, function () {
        $('#missingsub2pub, #missingsub2, #missingpubid').remove();
    });
    /* ----------------------------------------------------------------- */




    /* --------------------- HANDLE REQUEST LANGUAGE ------------------- */
    var $reqlangSwitch = $('input[name="reqlang"]').parent('.box_switch');
    checkLangStatus();
    setTimeout(sortLanguagesBySelection, 100);

    $reqlangSwitch.on('click', function (e) {
        setTimeout(function () {
            checkLangStatus();
        }, 50);
    });

    function checkLangStatus() {
        var isLangOn = !$reqlangSwitch.hasClass('off');
        if (isLangOn) {
            $('#laguage_container').show();
            setTimeout(sortLanguagesBySelection, 100);
        } else {
            $(".langcontent input[type='checkbox']").prop('checked', false);
            $('#laguage_container').hide();
        }
    }

    function sortLanguagesBySelection() {
        var $container = $(".langcontent");
        var $items = $container.children("p").get();

        $items.sort(function (a, b) {
            var aChecked = $(a).find('input[type="checkbox"]').prop('checked');
            var bChecked = $(b).find('input[type="checkbox"]').prop('checked');
            if (aChecked && !bChecked) return -1;
            if (!aChecked && bChecked) return 1;
            return $(a).text().trim().localeCompare($(b).text().trim());
        });

        $.each($items, function (i, item) {
            $container.append(item);
        });
    }

    $(document).on('change', '.langcontent input[type="checkbox"]', function () {
        sortLanguagesBySelection();
    })

    $("#slang").on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.langcontent p').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        if (value === "") {
            sortLanguagesBySelection();
        }
    })

    $("#select-all-lang").click(function () {
        $(".langcontent input[type='checkbox']").prop('checked', true);
        setTimeout(sortLanguagesBySelection, 50);
    });

    $("#deselect-all-lang").click(function () {
        $(".langcontent input[type='checkbox']").prop('checked', false);
        setTimeout(sortLanguagesBySelection, 50);
    });
    /* ----------------------------------------------------------------- */



    /* --------------------------- SUBMIT FORM ------------------------- */
    $('form').on('submit', function (e) {
        if (!validateCaps()) {
            e.preventDefault();
            return false;
        }

        if (!validateDeviceOnSubmit()) {
            e.preventDefault();
            return false;
        }

        if (!validateCROnSubmit()) {
            e.preventDefault();
            return false;
        }

        return true;
    });
    /* ----------------------------------------------------------------- */

})

//////////////////////////////////////////////////////////////////////////////////////////////


