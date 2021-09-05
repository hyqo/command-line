<?php

namespace Hyqo\CLI;

/** @codeCoverageIgnore */
class Output
{
    private Formatter $formatter;

    public static array $cache = [];

    public function __construct(private $stream)
    {
        $this->formatter = new Formatter(stream_isatty($this->stream));
    }

    public function write(array|string $message): void
    {
        fwrite($this->stream, $this->formatter->format($message));
    }

    public static function send(array|string $message, $stream): void
    {
        (self::$cache[get_resource_id($stream)] ??= new self($stream))->write($message);
    }
}
