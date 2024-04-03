<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Commands;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValidModifier;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;
use PrinsFrank\ADLParser\Exception\InvalidFileException;
use PrinsFrank\ADLParser\Parser;
use PrinsFrank\Aristotle\Console\Console;
use PrinsFrank\Aristotle\Console\Foreground;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('invalid', 'Mark a conclusion as invalid')]
class InValidCommand extends AristotleCommand
{
    /** @throws InvalidArgumentException */
    protected function configure(): void
    {
        $this->addArgument('identifier')
            ->addArgument('label');
    }

    /**
     * @throws InvalidArgumentException
     * @throws DuplicateDefinitionException
     * @throws InvalidFileException
     * @throws InvalidComponentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $identifier = $input->getArgument('identifier');
        if ($identifier === null || is_string($identifier) === false) {
            $output->writeln(Console::format('Please provide an identifier to mark as invalid.', Foreground::LightRed));

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

        if ($componentSet->hasModifierOfType($identifier, InValidModifier::class)) {
            $output->writeln(Console::format('Conclusion has already been marked as invalid', Foreground::LightYellow));

            return Command::SUCCESS;
        }

        $label = $input->getArgument('label');
        file_put_contents($this->configuration->getConfigPath(), PHP_EOL . 'invalid ' . $identifier . ($label !== null ? ' ' . $label : '') . PHP_EOL, FILE_APPEND);
        $output->writeln('Added validity');

        return Command::SUCCESS;
    }
}
