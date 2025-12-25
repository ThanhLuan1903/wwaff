<style>
  .money {
    white-space: nowrap;
    font-size: 1.5rem;
    line-height: 2.1875rem;
    font-weight: 700;
    text-transform: uppercase;
    background: linear-gradient(180deg, #fffbae, #eaa50d);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .sum {
    color: #fae584;
    font-size: 1rem;
    line-height: 1.375rem;
    white-space: nowrap;
    padding-right: 5px;
  }

  .top-king {
    min-height: 655px;
    background: linear-gradient(135deg, #c0392b 0%, #f9d423 100%);
    position: relative;
  }

  .custom-bg-ranking {
    position: absolute;
    color: white;
    font-size: 19px;
    font-weight: bold;
    height: 100%;
    width: 100%;
    height: 100%;
    top: 15px;
    left: 39px;
    font-style: italic;
  }
</style>
<section class="pt-4">
  <div class="row">
    <!-- <h4>Sale Rewards Ranking</h4> -->
    <div class="col-6">
      <div class="card shadow-sm bg-white" style="border-radius: 25px;">
        <div class="card-body top-king ">
          <div class="card-title">
            <h3 class="text-center">Top 10 Balance</h3>
            <p class="text-center sum">Total Award:
              <span class="time-remind money" id="day-remind"><?= number_format($sum_sale_rewards, 0, ',', '.') ?> USD</span>
            </p>
            <p class="text-center text-white">Time Remaining:
              <span class="time-remind text-white" id="countdown">18</span>
            </p>
          </div>
          <table class="table rewards">
            <thead>
              <tr>
                <th class="text-white">Rank</th>
                <th class="text-white">Publisher</th>
                <th class="text-white">Amount</th>
                <th class="text-white">Award</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($top_10_rewards as $stt => $reward) : ?>
                <?php if (!isset($balance_users[$stt])) {
                  break;
                } ?>
                <tr>
                  <?php if ($reward->ranking == 1) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-1.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php elseif ($reward->ranking == 2) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-2.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php elseif ($reward->ranking == 3) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-3.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php else : ?>
                    <td style="position: relative;"><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-default.png" alt="top-1" width="auto" height="30px" class="image"><span class="custom-bg-ranking"><?= $reward->ranking ?></span></td>
                    </td>
                  <?php endif; ?>
                  <td><?= $balance_users[$stt]->username ?: '-----' ?></td>
                  <td><?= $balance_users[$stt]->finance > 0 ? number_format(round($balance_users[$stt]->finance, 2), 2) . ' USD' : '----' ?></td>
                  <th><?= number_format(round($reward->reward, 2), 2) ?> USD</th>
                </tr>
              <?php $stt++;
              endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div class="col-6">
      <div class="card shadow-sm bg-white" style="border-radius: 25px;">
        <div class="card-body top-king">
          <div class="card-title">
            <h4 class="text-center">Top 10 Sales</h4>
            <p class="text-center sum">Total Award:
              <span class="time-remind money" id="day-remind"><?= number_format($sum_custom_sale_rewards, 0, ',', '.') ?> USD</span>
            </p>
            <p class="text-center text-white">Time Remaining:
              <span class="time-remind text-white" id="countdown-1">18</span>
            </p>
          </div>
          <table class="table rewards">
            <thead>
              <tr>
                <th class="text-white">Rank</th>
                <th class="text-white">Email</th>
                <th class="text-white">Amount</th>
                <th class="text-white">Award</th>
              </tr>
            </thead>
            <tbody>
              <?php $stt = 1 ?>;
              <?php foreach ($custom_sale_rewards as $reward) : ?>
                <tr>
                  <?php if ($stt == 1) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-1.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php elseif ($stt == 2) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-2.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php elseif ($stt == 3) : ?>
                    <td><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-3.png" alt="top-1" width="auto" height="30px" class="image"></td>
                  <?php else : ?>
                    <td style="position: relative;"><img data-v-0b6a6d04="" src="<?php echo base_url(); ?>/temp/default/images/ranking/top-default.png" alt="top-1" width="auto" height="30px" class="image"><span class="custom-bg-ranking"><?= $stt ?></span></td>
                    </td>
                  <?php endif;
                  $stt++ ?>
                  <td><?= $reward->username ?></td>
                  <td><?= number_format(round($reward->amount, 2), 2, ',', '.') ?> USD</td>
                  <td><?= number_format(round($reward->reward, 2), 2, ',', '.') ?> USD</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  function countdown() {
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();
    const lastDayOfMonth = new Date(year, month + 1, 0).getDate();
    const endOfMonth = new Date(year, month, lastDayOfMonth, 23, 59, 59);
    let secondsLeft = Math.floor((endOfMonth - now) / 1000);

    const countdownEl = document.getElementById("countdown");
    const countdownEl_1 = document.getElementById("countdown-1");
    const intervalId = setInterval(() => {
      const seconds = Math.max(secondsLeft % 60, 0);
      const minutes = Math.max(Math.floor(secondsLeft / 60) % 60, 0);
      const hours = Math.max(Math.floor(secondsLeft / 3600) % 24, 0);
      const days = Math.max(Math.floor(secondsLeft / 86400), 0);

      countdownEl.innerHTML = `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
      countdownEl_1.innerHTML = `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
      secondsLeft--;

      if (secondsLeft < 0) {
        clearInterval(intervalId);
        countdownEl.innerHTML = "Đã hết thời gian đếm ngược";
        countdownEl_1.innerHTML = "Đã hết thời gian đếm ngược";
      }
    }, 1000);
  }

  countdown();
</script>