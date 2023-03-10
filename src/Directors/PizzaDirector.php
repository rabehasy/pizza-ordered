<?php

namespace App\Directors;

use App\Builders\PizzaBuilderInterface;
use App\Entity\Pizza;

class PizzaDirector
{
    public function __construct(PizzaBuilderInterface $pizzaBuilder)
    {
        $this->pizzaBuilder = $pizzaBuilder;
    }

    public function create(array $ingredients, string $size) : Pizza
    {
        return $this->pizzaBuilder
            ->preparePizza()
            ->setSize($size)
            ->addIngredient($ingredients)
            ->getPizza();
    }
}