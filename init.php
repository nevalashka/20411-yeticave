<?php
require_once 'functions.php';
$db = require_once 'config/db.php';

$link = mysqli_connect($db['localhost'], $db['root'], $db[''], $db['yeticave']);
mysqli_set_charset($link, "utf8");

$categories = [];
$content = '';
