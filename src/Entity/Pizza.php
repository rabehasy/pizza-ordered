<?php

namespace App\Entity;

class Pizza
{
    protected $price = 0.0;
    protected $size = 'M';
    protected $ingredients = [];

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size) : Pizza
    {
        $this->size = $size;

        if ($size === 'XL (+5 eur)') {
            $this->price += 5;
        }

        if ($size === 'S') {
            $this->price -= 3;
        }

        return $this;
    }

    public function getIngredients(): string
    {
        return implode(', ', $this->ingredients);
    }

    public function addIngredient(array $ingredients) : Pizza
    {
        $this->ingredients = array_merge($this->ingredients, $ingredients);

        if (in_array('oeuf (+1 eur)', $ingredients)) {
            $this->price += 1;
        }
        if (in_array('chorizo (+1.50 eur)', $ingredients)) {
            $this->price += 1.5;
        }
        if (in_array('mozarrella (+0.50 eur)', $ingredients)) {
            $this->price += 0.5;
        }
        if (in_array('champignon (+0.50 eur)', $ingredients)) {
            $this->price += 0.5;
        }

        return $this;
    }
}