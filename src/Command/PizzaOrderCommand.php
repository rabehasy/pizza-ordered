<?php

namespace App\Command;

use App\Builders\MargheritaBuilder;
use App\Directors\PizzaDirector;
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
        $typeChoiceQuestion = new ChoiceQuestion(
            'Choisir le type de la pizza souhaitée',
            ['4 fromages (10 eur)', 'margherita (9 eur)', 'saumon (14 eur)', 'vegetarienne (12 eur)'],
        );
        $typeChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
        $pizzaType = $helper->ask($input, $output, $typeChoiceQuestion);
        $output->writeln('Votre choix: ' . $pizzaType);

        $sizeChoiceQuestion = new ChoiceQuestion(
            'Choisir la taille',
            ['S', 'M', 'L', 'XL (+5 eur)'],
        );
        $sizeChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
        $pizzaSize = $helper->ask($input, $output, $sizeChoiceQuestion);
        $output->writeln('Taille: ' . $pizzaSize);

        $ingredientsChoices = [];
        $ingredientConfirmationQuestion = new ConfirmationQuestion('Ajouter des ingrédients ? (répondre "y" si oui)', false);
        if ($helper->ask($input, $output, $ingredientConfirmationQuestion)) {
            $ingredientsMultipleChoiceQuestion = new ChoiceQuestion(
                'Ingrédients à ajouter (chiffre séparé par une virgule)',
                ['oeuf (+1 eur)', 'chorizo (+1.50 eur)', 'mozarrella (+0.50 eur)', 'champignon (+0.50 eur)'],
            );
            $ingredientsMultipleChoiceQuestion->setMultiselect(true);
            $ingredientsMultipleChoiceQuestion->setErrorMessage('Choix "%s" invalide.');
            $ingredientsChoices = $helper->ask($input, $output, $ingredientsMultipleChoiceQuestion);
        }

        $pizzaDirector = new PizzaDirector(new MargheritaBuilder());
        $pizzaOrdered = $pizzaDirector->createMargherita($ingredientsChoices, $pizzaSize);

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