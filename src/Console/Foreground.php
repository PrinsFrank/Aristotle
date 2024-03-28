<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Console;

/** https://misc.flogisoft.com/bash/tip_colors_and_formatting */
enum Foreground: int
{
    case Default = 39;
    case Black = 30;
    case Red = 31;
    case Green = 32;
    case Yellow = 33;
    case Blue = 34;
    case Magenta = 35;
    case Cyan = 36;
    case LightGray = 37;
    case DarkGray = 90;
    case LightRed = 91;
    case LightGreen = 92;
    case LightYellow = 93;
    case LightBlue = 94;
    case LightMagenta = 95;
    case LightCyan = 96;
    case White = 97;
}
