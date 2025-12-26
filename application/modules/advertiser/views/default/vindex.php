<?php
$pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
$advertiser = $this->session->userdata('user');
$avatar = (!empty($advertiser->avatar_url))
    ? base_url($advertiser->avatar_url)
    : base_url('temp/default/images/avt_unknow.jpeg');
$site_name = $pub_config['sitename'];
$logo =  $pub_config['logo'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta property="og:image" content="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <link rel="icon" href="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png">
    <title>Worldwide Affiliate</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>temp/default/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->

    <link href="<?php echo base_url(); ?>/temp/default/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/hover.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/search-header.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/temp/default/css/login.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/temp/default/js/multiple/jquery-3.2.1.min.js" type="text/javascript">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" type="text/javascript"></script>


    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
        integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



</head>

<body>
    <div class="mask_mbnav" id="anhienmenu"></div>
    <header class="mb-3 border-bottom navbar-dark fixed-top topmenu">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
        <button type="button" class="button_mb_nav-d d-none" data-bs-toggle="collapse" data-bs-target="#anhienmenu">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

                <!-- lastest code -->
                <!-- <a href="<?php echo base_url('v2'); ?>" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none col-6 logo_img_wrap"> -->

                <!-- new code -->
                <a href="<?php echo base_url('v2'); ?>">
                    <img src="<?php echo base_url(); ?>/upload/files/website_logo_waff_png.png" alt="Logo" class="logo">
                </a>
                <nav class="nav_u_profil navbar-expand-lg col-8 d-flex">
                    <?php
          if ($this->session->userdata('userid')) {
            include APPPATH . '/views/default/topbar.php';
          }
          ?>
                    <?php
          $where = "receiver = {$this->session->userdata('user')->id} AND is_adv = 1 AND mark_as_read = 0";
          $unread_notifications = $this->Home_model->get_number('notifications', $where);
          ?>
                </nav>
                <div class="nav_u_profil me-4 pe-1">
                    <div class="dropdown m-auto col-3 mx-3 d-flex d-row">

            <a class="fs-6 d-flex align-items-center" style="text-decoration: none" href="<?php echo base_url('v2/notifications'); ?>">
                            <i class="widget-icon fa fa-bell " style="color:black; font-size:20px"></i>
              <span class="bell-number" style="font-size:30px" data-count="<?= $unread_notifications ?>"></span>
                        </a>

                        <a class="nav-link dropdown-toggle fs-6" id="dropdownUser1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?=$avatar ?>" width="30" height="30" class="rounded-circle">
                        </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1" style="right:0px !important">
                            <li>
                                <p style="font-size:10px;margin: 0px" class="text-center">
                                    <?= $advertiser->email . ' (' . $advertiser->id . ')'; ?>

                                </p>
                            </li>
              <li><a style="font-size:12px" class="dropdown-item" href="<?php echo base_url('v2/profile/profile'); ?>">Profile</a></li>
                            <!-- <li><a style="font-size:12px" class="dropdown-item" href="">Request a product</a></li> -->
                            <li><a style="font-size:12px" class="dropdown-item" id="referBtn" href="#">Refer a
                                    Friend</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a style="font-size:12px" class="dropdown-item" href="#">English</a></li>
              <li><a style="font-size:12px" class="dropdown-item" href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/1') ?>">Help and
                                    Support</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
              <li><a style="font-size:12px" class="dropdown-item" href="<?php echo base_url('v2/logout'); ?>">Sign out</a></li>

                        </ul>

                        <script>
                        $(document).ready(function() {
                            var firstName = $('#firstName').text();
                            var lastName = $('#lastName').text();
                            var intials = firstName.charAt(0) + lastName.charAt(0);
                            var profileImage = $('#profileImage').text(intials);
                        });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container-fluid  overflow-auto mx-2 mt-5">
            <!-- vdashboard--->
            <?php
      if (!empty($content)) echo $content;
      ?>
            <!--end vdashboard--->
        </div>
    </main>

    <!-- modal reference -->
  <div class="modal fade" id="modalRefer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Refer a friend</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
            <input type="text" class="form-control" readonly="true" id="refer" value="<?php echo base_url($this->uri->segment(1) . '/advertiser/sign-up?ref=' . $advertiser->ref_pub_token) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-copy" type="button">
                                <i>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13">
                                        <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M272 0H396.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9V336c0 26.5-21.5 48-48 48H272c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128H192v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z" />
                                    </svg>
                                </i>
                            </button>
                        </div>
                    </div>
                    <p class="note">You will get a <strong>3%</strong> increase on the total payment of the publisher
                        you refer to work
                        with
                        <strong>Wedebeek</strong>.
                    </p>
                    <div class="refs">
                        <p>Users ref your link</p>
                        <ul>
                            <?php foreach ($this->session->userdata('refs') as $ref) : ?>
                            <li><?php echo $ref; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php ?>
                    <style>
                    .refs p {
                        color: var(--bs-blue);
                        font-weight: bold;
                        font-size: 14px;
                        padding: 0 5px;
                    }

                    .note {
                        color: #ff0000d6;
                        font-weight: 400;
                        font-size: 14px;
                        padding: 0 5px;
                    }

                    .btn-copy svg {
                        fill: white;
                    }

                    .btn-copy {
                        width: 60px;
                        background-color: #3d76b9;
                        color: #fff;
                    }
                    </style>
                </div>
                <div class="modal-footer">
                    <button class="btn-cus close" data-bs-dismiss="modal">
                        <span class="btn-text">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script>
    const myModalRefer = new bootstrap.Modal(document.getElementById('modalRefer'), {
        keyboard: false
    })
    $("#referBtn").on('click', (e) => {
        e.preventDefault();
        myModalRefer.show()
    })
    $(".btn-copy").on('click', () => {
        const value = $('#refer').val();
        copyToClipboard(value)
    })
    const copyToClipboard = (data) => {
        if (window.isSecureContext && navigator.clipboard) {
            navigator.clipboard.writeText(data);
        } else {
            unsecuredCopyToClipboard(data);
        }
    };
    const unsecuredCopyToClipboard = (data) => {
        var $temp = $("<input type='hidden'>");
        $("body").append($temp);
        $temp.val(data).focus().select();
        $temp.remove();
    };
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>