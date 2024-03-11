<?php

namespace App\Services;

/**
 * Коммерческое предложение
 * 
 * (отвечает за формирование коммерческого предложения)
 */

class CommercialOffer
{
    /**
     * Cформировать коммерческое предложение
     * 
     * @param int $timestamp unix-метка для определения даты комм.предл.
     * @param Estimate $estimate смета
     * @param string $template шаблон отображения
     * 
     * @todo запрограммировать шаблон отображения
     * 
     */
    public function generate(int $timestamp, Estimate $estimate, string $template = null): ?string
    {
        return json_encode($estimate->evaluate());
    }
}
