<?php

namespace App\Builders;

use App\Entity\Margherita;
use App\Entity\Pizza;

class MargheritaBuilder implements PizzaBuilderInterface
{
    private $pizza;
    public function preparePizza(): PizzaBuilderInterface
    {
        $this->pizza = new Margherita();

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