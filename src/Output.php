<?php

namespace Hyqo\CLI;

class Output
{
    public function __construct(
        private $stdout = STDOUT,
        private $stderr = STDERR
    ) {
    }

    /** @codeCoverageIgnore */
    public function write(array|string $message): void
    {
        fwrite($this->stdout, $this->format($message));
    }

    /** @codeCoverageIgnore */
    public function error(array|string $message): void
    {
        fwrite($this->stderr, $this->format($message));
    }

    public function format(array|string $message): string
    {
        if (is_array($message)) {
            return array_reduce($message, static fn(string $carry, string $line) => $carry . $line . PHP_EOL, '');
        }

        return $message . PHP_EOL;
    }
}
