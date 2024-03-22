<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Commands;

use PrinsFrank\Aristotle\Configuration;
use Symfony\Component\Console\Command\Command;

abstract class AristotleCommand extends Command
{
    public function __construct(
        protected readonly Configuration $configuration,
    ) {
        if (file_exists($this->configuration->getConfigPath()) === false) {
            file_put_contents($this->configuration->getConfigPath(), '');
        }

        parent::__construct();
    }
}
