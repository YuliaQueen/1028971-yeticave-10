<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= $q_search ?></span>»</h2>
        <ul class="lots__list">
            <?php if (count($search_result)): ?>
                <?php foreach ($search_result as $item): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= $item['lot_picture'] ?>" width="350" height="260" alt="Сноуборд">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= $item['category_name'] ?></span>
                            <h3 class="lot__title"><a class="text-link"
                                                      href="lot.php?lot_id=<?= $item['lot_id'] ?>"><?= $item['lot_name'] ?></a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span
                                        class="lot__cost"><?= change_number($item['lot_start_price']) . ' &#8381;' ?></span>
                                </div>
                                <div class="lot__timer timer">
                                    <?= time_to_end($item['lot_end_date']); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p><b><?= $errors; ?></b></p>
            <?php endif; ?>

        </ul>
    </section>
    <!--    <ul class="pagination-list">-->
    <!--        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>-->
    <!--        <li class="pagination-item pagination-item-active"><a>1</a></li>-->
    <!--        <li class="pagination-item"><a href="#">2</a></li>-->
    <!--        <li class="pagination-item"><a href="#">3</a></li>-->
    <!--        <li class="pagination-item"><a href="#">4</a></li>-->
    <!--        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>-->
    <!--    </ul>-->
</div>

