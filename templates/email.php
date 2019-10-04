<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= strip_tags($winner_info['user_name']); ?>!</p>
<p>Ваша ставка для лота <a
        href="http://yeticave/lot.php?id=<?= (int)$winner_info['bid_lot']; ?>"><?= strip_tags($winner_info['lot_name']); ?></a>
    победила.
</p>
<p>Перейдите по ссылке <a href="http://1028971-yeticave-10/my-bets.php">Мои ставки</a>, чтобы связаться с автором
    объявления.</p>
<small>Интернет-аукцион «YetiCave»</small>
