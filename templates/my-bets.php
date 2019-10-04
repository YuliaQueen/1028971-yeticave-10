<section class="rates container">
    <h2>Мои ставки</h2>

    <table class="rates__list">
        <?php foreach ($my_bets as $bets): ?>
            <?php if ($bets['is_my_winning'] && $bets['lot_finished'] === 0): ?>
                <tr class="rates__item rates__item--win">
            <?php else: ?>
                <tr class="rates__item ">
            <?php endif; ?>
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?= esc($bets['lot_picture']) ?>" width="54" height="40"
                         alt="<?= esc($bets['lot_name']) ?>">
                </div>
                <div>
                    <h3 class="rates__title"><a
                            href="lot.php?lot_id=<?= (int)$bets['lot_id'] ?>"><?= esc($bets['lot_name']) ?></a></h3>
                    <?php if ($bets['is_my_winning'] && $bets['lot_end_date'] < $cur_time): ?>
                        <div> <?= 'Контакты: ' . $bets['owner_contacts'] ?? ''; ?></div>
                    <?php endif; ?>
                </div>
            </td>
            <td class="rates__category">
                <?= esc($bets['category_name']) ?>
            </td>
            <td class="rates__timer">
                <?php if ($bets['lot_finished'] === 1) : // менее часа ?>
                    <div class="timer timer--finishing"><?= $bets['time_to_end'] ?></div>
                <?php elseif ($bets['lot_finished'] === 0) : // завершенный ?>
                    <?php if ($bets['is_my_winning']): ?>
                        <div class="timer timer--win"> <?= $bets['bet_status'] ?></div>
                    <?php else: ?>
                        <div class="timer timer--end"> <?= $bets['bet_status'] ?></div>
                    <?php endif ?>
                <?php else: // более часа ?>
                    <div class="timer"><?= $bets['time_to_end'] ?></div>
                <?php endif ?>
            </td>
            <td class="rates__price">
                <?= change_number($bets['my_bid_amount']) . ' &#8381;' ?>
            </td>
            <td class="rates__time">
                <?= esc($bets['lot_end_date']) ?>
            </td>
            </tr>
        <?php endforeach; ?>

    </table>

</section>

