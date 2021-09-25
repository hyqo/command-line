<?php

namespace Hyqo\CLI;

class Formatter
{
    private const STYLES = [
        'error' => '31m',
        'trace' => '90m',
    ];

    public function __construct(private bool $colorize = false)
    {
    }

    public function format(array|string $message, bool $ansi = false): string
    {
        $message = $this->normalize($message);

        foreach (self::STYLES as $tag => $style) {
            $message = preg_replace(
                sprintf('/<%1$s>(.*)<\/%1$s>/s', $tag),
                $this->colorize ? sprintf("\033[%s$1\033[0m", $style) : '$1',
                $message
            );
        }

        return $message;
    }

    public function normalize(array|string $message): string
    {
        if (is_array($message)) {
            return array_reduce($message, static fn(string $carry, string $line) => $carry . $line . PHP_EOL, '');
        }

        return $message . PHP_EOL;
    }
}
