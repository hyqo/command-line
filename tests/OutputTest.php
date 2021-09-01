<?php

use Hyqo\CLI\Output;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    private Output $output;

    protected function setUp(): void
    {
        $this->output = new Output();
    }

    public function testFormatString()
    {
        $message = 'test';
        $expected = 'test' . PHP_EOL;

        $this->assertEquals('test' . PHP_EOL, $this->output->format($message));
    }

    public function testFormatArray()
    {
        $message = ['foo', 'bar'];
        $expected = 'foo' . PHP_EOL . 'bar' . PHP_EOL;

        $this->assertEquals($expected, $this->output->format($message));
    }
}
