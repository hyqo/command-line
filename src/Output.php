<?php

namespace Hyqo\Cli;

/** @codeCoverageIgnore */
class Output
{
    /** @var \SplDoublyLinkedList */
    public static $cache = [];

    /** @var Formatter */
    protected $formatter;

    protected $stream;

    public function __construct($stream)
    {
        $this->stream = $stream;
        $this->formatter = new Formatter(stream_isatty($this->stream));
    }

    /**
     * @param array|string $message
     */
    public function write($message): void
    {
        fwrite($this->stream, $this->formatter->format($message));
    }

    /**
     * @param array|string $message
     */
    public static function send($message, $stream): void
    {
//        $id = get_resource_id($stream);

//        if (array_key_exists($id, self::$cache)) {
//            $output = self::$cache[$id];
//        } else {
//            $output = self::$cache[$id] = new self($stream);
//        }
        $output = new self($stream);

        $output->write($message);
    }
}
