<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Commands;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Parser;
use PrinsFrank\Aristotle\ComponentSet\ComponentSetFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('conclusion')]
class ConclusionCommand extends AristotleCommand
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
            $output->writeln('Please provide an identifier to read or add.');

            return Command::FAILURE;
        }

        $componentSet = (new Parser())->parse($this->configuration->getConfigPath());
        $existingIdentity = $componentSet->getIdentity($identifier);
        if ($existingIdentity !== null && $existingIdentity instanceof Conclusion === false) {
            $output->writeln('Identity "' . $identifier . '" already exists but is not a conclusion.');

            return Command::FAILURE;
        }

        if ($existingIdentity !== null) {
            $output->writeln((new ComponentSetFormatter())->getFormattedInfo($componentSet, $identifier));

            return Command::SUCCESS;
        }

        $label = $input->getArgument('label');
        file_put_contents($this->configuration->getConfigPath(), PHP_EOL . 'conclusion ' . $identifier . ($label !== null ? ' ' . $label : '') . PHP_EOL, FILE_APPEND);
        $output->writeln('Added conclusion');

        return Command::SUCCESS;
    }
}
