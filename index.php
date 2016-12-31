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
<form method="get" style="margin-bottom: 20px">
    <label for="address">Адрес:</label>
    <input name="address" id="address">
    <button type="submit">Найти координаты</button>
</form>

<?php if (isset($_GET['address'])) :
    $address = htmlspecialchars($_GET['address']);
    $collection = $geo->searchPoint($address); ?>

<?php if (!empty($collection)) : ?>
    <script src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects&lang=ru-RU" type="text/javascript"></script>
        <script>
            <?php $geo->usersSelection(); ?>
            ymaps.ready(init);
            var latitude = <?php echo $latitude = $collection[$geo->getSelector()]->getLatitude(); ?>;
            var longitude = <?php echo $longitude = $collection[$geo->getSelector()]->getLongitude(); ?>;
            function init () {
                var myMap = new ymaps.Map("map", {
                        center: [latitude, longitude],
                        zoom: 10
                    }),

                    myGeoObject = new ymaps.GeoObject({
                        geometry: {
                            type: "Point",
                            coordinates: [latitude, longitude]
                        },
                        properties: {
                            iconContent: `${latitude}, ${longitude}`
                        }
                    }, {
                        preset: 'twirl#redStretchyIcon',
                        draggable: false
                    });

                myMap.geoObjects
                    .add(myGeoObject);
            }
        </script>

    <div id="map" style="width:400px; height:300px"></div>

    <h4>Скорее всего, вы искали координаты для одного из следующих адресов</h4>
    <ul>
    <?php $i = 0; foreach ($collection as $item) :?>
        <li>
            <?php echo $item->getAddress(); ?> -
            <?php echo $item->getLatitude() . ', ' . $item->getLongitude();
            if ($item->getLatitude() == $latitude && $item->getLongitude() == $longitude) : ?>
                <b>Показан на карте</b>
                <?php else : ?>
            <a href="index.php?address=<?php echo str_replace(" ", "+", $address) ?>&result=<?php echo $i ?>">Показать на карте</a>
                <?php endif; ?>
        </li>
    <?php $i++; endforeach; ?>
    </ul>
        Если вы не нашли нужный вам адрес в списке, попробуйте уточнить поисковый запрос.
    <?php else : ?>
    <h4>К сожалению, мы ничего не нашли по вашему запросу :(</h4>
    <?php endif; ?>
    <?php endif; ?>

</body>
</html>

