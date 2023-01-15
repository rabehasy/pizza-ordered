<?php

namespace App\Builders;

use App\Entity\Pizza;

interface PizzaBuilderInterface
{
    public function preparePizza(): PizzaBuilderInterface;
    public function addIngredient(array $ingredient) : PizzaBuilderInterface;
    public function setSize(string $size) : PizzaBuilderInterface;
    public function getPizza() : Pizza;
}