<?php

namespace App\Builders;

use App\Entity\Pizza;
use App\Entity\Vegetarienne;

class VegetarienneBuilder implements PizzaBuilderInterface
{

    public function preparePizza(): PizzaBuilderInterface
    {
        $this->pizza = new Vegetarienne();

        return $this;
    }

    public function addIngredient(array $ingredients): PizzaBuilderInterface
    {
        $this->pizza->addIngredient($ingredients);

        return $this;
    }

    public function setSize(string $size): PizzaBuilderInterface
    {
        $this->pizza->setSize($size);
        return $this;
    }

    public function getPizza(): Pizza
    {
        return $this->pizza;
    }
}