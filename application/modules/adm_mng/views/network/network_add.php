<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-inbox"></i><span class="break"></span>Network</h2>
            <div class="box-icon">
                <a class="btn-add"
                    href="<?php echo base_url() . $this->config->item('manager') . '/route/' . $this->uri->segment(3) . '/list/'; ?>"><i
                        class="glyphicon glyphicon-list-alt"></i></a>
                <a class="btn-setting" href="#"><i class="glyphicon glyphicon-wrench"></i></a>
                <a class="btn-minimize" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a class="btn-close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="POST" action="<?php echo base_url() . $this->config->item('manager') . '/' . $this->uri->segment(2) . '/store'; ?>">

                <?php if ($dulieu) {
                    echo '<input class="hide" value="' . $dulieu->id . '" name="id"/>';
                } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php if ($dulieu) {
                                        echo $dulieu->title;
                                    } ?>" placeholder="Name" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Adv</label>
                    <div class="col-sm-10">
                        <select name="adv_id" class="form-control net_change">
                            <?php foreach ($advList as $advList): ?>
                                <option value="<?= $advList->id ?>">
                                    <?= $advList->first_name . ' ' . $advList->last_name ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Subid</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="subid" name="subid"
                            value="<?php if ($dulieu) {
                                        echo $dulieu->subid;
                                    } ?>" placeholder="Affsub" />
                    </div>
                </div>

                <input type="hidden" value="0" name="order">

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <span class="box_switch<?php if ($dulieu) {
                                                    echo $dulieu->show == 1 ? '' : ' off';
                                                } ?>">
                            <a href="">switch off</a>
                            <input id="off_on" type='hidden' name="show" value="1" />
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Postback</label>
                    <div class="col-sm-10">
                        <div class="well well-lg pbcolleft">
                            <div class="row">

                                <span class="col-sm-2">Pass:</span><span class="col-sm-10"><input style="width: 334px;"
                                        title="#pass" value="<?php if ($dulieu) {
                                                                    echo $dulieu->pb_pass;
                                                                } ?>" type="text"
                                        name="pb_pass" /></span>

                                <span class="col-sm-2">Subid</span>
                                <span class="col-sm-10">
                                    <input title="#0" value="<?php if ($dulieu) {
                                                                    echo $pb_value_array['clickid'][0];
                                                                } ?>"
                                        class="sp50" type="text" name="pb_value[clickid][]" />
                                    <span class="right">=</span>
                                    <input title="#1" value="<?php if ($dulieu) {
                                                                    echo $pb_value_array['clickid'][1];
                                                                } ?>"
                                        class="sp50" type="text" name="pb_value[clickid][]" />


                                </span>

                                <span class="col-sm-2">Commission</span>
                                <span class="col-sm-10">
                                    <input title="#2"
                                        value="<?php if ($dulieu) {
                                                    echo $pb_value_array['commission'][0];
                                                } ?>"
                                        class="sp50" type="text" name="pb_value[commission][]" />
                                    <span class="right">=</span>
                                    <input title="#3"
                                        value="<?php if ($dulieu) {
                                                    echo $pb_value_array['commission'][1];
                                                } ?>"
                                        class="sp50" type="text" name="pb_value[commission][]" />
                                </span>

                                <span class="col-sm-2">Sale amount</span>
                                <span class="col-sm-10">
                                    <input title="#4"
                                        value="<?php if ($dulieu) {
                                                    echo $pb_value_array['sale_amount'][0];
                                                } ?>"
                                        class="sp50" type="text" name="pb_value[sale_amount][]" />
                                    <span class="right">=</span>
                                    <input title="#5"
                                        value="<?php if ($dulieu) {
                                                    echo $pb_value_array['sale_amount'][1];
                                                } ?>"
                                        class="sp50" type="text" name="pb_value[sale_amount][]" />

                                </span>
                                <input type="hidden" name="pb_value[pub_id][]" value="<?php if ($dulieu) {
                                                                                            echo $pb_value_array['pub_id'][0];
                                                                                        } ?>">
                                <input type="hidden" name="pb_value[pub_id][]" value="<?php if ($dulieu) {
                                                                                            echo $pb_value_array['pub_id'][1];
                                                                                        } ?>">

                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">Submit</button></div>
                </div>

            </form>
        </div>
    </div>
</div>