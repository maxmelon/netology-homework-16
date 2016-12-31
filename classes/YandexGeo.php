<?php

class YandexGeo
{
    protected $selector;

    /**
     * Принимает адрес и возвращает объект, содержащий результаты поиска -
     * 5 подходящих адресов и их свойства, в том числе координаты.
     * @param $address
     * @return \Yandex\Geo\GeoObject[]
     */
    public function searchPoint($address)
    {
        $api = new \Yandex\Geo\Api();
        $address = htmlspecialchars($address);
        $api->setQuery($address);
        $api->setLimit(5)
            ->load();
        $response = $api->getResponse();
        $collection = $response->getList();
        return $collection;
    }

    /**
     * Определяет селектор для выбора адреса, который будет отображен на карте.
     * При значении селектора 0 (по умолчанию) на карте будет показан
     * первый адрес из результатов поиска.
     * @return void
     */
    public function usersSelection()
    {
        if(isset($_GET['result'])) {
            $this->selector = htmlspecialchars($_GET['result']);
        } else {
            $this->selector = 0;
        }
    }

    /**
     * @return mixed
     */
    public function getSelector()
    {
        return $this->selector;
    }
}