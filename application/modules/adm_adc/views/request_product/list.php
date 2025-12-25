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
            <h2><i class="glyphicon glyphicon-envelope"></i><span class=" break"></span>List Request Product </h2>
            <div class="box-icon">

            </div>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered table-center">
                <thead>
                    <tr role="row">
                        <th scope="col" style="width: 50px">#</th>
                        <th scope="col" style="width: 150px">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Preview Link</th>
                        <th scope="col" style="width: 150px">Payout</th>
                        <th scope="col" style="width: 100px">Status</th>
                        <th scope="col" >Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data)) { ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No data.</td>
                    </tr>
                    <?php } else { ?>
                    <?php  
                    foreach($data as $dt) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $dt->id; ?></th>
                        <td>
                            <img src="<?php echo $dt->image_url;?>" class="img-thumbnail product-img" alt="">
                        </td>
                        <td><?php echo $dt->name;?></td>
                        <td>
                            <a href="<?php echo $dt->preview_link ?>" target="_blank">
                                <?php echo $dt->preview_link ?>
                            </a>
                        </td>
                        <td><?php echo $dt->cust_payout;?></td>
                        <td>

                            <select name="status"
                                action="<?php echo base_url($this->uri->segment(1).'/product/change_status_request/'.$dt->id);?>">
                                <option value="1" <?php echo $dt->status==1?'selected':'';?>>Pending</option>
                                <option value="2" <?php echo $dt->status==2?'selected':'';?>>Unsuccessful</option>
                                <option value="3" <?php echo $dt->status==3?'selected':'';?>>Succeeded</option>
                            </select>
                        </td>
                        <td>
                            <button data-id="<?= $dt->id ?>" class="btn btn-primary btn-xs update-request-product">
                                <i class="glyphicon glyphicon-edit glyphicon-white"></i> 
                            </button>
                            <a href="<?= base_url($this->config->item('admin') . '/advertiser/delete_request_product/') . '/' . $dt->id ?>"><button data-id="<?= $dt->id ?>" class="btn btn-danger btn-xs" >
                                <i class="glyphicon glyphicon-trash glyphicon-white"></i> 
                            </button></a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <?php if(!empty($data)) { ?>
            <div class="row flex-justify-center">
                <div class="col-md-6">
                    <?php echo 'Showing '.$from.' to '.$to.' of '.$this->pagination->total_rows.' entries'?>
                </div>
                <div class="col-md-6">
                    <ul class="pagination">
                        <?php echo $this->pagination->create_links();?>
                    </ul>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div style="margin-top: 40px;" class="modal fade request-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Request Product</h4>
        </div>
        <div class="modal-body" id="request-form">
        </div>
    </div>
</div>
</div>
<script>
$(document).ready(function() {
    $("[name='status']").on('change', (e) => {
        submit(e.target.value, $(e.target).attr('action'))
    })

    $('.update-request-product').click(function() {
        $('.request-modal').modal();
        const id = $(this).data('id');
        $('#request-form').load(`<?= base_url($this->config->item('admin') . '/advertiser/update_request_product/') ?>/${id}`)
    });

    

})

function submit(val, url) {
    const formData = new FormData();
    formData.append('status', $("[name='status']").val());
    $.ajax({
        url: url,
        type: "Post",
        data: formData,
        async: true,
        contentType: false,
        processData: false,
        cache: false,
        success: function(data) {
            const res = data && JSON.parse(data);
            if (res['error'] == true) {
                const error = res.data
                alert(error.name)
            } else {
                window.location.reload();
            }
        },
        error: function(xhr, exception) {
            var msg = "";
            if (xhr.status === 0) {
                msg = "Not connect.\n Verify Network." + xhr.responseText;
            } else if (xhr.status == 404) {
                msg = "Requested page not found. [404]" + xhr.responseText;
            } else if (xhr.status == 500) {
                msg = "Internal Server Error [500]." + xhr.responseText;
            } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed.";
            } else if (exception === "timeout") {
                msg = "Time out error." + xhr.responseText;
            } else if (exception === "abort") {
                msg = "Ajax request aborted.";
            } else {
                msg = "Error:" + xhr.status + " " + xhr.responseText;
            }
        }
    });
}
</script>