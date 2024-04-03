<?php

namespace App\Tools;

/**
 * @author ElisDN <mail@elisdn.ru>
 * @link https://elisdn.ru
 */
class CBRAgent implements BankAgent
{
    protected $list = array();
 
    public function load()
    {
        $xml = new \DOMDocument();
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');
 
        if (@$xml->load($url)) {
            $this->list = []; 
 
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');
 
            foreach ($items as $item) {
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$code] = floatval(str_replace(',', '.', $curs));
            }
 
            return true;
        }
 
        return false;
    }
 
    public function get($cur)
    {
        return isset($this->list[$cur]) ? $this->list[$cur] : 0;
    }
}
