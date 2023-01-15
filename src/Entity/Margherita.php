<?php

namespace App\Entity;

class Margherita extends Pizza
{
    public function __construct()
    {
        $this->price = 9.0;
    }
}