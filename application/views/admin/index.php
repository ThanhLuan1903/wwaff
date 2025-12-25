<?php session_start();
$_SESSION['upanh'] = $this->session->userdata('upanh');
$_SESSION['url'] = '/upload/';
$query = $this->db->where('trangthai', 0)->get('contact');
$lienhemoi = $query ? $query->num_rows() : null;
if (empty($lienhemoi)) {
   $lienhecu = $this->db->where('trangthai', 1)->get('contact')->num_rows();
}

?>
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
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
   <script>
      var base_url = "<?php echo base_url(); ?>";
      var adminurl = "<?php echo base_url($this->config->item('admin')); ?>/";
      var order = new Array();
      <?php $order = $this->session->userdata('order'); ?>
      order['0'] = "<?php echo @$order['0']; ?>";
      order['1'] = "<?php echo @$order['1']; ?>";
   </script>
   <script src="<?php echo base_url(); ?>temp/admin/js/jquery.min.js"></script>
   <script src="<?php echo base_url(); ?>temp/admin/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>temp/admin/js/tooltip.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<body>
   <?php $acc = unserialize($userData->mailling);  ?>
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#anhien">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
               <img alt="" class="pull-left" src="<?php echo $this->session->userdata('adavata'); ?>" />
               <span class="pull-left hidden-xs"><?php echo $this->pub_config['sitename']; ?></span>
            </a>
         </div>
         <div class="collapse navbar-collapse" id="anhien">
            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown hidden-xs parentli">
                  <a href="<?php echo base_url(); ?>" class="btn dropdown-toggle">
                     <i style="color: blue;" class="glyphicon glyphicon-eye-open"></i>
                     <span class="label label-warning hidden-xs">viewsite</span>
                  </a>
               </li>

               <li class="parentli">
                  <a href="#" class="dropdown-toggle btn-setting" data-toggle="dropdown">
                     <i class=" glyphicon glyphicon-wrench"></i>
                  </a>
               </li>
               <li class="parentli">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <span class="glyphicon glyphicon-user"></span>
                     <span class="caret"></span>
                  </a>
               </li>
               <li><a href="<?php echo base_url($this->config->item('admin')); ?>/logout"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
            </ul>
         </div>
      </div>
   </nav>

   <div class="container-fluid wrapper1">
      <div class="row">
         <?php include('left_menu.php'); ?>
         <div class="col-sm-11 col-xs-11 col-md-10 noidung">
            <ul class="breadcrumb">
               <?php if (!empty($breadcrumb)) {
                  echo $breadcrumb;
               } else { ?>
                  <li>
                     <a href="#">Home</a>
                  </li>
                  <li>
                     <a href="#">Tables</a>
                  </li>
               <?php } ?>
            </ul>
            <hr />
            <?php if (!empty($content)) {
               echo $content;
            } ?>
         </div>
         <div style="margin-top: 40px;" class="modal fade userview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     <h4 class="modal-title" id="myModalLabel">Affiliate </h4>
                  </div>
                  <div class="modal-body cusermodal">
                  </div>
               </div>
            </div>
         </div>

         <div style="margin-top: 40px;" class="modal fade adv_view" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     <h4 class="modal-title" id="myModalLabel">Advertiser </h4>
                  </div>
                  <div class="modal-body cadvmodal">
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Setting</h4>
               </div>
               <div class="modal-body">
                  <!--form setting--->
                  <form class="form-horizontal form_setting" role="form" id="form_setting">
                     <div class="form-group">
                        <div class="col-sm-3" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-send"></span></span>
                              <select class="form-control" id="activeemail" name="activate">
                                 <option value="0">off</option>
                                 <option value="1" <?php if ($this->pub_config['activate']) echo 'selected'; ?>>on</option>
                              </select>
                           </div>
                        </div>
                        <label for="activeemail" class="col-sm-3 control-label" style="padding-left: 0px;"><span class="label label-primary">Email active</span></label>
                        <div class="col-sm-4">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                              <input type="text" class="form-control" id="minpay" placeholder="Minpay" value="<?php echo $this->pub_config['minpay'] ?>" name="minpay" />
                           </div>
                        </div>
                        <label for="minpay" class="col-sm-2 control-label"><span class="label label-warning">Minpay</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-10">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-book"></span></span>
                              <input type="text" class="form-control" id="sitename" placeholder="Sitename" value="<?php echo $this->pub_config['sitename'] ?>" name="sitename" />
                           </div>
                        </div>
                        <label for="sitename" class="col-sm-2 control-label"><span class="label label-success">Sitename</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-10">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                              <input type="email" class="form-control" id="inputEmai" placeholder="Email" value="<?php echo $this->pub_config['emailadmin'] ?>" name="emailadmin" />
                           </div>
                        </div>
                        <label for="inputEmai" class="col-sm-2 control-label"><span class="label label-success">Email</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-10">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-camera"></span></span>
                              <input type="text" class="form-control" id="xFilePath" placeholder="Logo" value="<?php echo $this->pub_config['logo'] ?>" name="logo" />
                              <span class="input-group-btn">
                                 <button class="btn btn-default" type="button" onclick="BrowseServer();">upload</button>
                              </span>
                           </div>
                        </div>
                        <label for="xFilePath" class="col-sm-2 control-label"><span class="label label-success">Logo</span></label>
                     </div>
                     <div class="form-group hide">
                        <div class="col-sm-10">
                           <textarea class="form-control" rows="5" name="termsinfo"><?php echo $this->pub_config['termsinfo'] ?></textarea>
                        </div>
                        <label for="" class="col-sm-2 control-label"><span class="label label-danger">Terms..</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-screenshot"></span></span>
                              <input type="text" class="form-control" id="rate" placeholder="Rate" value="<?php echo $this->pub_config['rate'] * 100 ?>" name="rate" />
                           </div>
                        </div>
                        <label for="minpay" class="col-sm-2 control-label"><span class="label label-success">Rate default</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-screenshot"></span></span>
                              <select class="form-control" id="activeemail" name="checkip">
                                 <?php $cip = file_get_contents("setting_file/cip.txt"); ?>
                                 <option value="0">off</option>
                                 <option value="1" <?php if ($cip == 1) echo 'selected'; ?>>Check Ip click</option>
                                 <option value="2" <?php if ($cip == 2) echo 'selected'; ?>>Check Ip Lead</option>
                                 <option value="3" <?php if ($cip == 3) echo 'selected'; ?>>Check Ip Lead + Click</option>
                              </select>
                           </div>
                        </div>
                        <label for="minpay" class="col-sm-2 control-label"><span class="label label-success">Check Ip Click/Lead</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-screenshot"></span></span>
                              <select class="form-control" id="activeemail" name="indexpage">
                                 <?php $cip = $this->pub_config['indexpage']; ?>
                                 <option value="0" <?php if ($cip == 0) echo 'selected'; ?>>index1</option>
                                 <option value="1" <?php if ($cip == 1) echo 'selected'; ?>>index2</option>
                              </select>
                           </div>
                        </div>
                        <label for="minpay" class="col-sm-2 control-label"><span class="label label-success">Index Page</span></label>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-screenshot"></span></span>
                              <select class="form-control" id="" name="strictness">
                                 <?php $strictness = file_get_contents("setting_file/strictness.txt"); ?>
                                 <option value="0" <?php if ($strictness == 0) echo 'selected'; ?>>0</option>
                                 <option value="1" <?php if ($strictness == 1) echo 'selected'; ?>>1</option>
                                 <option value="2" <?php if ($strictness == 2) echo 'selected'; ?>>2</option>
                                 <option value="3" <?php if ($strictness == 3) echo 'selected'; ?>>3</option>
                              </select>
                           </div>
                        </div>
                        <label for="minpay" class="col-sm-2 control-label"><span class="label label-success">Strictness</span></label>
                     </div>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="setting_save">Save changes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="smartlink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="myModalLabel">Smartlink</h4>
               </div>
               <div class="modal-body">
                  <!--form --->
                  <form class="form-horizontal form_smartlink" role="form" id="form_smartlink">
                     <div class="form-group">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-send"></span></span>
                              <?php
                              $smlink = unserialize(file_get_contents("setting_file/smartlink.txt"));
                              ?>
                              <select class="form-control" id="atcsm" name="type">
                                 <option value="0">Off</option>
                                 <option value="1" <?php if ($smlink['type'] == 1) echo 'selected'; ?>>Redirect</option>
                                 <option value="2" <?php if ($smlink['type'] == 2) echo 'selected'; ?>>Custom link</option>
                              </select>
                           </div>
                        </div>
                        <label for="atcsm" class="col-sm-3 control-label" style="padding-left: 0px;"><span class="label label-primary">Smartlink Type</span></label>
                     </div>

                     <div class="form-group chide">
                        <div class="col-sm-4" style="padding-right: 5px;">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-random"></span></span>
                              <select class="form-control" id="network" name="network">
                                 <?php
                                 $network = $this->Home_model->get_data('network', array('show' => 1));
                                 if ($network) {
                                    foreach ($network as $network) {
                                       if ($smlink['network'] == $network->id) {
                                          $sl = "selected";
                                       } else {
                                          $sl = '';
                                       }
                                       echo '<option ' . $sl . ' value="' . $network->id . '">' . $network->title . '</option>';
                                    }
                                 }
                                 ?>

                              </select>
                           </div>

                        </div>

                        <div class="col-sm-4">
                           <div class="input-group">
                              <span class="input-group-addon">%</span>
                              <input type="text" class="form-control" id="percent" placeholder="Percent" value="100" name="percent">
                           </div>
                        </div>
                        <label for="percent" class="col-sm-2 control-label"><span class="label label-info">Network - Percent</span></label>
                     </div>


                     <div class="form-group chide">
                        <div class="col-sm-10">
                           <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                              <input type="text" class="form-control" id="smlink" placeholder="Sitename" value="<?php if ($smlink['smlink']) echo $smlink['smlink'] ?>" name="smlink" />
                           </div>
                        </div>
                        <label for="smlink" class="col-sm-2 control-label"><span class="label label-success">Smartlink</span></label>
                     </div>
                  </form>
                  <!--end form -->
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="smartlink_save">Save changes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <footer class="footer">
      <div class="container-fluid">
         <p class="text-muted">cpaleadz.com</p>
         <span style="text-align:left;float:left">&copy; <a href="" target="_blank">creativeLabs</a> 2015</span>
      </div>
   </footer>
   <?php
   echo '
          <!--ckeditor-->
         <script type="text/javascript" src="' . base_url() . 'ckeditor/ckeditor.js"></script>
         <script type="text/javascript" src="' . base_url() . 'ckeditor/ckfinder/ckfinder.js"></script>
         <script type="text/javascript" src="' . base_url() . 'temp/admin/js/ck_type.js"></script>
         ';
   if ($this->uri->segment(3) == 'network') {
      echo '
           <script type="text/javascript" src="' . base_url() . 'temp/admin/js/network_edit.js"></script>
           ';
   }
   ?>
   <script type="text/javascript" src="<?php echo base_url(); ?>temp/admin/js/custom.js">
   </script>
</body>

</html>