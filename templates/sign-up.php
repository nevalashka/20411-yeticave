<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $val): ?>
        <li class="nav__item">
            <a href="all-lots.html">
                <?= $val["category"];?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form container <?= (isset($errors)) ? 'form--invalid' : '';?>" action="sign-up.php" method="post" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item
                <?= (isset($errors['email'])) ? 'form__item--invalid' : '';?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?= (isset($users['email'])) ? $users['email'] : ''; ?>">
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item
                <?= (isset($errors['password'])) ? 'form__item--invalid' : ''; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" required placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item
                <?= (isset($errors['name'])) ? 'form__item--invalid' : '';?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" required placeholder="Введите имя" value="<?= (isset($users['name'])) ? $users['name'] : ''; ?>">
        <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item
                <?= (isset($errors['contact'])) ? 'form__item--invalid' : '';?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="contact" placeholder="Напишите как с вами связаться" required><?= (isset($users['contact'])) ? $users['contact'] : ''; ?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last
                <?= (isset($errors['url_picture'])) ? 'form__item--invalid' : '';?>">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="avatar">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
