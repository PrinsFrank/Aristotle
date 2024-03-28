<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Console;

enum Reset: int
{
    case All = 0;
    case BoldBright = 21;
    case Dim = 22;
    case Underlined = 24;
    case Blink = 25;
    case Reverse = 27;
    case Hidden = 28;
}
