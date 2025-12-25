<style>
  .tickets-container .tickets-list .ticket-item .ticket-state i {
    font-size: 13px;
    color: #fff;
    line-height: 20px;
  }

  .tickets-container .tickets-list .ticket-item .ticket-state {
    position: absolute;
    top: 13px;
    right: -12px;
    height: 24px;
    width: 24px;
    -webkit-border-radius: 50%;
    -webkit-background-clip: padding-box;
    -moz-border-radius: 50%;
    -moz-background-clip: padding;
    border-radius: 50%;
    background-clip: padding-box;
    background-color: #e5e5e5;
    text-align: center;
    -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .2);
    -moz-box-shadow: 0 0 3px rgba(0, 0, 0, .2);
    box-shadow: 0 0 3px rgba(0, 0, 0, .2);
    border: 2px solid #fff;
  }

  .bg-palegreen {
    background-color: #a0d468 !important;
  }

  .tickets-container .tickets-list .ticket-item .ticket-type .type {
    color: #999;
    font-size: 11px;
    text-transform: uppercase;
  }

  .tickets-container .tickets-list .ticket-item .ticket-type {
    line-height: 30px;
    height: 50px;
    padding: 10px;
  }

  .tickets-container .tickets-list .ticket-item .ticket-time i {
    color: #ccc;
    width: 50px;
  }

  .tickets-container .tickets-list .ticket-item .divider {
    position: absolute;
    top: 0;
    left: 0;
    height: 50px;
    width: 1px;
    background-color: #eee;
    display: inline-block;
  }

  .tickets-container .tickets-list .ticket-item .ticket-time {
    line-height: 30px;
    height: 50px;
    padding: 10px;
  }

  .tickets-container .tickets-list .ticket-item .ticket-user .user-company {
    margin-left: 2px;
    color: #999;
  }

  .tickets-container .tickets-list .ticket-item .ticket-user .user-at {
    margin-left: 2px;
    color: #ccc;
    font-size: 13px;
  }

  .tickets-container .tickets-list .ticket-item .ticket-user .user-name {
    margin-left: 5px;
    font-size: 13px;
  }

  .tickets-container .tickets-list .ticket-item .ticket-user .user-avatar {
    width: 30px;
    height: 30px;
    -webkit-border-radius: 3px;
    -webkit-background-clip: padding-box;
    -moz-border-radius: 3px;
    -moz-background-clip: padding;
    border-radius: 3px;
    background-clip: padding-box;
  }

  .tickets-container .tickets-list .ticket-item .ticket-user {
    height: 50px;
    padding: 10px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  .widget-main.no-padding {
    padding: 0;
  }

  .widget-main {
    padding: 12px;
  }

  .no-padding {
    padding: 0 !important;
  }

  .widget-body {
    background-color: #fbfbfb;
    -webkit-box-shadow: 1px 0 10px 1px rgba(0, 0, 0, .3);
    -moz-box-shadow: 1px 0 10px 1px rgba(0, 0, 0, .3);
    box-shadow: 1px 0 10px 1px rgba(0, 0, 0, .3);
  }

  .widget-header>.widget-caption {
    line-height: 33px;
    padding: 0;
    margin: 0;
    float: left;
    text-align: left;
    font-weight: bold;
    font-size: 15px;
  }

  .widget-header .widget-icon {
    display: block;
    width: 30px;
    height: 32px;
    position: relative;
    float: left;
    font-size: 111%;
    line-height: 32px;
    text-align: center;
    margin-left: -10px;
  }

  .themesecondary {
    color: #5bc0de !important;
  }

  .widget-header.bordered-bottom {
    border-bottom: 3px solid #fff;
  }

  .widget-header {
    position: relative;
    min-height: 35px;
    background: #fff;
    -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, .3);
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, .3);
    box-shadow: 0 0 4px rgba(0, 0, 0, .3);
    color: #555;
    padding-left: 12px;
    text-align: right;
  }

  .bordered-themesecondary {
    border-color: #5bc0de !important;
  }

  .widget-box {
    padding: 0;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    margin: 3px 0 30px 0;
  }

  .bell-number[data-count]:after {
    position: absolute;
    right: 0%;
    top: 1%;
    content: attr(data-count);
    font-size: 30%;
    padding: .6em;
    border-radius: 999px;
    line-height: .75em;
    color: white;
    background: rgba(255, 0, 0, .85);
    text-align: center;
    min-width: 2em;
    font-weight: bold;
    width: none !important;
    height: none;
  }

  .empty-notification {
    padding: 40px 20px;
    text-align: center;
    color: #6c757d;
    font-size: 16px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    margin: 20px 0;
  }

  .empty-notification i {
    font-size: 48px;
    color: #5bc0de;
    margin-bottom: 15px;
    display: block;
  }

  .empty-notification .message {
    font-weight: 500;
    margin-bottom: 8px;
  }

  .empty-notification .sub-message {
    font-size: 14px;
    color: #adb5bd;
  }
</style>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="container bootstrap snippets bootdey">
  <div class="row">
    <div class="row">
      <div class="col-md-12">
        <div class="widget-box">
          <div class="widget-header bordered-bottom bordered-themesecondary">
            <i class="widget-icon fa fa-bell themesecondary"></i>
            <h2 class="widget-caption themesecondary" style="font-weight: bold">NOTIFICATIONS</h2>
          </div><!--Widget Header-->
          <div class="widget-body">
            <br>
            <div class="container">
              <div class="row">
                <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                  <thead style="background:#dee2e6" style="">
                    <tr style="cursor:pointer">
                      <th>
                        <div class="d-flex align-item-center justify-content-between">
                          <span>NO.</span>
                          <i class="fa fa-sort"></i>
                        </div>
                      </th>
                      <th>
                        <div class="d-flex align-item-center justify-content-between">
                          <span>SUBJECT</span>
                          <i class="fa fa-sort"></i>
                        </div>
                      </th>
                      <th>
                        <div class="d-flex align-item-center justify-content-between">
                          <span><i class="fa fa-clock-o"></i> CREATE</span>
                          <i class="fa fa-sort"></i>
                        </div>
                      </th>
                      <th>
                        <div class="d-flex align-item-center justify-content-between">
                          <span><i class="fa fa-clock-o"></i> LAST UPDATE</span>
                          <i class="fa fa-sort"></i>
                        </div>
                      </th>
                      <th>
                        <div class="d-flex align-item-center justify-content-between">
                          <span>TYPE</span>
                          <i class="fa fa-sort"></i>
                        </div>
                      </th>
                      <th>
                        <span>MARK READ </span>
                        <i class="fa fa-envelope-open-o" style="color: black;font-size:10px;"></i>
                      </th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    if ($notifications) {
                      foreach ($notifications as $noti) :
                    ?>
                        <tr>
                          <td>#<?= $noti->id ?></td>
                          <td><a data-id="<?= $noti->id; ?>" class="click-to-read" href="<?= !empty($noti->link) ? $noti->link : '#' ?>" style="font-weight: <?= $noti->mark_as_read == 0 ? 'bold' : 'normal' ?>;text-decoration: none;"><?= $noti->title ?></a>
                            <br><?= $noti->short_description ?>
                          </td>
                          <td><?= $noti->created_at ?></td>
                          <td><?= $noti->updated_at ?></td>
                          <td><?= $noti->category ?></td>
                          <td style="text-align: center;">
                            <?php if ($noti->mark_as_read == 0) : ?>
                              <input type="checkbox" class="mark-as-read" value="<?= $noti->id; ?>">
                            <?php elseif ($noti->mark_as_read != 0) : ?>
                              <i class="fa fa-envelope-open-o" style="color: #5bc0de;font-size:20px;"></i>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php
                      endforeach;
                    } else { ?>
                      <tr>
                        <td colspan="6" class="empty-notification">
                          <i class="fa fa-bell-slash"></i>
                          <div class="message">No notifications yet</div>
                          <div class="sub-message">Check back later!</div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    handleMarkAsRead('.mark-as-read');
    handleMarkAsRead('.click-to-read');
  });

  const handleMarkAsRead = (element) => {
    $(element).click(function() {
      event.preventDefault();
      const domEl = $(this);
      const url = `<?= base_url() ?>/v2/notifications/mark-as-read`;
      const id = $(this).val() !== '' ? $(this).val() : $(this).data('id');
      const link = $(this).attr('href');
      const isCheckBox = $(this).is('input');

      $.ajax({
        method: 'POST',
        url,
        data: {
          id
        },
        success: function(response) {
          if (isCheckBox) {
            domEl.parent().html('<i class="fa fa-envelope-open-o" style="color: #5bc0de;font-size:20px;"></i>');
            showToast('success', 'Updated Successfully');
          } else {
            domEl.closest('tr').find('.mark-as-read').parent().html('<i class="fa fa-envelope-open-o" style="color: #5bc0de;font-size:20px;"></i>');
            location.href = link;
          }
        },
        error: function(error) {
          showToast('error', 'OOP! Errors');
        }
      })
    });
  }
</script>