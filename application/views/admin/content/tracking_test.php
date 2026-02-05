<style>
:root {
    --bd: #e5e7eb;
    --tx: #111827;
    --bg: #f9fafb;
    --card: #ffffff;
    --shadow: 0 1px 2px rgba(0, 0, 0, .06);
    --radius: 10px;
}

h2 {
    margin: 0 0 12px;
    color: var(--tx)
}

.card {
    background: var(--card);
    border: 1px solid var(--bd);
    border-radius: var(--radius);
    padding: 14px;
    box-shadow: var(--shadow);
    margin-bottom: 14px;
}

.form-row {
    display: flex;
    gap: 14px;
    align-items: center;
    margin: 10px 0 12px;
    flex-wrap: wrap;
}

.form-col {
    flex: 1;
    min-width: 240px;
}

.form-col label {
    font-weight: 700;
    display: block;
    margin-bottom: 6px;
    color: var(--tx);
}

.help {
    display: block;
    margin-top: 6px;
    color: var(--tx);
    font-size: 12px;
}

/* input/select/button đồng bộ */
.ctrl {
    width: 100%;
    height: 40px;
    padding: 8px 10px;
    border: 1px solid var(--bd);
    border-radius: 10px;
    outline: none;
    background: #fff;
}

.ctrl:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .15);
}

.btn-test {
    height: 40px;
    padding: 0 14px;
    border: 1px solid #0ea5a4;
    background: #14b8a6;
    color: #fff;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
}

.err {
    padding: 10px 12px;
    border: 1px solid #fecaca;
    background: #fff1f2;
    color: #991b1b;
    border-radius: 10px;
    margin-bottom: 12px;
}

/* table */
table.test-result {
    border-collapse: collapse;
    width: 100%;
    background: #fff;
    border: 1px solid var(--bd);
    overflow: hidden;
}

table.test-result th,
table.test-result td {
    padding: 10px 12px;
    vertical-align: top;
    border-bottom: 1px solid var(--bd);
}

table.test-result th {
    background: var(--bg);
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: .3px;
    color: #374151;
}

table.test-result tr:hover td {
    background: #fcfcfd
}

.small {
    font-size: 12px;
    color: var(--tx)
}

.mono {
    color: var(--tx);
}

.muted {
    color: var(--tx)
}

/* badges */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 8px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 800;
    border: 1px solid transparent;
    line-height: 1.2;
    margin-right: 6px;
}

.b-2xx {
    background: #ecfdf5;
    color: #065f46;
    border-color: #a7f3d0;
}

.b-3xx {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #bfdbfe;
}

.b-4xx {
    background: #fffbeb;
    color: #92400e;
    border-color: #fde68a;
}

.b-5xx {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
}

.b-0 {
    background: #f3f4f6;
    color: #374151;
    border-color: #e5e7eb;
}

.device-pill {
    display: inline-flex;
    padding: 3px 8px;
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}
</style>

<h2>Affiliate Link Tester</h2>

<?php if (!empty($error_msg)): ?>
<div class="err"><?php echo htmlentities($error_msg); ?></div>
<?php endif; ?>

<div class="card">
    <form method="post" action="<?php echo current_url(); ?>">

        <div class="form-col" style="min-width:280px;">
            <label>Affiliate Link</label>
            <input class="ctrl mono" type="text" name="link" value="<?php echo htmlentities($link); ?>"
                placeholder="Paste tracking link here..." required>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label>Country</label>
                <select name="country" class="ctrl" required>
                    <option value="VN" <?php echo ($country === 'VN') ? 'selected' : ''; ?>>Vietnam</option>
                    <option value="US" <?php echo ($country === 'US') ? 'selected' : ''; ?>>United States</option>
                    <option value="GB" <?php echo ($country === 'GB') ? 'selected' : ''; ?>>United Kingdom</option>
                    <option value="ES" <?php echo ($country === 'ES') ? 'selected' : ''; ?>>Spain</option>
                </select>
                <span class="help">(VN direct, other GEO via Webshare proxy)</span>
            </div>

            <div class="form-col">
                <label>Device</label>
                <!-- ✅ hardcode giống GEO: value tương ứng -->
                <select name="device" class="ctrl" required>
                    <option value="1" <?php echo ((string)$device === '1') ? 'selected' : ''; ?>>Desktop</option>
                    <option value="2" <?php echo ((string)$device === '2') ? 'selected' : ''; ?>>Android</option>
                    <option value="3" <?php echo ((string)$device === '3') ? 'selected' : ''; ?>>iPhone</option>
                    <option value="4" <?php echo ((string)$device === '4') ? 'selected' : ''; ?>>iPad</option>
                </select>
                <span class="help">(UA simulation: Desktop / Android / iOS)</span>
            </div>

            <div class="form-col" style="flex:0;min-width:160px;">
                <button class="btn-test" type="submit">Test Link</button>
            </div>
        </div>

    </form>
</div>

<?php
// helper badge class theo status
function status_badge_class($code){
  $code = (int)$code;
  if ($code === 0) return 'b-0';
  if ($code >= 200 && $code < 300) return 'b-2xx';
  if ($code >= 300 && $code < 400) return 'b-3xx';
  if ($code >= 400 && $code < 500) return 'b-4xx';
  if ($code >= 500) return 'b-5xx';
  return 'b-0';
}
function device_name($id){
  switch ((int)$id){
    case 1: return 'Desktop';
    case 2: return 'Android';
    case 3: return 'iPhone';
    case 4: return 'iPad';
    default: return 'Unknown';
  }
}
?>

<?php if (!empty($result)): ?>
<div class="card">
    <h3 style="margin:0 0 10px;color:var(--tx)">Test Result</h3>

    <table class="test-result">
        <tr>
            <th width="60">Step</th>
            <th>URL</th>
            <th width="140">Device</th>
            <th width="220">Status</th>
            <th width="110">Type</th>
        </tr>

        <?php foreach ($result as $row): ?>
        <?php
          // ✅ Ẩn step 0 và -1
          if ((int)$row['step'] <= 0) continue;

          $st = (int)$row['status'];
          $badge = status_badge_class($st);
          $devId = isset($row['device']) ? (int)$row['device'] : (int)$device; 
        ?>
        <tr>
            <td class="mono"><?php echo (int)$row['step']; ?></td>

            <td style="word-break:break-all" class="mono">
                <?php echo htmlentities($row['url']); ?>
            </td>

            <td>
                <span class="device-pill"><?php echo htmlentities(device_name($devId)); ?></span>
            </td>

            <td>
                <div style="margin-bottom:6px">
                    <span class="badge <?php echo $badge; ?>"><?php echo $st; ?></span>
                    <span class="small"><?php echo htmlentities($row['status_title']); ?></span>
                </div>

                <?php if (!empty($row['proxy'])): ?>
                <div class="small">Proxy: <span class="mono"><?php echo htmlentities($row['proxy']); ?></span></div>
                <?php endif; ?>

                <?php if (!empty($row['error'])): ?>
                <div class="small" style="color:#991b1b">Error: <?php echo htmlentities($row['error']); ?></div>
                <?php endif; ?>
            </td>

            <td class="mono"><?php echo isset($row['type']) ? htmlentities($row['type']) : 'http'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>