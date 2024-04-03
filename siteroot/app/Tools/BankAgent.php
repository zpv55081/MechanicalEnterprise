<?php

namespace App\Tools;

interface BankAgent
{
    public function load();
    
    public function get($cur);
}
