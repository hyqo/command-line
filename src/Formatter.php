<?php

namespace Hyqo\Cli;

class Formatter
{
    protected $colorize = false;

    protected const STYLES = [
        'error' => '31m',
        'trace' => '90m',
    ];

    public function __construct(bool $colorize = false)
    {
        $this->colorize = $colorize;
    }

    /**
     * @param array|string $message
     */
    public function format($message, bool $ansi = false): string
    {
        $message = $this->normalize($message);

        foreach (self::STYLES as $tag => $style) {
            $message = preg_replace(
                sprintf('/<%1$s>(.*)<\/%1$s>/sU', $tag),
                $this->colorize ? sprintf("\033[%s$1\033[0m", $style) : '$1',
                $message
            );
        }

        return $message;
    }

    /**
     * @param array|string $message
     */
    public function normalize($message): string
    {
        if (is_array($message)) {
            return array_reduce($message, static function (string $carry, string $line) {
                return $carry . $line . PHP_EOL;
            }, '');
        }

        return $message . PHP_EOL;
    }
}
