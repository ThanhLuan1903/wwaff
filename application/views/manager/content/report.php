<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    $(function() {
        $("#startdate").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#enddate").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    $(document).ready(function() {
        if ($(".vpub").is(':checked'))
            $('.checkpub').show();

    })
</script>

<style>
    .table,
    .table th,
    .table td,
    .table thead tr th,
    .table tbody tr td {
        font-size: 14px !important;
        padding: 10px !important;
        vertical-align: middle;
    }

    .table thead th {
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td:nth-child(2) {
        text-align: left;
    }


    .rp_fitter {
        width: 640px;
        margin: 10px auto;
    }

    .form-inline .form-group,
    .form-inline span.form-group {
        flex: 1;
        padding: 0 5px;
        box-sizing: border-box;
    }

    #startdate,
    #enddate {
        width: 110px;
        height: 32px;
        box-sizing: border-box;
        padding: 5px;
        border: 1px solid#cccccc;
    }

    .form-inline input.form-control,
    .form-inline select.form-control {
        width: 110px;
        height: 32px;
        box-sizing: border-box;
    }

    .form-inline label {
        display: block;
        margin-bottom: 5px;
    }

    /* Responsive cho màn hình nhỏ */
    @media (max-width: 992px) {
        .form-inline {
            flex-wrap: wrap;
        }

        .form-inline .form-group,
        .form-inline span.form-group {
            flex: 0 0 33.33%;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 768px) {

        .form-inline .form-group,
        .form-inline span.form-group {
            flex: 0 0 50%;
        }
    }

    @media (max-width: 576px) {

        .form-inline .form-group,
        .form-inline span.form-group {
            flex: 0 0 100%;
        }
    }

    input.vpub[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-left: 10px;
        vertical-align: middle;
        cursor: pointer;
        position: relative;
        top: -2px;
    }

    .label-success {
        font-size: 14px;
        padding: 5px 10px;
        vertical-align: middle;
    }

    span.form-group .label {
        display: inline-block;
        vertical-align: middle;
    }

    .inputrepr label {
        width: 80px;
        display: inline-block;
        color: #151390
    }
</style>

<div class="row">
    <div class="box col-md-12">
        <div data-original-title="" class="box-header">
            <h2><i class="glyphicon glyphicon-signal"></i><span class="break"></span>Report</h2>
            <div class="box-icon">
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" method="post" role="form">
                        <span class="form-group col-md-2" style="margin-bottom:15px;font-size:20px">
                            <span class="label label-success">Publisher</span>
                            <input name="pubcheck" class="vpub" type="checkbox" value="1" <?php if ($this->session->userdata('pubcheck')) echo 'checked'; ?> />
                        </span>
                        <br />
                        <div class="col-md-12" style=" display: flex; flex-wrap: nowrap; padding:0">
                            <span class="form-group col-md-2 inputrepr">
                                <label>Start Date</label> <input id="startdate" type="text" name="from" value="<?php if ($this->session->userdata('from')) {
                                                                                                                    echo $this->session->userdata('from');
                                                                                                                } ?>" />
                            </span>
                            <span class="form-group col-md-2 inputrepr"><label>End Date</label> <input id="enddate" type="text" name="to" value="<?php if ($this->session->userdata('to')) {
                                                                                                                                                        echo $this->session->userdata('to');
                                                                                                                                                    } ?>" />
                            </span>
                            <hr />
                            <span class="form-group col-md-2">
                                <label>Pub Id</label>
                                <input class="form-control input-sm" name="pubid" type="text" value="<?php echo $this->session->userdata('pubid') ?>" />
                            </span>

                            <span class="form-group col-md-2">
                                <label>Offer Id </label>
                                <input class="form-control input-sm" name="oid" type="text" value="<?php echo $this->session->userdata('oid') ?>" />
                            </span>
                            <span class="form-group col-md-2">
                                <label>Sub2 </label>
                                <input class="form-control input-sm" name="s2" type="text" value="<?php echo $this->session->userdata('s2') ?>" />
                            </span>
                            <?php if ($this->users->parrent <= 0) { ?>
                                <span class="form-group col-md-2">
                                    <label>Net ID </label>
                                    <select class="form-control input-sm" name="idnet">
                                        <option value="">All</option>
                                        <?php
                                        $net = $this->Home_model->get_data('network', array(), array(), array('title', 'ASC'));
                                        foreach ($net as $net) {
                                            $selected = $this->session->userdata('idnet') == $net->id ? 'selected' : '';
                                            echo "
                                            <option $selected value='$net->id'> $net->title </option>                                        
                                        ";
                                        }
                                        ?>
                                    </select>
                                </span>
                            <?php } ?>

                            <div class="form-group col-md-2">
                                <label>Filter</label>
                                <select class="form-control input-sm" name="status">
                                    <option value="">All</option>
                                    <option <?php echo $this->session->userdata('status') == 1 ? 'selected' : '' ?> value="1">Pending</option>
                                    <option <?php echo $this->session->userdata('status') == 2 ? 'selected' : '' ?> value="2">Declined</option>
                                    <option <?php echo $this->session->userdata('status') == 3 ? 'selected' : '' ?> value="3">Pay</option>
                                    <option <?php echo $this->session->userdata('status') == 4 ? 'selected' : '' ?> value="4">Approved</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Time Zone</label>
                                <select class="form-control input-sm timezone" name="timezone_report">
                                    <option value="0">GMT +7</option>
                                    <option value="1">GMT -5</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-12 text-right" style="margin-top:15px;margin-bottom:25px;">
                            <button type="submit" name="submit" class="btn btn-primary btn-sm ">Submit</button>
                            <button type="submit" name="reset" value="1" class="btn btn-warning btn-sm ">Reset</button>
                        </div>
                        <hr />

                    </form>

                </div>
                <div class="col-md-12"></div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr role="row">
                                <th>Date</th>
                                <th>Offers Id- Names</th>
                                <th>Network</th>
                                <th style="display: none;" class="checkpub">Publisher</th>
                                <?php
                                if ($this->session->userdata('s2')) echo '<th>Sub2</th>';
                                if ($this->session->userdata('idnet')) echo '<th>Idnet</th>';
                                if ($this->session->userdata('status')) echo '<th>Status</th>';
                                ?>
                                <th>Click</th>
                                <th>Lead</th>
                                <th>Unique</th>
                                <th>Cr</th>
                                <th>Earning</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($dulieu)) {

                                foreach ($dulieu as $dulieu) {
                                    $total += $dulieu->pay;
                                    echo ' <tr>';
                                    echo '    <td style="width:100px">' . date('d-m-Y', strtotime($dulieu->date)) . '</td>';
                                    echo '    <td>' . $dulieu->offerid . ' - ' . $dulieu->oname . '</td>';
                                    echo '    <td>' . $dulieu->title . '</td>';
                                    echo '    <td style="display: none;" class="checkpub">' . $dulieu->email . ' (<i><b>' . $dulieu->userid . '</b></i>)</td>';
                                    if ($this->session->userdata('s2')) echo '    <td>' . $dulieu->s2 . '</td>';
                                    if ($this->session->userdata('idnet')) echo '    <td>' . $dulieu->idnet . '</td>';
                                    if ($this->session->userdata('status')) echo '    <td>' . $dulieu->status . '</td>';
                                    echo '    <td>' . $dulieu->click . '</td>';
                                    echo '    <td>' . $dulieu->lead . '</td>';
                                    echo '    <td>' . $dulieu->uniq . '</td>';
                                    echo '    <td>' . round(($dulieu->lead / $dulieu->click) * 100, 2) . '</td>';
                                    echo '    <td>' . round($dulieu->pay, 2) . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    Total: <?php echo round($total, 2); ?> $
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div style="margin:20px 0;float:left" class="form-group form-inline filter">
                            <select title="<?php echo $this->uri->segment(3); ?>" name="filter_cat" size="1" class="form-control input-sm">
                                <option value="0">all</option>
                                <?php
                                if (!empty($category)) {
                                    $where = $this->session->userdata('where');

                                    foreach ($category as $category1) {
                                        echo '
                                            <option value="' . $category1->id . '"';
                                        if (!empty($where['manager'])) {
                                            echo $where['manager'] == $category1->id ? ' selected' : '';
                                        }
                                        echo '>' . $category1->title . '</option>
                                        ';
                                    }
                                }
                                ?>
                            </select>
                            <label></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class=" pagination">
                            <?php //echo $this->pagination->create_links();
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var timezone_report = "<?php echo $this->session->userdata('timezone_report') ? $this->session->userdata('timezone_report') : 0; ?>";
        $('select.timezone option[value="' + timezone_report + '"]').prop('selected', true);
    })
</script>