<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'autoloader.php';
$geo = new YandexGeo();
error_reporting(E_CORE_ERROR);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Composer Test: Yandex Geo</title>
</head>
<body>
<form method="post">
    <label for="address">Адрес:</label>
    <input name="address" id="address">
    <button type="submit">Найти координаты</button>
</form>
<?php if (isset($_POST['address'])) : $collection = $geo->searchPoint($_POST['address']);
    if (!empty($collection)) : ?>
    <h4>Скорее всего, вы искали координаты для одного из следующих адресов</h4>
    <ul>
    <?php foreach ($collection as $item) :?>
        <li>
            <?php echo $item->getAddress(); ?> -
            <?php echo $item->getLatitude() . ', ' . $item->getLongitude(); ?>
        </li>
    <?php endforeach; ?>
    </ul>
        Если вы не нашли нужный вам адрес в списке, попробуйте уточнить поисковый запрос.
    <?php else : ?>
    <h4>К сожалению, мы ничего не нашли по вашему запросу :(</h4>
    <?php endif; ?>
    <?php endif; ?>
</body>
</html>

