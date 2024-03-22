<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle;

class Configuration
{
    public function __construct(
        protected readonly string $rootPath,
        protected readonly string $fileName,
    ) {
    }

    public function getConfigPath(): string
    {
        return $this->rootPath . '/' . $this->fileName;
    }
}
