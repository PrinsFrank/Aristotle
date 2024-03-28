<?php
declare(strict_types=1);

namespace Console;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\Aristotle\Console\Console;
use PrinsFrank\Aristotle\Console\Foreground;

#[CoversClass(Console::class)]
class ConsoleTest extends TestCase
{
    public function testFormat(): void
    {
        static::assertSame('foo', Console::format('foo'));
        static::assertSame("\e[32mfoo\e[0m", Console::format('foo', Foreground::Green));
    }
}
