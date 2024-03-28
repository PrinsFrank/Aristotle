<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Console;

enum Set: int
{
    case BoldBright = 1;
    case Dim = 2;
    case Underlined = 4;
    case Blink = 5;
    case Reverse = 7;
    case Hidden = 8;
}
