<style>
    .flex-justify-center {
        display: flex;
        justify-content: center;
    }

    .table-center tbody tr td,
    .table-center tbody tr th {
        vertical-align: middle !important;
    }
</style>
<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-comment"></i><span class="break"></span>List Request Support</h2>
            <div class="box-icon"></div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered table-center">
                <thead>
                    <tr role="row" style="background:#cdcdcd">
                        <th scope="col" style="width: 50px">ID</th>
                        <th scope="col" style="width: 200px">Name</th>
                        <th scope="col" style="width: 200px">Email</th>
                        <th scope="col">Title</th>
                        <th scope="col" style="width: 150px">Last Update</th>
                        <th scope="col" style="width: 50px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)) { ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No data.</td>
                        </tr>
                    <?php } else { ?>
                        <?php
                        foreach ($data as $dt) {
                        ?>
                            <tr>
                                <th scope="row">
                                    <a href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"><?php echo $dt->id ?></a>
                                </th>
                                <td><?php echo $dt->name; ?></td>
                                <td><?php echo $dt->email; ?></td>
                                <td>
                                    <a href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"><?php echo $dt->title ?></a>
                                </td>
                                <td><?php echo $dt->updated_at; ?></td>
                                <td>
                                    <a href="<?php echo base_url($this->uri->segment(1) . '/help_and_support/detail/' . $dt->id) ?>"
                                        data-toggle="tooltip" data-placement="top" title="View messenger"
                                        class="btn btn-info btn-xs">
                                        <i class="glyphicon glyphicon-eye-open glyphicon glyphicon-white"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!empty($data)) { ?>
                <div class="row flex-justify-center">
                    <div class="col-md-6">
                        <?php echo 'Showing ' . $from . ' to ' . $to . ' of ' . $this->pagination->total_rows . ' entries' ?>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>