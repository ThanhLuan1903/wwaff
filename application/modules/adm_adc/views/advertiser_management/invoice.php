<table class="table table-striped table-hover table-bordered okdt">
  <tr>
    <th>Id</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Note</th>
    <th>Date</th>
  </tr>
  <tbody>
    <?php foreach($invoices as $invoice): ?>
      <tr>
        <td><?= $invoice->id ?></td>
        <td><?= $invoice->amount ?></td>
        <td><?= $invoice->status ?></td>
        <td><?= $invoice->note ?></td>
        <td><?= $invoice->date ?></td>
        <td>
          <button type="button" data-id="<?= $invoice->id ?>" data-status="Complete" class="btn btn-success btn-xs update-status-invoice" <?= $invoice->status !== 'Pending' ? 'disabled' : '' ?>>Complete</button>
          <button type="button" data-id="<?= $invoice->id ?>" data-status="Reverse" class="btn btn-warning btn-xs update-status-invoice" <?= $invoice->status !== 'Pending' ? 'disabled' : '' ?>>Reverse</button>
          <button data-id="<?= $invoice->id ?>" class="btn btn-danger btn-xs delete-invoice">
            <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
          </button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<script>
  $(document).ready(function() {
    update_status_invoice();
    delete_invoice();
  });

  function update_status_invoice() {
    $('.update-status-invoice').click(function() {
      const status = $(this).data('status')
      const id = $(this).data('id');

      $.ajax({
        type: "POST",
        url: '<?= base_url($this->config->item('admin') . '/advertiser/update_status_payment') ?>',
        data: { id, status },
        success: function(response) {
          if (response == 1) {
            location.reload();
          }
        }
      });
    });
  }
  function delete_invoice() {
    $('.delete-invoice').click(function() {
      const id = $(this).data('id');
      const is_delete = true;
      $.ajax({
        type: "POST",
        url: '<?= base_url($this->config->item('admin') . '/advertiser/update_status_payment') ?>',
        data: { id, is_delete },
        success: function(response) {
          if (response == 1) {
            location.reload();
          }
        }
      });
    });
  }


</script>