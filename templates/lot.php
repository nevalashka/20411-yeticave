<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $val): ?>
        <li class="nav__item">
            <a href="all-lots.html"><?= $val["category"];?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?=$lot[0]["name_lot"];?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot[0]['url_picture']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot[0]['category']; ?></span></p>
            <p class="lot-item__description">
                <?=$lot[0]['description']; ?>
            </p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?= time_count(); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost">10 999</span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
