<?php

use Hyqo\CLI\Formatter;
use Hyqo\CLI\Output;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function testNormalizeString()
    {
        $message = 'test';
        $expected = 'test' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->normalize($message));
    }

    public function testNormalizeArray()
    {
        $message = ['foo', 'bar'];
        $expected = 'foo' . PHP_EOL . 'bar' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->normalize($message));
    }

    public function testFormatWithoutAnsi()
    {
        $message = ["<error>line 1\nline 2</error>", '<trace>bar</trace>'];
        $expected = 'line 1' . PHP_EOL . 'line 2' . PHP_EOL . 'bar' . PHP_EOL;

        $this->assertEquals($expected, (new Formatter())->format($message));
    }

    public function testFormatWithAnsi()
    {
        $message = ['error: <error>foo</error>', 'text', '<trace>bar</trace>'];
        $expected = "error: \033[31mfoo\033[0m" . PHP_EOL . "text" . PHP_EOL . "\033[90mbar\033[0m" . PHP_EOL;

        $this->assertEquals($expected, (new Formatter(true))->format($message));
    }
}
