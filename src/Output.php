<?php

namespace Hyqo\CLI;

/** @codeCoverageIgnore */
class Output
{
    private Formatter $formatter;

    public function __construct(private $stream)
    {
        $this->formatter = new Formatter(stream_isatty($this->stream));
    }

    public function write(array|string $message): void
    {
        fwrite($this->stream, $this->formatter->format($message));
    }
}
