<section class="lot-item container">

    <h2><?= esc($lot_info['lot_name']); ?></h2>

    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= esc($lot_info['lot_picture']); ?>" width="730" height="548" alt="Сноуборд">

            </div>
            <p class="lot-item__category">Категория: <span><?= esc($lot_info['category']); ?></span></p>
            <p class="lot-item__description"><?= esc($lot_info['lot_description']) ?></p>
        </div>
        <div class="lot-item__right">

            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="lot-item__state">

                    <?php $finishing_status = time_class(esc($lot_info['lot_end_date'])); ?>
                    <?php if ($finishing_status === 0): ?>
                        <div class="lot-item__timer timer timer--finishing">
                            <b>Закрыт</b>
                        </div>
                    <?php elseif ($finishing_status === 1): ?>
                        <div class="lot-item__timer timer timer--finishing">
                            <?= time_to_end(esc($lot_info['lot_end_date'])); ?>
                        </div>
                    <?php else: ?>
                        <div class="lot-item__timer timer">
                            <?= time_to_end(esc($lot_info['lot_end_date'])); ?>
                        </div>
                    <?php endif; ?>

                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= change_number($last_bid) . ' &#8381;'; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= change_number($lot_info['lot_bet_step']) . ' &#8381;' ?></span>
                        </div>
                    </div>
                    <?php if ($_SESSION['user_name']['user_id'] !== $last_bid_user): ?>
                        <form class="lot-item__form <?= esc(count($errors)) ? ' form--invalid' : ''; ?>"
                              action="<?= 'lot.php?lot_id=' . $lot_id; ?>" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item <?= isset($errors['bid']) ? ' form__item--invalid' : '' ?> ">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="bid"
                                       placeholder="<?= change_number($last_bid + $lot_info['lot_bet_step']) . ' &#8381;' ?>">
                                <?php if ($finishing_status === 0): ?>
                                    <span class="form__error">Нельзя сделать ставку</span>
                                <?php else: ?>
                                    <span class="form__error"><?= esc($errors['bid'] ?? '') ?></span>
                                <?php endif; ?>

                            </p>
                            <button type="submit"
                                    class="button" <?php if ($finishing_status === 0) print('disabled') ?>>
                                Сделать ставку
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="history">
                <h3>История ставок (<span><?= count($bids)  ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bids as $bid): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= esc($bid['user_name']) ?></td>
                            <td class="history__price"><?= esc($bid['bid_amount']) ?></td>
                            <td class="history__time"><?= esc($bid['bid_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
