<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Console;

enum Background: int
{
    case Default = 49;
    case Black = 40;
    case Red = 41;
    case Green = 42;
    case Yellow = 43;
    case Blue = 44;
    case Magenta = 45;
    case Cyan = 46;
    case LightGray = 47;
    case DarkGray = 100;
    case LightRed = 101;
    case LightGreen = 102;
    case LightYellow = 103;
    case LightBlue = 104;
    case LightMagenta = 105;
    case LightCyan = 106;
    case White = 107;
}
