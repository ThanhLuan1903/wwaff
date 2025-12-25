<?php
$advertiser         = $this->session->userdata('user');
$need_payment_class = $need_payment ? 'btn-danger' : 'btn-primary';
$alert_string       = (empty($available) || is_null($available)) ? 0 : $available;
?>
<div class="row  mt-5">
  <div class="sc-dlyikq hrvHfq">
    <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV">Payments</span>
    <p class="text-muted text-start mb-3" style="font-size: 1.2em;">‘’Your threshold is 50$’’</p>
    <div class="card">
      <div class="card-header">
        <b>Current payout amount must be paid <?= $alert_string ?>$</b>
      </div>
      <div class="card-body">
        <div class="col-auto">
          <button type="submit" data-status="new_payment" class="btn <?= $need_payment_class ?> mb-3 btn-sm edit_pp" <?php echo $alert_string >= 50 ? '' : 'disabled'; ?>>Make Payment</button>
        </div>

      </div>
    </div>
    <div class="card mt-2">
      <div class="card-header">
        <b>Payout History</b>
      </div>
      <div class="card-body">
        <div class="sc-eitiEO uHLlo">
          <?php
          if ($this->session->userdata('err_po')) {
            echo '<span class="text-danger tt">' . $this->session->userdata('err_po') . '</span>';
            $this->session->unset_userdata('err_po');
          }
          if ($this->session->userdata('succ_po')) {
            echo '<span class="text-success tt">' . $this->session->userdata('succ_po') . '</span>';
            $this->session->unset_userdata('succ_po');
          }
          ?>
          <?php if ($payments): ?>
            <div class="table-responsive">
              <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Note</th>
                    <th>Amount (USD)</th>
                    <th>Status</th>
                    <th>Detail Payment</th>
                    <!--th>Edit</th-->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($payments as $k => $payment): ?>
                    <tr>
                      <td><?= $payment->id ?></td>
                      <td><?= $payment->date ?></td>
                      <td><?= $payment->method ?></td>
                      <td><?= $payment->note ?></td>
                      <td><?= $payment->amount ?></td>
                      <td>
                        <span class="badge bg-<?php
                                              if ($payment->status == 'Pending') {
                                                echo 'warning';
                                              } elseif ($payment->status == 'Completed') {
                                                echo 'success';
                                              } elseif ($payment->status == 'Reverse') {
                                                echo 'danger';
                                              } else {
                                                echo 'secondary';
                                              }

                                              ?>">
                          <?= $payment->status ?>
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-info btn-detail-payment"
                          data-id="<?= $payment->id ?>">
                          Detail
                        </button>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paymentModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form class="formpayment" method="post" action="<?php echo base_url('v2/request_payouts'); ?>">
        <input type="hidden" name="pid" id="pid" value="0">
        <input type="hidden" name="offersIdList" id="offersIdList" value="">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <style>
          .formpayment label {
            text-align: right
          }
        </style>

        <div class="modal-body">
          <div class="row mb-2" id="amount">
            <label class="col-sm-4 col-form-label  col-form-label-sm">Amount</label>
            <div class="col-sm-8">
              <div class="input-group">
                <input type="text" name="amount" class="form-control form-control-sm" id="amount" placeholder="$"
                  readonly>
                <button type="button" class="btn btn-info btn-sm" id="chooseConversion" data-bs-toggle="modal"
                  data-bs-target="#conversionModal">Choose Conversion</button>
              </div>
            </div>
          </div>
          <div class="row mb-2" id="amount">
            <label class="col-sm-4 col-form-label  col-form-label-sm">Note</label>
            <div class="col-sm-8">
              <textarea type="text" name="note" class="form-control form-control-sm"></textarea>
            </div>
          </div>
          <div class="row mb-2">
            <label for="payment_method" class="col-sm-4 col-form-label  col-form-label-sm">Payment Method</label>
            <div class="col-sm-8">
              <select name="method" class="form-select form-select-sm" id="payment_method">
                <option value="pmchose">Payment Method</option>
                <option value="PayPal">PayPal</option>
                <option value="Payoneer">Payoneer</option>
                <option value="Crypto">Crypto</option>
                <option value="Bank Wire">Bank Wire</option>
              </select>
            </div>
          </div>

          <!--payoone-->
          <div class="row mb-2 formpay" id="Payoneer">
            <label class="col-sm-4 ">Payoneer Id:</label>
            <div class="col-sm-8">
              <span>Support@wedebeek.com</span>
            </div>
          </div>
          <!-- paypal-->
          <div class="row mb-2 formpay" id="PayPal">
            <label class="col-sm-4 ">Paypal Email:</label>
            <div class="col-sm-8">
              <span>nguyenvinhthuy30495@gmail.com</span>
            </div>
          </div>
          <!-- crypto-->
          <div class="row mb-2 formpay" id="Crypto">
            <label class="col-sm-4 ">Address Wallet</label>
            <div class="col-sm-8">
              <span>0x053ed76321e65a803e89c3018469b206c727f39a</span>
              <span>BNB Smart Chain (BEP20)</span>
            </div>
          </div>
          <!--wire-->
          <div id="BankWire" class="formpay">
            <div class="row mb-2 ">
              <label class="col-sm-4 ">Beneficiary name</label>
              <div class="col-sm-8">
                <span>Wedebeek Technology Limited</span>
              </div>
            </div>
            <div class="row mb-2 ">
              <label class="col-sm-4 ">Beneficiary Address</label>
              <div class="col-sm-8">
                <span>174 Chau Thi Vinh Te, My An Ward, Ngu Hanh Son District, Da Nang City, Viet Nam</span>
              </div>
            </div>
            <div class="row mb-3 ">
              <label class="col-sm-4 ">Bank name</label>
              <div class="col-sm-8">
                <span>Military Commercial Joint Stock Bank</span>
              </div>
            </div>
            <div class="row mb-3 ">
              <label class="col-sm-4 ">Bank address</label>
              <div class="col-sm-8">
                <span>63 Le Van Luong, Trung Hoa Ward, Cau Giay District, Hanoi City, VN</span>
              </div>
            </div>
            <div class="row mb-3 ">
              <label class="col-sm-4">Account number</label>
              <div class="col-sm-8">
                <span>1424797979</span>
              </div>
            </div>

            <div class="row mb-3 ">
              <label class="col-sm-4">Swiftcode</label>
              <div class="col-sm-8">
                <span>MSCBVNVX</span>
              </div>
            </div>

          </div>
          <div class="row mb-2">
            <label for="payment_image" class="col-sm-4 col-form-label col-form-label-sm">Proof Payment</label>
            <div class="col-sm-8">
              <input type="file" name="payment_image" class="form-control form-control-sm" id="payment_image" accept="image/*">
              <small class="text-muted">Please upload a photo of your payment proof.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm" id="savebutton" disabled>Make payment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Conversion Modal -->
<div class="modal fade" id="conversionModal" tabindex="-1" aria-labelledby="conversionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="conversionModalLabel">Approved Leads</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-secondary" id="selectedInfo" style="display: none;">
          Selected: <span id="selectedCount">0</span> rows, Total: <span id="selectedTotal">0</span> USD
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>ID</th>
                <th>Offer Title</th>
                <th>Category</th>
                <th>Unique</th>
                <th>Clicks</th>
                <th>Leads</th>
                <th>Approved</th>
                <th>Pending</th>
                <th>Declined</th>
                <th>Paid</th>
                <th>Approved Amount</th>
                <th>Pending Amount</th>
                <th>Declined Amount</th>
                <th>Paid Amount</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody id="conversionTableBody">
              <!-- Rows will be dynamically added here -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="transferToPayment" disabled>Transfer to Payment</button>
      </div>
    </div>
  </div>
</div>

<!-- Detail Payment Modal -->
<div class="modal fade" id="detailPaymentModal" tabindex="-1" aria-labelledby="detailPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailPaymentModalLabel">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Offer Title</th>
                <th>Unique</th>
                <th>Clicks</th>
                <th>Leads</th>
                <th>Approved</th>
                <th>Approved Amount</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody id="detailPaymentContent">
              <!-- Rows will be dynamically added here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-xl {
    max-width: 90%;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .table th,
  .table td {
    white-space: nowrap;
    text-align: center;
  }
</style>

<script>
  $(document).ready(function() {
    const MINIMUM_AMOUNT = 2;

    function updateSelectedInfo() {
      let selectedCount = 0;
      let selectedTotal = 0;

      $('.rowCheckbox:checked').each(function() {
        selectedCount++;
        const amount = parseFloat($(this).closest('tr').find('td:nth-child(12)').text().replace('$', '').trim()) || 0;
        selectedTotal += amount;
      });

      $('#selectedCount').text(selectedCount);
      $('#selectedTotal').text(selectedTotal.toFixed(2));

      const infoBox = $('#selectedInfo');
      const transferButton = $('#transferToPayment');

      if (selectedCount > 0) {
        infoBox.show();
        if (selectedTotal >= MINIMUM_AMOUNT) {
          infoBox.removeClass('alert-danger').addClass('alert-success');
          transferButton.removeAttr('disabled');
        } else {
          infoBox.removeClass('alert-success').addClass('alert-danger');
          transferButton.attr('disabled', true);
        }
      } else {
        infoBox.hide();
        transferButton.attr('disabled', true);
      }
    }

    $('#selectAll').click(function() {
      const isChecked = $(this).prop('checked');
      $('.rowCheckbox').prop('checked', isChecked);
      updateSelectedInfo();
    });

    $(document).on('change', '.rowCheckbox', function() {
      updateSelectedInfo();
    });

    $('#chooseConversion').click(function() {
      loadConversionData();
    });

    function loadConversionData(options = {}) {
      const {
        url = '<?php echo base_url('v2/statistics/getApprovedLead'); ?>',
          renderSelector = '#conversionTableBody',
          loadingSelector = '#conversionModalLabel',
          data = {},
          columns = null,
          showCheckbox = true,
          onSuccess = null,
          onError = null
      } = options;

      // Định nghĩa các cột và tiêu đề đầy đủ
      const allColumns = [{
          key: 'offerid',
          label: 'ID'
        },
        {
          key: 'oname',
          label: 'Offer Title'
        },
        {
          key: 'category',
          label: 'Category'
        },
        {
          key: 'hosts',
          label: 'Unique'
        },
        {
          key: 'click',
          label: 'Clicks'
        },
        {
          key: 'lead',
          label: 'Leads'
        },
        {
          key: 'approved',
          label: 'Approved'
        },
        {
          key: 'pending',
          label: 'Pending'
        },
        {
          key: 'declined',
          label: 'Declined'
        },
        {
          key: 'payed',
          label: 'Paid'
        },
        {
          key: 'mapproved',
          label: 'Approved Amount'
        },
        {
          key: 'mpending',
          label: 'Pending Amount'
        },
        {
          key: 'mdeclined',
          label: 'Declined Amount'
        },
        {
          key: 'mpayed',
          label: 'Paid Amount'
        },
        {
          key: 'mtotal',
          label: 'Total Amount'
        }
      ];

      const showColumns = columns ?
        allColumns.filter(col => columns.includes(col.key)) :
        allColumns;

      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        data: data,
        beforeSend: function() {
          if (loadingSelector) $(loadingSelector).text('Loading Conversion');
          if (renderSelector) $(renderSelector).html(`
                    <tr>
                    <td colspan="${showColumns.length + (showCheckbox ? 1 : 0)}" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                    </tr>
                `);
        },
        success: function(response) {
          let content = '';
          if (response && response.data && response.data.length > 0) {
            response.data.forEach(item => {
              content += `<tr>`;
              if (showCheckbox) {
                content += `<td><input type="checkbox" class="rowCheckbox" value="${item.offerid}"></td>`;
              }
              showColumns.forEach(col => {
                let value = item[col.key] !== undefined ? item[col.key] : '';
                if (col.key.startsWith('m')) value = '$' + parseFloat(value).toFixed(2);
                content += `<td>${value}</td>`;
              });
              content += `</tr>`;
            });
          } else {
            content = `
                    <tr>
                        <td colspan="${showColumns.length + (showCheckbox ? 1 : 0)}" class="text-center">No approved leads found.</td>
                    </tr>`;
          }
          if (renderSelector) $(renderSelector).html(content);
          if (loadingSelector) $(loadingSelector).text('Approved Leads');
          if (onSuccess) onSuccess(response);
        },
        error: function() {
          if (renderSelector) $(renderSelector).html(`
                    <tr>
                    <td colspan="${showColumns.length + (showCheckbox ? 1 : 0)}" class="text-center text-danger">Failed to load conversion data. Please try again later.</td>
                    </tr>
                `);
          if (loadingSelector) $(loadingSelector).text('Error');
          if (onError) onError();
        }
      });
    }

    $('#selectAll').click(function() {
      $('.rowCheckbox').prop('checked', this.checked);
    });

    $('.edit_pp').click(function(e) {
      var st = $(this).attr('data-status');
      if ((st != "new_payment") && (st != "Pending")) {
        alert('This Payment is ' + st + ' !');
      } else {
        var pid = $(this).attr('data-id');
        var note = $(this).find('input[name^="note"]').text();
        var method = $(this).find('.method').text();
        if (pid) {
          $('#amount').hide();

          $('#payment_method').val(method).change();
          $('#pid').val(pid);
          $('#input_' + method).val(note);

        } else {
          $('#pid').val(0);
          $('#amount').show();
          $('#payment_method').val('pmchose').change();
        }
        $('#paymentModal').modal('show');
      }

      e.preventDefault();
    });

    $('.formpay').hide();

    $('#payment_method').on('change', function(e) {
      payoption = $(this).val();
      if (payoption) {
        if (payoption == "Bank Wire") payoption = "BankWire";
        $('.formpay').hide();
        $('#' + payoption).show();
        if (payoption == "pmchose") {
          $("#savebutton").prop("disabled", true);
        } else {
          $("#savebutton").removeAttr('disabled');
        }
      }
    });

    $('#savebutton').click(function(e) {
      e.preventDefault();

      const formData = new FormData($('.formpayment')[0]);
      const fileInput = $('#payment_image')[0].files[0];

      if (fileInput) {
        formData.append('payment_image', fileInput);
      }

      const amount = $('input[name="amount"]').val();
      const editFlag = $('input[name="pdi"]').val();
      if (amount < MINIMUM_AMOUNT && editFlag == 0) {
        alert(`Minimum amount is ${MINIMUM_AMOUNT}$`);
        return;
      }

      $.ajax({
        url: $('.formpayment').attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
          $('#savebutton').attr('disabled', true);
        },
        success: function(response) {
          alert('Payment request submitted successfully!');
          $('#paymentModal').modal('hide');
          location.reload();
        },
        error: function() {
          alert('Failed to submit payment request. Please try again.');
        },
        complete: function() {
          $('#savebutton').removeAttr('disabled');
        }
      });
    });

    $('#transferToPayment').click(function() {
      let selectedTotal = 0;
      updateOffersIdList();
      $('.rowCheckbox:checked').each(function() {
        const amount = parseFloat($(this).closest('tr').find('td:nth-child(12)').text().replace('$', '').trim()) || 0;
        selectedTotal += amount;
      });

      $('#paymentModal input[name="amount"]').val(selectedTotal.toFixed(2) + ' USD');

      $('#conversionModal').modal('hide');
      $('#paymentModal').modal('show');
    });

    function updateOffersIdList() {
      let selectedIds = [];
      $('.rowCheckbox:checked').each(function() {
        selectedIds.push($(this).val());
      });
      $('#offersIdList').val(selectedIds.join(','));
    }

    $(document).on('change', '.rowCheckbox', function() {
      updateOffersIdList();
    });

    $(document).on('click', '.btn-detail-payment', function() {
      var paymentId = $(this).data('id');
      loadConversionData({
        loadingSelector: '#detailPaymentModalLabel',
        renderSelector: '#detailPaymentContent',
        data: {
          payment_id: paymentId
        },
        columns: ['offerid', 'oname', 'hosts', 'click', 'lead', 'approved', 'mapproved', 'mtotal'],
        showCheckbox: false
      });

      $('#detailPaymentModal').modal('show');

    });
  });
</script>
<style>
  #selectedInfo {
    font-weight: bold;
    margin-bottom: 15px;
  }

  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
  }

  .alert-success {
    background-color: #d4edda;
    color: #155724;
  }

  .tt {
    margin-bottom: 20px;
    font-weight: bold;
    display: block
  }

  .Reverse {
    background-color: #c5577d !important;
  }

  .Pending {
    background-color: #ad7e30 !important;
  }

  * {
    box-sizing: border-box;
  }

  div,
  span,
  a {
    margin: 0px;
    padding: 0px;
    border: 0px;
    font-size: 100%;
    vertical-align: baseline;
  }

  .fbiYMC {
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    width: 230px;
    max-width: 450px;
    position: relative;
    transition: width 0.1s ease 0s;
  }

  @media (max-width: 425px) {
    .fbiYMC {
      width: 100%;
    }
  }

  .cRFcPy {
    outline: 0px;
    border: 0px;
    height: 33px;
    font-size: 0.9em;
    padding: 0px 35px 0px 10px;
    background-color: rgb(236, 236, 238);
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    width: 100%;
    border-radius: 2px;
    color: rgb(62, 62, 73);
  }

  .cRFcPy::-webkit-input-placeholder {
    color: rgb(153, 153, 153);
  }

  .cRFcPy:focus {
    padding: 0px 60px 0px 10px;
  }

  .cRFcPy:focus::-webkit-input-placeholder {
    color: transparent;
  }

  .eWBLfl {
    color: rgb(166, 166, 166);
    position: absolute;
    right: 10px;
    width: 20px;
    height: 20px;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    border: 1px solid rgb(187, 187, 187);
    border-radius: 2px;
  }

  @media (max-width: 425px) {
    .eWBLfl {
      display: none;
    }
  }

  .kavdHi {
    position: absolute;
    right: 8px;
    top: 8px;
    color: rgb(62, 62, 73);
    display: none;
  }

  @media (max-width: 425px) {
    .kavdHi {
      display: block;
    }
  }

  .bfwcis {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
    margin-bottom: 7px;
    padding: 12px 15px;
    border-radius: 3px;
    background-color: rgb(255, 255, 255);
    color: rgb(0, 0, 0);
    box-shadow: rgba(0, 0, 0, 0.17) 0px 2px 7px 0px;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s ease 0s;
  }

  .bfwcis:hover {
    transform: scale(0.99);
  }

  @media (max-width: 768px) {
    .bfwcis {
      flex-direction: column;
      align-items: flex-start;
    }
  }

  .fYJXyK {
    width: 25%;
    padding-right: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  @media (max-width: 768px) {
    .fYJXyK {
      width: 100%;
      margin-bottom: 10px;
      padding-right: 0px;
    }
  }

  .iYdzkK {
    width: 20%;
  }

  @media (max-width: 768px) {
    .iYdzkK {
      width: 100%;
      margin-bottom: 10px;
      padding-right: 0px;
    }
  }

  .hERdbK {
    width: 15%;
    color: rgb(131, 131, 131);
  }

  @media (max-width: 768px) {
    .hERdbK {
      width: 100%;
      margin-bottom: 10px;
      padding-right: 0px;
    }
  }

  .hERdbK>span {
    padding-left: 3px;
  }

  .fTkPgh {
    width: 25%;
    padding-right: 10px;
  }

  @media (max-width: 768px) {
    .fTkPgh {
      width: 100%;
      margin-bottom: 10px;
      padding-right: 0px;
    }
  }

  .dhYqaO {
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    width: 15%;
    padding: 2px 7px;
    border-radius: 3px;
    background-color: rgb(73, 142, 68);
    color: rgb(255, 255, 255);
    text-transform: uppercase;
    text-align: center;
    font-size: 12px;
  }

  @media (max-width: 768px) {
    .dhYqaO {
      width: auto;
      margin-bottom: 0px;
    }
  }

  .uHLlo {
    margin-top: 20px;
  }

  .hrvHfq {
    flex: 1 1 0%;
  }

  ._1ykwro3W9x7ktXduniR6Cp {
    background-color: inherit;
    display: inline-block;
  }

  ._2zZKiYIMOuyWJddFzI_uHV {
    font-size: 1.6em;
    padding: 5px 0 15px;
  }

  .css-1didjui {
    text-transform: capitalize;
    font-size: 18px;
    color: rgb(102, 102, 102);
  }
</style>