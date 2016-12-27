<?php

class YandexGeo
{
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
}