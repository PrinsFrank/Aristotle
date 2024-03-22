<?php
declare(strict_types=1);

namespace PrinsFrank\Aristotle\ComponentSet;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\FalseModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValidModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\TrueModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\ValidModifier;
use PrinsFrank\ADLParser\Argument\ComponentSet;

class ComponentSetFormatter
{
    public function getFormattedInfo(ComponentSet $componentSet, string $identifier, $level = 0): array
    {
        $array = [];
        $identity = $componentSet->getIdentity($identifier);
        if ($identity instanceof Conclusion) {
            foreach ($identity->identifiers as $linkedIdentifier) {
                $array = [...$array, ...$this->getFormattedInfo($componentSet, $linkedIdentifier, $level)];
            }
        }

        $array[] = $this->formatInfo($level, $identity);
        foreach ($componentSet->getModifiers($identifier) as $modifier) {
            $array[] = $this->formatInfo($level, $modifier);
        }


        return $array;
    }

    private function formatInfo(int $level, Identity|Modifier $component): string
    {
        $label =  ($component->label !== null ? ' (' . $component->label . ')' : '');
        return str_repeat('    ', $level) . match ($component::class) {
            Conclusion::class => 'Conclusion: ' . $component->identifier . $label,
            Premise::class => 'If: ' . $component->identifier . $label,
            FalseModifier::class => '- False' . $label,
            InValidModifier::class => '- Invalid' . $label,
            TrueModifier::class => '+ True' . $label,
            ValidModifier::class => '+ valid' . $label,
        };
    }
}
