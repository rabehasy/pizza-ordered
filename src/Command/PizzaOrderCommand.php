<?php

namespace App\Command;

use App\Builders\MargheritaBuilder;
use App\Builders\QuatreFromagesBuilder;
use App\Builders\SaumonBuilder;
use App\Builders\VegetarienneBuilder;
use App\Directors\PizzaDirector;
use App\Entity\Pizza;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:pizza-order')]
class PizzaOrderCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');
        // Quel type de pizza veut le client ?
        $typeChoiceQuestion = new ChoiceQuestion(
            'Choisir le type de la pizza souhaitée',
            [Pizza::QUATRE_FROMAGES, Pizza::MARGHERITA, Pizza::SAUMON, Pizza::VEGETARIENNE],
        );
        $typeChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
        $pizzaType = $helper->ask($input, $output, $typeChoiceQuestion);
        $output->writeln('Votre choix: ' . $pizzaType);

        // Taille de la pizza
        $sizeChoiceQuestion = new ChoiceQuestion(
            'Choisir la taille',
            [Pizza::TAILLE_S, Pizza::TAILLE_M, Pizza::TAILLE_L, Pizza::TAILLE_XL],
        );
        $sizeChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
        $pizzaSize = $helper->ask($input, $output, $sizeChoiceQuestion);
        $output->writeln('Taille: ' . $pizzaSize);

        // Ajout des ingrédients ou pas ?
        $ingredientsChoices = [];
        $ingredientConfirmationQuestion = new ConfirmationQuestion('Ajouter des ingrédients ? (répondre "y" si oui)', false);
        if ($helper->ask($input, $output, $ingredientConfirmationQuestion)) {
            $ingredientsMultipleChoiceQuestion = new ChoiceQuestion(
                'Ingrédients à ajouter (chiffre séparé par une virgule)',
                [Pizza::INGREDIENT_EGG, Pizza::INGREDIENT_CHORIZO, Pizza::INGREDIENT_MOZARELLA, Pizza::INGREDIENT_CHAMPIGNON],
            );
            $ingredientsMultipleChoiceQuestion->setMultiselect(true);
            $ingredientsMultipleChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
            $ingredientsChoices = $helper->ask($input, $output, $ingredientsMultipleChoiceQuestion);
        }

        $pizzaDirectorInstance = match ($pizzaType) {
            Pizza::QUATRE_FROMAGES => new QuatreFromagesBuilder(),
            Pizza::MARGHERITA => new MargheritaBuilder(),
            Pizza::SAUMON => new SaumonBuilder(),
            Pizza::VEGETARIENNE => new VegetarienneBuilder(),
        };
        $pizzaDirector = new PizzaDirector($pizzaDirectorInstance);
        $pizzaOrdered = $pizzaDirector->create($ingredientsChoices, $pizzaSize);

        $io->section('Récapitulatif');
        $io->listing([
            'Type : '.$pizzaType,
            'Taille : '.$pizzaSize,
            'Ingrédients : '.$pizzaOrdered->getIngredients(),
            'Prix à payer : '.$pizzaOrdered->getPrice().' Eur',
        ]);

        return Command::SUCCESS;
    }
}