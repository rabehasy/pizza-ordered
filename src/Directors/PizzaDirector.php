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

    public function createMargherita(array $ingredients) : Pizza
    {
        return $this->pizzaBuilder
            ->preparePizza()
            ->addIngredient($ingredients)
            ->getPizza();
    }
}