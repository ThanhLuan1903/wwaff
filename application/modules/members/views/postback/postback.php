<div class="row  mt-5">
    <div class="col-12">
        <span class="_1ykwro3W9x7ktXduniR6Cp css-1didjui _2zZKiYIMOuyWJddFzI_uHV">Postbacks</span>
        <?php
        if (form_error('postback') || $flash = $this->session->flashdata('success')) {

            if ($flash) echo '
                 <div class="alert alert-success" role="alert">
                    ' . $flash . '
                 </div>
                ';
            else
                echo '
                  <div class="alert alert-danger" role="alert">
                     ' . form_error('postback') . '<br/>
                  </div>
                 ';
        }

        ?>
    </div>
    <div class="row ">
        <div class="col-sm-12 col-md-6 d-flex align-items-stretch">
            <div class="card">
                <div class="card-header">
                    <b>Transaction Notifications</b>
                </div>
                <div class="card-body">
                    <p>
                        Choose which transaction notifications you wish to receive and how you want to receive the
                        data. For
                        more information, please read the Transaction Notifications Success Center article.
                    </p>
                    <div class="row centered-form">
                        <div class="form-container">
                            <form method="post" action="">
                                <div class="row mb-3 mt-3">
                                    <label for="disabledSelect" class="col-sm-3 col-form-label text-end">Status</label>
                                    <div class="col-sm-9">
                                        <select id="disabledSelect" class="form-select form-select-sm" disabled>
                                            <option>Enabled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="callbackurl" class="col-sm-3 col-form-label text-end">Callback
                                        URL</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="callbackurl" rows="3"
                                            name="postback"><?php echo set_value('postback') ?: $postBack[0]->postback; ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="disabledSelect" class="col-sm-3 col-form-label text-end">Callback
                                        method</label>
                                    <div class="col-sm-9">
                                        <select id="disabledSelect" class="form-select form-select-sm" disabled>
                                            <option>GET</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label text-end"></label>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 d-flex align-items-stretch">
            <div class="card">
                <div class="card-header"> # </div>
                <div class="card-body full-height d-flex flex-column" id="listPostback">
                    <h5 style="display:block;margin:0 auto;" class="mt-2">Test Postback</h5>

                    <div class="row mt-3">
                        <label for="pburl" class="col-sm-2 col-form-label-sm">Offers Test</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="pburl"
                                value="<?php echo base_url(); ?>click/testpb?pid=<?php echo $this->session->userdata('user')->id ?>&offer_id=7745">
                        </div>
                    </div>

                    <div class="alert alert-success mt-3" role="alert">
                        Please add this link to your website in the offer section. Then just run the link in your offer
                        output to complete the conversion test
                    </div>
                    <hr class="mt-5" />
                    <div class="row d-flex justify-content-end">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="<?php echo base_url('v2/postbackLog'); ?>" class="btn btn-primary btn-sm">Postback Log</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-header">
                    <b>Parameter setting:</b>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>

                        </thead>
                        <tbody>
                            <tr style="color:#FFD832">
                                <td>{view}</td>
                                <td>Used to send your click id.</td>
                            </tr>
                            <tr style="color:#FFD832">
                                <td>{view2}</td>
                                <td>Used to send your source id.</td>
                            </tr>
                            <tr>
                                <td>{view3}</td>
                                <td>Click/View identifier/reference specified by the Publisher.</td>
                            </tr>
                            <tr>
                                <td>{view4}</td>
                                <td>Click/View identifier/reference specified by the Publisher.</td>
                            </tr>
                            <tr>
                                <td>{view5}</td>
                                <td>Click/View identifier/reference specified by the Publisher.</td>
                            </tr>
                            <tr>
                                <td>{lead_date}</td>
                                <td>Date and time of conversion committing in format %Y-%m-%d %H:%i:%s (timezone: UTC)</td>
                            </tr>
                            <tr>
                                <td>{click_date}</td>
                                <td>Date and time of click committing in format %Y-%m-%d %H:%i:%s (timezone: UTC)</td>
                            </tr>
                            <tr style="color:#FFD832">
                                <td>{commission}</td>
                                <td>Used to get product commission.</td>
                            </tr>
                            <tr>
                                <td>{sale_amount}</td>
                                <td>Used to get product sale amount.</td>
                            </tr>
                            <tr>
                                <td>{click_url}</td>
                                <td>Ad click locations are tracked using URL format.</td>
                            </tr>
                            <tr>
                                <td>{lead_Geo}</td>
                                <td>The geographic location associated with the lead, sent via Postback.</td>
                            </tr>
                            <tr>
                                <td>{click_Geo}</td>
                                <td>The geographic location where the click occurred, sent via Postback.</td>
                            </tr>
                            <tr>
                                <td>{city}</td>
                                <td>The city associated with the transaction, sent via Postback</td>
                            </tr>
                            <tr>
                                <td>{useragent}</td>
                                <td>The user agent string of the user's browser or device, sent via Postback.</td>
                            </tr>
                            <tr>
                                <td>{ip}</td>
                                <td>The IP address of the user, sent via Postback.</td>
                            </tr>
                            <tr>
                                <td>{device_And_os}</td>
                                <td>Information about the user's device and operating system, sent via Postback.</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .centered-form {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        width: 100%;
        max-width: 900px;
        padding: 20px;

    }
</style>

<style>
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

    .edit_pp {
        width: 30px
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