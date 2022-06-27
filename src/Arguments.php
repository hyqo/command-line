<?php

namespace Hyqo\Cli;

class Arguments
{
    /** @var null|array */
    protected $argv;

    /** @var null|array */
    protected $shortOptions = null;

    /** @var null|array */
    protected $longOptions = null;

    public function __construct(?array $argv = null)
    {
        if (null === $argv) {
            $this->argv = $_SERVER['argv'];
        } else {
            $this->argv = $argv;
        }
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
        if (null === $this->longOptions) {
            $this->longOptions = (function () {
                $arguments = [];

                foreach ($this->argv as $argument) {
                    if (!preg_match('/^--(?P<key>\w+)(?: *= *(?P<value>.+))?/', $argument, $matches)) {
                        continue;
                    }

                    $key = $matches['key'];
                    $value = $matches['value'] ?? true;

                    if (is_string($value) && strtolower($value) === 'false') {
                        $value = false;
                    }

                    $arguments[$key] = $value;
                }

                return $arguments;
            })();
        }

        return $this->longOptions;
    }
}
