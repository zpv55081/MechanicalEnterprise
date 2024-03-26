<?php

namespace App\Tools;

use Illuminate\Support\Facades\Redis;
use \Illuminate\Redis\Connections\Connection;

/**
 * Обмен валюты
 */
class CurrencyExchange
{
    public array $currKeys = ['USD', 'EUR'];

    private Connection $redisResource;

    function __construct()
    {
        $this->redisResource = Redis::connection();
    }

    /**
     * Скачать курсы
     */
    private function downloadRates(): ?array
    {
        $cbrAgent = new CBRAgent;

        $arRates = null;
        if ($cbrAgent->load()) {     
            foreach($this->currKeys as $currency) {  
                $arRates[$currency] = $cbrAgent->get($currency);
            }    
        }

        return $arRates;
    }

    /**
     * Кэшировать курсы в ОЗУ
     */
    private function cacheRates(array $arRates): void
    {
        $this->redisResource->setex('currency_rates', 60, json_encode($arRates));
    }

    /**
     * Получить курсы валют
     */
    public function receiveRates() :array
    {
        $ratesJson = $this->redisResource->get('currency_rates');
        $cachedCurrencyRates = json_decode($ratesJson, true);

        if ($cachedCurrencyRates) {
            return $cachedCurrencyRates;
        } else {
            $currencyRates = $this->downloadRates();
            $this->cacheRates($currencyRates);
            return $currencyRates;
        };
    }
}
