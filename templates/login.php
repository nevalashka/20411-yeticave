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
<form class="form container <?= (isset($errors)) ? 'form--invalid' : '';?>" action="login.php" method="post" enctype="multipart/form-data">
    <h2>Вход</h2>
    <div class="form__item <?= (isset($errors['email'])) ? 'form__item--invalid' : '';?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= (isset($login['email'])) ? $login['email'] : ''; ?>">
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last <?= (isset($errors['password'])) ? 'form__item--invalid' : '';?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
