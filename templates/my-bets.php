
<section class="rates container">
    <h2>Мои ставки</h2>

    <table class="rates__list">
        <?php foreach ($my_bets as $bets): ?>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?= $bets['lot_picture'] ?>" width="54" height="40" alt="Сноуборд">
                </div>
                <h3 class="rates__title"><a href="lot.php?lot_id=<?= $bets['lot_id']?>"><?= $bets['lot_name']?></a></h3>
            </td>
            <td class="rates__category">
                <?= $bets['category_name'] ?>
            </td>
            <td class="rates__timer">
                <?php $finishing_status = time_class($bets['lot_end_date']); ?>
                <div class="timer timer--finishing"><?= time_to_end($bets['lot_end_date']); ?></div>
            </td>
            <td class="rates__price">
                <?=get_last_bid($bets['lot_id'], $bets['lot_start_price'])?>
            </td>
            <td class="rates__time">
                <?= $bets['bid_date'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</section>
