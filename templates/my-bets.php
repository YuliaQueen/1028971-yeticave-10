<section class="rates container">
    <h2>Мои ставки</h2>

    <table class="rates__list">
        <?php foreach ($my_bets as $bets): ?>
            <?php if ($bets['is_my_winning'] && $bets['lot_end_date'] < $cur_time): ?>
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
                <?php $finishing_status = time_class(esc($bets['lot_end_date'])); ?>
                <?php if ($finishing_status === 1): ?>
                    <div class="timer timer--finishing"><?= time_to_end(esc($bets['lot_end_date'])); ?></div>
                <?php elseif ($finishing_status === 0): ?>
                    <div
                        class="timer <?= !empty($bets['is_my_winning']) ? ' timer--win' : 'timer--end'; ?> "> <?= $bets['bet_status'] ?></div>
                <?php else: ?>
                    <div class="timer"><?= time_to_end(esc($bets['lot_end_date'])); ?></div>
                <?php endif; ?>
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
