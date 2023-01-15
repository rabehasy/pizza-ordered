<?php

namespace App\Entity;

class Pizza
{
    const QUATRE_FROMAGES = '4 fromages (10 eur)';
    const MARGHERITA = 'margherita (9 eur)';
    const SAUMON = 'saumon (14 eur)';
    const VEGETARIENNE = 'vegetarienne (12 eur)';

    const TAILLE_S = 'S (-3 eur)';
    const TAILLE_M = 'M';
    const TAILLE_L = 'L';
    const TAILLE_XL = 'XL (+5 eur)';

    const INGREDIENT_EGG = 'oeuf (+1 eur)';
    const INGREDIENT_CHORIZO = 'chorizo (+1.50 eur)';
    const INGREDIENT_MOZARELLA = 'mozarrella (+0.50 eur)';
    const INGREDIENT_CHAMPIGNON = 'champignon (+0.50 eur)';


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

        if ($size === self::TAILLE_XL) {
            $this->price += 5;
        }

        if ($size === self::TAILLE_S) {
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

        if (in_array(self::INGREDIENT_EGG, $ingredients)) {
            $this->price += 1;
        }
        if (in_array(self::INGREDIENT_CHORIZO, $ingredients)) {
            $this->price += 1.5;
        }
        if (in_array(self::INGREDIENT_MOZARELLA, $ingredients)) {
            $this->price += 0.5;
        }
        if (in_array(self::INGREDIENT_CHAMPIGNON, $ingredients)) {
            $this->price += 0.5;
        }

        return $this;
    }
}