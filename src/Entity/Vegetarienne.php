<?php

namespace App\Entity;

class Vegetarienne extends Pizza
{
    public function __construct()
    {
        $this->price = 12.0;
    }
}