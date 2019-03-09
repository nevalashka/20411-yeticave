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
        <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?= (isset($errors['email'])) ? 'form__item--invalid' : '';?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail"
               value="<?= (isset($users['email'])) ? $users['email'] : ''; ?>">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item form__item--last">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <span class="form__error">Введите пароль</span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
