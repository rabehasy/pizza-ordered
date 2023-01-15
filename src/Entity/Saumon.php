<?php

namespace App\Entity;

class Saumon extends Pizza
{
    public function __construct()
    {
        $this->price = 14.0;
    }
}