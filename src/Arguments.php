<?php

namespace Hyqo\CLI;

class Arguments
{
    private ?array $shortOptions = null;
    private ?array $longOptions = null;

    public function __construct(
        private ?array $argv = null
    ) {
        $this->argv ??= $_SERVER['argv'];
    }

    public function getFirst(): ?string
    {
        return $this->get(1);
    }

    public function getAll(): array
    {
        return $this->argv;
    }

    public function get(int $index): ?string
    {
        return $this->argv[$index] ?? null;
    }

    public function getShortOptions(): array
    {
        return $this->shortOptions = iterator_to_array(
            (function () {
                foreach ($this->argv as $argument) {
                    if (!preg_match('/^-([a-zA-Z0-9]+)$/', $argument, $match)) {
                        continue;
                    }

                    foreach (str_split($match[1]) as $option) {
                        yield $option => true;
                    }
                }
            })()
        );
    }

    public function getLongOptions(): array
    {
        return $this->longOptions ??= iterator_to_array(
            (function () {
                foreach ($this->argv as $argument) {
                    if (!preg_match('/^--(?P<key>\w+)(?: *= *(?P<value>.+))?/', $argument, $matches)) {
                        continue;
                    }

                    $key = $matches['key'];
                    $value = $matches['value'] ?? true;

                    $value = match ($value) {
                        'false', 'FALSE' => false,
                        default => $value
                    };

                    yield $key => $value;
                }
            })()
        );
    }
}
