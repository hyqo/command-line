<?php


use Hyqo\CLI\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    private Arguments $arguments;

    protected function setUp(): void
    {
        $this->arguments = new Arguments([
            'arg0',
            'arg1',
            'arg2',
            '-fa',
            '--l1=foo',
            '--l2=false',
            '--l3',
        ]);
    }

    public function testGetFirstArgument()
    {
        $this->assertEquals('arg1', $this->arguments->getFirstArgument());
    }

    public function testGetArgument()
    {
        $this->assertEquals('arg1', $this->arguments->getArgument(1));
        $this->assertEquals('arg2', $this->arguments->getArgument(2));
    }

    public function testGetShortOptions()
    {
        $this->assertEquals(['f' => true, 'a' => true], $this->arguments->getShortOptions());
    }

    public function testGetLongOptions()
    {
        $this->assertEquals(
            ['l1' => 'foo', 'l2' => false, 'l3' => true],
            $this->arguments->getLongOptions()
        );
    }
}
