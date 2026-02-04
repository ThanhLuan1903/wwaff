<style>
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-col {
        flex: 1;
    }
    .form-col label {
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
    }
    .form-col small {
        color: #666;
    }
    table.test-result th,
    table.test-result td {
        padding: 8px 10px;
        vertical-align: top;
    }
    table.test-result th {
        background: #f5f5f5;
    }
</style>
<h2>Affiliate Link Tester</h2>

<?php if (!empty($error_msg)): ?>
    <div style="padding:10px;border:1px solid #f00;color:#a00;margin-bottom:10px;">
        <?php echo htmlentities($error_msg); ?>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo current_url(); ?>">

    <!-- Affiliate link -->
    <p>
        <label><strong>Affiliate Link</strong></label><br>
        <input type="text"
               name="link"
               style="width:100%;max-width:800px"
               value="<?php echo htmlentities($link); ?>"
               required>
    </p>

    <!-- Country + Device -->
    <div class="form-row">
        <div class="form-col">
            <label>Country</label>
<select name="country" class="form-control" required>
  <option value="VN" <?php echo ($country === 'VN') ? 'selected' : ''; ?>>VIETNAM</option>
  <option value="US" <?php echo ($country === 'US') ? 'selected' : ''; ?>>UNITED STATES</option>
  <option value="GB" <?php echo ($country === 'GB') ? 'selected' : ''; ?>>UNITED KINGDOM</option>
  <option value="ES" <?php echo ($country === 'ES') ? 'selected' : ''; ?>>SPAIN</option>
</select>

<br>
            <small>(VN direct, other GEO via Webshare proxy)</small>
        </div>

        <div class="form-col">
            <label>Device</label>
            <select name="device" required>
                <?php foreach ($devices as $id => $name): ?>
                    <option value="<?php echo $id; ?>"
                        <?php echo ($device == $id) ? 'selected' : ''; ?>>
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <small>(Desktop / Browser only)</small>
        </div>
    </div>

    <!-- Button -->
    <p>
        <button type="submit">Test Link</button>
    </p>

</form>

<?php if (!empty($result)): ?>
<h3>Test Result</h3>

<table class="test-result" border="1" cellspacing="0" width="100%">
    <tr>
        <th width="50">Step</th>
        <th>URL</th>
        <th width="200">Status</th>
        <th width="80">Type</th>
    </tr>

    <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo $row['step']; ?></td>
            <td style="word-break:break-all">
                <?php echo htmlentities($row['url']); ?>
            </td>
            <td>
            <div><b><?php echo (int)$row['status']; ?></b></div>
            <small><?php echo htmlentities($row['status_title']); ?></small>
            <?php if (!empty($row['proxy'])): ?>
                <div><small>Proxy: <?php echo htmlentities($row['proxy']); ?></small></div>
            <?php endif; ?>
            <?php if (!empty($row['error'])): ?>
                <div style="color:#a00"><small><?php echo htmlentities($row['error']); ?></small></div>
            <?php endif; ?>
            </td>

            <td><?php echo isset($row['type']) ? $row['type'] : 'http'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>


