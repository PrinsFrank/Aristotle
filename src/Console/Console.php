<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\Console;

class Console
{
    public static function format(string $string, ?Foreground $foreground = null, ?Background $background = null, ?Set $set = null): string
    {
        $controlSequences = array_filter([$foreground, $background, $set]);
        if ($controlSequences === []) {
            return $string;
        }

        $controlSequenceInts = array_map(
            fn (Foreground|Background|Set $backedEnum) => $backedEnum->value,
            $controlSequences
        );

        return sprintf("\e[%sm%s\e[%sm", implode('m;', $controlSequenceInts), $string, Reset::All->value);
    }
}
