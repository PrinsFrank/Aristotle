<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Commands;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Modifier\ValidModifier;
use PrinsFrank\ADLParser\Parser;
use PrinsFrank\Aristotle\Console\Console;
use PrinsFrank\Aristotle\Console\Foreground;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('valid', 'Mark a conclusion as invalid')]
class ValidCommand extends AristotleCommand
{
    protected function configure(): void
    {
        $this->addArgument('identifier')
            ->addArgument('label');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $identifier = $input->getArgument('identifier');
        if ($identifier === null) {
            $output->writeln(Console::format('Please provide an identifier to mark as valid.', Foreground::LightRed));

            return Command::FAILURE;
        }

        $componentSet = (new Parser())->parse($this->configuration->getConfigPath());
        $identity = $componentSet->getIdentity($identifier);
        if ($identity === null) {
            $output->writeln(Console::format('Identity with identifier ' . $identifier . ' does not exist', Foreground::LightRed));

            return Command::FAILURE;
        }

        if ($identity instanceof Conclusion === false) {
            $output->writeln(Console::format('Validity only applies to conclusions', Foreground::LightRed));

            return Command::FAILURE;
        }

        if ($componentSet->hasModifierOfType($identifier, ValidModifier::class)) {
            $output->writeln(Console::format('Conclusion has already been marked as valid', Foreground::LightYellow));

            return Command::SUCCESS;
        }

        $label = $input->getArgument('label');
        file_put_contents($this->configuration->getConfigPath(), PHP_EOL . 'valid ' . $identifier . ($label !== null ? ' ' . $label : '') . PHP_EOL, FILE_APPEND);
        $output->writeln(Console::format('Added validity', Foreground::LightGreen));

        return Command::SUCCESS;
    }
}
