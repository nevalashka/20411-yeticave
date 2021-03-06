<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $val): ?>
        <li class="nav__item">
            <a href="all-lots.html"><?= $val["category"];?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form form--add-lot container
             <?= (isset($errors)) ? 'form--invalid' : '';?>"
      action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= (isset($errors['name_lot'])) ? 'form__item--invalid' : '';?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="name_lot" placeholder="Введите наименование лота"
            value="<?= (isset($lot['name_lot'])) ? $lot['name_lot'] : ''; ?>">
            <?php if(isset($errors['name_lot'])): ?>
            <span class="form__error"><?=$errors['name_lot'];?></span>
            <?php endif; ?>
        </div>
        <div class="form__item
            <?= (isset($errors['category'])) ? 'form__item--invalid' : '' ?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <option value="">Выберите категорию</option>
                <?php foreach ($categories as $val): ?>
                <option value="<?= $val["id"];?>"
                <?= (isset($lot['category']) && $lot['category'] == $val['id']) ? 'selected' : ''; ?>
            >
                <?= $val["category"];?></option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($errors['category'])): ?>
            <span class="form__error"><?=$errors['category'];?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form__item form__item--wide <?= (isset($errors['description'])) ? 'form__item--invalid' : '';?>">
        <label for="message">Описание</label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"><?= (isset($lot['description'])) ? $lot['description'] : ''; ?></textarea>
        <?php if(isset($errors['description'])): ?>
        <span class="form__error"><?=$errors['description'];?></span>
        <?php endif; ?>
    </div>
    <div class="form__item form__item--file <?= (isset($errors['url_picture'])) ? 'form__item--invalid' : '';?>">
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="url_picture">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <?php if(isset($errors['url_picture'])): ?>
        <span class="form__error"><?=$errors['url_picture'];?></span>
        <?php endif; ?>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= (isset($errors['start_price'])) ? 'form__item--invalid' : '';?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="text" name="start_price" placeholder="0"
            value="<?= (isset($lot['start_price'])) ? $lot['start_price'] : ''; ?>">
            <?php if(isset($errors['start_price'])): ?>
            <span class="form__error"><?=$errors['start_price'];?></span>
            <?php endif; ?>
        </div>
        <div class="form__item form__item--small <?= (isset($errors['bid_step'])) ? 'form__item--invalid' : '';?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="text" name="bid_step" placeholder="0"
            value="<?= (isset($lot['bid_step'])) ? $lot['bid_step'] : ''; ?>">
            <?php if(isset($errors['bid_step'])): ?>
            <span class="form__error"><?=$errors['bid_step'];?></span>
            <?php endif; ?>
        </div>
        <div class="form__item <?= (isset($errors['date_finish'])) ? 'form__item--invalid' : '';?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="date_finish" value="<?= (isset($lot['date_finish'])) ? $lot['date_finish'] : ''; ?>">
            <?php if(isset($errors['date_finish'])): ?>
            <span class="form__error"><?=$errors['date_finish'];?></span>
            <?php endif; ?>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>





