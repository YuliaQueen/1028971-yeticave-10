<section class="rates container">
    <h2>Мои ставки</h2>

    <table class="rates__list">
        <?php foreach ($my_bets as $bets): ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= esc($bets['lot_picture']) ?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a
                            href="lot.php?lot_id=<?= (int)$bets['lot_id'] ?>"><?= esc($bets['lot_name']) ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= esc($bets['category_name']) ?>
                </td>
                <td class="rates__timer">
                    <?php $finishing_status = time_class(esc($bets['lot_end_date'])); ?>
                    <?php if ($finishing_status === 1): ?>
                        <div class="timer timer--finishing"><?= time_to_end(esc($bets['lot_end_date'])); ?></div>
                    <?php else: ?>
                        <div class="timer"><?= time_to_end(esc($bets['lot_end_date'])); ?></div>
                    <?php endif; ?>
                </td>
                <td class="rates__price">
                    <?= get_last_bid(esc($bets['lot_id']), esc($bets['lot_start_price'])) . ' &#8381;' ?>
                </td>
                <td class="rates__time">
                    <?= esc($bets['lot_end_date']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</section>
