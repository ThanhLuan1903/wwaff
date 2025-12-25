<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>adminmmo</title>
   <link href="<?php echo base_url(); ?>temp/admin/css/bootstrap.min.css" rel="stylesheet" />
   <link href="<?php echo base_url(); ?>temp/admin/css/bootstrap-theme.min.css" rel="stylesheet" />
   <link href="<?php echo base_url(); ?>temp/admin/css/style.css" rel="stylesheet" />
   <script>
      var manger = "<?php echo base_url($this->config->item('manager')); ?>/";
      var base_url = "<?php echo base_url(); ?>";
      var order = new Array();
      <?php $order = $this->session->userdata('order'); ?>
      order['0'] = "<?php echo @$order['0']; ?>";
      order['1'] = "<?php echo @$order['1']; ?>";
   </script>
   <script src="<?php echo base_url(); ?>temp/admin/js/jquery.min.js"></script>
   <script src="<?php echo base_url(); ?>temp/admin/js/bootstrap.min.js"></script>
</head>

<body>
   <?php echo $content; ?>
</body>

</html>