<form class="clearfix" method="POST" action="<?php echo base_url() . 'admin/route/' . $this->uri->segment(3); ?>">
    <?php if ($dulieu) {
        echo '<input class="hide" value="' . $dulieu->id . '" name="id"/>';
    } ?>

    <table class="tb_content clearfix">
        <tr>
            <td>Title</td>
            <td>
                <input value="<?php if ($dulieu) {
                                    echo $dulieu->title;
                                } ?>" class="span300" type="text" name="title" />
            </td>
        </tr>

        <tr>
            <td>Master</td>
            <td>
                <input value="<?php if ($dulieu) {
                                    echo $dulieu->master;
                                } ?>" class="span300" type="text" name="master" />
            </td>
        </tr>

        <tr>
            <td>Email</td>
            <td>
                <input value="<?php if ($dulieu) {
                                    echo $dulieu->email;
                                } ?>" class="span300" type="text" name="email" />
            </td>
        </tr>

        <tr>
            <td>Phone</td>
            <td>
                <input value="<?php if ($dulieu) {
                                    echo $dulieu->phone;
                                } ?>" class="span300" type="text" name="phone" />
            </td>
        </tr>

        <tr>
            <td>Metades(SEO)</td>
            <td>
                <textarea name="metades"><?php if ($dulieu) {
                                                echo $dulieu->metades;
                                            } ?></textarea>
            </td>
        </tr>

        <tr>
            <td>MetaKey(SEO)</td>
            <td>
                <textarea name="metakey"><?php if ($dulieu) {
                                                echo $dulieu->metakey;
                                            } ?></textarea>
            </td>
        </tr>

        <tr>
            <td>Google anatylic</td>
            <td>
                <textarea name="google"><?php if ($dulieu) {
                                            echo $dulieu->google;
                                        } ?></textarea>
            </td>
        </tr>

        <tr>
            <td>Logo</td>
            <td>
                <input type="text" id="xFilePath" name="logo" style="width:300px" value="<?php if ($dulieu) {
                                                                                                echo $dulieu->logo;
                                                                                            } ?>" />
                <input type="button" value="Upload" onclick="upfile( 'Images:/', 'xFilePath' );" />
            </td>
        </tr>

        <tr>
            <td>Favicon</td>
            <td>
                <input type="text" id="favi" name="favicon" style="width:300px" value="<?php if ($dulieu) {
                                                                                            echo $dulieu->favicon;
                                                                                        } ?>" />
                <input type="button" value="Upload" onclick="upfile( 'Images:/', 'favi' );" />
            </td>
        </tr>

        <tr>
            <td>footer</td>
            <td>
                <textarea id="soanthao" name="footer"><?php if ($dulieu) {
                                                            echo $dulieu->footer;
                                                        } ?></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="submit_td"><input type="submit" value="Submit" /></td>
        </tr>
    </table>

</form>

<script type="text/javascript">
    function upfile(startupPath, functionData) {
        var finder2 = new CKFinder();
        finder2.basePath = '../';
        finder2.startupPath = startupPath;
        finder2.selectActionFunction = SetFileField2;
        finder2.selectActionData = functionData;
        finder2.selectThumbnailActionFunction = ShowThumbnails1;
        finder2.popup();
    }

    function SetFileField2(fileUrl, data) {
        document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    function ShowThumbnails1(fileUrl, data) {
        var sFileName = this.getSelectedFile().name;
        document.getElementById('thumbnails').innerHTML +=
            '<div class="thumb">' +
            '<img src="' + fileUrl + '" />' +
            '<div class="caption">' +
            '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
            '</div>' +
            '</div>';

        document.getElementById('preview').style.display = "";
        return false;
    }
</script>