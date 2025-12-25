<style>
  .tb_content th {
    text-align: center;
    background: #EEEEEE;
    padding: 5px;
  }

  .tb_content {
    width: 100%;
    border-collapse: separate;
    border-spacing: 2px;
    margin-top: 0px;
    position: relative;
  }

  .tb_content td {
    display: table-cell;
    border-bottom: 1px dotted #CCCCCC;
    color: #000000;
    padding: 10px 0px 10px 10px;
    background-color: #f7f7fb;
    vertical-align: middle;
  }

  .tb_content .tb_check {
    width: 20px;
    text-align: center;
    padding: 5px;
    background: #EEEEEE;
  }

  .tb_content .span30 {
    width: 30px;
    cursor: pointer;
  }
</style>
<table class="tb_content clearfix">
  <tr>
    <th></th>
    <th></th>
  </tr>
  <tr>
    <td class="dd">Change password</td>
    <td>
      <form action="<?php echo base_url() . $this->config->item('admin') . '/advertiser/update_advertiser/' . $advertiser->id; ?>" method="POST">
        <input name="password" type="text" /> <input type="submit" />
      </form>
    </td>
  </tr>
  <tr>
    <td class="dd">First Name</td>
    <td><?php echo $advertiser->first_name ?></td>
  </tr>
  <tr>
    <td class="dd">Last Name</td>
    <td><?php echo $advertiser->last_name; ?></td>
  </tr>
  <tr>
    <td class="dd">Email</td>
    <td><?php echo $advertiser->email; ?></td>
  </tr>
  <tr>
    <td class="dd">Address</td>
    <td><?php echo $advertiser->address; ?></td>
  </tr>
  <tr>
    <td class="dd">Phone Nubmer</td>
    <td><?php echo $advertiser->phone; ?></td>
  </tr>
  <tr>
    <td class="dd">Social Network</td>
    <td><?php echo $advertiser->social_network; ?></td>
  </tr>
  <tr>
    <td class="dd">Website</td>
    <td><?php echo $advertiser->website; ?></td>
  </tr>
</table><!-- end table content-->