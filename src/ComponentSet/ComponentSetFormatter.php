<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\ComponentSet;

use InvalidArgumentException;
use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\FalseModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValidModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\TrueModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\ValidModifier;
use PrinsFrank\ADLParser\Argument\ComponentSet;
use PrinsFrank\Aristotle\Console\Console;
use PrinsFrank\Aristotle\Console\Foreground;

class ComponentSetFormatter
{
    /**
     * @throws InvalidArgumentException
     * @return list<string>
     */
    public function getFormattedInfo(ComponentSet $componentSet, string $identifier, int $level = 0): array
    {
        $array = [];
        $identity = $componentSet->getIdentity($identifier);
        if ($identity instanceof Conclusion) {
            foreach ($identity->identifiers as $linkedIdentifier) {
                $array = [...$array, ...$this->getFormattedInfo($componentSet, $linkedIdentifier, $level + 1)];
            }
        }

        if ($identity instanceof TrueModifier || $identity instanceof ValidModifier) {
            $foreground = Foreground::LightGreen;
        } elseif ($identity instanceof FalseModifier || $identity instanceof InValidModifier) {
            $foreground = Foreground::LightRed;
        } elseif ($identity instanceof Premise) {
            $foreground = match($componentSet->getPremiseState($identity)) {
                true => Foreground::LightGreen,
                false => Foreground::LightRed,
                null => Foreground::LightBlue,
            };
        } elseif ($identity instanceof Conclusion) {
            $foreground = match($componentSet->getConclusionState($identity)) {
                true => Foreground::LightGreen,
                false => Foreground::LightRed,
                null => Foreground::LightBlue,
            };
        } else {
            throw new InvalidArgumentException('Unsupported identity/modifier provided');
        }

        $array[] = $this->formatInfo($level, $identity, $foreground);
        foreach ($componentSet->getModifiers($identifier) as $modifier) {
            $array[] = $this->formatInfo($level + 1, $modifier, $foreground);
        }

        return $array;
    }

    /** @throws InvalidArgumentException */
    private function formatInfo(int $level, Identity|Modifier $component, Foreground $foreground): string
    {
        $label = (property_exists($component, 'label') && $component->label !== null ? ' (' . $component->label . ')' : '');

        return str_repeat('  ', $level) . match ($component::class) {
            Conclusion::class => Console::format('Conclusion: ' . $component->identifier . $label, $foreground),
            Premise::class => Console::format('If: ' . $component->identifier . $label, $foreground),
            FalseModifier::class => Console::format('- False' . $label, $foreground),
            InValidModifier::class => Console::format('- Invalid' . $label, $foreground),
            TrueModifier::class => Console::format('+ True' . $label, $foreground),
            ValidModifier::class => Console::format('+ valid' . $label, $foreground),
            default => throw new InvalidArgumentException('Unsupported indentity/modifier provided'),
        };
    }
}
